@extends('layouts.master')

@section('titulo', 'SubGrupos')

@section('titulo_pagina', 'SubGrupos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Ficha Tecnica</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('subgrupos.index') }}">SubGrupos</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear SubGrupo</h5>
        </div>
        <div class="card-block">

            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('subgrupos.store') }}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Grupo</label>
                    <div class="col-sm-10">
                        <select name="id_grupo" class="js-example-basic-single form-control @error('id_grupo') is-invalid @enderror" >
                            <option value="0">Seleccione Grupo</option>
                            @foreach ($grupos as $grupo)
                                <option value="{{ $grupo->id_grupo }}"
                                    @if ($grupo->id_grupo == old('id_grupo', $subgrupo->id_grupo ?? '')) selected = "selected" @endif>
                                    {{$grupo->codigo_grupo}} - {!! $grupo->nombre_grupo !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Codigo</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control @error('codigo_subgrupo') is-invalid @enderror"
                            name="codigo_subgrupo" value="{{old('codigo_subgrupo')}}" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('nombre_subgrupo') is-invalid @enderror"
                            name="nombre_subgrupo" value="{{ old('nombre_subgrupo') }}"
                            placeholder="Ingrese el Nombre del SubGrupo">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('descripcion_subgrupo') is-invalid @enderror"
                            name="descripcion_subgrupo"
                            placeholder="Ingrese la Descripción del SubGrupo">{{ old('descripcion_subgrupo') }}</textarea>
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
