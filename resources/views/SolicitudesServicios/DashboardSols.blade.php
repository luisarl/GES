@extends('layouts.master')

@section('titulo', 'Dashboard Solicitudes')

@section('titulo_pagina', 'Dashboard Solicitudes de Servicio')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('solicitudes.index')}}">Solicitudes de Servicio</a> </li>
    <li class="breadcrumb-item"><a href="#!">Dashboard</a> </li>
</ul>
@endsection

@section('contenido')

<div class="row">
    <div class="col-md-3 col-xl-3">
        <div class="card user-widget-card bg-c-blue">
            <div class="card-block">
                <i class="icofont icofont-ui-clip-board bg-simple-c-blue card1-icon"></i>
                <h2>{{ $solicitudes }}</h2>
                <p>SOLICITUDES</p>
                <a href=" {{ route('solicitudes.index') }}" class="more-info">Ver Todos </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xl-3">
        <div class="card user-widget-card bg-c-green">
            <div class="card-block ">
                <i class="fa fa-users bg-simple-c-green card1-icon"></i>
                <h2>{{ $responsables }}</h2>
                <p>RESPONSABLES</p>
                <a href="{{ route('responsables.index') }}" class="more-info">Ver Todos </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3">
        <div class="card user-widget-card bg-c-pink">
            <div class="card-block">
                <i class="fa fa-th-large bg-simple-c-pink card1-icon"></i>
                <h2>{{ $servicios }}</h2>
                <p>SERVICIOS</p>
                <a href="{{ route('servicios.index') }}" class="more-info">Ver Todos </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xl-3">
        <div class="card user-widget-card bg-c-yellow">
            <div class="card-block ">
                <i class="fa fa-th bg-simple-c-yellow card1-icon"></i>
                <h2>{{ $subservicios }}</h2>
                <p>SUBSERVICIOS</p>
                <a href="{{ route('subservicios.index') }}" class="more-info">Ver Todos </a>
            </div>
        </div>
    </div>
</div>

