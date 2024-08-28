@extends('layouts.master')

@section('titulo', 'Control Combustible')

@section('titulo_pagina', 'Solicitud Despacho de Combustible')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Solicitudes de Despacho</a> </li>
    <li class="breadcrumb-item"><a href="#!">Solicitudes</a> </li>
</ul>
@endsection

@section('contenido')
<!-- Scroll - Vertical table end -->
@include('mensajes.MsjExitoso')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjError')
@include('ControlCombustible.Despachos.DespachoDestroy')

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
     
        {{-- BOTON VER POR ESTATUS --}}   
        <div class="btn-group"> 
            <select id="estatus-filter" class="form-control">
                <option value="" disabled selected>ESTATUS</option>
                <option value="POR ACEPTAR">POR ACEPTAR</option>
                <option value="ACEPTADO">ACEPTADO</option>
                <option value="PROCESADO">PROCESADO</option>
                <option value="ANULADO">ANULADO</option>
              

            </select>
        </div>
        <div class="btn-group"> 
            <select id="combustible-filter" class="form-control" href="">
                <option value="" disabled selected href="">TIPO DE COMBUSTIBLE</option>
                @foreach($tipos as $tipo)
                    <option value="{{$tipo->id_tipo_combustible}}">{{$tipo->descripcion_combustible}}</option>
                @endforeach
            </select>
        </div>
         {{-- BOTON PARA LIMPIAR FILTROS --}}
         <div class="btn-group">
            <button id="btnLimpiarFiltros" class="form-control form-control-lg" onmouseover="this.style.color='red';" onmouseout="this.style.color='black';">
                <i class="fa fa-trash"></i>  LIMPIAR</button>
        </div>
            @can('cntc.despachos.crear')  
                <a class="btn btn-primary  float-right" title="Nuevo" href="{!! route('cntcdespachos.create') !!}">
                <i class="fa fa-plus"></i> Nuevo</a>
            @endcan
          
      
    </div>
    <div class="card-block">

        <div class="table-responsive dt-responsive">
            <table id="datatable" class="table table-striped table-bordered" style="width: 100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Departamento</th>
                        <th>Cantidad</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                        <th>Tipo de Combustible</th>
                        <th>Creadas</th>
                        <th>Recibidas</th>
                   
                    </tr>
                </thead>
                <tbody>
                @foreach ($solicitudes as $solicitud)
                
            
                    <tr>
                        <td>{{$solicitud->id_solicitud_despacho}}</td>
                        <td>{{date('d-m-Y ', strtotime($solicitud->fecha_creacion))}}</td>
                        <td>{{$solicitud->nombre_departamento}}</td>
                        <td>{{number_format($solicitud->total,2)}}</td>
                       
                        <td>
                            @if($solicitud->estatus == 'POR ACEPTAR')
                                <label class="label label-warning">POR ACEPTAR</label>
                            @elseif($solicitud->estatus == 'ACEPTADO')
                                <label class="label label-info">ACEPTADO</label>
                            @elseif($solicitud->estatus == 'PROCESADO')
                                <label class="label label-success">PROCESADO</label>
                            @elseif($solicitud->estatus == 'ANULADO')
                                <label class="label label-danger">ANULADO</label>
                            @endif
                        </td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                    @can('cntc.despachos.ver')
                                        <a class="dropdown-item" href=" {{ route('cntcdespachos.show', $solicitud->id_solicitud_despacho ) }}"><i class="fa fa-eye"></i>Ver</a>
                                    @endcan
                                    @if($solicitud->estatus == 'POR ACEPTAR')
                                    @can('cntc.despachos.editar')
                                        <a class="dropdown-item" href=" {{ route('cntcdespachos.edit', $solicitud->id_solicitud_despacho ) }}"><i class="fa fa-edit"></i>Editar</a>
                                    @endcan
                                    @endif
                                    @if($solicitud->estatus == 'POR ACEPTAR')
                                    @can('cntc.despachos.eliminar')
                                        <a class="dropdown-item" data-id="{{$solicitud->id_solicitud_despacho }}" data-toggle="modal" data-target="#modal-anular" href="#!">
                                            <i class="fa fa-ban"></i>Anular</a>
                                    @endcan
                                    @endif
                                    @if($solicitud->estatus == 'ACEPTADO')
                                    @can('cntc.despachos.despachar')
                                        <a class="dropdown-item" href=" {{ route('cntcdespacharsolicituddespacho', $solicitud->id_solicitud_despacho ) }}"><i class="zmdi zmdi-local-gas-station"></i>Despachar</a>
                                    @endcan
                                    @endif
                                </div>  
                        </td>
                        <td>
                            {{$solicitud->id_tipo_combustible}}
                        </td>
                        <td>{{$solicitud->id_departamento}}</td>
                       <td>{{$solicitud->id_departamento_servicio}}</td>
                       
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Departamento</th>
                        <th>Cantidad</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                        <th>Tipo de Combustible</th>
                        <th>Creadas</th>
                        <th>Recibidas</th>
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
                "CREADAS": 7,
                "RECIBIDAS": 8
                };
                
                table.columns().search('').draw(); // para restablecer filtro
                if (columnMappings.hasOwnProperty(selectedText)) 
                {
                var columnIndex = columnMappings[selectedText];
                table.column(columnIndex).search('^' + selectedValue + '$', true, false).draw();
                }
            });

               // FILTRO COMBUSTIBLE
               $('#combustible-filter').on('change', function() {
                var selectedValue2 = $(this).val();
                var table=$('#datatable').DataTable(); 
                table.column(6).search(selectedValue2).draw(); 
            });
           

            // FILTRO ESTATUS 
            $('#estatus-filter').on('change', function() {
                var selectedValue = $(this).val();
                var table=$('#datatable').DataTable(); 
                table.column(4).search(selectedValue).draw(); 
            });


          

             // OCULTAR TABLAS
             $(document).ready(function() {
                var table=$('#datatable').DataTable();
                table.column(6).visible(false); 
                table.column(7).visible(false); 
                table.column(8).visible(false); 
            });
            
            // LIMPIAR FILTROS 
            $('#btnLimpiarFiltros').on('click', function() {
                var table = $('#datatable').DataTable();
                table.search('').columns().search('').draw();

                $("#estatus-filter, #combustible-filter, #departamento-filter, #perfil-filter").val(function() {
                    return this.options[0].value;
                });
            });

        });
    </script>

@endsection