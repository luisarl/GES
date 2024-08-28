@extends('layouts.master')

@section('titulo', 'Ubicaciones')

@section('titulo_pagina', 'Ubicaciones')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Ficha Tecnica</a> </li>
        <li class="breadcrumb-item"><a href="{{ url('ubicacionesarticulos/') }}">Ubicacion</a>
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
        <form class="" method="POST" action=" {{ route('ubicacionesarticulos.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-12 col-md-1 form-label">Almacenes</label>
                    <div class="col-md-4 @error('id_almacen') is-invalid @enderror">
                        <select name="id_almacen" id="_almacenes" class="js-example-basic-single form-control @error('id_almacen') is-invalid @enderror">
                            <option value="0">Seleccione el Almacén</option>
                            @foreach ($almacenes as $almacen)
                                <option value="{{ $almacen->id_almacen }}"
                                    @if ($almacen->id_almacen == old('id_almacen')) selected="selected" @endif>
                                    {!! $almacen->nombre_almacen !!}</option>
                            @endforeach
                        </select>
                    </div>
                     <label class="col-sm-6 col-md-2 form-label">Sub Almacen</label>
                    <div class="col-md-4">
                        <div class="@error('id_subalmacen') is-invalid @enderror">
                            <select name="id_subalmacen" id="_subalmacenes"
                                data-old="{{ old('id_subalmacen') }}"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-1 form-label">Codigo</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control @error('codigo_ubicacion') is-invalid @enderror"
                            name="codigo_ubicacion" value="{{old('codigo_ubicacion')}}" placeholder="">
                    </div>
                <label class="col-sm-6 col-md-2 form-label">Nombre de la Zona</label>
                     <div class="col-md-4">
                        <input type="text" class="form-control @error('nombre_ubicacion') is-invalid @enderror"
                            name="nombre_ubicacion" value="{{ old('nombre_ubicacion') }}"
                            placeholder="Ingrese el Nombre de la Ubicacion">
                    </div>
            </div>

            {{-- <div class="form-group row">
                <label class="col-sm-2 col-form-label">Subalmacenes</label>
                <div class="col-sm-10 @error('id_subalmacen') is-invalid @enderror">
                    <select name="id_subalmacen" id="id_subalmacen" class="js-example-basic-single form-control">
                        <option value="0">Seleccione Subalmacenes</option>
                        @foreach ($subalmacenes as $subalmacen)
                            <option value="{{ $subalmacen->id_subalmacen }}"
                                @if ($subalmacen->id_subalmacen == old('id_subalmacen', $ubicacion->id_subalmacen ?? '')) selected = "selected" @endif>
                                {!! $subalmacen->codigo_subalmacen !!} - {!! $subalmacen->nombre_subalmacen !!}</option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
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


    <!--Personalizado -->
    <script>
        var obtenersubalmacen = "{{ url('obtenersubalmacen') }}"; 
        var obtenerzonas = "{{ url('obtenerzonas') }}"; 
    </script>
    <script src="{{ asset('libraries\assets\js\FictUbicaciones.js') }}"></script>

@endsection
