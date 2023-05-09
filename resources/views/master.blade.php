<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>@yield('title') | Jatri Reward</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ url()->asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url()->asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url()->asset('assets/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url()->asset('assets/css/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ url()->asset('assets/css/custom.css') }}" id="stylesheet" rel="stylesheet" type="text/css">


    @yield('external_css')
    <script src="{{ url()->asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ url()->asset('assets/js/pickers/moment.min.js') }}"></script>
    <script src="{{ url()->asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    @yield('external_js')

    <script src="{{ url()->asset('assets/js/app.js') }}"></script>

</head>

<body>

<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="{{ url('/') }}" class="d-inline-flex align-items-center">
                <h4 class="text-white">Jatri Reward</h4>
            </a>
        </div>

        <ul class="nav flex-row">
            <li class="nav-item nav-item-dropdown-lg dropdown">
                <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                    <i class="ph-arrows-left-right"></i>
                </button>

                <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                    <i class="ph-x"></i>
                </button>
            </li>
        </ul>

        <div class="navbar-collapse justify-content-center flex-lg-1 order-2 order-lg-1 collapse" id="navbar_search"></div>

        <ul class="nav flex-row justify-content-end order-1 order-lg-2">
            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        @if(isset(auth()->user()->avatar))
                            <img src="{{ asset( 'storage/'.auth()->user()->avatar ) }}" class="w-32px h-32px rounded-pill" alt="" style="background: #fff;">
                        @else
                            <img src="{{ url()->asset('assets/images/user.png') }}" class="w-32px h-32px rounded-pill" alt="" style="background: #fff;">
                        @endif
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">@if(isset(auth()->user()->name)){{ auth()->user()->name }}@endif</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ url('/admins/profile') }}" class="dropdown-item">
                        <i class="ph-user-circle me-2"></i>
                        My profile
                    </a>

                    <a href="{{ url('/auth/logout') }}" class="dropdown-item">
                        <i class="ph-sign-out me-2"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->


<!-- Page content -->
<div class="page-content">

    <!-- Main sidebar -->
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- Main navigation -->

            @include('nav')

            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /main sidebar -->


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">

            <!-- Page header -->
            <div class="page-header page-header-light shadow">
                <div class="page-header-content d-lg-flex border-top">
                    <div class="d-flex">
                        <div class="breadcrumb py-2">
                            <a href="{{ url('/') }}" class="breadcrumb-item"><i class="ph-house"></i></a>

                            @yield('breadcrumb')

                        </div>

                        <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                            <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                        </a>
                    </div>

                    <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
                        <div class="d-lg-flex mb-2 mb-lg-0">
                            @yield('page_actions')
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">

                @if(session('success') || session('error') || $errors->any())
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <span class="fw-semibold">Oh snap!</span> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    <span class="fw-semibold">Well done!</span> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                @endif

                @yield('page_content')

            </div>
            <!-- /content area -->


            <!-- Footer -->
            <div class="navbar navbar-sm navbar-footer border-top">
                <div class="container-fluid">
                    <span>&copy; {{ date('Y') }} <a href="https://www.jatri.co/">Jatri Services Ltd. All rights reserved.</a></span>
                </div>
            </div>
            <!-- /footer -->

        </div>
        <!-- /inner content -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

</body>

@yield('footer_js')

</html>
