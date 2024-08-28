@extends('layouts.master')

@section('titulo', 'Departamentos')

@section('titulo_pagina', 'Departamentos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Configuración</a> </li>
        <li class="breadcrumb-item"><a href="{{ asset('departamentos/') }}">Departamentos</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Departamento</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title">Datos</h4>
            <form class="" method="POST" action=" {{ route('departamentos.store') }}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('nombre_departamento') is-invalid @enderror" name="nombre_departamento"
                           value="{{ old('nombre_departamento') }}" placeholder="Ingrese el Nombre del Departamento">
                    </div>
                    <label class="col-sm-2 col-form-label">Prefijo</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('prefijo') is-invalid @enderror" name="prefijo"
                           value="{{ old('prefijo') }}" placeholder="Ingrese el Prefijo">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-">Nombre Responsable</label>
                    <div class="col-md-4 col-lg-4">
                        <input type="text" class="form-control @error('responsable') is-invalid @enderror" name="responsable"
                           value="{{ old('responsable') }}" placeholder="Ingrese el Nombre del Responsable">
                    </div>
                    <label class="col-md-2 col-lg-2">Correo Responsable</label>
                    <div class="col-md-4 col-lg-4">
                       <input type="correo" class="form-control @error('correo') is-invalid @enderror" name="correo"
                       value="{{ old('correo') }}" placeholder="Ingrese el Correo del Responsable">
                   </div>
                </div>
                <h4 class="sub-title">Servicios</h4>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-">Aplica Servicios</label>
                    <div class="col-sm-1 col-md-1 col-lg-1">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="checkbox" id="aplica_servicios" name="aplica_servicios" value="SI" >
                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                    <label class="col-md-2 col-lg-2">Correlativo Servicios</label>
                    <div class="col-md-2 col-lg-2">
                       <input type="text" class="form-control @error('correlativo_servicios') is-invalid @enderror" name="correlativo_servicios"
                       value="0" readonly>
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
