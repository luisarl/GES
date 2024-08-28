<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ficha Tecnica</title>
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
    </style>

    <h4 class="center">REPORTE CATALOGACION DE ARTICULOS</h4>
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
            </tr>
        </tbody>
    </table>

    <table  border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @if($catalogaciones != null) 
        @php($total = 0)
        
            @foreach($catalogaciones as $catalogacion)
                <tr>
                    <td>{{$catalogacion->nombre_usuario}}</td>
                    <td>{{date('d-m-Y', strtotime($catalogacion->fecha))}}</td>
                    <td>{{$catalogacion->total}}</td>
                </tr>
                @php($total += $catalogacion->total)
            @endforeach
            <tr>
                <th colspan="2">TOTAL</th>
                <th>{{$total}}</th>
            </tr>
        @endif
        </tbody>
    </table>
</body>

</html>