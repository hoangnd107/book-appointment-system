@extends('admin.layout')
@section('title')
{{__("message.Pharmacy")}}
@stop
@section('meta-data')
@stop
@section('content')


    <div class="container-fluid mb-4" >
        <!-- end page title -->
        @if(Session::has('message'))
            <div class="col-sm-12">
                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
                    <i class="uil uil-check me-2"></i>
                    {{ Session::get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            </div>
         @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="card-title float-left">{{__("message.Pharmacy")}} {{__("message.List")}}</h4>
                            <p><a href="{{url('admin/addpharmacy/0')}}" type="button" class="btn btn-primary waves-effect waves-light mb-3 float-right">{{__("message.Add")}} {{__("message.Pharmacy")}}</a></p>
                            <div class="table-responsive mb-4">
                               <table class="table table-bordered dt-responsive tablels" id="dataTable" style="border-collapse: collapse; width: 100%;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{__("message.Id")}}</th>
                                            <th>{{__("message.Image")}}</th>
                                            <th>{{__("message.Name")}}</th>
                                            <th>{{__("message.Email")}}</th>
                                            <th>{{__("message.Phone")}}</th>
                                            <th>{{__("message.Working Time")}}</th>
                                            <th>{{__("message.Action")}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($pharmacy as $p)
                                        <tr>
                                            <td>{{$p->id}}</td>
                                            <td>
                                                <img src="{{asset('public/upload/doctors/'.$p->image)}}" width="60px;" alt="">
                                            </td>
                                            <td>{{$p->name}}</td>
                                            <td>{{$p->email}}</td>
                                            <td>{{$p->phoneno}}</td>
                                            <td>{{$p->working_time}}</td>
                                            <td>
                                                <a href="{{route('addpharmacy', $p->id)}}" class="px-3"><i class="fas fa-edit"></i></a>

                                                 @if (Session::get('is_demo') == '0')
                                                    <a href="#" onclick="disablebtn()" class="px-3 px-3 text-danger"><i class="fas fa-trash">
                                                    </i></a>
                                            @else
                                            <a href="{{route('deletepharmacy', $p->id)}}" class="px-3 px-3 text-danger"><i class="fas fa-trash">
                                            </i></a>
                                            @endif

                                                <a href="{{route('medicine',$p->id)}}" class="px-3 px-3 btn btn-secondary">{{__("message.Medicine")}}</a>
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
        <!-- end row -->
    </div> <!-- container-fluid -->
@stop
