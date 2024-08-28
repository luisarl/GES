@extends('layouts.master')

@section('titulo', 'Ver Resguardo')

@section('titulo_pagina', 'Ver  Resguardo')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Resguardo</a> </li>
    <li class="breadcrumb-item"><a href="{{ url('resgresguardos') }}">Resguardo</a> </li>
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
                        <strong>{{$resguardo->nombre_articulo}} </strong> 
                        
                        <span class="f-right">
                            <strong>ESTATUS: </strong>
                            @if($resguardo->estatus == 'POR PROCESAR')
                                <label class="label label-info">POR PROCESAR</label>
                            @elseif($resguardo->estatus == 'DISPONIBLE')
                                <label class="label label-success">DISPONIBLE</label>
                            @elseif($resguardo->estatus == 'DESINCORPORADO')
                                <label class="label label-danger">DESINCORPORADO</label>
                            @elseif($resguardo->estatus ='DESPACHADO')
                                <label class="label label-primary">DESPACHADO</label>  
                            @endif
                        </span>
                        <br>
                        <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($resguardo->fecha_creacion)) }}">
                            <strong>CREADO POR: </strong> {{ $resguardo->creado_por }} </label>
                        <br>
                        {{-- 
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($solicitud->fecha_aprobacion)) }}">
                            <strong>APROBADO: </strong> {{  $solicitud->aprobado_por}} </label>
                            <br>
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ $solicitud->fecha_procesado  }}">
                            <strong>PROCESADO: </strong> {{  $solicitud->procesado_por}} </label>
                            --}}
                        <hr> 
                    </div>
                    <div class="col-lg-6">
                        <h6 class="txt-muted"><strong>CODIGO ARTICULO: </strong> {{$resguardo->codigo_articulo}} </h6>
                        <h6 class="txt-muted"><strong>NOMBRE ARTICULO: </strong> {{$resguardo->nombre_articulo}} </h6>
                        <h6 class="txt-muted"><strong>PRESENTACION: </strong> {{number_format($resguardo->equivalencia_unidad, 2).' '.$resguardo->tipo_unidad}} </h6>
                        <h6 class="txt-muted"><strong>OBSERVACION: </strong> {{$resguardo->observacion}} </h6>
                        
                        
                    </div>
                    
                    <div class="col-lg-6">
                        <h6 class="txt-muted"><strong>UNIDAD/ GERENCIA: </strong> {{$resguardo->nombre_departamento}} </h6>
                        <h6 class="txt-muted"><strong>SOLICITUD RESGUARDO: </strong># {{$resguardo->id_solicitud_resguardo}} </h6>
                        <h6 class="txt-muted"><strong>ALMACEN: </strong> {{$resguardo->nombre_almacen}} </h6> 
                        <h6 class="txt-muted"><strong>UBICACION ACTUAL: </strong> {{$resguardo->nombre_ubicacion}} </h6>
                    </div>
                    
                    <div class="col-lg-12">
                        <hr>
                        <h6 class="txt-muted"><strong>CANTIDAD INICIAL: </strong> {{number_format($resguardo->cantidad, 2)}} </h6>
                        <h6 class="txt-muted"><strong>CANTIDAD DISPONIBLE: </strong> {{number_format($resguardo->cantidad_disponible, 2)}} </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-block">
        <h4 class="sub-title">Historico</h4>
        <div class="table-responsive">
            {{-- <form action="{{route('cerrarsalidaalmacen', $salida->id_salida )}}" method="POST"> --}}
            @csrf
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th style="width:5%">ID SOLICITUD</th>
                        <th style="width:10%">TIPO</th>
                        <th>FECHA</th>
                        <th style="width:5%">CANT.</th>
                        <th style="width:30%">RESPONSABLE</th>
                        <th style="width:30%">OBSERVACION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historicos as $historico)
                        <tr>
                            <td>{{$historico->id_solicitud}}</td>
                            <td>{{$historico->tipo}}</td>
                            <td>{{$historico->fecha_creacion}}</td>
                            <td>{{$historico->cantidad}}</td>
                            <td>{{$historico->responsable}}</td>
                            <td>{{$historico->observacion}}</td>
                        </tr>
                    @endforeach
                    {{-- @foreach($articulos as $articulo)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$articulo->codigo_articulo}}</td>
                            <td>{{$articulo->nombre_articulo}}</td>
                            <td>{{$articulo->equivalencia_unidad.' '.$articulo->tipo_unidad}}</td>
                            <td>{{number_format($articulo->cantidad, 2)}}</td>
                            <td>{{$articulo->estado}}</td>
                            <td>{{$articulo->observacion}}</td>
                            <td>{{$articulo->nombre_clasificacion}}</td>
                            <td>{{$articulo->nombre_ubicacion}}</td>
                        </tr>
                    @endforeach --}}
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