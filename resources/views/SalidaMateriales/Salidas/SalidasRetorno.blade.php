@extends('layouts.master')

@section('titulo', 'Retorno de Salida')

@section('titulo_pagina', 'Retorno de Salida')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('autorizacionsalidas') }}">Autorización de Salida</a> </li>
    <li class="breadcrumb-item"><a href="{{ url('autorizacionsalidas') }}">Salidas</a> </li>
    <li class="breadcrumb-item"><a href="#!">Retorno Salida</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('SalidaMateriales.Salidas.SalidasValidar')

<div class="card product-detail-page">
    <div class="card-block">
        <div class="row">
            <div class="col-lg-12 col-xs-12 product-detail" id="product-detail">
                <div class="row">
                    <div class="col-lg-12">
                        <span class="txt-muted d-inline-block h6"><strong>CORRELATIVO Nº {{$salida->id_salida}} </strong> </span>
                        
                        {{-- BOTON IMPRIMIR --}}
                        {{-- <a href="{{ route('imprimirautorizacionsalidas', $salida->id_salida) }}" target="_blank" type="button"
                            class="btn btn-primary btn-sm" title="Imprimir">
                            <i class="fa fa-print fa-2x"></i> </a> --}}
                        {{-- BOTON EDITAR --}}  
                        {{-- @if ($salida->anulado != 'SI')
                            @can('asal.salida.materiales.salidas.editar')
                            <a href="{{ route('autorizacionsalidas.edit', $salida->id_salida) }}" type="button"
                                class="btn btn-primary btn-sm" title="Editar">
                                <i class="fa fa-edit fa-2x"></i> </a>
                            @endcan    
                        @endif --}}
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
                            <strong>CREADO POR: </strong> {{ $salida->creado_por }} </label>
                        <br>
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ $salida->fecha_validacion  }}">
                            <strong>VALIDADO POR: </strong> {{ $salida->usuario_validacion }} </label>
                        <br>
                        <label data-toggle="popover" data-placement="bottom"  title="FECHA:" data-content="{{ $salida->fecha_cierre  }}">
                            <strong>CERRADO POR: </strong> {{ $salida->cerrado_por }} </label>    
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

        <form method="POST" action="{{ route('guardaretornosalidas', $salida->id_salida) }}"
            enctype="multipart/form-data">
            @csrf @method('put')
            {{-- <div class="row"> --}}
                <div class="table-responsive">
                    <table id="tablaretorno" class="listado_herramientas table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="visibility:collapse; display:none;">Id detalle</th>
                                <th>#</th>
                                <th>Codigo</th>
                                <th>Articulo</th>
                                <th>Comentario</th>
                                <th>Unidad</th>
                                <th>Cantidad Salida</th>
                                <th>Cantidad Pendiente</th>
                                <th>Fecha Retorno</th>
                                <th>Cantidad Retorno</th>
                                <th>Estatus</th>
                                <th>Observación</th>
                               
                            </tr>
                        </thead>
                        <tbody>
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
                                    
                                    <tr class="table-success">
                                        <th class="retorna" style="visibility:collapse; display:none;">NO</th>
                                        <th style="visibility:collapse; display:none;">{{$articulo->id_detalle}}</th>
                                        <th>{{ $articulo->item}}</th>
                                        <th>{{ $articulo->codigo_articulo }}</th>
                                        <th>{{ $articulo->nombre_articulo }}</th>
                                        {{-- <td>{{ $articulo->created_at }}</td> --}}
                                        <th>{{ $articulo->comentario }}</th>
                                        <th>{{ $articulo->tipo_unidad }}</th>
                                        <th>{{ number_format($articulo->cantidad_salida, 2)}}</th>
                                        <th>{{ $CantidadPendiente}}</th>
                                        <th>{{ $articulo->fecha_retorno }}</th>
                                        {{-- <td class="cantidad_pendiente">{{ $cantidad_pendiente }}</td>     --}}
                                        <th></th>
                                        <th>{{$articulo->estatus}}</th>
                                        <th></th>
                                    </tr>
                                
                                @else

                                    <tr class="table-active">
                                        <th class="retorna" style="visibility:collapse; display:none;">SI</th>
                                        <td class="id_detalle" style="visibility:collapse; display:none;">{{$articulo->id_detalle}}</td>
                                        <td class="item">{{ $articulo->item}}</td>
                                        <td class="codigo_articulo">{{ $articulo->codigo_articulo }}</td>
                                        <td class="nombre_articulo">{!! wordwrap($articulo->nombre_articulo, 30, "<br>" ) !!}</td>
                                        {{-- <td>{{ $articulo->created_at }}</td> --}}
                                        <td class="comentario">{{ $articulo->comentario }}</td>
                                        <td class="unidad">{{ $articulo->tipo_unidad }}</td>
                                        <td class="">{{number_format($articulo->cantidad_salida, 2)}}</td>
                                        <td class="cantidad_salida">{{ $CantidadPendiente}}</td>
                                        <td class="fecha_retorno">{{ $articulo->fecha_retorno }}</td>
                                        {{-- <td class="cantidad_pendiente">{{ $cantidad_pendiente }}</td>     --}}
                                        @if ($articulo->cantidad_salida < 1)
                                            @php
                                                $intervalo = '0.10';
                                            @endphp
                                        @else
                                            @php
                                                $intervalo = 1;
                                            @endphp
                                        @endif

                                        <td class="cantidad_retorno" id="cantidad_retorno{{$loop->iteration}}" data-type="number" data-min="0" data-max="{{$CantidadPendiente}}" data-step="{{$intervalo}}">0</td>
                                        <td class="estatus" id="estatus{{$loop->iteration}}" data-type="select" data-value="" data-prepend=" "
                                            data-source='[{value: 2, text: "CERRADO"}]'>
                                        </td>
                                        <td class="observacion" id="observacion{{$loop->iteration}}" data-type="textarea"
                                            data-rows="3" data-cols="3" data-value="" data-prepend="Ingrese Eventualidad">
                                        </td>
                                    </tr>
                                @endif
                            @else
                            <tr>
                                <th class="retorna" style="visibility:collapse; display:none;">NO</th>
                                <td class="item" style="visibility:collapse; display:none;">0</td>
                                <td colspan="7"> </td>
                                <td>{{ $articulo->fecha_retorno }}</td>
                                <td>{{ number_format($articulo->cantidad_retorno, 2 )}}</td>
                                <td class="estatus">{{ $articulo->estatus }}</td>
                                <td>{{ $articulo->observacion }}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @if($salida->estatus == 'VALIDADO/ABIERTO')
            <div class="row text-center">
                {{-- Campo oculto con arreglo de los datos recepcion --}}
                <input type="hidden" name="datosretorno" id="datosretorno">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTablaRetorno()">RECIBIR</button>
                </div>
            </div>
            @endif
        </form>    
    </div>
</div>
@endsection

@section('scripts')
<!-- Custom js -->
<script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>

<!--Personalizado -->
<script src="{{ asset('libraries\assets\js\AsalSalidas.js') }}"></script>

<!-- Bootstrap Editable -->
<script src="{{ asset('libraries/bower_components/bootstrap-editable/js/bootstrap-editable.min.js')}}"></script>
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

<script type="text/javascript">
    $.fn.editable.defaults.mode = 'inline';

        let TotalArticulos = {!! json_encode($TotalArticulos) !!};
        
        for(let i= 1; i <= TotalArticulos; i++) 
        {
            $('#cantidad_retorno'+i).editable();
            $('#estatus'+i).editable();
            $('#observacion'+i).editable();
        }
      
</script>

@endsection