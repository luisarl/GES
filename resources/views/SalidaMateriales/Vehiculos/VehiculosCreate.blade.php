@extends('layouts.master')

@section('titulo', 'Creacion Vehiculo')

@section('titulo_pagina', 'Creacion Vehiculo')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('autorizacionsalidas') }}">Autorización de Salida</a> </li>
    <li class="breadcrumb-item"><a href="{{ url('vehiculos') }}">Vehiculos</a> </li>
    <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Crear Vehiculo</h5>

    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form class="" method="POST" action=" {{ route('vehiculos.store') }}">
            @csrf
            <div class="form-group row">
            <label class="col-sm-2 col-form-label">Placa</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control @error('placa_vehiculo') is-invalid @enderror" name="placa_vehiculo"
                       value="{{ old('placa_vehiculo') }}" placeholder="Ejemplo: AA 123AA">
                </div>
                <label class="col-sm-2 col-form-label">Marca</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control @error('marca_vehiculo') is-invalid @enderror" name="marca_vehiculo"
                       value="{{ old('marca_vehiculo') }}" placeholder="Marca Vehiculo">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Modelo</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control @error('modelo_vehiculo') is-invalid @enderror" name="modelo_vehiculo"
                       value="{{ old('modelo_vehiculo') }}" placeholder="Modelo Vehiculo">
                </div>
                <label class="col-sm-2 col-form-label">Descripcion</label>
                <div class="col-sm-4">
                    <textarea rows="3" cols="3" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"
                       value="{{ old('descripcion') }}" placeholder="Breve Descripcion del Vehiculo"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Estado</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="activo"
                                value="SI" checked> Activo </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="activo"
                                value="NO"> Inactivo </label>
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 d-md-block float-right">

                <button type="submit" class="btn btn-primary ">
                    <i class="fa fa-save"></i>Guardar
                </button>
            </div>
        </form>

    </div>
</div>

@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<!-- personalizado -->
<script type="text/javascript" src="{{ asset('libraries\assets\js\AsalSalidas.js') }}"></script>

@endsection