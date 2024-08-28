@extends('layouts.master')

@section('titulo', 'Herramientas')

@section('titulo_pagina', 'Herramientas')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item"><a href="{{ url('/dashboardcnth') }}"> <i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="#!">Herramientas</a> </li>
</ul>
@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjValidacion') 
@include('ControlHerramientas.Herramientas.HerramientasDestroy')

    <div class="card">
        <div class="card-header">
            <h5>Listado de Herramientas</h5>
            @can('cnth.herramientas.crear')
            <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('herramientas.create') !!}">
                <i class="fa fa-plus"></i> Nuevo</a> <!--fa fa-print-->
            @endcan
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="datatable" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Grupo</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($herramientas as $herramienta)
                            <tr>
                                <td>{{$herramienta->id_herramienta}}</td>
                                <td>{{$herramienta->codigo_herramienta}}</td>
                                <td>
                                    @php
                                        $texto = $herramienta->nombre_herramienta;
                                        $nombre_herramienta = wordwrap($texto, 40, "<br>", false);
                                    @endphp
     
                                 {!!$nombre_herramienta!!}
                                </td>
                                <td>
                                    @php
                                        $texto = $herramienta->descripcion_herramienta;
                                        $descripcion_herramienta = wordwrap($texto, 40, "<br>", false);
                                    @endphp
     
                                 {!!$descripcion_herramienta!!}
                                </td>
                                <td>{{$herramienta->grupo->nombre_grupo}}</td>
                                <td class="dropdown"> 
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                        @can('cnth.herramientas.ver')
                                            <a class="dropdown-item" href=" {{ route('herramientas.show', $herramienta->id_herramienta) }}"><i class="fa fa-eye"></i>Ver</a>  
                                        @endcan
                                        @can('cnth.herramientas.editar')   
                                            <a class="dropdown-item" href=" {{ route('herramientas.edit', $herramienta->id_herramienta) }}"><i class="fa fa-edit"></i>Editar</a>                  
                                        @endcan
                                        @can('cnth.herramientas.eliminar')    
                                            <a class="dropdown-item" data-id="{{ $herramienta->id_herramienta }}" data-nombre="{{ $herramienta->nombre_herramienta }}"  data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                        @endcan    
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Grupo</th>
                            <th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
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
    <script src="{{ asset('libraries\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}"></script>

    <script src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}"></script>
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
            modal.find('.modal-body h5').text('Desea Eliminar la Herramienta ' + nombre + ' ?') //cambia texto en el body del modal
        })
    </script>

@endsection
