@extends('layouts.email')

@section('titulo','SE HA REALIZADO UNA RECEPCION DE HERRAMIENTAS')

@section('contenido')
<ul>
    <li>Despacho Nº: {{$movimiento->id_movimiento}} </li>
    <li>Almacen: {{$movimiento->nombre_almacen}} </li>
    <li>Zona: {{$movimiento->nombre_zona}}</li>
    <li>Motivo: {{$movimiento->motivo}}</li>
    <li>Responsable: {{$movimiento->responsable}}</li>
    <li>Recepcionado Por: {{ $usuario }}</li>
</ul>

<b>LISTADO DE HERRAMIENTAS</b>

<table class="content" style="border-collapse: collapse;width: 100%;max-width: 800px; " cellspacing="4" cellpadding="4" border="0" align="center">
    <thead>
        <tr style="border-bottom: 1px solid">
            <th>HERRAMIENTA</th>
            <th>FECHA DESPACHO</th>
            <th>RESPONSABLE</th>
            <th>CANTIDAD ENTREGADA</th>
            <th>FECHA RECEPCIÓN</th>
            <th>CANTIDAD RECEPCIÓN</th>
            <th>ESTATUS</th>
            <th>EVENTUALIDADES</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        @foreach ($herramientas as $herramienta)

        @if ($herramienta->cantidad_entregada != NULL)
        <tr style="background-color: rgba(0,0,0,.075); border-bottom: 1px solid">
            @else
        <tr style="border-bottom: 1px solid">
            @endif
            <td>
                @if($herramienta->cantidad_entregada != NULL)
                {{$herramienta->nombre_herramienta}}
                @endif
            </td>
            <td>{{$herramienta->fecha_despacho}}</td>
            <td>{{$herramienta->responsable}}</td>
            <td>{{$herramienta->cantidad_entregada}}</td>
            <td>{{$herramienta->fecha_devolucion}}</td>
            <td>
                @if($herramienta->cantidad_entregada == NULL)
                {{$herramienta->cantidad_devuelta}}
                @endif
            </td>
            <td>
                @if($herramienta->estatus != 'BUEN ESTADO' )
                <span style="color: #fe5d70"> {{$herramienta->estatus}} </span>
                @else
                <span style="color: #0ac282"> {{$herramienta->estatus}} </span>
                @endif
            </td>
            <td>{{$herramienta->eventualidad}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('url', Request::root().'/despachos/'.$movimiento->id_movimiento)
@section('boton', 'VER RECEPCION')