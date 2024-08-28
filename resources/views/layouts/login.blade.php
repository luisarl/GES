<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{config('app.name')}} - @yield('titulo') </title>
 <!-- Favicon icon -->
 <link rel="icon" href="{{asset('images/logos/favico.png')}}" type="image/x-icon">
 <!-- Google font-->
 <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
 <!-- Required Fremwork -->
 <link rel="stylesheet" type="text/css" href="{{ asset('libraries/bower_components/bootstrap/css/bootstrap.min.css')}}">
<!-- themify-icons line icon -->
<link rel="stylesheet" type="text/css" href="libraries\assets\icon\themify-icons\themify-icons.css">
<!-- ico font -->
<link rel="stylesheet" type="text/css" href="libraries\assets\icon\icofont\css\icofont.css">
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="libraries\assets\css\style.css">
<!-- Login Style -->
<link rel="stylesheet" href="{{ asset('libraries/assets/css/login.css') }}">
</head>
<body style="margin-top: 3%;">
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
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
        </div>
    </div>
</div>
<!-- Pre-loader end -->
  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-8">
            <img src="{{ asset('images/logos/bg_login.jpg') }}" alt="login" class="login-card-img">
          </div>
          <div class="col-md-4">
            <div class="card-body">
              <div class="brand-wrapper">
                <img src="{{ asset('images/logos/logo.jpg')}}" alt="logo" class="logo">
                  <p class="login-card-description">{{config('app.name')}}</p>
              </div>
              
              @yield('contenido')
              
                {{-- <a href="#!" class="forgot-password-link">Forgot password?</a>
                <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
                
                <nav class="login-card-footer-nav">
                  <a href="#!">Aceronet</a>
                </nav> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
   <!-- Required Jquery -->
   <script type="text/javascript" src="libraries\bower_components\jquery\js\jquery.min.js"></script>
   <script type="text/javascript" src="libraries\bower_components\jquery-ui\js\jquery-ui.min.js"></script>
   <script type="text/javascript" src="libraries\bower_components\popper.js\js\popper.min.js"></script>
   <script type="text/javascript" src="libraries\bower_components\bootstrap\js\bootstrap.min.js"></script>
   <script type="text/javascript" src="libraries\assets\js\common-pages.js"></script>

</body>
</html>
