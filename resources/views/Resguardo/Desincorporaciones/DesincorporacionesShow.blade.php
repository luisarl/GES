@extends('layouts.master')

@section('titulo', 'Solicitudes de Desincorporacion')

@section('titulo_pagina', 'Solicitud de Desincorporacion')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Resguardo</a> </li>
    <li class="breadcrumb-item"><a href="{{ url('resgdesincorporaciones') }}">Solicitudes Desincorporacion</a> </li>
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
                        <span class="txt-muted d-inline-block h6 m-r-10"><strong>CORRELATIVO Nº {{$solicitud->id_solicitud_desincorporacion}} </strong> </span>
                        
                        {{-- @if($salida->estatus != 'GENERADO') --}}
                            {{-- @can('asal.salidamateriales.imprimir') --}}
                                {{-- BOTON IMPRIMIR --}}
                                <a href="{{ route('resgimprimirsolicituddesincorporacion', $solicitud->id_solicitud_desincorporacion) }}" target="_blank" type="button"
                                    class="btn btn-primary btn-sm" title="Imprimir">
                                    <i class="fa fa-print fa-2x"></i> </a>

                            {{-- @endcan --}}
                        {{-- @endif     --}}
                        {{-- BOTON EDITAR --}}  
                        {{-- @if ($salida->anulado != 'SI')
                            @can('asal.salidamateriales.editar') --}}
                            <a href="{{ route('resgdesincorporaciones.edit', $solicitud->id_solicitud_desincorporacion) }}" type="button"
                                class="btn btn-primary btn-sm" title="Editar">
                                <i class="fa fa-edit fa-2x"></i> </a>
                          {{--  @endcan    
                        @endif
                        --}}
                        <span class="f-right">
                            <strong>ESTATUS: </strong>
                            @if($solicitud->estatus == 'POR APROBACION')
                                <label class="label label-info">POR APROBACION</label>
                            @elseif($solicitud->estatus == 'APROBADO')
                                <label class="label label-warning">APROBADO</label>
                            @elseif($solicitud->estatus == 'PROCESADO')
                                <label class="label label-success">PROCESADO</label>
                            @elseif($solicitud->estatus == 'ANULADO')
                                <label class="label label-danger">ANULADO</label>
                            @else
                                {{$solicitud->estatus}}
                        @endif
                        </span>
                        <br>
                        <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($solicitud->fecha_creacion)) }}">
                            <strong>CREADO: </strong> {{ $solicitud->creado_por }} </label>
                        <br>
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($solicitud->fecha_aprobacion)) }}">
                            <strong>APROBADO: </strong> {{  $solicitud->aprobado_por}} </label>
                            <br>
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ $solicitud->fecha_procesado  }}">
                            <strong>PROCESADO: </strong> {{  $solicitud->procesado_por}} </label>
                        <hr>
                    </div>
                    <div class="col-lg-6">
                       
                        <h6 class="txt-muted"><strong>SOLICITADO POR: </strong> {{$solicitud->creado_por}} </h6>
                        <h6 class="txt-muted"><strong>UNIDAD/ GERENCIA: </strong> {{$solicitud->nombre_departamento}} </h6>
                        
                    </div>
                    <div class="col-lg-6">
                        <h6 class="txt-muted"><strong>ALMACEN: </strong> {{$solicitud->nombre_almacen}} </h6>   
                    </div>
                    <div class="col-lg-12">
                        <hr>
                        <h6 class="txt-muted"><strong>RESPONSABLE: </strong> {{$solicitud->responsable}} </h6>
                        <h6 class="txt-muted"><strong>OBSERVACIONES: </strong> {{$solicitud->observacion}} </h6>
                        @if($solicitud->documento != null)
                            <h6 class="txt-muted"><strong>DOCUMENTO: </strong> 
                                <a href="{{asset($solicitud->documento)}}" target="_blank">{{explode('/', $solicitud->documento)[4]}}</a> 
                            </h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-block">
        <h4 class="sub-title">Articulos</h4>
        <div class="table-responsive">
            {{-- <form action="{{route('cerrarsalidaalmacen', $salida->id_salida )}}" method="POST"> --}}
            @csrf
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th style="width:5%">ITEM</th>
                        <th style="width:5%">SOLRESG</th>
                        <th style="width:10%">CODIGO</th>
                        <th style="width:30%">DESCRIPCIÓN</th>
                        <th style="width:5%">UNIDAD</th>
                        <th style="width:5%">CANT.</th>
                        <th style="width:10%">ESTADO</th>
                        <th style="width:10%">OBSERVACION</th>
                        <th style="width:15%">DISP. FINAL</th>
                        <th>UBICACION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articulos as $articulo)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$articulo->id_solicitud_resguardo}}</td>
                            <td>{{$articulo->codigo_articulo}}</td>
                            <td>{{$articulo->nombre_articulo}}</td>
                            <td>{{number_format($articulo->equivalencia_unidad, 2).' '.$articulo->tipo_unidad}}</td>
                            <td>{{number_format($articulo->cantidad, 2)}}</td>
                            <td>{{$articulo->estado}}</td>
                            <td>{{$articulo->observacion}}</td>
                            <td>{{$articulo->nombre_clasificacion}}</td>
                            <td>{{$articulo->nombre_ubicacion}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>  
    </div>
</div>
@endsection

@section('scripts')
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
</script>
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