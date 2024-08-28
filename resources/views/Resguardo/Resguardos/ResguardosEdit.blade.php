@extends('layouts.master')

@section('titulo', 'Resguardos de Articulos')

@section('titulo_pagina', 'Resguardos de Articulos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Resguardo</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('resgresguardos.index') }}">Resguardos</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Editar Resguardo de Articulo</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action=" {{ route('resgresguardos.update', $resguardo->id_resguardo) }}" enctype="multipart/form-data">
            @csrf @method("put")
            <input type="hidden" name="id_ubicacion" value="{{$resguardo->id_ubicacion}}">
            <input type="hidden" name="id_clasificacion" value="{{$resguardo->id_clasificacion}}">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Codigo</label>
                <div class="col-sm-2">
                    <input type="text" name="codigo_articulo" class="form-control @error('codigo_articulo') is-invalid @enderror" 
                    value=" {{old('codigo_articulo', $resguardo->codigo_articulo ?? '')}}" placeholder="Ingrese el Codigo del Articulo" readonly>
                </div>
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-6">
                    <input type="text" name="nombre_articulo" class="form-control @error('nombre_articulo') is-invalid @enderror" 
                    value=" {{old('nombre_articulo', $resguardo->nombre_articulo ?? '')}}" placeholder="Ingrese el Nombre del Articulo" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Cantidad</label>
                <div class="col-sm-2">
                    <input type="text" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror" 
                    value=" {{old('cantidad', number_format($resguardo->cantidad_disponible, 2) ?? '')}}" placeholder="Ingrese la Cantidad" readonly>
                </div>
                <label class="col-sm-2 col-form-label">Presentacion</label>
                <div class="col-sm-2">
                    <input type="text" name="unidad" class="form-control @error('unidad') is-invalid @enderror" 
                    value=" {{old('unidad',number_format($resguardo->equivalencia_unidad, 2).' '.$resguardo->tipo_unidad ?? '')}}" placeholder="Ingrese el Nombre de la Unidad" readonly>
                </div>
                <label class="col-sm-2 col-form-label">Disposicion Final</label>

                @can('resg.resguardos.editarclasificacion')
                    <div class="col-sm-2">
                        <select name="id_clasificacion" id="id_clasificacion"
                        class="js-example-basic-single form-control">
                        {{-- <option value="0">SELECCIONE EL ALMACEN</option> --}}
                        @foreach ($clasificaciones as $clasificacion)
                            <option value="{{$clasificacion->id_clasificacion}}" @if ($clasificacion->id_clasificacion == old('id_clasificacion', $resguardo->id_clasificacion )) ??  selected = "selected" @endif>
                                {{$clasificacion->nombre_clasificacion}}
                            </option>
                        @endforeach
                        </select>
                    </div>
                @else
                    <div class="col-sm-2">
                        <input type="text" name="nombre_clasificacion" class="form-control @error('nombre_clasificacion') is-invalid @enderror" 
                        value=" {{old('nombre_clasificacion', $resguardo->nombre_clasificacion ?? '')}}" placeholder="Ingrese el Nombre de la Clasificacion" readonly>
                    </div>
                @endcan

            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Observacion</label>
                <div class="col-sm-10">
                    <textarea name="observacion" class="form-control @error('observacion') is-invalid @enderror" 
                    rows="3" placeholder="Ingrese la Observacion" readonly>{{ old('observacion', $resguardo->observacion ?? '') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Ubicacion</label>
                @can('resg.resguardos.editarubicacion')
                    <div class="col-sm-2">
                        <select name="id_ubicacion" id="id_ubicacion"
                        class="js-example-basic-single form-control">
                        {{-- <option value="0">SELECCIONE EL ALMACEN</option> --}}
                            @foreach ($ubicaciones as $ubicacion)
                            <option value="{{$ubicacion->id_ubicacion}}" @if ($ubicacion->id_ubicacion == old('id_ubicacion', $resguardo->id_ubicacion )) ??  selected = "selected" @endif>
                                {{$ubicacion->nombre_ubicacion}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="col-sm-2">
                        <input type="text" name="nombre_ubicacion" class="form-control @error('nombre_ubicacion') is-invalid @enderror" 
                        value=" {{old('nombre_ubicacion', $resguardo->nombre_ubicacion ?? '')}}" placeholder="Ingrese el Nombre de la Ubicacion" readonly>
                    </div>
                @endcan
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
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
@endsection