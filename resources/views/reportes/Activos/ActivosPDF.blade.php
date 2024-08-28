<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Activos</title>
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
    <h4 class="center">REPORTE ACTIVOS</h4>
    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px">
                    <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                    <br>
                    <strong>ACERONET</strong>
                </td>
                <td style="width:80px">
                    <h5>DEPARTAMENTO</h5>
                    {{$_GET['nombre_departamento']}}
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
                <th style="width:3% ">Nro</th>
                <th style="width:5% ">Codigo</th>
                <th style="width:13% ">Nombre</th>
                <th style="width:7%">Serial</th>
                <th style="width:10%">Marca</th>
                <th style="width:30%">Caracteristica</th>
                <th style="width:13%">Responsable</th>
            </tr>
        </thead>

        <tbody>
            {{-- @dd($solicitudes) --}}
            {{$contador = 1}}
            @foreach ($activos as $activo)
            <tr>
                <td>{{$contador}}</td>
                <td>{{$activo->codigo_activo}}</td>
                <td>{{$activo->nombre_activo}}</td>
                <td>{{$activo->serial}}</td>
                <td>{{$activo->marca}}</td>
                <td>
                    <table border="0">
                        <thead>
                            <tr>
                                <th style="text-align: left; width: 50%;">Caracteristica</th>
                                <th style="text-align: left; width-max: 50%;">Valor</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: justify;">
                                {!! $activo->caracteristicas !!}
                        </tbody>
                    </table>
                </td>
                <td>{{$activo->responsable}}</td>
                {{$contador++}}
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>