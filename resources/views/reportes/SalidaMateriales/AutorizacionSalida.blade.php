<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Autorizacion de Salida</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('images/logos/favico.png')}}" type="image/x-icon">
</head>

<body>
    <style>
        h4, h5, h6
        {
            margin-top: 5px;
            margin-bottom: 5px;
        }
        table 
        {
            width: 100%;
            border: 0px solid #000;
            margin: 10px 10px 10px 10px;
            border-spacing: 0px;
            border-collapse: collapse;
        }

        td 
        {
            padding-left: 5px;
            padding-right: 5px;
           /* text-align: center; */
        }

        .center
        {
            text-align: center;
        }
        .firma
        {
            padding-bottom: 30px;
        }

        body 
        {
            font-size: 10px;
            overflow-x: hidden;
            color: #353c4e;
            font-family: "Open Sans", sans-serif;
            background-attachment: fixed;
        }
        .marca-agua
        {
            position:absolute;
            /*opacity:0.5;*/
            font-size:45px;
            width:100%;
            height:100%;
            margin-top: -10px;
            text-align:center;
            /*color: rgba(142, 189, 236, 0.908);*/
        }
    </style>

    @php
    $duplicar = 2;
    @endphp

    @for ($i = 0; $i < $duplicar; $i++) 

    <h4 class="center" >AUTORIZACIÓN DE SALIDA DE MATERIALES, EQUIPOS Y HERRAMIENTAS</h4>
    <div class="marca-agua">
        @if($salida->estatus == 'GENERADO')
            NO VALIDADO
        @else
            {{$salida->estatus}}
        @endif
    </div>
    <h6 style="text-align: right;">Fecha Impresión: {{ Carbon\Carbon::now()->format('d-m-Y H:i:s')}}</h6>
    <h6 style="text-align: right;">{{ $i == 0 ? 'Almacen' : 'Control' ;}} </h6>
    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px"> 
                    <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                    <br> 
                    <strong>ACERONET</strong> 
                </td>
                <td style="width:80px">
                    <h5>FECHA EMISIÓN</h5>
                    {{$salida->fecha_emision}}
                </td>
                <td style="width:80px">
                    <h5>FECHA ESTIMADA DE SALIDA</h5>
                    {{$salida->fecha_salida}}
                </td>
                <td style="width:80px">
                    <h5>HORA ESTIMADA DE SALIDA</h5>
                    {{$salida->hora_salida}}
                </td>
                <td style="width:80px">
                    <h5>JEFATURA DE ALMACENES</h5>
                    FOR-ALM-002 
                </td>
            </tr>
        </tbody>
    </table>
    <table border="1">
        <tbody>
            <tr>
                <td rowspan="2">
                    <h4 class="center">CORRELATIVO</h4>
                    <h1 class="center">{{$salida->id_salida}}</h1>   
                     {{-- <h5>SOLICITADO POR: <small>{{$salida->solicitante}}</small> </h5> --}}
                     {{-- <h5>AUTORIZADO POR: <small>{{$salida->autorizado}}</small> </h5> --}}
                     {{-- <h5>UNIDAD / GERENCIA: <small>{{$salida->departamento}}</small> </h5> --}}
                     {{-- <h5>RESPONSABLE: <small>{{$salida->responsable}}</small> </h5> --}}
                </td>
                <td>
                    {{-- <h5>CONDUCTOR: <small>{{$salida->conductor}}</small> </h5> --}}
                    <h5>VEHICULO: 
                        <small>
                            @if($salida->tipo_vehiculo == 'INTERNO')
                                {{$salida->vehiculo_interno}}
                            @else
                                {{$salida->vehiculo_foraneo}}
                            @endif
                        </small> 
                    </h5>
                </td>
            </tr>
            <tr>
                <td>
                    <h5>ALMACEN: <small>{{$salida->nombre_almacen}}</small> </h5>
                    <h5>TIPO SALIDA: <small>{{$salida->nombre_tipo}}</small> </h5>
                    <h5>MOTIVO SALIDA: <small>{{$salida->nombre_subtipo}}</small> </h5>
                </td>
            </tr>
            <tr>
                <td>
                    <h5>DESTINO: <small>{{$salida->destino}}</small> </h5>
                </td>
                <td>
                    <h5>ACTIVIDAD: <small>{{$salida->motivo}}</small> </h5>
                </td>
            </tr>
            {{-- <tr>
                <td colspan="2">
                    <h5>MOTIVO: <small>{{$salida->motivo}}</small> </h5>
                </td>
            </tr> --}}
        </tbody>
    </table>

        <table border="1">
            <tbody>
                {{-- <tr>
                    <td colspan="6" style="background-color:#cccccc; text-align:center;"><strong>DATOS DEL
                            MATERIAL, EQUIPO Y HERRAMIENTA</strong></td>
                </tr> --}}
                <tr style="border-bottom: 1pt solid black;">
                    <th style="">ITEM</th>
                    <th style="">CODIGO</th>
                    <th style="">DESCRIPCIÓN</th>
                    <th style="">OBSERVACIÓN</th>
                    <th style="">UNIDAD</th>
                    <th style="">CANT.</th>
                    <th style="">USO OFICIAL</th>
                </tr>
                @foreach ($articulos as $articulo)
                <tr>
                    <td style="width:5%">{{$articulo->item}}</td>
                    <td style="width:10%">{{$articulo->codigo_articulo}}</td>
                    <td style="width:30%">{{$articulo->nombre_articulo}}</td>
                    <td style="width:20%">{{$articulo->comentario}}</td>
                    <td style="width:5%">{{$articulo->tipo_unidad}}</td>
                    <td style="width:10px">{{number_format($articulo->cantidad_salida, 2)}}</td>
                    <td style="width:30%"></td>
                </tr>
                    @php
                        $CantidadItems = $loop->count;
                    @endphp
                @endforeach
            </tbody>
        </table>

        <table border="1" class="center">
            <tbody>
                <tr>
                    {{-- <td style="width:80px"> 
                        <h5 class="firma">RESPONSABLE MATERIAL</h5>
                        <small>{{$salida->responsable}}</small>
                        <h6>Nombres, Firma, Fecha</h6>
                    </td> --}}
                    <td style="width:80px">
                        <h5 class="firma">AUTORIZADO</h5>
                        {{-- <small>{{$salida->autorizado}}</small> --}}
                        <h6>Firma, Fecha</h6>
                        {{-- <h6>Nombres, Firma, Fecha</h6> --}}
                    </td>
                    <td style="width:80px">
                        <h5 class="firma">JEFE ALMACEN / AUDITORIA</h5>
                        {{-- <small>{{$salida->responsable_almacen}}</small> --}}
                        <h6>Firma, Fecha</h6>
                        {{-- <h6>Nombres, Firma, Fecha</h6> --}}
                    </td>
                    <td style="width:80px">
                        <h5 class="">REVISION POR SEGURIDAD</h5>
                        <h6 class="firma">SALIDA</h6>
                        <h6>Fecha / Hora</h6>
                    </td>
                    <td style="width:80px">
                        <h5 class="">REVISION POR SEGURIDAD</h5>
                        <h6 class="firma">ENTRADA</h6>
                        <h6>Fecha / Hora</h6>
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- <h6 style="text-align: right" >CREADO POR: {{$salida->creado_por}}</h6> --}}
        <br>
        {{-- Salto de pagina --}}
        @if ($CantidadItems >= 8 && $i < 1)
             <div style="page-break-after:always;"></div> 
        @endif

        @endfor
</body>

</html>