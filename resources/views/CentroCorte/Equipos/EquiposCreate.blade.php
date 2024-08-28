@extends('layouts.master')

@section('titulo', 'Crear Equipo')

@section('titulo_pagina', 'Crear Equipo')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('cencequipos.index')}}">Centro de Corte</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('cencequipos.index') }}">Equipos</a></li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>
@endsection

@section('contenido')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Crear Equipos</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form class="" method="POST" action=" {{ route('cencequipos.store') }}">
            @csrf

            <div class="form-group row">
                <div class="col-md-2 col-lg-2">
                    <label for="name-2" class="block">Nombre</label>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control @error('nombre_equipo') is-invalid @enderror" name="nombre_equipo"
                        value="{{ old('nombre_equipo') }}" placeholder="Ingrese el Nombre del Equipo">
                </div>

                <div class="col-md-2 col-lg-2">
                    <label for="name-2" class="block">Tecnologia</label>
                </div>
                <div class="col-sm-4 @error('id_tecnologia') is-invalid @enderror">
                    <select name="id_tecnologia[]" id="id_tecnologia" class="js-example-basic-multiple form-control @error('responsables') is-invalid @enderror"
                    multiple="multiple">
                        @foreach ($tecnologias as $tecnologia)
                            <option value="{{ $tecnologia->id_tecnologia }}"
                                @if ($tecnologia->id_tecnologia==old('id_tecnologia')) selected="selected" @endif>{{ $tecnologia->nombre_tecnologia }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="3" cols="3" class="form-control @error('descripcion_equipo') is-invalid @enderror" name="descripcion_equipo"
                        placeholder="Ingrese la Descripción del Equipo">{{ old('descripcion_equipo') }}</textarea>
                </div>
            </div>
            <hr>
            <div class="float-right">
                <button type="submit" class="btn btn-primary ">
                    <i class="fa fa-save"></i>Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')

<!-- jquery file upload js -->
<script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

<script type="text/javascript" src="{{ asset('libraries\bower_components\bootstrap-multiselect\js\bootstrap-multiselect.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\bower_components\multiselect\js\jquery.multi-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\jquery.quicksearch.js') }}"></script>
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

@endsection