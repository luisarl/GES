@extends('layouts.master')

@section('titulo', 'Stock')

@section('titulo_pagina', 'Listado de Herramientas')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item"><a href="{{ url('/dashboardcnth') }}"> <i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="#!">Stock Herramientas</a> </li>
</ul>
@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>PARAMETROS DE BUSQUEDA</strong></h4>
        <form method="GET" action="">
            <div class="form-group row">
                <label class="col-sm-12 col-md-1 form-label">Almacen</label>
                    <div class="col-sm-6 col-md-2">
                        <select name="id_almacen" id="_almacenes" class="js-example-basic-single form-control @error('id_almacen') is-invalid @enderror">
                            <option value="0">Almacenes</option>
                            @foreach ($almacenes as $almacen)
                                <option value="{{ $almacen->id_almacen }}"
                                    @if ($almacen->id_almacen == old('id_almacen',  $_GET['id_almacen'] ?? '')) selected="selected" @endif>
                                    {!! $almacen->nombre_almacen !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <select name="herramientas" id="herramientas" class="js-example-basic-single form-control @error('herramientas') is-invalid @enderror">
                            <option value="0">Herramientas</option>
                            <option value="TODAS">TODAS</option>
                        </select>
                    </div>

                    <div class="col-auto">
                        <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-1 mb-1">
                    </div>
                    @can('repo.cnth.listadoherramientas.pdf')
                        <div class="col-auto">
                            <input type="submit" value="Imprimir" name="pdf" class="btn btn-primary mt-1 mb-1">
                        </div>
                    @endcan
            </div>
        </form>
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="despachos" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Almacen</th>
                        <th style="width:5%">ID</th>
                        <th style="width:20%">Nombre Herramienta</th>
                        <th>Stock Actual</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($stock != null)
                        @foreach ($stock as $stocks)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$stocks->nombre_almacen}}</td>
                            <td style="width:5%">{{$stocks->id_herramienta}}</td>
                            <td style="width:20%">{{$stocks->nombre_herramienta}}</td>
                            <td>{{$stocks->stock_actual}}</td>
                        </tr>
                        @endforeach
                    @endif
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
     <!-- Personalizado -->
     <script>
        var RutaServicios = "{{ url('embaserviciosdepartamento') }}";
    </script>
    
    <script>
        // LLENA EL SELECT ALMACENES
        function SelectAlmacenesHerramienta() {
            var RutaHerramientas = "{{ url('repherramientasalmacen') }}";
            var id_almacen = $('#_almacenes').val();
            var selectedHerramienta = "{{ old('herramientas', $_GET['herramientas'] ?? '') }}"; // Captura el valor previamente seleccionado
    
            $.get(RutaHerramientas + '/' + id_almacen, function(data) {
                $('#herramientas').empty();
                $('#herramientas').append('<option value="0">Seleccione Herramienta</option>');
                $('#herramientas').append('<option value="TODAS" ' + (selectedHerramienta == 'TODAS' ? "selected" : "") + '>TODAS</option>');
                $.each(data, function(fetch, herramientas) {
                    for (var i = 0; i < herramientas.length; i++) {
                        $('#herramientas').append('<option value="' + herramientas[i].id_herramienta + '" ' + (selectedHerramienta == herramientas[i].id_herramienta ? "selected" : "") + '>' + herramientas[i].id_herramienta + ' - ' + herramientas[i].nombre_herramienta + '</option>');
                    }
                });
            });
        }
    
        SelectAlmacenesHerramienta();
        $('#_almacenes').on('change', SelectAlmacenesHerramienta);
    </script>
@endsection

