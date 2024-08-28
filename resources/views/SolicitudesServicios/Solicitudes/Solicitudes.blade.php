@extends('layouts.master')

@section('titulo', 'Solicitudes')

@section('titulo_pagina', 'Solicitudes')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Solicitudes de Servicio</a> </li>
    <li class="breadcrumb-item"><a href="#!">Solicitudes</a> </li>
</ul>
@endsection

@section('contenido')
<!-- Scroll - Vertical table end -->
@include('mensajes.MsjExitoso')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjError')
@include('SolicitudesServicios.Solicitudes.SolicitudesDestroy')

<!-- Scroll - Vertical table end -->
<!-- Scroll - Vertical, Dynamic Height table start -->
<div class="card">
    <div class="card-header">
        <h5>Listado de Solicitudes</h5>

{{-- SECCION DE FILTROS --}}

        {{-- BOTON VER SOLICITUDES ENVIADAS Y RECIBIDAS POR DPTO --}}  
        <div class="btn-group"> 
            <select id="departamento-filter" class="select-filter form-control">
                <option value="" disabled selected>DEPARTAMENTO</option> 
                <option value="{{Auth::user()->id_departamento}}">CREADAS</option>
                <option value="{{Auth::user()->id_departamento}}">RECIBIDAS</option>
            </select>
        </div>
        {{-- BOTON VER POR ASIGNADOS --}}    
        <div class="btn-group">
            <select id="asignados-filter" class="form-control" href="">
                <option value="" disabled selected href="">ASIGNADOS</option>
                @foreach($usuariosresponsables as $responsable)
                    <option value="{{$responsable->nombre_responsable}}">{{$responsable->nombre_responsable}}</option>
                @endforeach
            </select>
        </div>
        {{-- BOTON VER POR ESTATUS --}}   
        <div class="btn-group"> 
            <select id="estatus-filter" class="form-control">
                <option value="" disabled selected>ESTATUS</option>
                <option value="POR ACEPTAR">POR ACEPTAR</option>
                <option value="NO PROCEDE">NO PROCEDE</option>
                <option value="ABIERTO">ABIERTO</option>
                <option value="EN PROCESO">EN PROCESO</option>
                <option value="CERRADO">CERRADO</option>
                <option value="FINALIZADO">FINALIZADO</option>
                <option value="ANULADO">ANULADO</option>

            </select>
        </div>
        {{-- BOTON VER CREADAS --}}   
        <div class="btn-group">
            <button id="creadas-filter" data-name="{{Auth::user()->name}}" class="form-control form-control-lg" onmouseover="this.style.color='rgb(8, 172, 172)';" onmouseout="this.style.color='black';">
                <i class="fa fa-user"></i>  CREADAS</button>
        </div>
        {{-- BOTON VER TODAS --}}
        @can('sols.solicitudes.ver.todas') 
        <div class="btn-group">   
            <a class="form-control form-control-lg" title="Nuevo" href="{!! route('solicitudes/todas/departamento') !!}"><i class="fa fa-list-ul"></i>  TODAS</a>
        </div>
        @endcan  
        {{-- BOTON PARA LIMPIAR FILTROS --}}
        <div class="btn-group">
            <button id="btnLimpiarFiltros" class="form-control form-control-lg" onmouseover="this.style.color='red';" onmouseout="this.style.color='black';">
                <i class="fa fa-trash"></i>  LIMPIAR</button>
        </div>
        @can('sols.solicitudes.crear')
            <a class="btn btn-primary  float-right" title="Nuevo" href="{!! route('solicitudes.create') !!}">
            <i class="fa fa-plus"></i> Nuevo</a>
        @endcan
    </div>
    <div class="card-block">
        <div class="table-responsive dt-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap table-responsive" style="width: 100%">
                <thead>
                    <tr>
                        <th style="max-width: 1%;">ID</th>
                        <th style="max-width: 2%;">Codigo</th>
                        <th style="max-width: 9%;">Fecha</th>
                        <th style="max-width: 8%;">Servicio</th>
                        <th style="max-width: 8%;">SubServicio</th>
                        <th style="max-width: 8%;">Motivo</th>
                        <th style="max-width: 8%;">Creado por</th>
                        <th style="max-width: 6%;">Estatus</th>
                        <th style="max-width: 6%;">Acciones</th>
                        <th >Enviadas</th>
                        <th >Recibidas</th>
                        <th >Asignados</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($solicitudes as $solicitud)

                    <tr>
                        <td>{{$solicitud->id_solicitud}}</td>
                        <td>{{$solicitud->codigo_solicitud}}</td>
                        <td>{{date('d-m-Y g:i A', strtotime($solicitud->fecha_creacion))}}</td>
                        <td>
                            @php
                              $servicio = wordwrap($solicitud->nombre_servicio, 15, "<br>", false);
                            @endphp
                            {!!$servicio!!}
                          </td>
                        <td>
                            @php
                              $subservicio = wordwrap($solicitud->nombre_subservicio, 15, "<br>", false);
                            @endphp
                            {!!$subservicio!!}
                        </td>
                        <td>
                            @php
                              $asunto = wordwrap($solicitud->asunto_solicitud, 23, "<br>", false);
                            @endphp
                            {!!$asunto!!}
                        </td>
                        <td>{{$solicitud->creado_por}}</td>
                        <td>
                            @if($solicitud->estatus == 'POR ACEPTAR')
                                <label class="label label-warning">POR ACEPTAR</label>
                            @elseif($solicitud->estatus == 'ABIERTO')
                                <label class="label label-info">ABIERTO</label>
                            @elseif($solicitud->estatus == 'EN PROCESO')
                                <label class="label label-warning">EN PROCESO</label>
                            @elseif($solicitud->estatus == 'CERRADO')
                                <label class="label label-primary">CERRADO</label>
                            @elseif($solicitud->estatus == 'FINALIZADO')
                                <label class="label label-success">FINALIZADO</label>
                            @elseif($solicitud->estatus == 'ANULADO')
                                <label class="label label-danger">ANULADO</label>
                            @elseif($solicitud->estatus == 'NO PROCEDE')
                                <label class="label label-danger">NO PROCEDE</label>    
                            @endif
                        </td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                    @can('sols.solicitudes.ver')
                                        <a class="dropdown-item" href=" {{ route('solicitudes.show', $solicitud->id_solicitud ) }}"><i class="fa fa-eye"></i>Ver</a>
                                    @endcan
                                    @can('sols.solicitudes.editar')
                                        <a class="dropdown-item" href=" {{ route('solicitudes.edit', $solicitud->id_solicitud ) }}"><i class="fa fa-edit"></i>Editar</a>
                                    @endcan

                                    @if($solicitud->estatus == 'POR ACEPTAR')
                                        @can('sols.solicitudes.anular')
                                        <a class="dropdown-item" data-id="{{ $solicitud->id_solicitud }}" data-toggle="modal" data-target="#modal-anular" href="#!">
                                            <i class="fa fa-ban"></i>Anular</a>
                                        @endcan
                                    @endif

                                    @if(Auth::user()->id_departamento == $solicitud->id_departamento_solicitud)
                                        @if(($solicitud->estatus == 'CERRADO' || $solicitud->estatus == 'FINALIZADO') && ($solicitud->encuesta_servicio_enviada == 'NO') )
                                            <a class="dropdown-item" href=" {{ route('solicitudes/encuestaservicio', $solicitud->id_solicitud ) }}"><i class="icofont icofont-prescription"></i>Encuesta Servico</a>
                                        @endif
                                    @endif
                                    
                                    @if(Auth::user()->id_departamento == $solicitud->id_departamento_servicio)
                                        @if(($solicitud->estatus == 'CERRADO' || $solicitud->estatus == 'FINALIZADO') && ($solicitud->encuesta_solicitud_enviada == 'NO'))    
                                            <a class="dropdown-item" href=" {{ route('solicitudes/encuestasolicitud', $solicitud->id_solicitud ) }}"><i class="icofont icofont-prescription"></i>Encuesta Solicitud</a>
                                        @endif
                                    @endif          
                                </div>
                                {{-- @dd($asignados->nombres_responsables)  --}}
                        </td>
                        <td>{{$solicitud->id_departamento_solicitud}}</td>
                        <td>{{$solicitud->id_departamento_servicio}}</td>
                        <td>
                            {{$solicitud->responsables}}
                        </td> 
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="max-width: 1%;">ID</th>
                        <th style="max-width: 2%;">Codigo</th>
                        <th style="max-width: 9%;">Fecha</th>
                        <th style="max-width: 8%;">Servicio</th>
                        <th style="max-width: 8%;">SubServicio</th>
                        <th style="max-width: 8%;">Motivo</th>
                        <th style="max-width: 8%;">Creado por</th>
                        <th style="max-width: 6%;">Estatus</th>
                        <th style="max-width: 6%;">Acciones</th>
                        <th >Enviadas</th>
                        <th >Recibidas</th>
                        <th >Asignados</th>
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
            modal.find('.modal-body h5').text('Desea Anular la Solicitud ' + id + ' ?') //cambia texto en el body del modal
        })
    </script>

    <script>
       
        $(document).ready(function() 
        {

            // FILTRO DEPARTAMENTO y PERFIL 
            $('.select-filter').on('change', function() {
                var selectedValue = this.value
                var selectedText = $("option:selected",this).text();
                var table=$('#datatable').DataTable(); 
                var columnMappings = 
                {
                "CREADAS": 9,
                "RECIBIDAS": 10
                };
                
                table.columns().search('').draw(); // para restablecer filtro
                if (columnMappings.hasOwnProperty(selectedText)) 
                {
                var columnIndex = columnMappings[selectedText];
                table.column(columnIndex).search('^' + selectedValue + '$', true, false).draw();
                }
            });
            

            // FILTRO ESTATUS 
            $('#estatus-filter').on('change', function() {
                var selectedValue = $(this).val();
                var table=$('#datatable').DataTable(); 
                table.column(7).search(selectedValue).draw(); 
            });

            // FILTRO ASIGNADOS
            $('#asignados-filter').on('change', function() {
                var selectedValue2 = $(this).val();
                var table=$('#datatable').DataTable(); 
                table.column(11).search(selectedValue2).draw(); 
            });

            // FILTRO CREADAS
            $('#creadas-filter').on('click', function() {
                var selectedValue2 = $(this).data('name');
                var table=$('#datatable').DataTable(); 
                table.column(6).search(selectedValue2).draw(); 
            });

            // OCULTAR TABLAS
            $(document).ready(function() {
                var table=$('#datatable').DataTable();
                table.column(9).visible(false); 
                table.column(10).visible(false); 
                table.column(11).visible(false); 
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