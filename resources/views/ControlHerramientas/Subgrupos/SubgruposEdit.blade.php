@extends('layouts.master')

@section('titulo', 'SubGrupos')

@section('titulo_pagina', 'SubGrupos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('cnthsubgrupos.index') }}">SubGrupos</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Editar SubGrupo</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('cnthsubgrupos.update', $cnthsubgrupo->id_subgrupo) }}" enctype="multipart/form-data">
            @csrf @method("put")

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Codigo</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control @error('codigo_subgrupo') is-invalid @enderror"
                        name="codigo_subgrupo" value="{{old('codigo_subgrupo', $cnthsubgrupo->codigo_subgrupo ?? '')}}" placeholder="" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_subgrupo') is-invalid @enderror" name="nombre_subgrupo" value=" {{old('nombre_subgrupo', $cnthsubgrupo->nombre_subgrupo ?? '')}}" placeholder="Ingrese el Nombre del SubGrupo">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="3" cols="3"class="form-control @error('descripcion_subgrupo') is-invalid @enderror" name="descripcion_subgrupo" placeholder="Ingrese la Descripción del SubGrupo">{{old('descripcion_subgrupo', $cnthsubgrupo->descripcion_subgrupo ?? '')}}</textarea>
                </div>
            </div>
           <div class="form-group row">
                <label class="col-sm-2 col-form-label">Grupo</label>
                <div class="col-sm-10 @error('id_grupo') is-invalid @enderror">
                    <select name="id_grupo" class="js-example-basic-single form-control" >
                    <option value="0">Seleccione el Grupo</option>
                    @foreach ($cnthgrupos as $grupo)
                        <option value="{{ $grupo->id_grupo }}"
                            @if ($grupo->id_grupo == old('id_grupo', $cnthsubgrupo->id_grupo ?? '')) selected = "selected" @endif>
                            {{$grupo->codigo_grupo}} - {!! $grupo->nombre_grupo !!}</option>
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