@extends('layouts.master')

@section('titulo', 'Traslado entre Almacenes')

@section('titulo_pagina', 'Traslado entre Almacenes')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
        <li class="breadcrumb-item"><a href="#!">Traslado entre Almacenes</a> </li>
    </ul>
@endsection

@section('contenido')
    <!-- Page-header end -->

    <!-- Page-body start -->
    <div class="page-body">
        <!-- Edit With Click card start -->
        <div class="card">
            <div class="card-header">
                <h5>AGREGAR PRODUCTOS</h5>
                <a class="btn btn-primary " title="Historial de Traslado" href="{!! route('trasladoshistorico') !!}">
                    <i class="fa fa-history"></i>Historial</a>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="example-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ARTICULO</th>
                                <th>UBICACION</th>
                                <th>STOCK</th>
                                <th>ALMACENES PRINCIPAL</th>
                                <th>ALMACENES DESTINO</th>
                            </tr>
                        </thead>
                        <tbody>
       
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-primary waves-effect waves-light add" onclick="add_row();">AGREGAR OTRO
                </button>
                <div class="d-grid gap-2 d-md-block float-right">

                    <button type="submit" class="btn btn-primary ">
                        <i class="fa fa-save"></i>Guardar
                    </button>
                </div>
            </div>
        </div>
        <!-- 
        <div class="card">
            <div class="card-header">
                <h5>Edit With Button</h5>
                <span>Click on buttons to perform actions</span>

            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="example-2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First</th>
                                <th>Last</th>
                                <th>Nickname</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td class="tabledit-view-mode"><span class="tabledit-span">Mark</span>
                                    <input class="tabledit-input form-control input-sm" type="text" name="First"
                                        value="Mark">
                                </td>
                                <td class="tabledit-view-mode"><span class="tabledit-span">Otto</span>
                                    <input class="tabledit-input form-control input-sm" type="text" name="Last"
                                        value="Otto">
                                </td>
                                <td class="tabledit-view-mode"><span class="tabledit-span">@mdo</span>
                                    <select class="tabledit-input form-control input-sm" name="Nickname" disabled=""
                                        style="display:none;">
                                        <option value="1">@mdo</option>
                                        <option value="2">@fat</option>
                                        <option value="3">@twitter</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </button>
        </div>-->

    </div>
    <!-- Page-body end -->


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


        <!-- prueba -->
        <!-- Editable-table js -->
        <script type="text/javascript" src="libraries\assets\pages\edit-table\jquery.tabledit.js"></script>
        <script type="text/javascript" src="libraries\assets\pages\edit-table\editable.js"></script>
        <!-- i18next.min.js -->

        
        <!-- aqui empieza -->
    @endsection
