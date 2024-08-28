@extends('layouts.master')

@section('titulo', 'Salidas')

@section('titulo_pagina', 'Salidas')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item"><a href="{{ url('/dashboardcnth') }}"> <i class="feather icon-home"></i> </a></li>
        <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
        <li class="breadcrumb-item"><a href="#!">Salidas</a> </li>
    </ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Listado de Salidas</h5>
        @can('cnth.salidas.crear')
            <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('salidas.create') !!}">
                <i class="fa fa-plus"></i> Nuevo</a> <!--fa fa-print-->
        @endcan
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Almacen</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Fecha</th>       
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salidas as $salida)
                        <tr>
                            <td>{{$salida->id_salida}}</td>
                            <td>{{$salida->nombre_almacen}}</td>
                            <td>SALIDA</td>
                            <th>{{$salida->nombre_usuario}}</th>
                            <td>{{$salida->fecha}}</td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                        @can('cnth.salidas.ver')
                                            <a class="dropdown-item" href="{{ route('salidas.show', $salida->id_salida) }}"><i class="fa fa-eye"></i>Ver</a>
                                        @endcan
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                <tfoot>
                    <tr>
                        <th>Nº</th>
                        <th>Almacen</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Fecha</th>       
                        <th>Opciones</th>
                    </tr>
                </tfoot>
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
    <script src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
    </script>
    <!-- Custom js -->
    <script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>
    <!--Bootstrap Typeahead js -->
    <script src=" {{ asset('libraries\bower_components\bootstrap-typeahead\js\bootstrap-typeahead.min.js') }}" ></script>
    
    <!-- personalizado -->
    <script>
        var route = "{{ url('AutocompletarDespachoCreate') }}";
    </script>
    <script type="text/javascript" src="{{ asset('libraries\assets\js\entradas-salidas.js') }}"></script>
    
@endsection