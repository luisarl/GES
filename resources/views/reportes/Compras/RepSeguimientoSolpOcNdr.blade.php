@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte Seguimiento SOLP OC NDR')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Seguimiento SOLP OC NDR</a> </li>
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
                <div class="col-auto">
                    <input type="submit" value="Excel" name="excel" class="btn btn-primary mt-1 mb-1" OnClick="">
                        {{-- <i class="fa fa-file-excel-o"></i>Exportar
                    </input> --}}
                </div>
            </div>
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Solp</th>
                        <th>Fecha Solp</th>
                        <th>Oc</th>
                        <th>Fecha Oc</th>
                        <th>NDR</th>
                        <th>FecNdr</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seguimiento as $seguimiento)
                    <tr>
                        <td>{{$seguimiento->Empresa}}</td>
                        <td>{{$seguimiento->SolP}}</td>
                        <td>{{$seguimiento->FecSolP}}</td>
                        <td>{{$seguimiento->OC}}</td>
                        <td>{{$seguimiento->FecOC}}</td>
                        <td>{{$seguimiento->NDR}}</td>
                        <td>{{$seguimiento->FecNDR}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection