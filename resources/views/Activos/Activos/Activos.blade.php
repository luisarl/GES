@extends('layouts.master')

@section('titulo', 'Activos')

@section('titulo_pagina', 'Activos')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Activos</a> </li>
</ul>
@endsection

@section('contenido')
<!-- Scroll - Vertical table end -->
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('Activos.Activos.ActivosDestroy')

<!-- Scroll - Vertical table end -->
<!-- Scroll - Vertical, Dynamic Height table start -->
<div class="card">
    <div class="card-header">
        <h5>Listado de Activos</h5>
        @can('actv.activos.crear')
            <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('activos.create') !!}">
                <i class="fa fa-plus"></i> Nuevo</a>
        @endcan
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Marca</th>
                        <th>departamento</th>
                        <th>Ubicacion</th>
                        <th>Tipo</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activos as $activo)
                    <tr>
                        <td>{{$activo->id_activo}}</td>
                        <td>{{$activo->nombre_activo}}</td>
                        <td>{{$activo->codigo_activo}}</td>
                        <td>{{$activo->marca}}</td>
                        <td>{{$activo->nombre_departamento}}</td>
                        <td>{{$activo->ubicacion}}</td>
                        <td>{{$activo->nombre_tipo}}</td>
                        <td>
                            @if($activo->estatus == 'ACTIVO')
                                <label class="label label-success">ACTIVO</label>
                            @elseif($activo->estatus == 'INACTIVO')
                                <label class="label label-warning">INACTIVO</label>
                            @elseif($activo->estatus == 'DESINCORPORADO')
                                <label class="label label-danger">DESINCORPORADO</label>
                            @elseif($activo->estatus == 'RESGUARDADO')
                                <label class="label label-primary">RESGUARDADO</label>  
                            @endif
                        </td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @can('actv.activos.editar')
                                    <a class="dropdown-item" href=" {{ route('activos.edit', $activo->id_activo) }}"><i class="fa fa-edit"></i>Editar</a>
                                @endcan
                                @can('actv.activos.eliminar')
                                    <a class="dropdown-item" data-id="{{ $activo->id_activo }}" data-nombre="{{ $activo->nombre_activo }}"  data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Serial</th>
                        <th>Marca</th>
                        <th>departamento</th>
                        <th>Ubicacion</th>
                        <th>Tipo</th>
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
            modal.find('.modal-body h5').text('Desea Eliminar la Activos ' + nombre + ' ?') //cambia texto en el body del modal
        })
    </script>

@endsection