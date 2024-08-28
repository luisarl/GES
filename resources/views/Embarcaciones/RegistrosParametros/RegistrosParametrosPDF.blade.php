<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registros Parametros</title>
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

        .medidas {
            width: 12%
        }
    </style>

    {{-- Cabecera --}}
    <h4 class="center"> REGISTROS DE PARAMETROS</h4>
    <table border="1">
        <tbody>
            <tr>
                <td style="width:20px" class="center">
                    {{-- <img src="{{ asset(" images/logos/logo_global_menu.png") }}" alt="" class=""> --}}
                    <br>
                    <strong>EMBARCACIONES</strong>
                </td>
                <td style="width:100px" class="center">
                    <h5>MAQUINA</h5>
                    {{$registros[0]->nombre_maquina}}
                </td>
                <td style="width:100px" class="center">
                    <h5>FECHA</h5>
                    {{date('d-m-Y', strtotime($registros[0]->fecha))}}
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width:100%" border="1" class="center">
        <thead>
            <tr>
                <th>Parametros</th>
                <th>0</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
                <th>13</th>
                <th>14</th>
                <th>15</th>
                <th>16</th>
                <th>17</th>
                <th>18</th>
                <th>19</th>
                <th>20</th>
                <th>21</th>
                <th>22</th>
                <th>23</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $registro)
            <tr>
                <td>{{$registro->nombre_parametro}}</td>
                <td>{{$registro->hora0}}</td>
                <td>{{$registro->hora1}}</td>
                <td>{{$registro->hora2}}</td>
                <td>{{$registro->hora3}}</td>
                <td>{{$registro->hora4}}</td>
                <td>{{$registro->hora5}}</td>
                <td>{{$registro->hora6}}</td>
                <td>{{$registro->hora7}}</td>
                <td>{{$registro->hora8}}</td>
                <td>{{$registro->hora9}}</td>
                <td>{{$registro->hora10}}</td>
                <td>{{$registro->hora11}}</td>
                <td>{{$registro->hora12}}</td>
                <td>{{$registro->hora13}}</td>
                <td>{{$registro->hora14}}</td>
                <td>{{$registro->hora15}}</td>
                <td>{{$registro->hora16}}</td>
                <td>{{$registro->hora17}}</td>
                <td>{{$registro->hora18}}</td>
                <td>{{$registro->hora19}}</td>
                <td>{{$registro->hora20}}</td>
                <td>{{$registro->hora21}}</td>
                <td>{{$registro->hora22}}</td>
                <td>{{$registro->hora23}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <table border="1">
        <tbody>
            <tr>
                <td class="center" style="width:5px">
                    <h5>OBSERVACIONES</h5>
                </td>
                <td style="width:200px">
                    @foreach($observaciones->slice(0,12) as $observacion)
                    HORA {{$observacion->hora}}: {{$observacion->observaciones}} <br>
                    @endforeach
                </td>
                <td style="width:200px">
                    @foreach($observaciones->slice(12,24) as $observacion)
                    HORA {{$observacion->hora}}: {{$observacion->observaciones}} <br>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>