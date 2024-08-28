@extends('layouts.master')

@section('titulo', 'Tipo de Activo')

@section('titulo_pagina', 'Tipo de Activo')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Salida de Materiales</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('asaltipos.index') }}">Tipos de Salidas</a>
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
        <h5>Editar Tipo de Salida</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('asaltipos.update', $tipo->id_tipo) }}" enctype="multipart/form-data">
            @csrf @method("put")
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_tipo') is-invalid @enderror" name="nombre_tipo" value="{{old('nombre_tipo', $tipo->nombre_tipo ?? '')}}" placeholder="Ingrese el Nombre del Tipo">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="3" cols="3" class="form-control @error('descripcion_tipo') is-invalid @enderror" name="descripcion_tipo"
                        placeholder="Ingrese la Descripción del Tipo">{{old('nombre_tipo', $tipo->descripcion_tipo ?? '')}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Estado</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="activo"
                                value="SI" @if($tipo->activo == 'SI') checked @endif> Activo </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="activo"
                                value="NO" @if($tipo->activo == 'NO') checked @endif> Inactivo </label>
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

@endsection