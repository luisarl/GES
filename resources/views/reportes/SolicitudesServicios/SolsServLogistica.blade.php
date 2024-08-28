@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte de Servicios')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Reporte Servicios</a> </li>
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
                        <option value="EN PROCESO" @if ('EN PROCESO'==old('estatus', $_GET['estatus'] ?? '' ))
                            selected="selected" @endif>EN PROCESO</option>
                        <option value="POR ACEPTAR" @if ('POR ACEPTAR'==old('estatus', $_GET['estatus'] ?? '')) 
                            selected="selected" @endif>POR ACEPTAR</option>
                        <option value="ABIERTO" @if ('ABIERTO'==old('estatus', $_GET['estatus'] ?? '' ))
                            selected="selected" @endif>ABIERTO</option>
                        <option value="FINALIZADO" @if ('FINALIZADO'==old('estatus', $_GET['estatus'] ?? '')) 
                            selected="selected" @endif>FINALIZADO</option>
                        <option value="CERRADO" @if ('CERRADO'==old('estatus', $_GET['estatus'] ?? '' ))
                            selected="selected" @endif>CERRADO</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-1">
                </div>
                <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-1 mb-1" OnClick="">
                </div>
                @can('repo.solicitudes.logistica.pdf')
                <div class="col-auto">
                    <input type="submit" value="Imprimir" name="pdf" class="btn btn-primary mt-1 mb-1">
                </div>
                @endcan
            </div>           
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>
        @php
        $contador = 1;
        @endphp
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>ID Solicitud</th>
                        <th>Solicitante</th>
                        <th>Departamento</th>
                        <th>Servicio</th>
                        <th>Subservicio</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha/Hora Solicitud</th>
                        <th>Fecha/hora Requerimiento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitudes as $solicitud) 
                    <tr>
                        <td>{{$contador++}}</td>
                        <td>{{$solicitud->id_solicitud}}</td>
                        <td>{{$solicitud->name}}</td>
                        <td>{{$solicitud->nombre_departamento}}</td>
                        <td>{{$solicitud->nombre_servicio}}</td>
                        <td>{{$solicitud->nombre_subservicio}}</td>
                        <td>{{$solicitud->logistica_origen}}</td> 
                        <td>{{$solicitud->logistica_destino}}</td>
                        <td>{{date('d-m-Y g:i:s A', strtotime($solicitud->fecha_creacion))}}</td>
                        <td>{{date('d-m-Y g:i:s A', strtotime($solicitud->logistica_fecha))}}</td>
                    </tr>
                    @endforeach
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

{{-- <!-- personalizado -->
<script>
    var route = "{{ url('unidadesarticulo') }}"; 
    var importarnde = "{{ url('importarnde') }}"; 
</script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\AsalSalidas.js') }}"></script> --}}