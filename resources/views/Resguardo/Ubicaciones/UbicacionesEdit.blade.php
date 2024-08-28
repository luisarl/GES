@extends('layouts.master')

@section('titulo', 'Ubicaciones')

@section('titulo_pagina', 'Ubicaciones')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Resguardo</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('resgubicaciones.index') }}">Ubicaciones</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Editar Ubicacion</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('resgubicaciones.update', $ubicacion->id_ubicacion) }}" enctype="multipart/form-data">
            @csrf @method("put")

           <div class="form-group row">
                <label class="col-sm-2 col-form-label">Almacen</label>
                <div class="col-sm-5 @error('id_almacen') is-invalid @enderror">
                    <select name="id_almacen" id="id_almacen"
                        class="js-example-basic-single form-control">
                        <option value="0">SELECCIONE EL ALMACEN</option>
                        @foreach ($almacenes as $almacen)
                        <option value="{{ $almacen->id_almacen }}" @if ($almacen->id_almacen == old('id_almacen',
                            $ubicacion->id_almacen ?? '')) selected = "selected" @endif>
                            {!! $almacen->nombre_almacen !!}</option>
                        @endforeach
                    </select>
                </div>
           </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" name="nombre_ubicacion" class="form-control @error('nombre_ubicacion') is-invalid @enderror" value="{{old('nombre_ubicacion', $ubicacion->nombre_ubicacion ?? '')}}" placeholder="Ingrese el Nombre de la Ubicacion">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripcion</label>
                <div class="col-sm-10">
                    <textarea name="descripcion_ubicacion" class="form-control @error('descripcion_ubicacion') is-invalid @enderror" 
                    rows="3" placeholder="Ingrese la Descripcion">{{ old('descripcion_ubicacion', $ubicacion->descripcion_ubicacion ?? '') }}</textarea>
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