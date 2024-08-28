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
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>
@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Editar Almacen</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('almacenes.update', $almacen->id_almacen) }}" enctype="multipart/form-data">
            @csrf @method("put")
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_almacen') is-invalid @enderror" name="nombre_almacen" value=" {{old('nombre_almacen', $almacen->nombre_almacen ?? '')}}" placeholder="Ingrese el Nombre del almacen">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 col-lg-2">
                    <label for="name-2" class="block">Empresa</label>
                </div>
                <div class="col-md-4 col-lg-4 @error('id_grupo') is-invalid @enderror">
                     <select name="id_empresa" class="js-example-basic-single form-control">
                        <option value="0">Seleccione la Empresa </option>
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id_empresa }}"
                                @if ($empresa->id_empresa == old('id_empresa', $almacen->id_empresa ?? '')) selected = "selected" @endif>
                                {!! $empresa->nombre_empresa !!}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-md-2 col-lg-2">Visible en Control Herramienta</label>
                <div class="checkbox-zoom zoom-primary">
                 <label class="col-md-4 col-lg-4">
                     <input type="checkbox" name="visible_cnth" @if (str_replace(" ","", $almacen->visible_cnth) == 'SI') checked @endif >
                     <span class="cr">
                         <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                     </span>
                     <span></span>
                 </label>
                </div>
                <label class="col-md-2 col-lg-2">Visible en Ficha Tecnica</label>
                <div class="checkbox-zoom zoom-primary">
                 <label class="col-md-4 col-lg-4">
                     <input type="checkbox" name="visible_ficht" @if (str_replace(" ","", $almacen->visible_ficht) == 'SI') checked @endif >
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
                    <input type="text" class="form-control @error('responsable') is-invalid @enderror" name="responsable" value=" {{old('responsable', $almacen->responsable ?? '')}}" placeholder="Ingrese el nombre del Responsable">
                </div>
                <label class="col-md-2 col-lg-2">Correo Principal</label>
                <div class="col-md-4 col-lg-4">
                    <input type="text" class="form-control @error('correo') is-invalid @enderror" name="correo" value=" {{old('correo', $almacen->correo ?? '')}}" placeholder="Ingrese el Correo principal">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-lg-2">Superior</label>
                    <div class="col-md-4 col-lg-4">
                        <input type="text" class="form-control @error('superior') is-invalid @enderror" name="superior" value=" {{old('superior', $almacen->superior ?? '')}}" placeholder="Ingrese el nombre del Superior">
                    </div>
                <label class="col-md-2 col-lg-2">Correo Superior</label>
                    <div class="col-md-4 col-lg-4">
                        <input type="text" class="form-control @error('correo2') is-invalid @enderror" name="correo2" value=" {{old('correo2', $almacen->correo2 ?? '')}}" placeholder="Ingrese el Correo Superior ">
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

@endsection