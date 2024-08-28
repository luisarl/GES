<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reportes de Despachos</title>
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

    <h1 class="center">REPORTE DESPACHO DE COMBUSTIBLE {{$combustible}}</h1>

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
                    <h5>FECHA DE INICIO</h5>
                   {{date('d-m-Y ', strtotime($FechaInicio))}}
                 
                </td>
                <td style="width:80px">
                    <h5>FECHA DE FINAL</h5>
                    {{date('d-m-Y ', strtotime($FechaFin))}}
                </td>
                <td style="width:80px">
                    <h5>TIPO DE COMBUSTIBLE</h5>
                   {{$combustible}}
                </td>
                
                 
            </tr>
        </tbody>
    </table>
    
        <table border="1">
            <tbody>
            
                <tr style="border-bottom: 1pt solid black;">
                    <th style="width:1%">ID DESPACHO</th>
                    <th style="width:1%">FECHA</th>
                    <th style="width:1%">DEPARTAMENTO</th>
                    <th style="width:2%">MARCA/NOMBRE EQUIPO</th>
                    <th style="width:2%">PLACA/SERIAL EQUIPO</th>
                    <th style="width:1%">CANTIDAD DESPACHADA</th>
                    <th style="width:1%">STOCK INICIAL</th>
                    <th style="width:1%">STOCK FINAL</th>
                   
                </tr>
                @foreach($reportes as $reporte)
              
                    <tr>
                       <td>{{$reporte->id_solicitud_despacho}}</td>
                       <td>{{date('d-m-Y ', strtotime($reporte->fecha_despacho))}}</td>
                       <td>{{$reporte->nombre_departamento}}</td>
                       <td>{{$reporte->marca_equipo}}</td>
                       <td>{{$reporte->placa_equipo}}</td>
                       <td>{{number_format($reporte->cantidad_despachada,2)}}</td>
                       <td>{{number_format($reporte->stock_anterior,2)}}</td>
                       <td>{{number_format($reporte->stock_combustible,2)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
         <br>

             <h1 class="center">CANTIDAD DESPACHADA POR GERENCIAS</h1>
         <table border="1">
            <tbody>
             
                <tr style="border-bottom: 1pt solid black;">
                  
                    <th style="width:1%">DEPARTAMENTO</th>
                    <th style="width:1%">CANTIDAD DESPACHADA</th>
                   
                </tr>
                @foreach($gerencias as $gerencia)
              
                    <tr>
                       <td>{{$gerencia->nombre_departamento}}</td>
                       <td>{{number_format($gerencia->cantidad,2)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        
        
        


        @endfor
</body>

</html>