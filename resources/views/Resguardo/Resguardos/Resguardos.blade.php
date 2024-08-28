@extends('layouts.master')

@section('titulo', 'Resguardo de Articulos')

@section('titulo_pagina', 'Resguardo de Articulos')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Resguardo</a> </li>
</ul>
@endsection

@section('contenido')
<!-- Scroll - Vertical table end -->
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')


<!-- Scroll - Vertical table end -->
<!-- Scroll - Vertical, Dynamic Height table start -->
<div class="card">
    <div class="card-header">
        <h5>Listado de Resguardo de Articulos</h5>
        {{-- @can('resg.resguardos.crear')
            <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('resgresguardos.create') !!}">
                <i class="fa fa-plus"></i> Nuevo</a>
        @endcan  --}}
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Almacen</th>
                        <th>Departamento</th>
                        <th>Id Solc.</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Presentacion</th>
                        <th>Cantidad</th>
                        <th>Disp. Final</th>
                        <th>Estatus</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $articulo)
                    <tr>
                        <td>{{$articulo->id_resguardo}}</td>
                        <td>{{$articulo->nombre_almacen}}</td>
                        <td>{{$articulo->nombre_departamento}}</td>
                        <td>{{$articulo->id_solicitud_resguardo}}</td>
                        <td>{{$articulo->codigo_articulo}}</td>
                        <td>{!! wordwrap($articulo->nombre_articulo, 30, "<br>" ) !!}</td>
                        <td>{{ number_format($articulo->equivalencia_unidad, 2).' '.$articulo->tipo_unidad}}</td>
                        <td>{{$articulo->cantidad_disponible}}</td>
                        <td>{{$articulo->nombre_clasificacion}}</td>
                        <td>
                            @if($articulo->estatus == 'POR PROCESAR')
                                <label class="label label-info">POR PROCESAR</label>
                            @elseif($articulo->estatus == 'DISPONIBLE')
                                <label class="label label-success">DISPONIBLE</label>
                            @elseif($articulo->estatus == 'DESINCORPORADO')
                                <label class="label label-danger">DESINCORPORADO</label>
                            @elseif($articulo->estatus ='DESPACHADO')
                                <label class="label label-primary">DESPACHADO</label>  
                            @endif
                        </td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @can('resg.resguardos.ver')
                                    <a class="dropdown-item" href=" {{ route('resgresguardos.show', $articulo->id_resguardo) }}"><i class="fa fa-eye"></i>Ver</a>
                                @endcan
                                @can('resg.resguardos.editar')
                                    <a class="dropdown-item" href=" {{ route('resgresguardos.edit', $articulo->id_resguardo) }}"><i class="fa fa-edit"></i>Editar</a>
                                @endcan

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Almacen</th>
                        <th>Departamento</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Presentacion</th>
                        <th>Cantidad</th>
                        <th>Ubicacion</th>
                        <th>Disp. Final</th>
                        <th>Estatus</th>
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