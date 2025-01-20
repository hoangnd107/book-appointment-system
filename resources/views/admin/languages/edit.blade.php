@extends('admin.layout')
@section('title')
    {{ __('message.Languages_Translation') }}
@stop
@section('meta-data')
@stop
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">{{ __('message.Languages_Translation') }}</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">{{ __('message.Languages_Translation') }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;justify-content: center;">
                    <div class="col-md-12 col-lg-6">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h1>{{ __('message.Edit') }} ({{ strtoupper($lang) }})</h1>

                                <form action="{{ route('languages.update', ['lang' => $lang, 'key' => $key]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="key">{{ __('message.Key') }}</label>
                                        <input type="text" name="key" id="key" class="form-control"
                                            value="{{ $key }}" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="value">{{ __('message.Value') }}</label>
                                        <input type="text" name="value" id="value" class="form-control"
                                            value="{{ $value }}" required>
                                    </div>
                                    @if (Session::get('is_demo') == '0')
                                        <button type="button" onclick="disablebtn()"
                                            class="btn custom-btn">{{ __('message.Submit') }}</button>
                                    @else
                                        <button class="btn custom-btn" type="submit"
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

@stop
@section('footer')
@stop
