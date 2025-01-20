<?php

namespace App\Http\Controllers\API;

error_reporting(-1);
ini_set('display_errors', 'On');

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use validate;
use Sentinel;
use Response;
use Validator;
use DB;
use DataTables;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\User;
use App\Models\Services;
use App\Models\Review;
use App\Models\Doctors;
use App\Models\Patient;
use App\Models\TokenData;
use App\Models\Resetpassword;
use App\Models\BookAppointment;
use App\Models\SlotTiming;
use App\Models\Doctor_Hoilday;
use App\Models\Schedule;
use App\Models\Reportspam;
use App\Models\Settlement;
use App\Models\Subscription;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\Banner;
use App\Models\About;
use App\Models\Privecy;
use Hash;
use Mail;
use DateTime;
use DateInterval;
use App\Models\Medicines;
use App\Models\AppointmentMedicines;
use App\Models\ap_img_uplod;
use App\Models\PharmacyOrder;
use App\Models\PharmacyOrderData;
use App\Models\PharmacyProduct;
use Carbon\Carbon;
use Exception;
use Google_Client;
use Illuminate\Support\Facades\File;

class ApiController extends Controller
{

    public function connectycube_register(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "type" => "required",
        ];
        if ($request->type == 1) {
            $rules['patient_id'] = 'required';
        } else {
            $rules['doctor_id'] = 'required';
        }
        $messages = array(
            'type.required' => "type is required",
            'patient_id.required' => "patient_id is required",
            'doctor_id.required' => "doctor_id is required",

        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            if ($request->type == 1) {
                $data = Patient::find($request->patient_id);

                if ($data) {
                    $login_field = "";
                    $user_id = "";
                    $connectycube_password = "";

                    if (env('ConnectyCube') == true) {

                        $login_field = $data->phone . rand() . "#1";
                        $user_id = $this->signupconnectycude($data->name, $data->password, $data->email, $data->phone, $login_field);
                        $connectycube_password = $data->password;
                    }

                    $data->connectycube_user_id = $user_id;
                    $data->login_id = $login_field;
                    $data->connectycube_password = $connectycube_password;

                    $connrctcube = ($data->connectycube_user_id);

                    if ($connrctcube == "0-email must be unique") {
                        $response['status'] = "0";
                        $response['msg'] = "Email Or Mobile Number Already Register in ConnectCube";
                    } else {
                        $data->save();
                        $response['status'] = "1";
                        $response['msg'] =  "ConnectCube Register Successfully";
                        $response['data'] = array("connectycube_user_id" => $data->connectycube_user_id, "login_id" => $login_field);
                    }
                } else {
                    $response = array("status" => 0, "msg" => "Patient id Not Found");
                }
            } else {
                $data = Doctors::find($request->doctor_id);

                if ($data) {
                    $login_field = "";
                    $user_id = "";
                    $connectycube_password = "";

                    if (env('ConnectyCube') == true) {
                        $login_field =$data->phoneno . rand() . "#2";
                        $user_id = $this->signupconnectycude($data->name, $data->password, $data->email, $data->phoneno, $login_field);
                        $connectycube_password = $data->password;
                    }

                    $data->connectycube_user_id = $user_id;
                    $data->login_id = $login_field;
                    $data->connectycube_password = $connectycube_password;

                    $connrctcube = ($data->connectycube_user_id);

                    if ($connrctcube == "0-email must be unique") {
                        $response['status'] = "0";
                        $response['msg'] = "Email Or Mobile Number Already Register in ConnectCube";
                    } else {
                        $data->save();
                        $response['status'] = "1";
                        $response['msg'] =  "ConnectCube Register Successfully";
                        $response['data'] = array("connectycube_user_id" => $data->connectycube_user_id, "login_id" => $login_field);
                    }
                } else {
                    $response = array("status" => 0, "msg" => "Doctors id Not Found");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function pharmacy_medicines(Request $request)
    {
        $response = array("status" => 0, "msg" => "Validation error");
        $rules = [
            "pharmacy_id" => "required",
        ];
        $messages = array(
            'pharmacy_id.required' => "pharmacy_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $setting = Setting::find(1);
            if ($request->keyword) {
                $data = PharmacyProduct::where('pharmacy_id', $request->pharmacy_id)->where('name', 'LIKE', '%' . $request->keyword . '%')->get();
                if (count($data) != 0) {
                    $response['success'] = "1";
                    $response['msg'] = __("message.Medicines_Get_Success");
                    $response['data'] = $data;
                    $response['pharmacy_tax'] = $setting->pharmacy_tax;
                    $response['pharmacy_delivery_charge'] = $setting->pharmacy_delivery_charge;
                } else {
                    $response['success'] = "0";
                    $response['msg'] = __("message.Medicines_data_Not_Found");
                    $response['data'] = $data;
                    $response['pharmacy_tax'] = $setting->pharmacy_tax;
                    $response['pharmacy_delivery_charge'] = $setting->pharmacy_delivery_charge;
                    // $response = array("status" => 0, "msg" => "Medicines data Not Found");
                }
            } else {
                $data = PharmacyProduct::where('pharmacy_id', $request->pharmacy_id)->get();

                if (count($data) != 0) {
                    $response['success'] = "1";
                    $response['msg'] = __("message.Medicines_Get_Success");
                    $response['data'] = $data;
                    $response['pharmacy_tax'] = $setting->pharmacy_tax;
                    $response['pharmacy_delivery_charge'] = $setting->pharmacy_delivery_charge;
                } else {
                    $response['success'] = "0";
                    $response['msg'] = __("message.Medicines_data_Not_Found");
                    $response['data'] = $data;
                    $response['pharmacy_tax'] = $setting->pharmacy_tax;
                    $response['pharmacy_delivery_charge'] = $setting->pharmacy_delivery_charge;
                    // $response = array("status" => 0, "msg" => "Medicines data Not Found");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function medicines_detail(Request $request)
    {
        $response = array("status" => 0, "msg" => "Validation error");
        $rules = [
            "medicine_id" => "required",
        ];
        $messages = array(
            'medicine_id.required' => "medicine_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = PharmacyProduct::find($request->medicine_id);
            if ($data) {
                $response['success'] = "1";
                $response['msg'] = __("message.Medicines_Get_Success");
                $response['data'] = $data;
            } else {
                $response['success'] = "0";
                $response['msg'] = __("message.Medicines_data_Not_Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function medicine_order(Request $request)
    {

        $response = array("status" => 0, "msg" => "Validation error");
        $rules = [
            "user_id" => "required",
            "pharmacy_id" => "required",
            "phoneno" => "required",
            "total" => "required",
            "product_json" => "required",
            "payment_type" => "required",
            "address" => "required",
            "message" => "required",
            "tax" => "required",
            "delivery_charge" => "required",
            "tax_pr" => "required",
        ];

        if ($request->payment_type != 'COD') {
            $rules['transaction_id'] = 'required';
        }
        $messages = array(
            'user_id.required' => "user_id is required",
            'pharmacy_id.required' => "pharmacy_id is required",
            'phoneno.required' => "phoneno is required",
            'total.required' => "total is required",
            'product_json.required' => "product_json is required",
            'payment_type.required' => "payment_type is required",
            'address.required' => "address is required",
            'message.required' => "message is required",
            'tax.required' => "tax is required",
            'delivery_charge.required' => "delivery_charge is required",
            'tax_pr.required' => "tax_pr is required",
            'transaction_id.required' => "transaction_id is required",

        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            if ($request->payment_type == 'COD') {
                $data = new PharmacyOrder();
                $data->Pharmacy_id = $request->pharmacy_id;
                $data->tax_pr = $request->tax_pr;
                $data->tax = $request->tax;
                $data->delivery_charge = $request->delivery_charge;
                $data->total = $request->total;
                $data->phone = $request->phoneno;
                $data->message = $request->message;
                $data->address = $request->address;
                $data->payment_type = $request->payment_type;
                $data->is_completed = '1';
                $data->order_type = 2;
                $data->status = 0;
                $data->user_id = $request->user_id;
                $data->save();

                if ($request->product_json) {
                    $products = json_decode($request->product_json, true);
                    // return $products;
                    foreach ($products as $id => $item) {
                        $add = new PharmacyOrderData();
                        $add->order_id = $data->id;
                        $add->service_id = $item['id'];
                        $add->qty = $item['quantity'];
                        $add->name = $item['title'];
                        $add->price = $item['price'];
                        $add->save();
                    }
                }
            } else {
                $data = new PharmacyOrder();
                $data->Pharmacy_id = $request->pharmacy_id;
                $data->tax_pr = $request->tax_pr;
                $data->tax = $request->tax;
                $data->delivery_charge = $request->delivery_charge;
                $data->total = $request->total;
                $data->phone = $request->phoneno;
                $data->message = $request->message;
                $data->address = $request->address;
                $data->payment_type = $request->payment_type;
                $data->is_completed = '1';
                $data->order_type = 2;
                $data->status = 0;
                $data->user_id = $request->user_id;
                $data->transaction_id = $request->transaction_id;
                $data->save();

                if ($request->product_json) {
                    $products = json_decode($request->product_json, true);
                    // return $products;
                    foreach ($products as $id => $item) {
                        $add = new PharmacyOrderData();
                        $add->order_id = $data->id;
                        $add->service_id = $item['id'];
                        $add->qty = $item['quantity'];
                        $add->name = $item['title'];
                        $add->price = $item['price'];
                        $add->save();
                    }
                }
            }

            $response['status'] = "1";
            $response['msg'] = __("message.Medicines_Order_Success");
            $response['data'] = $data;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function prescription_order(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "user_id" => "required",
            "pharmacy_id" => "required",
            "prescription_file" => "required",
            "phoneno" => "required",
            "address" => "required",
            "message" => "required",
        ];
        $messages = array(
            'user_id.required' => "user_id is required",
            'pharmacy_id.required' => "pharmacy_id is required",
            'prescription_file.required' => "prescription_file is required",
            'phoneno.required' => "phoneno is required",
            'address.required' => "address is required",
            'message.required' => "message is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $data = new PharmacyOrder();

            if ($request->hasFile('prescription_file')) {
                $file = $request->file('prescription_file');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/upload/orderprescription/';
                $picture = time() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $request->file('prescription_file')->move($destinationPath, $picture);
            }
            $data->prescription = $picture;
            $data->Pharmacy_id = $request->pharmacy_id;
            $data->phone = $request->phoneno;
            $data->message = $request->message;
            $data->address = $request->address;
            $data->is_completed = '1';
            $data->order_type = 1;
            $data->status = 0;
            $data->user_id = $request->user_id;
            $data->save();



            $response['status'] = "1";
            $response['msg'] = __("message.Prescription_Order_Success");
            $response['data'] = $data;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function view_order(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "order_id" => "required",

        ];
        $messages = array(
            'order_id.required' => "order_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = PharmacyOrder::find($request->order_id);
            if ($data) {
                $data1 = PharmacyOrderData::where('order_id', $data->id)->get();

                if (!$data1->isEmpty()) {
                    $sub = 0;
                    foreach ($data1 as $orderDetail) {
                        $medicine = PharmacyProduct::find($orderDetail->service_id);

                        if ($medicine && $medicine->image) {
                            $orderDetail->medicine_img = asset("public/upload/pharmacymedicine") . '/' . $medicine->image;
                        } else {
                            $orderDetail->medicine_img = "";
                        }
                        $sub += $orderDetail->price * $orderDetail->qty;
                    }
                    $data->subtotal = $sub;
                }

                $pharmacy = Doctors::find($data->Pharmacy_id);

                if ($pharmacy) { // Check if the pharmacy exists
                    $data->Pharmacy_name = $pharmacy->name;
                    $data->Pharmacy_address = $pharmacy->address;
                    $data->Pharmacy_email = $pharmacy->email;
                    $data->Pharmacy_phoneno = $pharmacy->phoneno;

                    $data->Pharmacy_image = $pharmacy->image
                        ? asset("public/upload/doctors") . '/' . $pharmacy->image
                        : "";
                } else {
                    // Handle case if pharmacy not found
                    $data->Pharmacy_name = "Pharmacy not found";
                    $data->Pharmacy_address = "";
                    $data->Pharmacy_email = "";
                    $data->Pharmacy_phoneno = "";
                    $data->Pharmacy_image = "";
                }

                $data->medicine = $data1;


                $user = Patient::find($data->user_id);
                if ($user) {
                    $data->user_image = $user->profile_pic ? asset("public/upload/profile/" . $user->profile_pic) : "";
                    $data->user_name = $user->name;
                    $data->user_email = $user->email;
                } else {
                    $data->user_image = "";
                    $data->user_name = "";
                    $data->user_email = "";
                }

                $setting = Setting::find(1);
                $data->admin_delivery_charge = $setting->pharmacy_delivery_charge;
                $data->admin_tax = $setting->pharmacy_tax;

                $response['status'] = "1";
                $response['msg'] = __("message.Order Details");
                $response['data'] = $data;
            } else {
                $response['status'] = "0";
                $response['msg'] = __("message.Order_not_found");
                // $response['data']=$data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function change_pharmacyorder_status(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "order_id" => "required",
            "status" => "required",
        ];
        $messages = array(
            'order_id.required' => "order_id is required",
            'status.required' => "status is required",

        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $data = PharmacyOrder::find($request->order_id);
            if ($data) {

                $data->status = $request->status;
                $data->save();

                if ($request->get("status") == '1') { // accept
                    $msg = __("message.pharmacy_order_Accept_msg");
                    $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                } else if ($request->get("status") == '2') { //reject
                    $msg = __("message.pharmacy_order_reject_msg");
                    $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                } else if ($request->get("status") == '3') { //complete
                    $msg = __("message.pharmacy_order_complete_msg");
                    $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                } else if ($request->get("status") == '4') { //waiting
                    $msg = __("message.pharmacy_order_user_Accept_msg");
                    $android = $this->sendNotifications($msg, $data->Pharmacy_id, "doctor_id", $data->id);
                } else if ($request->get("status") == '6') { //cancel
                    $msg =  __("message.pharmacy_order_user_reject_msg");
                    $android = $this->sendNotifications($msg, $data->Pharmacy_id, "doctor_id", $data->id);
                } else if ($request->get("status") == '7') { //Prepared
                    $msg =  __("message.pharmacy_order_Prepared_msg");
                    $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                } else if ($request->get("status") == '8') { //Out_for_Delivery
                    $msg =  __("message.pharmacy_order_Out_for_Delivery_msg");
                    $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                }

                $response['status'] = "1";
                $response['msg'] = __("message.Order_Status_Change_Success");
                // $response['data']=$data;
            } else {
                $response['status'] = "0";
                $response['msg'] = __("message.Order_not_found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function prescription_addprice(Request $request)
    {

        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "order_id" => "required",
            "price" => "required",
        ];
        $messages = array(
            'order_id.required' => "order_id is required",
            'price.required' => "price is required",

        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $data = PharmacyOrder::where('id', $request->order_id)->where('order_type', '1')->first();
            if ($data) {

                $setting = Setting::find(1);
                $subtotal = $request->price + $setting->pharmacy_delivery_charge;
                $tax = $subtotal * $setting->pharmacy_tax /100;

                $data->tax_pr = $setting->pharmacy_tax;
                $data->tax = $tax;
                $data->delivery_charge = $setting->pharmacy_delivery_charge;
                $data->total = $subtotal + $tax;
                $data->prescription_price = $request->price;
                $data->status = 5;
                $data->save();
                $msg = __("message.pharmacy_send_price_order");
                // $android = $this->send_notification_android_user($msg, $data->user_id);
                $android = $this->sendNotifications($msg, $data->user_id, "user_id", $data->id);
                $response['status'] = "1";
                $response['msg'] = __("message.pharmacy_send_price_order");
            } else {
                $response['status'] = "0";
                $response['msg'] = __("message.Order_not_found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function send_notification_android_user($msg, $user_id)
    {
        $setting = $user = User::find(1);
        $key = $setting->android_key;
        $getuser = TokenData::where("type", 1)->where("user_id", $user_id)->get();
        //  echo "<pre>";print_r($getuser);exit;
        $i = 0;
        if (count($getuser) != 0) {

            $reg_id = array();
            foreach ($getuser as $gt) {
                $reg_id[] = $gt->token;
            }
            $regIdChunk = array_chunk($reg_id, 1000);
            foreach ($regIdChunk as $k) {
                $registrationIds =  $k;

                $message = array(
                    'message' => $msg,
                    'title' =>  'Notification',
                    'notificationType' => 4,
                    'body' => $msg,
                );

                $message1 = array(
                    'body' => $msg,
                    'title' =>  'Notification'
                );
                $fields = array(
                    'registration_ids'  => $registrationIds,
                    'data'              => $message
                );
                $url = 'https://fcm.googleapis.com/fcm/send';
                $headers = array(
                    'Authorization: key=' . $key, // . $api_key,
                    'Content-Type: application/json'
                );
                $json =  json_encode($fields);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                $result = curl_exec($ch);
                //   echo "<pre>";print_r($result);exit;
                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }
                curl_close($ch);
                $response[] = json_decode($result, true);
            }
            $succ = 0;
            foreach ($response as $k) {
                $succ = $succ + $k['success'];
            }
            if ($succ > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function get_user_order_list(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "user_id" => "required",
        ];
        $messages = array(
            'user_id.required' => "user_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $data = PharmacyOrder::where('user_id', $request->user_id)
                ->orderBy('id', 'desc')
                ->get();

            if (!$data->isEmpty()) {
                foreach ($data as $d) {
                    $d->prescription = asset("public/upload/orderprescription") . '/' . $d->prescription;
                    if ($d->order_type == 2) {

                        $orderDetails = PharmacyOrderData::where('order_id', $d->id)->get();
                        $sub = 0;
                        if (!$orderDetails->isEmpty()) {
                            foreach ($orderDetails as $orderDetail) {
                                $medicine = PharmacyProduct::find($orderDetail->service_id);

                                if ($medicine && $medicine->image) {
                                    $orderDetail->medicine_img = asset("public/upload/pharmacymedicine") . '/' . $medicine->image;
                                } else {
                                    $orderDetail->medicine_img = "";
                                }
                                $sub += $orderDetail->price * $orderDetail->qty;
                            }
                        }
                        $d->medicine = $orderDetails; // Assigning the medicines to the order
                        $d->subtotal = $sub;
                    }



                    $pharmacy = Doctors::find($d->Pharmacy_id);

                    if ($pharmacy) { // Check if the pharmacy exists
                        $d->Pharmacy_name = $pharmacy->name;
                        $d->Pharmacy_address = $pharmacy->address;
                        $d->Pharmacy_email = $pharmacy->email;
                        $d->Pharmacy_phoneno = $pharmacy->phoneno;

                        $d->Pharmacy_image = $pharmacy->image
                            ? asset("public/upload/doctors") . '/' . $pharmacy->image
                            : "";
                    } else {
                        // Handle case if pharmacy not found
                        $d->Pharmacy_name = "Pharmacy not found";
                        $d->Pharmacy_address = "";
                        $d->Pharmacy_email = "";
                        $d->Pharmacy_phoneno = "";
                        $d->Pharmacy_image = "";
                    }
                }

                $response['status'] = "1";
                $response['msg'] = __("message.Order_List_Get_Success");
                $response['data'] = $data;
            } else {
                $response['status'] = "0";
                $response['msg'] = __("message.Order_not_found");
            }

            $response['status'] = "1";
            $response['msg'] = __("message.Prescription_Order_Success");
            $response['data'] = $data;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function get_pharmacy_order_list(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "pharmacy_id" => "required",
        ];
        $messages = array(
            'pharmacy_id.required' => "pharmacy_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->type) {
                $data = PharmacyOrder::where('pharmacy_id', $request->pharmacy_id)->whereIn('status', ['0', '1', '4', '5',' 7',' 8'])->orderby('id', "DESC")->get();
                if (count($data) != 0) {
                    foreach ($data as $d) {

                        $data1 = PharmacyOrderData::where('order_id', $d->id)->get();
                        if (count($data1) != 0) {
                            $d->medicine = $data1;
                        }
                        $user = Patient::find($d->user_id);
                        if ($user) {
                            $d->user_image = $user->profile_pic ? asset("public/upload/profile/" . $user->profile_pic) : "";
                            $d->user_name = $user->name;
                            $d->user_email = $user->email;
                        } else {
                            $d->user_image = "";
                            $d->user_name = "";
                            $d->user_email = "";
                        }
                    }
                    $response['status'] = "1";
                    $response['msg'] =  __("message.Order_List_Get_Success");
                    $response['data'] = $data;
                } else {
                    $response['status'] = "0";
                    $response['msg'] = __("message.Order_not_found");
                    $response['data'] = $data;
                }
            } else {
                $data = PharmacyOrder::where('pharmacy_id', $request->pharmacy_id)->orderby('id', "DESC")->get();
                if (count($data) != 0) {
                    foreach ($data as $d) {

                        $data1 = PharmacyOrderData::where('order_id', $d->id)->get();
                        if (count($data1) != 0) {
                            $d->medicine = $data1;
                        }
                        $user = Patient::find($d->user_id);
                        if ($user) {
                            $d->user_image = $user->profile_pic ? asset("public/upload/profile/" . $user->profile_pic) : "";
                            $d->user_name = $user->name;
                            $d->user_email = $user->email;
                        } else {
                            $d->user_image = "";
                            $d->user_name = "";
                            $d->user_email = "";
                        }
                    }


                    $response['status'] = "1";
                    $response['msg'] =  __("message.Order_List_Get_Success");
                    $response['data'] = $data;
                } else {
                    $response['status'] = "0";
                    $response['msg'] = __("message.Order_not_found");
                    $response['data'] = $data;
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function add_pharmacy_medicine(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "medicine_id" => "required",
            "pharmacy_id" => "required",
            "name" => "required",
            "description" => "required",
            "price" => "required",
        ];
        $messages = array(
            'medicine_id.required' => "medicine_id is required",
            'pharmacy_id.required' => "pharmacy_id is required",
            'name.required' => "name is required",
            'description.required' => "description is required",
            'price.required' => "price is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            if ($request->medicine_id == 0) {
                $data = new PharmacyProduct();

                $msg = __("message.Successfull Medicine Added");
                $img_url = "";
                $rel_url = "";
            } else {
                $data = PharmacyProduct::find($request->medicine_id);

                $msg = __("message.Successfull Medicine Update");
                $img_url = $data->image;
                $rel_url = $data->image;
            }

            if ($request->hasFile('upload_image')) {
                $file = $request->file('upload_image');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/upload/pharmacymedicine/';
                $picture = time() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $request->file('upload_image')->move($destinationPath, $picture);
                $img_url = $picture;
                $image_path = public_path() . "/upload/pharmacymedicine/" . $rel_url;
                if (file_exists($image_path) && $rel_url != "") {
                    try {
                        unlink($image_path);
                    } catch (Exception $e) {
                    }
                }
            }

            $data->image = $img_url;
            $data->pharmacy_id = $request->pharmacy_id;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->save();

            $response['status'] = "1";
            $response['msg'] = $msg;
            $response['data'] = $data;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function delete_pharmacy_medicine(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "medicine_id" => "required",
        ];
        $messages = array(
            'medicine_id.required' => "medicine_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = PharmacyProduct::find($request->medicine_id);
            if ($data) {
                $data->delete();
                $response['status'] = "1";
                $response['msg'] = __("message.Successfull Medicine Delete");
            } else {
                $response['status'] = "1";
                $response['msg'] = __("message.Result Not Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function get_bankdetails(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "doctor_id" => "required",

        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required",

        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $data = Doctors::select('bank_name', 'ifsc_code', 'account_no', 'account_holder_name')->find($request->doctor_id);

            if ($data) {
                $response['success'] = "1";
                $response['msg'] =  __("message.Doctors_Bank_Details");
                $response['data'] = $data;
            } else {
                $response = array("status" => 0, "msg" => __("message.Doctor_Not_Found"));
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function add_bankdetails(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [
            "doctor_id" => "required",
            "bank_name" => "required",
            "ifsc_code" => "required",
            "account_no" => "required",
            "account_holder_name" => "required",
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'bank_name.required' => "bank_name is required",
            'ifsc_code.required' => "ifsc_code is required",
            'account_no.required' => "account_no is required",
            'account_holder_name.required' => "account_holder_name is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $data = Doctors::find($request->doctor_id);

            if ($data) {
                $data->bank_name = $request->get("bank_name");
                $data->ifsc_code = $request->get("ifsc_code");
                $data->account_no = $request->get("account_no");
                $data->account_holder_name = $request->get("account_holder_name");
                $data->save();

                $response['success'] = "1";
                $response['msg'] =  __("message.Doctors_Bank_Add_Success");
                // $response['data']=$data;


            } else {
                $response = array("status" => 0, "msg" => __("message.Doctor_Not_Found"));
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function most_used_medicine(Request $request)
    {
        $response = array("status" => 1, "msg" => "Validation error");
        $rules = [];
        $messages = array();
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $data = Medicines::select("id", "name", "dosage", "medicine_type", "description")->limit(15)->get();

            if ($data) {

                // $response['success']="1";
                $response['msg'] = __("message.Medicines_data_Get_Success");
                $response['data'] = $data;
            } else {
                $response = array("status" => 0, "msg" => "Medicines id Not Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function upload_image(Request $request)
    {
        $response = array("status" => "0", "message" => "Validation error");
        $rules = [
            'appointment_id' => 'required',
            'image' => 'required',
            'name' => 'required'
        ];
        $messages = array(
            'appointment_id.required' => "appointment_id is required",
            'image.required' => "image is required",
            'name.required' => "name is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/upload/ap_img_up/';
                $picture = time() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $request->file('image')->move($destinationPath, $picture);
                $img_url = $picture;
            } else {
                $img_url = '';
            }
            $data = new ap_img_uplod();
            $data->name = $request->get("name");
            $data->appointment_id = $request->get("appointment_id");
            $data->image = $img_url;
            $data->save();
            $response = array("status" => 1, "message" => __("message.Upload Image"), "data" => $data);
            return Response::json($response);
            // $response['success']="1";
            // $response['message']="Update Successfully";
            //  $response['data']=$data;
            // return $request;

        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function delete_upload_image(Request $request)
    {
        $response = ['status' => '0', 'message' => 'Validation error'];
        $rules = [
            'image_id' => 'required',
        ];
        $messages = [
            'image_id.required' => 'image_id is required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ', ';
            }
            $response['msg'] = $message;
        } else {
            $data = ap_img_uplod::find($request->get('image_id'));
            if ($data) {

                $image_path = public_path('upload/ap_img_up') . '/' . $data->image;
                unlink($image_path);
                $data->delete();

                $response['status'] = '1';
                $response['message'] =  __("message.Image_Delete_Successfully");
            } else {
                $response['status'] = '0';
                $response['message'] = __("message.Image_allready_deleted");
            }
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    public function add_medicine_to_app(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            'medicine_id' => 'required',
            'appointment_id' => 'required',
        ];
        $messages = array(
            'medicine_id.required' => 'The Medicine Id field is required.',
            'appointment_id.required' => 'The Appointment Id  field is required.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);

            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $BookAppointment = BookAppointment::where('id', $request->appointment_id)->first();
            if ($BookAppointment) {
                $app_medicine = new AppointmentMedicines;
                $app_medicine->appointment_id = $request->appointment_id;
                $app_medicine->medicines = $request->medicine_id;
                $app_medicine->save();

                // $user=BookAppointment::find($request->get("appointment_id"));
                // $set = Setting::find(1);
                // $msg = "Doctor have sent E-Prescription for you";
                // $android=$this->send_notification_android_user($set->android_key,$msg,$user->user_id);

                $response = array("status" => 1, "msg" =>  __("message.Successfull Medicine Added")); //"Medicine successfully added to E-prescription."
            } else {
                $response = array("status" => 0, "msg" => __("message.Appointment Not Found"));
            }
        }
        return Response::json($response);
    }

    public function search_medicine(Request $request)
    {

        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            'name' => 'required'
        ];
        $messages = array(
            'name.required' => "name is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = Medicines::Where('name', 'like', '%' . $request->get("name") . '%')->select("id", "name", "dosage", "medicine_type", "description")->get();
            if ($data) {
                // foreach($data as $data){
                //     $arrName[] = array(
                //     "id"=>$data->id,
                //     "name"=>$data->name,
                //     "dosage"=>$data->dosage,
                //     "medicine_type"=>$data->explode(',',$data->medicine_type)
                //     );
                // }
                // return $arrName;

                $response = array("status" => 1, "msg" => __("message.Search Result"), "data" => $data);
            } else {
                $response = array("status" => 0, "msg" => __("message.Result Not Found"));
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function change_password_doctor(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
            'conf_password' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'old_password.required' => "old_password is required",
            'new_password.required' => "new_password is required",
            'conf_password.required' => "conf_password is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $data = Doctors::where('id', $request->get("doctor_id"))->first();

            if ($data) {

                if ($data->password == $request->get("old_password")) {
                    if ($request->get("new_password") == $request->get("new_password")) {
                        $data->password = $request->get("new_password");
                        $data->save();
                        $response = array("status" => 1, "msg" => __("message.Password Change Successfully"));
                    } else {
                        $response = array("status" => 0, "msg" => __("message.Confirm_Password_not_match"));
                    }
                } else {
                    $response = array("status" => 0, "msg" => __("message.Current_Password_wrong"));
                }
            } else {
                $response = array("status" => 0, "msg" => __("message.Doctor_Not_Found"));
            }
        }
        return Response::json($response);
    }

    public function doctor_subscription_list(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];
        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $data = Doctors::where('id', $request->get("doctor_id"))->first();

            if ($data) {

                $Subscriber = Subscriber::where('doctor_id', $request->get("doctor_id"))->where('is_complet', "1")->where('status', "2")->join('doctors', 'doctors.id', '=', 'subscriber.doctor_id')->join('subscription', 'subscription.id', '=', 'subscriber.subscription_id')->get(['subscriber.status', 'subscription.month', 'subscription.price', 'subscriber.date']);

                if ($Subscriber) {

                    $ls['doctors_subscription'] = $Subscriber;
                    $response['success'] = "1";
                    $response['register'] = __("message.Subscription List");
                    $response['data'] = $ls;
                } else {

                    $response = array("status" => 0, "msg" => __("message.Subscription_Detail_Found"));
                }
            } else {
                $response = array("status" => 0, "msg" => __("message.Doctor_Not_Found"));
            }
        }
        return Response::json($response);
    }

    public function get_subscription_list()
    {
        $data = Subscription::all();
        if ($data) {
            $setting = Setting::find(1);
            $currency = explode("-", trim($setting->currency));
            $array = array("data" => $data, "currency" => trim($currency[1]));
            $response = array("status" => 1, "msg" => __("message.Subscription List"), "data" => $array);
        } else {
            $response = array("status" => 0, "msg" => __("message.Result Not Found"));
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function get_all_doctor(Request $request)
    {
        $data = Doctors::take(27)->get();
        $services = Services::all();
        foreach ($data as $d) {
            $d->timing = Schedule::select("start_time", "day_id", "end_time", "duration")->where("doctor_id", $d->id)->get();
        }
        return json_encode(array("services" => $services, "data" => $data));
    }

    public function showsearchdoctor(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            'term' => 'required'
        ];
        $messages = array(
            'term.required' => "term is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            $data = Doctors::Where('name', 'like', '%' . $request->get("term") . '%')->select("id", "name", "address", "image", "department_id")->paginate(10);
            if ($data) {

                foreach ($data as $k) {
                    $dr = Services::find($k->department_id);
                    if ($dr) {
                        $k->department_name = $dr->name;
                    } else {
                        $k->department_name = "";
                    }
                    $k->image = asset('public/upload/doctors') . '/' . $k->image;
                    unset($data->department_id);
                }
                $response = array("status" => 1, "msg" => __("message.Search Result"), "data" => $data);
            } else {
                $response = array("status" => 0, "msg" => __("message.Result Not Found"));
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function nearbydoctor(Request $request)
    {
        $response = array("status" => "0", "register" => "Validation error");
        $rules = [
            // 'lat' => 'required',
            // 'lon' => 'required',
            'type' => 'required',
        ];
        if ($request->type == 1) {
            $rules['lat'] = 'required';
            $rules['lon'] = 'required';
        }
        $messages = array(
            'lat.required' => "lat is required",
            'lon.required' => 'lon is requied',
            'type.required' => 'type is requied',
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {
            if ($request->type == 1) {
                $lat = $request->get("lat");
                $lon =  $request->get("lon");

                $data = DB::table("doctors")
                    ->select(
                        "doctors.id",
                        "doctors.name",
                        "doctors.address",
                        "doctors.department_id",
                        "doctors.image",
                        DB::raw("6371 * acos(cos(radians(" . $lat . "))
                              * cos(radians(doctors.lat))
                              * cos(radians(doctors.lon) - radians(" . $lon . "))
                              + sin(radians(" . $lat . "))
                              * sin(radians(doctors.lat))) AS distance")
                    )
                    ->orderby('distance')->WhereNotNull("doctors.lat")->where('profile_type', 1)->paginate(10);

                if ($data) {

                    foreach ($data as $k) {
                        $department = Services::find($k->department_id);
                        $k->department_name = isset($department) ? $department->name : "";
                        $k->image = asset("public/upload/doctors") . '/' . $k->image;
                        unset($k->department_id);
                    }
                    $response = array("status" => 1, "msg" => __("message.Search Result"), "data" => $data);
                } else {
                    $response = array("status" => 0, "msg" => __("message.Result Not Found"));
                }
            } else {

                $data = DB::table("doctors")->select(
                    "doctors.id",
                    "doctors.name",
                    "doctors.address",
                    "doctors.department_id",
                    "doctors.image",
                )->where('profile_type', 2)->paginate(10);
                if ($data) {
                    foreach ($data as $k) {
                        $k->image = asset("public/upload/doctors") . '/' . $k->image;
                        unset($k->department_id);
                    }
                    $response = array("status" => 1, "msg" => __("message.Search Result"), "data" => $data);
                } else {
                    $response = array("status" => 0, "msg" => __("message.Result Not Found"));
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function postregisterpatient(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'phone' => 'required',
            'password' => 'required',
            // 'token' => 'required',
            'email' => 'required',
            'name' => 'required'
        ];

        $messages = array(
            'phone.required' => "Mobile No is required",
            'password.required' => "password is required",
            //   'token.required' => "token is required",
            'phone.unique' => "Mobile Number Already Register",
            'email.required' => 'Email is required',
            'name.required' => 'name is required'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $getuser = Patient::where("phone", $request->get("phone"))->first();
            if (empty($getuser)) { //update token

                $getemail = Patient::where("email", $request->get("email"))->first();
                if ($getemail) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Email Already Existe");
                } else {

                    $inset = new Patient();
                    $inset->phone = $request->get("phone");
                    $inset->name = $request->get("name");
                    $inset->password = $request->get("password");
                    $inset->email = $request->get("email");
                    $inset->save();
                    $store = TokenData::where("token", $request->get("token"))->update(["user_id" => $inset->id]);
                    $response['success'] = "1";
                    $response['register'] = array("user_id" => $inset->id, "name" => $request->get("name"), "phone" => $inset->phone, "email" => $inset->email);
                }
            } else {
                $response['success'] = "0";
                $response['register'] = __("message.Mobile_No_Already_Register");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function storetoken(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'type' => 'required',
            'token' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response['register'] =  __("message.enter_data_perfectly");
        } else {
            $store = new TokenData();
            $store->token = $request->get("token");
            $store->type = $request->get("type");
            $store->save();
            $response['success'] = "1";
            //   $response['headers']=array("Access-Control-Allow-Origin"=>"*","Access-Control-Allow-Credentials"=>true,"Access-Control-Allow-Headers"=>"Origin,Content-Type,X-Amz-Date,Authorization,X-Api-Key,X-Amz-Security-Token","Access-Control-Allow-Methods"=>"POST, OPTIONS,GET");
            $response['register'] = "Registered";
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function getalldoctors()
    {
        $data = Doctors::take(26)->get();
        return Response::json($data);
    }

    public function showlogin(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'email' => 'required',
            // 'token' => 'required',
            "login_type" => 'required'
        ];
        if ($request->input('login_type') == '1') {
            $rules['password'] = 'required';
        }
        if ($request->input('login_type') == '2' || $request->input('login_type') == '3' || $request->input('login_type') == '4') {
            $rules['name'] = 'required';
            //   $rules['phone']='required';
        }
        $messages = array(
            'email.required' => "Email is required",
            'password.required' => "password is required",
            //   'token.required' => "token is required",
            'login_type.required' => "login type is required",
            'name.required' => "name is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {

            if ($request->input('login_type') == '1') {
                $getuser = Patient::where("email", $request->get("email"))->where("password", $request->get("password"))->first();
                if ($getuser) { //update token
                    $store = TokenData::where("token", $request->get("token"))->first();
                    if ($store) {
                        $store->user_id = $getuser->id;
                        $store->save();
                    }
                    $getuser->login_type = $request->get("login_type");
                    $getuser->save();
                    if ($getuser->profile_pic != "") {
                        $image = asset("public/upload/profile") . '/' . $getuser->profile_pic;
                    } else {
                        $image = asset("public/upload/profile/profile.png");
                    }
                    $response['success'] = "1";
                    $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                    $response['register'] = array("user_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phone, "email" => $getuser->email, "profile_pic" => $image, "connectycube_user_id" => $getuser->connectycube_user_id, "login_id" => $getuser->login_id, "connectycube_password" => $getuser->connectycube_password);
                } else { //in vaild user
                    $data = Patient::where("phone", $request->get("phone"))->first();
                    if ($data) {
                        $response['success'] = "0";
                        $response['register'] = __("message.Current Password is Wrong");
                    } else {
                        $response['success'] = "0";
                        $response['register'] = __("message.You have entered an invalid email address");
                    }
                }
            } else if ($request->input('login_type') == '2' || $request->input('login_type') == '3' || $request->input('login_type') == '4') {
                $getuser = Patient::where("email", $request->get("email"))->first();
                if ($getuser) { //update patient
                    $imgdata = $getuser->profile_pic;
                    $png_url = "";
                    if ($request->get("image") != "") {
                        $png_url = "profile-" . mt_rand(100000, 999999) . ".png";
                        $path = public_path() . '/upload/profile/' . $png_url;
                        $content = $this->file_get_contents_curl($request->get("image"));
                        $savefile = fopen($path, 'w');
                        fwrite($savefile, $content);
                        fclose($savefile);
                        $img = public_path() . '/upload/profile/' . $png_url;
                        $getuser->login_type = $request->get("login_type");
                        $getuser->profile_pic = $png_url;
                        $getuser->save();
                    }
                    if ($imgdata != $png_url && $imgdata != "") {
                        $image_path = public_path() . "/upload/profile/" . $imgdata;
                        if (file_exists($image_path) && $imgdata != "") {
                            try {
                                unlink($image_path);
                            } catch (Exception $e) {
                            }
                        }
                    }
                    $store = TokenData::where("token", $request->get("token"))->first();
                    if ($store) {
                        $store->user_id = $getuser->id;
                        $store->save();
                    }
                    if ($getuser->profile_pic != "") {
                        $image = asset("public/upload/profile") . '/' . $getuser->profile_pic;
                    } else {
                        $image = asset("public/upload/profile/profile.png");
                    }
                    $response['success'] = "1";
                    $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                    $response['register'] = array("user_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phone, "email" => $getuser->email, "profile_pic" => $image, "connectycube_user_id" => $getuser->connectycube_user_id, "login_id" => $getuser->login_id, "connectycube_password" => $getuser->connectycube_password);
                } else { //register patient

                    $login_field = "";
                    $user_id = "";
                    $connectycube_password = "";

                    $getuser = new Patient();
                    $phone = rand(100000000, 9999999999);
                    $getuser->login_type = $request->get("login_type");
                    $png_url = "";
                    if ($request->get("image") != "") {
                        $png_url = "profile-" . mt_rand(100000, 999999) . ".png";
                        $path = public_path() . '/upload/profile/' . $png_url;
                        $content = $this->file_get_contents_curl($request->get("image"));
                        $savefile = fopen($path, 'w');
                        fwrite($savefile, $content);
                        fclose($savefile);
                        $img = public_path() . '/upload/profile/' . $png_url;
                        $getuser->profile_pic = $png_url;
                    }
                    $number = rand();
                    $fix = "@123";
                    $length = 8;
                    $password = substr(str_repeat(0, $length) . $number . $fix, -$length);
                    $getuser->phone = $phone;
                    $getuser->name = $request->get("name");
                    $getuser->password = $password;
                    $getuser->email = $request->get("email");

                    if (env('ConnectyCube') == true) {

                        $login_field = $request->get("phone") . rand() . "#1";

                        $user_id = $this->signupconnectycude($request->get("name"), $password, $request->get("email"), $phone, $login_field);
                        $connectycube_password = $password;
                    }

                    $getuser->connectycube_user_id = $user_id;
                    $getuser->login_id = $login_field;
                    $getuser->connectycube_password = $connectycube_password;


                    if ($user_id == "0-email must be unique") {
                        $response['success'] = "0";
                        $response['register'] = __("message.ConnectCube_error_msg");
                    } else {
                        $getuser->save();
                        $store = TokenData::where("token", $request->get("token"))->first();
                        if ($store) {
                            $store->user_id = $getuser->id;
                            $store->save();
                        }
                        if ($getuser->profile_pic != "") {
                            $image = asset("public/upload/profile") . '/' . $getuser->profile_pic;
                        } else {
                            $image = asset("public/upload/profile/profile.png");
                        }

                        $response['success'] = "1";
                        $response['headers'] = array('Access-Control-Allow-Origin' => '*');
                        $response['register'] = array("user_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phone, "email" => $getuser->email, "profile_pic" => $image, "connectycube_user_id" => $getuser->connectycube_user_id, "login_id" => $getuser->login_id, "connectycube_password" => $getuser->connectycube_password);
                    }
                }
            } else {
                $data = Patient::where("phone", $request->get("phone"))->first();
                if ($data) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Invaild Phone Number");
                } else {
                    $response['success'] = "0";
                    $response['register'] = __("message.Invaild Login Type");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function file_get_contents_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function doctorregister(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'phone' => 'required',
            'password' => 'required',
            'email' => 'required',
            'name' => 'required',
            // 'type' => 'required',
            // 'token' =>'required'
        ];

        $messages = array(
            'phone.required' => "Mobile No is required",
            'password.required' => "password is required",
            //   'token.required' => "token is required",
            'email.required' => 'Email is required',
            'name.required' => 'name is required',
            // 'type.required' => "type is required",
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $getuser = Doctors::where("email", $request->get("email"))->first();
            if (empty($getuser)) { //update token
                $inset = new Doctors();
                $inset->phoneno = $request->get("phone");
                $inset->name = $request->get("name");
                $inset->password = $request->get("password");
                $inset->email = $request->get("email");
                if ($request->get("type")) {
                    if ($request->get("type") == 2) {
                        $inset->profile_type = $request->get("type");
                    }
                } else {
                    $inset->profile_type = 1;
                }
                $inset->save();
                $store = TokenData::where("token", $request->get("token"))->update(["user_id" => $inset->id]);
                $response['success'] = "1";
                $response['register'] = array("user_id" => $inset->id, "name" => $inset->name, "phone" => $inset->phoneno, "email" => $inset->email,);
            } else {
                $response['success'] = "0";
                $response['register'] = __("message.Email Already Existe");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function doctorlogin(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'type' => 'required',
            // 'token' => 'required'
        ];

        $messages = array(
            'email.required' => "Email is required",
            'password.required' => "password is required",
            'type.required' => "type is required",
            //   'token.required' => "token is required"
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $getuser = Doctors::where("email", $request->get("email"))->where("password", $request->get("password"))->where("profile_type",  $request->get("type"))->first();

            if ($getuser) { //update token
                $store = TokenData::where("token", $request->get("token"))->first();
                if ($store) {
                    $store->doctor_id = $getuser->id;
                    $store->save();
                }
                if ($getuser->image != "") {
                    $image = asset("public/upload/doctors") . '/' . $getuser->image;
                } else {
                    $image = asset("public/upload/profile/profile.png");
                }
                $response['success'] = "1";
                $response['register'] = array("doctor_id" => $getuser->id, "name" => $getuser->name, "phone" => $getuser->phoneno, "email" => $getuser->email, "login_id" => $getuser->login_id, "connectycube_user_id" => $getuser->connectycube_user_id, "profile_pic" => $image, "connectycube_password" => $getuser->connectycube_password);
            } else { //in vaild user
                $data = Doctors::where("email", $request->get("email"))->first();
                if ($data) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Current Password is Wrong");
                } else {
                    $response['success'] = "0";
                    $response['register'] = __("message.You have entered an invalid email address");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function getspeciality()
    {
        //$data=Services::select('id','name','icon')->paginate(10);
        $data = Services::select('id', 'name', 'icon')->get();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $d->total_doctors = count(Doctors::where("department_id", $d->id)->get());
                $d->icon = asset("public/upload/services") . '/' . $d->icon;
            }
            $response['success'] = "1";
            $response['register'] = __("message.Speciality_list");
            $response['data'] = $data;
        } else {
            $response['success'] = "0";
            $response['register'] = __("message.Speciality_Not_Found");
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function bookappointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required',
            'doctor_id' => 'required',
            'date' => 'required',
            'slot_id' => 'required',
            'slot_name' => 'required',
            'phone' => 'required',
            'user_description' => 'required',
            'payment_type' => 'required',
            'consultation_fees' => 'required'
        ];

        if ($request->get("payment_type") == "stripe") {
            $rules['stripe_payment_id'] = 'required';
        }
        $messages = array(
            'stripe_payment_id.required' => "stripe_payment_id is required",
            'user_id.required' => "user_id is required",
            'doctor_id.required' => "doctor_id is required",
            'date.required' => "date is required",
            'slot_id.required' => "slot_id is required",
            'slot_name.required' => "slot_name is required",
            'phone.required' => "phone is required",
            'user_description.required' => "user_description is required",
            //   'payment_method_nonce.required'=>"payment_method_nonce is required",
            'consultation_fees.requierd' => "consultation_fees is required",
            "payment_type.required" => "Payment Type is Required",
            //   "stripeToken.required"=>"stripeToken is required"
        );


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if (Patient::find($request->get("user_id"))) {

                $getappointment = BookAppointment::where("date", $request->get("date"))->where('is_completed', '1')->where("slot_id", $request->get("slot_id"))->first();
                if ($getappointment) {
                    $response['success'] = "0";
                    $response['register'] = "Slot Already Booked";
                } else {
                    DB::beginTransaction();
                    try {
                        $date = DateTime::createFromFormat('d', 15)->add(new DateInterval('P1M'));
                        $data = new BookAppointment();
                        $data->user_id = $request->get("user_id");
                        $data->doctor_id = $request->get("doctor_id");
                        $data->slot_id = $request->get("slot_id");
                        $data->slot_name = $request->get("slot_name");
                        $data->date = $request->get("date");
                        $data->phone = $request->get("phone");
                        $data->user_description = $request->get("user_description");
                        if ($request->get("payment_type") == "COD") {
                            $data->payment_mode = "COD";
                            $data->is_completed = "1";
                        } else if ($request->get("payment_type") == "stripe") {
                            $data->payment_mode = "";
                            $data->is_completed = "1";
                            $data->transaction_id = $request->get("stripe_payment_id");
                        } else {
                            $data->payment_mode = "";
                            $data->is_completed = "0";
                        }


                        $data->consultation_fees = $request->get("consultation_fees");
                        $data->save();
                        if ($request->get("payment_type") == "COD") {
                            $url = "";
                        } else {
                            $url = route('make-payment', ['id' => $data->id, "type" => '1']);
                        }
                        if ($data->payment_mode == "COD") {
                            $store = new Settlement();
                            $store->book_id = $data->id;
                            $store->status = '0';
                            $store->payment_date = $date->format('Y-m-d');
                            $store->doctor_id = $data->doctor_id;
                            $store->amount = $request->get("consultation_fees");
                            $store->save();
                            $msg = __("message.You have a new upcoming appointment");
                            $user = User::find(1);
                            // $android = $this->send_notification_android($user->android_key, $msg, $request->get("doctor_id"), "doctor_id", $data->id);
                            // $ios = $this->send_notification_IOS($user->ios_key, $msg, $request->get("doctor_id"), "doctor_id", $data->id);
                            $android = $this->sendNotifications($msg, $request->get("doctor_id"), "doctor_id", $data->id);
                            try {
                                $user = Doctors::find($request->get("doctor_id"));
                                $user->msg = $msg;

                                $result = Mail::send('email.Ordermsg', ['user' => $user], function ($message) use ($user) {
                                    $message->to($user->email, $user->name)->subject(__('message.System Name'));
                                });
                            } catch (\Exception $e) {
                            }
                        }
                        $response['success'] = "1";
                        $response['register'] = __("message.Appointment Book Successfully");
                        $response['data'] = $data->id;
                        $response['url'] = $url;
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollback();
                        $response['success'] = "0";
                        $response['register'] = $e;
                    }
                }
            } else {
                $response['success'] = "3";
                $response['register'] = __("message.User not found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function viewdoctor(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'type' => 'required',
        ];
        if ($request->type == 1) {
            $rules['doctor_id'] = 'required';
        } else {
            $rules['pharmacy_id'] = 'required';
        }
        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'pharmacy_id.required' => "pharmacy_id is required",
            'type.required' => "type is required",
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if ($request->type == 1) {
                $getdetail = Doctors::find($request->get("doctor_id"));
                unset($getdetail->state);
                unset($getdetail->city);
                if (empty($getdetail)) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Doctor_Not_Found");
                } else {
                    $getdepartment = Services::find($getdetail->department_id);
                    if ($getdepartment) {
                        $getdetail->department_name = $getdepartment->name;
                    } else {
                        $getdetail->department_name = "";
                    }
                    $getdetail->avgratting = Review::where('doc_id', $request->get("doctor_id"))->avg('rating');
                    $getdetail->total_review = count(Review::where('doc_id', $request->get("doctor_id"))->get());
                    $getdetail->image = asset('public/upload/doctors') . '/' . $getdetail->image;
                    $response['success'] = "1";
                    $response['register'] = __("message.Doctor_Get_Success");
                    $response['data'] = $getdetail;
                }
            } else {
                $getdetail = Doctors::where('id', $request->get("pharmacy_id"))->where('profile_type', 2)->first();
                unset($getdetail->state);
                unset($getdetail->city);
                if (empty($getdetail)) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Pharmacy_Not_Found");
                } else {
                    $getdepartment = Services::find($getdetail->department_id);
                    if ($getdepartment) {
                        $getdetail->department_name = $getdepartment->name;
                    } else {
                        $getdetail->department_name = "";
                    }
                    $getdetail->avgratting = Review::where('doc_id', $request->get("pharmacy_id"))->avg('rating');
                    $getdetail->total_review = count(Review::where('doc_id', $request->get("pharmacy_id"))->get());
                    $getdetail->image = asset('public/upload/doctors') . '/' . $getdetail->image;
                    $response['success'] = "1";
                    $response['register'] = __("message.Pharmacy_Get_Success");
                    $response['data'] = $getdetail;
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function addreview(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required',
            'rating' => 'required',
            'doc_id' => 'required',
            'description' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'rating.required' => "rating is required",
            'doc_id.required' => "doc_id is required",
            'description.required' => "description is required"
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {

            $store = new Review();
            $store->user_id = $request->get("user_id");
            $store->doc_id = $request->get("doc_id");
            $store->rating = $request->get("rating");
            $store->description = $request->get("description");
            $store->save();
            $response['success'] = "1";
            $response['register'] = __("message.Review_Add_Success");
            $response['data'] = $store;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function getslotdata(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'date' => 'required',

        ];

        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'date.required' => "date is required"
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $day = date('N', strtotime($request->get("date"))) - 1;
            $data = Schedule::with('getslotls')->where("doctor_id", $request->get("doctor_id"))->where("day_id", $day)->get();
            $main = array();
            if (count($data) > 0) {
                foreach ($data as $k) {
                    $slotlist = array();
                    $slotlist['title'] = $k->start_time . " - " . $k->end_time;
                    if (count($k->getslotls) > 0) {
                        foreach ($k->getslotls as $b) {
                            $ka = array();
                            $getappointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->whereNotNull('transaction_id')->where('is_completed', '1')->where('status', "!=", 6)->first();
                            $getcodappointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->where('payment_mode', "COD")->where('is_completed', '1')->where('status', "!=", 6)->first();
                            $cancel_appointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->where('status', 6)->where('is_completed', '1')->first();

                            $ka['id'] = $b->id;
                            $ka['name'] = $b->slot;

                            if ($getappointment || $getcodappointment) {
                                $ka['is_book'] = '1';
                            } elseif ($cancel_appointment) {
                                $ka['is_book'] = '0';
                            } else {
                                $ka['is_book'] = '0';
                            }
                            $slotlist['slottime'][] = $ka;
                        }
                    }
                    $main[] = $slotlist;
                }
            }
            if (empty($slotlist)) {
                $response['success'] = "0";
                $response['register'] = __("message.Slot_Not_Found");
            } else {
                $response['success'] = "1";
                $response['register'] = __("message.Get_Slot_Success");
                $response['data'] = $main;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function getlistofdoctorbyspecialty(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'department_id' => 'required',
            'lat' => 'required',
            'lon' => 'required'
        ];

        $messages = array(
            'department_id.required' => "department_id is required",
            'lat.required' => "lat is required",
            'lon.required' => "lon is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $lat = $request->get('lat');
            $lon = $request->get("lon");
            $data =  $data = DB::table("doctors")
                ->where("department_id", $request->get("department_id"))
                ->select(
                    "doctors.id",
                    "doctors.name",
                    "doctors.address",
                    "doctors.email",
                    "doctors.phoneno",
                    "doctors.department_id",
                    "doctors.image",
                    DB::raw("6371 * acos(cos(radians(" . $lat . "))
                              * cos(radians(doctors.lat))
                              * cos(radians(doctors.lon) - radians(" . $lon . "))
                              + sin(radians(" . $lat . "))
                              * sin(radians(doctors.lat))) AS distance")
                )
                ->orderby('distance')->WhereNotNull("doctors.lat")->paginate(10);

            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = "Doctors Not Found";
            } else {
                foreach ($data as $d) {
                    $dp = Services::find($d->department_id);
                    if ($dp) {
                        $d->department_name = $dp->name;
                    }
                    $d->image = asset('public/upload/doctors') . '/' . $d->image;
                }
                $response['success'] = "1";
                $response['register'] = __("message.Doctor_Get_Success");
                $response['data'] = $data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function userspastappointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = BookAppointment::where("user_id", $request->get("user_id"))->select("id", "doctor_id", "date", "slot_name as slot", 'phone')->where('is_completed', '1')->orderby('id', "DESC")->paginate(15);

            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            } else {
                $new = array();
                foreach ($data as $d) {
                    $a = array();

                    $doctors = Doctors::find($d->doctor_id);
                    $department = Services::find($doctors->department_id);
                    if ($doctors) {
                        $d->name = $doctors->name;
                        $d->address = $doctors->address;
                        $d->image = isset($doctors->image) ? asset('public/upload/doctors') . '/' . $doctors->image : "";
                        $d->department_name = isset($department) ? $department->name : "";
                    } else {
                        $d->name = "";
                        $d->address = "";
                        $d->image = "";
                        $d->department_name = "";
                    }

                    unset($d->department_id);
                    unset($d->doctor_id);
                    unset($d->doctorls);
                    if ($d->status == '1') {
                        $d->status = __("message.Received");
                    } else if ($d->status == '2') {
                        $d->status = __("message.Approved");
                    } else if ($d->status == '3') {
                        $d->status = __("message.In Process");
                    } else if ($d->status == '4') {
                        $d->status = __("message.Completed");
                    } else if ($d->status == '5') {
                        $d->status = __("message.Rejected");
                    } else {
                        $d->status = __("message.Absent");
                    }
                }


                $response['success'] = "1";
                $response['register'] = __("message.Appointment Book list");
                $response['data'] = $data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function usersupcomingappointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = BookAppointment::where("date", ">=", date('Y-m-d'))->select("id", "doctor_id", "date", "slot_name as slot", 'phone')->where('is_completed', '1')->where("user_id", $request->get("user_id"))->paginate(15);
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            } else {
                foreach ($data as $d) {
                    $a = array();

                    $doctors = Doctors::find($d->doctor_id);
                    $department = Services::find($doctors->department_id);
                    if ($doctors) {
                        $d->name = $doctors->name;
                        $d->address = $doctors->address;
                        $d->image = isset($doctors->image) ? asset('public/upload/doctors') . '/' . $doctors->image : "";
                        $d->department_name = isset($department) ? $department->name : "";
                    } else {
                        $d->name = "";
                        $d->address = "";
                        $d->image = "";
                        $d->department_name = "";
                    }
                    unset($d->department_id);
                    unset($d->doctor_id);
                    unset($d->doctorls);

                    if ($d->status == '1') {
                        $d->status = __("message.Received");
                    } else if ($d->status == '2') {
                        $d->status = __("message.Approved");
                    } else if ($d->status == '3') {
                        $d->status = __("message.In Process");
                    } else if ($d->status == '4') {
                        $d->status = __("message.Completed");
                    } else if ($d->status == '5') {
                        $d->status = __("message.Rejected");
                    } else {
                        $d->status = __("message.Absent");
                    }
                    //$new[]=$a;
                }
                $response['success'] = "1";
                $response['register'] = __("message.Appointment Book list");
                $response['data'] = $data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function reviewlistbydoctor(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];


        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = Review::with('patientls')->where("doc_id", $request->get("doctor_id"))->orderby('id', 'DESC')->select('id', 'user_id', 'rating', 'description')->get();
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Review_Not_Found");
            } else {
                $main_array = array();
                foreach ($data as $d) {
                    $ls = array();
                    $ls['name'] = isset($d->patientls->name) ? $d->patientls->name : "";
                    $ls['rating'] = isset($d->rating) ? $d->rating : "";
                    $ls['description'] = isset($d->description) ? $d->description : "";
                    $ls['image'] = isset($d->patientls->profile_pic) ? asset('public/upload/profile') . '/' . $d->patientls->profile_pic : "";
                    $ls['phone'] = isset($d->patientls->phone) ? $d->phone : "";
                    $main_array[] = $ls;
                }

                $response['success'] = "1";
                $response['register'] = __("message.Review_List_Success");
                $response['data'] = $main_array;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function doctorpastappointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];

        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = BookAppointment::orderby('id', "DESC")->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->select("date", "id", "slot_name as slot", "user_id", "phone", "status")->paginate(10);
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            } else {
                foreach ($data as $d) {
                    $user = Patient::find($d->user_id);
                    if ($user) {
                        $d->name = $user->name;
                        $d->image = isset($user->profile_pic) ? asset('public/upload/profile') . '/' . $user->profile_pic : "";
                    } else {
                        $d->name = "";
                        $d->image = "";
                    }
                    if ($d->status == '1') {
                        $d->status = __("message.Received");
                    } else if ($d->status == '2') {
                        $d->status = __("message.Approved");
                    } else if ($d->status == '3') {
                        $d->status = __("message.In Process");
                    } else if ($d->status == '4') {
                        $d->status = __("message.Completed");
                    } else if ($d->status == '5') {
                        $d->status = __("message.Rejected");
                    } else {
                        $d->status = __("message.Absent");
                    }
                    unset($d->user_id);
                }
                $response['success'] = "1";
                $response['register'] = __("message.Appointment Book list");
                $response['data'] = $data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function doctoruappointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];

        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {

            $data = BookAppointment::where("date", ">=", date('Y-m-d'))->where("doctor_id", $request->get("doctor_id"))->where("is_completed", 1)->orderby('id', 'DESC')->select("date", "id", "slot_name as slot", "user_id", "phone", "status")->paginate(10);
            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            } else {

                foreach ($data as $d) {
                    $user = Patient::find($d->user_id);
                    if ($user) {
                        $d->name = $user->name;
                        $d->image = isset($user->profile_pic) ? asset('public/upload/profile') . '/' . $user->profile_pic : "";
                    } else {
                        $d->name = "";
                        $d->image = "";
                    }
                    if ($d->status == '1') {
                        $d->status = __("message.Received");
                    } else if ($d->status == '2') {
                        $d->status = __("message.Approved");
                    } else if ($d->status == '3') {
                        $d->status = __("message.In Process");
                    } else if ($d->status == '4') {
                        $d->status = __("message.Completed");
                    } else if ($d->status == '5') {
                        $d->status = __("message.Rejected");
                    } else {
                        $d->status = __("message.Absent");
                    }
                    unset($d->user_id);
                }
                $response['success'] = "1";
                $response['register'] = __("message.Appointment Book list");
                $response['data'] = $data;
            }
        }
        return json_encode($response);
    }

    public function doctordetail(Request $request)
    {

        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'type' => 'required'
        ];
        if ($request->type == '1') {
            $rules = [
                'doctor_id' => 'required'
            ];
        } else if ($request->type == '2') {
            $rules = [
                'pharmacy_id' => 'required'
            ];
        }
        $messages = array(
            'type.required' => "type is required",
            'pharmacy_id.required' => "pharmacy_id is required",
            'doctor_id.required' => "doctor_id is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if ($request->type == '1') {
                $data = Doctors::where('id', $request->get("doctor_id"))->where('profile_type', '1')->orderBy('id', 'desc')->first();
                // echo "<pre>";
                // print_r($data);
                // die();
                if (empty($data)) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Doctor_Not_Found");
                } else {
                    $d = Services::find($data->department_id);
                    $data->department_name = isset($d) ? $d->name : "";
                    unset($data->department_id);
                    if (isset($data->image) && !empty($data->image)) {
                        $data->image = $data->image;
                    } else {
                        $data->image = 'user.png';
                    }
                    $data->avgratting = round(Review::where("doc_id", $request->get("doctor_id"))->avg('rating'));

                    $mysubscriptionlist = Subscriber::where('doctor_id', $request->get("doctor_id"))->where("status", '2')->orderby('id', 'DESC')->first();

                    if (isset($mysubscriptionlist)) {
                        $mysubscriptionlist->subscription_data = Subscription::find($mysubscriptionlist->subscription_id);


                        $datetime = new DateTime($mysubscriptionlist->date);
                        if (isset($mysubscriptionlist->subscription_data)) {
                            $month = $mysubscriptionlist->subscription_data->month;
                            $datetime->modify('+' . $month . ' month');
                            $date = $datetime->format('Y-m-d H:i:s');
                            //echo $d=strtotime($date);
                            $current_date = $this->getsitedateall();
                            if ($mysubscriptionlist->is_complet == 1) {
                                $data->is_subscription = "1";
                            } else {
                                $data->is_subscription = "0";
                            }
                            //die
                            if (strtotime($current_date) < strtotime($date)) {

                                if ($mysubscriptionlist->status == 2) {
                                    $data->is_approve = 1;
                                } else {
                                    $data->is_approve = 0;
                                }
                            } else {
                                $data->is_subscription = "0";
                                $data->is_approve = 0;
                            }
                        } else {

                            $data->is_subscription = "0";
                            $data->is_approve = 0;
                        }
                    } else {
                        $data->is_subscription = "0";
                        $data->is_approve = 0;
                    }

                    $response['success'] = "1";
                    $response['register'] =  __("message.Doctor_Get_Success");
                    $response['data'] = $data;
                }
            } else if ($request->type == '2') {

                $data = Doctors::where('id', $request->get("pharmacy_id"))->where('profile_type', '2')->orderBy('id', 'desc')->first();
                // echo "<pre>";
                // print_r($data);
                // die();
                if (empty($data)) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Doctor_Not_Found");
                } else {
                    unset($data->department_id);
                    if (isset($data->image) && !empty($data->image)) {
                        $data->image = $data->image;
                    } else {
                        $data->image = 'user.png';
                    }
                    $data->avgratting = round(Review::where("doc_id", $request->get("pharmacy_id"))->avg('rating'));
                    $response['success'] = "1";
                    $response['register'] =  __("message.Doctor_Get_Success");
                    $response['data'] = $data;
                }
            }
        }
        // return json_encode($response, JSON_NUMERIC_CHECK);
        return json_encode($response);
    }

    // public function place_subscription(Request $request){
    //     $response = array("success" => "0", "msg" => "Validation error");
    //     $rules = [
    //         'doctor_id' => 'required',
    //         'subscription_id' => 'required',
    //         'payment_method_nonce' => 'required',
    //         'amount' => 'required'
    //     ];

    //     $messages = array(
    //         'doctor_id.required' => "doctor_id is required",
    //         'subscription_id.required' => "subscription_id is required",
    //         'payment_method_nonce.required' => "payment_method_nonce is required",
    //         'amount.required' => "amount is required"
    //     );
    //     $validator = Validator::make($request->all(), $rules, $messages);
    //     if ($validator->fails()) {
    //         $message = '';
    //         $messages_l = json_decode(json_encode($validator->messages()), true);
    //         foreach ($messages_l as $msg) {
    //             $message .= $msg[0] . ", ";
    //         }
    //         $response['register'] = $message;
    //     } else {
    //         $gateway = new \Braintree\Gateway([
    //             'environment' => env('BRAINTREE_ENV'),
    //             'merchantId' => env('BRAINTREE_MERCHANT_ID'),
    //             'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
    //             'privateKey' => env('BRAINTREE_PRIVATE_KEY')
    //         ]);
    //         $nonce = $request->get("payment_method_nonce");
    //         $result = $gateway->transaction()->sale([
    //             'amount' => $request->get("amount"),
    //             'paymentMethodNonce' => $nonce,
    //             'options' => [
    //                 'submitForSettlement' => true
    //             ]
    //         ]);
    //         if ($result->success) {
    //             $transaction = $result->transaction;
    //             DB::beginTransaction();
    //             try {

    //                 $data = new Subscriber();
    //                 $data->doctor_id = $request->get("doctor_id");
    //                 $data->payment_type = '1';
    //                 $data->amount = $request->get("amount");
    //                 $data->date = $this->getsitedateall();
    //                 $data->subscription_id = $request->get("subscription_id");

    //                 $data->status = "2";
    //                 $data->transaction_id = $transaction->id;
    //                 $data->save();

    //                 DB::commit();
    //                 $response['success'] = "1";
    //                 $response['register'] = "Subscription Book Successfully";

    //             } catch (\Exception $e) {
    //                 DB::rollback();
    //                 $response['success'] = "0";
    //                 $response['register'] = $e;
    //             }
    //         } else {
    //             $errorString = "";
    //             foreach ($result->errors->deepAll() as $error) {
    //                 $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    //             }
    //             $response['success'] = "0";
    //             $response['register'] = $errorString;
    //         }
    //     }
    //     return json_encode($response, JSON_NUMERIC_CHECK);
    // }

    public function subscription_upload(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'subscription_id' => 'required',
            'payment_type' => 'required',
            'amount' => 'required',
            // 'description'=>'required'
        ];

        if ($request->payment_type == '5') {
            $rules['stripe_token'] = 'required';
        }

        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'subscription_id.required' => "subscription_id is required",
            'payment_type.required' => "payment_type is required",
            'amount.required' => "amount is required",
            'stripe_token.required' => "stripe_token is required",
            // 'description.required' => "description is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = new Subscriber();
            $data->doctor_id = $request->get("doctor_id");
            $data->subscription_id = $request->get("subscription_id");
            $data->payment_type = $request->get("payment_type");
            $data->amount = $request->get("amount");
            $data->date = $this->getsitedateall();
            if ($request->get("description")) {
                $data->description = $request->get("description");
            }
            if ($request->payment_type == '5') {
                $data->transaction_id = $request->get("stripe_token");
                $data->status = "2";
            }

            // $data->status = "1";
            $data->is_complet = '1';
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'png';
                $folderName = '/upload/bank_receipt/';
                $picture = time() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $request->file('file')->move($destinationPath, $picture);
                $data->deposit_image = $picture;
                $data->status = "2";
            } else {
                if ($request->payment_type != '5') {
                    $data->status = "1";
                }
            }

            $data->save();
            if ($request->get("payment_type") == 2) {
                $url = "";
            } else {
                $url = route('make-payment', ['id' => $data->id, "type" => '2']);
            }
            if ($data) {
                $response['success'] = "1";
                $response['msg'] =  __("message.Your subscription plan add successfully");
                $response['url'] = $url;
                $response['id'] = $data->id;
            } else {
                $response['success'] = "0";
                $response['msg'] = __("message.something getting wrong");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function appointmentdetail(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'id' => 'required',
            'type' => 'required'
        ];

        $messages = array(
            'id.required' => "id is required",
            'type.required' => "type is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = BookAppointment::with('doctorls', 'patientls')->find($request->get("id"));

            $doctor = Doctors::with('departmentls')->find($data->doctor_id);
            $doctor->avgratting = round(Review::where("doc_id", $doctor->id)->avg('rating'));
            // return $doctor;
            $image = ap_img_uplod::where('appointment_id', $request->get("id"))->get();
            $p = AppointmentMedicines::where('appointment_id', $request->get("id"))->first();
            if ($p) {
                $prescription = AppointmentMedicines::where('appointment_id', $request->get("id"))->get();
                foreach ($prescription as $p) {
                    $med = $p->medicines;
                    $med_data = json_decode($med);
                    $response['prescription'] = $med_data;
                }
            } else {
                $response['prescription'] = "null";
            }
            $ls = array();
            if ($data) {
                if ($request->get("type") == 1) { //patients
                    $ls['doctor_image'] = isset($data->doctorls->image) ? asset("public/upload/doctors") . '/' . $data->doctorls->image : "";
                    $ls['doctor_name'] = isset($data->doctorls) ? $data->doctorls->name : "";
                    $ls['user_image'] = isset($data->patientls->profile_pic) ? asset("public/upload/profile") . '/' . $data->patientls->profile_pic : "";
                    $ls['user_name'] = isset($data->patientls) ? $data->patientls->name : "";
                    $ls['status'] = $data->status;
                    $ls['doctor_id'] = $data->doctor_id;
                    $ls['user_id'] = $data->user_id;
                    $ls['date'] = $data->date;
                    $ls['slot'] = $data->slot_name;
                    $ls['phone'] = isset($data->doctorls) ? $data->doctorls->phoneno : "";;
                    $ls['email'] = isset($data->doctorls) ? $data->doctorls->email : "";;
                    $ls['description'] = $data->user_description;
                    $ls['connectycube_user_id'] = $data->doctorls->connectycube_user_id;
                    $ls['id'] = $data->id;
                    if ($data->prescription_file != "") {
                        $ls['prescription'] = asset('public/upload/prescription') . '/' . $data->prescription_file;
                    } else {
                        $ls['prescription'] = "";
                    }
                    $ls['device_token'] = TokenData::select('token', 'type')->where("doctor_id", $data->doctor_id)->distinct('token')->get();
                    $date12 = date('Y-m-d H:i:s', strtotime($data->date . ' ' . $data->slot_name));
                    $date22 = $this->getsitedatetime();
                    $date1 = date_create($date12);
                    $date2 = date_create($date22);

                    if ($data->date != $this->getsitedate()) {
                        $ls['remain_time'] = "00:00:00";
                    } else {

                        if (strtotime($date12) < strtotime($date22)) {
                            $ls['remain_time'] = "00:00:00";
                        } else {
                            $diff = $date1->diff($date2);
                            $ls['remain_time'] = $diff->format("%H:%I:%S");
                        }
                    }
                    $sdchule_id = SlotTiming::find($data->slot_id) ? SlotTiming::find($data->slot_id)->schedule_id : '0';
                    $ls['is_appointment_time'] = 0;

                    if ($sdchule_id != 0) {
                        //echo $this->getsitedate();exit;
                        if ($data->date == $this->getsitedate()) {
                            $duration = Schedule::find($sdchule_id) ? Schedule::find($sdchule_id)->duration : 0;
                            $current_time = $this->getsitecurrenttime();
                            $sunrise = SlotTiming::find($data->slot_id) ? date("H:i", strtotime(SlotTiming::find($data->slot_id)->slot)) : 0;
                            $sunset = date("H:i", strtotime("+15 minutes", strtotime($sunrise)));
                            // echo $current_time." sunrise ".$sunrise." sunset".$sunset.' '.$sdchule_id;exit;
                            if (strtotime($current_time) >= strtotime($sunrise) && strtotime($current_time) <= strtotime($sunset)) {
                                $ls['is_appointment_time']  = 1;
                            }
                        }
                    }
                } else { //doctor
                    $ls['user_image'] = isset($data->patientls->profile_pic) ? asset("public/upload/profile") . '/' . $data->patientls->profile_pic : "";
                    $ls['user_name'] = isset($data->patientls) ? $data->patientls->name : "";
                    $ls['doctor_name'] = isset($data->doctorls) ? $data->doctorls->name : "";
                    $ls['doctor_image'] = isset($data->doctorls->image) ? asset("public/upload/doctors") . '/' . $data->doctorls->image : "";

                    $ls['status'] = $data->status;
                    $ls['date'] = $data->date;
                    $ls['doctor_id'] = $data->doctor_id;
                    $ls['user_id'] = $data->user_id;
                    $ls['slot'] = $data->slot_name;
                    $ls['phone'] = $data->phone;
                    $ls['email'] = isset($data->patientls) ? $data->patientls->email : "";
                    $ls['connectycube_user_id'] = $data->patientls->connectycube_user_id;
                    $ls['description'] = $data->user_description;
                    $ls['id'] = $data->id;
                    if ($data->prescription_file != "") {
                        $ls['prescription'] = asset('public/upload/prescription') . '/' . $data->prescription_file;
                    } else {
                        $ls['prescription'] = "";
                    }
                    $ls['device_token'] = TokenData::select('token', 'type')->where("user_id", $data->user_id)->distinct('token')->get();
                    $date12 = date('Y-m-d H:i:s', strtotime($data->date . ' ' . $data->slot_name));
                    $date22 = $this->getsitedatetime();
                    $date1 = date_create($date12);
                    $date2 = date_create($date22);
                    // echo $date12."=>".$date22;exit;
                    if ($data->date != $this->getsitedate()) {
                        $ls['remain_time'] = "00:00:00";
                    } else {

                        if (strtotime($date12) < strtotime($date22)) {
                            $ls['remain_time'] = "00:00:00";
                        } else {
                            $diff = $date1->diff($date2);
                            $ls['remain_time'] = $diff->format("%H:%I:%S");
                        }
                    }
                    $sdchule_id = SlotTiming::find($data->slot) ? SlotTiming::find($data->slot)->schedule_id : '0';
                    $ls['is_appointment_time'] = 0;

                    if ($sdchule_id != 0) {
                        //echo $this->getsitedate();exit;
                        if ($data->date == $this->getsitedate()) {
                            $duration = Schedule::find($sdchule_id) ? Schedule::find($sdchule_id)->duration : 0;
                            $current_time = $this->getsitecurrenttime();
                            $sunrise = SlotTiming::find($data->slot_id) ? date("H:i", strtotime(SlotTiming::find($data->slot_id)->slot)) : 0;
                            $sunset = date("H:i", strtotime("+15 minutes", strtotime($sunrise)));
                            // echo $current_time." sunrise ".$sunrise." sunset".$sunset.' '.$sdchule_id;exit;
                            if (strtotime($current_time) >= strtotime($sunrise) && strtotime($current_time) <= strtotime($sunset)) {
                                $ls['is_appointment_time']  = 1;
                            }
                        }
                    }
                }
                $response['success'] = "1";
                $response['register'] = __("message.appointment Details");
                $response['data'] = $ls;
                $response['image'] = $image;
                $response['doctor'] = $doctor;
            } else {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function doctoreditprofile(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            "type" => 'required',
        ];

        if ($request->type == '1') {
            $rules = [
                "doctor_id" => 'required',
                "name" => 'required',
                "email" => "required",
                "aboutus" => "required",
                "working_time" => "required",
                "address" => "required",
                "lat" => "required",
                "lon" => "required",
                "phoneno" => "required",
                "services" => "required",
                "healthcare" => "required",
                "department_id" => "required",
                "consultation_fees" => "required",
                //"time_json"=>"required",

            ];
        } else if ($request->type == '2') {
            $rules = [
                "pharmacy_id" => 'required',
                "name" => 'required',
                "email" => "required",
                "aboutus" => "required",
                "working_time" => "required",
                "address" => "required",
                "lat" => "required",
                "lon" => "required",
                "phoneno" => "required",
                "services" => "required",
            ];
        }

        $messages = array(
            'pharmacy_id.required' => "pharmacy_id is required",
            'doctor_id.required' => "doctor_id is required",
            'name.required' => "name is required",
            'email.required' => "email is required",
            'aboutus.required' => "aboutus is required",
            'working_time.required' => "working_time is required",
            'address.required' => "address is required",
            'lat.required' => "lat is required",
            'lon.required' => "lon is required",
            'phoneno.required' => "phoneno is required",
            'services.required' => "services is required",
            'healthcare.required' => "healthcare is required",
            'department_id.required' => "department_id is required",
            'consultation_fees.required' => "consultation_fees is required",
            //'time_json.required' => "time_json is required"

        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {

            if ($request->type == '1') {
                $store = Doctors::where('profile_type', '1')->where('id', $request->get("doctor_id"))->first();
                if ($store) {
                    DB::beginTransaction();
                    try {
                        $img_url = $store->image;
                        $rel_url = $store->image;
                        if ($request->file('image')) {

                            $file = $request->file('image');
                            $filename = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension() ?: 'png';
                            $folderName = '/upload/doctors/';
                            $picture = time() . '.' . $extension;
                            $destinationPath = public_path() . $folderName;
                            $request->file('image')->move($destinationPath, $picture);
                            $img_url = $picture;
                            $image_path = public_path() . "/upload/doctors/" . $rel_url;
                            if (file_exists($image_path) && $rel_url != "") {
                                try {
                                    unlink($image_path);
                                } catch (Exception $e) {
                                }
                            }
                        }
                        $store->name = $request->get("name");
                        $store->department_id = $request->get("department_id");
                        // $store->password = $request->get("password");
                        $store->phoneno = $request->get("phoneno");
                        $store->aboutus = $request->get("aboutus");
                        $store->services = $request->get("services");
                        $store->healthcare = $request->get("healthcare");
                        $store->address = $request->get("address");
                        $store->lat = $request->get("lat");
                        $store->lon = $request->get("lon");
                        $store->email = $request->get("email");
                        $store->working_time = $request->get("working_time");
                        $store->consultation_fees = $request->get("consultation_fees");
                        $store->image = $img_url;
                        $store->save();
                        if ($request->get("time_json") != "") {
                            $datadesc = json_decode($request->get("time_json"), true);
                            $arr = $datadesc['timing'];
                            $i = 0;
                            $removedata = Schedule::where("doctor_id", $request->get("doctor_id"))->get();
                            if (count($removedata) > 0) {
                                foreach ($removedata as $k) {
                                    $findslot = SlotTiming::where("schedule_id", $k->id)->delete();
                                    $k->delete();
                                }
                            }
                            foreach ($arr as $k) {
                                foreach ($k as $l) {
                                    $getslot = $this->getslotvalue($l['start_time'], $l['end_time'], $l['duration']);
                                    $store = new Schedule();
                                    $store->doctor_id = $request->get("doctor_id");
                                    $store->day_id = $i;
                                    $store->start_time = $l['start_time'];
                                    $store->end_time = $l['end_time'];
                                    $store->duration = $l['duration'];
                                    $store->save();
                                    foreach ($getslot as $g) {
                                        $aslot = new SlotTiming();
                                        $aslot->schedule_id = $store->id;
                                        $aslot->slot = $g;
                                        $aslot->save();
                                    }
                                }
                                $i++;
                            }
                        }
                        DB::commit();
                        $response['success'] = "1";
                        $response['register'] = __("message.Profile Update Successfully");
                    } catch (Exception $e) {
                        DB::rollback();
                        $response['success'] = "0";
                        $response['register'] = __("message.something getting wrong");
                    }
                } else {
                    $response['success'] = "0";
                    $response['register'] = __("message.Doctor_Not_Found");
                }
            } else if ($request->type == '2') {
                $store = Doctors::where('profile_type', '2')->where('id', $request->get("pharmacy_id"))->first();
                if ($store) {
                    DB::beginTransaction();
                    try {
                        $img_url = $store->image;
                        $rel_url = $store->image;
                        if ($request->file('image')) {

                            $file = $request->file('image');
                            $filename = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension() ?: 'png';
                            $folderName = '/upload/doctors/';
                            $picture = time() . '.' . $extension;
                            $destinationPath = public_path() . $folderName;
                            $request->file('image')->move($destinationPath, $picture);
                            $img_url = $picture;
                            $image_path = public_path() . "/upload/doctors/" . $rel_url;
                            if (file_exists($image_path) && $rel_url != "") {
                                try {
                                    unlink($image_path);
                                } catch (Exception $e) {
                                }
                            }
                        }
                        $store->name = $request->get("name");
                        $store->phoneno = $request->get("phoneno");
                        $store->aboutus = $request->get("aboutus");
                        $store->services = $request->get("services");
                        $store->address = $request->get("address");
                        $store->lat = $request->get("lat");
                        $store->lon = $request->get("lon");
                        $store->email = $request->get("email");
                        $store->working_time = $request->get("working_time");
                        $store->image = $img_url;
                        $store->save();
                        DB::commit();
                        $response['success'] = "1";
                        $response['register'] = __("message.Profile Update Successfully");
                    } catch (Exception $e) {
                        DB::rollback();
                        $response['success'] = "0";
                        $response['register'] = __("message.something getting wrong");
                    }
                } else {
                    $response['success'] = "0";
                    $response['register'] = __("message.Pharmacy_Not_Found");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function getslotvalue($start_time, $end_time, $duration)
    {
        $datetime1 = strtotime($start_time);
        $datetime2 = strtotime($end_time);
        $interval  = abs($datetime2 - $datetime1);
        $minutes   = round($interval / 60);
        $noofslot = $minutes / $duration;
        $slot = array();
        if ($noofslot > 0) {
            for ($i = 0; $i < $noofslot; $i++) {
                $a = $duration * $i;
                $slot[] = date("h:i A", strtotime("+" . $a . " minutes", strtotime($start_time)));
            }
        }
        return $slot;
    }

    public function getdoctorschedule(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];

        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = Doctors::find($request->get("doctor_id"));

            if (empty($data)) {
                $response['success'] = "0";
                $response['register'] = __("message.User not found");
            } else {
                $data = Schedule::with('getslotls')->where("doctor_id", $request->get("doctor_id"))->get();
                $response['success'] = "1";
                $response['register'] = __("message.Doctor_Get_Success");
                $response['data'] = $data;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function usereditprofile(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ];

        $messages = array(
            'id.required' => "id is required",
            'name.required' => "name is required",
            'email.required' => "email is required",
            'phone.required' => "phone is required",
            'password.required' => "password is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data1 = Patient::find($request->get("id"));

            if (empty($data1)) {
                $response['success'] = "0";
                $response['register'] = __("message.User not found");
            } else {

                $checkemail = Patient::where("email", $request->get("email"))->where("id", '!=', $request->get("id"))->first();
                if ($checkemail) {
                    $response['success'] = "0";
                    $response['register'] = __("message.Email Id Already Use By Other User");
                } else {
                    $img_url = $data1->profile_pic;
                    $rel_url = $data1->profile_pic;
                    if ($request->file('image')) {

                        $file = $request->file('image');
                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension() ?: 'png';
                        $folderName = '/upload/profile/';
                        $picture = time() . '.' . $extension;
                        $destinationPath = public_path() . $folderName;
                        $request->file('image')->move($destinationPath, $picture);
                        $img_url = $picture;
                        $image_path = public_path() . "/upload/profile/" . $rel_url;
                        if (file_exists($image_path) && $rel_url != "") {
                            try {
                                unlink($image_path);
                            } catch (Exception $e) {
                            }
                        }
                    }
                    $data1->name = $request->get("name");
                    $data1->email = $request->get("email");
                    $data1->password = $request->get("password");
                    $data1->phone = $request->get("phone");
                    $data1->profile_pic = $img_url;
                    $data1->save();
                    $response['success'] = "1";
                    $response['register'] = __("message.Profile Update Successfully");
                    $response['data'] = $data1;
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function saveReportspam(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'title.required' => "title is required",
            'description.required' => "description is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {

            $store = new Reportspam();
            $store->user_id = $request->get("user_id");
            $store->title = $request->get("title");
            $store->description = $request->get("description");
            $store->save();
            $response['success'] = "1";
            $response['register'] = __("message.Report_Send_Success");
            $response['data'] = $store;
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function user_reject_appointment(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'user_id' => 'required',
            'id' => 'required'
        ];

        $messages = array(
            'user_id.required' => "user_id is required",
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {

            $data = BookAppointment::where("id", $request->get("id"))->where("user_id", $request->get("user_id"))->first();
            if ($data) {
                $data->status = 5;
                $data->save();
                $response['success'] = "1";
                $response['register'] = __("message.Appointment In Reject");
            } else {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function appointmentstatuschange(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'app_id' => 'required',
            'status' => 'required'
        ];
        // if($request->input('status')==4){
        //     $rules['prescription'] = 'required';
        // }

        $messages = array(
            'app_id.required' => "app_id is required",
            'status.required' => "status is required",
            //   "prescription"=>"prescription is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {

            $getapp = BookAppointment::with('doctorls', 'patientls')->find($request->get("app_id"));
            if ($getapp) {
                $getapp->status = $request->get("status");
                if ($request->hasFile('prescription')) {
                    $file = $request->file('prescription');
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension() ?: 'png';
                    $folderName = '/upload/prescription/';
                    $picture = time() . '.' . $extension;
                    $destinationPath = public_path() . $folderName;
                    $request->file('prescription')->move($destinationPath, $picture);
                    $getapp->prescription_file = $picture;
                }
                $getapp->save();
                if ($request->get("status") == '3') { // in process
                    $msg = __("message.Your Appointment  has been accept by") . " " . $getapp->doctorls->name . " " . __("message.for time") . "" . $getapp->date . ' ' . $getapp->slot_name;
                } else if ($request->get("status") == '5') { //reject
                    $msg = __("message.Your Appointment  has been reject By") . " " . $getapp->doctorls->name;
                    Settlement::where("book_id", $request->get("app_id"))->delete();
                } else if ($request->get("status") == '4') { //complete
                    $msg = __("message.Your Appointment  with") . " " . $getapp->doctorls->name . " is completed";
                } else if ($request->get("status") == '0') { //absent
                    $msg = __("message.You were absent on your appointment with") . " " . $getapp->doctorls->name;
                } else if ($request->get("status") == '6') { //absent
                    $msg = __("message.Your appointment cancel with") . " " . $getapp->doctorls->name;
                } else {
                    $msg = "";
                }
                $user = User::find(1);

                // $android = $this->send_notification_android($user->android_key, $msg, $getapp->user_id, "user_id", $getapp->id);
                // $ios = $this->send_notification_IOS($user->ios_key, $msg, $getapp->user_id, "user_id", $getapp->id);

                $android = $this->sendNotifications($msg, $getapp->user_id, "user_id", $getapp->id);

                $response['success'] = "1";
                $response['msg'] = $msg;
                try {
                    if ($getapp->prescription_file != "") {
                        $user = Patient::find($getapp->user_id);
                        $user->msg = $msg;
                        $user->prescription = $getapp->prescription_file;
                        $user->email = "redixbit.jalpa@gmail.com";
                        $result = Mail::send('email.Ordermsg', ['user' => $user], function ($message) use ($user) {
                            $message->to($user->email, $user->name)->subject(__('message.System Name'));
                            $message->attach(asset('public/upload/prescription') . '/' . $user->prescription);
                        });
                    } else {
                        $user = Patient::find($getapp->user_id);
                        $user->msg = $msg;
                        //$user->email="redixbit.jalpa@gmail.com";
                        $result = Mail::send('email.Ordermsg', ['user' => $user], function ($message) use ($user) {
                            $message->to($user->email, $user->name)->subject(__('message.System Name'));
                        });
                    }
                } catch (\Exception $e) {
                }
            } else {
                $response['success'] = "0";
                $response['msg'] = __("message.Appointment Not Found");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
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

    public function sendNotifications($msg, $id, $field, $order_id)
    {
        $accessToken = $this->generateAccessToken();

        $getusers = TokenData::where("type", 1)->where($field, $id)->get();
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
                        'title' =>  __('message.notification'),
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

    // public function send_notification_android($key, $msg, $id, $field, $order_id)
    // {
    //     $getuser = TokenData::where("type", 1)->where($field, $id)->get();

    //     $i = 0;
    //     if (count($getuser) != 0) {

    //         $reg_id = array();
    //         foreach ($getuser as $gt) {
    //             $reg_id[] = $gt->token;
    //         }
    //         $regIdChunk = array_chunk($reg_id, 1000);
    //         foreach ($regIdChunk as $k) {
    //             $registrationIds =  $k;
    //             $message = array(
    //                 'message' => $msg,
    //                 'title' =>  __('message.notification')
    //             );
    //             $message1 = array(
    //                 'body' => $msg,
    //                 'title' =>  __('message.notification'),
    //                 'type' => $field,
    //                 'order_id' => $order_id,
    //                 'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
    //             );
    //             //echo "<pre>";print_r($message1);exit;
    //             $fields = array(
    //                 'registration_ids'  => $registrationIds,
    //                 'data'              => $message1,
    //                 'notification'      => $message1
    //             );

    //             // echo "<pre>";print_r($fields);exit;
    //             $url = 'https://fcm.googleapis.com/fcm/send';
    //             $headers = array(
    //                 'Authorization: key=' . $key, // . $api_key,
    //                 'Content-Type: application/json'
    //             );
    //             $json =  json_encode($fields);
    //             $ch = curl_init();
    //             curl_setopt($ch, CURLOPT_URL, $url);
    //             curl_setopt($ch, CURLOPT_POST, true);
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //             $result = curl_exec($ch);
    //             //echo "<pre>";print_r($result);exit;
    //             if ($result === FALSE) {
    //                 die('Curl failed: ' . curl_error($ch));
    //             }
    //             curl_close($ch);
    //             $response[] = json_decode($result, true);
    //         }
    //         $succ = 0;
    //         foreach ($response as $k) {
    //             $succ = $succ + $k['success'];
    //         }
    //         if ($succ > 0) {
    //             return 1;
    //         } else {
    //             return 0;
    //         }
    //     }
    //     return 0;
    // }

    // public function send_notification_IOS($key, $msg, $id, $field, $order_id)
    // {
    //     $getuser = TokenData::where("type", 2)->where($field, $id)->get();
    //     if (count($getuser) != 0) {
    //         $reg_id = array();
    //         foreach ($getuser as $gt) {
    //             $reg_id[] = $gt->token;
    //         }

    //         $regIdChunk = array_chunk($reg_id, 1000);
    //         foreach ($regIdChunk as $k) {
    //             $registrationIds =  $k;
    //             $message = array(
    //                 'message' => $msg,
    //                 'title' =>  __('message.notification')
    //             );
    //             $message1 = array(
    //                 'body' => $msg,
    //                 'title' =>  __('message.notification'),
    //                 'type' => $field,
    //                 'order_id' => $order_id,
    //                 'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
    //             );
    //             $fields = array(
    //                 'registration_ids'  => $registrationIds,
    //                 'data'              => $message1,
    //                 'notification' => $message1
    //             );
    //             $url = 'https://fcm.googleapis.com/fcm/send';
    //             $headers = array(
    //                 'Authorization: key=' . $key, // . $api_key,
    //                 'Content-Type: application/json'
    //             );
    //             $json =  json_encode($fields);
    //             $ch = curl_init();
    //             curl_setopt($ch, CURLOPT_URL, $url);
    //             curl_setopt($ch, CURLOPT_POST, true);
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //             $result = curl_exec($ch);
    //             if ($result === FALSE) {
    //                 die('Curl failed: ' . curl_error($ch));
    //             }
    //             curl_close($ch);
    //             $response[] = json_decode($result, true);
    //         }
    //         $succ = 0;
    //         foreach ($response as $k) {
    //             $succ = $succ + $k['success'];
    //         }
    //         if ($succ > 0) {
    //             return 1;
    //         } else {
    //             return 0;
    //         }
    //     }
    //     return 0;
    // }

    public function forgotpassword(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'type' => 'required',
            'email' => 'required'
        ];

        $messages = array(
            'type.required' => "type is required",
            'email.required' => "email is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if ($request->get("type") == 1) { //patient
                $checkmobile = Patient::where("email", $request->get("email"))->first();
            } else { // doctor
                $checkmobile = Doctors::where("email", $request->get("email"))->first();
            }
            if ($checkmobile) {
                $code = mt_rand(100000, 999999);
                $store = array();
                $store['email'] = $checkmobile->email;
                $store['name'] = $checkmobile->name;
                $store['code'] = $code;
                $add = new ResetPassword();
                $add->user_id = $checkmobile->id;
                $add->code = $code;
                $add->type = $request->get("type");
                $add->save();

                Mail::send('email.forgotpassword', ['user' => $store], function ($message) use ($store) {
                    $message->to($store['email'], $store['name'])->subject(__("message.System Name"));
                });

                //   exit();
                try {
                    $result =  Mail::send('email.reset_password', ['user' => $store], function ($message) use ($store) {
                        $message->to($store['email'], $store['name'])->subject(__("message.System Name"));
                    });
                } catch (\Exception $e) {
                }

                $response['success'] = "1";
                $response['msg'] = __("message.Mail Send Successfully");
            } else {
                $response['success'] = "0";
                $response['msg'] = __("message.error mail sending");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function getholiday(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'doctor_id' => 'required'
        ];

        $messages = array(
            'doctor_id.required' => "doctor_id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $data = Doctor_Hoilday::where("doctor_id", $request->get("doctor_id"))->orderby('id', 'DESC')->get();
            if (count($data) > 0) {
                $response['success'] = "1";
                $response['msg'] =  __("message.My Hoilday List");
                $response['data'] = $data;
            } else {
                $response['success'] = "0";
                $response['msg'] =  __("message.No Hoilday Data");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function saveholiday(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required'

        ];

        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'id.required' => "id is required",
            'start_date.required' => "start_date is required",
            'end_date.required' => "end_date is required",
            'description.required' => "description is required",
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            if ($request->get('id') == 0) {
                $store = new Doctor_Hoilday();
                $store->doctor_id = $request->get("doctor_id");
                $store->start_date = $request->get("start_date");
                $store->end_date = $request->get("end_date");
                $store->description = $request->get("description");
                $store->save();
                $response['success'] = "1";
                $response['msg'] = __("message.My Hoilday Add Successfully");
                $response['data'] = $store;
            } else {
                $store = Doctor_Hoilday::find($request->get('id'));
                if ($store) {
                    $store->doctor_id = $request->get("doctor_id");
                    $store->start_date = $request->get("start_date");
                    $store->end_date = $request->get("end_date");
                    $store->description = $request->get("description");
                    $store->save();
                    $response['success'] = "1";
                    $response['msg'] = __("message.My Hoilday Add Successfully");
                    $response['data'] = $store;
                } else {
                    $response['success'] = "0";
                    $response['msg'] = __("message.No Hoilday Data");
                }
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function deleteholiday(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'id' => 'required'
        ];

        $messages = array(
            'id.required' => "id is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $date = $request->get("date");
            $data = Doctor_Hoilday::find($request->get("id"));
            if (!empty($data)) {
                $data->delete();
                $response['success'] = "1";
                $response['msg'] =  __("message.Hoilday Delete Successfully");
            } else {
                $response['success'] = "0";
                $response['msg'] = __("message.No Hoilday Data");
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function checkholiday(Request $request)
    {
        $response = array("success" => "0", "msg" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'date' => 'required'
        ];

        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'date.required' => "date is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $date = $request->get("date");
            $data = Doctor_Hoilday::where("start_date", "<=", $date)->where("end_date", ">=", $date)->where("doctor_id", $request->get("doctor_id"))->first();
            // echo "<pre>";print_r($data);exit;
            if (empty($data)) {

                $day = date('N', strtotime($request->get("date"))) - 1;
                $data = Schedule::with('getslotls')->where("doctor_id", $request->get("doctor_id"))->where("day_id", $day)->get();
                $main = array();
                if (count($data) > 0) {
                    foreach ($data as $k) {
                        $slotlist = array();
                        $slotlist['title'] = $k->start_time . " - " . $k->end_time;
                        if (count($k->getslotls) > 0) {
                            foreach ($k->getslotls as $b) {
                                $ka = array();
                                $getappointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->whereNotNull('transaction_id')->where('is_completed', '1')->where('status', "!=", 6)->first();
                                $getcodappointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->where('payment_mode', "COD")->where('is_completed', '1')->where('status', "!=", 6)->first();
                                $cancel_appointment = BookAppointment::where("date", $request->get("date"))->where("slot_id", $b->id)->where('status', 6)->where('is_completed', '1')->first();

                                $ka['id'] = $b->id;
                                $ka['name'] = $b->slot;

                                if ($getappointment || $getcodappointment) {
                                    $ka['is_book'] = '1';
                                } elseif ($cancel_appointment) {
                                    $ka['is_book'] = '0';
                                } else {
                                    $ka['is_book'] = '0';
                                }
                                $slotlist['slottime'][] = $ka;
                            }
                        }
                        $main[] = $slotlist;
                    }
                }


                $response['success'] = "1";
                $response['msg'] = "Working Day";
                $response['data'] = $main;
            } else {
                $response['success'] = "0";
                $response['msg'] = "Hoilday";
                $response['data'] = [];
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function mediaupload(Request $request)
    {
        // dd($request->all());
        $response = array("status" => 0, "msg" => "Validation error");
        $rules = [
            'file' => 'required'
        ];
        $messages = array(
            'file.required' => "file is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['msg'] = $message;
        } else {

            $img_url = "";
            $type = "";
            // echo "<pre>";print_r($_FILES);exit;
            if ($request->file("file")) {

                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension() ?: 'mp4';
                $folderName = '/upload/chat';
                $picture = time() . '.' . $extension;
                $destinationPath = public_path() . $folderName;
                $request->file('file')->move($destinationPath, $picture);
                $img_url = $picture;

                $response = array("status" => 1, "msg" =>  __("message.Media_Upload_Success"), "data" => $img_url);
                return Response::json($response);
            } else {
                $response = array("status" => 0, "msg" => "Media Not Upload", "data" => array());
                return Response::json($response);
            }
        }
        return Response::json($response);
    }

    public function banner_list(Request $request)
    {
        $data = Banner::select('id', 'image')->orderby('id', 'DESC')->get();
        if (count($data) > 0) {
            $response['status'] = 1;
            $response['msg'] = "Banner List";
            $response['data'] = $data;
        } else {
            $data3 = array();
            $response['status'] = 0;
            $response['message'] = "Data Not Found";
            $response['data'] = $data3;
        }
        return Response::json($response);
    }

    public function income_report(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'doctor_id' => 'required',
            'duration' => 'required'
        ];

        $messages = array(
            'doctor_id.required' => "doctor_id is required",
            'duration.required' => "duration is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $date = Carbon::now();

            if ($request->get("duration") == "today") {

                $data = BookAppointment::orderby('id', "DESC")->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->whereDate('created_at', '=', $date)->select("date", "id", "consultation_fees", "created_at")->paginate(10);
            } else if ($request->get("duration") == "last 7 days") {

                $date = Carbon::now()->subDays(7);
                $data = BookAppointment::orderby('id', "DESC")->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->whereDate('created_at', '>=', $date)->select("date", "id", "consultation_fees", "created_at")->paginate(10);
            } else if ($request->get("duration") == "last 30 days") {

                $date = Carbon::now()->subDays(30);
                $data = BookAppointment::orderby('id', "DESC")->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->whereDate('created_at', '>=', $date)->select("date", "id", "consultation_fees", "created_at")->paginate(10);
            } else {

                $date = explode(',', $request->get("duration"));
                $start = $date[0];
                $end = $date[1];
                $data = BookAppointment::orderby('id', "DESC")->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])->select("date", "id", "consultation_fees", "created_at")->paginate(10);
            }

            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Appointment Not Found");
            } else {
                $report = array();

                foreach ($data as  $d) {
                    $created_at = date('Y-m-d', strtotime($d->created_at));

                    $visitors = BookAppointment::select(DB::raw("(DATE_FORMAT(created_at, '%Y-%m-%d'))"))->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->where("doctor_id", $request->get("doctor_id"))->where('is_completed', '1')->whereDate('created_at', $created_at)->sum('consultation_fees');

                    $report[] = array(
                        "date" => $created_at,
                        "amount" => $visitors
                    );
                }
                //  echo "<pre>";
                //  print_r($datess);
                //  exit();
                //  $date_data = array_unique($datess);

                $myArray = array_map("unserialize", array_unique(array_map("serialize", $report)));
                $indexed_data = array_values($myArray);

                $total = 0;
                foreach ($myArray as $my) {
                    $totals = $total + $my['amount'];
                    $total = $totals;
                }

                $temp_array = array("income_record" => $indexed_data, "total_income" => $total);
                $response['success'] = "1";
                $response['register'] = __("message.Appointment List");
                $response['data'] = $temp_array;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function data_list(Request $request)
    {
        $banner = Banner::select('id', 'image')->orderby('id', 'DESC')->get();

        $speciality = Services::select('id', 'name', 'icon')->get();

        if (!empty($request->get("user_id"))) {
            $user_id = $request->get("user_id");
        } else {
            $user_id = 0;
        }

        $data = BookAppointment::with('doctorls')->where("date", ">=", date('Y-m-d'))->select("id", "doctor_id", "date", "slot_name as slot", 'phone')->where('is_completed', '1')->where("user_id", $user_id)->get();

        foreach ($data as $d) {
            $dr = Services::find($d->doctorls->department_id);
            if ($dr) {
                $d->department_name = $dr->name;
            }
            unset($d->doctorls->id);
            // unset($d->doctorls->department_id);
            unset($d->doctorls->aboutus);
            unset($d->doctorls->services);
            unset($d->doctorls->healthcare);
            unset($d->doctorls->facebook_url);
            unset($d->doctorls->twitter_url);
            unset($d->doctorls->created_at);
            unset($d->doctorls->updated_at);
            unset($d->doctorls->is_approve);
            unset($d->doctorls->login_id);
            unset($d->doctorls->connectycube_user_id);
            unset($d->doctorls->connectycube_password);
            unset($d->doctorls->unique_id);
            unset($d->doctorls->gender);
            unset($d->doctorls->title);
            unset($d->doctorls->institution_name);
            unset($d->doctorls->birth_name);
            unset($d->doctorls->spouse_name);
            unset($d->doctorls->state);
            unset($d->doctorls->city);
        }
        $temp_array = array("banner" => $banner, "speciality" => $speciality, "appointment" => $data);

        $response['status'] = 1;
        $response['msg'] = "List";
        $response['data'] = $temp_array;


        return Response::json($response);
    }

    public function about()
    {
        $data = About::find(1);
        if ($data) {
            $response['status'] = 1;
            $response['msg'] = "About List";
            $response['data'] = $data;
        } else {
            $data3 = array();
            $response['status'] = 0;
            $response['message'] = __("message.Result Not Found");
            $response['data'] = $data;
        }
        return Response::json($response);
    }

    public function privecy()
    {
        $data = About::find(1);
        if ($data) {
            $response['status'] = 1;
            $response['msg'] = "Privecy List";
            $response['data'] = $data;
        } else {
            $data3 = array();
            $response['status'] = 0;
            $response['message'] = __("message.Result Not Found");
            $response['data'] = $data;
        }
        return Response::json($response);
    }

    public function pharmacy_income_report(Request $request)
    {
        $response = array("success" => "0", "register" => "Validation error");
        $rules = [
            'pharmacy_id' => 'required',
            'duration' => 'required'
        ];

        $messages = array(
            'pharmacy_id.required' => "pharmacy_id is required",
            'duration.required' => "duration is required"
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $message = '';
            $messages_l = json_decode(json_encode($validator->messages()), true);
            foreach ($messages_l as $msg) {
                $message .= $msg[0] . ", ";
            }
            $response['register'] = $message;
        } else {
            $date = Carbon::now();

            if ($request->get("duration") == "today") {

                $data = PharmacyOrder::orderby('id', "DESC")->where("pharmacy_id", $request->get("pharmacy_id"))->where('is_completed', '1')->whereDate('created_at', '=', $date)->select("id", "total", "created_at")->paginate(10);
            } else if ($request->get("duration") == "last 7 days") {

                $date = Carbon::now()->subDays(7);
                $data = PharmacyOrder::orderby('id', "DESC")->where("pharmacy_id", $request->get("pharmacy_id"))->where('is_completed', '1')->whereDate('created_at', '>=', $date)->select("id", "total", "created_at")->paginate(10);
            } else if ($request->get("duration") == "last 30 days") {

                $date = Carbon::now()->subDays(30);
                $data = PharmacyOrder::orderby('id', "DESC")->where("pharmacy_id", $request->get("pharmacy_id"))->where('is_completed', '1')->whereDate('created_at', '>=', $date)->select("id", "total", "created_at")->paginate(10);
            } else {

                $date = explode(',', $request->get("duration"));
                $start = $date[0];
                $end = $date[1];
                $data = PharmacyOrder::orderby('id', "DESC")->where("pharmacy_id", $request->get("pharmacy_id"))->where('is_completed', '1')->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])->select("id", "total", "created_at")->paginate(10);
            }

            if (count($data) == 0) {
                $response['success'] = "0";
                $response['register'] = __("message.Order_not_found");
            } else {
                $report = array();

                foreach ($data as  $d) {
                    $created_at = date('Y-m-d', strtotime($d->created_at));

                    $visitors = PharmacyOrder::select(DB::raw("(DATE_FORMAT(created_at, '%Y-%m-%d'))"))->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                        ->where("pharmacy_id", $request->get("pharmacy_id"))->where('is_completed', '1')->whereDate('created_at', $created_at)->sum('total');

                    $report[] = array(
                        "date" => $created_at,
                        "amount" => $visitors
                    );
                }
                //  echo "<pre>";
                //  print_r($datess);
                //  exit();
                //  $date_data = array_unique($datess);

                $myArray = array_map("unserialize", array_unique(array_map("serialize", $report)));
                $indexed_data = array_values($myArray);

                $total = 0;
                foreach ($myArray as $my) {
                    $totals = $total + $my['amount'];
                    $total = $totals;
                }

                $temp_array = array("income_record" => $indexed_data, "total_income" => $total);
                $response['success'] = "1";
                $response['register'] = __("message.Order_List_Get_Success");
                $response['data'] = $temp_array;
            }
        }
        return json_encode($response, JSON_NUMERIC_CHECK);
    }
}
