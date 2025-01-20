<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Session;
use validate;
use Sentinel;
use DB;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\TokenData;
use Yajra\DataTables\DataTables;
use Google_Client;
use Illuminate\Support\Facades\File;


class NotificationController extends Controller
{

    public function showsendnotification()
    {
        return view("admin.notification");
    }

    public function notificationkey()
    {
        $user = Setting::find(1);
        return view("admin.notificationkey")->with("user", $user);
    }

    public function updatenotificationkey(Request $request)
    {
        $user = Setting::find(1);
        if ($request->hasFile('jsonfile')) {
            $file = $request->file('jsonfile');
            $filename = $file->getClientOriginalName();
            $folderName = '/upload/jsonfile/';
            $picture = $filename;
            $destinationPath = public_path() . $folderName;
            $request->file('jsonfile')->move($destinationPath, $picture);
            $img_url = $picture;

            if ($user && $user->image) {
                $oldImagePath = public_path() . $folderName . $user->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $user->not_json_filename = $img_url;
        $user->save();
        Session::flash('message', __('message.Notification Key Update Successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function notificationtable(Request $request)
    {
        $notify = Notification::all();

        return DataTables::of($notify)
            ->editColumn('id', function ($notify) {
                return $notify->id;
            })
            ->editColumn('message', function ($notify) {
                return $notify->message;
            })
            ->make(true);
    }


    public function savenotification()
    {
        return view("admin.addnotification");
    }

    public function sendnotificationtouser(Request $request)
    {
        if ($request->get("message") == "") {
            Session::flash('message', __('message.Message Is Required'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        $msg = $request->get("message");
        $android = $this->sendNotifications($msg);
        if ($android == 1) {
            $store = new Notification();
            $store->message = $request->get("message");
            $store->save();
            Session::flash('message', __('message.Notification Send Successfully'));
            Session::flash('alert-class', 'alert-success');
            return redirect("admin/sendnotification");
        } else {
            Session::flash('message', __('message.Notification Not Send Successfully'));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function generateAccessToken()
    {
        $setting = Setting::find(1);
        $contents = File::get(public_path('upload/jsonfile/' . $setting->not_json_filename));
        $accountJson = json_decode($contents, true);  // Convert JSON to associative array

        $scopes = array(
            "https://www.googleapis.com/auth/userinfo.email",
            "https://www.googleapis.com/auth/firebase.database",
            "https://www.googleapis.com/auth/firebase.messaging"
        );

        $client = new Google_Client();
        $client->setAuthConfig($accountJson);
        $client->setScopes($scopes);
        $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
        return $accessToken;
    }

    public function sendNotifications($msg)
    {
        $accessToken = $this->generateAccessToken();

        $getusers = TokenData::where("type", '1')->get();
        $setting = Setting::find(1);
        $contents = File::get(public_path('upload/jsonfile/' . $setting->not_json_filename));
        $accountJson = json_decode($contents);
        $api = "https://fcm.googleapis.com/v1/projects/" . $accountJson->project_id . "/messages:send";

        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $accessToken
        );

        $responses = [];

        foreach ($getusers as $user) {
            $message = array(
                "message" => array(
                    "token" => $user->token,
                    "notification" => array(
                        "title" => __('message.notification'),
                        "body" => $msg
                    ),
                    "data" => array(
                        'message' => $msg,
                        'title' =>  __('message.notification')
                    )
                )
            );

            $ch = curl_init($api);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

            $response = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $responses[] = [
                'status_code' => $statusCode,
                'response' => json_decode($response)
            ];

            curl_close($ch);
        }

        $succ = 0;
        foreach ($responses as $response) {
            if (isset($response['status_code']) && $response['status_code'] == 200) {
                $succ++;
            }
        }

        if ($succ > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}
