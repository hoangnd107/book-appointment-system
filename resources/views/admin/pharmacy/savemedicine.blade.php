@extends('admin.layout')
@section('title')
    {{ __('message.save') }} {{ __('message.Pharmacy') }} | {{ __('message.Admin') }} {{ __('message.Pharmacy') }}
@stop
@section('meta-data')
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('message.save') }} {{ __('message.Pharmacy') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('admin/Pharmacy') }}">{{ __('message.Pharmacy') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('message.save') }} {{ __('message.Pharmacy') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="display: flex;justify-content: center;">
            <div class="col-xl-8 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('admin/updatemedicine') }}" class="needs-validation" method="post"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="pharmacy_id" id="pharmacy_id" value="{{ $pharmacy_id }}">
                            <input type="hidden" name="medicine_id" id="medicine_id" value="{{ $medicine_id }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="mar20">
                                            <div id="uploaded_image">
                                                <div class="upload-btn-wrapper">
                                                    <button type="button" class="btn imgcatlog">
                                                        <input type="hidden" name="real_basic_img" id="real_basic_img"
                                                            value="<?= isset($data->image) ? $data->image : '' ?>" />
                                                        <?php
                                                        if (isset($data->image)) {
                                                            $path = asset('public/upload/pharmacymedicine') . '/' . $data->image;
                                                        } else {
                                                            $path = asset('public/upload/pharmacymedicine/medicine.png');
                                                        }
                                                        ?>
                                                        <img src="{{ $path }}" alt="..."
                                                            class="img-thumbnail imgsize" id="basic_img" width="150px;">
                                                    </button>
                                                    <input type="hidden" name="basic_img" id="basic_img1" />
                                                    <input type="file" name="upload_image" id="upload_image" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('message.Name') }}<span
                                                class="reqfield">*</span></label>
                                        <input type="text" class="form-control"
                                            placeholder=' {{ __('message.Enter') }} {{ __('message.Medicine') }} {{ __('message.Name') }}'
                                            id="name" name="name" required=""
                                            value="<?= isset($data->name) ? $data->name : '' ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">{{ __('message.Price') }}<span
                                                class="reqfield">*</span></label>
                                        <input type="text" class="form-control" id="Price"
                                            placeholder='{{ __('message.Enter') }} {{ __('message.Price') }}'
                                            name="price" required=""
                                            value="<?= isset($data->price) ? $data->price : '' ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">{{ __('message.description') }}<span
                                                class="reqfield">*</span></label>
                                        <textarea id="description" class="form-control" rows="5" placeholder='{{ __('message.Enter Your Description') }}'
                                            name="description" required="">{{ isset($data->description) ? $data->description : '' }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                            </div>




                            <div class="row">
                                <div class="form-group">
                                    @if (Session::get('is_demo') == '0')
                                        <button type="button" onclick="disablebtn()"
                                            class="btn btn-primary">{{ __('message.Submit') }}</button>
                                    @else
                                        <button class="btn btn-primary" type="submit"
                                            value="Submit">{{ __('message.Submit') }}</button>
                                    @endif

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
