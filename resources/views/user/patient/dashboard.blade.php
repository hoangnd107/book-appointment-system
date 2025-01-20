@extends('user.layout')
@section('title')
{{__('message.Patient Dashboard')}}
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
            <h1>{{__('message.Patient Dashboard')}}</h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="{{url('/')}}">{{__('message.Home')}}</a></li>
         <li>{{__('message.Patient Dashboard')}}</li>
      </ul>
   </div>
</section>
<section class="patient-dashboard bg-color-3">
   <div class="left-panel">
      <div class="profile-box patient-profile">
         <div class="upper-box">
            <figure class="profile-image">
               @if(isset($userdata)&&$userdata->profile_pic!="")
               <img src="{{asset('public/upload/profile').'/'.$userdata->profile_pic}}" alt="">
               @else
               <img src="{{asset('public/upload/profile/profile.png')}}" alt="">
               @endif
            </figure>
            <div class="title-box centred">
               <div class="inner">
                  <h3>{{isset($userdata->name)?$userdata->name:""}}</h3>
                  <p><i class="fas fa-envelope"></i>{{isset($userdata->email)?$userdata->email:""}}</p>
               </div>
            </div>
         </div>
         <div class="profile-info">
            <ul class="list clearfix">
               <li><a href="{{url('userdashboard')}}" class="current"><i class="fas fa-columns"></i>{{__('message.Dashboard')}}</a></li>
               <li><a href="{{url('usermedicineorder')}}"><i class="fas fa-columns"></i>{{__('message.Medicine Order')}}</a></li>
               <li><a href="{{url('favouriteuser')}}"><i class="fas fa-heart"></i>{{__('message.Favourite Doctors')}}</a></li>
               <li><a href="{{url('viewschedule')}}"><i class="fas fa-clock"></i>{{__('message.Schedule Timing')}}</a></li>
               <li><a href="{{url('userreview')}}" ><i class="fas fa-comments"></i>{{__('message.Review')}}</a></li>
               <li><a href="{{url('usereditprofile')}}" ><i class="fas fa-user"></i>{{__('message.My Profile')}}</a></li>
               <li><a href="{{url('changepassword')}}"><i class="fas fa-unlock-alt"></i>{{__('message.Change Password')}}</a></li>
               <li><a href="{{url('logout')}}"><i class="fas fa-sign-out-alt"></i>{{__('message.Logout')}}</a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="feature-content">
               <div class="row clearfix">
                  <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                     <div class="feature-block-two">
                        <div class="inner-box">
                           <div class="pattern">
                              <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-79.png')}}');"></div>
                              <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-80.png')}}');"></div>
                           </div>
                           <div class="icon-box"><i class="icon-Dashboard-3"></i></div>
                           <h3>{{$totalappointment}}</h3>
                           <h5>{{__('message.Total')}}</h5>
                           <h5>{{__("message.Appointment")}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                     <div class="feature-block-two">
                        <div class="inner-box">
                           <div class="pattern">
                              <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-81.png')}}');"></div>
                              <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-82.png')}}');"></div>
                           </div>
                           <div class="icon-box"><i class="icon-Dashboard-email-4"></i></div>
                           <h3>{{$completeappointment}}</h3>
                           <h5>{{__('message.Completed')}}</h5>
                           <h5>{{__("message.Appointment")}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                     <div class="feature-block-two">
                        <div class="inner-box">
                           <div class="pattern">
                              <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-83.png')}}');"></div>
                              <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-84.png')}}');"></div>
                           </div>
                           <div class="icon-box"><i class="icon-Dashboard-5"></i></div>
                           <h3>{{$pendingappointment}}</h3>
                           <h5>{{__("message.Pending")}}</h5>
                           <h5>{{__("message.Appointment")}}</h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="doctors-appointment">
               <div class="title-box">
                  <h3>{{__("message.Doctors Appointment")}}</h3>
                  <div class="btn-box">
                     @if($type==2)
                     <a href="{{url('userdashboard?type=2')}}" class="theme-btn-one">{{__('message.past')}} <i class="icon-Arrow-Right"></i></a>
                     @else
                     <a href="{{url('userdashboard?type=2')}}" class="theme-btn-two">{{__('message.past')}}</a>
                     @endif
                     @if(!isset($type))
                     <a href="{{url('userdashboard')}}" class="theme-btn-one">{{__('message.Today')}} <i class="icon-Arrow-Right"></i></a>
                     @else
                     <a href="{{url('userdashboard')}}" class="theme-btn-two">{{__('message.Today')}}</a>
                     @endif
                     @if($type==3)
                     <a href="{{url('userdashboard?type=3')}}" class="theme-btn-one">{{__('message.Upcoming')}} <i class="icon-Arrow-Right"></i></a>
                     @else
                     <a href="{{url('userdashboard?type=3')}}" class="theme-btn-two">{{__('message.Upcoming')}}</a>
                     @endif
                  </div>
               </div>
               <div class="doctors-list">
                  <div class="table-outer">
                     <table class="doctors-table">
                        <thead class="table-header">
                           <tr>
                              <th>{{__('message.Doctor Name')}}</th>
                              <th>{{__('message.Phone')}}</th>
                              <th>{{__('message.Date')}}</th>
                              <th>{{__('message.Status')}}</th>
                              <th>{{__('message.Action')}}</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($bookdata as $bdata)
                           <tr >
                              <td data-toggle="modal" data-target="#queryModalgrid" onclick="get_desc(<?php echo $bdata->id ?>)">
                                 <div class="name-box">
                                    <figure class="image">
                                       @if(isset($bdata->doctorls))
                                       <img src="{{asset('public/upload/doctors').'/'.$bdata->doctorls->image}}" alt="">
                                       @else
                                       <img src="{{asset('public/upload/profile/profile.png')}}" alt="">
                                       @endif
                                    </figure>
                                    <h5>{{isset($bdata->doctorls)?$bdata->doctorls->name:""}}</h5>
                                    <span class="designation">{{$bdata->department_name}}</span>
                                 </div>
                              </td>
                              <td>
                                 <p>{{$bdata->phone}}</p>
                              </td>
                              <td>
                                 <p>{{date("F d,Y",strtotime($bdata->date))}}</p>
                                 <span class="time">{{$bdata->slot_name}}</span>
                              </td>
                              <td>
                                 <?php
                                    if($bdata->status=='1'){
                                         echo '<span class="status">'.__("message.Received").'</span>';
                                    }else if($bdata->status=='2'){
                                         echo '<span class="status">'. __("message.Approved").'</span>';
                                    }else if($bdata->status=='3'){
                                         echo '<span class="status">'. __("message.In Process").'</span>';
                                    }
                                    else if($bdata->status=='4'){
                                         echo '<span class="status">'. __("message.Completed").'</span>';
                                    }
                                    else if($bdata->status=='5'){
                                         echo '<span class="status">'. __("message.Rejected").'</span>';
                                    }else{
                                         echo '<span class="status">'. __("message.Absent").'</span>';
                                    }
                                    ?>
                                     @if($bdata->prescription_file!="")
                                             <li><a href="{{asset('public/upload/prescription').'/'.$bdata->prescription_file}}" target="_blank" class="btn btn-success" style="color:white">{{__("message.View Prescription")}}</a></li>
                                             @endif
                              </td>
                              <td>
                                  @if($bdata->status=='2'||$bdata->status=='3'||$bdata->status=='1')
                                      <button type="button" class="btn btn-danger" onclick="reject_record('{{$bdata->id}}')">{{__("message.Reject")}}</button>
                                  @endif
                              </td>

                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                     {{ $bookdata->links('pagination::bootstrap-4') }}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

