@extends('layouts.master')

@section('titulo', 'Articulo')

@section('titulo_pagina', 'Articulos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('articulos.index') }}">Articulos</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Ficha Tecnica</a> </li>
    </ul>

@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="row card-header">  
        <div class=" col-6">
            <h4>FICHA TECNICA Nº {{$articulo->id_articulo}}
                <a href="{{ route('fichatecnica', $articulo->id_articulo) }}" target="_blank" type="button"
                    class="btn btn-primary btn-sm" title="Descargar">
                    <i class="fa fa-download"></i> </a>

            </h4> 
            <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ $responsables->fecha_creacion  }}">
                <strong> SOLICITADO POR: </strong> {{ $responsables->creado_por }} </label>
            <br>
            <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ $responsables->fecha_aprobacion  }}">
                <strong> APROBADO POR: </strong> {{ $responsables->aprobado_por }} </label>
            <br>
            <label data-toggle="popover" data-placement="bottom"  title="FECHA:" data-content="{{ $responsables->fecha_catalogacion  }}">
                <strong> CATALOGADO POR: </strong> {{ $responsables->catalogado_por }} </label>
        </div>
        <div class="col-6">
            @if (str_replace(" ","",$articulo->activo) == 'NO')
                <h1 class="text-danger">ARTICULO INACTIVO</h1>
            @endif    
        </div>
        <div class="col-12"> 
            <hr> 
        </div>
    </div>
    <div class="row ">
        <div class="col-md-8">
            <div class="invoice-box row">
                <div class="col-sm-12">

                    <table class="table table-responsive invoice-table table-borderless">
                        <tbody>
                            <tr>
                                <th></th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>CODIGO: {{$articulo->codigo_articulo}}</th>
                            </tr>
                            <tr>
                                <th>REFERENCIA: {{$articulo->referencia}}</th>
                            </tr>
                            <tr>
                                <th>NOMBRE: {{$articulo->nombre_articulo}}</th>
                            </tr>
                            <tr>
                                <th>DESCRIPCIÓN: {{$articulo->descripcion_articulo}}</th>
                            </tr>
                        @if ($articulo->documento_articulo != "")
                            <tr>
                                <th>
                                    DOCUMENTO ASOCIADO : <br>
                                    <a href="{{ asset($articulo->documento_articulo) }}" target="_blank" type="button"
                                        class="btn btn-primary" title="Descargar">
                                        <i class="fa fa-file fa-lg"></i> </a>
                                </th>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3">
            @foreach ($imagenes as $imagen)
                <div class="thumbnail">
                    <div class="thumb">
                        <a href="{{ asset($imagen->imagen) }} " data-lightbox="1"
                            data-title="{{ $articulo->nombre_articulo }}">
                            @if($loop->first)
                                <img src="{{ asset($imagen->imagen) }}" alt="" width="200px" height="200px"
                                    class="img-fluid img-thumbnail">
                            @endif        
                        </a>
                        
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card-block">
        <div class="row invoive-info">
            <div class="col-md-6 col-sm-6 ">
                <h6>Información :</h6>
                <table class="table table-responsive invoice-table invoice-order table-borderless">
                    <tbody>
                        <tr>
                            <th>GRUPO : </th>
                            <td>&nbsp;&nbsp;{{$articulo->nombre_grupo}}</td>
                        </tr>
                        <tr>
                            <th>SUBGRUPO : </th>
                            <td>&nbsp;&nbsp;{{$articulo->nombre_subgrupo}}</td>
                        </tr>
                        <tr>
                            <th>CATEGORIA : </th>
                            <td>&nbsp;&nbsp;{{$articulo->nombre_categoria}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6 col-sm-6">
                <h6>Unidades :</h6>
                <table class="table table-responsive invoice-table invoice-order table-borderless">
                    <tbody>
                        <tr>
                            <th colspan="">Tipo de Unidad :</th>
                            <th>&nbsp;&nbsp;{{$articulo->tipo_unidad}}</th>
                        </tr>
                        <tr>
                            <th>PRIMARIA :</th>
                            <td>&nbsp;&nbsp;{{$articulo->nombre_unidad}}</td>
                        </tr>
                        <tr>
                            <th>SECUNDARIA :</th>
                            <td>&nbsp;&nbsp;{{$articulo->nombre_unidad_sec}}</td>
                        </tr>
                        <tr>
                            <th>ALTERNA :</th>
                            <td>
                                @if($articulo->unidad_ter == 0)
                                    &nbsp;&nbsp;N/A
                                 @else
                                    &nbsp;&nbsp;{{$articulo->nombre_unidad_alt}}
                                 @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- <div class="col-md-4 col-sm-6">
                <h6>Stock :</h6>
                <table class="table table-responsive invoice-table invoice-order table-borderless">
                    <tbody>
                        <tr>
                            <th>PUNTO MINIMO :</th>
                            <td>&nbsp;&nbsp;{{$articulo->minimo}}</td>
                        </tr>
                        <tr>
                            <th>PUNTO MAXIMO :</th>
                            <td>&nbsp;&nbsp;{{$articulo->maximo}}</td>
                        </tr>
                        <tr>
                            <th>PUNTO DE PEDIDO :</th>
                            <td>&nbsp;&nbsp;{{$articulo->pedido}}</td>
                        </tr>
                    </tbody>
                </table>
            </div> --}}
        </div>
    @if ($DatosAdicionales != '[]')
        <h4>DATOS ADICIONALES</h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table  invoice-detail-table">
                        <thead>
                            <tr class="thead-default">
                                <th>Clasificación</th>
                                <th>Sub Clasificación</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($DatosAdicionales as $adicionales)
                                <tr>
                                    <td>{{ $adicionales->nombre_clasificacion }}</td>
                                    <td>{{ $adicionales->nombre_subclasificacion }}</td>
                                    <td>
                                        {{-- ARREGLAR MOSTRAR URL --}}
                                        @if (substr($adicionales->valor, 0, 4) == 'HTTP')
                                            <a href="{{ $adicionales->valor }}"
                                                target="_blank">{{ $adicionales->valor }}</a>
                                        @else
                                            {{ $adicionales->valor }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    </div>
</div>

@if (str_replace(" ","",$articulo->activo) == 'SI')
        <div class="card">
            <div class="card-header">
                <h5>Listado de Empresas</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-block table-border-style">
                            <form action="{{ route('solicitud') }}" method="post">
                            @csrf
                            {{-- CAMPO OCULTO CON EL ID DEL ARTICULO --}}
                            <input type="hidden" name="id_articulo" value="{{ $articulo->id_articulo }}">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Almacen</th>
                                            <th>Empresa</th>
                                            <th>Estatus / Solicitud</th>
                                            <th>Almacenes Profit</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        

                                            @foreach ($empresas as $empresa)

                                            @php
                                                    $contador = $loop->count; 
                                                    $puntos = App\Models\Articulo_MigracionModel::PuntosArticuloProfit($empresa->base_datos,$articulo->codigo_articulo );
                                                    $StockAlmacenes = App\Models\Articulo_MigracionModel::StockAlmacenesArticuloProfit($empresa->base_datos,$articulo->codigo_articulo );
                                            @endphp
                                                <tr>
                                                    <td>{{ $empresa->id_empresa }}</td>
                                                    <td>{{ $empresa->alias_empresa }}</td>
                                                    <td>{{ $empresa->nombre_empresa }} </td>
                                                    {{-- <td>{{ $almacen->bd_almacen }}</td> --}}
                                                    <td>
                                                        {{-- Busca si un articulo esta migrado y/o tiene solicitud a una empresa --}}
                                                        @php 
                                                            $EstatusArticulo = App\Models\Articulo_MigracionModel::EstatusArticuloMigracion($articulo->id_articulo, $empresa->id_empresa); 
                                                            if($EstatusArticulo != NULL)
                                                            {
                                                                $migrado = str_replace(" ","",$EstatusArticulo->migrado);
                                                                $solicitado =  str_replace(" ","",$EstatusArticulo->solicitado);
                                                            }
                                                            else
                                                                {
                                                                $migrado = "";
                                                                $solicitado = "";
                                                                }
                                                        @endphp
                                                        
                                                        @if($migrado == "SI") 

                                                        <label class="label label-info label-lg " data-toggle="popover" data-placement="left" title="MIGRADO POR:" data-content="{{$EstatusArticulo->nombre_usuario}}">
                                                            <i class="fa fa-check-square-o text-dark"> </i> <strong
                                                                class="text-dark"> DISPONIBLE EN PROFIT 
                                                            </strong></label>

                                                        @elseif($migrado == "NO" && $solicitado == "SI")
                                                        
                                                        <label class="label label-danger label-lg " data-toggle="popover" data-placement="left" title="SOLICITADO POR:" data-content="{{$EstatusArticulo->nombre_solicitante}}">
                                                                <i class="fa fa-info-circle text-dark"> </i> <strong
                                                                    class="text-dark"> MIGRACION PENDIENTE
                                                                </strong></label> 
                                                                
                                                        @elseif($articulo->codigo_articulo != "")   
                                                        
                                                            <div class="checkbox-fade fade-in-primary">
                                                                <label>
                                                                    <input type="checkbox" id="empresas" name="empresas[]" value="{{$empresa->id_empresa}}">
                                                                    <span class="cr">
                                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                    </span>
                                                                    SOLICITAR
                                                                </label>
                                                            </div>  
                                                        @endif
                                                    </td>
                                                    
                                                    @if($puntos != NULL)
                                                        <td>
                                                            <table class="table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nombre</th>
                                                                        <th>Stock Actual</th>
                                                                        {{-- <th>Stock por Llegar</th> --}}
                                                                    </tr>
                                                                </thead>
                                                                @foreach ($StockAlmacenes as $stock)
                                                                <tr>
                                                                    <td>{{ $stock->des_sub}} </td>
                                                                    <td> {{ number_format($stock->stock_act, 2, '.', '')}} </td>
                                                                    {{-- <td>{{ number_format($stock->stock_lle, 2, '.', '')}} </td>           --}}
                                                                </tr>
                                                                @endforeach  
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <strong> PUNTO PEDIDO : </strong> {{ number_format($puntos->pto_pedido, 2, '.', '')}} <br>
                                                            <strong> PENDIENTE SOLP : </strong> {{ number_format($puntos->stock_ped, 2, '.', '')}} <br>
                                                            <strong> PENDIENTE OC : </strong> {{ number_format($puntos->stock_lle, 2, '.', '')}}
                                                        </td>
                                                    @else
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            @can('fict.articulos.solicitud.migracion')
                                @if (App\Models\Articulo_MigracionModel::ArticuloMigrado($articulo->id_articulo))
                                    <div class="d-grid gap-2 d-md-block float-right">    
                                        
                                        <button type="button" class="btn btn-primary btn"
                                        data-toggle="modal"
                                        data-target="#modal-solicitud"
                                        href="#!">
                                        <i class="fa fa-share-square-o"></i>Solicitar Migración
                                        </button> 

                                    </div>
                                @endif        
                                @include('FichaTecnica.Articulos.ArticuloSolicitud')
                            @endcan
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Ubicacion por Almacen</h5>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-block table-border-style">
                        <form action="{{ route('solicitud') }}" method="post">
                        @csrf
                        {{-- CAMPO OCULTO CON EL ID DEL ARTICULO --}}
                        <input type="hidden" name="id_articulo" value="{{ $articulo->id_articulo }}">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Articulo</th>
                                        <th>Almacen</th>
                                        <th>Subalmacen</th>
                                        <th>Zona</th>
                                        <th>Ubicacion</th>
                                        <th>Acciones</th>
                                        {{-- <th>Existencia</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ubicaciones as $ubicacion)
  
                                        {{-- @php
                                        $StockAlmacenes = App\Models\Articulo_MigracionModel::StockAlmacenesArticuloProfit($ubicacion->base_datos,$ubicacion->codigo_articulo );
                                        @endphp --}}
                                        <tr>  
                                            <td>{{ $ubicacion->codigo_articulo }}</td>  
                                            <td>{{ $ubicacion->nombre_articulo }}</td>
                                            <td>{{ $ubicacion->nombre_almacen }}</td>
                                            <td>{{ $ubicacion->nombre_subalmacen}}</td>
                                            <td>{{ $ubicacion->nombre_ubicacion }}</td>
                                            <td>{{ $ubicacion->zona }}</td>     
                                            <td>
                                                <a class="btn btn-primary btn-sm" title="Imprimir" target="_blank"
                                                href=" {{ route('fictimprimiretiquetas', ['id_articulo' => $ubicacion->id_articulo, 'id_almacen' =>  $ubicacion->id_almacen, 'id_subalmacen' => $ubicacion->id_subalmacen])}}" >
                                                <i class="fa fa-print fa-2x"></i></a>
                                            </td>
                                            {{-- <td>
                                                @foreach ($StockAlmacenes as $stock)
                    
                                                    @if($stock->stock_act  > 0 )
                                                        {{ number_format($stock->stock_act, 2, '.', '')}}
                                                    @endif
                    
                                                @endforeach  
                                            </td>      --}}
                                        </tr>
                                    @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('scripts')
    <!--Forms - Wizard js-->
    <script src="{{ asset('libraries\bower_components\jquery.cookie\js\jquery.cookie.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\jquery.steps\js\jquery.steps.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\jquery-validation\js\jquery.validate.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\forms-wizard-validation\form-wizard.js') }}"></script>

    <!-- jquery file upload js -->
    <script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

    <!-- Select -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}">
    </script>

    <script type="text/javascript" src=" {{ asset('libraries\bower_components\lightbox2\js\lightbox.min.js') }} ">
    </script>

    <!-- Masking js -->
    <script src="{{ asset('libraries\assets\pages\form-masking\inputmask.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\autoNumeric.js') }} "></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\jquery.inputmask.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\form-mask.js') }} "></script>
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
