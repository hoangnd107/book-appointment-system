@extends('admin.layout')
@section('title')
    {{ __('message.Data-Deletion') }} | {{ __('message.Admin Dashboard') }}
@stop
@section('meta-data')
@stop
@section('content')
    <style>
        td.dataTables_empty {
            font-size: medium;
            font-weight: 600;
        }
    </style>

    <div class="container-fluid">
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
                        <h4>{{ __('message.Data-Deletion') }}</h4>
                        <div class="content mt-3">
                            <div class="animated">
                                <div class="col-sm-12">
                                    <div class="modal-content">
                                        <div class="modal-content">
                                            <div class="row m-3">
                                                <div class="col-md-12 col-lg-8 col-xl-11">
                                                    <h6 class="modal-title">{{ url('accountdeletion') }}</h6>
                                                </div>
                                                <div class="col-md-12 col-lg-4 col-xl-1">
                                                    <a href= "{{ url('accountdeletion') }}" class="btn btn-md btn-primary"
                                                        value="Visit" target="#">{{ __('message.Visit') }}</a>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('admin/edit_data_deletion') }}" method="post"
                                                    enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">

                                                        <input type="hidden" class="form-control" id="id"
                                                            name="id" required=""
                                                            value="{{ isset($data->id) ? $data->id : 0 }}">

                                                        <textarea class="form-control" name="data_deletion">{{ isset($data->data_deletion) ? $data->data_deletion : '' }}</textarea>

                                                    </div>
                                                    @if (Session::get('is_demo') == '0')
                                        <button type="button" onclick="disablebtn()"
                                            class="btn btn-primary">{{ __('message.Submit') }}</button>
                                    @else
                                        <button class="btn btn-primary" type="submit"
                                            value="Submit">{{ __('message.Submit') }}</button>
                                    @endif
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
        </div>
    </div>

    <script src="{{ asset('public/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('public/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace('data_deletion');
        });
    </script>
@stop
@section('footer')
@stop