<div class="modal fade" id="queryModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
                {{__("message.Doctor Details")}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
         <div class="container-fluid">
           <div class="row">
              <div class="col-3">
                 <img id="myImage" src="" alt="" height="100%" width="100%">
              </div>
              <div class="col-6">
                 <div class ="h4" id ="name"></div>
                 <div class ="h6" id ="phone"> </div>
                  <div class ="h6"><span id="status1" style="position: relative; display: inline-block;font-size: 13px;line-height: 16px; font-weight: 600;padding: 5px 15px; border-radius: 15px; background: #ebfbf3;color: #39dc86;"> </span></div>
              </div>
              <div class="col-3">
                 <div class="text-end d-flex justify-content-end">
                    <i class="fas fa-calendar"></i>
                 </div>
                 <div class="d-flex justify-content-end" style="margin-bottom: -10px ">12-15-2023</div>
                 <div class="d-flex justify-content-end"><b id="data"></b></div>
              </div>
           </div>
           <div class="container-fluid">
               <h4 class="modal-title mt-2">
                  {{__("message.Prescription")}}
               </h4>
                <div id="m_data">


            </div>
        </div>
      </div>
   </div>
</div>

<input type="hidden" id="path_admin" value="{{url('/')}}">
<script>
     function get_desc(id){
      $("#m_data").empty();
      $.ajax({

        url:$("#path_admin").val()+"/get-user-appointment"+"/"+id,
        data: { },
        success: function(data)
        {
          console.log(data);
          $("#name").html(data.doctorls.name);
          $("#phone").html(data.phone);
          $("#data").html(data.slot_name);
          $("#myImage").attr("src", "{{ asset('public/upload/doctors') }}/" + data.doctorls.image);
        //   $("#status").html(data.status);

           if (data.status === 1) {
                $("#status1").html("{{ __('message.Received') }}");
            } else if (data.status === 2) {
                $("#status1").html("{{ __('message.Approved') }}");
            } else if (data.status === 3) {
                $("#status1").html("{{ __('message.In Process') }}");
            } else if (data.status === 4) {
                $("#status1").html("{{ __('message.Completed') }}");
            } else if (data.status === 5) {
                $("#status1").html("{{ __('message.Rejected') }}");
            } else {
                $("#status1").html("{{ __('message.Absent') }}");
            }

            if(data.medicine){
                var medicines = data.medicine.medicine;

                for (var i = 0; i < medicines.length; i++) {

                for (var j = 0; j < medicines[i].time.length; j++) {
                    var tTime = medicines[i].time[j].t_time;
                  }


                    $("#m_data").append(
                          '<div class="container m-2">' +
                            '<div class="row">' +
                              '<div id="m_name">' + medicines[i].medicine_name + '</div>' +
                            '</div>' +
                            '<div class="row">' +
                              '<div class="col- ">{{ __("message.Type") }}:&nbsp;&nbsp;</div>' +
                              '<div class="col-"><p class="text-dark" id="m_tablet">' + medicines[i].type + '</p></div>' +
                              '<div class="offset-2 col- ">{{ __("message.Dosage") }}:&nbsp;&nbsp;</div>' +
                              '<div class="col-"><p class="text-dark" id="m_dosage">' + medicines[i].dosage + '</p></div>' +
                              '<div class="offset-2 col- ">{{ __("message.Time") }}:&nbsp;&nbsp;</div>' +
                              '<div class="col-"><p class="text-dark" id="m_time">' + tTime + '</p></div>' +
                            '</div>' +
                            '<div class="row">' +
                              '<div>{{ __("message.Consume it for") }} ' + medicines[i].repeat_days + ' {{ __("message.Days") }}</div>' +
                            '</div>' +
                          '</div>' +
                           '<hr>'
                        );
                  }
            }else{
                $("#m_data").append("{{ __('message.Prescription not found') }}");
            }

        }
       });
    }
</script>


</section>
@stop
@section('footer')
@stop
