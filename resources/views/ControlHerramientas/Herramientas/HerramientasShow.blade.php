@extends('layouts.master')

@section('titulo', 'Detalle de la Herramienta')

@section('titulo_pagina', 'Detalle de Herramienta')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item"><a href="{{ url('/dashboardcnth') }}"> <i class="feather icon-home"></i> </a>
        </li><li class="breadcrumb-item"><a href="{{ url('/herramientas') }}">Herramientas</a> </li>
    </li><li class="breadcrumb-item"><a href="#">Detalle de Herramienta</a> </li>
    </ul>
@endsection

@section('contenido')

    <div class="page-body">
        <div class="card">
            <div class="card-header">
                <div class="row card-header">  
                    <div class=" col-6">
                        <h4>{{$herramientas->nombre_herramienta}} Nº {{$herramientas->id_herramienta}}                        
                        </h4> 
                    </div>
                </div>
                <div class="page-body">
                <div class="row">
                    <div class="col-12"> 
                        <hr> 
                    </div>
                    <div class="col-md-8">
                        <div class="invoice-box row">
                            <div class="col-sm-12">
                                <table class="table table-responsive invoice-table table-borderless">
                                    <tbody>
                                        <tr>
                                            <th>NOMBRE: {{$herramientas->nombre_herramienta}}</th>
                                        </tr>
                                        <tr>
                                            <th>CODIGO: {{$herramientas->codigo_herramienta}}</th>
                                        </tr>
                                        <tr>
                                            <th>GRUPO: {{$herramientas->nombre_grupo}}</th>
                                        </tr>
                                        <tr>
                                            <th>SUBGRUPO: {{$herramientas->nombre_subgrupo}}</th>
                                        </tr>
                                        <tr>
                                            <th>CATEGORIA: {{$herramientas->nombre_categoria}}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="thumbnail">
                            <div class="thumb">
                                <a href="" data-lightbox="1" data-title="">
                                    <img src="{{ asset($herramientas->imagen_herramienta) }}" alt="" width="200px"
                                        height="200px" class="img-fluid img-thumbnail">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Ubicación</h4>
                    <table id="demo-foo-filtering" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ALMACEN</th>
                                <th>UBICACION</th>
                                <th>EXISTENCIA</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($almacenes as $almacen)
                            <tr>
                                <td>{{$almacen->nombre_almacen}}</td>
                                <td>{{$almacen->nombre_ubicacion}}</td>
                                <td>{{$almacen->stock_actual}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Historico</h4>
                    <table id="demo-foo-filtering" class="table table-striped">
                        <thead>
                            <tr>
                                <th>MOVIMIENTO</th>
                                <th>ALMACEN</th>
                                <th>USUARIO</th>
                                <th>FECHA</th>
                                <th>TIPO MOVIMIENTO</th>
                                <th>ENTRADA</th>
                                <th>SALIDA</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($HistoricoHerramienta as $historico)
                            <tr>
                                <td>{{$historico->movimiento}}</td>
                                <td>{{$historico->nombre_almacen}}</td>
                                <td>{{$historico->usuario}}</td>
                                <td>{{$historico->fecha}}</td>
                                <td>{{$historico->tipo_movimiento}}</td>
                                <td>{{$historico->entrada}}</td>
                                <td>{{$historico->salida}}</td>
                            </tr>
                        @endforeach
                        </tbody>
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

    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })
    </script>

@endsection
