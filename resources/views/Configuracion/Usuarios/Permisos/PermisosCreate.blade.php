@extends('layouts.master')

@section('titulo', 'Permisos')

@section('titulo_pagina', 'Permisos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{!! url('/') !!}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Configuración</a> </li>
        <li class="breadcrumb-item"><a href="#!">Permisos de Usuarios</a> </li>
    </ul>
@endsection

@section('contenido')
    @include('mensajes.MsjExitoso')
    @include('mensajes.MsjError')
    <!-- Scroll - Vertical table end -->
<div class="card">
    <div class="card-header">
        <h5>Crear Permisos</h5>

    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form class="" method="POST" action=" {{ route('permisos.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre del permiso</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                       value="{{ old('name') }}" placeholder="Ingrese el nombre del Permiso">
                </div>
            </div>
            <div class="d-grid gap-2 d-md-block float-right">
                <button type="submit" class="btn btn-success ">
                    <i class="fa fa-save"></i>Guardar
                </button>
            </div>
        </form>

    </div>
</div>
@endsection