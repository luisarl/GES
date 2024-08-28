<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Solicitud de Despacho</title>
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

    <h1 class="center">SOLICITUD DE DESPACHO</h1>

    <h6 style="text-align: right;">Fecha Impresión: {{ Carbon\Carbon::now()->format('d-m-Y H:i:s')}}</h6>
    {{-- <h6 style="text-align: right;">{{ $i == 0 ? 'Almacen' : 'Control' ;}} </h6> --}}
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
                    {{date('d-m-Y', strtotime($solicitud->fecha_creacion))}}
                </td>
                <td style="width:80px">
                    <h5>UNIDAD SOLICITANTE</h5>
                    {{$solicitud->nombre_departamento}}
                </td>
                <td style="width:80px">
                    <h5>UBICACION DESTINO</h5>
                    {{$solicitud->ubicacion_destino}}
                </td>
                <td style="width:80px">
                    <h5>ALMACEN RESPONSABLE</h5>
                    {{$solicitud->nombre_almacen}}
                </td>
                <td style="width:80px">
                    <h5>JEFATURA DE ALMACENES</h5>
                    FOR-ALM-005 
                </td>
            </tr>
        </tbody>
    </table>
    <table border="1">
        <tbody>
            <tr>
                <td style="width:30%">
                    <h4 class="center">CORRELATIVO</h4>
                    <h1 class="center">{{$solicitud->id_solicitud_despacho}}{{--$salida->id_salida--}}</h1>   
                     {{-- <h5>SOLICITADO POR: <small>{{$salida->solicitante}}</small> </h5> --}}
                     {{-- <h5>AUTORIZADO POR: <small>{{$salida->autorizado}}</small> </h5> --}}
                     {{-- <h5>UNIDAD / GERENCIA: <small>{{$salida->departamento}}</small> </h5> --}}
                     {{-- <h5>RESPONSABLE: <small>{{$salida->responsable}}</small> </h5> --}}
                </td>
                <td style="width:70%">
                    <h4 class="">OBSERVACIONES:</h4> 
                    <small> {{$solicitud->observacion}}</small>
                </td>
            </tr>

        </tbody>
    </table>

        <table border="1">
            <tbody>
                {{-- <tr>
                    <td colspan="6" style="background-color:#cccccc; text-align:center;"><strong>DATOS DEL
                            MATERIAL, EQUIPO Y HERRAMIENTA</strong></td>
                </tr> --}}
                <tr style="border-bottom: 1pt solid black;">
                    <th style="width:5%">ITEM</th>
                    <th style="width:10%">CODIGO</th>
                    <th style="width:30%">DESCRIPCIÓN</th>
                    <th style="width:15%">UNIDAD</th>
                    <th style="width:5%">CANT.</th>
                    <th style="width:15%">ESTADO</th>
                    <th style="width:20%">DISP. FINAL</th>
                    <th>UBICACION</th>
                </tr>
                @foreach($articulos as $articulo)
                @php($CantidadArticulos = $loop->iteration)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$articulo->codigo_articulo}}</td>
                        <td>{{$articulo->nombre_articulo}}</td>
                        <td>{{number_format($articulo->equivalencia_unidad, 2).' '.$articulo->tipo_unidad}}</td>
                        <td>{{number_format($articulo->cantidad, 2)}}</td>
                        <td>{{$articulo->estado}}</td>
                        <td>{{$articulo->nombre_clasificacion}}</td>
                        <td>{{$articulo->nombre_ubicacion}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table border="1" class="center">
            <tbody>
                <tr style="border-bottom: 1pt solid black;">
                    <td colspan="3">UNIDAD SOLICITANTE</td>
                    <td colspan="2">ALMACEN RECEPTOR</td>
                    <td>SEGURIDAD</td>
                </tr>
                <tr>
                    <td style="width:80px">
                        <h5 class="firma">SOLICITADO</h5>
                        {{-- <small>{{$salida->autorizado}}</small> --}}
                        <h6>Firma, Fecha</h6>
                        {{-- <h6>Nombres, Firma, Fecha</h6> --}}
                    </td>
                    <td style="width:80px">
                        <h5 class="firma">AUTORIZADO</h5>
                        {{-- <small>{{$salida->responsable_almacen}}</small> --}}
                        <h6>Firma, Fecha</h6>
                        {{-- <h6>Nombres, Firma, Fecha</h6> --}}
                    </td>
                    <td style="width:80px">
                        <h5 class="">ENTREGADO</h5>
                        <h6 class="firma"></h6>
                        <h6>Firma, Fecha</h6>
                    </td>
                    <td style="width:80px">
                        <h5 class="">RECIBIDO ALMACEN</h5>
                        <h6 class="firma"></h6>
                        <h6>Firma, Fecha</h6>
                    </td>
                    <td style="width:80px">
                        <h5 class="">JEFE ALMACEN</h5>
                        <h6 class="firma"></h6>
                        <h6>Firma, Fecha</h6>
                    </td>
                    <td style="width:80px">
                        <h5 class="">REVISION POR SEGURIDAD</h5>
                        <h6 class="firma"></h6>
                        <h6>Firma, Fecha</h6>
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- <h6 style="text-align: right" >CREADO POR: {{$salida->creado_por}}</h6> --}}
        <br>
        {{-- Salto de pagina --}}
        @if ($CantidadArticulos >= 7 && $i < 1)
             <div style="page-break-after:always;"></div> 
        @endif
    @endfor
</body>

</html>