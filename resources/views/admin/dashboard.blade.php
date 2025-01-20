@extends('admin.layout')
@section('title')
    {{ __('message.Dashboard') }} | {{ __('message.Admin') }} {{ __('message.Dashboard') }}
@stop
@section('meta-data')
@stop
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">{{ __('message.Dashboard') }}</h1>
                    {{-- <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">{{ __('message.Dashboard') }}</li>
                    </ol> --}}
                </div>

                <div class="row mb-3">
                    <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            {{ __('message.New Appointment') }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalappointment }}</div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            {{ __('message.Total Doctors') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totaldoctor }}</div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            {{ __('message.Total Patients') }}
                                        </div>
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalpatient }}</div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            {{ __('message.Total Review') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalreview }}</div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-star fa-2x text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            {{ __('message.Total') }} {{ __('message.Pharmacy') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalpharmacy }}</div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clinic-medical fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            {{ __('message.Pharmacy') }} {{ __('message.Total Order') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalpharmacyorder }}</div>
                                        <div class="mt-2 mb-0 text-muted text-xs">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-bag fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row d-flex align-items-stretch">
                    <!-- Area Chart -->
                    <div class="col-xl-6 col-lg-12 mb-4">
                        <div class="card h-100">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h4>{{ __('message.Monthly_Appointment_Report') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pie Chart -->
                    <div class="col-xl-6 col-lg-12 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4>{{ __('message.Today Appointment') }}</h4>
                                <div class="table-responsive p-3">
                                    <table id="latsrappointmenttable" class="table table-bordered dt-responsive tablels">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>{{ __('message.Id') }}</th>
                                                <th>{{ __('message.Doctor Name') }}</th>
                                                <th>{{ __('message.Patient Name') }}</th>
                                                <th>{{ __('message.DateTime') }}</th>
                                                <th>{{ __('message.Phone') }}</th>
                                                <th>{{ __('message.Status') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mb-4">
                    <!-- Area Chart -->
                    <div class="col-xl-6 col-lg-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h4>{{ __('message.Doctors') }} {{ __('message.List') }}</h4>
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
                    <!-- Pie Chart -->
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>{{__("message.Pharmacy")}} {{__("message.List")}}</h4>
                                <div class="table-responsive p-3">
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
                                                     <img src="{{asset('public/upload/doctors/'.$p->image)}}" width="65px;" alt="">
                                                 </td>
                                                 <td>{{$p->name}}</td>
                                                 <td>{{$p->email}}</td>
                                                 <td>{{$p->phoneno}}</td>
                                                 <td>{{$p->working_time}}</td>
                                                 <td style="display: flex;">
                                                     <a href="{{route('addpharmacy', $p->id)}}" class="px-3 text-primary"><i class="fas fa-edit"></i></a>

                                                     <a href="{{route('deletepharmacy', $p->id)}}" class="px-3 px-3 text-danger"><i class="fas fa-trash">
                                                             </i></a>

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
        </div>
    </div>
    <script src="{{ asset('public/admin') }}/vendor/chart.js/Chart.min.js"></script>
    <script>
        Chart.defaults.global.defaultFontFamily = 'Nunito',
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json(array_values($months)),
                datasets: [{
                    label: "Earnings",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.5)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: @json(array_values($earnings)),
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '$' + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
    </script>
@stop
