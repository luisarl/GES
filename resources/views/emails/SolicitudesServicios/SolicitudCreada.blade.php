@extends('layouts.email')

@section('titulo','SE HA CREADO UNA SOLICITUD DE SERVICIO')

@section('contenido')

<ul>
    <li>Numero: {{$solicitud->id_solicitud}}</li>
    <li>Codigo: {{$solicitud->codigo_solicitud }} </li>
    <li>Fecha/Hora: {{$solicitud->fecha_creacion}}</li>
    <li>Solicitante: {{$solicitud->creado_por }} </li>
    <li>Departamento: {{$solicitud->nombre_departamento_solicitud }} </li>
    <li>Servicio: {{$solicitud->nombre_servicio}}</li>
    <li>Subservicio: {{$solicitud->nombre_subservicio}}</li>
</ul>
<b>Motivo: {{$solicitud->asunto_solicitud}}</b> <br>
<b>Comentario: {{$solicitud->descripcion_solicitud}}</b> <br>
@endsection

@section('url', Request::root().'/solicitudes/'.$solicitud->id_solicitud.'/edit' )
@section('boton', 'VER SOLICITUD')