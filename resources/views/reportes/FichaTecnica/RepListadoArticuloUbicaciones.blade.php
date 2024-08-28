@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte de Articulos')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Reporte Salidas</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

@section('contenido')
<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>PARAMETROS DE BUSQUEDA</strong></h4>
    </div>
    <div class="card-block">
        <form method="GET" action="">
            {{-- @csrf --}}
            <div class="form-group row">
                <label class="col-sm-12 col-md-1 form-label">Almacenes</label>
                    <div class="col-md-3">
                        <select name="id_almacen" id="_almacenes" class="js-example-basic-single form-control @error('id_almacen') is-invalid @enderror">
                            <option value="0">Almacén</option>
                            @foreach ($almacenes as $almacen)
                                <option value="{{ $almacen->id_almacen }}"
                                    @if ($almacen->id_almacen == old('id_almacen')) selected="selected" @endif>
                                    {!! $almacen->nombre_almacen !!}</option>
                            @endforeach
                        </select>
                    </div>
                     <label class="col-sm-6 col-md-1 form-label">Sub Almacen</label>
                    <div class="col-md-3">
                        <div class="@error('id_subalmacen') is-invalid @enderror">
                            <select name="id_subalmacen" id="_subalmacenes"
                                data-old="{{ old('id_subalmacen') }}"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>
                   <label class="col-sm-6 col-md-1 form-label">Zonas</label>
                    <div class="col-md-3">
                        <div class="@error('id_ubicacion') is-invalid @enderror">
                            <select name="id_ubicacion" id="_zonas"
                                data-old="{{ old('id_ubicacion') }}"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="form-group row">
                <div class="col-md-1">
                </div>
                <div class="col-auto">
                    <input type="submit" value="Imprimir" name="pdf" class="btn btn-primary mt-1 mb-1">
                        {{-- <i class="fa fa-print"></i>Imprimir
                    </input> --}}
                </div>
            </div>
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Articulo</th>
                        <th>Almacen</th>
                        <th>Subalmacen</th>
                        <th>Zona</th>
                        <th>Ubicacion</th>
                        {{-- <th>Existencia</th> --}}
                    </tr>
                </thead>
                <tbody>
                @foreach ($ubicaciones as $ubicacion)

                    {{-- @php
                    $StockAlmacenes = App\Models\Articulo_MigracionModel::StockAlmacenesArticuloProfit($ubicacion->base_datos,$ubicacion->codigo_articulo );
                    @endphp --}}
                    <tr>  
                        <td>{{ $ubicacion->codigo_articulo }}</td>  
                        <td>{{ $ubicacion->nombre_articulo }}</td>
                        <td>{{ $ubicacion->nombre_almacen }}</td>
                        <td>{{ $ubicacion->nombre_subalmacen}}</td>
                        <td>{{ $ubicacion->nombre_ubicacion }}</td>
                        <td>{{ $ubicacion->zona }}</td>     
                        {{-- <td>
                            @foreach ($StockAlmacenes as $stock)

                                @if($stock->stock_act  > 0 )
                                    {{ number_format($stock->stock_act, 2, '.', '')}}
                                @endif

                            @endforeach  
                        </td>      --}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <!-- Select -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

    <!--Personalizado -->
    <script>
        var obtenersubalmacen = "{{ url('obtenersubalmacen') }}"; 
        var obtenerzonas = "{{ url('obtenerzonas') }}"; 
    </script>
    <script src="{{ asset('libraries\assets\js\FictUbicaciones.js') }}"></script>
@endsection