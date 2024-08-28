<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>SEGUIMIENTO</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images/logos/favico.png') }}" type="image/x-icon">
</head>

<body>
    <style>
        h4,
        h5,
        h6 {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border: 0px solid #000;
            margin: 10px 10px 10px 10px;
            border-spacing: 0px;
            border-collapse: collapse;
        }

        td {
            padding-left: 5px;
            padding-right: 5px;
            text-align: center;
        }

        th,
        td {
            padding: 4px;
        }

        .center {
            text-align: center;
        }

        .firma {
            padding-bottom: 30px;
        }

        body {
            font-size: 10px;
            overflow-x: hidden;
            color: #353c4e;
            font-family: "Open Sans", sans-serif;
            background-attachment: fixed;
        }
    </style>

    <h4 class="center">SEGUIMIENTO</h4>
    <h6 style="text-align: right;">Fecha Impresión: {{ Carbon\Carbon::now()->format('d-m-Y H:i:s')}}</h6>

    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px">
                    <img src="{{ asset('images/logos/logo_global_menu.png') }}" alt="" class="">
                    <br>
                    <strong>ACERONET</strong>
                </td>
                <td style="width:80px">
                    <h5>FECHA CREACIÓN</h5>
                    {{$BuscarOrdenTrabajo->created_at}}
                </td>
                <td style="width:80px">
                    <h5>CREADO POR</h5>
                    {{$BuscarOrdenTrabajo->name}}
                </td>
                {{-- <td style="width:80px">
                    <h5>TIPO</h5>
                    {{$BuscarOrdenTrabajo->tipo_lista}}
                </td> --}}
                {{-- <td style="width:80px">
                    <h5>CENTRO DE TRABAJO</h5>
                    {{$BuscarOrdenTrabajo->nombre_equipo}}
                </td> --}}
                {{-- <td style="width:80px">
                    <h5>TECNOLOGÍA</h5>
                    {{$BuscarOrdenTrabajo->nombre_tecnologia}}
                </td> --}}
                <td style="width:80px">
                    <h5>CONAP</h5>
                    N° {{$BuscarOrdenTrabajo->nro_conap}}
                </td>
                <td style="width:80px">
                    <h5>APROVECHAMIENTO</h5>
                    N° {{$BuscarOrdenTrabajo->id_aprovechamiento}}
                </td>
                <td style="width:80px">
                    <h5>ORDEN DE TRABAJO</h5>
                    N° {{$BuscarOrdenTrabajo->id_orden_trabajo}}
                </td>
                <td style="width:80px">
                    <h5>SEGUIMIENTO</h5>
                    N° {{$BuscarSeguimiento->id_seguimiento}}
                </td>
                <td style="width:80px">
                    <h5>ESTATUS</h5>
                    {{$BuscarSeguimiento->estatus}}
                </td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="center">
        <tbody>
            <tr>
                <th>CENTRO DE TRABAJO:</th>
                <td>{{$BuscarOrdenTrabajo->nombre_equipo}}</td>
            </tr>
            <tr>
                <th>TECNOLOGÍA:</th>
                <td>{{$BuscarOrdenTrabajo->nombre_tecnologia}}</td>
            </tr>
            <tr>
                <th>TIPO:</th>
                <td> {{$BuscarOrdenTrabajo->tipo_lista}}</td>
            </tr>
            {{-- <tr>
                <th>TECNOLOGÍA:</th>
                <td>{{$OrdenesTrabajosConap->nombre_tecnologia}}</td>
            </tr>
            <tr>
                <th>FECHA INICIO:</th>
                <td>{{$OrdenesTrabajosConap->fecha_inicio}}</td>
            </tr>
            <tr>
                <th>FECHA CULMINACIÓN:</th>
                <td>{{$OrdenesTrabajosConap->fecha_fin}}</td>
            </tr> --}}
        </tbody>
    </table>

    @if($BuscarOrdenTrabajo->equipo == '1')

    <table border="1" class="center">
        <thead>
            <tr>
                <th colspan="10" style="background-color: #D9D9D9;">TIEMPOS TOTALES / HORÓMETROS MAQUINA</th>
            </tr>
        </thead>
        <thead style="background-color: #D9D9D9;">
                <tr>
                    <th class="bg-primary text-center" colspan="2"></th>
                    <th class="bg-primary text-center" colspan="4">ESTADO EN FUNCIONAMIENTO/MÁQUINA ENCENDIDA</th>
                    <th class="bg-primary text-center" colspan="4">TIEMPO DE TRABAJO BAJO PROGRAMACIÓN</th>
                </tr>
                <tr>
                    <th class="bg-primary text-center" colspan="2"></th>
                    <th class="bg-primary text-center" colspan="2">CONTADOR MÁQUINA</th>
                    <th class="bg-inverse text-center" colspan="2">RELACIÓN</th>
                    <th class="bg-primary text-center" colspan="2">CONTADOR MÁQUINA</th>
                    <th class="bg-inverse text-center" colspan="2">RELACIÓN</th>
                </tr>
                <tr>
                    <th class="bg-primary text-center" style="width: 3%">ID</th>
                    <th class="bg-primary text-center" style="width: 10%">Fecha</th>
                    <th class="bg-primary text-center">Horómetro Inicial ON</th>
                    <th class="bg-primary text-center">Horómetro Final ON</th>
                    <th class="bg-inverse text-center">Horas Máquina ON (HH:MM:SEC)</th>
                    <th class="bg-inverse text-center">Horas Máquina ON (Horas)</th>
                    <th class="bg-primary text-center">Horómetro Inicial AUT</th>
                    <th class="bg-primary text-center">Horómetro Final AUT</th>
                    <th class="bg-inverse text-center">Tiempo modo AUT (HH:MM:SEC)</th>
                    <th class="bg-inverse text-center">Tiempo modo AUT (Horas)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($SeguimientoPlanchaHorometro as $SeguimientoPlanchaHorometros)
                <tr>
                    <td id='id_horometro'>{{$SeguimientoPlanchaHorometros->id_seguimiento_pl_horometro }}  </td>
                    <td id='fecha_creado_horometro'> {{$SeguimientoPlanchaHorometros->fecha_creado }} </td>
                    <td id='horometro_inicial_on'>{{$SeguimientoPlanchaHorometros->horometro_inicial_on }} </td>
                    <td id='horometro_final_on'>{{$SeguimientoPlanchaHorometros->horometro_final_on }} </td>
                    <td id='horas_maquina_on'>{{$SeguimientoPlanchaHorometros->horas_hms_on }} </td>
                    <td class='horas_on' id='horas_on'>{{$SeguimientoPlanchaHorometros->horas_on }} </td>
                    <td id='horometro_inicial_aut'>{{$SeguimientoPlanchaHorometros->horometro_inicial_aut }} </td>
                    <td id='horometro_final_aut'>{{$SeguimientoPlanchaHorometros->horometro_final_aut }} </td>
                    <td id='tiempo_modo_aut'> {{$SeguimientoPlanchaHorometros->tiempo_hms_aut }} </td>
                    <td class='tiempo_aut' id='tiempo_aut'>{{$SeguimientoPlanchaHorometros->tiempo_aut }} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4"></th>
                    <th>Total Horas</th>
                    <th id="total_horas_on">
                        @if ($TotalHorasOn == '')
                        @else
                            {{number_format($TotalHorasOn, 2, '.', '')}}
                        @endif
                    </td>
                    <th colspan="2"> </th>
                    <th>Total Horas</th>
                    <th id="total_tiempo_aut">
                        @if ($TotalTiempoAut == '')
                        @else
                        {{number_format($TotalTiempoAut, 2, '.', '')}}
                        @endif
                    </td>
                </tr> 
            </tfoot>
    </table>

    @else

    <table border="1" class="center">
        <thead>
            <tr>
                <th colspan="6" style="background-color: #D9D9D9;">TIEMPOS TOTALES / HORÓMETROS MAQUINA</th>
            </tr>
        </thead>
        <thead style="background-color: #D9D9D9;">
                <tr>
                    <th class="bg-primary text-center" colspan="2"></th>
                    <th class="bg-primary text-center" colspan="4">ESTADO EN FUNCIONAMIENTO/MÁQUINA ENCENDIDA</th>
                </tr>
                <tr>
                    <th class="bg-primary text-center" colspan="2"></th>
                    <th class="bg-primary text-center" colspan="2">CONTADOR MÁQUINA</th>
                    <th class="bg-inverse text-center" colspan="2">RELACIÓN</th>
                </tr>
                <tr>
                    <th class="bg-primary text-center" style="width: 3%">ID</th>
                    <th class="bg-primary text-center" style="width: 10%">Fecha</th>
                    <th class="bg-primary text-center">Horómetro Inicial ON</th>
                    <th class="bg-primary text-center">Horómetro Final ON</th>
                    <th class="bg-inverse text-center">Horas Máquina ON (HH:MM:SEC)</th>
                    <th class="bg-inverse text-center">Horas Máquina ON (Horas)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($SeguimientoPlanchaHorometro as $SeguimientoPlanchaHorometros)
                <tr>
                    <td id='id_horometro'>{{$SeguimientoPlanchaHorometros->id_seguimiento_pl_horometro }}  </td>
                    <td id='fecha_creado_horometro'> {{$SeguimientoPlanchaHorometros->fecha_creado }} </td>
                    <td id='horometro_inicial_on'>{{$SeguimientoPlanchaHorometros->horometro_inicial_on }} </td>
                    <td id='horometro_final_on'>{{$SeguimientoPlanchaHorometros->horometro_final_on }} </td>
                    <td id='horas_maquina_on'>{{$SeguimientoPlanchaHorometros->horas_hms_on }} </td>
                    <td class='horas_on' id='horas_on'>{{$SeguimientoPlanchaHorometros->horas_on }} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4"></th>
                    <th>Total Horas</th>
                    <th id="total_horas_on">
                        @if ($TotalHorasOn == '')
                        @else
                            {{number_format($TotalHorasOn, 2, '.', '')}}
                        @endif
                    </td>
                    
                </tr> 
            </tfoot>
    </table>

    @endif
  

    <table border="1" class="center">
        <thead>
            <tr>
                <th colspan="12" style="background-color: #D9D9D9;">AVANCE DE CORTE DIARIO</th>
            </tr>
        </thead>
            <thead>
                <tr class="background-primary" style="background-color: #D9D9D9;">
                    <th class="bg-inverse" style="width: 3%">ID</th>
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
                    <td id='id_avance'>{{$SeguimientoPlanchaAvances->id_seguimiento_pl_avance}}</td>
                    <td id='fecha_creado_avance'>{{$SeguimientoPlanchaAvances->fecha_creado}}</td>
                    <td class='numero_parte' id='numero_parte'>{{$SeguimientoPlanchaAvances->nro_partes}}</td>
                    <td class='descripcion_nroparte' id='descripcion_nroparte'>{{$SeguimientoPlanchaAvances->descripcion}}</td>
                    <td class='dimensiones_nroparte' id='dimensiones_nroparte'>{{$SeguimientoPlanchaAvances->dimensiones}}</td>
                    <td class='cant_piezas_nroparte' id='cant_piezas_nroparte'>{{$SeguimientoPlanchaAvances->cantidad_piezas}}</td>
                    <td class='peso_unit_nroparte' id='peso_unit_nroparte'>{{number_format($SeguimientoPlanchaAvances->peso_unitario, 3, '.', '')}}</td>
                    <td class='peso_total_nroparte' id='peso_total_nroparte'>{{number_format($SeguimientoPlanchaAvances->peso_total, 3, '.', '')}}</td>
                    <td class='cant_piezas_avance' id='cant_piezas_avance'>{{$SeguimientoPlanchaAvances->avance_cant_piezas}}</td>
                    <td class='peso_avance' id='peso_avance'>{{number_format($SeguimientoPlanchaAvances->avance_peso, 3, '.', '')}}</td>              
                    <td class='cant_piezas_pendiente' id='cant_piezas_pendiente'>{{$SeguimientoPlanchaAvances->pendiente_cant_piezas}}</td>
                    <td class='peso_pendiente' id='peso_pendiente'>{{number_format($SeguimientoPlanchaAvances->pendiente_peso, 3, '.', '')}}</td>                            
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

    <table border="1" class="center">
        <thead>
            <tr>
                <th colspan="7" style="background-color: #D9D9D9;">OXIGENO</th>
            </tr>
        </thead>
        <thead>
            <tr class="background-primary" style="background-color: #D9D9D9;">
                <th style="width: 3%">ID</th>
                <th>Fecha</th>
                <th>Oxigeno Inicial (PSI)</th>
                <th>Oxigeno Final (PSI)</th>
                <th>Oxigeno Usado (PSI)</th>
                <th>¿Cambió?</th>
                <th>Litros Gaseosos (L)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($SeguimientoPlanchaOxigeno as $SeguimientoPlanchaOxigenos)
                <tr>
                    <td id='id_oxigeno'>{{$SeguimientoPlanchaOxigenos->id_seguimiento_pl_oxigeno}}</td>
                    <td id='fecha_creado_oxigeno'>{{$SeguimientoPlanchaOxigenos->fecha_creado}}</td>
                    <td id='oxigeno_inicial'>{{$SeguimientoPlanchaOxigenos->oxigeno_inicial}}</td>
                    <td id='oxigeno_final'>{{$SeguimientoPlanchaOxigenos->oxigeno_final}}</td>
                    <td id='oxigeno_usado'>{{$SeguimientoPlanchaOxigenos->oxigeno_usado}}</td>
                    <td id='cambio_oxigeno'>{{$SeguimientoPlanchaOxigenos->cambio}}</td>
                    <td id='litros_gaseosos'>
                        @if ($SeguimientoPlanchaOxigenos->litros_gaseosos == '')
                        @else
                        {{number_format($SeguimientoPlanchaOxigenos->litros_gaseosos, 2, '.', '')}}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <thead>
            <tr class="background-primary">
                <th></th>
                <th colspan="3">TOTAL OXIGENO</th>
                <th id="total_oxigeno_usados">{{$TotalOxigenoUsado}}</th>
                <th>TOTAL LITROS</th>
                <th id="total_litros_gaseosos">
                    @if ($TotalLitrosGaseosos == '')
                    @else
                    {{number_format($TotalLitrosGaseosos, 2, '.', '')}}
                    @endif
                </th>
            </tr>
        </thead>
    </table>

    <table border="1" class="center">
        <thead>
            <tr>
                <th colspan="6" style="background-color: #D9D9D9;">CONSUMIBLES</th>
            </tr>
        </thead>
        <thead>
            <tr class="background-primary" style="background-color: #D9D9D9;">
                <th style="width: 3%">ID</th>
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
                    <td id='id_consumible'>{{$SeguimientoPlanchaConsumibles->id_seguimiento_pl_consumible}}</td>
                    <td id='fecha_creado_consumible'>{{$SeguimientoPlanchaConsumibles->fecha_creado}}</td>
                    <td id='consumible_usado'>{{$SeguimientoPlanchaConsumibles->consumible}}</td>
                    <td id='consumo_consumible'>
                        @if ($SeguimientoPlanchaConsumibles->consumo == '')
                        @else
                        {{number_format($SeguimientoPlanchaConsumibles->consumo, 2, '.', '')}}
                        @endif
                    </td>
                    <td id='unidad_consumible'>{{$SeguimientoPlanchaConsumibles->unidad}}</td>
                    <td id='observacion_consumible'>{{$SeguimientoPlanchaConsumibles->observaciones}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>