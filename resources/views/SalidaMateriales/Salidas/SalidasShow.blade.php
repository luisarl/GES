@extends('layouts.master')

@section('titulo', 'Autorización de Salida')

@section('titulo_pagina', 'Autorización de Salida')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('autorizacionsalidas') }}">Autorización de Salida</a> </li>
    <li class="breadcrumb-item"><a href="{{ url('autorizacionsalidas') }}">Salidas</a> </li>
    <li class="breadcrumb-item"><a href="#!">Ver Salida</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('SalidaMateriales.Salidas.SalidasValidar')
@include('SalidaMateriales.Salidas.SalidasValidarAlmacen')

<div class="card product-detail-page">
    <div class="card-block">
        <div class="row">
            <div class="col-lg-12 col-xs-12 product-detail" id="product-detail">
                <div class="row">
                    <div class="col-lg-12">
                        <span class="txt-muted d-inline-block h6"><strong>CORRELATIVO Nº {{$salida->id_salida}} </strong> </span>
                        
                        {{-- @if($salida->estatus != 'GENERADO') --}}
                            @can('asal.salidamateriales.imprimir')
                                {{-- BOTON IMPRIMIR --}}
                                <a href="{{ route('imprimirautorizacionsalidas', $salida->id_salida) }}" target="_blank" type="button"
                                    class="btn btn-primary btn-sm" title="Imprimir Formato Normal">
                                    <i class="fa fa-print fa-2x"> Normal</i> </a>
                                {{-- BOTON IMPRIMIR 2--}}
                                <a href="{{ route('imprimirautorizacionsalidas2', $salida->id_salida) }}" target="_blank" type="button"
                                    class="btn btn-primary btn-sm" title="Imprimir Formato Largo">
                                    <i class="fa fa-print fa-2x"> Largo</i> </a>
                            {{-- @endcan --}}
                        @endif    
                        {{-- BOTON EDITAR --}}  
                        @if ($salida->anulado != 'SI')
                            @can('asal.salidamateriales.editar')
                            <a href="{{ route('autorizacionsalidas.edit', $salida->id_salida) }}" type="button"
                                class="btn btn-primary btn-sm" title="Editar">
                                <i class="fa fa-edit fa-2x"></i> </a>
                            @endcan    
                        @endif
                        @if ($salida->estatus == 'VALIDADO/ABIERTO')
                            @can('asal.salidamateriales.retorno')
                                <a href="{{ route('retornosalidas', $salida->id_salida) }}" type="button"
                                    class="btn btn-primary btn-sm" title="Retorno">
                                <i class="icofont icofont-download-alt icofont-2x"></i></a>
                            @endcan
                        @endif
                        @if ($salida->estatus == 'VALIDADO/ABIERTO' || $salida->estatus == 'CERRADO')
                            @can('asal.salidamateriales.cerrar')
                                <a href="{{ route('cerrarsalidaalmacen', $salida->id_salida) }}" type="button"
                                    class="btn btn-primary btn-sm" title="Cierre Almacen">
                                <i class="fa fa-check-square-o fa-2x"></i></a>
                            @endcan       
                        @endif
                        <span class="f-right">
                            <strong>ESTATUS: </strong>
                            @if ($salida->estatus == 'GENERADO')
                                    <label class="label label-info">{{$salida->estatus}}</label>
                                @elseif($salida->estatus == 'VALIDADO/ALMACEN')
                                    <label class="label label-inverse">{{$salida->estatus}}</label>
                                @elseif($salida->estatus == 'VALIDADO/ABIERTO')
                                    <label class="label label-warning">{{$salida->estatus}}</label>
                                @elseif($salida->estatus == 'CERRADO')
                                    <label class="label label-primary">{{$salida->estatus}}</label>
                                @elseif($salida->estatus == 'CERRADO/ALMACEN')
                                    <label class="label label-success">{{$salida->estatus}}</label>
                                @elseif($salida->estatus == 'ANULADO')
                                    <label class="label label-danger">{{$salida->estatus}}</label>
                                @else
                                    {{$salida->estatus}}
                            @endif
                        </span>
                        <br>
                        <br>
                        <h6 class="txt-muted"><strong>FECHA ESTIMADA DE SALIDA: </strong> {{$salida->fecha_salida}}</h6>
                        <h6 class="txt-muted"><strong>HORA ESTIMADA DE SALIDA: </strong> {{$salida->hora_salida}}</h6>
                        <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ $salida->fecha_emision  }}">
                            <strong>CREADO: </strong> {{ $salida->creado_por }} </label>
                        <br>
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ $salida->fecha_validacion_almacen  }}">
                            <strong>VALIDADO/ALMACEN: </strong> {{ $salida->usuario_validacion_almacen }} </label>
                        <br>
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ $salida->fecha_validacion  }}">
                            <strong>VALIDADO/ABIERTO: </strong> {{ $salida->usuario_validacion }} </label>
                        <br>
                        <label data-toggle="popover" data-placement="bottom"  title="FECHA:" data-content="{{ $salida->fecha_cierre  }}">
                            <strong>CERRADO: </strong> {{ $salida->cerrado_por }} </label>  
                        <br>
                        <label data-toggle="popover" data-placement="bottom"  title="FECHA:" data-content="{{ $salida->fecha_cierre_almacen  }}">
                            <strong>CERRADO/ALMACEN: </strong> {{ $salida->usuario_cierre_almacen }} </label>    
                        <hr>
                    </div>
                    <div class="col-lg-6">
                       
                        <h6 class="txt-muted"><strong>SOLICITADO POR: </strong> {{$salida->solicitante}} </h6>
                        <h6 class="txt-muted"><strong>AUTORIZADO POR: </strong> {{$salida->autorizado}} </h6>
                        <h6 class="txt-muted"><strong>UNIDAD/ GERENCIA: </strong> {{$salida->departamento}} </h6>
                        <h6 class="txt-muted"><strong>RESPONSABLE: </strong> {{$salida->responsable}} </h6>
                    </div>
                    <div class="col-lg-6">
                        
                        <h6 class="txt-muted"><strong>CONDUCTOR: </strong> {{$salida->conductor}} </h6>
                        <h6 class="txt-muted"><strong>VEHICULO: </strong>
                            @if($salida->tipo_vehiculo == 'INTERNO')
                            {{$salida->vehiculo_interno}}
                            @else
                            {{$salida->vehiculo_foraneo}}
                            @endif
                        </h6>
                        <hr>
                        <h6 class="txt-muted"><strong>ALMACEN: </strong> {{$salida->nombre_almacen}} </h6>
                        <h6 class="txt-muted"><strong>TIPO SALIDA: </strong> {{$salida->nombre_tipo}} </h6>
                        <h6 class="txt-muted"><strong>MOTIVO SALIDA: </strong> {{$salida->nombre_subtipo}} </h6>
                    </div>
                    <div class="col-lg-12">
                        <hr>
                        <h6 class="txt-muted"><strong>DESTINO: </strong> {{$salida->destino}} </h6>
                        <hr>
                        <h6 class="txt-muted"><strong>ACTIVIDAD: </strong> {{$salida->motivo}} </h6>
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
            <table class="table table-striped table-bordered" id="">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Articulo</th>
                        <th>Comentario</th>
                        <th>Unidad</th>
                        <th>Cantidad Salida</th>
                        <th>Cantidad Pendiente</th>
                        <th>Fecha Retorno</th>
                        <th>Cantidad Retorno</th>
                        <th>Observacion Control</th>
                        <th>Importacion</th>
                        <th>Estatus</th>
                        <th>Observacion Almacen</th>
                    </tr>
                    @foreach ($articulos as $articulo)
                    @php
                        $TotalArticulos = $loop->count;
                        $CantidadPendiente = $articulo->cantidad_salida - $articulo->cantidad_retorno;
                    @endphp
                    @if ($articulo->cantidad_salida != NULL)
                        @if($articulo->estatus == 'CERRADO')
                            @php
                                $CantidadPendiente = 0; 
                            @endphp
                            @if($articulo->estatus == 'CERRADO' && $articulo->cerrado == 'SI')
                                <tr class="bg-warning">
                            @else
                                <tr class="table-success">
                            @endif
                               
                                <th style="visibility:collapse; display:none;">{{$articulo->id_detalle}}</th>
                                <th>{{ $articulo->item}}</th>
                                <th>{{ $articulo->codigo_articulo }}</th>
                                <th>{!! wordwrap($articulo->nombre_articulo, 30, "<br>" );  !!}</th>
                                {{-- <td>{{ $articulo->created_at }}</td> --}}
                                <th>{{ $articulo->comentario }}</th>
                                <th>{{ $articulo->tipo_unidad }}</th>
                                <th>{{ number_format($articulo->cantidad_salida, 2)}}</th>
                                <th>{{ $CantidadPendiente}}</th>
                                <th>{{ $articulo->fecha_retorno }}</th>
                                {{-- <td class="cantidad_pendiente">{{ $cantidad_pendiente }}</td>     --}}
                                <th></th>
                                <th></th>
                                <th>{{ $articulo->importacion }}</th>
                                <th>
                                    @if($articulo->cerrado != 'SI')
                                        {{$articulo->estatus}}
                                    @else
                                        CERRADO/ALMACEN
                                    @endif
                                <th>{!! wordwrap($articulo->observacion_almacen, 30, '<br>') !!}</th>        
                            </tr>
                        @else
                            <tr class="table-active">
                                <td>{{ $articulo->item}}</td>
                                <td>{{ $articulo->codigo_articulo }}</td>
                                <td>{!! wordwrap($articulo->nombre_articulo, 30, "<br>" ) !!}</td>
                                <td>{{ $articulo->comentario }}</td>
                                <td>{{ $articulo->tipo_unidad }}</td>
                                <td>{{ number_format($articulo->cantidad_salida, 2)}}</td>
                                <td>{{ $CantidadPendiente}}</td>
                                <td>{{ $articulo->fecha_retorno }}</td>
                                <td>0</td>
                                <td></td>
                                <td>{{ $articulo->importacion }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td colspan="7"> </td>
                            <td>{{ $articulo->fecha_retorno }}</td>
                            <td>{{ number_format($articulo->cantidad_retorno, 2) }}</td>
                            <td>{!! wordwrap($articulo->observacion, 30, '<br>') !!}</td>
                            <td></td>
                            <td>{{ $articulo->estatus }}</td>
                            <td></td>
                        </tr>
                    @endif
                    @endforeach
                </thead>
                <tbody>
                </tbody>
            </table>
           
        {{-- </form> --}}
        </div>
        <hr>
        
        <div class="float-right">
           @if($salida->estatus == 'GENERADO')
                @can('asal.salidamateriales.validar.almacen')
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-validar-almacen"
                    title="Aprobar" href="#!">
                    <i class="fa fa-check-square"></i>Aprobacion Almacen
                    </button>
                @endcan
            @elseif ($salida->estatus == 'VALIDADO/ALMACEN')
                @can('asal.salidamateriales.validar')
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-validar"
                        title="Validar" href="#!">
                        <i class="fa fa-check-square-o"></i>Validacion Seguridad
                    </button>
                @endcan
            @endif
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