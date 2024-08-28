@extends('layouts.master')

@section('titulo', 'Plantillas Almacenes')

@section('titulo_pagina', 'Plantillas Almacenes')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item"><a href="{{ url('/') }}"> <i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}"></i>Reportes</a></li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="#!">Plantillas Almacenes</a> </li>
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
                        {{-- <option value="0">Almacenes</option> --}}
                        @foreach ($almacenes as $almacen)
                            <option value="{{ $almacen->id_almacen }}"
                                @if ($almacen->id_almacen == old('id_almacen',  $_GET['id_almacen'] ?? '')) selected="selected" @endif>
                                {!! $almacen->nombre_almacen !!}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-12 col-md-1 form-label">Plantillas</label>
                    <div class="col-sm-6 col-md-2">
                        <div class="@error('id_plantilla') is-invalid @enderror">
                            <select name="id_plantilla" id="_plantilla"
                            data-old =  {{(old('id_plantilla', $_GET['id_plantilla'] ??  'class="js-example-basic-single form-control "')) }} 
                                class="js-example-basic-single form-control " >
                                <option value='0' >Seleccione</option>
                            </select>
                        </div>
                    </div>

                <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-1 mb-1">
                         {{-- <i class="fa fa-search"></i>Buscar
                    </input> --}} 
                </div>
                @can('repo.cnth.plantillasalmacenes.pdf')
                <div class="col-auto">
                    <input type="submit" value="Imprimir" name="pdf" class="btn btn-primary mt-1 mb-1">
                        {{-- <i class="fa fa-print"></i>Imprimir
                    </input> --}}
                </div>
                @endcan


               



                {{-- @can('repo.asal.listadosalidas.excel')
                <div class="col-auto">
                    <input type="submit" value="Exportar" name="excel" class="btn btn-primary mt-1 mb-1" OnClick="">
                        {{-- <i class="fa fa-file-excel-o"></i>Exportar
                    </input> 
                </div>
                @endcan --}}
            </div>
        </form>
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="plantillasTable" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Nombre Plantilla</th>
                        <th>Id Herramienta</th>
                        <th>Nombre Herramienta</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($plantillas != null)
                    @foreach ($plantillas as $plantilla)
                    <tr>
                        <td>{{$plantilla->id_plantilla}}</td>
                        <td>{{$plantilla->nombre_plantilla}}</td>
                        <td>{{$plantilla->id_herramienta}}</td>
                        <td>{{$plantilla->nombre_herramienta}}</td>
                        <td>{{$plantilla->cantidad}}</td>
                       
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

    <script>
        var obtenerplantilla = "{{ url('plantillasalmacen') }}"; 

        function CargarPlantillas() {
        //console.log(e);
        var IdPlantilla = $('#_almacenes').val();

        $.get(obtenerplantilla+ '/' + IdPlantilla, function(data) {
            var old = $('#_plantilla').data('old') != '' ? $('#_plantilla').data('old') : '';
            $('#_plantilla').empty();
            $('#_plantilla').append('<option value="0">Seleccione Plantilla</option>');

            $.each(data, function(fetch, plantillas) {
                console.log(data);
                for (i = 0; i < plantillas.length; i++) {
                    $('#_plantilla').append('<option value="' + plantillas[i].id_plantilla + '"   ' + (old ==
                        plantillas[i].id_plantilla ? "selected" : "") + ' >'+ plantillas[i]
                        .id_plantilla + ' - ' + plantillas[i]
                        .nombre_plantilla + '</option>');
                }
            })

        })
    }

CargarPlantillas();
$('#_almacenes').on('change', CargarPlantillas);
    </script>

@endsection
