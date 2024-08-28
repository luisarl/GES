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

    <h4 class="center">REPORTE AUDITORIA DE AUTORIZACIÓN DE SALIDA DE MATERIALES</h4>
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
                     {{$salidas[0]->nombre_almacen}}
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
                <th>Fecha Creación</th>
                <th>Departamento</th>
                <th>Actividad</th>
                <th>Estatus</th>
                <th>Fecha Validacion Almacen</th>
                <th>Usuario Almacen</th>
                <th>Fecha Validacion Control</th>
                <th>Usuario Control</th>
                <th>Fecha Cierre Control</th>
                <th>Usuario Cierre Control</th>
                <th>Fecha Cierre Almacen</th>
                <th>Usuario Cierre Almacen</th>
                <th>Anulación</th>
                <th>Anulado por</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salidas as $salida)
            <tr>
                <td>{{$salida->id_salida}}</td>
                <td>{{$salida->fecha_creacion}}</td>
                <td>{{$salida->departamento}}</td>
                <td>{{$salida->motivo}}</td>
                <td>{{$salida->estatus}}</td>
                <td>{{$salida->fecha_validacion_almacen}}</td>
                <td>{{$salida->usuario_validacion_almacen}}</td>
                <td>{{$salida->fecha_validacion_control}}</td>
                <td>{{$salida->usuario_validacion_control}}</td>
                <td>{{$salida->fecha_cierre}}</td>
                <td>{{$salida->cerrado_por}}</td>
                <td>{{$salida->fecha_cierre_almacen}}</td>
                <td>{{$salida->usuario_cierre_almacen}}</td>
                @if($salida->anulado_por != null){
                    <td>{{$salida->fecha_anulacion}}</td>
                    <td>{{$salida->anulado_por}}</td>
                }
                @else {
                    <td> </td>
                    <td> </td>
                }
                @endif
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
                    {{$salidas[0]->nombre_almacen}}
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>