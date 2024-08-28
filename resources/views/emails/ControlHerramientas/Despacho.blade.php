@extends('layouts.email')

@section('titulo','SE HA REALIZADO UN DESPACHO DE HERRAMIENTAS')

@section('contenido')
<ul>
    <li>Despacho Nº: {{$movimiento->id_movimiento}} </li>
    <li>Almacen: {{$movimiento->nombre_almacen}} </li>
    <li>Zona: {{$movimiento->nombre_zona}}</li>
    <li>Motivo: {{$movimiento->motivo}}</li>
    <li>Responsable: {{$movimiento->responsable}}</li>
    <li>Despachado Por: {{$movimiento->creado_por}}</li>

</ul>

<b>LISTADO DE HERRAMIENTAS</b>

<table class="content" style="border-collapse: collapse;width: 100%;max-width: 800px; " cellspacing="4" cellpadding="4" border="0" align="center">
    <tbody style="text-align: center;">
        <tr style="border-bottom: 1px solid">
            <th>Codigo</th>
            <th>Herramienta</th>
            <th>Fecha Despacho</th>
            <th>Cantidad</th>
        </tr>

        @foreach ($herramientas as $herramienta)
        <tr style="border-bottom: 1px solid">
            <td>{{$herramienta->id_herramienta}}</td>
            <td>{{$herramienta->nombre_herramienta}}</td>
            <td>{{$herramienta->fecha_despacho}}</td>
            <td>{{$herramienta->cantidad_entregada}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('url', Request::root().'/despachos/'.$movimiento->id_movimiento)
@section('boton', 'VER DESPACHO')