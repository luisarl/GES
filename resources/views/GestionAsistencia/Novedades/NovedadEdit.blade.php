@extends('layouts.master')

@section('titulo', 'Novedades en Asitencias')

@section('titulo_pagina', 'Editar Novedad')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Gestion de Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('gstanovedades.index') }}">Editar Novedad</a> </li>
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>Novedades en la Asistencia</strong></h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('gstanovedades.update',$novedades->id_novedad) }}">
            @csrf
            @method('put')
            <div class="form-group row">
            <label class="col-sm-2 form-label">Nombre de la Novedad</label>
                <div class="col-sm-4">
                    <input type="text" name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion',$novedades->descripcion) }}">
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