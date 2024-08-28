<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Articulos en Resguardo</title>
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

    <h4 class="center">REPORTE ARTICULOS EN RESGUARDO</h4>
    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px">
                    <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                    <br>
                    <strong>ACERONET</strong>
                </td>
                <td style="width:80px">
                    <h5>ALMACEN</h5>
                    {{$resguardos[0]->nombre_almacen}}
                </td>
                <td style="width:80px">
                    <h5>DISPOSICION FINAL</h5>
                    @if($_GET['id_clasificacion'] == 0) 
                        TODAS
                    @else
                        {{$resguardos[0]->nombre_clasificacion}}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <table  border="1">
        <thead>
            <tr>
                <th>Resg.</th>
                <th>Solic. Resg.</th>
                <th>Almacen</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Presentacion</th>
                <th>Cantidad</th>
                {{-- <th>Disp. Final</th> --}}
                <th>Observacion</th>
                <th>Estado</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
         
            @foreach ($resguardos as $resguardo)
            <tr>
                <td>{{$resguardo->id_resguardo}}</td>
                <td>{{$resguardo->id_solicitud_resguardo}}</td>
                <td>{{$resguardo->nombre_almacen}}</td>
                <td>{{$resguardo->codigo_articulo}}</td>
                <td>{!!wordwrap($resguardo->nombre_articulo, 30, '<br>')!!}</td>
                <td>{{$resguardo->presentacion}}</td>
                <td>{{number_format($resguardo->cantidad_disponible, 2)}}</td>
                {{-- <td>{{$resguardo->nombre_clasificacion}}</td> --}}
                <td>{{$resguardo->observacion}}</td>
                <td>{{$resguardo->estado}}</td>
                <td>{{$resguardo->estatus}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>