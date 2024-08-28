<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado Estatus Despacho De Herramientas</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('images/logos/favico.png')}}" type="image/x-icon">
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

        .center {
            text-align: center;
        }

        .firma {
            padding-bottom: 30px;
        }

        body {
            font-size: 8px;
            overflow-x: hidden;
            color: #353c4e;
            font-family: "Open Sans", sans-serif;
            background-attachment: fixed;
        }
        @page {
		    
	    }
    </style>

    <h4 class="center">LISTADO ESTATUS DESPACHO DE HERRAMIENTAS</h4>
    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px">
                    <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                    <br>
                    <strong>ACERONET</strong>
                </td>
                <td style="width:80px">
                    <h5>FECHA INICIO</h5>
                    {{$_GET['fecha_inicio']}}
                </td>
                <td style="width:80px">
                    <h5>FECHA FIN</h5>
                    {{$_GET['fecha_fin']}}
                </td>
                <td style="width:80px">
                    <h5>ALMACEN</h5>
                    {{$EstatusDespacho[0]->nombre_almacen}}
                </td>
                <td style="width:80px">
                    <h5>ESTATUS</h5>
                    {{$_GET['estatus']}}
                </td>
            </tr>
        </tbody>
    </table>
    <table  border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>SOLICITANTE</th>
                <th>RESPONSABLE</th>
                <th>DETALLES DE HERRAMIENTAS</th>
                <th>ESTATUS</th>
            </tr>
        </thead> 
  
        <tbody>
            @foreach($EstatusDespacho as $EstatusDespachos)
           <tr>
                <td>{{$EstatusDespachos->id_movimiento}}</td>
                <td>{{$EstatusDespachos->creado_por}}</td>
                <td>{{$EstatusDespachos->responsable}}</td>
                <td>
                    <table border="0" id='table'>
                         <thead>
                            <tr>
                                <th>HERRAMIENTA</th>
                                <th>FECHA DESPACHO</th>
                                <th>CANT. ENTREGADA</th>
                                <th>FECHA RECEPCIÓN</th>
                                <th>CANT. RECEPCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            {!!$EstatusDespachos->herramientas!!}
                        </tbody>
                    </table>
                </td>
                <td>{{$EstatusDespachos->estatus}}</td>
            </tr> 
            @endforeach
        </tbody>
    </table> 

</body>

</html>

@section('scripts')

@endsection