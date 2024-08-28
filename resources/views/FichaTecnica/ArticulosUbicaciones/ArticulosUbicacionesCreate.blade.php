@extends('layouts.master')

@section('titulo', 'Zona de Articulo')

@section('titulo_pagina', 'Zona de Articulo')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Ficha Tecnica</a> </li>
        <li class="breadcrumb-item"><a href="#!">Asignar Zona de Articulo</a> </li>
    </ul>

@endsection

@section('contenido')

@include('mensajes.MsjError')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjValidacion')

<form class="" method="POST" action=" {{ route('articulosubicaciones.store') }}">
    @csrf
    <div class="card">
        <div class="card-block">

            <h6 class="sub-title">Filtros</h6>
            <div class="row">
                <div class="col-xl-6 col-lg-12 ">
                    <h6 class="sub-title">Parametros</h6>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Codigo Articulo</label>
    
                        <div class="col-sm-10">
                            <input type="number" min="1"
                                class="form-control form-control-bold form-control-uppercase @error('') is-invalid @enderror"
                                name="codigo_articulo" id='_codigoarticulo'
                                value="NULL" 
                                placeholder="Ingrese el Codigo ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nombre Articulo</label>
    
                        <div class="col-sm-10" id="scrollable-dropdown-menu">
                            <input type="text"
                                class="typeahead form-control form-control-bold form-control-uppercase @error('nombre_articulo') is-invalid @enderror"
                                name="nombre_articulo" id='nombre_articulo' autocomplete="off"
                                placeholder="Ingrese el Nombre" onchange="ObtenerCodigoArticulo()">
                        </div>
                    </div>     
                    <div class="form-group row">
                        <div class="col-md-2 col-lg-2">
                            <label for="name-2" class="block">Categoria</label>
                        </div>
                        <div class="col-md-10 col-lg-10 @error('id_categoria') is-invalid @enderror">
                            <select name="id_categoria" id="_categorias"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione la Categoria</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}"
                                        @if ($categoria->id_categoria == old('id_categoria')) selected = "selected" @endif>
                                        {{$categoria->codigo_categoria}} - {!! $categoria->nombre_categoria !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 col-lg-2">
                            <label for="name-2" class="block">Grupos</label>
                        </div>
                        <div class="col-md-10 col-lg-10 @error('id_grupo') is-invalid @enderror">
                                <select name="id_grupo" id="_grupos"
                                class="js-example-basic-single form-control">
                                <option value="0">Seleccione el Grupo </option>
                                @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->id_grupo }}"
                                        @if ($grupo->id_grupo == old('id_grupo')) selected = "selected" @endif>
                                        {{$grupo->codigo_grupo}} - {!! $grupo->nombre_grupo !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>  

                <div class="col-xl-6 col-lg-12 ">
                    <h6 class="sub-title">Ubicaciones</h6>
                    <div class="form-group row">
                        <label for="almacenes" class="col-sm-2 col-form-label">Almacenes</label>
                        <div class="col-sm-10 @error('id_almacen') is-invalid @enderror">
                            <select name="id_almacen" id="_almacenes" class="js-example-basic-single form-control">
                                <option value="0">Seleccione el Almacén</option>
                                @foreach ($almacenes as $almacen)
                                    <option value="{{ $almacen->id_almacen }}"
                                        @if ($almacen->id_almacen == old('id_almacen')) selected="selected" @endif>{!! $almacen->id_almacen !!} -
                                        {!! $almacen->nombre_almacen !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subalmacenes" class="col-sm-2 col-form-label">Subalmacen</label>
                        <div class="col-sm-10 @error('id_subalmacen') is-invalid @enderror">
                            <select name="id_subalmacen" id="_subalmacenes"
                                data-old="{{ old('id_subalmacen') }}"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>
            
                    <div class="form-group row">
                        <div class="col-md-2 col-lg-2">
                            <label for="zonas" class="block">Zonas</label>
                        </div>
                        <div class="col-sm-10 @error('id_ubicacion') is-invalid @enderror">
                            <select name="id_ubicacion" id="_zonas"
                                data-old="{{ old('id_ubicacion') }}"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>   
                </div> 
            </div>
            <hr>
            <div class="float-right">
                <button onclick="FiltroArticulosUbicaciones()" class="form-control btn btn-primary"
                    id='botonImportar' type="button">
                    <i class="fa fa-search"></i> Buscar 
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-block">    
            <h6 class="sub-title">ARTICULOS</h6>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="tabla_almacenes">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Articulo</th>
                            <th>Ubicacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{-- Campo oculto con arreglo de los datos adicionales --}}
            <input type="hidden" name="datosarticulos" id="datosarticulos">
            <div class="d-grid gap-2 d-md-block float-right">
                <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla()">
                    <i class="fa fa-save"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')

    <!-- Select -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
    
    <!--Bootstrap Typeahead js -->
    <script src=" {{ asset('libraries\bower_components\bootstrap-typeahead\js\bootstrap-typeahead.min.js') }}" ></script>
    
    <!--Personalizado -->   
    <script>
        var route = "{{ url('autocompletararticulo') }}"; 
        var obtenersubalmacen = "{{ url('obtenersubalmacen') }}"; 
        var obtenerzonas = "{{ url('obtenerzonas') }}"; 
        var FiltroArticulos = "{{ url('filtroarticulosubicaciones') }}"
    </script>
    <script src="{{ asset('libraries\assets\js\FictUbicaciones.js') }}"></script>

@endsection