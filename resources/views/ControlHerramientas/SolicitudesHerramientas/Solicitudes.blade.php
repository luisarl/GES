@extends('layouts.master')

@section('titulo', 'Solicitudes')

@section('titulo_pagina', 'Solicitudes')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="#!">Solicitudes</a> </li>
</ul>
@endsection

@section('contenido')

    <div class="card">
        <div class="card-header">
            <h5>Listado de Solicitudes</h5>
            <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('solicitudes.create') !!}">
                <i class="fa fa-plus"></i> Nuevo</a> <!--fa fa-print-->
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="datatable" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Numero Solicitud</th>
                            <th>Almacen</th>
                            <th>Responsable</th>
                            <th>Fecha Solicitud</th>
                            <th>Estatus</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>102</td>
                            <td>Almacen Principal</td>
                            <td>Luis Mejias</td>
                            <td>25/01/2022</td>
                            <td><label class="label label-warning">ABIERTO</label></td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                 <a class="dropdown-item" href=""><i class="fa fa-edit"></i>Editar</a>
                                 <a class="dropdown-item" data-id="" data-nombre="" data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>104</td>
                            <td>Mantenimiento</td>
                            <td>Jose Alfonzo</td>
                            <td>25/01/2022</td>
                            <td><label class="label label-primary">CERRADO</label></td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                 <a class="dropdown-item" href=""><i class="fa fa-edit"></i>Editar</a>
                                 <a class="dropdown-item" data-id="" data-nombre="" data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>102</td>
                            <td>Paramaconi</td>
                            <td>Patricia Rojas</td>
                            <td>25/01/2022</td>
                            <td><label class="label label-primary">CERRADO</label></td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                 <a class="dropdown-item" href=""><i class="fa fa-edit"></i>Editar</a>
                                 <a class="dropdown-item" data-id="" data-nombre="" data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>102</td>
                            <td>Almacen Principal</td>
                            <td>Luis Mejias</td>
                            <td>25/01/2022</td>
                            <td><label class="label label-warning">ABIERTO</label></td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                 <a class="dropdown-item" href=""><i class="fa fa-edit"></i>Editar</a>
                                 <a class="dropdown-item" data-id="" data-nombre="" data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th>Numero Solicitud</th>
                            <th>Almacen</th>
                            <th>Responsable</th>
                            <th>Fecha Solicitud</th>
                            <th>Estatus</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
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
@endsection
