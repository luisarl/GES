@extends('layouts.email')

@section('titulo','SE HA MODIFICADO UNA FICHA TECNICA')

@section('contenido')
<ul>
    <li>Nombre: {{$articulo->nombre_articulo }} </li>
    {{-- <li>Grupo:</li>
    <li>Sub Grupo</li> --}}
    <li>Modificado Por: {{$usuario}}</li>
</ul>
@endsection

@section('url', Request::root().'/articulos/'.$articulo->id_articulo.'/edit' )
@section('boton', 'VER FICHA TECNICA')