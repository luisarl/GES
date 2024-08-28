<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>ORDEN DE TRABAJO</title>
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



    <h4 class="center">ORDEN TRABAJO</h4>
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
                    {{$OrdenesTrabajosConap->created_at}}
                </td>
                <td style="width:80px">
                    <h5>CREADO POR</h5>
                    {{$OrdenesTrabajosConap->name}}
                </td>
                <td style="width:80px">
                    <h5>CONAP</h5>
                    N° {{$OrdenesTrabajosConap->nro_conap}}
                </td>
                <td style="width:80px">
                    <h5>APROVECHAMIENTO</h5>
                    N° {{$OrdenesTrabajosConap->id_aprovechamiento}}
                </td>
                <td style="width:80px">
                    <h5>ORDEN DE TRABAJO</h5>
                    N° {{$OrdenesTrabajosConap->id_orden_trabajo}}
                </td>
                <td style="width:80px">
                    <h5>ESTATUS</h5>
                    {{$OrdenesTrabajosConap->estatus}}
                </td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="center">
        <tbody>
            <tr>
                <th>NOMBRE DEL CONAP:</th>
                <td>{{$OrdenesTrabajosConap->nombre_conap}}</td>
            </tr>
            <tr>
                <th>DESCRIPCIÓN DEL CONAP:</th>
                <td>{{$OrdenesTrabajosConap->descripcion_conap}}</td>
            </tr>
            <tr>
                <th>FECHA INICIO:</th>
                <td>{{$OrdenesTrabajosConap->fecha_inicio}}</td>
            </tr>
            <tr>
                <th>FECHA CULMINACIÓN:</th>
                <td>{{$OrdenesTrabajosConap->fecha_fin}}</td>
            </tr>
        </tbody>
    </table>


    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <table border="1" class="center">
                    <thead style="background-color: #D9D9D9; text-align: center;">
                        <tr>
                            <th style="width: 15%">ESPESOR (MM)</th>
                            <th>TIEMPO (H)</th>
                            <th>CENTRO DE TRABAJO</th>
                            <th>TECNOLOGÍA</th>
                            <th>OXIGENO (L)</th>
                            <th>GAS PROPANO (L)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="text-align: center;">
                            @foreach($TiempoEjecutado as $index => $tiempoEjecutado)
                        <tr style="text-align: center;">
                            <td>{{number_format($Espesores[$index] ?? 0, 2, '.', '')}}</td>
                            <td>{{$CentroTrabajo[$index]}}</td>
                            <td>{{$Tecnologia[$index]}}</td>
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


    <div class="card-block">
        <table border="1" class="center">
            <thead>
                <tr class="background-primary">
                    <th colspan="5" style="background-color: #D9D9D9; text-align: center;">MATERIA PRIMA</th>
                </tr>
                <tr style="background-color: #D9D9D9; text-align: center;">
                    <th style="width:15%">ESPESOR (MM)</th>
                    <th style="width:50%">DIMENSIONES (MM)</th>
                    <th style="width:10%">CANTIDAD (UND)</th>
                    <th>PESO UNITARIO (KG)</th>
                    <th>PESO TOTAL (KG)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($MateriaPrima as $MateriaPrimas)
                <tr>
                    <td id='espesor_materia'>{{number_format($MateriaPrimas->espesor, 2, '.', '')}}</td>
                    <td id='dimensiones_materia'>{{$MateriaPrimas->dimensiones}}</td>
                    <td id='cantidad_materia'>{{$MateriaPrimas->cantidad}}</td>
                    <td id='peso_materia'>{{number_format($MateriaPrimas->peso_unit, 2, '.', '')}}</td>
                    <td id='peso_materia'>{{number_format($MateriaPrimas->peso_total, 2, '.', '')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="card-block">
        <table border="1" class="center">
            <thead>
                <tr class="background-primary">
                    <th colspan="5" style="background-color: #D9D9D9; text-align: center;">ÁREA DE CORTE</th>
                </tr>
                <tr style="background-color: #D9D9D9; text-align: center;">
                    <th style="width:15%">ESPESOR (MM)</th>
                    <th style="width:50%">DIMENSIONES (MM)</th>
                    <th style="width:10%">CANTIDAD (UND)</th>
                    <th>PESO UNITARIO (KG)</th>
                    <th>PESO TOTAL (KG)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($AreaCorte as $AreaCortes)
                <tr>
                    <td id='espesor_area'>{{number_format($AreaCortes->espesor, 2, '.', '')}}</td>
                    <td id='dimensiones_corte'>{{$AreaCortes->dimensiones}}</td>
                    <td id='cantidad_corte'>{{$AreaCortes->cantidad}}</td>
                    <td id='peso_corte'>{{number_format($AreaCortes->peso_unit, 2, '.', '')}}</td>
                    <td id='peso_corte'>{{number_format($AreaCortes->peso_total, 2, '.', '')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="card-block">
        <div class="table-responsive">
            <table border="1" class="center">
                <tr class="background-primary">
                    <th colspan="3" style="background-color: #D9D9D9; text-align: center;">TIEMPOS TOTALES / HORÓMETROS
                        MAQUINAS</th>
                </tr>
                <thead>
                    <tr style="background-color: #D9D9D9; text-align: center;">
                        <th style="width: 15%">ESPESOR (MM)</th>
                        <th>HORAS MÁQUINA</th>
                        <th>HORAS AUTOMÁTICO</th>
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


    <div class="card-block">
        <div class="table-responsive">
            <table border="1" class="center">
                <thead>
                    <tr class="background-primary">
                        <th colspan="7" style="background-color: #D9D9D9; text-align: center;">PARTES CORTADAS</th>
                    </tr>
                    <tr style="background-color: #D9D9D9; text-align: center;">
                        <th style="width: 15%">ESPESOR (MM)</th>
                        <th>APROVECHAMIENTO</th>
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
                            {{number_format($TotalToneladas = $TotalAvances['avance_peso'] / 1000, 3, '.', '')}}
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

    <div class="card-block">
        <div class="table-responsive">
            <table border="1" class="center">
                <thead>
                    <tr class="background-primary">
                        <th colspan="7" style="background-color: #D9D9D9; text-align: center;">CORTES</th>
                    </tr>

                    <tr style="background-color: #D9D9D9; text-align: center;">
                        <th style="width: 15%">ESPESOR (MM)</th>
                        <th>CNC APROV</th>
                        <th>PIEZAS ANIDADAS</th>
                        <th>PIEZAS CORTADAS</th>
                        <th>PIEZAS DAÑADAS</th>
                        <th>LONG. DE CORTE (MM)</th>
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
                        <td class='piezas_anidadas' id='piezas_anidadas'>{{$TotalCorte['piezas_anidadas']}}</td>
                        <td class='piezas_cortadas' id='piezas_cortadas'>{{$TotalCorte['piezas_cortadas']}}</td>
                        <td class='piezas_danadas' id='piezas_danadas'>{{$TotalCorte['piezas_danadas']}}</td>
                        <td class='longitud_corte' id='longitud_corte'>{{number_format($TotalCorte['longitud_corte'], 2,
                            '.', '')}}</td>
                        <td class='numero_perforaciones' id='numero_perforaciones'>
                            {{$TotalCorte['numero_perforaciones']}}</td>
                    </tr>
                    @php
                    $TotalCantidadCortadas = $TotalCantidadCortadas + $TotalCorte['piezas_cortadas'];
                    $TotalCantidadDanadas = $TotalCantidadDanadas + $TotalCorte['piezas_danadas'];
                    $TotalCantidadLongitud = $TotalCantidadLongitud + $TotalCorte['longitud_corte'];
                    $TotalCantidadPerforaciones = $TotalCantidadPerforaciones + $TotalCorte['numero_perforaciones'];
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



    <div class="card-block">
        <div class="table-responsive">
            <table border="1" class="center">
                <thead>
                    <tr class="background-primary">
                        <th colspan="6" style="background-color: #D9D9D9; text-align: center;">MATERIA PRIMA SOBRANTE
                        </th>
                    </tr>
                    <tr style="background-color: #D9D9D9; text-align: center;">
                        <th style="width: 15%">ESPESOR (MM)</th>
                        <th>DESCRIPCIÓN</th>
                        <th>REFERENCIA</th>
                        <th>CANTIDAD</th>
                        <th>UBICACIÓN</th>
                        <th>OBSERVACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    @if($CierrePlanchaSobrante != NULL)
                    @foreach ($CierrePlanchaSobrante as $CierrePlanchaSobrantes)
                    <tr>
                        <td id='espesor'> {{number_format($CierrePlanchaSobrantes->espesor, 2, '.', '')}}</td>
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


    <div class="card-block">
        <table border="1" class="center">
            <thead>
                <tr class="background-primary">
                    <th colspan="5" style="background-color: #D9D9D9; text-align: center;">CONSUMIBLES USADOS</th>
                </tr>
                <tr style="background-color: #D9D9D9; text-align: center;">
                    <th style="width: 15%">ESPESOR (MM)</th>
                    <th>CONSUMIBLE</th>
                    <th>CONSUMO</th>
                    <th>UNIDAD</th>
                    <th>OBSERVACIÓN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($SeguimientoPlanchaConsumible as $SeguimientoPlanchaConsumibles)
                <tr>
                    <td id='espesor'> {{number_format($SeguimientoPlanchaConsumibles->espesor, 2, '.', '')}}</td>
                    <td id='consumible_usado'> {{$SeguimientoPlanchaConsumibles->consumible}}</td>
                    <td id='consumo_consumible'> {{number_format($SeguimientoPlanchaConsumibles->consumo, 2, '.', '')}}
                    </td>
                    <td id='unidad_consumible'> {{$SeguimientoPlanchaConsumibles->unidad}}</td>
                    <td id='observacion_consumible'> {{$SeguimientoPlanchaConsumibles->observaciones}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    <div class="card-block">
        <table border="1" class="center">
            <thead>
                <tr class="background-primary">
                    <th style="background-color: #D9D9D9; text-align: center;">OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: justify;">
                        {{$OrdenesTrabajosConap->observaciones}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>