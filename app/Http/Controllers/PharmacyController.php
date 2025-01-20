<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use App\Models\Services;
use App\Models\Schedule;
use App\Models\PaymentGatewayDetail;
use App\Models\Review;
use App\Models\FavoriteDoc;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\BookAppointment;
use App\Models\Doctor_Hoilday;
use App\Models\Patient;
use App\Models\PharmacyOrder;
use App\Models\PharmacyOrderData;
use Illuminate\Support\Facades\Session;
use App\Models\PharmacyProduct;
use Illuminate\Support\Facades\DB;
use Exception;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class PharmacyController extends Controller
{
    public function pharmacy()
    {
        $pharmacy = Doctors::where('profile_type', '2')->get();
        return view('admin.pharmacy.pharmacy', compact('pharmacy'));
    }
    public function addpharmacy($id)
    {
        $setting =Setting::find(1);
        $data = Doctors::find($id);
        return view("admin.pharmacy.savepharmacy")->with("id", $id)->with("data", $data)->with("setting", $setting);
        // return view('admin.pharmacy.savepharmacy');
    }

    public function updatepharmacy(Request $request)
    {
        // return $request;

        if ($request->get("id") == 0) {
            $store = new Doctors();
            $data = Doctors::where("email", $request->get("email"))->first();
            if ($data) {
                Session::flash('message', __("message.Email Already Existe"));
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            $msg = __("message.Pharmacy Add Successfully");
            $img_url = "profile.png";
            $rel_url = "";
        } else {
            $store = Doctors::find($request->get("id"));
            $msg = __("message.Pharmacy Update Successfully");
            $img_url = $store->image;
            $rel_url = $store->image;
        }
        if ($request->hasFile('upload_image')) {
            $file = $request->file('upload_image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/upload/doctors/';
            $picture = time() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('upload_image')->move($destinationPath, $picture);
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
        $store->password = $request->get("password");
        $store->phoneno = $request->get("phoneno");
        $store->aboutus = $request->get("aboutus");
        $store->services = $request->get("services");
        $store->address = $request->get("address");
        $store->lat = $request->get("lat");
        $store->lon = $request->get("lon");
        $store->email = $request->get("email");
        $store->working_time = $request->get("working_time");
        $store->image = $img_url;
        $store->is_approve = '1';
        $store->profile_type = '2';
        //   $user_id = "";
        //   $login_field = "";
        //    if($request->get("id")==0&&env('ConnectyCube')==true){
        //                           $login_field = $request->get("phoneno").rand()."#1";
        //                           $user_id = $this->signupconnectycude($request->get("name"),$request->get("password"),$request->get("email"),$request->get("phoneno"),$login_field);
        //      }
        //      $store->connectycube_user_id = $user_id;
        //   $store->login_id = $login_field;
        $store->save();

        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect("admin/pharmacy");
    }

    public function deletepharmacy($id)
    {
        $data = Doctors::find($id);
        $data->delete();

        return redirect()->back();
    }



    // mrdicine controller

    public function medicine($pharmacy_id)
    {
        $data = PharmacyProduct::where('pharmacy_id', $pharmacy_id)->get();
        return view('admin.pharmacy.pharmacymedicine', compact('pharmacy_id', 'data'));
    }

    public function addmedicine($pharmacy_id, $medicine_id)
    {
        $data = PharmacyProduct::find($medicine_id);
        return view('admin.pharmacy.savemedicine', compact('pharmacy_id', 'data', 'medicine_id'));
    }

    public function updatemedicine(Request $request)
    {
        // return $request;
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

        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('medicine', $request->pharmacy_id);
    }

    public function medicinedelete($id)
    {
        $data = PharmacyProduct::find($id);
        $data->delete();

        return redirect()->back();
    }

    public function pharmacyorder()
    {
        $orderdata = PharmacyOrder::get();
        foreach ($orderdata as $order) {
            $doctor = Doctors::find($order->Pharmacy_id);
            $patient = Patient::find($order->user_id);

            if ($doctor) {
                $order->Pharmacy_id = $doctor->name;
            }

            if ($patient) {
                $order->user_id = $patient->name;
            }
        }
        return view('admin.pharmacy.pharmacyorder', compact('orderdata'));
    }


    // fornt controller

    public function searchpharmacy(Request $request)
    {
        $setting = Setting::find(1);
        $services = Services::all();
        $term = $request->get("term");
        $type = $request->get("type");
        if (!empty($term) && !empty($type)) { //11
            $doctorslist = Doctors::with('departmentls')->where("department_id", $type)->Where('name', 'like', '%' . $term . '%')->where("is_approve", "1")->where('profile_type', 2)->paginate(10);
        } else if (!empty($term) && empty($type)) { //10
            $doctorslist = Doctors::with('departmentls')->where("is_approve", "1")->Where('name', 'like', '%' . $term . '%')->where('profile_type', 2)->paginate(10);
        } else if (empty($term) && !empty($type)) { //01
            $doctorslist = Doctors::with('departmentls')->where("is_approve", "1")->where("department_id", $type)->where('profile_type', 2)->paginate(10);
        } else { //00
            $doctorslist = Doctors::with('departmentls')->where("is_approve", "1")->where('profile_type', 2)->paginate(10);
        }

        if (!empty($term) && !empty($type)) { //11
            $doctorslistmap = Doctors::with('departmentls')->where("is_approve", "1")->where("department_id", $type)->Where('name', 'like', '%' . $term . '%')->where('profile_type', 2)->get();
        } else if (!empty($term) && empty($type)) { //10
            $doctorslistmap = Doctors::with('departmentls')->where("is_approve", "1")->Where('name', 'like', '%' . $term . '%')->where('profile_type', 2)->get();
        } else if (empty($term) && !empty($type)) { //01
            $doctorslistmap = Doctors::with('departmentls')->where("is_approve", "1")->where("department_id", $type)->where('profile_type', 2)->get();
        } else { //00
            $doctorslistmap = Doctors::with('departmentls')->where("is_approve", "1")->where('profile_type', 2)->get();
        }



        foreach ($doctorslist as $k) {
            $k->avgratting = Review::where('doc_id', $k->id)->avg('rating');
            $k->totalreview = count(Review::where('doc_id', $k->id)->get());
            if (!empty(Session::get("user_id")) && Session::get('role_id') == '1') {
                $lsfav = FavoriteDoc::where("doctor_id", $k->id)->where("user_id", Session::get("user_id"))->first();
                if ($lsfav) {
                    $k->is_fav = 1;
                } else {
                    $k->is_fav = 0;
                }
            } else {
                $k->is_fav = 0;
            }
        }

        return view("user.allpharmacy")->with("services", $services)->with("setting", $setting)->with("doctorlist", $doctorslist)->with("term", $term)->with("type", $type)->with("doctorslistmap", $doctorslistmap);
        // return view('user.allpharmacy');
    }

    public function rattinglinescal($id){
        $totalreview=count(Review::where("doc_id",$id)->get());
        if($totalreview!=0){
           $str5=0;
           $str4=0;
           $str3=0;
           $str2=0;
           $str1=0;
           $str5=count(Review::where("doc_id",$id)->where("rating",5)->get())*100/$totalreview;
           $str4=count(Review::where("doc_id",$id)->where("rating",4)->get())*100/$totalreview;
           $str3=count(Review::where("doc_id",$id)->where("rating",3)->get())*100/$totalreview;
           $str2=count(Review::where("doc_id",$id)->where("rating",2)->get())*100/$totalreview;
           $str1=count(Review::where("doc_id",$id)->where("rating",1)->get())*100/$totalreview;
           return array("start5"=>$str5,"start4"=>$str4,"start3"=>$str3,"start2"=>$str2,"start1"=>$str1);
        }else{
           return array("start5"=>0,"start4"=>0,"start3"=>0,"start2"=>0,"start1"=>0);
        }
     }

    public function viewpharmacy($id)
    {
        $data = Doctors::with('departmentls')->find($id);
        if ($data) {
            $data->reviewslist = Review::with('patientls')->where("doc_id", $data->id)->get();
            $data->avgratting = Review::where("doc_id", $data->id)->avg('rating');
            $data->totalreview = count(Review::where("doc_id", $data->id)->get());
            $data->startrattinglines=$this->rattinglinescal($data->id);
            if (!empty(Session::get("user_id")) && Session::get('role_id') == '1') {
                $lsfav = FavoriteDoc::where("doctor_id", $id)->where("user_id", Session::get("user_id"))->first();
                if ($lsfav) {
                    $data->is_fav = 1;
                } else {
                    $data->is_fav = 0;
                }
            } else {
                $data->is_fav = 0;
            }
        } else {
            return redirect("/");
        }
        $setting = Setting::find(1);
        $gateway = new \Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId'  => env('BRAINTREE_MERCHANT_ID'),
            'publicKey'   => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey'  => env('BRAINTREE_PRIVATE_KEY')
        ]);
        $token = $gateway->ClientToken()->generate();
        $date = $this->getsitedate();

        $arr = array();
        $data1 = PaymentGatewayDetail::all();
        foreach ($data1 as $k) {
            $arr[$k->gateway_name . "_" . $k->key] = $k->value;
        }

        $medicine = PharmacyProduct::where('pharmacy_id', $id)->get();
        return view("user.viewpharmacy")->with("data", $data)->with("setting", $setting)->with("token", $token)->with("paymentdetail", $arr)->with("medicine", $medicine);
    }



    // cart controller
    public function addToCart($id)
    {

        $product = PharmacyProduct::find($id);

        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                $id => [
                    "pharmacy_id" => $product->pharmacy_id,
                    "id" => $product->id,
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                ]
            ];
        } else {
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "pharmacy_id" => $product->pharmacy_id,
                    "id" => $product->id,
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                ];
            }
        }
        session()->put('cart', $cart);
        Session::flash('message',  __("message.cart_medicine_add_success"));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function removeCartItem($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        Session::flash('message',  __("message.cart_medicine_Delete_success"));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }


    public function addpharmacyorder(Request $request)
    {
        // return $request;
        if ($request->payment_type == 'cod') {

            $data = new PharmacyOrder();
            $data->Pharmacy_id = $request->Pharmacy_id;
            $data->total = $request->total;
            $data->phone = $request->phone_no;
            $data->message = $request->message;
            $data->address = $request->address;
            $data->payment_type = $request->payment_type;
            $data->tax = $request->tax;
            $data->delivery_charge = $request->delivery_charge;
            $data->is_completed = '1';
            $data->order_type = 2;
            $data->status = 0;
            $data->user_id = session()->get('user_id');
            $data->save();

            if (session()->has('cart')) {
                $orderdata = session()->get('cart');
                foreach ($orderdata as $id => $item) {
                    $add = new PharmacyOrderData();
                    $add->order_id = $data->id;
                    $add->service_id = $item['id'];
                    $add->qty = $item['quantity'];
                    $add->name = $item['name'];
                    $add->price = $item['price'];
                    $add->save();
                }
            }
            session()->forget('cart');
            Session::flash('message', __('Medicine order placed successfully'));
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        }
        if ($request->get("payment_type") == "stripe") {

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $unique_id = uniqid();
            $charge = \Stripe\Charge::create(array(
                'description' => "Amount: " . $request->get("total") . ' - ' . $unique_id,
                'source' => $request->get("stripeToken"),
                'amount' => (int)($request->get("total") * 100),
                'currency' => env('STRIPE_CURRENCY')
            ));

            DB::beginTransaction();
            try {
                $data = new PharmacyOrder();
                $data->Pharmacy_id = $request->Pharmacy_id;
                $data->total = $request->total;
                $data->phone = $request->phone_no;
                $data->message = $request->message;
                $data->address = $request->address;
                $data->payment_type = "Stripe";
                $data->transaction_id = $charge->id;
                $data->tax = $request->tax;
            $data->delivery_charge = $request->delivery_charge;
                $data->order_type = 2;
                $data->is_completed = '1';
                $data->status = 0;
                $data->user_id = session()->get('user_id');
                $data->save();

                if (session()->has('cart')) {
                    $orderdata = session()->get('cart');
                    foreach ($orderdata as $id => $item) {
                        $add = new PharmacyOrderData();
                        $add->order_id = $data->id;
                        $add->service_id = $item['id'];
                        $add->qty = $item['quantity'];
                        $add->name = $item['name'];
                        $add->price = $item['price'];
                        $add->save();
                    }
                }
                session()->forget('cart');
                DB::commit();
                Session::flash('message', __('message.medicine_order_palce'));
                Session::flash('alert-class', 'alert-success');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('message', $e);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        } else if ($request->get("payment_type") == "braintree") {

            $gateway = new \Braintree\Gateway([
                'environment' => env('BRAINTREE_ENV'),
                'merchantId'  => env('BRAINTREE_MERCHANT_ID'),
                'publicKey'   => env('BRAINTREE_PUBLIC_KEY'),
                'privateKey'  => env('BRAINTREE_PRIVATE_KEY')
            ]);
            $nonce = $request->get("payment_method_nonce");
            $result = $gateway->transaction()->sale([
                'amount' => $request->total,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);
            if ($result->success) {
                $transaction = $result->transaction;
                DB::beginTransaction();
                try {
                    $data = new PharmacyOrder();
                    $data->Pharmacy_id = $request->Pharmacy_id;
                    $data->total = $request->total;
                    $data->phone = $request->phone_no;
                    $data->message = $request->message;
                    $data->address = $request->address;
                    $data->payment_type = "Braintree";
                    $data->transaction_id = $transaction->id;
                    $data->tax = $request->tax;
            $data->delivery_charge = $request->delivery_charge;
                    $data->order_type = 2;
                    $data->is_completed = '1';
                    $data->status = 0;
                    $data->user_id = session()->get('user_id');
                    $data->save();

                    if (session()->has('cart')) {
                        $orderdata = session()->get('cart');
                        foreach ($orderdata as $id => $item) {
                            $add = new PharmacyOrderData();
                            $add->order_id = $data->id;
                            $add->service_id = $item['id'];
                            $add->qty = $item['quantity'];
                            $add->name = $item['name'];
                            $add->price = $item['price'];
                            $add->save();
                        }
                    }
                    session()->forget('cart');
                    DB::commit();
                    Session::flash('message',  __('message.medicine_order_palce'));
                    Session::flash('alert-class', 'alert-success');
                    return redirect()->back();
                } catch (\Exception $e) {
                    DB::rollback();
                    Session::flash('message', $e);
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                }
            } else {
                $errorString = "";
                foreach ($result->errors->deepAll() as $error) {
                    $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
                }
                Session::flash('message', $errorString);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        } else if ($request->get("payment_type") == "Flutterwave") {

            $reference = Flutterwave::generateReference();

            $data1 = PaymentGatewayDetail::where("gateway_name", "rave")->get();

            $arr = array();
            foreach ($data1 as $k) {
                $arr[$k->gateway_name . "_" . $k->key] = $k->value;
            }

            $user = Session::get("user_id");
            $userinfo = Patient::find($user);

            $data = [
                'payment_options' => 'card,banktransfer',
                'amount' => $request->get("total"),
                'email' => $userinfo->email,
                'tx_ref' => $reference,
                'currency' => $arr['rave_currency'],
                'redirect_url' => route('web-callbackorder'),
                'customer' => [
                    'email' => $userinfo->email,
                    "phonenumber" => $request->get("phone_no"),
                    "name" => $userinfo->name
                ],

                "customizations" => [
                    "title" => 'Book Appointment',
                    "description" => "Book Appointment"
                ]
            ];

            $payment = Flutterwave::initializePayment($data);
            // echo "<pre>";print_r($payment);exit;


            $data = new PharmacyOrder();
            $data->Pharmacy_id = $request->Pharmacy_id;
            $data->total = $request->total;
            $data->phone = $request->phone_no;
            $data->message = $request->message;
            $data->address = $request->address;
            $data->tax = $request->tax;
            $data->delivery_charge = $request->delivery_charge;
            $data->payment_type = "Rave";
            $data->transaction_id = $reference;
            $data->order_type = 2;
            $data->is_completed = '0';
            $data->status = 0;
            $data->user_id = session()->get('user_id');
            $data->save();

            if (session()->has('cart')) {
                $orderdata = session()->get('cart');
                foreach ($orderdata as $id => $item) {
                    $add = new PharmacyOrderData();
                    $add->order_id = $data->id;
                    $add->service_id = $item['id'];
                    $add->qty = $item['quantity'];
                    $add->name = $item['name'];
                    $add->price = $item['price'];
                    $add->save();
                }
            }
            session()->forget('cart');
            Session::flash('message',  __('message.medicine_order_palce'));
            Session::flash('alert-class', 'alert-success');
            return redirect($payment['data']['link']);
            DB::commit();


            if ($payment['status'] !== 'success') {
                return redirect()->route('payment-failed');
                Session::flash('message', $errorString);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            } else {
                return redirect($payment['data']['link']);
            }
        } else if ($request->get("payment_type") == "Razorpay") {
            $data1 = PaymentGatewayDetail::where("gateway_name", "razorpay")->get();
            $arr = array();
            if (count($data1) > 0) {
                foreach ($data1 as $k) {
                    $arr[$k->gateway_name . "_" . $k->key] = $k->value;
                }
            }
            // echo "<pre>";print_r($arr);exit;
            $input = $request->all();

            // $api = new Api($arr['razorpay_razorpay_key'],$arr['razorpay_razorpay_secert']);
            // $payment = $api->payment->fetch($request->get('razorpay_payment_id'));
            // $response = $api->payment->fetch($request->get('razorpay_payment_id'))->capture(array('amount'=>(int)$amount*100));


            $data = new PharmacyOrder();
            $data->Pharmacy_id = $request->Pharmacy_id;
            $data->total = $request->total;
            $data->phone = $request->phone_no;
            $data->message = $request->message;
            $data->address = $request->address;
            $data->tax = $request->tax;
            $data->delivery_charge = $request->delivery_charge;
            $data->payment_type = "Razorpay";
            $data->transaction_id = $request->get('razorpay_payment_id');
            $data->order_type = 2;
            $data->is_completed = '1';
            $data->status = 0;
            $data->user_id = session()->get('user_id');
            $data->save();

            if (session()->has('cart')) {
                $orderdata = session()->get('cart');
                foreach ($orderdata as $id => $item) {
                    $add = new PharmacyOrderData();
                    $add->order_id = $data->id;
                    $add->service_id = $item['id'];
                    $add->qty = $item['quantity'];
                    $add->name = $item['name'];
                    $add->price = $item['price'];
                    $add->save();
                }
            }
            session()->forget('cart');
            Session::flash('message',  __('message.medicine_order_palce'));
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } else if ($request->get("payment_type") == "Paystack") {

            $data1 = PaymentGatewayDetail::where("gateway_name", "paystack")->get();

            $arr = array();
            foreach ($data1 as $k) {
                $arr[$k->gateway_name . "_" . $k->key] = $k->value;
            }


            $curl = curl_init();
            $email = 'admin@gmail.com';
            $amount = $request->get("total");
            $callback_url = route('paystack_callback');
            // echo "<pre>";print_r($amount);exit;

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'amount' => $amount,
                    'email' => $email,
                    'callback_url' => $callback_url
                ]),
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer " . $arr['paystack_secert_key'] . "",
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            if ($err) {
                die('Curl returned error: ' . $err);
            }
            $tranx = json_decode($response, true);
            //   echo "<pre>";print_r($tranx);exit;

            if ($tranx['data']['reference']) {
                DB::beginTransaction();
                try {

                    $data = new PharmacyOrder();
                    $data->Pharmacy_id = $request->Pharmacy_id;
                    $data->total = $request->total;
                    $data->phone = $request->phone_no;
                    $data->message = $request->message;
                    $data->address = $request->address;
                    $data->tax = $request->tax;
                    $data->delivery_charge = $request->delivery_charge;
                    $data->payment_type = "Paystack";
                    $data->transaction_id = $tranx['data']['reference'];
                    $data->order_type = 2;
                    $data->is_completed = '0';
                    $data->status = 0;
                    $data->user_id = session()->get('user_id');
                    $data->save();

                    if (session()->has('cart')) {
                        $orderdata = session()->get('cart');
                        foreach ($orderdata as $id => $item) {
                            $add = new PharmacyOrderData();
                            $add->order_id = $data->id;
                            $add->service_id = $item['id'];
                            $add->qty = $item['quantity'];
                            $add->name = $item['name'];
                            $add->price = $item['price'];
                            $add->save();
                        }
                    }
                    session()->forget('cart');
                    Session::flash('message',  __('message.medicine_order_palce'));
                    Session::flash('alert-class', 'alert-success');
                    return Redirect($tranx['data']['authorization_url']);
                } catch (\Exception $e) {
                    DB::rollback();
                }
            } else {
                die('something getting worng');
            }

            if (!$tranx['status']) {
                print_r('API returned error: ' . $tranx['message']);
            }
            return Redirect($tranx['data']['authorization_url']);
        }
    }

    public function upload_pre_order(Request $request)
    {

        // return $request;

        if ($request->hasFile('prescription')) {
            $file = $request->file('prescription');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $folderName = '/upload/orderprescription/';
            $picture = time() . '.' . $extension;
            $destinationPath = public_path() . $folderName;
            $request->file('prescription')->move($destinationPath, $picture);
        }

        $data = new PharmacyOrder();
        $data->Pharmacy_id = $request->Pharmacy_id;
        $data->prescription = $picture;
        $data->phone = $request->phone_no;
        $data->message = $request->message;
        $data->address = $request->address;
        $data->tax = $request->tax;
        $data->delivery_charge = $request->delivery_charge;
        $data->order_type = 1;
        $data->is_completed = '1';
        $data->status = 0;
        $data->user_id = session()->get('user_id');
        $data->save();

        Session::flash('message', __('message.Prescription upload successfully'));
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function usermedicineorder(Request $request)
    {

        if (Session::get("user_id") != "" && Session::get("role_id") == '1') {
            $setting = Setting::find(1);
            $orderdata = PharmacyOrder::where('user_id', Session::get("user_id"))->get();
            $complet = PharmacyOrder::where('user_id', Session::get("user_id"))->where('status', '3')->count();
            $pending = PharmacyOrder::where('user_id', Session::get("user_id"))->where('status', '0')->count();
            foreach ($orderdata as $order) {
                $u = Patient::find($order->user_id);
                $p = Doctors::find($order->Pharmacy_id);
                if($p){
                    $order->Pharmacy_id = $p->name;
                }else{
                    $order->Pharmacy_id = "";
                }
                if($u){
                    $order->user_id = $u->name;
                }else{
                    $order->user_id = "";
                }
            }
            $userdata = Patient::find(Session::get("user_id"));
            if (empty($userdata)) {
                $this->logout();
            }
            return view("user.patient.medicineorder")->with("orderdata", $orderdata)->with("setting", $setting)->with("userdata", $userdata)->with("complet", $complet)->with("pending", $pending);
        } else {
            return redirect("/");
        }

        // return view('user.patient.medicineorder');
    }
    public function get_orderdata($id)
    {
        $setting = Setting::find(1);
        $currency = explode("-", $setting->currency);
        $orderdata = PharmacyOrder::find($id);
        $u = Patient::find($orderdata->user_id);
        $p = Doctors::find($orderdata->Pharmacy_id);
        $orderdata->Pharmacy_id = $p->name;
        $orderdata->user_id = $u->name;

        $data = PharmacyOrderData::where('order_id', $id)->get();
        return array($data, $orderdata,$currency);
    }

    public function pharmacylogin(Request $request)
    {
        // return $request;

        $getUser = Doctors::where("email", $request->get("email"))->where("password", $request->get("password"))->where("profile_type", '2')->first();
        $setting = Setting::find(1);
        if ($getUser) {

            if ($request->get("rem_me") == 1) {
                setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                setcookie('password', $request->get("password"), time() + (86400 * 30), "/");
                setcookie('rem_me', 1, time() + (86400 * 30), "/");
            }
            Session::put("user_id", $getUser->id);
            Session::put("role_id", '3');

            $previousUrl = session('previous_url', '/');
            session()->forget('previous_url');
            return redirect()->intended($previousUrl);
            // return redirect("pharmacydashboard");
        } else {
            Session::flash('message', __("message.Login Credentials Are Wrong"));
            Session::flash('alert-class', 'alert-danger');
            return redirect("profilelogin");
        }
    }

    public function postpharmacyregister(Request $request){
        //dd($request->all());
        $getuser=Doctors::where("email",$request->get("email"))->first();
        if($getuser){
            Session::flash('message',__("message.Email Already Existe"));
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }else{
            $store=new Doctors();
            $store->name=$request->get("name");
            $store->email=$request->get("email");
            $store->password=$request->get("password");
            $store->phoneno=$request->get("phone");
            $store->profile_type= '2';
            $store->is_approve = '1';

            // if(env('ConnectyCube')==true){
            //       $login_field = $request->get("phone").rand()."#2";
            //       $user_id = $this->signupconnectycude($request->get("name"),$request->get("password"),$request->get("email"),$request->get("phone"),$login_field);
            // }

            // $store->connectycube_user_id = $user_id;
            // $store->login_id = $login_field;
            // $store->connectycube_password = $request->get("password");


            // $connrctcube = ($store->connectycube_user_id);
            // if($connrctcube == "0-email must be unique"){

            //     Session::flash('message',__("email or password allready added in ConnectCube"));
            //     Session::flash('alert-class', 'alert-danger');
            //     return redirect()->back();
            // }
            // else
            // {
                $store->save();
                if($request->get("rem_me")==1){
                        setcookie('email', $request->get("email"), time() + (86400 * 30), "/");
                        setcookie('password',$request->get("password"), time() + (86400 * 30), "/");
                        setcookie('rem_me',1, time() + (86400 * 30), "/");
                }

                Session::put("user_id",$store->id);
                Session::put("role_id",'3');
                Session::flash('message',__("Successful Register"));
                Session::flash('alert-class', 'alert-success');
                return redirect("doctordashboard");
            }
        // }
    }

    public function pharmacydashboard(Request $request)
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '3') {
            $setting = Setting::find(1);
            $totalreview = count(Review::where("doc_id", Session::get("user_id"))->get());
            $today = PharmacyOrder::where('Pharmacy_id', Session::get("user_id"))->whereDate('created_at', now()->format('Y-m-d'))->count();
            $orderdata = PharmacyOrder::where('Pharmacy_id', Session::get("user_id"))->get();
            foreach ($orderdata as $order) {
                $u = Patient::find($order->user_id);
                $order->user_id = $u->name;
            }

            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            return view("user.pharmacy.dashboard")->with("setting", $setting)->with("doctordata", $doctordata)->with("orderdata", $orderdata)->with("totalreview", $totalreview)->with("today", $today);
        } else {
            return redirect("/");
        }
        // return view('user.pharmacy.dashboard');
    }

    public function pharmacyreview()
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '3') {
            $setting = Setting::find(1);
            $doctordata = Doctors::find(Session::get("user_id"));
            $reviewdata = Review::with('patientls')->where("doc_id", Session::get("user_id"))->get();
            return view("user.pharmacy.review")->with("setting", $setting)->with("doctordata", $doctordata)->with("reviewdata", $reviewdata);
        } else {
            return redirect("/");
        }
    }

    public function pharmacyeditprofile()
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '3') {
            $setting = Setting::find(1);

            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            return view("user.pharmacy.editprofile")->with("setting", $setting)->with("doctordata", $doctordata);
        } else {
            return redirect("/");
        }
    }

    public function pharmacychangepassword()
    {
        if (Session::get("user_id") != "" && Session::get("role_id") == '3') {
            $setting = Setting::find(1);
            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            return view("user.pharmacy.changepassword")->with("setting", $setting)->with("doctordata", $doctordata);
        } else {
            return redirect("/");
        }
    }

    public function updatepharmacysideprofile(Request $request){
        //dd($request->all());
          $doctoremail=Doctors::where("email",$request->get("email"))->where("id","!=",Session::get("user_id"))->first();
          if($doctoremail){
                 Session::flash('message',__("message.Email Already Existe"));
                 Session::flash('alert-class', 'alert-danger');
                 return redirect()->back();
          }else{
            $store=Doctors::find(Session::get("user_id"));
            $msg=__("message.Doctor Update Successfully");
            $img_url=$store->image;
            $rel_url=$store->image;
          }
            if ($request->hasFile('upload_image'))
              {
                 $file = $request->file('upload_image');
                 $filename = $file->getClientOriginalName();
                 $extension = $file->getClientOriginalExtension() ?: 'png';
                 $folderName = '/upload/doctors/';
                 $picture = time() . '.' . $extension;
                 $destinationPath = public_path() . $folderName;
                 $request->file('upload_image')->move($destinationPath, $picture);
                 $img_url =$picture;
                  $image_path = public_path() ."/upload/doctors/".$rel_url;
                    if(file_exists($image_path)&&$rel_url!="") {
                        try {
                             unlink($image_path);
                        }
                        catch(Exception $e) {

                        }
                  }
             }
          $store->name=$request->get("name");
          $store->phoneno=$request->get("phoneno");
          $store->aboutus=$request->get("aboutus");
          $store->services=$request->get("services");
          $store->address=$request->get("address");
          $store->lat=$request->get("lat");
          $store->lon=$request->get("lon");
          $store->email=$request->get("email");
          $store->working_time=$request->get("working_time");
          $store->image=$img_url;
          $store->save();
          Session::flash('message',$msg);
          Session::flash('alert-class', 'alert-success');
          return redirect()->back();
    }

    public function pharmacyorderchangestatus($id,$status){
        $data = PharmacyOrder::find($id);
        $data->status = $status;
        $data->save();

        return redirect()->back();
    }

    public function addprice(Request $request){
        $data = PharmacyOrder::find($request->id);
        $data->status = 5;
        $data->total = $request->price;
        $data->save();

        return redirect()->back();
    }

    public function pharmacymedicine(Request $request){
        if (Session::get("user_id") != "" && Session::get("role_id") == '3') {
            $setting = Setting::find(1);
            $data = PharmacyProduct::where('pharmacy_id', Session::get("user_id"))->get();
            $doctordata = Doctors::with('departmentls')->find(Session::get("user_id"));
            return view("user.pharmacy.addmedicine")->with("setting", $setting)->with("doctordata", $doctordata)->with('data',$data);
        } else {
            return redirect("/");
        }
        // return view('user.pharmacy.addmedicine');
    }

    public function medicinedeletefront($id)
    {
        $data = PharmacyProduct::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function updatemedicinefront(Request $request)
    {
        // return $request;
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

        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function getdatapharmmacy($id){

        $data = PharmacyProduct::find($id);
        return $data;
    }

    public function deleteimgpharmmacy($id){
        $data = PharmacyProduct::find($id);
        if( $data ){
            $data->image = null;
            $data->save();
            return 1;
        }else{
            return 0;
        }

    }

}
