
@extends('layouts.master')

@section('titulo', 'Listado de Horarios')

@section('titulo_pagina', 'Listado de Horarios')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Gestion Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="#!">Horarios</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('GestionAsistencia.Horarios.HorarioDestroy')


<div class="card">
    <div class="card-header">
     @can('gsta.horarios.crear')
          <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('gstahorarios.create') !!}">
            <i class="fa fa-plus"></i> Nuevo</a>
     @endcan
    </div>
    <div class="card-block">
        
      
       
        <div class="dt-responsive table-responsive">
            <table class="table table-striped table-bordered" id="datatable">
                <thead class="text-center">
                    <tr>
                            <th>Id</th>
                            <th>Nombre Horario</th>
                            <th>Inicio de Jornada</th>
                            <th>Fin de Jornada</th>
                            <th>Ver</th>
                          
                    </tr>
                </thead>
                <tbody>
                    @foreach ($horarios as $horario)
                    <tr>
                        <td>{{$horario->id_horario}}</td>
                        <td>{{$horario->nombre_horario}}</td>
                        <td>{{date('g:i:s A', strtotime($horario->inicio_jornada))}}</td>
                        <td>{{date('g:i:s A', strtotime($horario->fin_jornada))}}</td>
                       

                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                    aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @can('gsta.horarios.ver') 
                                    <a class="dropdown-item" href="{{ route('gstahorarios.show', $horario->id_horario) }}">
                                    <i class="fa fa-eye"></i>Ver</a>
                                @endcan
                                
                              
                                @can('gsta.horarios.editar') 
                                <a class="dropdown-item"
                                    href="{{ route('gstahorarios.edit',$horario->id_horario) }}">
                                    <i class="fa fa-edit"></i>Editar</a>
                                @endcan 
                             
                               
                               @can('gsta.horarios.eliminar') 
                                <a class="dropdown-item" data-id="{{ $horario->id_horario }}"
                                    data-nombre="{{ $horario->id_horario }}" data-toggle="modal"
                                    data-target="#modal-eliminar" href="#!">
                                    <i class="fa fa-ban"></i>Anular</a>
                                
                                @endcan 
                            
                            </div>
                        </td>
                       
                        
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                         <th>Id</th>
                         <th>Nombre Horario</th>
                         <th>Inicio de Jornada</th>
                         <th>Fin de Jornada</th>
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
            modal.find('.modal-body h5').text('Desea Eliminar El Horario ' + nombre + ' ?') //cambia texto en el body del modal
        })
</script>
@endsection

