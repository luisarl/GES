@extends('layouts.master')

@section('titulo', 'Despacho')

@section('titulo_pagina', 'Listado Estatus Despacho de Herramientas')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item"><a href="{{ url('/dashboardcnth') }}"> <i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="#!">Estatus Despacho</a> </li>
</ul>
@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>PARAMETROS DE BUSQUEDA</strong></h4>
        <form method="GET" action="">
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
            <label class="col-sm-6 col-md-1 form-label">Estatus</label>
            <div class="col-sm-6 col-md-2 ">
                <select name="estatus"
                    class="js-example-basic-single form-control @error('estatus') is-invalid @enderror">
                    <option value="TODOS" @if ('TODOS'==old('estatus', $_GET['estatus'] ?? '' )) selected="selected"
                        @endif>TODOS</option>
                    <option value="RECEPCION" @if ('RECEPCION'==old('estatus', $_GET['estatus'] ?? '' ))
                        selected="selected" @endif>RECEPCION</option>
                    <option value="DESPACHO" @if ('DESPACHO'==old('estatus', $_GET['estatus'] ?? ''
                        )) selected="selected" @endif>DESPACHO</option>
                    {{-- <option value="CERRADO" @if ('CERRADO'==old('estatus', $_GET['estatus'] ?? '' ))
                        selected="selected" @endif>CERRADO</option> --}}
                </select>
            </div>
            <label class="col-sm-12 col-md-1 form-label">Almacen</label>
                <div class="col-sm-6 col-md-2">
                    <select name="id_almacen" id="_almacenes" class="js-example-basic-single form-control @error('id_almacen') is-invalid @enderror">
                        <option value="0">Almacenes</option>
                        @foreach ($almacenes as $almacen)
                            <option value="{{ $almacen->id_almacen }}"
                                @if ($almacen->id_almacen == old('id_almacen',  $_GET['id_almacen'] ?? '')) selected="selected" @endif>
                                {!! $almacen->nombre_almacen !!}</option>
                        @endforeach
                    </select>
                </div>
        </div>

        <div class="form-group row">
                <div class="col-md-1">
                </div>
                <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-1 mb-1">
                         {{-- <i class="fa fa-search"></i>Buscar
                    </input> --}} 
                </div>
                @can('repo.cnth.listadoestatusdespacho.pdf')
                <div class="col-auto">
                    <input type="submit" value="Imprimir" name="pdf" class="btn btn-primary mt-1 mb-1">
                        {{-- <i class="fa fa-print"></i>Imprimir
                    </input> --}}
                </div>
                @endcan
                {{-- @can('repo.asal.listadosalidas.excel')
                <div class="col-auto">
                    <input type="submit" value="Exportar" name="excel" class="btn btn-primary mt-1 mb-1" OnClick="">
                        {{-- <i class="fa fa-file-excel-o"></i>Exportar
                    </input> 
                </div>
                @endcan --}}
            </div>
        </form>
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="despachos" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Almacen</th>
                        <th>Despachado Por</th>
                        <th>Recibido Por</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($EstatusDespacho != null)
                        @foreach ($EstatusDespacho as $EstatusDespachos)
                        <tr>
                            <td>{{$EstatusDespachos->id_movimiento}}</td>
                            <td>{{$EstatusDespachos->nombre_almacen}}</td>
                            <td>{{$EstatusDespachos->creado_por}}</td>
                            <td>{{$EstatusDespachos->responsable}}</td>
                            <td>{{$EstatusDespachos->estatus}}</td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- data-table js -->
    <script src="{{ asset('libraries\bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\data-table\js\jszip.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\data-table\js\pdfmake.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\data-table\js\vfs_fonts.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.print.min.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}">
    </script>
    <script
        src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
    </script>

    <!-- Custom js -->
    <script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>

    <!-- sweet alert js -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>
    
    <!-- Select -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
@endsection
