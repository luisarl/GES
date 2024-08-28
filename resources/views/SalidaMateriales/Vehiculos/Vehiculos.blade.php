@extends('layouts.master')

@section('titulo', 'Vehiculos')

@section('titulo_pagina', 'Vehiculos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ url('autorizacionsalidas') }}">Autorización de Salida</a> </li>
        <li class="breadcrumb-item"><a href="#!">Vehiculos</a> </li>
    </ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('SalidaMateriales.Vehiculos.VehiculosDestroy')

<div class="card">
    <div class="card-header">
        <h5>Listado de Vehiculos</h5>
        @can('asal.vehiculos.crear')
        <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('vehiculos.create') !!}">
            <i class="fa fa-plus"></i> Nuevo</a> <!--fa fa-print-->
        @endcan
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Marca</th>
                        <th>Placa</th>
                        <th>Modelo</th>       
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach ($vehiculos as $vehiculo)
                        <tr>
                            <td>{{$vehiculo->id_vehiculo}}</td>
                            <td>{{$vehiculo->marca_vehiculo}}</td>
                            <td>{{$vehiculo->placa_vehiculo}}</td>
                            <td>{{$vehiculo->modelo_vehiculo}}</td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                        @can('asal.vehiculos.editar')
                                        <a class="dropdown-item" href="{{ route('vehiculos.edit', $vehiculo->id_vehiculo) }}"><i class="fa fa-edit"></i>Editar</a>
                                        @endcan
                                        @can('asal.vehiculos.eliminar')
                                        <a class="dropdown-item" data-id="{{ $vehiculo->id_vehiculo }}" data-nombre="{{ $vehiculo->marca_vehiculo }}" data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                        @endcan
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                <tfoot>
                    <tr>
                        <th>Nº</th>
                        <th>Marca</th>
                        <th>Placa</th>
                        <th>Modelo</th>       
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

    <script type="text/javascript" src="{{ asset('libraries\assets\js\entradas-salidas.js') }}"></script>

    <script>
        $('#modal-eliminar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            var nombre = button.data('nombre') // Extrae la informacion de data-nombre

            action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            action += id; // se agrega el id seleccionado al formulario

            $('#formdelete').attr('action', action); //cambia la ruta del formulario

            var modal = $(this)
            modal.find('.modal-body h5').text('Desea Eliminar el vehiculo ' + nombre + ' ?') //cambia texto en el body del modal
        })
    </script>

    
@endsection