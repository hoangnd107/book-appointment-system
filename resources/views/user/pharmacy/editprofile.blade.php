@extends('user.layout')
@section('title')
{{__("message.My Profile")}}
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
            <h1>{{__("message.My Profile")}}</h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="{{url('/')}}">{{__("message.Home")}}</a></li>
         <li>{{__("message.My Profile")}}</li>
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
                <li><a href="{{url('pharmacydashboard')}}" ><i class="fas fa-columns"></i>{{__('message.Dashboard')}}</a></li>
                <li><a href="{{ url('pharmacymedicine') }}"><i class="fas fa-pills"></i>{{ __('message.Medicine') }}</a></li>
                <li><a href="{{url('pharmacyreview')}}" ><i class="fas fa-star"></i>{{__('message.Reviews')}}</a></li>
                <li><a href="{{url('pharmacyeditprofile')}}" class="current"><i class="fas fa-user"></i>{{__('message.My Profile')}}</a></li>
                <li><a href="{{url('pharmacychangepassword')}}"><i class="fas fa-unlock-alt"></i>{{__('message.Change Password')}}</a></li>
                <li><a href="{{url('logout')}}"><i class="fas fa-sign-out-alt"></i>{{__("message.Logout")}}</a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="add-listing my-profile">
               <div class="single-box">
                  <div class="title-box">
                     <h3>{{__("message.My Profile")}}</h3>
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
                     <form action="{{url('updatepharmacy')}}" method="post" enctype="multipart/form-data">
                       {{csrf_field()}}
                                    <div class="profile-title">
                                        <figure class="image-box">

                                          @if($doctordata->image!="")
                                             <img src="{{asset('public/upload/doctors').'/'.$doctordata->image}}" alt="" accept="image/*">
                                          @else
                                             <img src="{{asset('public/upload/doctors/defaultpharmacy.png')}}" alt="" >
                                          @endif
                                       </figure>
                                        <div class="upload-photo">
                                            <input type="file" name="upload_image" accept="image/*">
                                            <span></span>
                                        </div>
                                    </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <label>{{__('message.Name')}}</label>
                                                <input type="text" name="name" id="name" placeholder="{{__('message.Enter Pharmacy Name')}}" required="" value="{{isset($doctordata->name)?$doctordata->name:''}}">
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <label>{{__('message.Email')}}</label>
                                                <input type="email" name="email" placeholder="{{__('message.Your email')}}" required="" id="email" value="{{isset($doctordata->email)?$doctordata->email:''}}">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <label>{{__('message.Phone no')}}</label>
                                                <input type="text" name="phoneno" id="phoneno" placeholder="{{__('message.Enter Phone No')}}" required="" value="{{isset($doctordata->phoneno)?$doctordata->phoneno:''}}">
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <label>{{__('message.Working Time')}}</label>
                                                <input type="text" name="working_time" placeholder="{{__('message.Enter Working Time')}}" required="" id="working_time" value="{{isset($doctordata->working_time)?$doctordata->working_time:''}}">
                                            </div>


                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label>{{__('message.About Us')}}</label>
                                                <textarea name="aboutus" id="aboutus" placeholder="{{__('message.Enter About Pharmacy')}}" required="">{{isset($doctordata->aboutus)?$doctordata->aboutus:''}}</textarea>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label>{{__('message.Services')}}</label>
                                                <textarea name="services"  id
                                                ="services" placeholder="{{__('message.Enter Description about Services')}}" required="">{{isset($doctordata->services)?$doctordata->services:''}}</textarea>
                                            </div>
                                        </div><br>
                                        <div class="col-md-12 p-0"  id="addressorder">
                                          <label>{{__("message.Address")}}<span class="reqfield">*</span></label>
                                          <input  type="text" id="us2-address" name="address" placeholder='{{__("message.Search Location")}}' required data-parsley-required="true" required=""/>
                                       </div>
                                       <div class="map" id="maporder">
                                          <div class="form-group">
                                             <div class="col-md-12 p-0">
                                                <div id="us2"></div>
                                             </div>
                                          </div>
                                       </div>
                                           <input type="hidden" name="lat" id="us2-lat" value="{{isset($doctordata->lat)?$doctordata->lat:Config::get('mapdetail.lat')}}" />
                                          <input type="hidden" name="lon" id="us2-lon" value="{{isset($doctordata->lon)?$doctordata->lon:Config::get('mapdetail.long')}}" />

                                </div>

               </div>
               <div class="btn-box">
               <button class="theme-btn-one" type="submit">{{__('message.Save Change')}}<i class="icon-Arrow-Right"></i></button>
               <a href="{{url('changepassword')}}" class="cancel-btn">{{__('message.Cancel')}}</a>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
@stop
