<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SOLICITUD DE SERVICIO</title>
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

    </style>

    <h4 class="center" >SOLICITUD DE SERVICIO</h4>
    <table border="1" class="header">
        <tbody>
            <tr>
                <td style="width:80px"> 
                    <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                    <br> 
                    <strong>ACERONET</strong> 
                </td>

                <td VALIGN=TOP class="tamano">
                    <h4 style="padding-bottom: 4px;">NUMERO:</h4>
                    <h4>{{$solicitud->id_solicitud}}</h4>
                </td>

                <td VALIGN=TOP class="tamano">
                    <h4 style="padding-bottom: 4px;">CODIGO:</h4>
                    <h4>{{$solicitud->codigo_solicitud}}</h4>
                </td>

                <td VALIGN=TOP class="tamano">
                    <h4 style="padding-bottom: 4px;">FECHA CREACION:</h4>
                    <h4>{{$solicitud->fecha_creacion}}</h4>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="tabla">
        <tbody>
            <tr>
                <td><h4>PRIORIDAD:</h4></td> 
                <td>{{$solicitud->prioridad}}</td> 
                <td><h4>DEPARTAMENTO SERV.:</h4></td> 
                <td>{{$solicitud->nombre_departamento_servicio}}</td> 

            </tr>

            <tr>
                <td><h4>USUARIO:</h4></td> 
                <td>{{$solicitud->creado_por}}</td>          
                <td><h4>SERVICIO:</h4></td> 
                <td>{{$solicitud->nombre_servicio}}</td> 

            </tr>

            <tr>
                <td><h4>DEPARTAMENTO SOLI.:</h4></td> 
                <td>{{$solicitud->nombre_departamento_solicitud}}</td> 
                <td><h4>SUBSERVICIO:</h4></td>
                <td>{{$solicitud->nombre_subservicio}}</td> 
            </tr>
            <tr>
                <td><h4>CORREO:</h4></td> 
                <td>{{$solicitud->correo_usuario}}</td> 
                <td></td><td></td>
            </tr>
        </tbody>
    </table>

    <table class="tabla" border="1"> 
        <tr>
            <td VALIGN=TOP class="tabla2">
                <h4 >MOTIVO:</h4>
                <h5>{{$solicitud->asunto_solicitud}}</h5> 
                {{-- DEPARTAMENTO LOGISTICA --}}
                @if($solicitud->id_departamento_servicio == 9)
                    <p>
                        ORIGEN : {{$solicitud->logistica_origen}} <br> 
                        DESTINO : {{$solicitud->logistica_destino}} <br> 
                        FECHA/HORA : {{$solicitud->logistica_fecha}} <br> 
                        NUMERO TELEFONICO: {{$solicitud->logistica_telefono}}
                    </p>
                @endif
                {{-- DEPARTAMENTO MANTENIMIENTO --}}
                @if($solicitud->id_departamento_servicio == 10)
                    <p>
                        TIPO : {{$solicitud->mantenimiento_tipo_equipo}} <br> 
                        NOMBRE : {{$solicitud->mantenimiento_nombre_equipo}}<br> 
                        PLACA/CODIGO : {{$solicitud->mantenimiento_codigo_equipo}} 
                    </p>
                @endif
                {{-- DEPARTAMENTO MANTENIMIENTO EMBARCACIONES --}}
                @if($solicitud->id_departamento_servicio == 22)
                    <p>
                        EMBARCACION / UNIDAD : {{$solicitud->mantenimiento_tipo_equipo}} <br> 
                        EQUIPO : {{date('d-m-Y g:i:s A', strtotime($solicitud->mantenimiento_nombre_equipo))}} 
                    </p>
                @endif
            </td>
        </tr>
        <tr>
            <td VALIGN=TOP class="tabla2">
                <h4>COMENTARIO:</h4>
                <h5>{{$solicitud->descripcion_solicitud}}</h5>
            </td>
        </tr>
    </table>

</body>

</html>