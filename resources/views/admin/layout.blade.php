<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{ Session::get('favicon') }}" rel="icon">
    <title>@yield('title')</title>
    <link href="{{ asset('public/admin') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/admin') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    @if (__('message.RTL') == 0)
        <link href="{{ asset('public/admin') }}/vendor/bootstrap/css/bootstrapRTL.min.css" rel="stylesheet"
            type="text/css">
        <style>
            body {
                direction: rtl;
            }

            .sidebar .nav-item .nav-link {
                text-align: right !important;
            }

            .navbar-nav {
                padding: 0px !important;
            }

            .sidebar .sidebar-heading {
                text-align: right !important;
            }

            .navbar-expand .navbar-nav .dropdown-menu-right {
                left: auto !important;
            }
        </style>
    @endif
    <link href="{{ asset('public/admin') }}/css/ruang-admin.min.css" rel="stylesheet">
    <link href="{{ asset('public/admin') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    @php
        $color = app\models\Setting::find(1);
    @endphp
    <style>
        .btn-primary {
            background-color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
            border-color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
        }

        .btn:hover {
            background-color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
            border-color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
        }

        .bg-navbar {
            background-color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }}
        }

        a {
            color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
            text-decoration: none;
            background-color: transparent;
        }

        a:hover {
           color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
        }

        .sidebar-light .sidebar-brand {
            color: #fafafa;
            background-color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
            border-right: 1px solid rgb(163, 157, 157);
        }

        .page-item.active .page-link {
            background-color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
            border-color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
        }

        .page-link {
            color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }}
        }

        .sidebar-light .nav-item.active .nav-link {
            color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
            background-color: #eaecf4;
        }

        .sidebar-light .nav-item.active .nav-link i {
            color: {{ isset($color->admin_theme_color) ? $color->admin_theme_color : '#6777ef' }};
            background-color: #eaecf4;
        }

        #accordionSidebar {
            max-height: 100vh;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        #accordionSidebar::-webkit-scrollbar {
            display: none;
        }

        @media (max-width: 992px) {
            #accordionSidebar {
                max-height: 170vh;
                overflow-y: auto;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
        }

        /* .sidebar {
            width: 18rem !important;
        }

        .sidebar .nav-item .nav-link {
            width: 18rem !important;
        } */


        .sidebar-light .sidebar-heading {
            color: black;
            font-size: 15px;
        }

        .sidebar .nav-item .nav-link span {
            font-size: 17px;
        }

        .breadcrumb {
            font-size: 14px;
        }



        .sidebar .sidebar-brand {
            font-size: 10px;
        }
    </style>

