@extends('layouts.master')

@section('titulo', 'Crear Parametro')

@section('titulo_pagina', 'Crear Parametro')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('embaparametros.index') }}">Parametros</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Parametros</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('embaparametros.store') }}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('nombre_parametro') is-invalid @enderror" name="nombre_parametro"
                           value="{{ old('nombre_parametro') }}" placeholder="Ingrese el Nombre del parametro">
                    </div>

                    <label class="col-sm-2 col-form-label">Unidad</label>
                    <div class="col-sm-4 @error('id_unidad') is-invalid @enderror">
                        <select name="id_unidad" id="" data-old="{{ old('id_unidad') }}"
                                class="js-example-basic-single form-control" >
                            <option value="0">Seleccione la Unidad</option>
                            @foreach ($unidades as $unidad)
                                <option value="{{$unidad->id_unidad}}" @if ($unidad->id_unidad == old('id_unidad', $parametro->id_unidad ?? '')) selected = "selected" @endif>
                                    {{$unidad->nombre_unidad}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('descripcion_parametro') is-invalid @enderror" name="descripcion_parametro"
                            placeholder="Ingrese la Descripción del Parametro">{{ old('descripcion_parametro') }}</textarea>
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
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

@endsection
