@extends('layouts.master')

@section('titulo', 'Solicitudes de Despacho')

@section('titulo_pagina', 'Solicitud de Despacho')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Control Combustible</a> </li>
    <li class="breadcrumb-item"><a href="{{route('cntcdespachos.index') }}">Solicitudes Despacho</a> </li>
    <li class="breadcrumb-item"><a href="#!">Ver</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')

<div class="card product-detail-page">
    <div class="card-block">
        <div class="row">
            <div class="col-lg-12 col-xs-12 product-detail" id="product-detail">
                <div class="row">
                    <div class="col-lg-12">
                    <span class="txt-muted d-inline-block h6 m-r-10"><strong>SOLICITUD Nº {{$solicitudes->id_solicitud_despacho}} </strong> </span>
                        
                      
                        
                            @if($solicitudes->estatus != 'ACEPTADO' &&$solicitudes->estatus != 'PROCESADO' && $solicitudes->estatus != 'ANULADO')
                                @can('cntc.despachos.editar')
                                    <a href="{{ route('cntcdespachos.edit', $solicitudes->id_solicitud_despacho) }}" type="button"
                                    class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fa fa-edit fa-2x"></i> </a>
                                @endcan
                            @elseif($solicitudes->estatus != 'PROCESADO'&& $solicitudes->estatus != 'ANULADO')
                                @can('cntc.despachos.despachar')
                                    <a href="{{ route('cntcdespacharsolicituddespacho', $solicitudes->id_solicitud_despacho) }}" type="button"
                                    class="btn btn-primary btn-sm" title="Despachar">
                                    <i class="zmdi zmdi-local-gas-station fa-2x"></i> Despachar</a>
                                @endcan
                            @endif
                            
                      
                        <span class="f-right">
                            <strong>ESTATUS: </strong>
                            @if($solicitudes->estatus == 'POR ACEPTAR')
                                <label class="label label-warning">POR ACEPTAR</label>
                            @elseif($solicitudes->estatus == 'ACEPTADO')
                                <label class="label label-info">ACEPTADO</label>
                            @elseif($solicitudes->estatus == 'PROCESADO')
                                <label class="label label-success">PROCESADO</label>
                            @elseif($solicitudes->estatus == 'ANULADO')
                                <label class="label label-danger">ANULADO</label>
                        @endif
                        </span>
                        <br>
                        <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($solicitudes->fecha_creacion)) }}">
                            <strong>CREADO: </strong> {{ $solicitudes->creado_por }} </label>
                        <br>
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($solicitudes->fecha_aceptado)) }}">
                            <strong>ACEPTADO: </strong> {{  $solicitudes->aceptado_por}} </label>
                        <br>
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($solicitudes->fecha_aprobacion)) }}">
                            <strong>PROCESADO: </strong> {{  $solicitudes->aprobado_por}} </label>
                            <br>
                       
                        <hr>
                    </div>
                    <div class="col-lg-6">
                       
                        <h6 class="txt-muted"><strong>SOLICITADO POR: </strong> {{$solicitudes->creado_por}} </h6>
                        <h6 class="txt-muted"><strong>UNIDAD/ GERENCIA: </strong> {{$solicitudes->nombre_departamento}} </h6>
                        
                    </div>
                    <div class="col-lg-6">
                        <h6 class="txt-muted"><strong>TIPO DE COMBUSTIBLE: </strong> {{$solicitudes->descripcion_combustible}} </h6>
                        <h6 class="txt-muted"><strong>MOTIVO: </strong> {{$solicitudes->motivo}} </h6>   
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-block">
        <h4 class="sub-title">Equipos</h4>
        <div class="table-responsive">
         
            @csrf
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th style="width:5%">Marca/Nombre Equipo</th>
                        <th style="width:10%">PLACA</th>
                        <th style="width:10%">Responsable</th>
                        <th style="width:10%">Departamento Solc</th>
                        <th style="width:5%">Cant.Solicitada</th>
                        @if($solicitudes->estatus == 'PROCESADO')
                        <th style="width:5%">Cant.Despachada</th>
                        <th style="width:5%">Fecha.Despacho</th>
                        @endif
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipos as $equipo)
                        <tr>
                            <td>{{$equipo->marca_equipo}}</td>
                            <td>{{$equipo->placa_equipo}}</td>
                            <td>{{$equipo->responsable}}</td>
                            <td>{{$equipo->nombre_departamento}}</td>
                            <td>{{number_format($equipo->cantidad, 2)}}</td>
                            @if($solicitudes->estatus == 'PROCESADO')
                            <td>{{number_format($equipo->cantidad_despachada,2)}}</td>
                            <td>{{ date('d-m-Y', strtotime($equipo->fecha_despacho)) }}</td>
                            @endif
                            
                         
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>  
        <div class="d-grid gap-2 float-right">
            <div class="text-end">
                <label><strong>TOTAL SOLICITADO:</strong> {{number_format($solicitudes->total,2) }} LT</label>
                <br>
                @if($solicitudes->estatus == 'PROCESADO')
                    <label><strong>TOTAL DESPACHADO:</strong> {{number_format($solicitudes->total_despachado,2)}} LT</label>
                @endif
            </div>
            <br>
            <div class="text-end float-right" >
                @if($solicitudes->estatus != 'ACEPTADO' && $solicitudes->estatus != 'PROCESADO' && $solicitudes->estatus != 'ANULADO' )
                    @can('cntc.despachos.aceptar')
                    <a href="{{ route('cntcaceptarsolicituddespacho', $solicitudes->id_solicitud_despacho) }}" type="button"
                        class="btn btn-primary btn-sm" title="">
                        <i class="fa fa-check fa-2x"></i> ACEPTAR
                    </a>
                    @endcan
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            html: true,
            content: function() {
                return $('#primary-popover-content').html();
            }
        });
    });
</script>
@endsection
