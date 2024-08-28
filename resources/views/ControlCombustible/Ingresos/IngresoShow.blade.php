@extends('layouts.master')

@section('titulo', 'Solicitudes de Ingresos')

@section('titulo_pagina', 'Solicitud de Ingresos')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Control Combustible</a> </li>
    <li class="breadcrumb-item"><a href="{{route('cntcingresos.index') }}">Solicitudes Ingresos</a> </li>
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
                    <div class="col-lg-5">

                        <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($solicitudes->fecha_creacion)) }}">
                            <strong>CREADO: </strong> {{ $solicitudes->creado_por }} </label>
                        <br>
               
                    </div>
               
                    <div class="col-lg-5">
                        <h6 class="txt-muted"><strong>TIPO DE COMBUSTIBLE: </strong> {{$solicitudes->descripcion_combustible}} </h6>
                          <h6 class="txt-muted"><strong>UNIDAD/ GERENCIA: </strong> {{$solicitudes->nombre_departamento}} </h6>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-block">
        <h4 class="sub-title">Totales</h4>
        <div class="table-responsive">
         
            @csrf
            
        </div>  
        <div class="form-group row">
            <div class="col-sm-2">
                  <label><strong>TOTAL INGRESADO</strong></label>
                  <input type="number" value="{{number_format($solicitudes->cantidad,2)}}" class="form-control" disabled>
            </div>
            <div class="col-sm-2">
                 <label><strong>TOTAL STOCK ANTERIOR</strong></label>
                 <input type="number" value="{{number_format( $solicitudes->stock_anterior,2) }}" class="form-control" disabled>
            </div>
            <div class="col-sm-2">
                <label><strong>TOTAL STOCK FINAL</strong></label>
                <input type="number" value="{{number_format( $solicitudes->stock_anterior + $solicitudes->cantidad,2) }}" class="form-control" disabled>
            </div>
            <div class="col-sm-2">
                <label><strong>OBSERVACION</strong></label>
                <input type="text" value="{{ $solicitudes->observacion }}" class="form-control" disabled>
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
