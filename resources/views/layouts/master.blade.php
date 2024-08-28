<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Titulo -->
    <title>{{config('app.name')}} - @yield('titulo') </title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="Luis Romero">

    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('images/logos/favico.png')}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/bower_components/bootstrap/css/bootstrap.min.css')}}">
    <!-- sweet alert framework -->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('libraries/bower_components/sweetalert/css/sweetalert.css')}}"> --}}
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/assets/icon/themify-icons/themify-icons.css')}}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/assets/icon/icofont/css/icofont.css')}}">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/assets/icon/feather/css/feather.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/assets/icon/font-awesome/css/font-awesome.min.css')}}">
    <!-- Material Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\assets\icon\material-design\css\material-design-iconic-font.min.css')}}">    
     <!--forms-wizard css-->
     <link rel="stylesheet" type="text/css" href="{{ asset('libraries\bower_components\jquery.steps\css\jquery.steps.css') }}">

    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\assets\pages\data-table\css\buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') }}">

    <!-- jquery file upload Frame work -->
    <link href=" {{ asset('libraries\assets\pages\jquery.filer\css\jquery.filer.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('libraries\assets\pages\jquery.filer\css\themes\jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet">

    <!-- lightbox Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\bower_components\lightbox2\css\lightbox.min.css') }} ">

    <!-- Select 2 css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\bower_components\select2\css\select2.min.css') }}">

    <!-- Multi Select css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\bower_components\bootstrap-multiselect\css\bootstrap-multiselect.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\bower_components\multiselect\css\multi-select.css') }}">
    <!-- jpro forms css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\assets\pages\j-pro\css\demo.css') }} ">
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\assets\pages\j-pro\css\font-awesome.min.css') }} ">
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\assets\pages\j-pro\css\j-forms.css') }} ">
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\assets\pages\j-pro\css\j-pro-modern.css') }}">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/assets/css/jquery.mCustomScrollbar.css')}}">

    <!-- Bootstrap Editable -->
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/bower_components/bootstrap-editable/css/bootstrap-editable.css')}}">
    {{-- <script>$.fn.poshytip={defaults:null}</script> --}}

</head>

<body>
<!-- Pre-loader start -->
<div class="theme-loader">
    <div class="ball-scale">
        <div class='contain'>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            {{-- <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div> --}}
        </div>
    </div>
</div>
<!-- Pre-loader end -->
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>

    <div class="pcoded-container navbar-wrapper">
    <nav class="navbar header-navbar pcoded-header iscollapsed" header-theme="theme6" pcoded-header-position="fixed">
        <!-- <nav class="navbar header-navbar pcoded-header"> -->
            <div class="navbar-wrapper">

                <div class="navbar-logo" logo-theme="theme6">
                    <a class="mobile-menu" id="mobile-collapse" href="#!">
                        <i class="fa fa-bars"></i>
                    </a>
                    <a href="{{ url('/') }}">
                        <img class="img-fluid" src=" {{ asset('images/logos/logo_global_menu.png') }}" alt="Logo">
                    </a>
                    <a class="mobile-options">
                        <i class="feather icon-more-horizontal"></i>
                    </a>
                </div>

                <div class="navbar-container container-fluid">
                    <ul class="nav-left">

                        <li>
                            <a href="#!" onclick="javascript:toggleFullScreen()">
                                <i class="feather icon-maximize full-screen"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-right">
                        <li class="user-profile header-notification">
                            <div class="dropdown-primary dropdown">
                                <div class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{ asset('libraries/assets/images/avatar.jpg') }}" class="img-radius" alt="User-Profile-Image">
                                    <span>{!! Auth::user()->name !!}</span>
                                    <i class="feather icon-chevron-down"></i>
                                </div>
                                <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    {{-- <li>
                                        <a href="#">
                                            <i class="fa fa-gear"></i> Configuración
                                        </a>
                                    </li> --}}
                                    <li class="nav-item dropdown" >
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ route('perfil') }}" role="button" data-bs-toggle="dropdown">
                                            <i class="fa fa-user"></i> Perfil
                                        </a>
                                    </li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <li class="nav-item dropdown" >
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" onclick="this.closest('form').submit()" role="button" data-bs-toggle="dropdown">
                                                <i class="fa fa-sign-out" ></i> Salir
                                            </a>
                                        </li>
                                    </form>
                                    
                                </ul>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
            @include('menus.menulat')

                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <!-- Main-body start -->
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- Page-header start -->
                                <div class="page-header">
                                    <div class="row align-items-end">
                                    <div class="col-lg-8">
                                            <div class="page-header-title">
                                                <div class="d-inline">
                                                    <h4>@yield('titulo_pagina')</h4>
                                                   <!-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                @yield('menu_pagina')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page-header end -->

                                <div class="page-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                             @yield('contenido')

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div id="styleSelector">

                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Warning Section Starts -->
<!-- Older IE warning message -->
<!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers
        to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="../files/assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="../files/assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="../files/assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="../files/assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="../files/assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
<!-- Warning Section Ends -->
<!-- Required Jquery -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script type="text/javascript" src="{{ asset('libraries/bower_components/jquery/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/bower_components/popper.js/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('libraries/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>

<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('libraries/bower_components/modernizr/js/modernizr.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/bower_components/modernizr/js/css-scrollbars.js') }}"></script>

<!-- sweet alert js -->
    {{-- <script type="text/javascript" src="{{ asset('libraries/bower_components/sweetalert/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/assets/js/modal.js') }}"></script> --}}
<!-- sweet alert modal.js intialize js -->

<!-- i18next.min.js -->
<script type="text/javascript" src="{{ asset('libraries/bower_components/i18next/js/i18next.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/bower_components/jquery-i18next/js/jquery-i18next.min.js') }}"></script>

<!-- Custom js -->
<script src="{{ asset('libraries/assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('libraries/assets/js/vartical-layout.min.js') }}"></script>
<script src=" {{ asset('libraries/assets/js/jquery.mCustomScrollbar.concat.min.js') }} "></script>
<script type="text/javascript" src="{{ asset('libraries/assets/js/script.js') }} "></script>

@yield('scripts')

</body>

</html>