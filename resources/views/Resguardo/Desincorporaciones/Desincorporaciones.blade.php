@extends('layouts.master')

@section('titulo', 'Solicitudes de Desincorporaciones')

@section('titulo_pagina', 'Solicitudes de Desincorporaciones')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Resguardo</a> </li>
    <li class="breadcrumb-item"><a href="#!">Desincorporaciones</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('Resguardo.Despachos.DespachosDestroy')

<div class="card">
    <div class="card-header">
        <h5>Listado de Solicitudes</h5>
        @can('resg.soldesincorporacion.crear')
        <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('resgdesincorporaciones.create') !!}">
            <i class="fa fa-plus"></i> Nuevo</a>
        @endcan
    </div>
    <div class="card-block">
            <div class="form-inline float-right">
                <label class="form-label" for="id_salida">Buscar Por Numero: </label>
                <input type="text" name="id_salida" id="id-filtro" class="form-control input-sm ml-1 mb-1">
            </div>

        <div class="dt-responsive table-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap" style="width: 100%">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Fecha</th>
                        <th>Solicitante</th>
                        <th>Almacen</th>
                        <th>Estatus</th>
                        <th>Opciones</th>
                        {{-- <th style='visibility:collapse; display:none;'>Articulos </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudes as $solicitud)
                    <tr>
                        <td>{{$solicitud->id_solicitud_desincorporacion   }}</td>
                        <td>{{$solicitud->fecha_creacion}}</td>
                        <td>{{$solicitud->creado_por}}</td>
                        <td>{{$solicitud->nombre_almacen}}</td>
                        <td>
                            @if($solicitud->estatus == 'POR APROBACION')
                            <label class="label label-info">POR APROBACION</label>
                            @elseif($solicitud->estatus == 'APROBADO')
                                <label class="label label-warning">APROBADO</label>
                            @elseif($solicitud->estatus == 'PROCESADO')
                                <label class="label label-success">PROCESADO</label>
                            @elseif($solicitud->estatus == 'ANULADO')
                                <label class="label label-danger">ANULADO</label>
                            @else
                                {{$solicitud->estatus}}
                            @endif
                        </td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                    aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @can('resg.soldesincorporacion.ver')
                                    <a class="dropdown-item" href="{{ route('resgdesincorporaciones.show', $solicitud->id_solicitud_desincorporacion) }}">
                                    <i class="fa fa-eye"></i>Ver</a>
                                @endcan
                               
                                @if ($solicitud->estatus != 'ANULADO')
                                @can('resg.soldesincorporacion.editar')
                                <a class="dropdown-item"
                                    href="{{ route('resgdesincorporaciones.edit',$solicitud->id_solicitud_desincorporacion) }}">
                                    <i class="fa fa-edit"></i>Editar</a>
                                @endcan
                                @endif
                                @if ($solicitud->estatus == 'POR APROBACION' || $solicitud->estatus == 'APROBADO')
                                @can('resg.soldesincorporacion.eliminar')
                                <a class="dropdown-item" data-id="{{ $solicitud->id_solicitud_desincorporacion}}"
                                    data-nombre="{{ $solicitud->id_solicitud_desincorporacion }}" data-toggle="modal"
                                    data-target="#modal-eliminar" href="#!">
                                    <i class="fa fa-ban"></i>Anular</a>
                                @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nº</th>
                        <th>Fecha</th>
                        <th>Solicitante</th>
                        <th>Almacen</th>
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
<script src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
</script>
<!-- Custom js -->
<script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>
<!--Bootstrap Typeahead js -->
<script src=" {{ asset('libraries\bower_components\bootstrap-typeahead\js\bootstrap-typeahead.min.js') }}"></script>

<!-- personalizado -->
<script>
    // var route = "{{ url('anular') }}";

    // FILTRO ID 
    $('#id-filtro').on('keyup', function() {
        var selectedValue = $(this).val();
        var table=$('#datatable').DataTable(); 
        table.column(0).search(selectedValue).draw(); 
    });
</script>

<script>
    $('#modal-eliminar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            var nombre = button.data('nombre') // Extrae la informacion de data-nombre

            action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            action += id; // se agrega el id seleccionado al formulario

            $('#formdelete').attr('action', action); //cambia la ruta del formulario

            var modal = $(this)
            modal.find('.modal-body h5').text('Desea Anular la Solcitud de Despacho ' + nombre + ' ?') //cambia texto en el body del modal
        })
</script>

@endsection