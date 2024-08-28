@extends('layouts.master')

@section('titulo', 'Almacenes')

@section('titulo_pagina', 'Almacenes')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Configuración</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('subalmacenes.index') }}"> Subalmacenes</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>

@endsection

@section('contenido')
    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Editar Subalmacen</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form method="POST" action=" {{ route('subalmacenes.update', $subalmacen->id_subalmacen) }}"
                enctype="multipart/form-data">

                @csrf @method('put')
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Codigo</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control @error('codigo_subalmacen') is-invalid @enderror"
                            name="codigo_subalmacen" value="{{ old('codigo_subalmacen', $subalmacen-> codigo_subalmacen?? '') }}"
                            placeholder="Ingrese el Codigo del almacen">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                   <div class="col-sm-10">
                        <input type="text" class="form-control @error('nombre_subalmacen') is-invalid @enderror"
                            name="nombre_subalmacen" value=" {{ old('nombre_subalmacen', $subalmacen->nombre_subalmacen ?? '') }}"
                            placeholder="Ingrese el Nombre del subalmacen">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3"class="form-control @error('descripcion_subalmacen') is-invalid @enderror"
                            name="descripcion_subalmacen" placeholder="Ingrese la Descripción del subalmacen">{{ old('descripcion_subalmacen', $subalmacen
                            ->descripcion_subalmacen ?? '') }}</textarea>
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
