@extends('layouts.master')

@section('titulo', 'SubTipos De Salidas')

@section('titulo_pagina', 'SubTipos De Salidas')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Salida Materiales</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('asalsubtipos.index') }}">SubTipos</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjExitoso')

<div class="card">
    <div class="card-header">
        <h5>Editar Subtipo</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('asalsubtipos.update', $subtipo->id_subtipo) }}" enctype="multipart/form-data">
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
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="3" cols="3" class="form-control @error('descripcion_subtipo') is-invalid @enderror" name="descripcion_subtipo"
                        placeholder="Ingrese la Descripción del SubTipo">{{ old('descripcion_subtipo', $subtipo->descripcion_subtipo ?? '') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Estado</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="activo"
                                value="SI" @if($subtipo->activo == 'SI') checked @endif> Activo </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="activo"
                                value="NO" @if($subtipo->activo == 'NO') checked @endif> Inactivo </label>
                    </div>
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