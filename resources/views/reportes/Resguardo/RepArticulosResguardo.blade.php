@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte de Articulos en Resguardo')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Articulos en Resguardo</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

@section('contenido')
<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>PARAMETROS DE BUSQUEDA</strong></h4>
    </div>
    <div class="card-block">
        <form method="GET" action="">
            {{-- @csrf --}}
            <div class="form-group row">
                <label class="col-sm-12 col-md-1 form-label">Almacen</label>
                <div class="col-sm-6 col-md-2">
                    <select name="id_almacen" id="_almacenes" class="js-example-basic-single form-control @error('id_almacen') is-invalid @enderror">
                        {{-- <option value="0">Almacenes</option> --}}
                        @foreach ($almacenes as $almacen)
                            <option value="{{ $almacen->id_almacen }}"
                                @if ($almacen->id_almacen == old('id_almacen',  $_GET['id_almacen'] ?? '')) selected="selected" @endif>
                                {!! $almacen->nombre_almacen !!}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-6 col-md-1 form-label">Disp. Final</label>
                <div class="col-sm-6 col-md-2 ">
                    <select name="id_clasificacion" class="js-example-basic-single form-control @error('estatus') is-invalid @enderror">
                        <option value="0">TODAS</option>
                        @foreach ($clasificaciones as $clasificacion)
                            <option value="{{ $clasificacion->id_clasificacion }}"
                                @if ($clasificacion->id_clasificacion == old('id_clasificacion',  $_GET['id_clasificacion'] ?? '')) selected="selected" @endif>
                                {{ $clasificacion->nombre_clasificacion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-1">
                </div>
                <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-1 mb-1" OnClick="">
                         {{-- <i class="fa fa-search"></i>Buscar
                    </input> --}} 
                </div>
                {{-- @can('repo.asal.listadosalidas.pdf') --}}
                <div class="col-auto">
                    <input type="submit" value="Imprimir" name="pdf" class="btn btn-primary mt-1 mb-1">
                        {{-- <i class="fa fa-print"></i>Imprimir
                    </input> --}}
                </div>
                {{-- @endcan --}}
               
                {{-- @can('repo.asal.listadosalidas.excel') --}}
                <div class="col-auto">
                    <label class="form-label"> </label>
                        <input type="submit" value="Exportar" name="excel" class="btn btn-primary mt-1 mb-1" OnClick=""></input>
                </div>
                {{-- @endcan --}}
            </div>
            
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th>Resg.</th>
                        <th>Solic. Resg.</th>
                        <th>Almacen</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Presentacion</th>
                        <th>Cantidad</th>
                        <th>Disp. Final</th>
                        <th>Observacion</th>
                        <th>Estado</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @if($resguardos != null)
                        @foreach ($resguardos as $resguardo)
                        <tr>
                            <td>{{$resguardo->id_resguardo}}</td>
                            <td>{{$resguardo->id_solicitud_resguardo}}</td>
                            <td>{{$resguardo->nombre_almacen}}</td>
                            <td>{{$resguardo->codigo_articulo}}</td>
                            <td>{!!wordwrap($resguardo->nombre_articulo, 30, '<br>')!!}</td>
                            <td>{{$resguardo->presentacion}}</td>
                            {{-- <td>{{number_format($resguardo->cantidad, 2)}}</td> --}}
                            <td>{{number_format($resguardo->cantidad_disponible, 2)}}</td>
                            <td>{{$resguardo->nombre_clasificacion}}</td>
                            <td>{{$resguardo->observacion}}</td>
                            <td>{{$resguardo->estado}}</td>
                            <td>{{$resguardo->estatus}}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
