@extends('layouts.master')

@section('titulo', 'Almacenes')

@section('titulo_pagina', 'Almacenes')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Configuración</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('almacenes.index') }}">Almacenes</a>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>
@endsection

@section('contenido')

@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Crear Almacen</h5>

    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form class="" method="POST" action=" {{ route('almacenes.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_almacen') is-invalid @enderror" name="nombre_almacen"
                       value="{{ old('nombre_almacen') }}" placeholder="Ingrese el Nombre del almacen">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 col-lg-2">
                    <label for="name-2" class="block">Empresa</label>
                </div>
                <div class="col-md-4 col-lg-4 @error('id_empresa') is-invalid @enderror">
                     <select name="id_empresa" class="js-example-basic-single form-control">
                        <option value="0">Seleccione la Empresa </option>
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id_empresa }}"
                                @if ($empresa->id_empresa == old('id_empresa')) selected = "selected" @endif>
                                {!! $empresa->nombre_empresa !!}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-md-2 col-lg-2">Visible en Control Herramienta</label>
                <div class="checkbox-zoom zoom-primary">
                 <label class="col-md-4 col-lg-4">
                     <input type="checkbox" value="SI" name="visible_cnth">
                     <span class="cr">
                         <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                     </span>
                     <span></span>
                 </label>
                </div>
                <label class="col-md-2 col-lg-2">Visible en Ficha Tecnica</label>
                <div class="checkbox-zoom zoom-primary">
                 <label class="col-md-4 col-lg-4">
                     <input type="checkbox" value="SI" name="visible_ficht">
                     <span class="cr">
                         <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                     </span>
                     <span></span>
                 </label>
                </div>
            </div>   
            <div class="form-group row">
                <label class="col-md-2 col-lg-2">Responsable</label>
                <div class="col-md-4 col-lg-4">
                   <input type="responsable" class="form-control @error('responsable') is-invalid @enderror" name="responsable"
                   value="{{ old('responsable') }}" placeholder="Ingrese el Nombre del Responsable">
               </div>
                <label class="col-md-2 col-lg-2">Correo Principal</label>
                <div class="col-md-4 col-lg-4">
                   <input type="correo" class="form-control @error('correo') is-invalid @enderror" name="correo"
                   value="{{ old('correo') }}" placeholder="Ingrese el Correo del Responsable">
               </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-lg-2">Responsable Superior</label>
                <div class="col-md-4 col-lg-4">
                   <input type="superior" class="form-control @error('superior') is-invalid @enderror" name="superior"
                   value="{{ old('superior') }}" placeholder="Ingrese el Nombre del Superior">
               </div>
               <label class="col-md-2 col-lg-2">Correo Superior</label>
               <div class="col-md-4 col-lg-4">
                  <input type="correo2" class="form-control @error('correo2') is-invalid @enderror" name="correo2"
                  value="{{ old('correo2') }}" placeholder="Ingrese el Correo Superior">
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