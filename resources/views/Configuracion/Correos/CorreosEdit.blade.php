@extends('layouts.master')

@section('titulo', 'Usuarios')

@section('titulo_pagina', 'Asignacion de Correo')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Configuración</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('correos.index') }}">Correos</a>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>
@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Asignar Correo</h5>

    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('correos.update', $correo->id_correo) }}"  enctype="multipart/form-data">
            @csrf @method('put')
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Usuario</label>
                <div class="col-sm-10">
                    <select name="id_usuario" class="form-control @error('id_usuario') is-invalid @enderror" >
                        <option value="0">Seleccione Usuario</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id_usuario }}"
                                @if ($usuario->id == old('id_usuario', $correo->id_usuario ?? '')) 
                                selected = "selected" @endif>{!! $usuario->name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Modulo</label>
                <div class="col-sm-10">
                    <select name="modulo" class="form-control @error('modulo') is-invalid @enderror">
                        <option value="0">Seleccione el Modulo</option>
                        <option value="FICT"
                        @if ("FICT" == old('modulo', $correo->modulo ?? '')) selected = "selected" @endif>FICHA TECNICA</option>
                        <option value="COMP"
                        @if ("COMP" == old('modulo', $correo->modulo ?? '')) selected = "selected" @endif>COMPRAS</option>
                        <option value="ASAL"
                        @if ("ASAL" == old('modulo', $correo->modulo ?? '')) selected = "selected" @endif>AUTORIZACION SALIDAS</option>
                        <option value="CNTH"
                        @if ("CNTH" == old('modulo', $correo->modulo ?? '')) selected = "selected" @endif>CONTROL HERRAMIENTA</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre Destinatario</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_destinatario') is-invalid @enderror" name="nombre_destinatario"
                       value="{{ old('nombre_destinatario', $correo->nombre_destinatario ?? '') }}" placeholder="Ingrese el Nombre del destinatario">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Correo Destinatario</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('correo_destinatario') is-invalid @enderror" name="correo_destinatario"
                       value="{{ old('correo_destinatario', $correo->correo_destinatario ?? '') }}" placeholder="Ingrese el correo del destinatario ">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Proceso</label>
                <div class="col-sm-10">
                    <select name="proceso" class="form-control @error('proceso') is-invalid @enderror" >
                        <option value="0">Seleccione Proceso</option>
                        <option value="CREAR"
                            @if ("CREAR" == old('proceso', $correo->proceso ?? '')) selected = "selected" @endif> CREAR </option>
                        <option value="EDITAR"
                            @if ("EDITAR" == old('proceso', $correo->proceso ?? '')) selected = "selected" @endif> EDITAR </option>
                            <option value="ELIMINAR"
                            @if ("ELIMINAR" == old('proceso', $correo->proceso ?? '')) selected = "selected" @endif> ELIMINAR </option>
                        <option value="MIGRAR"
                            @if ("MIGRAR" == old('proceso', $correo->proceso ?? '')) selected = "selected" @endif> MIGRAR </option>
                            <option value="APROBAR"
                            @if ("APROBAR" == old('proceso', $correo->proceso ?? '')) selected = "selected" @endif> APROBAR </option>
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
{{-- <!--Forms - Wizard js-->
        <script src="{{ asset('libraries\bower_components\jquery.cookie\js\jquery.cookie.js') }}"></script>
<script src="{{ asset('libraries\bower_components\jquery.steps\js\jquery.steps.js') }}"></script>
<script src="{{ asset('libraries\bower_components\jquery-validation\js\jquery.validate.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\forms-wizard-validation\form-wizard.js') }}"></script>

<!-- jquery file upload js -->
<script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script> --}}
@endsection