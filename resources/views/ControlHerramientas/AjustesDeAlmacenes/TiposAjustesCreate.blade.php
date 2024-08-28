@extends('layouts.master')

@section('titulo', 'Tipo de Ajuste')

@section('titulo_pagina', 'Tipo de Ajuste')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Control herramientas</a> </li>
    <li class="breadcrumb-item"><a href="{{ asset('tiposajustes/') }}">Tipo de Ajustes</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
</ul>
@endsection
@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Grupo</h5>

        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form class="" method="POST" action="">
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 col-lg-2">Codigo</label>
                    <div class="col-md-4 col-lg-4">
                        <input type="number"
                            class="form-control @error('') is-invalid @enderror"
                            name="" value=""
                            placeholder="Solo llenar por el catalogador">
                    </div>
                    <label class="col-md-2 col-lg-2">Nombre</label>
                    <div class="col-md-4 col-lg-4">
                        <input type="text" class="form-control @error('') is-invalid @enderror" name=""
                           value="" placeholder="Ingrese el Nombre del Grupo">
                    </div>
                </div>
 
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('') is-invalid @enderror" name=""
                            placeholder="Ingrese la Descripción del Grupo"></textarea>
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
