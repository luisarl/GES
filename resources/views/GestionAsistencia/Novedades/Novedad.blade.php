@extends('layouts.master')

@section('titulo', 'Listado de Novedades')

@section('titulo_pagina', 'Listado de Novedades')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Gestion Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="#!">Novedades</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('GestionAsistencia.Novedades.NovedadDestroy')


<div class="card">
    <div class="card-header">
        @can('gsta.novedades.crear')
            <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('gstanovedades.create') !!}">
            <i class="fa fa-plus"></i> Nuevo</a>
        @endcan
    </div>
    <div class="card-block">
        
      
       
        <div class="dt-responsive table-responsive">
            <table class="table table-striped table-bordered" id="datatable">
                <thead class="text-center">
                    <tr>
                            <th>Id</th>
                            <th>Nombre Novedad</th>
                            <th>Ver</th>
                          
                    </tr>
                </thead>
                <tbody>
                    @foreach ($novedades as $novedad)
                    <tr>
                        <td>{{$novedad->id_novedad}}</td>
                        <td>{{$novedad->descripcion}}</td>

                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                    aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @can('gsta.novedades.ver') 
                                    <a class="dropdown-item" href="{{ route('gstanovedades.show', $novedad->id_novedad) }}">
                                    <i class="fa fa-eye"></i>Ver</a>
                                @endcan
                                
                              
                               @can('gsta.novedades.editar') 
                                <a class="dropdown-item"
                                    href="{{ route('gstanovedades.edit',$novedad->id_novedad) }}">
                                    <i class="fa fa-edit"></i>Editar</a>
                               @endcan
                             
                               
                                @can('gsta.novedades.eliminar')
                                <a class="dropdown-item" data-id="{{ $novedad->id_novedad }}"
                                    data-nombre="{{ $novedad->descripcion }}" data-toggle="modal"
                                    data-target="#modal-eliminar" href="#!">
                                    <i class="fa fa-ban"></i>Eliminar</a>
                                
                                @endcan 
                            
                            </div>
                        </td>
                       
                        
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                            <th>Id</th>
                            <th>Nombre Novedad</th>
                            <th>Ver</th>

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
<!-- personalizado -->


<script>
    $('#modal-eliminar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            var nombre = button.data('nombre') // Extrae la informacion de data-nombre

            action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            action += id; // se agrega el id seleccionado al formulario

            $('#formdelete').attr('action', action); //cambia la ruta del formulario
            
            var modal = $(this)
            modal.find('.modal-body h5').text('Desea Eliminar La Novedad:  ' + nombre + '  ?') //cambia texto en el body del modal
        })
</script>
@endsection

