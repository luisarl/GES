@extends('layouts.email')

@section('titulo','SE HA MODIFICADO UNA AUTORIZACION DE SALIDA')

@section('contenido')

<ul>
    <li>Correlativo: {{$salida->id_salida}}</li>
    <li>Almacen: {{$salida->nombre_almacen }} </li>
    <li>Solicitante: {{$salida->solicitante }} </li>
    <li>Responsable: {{$salida->responsable }} </li>

    @if($salida->tipo_vehiculo == 'INTERNO')
        <li>Vehiculo: {{$salida->vehiculo_interno}}</li>
    @else
        <li>Vehiculo: {{$salida->vehiculo_foraneo}}</li>
    @endif

    <li>Modificado Por: {{ $usuario }}</li>
</ul>

@endsection

@section('url', Request::root().'/autorizacionsalidas/'.$salida->id_salida.'/edit' )
@section('boton', 'VER SALIDA')