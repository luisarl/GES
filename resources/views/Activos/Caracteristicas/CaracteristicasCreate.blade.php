@extends('layouts.master')

@section('titulo', 'Caracteristicas')

@section('titulo_pagina', 'Caracteristicas')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Activos</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('caracteristicasactivos.index') }}">Caracteristicas</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Caracteristica</h5>
        </div>
        <div class="card-block">

            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('caracteristicasactivos.store') }}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tipos</label>
                    <div class="col-sm-10  @error('id_tipo') is-invalid @enderror">
                        <select name="id_tipo" class="js-example-basic-single form-control @error('id_tipo') is-invalid @enderror" >
                            <option value="0">Seleccione el Tipo</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id_tipo }}"
                                    @if ($tipo->id_tipo == old('id_tipo')) selected = "selected" @endif>
                                    {{ $tipo->nombre_tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('nombre_caracteristica') is-invalid @enderror"
                            name="nombre_caracteristica" value="{{ old('nombre_caracteristica') }}"
                            placeholder="Ingrese el Nombre de la Caracteristica">
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
