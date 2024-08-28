@extends('layouts.master')

@section('titulo', 'Ordenes trabajo')

@section('titulo_pagina', 'Orden de Trabajo')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Centro de Corte</a> </li>
    <li class="breadcrumb-item"><a href="#!">Orden de Trabajo</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjError')
@include('CentroCorte.OrdenTrabajo.Orden.OrdenTrabajoDestroy')

<div class="card">
    <div class="card-header">
        <h5>Estatus de Ordenes de Trabajo</h5>

        <div class="btn-group"> 
            <select id="estatus-filter" class="form-control">
                <option value="" disabled selected>ESTATUS</option>
                <option value="EJECUTADO">EJECUTADO</option>
                <option value="EN PROCESO">EN PROCESO</option>
                <option value="FINALIZADO">FINALIZADO</option>

            </select>
        </div>
        <div class="btn-group">
            <button id="btnLimpiarFiltros" class="form-control form-control-lg" onmouseover="this.style.color='red';" onmouseout="this.style.color='black';">
                <i class="fa fa-trash"></i>  LIMPIAR</button>
        </div>
    </div>

    <div class="card-block">
        <div class="table-responsive dt-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap table-responsive">
                <thead>
                    <tr>
                        <th style="width: 10%">ID Orden</th>
                        <th style="width: 10%">Fecha</th>
                        <th style="width: 15%">Nro CONAP</th>
                        <th style="width: 30%">Creado por</th>
                        <th style="width: 10%">Estatus</th>
                        <th style="width: 10%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($OrdenesTrabajos as $OrdenTrabajo)
                    <tr>
                    <td>{{$OrdenTrabajo->id_orden_trabajo}}</td>
                    <td>{{date('d-m-Y g:i A', strtotime($OrdenTrabajo->fecha_creado))}}</td>
                    <td>{{$OrdenTrabajo->nro_conap}}</td>
                    <td>{{$OrdenTrabajo->name}}</td>
                    <td>
                        @if($OrdenTrabajo->estatus == 'POR ACEPTAR')
                        <label class="label label-info">POR ACEPTAR</label>
                        @elseif($OrdenTrabajo->estatus == 'ACEPTADA')
                            <label class="label label-success">ACEPTADA</label>
                        @elseif($OrdenTrabajo->estatus == 'APROBADO')
                            <label class="label label-danger">APROBADO</label>
                        @elseif($OrdenTrabajo->estatus == 'EN PROCESO')
                            <label class="label label-info">EN PROCESO</label>
                        @elseif($OrdenTrabajo->estatus == 'FINALIZADO')
                            <label class="label label-success">FINALIZADO</label>
                        @endif    
                    </td>
                    <td class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                <a class="dropdown-item" target="_blank" href="{{ route('cencordentrabajo.show', $OrdenTrabajo->id_orden_trabajo) }}">
                                    <i class="fa fa-eye"></i>Ver</a>

                                @if($OrdenTrabajo->estatus == 'EN PROCESO' || $OrdenTrabajo->estatus == 'FINALIZADO')
                                    <a class="dropdown-item" target="_blank" href=" {{ route('cencordentrabajopdf', $OrdenTrabajo->id_orden_trabajo) }}"><i class="fa fa-print"></i>Imprimir</a>
                                @endif

                               
                                {{-- @can('cenc.aprovechamientos.ver') --}}
                                    <a class="dropdown-item" href=" {{ route('cencordentrabajo.edit', $OrdenTrabajo->id_orden_trabajo) }}"><i class="fa fa-edit"></i>Editar</a>
                                {{-- @endcan --}}

                                {{-- @if($OrdenTrabajo->estatus == 'POR ACEPTAR' || $OrdenTrabajo->estatus == 'ACEPTADO')
                                    <a class="dropdown-item" 
                                    data-id="{{ $OrdenTrabajo->id_orden_trabajo }}"
                                     data-toggle="modal" 
                                     data-target="#modal-orden-anular" 
                                     href="#!"><i class="fa fa-ban"></i>Anular</a>
                                @endif --}}
                            </div>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="width: 10%">ID Orden</th>
                        <th style="width: 10%">Fecha</th>
                        <th style="width: 15%">Nro CONAP</th>
                        <th style="width: 30%">Creado por</th>
                        <th style="width: 10%">Estatus</th>
                        <th style="width: 10%">Acciones</th>
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
        $('#modal-orden-anular').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            
            action = $('#ordentrabajoanular').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            action += id; // se agrega el id seleccionado al formulario

            $('#ordentrabajoanular').attr('action', action); //cambia la ruta del formulario

            var modal = $(this)
            modal.find('.modal-body h5').text('Desea Anular La Orden De Trabajo' + id + ' ?') //cambia texto en el body del modal
        })
    </script>

    <script>
        $(document).ready(function() 
        {
            // FILTRO ESTATUS 
            $('#estatus-filter').on('change', function() {
                var selectedValue = $(this).val();
                var table=$('#datatable').DataTable(); 
                table.column(4).search(selectedValue).draw(); 
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