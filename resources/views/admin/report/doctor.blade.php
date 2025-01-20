@extends('admin.layout')
@section('title')
    {{ __('message.Doctor Report') }}
@stop
@section('meta-data')
@stop
@section('content')
    <div class="container-fluid mb-4">
        {{-- <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{ __('message.Doctor Report') }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">{{ __('message.Doctor Report') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">{{ __('message.Doctor Report') }}</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">{{ __('message.Doctor Report') }}</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <form action="doctor_report" method="get">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-12">
                                            <div class="input-group">
                                                <label for="" class="mt-2">{{ __('message.Report') }} : </label>
                                                <select name="data_filter" id="" class="form-control"
                                                    onchange="showDiv('hidden_div', this)">
                                                    <option value="">{{ __('message.All data') }}</option>
                                                    <option value="1"
                                                        {{ Request::get('data_filter') == '1' ? 'selected' : '' }}>
                                                        {{ __('message.custom') }}</option>
                                                    <option value="today"
                                                        {{ Request::get('data_filter') == 'today' ? 'selected' : '' }}>
                                                        {{ __('message.Today') }}</option>
                                                    <option value="last_week"
                                                        {{ Request::get('data_filter') == 'last_week' ? 'selected' : '' }}>
                                                        {{ __('message.Last week') }}</option>
                                                    <option value="this_month"
                                                        {{ Request::get('data_filter') == 'this_month' ? 'selected' : '' }}>
                                                        {{ __('message.This month') }}</option>
                                                    <option value="last_month"
                                                        {{ Request::get('data_filter') == 'last_month' ? 'selected' : '' }}>
                                                        {{ __('message.Last month') }}</option>
                                                    <option value="this_year"
                                                        {{ Request::get('data_filter') == 'this_year' ? 'selected' : '' }}>
                                                        {{ __('message.This year') }}</option>
                                                    <option value="last_year"
                                                        {{ Request::get('data_filter') == 'last_year' ? 'selected' : '' }}>
                                                        {{ __('message.Last year') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if (Request::get('data_filter') == '1')
                                            <div class="col-xl-4 col-lg-12" id="hidden_div">
                                                <div class="input-group">
                                                    <label for="" class="mt-2">{{ __('message.Start Date') }}
                                                        :</label>
                                                    <input type="date" name="start_date"
                                                        value="{{ Request::get('start_date') ?? date('y-m-d') }}"
                                                        class="form-control">

                                                    <label for="" class="mt-2 ml-3"> {{ __('message.End Date') }}
                                                        :</label>
                                                    <input type="date" name="end_date"
                                                        value="{{ Request::get('end_date') ?? date('y-m-d') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-xl-4 col-lg-12" id="hidden_div" style="display: none;">
                                                <div class="input-group">
                                                    <label for="" class="mt-2">{{ __('message.Start Date') }}
                                                        :</label>
                                                    <input type="date" name="start_date" class="form-control">

                                                    <label for="" class="mt-2 ml-3"> {{ __('message.End Date') }}
                                                        :</label>
                                                    <input type="date" name="end_date" class="form-control">
                                                </div>
                                            </div>
                                        @endif
                                        {{-- <div class="col-4" id="hidden_div" style="display: none;">
                                        <div class="input-group">
                                            <label for="" class="mt-2">start date :</label>
                                            <input type="date" name="start_date" value="{{Request::get('start_date') ?? date('y-m-d')}}" class="form-control">

                                              <label for="" class="mt-2 ml-3"> end date :</label>
                                              <input type="date" name="end_date" value="{{Request::get('end_date') ?? date('y-m-d')}}" class="form-control" >
                                        </div>
                                      </div> --}}
                                        <div class="col-2 mt-1">
                                            <input type="submit" class="btn btn-primary"
                                                value="{{ __('message.Submit') }}">
                                        </div>
                                    </div>
                                </form><br>
                            </div>
                        </div>
                        <h4 class="card-title">
                            @if (Request::get('data_filter'))
                                @if ($total == null)
                                    {{ __('message.Doctor not found') }}
                                @else
                                    {{ __('message.Total doctor register are') }} {{ $total }}
                                @endif
                            @else
                                {{-- {{ __('message.Doctors') }} {{ __('message.List') }} --}}
                            @endif
                        </h4>

                        <input type="hidden" name="count_data" value="{{ $total }}" id="count_data">
                        <div class="table-responsive mb-4">
                        <table id="dataTable" class="table table-bordered dt-responsive tablels">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('message.Id') }}</th>
                                    <th>{{ __('message.Image') }}</th>
                                    <th>{{ __('message.Name') }}</th>
                                    <th>{{ __('message.Email') }}</th>
                                    <th>{{ __('message.Phone') }}</th>
                                    <th>{{ __('message.Service') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctors as $doc)
                                    <tr>
                                        <td>{{ $doc->id }}</td>
                                        <td> <img src="{{ asset('public/upload/doctors/') }}/{{ $doc->image }}"
                                                alt="" width="100px;"> </td>
                                        <td>{{ $doc->name }}</td>
                                        <td>{{ $doc->email }}</td>
                                        <td>{{ $doc->phoneno }}</td>
                                        <td>
                                            @if ($doc->departmentls)
                                                {{ $doc->departmentls->name }}
                                            @endif
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


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script>
        function showDiv(divId, element) {
            document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
        }
    </script>
    <script>
        $(document).ready(function() {

            var test = $("#count_data").val();
            if (test > 0) {
                $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    order: [
                        [0, 'desc']
                    ],
                    buttons: [{
                        extend: 'excel',
                        text: '{{ __('message.Download excel') }}'
                    }],
                });
            } else {
                let table = new DataTable('#myTable', {
                    order: [
                        [0, 'desc']
                    ]
                });
            }

        });
    </script>
@stop
@section('footer')

@stop
