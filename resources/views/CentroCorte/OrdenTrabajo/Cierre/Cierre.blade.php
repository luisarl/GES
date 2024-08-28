@extends('layouts.master')

@section('titulo', 'Cierre')

@section('titulo_pagina', 'Cierre')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Centro de Corte</a> </li>
    <li class="breadcrumb-item"><a href="#!">Cierre</a> </li>
</ul>
@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjError')

<div class="card">
    {{-- <div class="card-header">
        <h5>Listado de Cierre</h5>
        <div class="btn-group"> 
            <select id="estatus-filter" class="form-control">
                <option value="" disabled selected>ESTATUS</option>
                <option value="EJECUTADO">EJECUTADO</option>
                <option value="EN PROCESO">EN PROCESO</option>
                <option value="PAUSADO">PAUSADO</option>
                <option value="ANULADO">ANULADO</option>
            </select>
        </div>
        <div class="btn-group">
            <button id="btnLimpiarFiltros" class="form-control form-control-lg" onmouseover="this.style.color='red';" onmouseout="this.style.color='black';">
                <i class="fa fa-trash"></i>  LIMPIAR</button>
        </div>
    </div> --}}
   
    <div class="card-block">
        <div class="table-responsive dt-responsive">
            <table id="datatable" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Id Seguimiento</th>
                        <th>Fecha</th>
                        <th>Creado por</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                 @foreach ($Cierre as $Cierres)
                    <tr>
                    <td>{{$Cierres->id_cierre}}</td>
                    <td>{{$Cierres->id_seguimiento}}</td>
                    <td>{{date('d-m-Y g:i A', strtotime($Cierres->created_at))}}</td>
                    <td>{{$Cierres->name}}</td>
                    <td class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @if ($Cierres->estatus != 'FINALIZADO')
                                    <a class="dropdown-item" target="_blank" href="{{ route('cenccierre.create', ['IdCierrePlancha' => $Cierres->id_cierre_planchas]) }}">
                                        <i class="fa fa-edit"></i>Registrar</a>
                                @endif
                                    <a class="dropdown-item" target="_blank" href="{{ route('cenccierre.show', $Cierres->id_cierre_planchas) }}">
                                        <i class="fa fa-eye"></i>Ver</a>
                                    <a class="dropdown-item" target="_blank" href=" {{ route('cenccierrepdf', $Cierres->id_cierre_planchas) }}"><i
                                            class="fa fa-print"></i>Imprimir</a>
                            </div>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Id Seguimiento</th>
                        <th>Fecha</th>
                        <th>Creado por</th>
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
            modal.find('.modal-body h5').text('Desea Anular el Conap ' + id + ' ?') //cambia texto en el body del modal
        })
    </script>

    <script>
       
        $(document).ready(function() 
        {

            // FILTRO ESTATUS 
            $('#estatus-filter').on('change', function() {
                var selectedValue = $(this).val();
                var table=$('#datatable').DataTable(); 
                table.column(3).search(selectedValue).draw(); 
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