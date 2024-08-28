@extends('layouts.master')

@section('titulo', 'Ubicaciones')

@section('titulo_pagina', 'Ubicaciones')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('ubicaciones/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
        <li class="breadcrumb-item"><a href="">Ubicacion</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Crear Ubicacion</h5>
    </div>
    <div class="card-block">

        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('ubicaciones.update', $ubicacion->id_ubicacion) }}" enctype="multipart/form-data">
            @csrf @method("put")
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Codigo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('codigo_ubicacion') is-invalid @enderror"
                        name="codigo_ubicacion" value="{{ old('codigo_ubicacion', $ubicacion->codigo_ubicacion ?? '') }}" placeholder=""  readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_ubicacion') is-invalid @enderror"
                        name="nombre_ubicacion" value="{{ old('nombre_ubicacion', $ubicacion->nombre_ubicacion ?? '') }}"
                        placeholder="Ingrese el Nombre de la Ubicacion">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Almacenes</label>
                <div class="col-sm-10">
                    <select name="id_almacen" class="js-example-basic-single form-control @error('id_almacen') is-invalid @enderror" >
                        <option value="0">Seleccione Almacenes</option>
                        @foreach ($almacenes as $almacen)
                            <option value="{{ $almacen->id_almacen }}"
                                @if ($almacen->id_almacen == old('id_almacen', $ubicacion->id_almacen ?? '')) selected = "selected" @endif>
                                {!! $almacen->nombre_almacen !!}</option>
                        @endforeach
                    </select>
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
