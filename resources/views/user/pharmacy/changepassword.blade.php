@extends('user.layout')
@section('title')
{{__('message.Change Password')}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{__('message.System Name')}}"/>
<meta property="og:title" content="{{__('message.System Name')}}"/>
<meta property="og:image" content="{{asset('public/image_web/').'/'.$setting->favicon}}"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="{{__('message.System Name')}}"/>
<meta property="og:description" content="{{__('message.meta_description')}}"/>
<meta property="og:keyword" content="{{__('message.Meta Keyword')}}"/>
<link rel="shortcut icon" href="{{asset('public/image_web/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')
<section class="page-title-two">
   <div class="title-box centred bg-color-2">
      <div class="pattern-layer">
         <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-70.png')}}');"></div>
         <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-71.png')}}');"></div>
      </div>
      <div class="auto-container">
         <div class="title">
            <h1>{{__('message.Change Password')}}</h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="{{url('/')}}">{{__('message.Home')}}</a></li>
         <li>{{__('message.Change Password')}}</li>
      </ul>
   </div>
</section>
<section class="doctors-dashboard bg-color-3">
   <div class="left-panel">
      <div class="profile-box">
         <div class="upper-box">
            <figure class="profile-image">
               @if($doctordata->image!="")
               <img src="{{asset('public/upload/doctors').'/'.$doctordata->image}}" alt="">
               @else
               <img src="{{asset('public/upload/doctors/defaultpharmacy.png')}}" alt="">
               @endif
            </figure>
            <div class="title-box centred">
               <div class="inner">
                  <h3>{{$doctordata->name}}</h3>
                  <p>{{isset($doctordata->departmentls)?$doctordata->departmentls->name:""}}</p>
               </div>
            </div>
         </div>
         <div class="profile-info">
            <ul class="list clearfix">
                <li><a href="{{url('pharmacydashboard')}}"><i class="fas fa-columns"></i>{{__('message.Dashboard')}}</a></li>
                <li><a href="{{ url('pharmacymedicine') }}"><i class="fas fa-pills"></i>{{ __('message.Medicine') }}</a></li>
                <li><a href="{{url('pharmacyreview')}}" ><i class="fas fa-star"></i>{{__('message.Reviews')}}</a></li>
                <li><a href="{{url('pharmacyeditprofile')}}"><i class="fas fa-user"></i>{{__('message.My Profile')}}</a></li>
                <li><a href="{{url('pharmacychangepassword')}}"  class="current"><i class="fas fa-unlock-alt"></i>{{__('message.Change Password')}}</a></li>
                <li><a href="{{url('logout')}}"><i class="fas fa-sign-out-alt"></i>{{__("message.Logout")}}</a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="add-listing change-password">
               <div class="single-box">
                  <div class="title-box">
                     <h3>{{__('message.Change Password')}}</h3>
                  </div>
                  <div class="inner-box">
                     @if(Session::has('message'))
                     <div class="col-sm-12">
                        <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
                           {{ Session::get('message') }}
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                     </div>
                     @endif
                     <div id="registererror"></div>
                     {{-- <form action="{{url('updatedoctorpassword')}}" method="post">
                        {{csrf_field()}}
                        <div class="row clearfix">
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                              <label>{{__('message.Enter Your Current Password')}}</label>
                              <input type="password"  id="opwd" name="opwd" required="" onchange="checkdoctorcurrentpwd(this.value)">
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                              <label>{{__('message.Enter Your New Password')}}</label>
                              <input type="password" name="npwd" id="pwd" required="" onchange="checknewpwd(this.value)">
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                              <label>{{__('message.Enter Confirm password')}}</label>
                              <input type="password" name="conpwd"  id="cpwd" required="" onchange="checkbothpassword(this.value)">
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                           </div>
                        </div>
                  </div>
               </div>
               <div class="btn-box">
               <button class="theme-btn-one" type="submit">{{__('message.Save Change')}}<i class="icon-Arrow-Right"></i></button>
               <a href="{{url('changepassword')}}" class="cancel-btn">{{__("message.Cancel")}}</a>
               </div>
               </form> --}}
               <form action="{{url('updatedoctorpassword')}}" method="post" id="passwordChangeForm">
                  {{csrf_field()}}
                  <div class="row clearfix">
                     <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                        <label>{{__('message.Enter Your Current Password')}}</label>
                        <input type="password"  id="opwd" name="opwd" required="">
                        <span id="msg1" style="display: none;color: red;">{{__("message.Current_Password_wrong")}}</span>
                     </div>
                     <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                     </div>
                     <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                        <label>{{__('message.Enter Your New Password')}}</label>
                        <input type="password" name="npwd" id="pwd" required="">
                        <span id="msg2" style="display: none;color: red;">{{__("message.Current_Password_new_Password_same")}}</span>
                     </div>
                     <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                     </div>
                     <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                        <label>{{__('message.Enter Confirm password')}}</label>
                        <input type="password" name="conpwd"  id="cpwd" required="">
                        <span id="msg3" style="display: none;color: red;">{{__("message.Confirm_Password_not_match")}}</span>
                     </div>
                     <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                     </div>
                  </div>
                </div>
                  </div>
                  <div class="btn-box">
                  <button class="theme-btn-one" type="button" onclick="chengepswd()">{{__('message.Save Change')}}<i class="icon-Arrow-Right"></i></button>
                  <a href="{{url('changepassword')}}" class="cancel-btn">{{__("message.Cancel")}}</a>
                  </div>
                  </form>
            </div>
         </div>
      </div>
   </div>
   <input type="hidden" id="ccpp" value="{{$doctordata->password}}">
</section>
<script>
function chengepswd() {
    // Get the form fields
    $("#msg1").css("display","none");
    $("#msg2").css("display","none");
    $("#msg3").css("display","none");
    var oldcurrentPassword = document.getElementById('ccpp').value;
    var currentPassword = document.getElementById('opwd').value;
    var newPassword = document.getElementById('pwd').value;
    var confirmPassword = document.getElementById('cpwd').value;

    if (currentPassword === '' || newPassword === '' || confirmPassword === '') {
        alert('All fields are required.');
        return false;
    }else{

        if (oldcurrentPassword !== currentPassword) {
        $("#msg1").css("display","block");
        return false;
        }else{
         $("#msg1").css("display","none");
      }


      if (currentPassword == newPassword) {
        $("#msg2").css("display","block");
        return false;
        }else{
         $("#msg2").css("display","none");
      }


        if (newPassword !== confirmPassword) {
            $("#msg3").css("display","block");
            return false;
        }else{
         $("#msg3").css("display","none");
      }

        document.getElementById('passwordChangeForm').submit();
    }

}
</script>
@stop
@section('footer')
@stop
