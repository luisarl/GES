@extends('layouts.master')

@section('titulo', 'Creacion de Solicitudes')

@section('titulo_pagina', 'Entrega de Herramienta')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Despacho Solicitud</a> </li>
    </ul>
@endsection

@section('contenido')

    <div class="page-body">
        <div class="card">
            <div class="card-header">
                <h4 class="sub-title">Datos de la Solicitud</h4>
                <div class="form-group row">
                    <label class="col-md-2 col-lg-2 col-form-label">Motivo de la Solcitud</label>
                    <div class="col-md-4 col-lg-4">
                        <p> Herramientas para proyectos bajo la supervicion de la Gerencia de Sistema</p>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3">

                        <div class="thumbnail">
                            <div class="thumb">
                                <a href="" data-lightbox="1" data-title="">
                                    <img src="{{ asset('images/articulos/nodisponible.jpg') }}" alt="" width="200px"
                                        height="200px" class="img-fluid img-thumbnail">
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-block">
                    <div class="row invoive-info">
                        <div class="col-md-4 col-sm-6">
                            <h6>Informacion Solicitante:</h6>
                            <table class="table table-responsive invoice-table invoice-order table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Solicitante : </th>
                                        <td> Angel Ruiz</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha De :</th>
                                        <td>9/9/2022</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <h6>Informacion Responsable:</h6>
                            <table class="table table-responsive invoice-table invoice-order table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Responsable : </th>
                                        <td> Luis Romero</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha Hasta :</th>
                                        <td>9/9/2022</td>
                                    </tr>
                                    <tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <h6>Informacion Solicitud:</h6>
                            <table class="table table-responsive invoice-table invoice-order table-borderless">
                                <tbody>
                                    <th>Estatus :</th>
                                    <td>
                                        <span class="label label-warning">Pendiente</span>
                                    </td>
                                    </tr>
                                    <tr>
                                        <th>Solicitud :</th>
                                        <td>
                                            #145
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <h5>LISTADO HERRAMIENTAS</h5>
            </div>
            <div class="page-body">
                <div class="card-block">
                    <table id="demo-foo-filtering" class="table table-striped">
                        <thead>
                            <tr>
                                <th>HERRAMIENTA</th>
                                <th>UNIDAD</th>
                                <th>CANTIDAD</th>
                                <th>RESPONSABLE</th>
                                <th>ALMACEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>MARTILLO</td>
                                <td>UND</td>
                                <td>2</td>
                                <td>LUIS ROMERO</td>
                                <td><span class="tag tag-danger"> ALMACEN PRINCIPAL</span>
                                </td>
                            </tr>
                            <tr>
                                <td>DESTORNILLADOR</td>
                                <td>UND</td>
                                <td>6</td>
                                <td>LUIS ROMERO</td>
                                <td><span class="tag tag-danger"> ALMACEN PRINCIPAL</span>
                                </td>
                            </tr>
                            <tr>
                                <td>MULTIMETRO</td>
                                <td>UND</td>
                                <td>2</td>
                                <td>LUIS ROMERO</td>
                                <td><span class="tag tag-default">ALMACEN PRINCIPAL</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Kelly</td>
                                <td>UND</td>
                                <td>5</td>
                                <td>LUIS ROMERO</td>
                                <td><span class="tag tag-success">ALMACEN PRINCIPAL</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Airi Satou</td>
                                <td>UND</td>
                                <td>1</td>
                                <td>LUIS ROMERO</td>
                                <td><span class="tag tag-success"> ALMACEN PRINCIPAL</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Brielle</td>
                                <td>UND</td>
                                <td>1</td>
                                <td>LUIS ROMERO</td>
                                <td><span class="tag tag-default">ALMACEN PRINCIPAL</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Herrod Chandler</td>
                                <td>UND</td>
                                <td>2</td>
                                <td>DAVID AGUILERA</td>
                                <td><span class="tag tag-danger">ALMACEN PRINCIPAL</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Rhona Davidson</td>
                                <td>UND</td>
                                <td>1</td>
                                <td>DAVID AGUILERA</td>
                                <td><span class="tag tag-success"> ALMACEN PRINCIPAL</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row text-center">
                        <div class="col-sm-12 invoice-btn-group text-center">
                            <button type="button"
                                class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">DESPACHAR</button>
                            {{-- <button type="button" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light">Cancel</button> --}}
                        </div>
                    </div>
                </div>
                <!-- Filtering Foo-table card end -->
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
    <script src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
    </script>
    <!-- Custom js -->
    <script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>
    <!-- sweet alert js -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>
    <!-- Editable-table js -->
    <script type="text/javascript" src="libraries\assets\pages\edit-table\jquery.tabledit.js"></script>
    <script type="text/javascript" src="libraries\assets\pages\edit-table\editable.js"></script>

@endsection
