@extends('layouts.master')

@section('titulo', 'Tecnologia')

@section('titulo_pagina', 'Tecnologia')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('cenctecnologia.index')}}">Centro de Corte</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('cenctecnologia.index') }}">Tecnologia</a></li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>
@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Editar Tecnologia</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('cenctecnologia.update', $tecnologia->id_tecnologia) }}" enctype="multipart/form-data">
            @csrf @method("put")

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_tecnologia') is-invalid @enderror" name="nombre_tecnologia"
                        value="{{ old('nombre_tecnologia', $tecnologia->nombre_tecnologia ??'')}}" placeholder="Ingrese nombre de la tecnologia">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="3" cols="3" class="form-control @error('descripcion_tecnologia') is-invalid @enderror" name="descripcion_tecnologia"
                        placeholder="Ingrese la descripción de la tecnologia">{{old('descripcion_tecnologia', $tecnologia->descripcion_tecnologia ?? '')}}</textarea>
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

<!-- jquery file upload js -->
<script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

@endsection
