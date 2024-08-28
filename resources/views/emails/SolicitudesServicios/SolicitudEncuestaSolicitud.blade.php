@extends('layouts.email')

@section('titulo','SE HA CERRADO LA SOLICITUD DE SERVICIO')

@section('contenido')

<ul>
    <li>Fecha/Hora: {{$solicitud->fecha}}</li>
    <li>Usuario: {{$solicitud->usuario }} </li>
</ul>
<b>Motivo: {{$solicitud->asunto_solicitud}}</b> <br>
<b>Comentario: {{$solicitud->comentario}}</b> <br>
<br>
<b>Recuerde Llenar La Encuesta De Evaluacion De La Solicitud del Servicio.<b>
<a href="{{Request::root().'/solicitudes/encuestasolicitud/'.$solicitud->id_solicitud}}" style="color: #0073AA; text-align: center; text-decoration: none;">ACCEDER A ENCUESTA</a>

@endsection

@section('url', Request::root().'/solicitudes/'.$solicitud->id_solicitud.'/edit' )
@section('boton', 'VER SOLICITUD')