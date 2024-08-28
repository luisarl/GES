<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Etiqueta Articulo</title>
</head>
<body>
    <style>
        html 
        {
	        margin: 1pt 2pt;
        },
        table
        {
            font-family: Arial, Helvetica, sans-serif;
        }
        td, th 
        {
            height: 0px;
            vertical-align:top;
        }
    </style>

    <table border='0' style="margin-bottom: -4px;">
        <tbody>
            <tr>
                <td>
                    <img src="data:image/svg+xml;base64,{{ base64_encode($qr) }}">
                </td> 
                <th align="left" style="font-size: 10px;">  
                    {{$articulo[0]->codigo_articulo}}
                    <br>
                    <p style="font-size: 10px; text-align: justify; margin-bottom: 0px;margin-top: 0px;">{{$articulo[0]->nombre_articulo}} </p>
                </th>
            </tr>
        </tbody>
        
    </table>
    <table border="0" style="font-size: 7px; ">
        <tr align="left">
            <th style="width:95px;">
                ZONA:
                <br>
                {{$articulo[0]->nombre_ubicacion}}
            </th>
            <th style="width:95px;">
                UBICACION:
                <br>
                {{$articulo[0]->zona}}
            </th>
        </tr>
    </table>
</body>
</html>

