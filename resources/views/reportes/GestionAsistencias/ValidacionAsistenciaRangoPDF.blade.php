<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reportes de Asistencias</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images/logos/favicon.png') }}" type="image/x-icon">
</head>

<body>
    <style>
        h4, h5, h6 {
            margin-top: 5px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border: 1px solid #000;
            margin: 10px 0;
            border-collapse: collapse;
        }

        td, th {
            padding: 3px;
            border: 1px solid #000;
            text-align: center;
            font-size: 6px; /* Reducir el tamaño de la fuente */
        }

        .center {
            text-align: center;
        }

        body {
            font-size: 8px;
            overflow-x: hidden;
            color: #353c4e;
            font-family: "Open Sans", sans-serif;
            background-attachment: fixed;
        }
    </style>

    <h1 class="center">REPORTE ASISTENCIAS VALIDADAS</h1>
    <h6 style="text-align: right;">Fecha Impresión: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</h6>

    <table>
        <tbody>
            <tr>
                <td style="width:80px">
                    <img src="{{ asset('images/logos/logo_global_menu.png') }}" alt="Logo">
                    <br>
                    <strong>ACERONET</strong>
                </td>
                <td style="width:80px">
                    <h5>FECHA DE VALIDACION</h5>
                    {{ $FechaInicio }}
                </td>
                <td style="width:80px">
                    <h5>DEPARTAMENTO</h5>
                    {{ $departamentos }}
                </td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width:1%;">EMPRESA</th>
                <th style="width:1%;">DEPARTAMENTO</th>
                <th style="width:1%;">EMPLEADO</th>
                @foreach ($fechas as $index => $fecha)
                    @if ($index < 18)
                        <th style="width:4%;">{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($validaciones2 as $validacion)
            <tr>
                <td>{{ $validacion->nombre_empresa }}</td>
                <td>{{ $validacion->des_depart }}</td>
                <td>{{ $validacion->nombre_empleado }}</td>
                @foreach ($fechas as $index => $fecha)
                    @if ($index < 18)
                        @php
                            $horas = \Carbon\Carbon::parse($fecha)->format('Y-m-d');
                        @endphp
                        <td>
                            {!! $validacion->$horas ?? '' !!}
                        </td>
                    @endif
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>