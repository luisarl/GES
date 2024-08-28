<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ORDEN DE TRABAJO</title>
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

        .tabla 
        {
            border-top-width: 1;
            border-right-width: 1px; 
            border-bottom-width: 1px;
            border-left-width: 1px;
            text-align: left; 
            width: 100%; 
        }

        .tabla2 
        {
            colspan: 4; 
            class: header2; 
            height: 50px;
        }

        .header 
        {
            border-top-width: 1;
            border-right-width: 1px; 
            border-bottom-width: 1px;
            border-left-width: 1px;
            text-align: center;  
        }

        .tamano
        {
            width:160px; 
            text-align: center;
        }

        .bg
        {
            background-color: #c0c0c0;
        }

    </style>

    {{-- <h4 class="center" >SOLICITUD DE SERVICIO</h4> --}}
    <table border="1" class="tabla header">
        <tbody>
            <tr>
                <td style="width:100px"> 
                    @if($solicitud->id_departamento_servicio == 22)
                        <img src="{{ asset("images/logos/logo_paramaconi.png") }}" alt="" class="" width="70px" height="70px">
                    @else 
                        <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                        <strong>ACERONET</strong> 
                    @endif
                   
                    <br> 
                   
                </td>

                <td class="">
                    <h4>ORDEN DE TRABAJO # {{$solicitud->id_solicitud}}</h4>
                </td>
                <td> 
                    <h4>FECHA DE APERTURA OT: {{ date('d/m/Y', strtotime($solicitud->fecha_asignacion))}}</h4>
                </td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="tabla header">
        <tbody>
            <tr>
                <td style="width:100px" class="bg"> <h4> SOLICITANTE: </h4> </td>
                <td style="width:150px"><h4>{{ $solicitud->creado_por}}</h4> </td>
                <td class="bg"><h4> BUQUE/UBICACION: </h4></td>
                <td><h4>{{ $solicitud->mantenimiento_tipo_equipo}}</h4></td>
                <td class="bg"><h4> PRIORIDAD: </h4></td>
                <td><h4>{{ $solicitud->prioridad}}</h4></td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="tabla">
        <tbody>
            <tr>
                <td style="width:100px" class="bg"> <h4> FECHA REPORTE: </h4></td>
                <td style="width:150px"><h4>{{ date('d/m/Y', strtotime($solicitud->fecha_creacion))}}</h4></td>
                <td class="bg" style="width:50px"><h4>MOTIVO:</h4></td>
                <td> <h4>{{ $solicitud->asunto_solicitud}}</h4></td>
              
            </tr>
            <tr>
                <td class="bg"><h4> SERVICIO: </h4></td>
                <td><h4>{{ $solicitud->nombre_servicio}}</h4></td>
                
                <td rowspan="2" class="bg"><h4> COMENTARIO: </h4></td>
                <td rowspan="2"> <h4>{{ $solicitud->descripcion_solicitud}}</h4></td>
            </tr>
            <tr>
                <td class="bg"><h4> SUBSERVICIO: </h4></td>
                <td><h4>{{ $solicitud->nombre_subservicio}}</h4></td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="tabla">
        <tbody>
            <tr class="header">        
                <td colspan="2" class="bg"> <h4>PERSONAL TECNICO ASIGNADO | FECHA ASIGNACION: {{$solicitud->fecha_asignacion != null ? date('d/m/Y', strtotime($solicitud->fecha_asignacion)) : ''}} </h4></td> 
            </tr>
            @foreach($responsables as $responsable)
                <tr>
                    <td><h4>{{$responsable->nombre_responsable}}</h4></td>
                    <td>FIRMA:</td>
                </tr>
            @endforeach
            
        </tbody>
    </table>

    <table border="1" class="tabla">
        <tbody>
            <tr class="header">
                <td class="bg" colspan="3"> <h4>INSPECCION DE NOVEDAD Y DESCRIPCION DE ACTIVIDADES A EJECUTAR</h4></td> 
            </tr>
            <tr>
                <td colspan="3" style="padding-bottom: 80px;"></td>
            </tr>
            <tr>
                <td style="width: 150px;" class="bg"> <h4>TIEMPO ESTIMADO: </h4></td> 
                <td colspan="2"></td>
            </tr>
            <tr>
                <td class="bg"><h4>COORDINADOR:</h4></td>
                <td></td>
                <td>FIRMA:</td>
            </tr>
            <tr>
                <td class="bg"><h4>SUPERVIDOR ESPECIALISTA:</h4></td>
                <td></td>
                <td>FIRMA:</td>
            </tr>
        </tbody>
    </table>

    <table border="1" class="tabla">
        <tbody>
            <tr class="header">
                <td colspan="4" class="bg"> <h4>REQUERIMIENTOS</h4></td> 
            </tr>
            <tr class="center">
                <td style="width: 150px;"><h4>CODIGO/NRO PARTE</h4></td>
                <td style="width: 400px;"><h4>DESCRIPCION</h4></td>
                <td style="width: 30px;"><h4>UNIDAD</h4></td>
                <td style="width: 30px;"><h4>CANTIDAD</h4></td>
            </tr>
            @for($i = 0 ; $i < 10; $i ++)
            <tr>
                <td style="padding-bottom: 15px;"></td>
                <td style="padding-bottom: 15px;"></td>
                <td style="padding-bottom: 15px;"></td>
                <td style="padding-bottom: 15px;"></td>
            </tr>
            @endfor
           <tr>
                <td class="bg"><h4>AUTORIZADOR DE REQUERIMIENTOS:</h4></td>
                <td></td>
                <td colspan="2">FIRMA:</td>
           </tr>
        </tbody>
    </table>

    <table border="1" class="tabla">
        <tbody>
            <tr class="header">
                <td class="bg"> <h4>DESCRIPCION DE LAS ACTIVIDADES REALIZADAS </h4></td> 
            </tr>
            @for($i = 0 ; $i < 50 ; $i ++)
                <tr>
                    <td style="padding-bottom: 15px;"></td>
                </tr>
            @endfor
            <tr>
                <td style="padding-bottom: 30px;"></td>
            </tr>
        </tbody>
    </table>

    {{-- SALTO DE LINEA --}}
    {{-- <div style="page-break-after:always;"></div>  --}}

    <table border="1" class="tabla">
        <tbody>
            <tr class="header">
                <td colspan="2" class="bg" style="width: 50%"><h4>RECEPCION DEL TRABAJO</h4></td> 
                <td colspan="2" class="bg" style="width: 50%"><h4>FECHA CIERRE OT: {{$solicitud->fecha_cierre != null ? date('d/m/Y', strtotime($solicitud->fecha_cierre)) : ''}}</h4></td>
            </tr>
            <tr class="center">
                <td class="bg"><h4>COORDINADOR </h4></td>
                <td class="bg"><h4>SUPERVISOR ESPECIALISTA</h4></td>
                <td class="bg"><h4> PERSONAL A BORDO</h4></td>
                <td class="bg"><h4> CAPITAN DE BUQUE</h4></td>
            </tr>
            <tr>
                <td style="padding-bottom: 25px;"></td>
                <td style="padding-bottom: 25px;"></td>
                <td style="padding-bottom: 25px;"></td>
                <td style="padding-bottom: 25px;"></td>
            </tr>
            <tr class="center">
                <td class="bg" colspan="4"> <h4>OBSERVACIONES</h4></td> 
            </tr>
            <tr>
                <td style="padding-bottom: 100px;" colspan="4"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>