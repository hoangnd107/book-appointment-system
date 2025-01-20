@extends('admin.layout')
@section('title')
    {{ __('message.Medicine') }} | {{ __('Admin Dashboard') }}
@stop
@section('meta-data')
@stop
@section('content')


    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('message.save') }} {{ __('message.Medicine') }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('message.Medicine') }} /
                                </a></li>
                            <li class="active">  {{ __('message.save') }} {{ __('message.Medicine') }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a href="#addproduct-billinginfo-collapse" class="text-dark " data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
                            @if (Session::has('message'))
                                <div class="col-sm-12">
                                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show"
                                        role="alert">
                                        {{ Session::get('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            @endif

                        </a>
                        <form action="{{ route('add') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{-- <div data-repeater-list="outer-group" class="outer"> --}}
                            {{-- <div data-repeater-item class="outer"> --}}
                            {{-- <div class="row"> --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productname">{{ __('message.Medicine') }}
                                        {{ __('message.Name') }}</label>
                                    <input id="medicinename" name="name" type="text" class="form-control"
                                        placeholder=' {{ __('message.Enter') }} {{ __('message.Medicine') }} {{ __('message.Name') }}'required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="price">{{ __('message.Dosage') }}</label>
                                    <input id="dosage" name="dosage" type="text" class="form-control"
                                        placeholder='{{ __('message.Enter') }} your {{ __('message.Dosage') }}' required>
                                    @if ($errors->has('Dosage'))
                                        <span class="text-danger">{{ $errors->first('Dosage') }}</span>
                                    @endif
                                </div>
                            </div>
                            {{-- </div> --}}

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="price">{{ __('message.description') }}</label>
                                    <input id="description" name="description" type="text" class="form-control"
                                        placeholder='{{ __('message.Enter Your Description') }}' required>
                                    @if ($errors->has('Dosage'))
                                        <span class="text-danger">{{ $errors->first('Dosage') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="">{{ __('message.Type') }} {{ __('message.Medicine') }}
                                        :</label>
                                    <div id="showmore">
                                        <div><input type="text" name="type[]" class="form-control"
                                                placeholder='{{ __('message.Enter') }} {{ __('message.Medicine') }} {{ __('message.Type') }}'
                                                required></div><br>
                                    </div>
                                    <a class="btn btn-sm btn-success" id="addmore" style="color: white;">{{ __('message.Add Medicine') }}
                                        {{ __('message.Type') }}</a><br><br>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary ">{{ __('message.Submit') }}</button>
                            {{-- </div> --}}
                            {{-- </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#addmore').click(function() {
                event.preventDefault();
                $('#showmore').append(
                    '<div class="row mb-3"><div class="col-10"><input type="text" name="type[]" class="form-control col-10 " placeholder="" required></div><a href="#" class="remove col-2 p-2  btn btn-icon btn-danger" id="remove">{{ __('message.delete') }}</a></div>'
                );

            });

            $('#showmore').on("click", ".remove", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();

            });
        });
    </script>
@stop
