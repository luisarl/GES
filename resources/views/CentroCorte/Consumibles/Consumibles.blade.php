@extends('layouts.master')

@section('titulo', 'Consumibles')

@section('titulo_pagina', 'Consumibles')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('cencconsumibles.index')}}">Centro de Corte</a> </li>
    <li class="breadcrumb-item"><a href="#!">Consumibles</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('CentroCorte.Consumibles.ConsumiblesDestroy')

<div class="card">
    <div class="card-header">
        <h5>Listado de Consumibles</h5>
        @can('cenc.consumibles.crear')
            <a class="btn btn-primary float-right" title="Nuevo" href="{{ route('cencconsumibles.create') }}">
                <i class="fa fa-plus"></i> Nuevo</a>
        @endcan
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap" style="max-width: 100%;">
                <thead>
                    <tr>
                        <th style="max-width: 5%;">ID</th>
                        <th style="max-width: 45%;">Nombre</th>
                        <th style="max-width: 45%;">Descripcion</th>
                        <th style="max-width: 5%;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consumibles as $consumible)
                    <tr>
                        <td>{{$consumible->id_consumible}}</td>
                        <td>{{$consumible->nombre_consumible}} </td>
                        <td>{{$consumible->descripcion_consumible}}</td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                    aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @can('cenc.consumibles.editar')
                                    <a class="dropdown-item" href=" {{ route('cencconsumibles.edit', $consumible->id_consumible) }}"><i
                                            class="fa fa-edit"></i>Editar</a>
                                @endcan
                                @can('cenc.consumibles.eliminar') 
                                    <a class="dropdown-item" data-id="{{ $consumible->id_consumible }}"
                                        data-nombre="{{ $consumible->nombre_consumible }}" data-toggle="modal"
                                        data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
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
                        <th>Descripcion</th>
                        <th>Acciones</th>
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

<!-- sweet alert js -->
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
            modal.find('.modal-body h5').text('Desea Eliminar el Consumible ' + nombre + ' ?') 
        })
</script>

@endsection