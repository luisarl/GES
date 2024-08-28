@extends('layouts.master')

@section('titulo', 'Dashboard Gestion Asistencia')

@section('titulo_pagina', 'Dashboard Gestion Asistencia')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('gstadashboard')}}">Gestion de Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="#!">Dashboard</a> </li>
</ul>
@endsection

@section('contenido')

{{-- <div class="row">
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
</div> --}}

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
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>Cantidad de Empleados por Departamentos</h5>
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
                        @foreach($empleados as $empleado)
                        @php( $total += $empleado->cantidad)
                        <tr>
                            <td>{{$empleado->des_depart}}</td>
                            <td>{{$empleado->cantidad}}</td>
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
                <div id="grafico_empleados" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Ausencias por Departamentos</h5>
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
                        @foreach($ausencias as $ausencia)
                        @php( $total += $ausencia->cantidad)
                        <tr>
                            <td>{{$ausencia->des_depart}}</td>
                            <td>{{$ausencia->cantidad}}</td>
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
                <div id="grafico_ausencias" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Llegadas Tardias Por Departamentos</h5>
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
                        @foreach($retardos as $retardo)
                        @php( $total += $retardo->cantidad)
                        <tr>
                            <td>{{$retardo->des_depart}}</td>
                            <td>{{$retardo->cantidad}}</td>
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
                <div id="grafico_retardos" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-block">
         <form method="GET" action="">
                <div class="form-group row" style="margin-bottom: 0px;">
                    <label class="col-sm-12 col-md-1 form-label text-dark font-weight-bold">Filtro: </label>
                    <input type="hidden" name="fecha_inicio" value="{{ $FechaInicio }}">
                    <input type="hidden" name="fecha_fin" value="{{ $FechaFin }}">
                    <label for="departamento" class="col-sm-10 col-md-2 form-label">Departamentos</label>
                    <div class=" @error('departamento') is-invalid @enderror">
                        <select name="departamento" class="js-example-basic-single form-control">
                            <option value="">Seleccione un departamento</option>
                            @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento }}" @if ($departamento->id_departamento == old('departamento', $_GET['departamento'] ?? '' )) selected="selected" @endif>
                              {{ $departamento->nombre_departamento }}
                            </option>
                            @endforeach
                          </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" name="buscarempleado" class="btn btn-primary" OnClick="">
                            <i class="fa fa-search"></i>Buscar
                        </button>
                    </div>
                </div>
            </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>Ausencias Por Empleados</h5>
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
                            <th>EMPLEADO</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0)
                        @foreach($ausenciasempleados as $ausenciasempleado)
                        @php( $total += $ausenciasempleado->cantidad)
                        <tr>
                          
                            <td>{{$ausenciasempleado->nombre_empleado}}</td>
                            <td>{{$ausenciasempleado->cantidad}}</td>
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
                <div id="grafico_ausencia_empleado" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Llegadas Tardias Por Empleados</h5>
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
                            <th>EMPLEADO</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($total = 0)
                        @foreach($retardosempleados as $retardosempleado)
                        @php( $total += $retardosempleado->cantidad)
                        <tr>
                          
                            <td>{{$retardosempleado->nombre_empleado}}</td>
                            <td>{{$retardosempleado->cantidad}}</td>
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
                <div id="grafico_retardos_empleado" style="width: 100%; height: 500px;"></div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
<!-- google chart -->
<script src="{{ asset('libraries\assets\pages\chart\google\js\google-loader.js') }}"></script>
<!-- personalizado -->

<script src="{{ asset('libraries\assets\js\GstaDashboard.js') }}"></script>
<script>

 var empleados = {!! json_encode($empleados) !!};
 var ausencias = {!! json_encode($ausencias) !!};
 var retardos = {!! json_encode($retardos) !!};
 var ausenciasempleados = {!! json_encode($ausenciasempleados) !!};
 var retardosempleados = {!! json_encode( $retardosempleados) !!};
</script>
@endsection