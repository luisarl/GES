@extends('layouts.master')

@section('titulo', 'Clasificaciones')

@section('titulo_pagina', 'Clasificaciones')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Resguardo</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('resgclasificaciones.index') }}">Clasificaciones</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Clasificacion</h5>
        </div>
        <div class="card-block">

            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('resgclasificaciones.store') }}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('nombre_clasificacion') is-invalid @enderror"
                            name="nombre_clasificacion" value="{{ old('nombre_clasificacion') }}"
                            placeholder="Ingrese el Nombre de la Clasificacion">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripcion</label>
                    <div class="col-sm-10">
                        <textarea name="descripcion_clasificacion" class="form-control @error('descripcion_clasificacion') is-invalid @enderror" 
                        rows="3" placeholder="Ingrese la Descripcion">{{ old('descripcion_clasificacion') }}</textarea>
                    </div>
                </div>
                <hr>
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

<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

@endsection
