@extends('layouts.email')

@section('titulo','SE HA APROBADO UNA FICHA TECNICA')

@section('contenido')
<ul>
    <li>Nombre: {{$articulo->nombre_articulo }} </li>
    {{-- <li>Grupo:</li>
    <li>Sub Grupo</li> --}}
    <li>Creado Por: {{ $articulo->nombre_usuario_c }}</li>
    <li>Aprobado Por: {{ $usuario }}</li>
    
    <li>Migracion Solicitada a: <br>
        @foreach ($empresas as $empresa)
            <b>{{$empresa->nombre_empresa}}</b> <br>
        @endforeach
    </li>
</ul>
@endsection

@section('url', Request::root().'/articulos/'.$articulo->id_articulo.'/edit' )
@section('boton', 'VER FICHA TECNICA')