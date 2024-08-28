@extends('layouts.master')

@section('titulo', 'SubAlmacenes')

@section('titulo_pagina', 'Sub Almacenes')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Configuración</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('subalmacenes.index') }}">Sub Almacenes</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Subalmacen</h5>
        </div>
        <div class="card-block">

            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('subalmacenes.store') }}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Almacenes</label>
                    <div class="col-sm-10">
                        <select name="id_almacen"
                            class="js-example-basic-single form-control @error('id_almacen') is-invalid @enderror">
                            <option value="0">Seleccione almacen</option>
                            @foreach ($almacenes as $almacen)
                                <option value="{{ $almacen->id_almacen }}"
                                    @if ($almacen->id_almacen == old('id_almacen', $subalmacen->id_almacen ?? '')) selected = "selected" @endif>
                                    {{ $almacen->id_almacen }} - {!! $almacen->nombre_almacen !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Codigo</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control @error('codigo_subalmacen') is-invalid @enderror"
                            name="codigo_subalmacen" value="{{ old('codigo_subalmacen') }}" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('nombre_subalmacen') is-invalid @enderror"
                            name="nombre_subalmacen" value="{{ old('nombre_subalmacen') }}"
                            placeholder="Ingrese el Nombre del Subalmacen">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('descripcion_subalmacen') is-invalid @enderror"
                            name="descripcion_subalmacen" placeholder="Ingrese la Descripción del Subalmacen">{{ old('descripcion_subalmacen') }}</textarea>
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
