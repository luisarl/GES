@extends('layouts.login')
@section('titulo', 'Inicio de Sesion')
@section('contenido')

<p class="login-card-description">Inicio de Sesión</p>
@if(session('message'))
<div class="alert alert-danger background-danger">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="icofont icofont-close-line-circled text-white"></i>
    </button>
    <strong>Alerta!</strong> <br> {{session('message')}}
</div>
@endif
<form class="" method="POST" action="{{ route('auth.store') }}">
    @csrf
    <div class="form-group">
        <label for="username" class="sr-only">Username</label>
        <input type="username" name="username" id="username"
            class="form-control  @error('username') is-invalid @enderror" value="{{old('username')}}"
            placeholder="Nombre de Usuario" autocomplete="username" autofocus>
        @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group mb-4">
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password"
            class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group mb-4">
        <div class="checkbox-fade fade-in-primary d-">
            <label>
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember')
                    ? 'checked' : '' }}>
                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                <span class="text-inverse">Recuerdame</span>
            </label>
        </div>
    </div>

    <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="Acceder">
</form>
@endsection