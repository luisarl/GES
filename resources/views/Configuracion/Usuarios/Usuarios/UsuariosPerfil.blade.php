@extends('layouts.master')

@section('titulo', 'Perfiles')

@section('titulo_pagina', 'Perfiles')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{!! url('/') !!}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Perfil de Usuario</a> </li>
    </ul>
@endsection

@section('contenido')
    @include('mensajes.MsjExitoso')
    @include('mensajes.MsjValidacion')
    @include('mensajes.MsjError')
    <!-- Scroll - Vertical table end -->
    <!-- Scroll - Vertical, Dynamic Height table end -->
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Basic Inputs Validation start -->
                <div class="card">
                    <div class="card-block">
                        <form method="POST" action=" {{ route('perfilupdate') }}">
                            @csrf
                            <div class="col-xl-12 col-md-12">
                                <div class="card user-card-full">
                                    <div class="row m-l-0 m-r-0">
                                        <div class="col-sm-4 bg-c-lite-green user-profile">
                                            <div class="card-block text-center text-white">
                                                <div class="m-b-25">
                                                    <img src="{{ asset('libraries/assets/images/avatar.jpg') }}" class="img-radius"
                                                        alt="User-Profile-Image">
                                                </div>
                                                <h6 class="f-w-600">{!! Auth::user()->name !!}</h6>
                                                <p>{!! Auth::user()->roles[0]->name !!}</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="card-block">
                                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Informacion</h6>
                                                <div class="row">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-user"></i></span>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name"
                                                            value=" {{ old('name', Auth::user()->name ?? '') }}"
                                                            placeholder="Ingrese Nombre del Usuario ">
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-envelope"></i></span>
                                                        <input type="text"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email"
                                                            value=" {{ old('email', Auth::user()->email ?? '') }}"
                                                            placeholder="Ingrese el Email ">
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-unlock-alt"></i></span>
                                                        <input type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" value="{{ old('password') }}"
                                                            placeholder="Ingrese la contraseña">
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                            class="fa fa-unlock"></i></span>
                                                        <input type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password_confirmation" value="{{ old('password') }}"
                                                            placeholder="Confirme la contraseña">
                                                    </div>
                                                </div>
                                                <div class="d-grid gap-2 d-md-block float-right">
                                                    <button type="submit" class="btn btn-primary ">
                                                        <i class="fa fa-save"></i>Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- wather user -->
        <!-- Page-body end -->
        <!-- Scroll - Vertical, Dynamic Height table end -->
    @endsection

    @section('scripts')
        <!-- data-table js -->
        <script src="{{ asset('libraries\bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('libraries\assets\pages\data-table\js\jszip.min.js') }}"></script>
        <script src="{{ asset('libraries\assets\pages\data-table\js\pdfmake.min.js') }}"></script>
        <script src="{{ asset('libraries\assets\pages\data-table\js\vfs_fonts.js') }}"></script>
        <script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.print.min.js') }}"></script>
        <script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
        <script src="{{ asset('libraries\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('libraries\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}">
        </script>
        <script
                src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
        </script>

        <!-- Custom js -->
        <script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>

        <!-- sweet alert js -->
        <script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}">
        </script>
        <script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>


    @endsection
