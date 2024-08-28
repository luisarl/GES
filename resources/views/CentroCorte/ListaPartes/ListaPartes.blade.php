@extends('layouts.master')

@section('titulo', 'Lista Partes')

@section('titulo_pagina', 'Lista de Partes')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Centro de Corte</a> </li>
    <li class="breadcrumb-item"><a href="#!">Lista de Partes</a> </li>
    {{-- <li class="breadcrumb-item"><a href="#!">Conap</a> </li> --}}
</ul>
@endsection

@section('contenido')
<!-- Scroll - Vertical table end -->
@include('mensajes.MsjExitoso')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjError')
@include('CentroCorte.ListaPartes.ListaPartesDestroy')
@include('CentroCorte.ListaPartes.ListaPartesReabrir')

<!-- Scroll - Vertical table end -->
<!-- Scroll - Vertical, Dynamic Height table start -->
<div class="card">
    <div class="card-header">
        <h5>Listado </h5>

{{-- SECCION DE FILTROS --}}
        {{-- BOTON VER POR CONAP --}}   
        <div class="btn-group"> 
            <select name="estatus-filter" id="estatus-filter" class="js-example-basic-single form-control">
                   <option value="0">SELECCIONE EL NRO CONAP</option>
                    @foreach ($conaps as $conap)
                    <option value="{{ $conap->nro_conap }}"
                        @if ($conap->id_conap==old('id_conap')) selected="selected" @endif>{{ $conap->nro_conap }}
                    </option>
                    @endforeach
                </select>
        </div>
        {{-- BOTON PARA LIMPIAR FILTROS --}}
        <div class="btn-group">
            <button id="btnLimpiarFiltros" class="form-control form-control-lg" onmouseover="this.style.color='red';" onmouseout="this.style.color='black';">
                <i class="fa fa-trash"></i>  LIMPIAR</button>
        </div>
     {{--    <label for="">&ensp;&ensp;Fecha inicio </label>
        <div class="btn-group">
            <input type="date" name="fecha_inicio" min="" id=""
                class="form-control @error('fecha_inicio') is-invalid @enderror"
                value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '') }}" placeholder="Fecha inicio">
        </div>
        <label for="">&ensp;&ensp;Fecha fin </label>
        <div class="btn-group">
            <input type="date" name="fecha_fin" min="" id=""
                class="form-control @error('fecha_fin') is-invalid @enderror"
                value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '')  }}">
        </div> --}}
        @can('cenc.listapartes.crear')
            <a class="btn btn-primary  float-right" title="Nuevo" href="{!! route('cenclistapartes.create') !!}">
            <i class="fa fa-plus"></i> Nuevo</a>
        @endcan
    </div>
    <div class="form-group row">



    </div>
    <div class="card-block">
        <div class="table-responsive dt-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nro. Conap</th>
                        <th>Nombre Conap</th>
                        <th>Tipo</th>
                        <th>Creado por</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listap as $listaps)
                    <tr>
                        <td>{{$listaps->id_lista_parte}}</td>
                        <td>{{$listaps->nro_conap}}</td>
                        <td>{{$listaps->nombre_conap}}</td>
                        <td>{{$listaps->tipo_lista}}</td>
                        <td>{{$listaps->name}}</td>
                        <td>
                            @if($listaps->estatus == 'ACTIVADO')
                                <label class="label label-info">ACTIVADO</label>
                            @elseif($listaps->estatus == 'APROVECHADO')
                                <label class="label label-success">APROVECHADO</label>
                            @elseif($listaps->estatus == 'ANULADO')
                                <label class="label label-danger">ANULADO</label>
                            @endif
                        </td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                    {{-- <a class="dropdown-item" target="_blank" href="{{ route('listapartesdetallepdf', $listaps->id_lista_parte) }}"><i class="fa fa-print"></i>Detalle</a> --}}
                                    
                                    @can('cenc.listapartes.ver')
                                    <a class="dropdown-item" target="_blank" href="{{ route('cenclistapartes.show', $listaps->id_lista_parte) }}"><i class="fa fa-eye"></i>Ver</a>
                                    @endcan

                                    @can('cenc.listapartes.editar')
                                    <a class="dropdown-item" href="{{ route('cenclistapartes.edit', $listaps->id_lista_parte) }}"><i class="fa fa-edit"></i>Editar</a>
                                    @endcan

                                    @if($listaps->estatus == 'ACTIVADO')
                                        @can('cenc.listapartes.editar')
                                        <a class="dropdown-item" data-id="{{ $listaps->id_lista_parte }}" data-toggle="modal" data-target="#modal-anular" href="#!">
                                            <i class="fa fa-ban"></i>Anular</a>
                                        @endcan
                                    @endif

                                    @if($listaps->estatus == 'ANULADO')
                                        @can('cenc.listapartes.eliminar')
                                        <a class="dropdown-item" data-id="{{ $listaps->id_lista_parte }}" data-toggle="modal" data-target="#modal-activar" href="#!">
                                            <i class="fa fa-check"></i>Reactivar</a>
                                        @endcan
                                    @endif
                                    
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nro. Conap</th>
                        <th>Nombre Conap</th>
                        <th>Tipo</th>
                        <th>Creado por</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
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
        $('#modal-anular').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            
            action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            action += id; // se agrega el id seleccionado al formulario

            $('#formdelete').attr('action', action); //cambia la ruta del formulario

            var modal = $(this)
            modal.find('.modal-body h5').text('Desea Anular la Lista de Parte nro: ' + id + ' ?') //cambia texto en el body del modal
        })
    </script>

    <script>
        $('#modal-activar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            
            action = $('#formactivar').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            action += id; // se agrega el id seleccionado al formulario

            $('#formactivar').attr('action', action); //cambia la ruta del formulario

            var modal = $(this)
            modal.find('.modal-body h5').text('Desea Reactivar la Lista de Parte nro: ' + id + ' ?') //cambia texto en el body del modal
        })
    </script>

    <script>
       
        $(document).ready(function() 
        {
            // FILTRO ESTATUS 
            $('#estatus-filter').on('change', function() {
                var selectedValue = $(this).val();
                var table=$('#datatable').DataTable(); 
                table.column(1).search(selectedValue).draw();
            });
            // LIMPIAR FILTROS 
            $('#btnLimpiarFiltros').on('click', function() {
                var table = $('#datatable').DataTable();
                table.search('').columns().search('').draw();

                $("#estatus-filter").val(function() {
                    return this.options[0].value;
                });
            });

        });
    </script>

@endsection