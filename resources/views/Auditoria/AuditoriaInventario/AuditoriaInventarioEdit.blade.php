@extends('layouts.master')

@section('titulo', 'Auditoria')

@section('titulo_pagina', 'Auditoria Inventario')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Auditoria</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('audiauditoriainventario.index') }}">Auditoria Inventario</a></li>
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Editar Toma Fisica </h5>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-12">
                <div class="card-block table-border-style">
                    <form action="{{ route('audiauditoriainventario.update', $articulo->id_auditoria_inventario) }}" method="post" enctype="multipart/form-data">
                        @csrf @method('put')

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Imagen</label>
                                <div class="col-sm-2 col-md-10">
                                    <div class="thumbnail img-100">
                                        <div class="thumb">
                                            <a href="{{ asset($articulo->fotografia ?? '') }} " data-lightbox="1"
                                                data-title="{{ $articulo->nombre_articulo ?? '' }}">
                                                <img src="{{ asset($articulo->fotografia ?? '') }}" alt=""
                                                    class="img-fluid img-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Codigo</label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="text" class="form-control" name="codigo_articulo" id="codigo_articulo"
                                        value="{{old('codigo_articulo', $articulo->codigo_articulo ?? '')}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="text" class="form-control" name="nombre_articulo" id="nombre_articulo"
                                        value="{{old('nombre_articulo', $articulo->nombre_articulo ?? '')}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                
                                <label for="" class="col-sm-2 col-md-2">Almacen</label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="text" name="almacen" id="" class="form-control" value="{{$articulo->nombre_almacen}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-md-2">SubAlmacen</label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="text" name="almacen" id="" class="form-control" value="{{$articulo->nombre_subalmacen}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2">Stock Actual</label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="text" name="stock_actual" id="" class="form-control" value="{{ number_format($articulo->stock_actual, 2) }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2">Conteo Fisico</label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="number" name="conteo_fisico" id="conteo_fisico" class="form-control @error('conteo_fisico') is-invalid @enderror" value="{{old('conteo_fisico', number_format($articulo->conteo_fisico, 2) ?? '')}}" readonly>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="" class="col-sm-2">Fecha</label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="text" name="fecha" id="" class="form-control  @error('fecha') is-invalid @enderror" value="{{old('fecha', date('d-m-Y g:i:s A', strtotime($articulo->fecha)) ?? '')}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2">Numero Auditoria</label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="number" name="numero_auditoria" id="" class="form-control  @error('numero_auditoria') is-invalid @enderror" value="{{old('numero_auditoria', $articulo->numero_auditoria ?? '')}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2">Observaciones Auditoria</label>
                                <div class="col-sm-10 col-md-10">
                                    <textarea name="observacion" id="observacion" class="form-control @error('observacion') is-invalid @enderror" cols="3" rows="3">{{old('obsevacion', $articulo->observacion ?? '')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-2">Fotografia </label>
                                <div class="col-sm-10 col-md-10">
                                    <input type="file" name="fotografia" id="" class="form-control">
                                </div>
                            </div>
                        <hr>
                        <div class="d-grid gap-2 d-md-block float-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i>Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src=" {{ asset('libraries\bower_components\lightbox2\js\lightbox.min.js') }} "></script>

<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
</script>

@endsection