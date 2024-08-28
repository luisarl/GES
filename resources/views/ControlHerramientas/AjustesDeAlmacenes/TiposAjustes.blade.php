@extends('layouts.master')

@section('titulo', 'Tipo de Ajuste')

@section('titulo_pagina', 'Tipo de Ajuste')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="#!">Tipo de Ajustes</a> </li>
</ul>
@endsection

@section('contenido')

    <div class="card">
        <div class="card-header">
            <h5>Lista</h5>

                <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('tiposajustes.create') !!}">
                    <i class="fa fa-plus"></i> Nuevo</a> <!--fa fa-print-->
   
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="datatable" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <th>DESCRIPCION</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>IN</td>
                            <td>Ajustes de inventario negativos</td>
                            <td>
                                movimiento interno, que permite el registro de todos los ajustes<p> 
                                de inventario cuya cantidad artículos contados sea 
                                inferior a la cantidad registrada en el almacén correspondiente
                            </td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                 <a class="dropdown-item" href=""><i class="fa fa-edit"></i>Editar</a>
                                 <a class="dropdown-item" data-id="" data-nombre="" data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    
                    <tbody>
                        <tr>
                            <td>IP</td>
                            <td>Ajustes de inventario positivos</td>
                            <td>
                                movimiento interno, que permite el registro de todos los ajustes <p>
                                de inventario cuya cantidad de artículos contados sea superior a la cantidad registrada en el almacén correspondiente;
                            </td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                 <a class="dropdown-item" href=""><i class="fa fa-edit"></i>Editar</a>
                                 <a class="dropdown-item" data-id="" data-nombre="" data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                </div>
                            </td>
                        </tr>
                    </tbody> 
                    <tbody>
                        <tr>
                            <td>IV</td>
                            <td>Ajustes de inventario en valor</td>
                            <td>
                                Permite realizar ajustes a la valoración de los artículos
                            </td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                 <a class="dropdown-item" href=""><i class="fa fa-edit"></i>Editar</a>
                                 <a class="dropdown-item" data-id="" data-nombre="" data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td>IC</td>
                            <td>Ajustes de inventario en cantidad</td>
                            <td>
                                Permite realizar ajustes a la cantidad de los artículos en stock debido a factores externos (p.ej., robo)<p>
                                     y recuento de inventario.
                            </td>
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
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <th>DESCRIPCION</th>
                            <th>ACCIONES</th>
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
