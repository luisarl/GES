@extends('layouts.master')

@section('titulo', 'Tabla de Consumo')

@section('titulo_pagina', 'Tabla de Consumo')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Tabla de Consumo</a> </li>
</ul>
@endsection

@section('contenido')
<!-- Scroll - Vertical table end -->
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('CentroCorte.TablasConsumo.TablasConsumoDestroy')

<!-- Scroll - Vertical table end -->
<div class="card">
    <div class="card-header">
        <h5>Listado de Fichas</h5>
        {{-- @can('cenc.fichas.crear') --}}
            <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('cenctablasconsumo.create') !!}">
                <i class="fa fa-plus"></i> Nuevo</a>
        {{-- @endcan --}}
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th style="width: 20%">Nro</th>
                        <th style="width: 20%">Espesor</th>
                        <th style="width: 25%">Equipo</th>
                        <th style="width: 25%">Tecnologia</th>
                        <th style="width: 10%">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($espesores as $espesor)
                    <tr>
                        <td>{{ $loop->iteration  }}</td>
                        <td>{{ number_format($espesor->espesor, 2)}}</td>
                        <td>{{$espesor->nombre_equipo}}</td>
                        <td>{{$espesor->nombre_tecnologia}}</td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @can('cenc.tablaconsumo.editar')
                                    <a class="dropdown-item" href=" {{ route('cenctablasconsumo.edit', $espesor->id_tabla_consumo) }}"><i class="fa fa-edit"></i>Editar</a>
                                @endcan 
                                @can('cenc.tablaconsumo.eliminar')
                                    <a class="dropdown-item" data-id="{{ $espesor->id_tabla_consumo }}" data-nombre="{{ number_format($espesor->espesor, 1) }}"  data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="width: 20%">Nro</th>
                        <th style="width: 20%">Espesor</th>
                        <th style="width: 25%">Equipo</th>
                        <th style="width: 25%">Tecnologia</th>
                        <th style="width: 10%">Acciones</th>
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

    <script>
        $('#modal-eliminar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
            var nombre = button.data('nombre') 

            action = $('#formdelete').attr('data-action').slice(0, -1); 
            action += id; 

            $('#formdelete').attr('action', action); 

            var modal = $(this)
            modal.find('.modal-body h5').text('Desea el registro: ' + nombre + ' ?') 
        })
    </script>

@endsection