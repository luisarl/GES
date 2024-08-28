@extends('layouts.master')

@section('titulo', 'Categorias')

@section('titulo_pagina', 'Categorias')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Ficha Tecnica</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}">Categorias</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Editar Categoria</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('categorias.update', $categoria->id_categoria) }}" enctype="multipart/form-data">
            @csrf @method("put")
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Codigo</label>
                <div class="col-sm-10">
                    <input type="number"
                        class="form-control @error('codigo_categoria') is-invalid @enderror"
                        name="codigo_categoria"
                        value="{{ old('cod_categoria_profit', $categoria->codigo_categoria ?? '') }}"
                        placeholder="Solo llenar por el catalogador" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_categoria') is-invalid @enderror" name="nombre_categoria" value=" {{old('nombre_categoria', $categoria->nombre_categoria ?? '')}}" placeholder="Ingrese el Nombre de la Categoria">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="3" cols="3"class="form-control @error('descripcion_categoria') is-invalid @enderror" name="descripcion_categoria" placeholder="Ingrese la Descripción de la Categoria">{{old('descripcion_categoria', $categoria->descripcion_categoria ?? '')}}</textarea>
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