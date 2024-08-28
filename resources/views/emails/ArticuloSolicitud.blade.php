@extends('layouts.email')

@section('titulo','SOLICITUD DE MIGRACION DE ARTICULO A PROFIT')

@section('contenido')
{{-- <h4> {{ Auth::user()->name }} Solicito la Migracion del Articulo</h4> --}}

<ul>
    <li>Codigo: {{$articulo->codigo_articulo }} </li>
    <li>Nombre: {{$articulo->nombre_articulo }} </li>
    <li>Grupo: {{$articulo->nombre_grupo}} </li>
    <li>SubGrupo: {{$articulo->nombre_subgrupo}} </li>
    <li>Migracion Solicitada a: <br>
        @foreach ($empresas as $empresa)
            <b>{{$empresa->nombre_empresa}}</b> <br>
        @endforeach
    </li>

    <li>Solicitado Por: {{ $usuario}}</li>
    
</ul>
@endsection

@section('url', Request::root().'/articulos/'.$articulo->id_articulo.'/edit' )
@section('boton', 'VER FICHA TECNICA')