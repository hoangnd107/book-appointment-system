@extends('admin.layout')
@section('title')
    {{ __('message.Medicine') }} | {{ __('Admin Dashboard') }}
@stop
@section('meta-data')
@stop
@section('content')
    <div class="container-fluid mb-4">
        <!-- end page title -->
        @if (Session::has('message'))
            <div class="col-sm-12">
                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show"
                    role="alert">
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
                            <div>
                                <h4 class="card-title float-left">{{ __('message.Medicine') }} {{ __('message.List') }}</h4>
                                <a href="{{ url('admin/medicinesadd') }}" type="button"
                                    class="btn btn-primary waves-effect waves-light mb-3 float-right"><i
                                        class="fas fa-user-plus"></i>{{ __('message.Add Medicine') }}</a>
                            </div>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered dt-responsive tablels"
                                    id="medicine" style="border-collapse: collapse; width: 100%;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 120px;">{{ __('message.Id') }} </th>
                                            <th>{{ __('message.Name') }} </th>
                                            <th>{{ __('message.Dosage') }} </th>
                                            <th>{{ __('message.description') }} </th>
                                            <th>{{ __('message.Medicine') }} {{ __('message.Type') }} </th>
                                            <th style="width: 120px;">{{ __('message.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $user)
                                            <tr>

                                                <td><a href="javascript: void(0);"
                                                        class="text-reset  fw-bold">{{ $user->id }}</a> </td>

                                                {{-- <td>
                                                <img src="{{asset('public/upload/medicine/'.$user->image)}}" alt="" class="avatar-xs rounded-circle me-2" style="height: 4.2rem; width: 4.2rem;">
                                            </td> --}}
                                                <td>
                                                    <span>{{ $user->name }}</span>
                                                </td>
                                                <td>{{ $user->dosage }}</td>
                                                <td>{{ $user->description }}</td>
                                                <td>{{ $user->medicine_type }}</td>
                                                <td>
                                                    <a href="{{ route('editmedicines', $user->id) }}"
                                                        class="px-3 text-primary"><i class="fas fa-edit"></i></a>

                                                    <a href="{{ route('deletemedicines', $user->id) }}"
                                                        class="px-3 px-3 text-danger"><i class="fas fa-trash">
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
        <!-- end row -->
    </div> <!-- container-fluid -->
@stop
