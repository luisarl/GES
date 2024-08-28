@extends('layouts.master')

@section('titulo', 'Conap')

@section('titulo_pagina', 'Consulta de aprovechamiento - CONAP')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Centro de Corte</a> </li>
    <li class="breadcrumb-item"><a href="#!">Conap</a> </li>
    {{-- <li class="breadcrumb-item"><a href="#!">Conap</a> </li> --}}
</ul>
@endsection


@section('contenido')
<!-- Scroll - Vertical table end -->
@include('mensajes.MsjExitoso')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjError')
@include('CentroCorte.Conap.ConapDestroy')

<!-- Scroll - Vertical table end -->
<!-- Scroll - Vertical, Dynamic Height table start -->
<div class="card">
    <div class="card-header">
        <h5>Listado de Conap</h5>

{{-- SECCION DE FILTROS --}}

        {{-- BOTON VER POR ESTATUS --}}   
        <div class="btn-group"> 
            <select id="estatus-filter" class="form-control">
                <option value="" disabled selected>ESTATUS</option>
                <option value="APROBADO">APROBADO</option>
                <option value="CANCELADO">CANCELADO</option>
                <option value="SIN EFECTO">EN PROCESO</option>
                <option value="FINALIZADO">FINALIZADO</option>
            </select>
        </div>
        {{-- BOTON PARA LIMPIAR FILTROS --}}
        <div class="btn-group">
            <button id="btnLimpiarFiltros" class="form-control form-control-lg" onmouseover="this.style.color='red';" onmouseout="this.style.color='black';">
                <i class="fa fa-trash"></i>  LIMPIAR</button>
        </div>
      
        {{-- @can('cenc.conap.crear') --}}
            <a class="btn btn-primary  float-right" title="Nuevo" href="{!! route('cencconap.create') !!}">
            <i class="fa fa-plus"></i> Nuevo</a>
        {{-- @endcan --}}
    </div>
    <div class="form-group row">



    </div>
    <div class="card-block">
        <div class="table-responsive dt-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>Nro</th>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Creado por</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($conaps as $conap)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$conap->nro_conap}}</td>
                            <td>{{date('d-m-Y g:i A', strtotime($conap->created_at))}}</td> 
                            <td>{{$conap->nombre_conap}}</td>
                            <td>{{$conap->name}}</td>
                            <td>
                            @if($conap->estatus_conap == 'POR ACEPTAR')
                                <label class="label label-warning">POR ACEPTAR</label>
                            @elseif($conap->estatus_conap == 'ABIERTO')
                                <label class="label label-info">ABIERTO</label>
                            @elseif($conap->estatus_conap == 'EN PROCESO')
                                <label class="label label-warning">EN PROCESO</label>
                            @elseif($conap->estatus_conap == 'APROBADO')
                                <label class="label label-primary">APROBADO</label>
                            @elseif($conap->estatus_conap == 'CERRADO')
                                <label class="label label-primary">CERRADO</label>
                            @elseif($conap->estatus_conap == 'FINALIZADO')
                                <label class="label label-success">FINALIZADO</label>
                            @elseif($conap->estatus_conap == 'ANULADO')
                                <label class="label label-danger">ANULADO</label>
                            @elseif($conap->estatus_conap == 'NO PROCEDE')
                                <label class="label label-danger">NO PROCEDE</label>    
                            @endif
                            </td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                        aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                    @can('cenc.conap.ver')
                                        <a class="dropdown-item" target="_blank" href=" {{ route('cencconap.show', $conap->id_conap) }}">
                                            <i class="fa fa-eye"></i>Ver</a>
                                    @endcan

                                    @can('cenc.conap.editar')  
                                        <a class="dropdown-item" href=" {{ route('cencconap.edit', $conap->id_conap) }}">
                                            <i class="fa fa-edit"></i>Editar</a>
                                    @endcan

                                    @can('cenc.conap.eliminar') 
                                        <a class="dropdown-item" data-id="{{ $conap->id_conap }}"
                                            data-nombre="{{ $conap->nombre_conap }}" data-toggle="modal"
                                            data-target="#modal-anular" href=""><i class="fa fa-trash"></i>Borrar</a>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                    @endforeach
                        
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nro</th>
                        <th>Código</th>
                        <th>Fecha</th>
                        <th>Nombre</th>
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
    <script src="{{ asset('libraries\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}"></script>
    <!-- Custom js -->
    <script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>
    <!-- sweet alert js -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>

    <script>
        $('#modal-anular').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            
            action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            action += id; // se agrega el id seleccionado al formulario

            $('#formdelete').attr('action', action); //cambia la ruta del formulario

            var modal = $(this)
            modal.find('.modal-body h5').text('Desea Eliminar el Conap ' + id + ' ?') //cambia texto en el body del modal
        })
    </script>

    <script>
       
        $(document).ready(function() 
        {
            // FILTRO ESTATUS 
            $('#estatus-filter').on('change', function() {
                var selectedValue = $(this).val();
                var table=$('#datatable').DataTable(); 
                table.column(5).search(selectedValue).draw(); 
            });

            // LIMPIAR FILTROS 
            $('#btnLimpiarFiltros').on('click', function() {
                var table = $('#datatable').DataTable();
                table.search('').columns().search('').draw();

                $("#estatus-filter, #asignados-filter, #departamento-filter, #perfil-filter").val(function() {
                    return this.options[0].value;
                });
            });

        });
    </script>

@endsection