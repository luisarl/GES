@extends('layouts.email')

@if($solicitud->aceptada == 'SI')
    @section('titulo','LA SOLICITUD DE SERVICIO HA SIDO ACEPTADA')
@else
    @section('titulo','LA SOLICITUD DE SERVICIO NO PROCEDE')
@endif


@section('contenido')

<ul>
    <li>Aceptada: {{$solicitud->aceptada}}</li>
    <li>Fecha/Hora: {{$solicitud->fecha}}</li>
    <li>Usuario: {{$solicitud->usuario }} </li>
</ul>
<b>Motivo: {{$solicitud->asunto_solicitud}}</b> <br>
<b>Comentario: {{$solicitud->comentario}}</b> <br>
@endsection

@section('url', Request::root().'/solicitudes/'.$solicitud->id_solicitud.'/edit' )
@section('boton', 'VER SOLICITUD')