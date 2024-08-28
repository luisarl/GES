<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ficha Tecnica</title>
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

    <h4 class="center">REPORTE FECHAS FICHAS TECNICAS</h4>
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
            </tr>
        </tbody>
    </table>

    <table  border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Creado</th>
                <th>Fecha Creacion</th>
                <th>Aprobado</th>
                <th>Fecha Aprobacion</th>
                <th>Catalogado</th>
                <th>Fecha Catalogacion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articulos as $articulo)
                <tr>
                    <td>{{$articulo->id_articulo}}</td>
                    <td>{{$articulo->codigo_articulo}}</td>
                    <td>{!!wordwrap($articulo->nombre_articulo, 25, '<br>')!!}</td>
                    <td>{{$articulo->creado_por}}</td>
                    <td>{{date('d-m-Y g:i:s A', strtotime($articulo->fecha_creacion))}}</td>
                    <td>{{$articulo->aprobado_por}}</td>
                    <td>
                        @if($articulo->aprobado_por != null)
                            {{date('d-m-Y g:i:s A', strtotime($articulo->fecha_aprobacion))}}
                        @endif
                    </td>
                    <td>{{$articulo->catalogado_por}}</td>
                    <td>
                        @if($articulo->catalogado_por != null)
                            {{date('d-m-Y g:i:s A', strtotime($articulo->fecha_catalogacion))}}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>