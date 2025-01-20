@extends('admin.layout')
@section('title')
    {{ __('message.Doctors') }} | {{ __('message.Admin') }} {{ __('message.Doctors') }}
@stop
@section('meta-data')
@stop
@section('content')
    <div class="container-fluid mb-4">
        {{-- <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('message.Doctors') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">{{ __('message.Doctors') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (Session::has('message'))
                            <div class="col-sm-12">
                                <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show"
                                    role="alert">{{ Session::get('message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <h4 class="card-title float-left">{{ __('message.Doctors') }} {{ __('message.List') }}</h4>
                        <p><a class="btn btn-primary float-right"
                                href="{{ url('admin/savedoctor/0') }}">{{ __('message.Add Doctor') }}</a></p>
                        <div class="table-responsive p-3">
                            <table id="doctorstable" class="table table-bordered dt-responsive tablels">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ __('message.Id') }}</th>
                                        <th>{{ __('message.Image') }}</th>
                                        <th>{{ __('message.Name') }}</th>
                                        <th>{{ __('message.Email') }}</th>
                                        <th>{{ __('message.Phone') }}</th>
                                        <th>{{ __('message.Service') }}</th>
                                        <th>{{ __('message.Action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
