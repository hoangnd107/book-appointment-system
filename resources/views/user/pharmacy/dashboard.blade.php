@extends('user.layout')
@section('title')
    {{ __('message.Pharmacy') }} {{ __('message.Dashboard') }}
@stop
@section('meta-data')
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ __('message.System Name') }}" />
    <meta property="og:title" content="{{ __('message.System Name') }}" />
    <meta property="og:image" content="{{ asset('public/image_web/') . '/' . $setting->favicon }}" />
    <meta property="og:image:width" content="250px" />
    <meta property="og:image:height" content="250px" />
    <meta property="og:site_name" content="{{ __('message.System Name') }}" />
    <meta property="og:description" content="{{ __('message.meta_description') }}" />
    <meta property="og:keyword" content="{{ __('message.Meta Keyword') }}" />
    <link rel="shortcut icon" href="{{ asset('public/image_web/') . '/' . $setting->favicon }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')
    <section class="page-title-two">
        <div class="title-box centred bg-color-2">
            <div class="pattern-layer">
                <div class="pattern-1"
                    style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-70.png') }}');">
                </div>
                <div class="pattern-2"
                    style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-71.png') }}');">
                </div>
            </div>
            <div class="auto-container">
                <div class="title">
                    <h1>{{ __('message.Pharmacy') }} {{ __('message.Dashboard') }}</h1>
                </div>
            </div>
        </div>
        <div class="lower-content">
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">{{ __('message.Home') }}</a></li>
                <li>{{ __('message.Pharmacy') }} {{ __('message.Dashboard') }}</li>
            </ul>
        </div>
    </section>
    <section class="doctors-dashboard bg-color-3">
        <div class="left-panel">
            <div class="profile-box">
                <div class="upper-box">
                    <figure class="profile-image">
                        @if ($doctordata->image != '')
                            <img src="{{ asset('public/upload/doctors') . '/' . $doctordata->image }}" alt="">
                        @else
                            <img src="{{ asset('public/upload/doctors/defaultpharmacy.png') }}" alt="">
                        @endif
                    </figure>
                    <div class="title-box centred">
                        <div class="inner">
                            <h3>{{ $doctordata->name }}</h3>
                            <p>{{ isset($doctordata->departmentls) ? $doctordata->departmentls->name : '' }}</p>
                        </div>
                    </div>
                </div>
                <div class="profile-info">
                    <ul class="list clearfix">
                        <li><a href="{{ url('pharmacydashboard') }}" class="current"><i
                                    class="fas fa-columns"></i>{{ __('message.Dashboard') }}</a></li>
                        <li><a href="{{ url('pharmacymedicine') }}"><i
                                    class="fas fa-pills"></i>{{ __('message.Medicine') }}</a></li>
                        <li><a href="{{ url('pharmacyreview') }}"><i
                                    class="fas fa-star"></i>{{ __('message.Reviews') }}</a></li>
                        <li><a href="{{ url('pharmacyeditprofile') }}"><i
                                    class="fas fa-user"></i>{{ __('message.My Profile') }}</a></li>
                        <li><a href="{{ url('pharmacychangepassword') }}"><i
                                    class="fas fa-unlock-alt"></i>{{ __('message.Change Password') }}</a></li>
                        <li><a href="{{ url('logout') }}"><i
                                    class="fas fa-sign-out-alt"></i>{{ __('message.Logout') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="right-panel">
            <div class="content-container">
                <div class="outer-container">
                    <div class="feature-content">
                        <div class="row clearfix">
                            <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                                <div class="feature-block-two">
                                    <div class="inner-box">
                                        <div class="pattern">
                                            <div class="pattern-1"
                                                style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-79.png') }}');">
                                            </div>
                                            <div class="pattern-2"
                                                style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-80.png') }}');">
                                            </div>
                                        </div>
                                        <div class="icon-box"><i class="icon-Dashboard-1"></i></div>
                                        <h3>{{ count($orderdata) }}</h3>
                                        <h5>{{ __('message.Total Order') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                                <div class="feature-block-two">
                                    <div class="inner-box">
                                        <div class="pattern">
                                            <div class="pattern-1"
                                                style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-81.png') }}');">
                                            </div>
                                            <div class="pattern-2"
                                                style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-82.png') }}');">
                                            </div>
                                        </div>
                                        <div class="icon-box"><i class="icon-Dashboard-5"></i></div>
                                        <h3>{{ $totalreview }}</h3>
                                        <h5>{{ __('message.Total Review') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                                <div class="feature-block-two">
                                    <div class="inner-box">
                                        <div class="pattern">
                                            <div class="pattern-1"
                                                style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-83.png') }}');">
                                            </div>
                                            <div class="pattern-2"
                                                style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-84.png') }}');">
                                            </div>
                                        </div>
                                        <div class="icon-box"><i class="icon-Dashboard-3"></i></div>
                                        <h3>{{ $today }}</h3>
                                        <h5>{{ __('message.New Order') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="doctors-appointment">
                        <div class="title-box">
                            <h3>{{ __('message.Medicine Order') }}</h3>
                            <div class="btn-box">

                            </div>
                        </div>
                        <div class="doctors-list  m-3">
                            <div class="table-outer">
                                <table id="myTable">
                                    <thead class="table-header">
                                        <tr>
                                            <th>{{ __('message.Id') }}</th>
                                            <th>{{ __('message.Patients') }} {{ __('message.Name') }}</th>
                                            <th>{{ __('message.Phone') }}</th>
                                            <th>{{ __('message.Order') }} {{ __('message.Type') }}</th>
                                            <th>{{ __('message.Total') }}</th>
                                            <th>{{ __('message.date') }}</th>
                                            <th>{{ __('message.More') }}</th>
                                            <th>{{ __('message.Status') }}</th>
                                            <th>{{ __('message.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderdata as $bdata)
                                            <tr>
                                                <td>{{ $bdata->id }}</td>
                                                <td>{{ $bdata->user_id }} </td>
                                                <td>{{ $bdata->phone }}</td>
                                                <td>
                                                    <?php
                                                    if ($bdata->order_type == '2') {
                                                        echo '<span>' . __('message.Normale') . '</span>';
                                                    } elseif ($bdata->order_type == '1') {
                                                        echo '<span>' . __('message.Prescription') . '</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>{{ $bdata->total }}</td>
                                                <td>{{ $bdata->created_at }}</td>
                                                <td>
                                                    <button onclick="get_orderdata(<?php echo $bdata->id; ?>)"
                                                        class="btn btn-info" data-toggle="modal"
                                                        data-target="#exampleModal">{{ __('message.More') }}</button>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($bdata->status == '0') {
                                                        echo '<span class="status">' . __('message.In Process') . '</span>';
                                                    } elseif ($bdata->status == '1') {
                                                        echo '<span class="status">' . __('message.Accept') . '</span>';
                                                    } elseif ($bdata->status == '2') {
                                                        echo '<span class="status">' . __('message.Rejected') . '</span>';
                                                    } elseif ($bdata->status == '3') {
                                                        echo '<span class="status">' . __('message.Completed') . '</span>';
                                                    } elseif ($bdata->status == '4') {
                                                        echo '<span class="status">' . __('message.waiting') . '</span>';
                                                    } elseif ($bdata->status == '5') {
                                                        echo '<span class="status">' . __('message.estimated') . '</span>';
                                                    } elseif ($bdata->status == '6') {
                                                        echo '<span class="status">' . __('message.Cancel') . '</span>';
                                                    } elseif ($bdata->status == '7') {
                                                        echo '<span class="status">' . __('message.Prepared') . '</span>';
                                                    } elseif ($bdata->status == '8') {
                                                        echo '<span class="status">' . __('message.Out for Delivery') . '</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    @if ($bdata->status == '0')
                                                        <a href="{{ url('pharmacyorderchangestatus/' . $bdata->id . '/' . '1') }}"
                                                            class="btn btn-success">{{ __('message.Accept') }}</a>
                                                        <a href="{{ url('pharmacyorderchangestatus/' . $bdata->id . '/' . '2') }}"
                                                            class="btn btn-danger">{{ __('message.Reject') }}</a>
                                                    @elseif ($bdata->status == '4')
                                                        <a href="{{ url('pharmacyorderchangestatus/' . $bdata->id . '/' . '7') }}"
                                                            class="btn btn-primary">{{ __('message.Prepared') }}</a>
                                                    @elseif ($bdata->status == '1' && $bdata->order_type == '2')
                                                        <a href="{{ url('pharmacyorderchangestatus/' . $bdata->id . '/' . '7') }}"
                                                            class="btn btn-primary">{{ __('message.Prepared') }}</a>
                                                    @elseif ($bdata->status == '7')
                                                        <a href="{{ url('pharmacyorderchangestatus/' . $bdata->id . '/' . '8') }}"
                                                            class="btn btn-primary">{{ __('message.Out for Delivery') }}</a>
                                                    @elseif ($bdata->status == '8')
                                                        <a href="{{ url('pharmacyorderchangestatus/' . $bdata->id . '/' . '3') }}"
                                                            class="btn btn-success">{{ __('message.Completed') }}</a>
                                                    @elseif ($bdata->status == '1' && $bdata->order_type == '1')
                                                        <a href="{{ url('pharmacyorderchangestatus/' . $bdata->id . '/' . '1') }}"
                                                            onclick="addid({{ $bdata->id }})" class="btn btn-warning"
                                                            style="color: white;" data-toggle="modal"
                                                            data-target="#addprice">{{ __('message.Add') }}
                                                            {{ __('message.Price') }}</a>
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

        <!-- Modal -->
        <div class="modal fade" id="addprice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('message.Add') }} {{ __('message.Price') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="{{ url('addprice') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" id="idnew" value="">
                            <div class="form-group">
                                <label for="exampleInputPassword1">{{ __('message.Price') }}</label>
                                <input type="text" class="form-control" id="exampleInputPrice1" name="price"
                                    placeholder="{{ __('message.Add') }} {{ __('message.Price') }}">
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('message.Submit') }}"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> {{ __('message.Doctor Details') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="m_data">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="path_admin" value="{{ url('/') }}">

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                let table = new DataTable('#myTable', {
                    order: [
                        [0, 'desc']
                    ]
                });
            });
        </script>
        <script>
            function addid(id) {
                $('#idnew').val(id);
            }

            function get_orderdata(id) {
                $("#m_data").empty();
                $.ajax({

                    url: $("#path_admin").val() + "/get_orderdata" + "/" + id,
                    data: {},
                    success: function(data) {
                        console.log(data);
                        // Access order details
                        var orderDetails = data[1];
                        console.log("Order Details:", orderDetails);

                        // Access order data
                        var orderData = data[0];
                        console.log("Order Data:", orderData);

                        var currency = data[2];
                        console.log("currency Data:", currency);

                        // Detecting if the language is RTL or LTR
                        var aaa = {{ __('message.RTL') }};
                        if (aaa == 0) {
                            var isRTL = 1;
                        } else {
                            var isRTL = 0;
                        }

                        // Example: Displaying order details dynamically for RTL and LTR
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Order ID') }}" + ": </b>" + orderDetails.id + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Name') }}" + ": </b>" + orderDetails.user_id + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Phone') }}" + ": </b>" + orderDetails.phone + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Address') }}" + ": </b>" + orderDetails.address + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Note') }}" + ": </b>" + orderDetails.message + "</p>");

                        if (orderDetails.payment_type != null) {
                            $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                                "{{ __('message.Payment Type') }}" + ": </b>" + orderDetails.payment_type +
                                "</p>");
                        }

                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Pharmacy') }} {{ __('message.Name') }}" + ": </b>" + orderDetails
                            .Pharmacy_id + "</p><hr>");

                        if (orderDetails.order_type == 2) {
                            var subtotal = 0;
                            orderData.forEach(function(item) {
                                subtotal += item.qty * item.price;

                                var itemHTML =
                                    '<div class="col-12" style="border-bottom:1px solid #e5e7ec; direction: ' +
                                    (isRTL ? "rtl" : "ltr") + ';">' +
                                    '<p><b>' + item.name + '</b></p>' +
                                    '<div class="row">' +
                                    '<div class="col-4">' +
                                    '<p>{{ __('message.Price') }}: ' + item.price + currency[1] + '</p>' +
                                    '</div>' +
                                    '<div class="col-4" style="text-align: center;">' +
                                    '<p>{{ __('message.Qty') }}: ' + item.qty + '</p>' +
                                    '</div>' +
                                    '<div class="col-4" style="display: inline; text-align: ' + (isRTL ?
                                        "left" : "right") + ';">' +
                                    '<p>{{ __('message.Total') }}: ' + (item.qty * item.price) + currency[
                                        1] + '</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                                $('#m_data').append(itemHTML);
                            });

                            // Display total amounts dynamically based on RTL or LTR
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'>{{ __('message.Sub Total') }}: " + subtotal + currency[1] + "</p>");
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'>{{ __('message.Delivery Charge') }}: " + orderDetails
                                .delivery_charge + currency[1] + "</p>");
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'>{{ __('message.Tax') }}: " + orderDetails.tax + currency[1] + "</p>");

                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'>{{ __('message.Total') }}: " + orderDetails.total + currency[1] +
                                "</p>");
                        } else {
                            // Handle prescription image
                            $('#m_data').append('<img src="' + $("#path_admin").val() +
                                '/public/upload/orderprescription/' + orderDetails.prescription +
                                '" style="width: 100%; direction: ' + (isRTL ? "rtl" : "ltr") + ';">');
                        }

                    }
                });
            }
        </script>
    </section>
@stop
@section('footer')
@stop
