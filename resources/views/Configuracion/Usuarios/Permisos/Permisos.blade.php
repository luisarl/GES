@extends('layouts.master')

@section('titulo', 'Permisos')

@section('titulo_pagina', 'Permisos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{!! url('/') !!}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Configuración</a> </li>
        <li class="breadcrumb-item"><a href="#!">Permisos de Usuarios</a> </li>
    </ul>
@endsection

@section('contenido')
    @include('mensajes.MsjExitoso')
    @include('mensajes.MsjError')
    <!-- Scroll - Vertical table end -->
    <!-- Scroll - Vertical, Dynamic Height table end -->
    <div class="card">
        <div class="card-header">
            <h5>Listado de Permisos</h5>
            @can('conf.permisos.crear')
                <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('permisos.create') !!}">
                    <i class="fa fa-plus"></i> Nuevo</a>
            @endcan
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="datatable" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre del permiso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permisos as $permiso)
                            <tr>
                                <td>{{ $permiso->id }}</td>
                                <td>{{ $permiso->name }}</td>
                                <td class="dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                            aria-hidden="true"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                        <a class="dropdown-item" data-toggle="modal"
                                            data-target="#modal-eliminar{{ $permiso->id }}" href="#!"><i
                                                class="fa fa-trash"></i>Borrar</a>
                                    </div>
                                    @include('Configuracion.Usuarios.Permisos.PermisosDestroy')
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nombre del permiso</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Scroll - Vertical, Dynamic Height table end -->
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
