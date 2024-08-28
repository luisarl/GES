<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>APROVECHAMIENTO {{$aprov->id_aprovechamiento}}</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images/logos/favico.png') }}" type="image/x-icon">
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
            text-align: center;
        }

        th,
        td {
            padding: 4px;
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
    </style>

    {{-- <p>{{dd($aprov)}}</p> --}}
    {{-- @foreach ($tipos as $tipo) --}}
    @if ($aprov->nombre_tecnologia === '1')

    <h4 class="center">APROVECHAMIENTO</h4>
    <h6 style="text-align: right;">Fecha Impresión: {{ Carbon\Carbon::now()->format('d-m-Y H:i:s')}}</h6>

    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px">
                    <img src="{{ asset('images/logos/logo_global_menu.png') }}" alt="" class="">
                    <br>
                    <strong>ACERONET</strong>
                </td>
                <td style="width:80px">
                    <h5>FECHA CREACIÓN</h5>
                    {{$aprov->created_at}}
                </td>
                <td style="width:80px">
                    <h5>CREADO POR</h5>
                    {{$aprov->name}}
                </td>
                <td style="width:80px">
                    <h5>TIPO</h5>
                    PLANCHA
                </td>
                <td style="width:80px">
                    <h5>CONAP</h5>
                    N° {{$aprov->nro_conap}}
                </td>
                <td style="width:80px">
                    <h5>APROVECHAMIENTO</h5>
                    N° {{$aprov->id_aprovechamiento}}
                </td>
                <td style="width:80px">
                    <h5>ESTATUS</h5>
                    {{$aprov->estatus}}
                </td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="center">

        <thead style="background-color: #D9D9D9;">
            <tr>
                <th style="width: 33.33%">CENTRO DE TRABAJO</th>
                <th>{{$aprov->equipo}}</th>
            </tr>
            <tr>
                <th style="width: 33.33%">TECNOLOGÍA</th>
                <th>{{$aprov->tecnologia}}</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th>ESPESOR (MM)</th>
                <td>{{number_format($aprov->espesor, 2, '.', '')}}</td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="center">
        <tr>
            <th colspan="3" style="background-color: #D9D9D9;">MATERIA PRIMA </th>
        </tr>
        <thead>
            <tr>
                @foreach($MateriaPrima as $MateriaPrimas)
                    @php
                        $CantidadMateriaPrima[] = $MateriaPrimas->dimensiones;
                        $IteracionMateriaPrima = count($CantidadMateriaPrima)
                    @endphp
                @endforeach
                <th rowspan="{{ $IteracionMateriaPrima + 1}}" style="width: 27%">DIMENSIONES (MM)</th>
                <th style="width: 43.33%">DESCRIPCIÓN</th>
                <th style="width: 10%">CANTIDAD</th>
            </tr>
        </thead>
        <tbody>

            @foreach($MateriaPrima as $MateriaPrimas)
            <tr>
                <td>{{$MateriaPrimas->dimensiones}}</td>
                <td>{{$MateriaPrimas->cantidad}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table border="1" class="center">
        <tbody>
            <tr>
                <th colspan="2" style="background-color: #D9D9D9;">APROVECHAMIENTO</th>
            </tr>
            <tr>
                <th style="width: 33.33%">CANTIDAD TOTAL DE PIEZAS (UND)</th>
                <td>{{$CantidadTotalPiezas}}</td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="center">
        <tr>
            <th colspan="3" style="background-color: #D9D9D9;">ÁREA DE CORTE </th>
        </tr>
        <thead>
            <tr>
                @foreach($AreaCorte as $AreaCortes)
                    @php
                        $CantidadAreaCortes[] = $AreaCortes->dimensiones;
                        $IteracionAreaCortes = count($CantidadAreaCortes)
                    @endphp
                @endforeach
                <th rowspan="{{ $IteracionAreaCortes + 1}}" style="width: 27%">DIMENSIONES (MM)</th>
                <th style="width: 43.33%">DESCRIPCIÓN</th>
                <th style="width: 10%">CANTIDAD</th>
            </tr>
        </thead>
        <tbody>

            @foreach($AreaCorte as $AreaCortes)
            <tr>
                <td>{{$AreaCortes->dimensiones}}x{{number_format($aprov->espesor, 2, '.', '')}}</td>
                <td>{{$AreaCortes->cantidad}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <table border="1" class="center">
        <tbody>
            <tr>
                <th style="width: 33.33%">LONGITUD DE CORTE (MM)</th>
                <td>{{$aprov->longitud_corte}}</td>
            </tr>
            <tr>
                <th style="width: 33.33%">NÚMERO DE PIERCING (UND)</th>
                <td>{{$aprov->numero_piercing}}</td>
            </tr>
            <tr>
                <th style="width: 33.33%">CICLO DE TALADRO (UND)</th>
                <td>{{$CiclosTaladros}}</td>
            </tr>

            <tr>
                <th style="width: 33.33%">METROS DE PERFORACIÓN (M)</th>
                <td>
                    {{number_format($TotalMetrosPerforacionPla, 2, '.', '') }} m
                </td>
            </tr>

            <tr>
                <th colspan="2" style="background-color: #D9D9D9;">CONSUMIBLES</th>
            </tr>
            <tr>
                <th style="width: 33.33%">NÚMERO DE BOQUILLA</th>
                <td>{{$aprov->numero_boquilla}}</td>
            </tr>
            <tr>
                <th style="width: 33.33%">INSERTO</th>
                <td>
                    @foreach($Inserto as $Insertos)
                    {!! $Insertos !!} |
                    @endforeach
                </td>
            </tr>
            <tr>
                <th style="width: 33.33%">CONSUMO DE OXÍGENO (L)</th>
                <td>{{number_format($ConsumoTotalOxigenoLitros, 2, '.', '')}}</td>
            </tr>
            <tr>
                <th style="width: 33.33%">CONSUMO DE GAS PROPANO (L)</th>
                <td>{{number_format($ConsumoGasCorteLitros, 2, '.', '')}}</td>
            </tr>
            <tr>
                <th style="width: 33.33%">TIEMPO ESTIMADO DE CORTE (H)</th>
                <td>{{$aprov->tiempo_estimado}}</td>
            </tr>
            <tr>
                <th colspan="2" style="background-color: #D9D9D9;">OBSERVACIONES</th>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify">{{$observaciones}}</td>
            </tr>

        </tbody>
    </table>

    @else
    {{-- PLASMA --}}
    <h4 class="center">APROVECHAMIENTO</h4>
    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px">
                    <img src="{{ asset('images/logos/logo_global_menu.png') }}" alt="" class="">
                    <br>
                    <strong>ACERONET</strong>
                </td>
                <td style="width:80px">
                    <h5>FECHA CREACIÓN</h5>
                    {{$aprov->created_at}}
                </td>
                <td style="width:80px">
                    <h5>TIPO</h5>
                    PLANCHA
                </td>
                <td style="width:80px">
                    <h5>CONAP</h5>
                    N° {{$aprov->nro_conap}}
                </td>
                <td style="width:80px">
                    <h5>APROVECHAMIENTO</h5>
                    N° {{$aprov->id_aprovechamiento}}
                </td>
                <td style="width:80px">
                    <h5>ESTATUS</h5>
                    {{$aprov->estatus}}
                </td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="center">

        <thead style="background-color: #D9D9D9;">
            <tr>
                <th style="width: 33.33%">CENTRO DE TRABAJO</th>
                <th>{{$aprov->equipo}}</th>
            </tr>
            <tr>
                <th style="width: 33.33%">TECNOLOGÍA</th>
                <th>{{$aprov->tecnologia}}</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th>ESPESOR (MM)</th>
                <td>{{number_format($aprov->espesor, 2, '.', '')}}</td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="center">
        <tr>
            <th colspan="3" style="background-color: #D9D9D9;">MATERIA PRIMA </th>
        </tr>
        <thead>
            <tr>
                @foreach($MateriaPrima as $MateriaPrimas)
                    @php
                        $CantidadMateriaPrima[] = $MateriaPrimas->dimensiones;
                        $IteracionMateriaPrima = count($CantidadMateriaPrima)
                    @endphp
                @endforeach
                <th rowspan="{{ $IteracionMateriaPrima + 1}}" style="width: 27%">DIMENSIONES (MM)</th>
                <th style="width: 43.33%">DESCRIPCIÓN</th>
                <th style="width: 10%">CANTIDAD</th>
            </tr>
        </thead>
        <tbody>

            @foreach($MateriaPrima as $MateriaPrimas)
            <tr>
                <td>{{$MateriaPrimas->dimensiones}}</td>
                <td>{{$MateriaPrimas->cantidad}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table border="1" class="center">
        <tbody>

            <tr>
                <th colspan="2" style="background-color: #D9D9D9;">APROVECHAMIENTO</th>
            </tr>
            <tr>
                <th style="width: 33.33%">CANTIDAD TOTAL DE PIEZAS (UND)</th>
                <td>{{$CantidadTotalPiezas}}</td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="center">
        <tr>
            <th colspan="3" style="background-color: #D9D9D9;">ÁREA DE CORTE </th>
        </tr>
        <thead>
            <tr>
                @foreach($AreaCorte as $AreaCortes)
                    @php
                        $CantidadAreaCortes[] = $AreaCortes->dimensiones;
                        $IteracionAreaCortes = count($CantidadAreaCortes)
                    @endphp
                @endforeach
                <th rowspan="{{ $IteracionAreaCortes + 1}}" style="width: 27%">DIMENSIONES (MM)</th>
                <th style="width: 43.33%">DESCRIPCIÓN</th>
                <th style="width: 10%">CANTIDAD</th>
            </tr>
        </thead>
        <tbody>

            @foreach($AreaCorte as $AreaCortes)
            <tr>
                <td>{{$AreaCortes->dimensiones}}x{{number_format($aprov->espesor, 2, '.', '')}}</td>
                <td>{{$AreaCortes->cantidad}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <table border="1" class="center">
        <tbody>

            <tr>
                <th style="width: 33.33%">LONGITUD CORTE (MM)</th>
                <td>{{$aprov->longitud_corte}}</td>
            </tr>
            <tr>
                <th style="width: 33.33%">NÚMERO DE PIERCING (UND)</th>
                <td>{{$aprov->numero_piercing}}</td>
            </tr>
            <tr>
                <th style="width: 33.33%">CICLOS DE TALADRO (UND)</th>
                <td>{{$CiclosTaladros}}</td>
            </tr>
            <th style="width: 33.33%">METROS DE PERFORACIÓN (M)</th>
            <td>
                {{number_format($TotalMetrosPerforacionPla, 2, '.', '') }} m
            </td>

            <tr>
                <th colspan="2" style="background-color: #D9D9D9;">CONSUMIBLES</th>
            </tr>
            <tr>
                <th style="width: 33.33%">JUEGO DE ANTORCHA (AMP)</th>
                <td>{{$aprov->juego_antorcha}}</td>
            </tr>
            <tr>
                <th style="width: 33.33%">INSERTO</th>
                <td>
                    @foreach($Inserto as $Insertos)
                    {!! $Insertos !!} |
                    @endforeach
                </td>
            </tr>
            <tr>
                <th style="width: 33.33%">CONSUMO DE OXÍGENO (L)</th>
                <td>{{number_format($ConsumoOxigenoPlasmaLitros, 2, '.', '')}}</td>
            </tr>
            <tr>
                <th style="width: 33.33%">TIEMPO ESTIMADO DE CORTE (H)</th>
                <td>{{$aprov->tiempo_estimado}}</td>
            </tr>
            <tr>
                <th colspan="2" style="background-color: #D9D9D9;">OBSERVACIONES</th>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify">{{$observaciones}}</td>
            </tr>


        </tbody>
    </table>
    {{--
    <table border="1" class="center">
        <tr>
            <th colspan="3" style="background-color: #D9D9D9;">DETALLE CICLO DE TALADRO </th>
        </tr>
        <thead>
            <tr>
                <th style="width: 33.33%">DIÁMETRO</th>
                <th>CANTIDAD</th>
                <th>METROS DE PERFORACIÓN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($CicloTaladro as $CicloTaladros)
            <tr>
                <td>{{$CicloTaladros->diametro_perforacion}}</td>
                <td>{{$CicloTaladros->cantidad_perforacion}}</td>
                <td>{{number_format($CicloTaladros->MetrosPer, 2, '.', '')}}</td>
            </tr>
            @endforeach

        </tbody>
    </table> --}}

    @endif

</body>

</html>