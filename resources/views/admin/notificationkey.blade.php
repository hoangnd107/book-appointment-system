@extends('admin.layout')
@section('title')
{{__("message.Edit Notification Key")}} | {{__("message.Admin")}}
@stop
@section('meta-data')
@stop
@section('content')
<div class="main-content">
   <div class="page-content">
      <div class="container-fluid">
         <div class="row" style="display: flex;justify-content: center;">
            <div class="col-xl-12 col-md-12">
               <div class="card">
                  <div class="card-body">
                     @if(Session::has('message'))
                     <div class="col-sm-12">
                        <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                     </div>
                     @endif
                     <h4>{{__("message.Edit Notification Key")}}</h4>
                     <div class="row" style="display: flex;justify-content: center;">
                        <div class="col-xl-8 col-md-12 border p-4">
                     <form action="{{url('admin/updatenotificationkey')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{-- <div class="form-group">
                           <label for="formrow-firstname-input">{{__("message.Android Key")}}</label>
                           <textarea class="form-control" row="5" required name="android_key" id="android_key" placeholder='{{__("message.Enter Android Notification Key")}}' >{{$user->android_key}}
                           </textarea>
                        </div>
                        <div class="form-group">
                           <label for="formrow-firstname-input">{{__("message.Ios Key")}}</label>
                           <textarea class="form-control" row="5" required name="ios_key" id="ios_key" placeholder='{{__("message.nter Ios Notification Key")}}'>{{$user->ios_key}}
                           </textarea>
                        </div> --}}
                        <div class="form-group">
                            <label for="formrow-firstname-input">{{__("message.uploade_json_file")}}</label>
                            <input type="file" class="form-control" required="" id="jsonfile" name="jsonfile">
                         </div>
                         <p><b>{{__("message.uploaded_file_name")}} :</b> {{$user->not_json_filename}}</p>
                        <div class="mt-4">
                           @if(Session::get("is_demo")=='0')
                              <button type="button" onclick="disablebtn()" class="btn btn-primary">{{__('message.Submit')}}</button>
                           @else
                               <button  class="btn btn-primary" type="submit" value="Submit">{{__("message.Submit")}}</button>
                           @endif
                        </div>
                     </form>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@stop
@section('footer')
@stop
