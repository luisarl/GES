@extends('layouts.master')

@section('titulo', 'Despacho')

@section('titulo_pagina', 'Despacho de Herramientas')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item"><a href="{{ url('/dashboardcnth') }}"> <i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="#!">Despacho de Herramientas</a> </li>
</ul>
@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')

<div class="card">
    <div class="card-header">
        <h5>Listado de Despachos</h5>   

        {{-- SELECT DE HERRAMIENTAS--}}   
        <div class="btn-group" style="width: 400px">
            <select id="herramientas-filtro" class="form-control js-example-basic-single">
                <option value="0">BUSCAR POR HERRAMIENTA</option>
                @foreach($herramientas as $herramienta)
                    <option value="{{$herramienta->nombre_herramienta}}">{{$herramienta->nombre_herramienta}}</option>
                @endforeach
            </select>
        </div>

        {{-- FILTRO VER POR ESTATUS --}}   
        <div class="btn-group"> 
            <select id="estatus-filtro" class="form-control js-example-basic-single">
                <option value="" disabled selected>ESTATUS</option>
                <option value="DESPACHO">DESPACHO</option>
                <option value="RECEPCION">RECEPCION</option>
            </select>
        </div>

        {{-- FILTRO VER POR ZONAS --}}   
        <div class="btn-group col-sm-2"> 
            <select id="zonas-filtro" class="form-control js-example-basic-single">
                <option value="0" disabled selected>ZONAS</option>
                @foreach($zonas as $zona)
                    <option value="{{$zona->nombre_zona}}">{{$zona->nombre_zona}}</option>
                @endforeach
            </select>
        </div>

        {{-- BOTON PARA LIMPIAR FILTROS --}}
        <div class="btn-group">
            <button id="btnLimpiarFiltros" class="form-control form-control-lg" onmouseover="this.style.color='red';" onmouseout="this.style.color='black';">
                <i class="fa fa-trash"></i>  LIMPIAR</button>
        </div>
        
    
        @can('cnth.movimientos.crear')   
            <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('despachos.create') !!}">
                <i class="fa fa-plus"></i> Nuevo</a>   
        @endcan 
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="despachos" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nº</th>
                        <th>Almacen</th>
                        <th>Despachado Por</th>
                        <th>Recibido Por</th>
                        <th>Fecha</th>
                        <th>Zona</th>
                        <th>Estatus</th>
                        <th>Opciones</th>
                        <th style='visibility:collapse; display:none;'>Herramientas</th>
                    </tr>
                </thead>
                <tbody></tbody>
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
    
    <!-- Select -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

    <script>
            $('#modal-eliminar').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button que llama al modal
                var id = button.data('id') // Extrae la informacion de data-id
                var nombre = button.data('nombre') // Extrae la informacion de data-nombre
    
                action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
                action += id; // se agrega el id seleccionado al formulario
    
                $('#formdelete').attr('action', action); //cambia la ruta del formulario
    
                var modal = $(this)
                modal.find('.modal-body h5').text('Desea Eliminar el Despacho ' + nombre + ' ?') //cambia texto en el body del modal
            })
    </script>
<script>
    
    function format(d) 
    {
        var datos = d.herramientas; 
        return (
            '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' 
                +'<thead><th>Codigo</th><th>Nombre Herramienta</th><th>Cantidad Entrega</th><th>Cantidad Devuelta</th> </thead>'
               +datos
            +'</table>'
        );
    }
 
$(document).ready(function () {
    var dt = $('#despachos').DataTable({
        deferRender: true,
        paging: true,
        searching: true,
        ordering : true,
        pageLength : 10,
        ajax: "{{route('datosdespachos')}}" ,
        columns: [
            {
                class: 'details-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
            { data: 'id_movimiento'},
            { data: 'nombre_almacen' },
            { data: 'creado_por' },
            { data: 'responsable'},
            { data: 'created_at'},
            { data: 'nombre_zona'},
            { data: 'estatus',
                render: function (data, type, row) {

                   if(row.estatus == 'DESPACHO')
                   {
                        return '<label class="label label-danger">'+row.estatus+'</label>';
                   }
                   else if(row.estatus == 'RECEPCION')
                        {
                            return '<label class="label label-primary">'+row.estatus+'</label>';
                        }                 
                }
            },
            { data: 'id_movimiento',
                render: function (data, type, row) {
                  
                    if(row.estatus == 'RECEPCION')
                    {
                        return '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>'
                        + '<div class="dropdown-menu dropdown-menu-right b-none contact-menu">'
                        + '@can("cnth.movimientos.ver")<a class="dropdown-item" href="despachos/'+row.id_movimiento+'"><i class="fa fa-eye"></i>Ver</a>@endcan'
                        + '</div>';
                    }
                    else
                        {
                            return '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>'
                            + '<div class="dropdown-menu dropdown-menu-right b-none contact-menu">'
                            + '@can("cnth.movimientos.ver")<a class="dropdown-item" href="despachos/'+row.id_movimiento+'"><i class="fa fa-eye"></i>Ver</a>@endcan'
                            + '@can("cnth.movimientos.editar")<a class="dropdown-item" href="despachos/'+row.id_movimiento+'/edit"><i class="fa fa-edit"></i>Editar</a>@endcan'
                            + '@can("cnth.movimientos.recepcion")<a class="dropdown-item" href="recepcion/'+row.id_movimiento+'"><i class="fa fa-check-square-o"></i>Recepcion</a>@endcan'
                            + '</div>';
                        }                                 
                }

            },
            { data: 'herramientas', visible: false },
        ],
        order: [[1, 'desc']],
        lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, 'Todos']],
        columnDefs: [
            {
                targets: 8,
                className: 'dropdown',
            },
        ],
        "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
        //order: [[1, 'desc']],
    });
 
    // Array to track the ids of the details displayed rows
    var detailRows = [];
 
    $('#despachos tbody').on('click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = dt.row(tr);
        var idx = detailRows.indexOf(tr.attr('id'));
 
        if (row.child.isShown()) {
            tr.removeClass('shown');
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice(idx, 1);
        } else {
            tr.addClass('shown');
            row.child(format(row.data())).show();
 
            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }
    });
 
    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on('draw', function () {
        detailRows.forEach(function(id, i) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });
});

// FILTRO ZONAS 
$('#zonas-filtro').on('change', function() {
    var selectedValue = $(this).val();
    var table=$('#despachos').DataTable(); 
    table.column(6).search(selectedValue).draw(); 
});

// FILTRO ESTATUS 
$('#estatus-filtro').on('change', function() {
    var selectedValue = $(this).val();
    var table=$('#despachos').DataTable(); 
    table.column(7).search(selectedValue).draw(); 
});

// FILTRO HERRAMIENTAS
$('#herramientas-filtro').on('change', function() {
    var selectedValue2 = $(this).val();
    var table=$('#despachos').DataTable(); 
    table.column(9).search(selectedValue2).draw(); 
});

 // LIMPIAR FILTROS 
$('#btnLimpiarFiltros').on('click', function() {
    var table = $('#despachos').DataTable();
    table.search('').columns().search('').draw();
    

    $("#herramientas-filtro, #estatus-filtro").val(function() {
        return this.options[0].value;
    });
});
</script>

@endsection
