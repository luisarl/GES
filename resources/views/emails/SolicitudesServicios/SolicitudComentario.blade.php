@extends('layouts.email')

@section('titulo','SE HA AGREGADO UN COMENTARIO A LA SOLICITUD DE SERVICIO')

@section('contenido')

<ul>
    <li>Fecha/Hora: {{$solicitud->fecha}}</li>
    <li>Usuario: {{$solicitud->usuario }} </li>
</ul>
<b>Motivo: {{$solicitud->asunto_solicitud}}</b> <br>
<b>Comentario: {{$solicitud->comentario}}</b> <br>
@endsection

@section('url', Request::root().'/solicitudes/'.$solicitud->id_solicitud.'/edit' )
@section('boton', 'VER SOLICITUD')