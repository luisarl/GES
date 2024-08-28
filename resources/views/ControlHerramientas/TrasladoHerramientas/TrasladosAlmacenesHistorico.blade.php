@extends('layouts.master')

@section('titulo', 'Historico Traslado')

@section('titulo_pagina', 'Historico Traslado')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('trasladosalmac/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="{{ asset('trasladosalmacenes/') }}">Traslados Almacenes</a>
    <li class="breadcrumb-item"><a href="#!">Historico Traslado</a> </li>
</ul>
@endsection

@section('contenido')

<div class="card">
    <div class="card-header">
        <h5>FILTRAR</h5>
    </div>
        <div class="card-block">
            <div class="">
                <div class="col-lg-12 col-xl-6">
                    <!-- Date card start -->    
                        <div class="card-block">
                            <form>
                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">FECHA INICIO</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control date" data-mask="99/99/9999">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">FECHA de CIERRE</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control date2" data-mask="99-99-9999">
                                    </div>
                                </div>
                            </form>
                        </div>
                    <!-- Date card end -->
                </div>
            </div>
        </div>
</div>

    <div class="card">
        <div class="card-header">
            <h5>LISTADO</h5>
        </div>
        <div class="card-block">
            <div class="dt-responsive table-responsive">
                <table id="datatable" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Almacen Principal</th>
                            <th>Herramienta</th>
                            <th>Codigo</th>
                            <th>Localizacion</th>
                            <th>Unidad</th>
                            <th>Existencia</th>
                            <th>Grupo</th>
                            <th>Almacen Secundario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00054712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>MANTENIMIENTO</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00780712</td>
                            <td>ZONA 7A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>0500402</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>13254002</td>
                            <td>ZONA 3B</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>07054712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>08054712</td>
                            <td>ZONA 4C</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>30054712</td>
                            <td>ZONA 3Z</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>01054712</td>
                            <td>ZONA 0A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00054724</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00032712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00454712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00084712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00034712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>EMBARCACIONES</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00014712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>MANTENIMIENTO</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00054012</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>MANTENIMIENTO</td>
                        </tr>
                        <tr>
                            <td>ALMACEN PRINCIPAL</td>
                            <td>PINZA DE PRESION QUIJADA</td>
                            <td>00004712</td>
                            <td>ZONA 4A</td>
                            <td>PIEZA</td>
                            <td>5</td>
                            <td>HERRAMIENTA</td>
                            <td>MANTENIMIENTO</td>
                        </tr>

                    </tbody>
                    <thead>
                        <tr>
                            <th>Almacen Principal</th>
                            <th>Herramienta</th>
                            <th>Codigo</th>
                            <th>Localizacion</th>
                            <th>Unidad</th>
                            <th>Existencia</th>
                            <th>Grupo</th>
                            <th>Almacen Secundario</th>
                        </tr>
                    </thead>
                </table>
                <a class="btn btn-primary " title="EXPORTAR" data-toggle="modal" data-target="#modal-migracion" href="#">
                    <i class="fa fa-download"></i>EXPORTAR</a>
                <a class="btn btn-primary " title="IMPRIMIR" data-toggle="modal" data-target="#modal-migracion" href="#">
                    <i class="fa fa-print"></i>IMPRIMIR</a>
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

    <!-- Masking js -->
    <script src="libraries\assets\pages\form-masking\inputmask.js"></script>
    <script src="libraries\assets\pages\form-masking\jquery.inputmask.js"></script>
    <script src="libraries\assets\pages\form-masking\autoNumeric.js"></script>
    <script src="libraries\assets\pages\form-masking\form-mask.js"></script>
    <!-- aqui empieza -->
@endsection
