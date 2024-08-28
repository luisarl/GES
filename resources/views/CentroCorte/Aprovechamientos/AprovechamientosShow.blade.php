@extends('layouts.master')

@section('titulo', 'Aprovechamientos')

@section('titulo_pagina', 'Aprovechamientos')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cencaprovechamientos.index') }}">Aprovechamientos</a>
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

    .table.table-xs td,
    .table.table-xs th {
        padding: 0.4rem 1.3rem;
    }

    #tabla_calculos {
        width: auto;
        font-size: smaller;
    }

    #tabla_calculos td th{
        width: auto;
        padding: 0;
    }



</style>

<div class="page-body">
    <div class="row">
        <div class="col-xl-8 col-lg-12 ">
            <div class="card">
                <div class="card-body">

                    <span class="title m-r-10 m-b-15 h6 "><i class="icofont icofont-tasks-alt m-r-5"></i> CONAP Nº
                        {{$aprov->nro_conap}} | {{$aprov->tipo_lista}} - Espesor: {{number_format($aprov->espesor, 2,
                        '.', '')}} mm</strong></span>

                    @if($aprov->estatus == 'POR VALIDAR')
                    <label class="label label-warning">{{$aprov->estatus}}</label>
                    @elseif($aprov->estatus == 'VALIDADO')
                    <label class="label label-warning">{{$aprov->estatus}}</label>
                    @elseif($aprov->estatus == 'APROBADO')
                    <label class="label label-success">{{$aprov->estatus}}</label>
                    @elseif($aprov->estatus == 'ANULADO')
                    <label class="label label-danger">{{$aprov->estatus}}</label>
                    @elseif($aprov->estatus == 'FINALIZADO')
                    <label class="label label-success">{{$aprov->estatus}}</label>
                    @endif


                    @if($aprov->estatus == 'POR VALIDAR')
                        {{-- @can('sols.solicitudes.aceptar') --}}
                            @include('CentroCorte.Aprovechamientos.AprovechamientosValidar')
                            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                data-target="#modal-validar-aprovechamiento" title="Validar Aprovechamiento" href="#!">
                                <i class="fa fa-check-square"></i>VALIDAR
                            </button>
                        {{-- @endcan --}}
                    @elseif($aprov->estatus == 'VALIDADO')
                        {{-- @can('sols.solicitudes.aceptar') --}}
                        @include('CentroCorte.Aprovechamientos.AprovechamientosAprobar')
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                            data-target="#modal-aprobar-aprovechamiento" title="Aprobar Aprovechamiento" href="#!">
                            <i class="fa fa-check-square"></i>APROBAR
                        </button>
                        {{-- @endcan --}}
                    @endif

            

                    <hr>
                    <table class="table table-borderless table-responsive table-xs">

                        @if ($aprov->tipo_lista == 'PLANCHAS')

                        @if($aprov->tecnologia == 'OXICORTE')

                        <tbody>
                            <tr>
                                <th>TIPO:</th>
                                <td>{{$aprov->tipo_lista}}</td>
                                <th>NÚMERO DE BOQUILLA:</th>
                                <td> {{$aprov->numero_boquilla}}</td>
                            </tr>
                            <tr>
                                <th>EQUIPO: </th>
                                <td>{{$aprov->equipo}}</td>
                                <th>INSERTO: </th>
                                @if (empty($Inserto))
                                    <td>0</td>
                                @else
                                    <td>
                                        @foreach ($Inserto as $Insertos)
                                            {{ $Insertos->diametro_perforacion }} |
                                        @endforeach
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <th>TECNOLOGÍA: </th>
                                <td>{{$aprov->tecnologia}}</td>
                                <th>CONSUMO DE OXÍGENO</th>
                                <td id="consumo_oxigeno">{{number_format($ConsumoTotalOxigenoLitros, 2, '.', '')}} L </td>
                            </tr>
                            <tr>
                                <th>CANTIDAD TOTAL PIEZAS: </th>
                                <td>{{$CantidadTotalPiezas}} und</td>
                                <th>CONSUMO DE GAS PROPANO: </th>
                                <td id="consumo_gas">{{number_format($ConsumoGasCorteLitros, 2, '.', '')}} L</td>
                            </tr>
                            <tr>
                                <th>LONGITUD DE CORTE: </th>
                                <td>{{$aprov->longitud_corte}} mm</td>
                                <th>TIEMPO ESTIMADO DE CORTE:</th>
                                <td>{{$aprov->tiempo_estimado}} hrs</td>
                            </tr>
                            <tr>
                                <th>NÚMERO DE PIERCING: </th>
                                <td>{{$aprov->numero_piercing}} und</td>
                            </tr>
                            <tr>
                                <th>CICLOS DE TALADROS:</th>
                                <td>{{$SumaCiclosTaladros}}</td>
                            </tr>
                            <tr>
                                <th>METROS DE PERFORACIÓN:</th>
                                <td>
                                    {{number_format($TotalMetrosPerforacionPla, 2, '.', '') }} m
                                </td>
                                <th> </th>
                                <td> </td>
                            </tr>
                        </tbody>
                        @else


                        @endif

                        @if($aprov->tecnologia == 'PLASMA')

                        <tbody>
                            <tr>
                                <th>TIPO:</th>
                                <td>{{$aprov->tipo_lista}}</td>

                                <th>JUEGO ANTORCHA: </th>
                                <td>{{$aprov->juego_antorcha}} amp</td>
                            </tr>
                            <tr>
                                <th>EQUIPO: </th>
                                <td>{{$aprov->equipo}}</td>
                                <th>INSERTO: </th>
                                @if (empty($Inserto))
                                    <td>0</td>
                                @else
                                    <td>
                                        @foreach ($Inserto as $Insertos)
                                            {{ $Insertos->diametro_perforacion }} |
                                        @endforeach
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <th>TECNOLOGÍA: </th>
                                <td>{{$aprov->tecnologia}}</td>

                                <th>CONSUMO DE OXÍGENO:</th>
                                <td id="consumo_oxigeno">{{number_format($ConsumoOxigenoPlasmaLitros, 2, '.', '')}} L</td>
                            </tr>
                            <tr>
                                <th>CANTIDAD TOTAL PIEZAS: </th>
                                <td>{{$CantidadTotalPiezas}} und</td>
                                <th>TIEMPO ESTIMADO DE CORTE:</th>
                                <td>{{$aprov->tiempo_estimado}} hrs</td>
                            </tr>
                            <tr>
                                <th>LONGITUD DE CORTE: </th>
                                <td>{{$aprov->longitud_corte}} mm</td>

                            </tr>
                            <tr>
                                <th>NÚMERO DE PIERCING: </th>
                                <td>{{$aprov->numero_piercing}} und</td>

                            </tr>
                            <tr>
                                <th>CICLOS DE TALADROS:</th>
                                <td>{{$SumaCiclosTaladros}}</td>
                            </tr>
                            <tr>
                                <th>METROS DE PERFORACIÓN:</th>
                                <td>
                                    {{number_format($TotalMetrosPerforacionPla, 2, '.', '') }} m
                                </td>
                                <th> </th>
                                <td> </td>
                            </tr>

                        </tbody>

                        @endif

                        @endif

                    </table>
                       <hr>
                </div>
            
           <div class="card-footer" style="padding-top: 0px; margin-top: -24px;">
                    <a href="{{ route('aprovechamientopdf', $aprov->id_aprovechamiento) }}" target="_blank" type="button"
                        class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                        <i class="fa fa-print"></i>Imprimir</a>
                
                    @can('cenc.aprovechamientos.editar')
                    <a class="btn btn-primary btn-sm float-right m-l-10" type="button"
                        href="{{ route('cencaprovechamientos.edit', $aprov->id_aprovechamiento) }}">
                        <i class="fa fa-edit"></i>Editar</a>
                    @endcan

                    {{-- <a href="{{ route('aprovechamientocalculospdf', $aprov->id_aprovechamiento) }}" target="_blank" type="button"
                        class="btn btn-primary btn-sm float-right m-l-10" title="Ver Lista Partes">
                        <i class="fa fa-calculator"></i>Calculos</a> --}}
                
                    <a href="{{ route('listapartesdetallepdf', $aprov->id_lista_parte) }}" target="_blank" type="button"
                        class="btn btn-primary btn-sm float-right m-l-10" title="Ver Lista Partes">
                        <i class="fa fa-eye"></i>Ver Lista Partes</a>
            </div>
        </div>



            {{-- MATERIAL PROCESADO PLANCHA--}}
            <div id="miCardPlanchampr">
                <div class="card">
                    <div class="card-block">
                        <h4 class="sub-title">MATERIAL PROCESADO PLANCHA</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                                <thead>
                                    <tr class="background-primary">
                                        <th style="width: 30%">Espesor (mm)</th>
                                        <th style="width: 30%">Cantidad (und)</th>
                                        <th style="width: 30%">Peso Total (kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($MaterialProcesado as $MaterialProcesados)
                                    <tr>
                                        <td id='diametro_perf_placp'>{{number_format($MaterialProcesados->espesor, 2,'.', '')}}</td>
                                        <td id='cant_perf_placp'>{{$MaterialProcesados->cantidad}}</td>
                                        <td id='cant_total_placp'>{{number_format($MaterialProcesados->peso, 2, '.', '')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MATERIA PRIMA PLANCHAS --}}
            <div id="miCardPlanchamp">
                <div class="card">
                    <div class="card-block">
                        <h4 class="sub-title">MATERIA PRIMA PLANCHA</h4>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                                <thead>
                                    <tr class="background-primary">
                                        <th style="width: 50%">Dimensiones (mm)</th>
                                        <th style="width: 25%">Cantidad (und)</th>
                                        <th style="width: 30%">Peso Unitario (kg)</th>
                                        <th style="width: 30%">Peso Total (kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($MateriaPrima as $MateriaPrimas)
                                    <tr>
                                        <td id='codigo_materia' style='display: none;'>
                                            {{$MateriaPrimas->codigo_materia}}</td>
                                        <td id='dimensiones_materia'>{{$MateriaPrimas->dimensiones}}</td>
                                        <td id='cantidad_materia'>{{$MateriaPrimas->cantidad}}</td>
                                        <td id='peso_materia'>{{number_format($MateriaPrimas->peso_unit, 2, '.', '')}}</td>
                                        <td id='peso_materia'>{{number_format($MateriaPrimas->peso_total, 2, '.', '')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- AREA DE CORTE PLANCHA--}}
            <div id="miCardPlanchacp">
                <div class="card">
                    <div class="card-block">
                        <h4 class="sub-title">ÁREA DE CORTE PLANCHA</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                                <thead>
                                    <tr class="background-primary">
                                        <th style="width: 30%">Dimensiones (mm)</th>
                                        <th style="width: 30%">Cantidad (und)</th>
                                        <th style="width: 30%">Peso Unitario (kg)</th>
                                        <th style="width: 30%">Peso Total (kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($AreaCorte as $AreaCortes)
                                    <tr>
                                        <td id='id_area_corte' style="display: none;">{{$AreaCortes->id_area_corte}}
                                        </td>
                                        <td id='dimensiones_corte'>{{$AreaCortes->dimensiones}}</td>
                                        <td id='cantidad_corte'>{{$AreaCortes->cantidad}}</td>
                                        <td id='peso_corte'>{{number_format($AreaCortes->peso_unit, 2, '.', '')}}</td>
                                        <td id='peso_corte'>{{number_format($AreaCortes->peso_total, 2, '.', '')}}</td>
                                        <td id="auxiliar_pla" style="display: none;">0</td>
                                        <td id="lista_parte_pla" style="display: none;">{{$AreaCortes->id_area_corte}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-block">
                    <div class="">
                        <div class="m-b-20">
                            <h6 class="sub-title m-b-15"><i class="icofont icofont-ui-note"> </i>Observaciones</h6>
                            <p>
                                {{$observaciones}}
                            </p>

                        </div>
                    </div>
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

            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text"><i class="icofont icofont-ui-clip-board m-r-10"></i> Estatus del
                        aprovechamiento</h5>
                </div>
                <div class="card-block">
                    <form class="" method="POST" action=" {{ route('aprovupdatestatus', $aprov->id_aprovechamiento) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Estatus</label>
                            <div class="col-sm-9">

                                <select name="estatus_aprov" id="estatus_aprov"
                                    class="js-example-basic-single form-control">
                                    @php
                                    $selectedValue = old('estatus_aprov', $aprov->estatus ?? '');
                                    $estatusOptions = ['POR VALIDAR', 'ACEPTADO', 'APROBADO', 'ANULADO', 'FINALIZADO'];
                                    $filteredOptions = array_diff($estatusOptions, [$selectedValue]);
                                    @endphp
                                    <option value="{{ $selectedValue }}" selected>{{ $selectedValue }}</option>
                                    @foreach ($filteredOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                @can('cenc.aprovechamientos.activar')
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-save"></i>Guardar</button>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}

      
            

            <div class="card" id="detalle_documentos">
                <div class="card-header">
                    <h5 class="card-header-text"><i class="fa fa-file-text m-r-10"></i>Documentos</h5>
                    <h4 class="card-header-toggle">+</h4>
                </div>
                <div class="card-content">
                 @if (count($DocumentosAprovechamientos) === 0)
                    <h6 style="text-align: center;">NO TIENE DOCUMENTOS CARGADOS</h6>
                    @else 

                    <div class="table-responsive dt-responsive">
                        <table class="table table-striped table-bordered nowrap table-responsive" cellspacing="0"
                            cellpadding="1" width="100%">
                            <tbody style="width: 20%">                                
                                @foreach($DocumentosAprovechamientos as $DocumentosAprovechamiento)
                                <tr>
                                    <td style="width: 20%">
                                        <a target="_blank" href="{{asset($DocumentosAprovechamiento->ubicacion_documento)}}">
                                            {{$DocumentosAprovechamiento->nombre_documento}}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                     @endif
                </div>
            </div>


                <div class="card" id="detalle_ciclo">
                    <div class="card-header">
                        <h5 class="card-header-text"><i class="fa fa-repeat m-r-10"></i>Detalle ciclo de
                            taladro</h5>
                        <h4 class="card-header-toggle">+</h4>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-styling" id="tabla_plancha">
                                <thead>
                                    <tr class="background-primary">
                                        <th style="width: 30%">DIÁMETRO</th>
                                        <th style="width: 30%">CANTIDAD</th>
                                        <th style="width: 40%">METROS PERFORACIÓN</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($MetrosPerforacionPlancha as $MetrosPerforacionPlanchas)
                                    <tr style="text-align: center;">
                                        @if ($MetrosPerforacionPlanchas->MetrosPer == null || $MetrosPerforacionPlanchas->diametro_perforacion == 0)
                                        @else
                                            <td>{{$MetrosPerforacionPlanchas->diametro_perforacion}}</td>
                                            <td>{{$MetrosPerforacionPlanchas->cantidad_perforacion}}</td>
                                            <td>{{number_format($MetrosPerforacionPlanchas->MetrosPer, 2, '.', '')}}</td>
                                        @endif
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            @if ($aprov->tipo_lista == 'PLANCHAS')
            <div class="card" id="detalle_calculos">
                    <div class="card-header">
                        <h5 class="card-header-text"><i class="fa fa-calculator m-r-10"></i>Detalles cálculos</h5>
                        <h4 class="card-header-toggle">+</h4>
                    </div>
                    
                    <div class="card-content">
                            <table class="table table-striped table-bordered table-styling table-responsive" id="tabla_calculos">
                                @if($aprov->tecnologia == 'OXICORTE')
                                <tbody>
                                    <tr>
                                        <th>Velocidad de corte (mm/min):</th>
                                        <td>{{number_format($VelocidadCorte, 2, '.', '')}}</td>
                                        <th>Longitud (mm):</th>
                                        <td>{{number_format($aprov->longitud_corte, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Tiempo efectivo de corte (min):</th>
                                        <td>{{number_format($TiempoEfectivoCorteMinutos, 2, '.', '')}}</td>
                                        <th>Tiempo efectivo de corte (h):</th>
                                        <td>{{number_format($TiempoEfectivoCorteHoras, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Tiempo de Prec. por Entradas (seg):</th>
                                        <td>{{number_format($TiempoPrecalentamientoEntradasSegundos, 2, '.', '')}}</td>
                                        <th>Tiempo de Prec. por Entradas (min):</th>
                                        <td>{{number_format($TiempoPrecalentamientoEntradasMinutos, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Consumo de Oxigeno/Prec. por "Entradada" (m3):</th>
                                        <td>{{number_format($ConsumoOxigenoPorEntradas, 2, '.', '')}}</td>
                                        <th>Consumo de Oxigeno/Prec. por "Entradada" (lt):</th>
                                        <td>{{number_format($ConsumoOxigenoPorEntradasLitros, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Consumo de Oxigeno/Prec. "Continuo" (m3):</th>
                                        <td>{{number_format($ConsumoOxigenoContinuo, 2, '.', '')}}</td>
                                        <th>Consumo de Oxigeno/Prec. "Continuo" (lt):</th>
                                        <td>{{number_format($ConsumoOxigenoContinuoLitros, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Consumo de Oxigeno/Corte (m3):</th>
                                        <td>{{number_format($ConsumoOxigenoCorte, 2, '.', '')}}</td>
                                        <th>Consumo de Oxigeno/Corte (lt):</th>
                                        <td>{{number_format($ConsumoOxigenoCorteLitros, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Consumo de Gas butano/Corte (m3):</th>
                                        <td>{{number_format($ConsumoGasCorte, 2, '.', '')}}</td>
                                        <th>Consumo de Gas butano/Corte (lt):</th>
                                        <td>{{number_format($ConsumoGasCorteLitros, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="4">TOTALES</th>
                                    </tr>
                                    <tr>
                                        <th>Consumo Total Oxigeno(m3):</th>
                                        <td>{{number_format($ConsumoTotalOxigeno, 2, '.', '')}}</td>
                                        <th>Consumo Total Oxigeno (lt):</th>
                                        <td>{{number_format($ConsumoTotalOxigenoLitros, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Consumo Total Gas butano (m3):</th>
                                        <td>{{number_format($ConsumoGasCorte, 2, '.', '')}}</td>
                                        <th>Consumo Total Gas butano(lt):</th>
                                        <td>{{number_format($ConsumoGasCorteLitros, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Kilos de Gas Butano (kg)</th>
                                        <td>{{number_format($KilosGasButano, 2, '.', '')}}</td>
                                        <th></th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Número de Cilindro de Oxigeno (und)</th>
                                        <td>{{number_format($NumeroCilidrosOxigeno, 2, '.', '')}}</td>
                                        <th>Número de Cilindro de Gas (und)</th>
                                        <td>{{number_format($NumeroCilidrosGas, 2, '.', '')}}</td>
                                    </tr>
                                </tbody>
                              
                                @else

                                <tbody>
                                    <tr>
                                        <th>Velocidad de corte (mm/min):</th>
                                        <td>{{number_format($VelocidadCorte[0]->valor, 2, '.', '')}}</td>
                                        <th>Longitud (mm):</th>
                                        <td>{{number_format($aprov->longitud_corte, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Tiempo efectivo de corte (min):</th>
                                        <td>{{number_format($TiempoEfectivoCorteMinutos, 2, '.', '')}}</td>
                                        <th>Tiempo efectivo de corte (h):</th>
                                        <td>{{number_format($TiempoEfectivoCorteHoras, 2, '.', '')}}</td>
                                    </tr>

                                    <tr>
                                        <th>Consumo de Oxigeno/Corte (lt):</th>
                                        <td>{{number_format($ConsumoOxigenoPlasmaLitros, 2, '.', '')}}</td>
                                        <th>Consumo de Oxigeno/Corte (m3):</th>
                                        <td>{{number_format($ConsumoOxigenoPlasmaM3, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Porcentaje de desperdicio (lt):</th>
                                        <td>{{number_format($PorcentajeDesperdicioLitros, 2, '.', '')}}</td>
                                        <th>Porcentaje de desperdicio (m3):</th>
                                        <td>{{number_format($PorcentajeDesperdicioM3, 2, '.', '')}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="4">TOTALES</th>
                                    </tr>

                                    <tr>
                                        <th>Número Cilindros Oxigeno</th>
                                        <td>{{number_format($NumeroCilidrosOxigeno, 2, '.', '')}}</td>
                                        <th></th>
                                        <td></td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                    </div>
                </div>
        @endif


        <div class="card">
            <div class="card-header">
                <h5 class="card-header-text"><i class="fa fa-users m-r-10"></i>Responsables</h5>
            </div>
            <div class="card-block task-details table-responsive dt-responsive">
                <table class="table table-border table-xs">
                    <tbody>

                        <tr>
                            <td><i class="fa fa-calendar-plus-o m-r-5"></i></i> Fecha creado:</td>
                            <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($aprov->fecha_creado))}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-user m-r-5"></i></i> Creado por:</td>
                            <td class="text-right">{{ $aprov->name}}</td>
                        </tr>

                        @if($aprov->fecha_validado != NULL)
                            <tr>
                                <td><i class="fa fa-calendar m-r-5"></i> Fecha validado: </td>
                                <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($AprovUsuarioValidado->fecha_validado))}}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-user m-r-5"></i></i> Validado por:</td>
                                <td class="text-right">{{ $AprovUsuarioValidado->name}}</td>
                            </tr>
                        @endif

                        @if($aprov->fecha_aprobado != NULL)
                            <tr>
                                <td><i class="fa fa-calendar m-r-5"></i> Fecha Aprobado: </td>
                                <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($AprovUsuarioAprobado->fecha_aprobado))}}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-user m-r-5"></i></i> Aprobado por:</td>
                                <td class="text-right">{{ $AprovUsuarioAprobado->name}}</td>
                            </tr>
                        @endif

                        @if($aprov->fecha_enproceso != NULL)
                            <tr>
                                <td><i class="fa fa-calendar m-r-5"></i> Fecha En Proceso: </td>
                                <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($AprovUsuarioEnProceso->fecha_enproceso))}}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-user m-r-5"></i></i> En Proceso por:</td>
                                <td class="text-right">{{ $AprovUsuarioEnProceso->name}}</td>
                            </tr>
                        @endif

                        @if($aprov->fecha_anulado != NULL)
                            <tr>
                                <td><i class="fa fa-calendar m-r-5"></i> Fecha Anulado: </td>
                                <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($AprovUsuarioAnulado->fecha_anulado))}}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-user m-r-5"></i></i> Anulado por:</td>
                                <td class="text-right">{{ $AprovUsuarioAnulado->name}}</td>
                            </tr>
                        @endif

                        @if($aprov->fecha_finalizado != NULL)
                            <tr>
                                <td><i class="fa fa-calendar m-r-5"></i> Fecha Finalizado: </td>
                                <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($AprovUsuarioFinalizado->fecha_finalizado))}}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-user m-r-5"></i></i> Finalizado por:</td>
                                <td class="text-right">{{ $AprovUsuarioFinalizado->name}}</td>
                            </tr>
                        @endif

                    </tbody> 
                </table>
            </div>
        </div>


        </div>

        <hr><br>


    </div>
</div>
<!-- Page-body end -->

@endsection

@section('scripts')

<script>
    // JavaScript para el acordeón
    document.addEventListener('DOMContentLoaded', function() {
      var card = document.getElementById('detalle_documentos');
      card.addEventListener('click', function() {
        card.classList.toggle('open');
      });
    });
</script>

<script>
    // JavaScript para el acordeón
    document.addEventListener('DOMContentLoaded', function() {
      var card = document.getElementById('detalle_ciclo');
      card.addEventListener('click', function() {
        card.classList.toggle('open');
      });
    });
</script>

<script>
    // JavaScript para el acordeón
    document.addEventListener('DOMContentLoaded', function() {
      var card = document.getElementById('detalle_calculos');
      card.addEventListener('click', function() {
        card.classList.toggle('open');
      });
    });
</script>

<script type="text/javascript" src="{{ asset('libraries\assets\js\CencAprovechamiento-show.js') }}"></script>


@endsection