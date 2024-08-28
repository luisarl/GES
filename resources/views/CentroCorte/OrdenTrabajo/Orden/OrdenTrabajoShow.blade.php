@extends('layouts.master')

@section('titulo', 'Orden de Trabajo')

@section('titulo_pagina', 'Orden de Trabajo')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cencordentrabajo.index') }}">Orden de Trabajo</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Ver</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

<style>
    /* Estilos CSS para el acordeón */
    .card {
        cursor: pointer;
    }

    .card-content {
        display: none;
        transition: all 0.3s ease;
    }

    .card.open .card-content {
        display: block;
    }

    /* Estilos CSS para el acordeón */
    .card-header {
        display: flex;
        align-items: center;
    }

    .card-header-text {
        flex-grow: 1;
    }

    .card-header-toggle {
        margin-left: 10px;
        cursor: pointer;
    }
</style>


@include('CentroCorte.OrdenTrabajo.Orden.OrdenTrabajoFinalizar')

<div class="page-body">
    <div class="row">
        <div class="col-xl-8 col-lg-12 ">

            <div class="card">
                <div class="card-body">

                    <span class="title m-r-10 m-b-15"><strong><i class="icofont icofont-tasks-alt m-r-5"></i>ORDEN DE
                            TRABAJO - N° {{$OrdenTrabajo->id_orden_trabajo}}</strong></span>
                    @if($OrdenTrabajo->estatus == 'POR ACEPTAR')
                    <label class="label label-info" id="estatus">POR ACEPTAR</label>
                    @elseif($OrdenTrabajo->estatus == 'ACEPTADA')
                    <label class="label label-success" id="estatus">ACEPTADA</label>
                    @elseif($OrdenTrabajo->estatus == 'APROBADO')
                    <label class="label label-danger" id="estatus">APROBADO</label>
                    @elseif($OrdenTrabajo->estatus == 'EN PROCESO')
                    <label class="label label-warning" id="estatus">EN PROCESO</label>
                    @elseif($OrdenTrabajo->estatus == 'ANULADO')
                    <label class="label label-danger" id="estatus">ANULADO</label>
                    @elseif($OrdenTrabajo->estatus == 'FINALIZADO')
                    <label class="label label-danger" id="estatus">FINALIZADO</label>
                    @endif

                    @if($OrdenTrabajo->estatus == 'EN PROCESO')
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                        data-target="#modal-orden-finalizar" title="Finalizar Orden Trabajo" href="#!">
                        <i class="fa fa-check-square"></i>FINALIZAR
                    </button>
                    @endif

                    <hr>
                    <table class="table table-borderless table-responsive table-xs">

                        <tbody>
                            <tr>
                                <th>FECHA CREACIÓN:</th>
                                <td>{{date('d-m-Y', strtotime($OrdenTrabajo->created_at))}}</td>
                                <th> </th>
                                <td> </td>
                            </tr>
                            <tr>
                                <th>CONAP: </th>
                                <td>{{$OrdenTrabajo->nro_conap}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                </div>

                <div class="card-footer" style="padding-top: 0px; margin-top: -24px;">
                    <a href="{{ route('cencordentrabajopdf', $OrdenTrabajo->id_orden_trabajo) }}" target="_blank"
                        type="button" class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                        <i class="fa fa-print"></i>Imprimir</a>

                    @if($OrdenTrabajo->estatus !== 'FINALIZADO')
                    <a class="btn btn-primary btn-sm float-right m-l-10" type="button"
                        href=" {{ route('cencordentrabajo.edit', $OrdenTrabajo->id_orden_trabajo) }}"><i
                            class="fa fa-edit"></i>Editar</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-12 ">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text"><i class="icofont icofont-clock-time m-r-10"></i>Tiempo Transcurrido
                    </h5>
                </div>
                <div class="card-block">
                    <div class="counter">
                        <div class="yourCountdownContainer">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h2>{{$TiempoTranscurrido->days}}</h2>
                                    <p>Dias</p>
                                </div>
                                <div class="col-sm-3">
                                    <h2>{{$TiempoTranscurrido->h}}</h2>
                                    <p>Horas</p>
                                </div>
                                <div class="col-sm-3">
                                    <h2>{{$TiempoTranscurrido->i}}</h2>
                                    <p>Minutos</p>
                                </div>
                                <div class="col-sm-3">
                                    <h2>{{$TiempoTranscurrido->s}}</h2>
                                    <p>Segundos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-xl-12 col-lg-12 ">
            <div id="EstimadoEjecutado">
                <div class="card">
                    <div class="card-header">
                        <h5>INFORMACIÓN GENERAL</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                                <li><i class="feather icon-trash-2 close-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block">
                        <div class="container">
                            <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                                <thead>
                                    <tr>
                                        <th class="bg-inverse" style="text-align: center;">ESPESOR (MM)</th>
                                        <th class="bg-inverse" style="text-align: center;">SEGUIMIENTO</th>
                                        <th class="bg-inverse" style="text-align: center;">LISTA DE PARTES</th>
                                        <th class="bg-inverse" style="text-align: center;">APROVECHAMIENTO</th>
                                        <th class="bg-inverse" style="text-align: center;">CENTRO DE TRABAJO</th>
                                        <th class="bg-inverse" style="text-align: center;">TECNOLOGÍA</th>
                                        <th class="bg-inverse" style="text-align: center;">CIERRE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align: center;">
                                        @foreach($TiempoEjecutado as $index => $tiempoEjecutado)
                                    <tr style="text-align: center;">
                                        <td>{{number_format($Espesores[$index] ?? 0, 2, '.', '')}}</td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('cencseguimientopdf', $Seguimiento[$index]) }}"
                                                target="_blank" type="button" class="btn btn-primary btn-sm"
                                                title="Ver Seguimiento">
                                                <i class="fa fa-file-text"></i> </a>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('listapartesdetallepdf', $ListaPartes[$index]) }}"
                                                target="_blank" type="button" class="btn btn-primary btn-sm"
                                                title="Ver Lista Partes">
                                                <i class="fa fa-file-text"></i> </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('aprovechamientopdf', $Aprovechamiento[$index]) }}"
                                                target="_blank" type="button" class="btn btn-primary btn-sm"
                                                title="Ver Aprovechamiento">
                                                <i class="fa fa-file-text"></i> </a>
                                        </td>
                                        <td>{{$CentroTrabajo[$index]}}</td>
                                        <td>{{$Tecnologia[$index]}}</td>
                                        <td>
                                            <a href="{{ route('cenccierrepdf', $Cierre->id_cierre) }}"
                                                target="_blank" type="button" class="btn btn-primary btn-sm"
                                                title="Ver Cierre">
                                                <i class="fa fa-file-text"></i> </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-12 col-lg-12 ">
            <div id="EstimadoEjecutado">
                <div class="card">
                    <div class="card-header">
                        <h5>TIEMPOS / CONSUMIBLES</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                                <li><i class="feather icon-trash-2 close-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block">

                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                                        <thead>
                                            <tr>
                                                <th class="background-primary" style="text-align: center;" colspan="4">
                                                    ESTIMADO</th>
                                            </tr>
                                            <tr>
                                                <th class="background-primary" style="text-align: center;">ESPESOR (MM)
                                                </th>
                                                <th class="background-primary" style="text-align: center;">TIEMPO (H)
                                                </th>
                                                <th class="background-primary" style="text-align: center;">OXIGENO (L)
                                                </th>
                                                <th class="background-primary" style="text-align: center;">GAS PROPANO
                                                    (L)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($estimados as $estimado)
                                            <tr style="text-align: center;">
                                                <td>{{number_format($estimado->espesor, 2, '.', '')}}</td>
                                                <td>{{$estimado->tiempo_estimado}}</td>
                                                <td>{{number_format($estimado->consumo_oxigeno, 2, '.', '')}}</td>
                                                <td>{{number_format($estimado->consumo_gas, 2, '.', '')}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                                        <thead>
                                            <tr>
                                                <th class="bg-inverse" style="text-align: center;" colspan="4">EJECUTADO
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="bg-inverse" style="text-align: center;">ESPESOR (MM)</th>
                                                <th class="bg-inverse" style="text-align: center;">TIEMPO (H)</th>
                                                <th class="bg-inverse" style="text-align: center;">OXIGENO (L)</th>
                                                <th class="bg-inverse" style="text-align: center;">GAS PROPANO (L)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="text-align: center;">
                                                @foreach($TiempoEjecutado as $index => $tiempoEjecutado)
                                            <tr style="text-align: center;">
                                                <td>{{number_format($Espesores[$index] ?? 0, 2, '.', '')}}</td>
                                                <td>{{$tiempoEjecutado}}</td>
                                                <td>{{number_format($OxigenoUsado[$index] ?? 0, 2, '.', '')}}</td>
                                                <td>{{number_format($GasUsado[$index] ?? 0, 2, '.', '')}}</td>
                                            </tr>
                                            @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 ">

            <div id="miCardPlanchamp">
                <div class="card">
                    <div class="card-header">
                        <h5>MATERIA PRIMA</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                                <li><i class="feather icon-trash-2 close-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                                <thead>
                                    <tr class="bg-inverse">
                                        <th style="width: 12%">ESPESOR (MM)</th>
                                        <th style="width: 50%">DIMENSIONES (MM)</th>
                                        <th style="width: 16%">CANTIDAD (UND)</th>
                                        <th style="width: 16%">PESO UNITARIO (KG)</th>
                                        <th style="width: 16%">PESO TOTAL (KG)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($MateriaPrima as $MateriaPrimas)
                                    <tr>
                                        <td id='codigo_materia'>{{number_format($MateriaPrimas->espesor, 2, '.', '')}}
                                        </td>
                                        <td id='dimensiones_materia'>{{$MateriaPrimas->dimensiones}}</td>
                                        <td id='cantidad_materia'>{{$MateriaPrimas->cantidad}}</td>
                                        <td id='peso_materia'>{{number_format($MateriaPrimas->peso_unit, 2, '.', '')}}
                                        </td>
                                        <td id='peso_materia'>{{number_format($MateriaPrimas->peso_total, 2, '.', '')}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div id="miCardPlanchacp">
                <div class="card">

                    <div class="card-header">
                        <h5>ÁREA DE CORTE</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                                <li><i class="feather icon-trash-2 close-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                                <thead>
                                    <tr class="bg-inverse">
                                        <th style="width: 12%">ESPESOR (MM)</th>
                                        <th style="width: 50%">DIMENSIONES (MM)</th>
                                        <th style="width: 16%">CANTIDAD (UND)</th>
                                        <th style="width: 16%">PESO UNITARIO (KG)</th>
                                        <th style="width: 16%">PESO TOTAL (KG)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($AreaCorte as $AreaCortes)
                                    <tr>
                                        <td id='codigo_materia'>{{number_format($AreaCortes->espesor, 2, '.', '')}}</td>
                                        <td id='dimensiones_corte'>{{$AreaCortes->dimensiones}}</td>
                                        <td id='cantidad_corte'>{{$AreaCortes->cantidad}}</td>
                                        <td id='peso_corte'>{{number_format($AreaCortes->peso_unit, 2, '.', '')}}</td>
                                        <td id='peso_corte'>{{number_format($AreaCortes->peso_total, 2, '.', '')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="miCardPlanchacp">
                <div class="card">
                    <div class="card-header">
                        <h5>TIEMPOS TOTALES / HORÓMETROS MAQUINAS</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                                <li><i class="feather icon-trash-2 close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                                <thead>
                                    <tr class="background-primary">
                                        <th style="text-align: center;">ESPESOR (MM)</th>
                                        <th style="text-align: center;">HORAS MÁQUINA</th>
                                        <th style="text-align: center;">HORAS AUTOMÁTICO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($TiemposHorometros as $key => $TiemposHorometro)
                                    <tr style="text-align: center;">
                                        <td>{{number_format($TiemposHorometro['espesor'], 2, '.', '')}}</td>
                                        <td>{{ $TiemposHorometro['horas_on'] }}</td>
                                        <td>{{ $TiemposHorometro['tiempo_aut'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h5>PARTES CORTADAS</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <li><i class="feather icon-minus minimize-card"></i></li>
                            <li><i class="feather icon-trash-2 close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                            <thead>
                                <tr class="background-primary">
                                    <th style="width: 10%">ESPESOR (MM)</th>
                                    <th style="width: 10%">APROVECHAMIENTO</th>
                                    <th>NÚMERO PARTES</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>CANTIDAD PIEZAS (UND)</th>
                                    <th>PESO TOTAL (KG)</th>
                                    <th>PESO TOTAL (TON)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $TotalCantidadPiezas = 0;
                                $TotalCantidadPeso = 0;
                                $TotalCantidadToneladas = 0;
                                @endphp
                                @foreach ($TotalAvance as $key => $TotalAvances)
                                <tr>
                                    <td>{{number_format($TotalAvances['espesor'], 2, '.', '')}}</td>
                                    <td>{{ $TotalAvances['id_aprovechamiento'] }}</td>
                                    <td>{{ $TotalAvances['nro_partes'] }}</td>
                                    <td>{{ $TotalAvances['descripcion'] }}</td>
                                    <td>{{ $TotalAvances['avance_cant_piezas'] }}</td>
                                    <td>{{ $TotalAvances['avance_peso'] }}</td>
                                    <td>
                                        {{number_format($TotalToneladas = $TotalAvances['avance_peso'] / 1000, 3, '.',
                                        '')}}
                                    </td>
                                </tr>
                                @php
                                $TotalCantidadPiezas = $TotalCantidadPiezas + $TotalAvances['avance_cant_piezas'];
                                $TotalCantidadPeso = $TotalCantidadPeso + $TotalAvances['avance_peso'];
                                $TotalCantidadToneladas = $TotalCantidadToneladas + $TotalToneladas;
                                @endphp
                                @endforeach
                            </tbody>
                            <thead>
                                <tr class="background-primary">
                                    <th colspan="4"> TOTALES</th>
                                    <th>{{$TotalCantidadPiezas}}</th>
                                    <th>{{number_format($TotalCantidadPeso, 2, '.', '')}}</th>
                                    <th>{{number_format($TotalCantidadToneladas, 3, '.', '')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h5>CORTES</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <li><i class="feather icon-minus minimize-card"></i></li>
                            <li><i class="feather icon-trash-2 close-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="TablaCortes">
                            <thead>
                                <tr class="background-primary">
                                    <th>ESPESOR (MM)</th>
                                    <th>CNC APROV</th>
                                    <th>PIEZAS ANIDADAS</th>
                                    <th>PIEZAS CORTADAS</th>
                                    <th>PIEZAS DAÑADAS</th>
                                    <th>LONGITUD DE CORTE (MM)</th>
                                    <th>NRO. PERF</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $TotalCantidadCortadas = 0;
                                $TotalCantidadDanadas = 0;
                                $TotalCantidadLongitud = 0;
                                $TotalCantidadPerforaciones = 0;
                                @endphp
                                @if($TotalCortes != NULL)
                                @foreach($TotalCortes as $key => $TotalCorte)
                                <tr>
                                    <td id='espesor'> {{number_format($TotalCorte['espesor'], 2, '.', '')}}</td>
                                    <td id='cnc_aprovechamiento'> {{$TotalCorte['cnc_aprovechamiento']}}</td>
                                    <td class='piezas_anidadas' id='piezas_anidadas'>{{$TotalCorte['piezas_anidadas']}}
                                    </td>
                                    <td class='piezas_cortadas' id='piezas_cortadas'>{{$TotalCorte['piezas_cortadas']}}
                                    </td>
                                    <td class='piezas_danadas' id='piezas_danadas'>{{$TotalCorte['piezas_danadas']}}
                                    </td>
                                    <td class='longitud_corte' id='longitud_corte'>
                                        {{number_format($TotalCorte['longitud_corte'], 2, '.', '')}}</td>
                                    <td class='numero_perforaciones' id='numero_perforaciones'>
                                        {{$TotalCorte['numero_perforaciones']}}</td>
                                </tr>
                                @php
                                $TotalCantidadCortadas = $TotalCantidadCortadas + $TotalCorte['piezas_cortadas'];
                                $TotalCantidadDanadas = $TotalCantidadDanadas + $TotalCorte['piezas_danadas'];
                                $TotalCantidadLongitud = $TotalCantidadLongitud + $TotalCorte['longitud_corte'];
                                $TotalCantidadPerforaciones = $TotalCantidadPerforaciones +
                                $TotalCorte['numero_perforaciones'];
                                @endphp
                                @endforeach
                            </tbody>
                            <thead>
                                <tr class="background-primary">
                                    <th colspan="3">TOTALES</th>
                                    <th id="total_piezas_cortadas">{{$TotalCantidadCortadas}}</th>
                                    <th id="total_piezas_danadas">{{$TotalCantidadDanadas}}</th>
                                    <th id="total_longitud_cortes">{{$TotalCantidadLongitud}}</th>
                                    <th id="total_nro_perforacion">{{$TotalCantidadPerforaciones}}</th>
                                </tr>
                            </thead>
                            @endif
                        </table>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h5>MATERIA PRIMA SOBRANTE</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <li><i class="feather icon-minus minimize-card"></i></li>
                            <li><i class="feather icon-trash-2 close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="TablaMateriaPrimaSobrante">
                            <thead>
                                <tr class="background-primary">
                                    <th>ESPESOR (MM)</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>REFERENCIA</th>
                                    <th>CANTIDAD (UND)</th>
                                    <th>UBICACIÓN</th>
                                    <th>OBSERVACIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($CierrePlanchaSobrante != NULL)
                                @foreach ($CierrePlanchaSobrante as $CierrePlanchaSobrantes)
                                <tr>
                                    <td id='espesor'> {{number_format($CierrePlanchaSobrantes->espesor, 2, '.', '')}}
                                    </td>
                                    <td id='descripcion_sobrante'>{{$CierrePlanchaSobrantes->descripcion}}</td>
                                    <td id='referencia_sobrante'>{{$CierrePlanchaSobrantes->referencia}}</td>
                                    <td id='cantidad_sobrante'>{{$CierrePlanchaSobrantes->cantidad}}</td>
                                    <td id='ubicacion_sobrante'>{{$CierrePlanchaSobrantes->ubicacion}}</td>
                                    <td id='observacion_sobrante'>{{$CierrePlanchaSobrantes->observacion}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h5>CONSUMIBLES USADOS</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <li><i class="feather icon-minus minimize-card"></i></li>
                            <li><i class="feather icon-trash-2 close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="TablaMateriaPrimaSobrante">
                            <thead>
                                <tr class="background-primary">
                                    <th>ESPESOR (MM)</th>
                                    <th>CONSUMIBLE</th>
                                    <th>CONSUMO</th>
                                    <th>UNIDAD (UND)</th>
                                    <th>OBSERVACIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($SeguimientoPlanchaConsumible as $SeguimientoPlanchaConsumibles)
                                <tr>
                                    <td id='espesor'> {{number_format($SeguimientoPlanchaConsumibles->espesor, 2, '.',
                                        '')}}</td>
                                    <td id='consumible_usado'> {{$SeguimientoPlanchaConsumibles->consumible}}</td>
                                    <td id='consumo_consumible'>
                                        {{number_format($SeguimientoPlanchaConsumibles->consumo, 2, '.', '')}}</td>
                                    <td id='unidad_consumible'> {{$SeguimientoPlanchaConsumibles->unidad}}</td>
                                    <td id='observacion_consumible'> {{$SeguimientoPlanchaConsumibles->observaciones}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h5>OBSERVACIONES</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <li><i class="feather icon-minus minimize-card"></i></li>
                            <li><i class="feather icon-trash-2 close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="">
                        <div class="m-b-20">
                            <p>
                                {{$OrdenTrabajo->observaciones}}
                            </p>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>RESPONSABLES</h5>

                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>
                            <li><i class="feather icon-minus minimize-card"></i></li>
                            <li><i class="feather icon-trash-2 close-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block">
                    <div class="container">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="background-primary" style="text-align: center;">CREADO POR:</th>
                                    <th class="background-primary" style="text-align: center;">ACEPTADO POR:</th>
                                    <th class="background-primary" style="text-align: center;">EN PROCESO POR:</th>
                                    <th class="background-primary" style="text-align: center;">FINALIZADO POR:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="text-align: center;">
                                    <td>{{$OrdenTrabajo->name}}</td>

                                    @if(isset($UsuarioAceptado->name))
                                        <td>{{$UsuarioAceptado->name}}</td>
                                    @else
                                        <td>  </td> 
                                    @endif

                                    @if(isset($UsuarioEnProceso->name))
                                        <td> {{$UsuarioEnProceso->name}} </td>   
                                    @else
                                        <td>  </td> 
                                    @endif

                                    @if(isset($UsuarioFinalizado->name))
                                        <td> {{$UsuarioFinalizado->name}} </td>   
                                    @else
                                        <td>  </td> 
                                    @endif
                                </tr>
                                <tr style="text-align: center;">
                                    <td>{{date('d-m-Y g:i:s A', strtotime($OrdenTrabajo->fecha_creado))}}</td>

                                    @if(isset($UsuarioAceptado->fecha_aceptado))
                                        <td>{{date('d-m-Y g:i:s A', strtotime($UsuarioAceptado->fecha_aceptado))}}</td>
                                    @else
                                        <td>  </td> 
                                    @endif

                                    @if(isset($UsuarioEnProceso->fecha_enproceso))
                                        <td>{{date('d-m-Y g:i:s A', strtotime($UsuarioEnProceso->fecha_enproceso))}}</td>
                                    @else
                                        <td>  </td> 
                                    @endif

                                    @if(isset($UsuarioFinalizado->fecha_finalizado))
                                        <td>{{ date('d-m-Y g:i:s A', strtotime($UsuarioFinalizado->fecha_finalizado)) }}</td>   
                                    @else
                                        <td>  </td> 
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Sweet alert start -->
{{-- <div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>Bootstrap Modals</h5>

        </div>
        <div class="card-block">
            <p>use button<code> onclick="_gaq.push(['_trackEvent', 'example', 'try', 'sweet-1']);"</code> to use effect.
            </p>
            <ul>
                <li>
                    <button type="button" class="btn btn-primary sweet-1 m-b-10"
                        onclick="_gaq.push(['_trackEvent', 'example', 'try', 'sweet-1']);">Basic</button>
                </li>
                <li>
                    <button type="button" class="btn btn-success alert-success-msg m-b-10"
                        onclick="_gaq.push(['_trackEvent', 'example', 'try', 'alert-success']);">Success</button>
                </li>
                <li>
                    <button type="button" class="btn btn-warning alert-confirm m-b-10"
                        onclick="_gaq.push(['_trackEvent', 'example', 'try', 'alert-confirm']);">Confirm</button>
                </li>
                <li>
                    <button type="button" class="btn btn-danger alert-success-cancel m-b-10"
                        onclick="_gaq.push(['_trackEvent', 'example', 'try', 'alert-success-cancel']);">Success or
                        Cancel</button>
                </li>
                <li>
                    <button type="button" class="btn btn-primary alert-prompt m-b-10"
                        onclick="_gaq.push(['_trackEvent', 'example', 'try', 'alert-prompt']);">Prompt</button>
                </li>
                <li>
                    <button type="button" class="btn btn-success alert-ajax m-b-10"
                        onclick="_gaq.push(['_trackEvent', 'example', 'try', 'alert-ajax']);">Ajax</button>
                </li>
            </ul>
        </div>
    </div>
</div> --}}
<!-- Sweet alert end -->

@endsection

@section('scripts')