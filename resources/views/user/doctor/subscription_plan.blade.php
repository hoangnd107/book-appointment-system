@extends('user.layout')
@section('title')
    {{ __('message.purchase plan') }}
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
    <section class="page-title centred bg-color-1">
        <div class="pattern-layer">
            <div class="pattern-1" style="background-image: url(assets/images/shape/shape-70.png);"></div>
            <div class="pattern-2" style="background-image: url(assets/images/shape/shape-71.png);"></div>
        </div>
        <div class="auto-container">
            <div class="content-box">
                <div class="title">
                    <h1>{{ __('message.purchase plan') }}</h1>
                </div>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ url('/') }}">{{ __('message.Home') }}</a></li>
                    <li>{{ __('message.purchase plan') }}</li>
                </ul>
            </div>
        </div>
    </section>
    <style>
        ul.features {
            list-style-type: none;
            text-align: left;
            margin-left: 10px;

            li {
                margin: 8px;

                .fas {
                    margin-right: 4px;
                }

                .fa-check-circle {
                    color: #f7c196;
                }

                .fa-times-circle {
                    color: #eb4d4b;
                }
            }
        }

        .custom-check-box {
            border: 1px solid #e5e7ec;
            margin-bottom: 10px;
            padding: 5px;
            padding-left: 20px;
            padding-top: 10px;
            border-radius: 10px;
        }

        .custom-check-box .custom-control.material-checkbox .material-control-indicator {
            background: #e5e7ec;
            width: 15px;
            height: 15px;
            top: 7px;
        }
    </style>
    <section class="category-section bg-color-3 centred">
        <div class="pattern-layer">
            <div class="pattern-1"
                style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-47.png') }}');"></div>
            <div class="pattern-2"
                style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-48.png') }}');"></div>
        </div>
        <div class="auto-container">
            {{-- <div class="sec-title centred">
              <p>{{__('message.Category')}}</p>
              <h2>{{__('message.Browse by specialist')}}</h2>
           </div> --}}
           @if (Session::has('message'))
           <div class="col-sm-12">
               <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show"
                   role="alert">
                   {{ Session::get('message') }}
                   <button type="button" class="close" data-dismiss="alert"
                       aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
           </div>
       @endif
            <div class="row clearfix">
                @foreach ($subscription as $subscription)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 category-block">
                        <div class="category-block-one wow fadeInUp animated animated animated" data-wow-delay="00ms"
                            data-wow-duration="1500ms"
                            style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                            <div class="inner-box">
                                <div class="pattern">
                                    <div class="pattern-1"
                                        style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-45.png') }}');">
                                    </div>
                                    <div class="pattern-2"
                                        style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-46.png') }}');">
                                    </div>
                                </div>
                                <h3>${{ $subscription->price }}/{{ $subscription->month }} {{ __('message.month') }}</h3>
                                <ul class="features">
                                    <li><i class="fas fa-check-circle"></i> Save 50% Off</li>
                                    <li><i class="fas fa-check-circle"></i> Save 50% Off</li>
                                    <li><i class="fas fa-check-circle"></i> Save 50% Off</li>
                                </ul>
                                <div class="link"><a href="#" data-toggle="modal" data-target="#add_plan"
                                        onclick="get_plan_id({{ $subscription->id }},{{ $subscription->price }})">
                                        @if ($setting->is_rtl == '1')
                                            <i class="icon-Arrow-Left"></i>
                                        @else
                                            <i class="icon-Arrow-Right"></i>
                                        @endif

                                    </a></div>
                                <div class="btn-box"><a href="#" data-toggle="modal" data-target="#add_plan"
                                        onclick="get_plan_id({{ $subscription->id }},{{ $subscription->price }},{{ $subscription->month }})"
                                        class="theme-btn-one">{{ __('Purchase') }}<i class="icon-Arrow-Right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="modal fade" id="add_plan" tabindex="-1" aria-labelledby="exampleModalgridLabel">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalgridLabel">
                        {{ __('message.purchase plan') }}
                    </h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row mx-1">
                        <div class="col-6">
                            <h5>{{ $doctor_id->name }}</h5>
                        </div>
                        <div class="col-6">
                            <h5>{{ __('message.Plan Details') }} :</h5>
                            <p><b id="pland"></b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="choose-service">
                            <div class="row m-3">
                                <div class="col-12 my-2">
                                    <h5>{{ __('message.Select paymet Type') }}</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-check-box">
                                        <div class="custom-controls-stacked">
                                            <label class="custom-control material-checkbox">
                                                <input type="radio" class="material-control-input" name="payment_type"
                                                    id="payment_type_stripe" value="2"
                                                    onchange="changeform(this.value)">
                                                <span class="material-control-indicator"></span>
                                                <span class="description">{{ __('message.Stripe') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-check-box">
                                        <div class="custom-controls-stacked">
                                            <label class="custom-control material-checkbox">
                                                <input type="radio" class="material-control-input" name="payment_type"
                                                    id="payment_type_rave" value="4"
                                                    onchange="changeform(this.value)">
                                                <span class="material-control-indicator"></span>
                                                <span class="description">{{ __('message.Rave') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-check-box">
                                        <div class="custom-controls-stacked">
                                            <label class="custom-control material-checkbox">
                                                <input type="radio" class="material-control-input" name="payment_type"
                                                    id="payment_type_braintree" value="1"
                                                    onchange="changeform(this.value)">
                                                <span class="material-control-indicator"></span>
                                                <span class="description">{{ __('message.Braintree') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-check-box">
                                        <div class="custom-controls-stacked">
                                            <label class="custom-control material-checkbox">
                                                <input type="radio" class="material-control-input" name="payment_type"
                                                    id="payment_type_razorpay" value="6"
                                                    onchange="changeform(this.value)">
                                                <span class="material-control-indicator"></span>
                                                <span class="description">{{ __('message.Razorpay') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-check-box">
                                        <div class="custom-controls-stacked">
                                            <label class="custom-control material-checkbox">
                                                <input type="radio" class="material-control-input" name="payment_type"
                                                    id="payment_type_paystack" value="7"
                                                    onchange="changeform(this.value)">
                                                <span class="material-control-indicator"></span>
                                                <span class="description">{{ __('message.Paystack') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                            <div class="text-center">
                                @if (Session::has('user_id'))
                                    <button class="theme-btn-one centred" type="button" id="show_book"
                                        onclick="bookshow()">{{ __('message.Pay') }}<i
                                            class="icon-Arrow-Right"></i></button>
                                @else
                                    <button type="button" class="theme-btn-one" onclick="pleaselogin()"
                                        id="show_book">{{ __('message.Pay') }}<i class="icon-Arrow-Right"></i></button>
                                @endif
                            </div>
                            <div id="braintree_div" style="display:none;">
                                <form action="{{ url('doctor_add_plan') }}" method="post" id="payment-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="doctor_id" id="doctor_id" value="{{ $doctor_id->id }}">
                                    <input type="hidden" name="payment_type" value="braintree">
                                    <input type="hidden" name="plan_id" id="plan_id_braintree" value="">
                                    <input type="hidden" name="amount" id="plan_price_braintree" value="">
                                    <div class="bt-drop-in-wrapper mx-5">
                                        <div id="bt-dropin"></div>
                                    </div>
                                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                                    <div class="btn-box ml-5" id="btnappointment">
                                        @if (Session::has('user_id'))
                                            <button class="theme-btn-one" type="submit">{{ __('message.Pay') }}<i
                                                    class="icon-Arrow-Right"></i></button>
                                        @else
                                            <button type="button" class="theme-btn-one"
                                                onclick="pleaselogin()">{{ __('message.Pay') }}<i
                                                    class="icon-Arrow-Right"></i></button>
                                        @endif
                                    </div>
                                </form>
                            </div>

                            <div id="stripe_div" style="display:none;">
                                {{-- <form action="{{ url('doctor_add_plan') }}" method="post" id="stripe-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="payment_type" value="stripe">
                                    <input type="hidden" name="doctor_id" id="doctor_id" value="{{ $doctor_id->id }}">
                                    <input type="hidden" name="plan_id" id="plan_id_stripe" value="">
                                    <input type="hidden" name="amount" id="plan_price_stripe" value="">
                                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="{{ $paymentdetail['stripe_public_key'] }}" data-amount="" data-id="stripid"
                                        data-name="{{ __('message.System Name') }}" data-label="{{ __('message.Pay') }}" data-description=""
                                        data-image="{{ asset('public/image_web/') . '/' . $setting->logo }}" data-locale="auto"></script>
                                </form> --}}
                                <button class="theme-btn-one" type="submit"
                                    onclick="stripe()">{{ __('message.Pay') }}<i class="icon-Arrow-Right"></i></button>
                            </div>



                            <div id="rave_div" style="display:none;">
                                <form action="{{ url('doctor_add_plan') }}" method="post" id="payment-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="doctor_id" id="doctor_id" value="{{ $doctor_id->id }}">
                                    <input type="hidden" name="payment_type" value="Flutterwave">
                                    <input type="hidden" name="plan_id" id="plan_id_rave" value="">
                                    <input type="hidden" name="amount" id="plan_price_rave" value="">
                                    <div class="bt-drop-in-wrapper">
                                        <div id="bt-dropin"></div>
                                    </div>
                                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                                    <div class="btn-box" id="btnappointment">
                                        @if (Session::has('user_id'))
                                            <button class="theme-btn-one" type="submit">{{ __('message.Pay') }}<i
                                                    class="icon-Arrow-Right"></i></button>
                                        @else
                                            <button type="button" class="theme-btn-one"
                                                onclick="pleaselogin()">{{ __('message.Pay') }}<i
                                                    class="icon-Arrow-Right"></i></button>
                                        @endif
                                    </div>
                                </form>
                            </div>

                            <div id="razorpay_div" style="display:none;">
                                <button class="theme-btn-one" type="submit"
                                    onclick="razorpay()">{{ __('message.Pay') }}<i class="icon-Arrow-Right"></i></button>
                            </div>

                            <div id="paystack_div" style="display:none;">
                                <form action="{{ url('doctor_add_plan') }}" method="post" id="payment-form">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="doctor_id" id="doctor_id" value="{{ $doctor_id->id }}">
                                    <input type="hidden" name="consultation_fees" value="">
                                    <input type="hidden" name="payment_type" value="Paystack">
                                    <input type="hidden" name="plan_id" id="plan_id_paystack" value="">
                                    <input type="hidden" name="amount" id="plan_price_paystack" value="">
                                    <div class="bt-drop-in-wrapper">
                                        <div id="bt-dropin"></div>
                                    </div>
                                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                                    <div class="btn-box" id="btnappointment">
                                        @if (Session::has('user_id'))
                                            <button class="theme-btn-one" type="submit">{{ __('message.Pay') }}<i
                                                    class="icon-Arrow-Right"></i></button>
                                        @else
                                            <button type="button" class="theme-btn-one"
                                                onclick="pleaselogin()">{{ __('message.Pay') }}<i
                                                    class="icon-Arrow-Right"></i></button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="web_path" value="{{ url('/') }}">
    <input type="hidden" name="plan_id" id="plan_id" value="">
    <input type="hidden" name="plan_price" id="plan_price" value="">
    <script src="https://js.braintreegateway.com/web/dropin/1.23.0/js/dropin.min.js"></script>
    <script type="text/javascript">
        document.querySelector('.show-btn').addEventListener('click', function() {
            document.querySelector('.sm-menu').classList.toggle('active');
        });
    </script>
    <script>
        function razorpay() {
            var plan_id = $("#plan_id").val();
            var plan_price = $("#plan_price").val();
            var webPath = $('#web_path').val();
            var url = webPath + '/doctor_subscription_payment?plan_id=' + encodeURIComponent(plan_id) + '&payment_type=3';;
            // Redirect to the constructed URL
            window.location.href = url;
        }

        function stripe() {
            var plan_id = $("#plan_id").val();
            var plan_price = $("#plan_price").val();
            var webPath = $('#web_path').val();
            var url = webPath + '/doctor_subscription_payment?plan_id=' + encodeURIComponent(plan_id) + '&payment_type=5';;
            // Redirect to the constructed URL
            window.location.href = url;
        }

        function get_plan_id(id, price, month) {
            var plan_id = $("#plan_id").val(id);
            var plan_price = $("#plan_price").val(price);
            $("#pland").text("$" + price + "/" + month + " month");

            $("#payment_type_braintree").prop("checked", false);
            $("#payment_type_stripe").prop("checked", false);
            $("#payment_type_rave").prop("checked", false);
            $("#payment_type_razorpay").prop("checked", false);
            $("#payment_type_paystack").prop("checked", false);

            $("#razorpay_div").css("display", "none");
            $("#braintree_div").css("display", "none");
            $("#stripe_div").css("display", "none");
            $("#rave_div").css("display", "none");
            $("#show_book").css("display", "block");
            $("#paystack_div").css("display", "none");
        }

        function changeform(val) {

            var plan_id = $("#plan_id").val();
            var plan_price = $("#plan_price").val();
            var slot = $('input[name="slot"]:checked').val();
            console.log(slot);
            // if (slot !== undefined) {
            if ($("#payment_type_braintree").prop("checked") == true) {
                $("#braintree_div").css("display", "block");
                $("#stripe_div").css("display", "none");
                $("#razorpay_div").css("display", "none");
                $("#rave_div").css("display", "none");
                $("#show_book").css("display", "none");
                $("#paystack_div").css("display", "none");
                $("#plan_id_braintree").val(plan_id);
                $("#plan_price_braintree").val(plan_price);
            }
            if ($("#payment_type_stripe").prop("checked") == true) {
                $("#stripe_div").css("display", "block");
                $("#braintree_div").css("display", "none");
                $("#razorpay_div").css("display", "none");
                $("#rave_div").css("display", "none");
                $("#show_book").css("display", "none");
                $("#paystack_div").css("display", "none");
                $("#plan_id_stripe").val(plan_id);
                $("#plan_price_stripe").val(plan_price);
                // $(".stripe-button").attr("data-amount", plan_price * 100);
            }
            if ($("#payment_type_rave").prop("checked") == true) {
                $("#rave_div").css("display", "block");
                $("#braintree_div").css("display", "none");
                $("#stripe_div").css("display", "none");
                $("#razorpay_div").css("display", "none");
                $("#show_book").css("display", "none");
                $("#paystack_div").css("display", "none");
                $("#plan_id_rave").val(plan_id);
                $("#plan_price_rave").val(plan_price);
            }
            if ($("#payment_type_razorpay").prop("checked") == true) {
                $("#razorpay_div").css("display", "block");
                $("#braintree_div").css("display", "none");
                $("#stripe_div").css("display", "none");
                $("#rave_div").css("display", "none");
                $("#show_book").css("display", "none");
                $("#paystack_div").css("display", "none");
                $("#plan_id_razorpay").val(plan_id);
                $("#plan_price_razorpay").val(plan_price);
            }
            if ($("#payment_type_paystack").prop("checked") == true) {
                $("#razorpay_div").css("display", "none");
                $("#braintree_div").css("display", "none");
                $("#stripe_div").css("display", "none");
                $("#rave_div").css("display", "none");
                $("#show_book").css("display", "none");
                $("#paystack_div").css("display", "block");
                $("#plan_id_paystack").val(plan_id);
                $("#plan_price_paystack").val(plan_price);
            }
            // } else {
            //     alert("Please Fillup All Field");
            //     $("#payment_type_braintree").prop("checked", false);
            //     $("#payment_type_stripe").prop("checked", false);
            //     $("#payment_type_cod").prop("checked", false);
            //     $("#payment_type_rave").prop("checked", false);
            //     $("#payment_type_paytm").prop("checked", false);
            //     $("#payment_type_razorpay").prop("checked", false);
            //     $("#payment_type_paystack").prop("checked", false);

            // }
        }

        function bookshow() {
            var slot = $('input[name="slot"]:checked').val();
            console.log(slot);
            if (slot == undefined) {
                alert("please choose payment type");
            }
        }

        var form = document.querySelector('#payment-form');
        var client_token = "{{ $token }}";

        braintree.dropin.create({
            authorization: client_token,
            selector: '#bt-dropin',
            paypal: {
                flow: 'vault'
            }
        }, function(createErr, instance) {
            if (createErr) {
                console.log('Create Error', createErr);
                return;
            }
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        console.log('Request Payment Method Error', err);
                        return;
                    }
                    document.querySelector('#nonce').value = payload.nonce;
                    form.submit();
                });
            });
        });
    </script>


@stop
@section('footer')
@stop
