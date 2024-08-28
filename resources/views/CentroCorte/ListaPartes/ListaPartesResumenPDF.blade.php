<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>LISTA DE PARTES {{$tipos[0]->tipo_lista}}</title>
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

    <h4 class="center">RESUMEN LISTA DE PARTES</h4>
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
                    {{$tipos[0]->created_at}}
                </td>
                <td style="width:80px">
                    <h5>TIPO</h5>
                    PLANCHA
                </td>
                <td style="width:80px">
                    <h5>CONAP</h5>
                    N° {{$tipos[0]->nro_conap}}
                </td>
                <td style="width:80px">
                    <h5>LISTA DE PARTES</h5>
                    N° {{$tipos[0]->id_lista_parte}}
                </td>
                <td style="width:80px">
                    <h5>ESTATUS</h5>
                    {{$tipos[0]->estatus}}
                </td>
            </tr>
        </tbody>
    </table>

    <table border="1">
                @php
                    $TotalPiezas = 0;
                    $TotalPeso = 0;
                @endphp
                <tr style="background-color: #D9D9D9;">
                    <th>Espesores (mm)</th>
                    @foreach ($SumListaPla as $SumListaPlas)
                        <th>
                            {{$espesor = number_format($SumListaPlas->espesor, 2, '.', '')}}
                        </th>
                        @php
                            $arrayespesores[] = $SumListaPlas->espesor;
                            $iteracion_espesores = count($arrayespesores);
                        @endphp
                    @endforeach
                    <th>TOTALES</th>
                </tr>
                <tr>
                    <th>Cant. de Piezas (und)</th>
                    @foreach ($SumListaPla as $SumListaPlas)
                        <th>{{ $SumListaPlas->resumen_cant }}</th>
                        @php
                            $TotalPiezas = $TotalPiezas + $SumListaPlas->resumen_cant;
                        @endphp
                    @endforeach
                    <th>
                        @php
                            echo $TotalPiezas;
                        @endphp
                    </th>
                </tr>
                <tr>
                    <th>Peso (Kg)</th>
                    @foreach ($SumListaPla as $SumListaPlas)
                        <th>
                            @php
                                $peso = number_format($SumListaPlas->resumen_peso, 2, '.', '');
                                echo $peso;
                                $TotalPeso = $TotalPeso + $peso;
                            @endphp
                        </th>
                    @endforeach
                    <th>
                        @php
                            echo $TotalPeso;
                        @endphp
                    </th>
                </tr>
                <tr style="background-color: #D9D9D9;">
                    <th>DIÁMETRO DE PERFORACIONES (mm)</th>
                    <th colspan="{{ $iteracion_espesores + 1 }}">CANTIDAD DE PERFORACIONES (und)</th>
                </tr>
                @for ($i = 0; $i < $iteracion_espesores; $i++)
                    @php
                        $TotalCantPerf = 0;
                        $Totales = 0;
                    @endphp
                @endfor
                
                    @foreach ($CantPerfPla as $CantPerfPlas)
                <tr>
                        @foreach ($CantPerfPlas as $valors)
                            @if ($valors != null)
                                <td>{{ $valors }}</td>
                            @else
                                <td> 0 </td>
                            @endif
                            @if ($loop->iteration > 1)
                                @php($TotalCantPerf += $valors)
                            @endif
                        @endforeach
                        <td>{{ $TotalCantPerf }}</td>
                        @php($TotalCantPerf = 0)
                </tr>
                    @endforeach
            <th>TOTAL</th>
                 @foreach ($SumPerfPla as $SumPerfPlas)
                    <td> {{ $SumPerfPlas }}</td>
                    @php($Totales += $SumPerfPlas)
                @endforeach
                    <td>{{ $Totales }}</td>
                <tr style="background-color: #D9D9D9;">
                    <th>DIÁMETRO DE PERFORACIONES (mm)</th>
                    <th colspan="{{$iteracion_espesores+1}}">METROS DE PERFORACIÓN (m)</th>
                </tr>
            @for ($i=0; $i < $iteracion_espesores; $i++)
                @php ($TotalMetrosPerf = 0)
                @php ($TotalesMetros = 0)
                @php ($Conversion = 0)
            @endfor
                @foreach ($MetrosPerfPla as $MetrosPerfPlas)
                <tr> 
                    @foreach ($MetrosPerfPlas as $valors)
                        @if ($valors != NULL)
                            <td>
                                @if($loop->iteration > 1)
                                    {{$valor=number_format($valors, 2, '.', '')}}
                                @else
                                    {{$valor=number_format($valors, 0, '.', '')}}
                                @endif
                            </td>
                        @else
                            <td> 0 </td>
                        @endif
                        @if($loop->iteration > 1)
                            @php($TotalMetrosPerf += $valors)
                        @endif
                    @endforeach
                    <td>
                        {{$SumaMetrosPerf=number_format($TotalMetrosPerf, 2, '.', '')}}
                    </td>
                    @php($TotalMetrosPerf = 0)
                </tr>
                @endforeach
            <th>TOTAL</th>
            @foreach ($TotalMetrosPerfPla as $TotalMetrosPerfPlas)
                <td>
                    {{$TotalMP=number_format($TotalMetrosPerfPlas, 2, '.', '')}}
                </td>
                @php($TotalesMetros += $TotalMetrosPerfPlas)
            @endforeach
        <td>
            {{$TotalesMetrosP=number_format($TotalesMetros, 2, '.', '')}}
        </td>
    </tbody> 
    </table>

    @else
    
    <h4 class="center">RESUMEN LISTA DE PARTES</h4>
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
                    {{$tipos[0]->created_at}}
                </td>
                <td style="width:80px">
                    <h5>TIPO</h5>
                    PERFIL
                </td>
                <td style="width:80px">
                    <h5>CONAP</h5>
                    N° {{$tipos[0]->nro_conap}}
                </td>
                <td style="width:80px">
                    <h5>LISTA DE PARTES</h5>
                    N° {{$tipos[0]->id_lista_parte}}
                </td>
                <td style="width:80px">
                    <h5>ESTATUS</h5>
                    {{$tipos[0]->estatus}}
                </td>
            </tr>
        </tbody>
    </table>


    <table border="1">

        @php($TotalPiezas = 0)
        @php($TotalPeso = 0)
            <tr style="background-color: #D9D9D9;">
                <th>Perfiles</th>
                @foreach ($SumListaPer as $SumListaPers)
                    <th>{{ $SumListaPers->nombre_ficha }}</th>
                    @php($arrayFichas[] = $SumListaPers->nombre_ficha)
                    @php($iteracion_fichas = count($arrayFichas))
                @endforeach
                <th>TOTALES</th>
            </tr>
            <tr>
                <th>Cant. de Piezas (und)</th>
                @foreach ($SumListaPer as $SumListaPers)
                    <th>{{ $SumListaPers->resumen_cant }}</th>
                    @php($TotalPiezas = $TotalPiezas + $SumListaPers->resumen_cant)
                @endforeach
                <th>{{ $TotalPiezas }}</th>
            </tr>
            <tr>
                <th>Peso (Kg)</th>
                @foreach ($SumListaPer as $SumListaPers)
                    @php($peso = number_format($SumListaPers->resumen_peso, 2, '.', ''))
                    @php($TotalPeso = $TotalPeso + $peso)
                    <th>{{ $peso }}</th>
                @endforeach
                <th>{{ $TotalPeso }}</th>
            </tr>
            <tr style="background-color: #D9D9D9;">
                <th>DIÁMETRO DE PERFORACIONES (mm)</th>
                <th colspan="{{ $iteracion_fichas + 1 }}">CANTIDAD DE PERFORACIONES (und)</th>
            </tr>
            @for ($i = 0; $i < $iteracion_fichas; $i++)
                @php($TotalCantPerf = 0)
                @php($Totales = 0)
            @endfor
                @foreach ($CantPerfPer as $CantPerfPers) 
                <tr>
                    @foreach ($CantPerfPers as $valors)
                        @if ($valors != null)
                            <td>{{ $valors }}</td>
                        @else
                            <td> 0 </td>
                        @endif
                        @if ($loop->iteration > 1)
                            @php($TotalCantPerf += $valors)
                        @endif
                    @endforeach
                    <td>{{ $TotalCantPerf }}</td>
                    @php($TotalCantPerf = 0)
                </tr>
                @endforeach
        <th>TOTAL</th>
        @foreach ($SumPerfPer as $SumPerfPers)
            <td> {{ $SumPerfPers }}</td>
            @php($Totales += $SumPerfPers)
        @endforeach
        <td>{{ $Totales }}</td>
       <tr style="background-color: #D9D9D9;">
            <th>DIÁMETRO DE PERFORACIONES (mm)</th>
            <th colspan="{{ $iteracion_fichas + 1 }}">METROS DE PERFORACIÓN (m)</th>
        </tr>

        @for ($i=0; $i < $iteracion_fichas; $i++)
            @php ($TotalMetrosPerf = 0)
            @php ($TotalesMetros = 0)
            @php ($TotalMetrosAla = 0)
            @php ($TotalMetrosAlma = 0)
            @php ($SumaMetros = 0)
            @php ($SumaMetrosTotal = 0)
            @php ($AcumTotal = 0)
            @php ($Totales = array_map(function () {return 0;}, array_values((array)$MetrosPerfPer[0])))
        @endfor
                @foreach ($MetrosPerfPer as $MetrosPerfPers) 
                <tr>
                    @foreach ($MetrosPerfPers as $valors)
                        @if ($valors != NULL)
                        <td>
                            @if($loop->iteration > 1)
                                @php ($BuscarAPerfil = App\Models\Cenc_ListaPartesModel::BuscarAlayAlmaListaPartesPerfiles($tipo->id_lista_parte,$valor))
                                @php ($BuscarAPerfils = (array)$BuscarAPerfil)
                                @foreach ($BuscarAPerfil as $BuscarAPerfils)
                                        @if ($BuscarAPerfils->t_ala != 0)
                                            {{$MetrosAla = number_format(($valors * $ala * 0.001),2, '.', '')}}
                                            @php ($TotalMetrosAla += $MetrosAla)
                                        @elseif($BuscarAPerfils->s_alma != 0)
                                            {{$MetrosAlma = number_format(($valors * $alma * 0.001),2, '.', '')}}
                                            @php ($TotalMetrosAlma += $MetrosAlma)
                                        @endif
                                    @endforeach
                                    @php ($SumaMetrosTotal = $TotalMetrosAla + $TotalMetrosAlma)
                                    @php ($Totales[$loop->index] += $SumaMetrosTotal)
                                    @php ($AcumTotal += $SumaMetrosTotal)
                            @else
                                {{$valor=number_format($valors, 0, '.', '')}}
                            @endif
                        </td>
                        @else
                            <td> 0 </td>
                        @endif
                        @if($loop->iteration > 1)
                            @php($TotalMetrosPerf = $TotalMetrosAla + $TotalMetrosAlma)
                        @endif
                    @endforeach
                    <td>
                        {{$SumaMetrosPerf=number_format($TotalMetrosPerf, 2, '.', '')}}
                    </td>
                    @php($TotalMetrosPerf = 0)
                    @php($TotalMetrosAla = 0)
                    @php($TotalMetrosAlma = 0)
                </tr>
                @endforeach
                <th>TOTAL</th>
                @foreach (array_slice($Totales, 1) as $TotalItem)
                    <td>
                        {{$TotalMP = number_format($TotalItem, 2, '.', '')}}
                    </td>
                @endforeach
            <td>
                {{$TotalesMetrosP = number_format($AcumTotal, 2, '.', '')}}
            </td>
    </tbody>
    </table>
    @endif
    @endforeach
</body>
</html>