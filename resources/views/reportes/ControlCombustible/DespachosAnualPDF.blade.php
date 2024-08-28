<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reportes de Despachos</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images/logos/favico.png') }}" type="image/x-icon">
</head>

<body>
    <style>
        h4, h5, h6 {
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
            height: 20px;
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
        .marca-agua {
            position: absolute;
            font-size: 45px;
            width: 100%;
            height: 100%;
            margin-top: -10px;
            text-align: center;
        }
    </style>

    @php
    $duplicar = 1;

    $total_enero = 0;
    $total_febrero = 0;
    $total_marzo = 0;
    $total_abril = 0;
    $total_mayo = 0;
    $total_junio = 0;
    $total_julio = 0;
    $total_agosto = 0;
    $total_septiembre = 0;
    $total_octubre = 0;
    $total_noviembre = 0;
    $total_diciembre = 0;
    @endphp

    @for ($i = 0; $i < $duplicar; $i++) 

    <h1 class="center">REPORTE DESPACHO ANUAL DE COMBUSTIBLE </h1>

    <h6 style="text-align: right;">Fecha Impresión: {{ Carbon\Carbon::now()->format('d-m-Y H:i:s')}}</h6>
  
    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px"> 
                    <img src="{{ asset('images/logos/logo_global_menu.png') }}" alt="">
                    <br> 
                    <strong>ACERONET</strong> 
                </td>
                <td style="width:80px">
                    <h5>AÑO DE DESPACHO</h5>
                     {{$year}}
                </td>
                <td style="width:80px">
                    <h5>FECHA DE IMPRESION</h5>
                    {{ Carbon\Carbon::now()->format('d-m-Y ')}}
                </td>
             
                <td style="width:80px">
                    <h5>TIPO DE COMBUSTIBLE</h5>
                   {{$combustible}}
                </td>
            </tr>
        </tbody>
    </table>
    
    <table border="1">
        <tbody>
            <tr style="border-bottom: 1pt solid black;">
                <th style="width:3%">DEPARTAMENTO</th>
                <th style="width:1%">ENERO</th>
                <th style="width:1%">FEBRERO</th>
                <th style="width:1%">MARZO</th>
                <th style="width:1%">ABRIL</th>
                <th style="width:1%">MAYO</th>
                <th style="width:1%">JUNIO</th>
                <th style="width:1%">JULIO</th>
                <th style="width:1%">AGOSTO</th>
                <th style="width:1%">SEPTIEMBRE</th>
                <th style="width:1%">OCTUBRE</th>
                <th style="width:1%">NOVIEMBRE</th>
                <th style="width:1%">DICIEMBRE</th>
                <th style="width:2%">TOTAL ANUAL</th>
            </tr>
            @foreach($reportes as $reporte)
                @php
                    $total_enero += $reporte->ENERO;
                    $total_febrero += $reporte->FEBRERO;
                    $total_marzo += $reporte->MARZO;
                    $total_abril += $reporte->ABRIL;
                    $total_mayo += $reporte->MAYO;
                    $total_junio += $reporte->JUNIO;
                    $total_julio += $reporte->JULIO;
                    $total_agosto += $reporte->AGOSTO;
                    $total_septiembre += $reporte->SEPTIEMBRE;
                    $total_octubre += $reporte->OCTUBRE;
                    $total_noviembre += $reporte->NOVIEMBRE;
                    $total_diciembre += $reporte->DICIEMBRE;
                    $total_anual = $reporte->ENERO + $reporte->FEBRERO + $reporte->MARZO + $reporte->ABRIL + $reporte->MAYO + $reporte->JUNIO + $reporte->JULIO + $reporte->AGOSTO + $reporte->SEPTIEMBRE + $reporte->OCTUBRE + $reporte->NOVIEMBRE + $reporte->DICIEMBRE;
                @endphp
                <tr>
                   <td>{{ $reporte->nombre_departamento }}</td>
                   <td class="center">{{number_format($reporte->ENERO,2)}}</td>
                   <td class="center">{{number_format($reporte->FEBRERO,2)}}</td>
                   <td class="center">{{number_format($reporte->MARZO,2)}}</td>
                   <td class="center">{{number_format($reporte->ABRIL,2) }}</td>
                   <td class="center">{{number_format($reporte->MAYO,2) }}</td>
                   <td class="center">{{number_format($reporte->JUNIO,2) }}</td>
                   <td class="center">{{number_format($reporte->JULIO,2) }}</td>
                   <td class="center">{{number_format($reporte->AGOSTO,2) }}</td>
                   <td class="center">{{number_format($reporte->SEPTIEMBRE,2)}}</td>
                   <td class="center">{{number_format($reporte->OCTUBRE,2) }}</td>
                   <td class="center">{{number_format($reporte->NOVIEMBRE,2) }}</td>
                   <td class="center">{{number_format($reporte->DICIEMBRE,2) }}</td>
                   <td class="center">{{number_format($total_anual,2) }}</td>
                </tr>
            @endforeach
            <tr>
                <th>TOTAL</th>
                <th>{{number_format($total_enero,2)}}</th>
                <th>{{number_format($total_febrero,2)}}</th>
                <th>{{number_format ($total_marzo,2) }}</th>
                <th>{{number_format ($total_abril,2) }}</th>
                <th>{{number_format ($total_mayo,2) }}</th>
                <th>{{number_format ($total_junio,2) }}</th>
                <th>{{number_format ($total_julio,2) }}</th>
                <th>{{number_format ($total_agosto,2) }}</th>
                <th>{{number_format ($total_septiembre,2) }}</th>
                <th>{{number_format ($total_octubre,2) }}</th>
                <th>{{number_format ($total_noviembre,2) }}</th>
                <th>{{number_format ($total_diciembre,2) }}</th>
                <th>{{number_format ($total_enero + $total_febrero + $total_marzo + $total_abril + $total_mayo + $total_junio + $total_julio + $total_agosto + $total_septiembre + $total_octubre + $total_noviembre + $total_diciembre,2) }}</th>
            </tr>
        </tbody>
    </table>
    <br>
    @endfor
</body>

</html