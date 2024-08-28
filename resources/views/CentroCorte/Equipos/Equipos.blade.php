@extends('layouts.master')

@section('titulo', 'Equipos')

@section('titulo_pagina', 'Equipos')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('cencequipos.index')}}">Centro de Corte</a> </li>
    <li class="breadcrumb-item"><a href="#!">Equipos</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('CentroCorte.Equipos.EquiposDestroy')

<div class="card">
    <div class="card-header">
        <h5>Listado de Equipos</h5>
        @can('cenc.equipos.crear')
            <a class="btn btn-primary float-right" title="Nuevo" href="{{ route('cencequipos.create') }}">
                <i class="fa fa-plus"></i> Nuevo</a>
        @endcan  
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Tecnologia</th>
                        <th style="width: 5%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipos as $equipo)
                    <tr>
                        <td>{{$equipo->id_equipo}}</td>
                        <td>{{$equipo->nombre_equipo}}</td>
                        <td>{{$equipo->descripcion_equipo}}</td>
                        <td>
                            @foreach($tecnologias as $tecnologia)
                                @if($equipo->id_equipo == $tecnologia->id_equipo)                        
                                    @php $texto = wordwrap($tecnologia->nombres_tecnologias, 15, "<br>", false) @endphp   
                                    {!!$texto!!}
                                @endif
                            @endforeach
                        </td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                    aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @can('cenc.equipos.editar')  
                                    <a class="dropdown-item" href=" {{ route('cencequipos.edit', $equipo->id_equipo) }}"><i
                                            class="fa fa-edit"></i>Editar</a>
                                @endcan
                                @can('cenc.equipos.eliminar') 
                                    <a class="dropdown-item" data-id="{{ $equipo->id_equipo }}"
                                        data-nombre="{{ $equipo->nombre_equipo }}" data-toggle="modal"
                                        data-target="#modal-eliminarE" href=""><i class="fa fa-trash"></i>Borrar</a>
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
                        <th>Tecnologia</th>
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
    $('#modal-eliminarE').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
            var nombre = button.data('nombre') 

            action = $('#formdelete').attr('data-action').slice(0, -1); 
            action += id; 

            $('#formdelete').attr('action', action); 

            var modal = $(this)
            modal.find('.modal-body h5').text('Desea Eliminar el Equipo' + nombre + ' ?') 
        })
</script>

@endsection