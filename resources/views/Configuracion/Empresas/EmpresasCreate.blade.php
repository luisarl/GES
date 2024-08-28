@extends('layouts.master')

@section('titulo', 'Empresas')

@section('titulo_pagina', 'Empresas')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Configuración</a> </li>
        <li class="breadcrumb-item"><a href="{{ asset('empresas/') }}">Empresas</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Crear Empresa</h5>

    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form class="" method="POST" action=" {{ route('empresas.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_empresa') is-invalid @enderror" name="nombre_empresa"
                       value="{{ old('nombre_empresa') }}" placeholder="Ingrese el Nombre de la Empresa">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Alias Empresa</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('alias_empresa') is-invalid @enderror" name="alias_empresa"
                       value="{{ old('alias_empresa') }}" placeholder="Ingrese el Alias de la Empresa">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-lg-2">Direccion</label>
                <div class="col-md-4 col-lg-4">
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion"
                       value="{{ old('direccion') }}" placeholder="Ingrese la direccion de la Empresa">
                </div>
               <label class="col-md-2 col-lg-2">RIF:</label>
               <div class="col-md-4 col-lg-4">
                  <input type="text" class="form-control @error('rif') is-invalid @enderror" name="rif"
                  value="{{ old('rif') }}" placeholder="J-0000000">
              </div>
           </div>
            <div class="form-group row">
                <label class="col-md-2 col-lg-2">Presidente</label>
                <div class="col-md-4 col-lg-4">
                   <input type="presidente" class="form-control @error('presidente') is-invalid @enderror" name="presidente"
                   value="{{ old('presidente') }}" placeholder="Ingrese el Nombre del Presidente">
               </div>
                <label class="col-md-2 col-lg-2">Correo Presidente</label>
                <div class="col-md-4 col-lg-4">
                   <input type="correo_presidente" class="form-control @error('correo_presidente') is-invalid @enderror" name="correo_presidente"
                   value="{{ old('correo_presidente') }}" placeholder="Ingrese el Correo Presidente">
               </div>
            </div>
           <div class="form-group row">
            <label class="col-md-2 col-lg-2">Responsable Almacen</label>
            <div class="col-md-4 col-lg-4">
               <input type="responsable_almacen" class="form-control @error('responsable_almacen') is-invalid @enderror" name="responsable_almacen"
               value="{{ old('responsable_almacen') }}" placeholder="Ingrese el Nombre del Responsable">
           </div>
            <label class="col-md-2 col-lg-2">Correo Responsable</label>
            <div class="col-md-4 col-lg-4">
               <input type="correo_responsable" class="form-control @error('correo_responsable') is-invalid @enderror" name="correo_responsable"
               value="{{ old('correo_responsable') }}" placeholder="Ingrese el Correo del Responsable">
           </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-lg-2">Superior Almacen</label>
            <div class="col-md-4 col-lg-4">
               <input type="superior_almacen" class="form-control @error('superior_almacen') is-invalid @enderror" name="superior_almacen"
               value="{{ old('superior_almacen') }}" placeholder="Ingrese el Nombre del Responsable">
           </div>
            <label class="col-md-2 col-lg-2">Correo Superior</label>
            <div class="col-md-4 col-lg-4">
               <input type="correo_superior" class="form-control @error('correo_superior') is-invalid @enderror" name="correo_superior"
               value="{{ old('correo_superior') }}" placeholder="Ingrese el Correo del Superior">
           </div>
        </div> 
        <div class="form-group row">
            <label class="col-md-2 col-lg-2">Base de Datos</label>
            <div class="col-md-4 col-lg-4">
                <input type="text" class="form-control @error('base_datos') is-invalid @enderror" name="base_datos"
                   value="{{ old('base_datos') }}" placeholder="Ingrese nombre de la Base de Datos">
            </div>
           <label class="col-md-2 col-lg-2">Visible en Ficha Tecnica</label>
           <div class="checkbox-zoom zoom-primary">
                <label class="col-md-4 col-lg-4">
                    <input type="checkbox" id="visible_ficht" name="visible_ficht" value="SI">
                    <span class="cr">
                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                    </span>
                    <span></span>
                </label>
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
