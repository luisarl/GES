@extends('layouts.master')

@section('titulo', 'Ubicaciones')

@section('titulo_pagina', 'Ubicaciones')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Resguardo</a> </li>
        <li class="breadcrumb-item"><a href="#!">Ubicaciones</a> </li>
    </ul>
@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('Resguardo.Ubicaciones.UbicacionesDestroy')

    <!-- Scroll - Vertical table end -->
    <!-- Scroll - Vertical, Dynamic Height table start -->
    <div class="card">
        <div class="card-header">
            <h5>Listado de Ubicaciones</h5>
            @can('resg.ubicaciones.crear')
                <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('resgubicaciones.create') !!}">
                    <i class="fa fa-plus"></i> Nuevo</a>
            @endcan
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="datatable" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th>Nombre</th>
                            <th>Almacen</th>
                            <th style="width: 10%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ubicaciones as $ubicacion)
                        <tr>
                            <td>{{$ubicacion->id_ubicacion}}</td>
                            <td>{{$ubicacion->nombre_ubicacion}}</td>
                            <td>{{$ubicacion->nombre_almacen}}</td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                    @can('resg.ubicaciones.editar')
                                        <a class="dropdown-item" href=" {{ route('resgubicaciones.edit', $ubicacion->id_ubicacion) }}"><i class="fa fa-edit"></i>Editar</a>
                                    @endcan 
                                    @can('resg.ubicaciones.eliminar')
                                        <a class="dropdown-item" data-id="{{ $ubicacion->id_ubicacion }}" data-nombre="{{ $ubicacion->nombre_ubicacion }}"  data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Almacen</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- Scroll - Vertical, Dynamic Height table end -->
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

    <script>
        $('#modal-eliminar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            var nombre = button.data('nombre') // Extrae la informacion de data-nombre

            action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            action += id; // se agrega el id seleccionado al formulario

            $('#formdelete').attr('action', action); //cambia la ruta del formulario

            var modal = $(this)
            modal.find('.modal-body h5').text('Desea Eliminar La Ubicacion ' + nombre + ' ?') //cambia texto en el body del modal
        })
    </script>

@endsection
