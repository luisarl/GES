<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ficha Tecnica</title>
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images/logos/favico.png') }}" type="image/x-icon">
</head>

<body>
    <style>
        .no-border {

            border 0px;
        }

        .margen{
            margin: 0px 0px 0px 0px;
        }

        table {
            width: 95%;
            border-collapse: separate;
            border: 0px solid #000;
            border-radius: 10px;
            padding-left: 10px;
            margin: 20px 20px 20px 20px;

        }

        tr {

            border: 1px solid;
            border-collapse: collapse;
            margin-bottom: 1px;
            margin-top: 1px;
        }

        td {
            text-align:;
            width: 33%;
        }


        .img {
            margin: 20px 20px 0px 20px;
            width: 200px;
            height: 200px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;

        }

        body {

            font-size: .875em;
            overflow-x: hidden;
            color: #353c4e;
            font-family: "Open Sans", sans-serif;
            background-attachment: fixed;

        }

        h3,h4{
            margin-bottom: 5px;
            margin-top: 3px;  
        }
        h2,
        p {
            margin-bottom: 5px;
            margin-top: 5px;
        }
    </style>

    <div class="margen">
        <img src="{{ asset("images/logos/logo_global_menu.png") }}" alt="" class="">
        <h4 style="margin-top: 4px;">ACERONET</h4>
    </div>
    <h2 style="text-align: center">FICHA TECNICA Nº {{ $articulo->id_articulo }}</h2>
    <hr >

    <table class="">
        <tbody>
            {{-- <tr>
                <td colspan="2">
                    
                    <h2 style="text-align: center">FICHA TECNICA Nº {{ $articulo->id_articulo }}</h2>
                    <hr>
                </td>
            </tr> --}}
            <tr>
                <td style="text-align: left;">
                    <br>
                    <p><strong>CODIGO: </strong> {{ $articulo->codigo_articulo }}</p>
                            <p><strong>NOMBRE: </strong> {{ $articulo->nombre_articulo }}</p>
                                    <p><strong>REFERENCIA: </strong> {{ $articulo->referencia }}</p>
                                            <p><strong>DESCRIPCIÓN: </strong>{{ $articulo->descripcion_articulo }}</p>

                                                    @if ($articulo->documento_articulo != '')
                                                        <p> <a href="{{ asset($articulo->documento_articulo) }}"> VER
                                                                DOCUMENTO ASOCIADO</a>
                                                        <p>
                                                    @endif
                </td>
                <td>
                    <img src="{{ asset($articulo->imagen_articulo) }}" alt="" class="img">
                </td>
            </tr>
        </tbody>
    </table>

    <hr>

    <table class="">
        <tbody>
            <tr>
                <td>
                    <h3>INFORMACIÓN</h3>
                </td>
                <td>
                    <h3>UNIDADES</h3>
                </td>
                <td>
                    <h3>STOCK</h3>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>GRUPO: </strong> <br> {{-- $articulo->grupo --}}  {{ $articulo->nombre_grupo }}</p>
                </td>
                <td>
                    <p><strong>PRIMARIA: </strong> <br>{{ $articulo->nombre_unidad }}</p>
                </td>
                <td>
                    <p><strong>PUNTO MINIMO: </strong> {{ $articulo->minimo }}</p>
                </td>
            </tr>    
            <tr>    
                <td>
                    <p><strong>SUBGRUPO: </strong> <br> {{-- $articulo->subgrupo --}}  {{ $articulo->nombre_subgrupo }}
                    </p>
                </td>
                <td>
                    <p><strong>SECUNDARIA: </strong> <br> {{ $articulo->nombre_unidad_sec }}</p>
                </td>
                <td>
                    <p><strong>PUNTO MAXIMO: </strong> {{ $articulo->maximo }}</p>
                </td>
            </tr>    
            <tr>    
                <td>
                    <p><strong>CATEGORIA: </strong> <br> {{-- $articulo->categoria --}} {{ $articulo->nombre_categoria }}</p>
                </td>
                <td>
                    @if ($articulo->unidad_ter == 0)
                        <p><strong>ALTERNA: </strong> <br> N/A </p>
                    @else
                        <p><strong>ALTERNA: </strong> <br>{{ $articulo->nombre_unidad_alt }} </p>
                    @endif
                </td>
                <td>
                    <p><strong>PUNTO DE PEDIDO: </strong> {{ $articulo->pedido }}</p>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    @if ($DatosAdicionales != "[]")
        <table class="">
            <tbody>
                <tr>
                    <td colspan="3">
                        <h3>DATOS ADICIONALES</h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>CLASIFICACIÓN</h4>
                    </td>
                    <td>
                        <h4>SUBCLASIFICACIÓN</h4>
                    </td>
                    <td>
                        <h4>VALOR</h4>
                    </td>
                </tr>
                @foreach ($DatosAdicionales as $adicionales)
                    <tr>
                        <td>
                            <p>{{ $adicionales->nombre_clasificacion }}</p>
                        </td>
                        <td>
                            <p>{{ $adicionales->nombre_subclasificacion }}</p>
                        </td>
                        <td>
                            <p>{{ $adicionales->valor }}</p>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endif


    <br>

    <p style="text-align: right"><strong>SOLICITADO POR: </strong> {{ $articulo->nombre_usuario_c }} </p>
    <p style="text-align: right"><strong>CATALOGADO POR: </strong> {{ $articulo->nombre_usuario_a }} </p>
    <hr>
</body>

</html>
