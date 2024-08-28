@extends('layouts.master')

@section('titulo', 'Dashboard Herramientas')

@section('titulo_pagina', 'Dashboard Control de Herramientas')

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
                    <i class="fa fa-wrench bg-simple-c-blue card1-icon"></i>
                    <h2>{{ $herramientas }}</h2>
                    <p>HERRAMIENTAS</p>
                    <a href=" {{ route('herramientas.index') }}" class="more-info">Ver Todos </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card user-widget-card bg-c-yellow">
                <div class="card-block ">
                    <i class="icofont icofont-upload-alt bg-simple-c-yellow card1-icon"></i>
                    <h2>{{ $despachos }}</h2>
                    <p>DESPACHOS</p>
                    <a href="{{ route('despachos.index') }}" class="more-info">Ver Todos </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card user-widget-card bg-c-green">
                <div class="card-block">
                    <i class="icofont icofont-download-alt bg-simple-c-green card1-icon"></i>
                    <h2>{{ $recepciones }}</h2>
                    <p>RECEPCIONES</p>
                    <a href="{{ route('despachos.index') }}" class="more-info">Ver Todos </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card user-widget-card bg-c-pink">
                <div class="card-block ">
                    <i class="fa fa-warning bg-simple-c-pink card1-icon"></i>
                    <h2>{{ $CantidadHerramientasPendientes }}</h2>
                    <p>HERRAMIENTAS SIN RECEPCIÓN</p>
                    <a href="#" class="more-info">Ver Todos </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ticket and update start -->
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <h5>HERRAMIENTAS CON RECEPCIÓN PENDIENTE</h5>
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
                                    <th>Movimiento</th>
                                    <th>Almacen</th>
                                    <th>Herramienta</th>
                                    <th>Responsable</th>
                                    <th>Cantidad Entregada</th>
                                    <th>Cantidad Recepción</th>
                                    <th>Cantidad Pendiente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($HerramientasPendientes as $herramienta)
                                    <tr>
                                        <td><a href="{{ route('recepcion', $herramienta->id_movimiento) }}">{{$herramienta->id_movimiento}} </a></td>
                                        <td>{{$herramienta->nombre_almacen}}</td>
                                        <td> 
                                            @php
                                            $texto = $herramienta->nombre_herramienta;
                                            $NombreHerramienta = wordwrap($texto, 40, "<br>", false);
                                            @endphp
                                            {!!$NombreHerramienta!!}
                                        </td>
                                        <td>{{$herramienta->responsable}}</td>
                                        <td>{{$herramienta->cantidad_entregada}}</td>
                                        <td>{{$herramienta->cantidad_devuelta}}</td>
                                        <td><strong>{{$herramienta->cantidad_pendiente}}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <div class="text-right m-r-20">
                            <a href="{{route('articulos.index') }}" class=" b-b-primary text-primary">Ver Todos los Articulos</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection