@extends('layouts.master')

@section('titulo', 'Editar Novedad')

@section('titulo_pagina', 'Editar Novedad')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('embanovedades.index') }}">Novedades</a>
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
        <h5>Editar Novedad</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('embanovedades.update', $novedad->id_novedad) }}">
            @csrf @method("put")

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Asignar Embarcacion</label>
                <div class="col-sm-10">
                    <select name="id_embarcacion" id="id_embarcacion"
                        data-old="{{ old('id_embarcacion') }}"
                        class="js-example-basic-single form-control ">
                        <option value="0">Seleccione</option>
                        @foreach ($embarcaciones as $embarcacion)
                            <option value="{{$embarcacion->id_embarcaciones}}"@if ($embarcacion->id_embarcaciones == old('id_embarcacion', $novedad->id_embarcacion )) selected="selected" @endif>{{$embarcacion->nombre_embarcaciones}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Motivo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('motivo_novedad') is-invalid @enderror" name="motivo_novedad" value=" {{old('motivo_novedad', $novedad->motivo_novedad ?? '')}}" placeholder="Ingrese el Nombre de la Novedad">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="5" cols="3"class="form-control @error('descripcion_novedad') is-invalid @enderror" name="descripcion_novedad" placeholder="Ingrese la Descripción de la Novedad">{{old('descripcion_novedad', $novedad->descripcion_novedad ?? '')}}</textarea>
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