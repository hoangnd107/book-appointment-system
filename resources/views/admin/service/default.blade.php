@extends('admin.layout')
@section('title')
{{__("message.specialities")}} | {{__("message.Admin")}} {{__("message.specialities")}}
@stop
@section("meta-data")
@stop
@section("content")
<div class="main-content">
   <div class="page-content">
      <div class="container-fluid mb-4">
         <div class="row">
            <div class="col-12">
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
                     <h4 class="card-title float-left">{{__("message.specialities")}} {{__("message.List")}}</h4>
                     <p><a class="btn btn-primary float-right" href="{{url('admin/saveservices/0')}}">{{__("message.Add")}} {{__("message.specialities")}}</a></p>
                     <div class="table-responsive p-3">
                     <table id="servicestable" class="table table-bordered dt-responsive tablels">
                        <thead class="thead-light">
                           <tr>
                              <th>{{__("message.Id")}}</th>
                              <th>{{__("message.Icon")}}</th>
                              <th>{{__("message.Name")}}</th>
                              <th>{{__("message.Action")}}</th>
                           </tr>
                        </thead>
                     </table>
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
