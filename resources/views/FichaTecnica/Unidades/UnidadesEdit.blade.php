@extends('layouts.master')

@section('titulo', 'Unidades de Medida')

@section('titulo_pagina', 'Unidades de Medida')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Ficha Tecnica</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('unidades.index') }}">Unidades de Medida</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>

@endsection

@section('contenido')

@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Editar Unid. de Medida</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('unidades.update', $unidad->id_unidad) }}" enctype="multipart/form-data">
            @csrf @method("put")
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Abreviatura</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-uppercase @error('abreviatura_unidad') is-invalid @enderror" name="abreviatura_unidad" value=" {{old('abreviatura_unidad', $unidad->abreviatura_unidad ?? '')}}" placeholder="Ingrese la Abreviatura de la Unidad de Medida" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_unidad') is-invalid @enderror" name="nombre_unidad" value=" {{old('nombre_unidad', $unidad->nombre_unidad ?? '')}}" placeholder="Ingrese el Nombre de la Unidad de Medida">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Clasificacion</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('clasificacion_unidad') is-invalid @enderror" name="clasificacion_unidad" value=" {{old('clasificacion_unidad', $unidad->clasificacion_unidad ?? '')}}" placeholder="Ingrese la Clasificación de la Unidad de Medida">
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
{{-- <!--Forms - Wizard js-->
        <script src="{{ asset('libraries\bower_components\jquery.cookie\js\jquery.cookie.js') }}"></script>
<script src="{{ asset('libraries\bower_components\jquery.steps\js\jquery.steps.js') }}"></script>
<script src="{{ asset('libraries\bower_components\jquery-validation\js\jquery.validate.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\forms-wizard-validation\form-wizard.js') }}"></script>

<!-- jquery file upload js -->
<script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script> --}}
@endsection