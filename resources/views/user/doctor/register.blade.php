@extends('user.layout')
@section('title')
 {{-- {{__('message.Doctor Register')}} --}}
 {{ __('Profile Register') }}
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
                        <h1 id="aa">{{__('message.Doctor Register')}}</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{url('/')}}">{{__('message.Home')}}</a></li>
                        <li id="aa1">{{__('message.Doctor Register')}}</li>
                    </ul>
                </div>
            </div>
</section>
<section class="registration-section bg-color-3">
            <div class="pattern">
                <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-85.png')}}');"></div>
                <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-86.png')}}');"></div>
            </div>
            <div class="auto-container">
                <div class="inner-box">
                    <div class="content-box">
                        <div class="title-box">
                            <h3 id="aa2">{{__('message.Doctor Register')}}</h3>
                            <a href="{{url('profilelogin')}}">{{__("message.Already a Profile?")}}</a>
                        </div>
                        <div class="inner">
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
                             <div id="registererror">

                             </div>

                             <style>
                                .nav-pills .nav-item .nav-link.active {
                                    background-color:#ff9136;
                                    border-radius: 30px;
                                }
                            </style>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link  active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                        role="tab" aria-controls="pills-home"
                                        aria-selected="true">{{ __('message.Doctors') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                        role="tab" aria-controls="pills-profile"
                                        aria-selected="false">{{ __('message.Pharmacy') }}</a>
                                </li>

                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <form action="{{url('postdoctorregister')}}" method="post" class="registration-form">
                                        {{csrf_field()}}
                                         <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label class="fr" >{{__('message.Name')}}</label>
                                        <input type="text" id="name" name="name" placeholder="{{__('message.Your name')}}" required="" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label class="fr">{{__('message.Phone Number')}}</label>
                                        <input type="text" name="phone" id="phone" placeholder="{{__('message.Enter Your Phone number')}}" required="" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label class="fr">{{__('message.Email')}}</label>
                                        <input type="email" name="email" id="email" placeholder="{{__('message.Your email')}}" required="" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label class="fr">{{__('message.Password')}}</label>
                                        <input type="password" name="password" id="pwd" placeholder="{{__('message.Enter password')}}" required="" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label class="fr">{{__('message.Confirm password')}}</label>
                                        <input type="password" name="cpassword" id="cpwd" onchange="checkbothpassword(this.value)" placeholder="{{__('message.Enter Confirm password')}}" required="" />
                                        <span id="cpwd_error" style="color: red" ></span>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <div class="custom-check-box fr">
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control ">
                                                    <input type="checkbox" class="material-control-input" name="agree" value="1" required="" />
                                                    <span class="material-control-indicator"></span>
                                                     <span class="description">{{__('message.I accept')}} <a href="{{url('/')}}">{{__('message.terms')}}</a> {{__('message.and')}} <a href="{{url('/')}}">{{__('message.conditions')}}</a> {{__('message.and general policy')}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn-one">{{__('message.Register Now')}}<i class="icon-Arrow-Right"></i></button>
                                    </div>
                                </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <form action="{{url('postpharmacyregister')}}" method="post" class="registration-form">
                                        {{csrf_field()}}
                                         <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="fr" >{{__('message.Name')}}</label>
                                                <input type="text" id="name" name="name" placeholder="{{__('message.Your name')}}" required="" />
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="fr">{{__('message.Phone Number')}}</label>
                                                <input type="text" name="phone" id="phone" placeholder="{{__('message.Enter Your Phone number')}}" required="" />
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="fr">{{__('message.Email')}}</label>
                                                <input type="email" name="email" id="email" placeholder="{{__('message.Your email')}}" required="" />
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="fr">{{__('message.Password')}}</label>
                                                <input type="password" name="password" id="pwd1" placeholder="{{__('message.Enter password')}}" required="" />
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="fr">{{__('message.Confirm password')}}</label>
                                                <input type="password" name="cpassword" id="cpwd1" onchange="checkbothpassword1(this.value)" placeholder="{{__('message.Enter Confirm password')}}" required="" />
                                                <span id="cpwd_error1" style="color: red" ></span>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <div class="custom-check-box fr">
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control ">
                                                            <input type="checkbox" class="material-control-input" name="agree" value="1" required="" />
                                                            <span class="material-control-indicator"></span>
                                                            <span class="description">{{__('message.I accept')}} <a href="{{url('/')}}">{{__('message.terms')}}</a> {{__('message.and')}} <a href="{{url('/')}}">{{__('message.conditions')}}</a> {{__('message.and general policy')}}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                                <button type="submit" class="theme-btn-one">{{__('message.Register Now')}}<i class="icon-Arrow-Right"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            <div class="text"><span>{{__('message.or')}}</span></div>

                            <div class="login-now"><p>{{__('message.Already have an account')}} <a href="{{url('profilelogin')}}">{{__('message.Login Now')}}</a></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       <section class="agent-section" style="background: aliceblue;">
   <div class="auto-container">
      <div class="inner-container bg-color-2">
         <div class="row clearfix">
            <div class="col-lg-6 col-md-12 col-sm-12 left-column">
               <div class="content_block_3">
                  <div class="content-box">
                     <h3>{{__('message.Emergency call')}}</h3>
                     <div class="support-box">
                        <div class="icon-box"><i class="fas fa-phone"></i></div>
                        <span>{{__('message.Telephone')}}</span>
                        <h3><a href="tel:{{$setting->phone}}">{{$setting->phone}}</a></h3>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 right-column">
               <div class="content_block_4">
                  <div class="content-box">
                     <h3>{{__('message.Sign up for Newsletter today')}}</h3>
                     <form action="#" method="post" class="subscribe-form">
                        <div class="form-group">
                           <input type="email" name="email" id="emailnews" placeholder="{{__('message.Your email')}}" required="">
                           <button type="button" onclick="addnewsletter()" class="theme-btn-one">{{__('message.Submit now')}}<i class="icon-Arrow-Right"></i></button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
    function handleClick(event) {
        // Prevent the default action of the link
        event.preventDefault();

        // Get the text content of the clicked link
        var clickedText = event.target.textContent;

        // Log the text content
        console.log(clickedText);
        $('#aa').text(clickedText + ' {{__("message.Register Now")}}');
        $('#aa1').text(clickedText + ' {{__("message.Register Now")}}');
        $('#aa2').text(clickedText + ' {{__("message.Register Now")}}');
    }
    document.getElementById("pills-home-tab").addEventListener("click", handleClick);
    document.getElementById("pills-profile-tab").addEventListener("click", handleClick);



    function checkbothpassword(value){
   var pwd=$("#pwd").val();
   if(pwd!=value){
       var txt=$("#pwdmatch").val();
       $("#cpwd_error").html(txt);
       $("#cpwd").val("");
   }
}

function checkbothpassword1(value){
   var pwd=$("#pwd1").val();
   if(pwd!=value){
       var txt=$("#pwdmatch").val();
       $("#cpwd_error1").html(txt);
       $("#cpwd1").val("");
   }
}

</script>

@stop
@section('footer')
@stop
