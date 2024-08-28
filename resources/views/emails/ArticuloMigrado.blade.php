@extends('layouts.email')

@section('titulo','SE HA CREADO UN NUEVO ARTICULO EN PROFIT')

@section('contenido')
<ul>
    <li>Codigo: {{$articulo->codigo_articulo }} </li>
    <li>Nombre: {{$articulo->nombre_articulo }} </li>
    <li>Grupo: {{$articulo->nombre_grupo}} </li>
    <li>SubGrupo: {{$articulo->nombre_subgrupo}} </li>
    <li>Disponible en: <br>
        @foreach ($empresas as $empresa)
            <b>{{$empresa->nombre_empresa}}</b> <br>
        @endforeach
    </li>

    <li>Solicitado Por: {{$articulo->nombre_usuario_c }}</li>
    <li>Aprobado Por: {{$articulo->aprobado_por }}</li>
    <li>Catalogado Por: {{ $usuario }}</li>

</ul>
@endsection

@section('url', Request::root().'/articulos/'.$articulo->id_articulo )
@section('boton', 'VER FICHA TECNICA')