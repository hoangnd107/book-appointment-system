<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['Localization']], function () {

    Route::any("searchdoctor", [ApiController::class, "showsearchdoctor"]);
    Route::any("nearbydoctor", [ApiController::class, "nearbydoctor"]);
    Route::post("register", [ApiController::class, "postregisterpatient"]);
    Route::any("user_reject_appointment", [ApiController::class, "user_reject_appointment"]);

    Route::post("connectycube_register",[ApiController::class,"connectycube_register"]);

    Route::any("savetoken", [ApiController::class, "storetoken"]);
    Route::any("login", [ApiController::class, "showlogin"]);
    Route::post("doctorregister", [ApiController::class, "doctorregister"]);
    Route::any("doctorlogin", [ApiController::class, "doctorlogin"]);
    Route::any("getspeciality", [ApiController::class, "getspeciality"]);
    Route::any("bookappointment", [ApiController::class, "bookappointment"]);
    Route::any("viewdoctor", [ApiController::class, "viewdoctor"]);
    Route::any("addreview", [ApiController::class, "addreview"]);
    Route::any("getslot", [ApiController::class, "getslotdata"]);
    Route::any("getlistofdoctorbyspecialty", [ApiController::class, "getlistofdoctorbyspecialty"]);
    Route::any("usersuappointment", [ApiController::class, "usersupcomingappointment"]);
    Route::any("userspastappointment", [ApiController::class, "userspastappointment"]);
    Route::any("doctoruappointment", [ApiController::class, "doctoruappointment"]);
    Route::any("doctorpastappointment", [ApiController::class, "doctorpastappointment"]);
    Route::any("reviewlistbydoctor", [ApiController::class, "reviewlistbydoctor"]);
    Route::any("doctordetail", [ApiController::class, "doctordetail"]);
    Route::any("appointmentdetail", [ApiController::class, "appointmentdetail"]);
    Route::any("doctoreditprofile", [ApiController::class, "doctoreditprofile"]);
    Route::any("usereditprofile", [ApiController::class, "usereditprofile"]);
    Route::any("getdoctorschedule", [ApiController::class, "getdoctorschedule"]);
    Route::any("Reportspam", [ApiController::class, "saveReportspam"]);
    Route::any("appointmentstatuschange", [ApiController::class, "appointmentstatuschange"]);
    Route::any("forgotpassword", [ApiController::class, "forgotpassword"]);
    Route::get("getalldoctors", [ApiController::class, "getalldoctors"]);

    Route::get("getholiday", [ApiController::class, "getholiday"]);
    Route::any("saveholiday", [ApiController::class, "saveholiday"]);
    Route::get("deleteholiday", [ApiController::class, "deleteholiday"]);
    Route::get("checkholiday", [ApiController::class, "checkholiday"]);

    Route::get("get_all_doctor", [ApiController::class, "get_all_doctor"]);

    Route::get("get_subscription_list", [ApiController::class, "get_subscription_list"]);

    // Route::post("place_subscription",[ApiController::class,"place_subscription"]);

    Route::any("subscription_upload", [ApiController::class, "subscription_upload"]);

    Route::any("mediaupload", [ApiController::class, "mediaupload"]);
    Route::any("doctor_subscription_list", [ApiController::class, "doctor_subscription_list"]);
    Route::any("change_password_doctor", [ApiController::class, "change_password_doctor"]);

    Route::any("bannerlist", [ApiController::class, "banner_list"]);

    Route::any("income_report", [ApiController::class, "income_report"]);

    Route::any("data_list", [ApiController::class, "data_list"]);
    Route::any("about", [ApiController::class, "about"]);
    Route::any("privecy", [ApiController::class, "privecy"]);


    Route::any("search_medicine", [ApiController::class, "search_medicine"]);
    Route::any("add_medicine_to_app", [ApiController::class, "add_medicine_to_app"]);
    Route::any("upload_image", [ApiController::class, "upload_image"]);
    Route::any('delete_upload_image', [ApiController::class, 'delete_upload_image']);
    Route::any("most_used_medicine", [ApiController::class, "most_used_medicine"]);

    Route::any('add_bankdetails', [ApiController::class, 'add_bankdetails']);
    Route::any("get_bankdetails", [ApiController::class, "get_bankdetails"]);

    Route::any("medicine_order", [ApiController::class, "medicine_order"]);
    Route::post("prescription_order", [ApiController::class, "prescription_order"]);
    Route::any("change_pharmacyorder_status", [ApiController::class, "change_pharmacyorder_status"]);
    Route::any("prescription_addprice", [ApiController::class, "prescription_addprice"]);

    Route::any("get_user_order_list", [ApiController::class, "get_user_order_list"]);
    Route::any("get_pharmacy_order_list", [ApiController::class, "get_pharmacy_order_list"]);
    Route::any("view_order", [ApiController::class, "view_order"]);

    Route::any("pharmacy_medicines", [ApiController::class, "pharmacy_medicines"]);
    Route::any("medicines_detail", [ApiController::class, "medicines_detail"]);
    Route::any("add_pharmacy_medicine", [ApiController::class, "add_pharmacy_medicine"]);
    Route::any("delete_pharmacy_medicine", [ApiController::class, "delete_pharmacy_medicine"]);

    Route::any("pharmacy_income_report", [ApiController::class, "pharmacy_income_report"]);
});
