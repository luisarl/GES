<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Servicios</title>
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
            font-size: 10px;
            overflow-x: hidden;
            color: #353c4e;
            font-family: "Open Sans", sans-serif;
            background-attachment: fixed;
        }
        .medidas 
        {
            width:12%
        }
    </style>

{{-- Cabecera  --}}
    <h4 class="center">REPORTE SOLICITUDES DE SERVICIOS POR DEPARTAMENTO</h4>
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
                    <h5>ESTATUS</h5>
                    {{$_GET['estatus']}}
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width:100%" border="1">

        <thead>
            <tr>
                <th style="max-width: 5%;">Item</th>
                <th style="max-width: 5%;">Codigo</th>
                <th style="max-width: 10%;">Fecha</th>
                <th style="max-width: 20%;">Servicio</th>
                <th style="max-width: 20%;">SubServicio</th>
                <th style="max-width: 20%;">Motivo</th>
                <th style="max-width: 10%;">Creado por</th>
                <th style="max-width: 10%;">Estatus</th>
            </tr>
        </thead>

        <tbody>

            {{$contador = 1}}
            @foreach ($solicitudes as $solicitud)
            <tr>
                <td>{{$contador}}</td>
                <td>{{$solicitud->id_solicitud}}</td>
                <td>{{date('d-m-Y g:i:s A', strtotime($solicitud->fecha_creacion))}}</td>
                <td>{{$solicitud->nombre_servicio}}</td>
                <td>{{$solicitud->nombre_subservicio}}</td>
                <td>{{$solicitud->asunto_solicitud}}</td>
                <td>{{$solicitud->creado_por}}</td>
                <td>{{$solicitud->estatus}}</td>
                {{$contador++}}
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>