<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>CIERRE</title>
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

    <h4 class="center">CIERRE</h4>
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
                    {{$BuscarCierrePlancha->created_at}}
                </td>
                <td style="width:80px">
                    <h5>GENERADO POR</h5>
                    {{$BuscarCierrePlancha->name}}
                </td>
                <td style="width:80px">
                    <h5>SEGUIMIENTO</h5>
                    N° {{$BuscarCierrePlancha->id_seguimiento}}
                </td>
                <td style="width:80px">
                    <h5>ORDEN DE TRABAJO</h5>
                    N° {{$BuscarCierrePlancha->id_orden_trabajo}}
                </td>
                <td style="width:80px">
                    <h5>CONAP</h5>
                    N° {{$BuscarCierrePlancha->nro_conap}}
                </td>
            </tr>
        </tbody>
    </table>


    <table border="1" class="center">
        <thead>
            <tr style="background-color: #D9D9D9;">
                <th colspan="2">CONSUMO</th>
            </tr>
            <tr style="background-color: #D9D9D9;">
                <th>GAS PROPANO</th>
                <th>OXIGENO</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                @if($CierrePlancha->consumo_gas == '')
                    <td> 0 </td>
                @else
                    <td>{{number_format($CierrePlancha->consumo_gas, 2, '.', '')}}</td>
                @endif

                @if($TotalLitrosGaseosos == '')
                    <td> 0 </td>
                @else
                    <td>{{number_format($TotalLitrosGaseosos, 2, '.', '')}}</td>
                @endif
            </tr>
        </tbody>
    </table>


    <table border="1" class="center">
        <thead>
            <tr>
                <th colspan="8" style="background-color: #D9D9D9;">CORTES</th>
            </tr>
        </thead>
        <thead>
            <tr class="background-primary" style="background-color: #D9D9D9;">
                <th style="width: 3%">ID</th>
                <th>FECHA</th>
                <th>CNC APROV</th>
                <th>PIEZAS ANIDADAS (UND)</th>
                <th>PIEZAS CORTADAS (UND)</th>
                <th>PIEZAS DAÑADAS (UND)</th>
                <th>LONGITUD DE CORTE (MM)</th>
                <th>NRO. PERF</th>
            </tr>
        </thead>
        <tbody>
            @foreach($CierrePlanchaCortes as $CierrePlanchaCorte)
            <tr>
                <td id='id_cortes'>{{$CierrePlanchaCorte->id_cierre_pl_cortes}}</td>
                <td id='fecha_creado_cortes'>{{$CierrePlanchaCorte->fecha_creado}}</td>
                <td id='cnc_aprovechamiento'> {{$CierrePlanchaCorte->cnc_aprovechamiento}}</td>
                <td id='piezas_anidadas'>{{$CierrePlanchaCorte->piezas_anidadas}}</td>
                <td id='piezas_cortadas'>{{$CierrePlanchaCorte->piezas_cortadas}}</td>
                <td id='piezas_danadas'>{{$CierrePlanchaCorte->piezas_danadas}}</td>
                <td id='longitud_corte'>{{$CierrePlanchaCorte->longitud_corte}}</td>
                <td id='numero_perforaciones'> {{$CierrePlanchaCorte->numero_perforaciones}}</td>
            </tr>
            @endforeach
        </tbody>
        <thead>
            <tr class="background-primary">
                <th> </th>
                <th colspan="2">TOTAL</th>
                <th id="total_piezas_anidadas">{{$TotalAnidadas}}</th>
                <th id="total_piezas_cortadas">{{$TotalCortadas}}</th>
                <th id="total_piezas_danadas">{{$TotalDanadas}}</th>
                <th id="total_longitud_cortes">{{$TotalLongitudCorte}}</th>
                <th id="total_nro_perforacion">{{$TotalPerforaciones}}</th>
            </tr>
        </thead>
    </table>

    <table border="1" class="center">
        <thead>
            <tr>
                <th colspan="7" style="background-color: #D9D9D9;">MATERIA PRIMA SOBRANTE</th>
            </tr>
        </thead>
        <thead>
            <tr class="background-primary" style="background-color: #D9D9D9;">
                <th style="width: 3%">ID</th>
                <th>FECHA</th>
                <th>DESCRIPCIÓN</th>
                <th>REFERENCIA</th>
                <th>CANTIDAD (UND)</th>
                <th>UBICACIÓN</th>
                <th>OBSERVACIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($CierrePlanchaSobrante as $CierrePlanchaSobrantes)
            <tr>
                <td id='id_orden_trabajo_sobrante'>{{$CierrePlanchaSobrantes->id_cierre_pl_sobrante}}</td>
                <td id='descripcion_sobrante'>{{$CierrePlanchaSobrantes->fecha_creado}}</td>
                <td id='descripcion_sobrante'>{{$CierrePlanchaSobrantes->descripcion}}</td>
                <td id='referencia_sobrante'>{{$CierrePlanchaSobrantes->referencia}}</td>
                <td id='cantidad_sobrante'>{{$CierrePlanchaSobrantes->cantidad}}</td>
                <td id='ubicacion_sobrante'>{{$CierrePlanchaSobrantes->ubicacion}}</td>
                <td id='observacion_sobrante'>{{$CierrePlanchaSobrantes->observacion}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>