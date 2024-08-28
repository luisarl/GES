<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reportes Control de Toner</title>
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
    @endphp

    @for ($i = 0; $i < $duplicar; $i++) 

        <h1 class="center">REPORTE CONTROL DE TONER </h1>

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
                        <h5>FECHA DE IMPRESION</h5>
                        {{ Carbon\Carbon::now()->format('d-m-Y ')}}
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table border="1">
            <tbody>
                <tr style="border-bottom: 1pt solid black;">
                    <th style="width:0.3%">ID</th>
                    <th style="width:1%">FECHA DEL CAMBIO</th>
                    <th style="width:1%">FECHA DEL ULTIMO CAMBIO</th>
                    <th style="width:2%">IMPRESORA</th>
                    <th style="width:1%">DEPARTAMENTO</th>
                    <th style="width:1%">SERVICIO</th>
                    <th style="width:1%">CANT.ACTUAL</th>
                    <th style="width:1%">CANT.ANTERIOR</th>
                    <th style="width:1%">TOTAL HOJAS IMPRESAS</th>
                    <th style="width:1%">DIAS DE DURACION</th>
            
                </tr>
                @foreach($reportes as $reporte)
                
                    <tr>
                    
                    <td class="center">{{$reporte->id_reemplazo_toner}}</td>
                    <td class="center">{{$reporte->fecha_cambio}}</td>
                    <td class="center">{{$reporte->fecha_cambio_anterior}}</td>
                    <td class="center">{{$reporte->nombre_activo}}</td>
                    <td class="center">{{$reporte->ubicacion}}</td>
                    <td class="center">{{$reporte->tipo_servicio}}</td>
                    <td class="center">{{$reporte->cantidad_hojas_actual}}</td>
                    <td class="center">{{$reporte->cantidad_hojas_anterior}}</td>
                    <td class="center">{{$reporte->cantidad_hojas_total}}</td>
                    <td class="center">{{$reporte->dias_de_duracion}}</td>
        
                    </tr>
                @endforeach
                
            </tbody>
        </table>
            <br>


        <h1 class="center">CANTIDAD PROMEDIO DE HOJAS POR GERENCIAS</h1>
        <table border="1">
            <tbody>
                    
                <tr style="border-bottom: 1pt solid black;">
                        
                    <th style="width:1%">DEPARTAMENTO</th>
                    <th style="width:1%">CANT.CAMBIOS</th>
                    <th style="width:1%">PROMEDIO HOJAS</th>
                    <th style="width:1%">PROMEDIO DIAS</th>
                </tr>
                    @foreach($promedios as $promedio)
                        <tr>
                            <td>{{$promedio->nombre_departamento}}</td>
                            <td>{{$promedio->cantidad}}</td>
                            <td>{{$promedio->promedio}}</td>
                            <td>{{$promedio->diaspromedio}}</td>
                        </tr>
                    @endforeach
            </tbody>
                
        </table>
            
    @endfor
</body>

</html