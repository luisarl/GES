@extends('layouts.email')

@section('titulo','SE HA ACEPTADO UNA SOLICITUD DE DESPACHO DE COMBUSTIBLE')

@section('contenido')
<ul>
    <li>Solicitud Nº: {{$solicitud->id_solicitud_despacho}} </li>
    <li>Solicitante: {{$solicitud->creado_por}}</li>
    <li>Aceptada por: {{$solicitud->aceptado_por}}</li>
    <li>Tipo de Combustible: {{$solicitud->descripcion_combustible}}</li>
    <li>Cantidad de Combustible Solicitado: {{number_format($solicitud->total,2)}}</li>

</ul>

{{-- <b>LISTADO DE EQUIPOS O VEHICULOS</b>

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
</table> --}}

@endsection

@section('url', Request::root().'/cntcdespacharsolicituddespacho/'.$solicitud->id_solicitud_despacho)
@section('boton', 'VER SOLICITUD DE DESPACHO')