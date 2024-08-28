<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Solicitud de Resguardo</title>
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
            /* margin: 10px 10px 10px 10px; */
            border-spacing: 0px;
            border-collapse: collapse;
        }

        td 
        {
            padding-left: 5px;
            padding-right: 5px;
            padding-bottom: 5px;
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
        $contador = 0;
        $condicion = 3;
    @endphp
    <table style="margin-left: -10px; margin-right: -10px;">
        {{-- <thead>
            <th>1</th>
            <th>2</th>
            <th>3</th>
        </thead> --}}
        <tbody> 
            @foreach($articulos as $articulo)
                @if($loop->iteration == 1)
                    <tr>
                @endif
                        
                @for ($i = 0; $i < $articulo->cantidad_impresion; $i++)
                    @php($contador += 1 )
                    <td style="width: 33%">
                        <table border="1" style="width:220px;"class="center">
                            <tbody>
                                <tr>
                                    <th>SOLRESG-{{$solicitud->id_solicitud_resguardo}}</th>
                                </tr>
                                <tr>
                                    <td>{{$articulo->nombre_articulo}}  (<strong>{{$articulo->presentacion}}</strong>)</td>
                                </tr>
                                <tr>
                                    <th>{{$articulo->clasificacion}}</th>
                                </tr>
                                <tr>
                                    <td>{{date('Y', strtotime($solicitud->fecha_creacion))}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    {{-- CIERRA LA FILA <TR> SI HAN PASADO 3 REGISTROS --}}
                    @if($contador == $condicion )
                        </tr>
                        <tr>
                        @php($condicion += 3)
                    @endif
                @endfor
            @endforeach
        </tbody>
    </table>
    </body>
</html>