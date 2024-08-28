@extends('layouts.master')

@section('titulo', 'Dashboard')

@section('titulo_pagina', 'Dashboard Ficha Tecnica')

{{-- @section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">s
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Almacenes</a> </li>
    </ul>
@endsection --}}

@section('contenido')

    <div class="row">
        <div class="col-md-3 col-xl-3">
            <div class="card user-widget-card bg-c-blue">
                <div class="card-block">
                    <i class="fa fa-shopping-bag bg-simple-c-blue card1-icon"></i>
                    <h2>{{ $articulos }}</h2>
                    <p>ARTICULOS</p>
                    <a href=" {{ route('articulos.index') }}" class="more-info">Ver Todos </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card user-widget-card bg-c-green">
                <div class="card-block ">
                    <i class="fa fa-building-o bg-simple-c-green card1-icon"></i>
                    <h2>{{ $almacenes }}</h2>
                    <p>ALMACENES</p>
                    <a href="{{ route('almacenes.index') }}" class="more-info">Ver Todos </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card user-widget-card bg-c-pink">
                <div class="card-block">
                    <i class="fa fa-th-large bg-simple-c-pink card1-icon"></i>
                    <h2>{{ $grupos }}</h2>
                    <p>GRUPOS</p>
                    <a href="{{ route('grupos.index') }}" class="more-info">Ver Todos </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card user-widget-card bg-c-yellow">
                <div class="card-block ">
                    <i class="fa fa-th bg-simple-c-yellow card1-icon"></i>
                    <h2>{{ $subgrupos }}</h2>
                    <p>SUBGRUPOS</p>
                    <a href="{{ route('subgrupos.index') }}" class="more-info">Ver Todos </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ticket and update start -->
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <h5>ARTICULOS RECIENTES</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            {{-- <li><i class="fa fa fa-wrench open-card-option"></i></li> --}}
                            {{-- <li><i class="fa fa-window-maximize full-card"></i></li> --}}
                            <li><i class="fa fa-minus minimize-card"></i></li>
                            {{-- <li><i class="fa fa-refresh reload-card"></i></li> --}}
                            {{-- <li><i class="fa fa-trash close-card"></i></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Creado por</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($UltimosArticulos as $articulo)
                                <tr>
                                    <td>{{$articulo->codigo_articulo}}</td>
                                    <td><a href="{{ route('articulos.edit', $articulo->id_articulo) }}"> {{$articulo->nombre_articulo}} </a></td>
                                    <td>{{$articulo->nombre_usuario_c}}</td>
                                    <td>
                                        @if ($articulo->estatus == 'MIGRADO')
                                            <label class="label label-primary">{{$articulo->estatus}}</label>
                                        @elseif($articulo->estatus == 'NO MIGRADO')
                                            <label class="label label-warning">{{$articulo->estatus}}</label>
                                        @elseif($articulo->estatus == 'MIGRACION PENDIENTE')
                                            <label class="label label-danger">{{$articulo->estatus}}</label>
                                            @elseif($articulo->estatus == 'APROBACION PENDIENTE')
                                            <label class="label label-warning">{{$articulo->estatus}}</label>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="text-right m-r-20">
                            <a href="{{route('articulos.index') }}" class=" b-b-primary text-primary">Ver Todos los Articulos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
