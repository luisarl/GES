@extends('layouts.master')

@section('titulo', 'Inventario')

@section('titulo_pagina', 'Inventario')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('dashboardcnth') }}">Control Herramientas</a></li>
    <li class="breadcrumb-item"><a href="#!">Inventario</a> </li>
</ul>
@endsection

@section('contenido')

    <div class="card">
        <div class="card-header">
            <h5>Listado de inventario</h5>
            <a class="btn btn-primary " title="Nuevo" data-toggle="modal" data-target="#modal-migracion" href="#">
                <i class="fa fa-download"></i>Exportar</a>
            <a class="btn btn-primary float-right" title="Nuevo" href="">
                <i class="fa fa-plus"></i> Nuevo</a> <!--fa fa-print-->
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="datatable" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Almacen</th>
                            <th>Herramienta</th>
                            <th>Codigo</th>
                            <th>Localizacion</th>
                            <th>Unidad</th>
                            <th>Existencia</th>
                            <th>Grupo</th>
                            <th>Sub Grupo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00054712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00780712</td>
                            <td>ZONA 7A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>0500402</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>13254002</td>
                            <td>ZONA 3B</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>07054712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>08054712</td>
                            <td>ZONA 4C</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>30054712</td>
                            <td>ZONA 3Z</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>01054712</td>
                            <td>ZONA 0A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00054724</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00032712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00454712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00084712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00034712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00014712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00054012</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>
                        <tr>
                            <td>Almacen Principal</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00004712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>ELECTRICA</td>
                        </tr>

                    </tbody>
                    <thead>
                        <tr>
                            <th>Almacen</th>
                            <th>Herramienta</th>
                            <th>Codigo</th>
                            <th>Localizacion</th>
                            <th>Unidad</th>
                            <th>Existencia</th>
                            <th>Grupo</th>
                            <th>Sub Grupo</th>
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

    <script>
        $('#modal-eliminar').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            var nombre = button.data('nombre') // Extrae la informacion de data-nombre

            action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            action += id; // se agrega el id seleccionado al formulario

            $('#formdelete').attr('action', action); //cambia la ruta del formulario

            var modal = $(this)
            modal.find('.modal-body h5').text('Desea Eliminar la Subclasificacion ' + nombre +
                ' ?') //cambia texto en el body del modal
        })
    </script>
    <!-- aqui empieza -->
@endsection
