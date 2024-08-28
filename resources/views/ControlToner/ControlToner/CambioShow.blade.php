@extends('layouts.master')

@section('titulo', 'Control de Toner')

@section('titulo_pagina', 'Control de Toner')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Control Toner</a> </li>
    <li class="breadcrumb-item"><a href="{{route('cnttcontroltoner.index') }}">Cambio de Toner</a> </li>
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
                    <span class="txt-muted d-inline-block h6 m-r-10"><strong>REEMPLAZO Nº {{$reemplazo->id_reemplazo_toner}} </strong> </span>
                        
                      
                                @can('cntc.despachos.editar')
                                    <a href="{{ route('cnttcontroltoner.edit', $reemplazo->id_reemplazo_toner) }}" type="button"
                                    class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fa fa-edit fa-2x"></i> </a>
                                @endcan
                          
                            
                        <br>
                        <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ date('d-m-Y ', strtotime($reemplazo->fecha_cambio)) }}">
                            <strong>CREADO: </strong>{{$reemplazo->creado_por}} </label>
                        <br>
                      
                        <hr>
                    </div>
                    <div class="col-lg-6">
                       
                        <h6 class="txt-muted"><strong>UNIDAD/ GERENCIA: </strong> {{$reemplazo->nombre_departamento}} </h6>
                        <h6 class="txt-muted"><strong>UBICACION: </strong> {{$reemplazo->ubicacion}} </h6>
                    </div>
                    <div class="col-lg-6">
                       
                        <h6 class="txt-muted"><strong>OBSERVACION: </strong> {{$reemplazo->observacion}} </h6>
                        <h6 class="txt-muted"><strong>TIPO DE SERVICIO: </strong> {{$reemplazo->tipo_servicio}} </h6>      
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-block">
        <h4 class="sub-title">Control</h4>
        <div class="table-responsive">
         
            @csrf
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th style="width:5%">Equipo</th>
                        <th style="width:2%">Fecha Cambio actual</th>
                        <th style="width:2%">Fecha Cambio anterior</th>
                        <th style="width:1%">Cant.Hojas.Actual</th>
                        <th style="width:1%">Cant.Hojas.Anterior</th>
                        <th style="width:1%">Cant.Hojas.Total</th>
                        <th style="width:1%">Dias de Duracion del Toner</th>  
                    </tr>
                </thead>
                <tbody>
                    
                        <tr>
                            <td>{{$reemplazo->nombre_activo}}</td>
                            <td>{{ date('d-m-Y', strtotime($reemplazo->fecha_cambio)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($reemplazo->fecha_cambio_anterior)) }}</td>
                            <td>{{number_format($reemplazo->cantidad_hojas_actual,2)}}</td>
                            <td>{{number_format($reemplazo->cantidad_hojas_anterior,2)}}</td>
                            <td>{{number_format($reemplazo->cantidad_hojas_total,2)}}</td>
                            <td>{{$reemplazo->dias_de_duracion}}</td>
                         
                            
                        </tr>
                  
                </tbody>
            </table>
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
