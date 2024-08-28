<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Plantillas Almacenes</title>
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
            /* text-align: center; */
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


<h4 class="center">REPORTE PLANTILLAS ALMACEN</h4>
<table border="1" class="center">
    <tbody>
        <tr>
            <td style="width:80px">
                <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                <br>
                <strong>ACERONET</strong>
            </td>
            
            <td style="width:80px">
                <h5>ALMACEN</h5>
                {{$plantillas[0]->nombre_almacen}}
            </td>
            
        </tr>
    </tbody>
</table>

<table  border="1">
    <thead>
        <tr>
            <th>Nº</th>
            <th>Nombre Plantilla</th>
            <th>Id Herramienta</th>
            <th>Nombre Herramienta</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($plantillas as $plantilla)
        <tr>
            <td>{{$plantilla->id_plantilla}}</td>
            <td>{{$plantilla->nombre_plantilla}}</td>
            <td>{{$plantilla->id_herramienta}}</td>
            <td>{{$plantilla->nombre_herramienta}}</td>
            <td>{{$plantilla->cantidad}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>


</body>

</html>