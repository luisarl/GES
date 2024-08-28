<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>LISTA DE PARTES DETALLADA {{$tipos[0]->tipo_lista}}</title>
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

    @foreach ($tipos as $tipo)
        @if ($tipo->tipo_lista === 'PLANCHAS')

            <h4 class="center">LISTA DE PARTES DETALLADA</h4>
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
                            {{$ListaPartesPlanchas[0]->created_at}}
                        </td>
                        <td style="width:80px">
                            <h5>TIPO</h5>
                            PLANCHA
                        </td>
                        <td style="width:80px">
                            <h5>CONAP</h5>
                            N° {{$ListaPartesPlanchas[0]->nro_conap}}
                        </td>
                        <td style="width:80px">
                            <h5>LISTA DE PARTES</h5>
                            N° {{$ListaPartesPlanchas[0]->id_lista_parte}}
                        </td>
                        <td style="width:80px">
                            <h5>ESTATUS</h5>
                            {{$tipos[0]->estatus}}
                        </td>
                    </tr>
                </tbody>
            </table>

            <table border="1" class="center">
                <thead style="background-color: #D9D9D9;">
                    <tr>
                        <th>Nro. Parte</th>
                        <th>Prioridad</th>
                        <th>Descripción</th>
                        <th>Dimensiones (MM)</th>
                        <th>Espesor (MM)</th>
                        <th>Cant. Piezas (UND)</th>
                        <th>Peso Unit (KG)</th>   
                        <th>Peso Total (KG)</th>
                        <th>Diámetro (M)</th>
                        <th>Cant. Perf (UND)</th>
                        <th>Cant. Total Perf (UND)</th>
                    </tr>
                </thead>
                <tbody>
                    @php($SumaTotalCantidadPiezas = 0)
                    @php($SumaTotalPeso = 0)
                    @php($SumaTotalPerforacion = 0)
                    @foreach($ListaPartesPlanchas as $ListaPartesPlanchasID)
                    <tr>
                        <td>{{$ListaPartesPlanchasID->nro_partes}}</td>
                        <td>{{$ListaPartesPlanchasID->prioridad}}</td>
                        <td>{{$ListaPartesPlanchasID->descripcion}}</td>
                        <td>{{$ListaPartesPlanchasID->dimensiones}}</td>
                        @if($ListaPartesPlanchasID->espesor == NULL)
                            <td> </td>
                        @else
                            <td>
                                {{$espesor = number_format($ListaPartesPlanchasID->espesor, 2, '.', '')}}
                            </td>
                        @endif
                        <td>{{$CantPiezas = $ListaPartesPlanchasID->cantidad_piezas}}</td>
                        @php($SumaTotalCantidadPiezas = $SumaTotalCantidadPiezas + (int)$CantPiezas)
                        @if($ListaPartesPlanchasID->peso_unit == NULL)
                            <td> </td>
                        @else
                        <td>
                            {{$peso = number_format($ListaPartesPlanchasID->peso_unit, 2, '.', '')}}
                        </td>
                        @endif
                        @if($ListaPartesPlanchasID->peso_total == NULL)
                        <td> </td>
                        @else
                        <td>
                            {{$pesoT = number_format($ListaPartesPlanchasID->peso_total, 2, '.', '')}}
                            @php($SumaTotalPeso = $SumaTotalPeso + $pesoT)
                        </td>
                        @endif
                        <td>{{number_format($ListaPartesPlanchasID->diametro_perforacion, 2, '.', '')}}</td>
                        <td>{{$ListaPartesPlanchasID->cantidad_perforacion}}</td>
                        <td>{{$PerfT = $ListaPartesPlanchasID->cantidad_total}}</td>
                        @php($SumaTotalPerforacion = $SumaTotalPerforacion + $PerfT) 
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="5">TOTALES</th>
                        <th>{{$SumaTotalCantidadPiezas}}</th>
                        <th></th>
                        <th>{{$SumaTotalPeso}}</th>
                        <th></th>
                        <th></th>
                        <th>{{$SumaTotalPerforacion}}</th>
                    </tr>
                </tbody>
            </table>

        @else
            
            <h4 class="center">LISTA DE PARTES DETALLADA</h4>
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
                            {{$ListaPartesPerfiles[0]->created_at}}
                        </td>
                        <td style="width:80px">
                            <h5>TIPO</h5>
                            PERFIL
                        </td>
                        <td style="width:80px">
                            <h5>CONAP</h5>
                            N° {{$ListaPartesPerfiles[0]->nro_conap}}
                        </td>
                        <td style="width:80px">
                            <h5>LISTA DE PARTES</h5>
                            N° {{$ListaPartesPerfiles[0]->id_lista_parte}}
                        </td>
                        <td style="width:80px">
                            <h5>ESTATUS</h5>
                            {{$tipos[0]->estatus}}
                        </td>
                    </tr>
                </tbody>
            </table>

            <table border="1" class="center">
                <thead style="background-color: #D9D9D9;">
                    <tr>
                        <th>Nro. Parte</th>
                        <th>Tipo</th>
                        <th>Cant. Piezas (UND)</th>
                        <th>Prioridad</th>
                        <th>Long. Pieza (MM)</th>
                        <th>Tipo Corte</th>
                        <th>Peso Unit (KG)</th>
                        <th>Peso Total (KG)</th>
                        <th>Diámetro (MM)</th>
                        <th>Ala (T)</th>
                        <th>Alma (S)</th>
                        <th>Cant. Total Perf (UND)</th>
                    </tr>
                </thead>
                <tbody> 
                    @php($SumaTotalCantidadPiezasPerfil = 0)
                    @php($SumaTotalPesoPerfil = 0)
                    @php($SumaTotalPerforacionPerfil = 0)
                    @foreach($ListaPartesPerfiles as $ListaPartesPerfilesID)
                    <tr>
                        <td>{{$ListaPartesPerfilesID->nro_partes}}</td>
                        <td>{{$ListaPartesPerfilesID->nombre_ficha}}</td>
                        <td>{{$CantPiezas = $ListaPartesPerfilesID->cantidad_piezas}}</td>
                        @php($SumaTotalCantidadPiezasPerfil = $SumaTotalCantidadPiezasPerfil + (int)$CantPiezas)
                        <td>{{$ListaPartesPerfilesID->prioridad}}</td>
                        <td>{{$ListaPartesPerfilesID->longitud_pieza}}</td>
                        <td>{{$ListaPartesPerfilesID->tipo_corte}}</td>
                        @if($ListaPartesPerfilesID->peso_unit == NULL)
                            <td> </td>
                        @else
                        <td>
                            {{$peso = number_format($ListaPartesPerfilesID->peso_unit, 2, '.', '')}}
                        </td>
                        @endif
                        @if($ListaPartesPerfilesID->peso_total == NULL)
                        <td> </td>
                        @else
                        <td>
                            {{$pesoT = number_format($ListaPartesPerfilesID->peso_total, 2, '.', '')}}
                            @php($SumaTotalPesoPerfil = $SumaTotalPesoPerfil + $pesoT)
                        </td>
                        @endif
                        <td>{{$ListaPartesPerfilesID->diametro_perforacion}}</td>
                        <td>{{$ListaPartesPerfilesID->t_ala}}</td>
                        <td>{{$ListaPartesPerfilesID->s_alma}}</td>
                        <td>{{$PerfT = $ListaPartesPerfilesID->cantidad_total}}</td>
                        @php($SumaTotalPerforacionPerfil = $SumaTotalPerforacionPerfil + $PerfT) 
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="2">TOTALES</th>
                        <th>{{$SumaTotalCantidadPiezasPerfil}}</th>
                        <th colspan="4"></th>
                        <th>{{$SumaTotalPesoPerfil}}</th>
                        <th colspan="3"></th>
                        <th>{{$SumaTotalPerforacionPerfil}}</th>
                    </tr>
                </tbody>
            </table>

        @endif
    @endforeach

</body>
</html>