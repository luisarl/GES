@extends('layouts.master')

@section('titulo', 'Salidas')

@section('titulo_pagina', 'Salidas')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Autorización de Salidas</a> </li>
    <li class="breadcrumb-item"><a href="#!">Salidas</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('SalidaMateriales.Salidas.SalidasDestroy')

<div class="card">
    <div class="card-header">
        <h5>Listado de Salidas</h5>
        @can('asal.salidamateriales.crear')
        <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('autorizacionsalidas.create') !!}">
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
                        <th>Almacen</th>
                        <th>Solicitante</th>
                        <th>Responsable</th>
                        <th>Tipo</th>
                        <th>Estatus</th>
                        <th>Opciones</th>
                        <th style='visibility:collapse; display:none;'>Articulos </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salidas as $salida)
                    <tr>
                        <td>{{$salida->id_salida}}</td>
                        <td>{{$salida->fecha_emision}}</td>
                        <td>{{$salida->nombre_almacen}}</td>
                        <td>{{$salida->solicitante}}</td>
                        <td>{{$salida->responsable}}</td>
                        <td>{{$salida->nombre_tipo}}</td>

                        <td>
                            @if ($salida->estatus == 'GENERADO')
                                    <label class="label label-info">{{$salida->estatus}}</label>
                                @elseif($salida->estatus == 'VALIDADO/ALMACEN')
                                    <label class="label label-inverse">{{$salida->estatus}}</label>
                                @elseif($salida->estatus == 'VALIDADO/ABIERTO')
                                    <label class="label label-warning">{{$salida->estatus}}</label>
                                @elseif($salida->estatus == 'CERRADO')
                                    <label class="label label-primary">{{$salida->estatus}}</label>
                                @elseif($salida->estatus == 'CERRADO/ALMACEN')
                                    <label class="label label-success">{{$salida->estatus}}</label>
                                @elseif($salida->estatus == 'ANULADO')
                                    <label class="label label-danger">{{$salida->estatus}}</label>
                                @else
                                    {{$salida->estatus}}
                            @endif
                        </td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                    aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @can('asal.salidamateriales.ver')
                                <a class="dropdown-item"
                                    href="{{ route('autorizacionsalidas.show', $salida->id_salida) }}">
                                    <i class="fa fa-eye"></i>Ver</a>
                                @endcan
                                @if ($salida->estatus == 'VALIDADO/ABIERTO')
                                @can('asal.salidamateriales.retorno')
                                    <a class="dropdown-item"
                                    href="{{ route('retornosalidas', $salida->id_salida) }}">
                                    <i class="icofont icofont-download-alt"></i>Retorno</a>
                                @endcan
                                @endif
                                @if ($salida->anulado != 'SI')
                                @can('asal.salidamateriales.editar')
                                <a class="dropdown-item"
                                    href="{{ route('autorizacionsalidas.edit',$salida->id_salida) }}">
                                    <i class="fa fa-edit"></i>Editar</a>
                                @endcan
                                @endif
                                @if ($salida->estatus == 'GENERADO' || $salida->estatus == 'VALIDADO/ALMACEN')
                                @can('asal.salidamateriales.eliminar')
                                <a class="dropdown-item" data-id="{{ $salida->id_salida }}"
                                    data-nombre="{{ $salida->id_salida }}" data-toggle="modal"
                                    data-target="#modal-eliminar" href="#!">
                                    <i class="fa fa-ban"></i>Anular</a>
                                @endcan
                                @endif
                            </div>
                        </td>
                        <td style='visibility:collapse; display:none;'>    
                            {{$salida->articulos}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nº</th>
                        <th>Fecha</th>
                        <th>Almacen</th>
                        <th>Solicitante</th>
                        <th>Responsable</th>
                        <th>Tipo</th>
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
    var route = "{{ url('anular') }}";

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
            modal.find('.modal-body h5').text('Desea Anular la Salida de Material? ' + nombre + ' ?') //cambia texto en el body del modal
        })
</script>

@endsection