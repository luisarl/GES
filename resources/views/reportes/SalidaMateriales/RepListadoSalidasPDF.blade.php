<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Autorizacion de Salida</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('images/logos/favico.png')}}" type="image/x-icon">
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
            /* text-align: center; */
        }

        .center {
            text-align: center;
        }

        .firma {
            padding-bottom: 30px;
        }

        body {
            font-size: 8px;
            overflow-x: hidden;
            color: #353c4e;
            font-family: "Open Sans", sans-serif;
            background-attachment: fixed;
        }
    </style>

    <h4 class="center">REPORTE AUTORIZACIÓN DE SALIDA DE MATERIALES</h4>
    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px">
                    <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                    <br>
                    <strong>ACERONET</strong>
                </td>
                <td style="width:80px">
                    <h5>FECHA INICIO</h5>
                    {{$_GET['fecha_inicio']}}
                </td>
                <td style="width:80px">
                    <h5>FECHA FIN</h5>
                    {{$_GET['fecha_fin']}}
                </td>
                <td style="width:80px">
                    <h5>ALMACEN</h5>
                    {{$almacen}}
                </td>
                <td style="width:80px">
                    <h5>ESTATUS</h5>
                    {{$_GET['estatus']}}
                </td>
            </tr>
        </tbody>
    </table>

    <table  border="1">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Fecha</th>
                <th>Solicitante</th>
                <th>Responsable</th>
                <th>Articulos</th>
                <th>Tipo</th>
                <th>Estatus</th>
                <th>Total Articulos</th>
            </tr>
        </thead>
        <tbody>
            @php
            $totalabiertos = 0;
            $totalcerrados = 0;
            $salidasabiertas = 0;
            $salidascerradas = 0;
            $salidasgeneradas = 0;
            @endphp
            
            @foreach ($salidas as $salida)
                @php
                // busca el estatus de los articulos, guarda en variable y los incrementa
                $pattern = '/ABIERTO/';
                $abierto = preg_match_all($pattern, $salida->articulos, $matches);
                $pattern2 = '/CERRADO/';
                $cerrado = preg_match_all($pattern2, $salida->articulos, $matches);
                $totalabiertos += $abierto;
                $totalcerrados += $cerrado;
                // busca el estatus de salidas en la tabla, guarda en variable con operador ternario e incrementa
                $estatus = $salida->estatus;
                $salidascerradas += ($estatus === 'CERRADO') ? 1 : 0;
                $salidasabiertas += ($estatus === 'VALIDADO/ABIERTO') ? 1 : 0;
                $salidasgeneradas += ($estatus !== 'CERRADO' && $estatus !== 'VALIDADO/ABIERTO') ? 1 : 0;
                @endphp

            <tr>
                <td>{{$salida->id_salida}}</td>
                <td>{{$salida->fecha_emision}}</td>
                <td>{{$salida->solicitante}}</td>
                <td>{{$salida->responsable}}</td>
                <td>
                    <table border="0">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Articulo</th>
                                <th>Observación</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            {!!$salida->articulos!!}
                        </tbody>
                    </table>
                </td>
                <td>{{$salida->nombre_tipo}}</td>
                <td>{{$salida->estatus}}</td>
                <td tyle="text-align: left"> 
                    <h5>ABIERTO:  {{$abierto}}</h5>
                    <h5>CERRADO:{{$cerrado}}</h5>
                </td> 
            </tr>
            @endforeach
        </tbody>
    </table>

    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px">
                    <h4>FECHA INICIO</h4>
                    {{$_GET['fecha_inicio']}}
                </td>
                <td style="width:80px">
                    <h4>FECHA FIN</h4>
                    {{$_GET['fecha_fin']}}
                </td>
                <td style="width:80px">
                    <h4>ALMACEN</h4>
                    {{$almacen}}
                </td>
                <td style="width:80px">
                    <h4>TOTAL SALIDAS</h4>
                    <hr>
                    <table border="0">
                        <thead>
                            <tr>
                                <th>ABIERTO</th>
                                <th>CERRADO</th>
                                <th>GENERADO</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="center">{{$salidasabiertas}}</td>
                                <td class="center">{{$salidascerradas}}</td>
                                <td class="center">{{$salidasgeneradas}}</td> 
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width:80px">
                    <h4>TOTAL ARTICULOS</h4>
                    <hr>
                    <table border="0">
                        <thead>
                            <tr>
                                <th>ABIERTO</th>
                                <th>CERRADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="center">{{$totalabiertos}}</td>
                                <td class="center">{{$totalcerrados}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>