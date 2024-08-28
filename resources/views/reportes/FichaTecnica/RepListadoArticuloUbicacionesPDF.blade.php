<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Articulos</title>
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
            font-size: 10px;
            overflow-x: hidden;
            color: #353c4e;
            font-family: "Open Sans", sans-serif;
            background-attachment: fixed;
        }
    </style>

    <h4 class="center">REPORTE ARTICULOS SEGUN UBICACION</h4>
    <table border="1" class="center">
        <tbody>
            <tr>
                <td style="width:80px">
                    <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
                    <br>
                    <strong>ACERONET</strong>
                </td>
            </tr>
        </tbody>
    </table>

    <table  border="1">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Articulos</th>
                <th>Almacen</th>
                <th>Sub Almacen</th>
                <th>Zona</th>
                <th>Ubicacion</th>
                <th>Existencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articulos as $articulo)
                    @php
                    $StockAlmacenes = App\Models\Articulo_MigracionModel::StockAlmacenesArticuloProfit($articulo->base_datos,$articulo->codigo_articulo );
                    @endphp
                    <tr>  
                        <td>{{ $articulo->codigo_articulo }}</td>  
                        <td>{{ $articulo->nombre_articulo }}</td>
                        <td>{{ $articulo->nombre_almacen }}</td>
                        <td>{{ $articulo->nombre_subalmacen}}</td>
                        <td>{{ $articulo->nombre_ubicacion }}</td>
                        <td>{{ $articulo->zona }}</td>
                        <td>
                            @foreach ($StockAlmacenes as $stock)
                                @if($stock->stock_act  > 0 )
                                    {{ number_format($stock->stock_act, 2, '.', '')}}
                                @endif
                            @endforeach  
                        </td>     
                    
                    {{-- <td>
                        <table class="table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Stock Actual</th>
                                </tr>
                            </thead>
                            @foreach ($StockAlmacenes as $stock)
                            <tr>
                                <td>{{ $stock->des_sub}} </td>
                                <td> {{ number_format($stock->stock_act, 2, '.', '')}} </td>          
                            </tr>
                            @endforeach  
                        </table>
                    </td> --}}
                    </tr>
                @endforeach
        </tbody>
    </table>
</body>

</html>