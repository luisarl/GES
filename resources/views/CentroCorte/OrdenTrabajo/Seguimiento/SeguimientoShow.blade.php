@extends('layouts.master')

@section('titulo', 'Seguimiento')

@section('titulo_pagina', 'Seguimiento')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cencseguimiento.index') }}">Seguimiento</a>
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


<div class="card">
    <div class="card-block">

        Estatus:
        @if(isset($Seguimiento->estatus))
            @if($Seguimiento->estatus == 'EN PROCESO')
                <label class="label label-warning">EN PROCESO</label>
                @elseif($Seguimiento->estatus == 'ANULADO')
                <label class="label label-danger">ANULADO</label>
                @elseif($Seguimiento->estatus == 'FINALIZADO')
                <label class="label label-success">FINALIZADO</label>
            @endif
        @endif
            
         <a href="{{ route('cencseguimientopdf', $OrdenTrabajoPlancha->id_orden_trabajo_plancha) }}" 
        target="_blank" type="button"class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
        <i class="fa fa-print"></i>Imprimir</a>

        {{-- 
        <a href="{{ route('cencseguimiento.edit', $Seguimiento->id_seguimiento) }}" 
            target="_blank" type="button"class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
            <i class="fa fa-edit"></i>Editar</a>
        --}}
        </div> 
</div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          

