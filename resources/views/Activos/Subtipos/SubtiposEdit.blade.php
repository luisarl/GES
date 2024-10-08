@extends('layouts.master')

@section('titulo', 'SubGrupos')

@section('titulo_pagina', 'SubGrupos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Activos</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('subtiposactivos.index') }}">Subtipos de Activos</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Editar Subtipos</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('subtiposactivos.update', $subtipo->id_subtipo) }}" enctype="multipart/form-data">
            @csrf @method("put")
           <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tipos de Activo</label>
                <div class="col-sm-10 @error('id_tipo') is-invalid @enderror">
                    <select name="id_tipo" class="js-example-basic-single form-control" >
                        <option value="0">Seleccione el Tipo</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id_tipo }}"
                                @if ($tipo->id_tipo == old('id_tipo', $subtipo->id_tipo ?? '')) selected = "selected" @endif>
                                {{ $tipo->nombre_tipo }}</option>
                        @endforeach
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" name="nombre_subtipo" class="form-control @error('nombre_subtipo') is-invalid @enderror" value=" {{old('nombre_subtipo', $subtipo->nombre_subtipo ?? '')}}" placeholder="Ingrese el Nombre del Subtipo">
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