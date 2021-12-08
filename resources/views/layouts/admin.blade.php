<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <!-- Favicon icon -->
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/template/images/favicon') }}') }}"> --}}

    <link rel="stylesheet" href="{{ asset('assets/template/plugins/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/utility.css') }}">
    <link href="{{asset('assets/template/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="{{ asset('assets/template/css/style.css') }}" rel="stylesheet">

    <style>
        .select2-container {
            display: block !important;
            width: 100% !important
        }

        .checkVariationDisplay {
            display: inline;
        }

        .variation_style {
            border: none;
            width: 55% !important;
        }

        .variation_style_only_img {
            border: none;
            width: 120% !important;
        }
        .form-control{
            height: 38px !important;
            min-height: 38px !important;
        }
        .scrollModal{
            max-height: 80vh !important;
            overflow-y: auto;
        }
        .dataTable > thead > tr > th[class*="sort"]:before,
        .dataTable > thead > tr > th[class*="sort"]:after {
            content: "" !important;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        padding:3px !important ;
        }


        @media (min-width: 992px){
            .saleParchaseWidth {
                max-width:80% !important;
            }
        }

    </style>
    @yield('style')

</head>

<body oncontextmenu="return true">
    <input type="hidden" value="{{ csrf_token() }}" id="laravelToken">
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                    stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="{{ route('dashboard') }}" class="px-2">
                    <b class="logo-abbr">
                        <h4 class="text-white">AMS</h4>
                    </b>
                    <span class="brand-title">
                        <h5 class="text-white">Accounts Management System</h5>
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="mdi mdi-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                    {{-- <div class="input-group icons">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                        </div>
                        <input type="search" class="form-control" placeholder="Search Dashboard" aria-label="Search Dashboard">
                        <div class="drop-down animated flipInX d-md-none">
                            <form action="#">
                                <input type="text" class="form-control" placeholder="Search">
                            </form>
                        </div>
                    </div> --}}
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="{{ asset('assets/img/person.png') }}" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="#"><i class="mdi mdi-account"></i> <span>Profile</span></a>
                                        </li>
                                        {{-- <hr class="my-2">
                                        <li>
                                            <a href="#"><i class="icon-lock"></i> <span>Lock Screen</span></a>
                                        </li> --}}
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="mdi mdi-key"></i>
                                                <span>Logout</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Dashboard</li>
                    @if (auth()->user()->can('view-users') ||
    auth()->user()->can('create-user'))

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="mdi mdi-account menu-icon"></i><span class="nav-text">User Management</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('view-users') <li><a href="{{ route('users.index') }}">Users</a></li> @endcan
                                @can('view-roles') <li><a href="{{ route('roles.index') }}">Roles</a></li> @endcan
                            </ul>
                        </li>

                    @endif


                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="mdi mdi-account-group menu-icon"></i><span class="nav-text">Accounts</span>
                        </a>
                        <ul aria-expanded="false">
                            @can('view-accounts')
                                <li>
                                    <a href="{{ route('accounts.index') }}">General Accounts</a>
                                </li>
                            @endcan
                            @can('view-sub-accounts')
                                <li>
                                    <a href="{{ route('sub-accounts.index') }}">Sub Accounts</a>
                                </li>
                            @endcan
                        </ul>
                    </li>


                    @if (auth()->user()->can('view-products') ||
                        auth()->user()->can('create-product'))
                         @can('view-products')
                            <li>
                                <a href="{{ route('products.index') }}" aria-expanded="false">
                                    <i class="mdi mdi-dropbox menu-icon"></i><span class="nav-text">Products</span>
                                </a>
                            </li>
                        @endcan
                    @endif


                    @if (auth()->user()->can('') || auth()->user()->can(''))
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="mdi mdi-book-open-page-variant menu-icon"></i><span class="nav-text">Vouchers</span>
                        </a>
                        

                        <ul aria-expanded="false">
                            <li>
                                <a class="has-arrow" href="javascript:void()" aria-expanded="false">List</a>
                                <ul aria-expanded="false">
                                    @can('')
                                    <li>
                                        <a href="{{ route('salePurchase.index')}}">Sale/Purchase Voucher</a>
                                    </li>
                                    @endcan

                                    @can('')
                                    <li>
                                        <a href="{{ route('journal.index') }}">Journal Voucher</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow" href="javascript:void()" aria-expanded="false">Create</a>
                                <ul aria-expanded="false">
                                    @can('')
                                    <li>
                                        <a href="{{ route('salePurchase.create')}}">Sale/Purchase Voucher</a>
                                    </li>
                                    @endcan

                                    @can('')
                                    <li>
                                        <a href="{{ route('journal.create') }}">Journal Voucher</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>




                    @endif

                    @if (auth()->user()->can('') || auth()->user()->can(''))
                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="mdi mdi-format-page-break menu-icon"></i><span class="nav-text">Reports</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('')
                                <li>
                                    <a href="{{route('partyAccount')}}">Party Account/Party Ledger</a>
                                </li>
                                @endcan

                                @can('')
                                <li>
                                    <a href="{{route('aging_report')}}">Aging Report</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <main>
                @yield('content')
            </main>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="https://www.ewdtech.com">EWD TECH</a>
                    2018</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('assets/template/plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/template/js/styleSwitcher.js') }}"></script>

    <script src="{{ asset('assets/template/js/settings.js') }}"></script>
    <script src="{{ asset('assets/template/js/gleek.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/protectCode.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/vouchers.js') }}"></script>

    @yield('script')
    <script>$(".select_2").select2({allowClear: true});</script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>


    {{-- datatable links --}}
    <script src="{{asset('assets/template/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>
</body>

</html>
