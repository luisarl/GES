@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte de Salidas')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Reporte Salidas</a> </li>
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
                <label class="col-sm-6 col-md-1 form-label">Estatus</label>
                <div class="col-sm-6 col-md-2 ">
                    <select name="estatus"
                        class="js-example-basic-single form-control @error('estatus') is-invalid @enderror">
                        <option value="TODOS" @if ('TODOS'==old('estatus', $_GET['estatus'] ?? '' )) selected="selected"
                            @endif>TODOS</option>
                        <option value="GENERADO" @if ('GENERADO'==old('estatus', $_GET['estatus'] ?? '' ))
                            selected="selected" @endif>GENERADO</option>
                        <option value="VALIDADO/ABIERTO" @if ('VALIDADO/ABIERTO'==old('estatus', $_GET['estatus'] ?? ''
                            )) selected="selected" @endif>VALIDADO/ABIERTO</option>
                        <option value="CERRADO" @if ('CERRADO'==old('estatus', $_GET['estatus'] ?? '' ))
                            selected="selected" @endif>CERRADO</option>
                        <option value="CERRADO/ALMACEN" @if ('CERRADO/ALMACEN'==old('estatus', $_GET['estatus'] ?? '' ))
                            selected="selected" @endif>CERRADO/ALMACEN</option>
                    </select>
                </div>
                <label class="col-sm-12 col-md-1 form-label">Almacen</label>
                    <div class="col-sm-6 col-md-2">
                        <select name="id_almacen" id="_almacenes" class="js-example-basic-single form-control @error('id_almacen') is-invalid @enderror">
                            <option value="0">Almacenes</option>
                            @foreach ($almacenes as $almacen)
                                <option value="{{ $almacen->id_almacen }}"
                                    @if ($almacen->id_almacen == old('id_almacen',  $_GET['id_almacen'] ?? '')) selected="selected" @endif>
                                    {!! $almacen->nombre_almacen !!}</option>
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
                @can('repo.asal.listadosalidasauditoria.pdf')
                <div class="col-auto">
                    <input type="submit" value="Imprimir" name="pdf" class="btn btn-primary mt-1 mb-1">
                        {{-- <i class="fa fa-print"></i>Imprimir
                    </input> --}}
                </div>
                @endcan
                {{-- @can('repo.asal.listadosalidas.excel')
                <div class="col-auto">
                    <input type="submit" value="Exportar" name="excel" class="btn btn-primary mt-1 mb-1" OnClick="">
                        {{-- <i class="fa fa-file-excel-o"></i>Exportar
                    </input> 
                </div>
                @endcan --}}
            </div>
            
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Fecha Creación</th>
                        <th>Departamento</th>
                        <th>Estatus</th>
                        <th>Validacion Almacen</th>
                        <th>Validacion Control</th>
                        <th>Fecha Cierre Control</th>
                        <th>Fecha Cierre Almacen</th>
                    </tr>
                </thead>
                <tbody>
                @if ($salidas != null)
                    @foreach ($salidas as $salida)
                    <tr>
                        <td>{{$salida->id_salida}}</td>
                        <td>{{$salida->fecha_creacion}}</td>
                        <td>{{$salida->departamento}}</td>
                        <td>{{$salida->estatus}}</td>
                        <td>{{$salida->fecha_validacion_almacen}}</td>
                        <td>{{$salida->fecha_validacion_control}}</td>
                        <td>{{$salida->fecha_cierre}}</td>
                        <td>{{$salida->fecha_cierre_almacen}}</td>
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

<!-- personalizado -->
<script>
    var route = "{{ url('unidadesarticulo') }}"; 
    var importarnde = "{{ url('importarnde') }}"; 
</script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\AsalSalidas.js') }}"></script>