@extends('layouts.master')

@section('titulo', 'Editar Consumible')

@section('titulo_pagina', 'Editar Consumible')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('cencconsumibles.index')}}">Centro de Corte</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('cencconsumibles.index') }}">Consumible</a></li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>
@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Editar Consumibles</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form class="" method="POST" action=" {{ route('cencconsumibles.update', $consumible->id_consumible) }}">
            @csrf @method('put')
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control @error('nombre_consumible') is-invalid @enderror" name="nombre_consumible"
                        value="{{ old('nombre_consumible', $consumible->nombre_consumible ??'')}}" placeholder="Ingrese el Nombre del Consumible">
                </div>

                <label class="col-sm-2 col-form-label">Unidad</label>
                <div class="col-sm-4">
                    <select name="unidad_consumible" id="unidad_consumible" class="js-example-basic-multiple form-control @error('responsables') is-invalid @enderror">
                        <option value="{{$consumible->unidad_consumible}}">{{$consumible->unidad_consumible}}</option>
                        <option value="unidad">Unidad</option>
                        <option value="mm">mm</option>
                        <option value="kg/cm2">kg/cm2</option>
                        <option value="m3/min">m3/min</option>
                        <option value="mm/min">mm/min</option>
                        <option value="lt/min">lt/min</option>
                        <option value="m/min">m/min</option>
                    </select>
                </div>

            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="3" cols="3" class="form-control @error('descripcion_consumible') is-invalid @enderror" name="descripcion_consumible"
                    placeholder="Ingrese la descripción de la tecnologia">{{old('descripcion_tecnologia', $consumible->descripcion_consumible ?? '')}}</textarea>
                </div>
            </div>
            <hr>
            <div class="float-right">
                <button type="submit" class="btn btn-primary ">
                    <i class="fa fa-save"></i>Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')


@endsection