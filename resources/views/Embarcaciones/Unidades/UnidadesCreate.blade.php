@extends('layouts.master')

@section('titulo', 'Crear Unidad de Medida')

@section('titulo_pagina', 'Crear Unidad de Medida')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('embaunidades.index') }}">Unidades de Medida</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Unidad de Medida</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form method="POST" action="{{ route('embaunidades.store') }}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control @error('nombre_unidad') is-invalid @enderror" name="nombre_unidad"
                           value="{{ old('nombre_unidad') }}" placeholder="Ingrese el Nombre de la Unidad">
                    </div>

                    <label class="col-sm-2 col-form-label">Abreviatura</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control @error('abreviatura') is-invalid @enderror" name="abreviatura"
                           value="{{ old('abreviatura') }}" placeholder="Ingrese la Abreviatura de la Unidad">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('descripcion_unidad') is-invalid @enderror" name="descripcion_unidad"
                            placeholder="Ingrese la Descripción de la Unidad">{{ old('descripcion_unidad') }}</textarea>
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
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

@endsection
