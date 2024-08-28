<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reportes de Asistencias</title>
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
            height: 20px;
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
    $duplicar = 1;
    @endphp

    @for ($i = 0; $i < $duplicar; $i++) 

    <h1 class="center">REPORTE HORAS TOTALES</h1>

    <h6 style="text-align: right;">Fecha Impresión: {{ Carbon\Carbon::now()->format('d-m-Y H:i:s')}}</h6>
  
    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px"> 
                    <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                    <br> 
                    <strong>ACERONET</strong> 
                </td>
               
                <td style="width:80px">
                    <h5>FECHA DE VALIDACION</h5>
                   {{$FechaInicio}}
                </td>
                <td style="width:80px">
                    <h5>DEPARTAMENTO</h5>
                  {{$departamentos}}
                </td>
                
             
               
            </tr>
        </tbody>
    </table>
    <table border="1">
      
    </table>

        <table border="1">
            <tbody>
             
                <tr style="border-bottom: 1pt solid black;">
                    <th style="width:3%">EMPRESA</th>
                    <th style="width:2%">DEPARTAMENTO</th>
                    <th style="width:1%">ID BIOMETRICO</th>
                    <th style="width:1%">ID NOMINA</th>
                    <th style="width:4%">EMPLEADO</th>
                    <th style="width:2%">HORA ENTRADA</th>
                    <th style="width:2%">HORA SALIDA </th>
                    <th style="width:1%">HORAS MINIMAS</th>
                    <th style="width:2%">HORAS TOTALES</th>
                    <th style="width:2%">HORAS EXTRA DIURNAS</th>
                    <th style="width:2%">HORAS NOCTURNAS</th>
                   
                </tr>
                @foreach($validaciones as $validacion)
            
                    <tr>
                       <td>{{$validacion->nombre_empresa}}</td>
                       <td>{{$validacion->des_depart}}</td>
                        <td>{{$validacion->id_biometrico}}</td>
                        <td>{{$validacion->id_empleado}}</td>
                        <td>{{$validacion->nombre_empleado}}</td>
                        <td id="hora_entrada">
                            @if ($validacion->hora_entrada == '00:00:00.0000000'&& $validacion->hora_salida== '00:00:00.0000000')
                                00:00:00
                            @else
                                {{ date('g:i:s A', strtotime($validacion->hora_entrada)) }}
                            @endif
                        </td>
                        <td id="hora_salida">
                            @if ($validacion->hora_entrada == '00:00:00.0000000'&& $validacion->hora_salida== '00:00:00.0000000')
                                00:00:00
                            @else
                                {{ date('g:i:s A', strtotime($validacion->hora_salida)) }}
                            @endif
                        </td>

                        <td>{{$validacion->horas_jornada}}</td>
                        <td>{{$validacion->horas_trabajadas}}</td>
                        <td>
                            @if ($validacion->hora_entrada == '00:00:00.0000000'&& $validacion->hora_salida== '00:00:00.0000000')
                                00:00:00
                            @else
                                {{$validacion->horas_extra_diurnas}}
                            @endif
                        </td>
                        <td>
                            @if ($validacion->hora_entrada == '00:00:00.0000000'&& $validacion->hora_salida == '00:00:00.0000000')
                                00:00:00
                            @else
                                {{$validacion->horas_extra_nocturnas}}
                            @endif
                        </td>
                    
                
                    </tr>
                @endforeach
            </tbody>
        </table>


        @endfor
</body>

</html>