@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte Solicitudes de Compra Asignadas por Comprador')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Solicitudes de Compra Asignadas por Comprador</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

@section('contenido')
<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>PARAMETROS DE BUSQUEDA</strong></h4>
    </div>
    <div class="card-block">
        <form method="GET" action="">
            {{-- @csrf --}}
            <div class="form-group row">
                <label class="col-sm-12 col-md-1 form-label">Fecha Inicio</label>
                <div class="col-sm-12 col-md-2 ">
                    <input type="date" name="fecha_inicio" min="" id=""
                        class="form-control @error('fecha_inicio') is-invalid @enderror"
                        value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '') }}">
                </div>
                <label class="col-sm-12 col-md-1 form-label">Fecha Fin</label>
                <div class="col-sm-12 col-md-2 ">
                    <input type="date" name="fecha_fin" min="" id=""
                        class="form-control @error('fecha_fin') is-invalid @enderror"
                        value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '')  }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-1">
                </div>
                <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-1 mb-1" OnClick="">
                         {{-- <i class="fa fa-search"></i>Buscar
                    </input> --}} 
                </div>

            </div>
            
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="table-responsive">    
                    <table class="table table-striped table-bordeles">
                        <thead>
                            <tr>
                                <th>COMPRADOR</th>
                                <th>ASIGNADO</th>
                                <th>ACUMULADO<br>AÑO</th>
                                <th>ACUMULADO<br>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($solicitudes as $solicitud)
                            <tr>
                                <td>{{$solicitud->Comprador}}</td>
                                <td>{{$solicitud->Asignados}}</td>
                                <td>{{$solicitud->AcumuladoAnio}}</td>
                                <td>{{$solicitud->AcumuladoTotal}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div id="grafico_solp_asignadas_comprador" style="width: 100%; height: 600px;"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- google chart -->
<script src="{{ asset('libraries\assets\pages\chart\google\js\google-loader.js') }}"></script>

<!-- personalizado -->
<script src="{{ asset('libraries\assets\js\CompReportes.js') }}"></script>

<script>

    var solicitudes = {!! json_encode($solicitudes) !!};

</script>

@endsection