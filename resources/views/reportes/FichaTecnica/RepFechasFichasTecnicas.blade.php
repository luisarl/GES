@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte de Ficha Tecnica')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Fechas Fichas Tecnicas</a> </li>
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
                <label class="col-sm-12 col-md-1 form-label">Fecha Inicio</label>
                <div class="col-sm-12 col-md-2 ">
                    <input type="date" name="fecha_inicio" min="" id=""
                        class="form-control @error('fecha_inicio') is-invalid @enderror"
                        value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '') }}">
                </div>
                <label class="col-sm-12 col-md-1 form-label">Fecha Fin</label>
                <div class="col-sm-12 col-md-2 ">
                    <input type="date" name="fecha_fin" min="" id=""
                        class="form-control @error('fecha_fin') is-invalid @enderror"
                        value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '')  }}">
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
                {{-- <div class="col-auto">
                    <input type="submit" value="Exportar" name="excel" class="btn btn-primary mt-1 mb-1" OnClick="">
                        {{-- <i class="fa fa-file-excel-o"></i>Exportar
                    </input> 
                </div> --}}
                {{-- @endcan --}}
            </div>
            
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Creado</th>
                        <th>Fecha Creacion</th>
                        <th>Aprobado</th>
                        <th>Fecha Aprobacion</th>
                        <th>Catalogado</th>
                        <th>Fecha Catalogacion</th>
                    </tr>
                </thead>
                <tbody>
                @if($articulos != null) 
                    @foreach($articulos as $articulo)
                        <tr>
                            <td>{{$articulo->id_articulo}}</td>
                            <td>{{$articulo->codigo_articulo}}</td>
                            <td>{!!wordwrap($articulo->nombre_articulo, 25, '<br>')!!}</td>
                            <td>{{$articulo->creado_por}}</td>
                            <td>{{date('d-m-Y g:i:s A', strtotime($articulo->fecha_creacion))}}</td>
                            <td>{{$articulo->aprobado_por}}</td>
                            <td>
                                @if($articulo->aprobado_por != null)
                                    {{date('d-m-Y g:i:s A', strtotime($articulo->fecha_aprobacion))}}
                                @endif
                            </td>
                            <td>{{$articulo->catalogado_por}}</td>
                            <td>
                                @if($articulo->catalogado_por != null)
                                    {{date('d-m-Y g:i:s A', strtotime($articulo->fecha_catalogacion))}}
                                @endif
                            </td>
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

