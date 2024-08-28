<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries\extra-pages\comming-soon\css\style-minimal-flat.css') }}">
    <script src="{{ asset('libraries\extra-pages\comming-soon\js\modernizr.custom.js') }}"></script>
</head>
    <!-- Canvas for particles animation -->
    <div id="particles-js"></div>

    <div class="container" style="text-align: center; height:100%; align-content:center;z-index:1;position:relative;">
        <img src="{{ asset('images/logos/logo_global_menu.png') }}" alt="" class="brand-logo ">
        <h1 class="">ERROR @yield('codigo')</h1>
        <p class=""> @yield('mensaje')<strong></strong>
        </p>
        <br>
        <a href="{{url('/')}}" class="btn btn-primary trigger ">Ir al inicio</a>
    </div>

    <script src="{{ asset('libraries\extra-pages\comming-soon\js\jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\extra-pages\comming-soon\js\jquery.easings.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\extra-pages\comming-soon\js\bootstrap.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('libraries\extra-pages\comming-soon\js\jquery.ba-cond.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\extra-pages\comming-soon\js\jquery.slitslider.js') }}" type="text/javascript"></script>

    <script src="{{ asset('libraries\extra-pages\comming-soon\js\notifyMe.js') }}" type="text/javascript"></script>

    <script src="{{ asset('libraries\extra-pages\comming-soon\js\classie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\extra-pages\comming-soon\js\dialogFx.js') }}" type="text/javascript"></script>

    <script src="{{ asset('libraries\extra-pages\comming-soon\js\particles.js') }}" type="text/javascript"></script>

    <script src="{{ asset('libraries\extra-pages\comming-soon\js\jquery.mCustomScrollbar.js') }}"type="text/javascript"></script>

    <script src="{{ asset('libraries\extra-pages\comming-soon\js\main-flat.js') }}" type="text/javascript"></script>

</body>

</html>