</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ url('admin/dashboard') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ Session::get('logo') }}" style="color: white;background-color: white;">
                </div>


                {{-- <div class="sidebar-brand-text mx-3">{{$title}}</div> --}}
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ __('message.Dashboard') }}</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                {{ __('message.Appointment') }}
            </div>
            <li class="nav-item {{ Request::is('admin/appointment') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/appointment') }}">
                    <i class="fas fa-calendar fa-palette"></i>
                    <span>{{ __('message.Appointment') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/doctors') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/doctors') }}">
                    <i class="fas fa-users fa-palette"></i>
                    <span>{{ __('message.Doctors') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/patients') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/patients') }}">
                    <i class="fas fa-users fa-palette"></i>
                    <span>{{ __('message.Patients') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/services') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/services') }}">
                    <i class="fa fa-adjust"></i>
                    <span>{{ __('message.Department') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/banner') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/banner') }}">
                    <i class="fas fa-fw fa-image"></i>
                    <span>{{ __('message.banner') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/reviews') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/reviews') }}">
                    <i class="fas fa-fw fa-star"></i>
                    <span>{{ __('message.Review') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/complain') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/complain') }}">
                    <i class="fas fa-fw fa-palette"></i>
                    <span>{{ __('message.complain') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/contact_list') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/contact_list') }}">
                    <i class="fas fa-file-contract"></i>
                    <span>{{ __('message.Contact') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/news') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/news') }}">
                    <i class="fas fa-fw fa-palette"></i>
                    <span>{{ __('message.News') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/medicines') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/medicines') }}">
                    <i class="fas fa-fw fa-pills"></i>
                    <span>{{ __('message.Medicine') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/languages/en') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/languages/en') }}">
                    <i class="fas fa-fw fa-language"></i>
                    <span>{{ __('message.Languages_Translation') }}</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                {{ __('message.Pharmacy') }}
            </div>
            <li class="nav-item {{ Request::is('admin/pharmacy') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/pharmacy') }}">
                    <i class="fas fa-clinic-medical"></i>
                    <span>{{ __('message.Pharmacy') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/pharmacyorder') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/pharmacyorder') }}">
                    <i class="fab fa-jedi-order"></i>
                    <span>{{ __('message.Pharmacy Order') }}</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                {{ __('message.Privecy') }}
            </div>
            <li class="nav-item {{ Request::is('admin/about') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/about') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('message.About') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/Terms_condition') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/Terms_condition') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('message.term') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/app_privacy') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/app_privacy') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('message.Privecy') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/data_deletion') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/data_deletion') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('message.Data-Deletion') }}</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                {{ __('message.Reports') }}
            </div>
            <li class="nav-item {{ Request::is('admin/doctor_report') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('doctor_report') }}">
                    <i class="fas fa-address-book"></i>
                    <span>{{ __('message.Doctors') }} </span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/user_report') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user_report') }}">
                    <i class="fas fa-address-book"></i>
                    <span>{{ __('message.Patients') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/do_sub_report') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('do_sub_report') }}">
                    <i class="fas fa-address-book"></i>
                    <span>{{ __('message.Doctor Subscription') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/app_book_report') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('app_book_report') }}">
                    <i class="fas fa-address-book"></i>
                    <span>{{ __('message.Appointment booked') }}</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                {{ __('message.Payment') }}
            </div>
            <li class="nav-item {{ Request::is('admin/pending_payment') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/pending_payment') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('message.Pending Payment') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Subscription' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('Subscription') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('message.Subscription') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/subscriber_doc') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/subscriber_doc') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('message.Subscriber') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/complete_payment') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/complete_payment') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('message.Complete Payment') }}</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                {{ __('message.Notification') }}
            </div>
            <li class="nav-item {{ Request::is('admin/sendnotification') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/sendnotification') }}">
                    <i class="fab fa-snapchat-ghost"></i>
                    <span>{{ __('message.Send Notification') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/notificationkey') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('admin/notificationkey') }}">
                    <i class="fas fa-key"></i>
                    <span>{{ __('message.Notification Key') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'payment-setting' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('payment-setting') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('message.Payment Gateway') }}</span>
                </a>
            </li>
        </ul>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column" style="height: 100vh;overflow-y: auto;">
            <div id="content">
                <!-- TopBar -->
                <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3"
                        style="background-color: white;color: #3f51b5;">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav @if (__('message.RTL') == 1) ml-auto @endif"
                        @if (__('message.RTL') == 0) style=" margin-right: 0%;" @endif>
                        {{-- <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                        aria-labelledby="searchDropdown">
                        <form class="navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-1 small"
                                    placeholder="What do you want to look for?" aria-label="Search"
                                    aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li> --}}

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="">
                                {{ Session::get('locale') ?? 'en' }} <i class="fas fa-angle-down ml-2"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item d-flex align-items-center" @if ($color->is_demo == 1) href="{{ url('local/en') }}" @else href="#" onclick="disablebtn()" @endif >
                                    {{-- <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/man.png" style="max-width: 60px"
                                            alt="">
                                        <div class="status-indicator bg-success"></div>
                                    </div> --}}
                                    <div class="font-weight-bold">
                                        <div>{{ __('message.english') }}</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" @if ($color->is_demo == 1) href="{{ url('local/ar') }}" @else href="#" onclick="disablebtn()" @endif>
                                    {{-- <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/girl.png" style="max-width: 60px"
                                            alt="">
                                        <div class="status-indicator bg-default"></div>
                                    </div> --}}
                                    <div class="font-weight-bold">
                                        <div>{{ __('message.arabic') }}</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" @if ($color->is_demo == 1) href="{{ url('local/fr') }}" @else href="#" onclick="disablebtn()" @endif>
                                    {{-- <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/girl.png" style="max-width: 60px"
                                            alt="">
                                        <div class="status-indicator bg-default"></div>
                                    </div> --}}
                                    <div class="font-weight-bold">
                                        <div>{{ __('message.french') }}</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" @if ($color->is_demo == 1) href="{{ url('local/es') }}" @else href="#" onclick="disablebtn()" @endif>
                                    {{-- <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/girl.png" style="max-width: 60px"
                                            alt="">
                                        <div class="status-indicator bg-default"></div>
                                    </div> --}}
                                    <div class="font-weight-bold">
                                        <div>{{ __('message.spanish') }}</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" @if ($color->is_demo == 1) href="{{ url('local/pt') }}" @else href="#" onclick="disablebtn()" @endif>
                                    {{-- <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/girl.png" style="max-width: 60px"
                                            alt="">
                                        <div class="status-indicator bg-default"></div>
                                    </div> --}}
                                    <div class="font-weight-bold">
                                        <div>{{ __('message.portuguese') }}</div>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter">0</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                {{-- <h6 class="dropdown-header">
                            Alerts Center
                        </h6>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">December 12, 2019</div>
                                <span class="font-weight-bold">A new monthly report is ready to
                                    download!</span>
                            </div>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-donate text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">December 7, 2019</div>
                                $290.29 has been deposited into your account!
                            </div>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">December 2, 2019</div>
                                Spending Alert: We've noticed unusually high spending for your account.
                            </div>
                        </a>
                        <a class="dropdown-item text-center small text-gray-500" href="#">Show All
                            Alerts</a> --}}
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('public/upload/profile/profile.png') }}" style="max-width: 60px">
                                <span
                                    class="ml-2 d-none d-lg-inline text-white small">{{ optional(Sentinel::getUser())->first_name ?? 'Admin' }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ url('admin/editprofile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('message.View Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ url('admin/setting') }}">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('message.Setting') }}
                                </a>
                                <a class="dropdown-item" href="{{ url('admin/changepassword') }}">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('message.Change Password') }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('admin/logout') }}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('message.Sign out') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- Topbar -->

                <!-- Container Fluid-->
                @yield('content')
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>{{ date('Y') }} © {{ __('message.System Name') }}</span>
                    </div>
                </div>
            </footer>
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <input type="hidden" id="siteurl" value="{{ url('admin') }}" />
    <input type="hidden" id="delete_record" value="{{ __('message.delete_record') }}">
    <input type="hidden" id="today_no_appointment_msg"
        value='{{ __('message.You dont have any  appointments for today') }}' />
    <input type="hidden" id="demo" value="{{ Session::get('is_demo') }}" />
    <input type="hidden" id="soundnotify" value="{{ asset('public/sound/notification/notification.mp3') }}" />
    <script src="{{ asset('public/admin') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('public/admin') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/admin') }}/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="{{ asset('public/admin') }}/js/ruang-admin.min.js"></script>
    <script src="{{ asset('public/admin') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public/admin') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('public/admin') }}/vendor/chart.js/Chart.min.js"></script>
    <script src="{{ url('public/js/locationpicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/admin.js?v=rgtrygr') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });
        });

        function disablebtn() {
            alert("This Action Disable In Demo");
        }
    </script>

</body>

</html>
