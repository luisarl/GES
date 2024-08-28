@extends('layouts.email')

@section('titulo','SE REALIZO LA EVALUACION DEL SERVICIO')

@section('contenido')

<ul>
    <li>Fecha/Hora: {{$solicitud->fecha}}</li>
    <li>Usuario: {{$solicitud->usuario }} </li>
</ul>
{{-- <b>Asunto: {{$solicitud->asunto_solicitud}}</b> <br> --}}
{{-- <b>Comentario: {{$solicitud->comentario}}</b> <br> --}}
@endsection

@section('url', Request::root().'/solicitudes/'.$solicitud->id_solicitud)
@section('boton', 'VER SOLICITUD')