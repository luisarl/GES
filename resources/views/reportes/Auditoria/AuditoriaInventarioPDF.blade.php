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

    <h4 class="center">REPORTE AUDITORIA INVENTARIO</h4>
    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px">
                    <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                    <br>
                    <strong>ACERONET</strong>
                </td>
                <td style="width:80px">
                    <h5>FECHA </h5>
                    {{$_GET['fecha']}}
                </td>
                <td style="width:80px">
                    <h5>Numero Auditoria</h5>
                    {{$_GET['numero_auditoria']}}
                </td>
            </tr>
        </tbody>
    </table>

    <table  border="1">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Codigo</th>
                <th>Articulo</th>
                <th>Almacen</th>
                <th>SubAlmacen</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Stock</th>
                <th>Conteo</th>
                <th>Direfencia</th>
                <th>Observacion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articulos as $articulo)
            <tr>
                <td>{{$articulo->numero_auditoria}}</td>
                <td>{{$articulo->codigo_articulo}}</td>
                <td>{{$articulo->nombre_articulo}}</td>
                <td>{{$articulo->nombre_almacen}}</td>
                <td>{{$articulo->nombre_subalmacen}}</td>
                <td>{{$articulo->usuario}}</td>
                <td>{{date('d-m-Y g:i:s A', strtotime($articulo->fecha))}}</td>
                <td>{{number_format($articulo->stock_actual, 2)}}</td>
                <td>{{number_format($articulo->conteo_fisico, 2)}}</td>
                <td>{{number_format($articulo->diferencia, 2)}}</td>
                <td>{{$articulo->observacion}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>