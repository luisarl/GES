@extends('layouts.master')

@section('titulo', 'Control Combustible')

@section('titulo_pagina', 'Crear Tipo de Ingreso')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Control de Combustible</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('cntctiposingresos.index') }}">Tipos de Ingresos</a> </li>
    <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
<div class="card-header">
        <h4 class="sub-title"><strong>Tipo de Ingreso</strong></h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('cntctiposingresos.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 form-label">Nombre Ingreso</label>
                    <div class="col-sm-4">
                        <input type="text" name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion') }}">
                    </div>
            </div>
            <hr>
        

            <div class="d-grid gap-2 d-md-block float-right">
                <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla()">
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



@endsection