<div class="card">

    <div class="card-block">
        <form method="GET" action="">
            <div class="form-group row" style="margin-bottom: 0px;">
                <label class="col-sm-12 col-md-1 form-label text-dark font-weight-bold">Filtro: </label>
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
                <div class="col-md-1">
                    <button type="submit" name="buscar" class="btn btn-primary" OnClick="">
                        <i class="fa fa-search"></i>Buscar
                    </button>
                </div>
                {{-- <div class="col-md-1">
                    <button type="submit" name="imprimir" class="btn btn-primary" value="imprimir">
                        <i class="fa fa-print"></i>Imprimir
                    </button>
                </div> --}}
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Solicitudes por Tipo Servicio</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-minus minimize-card"></i></li>
                <li><i class="feather icon-trash-2 close-card"></i></li>
            </ul>
        </div>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-5 col-lg-5">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>SERVICIO</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0)
                        @foreach($SolicitudesServicios as $servicio)
                        @php( $total += $servicio->cantidad)
                        <tr>
                            <td>{{$servicio->nombre_servicio}}</td>
                            <td>{{$servicio->cantidad}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>TOTAL</th>
                            <th>{{$total}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-7 col-lg-7">
                <div id="grafico_servicios" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>Solicitudes por Subservicios</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-minus minimize-card"></i></li>
                <li><i class="feather icon-trash-2 close-card"></i></li>
            </ul>
        </div>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-5 col-lg-5">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>SUBSERVICIO</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0)
                        @foreach($SolicitudesSubServicios as $subservicio)
                        @php( $total += $subservicio->cantidad)
                        <tr>
                            <td>{{$subservicio->nombre_subservicio}}</td>
                            <td>{{$subservicio->cantidad}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>TOTAL</th>
                            <th>{{$total}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-7 col-lg-7">
                <div id="grafico_subservicios" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Solicitudes por Departamento</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-minus minimize-card"></i></li>
                <li><i class="feather icon-trash-2 close-card"></i></li>
            </ul>
        </div>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-5 col-lg-5">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>DEPARTAMENTO</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0)
                        @foreach($SolicitudesDepartamentoSolicitante as $departamento)
                        @php($total += $departamento->cantidad)
                        <tr>
                            <td>{{$departamento->nombre_departamento}}</td>
                            <td>{{$departamento->cantidad}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>TOTAL</th>
                            <th>{{$total}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-7 col-lg-7">
                <div id="grafico_departamentos" style="width: 100%; height: 700px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>Solicitudes por Estatus</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-minus minimize-card"></i></li>
                <li><i class="feather icon-trash-2 close-card"></i></li>
            </ul>
        </div>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-5 col-lg-5">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>ESTATUS</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0)
                        @foreach($SolicitudesEstatus as $estatus)
                        @php($total += $estatus->cantidad)
                        <tr>
                            <td>{{$estatus->estatus}}</td>
                            <td>{{$estatus->cantidad}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>TOTAL</th>
                            <th>{{$total}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-7 col-lg-7">
                <div id="grafico_estatus" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Solicitudes por Responsable</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-minus minimize-card"></i></li>
                <li><i class="feather icon-trash-2 close-card"></i></li>
            </ul>
        </div>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-5 col-lg-5">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>RESPONSABLES</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($SolicitudesResponsable as $responsable)
                        <tr>
                            <td>{{$responsable->nombre_responsable}}</td>
                            <td>{{$responsable->cantidad}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-7 col-lg-7">
                <div id="grafico_responsable" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Solicitudes por Subservicios Detalle</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-minus minimize-card"></i></li>
                <li><i class="feather icon-trash-2 close-card"></i></li>
            </ul>
        </div>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-12 col-lg-12 table-responsive">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>SERVICIO</th>
                            <th>SUBSERVICIO</th>
                            <th>POR ACEPTAR</th>
                            <th>ABIERTO</th>
                            <th>NO PROCEDE</th>
                            <th>ANULADO</th>
                            <th>EN PROCESO</th>
                            <th>CERRADO</th>
                            <th>FINALIZADO</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0)
                        @foreach($SolicitudesSubServiciosDetalle as $subservicio)
                        @php($total += $subservicio->total)
                        <tr>
                            <td>{{$subservicio->nombre_servicio}}</td>
                            <td>{{$subservicio->nombre_subservicio}}</td>
                            <td>{{$subservicio->por_aceptar}}</td>
                            <td>{{$subservicio->abierto}}</td>
                            <td>{{$subservicio->no_procede}}</td>
                            <td>{{$subservicio->anulado}}</td>
                            <td>{{$subservicio->en_proceso}}</td>
                            <td>{{$subservicio->cerrado}}</td>
                            <td>{{$subservicio->finalizado}}</td>
                            <th>{{$subservicio->total}}</th>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="9">TOTAL</th>
                            <th>{{$total}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
        <div class="row">
            <div id="grafico_subservicios_detalle" style="width: 100%; height: 500px;"></div>
        </div> 
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Solicitudes por Departamento Detalle</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-minus minimize-card"></i></li>
                <li><i class="feather icon-trash-2 close-card"></i></li>
            </ul>
        </div>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-12 col-lg-12 table-responsive">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>DEPARTAMENTO</th>
                            <th>POR ACEPTAR</th>
                            <th>ABIERTO</th>
                            <th>NO PROCEDE</th>
                            <th>ANULADO</th>
                            <th>EN PROCESO</th>
                            <th>CERRADO</th>
                            <th>FINALIZADO</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0)
                        @foreach($SolicitudesDepartamentoSolicitanteDetalle as $departamento)
                        @php($total += $departamento->total)
                        <tr>

                            <td>{{$departamento->nombre_departamento}}</td>
                            <td>{{$departamento->por_aceptar}}</td>
                            <td>{{$departamento->abierto}}</td>
                            <td>{{$departamento->no_procede}}</td>
                            <td>{{$departamento->anulado}}</td>
                            <td>{{$departamento->en_proceso}}</td>
                            <td>{{$departamento->cerrado}}</td>
                            <td>{{$departamento->finalizado}}</td>
                            <th>{{$departamento->total}}</th>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="8">TOTAL</th>
                            <th>{{$total}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
        <div class="row">
            <div id="grafico_departamentos_detalle" style="width: 100%; height: 500px;"></div>
        </div> 
    </div>
</div>

@endsection

@section('scripts')
<!-- google chart -->
<script src="{{ asset('libraries\assets\pages\chart\google\js\google-loader.js') }}"></script>
<!-- personalizado -->
<script src="{{ asset('libraries\assets\js\SolsDashboard.js') }}"></script>

<script>

    var SolicitudesServicios = {!! json_encode($SolicitudesServicios) !!};
    var SolicitudesSubServicios = {!! json_encode($SolicitudesSubServicios) !!};
    var SolicitudesEstatus = {!! json_encode($SolicitudesEstatus) !!};
    var SolicitudesDepartamentos = {!! json_encode($SolicitudesDepartamentoSolicitante) !!};
    var SolicitudesResponsable = {!! json_encode($SolicitudesResponsable) !!};
    var SolicitudesSubServiciosDetalle = {!! json_encode($SolicitudesSubServiciosDetalle) !!};
    var SolicitudesDepartamentoSolicitanteDetalle = {!! json_encode($SolicitudesDepartamentoSolicitanteDetalle) !!}; 

</script>
@endsection