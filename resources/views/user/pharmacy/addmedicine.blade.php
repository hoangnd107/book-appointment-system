@extends('user.layout')
@section('title')
    {{ __('message.Pharmacy') }} {{ __('message.Medicine') }}
@stop
@section('meta-data')
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ __('message.System Name') }}" />
    <meta property="og:title" content="{{ __('message.System Name') }}" />
    <meta property="og:image" content="{{ asset('public/image_web/') . '/' . $setting->favicon }}" />
    <meta property="og:image:width" content="250px" />
    <meta property="og:image:height" content="250px" />
    <meta property="og:site_name" content="{{ __('message.System Name') }}" />
    <meta property="og:description" content="{{ __('message.meta_description') }}" />
    <meta property="og:keyword" content="{{ __('message.Meta Keyword') }}" />
    <link rel="shortcut icon" href="{{ asset('public/image_web/') . '/' . $setting->favicon }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')
    <section class="page-title-two">
        <div class="title-box centred bg-color-2">
            <div class="pattern-layer">
                <div class="pattern-1"
                    style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-70.png') }}');">
                </div>
                <div class="pattern-2"
                    style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-71.png') }}');">
                </div>
            </div>
            <div class="auto-container">
                <div class="title">
                    <h1>{{ __('message.Pharmacy') }} {{ __('message.Medicine') }}</h1>
                </div>
            </div>
        </div>
        <div class="lower-content">
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">{{ __('message.Home') }}</a></li>
                <li>{{ __('message.Pharmacy') }} {{ __('message.Medicine') }}</li>
            </ul>
        </div>
    </section>
    <section class="doctors-dashboard bg-color-3">
        <div class="left-panel">
            <div class="profile-box">
                <div class="upper-box">
                    <figure class="profile-image">
                        @if ($doctordata->image != '')
                            <img src="{{ asset('public/upload/doctors') . '/' . $doctordata->image }}" alt="">
                        @else
                            <img src="{{ asset('public/upload/doctors/defaultpharmacy.png') }}" alt="">
                        @endif
                    </figure>
                    <div class="title-box centred">
                        <div class="inner">
                            <h3>{{ $doctordata->name }}</h3>
                            <p>{{ isset($doctordata->departmentls) ? $doctordata->departmentls->name : '' }}</p>
                        </div>
                    </div>
                </div>
                <div class="profile-info">
                    <ul class="list clearfix">
                        <li><a href="{{ url('pharmacydashboard') }}" ><i
                                    class="fas fa-columns"></i>{{ __('message.Dashboard') }}</a></li>
                        <li><a href="{{ url('pharmacymedicine') }}" class="current"><i
                            class="fas fa-pills"></i>{{ __('message.Medicine') }}</a></li>
                        <li><a href="{{ url('pharmacyreview') }}"><i
                                    class="fas fa-star"></i>{{ __('message.Reviews') }}</a></li>
                        <li><a href="{{ url('pharmacyeditprofile') }}"><i
                                    class="fas fa-user"></i>{{ __('message.My Profile') }}</a></li>
                        <li><a href="{{ url('pharmacychangepassword') }}"><i
                                    class="fas fa-unlock-alt"></i>{{ __('message.Change Password') }}</a></li>
                        <li><a href="{{ url('logout') }}"><i
                                    class="fas fa-sign-out-alt"></i>{{ __('message.Logout') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="right-panel">
            <div class="content-container">
                <div class="outer-container">
                    <div class="feature-content">

                    </div>
                    <div class="doctors-appointment">
                        <div class="title-box">
                            <h3>{{ __('message.Medicine') }}</h3>
                            <div class="btn-box">
                                <button type="button" class="btn theme-btn-one" data-toggle="modal" data-target="#addmedicine">  {{ __('message.Add Medicine') }}</button>
                            </div>
                        </div>
                        <div class="doctors-list  m-3">
                            <div class="table-outer">
                                <table id="myTable">
                                    <thead class="table-header">
                                        <tr>
                                            <th>{{__("message.Id")}}</th>
                                            <th>{{__("message.Image")}}</th>
                                            <th>{{__("message.Name")}}</th>
                                            <th>{{__("message.description")}}</th>
                                            <th>{{__("message.Price")}}</th>
                                            <th>{{__("message.Action")}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $data)
                                        <tr>
                                            <td>{{$data->id}}</td>
                                            <td>
                                                <img src="{{asset('public/upload/pharmacymedicine/'.$data->image)}}" width="100px;" alt="">
                                            </td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->description}}</td>
                                            <td>{{$data->price}}</td>
                                            <td>
                                                <a href="#"  onclick="getdata({{$data->id}})" data-toggle="modal" data-target="#addmedicine" class="px-3 text-primary"><i class="fas fa-pen font-size-18"></i></a>

                                                <a href="{{route('medicinedeletefront',$data->id)}}" class="px-3 px-3 text-danger"><i class="fas fa-trash-alt font-size-18">
                                                        </i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal -->
         <div class="modal fade" id="addmedicine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">{{__("message.Add Medicine")}}</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">

                    <form action="{{url('updatemedicinefront')}}" class="needs-validation" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="pharmacy_id" id="pharmacy_id" value="{{Session::get("user_id")}}">
                        <input type="hidden" name="medicine_id" id="medicine_id" value="0">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="form-group">
                                <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
                                    <input type="file" name="upload_image" id="upload_image" class="form-control" />
                                    <div id="img">

                                    </div>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="form-group">
                                 <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
                                 <input type="text" class="form-control" placeholder='{{__("message.Enter")}} {{__("message.Medicine")}} {{__("message.Name")}}' id="name" name="name" required="" value="">
                              </div>

                              <div class="form-group">
                                 <label for="password">{{__("message.Price")}}<span class="reqfield">*</span></label>
                                 <input type="text" class="form-control" id="Price" placeholder='{{__("message.Enter")}} {{__("message.Price")}}' name="price" required="" value="">
                              </div>

                              <div class="form-group">
                                <label for="description">{{__("message.description")}}<span class="reqfield">*</span></label>
                                <textarea id="description" class="form-control" rows="5" placeholder='{{__("message.Enter Your Description")}}' name="description" required=""></textarea>
                             </div>
                           </div>

                        </div>

                        <div class="col-lg-12">
                           <div class="form-group">
                                 <button  class="btn btn-primary" type="submit" value="Submit">{{__("message.Submit")}}</button>
                           </div>
                        </div>
                 </div>
             </div>
         </div>
     </div>


        {{-- <!-- Modal -->
        <div class="modal fade" id="editmedicine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Medicine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                   <form action="{{url('updatemedicinefront1')}}" class="needs-validation" method="post" enctype="multipart/form-data">
                       {{csrf_field()}}
                       <input type="hidden" name="pharmacy_id" id="pharmacy_id" value="{{Session::get("user_id")}}">
                       <input type="hidden" name="medicine_id" id="edit_medicine_id" value="">
                       <div class="row">
                          <div class="col-lg-12">
                             <div class="form-group">
                               <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>

                                   <input type="file" name="upload_image" id="upload_image" class="form-control" />

                             </div>
                          </div>
                          <div class="col-lg-12">
                             <div class="form-group">
                                <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
                                <input type="text" class="form-control" placeholder='{{__("Enter Medicine Name")}}' id="edit_name" name="name" required="" value="">
                             </div>

                             <div class="form-group">
                                <label for="password">{{__("message.Price")}}<span class="reqfield">*</span></label>
                                <input type="number" class="form-control" id="edit_Price" placeholder='{{__("Enter Medicine Price")}}' name="price" required="" value="">
                             </div>

                             <div class="form-group">
                               <label for="description">{{__("message.description")}}<span class="reqfield">*</span></label>
                               <textarea id="edit_description" class="form-control" rows="5" placeholder='{{__("Enter Description")}}' name="description" required=""></textarea>
                            </div>
                          </div>

                       </div>

                       <div class="col-lg-12">
                          <div class="form-group">
                                <button  class="btn btn-primary" type="submit" value="Submit">{{__("message.Submit")}}</button>
                          </div>
                       </div>
                </div>
            </div>
        </div>
    </div> --}}

        <input type="hidden" id="path_admin" value="{{ url('/') }}">

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                let table = new DataTable('#myTable', {
                    order: [
                        [0, 'desc']
                    ]
                });
            });


            function getdata(id){
                $("#img").empty();
                $.ajax({
                url: $("#path_admin").val()+"/getdatapharmmacy/"+id,
                data:{},
                success: function( data ) {
                    console.log(data);
                    $("#medicine_id").val(data.id);
                    $("#name").val(data.name);
                    $("#Price").val(data.price);
                    $("#description").val(data.description);
                    if(data.image){
                        $("#img").append("<img class='m-2' src='" + $("#path_admin").val() + "/public/upload/pharmacymedicine/" + data.image + "' style='width: 100px;'><a href='#' onclick='deleteimg(" + id + ")' style='color: red;'> {{ __('message.delete') }}</a>");
                    }

                }
            });
            }

            function deleteimg(id){
                $.ajax({
                url: $("#path_admin").val()+"/deleteimgpharmmacy/"+id,
                data:{},
                success: function( data ) {
                    // console.log(data);
                    if(data == 1){
                        $("#img").hide();
                    }
                }
            });
            }
        </script>

    </section>
@stop
@section('footer')
@stop
