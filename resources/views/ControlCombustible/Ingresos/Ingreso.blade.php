@extends('layouts.master')

@section('titulo', 'Control Combustible')

@section('titulo_pagina', 'Ingresos de Combustible')

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
@include('SolicitudesServicios.Solicitudes.SolicitudesDestroy')

<!-- Scroll - Vertical table end -->
<!-- Scroll - Vertical, Dynamic Height table start -->
<div class="card">
    <div class="card-header">
        {{-- <label class="label label-success">GASOIL: 1000</label>    
        <label class="label label-success">GASOLINA: 500</label>     --}}
       

{{-- SECCION DE FILTROS --}}
    <div class="btn-group"> 
        <select id="combustible-filter" class="select-filter form-control">
            <option value="" disabled selected href="">TIPO DE COMBUSTIBLE</option> 
            @foreach($tipos as $tipo)
                 <option value="{{$tipo->id_tipo_combustible}}">{{$tipo->descripcion_combustible}}</option>
             @endforeach>
        </select>
    </div>
    <div class="btn-group"> 
        <select id="ingresos-filter" class="select-filter form-control">
            <option value="" disabled selected href="">TIPO DE INGRESO</option> 
            @foreach($TiposIngresos as $TiposIngreso)
                <option value="{{$TiposIngreso->id_tipo_ingresos}}">{{$TiposIngreso->descripcion_ingresos}}</option>
            @endforeach>
        </select>
    </div>
    <div class="btn-group">
        <button id="btnLimpiarFiltros" class="form-control form-control-lg" onmouseover="this.style.color='red';" onmouseout="this.style.color='black';">
            <i class="fa fa-trash"></i>  LIMPIAR</button>
    </div>
            @can('cntc.ingresos.crear')
                <a class="btn btn-primary  float-right" title="Nuevo" href="{!! route('cntcingresos.create') !!}">
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
                        <th>Tipo de Combustible</th>
                        <th>Tipo de Ingreso</th>
                        <th>Cantidad</th>
                        <th>Ver</th>
                        <th>id_combustible</th>
                        <th>id_tipo_ingreso</th>
                    
                   
                    </tr>
                </thead>
                <tbody>
                @foreach ($solicitudes as $solicitud)

                    <tr>
                        <td>{{$solicitud->id_solicitud_ingreso}}</td>
                        <td>{{date('d-m-Y ', strtotime($solicitud->fecha_creacion))}}</td>
                        <td>{{$solicitud->descripcion_combustible}}</td>
                        <td>{{$solicitud->descripcion_ingresos}}</td>
                        <td>{{number_format($solicitud->cantidad,2)}}</td>
                      
                        <td>
                            @can('cntc.ingresos.ver')
                               <a href="{{ route('cntcingresos.show', $solicitud->id_solicitud_ingreso) }}" class="btn btn-primary">
                                <i class="fa fa-eye"></i> Ver
                            </a> 
                            @endcan
                            
                        </td>
                        <td>{{$solicitud->id_tipo_combustible}}</td>
                        <td>{{$solicitud->id_tipo_ingreso}}</td>
                       
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Tipo de Combustible</th>
                        <th>Tipo de Ingreso</th>
                        <th>Cantidad</th>
                        <th>Ver</th>
                        <th>id_combustible</th>
                        <th>id_tipo_ingreso</th>
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
       
        $(document).ready(function() 
        {

            // FILTRO COMBUSTIBLE
            $('#combustible-filter').on('change', function() {
                var selectedValue2 = $(this).val();
                var table=$('#datatable').DataTable(); 
                table.column(6).search(selectedValue2).draw(); 
            });

            // FILTRO CREADAS
            $('#ingresos-filter').on('change', function() {
                var selectedValue2 = $(this).val();
                var table=$('#datatable').DataTable(); 
                table.column(7).search(selectedValue2).draw(); 
            });

             // OCULTAR TABLAS
             $(document).ready(function() {
                var table=$('#datatable').DataTable();
                table.column(6).visible(false); 
                table.column(7).visible(false); 
            });
            // LIMPIAR FILTROS 
            $('#btnLimpiarFiltros').on('click', function() {
                var table = $('#datatable').DataTable();
                table.search('').columns().search('').draw();

                $("#ingresos-filter,#combustible-filter").val(function() {
                    return this.options[0].value;
                });
            });

        });
    </script>

@endsection