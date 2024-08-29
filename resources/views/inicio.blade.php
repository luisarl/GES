@extends('layouts.master')

@section('titulo', 'Inicio')

@section('titulo_pagina', $bienvenida.' '.ucwords(strtolower(Auth::user()->name)).', Bienvenid@ ' . config('app.name') )

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
    {{-- <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-primary">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-shopping-bag f-34 text-primary social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">Ficha Tecnica</h4>
                        <p>Articulos</p>
                        <h2 class="m-b-0">{{ $articulos }}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('articulos.index') }}" class="download-icon"><i class="fa fa-link"></i></a>
        </div>
    </div> --}}

    {{-- <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-success">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="icofont icofont-truck-loaded f-34 text-success social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">Salidas de Materiales</h4>
                        <p>Salidas</p>
                        <h2 class="m-b-0">{{ $salidas }}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('autorizacionsalidas.index') }}" class="download-icon"><i class="fa fa-link"></i></a>
        </div>
    </div> --}}

    <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-primary">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="icofont icofont-ui-clip-board f-34 text-primary social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">GESServicios</h4>
                        <p>Solicitudes</p>
                        <h2 class="m-b-0">{{ $solicitudes }}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('solicitudes.index') }}" class="download-icon"><i class="fa fa-link"></i></a>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-warning">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="icofont icofont-tools-alt-2 f-34 text-warning social-icon"></i>
                        {{-- <i class="icofont icofont-tools-alt-2 "></i> --}}
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">GESHerramientas</h4>
                        <p>Despachos</p>
                        <h2 class="m-b-0">{{ $despachos }}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('despachos.index') }}" class="download-icon"><i class="fa fa-link"></i></a>
        </div>
    </div>

    {{-- <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-danger">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-cart-arrow-down f-34 text-danger social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">Compras</h4>
                        <p>Proveedores</p>
                        <h2 class="m-b-0">{{ $proveedores }}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('proveedores.index') }}" class="download-icon"><i class="fa fa-link "></i></a>
        </div>
    </div> --}}

    <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-info">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-archive f-34 text-info social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">GESActivos</h4>
                        <p>Activos</p>
                        <h2 class="m-b-0">{{ $activos }}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('activos.index') }}" class="download-icon"><i class="fa fa-link"></i></a>
        </div>
    </div>

    {{-- <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-success">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-briefcase f-34 text-success social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">Resguardo</h4>
                        <p>Resguardos</p>
                        <h2 class="m-b-0">{{ $resguardos }}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('resgresguardos.index') }}" class="download-icon"><i class="fa fa-link"></i></a>
        </div>
    </div> --}}


    {{-- <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-info">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-object-ungroup f-34 text-primary social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">Centro de Corte</h4>
                        <p>Conap</p>
                        <h2 class="m-b-0">{{$conaps}}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('cencconap.index') }}" class="download-icon"><i class="fa fa-link"></i></a>
        </div>
    </div> --}}

    {{-- <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-warning">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="icofont icofont-document-search f-34 text-warning social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">Auditoria</h4>
                        <p>Auditoria Inventario</p>
                        <h2 class="m-b-0">{{ $auditoria }}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('audiauditoriainventario.index') }}" class="download-icon"><i class="fa fa-link"></i></a>
        </div>
    </div> --}}

    <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-success">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-calendar-check-o f-34 text-success social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">GesAsistencia</h4>
                        <p>Validaciones</p>
                        <h2 class="m-b-0">{{$asistencias}}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('gstaasistenciasvalidaciones.create') }}" class="download-icon"><i class="fa fa-link "></i></a>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-danger">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="zmdi zmdi-local-gas-station f-34 text-danger social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">GESCombustible</h4>
                        <p>Despachos</p>
                        <h2 class="m-b-0">{{$despachoscombustible}}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('cntcdespachos.index') }}" class="download-icon"><i class="fa fa-link "></i></a>
        </div>
    </div>

    {{-- <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-success">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="zmdi zmdi-print f-34 text-success social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">Control Toner</h4>
                        <p>Reemplazos</p>
                        <h2 class="m-b-0">{{$reemplazos}}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('cnttcontroltoner.index') }}" class="download-icon"><i class="fa fa-link "></i></a>
        </div>
    </div> --}}

    {{-- <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-info">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="zmdi zmdi-boat f-34 text-primary social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">Embarcaciones</h4>
                        <p>Embarcaciones</p>
                        <h2 class="m-b-0">{{$embarcaciones}}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('embaembarcaciones.index') }}" class="download-icon"><i class="fa fa-link"></i></a>
        </div>
    </div> --}}

    <div class="col-xl-4 col-md-6">
        <div class="card social-card bg-inverse">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-gear f-34 text-inverse social-icon"></i>
                    </div>
                    <div class="col">
                        <h4 class="m-b-0">Configuracion</h4>
                        <p>Usuarios</p>
                        <h2 class="m-b-0">{{ $usuarios }}</h2>
                    </div>
                </div>
            </div>
            <a href="{{ route('usuarios.index') }}" class="download-icon"><i class="fa fa-link"></i></a>
        </div>
    </div>
</div>



@endsection