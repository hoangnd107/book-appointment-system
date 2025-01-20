@extends('user.layout')
@section('title')
{{__('message.Appointment List')}}
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

<section class="registration-section bg-color-3">
    <div class="pattern">
        <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-85.png')}}');"></div>
        <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-86.png')}}');"></div>
    </div>
    <div class="auto-container">
        <a class=" mb-2" href="{{url('backtoappointment')}}" style="color:black; text-decoration: underline;" >{{__('message.Back to appointment')}}</a>
        <!--<i class="fa fa-arrow-left" aria-hidden="true"></i>-->
            <div class="content-box">
                <div class="title-box">
                    <h3>{{__('message.appointment Details')}}</h3>
                </div>
                <div class="inner">
                    <div class="single-item">

                        <div class="row">
                            <div class="col-4">
                                <figure class="image-box">
                                    @if($am->patientls->profile_pic!="")
                                        <img src="{{asset('public/upload/profile').'/'.$am->patientls->profile_pic}}" alt="">
                                    @else
                                         <img src="{{asset('public/upload/profile/profile.png')}}" alt="">
                                    @endif
                                  </figure>
                            </div>
                            <div class="col-3">
                                  <h4>{{$am->patientls->name}}</h4>
                                  <ul class="info-list clearfix">
                                      <li><i class="fas fa-clock"></i> {{date("F d,Y",strtotime($am->date))}}, {{$am->slot_name}}</li>
                                      <li><i class="fas fa-envelope"></i> {{$am->patientls->email}}</li>
                                      <li><i class="fas fa-phone"></i> {{$am->phone}}</li>
                                      <li><i class="fas fa-sticky-note"></i>
                                         {{$am->user_description}}
                                      </li>
                                       @if($am->prescription_file!="")
                                     <li><a href="{{asset('public/upload/prescription').'/'.$am->prescription_file}}" target="_blank" class="btn btn-success" style="color:white">{{__("message.View Prescription")}}</a></li>
                                     @endif
                                       <li style="position: relative; display: inline-block;font-size: 13px;line-height: 16px; font-weight: 600;padding: 5px 15px; border-radius: 15px; background: #ebfbf3;color: #39dc86;">
                                       <?php
                                              if($am->status=='1'){
                                                   echo __("message.Received");
                                              }else if($am->status=='2'){
                                                   echo __("message.Approved");
                                              }else if($am->status=='3'){
                                                   echo __("message.In Process");
                                              }
                                              else if($am->status=='4'){
                                                   echo __("message.Completed");
                                              }
                                              else if($am->status=='5'){
                                                   echo __("message.Rejected");
                                              }else{
                                                   echo __("message.Absent");
                                              }
                                       ?>
                                     </li>

                                  </ul>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_Prescription">{{__("message.Add Prescription")}}</button><br><br>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_report">{{__("message.Add Report")}}</button>
                            </div>
                        </div>

                        <div class="row pt-4">

                            <h4 class="pl-3">{{__("message.prescription Details")}}</h4>
                            @if(count($app_medicine) > 0)
                            @foreach($app_medicine as $a_m)

                            @php
                                $m = json_decode($a_m->medicines);
                                $aa = $m->medicine;
                            @endphp

                                <div class="col-10">
                                    @foreach($aa as $aa)
                                        <div class="container ml-3 pt-2">
                                          <div class="row">
                                            <div id="m_name" class="col-10"><?php echo $aa->medicine_name; ?> </div>
                                          </div>
                                          <div class="row">

                                              <div class="col-3">
                                                  {{__("message.Type")}}: <b><?php echo $aa->type; ?></b>
                                              </div>
                                              <div class="col-3">
                                                  {{__("message.Dosage")}}: <b><?php echo $aa->dosage; ?></b>
                                              </div>
                                              <div class="col">
                                                  <div class="row ">
                                                     {{__("message.Time")}}: @foreach($aa->time as $time)<div class="card p-1 px-3 mx-1"> <?php echo $time->t_time; ?> </div> @endforeach
                                                   </div>
                                              </div>

                                          </div>

                                          <div class="row">
                                            <div class="col">{{__("message.Consume it for")}} <?php echo $aa->repeat_days; ?> {{__("message.Days")}}</div>
                                          </div>
                                          <hr>
                                        </div>

                                    @endforeach
                                </div>
                                <div class="col-2">
                                    <a type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_Prescription" onclick="get_desc(<?php echo $a_m->id ?>)" ><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                    <a type="button" class="btn btn-outline-danger" href="{{ url('delete_prescription', $a_m->id) }}"><i class="fa fa-trash "></i></a>
                                </div>


                                    <hr>
                            @endforeach
                            @else
                            <div class="container m-2">
                                      {{__("message.prescription details not found")}}
                             </div>
                            @endif

                        </div>
                        <div class="row mb-2">
                            <h4 class="pl-3">{{__("message.Report Image")}}</h4>

                        </div>
                        <div class="row ml-3">
                            @if(count($img) > 0)
                                @foreach($img as $image)

                                    <div class="card p-2 m-1" style="width: 7rem; height: 100%;">
                                        <img src="{{ asset('public/upload/ap_img_up').'/'.$image->image }}" class="img-fluid" style="border-radius: 10px; flex-grow: 1;">

                                            <div class="h6 text-center mt-2">
                                                {{ $image->name }}
                                            </div>
                                        <a type="button" class="btn btn-outline-danger mx-4" href="{{ url('delete_report', $image->id) }}"><i class="fa fa-trash "></i></a>
                                    </div>
                                @endforeach
                            @else
                                <div class="container m-2">
                                    {{__("message.Report not Uploaded")}}
                                </div>
                            @endif
                        </div>

                  </div>
                </div>
            </div>
    </div>

    <div class="modal fade" id="add_Prescription" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
             {{__("message.Add Prescription")}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
        <form action="{{url('save_prescription')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$apoid}}">
            <div class="modal-body">

               <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Medicine")}} </label>
                        <input class="form-control" list="browsers" name="medicine" id="myInput" placeholder="{{__('message.Search medicine')}}">
                    <datalist id="browsers" class="suggestions">

                    </datalist>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Type")}}</label>
                    <div class="custom-dropdown" id="timerange" style="width: 100%;margin-bottom: 10px;" >
                     <select class="" name="type"  required="" style="background:none; border:1px solid #E5E7EC;">
                        <option value="" > {{__("message.select")}} {{__("message.Type")}}</option>
                        <option value="Tablet" >Tablet</option>
                       <option value="Injection" >Injection</option>
                  </select>
               </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Dosage")}}</label>
                    <input type="text" name="dosge" id="dosge" placeholder="{{__('message.Enter')}} {{__('message.Dosage')}}" required="">
                </div><br>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Consum Days")}}</label>
                    <input type="text" name="repeat_days" id="repeat_days" placeholder="{{__('message.Enter')}} {{__('message.Consum Days')}}" required="">
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Consuming Time")}}</label>
                    <div class="row">
                        <div class="col-10">
                            <input type="time" name="t_time[]" id="t_time" placeholder="{{__('message.Enter')}} {{__('message.Consuming Time')}}" required="" style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-light" id="addmore">+</button>
                        </div>
                    </div><br>

                    <div id="showmore">

                    </div>

                </div>
                </div>

               <div class="modal-footer">
                 <button type="submit" class="btn btn-success">{{__('message.Submit')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
      </div>
   </div>
</div>

<div class="modal fade" id="add_report" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              {{__('message.Add Report')}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{url('save_prescription')}}" method="post" enctype="multipart/form-data" class="registration-form">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$apoid}}">
              <div class="modal-body">

                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__('message.Name')}}</label>
                    <input type="text" name="name" id="name" placeholder="{{__('message.Enter')}} {{__('message.Name')}}" required="">
                </div>

                   <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <label class="fr">{{__('message.Upload Report')}}</label>
                        <input type="file" name="report_img" required>
                    </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                 <button type="submit" class="btn btn-success">{{__('message.Submit')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
      </div>
   </div>
</div>


<div class="modal fade" id="edit_Prescription" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              {{__("message.Edit Prescription")}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
        <form action="{{url('edit_prescription')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="id1" id="id1" value="">
            <div class="modal-body">

               <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Medicine")}}</label>
                        <input class="form-control" list="browsers" name="medicine" id="myInput1" placeholder="Search medicine">
                    <datalist id="browsers" class="suggestions">

                    </datalist>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Type")}}</label>
                    <div class="custom-dropdown" id="timerange" style="width: 100%;margin-bottom: 10px;" >
                     <select class="" name="type"  required="" style="background:none; border:1px solid #E5E7EC;">
                        <option value="" >{{__("message.select")}} {{__("message.Type")}}</option>
                        <option value="Tablet" >Tablet</option>
                       <option value="Injection" >Injection</option>
                  </select>
               </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Dosage")}}</label>
                    <input type="text" name="dosge" id="dosge1" placeholder="{{__('message.Enter')}} {{__('message.Dosage')}}" required="">
                </div><br>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Consum Days")}}</label>
                    <input type="text" name="repeat_days" id="repeat_days1" placeholder="{{__('message.Enter')}} {{__('message.Consum Days')}}" required="">
                </div><br>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Consuming Time")}}</label><br>
                    <div class="row">
                        <div class="col-10">
                            <input type="time" name="t_time[]" id="t_time1" placeholder="{{__('message.Enter')}} {{__('message.Consuming Time')}}" required="" style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">
                        </div>
                        <div class="col-10">
                            <button type="button" class="btn btn-light" id="addmore1">+</button>
                        </div>
                    </div><br>

                    <div id="showmore1">

                    </div>

                </div>
                </div>

               <div class="modal-footer">
                 <button type="submit" class="btn btn-success">{{__('message.Submit')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
      </div>
   </div>
</div>

<input type="hidden" name="url" id="url" value="{{url('/')}}"></input>

<script>
    $(document).ready(function() {
    $('#addmore').click(function(event) {
        event.preventDefault();
        $('#showmore').append(
            '<div class="row mb-4">' +
                '<div class="col-10">' +
                    '<input type="time" name="t_time[]" id="t_time" placeholder="Enter time" required="" style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">' +
                '</div>' +
                '<div class="col">' +
                    '<button type="button" class="btn btn-light remove">-</button>' +
                '</div>' +
            '</div>'
        );
    });

    $('#showmore').on("click", ".remove", function(e) {
        e.preventDefault();
        $(this).closest('.row').remove();
    });
});

$(document).ready(function() {
    $('#addmore1').click(function(event) {
        event.preventDefault();
        $('#showmore1').append(
            '<div class="row mb-4">' +
                '<div class="col-10">' +
                    '<input type="time" name="t_time[]" id="t_time" placeholder="Enter time" required="" style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">' +
                '</div>' +
                '<div class="col">' +
                    '<button type="button" class="btn btn-light remove">-</button>' +
                '</div>' +
            '</div>'
        );
    });

    $('#showmore').on("click", ".remove", function(e) {
        e.preventDefault();
        $(this).closest('.row').remove();
    });
});

$(document).ready(function () {
    $('#myInput').on('input', function () {
        var inputText = $(this).val();

        if(inputText == null){
            $('#suggestions').empty();
                $('#browsers').empty();
        }else{
            var url = $('#url').val();
        $.ajax({
            url: url + '/getmedicines',
            method: 'GET',
            data: { inputText: inputText },
            success: function (data) {
                $('.suggestions').empty();

                data.suggestions.forEach(function (suggestion) {
                    $('.suggestions').append($('<option>').val(suggestion));
                });

            },
            error: function (error) {
                console.error(error);
            }
        });


        }

    });
});

$(document).ready(function () {
    $('#myInput1').on('input', function () {
        var inputText = $(this).val();

        if(inputText == null){
            $('#suggestions').empty();
                $('#browsers').empty();
        }else{
            var url = $('#url').val();
        $.ajax({
            url: url + '/getmedicines',
            method: 'GET',
            data: { inputText: inputText },
            success: function (data) {
                $('.suggestions').empty();

                data.suggestions.forEach(function (suggestion) {
                    $('.suggestions').append($('<option>').val(suggestion));
                });

            },
            error: function (error) {
                console.error(error);
            }
        });


        }

    });
});


function get_desc(id){
      $("#m_data").empty();
      $.ajax({

        url:$("#url").val()+"/get-user-appointment1"+"/"+id,
        data: { },
        success: function(data)
        {
          console.log(data);
            if(data.medicine){
                var medicines = data.medicine.medicine;
                $('#id1').val(data.id);
                for (var i = 0; i < medicines.length; i++) {

                for (var j = 0; j < medicines[i].time.length; j++) {
                    var tTime = medicines[i].time[j].t_time;
                  }
                        $('select[name="type"]').val(medicines[i].type);
                        $('#myInput1').append($('#myInput1').val(medicines[i].medicine_name));
                        $('#dosge1').append($('#dosge1').val(medicines[i].dosage));
                        $('#repeat_days1').append($('#repeat_days1').val(medicines[i].repeat_days));

                        var timesContainer = $('#showmore1');
                        timesContainer.empty(); // Clear previous entries

                        for (var j = 0; j < medicines[i].time.length; j++) {
                             var tTime = medicines[i].time[j].t_time;
                            if(j === 0) {
                               $('#t_time1').append($('#t_time1').val(tTime));
                             } else {

                            var timeInput = '<div class="row mb-4">' +
                                               '<div class="col-10">' +
                                                   '<input type="time" name="t_time[]" value="' + tTime + '" required style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">' +
                                               '</div>' +
                                               '<div class="col">' +
                                                   '<button type="button" class="btn btn-light remove">-</button>' +
                                               '</div>' +
                                            '</div>';

                            timesContainer.append(timeInput);
                             }


                        }
                  }
            }else{
                $("#m_data").append( '{{__('message.Prescription not found')}}');
            }

        }
       });

       $(document).on('click', '.remove', function() {
    $(this).closest('.row').remove();
});
    }


</script>

</section>


@stop
@section('footer')
@stop
