@extends('layouts.master')

@section('titulo', 'Articulos')

@section('titulo_pagina', 'Articulos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href=" {{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Ficha Tecnica</a> </li>
        <li class="breadcrumb-item"><a href="#!">Articulos</a> </li>
    </ul>
@endsection

@section('contenido')
    <!-- Scroll - Vertical table end -->
    @include('mensajes.MsjExitoso')
    @include('mensajes.MsjError')
    @include('FichaTecnica.Articulos.ArticulosDestroy')



    <!-- Scroll - Vertical table end -->
    <!-- Scroll - Vertical, Dynamic Height table start -->
    <div class="card">
        <div class="card-header">
            <h5>Listado de Articulos</h5>
            @can('fict.articulos.crear')
            <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('articulos.create') !!}">
                <i class="fa fa-plus"></i> Nuevo</a>
            @endcan
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="articulos" class="table table-striped table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Imagen</th>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Grupo</th>
                            <th>Fecha</th> 
                            <th>Creado por</th>
                            <th>Estatus</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Imagen</th>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Grupo</th>
                            <th>Fecha</th>
                            <th>Creado por</th>
                            <th>Estatus</th>
                            <th>Opciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- Scroll - Vertical, Dynamic Height table end -->


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

    <script type="text/javascript" src=" {{ asset('libraries\bower_components\lightbox2\js\lightbox.min.js') }} ">
    </script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })
    </script>

<script>

//FUNCION PARA REALIZAR SALTOS DE LINEAS ENTRE UNA CANITDAD DE CARACTERE
function wordWrap(str, maxWidth) {
    var newLineStr = "<br>"; done = false; res = '';
    while (str.length > maxWidth) {
        found = false;
        // Inserts new line at first whitespace of the line
        for (i = maxWidth - 1; i >= 0; i--) {
            if (testWhite(str.charAt(i))) {
                res = res + [str.slice(0, i), newLineStr].join('');
                str = str.slice(i + 1);
                found = true;
                break;
            }
        }
        // Inserts new line at maxWidth position, the word is too long to wrap
        if (!found) {
            res += [str.slice(0, maxWidth), newLineStr].join('');
            str = str.slice(maxWidth);
        }

    }

    return res + str;
}

function testWhite(x) {
    var white = new RegExp(/^\s$/);
    return white.test(x.charAt(0));
};


    $('#modal-eliminar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button que llama al modal
        var id = button.data('id') // Extrae la informacion de data-id
        var nombre = button.data('nombre') // Extrae la informacion de data-nombre

        action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
        action += id; // se agrega el id seleccionado al formulario

        $('#formdelete').attr('action', action); //cambia la ruta del formulario

        var modal = $(this)
        modal.find('.modal-body h5').text('Desea Eliminar el Articulo ' + nombre + ' ?') //cambia texto en el body del modal
    })


//LLENA DATA TABLA ARTICULOS
    $(document).ready(function() {
        var data = [];
        var articulos = {!! json_encode($articulos) !!};
        var i = 0;
        var estatus;
        var opciones;
        var nombre_articulo;
        var nombre_grupo;
        var imagen;


        articulos.forEach(element => {

            if (articulos[i].estatus == 'MIGRADO')
                {
                    estatus = '<label class="label label-primary" data-toggle="popover" data-placement="right"  data-original-title="CREADO POR:" data-content="' +articulos[i].creado_por+ '">MIGRADO</label>';
                }
                else if(articulos[i].estatus == 'NO MIGRADO')
                        {
                           estatus = '<label class="label label-warning" data-toggle="popover" data-placement="right" data-original-title="CREADO POR:" data-content="' +articulos[i].creado_por+ '">NO MIGRADO</label>';
                        }
                    else if(articulos[i].estatus == 'MIGRACION PENDIENTE')
                            {
                                estatus = '<label class="label label-danger" data-toggle="popover" data-placement="right" data-original-title="CREADO POR:" data-content="' +articulos[i].creado_por+ '">MIGRACION PENDIENTE</label>';
                            }
                            else if(articulos[i].estatus == 'APROBACION PENDIENTE')
                                    {
                                        estatus = '<label class="label label-warning" data-toggle="popover" data-placement="right" data-original-title="CREADO POR:" data-content="' +articulos[i].creado_por+ '">APROBACION PENDIENTE</label>';
                                    }

            if(articulos[i].activo == 'NO ')
            {
                estatus = '<label class="label label-inverse" data-toggle="popover" data-placement="right" data-original-title="CREADO POR:" data-content="' +articulos[i].creado_por+ '">ARTICULO INACTIVO</label>';
            }    
                            
            imagen =    '<div class="thumb">'
                            +'<a href="' +articulos[i].imagen_articulo + ' " data-lightbox="1"'
                                +  ' data-title="' +articulos[i].nombre_articulo + '">'
                                +  '<img src=" ' +articulos[i].imagen_articulo+ ' " alt="" class="img-fluid img-thumbnail img-40">'
                            +'</a>'
                        +'</div>';
            
            opciones = '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>'
                    + '<div class="dropdown-menu dropdown-menu-right b-none contact-menu">'
                    + '@can('fict.articulos.ver') <a class="dropdown-item" href="articulos/'+ articulos[i].id_articulo +' "><i class="fa fa-eye"></i>Ver</a> @endcan'
                    + '@can('fict.articulos.editar') <a class="dropdown-item" href="articulos/' + articulos[i].id_articulo +'/edit"><i class="fa fa-edit"></i>Editar</a> @endcan'
                    + '@can('fict.articulos.eliminar') <a class="dropdown-item" data-id=" ' + articulos[i].id_articulo + ' " data-nombre=" ' + articulos[i].nombre_articulo + ' "  data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a> @endcan'
                    + '</div>'
                    ;

            data.push( [articulos[i].id_articulo, imagen, articulos[i].codigo_articulo, wordWrap(articulos[i].nombre_articulo, 40),  wordWrap(articulos[i].nombre_grupo, 20), articulos[i].updated_at, articulos[i].creado_por, estatus, opciones] );
            i++;
        });

        $('#articulos').DataTable( {
            data:           data,
            deferRender:    true,
            paging: true,
            searching: true,
            ordering : true,
            pageLength : 10,
            order: [[5, 'desc']],
            lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, 'Todos']],
            columnDefs: [
                {
                    targets: 8,
                    className: 'dropdown',
                },
                {
                    targets: [5,6],
                    visible: false,
                },
                
            ],
            
            "fnDrawCallback" : function() {
                    $('[data-toggle="popover"]').popover(); 
            },

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
                }
        } );

    } );


</script>

@endsection