<div class="page-body">

    <div class="row">
        <div class="col-xl-12 col-lg-12">

            @if($OrdenTrabajoPlancha->id_equipo == '1') 
            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title">TIEMPOS TOTALES / HORÓMETROS MAQUINA / KF2612</h4>
    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="TablaHorometro">
                            <thead>
                                <tr>
                                    <th class="bg-primary text-center" style="width: 2%"></th>
                                    <th class="bg-primary text-center" style="width: 15%"></th>
                                    <th class="bg-primary text-center" colspan="4">ESTADO EN FUNCIONAMIENTO/MÁQUINA ENCENDIDA</th>
                                    <th class="bg-primary text-center" colspan="4">TIEMPO DE TRABAJO BAJO PROGRAMACIÓN</th>
                                </tr>
                                <tr>
                                    <th class="bg-primary text-center" style="width: 2%"></th>
                                    <th class="bg-primary text-center" style="width: 15%"></th>
                                    <th class="bg-primary text-center" colspan="2">CONTADOR MÁQUINA</th>
                                    <th class="bg-inverse text-center" colspan="2">RELACIÓN</th>
                                    <th class="bg-primary text-center" colspan="2">CONTADOR MÁQUINA</th>
                                    <th class="bg-inverse text-center" colspan="2">RELACIÓN</th>
                                </tr>
                                <tr>
                                    <th class="bg-primary text-center" style="width: 2%">ID</th>
                                    <th class="bg-primary text-center" style="width: 5%">Fecha</th>
                                    <th class="bg-primary text-center" style="width: 15%">Horómetro Inicial ON</th>
                                    <th class="bg-primary text-center" style="width: 15%">Horómetro Final ON</th>
                                    <th class="bg-inverse text-center" style="width: 15%">Horas Máquina ON (HH:MM:SEC)</th>
                                    <th class="bg-inverse text-center" style="width: 15%">Horas Máquina ON (Horas)</th>
                                    <th class="bg-primary text-center" style="width: 15%">Horómetro Inicial AUT</th>
                                    <th class="bg-primary text-center" style="width: 15%">Horómetro Final AUT</th>
                                    <th class="bg-inverse text-center" style="width: 15%">Tiempo modo AUT (HH:MM:SEC)</th>
                                    <th class="bg-inverse text-center" style="width: 15%">Tiempo modo AUT (Horas)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($SeguimientoPlanchaHorometro as $SeguimientoPlanchaHorometros)
                                <tr>
                                    <td id='id_horometro'> {{$SeguimientoPlanchaHorometros->id_seguimiento_pl_horometro}}</td>
                                    <td id='fecha_creado_horometro'> {{$SeguimientoPlanchaHorometros->fecha_creado}}</td>
                                    <td id='horometro_inicial_on'> {{$SeguimientoPlanchaHorometros->horometro_inicial_on}}</td>
                                    <td id='horometro_final_on'> {{$SeguimientoPlanchaHorometros->horometro_final_on}}</td>
                                    <td id='horas_maquina_on'> {{$SeguimientoPlanchaHorometros->horas_hms_on}}</td>
                                    <td class='horas_on' id='horas_on'> {{$SeguimientoPlanchaHorometros->horas_on}}</td>
                                    <td id='horometro_inicial_aut'> {{$SeguimientoPlanchaHorometros->horometro_inicial_aut}}</td>
                                    <td id='horometro_final_aut'> {{$SeguimientoPlanchaHorometros->horometro_final_aut}}</td>
                                    <td id='tiempo_modo_aut'> {{$SeguimientoPlanchaHorometros->tiempo_hms_aut}}</td>
                                    <td class='tiempo_aut' id='tiempo_aut'> {{$SeguimientoPlanchaHorometros->tiempo_aut}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4"></th>
                                    <th style="width: 15%">Total Horas</th>
                                    <th style="width: 15%" id="total_horas_on">{{$TotalHorasOn}}</th>

                                    <th colspan="2"> </th>
                                    <th style="width: 15%" >Total Horas</th>
                                    <th style="width: 15%" id="total_tiempo_aut">{{$TotalTiempoAut}}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
    @else
    <div class="card">
        <div class="card-block">
            <h4 class="sub-title">TIEMPOS TOTALES / HORÓMETROS MAQUINA / MORROCOY</h4>
            <input type="text"  id="equipo" value="MORROCOY" style="display: none;">
            <br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="TablaHorometro">
                    <thead>
                        <tr>
                            <th class="bg-primary text-center" style="width: 2%"></th>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                            <th class="bg-primary text-center" colspan="4">ESTADO EN FUNCIONAMIENTO/MÁQUINA ENCENDIDA</th>
                        </tr>
                        <tr>
                            <th class="bg-primary text-center" style="width: 2%"></th>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                            <th class="bg-primary text-center" colspan="2">CONTADOR MÁQUINA</th>
                            <th class="bg-inverse text-center" colspan="2">RELACIÓN</th>
                        </tr>
                        <tr>
                            <th class="bg-primary text-center" style="width: 2%">ID</th>
                            <th class="bg-primary text-center" style="width: 5%">Fecha</th>
                            <th class="bg-primary text-center" style="width: 15%">Horómetro Inicial ON</th>
                            <th class="bg-primary text-center" style="width: 15%">Horómetro Final ON</th>
                            <th class="bg-inverse text-center" style="width: 15%">Horas Máquina ON (HH:MM:SEC)</th>
                            <th class="bg-inverse text-center" style="width: 15%">Horas Máquina ON (Horas)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($SeguimientoPlanchaHorometro as $SeguimientoPlanchaHorometros)
                        <tr>
                            <td id='id_horometro'> {{$SeguimientoPlanchaHorometros->id_seguimiento_pl_horometro}}</td>
                            <td id='fecha_creado_horometro'> {{$SeguimientoPlanchaHorometros->fecha_creado}}</td>
                            <td id='horometro_inicial_on'> {{$SeguimientoPlanchaHorometros->horometro_inicial_on}}</td>
                            <td id='horometro_final_on'> {{$SeguimientoPlanchaHorometros->horometro_final_on}}</td>
                            <td id='horas_maquina_on'> {{$SeguimientoPlanchaHorometros->horas_hms_on}}</td>
                            <td class='horas_on' id='horas_on'> {{$SeguimientoPlanchaHorometros->horas_on}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4"></th>
                            <th style="width: 15%">Total Horas</th>
                                <th style="width: 15%" id="total_horas_on">{{$TotalHorasOn}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endif
            
             <div class="card">
                <div class="card-block">
                    <h4 class="sub-title">AVANCE DE CORTE DIARIO</h4>
        
        
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="tabla_lista_parte">
                            <thead>
                                <tr class="bg-inverse">
                                    <th style="text-align: center">Lista de Partes</th>
                                    <th style="text-align: center">Espesor (MM)</th>
                                    <th style="text-align: center">Cantidad Total (UND)</th>
                                    <th style="text-align: center">Peso Total (KG)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th style="text-align: center">{{$OrdenTrabajoPlancha->id_lista_parte}}</th>
                                    <th style="text-align: center">{{number_format($espesor, 2, '.', '')}}</th>
                                    <th style="text-align: center" class="cantidad_total_lp">{{$cantidad}}</th>
                                    <th style="text-align: center" class="peso_total_lp">{{number_format($peso, 2, '.', '')}}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <br>
        
                    <div class="table-responsive">
                    
                        <table class="table table-striped table-bordered table-styling" id="TablaAvance">
                            <thead>
                                <tr class="background-primary">
                                    <th class="bg-inverse">ID</th>
                                    <th class="bg-inverse">Fecha</th>
                                    <th class="bg-inverse">Nro. Parte</th>
                                    <th class="bg-inverse">Descripción</th>
                                    <th class="bg-inverse">Dimensiones (MM)</th>
                                    <th class="bg-inverse">Cantidad Piezas (UND)</th>
                                    <th class="bg-inverse">Peso Unitario (KG)</th>
                                    <th class="bg-inverse">Peso Total (KG)</th>
                                    <th>Avance Cant. Piezas (UND)</th>
                                    <th>Avance Peso Total (KG)</th>
                                    <th>Pendiente Cant. Piezas (UND)</th>
                                    <th>Pendiente Peso Total (KG)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($SeguimientoPlanchaAvance as $SeguimientoPlanchaAvances)
                                <tr>
                                    <td id='id_avance'> {{$SeguimientoPlanchaAvances->id_seguimiento_pl_avance}}</td>
                                    <td id='fecha_creado_avance'> {{$SeguimientoPlanchaAvances->fecha_creado}}</td>
                                    <td class='numero_parte' id='numero_parte'> {{$SeguimientoPlanchaAvances->nro_partes}}</td>
                                    <td class='descripcion_nroparte' id='descripcion_nroparte'> {{$SeguimientoPlanchaAvances->descripcion}}</td>
                                    <td class='dimensiones_nroparte' id='dimensiones_nroparte'> {{$SeguimientoPlanchaAvances->dimensiones}}</td>
                                    <td class='cant_piezas_nroparte' id='cant_piezas_nroparte'> {{$SeguimientoPlanchaAvances->cantidad_piezas}}</td>
                                    <td class='peso_unit_nroparte' id='peso_unit_nroparte'> {{number_format($SeguimientoPlanchaAvances->peso_unitario, 3, '.', '')}}</td>
                                    <td class='peso_total_nroparte' id='peso_total_nroparte'> {{number_format($SeguimientoPlanchaAvances->peso_total, 3, '.', '')}}</td>
                                    <td class='cant_piezas_avance' id='cant_piezas_avance'> {{$SeguimientoPlanchaAvances->avance_cant_piezas}}</td>
                                    <td class='peso_avance' id='peso_avance'> {{number_format($SeguimientoPlanchaAvances->avance_peso, 3, '.', '')}}</td>
                                    <td class='cant_piezas_pendiente' id='cant_piezas_pendiente'> {{$SeguimientoPlanchaAvances->pendiente_cant_piezas}}</td>
                                    <td class='peso_pendiente' id='peso_pendiente'> {{number_format($SeguimientoPlanchaAvances->pendiente_peso, 3, '.', '')}}</td>                  
                                </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr class="background-primary">
                                    <th colspan="8">TOTAL DE PRODUCCIÓN</th>
                                    <th id="total_produc_cant_piezas_avance">{{$prod_cant_piezas_avance}}</th>
                                    <th id="total_produc_peso_avance">{{number_format($prod_peso_total_avance, 3, '.', '')}}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr class="bg-inverse">
                                    <th colspan="8">TOTAL PENDIENTE</th>
                                    <th id="total_pend_cant_piezas_avance">{{$pend_cant_piezas_avance}}</th>
                                    <th id="total_pend_peso_avance">{{number_format($pend_peso_avance, 3, '.', '')}}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title">CONSUMO DE OXIGENO</h4>
        
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="TablaOxigeno">
                            <thead>
                                <tr class="background-primary">
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Oxigeno Inicial (PSI)</th>
                                    <th>Oxigeno Final (PSI)</th>
                                    <th>Oxigeno Usados (PSI)</th>
                                    <th>Cambio</th>
                                    <th>Litros Gaseosos (L)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($SeguimientoPlanchaOxigeno as $SeguimientoPlanchaOxigenos)
                                <tr>
                                    <td id='id_oxigeno'> {{$SeguimientoPlanchaOxigenos->id_seguimiento_pl_oxigeno}}</td>
                                    <td id='fecha_creado_oxigeno'> {{$SeguimientoPlanchaOxigenos->fecha_creado}}</td>
                                    <td id='oxigeno_inicial'> {{$SeguimientoPlanchaOxigenos->oxigeno_inicial}}</td>
                                    <td id='oxigeno_final'> {{$SeguimientoPlanchaOxigenos->oxigeno_final}}</td>
                                    <td class='oxigeno_usado' id='oxigeno_usado'> {{$SeguimientoPlanchaOxigenos->oxigeno_usado}}</td>
                                    <td id='cambio_oxigeno'> {{$SeguimientoPlanchaOxigenos->cambio}}</td>
                                    <td class='litros_gaseosos' id='litros_gaseosos'> {{number_format($SeguimientoPlanchaOxigenos->litros_gaseosos, 2, '.', '')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr class="background-primary">
                                    <th></th>
                                    <th colspan="3">TOTAL OXIGENO</th>
                                    <th id="total_oxigeno_usados">{{number_format($TotalOxigenoUsado, 2, '.', '')}}</th>
                                    <th>TOTAL LITROS</th>
                                    <th id="total_litros_gaseosos">{{number_format($TotalLitrosGaseosos, 2, '.', '')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        
            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title">CONSUMIBLES USADOS</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="TablaConsumible">
                            <thead>
                                <tr class="background-primary">
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Consumible</th>
                                    <th>Consumo</th>
                                    <th>Unidad</th>
                                    <th>Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($SeguimientoPlanchaConsumible as $SeguimientoPlanchaConsumibles)
                                <tr>
                                    <td id='id_consumible'> {{$SeguimientoPlanchaConsumibles->id_seguimiento_pl_consumible}}</td>
                                    <td id='fecha_creado_consumible'> {{$SeguimientoPlanchaConsumibles->fecha_creado}}</td>
                                    <td id='consumible_usado'> {{$SeguimientoPlanchaConsumibles->consumible}}</td>
                                    <td id='consumo_consumible'> {{number_format($SeguimientoPlanchaConsumibles->consumo, 2, '.', '')}}</td>
                                    <td id='unidad_consumible'> {{$SeguimientoPlanchaConsumibles->unidad}}</td>
                                    <td id='observacion_consumible'> {{$SeguimientoPlanchaConsumibles->observaciones}}</td>
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