<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/template/images/favicon') }}') }}">
    <!-- Pignose Calender -->
    <link href="{{ asset('assets/template/plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="{{ asset('assets/template/plugins/chartist/css/chartist.min.css ') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/plugins/sweetalert/sweetalert.css') }}">
    <!-- Custom Stylesheet -->
    <link href="{{ asset('assets/template/css/style.css') }}" rel="stylesheet">

    @yield('style')

</head>

<body oncontextmenu="return false">
<input type="hidden" value="{{ csrf_token() }}" id="laravelToken">
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
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
                <a href="{{route('dashboard')}}">
                    <b class="logo-abbr">
                        <h4 class="text-white">IS</h4>
                    </b>
                    <span class="brand-title">
                        <h4 class="text-white">Invertory System</h4>
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
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
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
                            <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="{{ asset('assets/img/person.png') }}" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="app-profile.html"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>
                                        <hr class="my-2">
                                        <li>
                                            <a href="page-lock.html"><i class="icon-lock"></i> <span>Lock Screen</span></a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="icon-key"></i>
                                                <span>Logout</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
                    @if(auth()->user()->can('view-users') || auth()->user()->can('create-user'))

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-user menu-icon"></i><span class="nav-text">User Management</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('view-roles') <li><a href="{{route('roles.index')}}">All Roles</a></li> @endcan
                                @can('view-users') <li><a href="{{route('users.index')}}">All Users</a></li> @endcan
                                @can('create-user') <li><a href="{{route('users.create')}}">Create User</a></li> @endcan
                            </ul>
                        </li>

                    @endif
                    
                    @if(auth()->user()->can('view-categories') || auth()->user()->can('create-category'))
                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-list menu-icon"></i><span class="nav-text">Categories</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('view-categories') <li><a href="{{route('categories.index')}}">All categories</a></li> @endcan
                                @can('create-category') <li><a href="{{route('categories.create')}}">Create category</a></li> @endcan
                                
                            </ul>
                        </li>
                    @endif
                   

                    @if(auth()->user()->can('view-sub-categories') || auth()->user()->can('create-sub-category'))
                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-vector menu-icon"></i><span class="nav-text">Sub-Categories</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('view-sub-categories') <li><a href="{{route('sub-categories.index')}}">Sub categories</a></li> @endcan
                                @can('create-sub-category') <li><a href="{{route('sub-categories.create')}}">Create sub category</a></li> @endcan   
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
                <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p>
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
    <script src="{{ asset('assets/template/js/settings.js') }}"></script>
    <script src="{{ asset('assets/template/js/gleek.js') }}"></script>
    <script src="{{ asset('assets/template/js/styleSwitcher.js') }}"></script>
    <script src="{{ asset('assets/template/js/dashboard/dashboard-1.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('assets/js/protectCode.js')}}"></script>
    @yield('script')



</body>

</html>
