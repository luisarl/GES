@extends('layouts.master')

@section('titulo', 'SubClasificacion')

@section('titulo_pagina', 'SubClasificacion')
@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Ficha Tecnica</a> </li>
        <li class="breadcrumb-item"><a href="{{ asset('subclasificaciones/') }}">SubClasificacion</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>
@endsection

@section('contenido')
    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Sub Clasificacion</h5>

        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('subclasificaciones.store') }}">
                @csrf
                <div class="form-group row">
                    {{-- <div class="col-md-4 col-lg-4"> --}}
                        <label class="col-sm-2 col-form-label">Visible en Ficha Tenica</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                    <input class="form-check-input" type="radio"  name="visible_fict" id="visible_fict" value="SI" > SI </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                    <input class="form-check-input" type="radio"  name="visible_fict" id="visible_fict" value="NO" > NO </label>
                                </div>
                                <span class="messages"></span>
                            </div>
                    {{-- </div> --}}
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Clasificacion</label>
                    <div class="col-sm-8">
                        <select name="id_clasificacion"
                            class="js-example-basic-single form-control @error('id_clasificacion') is-invalid @enderror">
                            <option value="0">Seleccione Clasificacion</option>
                            @foreach ($clasificaciones as $clasificacion)
                                <option value="{{ $clasificacion->id_clasificacion }}"
                                    @if ($clasificacion->id_clasificacion == old('id_clasificacion', $subclasificacion->id_clasificacion ?? '')) selected = "selected" @endif>
                                     {!! $clasificacion->nombre_clasificacion !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('nombre_subclasificacion') is-invalid @enderror"
                            name="nombre_subclasificacion" value="{{ old('nombre_subclasificacion') }}"
                            placeholder="Ingrese el Nombre de la SubClasificacion">
                    </div>
                </div>   --}}
                <div class="form-group row"> 
                    <label class="col-sm-2 col-form-label">Nombre SubClasificacion</label>
                    <div class="col-sm-8">
                        <select name="nombre_subclasificacion[]" value="{{ old('nombre_subclasificacion') }}" class="js-example-tags col-sm-12" multiple="multiple">
                            <option value="0"></option>
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
