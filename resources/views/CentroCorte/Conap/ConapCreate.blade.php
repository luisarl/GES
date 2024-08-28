@extends('layouts.master')

@section('titulo', 'Conap')

@section('titulo_pagina', 'Consulta de Aprovechamiento - CONAP')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Centro de Corte</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('cencconap.index') }}">Conap</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection


@section('contenido')

@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

    <div class="card">
        <div class="card-header">
            <h5>Crear Conap</h5>
        </div>
        <div class="card-block">
            <form class="" method="POST" action=" {{ route('cencconap.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nº Conap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('asunto_solicitud') is-invalid @enderror" name="nro_conap" id="nro_conap" 
                         placeholder="Ingrese número del conap" value="{{$idconap}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('asunto_solicitud') is-invalid @enderror" name="nombre_conap" id="nombre_conap"
                        value="{{ old('asunto_solicitud') }}" placeholder="Ingrese nombre">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('descripcion_conap') is-invalid @enderror" name="descripcion_conap" 
                            placeholder="Ingrese la descripción del conap">{{ old('descripcion_conap') }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="documentos" class="col-sm-2 col-md-2 col-lg-2 col-form-label">Archivos</label>
                    <div class="col-md-10 col-lg-10 @error('documentos') is-invalid @enderror">
                        <input type="file" name="documentos" id="filer_input" value="{{old('documentos[]') }}">
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
  
      <!-- jquery file upload js -->
    <script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

@endsection