@extends('layouts.master')

@section('titulo', 'Autorización de Salida')

@section('titulo_pagina', 'Crear Solicitud de Despacho')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Resguardo</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('resgdespachos.index') }}">Solicitud de Despacho</a> </li>
    <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>DETALLE</strong></h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('resgdespachos.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 form-label">Almacen Responsable</label>
                <div class="col-sm-4 @error('id_almacen') is-invalid @enderror">
                    <select name="id_almacen" id="id_almacen"
                        class="js-example-basic-single form-control">
                        <option value="0">SELECCIONE EL ALMACEN</option>
                        @foreach ($almacenes as $almacen)
                        <option value="{{$almacen->id_almacen}}" @if ($almacen->id_almacen == old('id_almacen')) selected = "selected" @endif>
                            {{$almacen->nombre_almacen}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-2 form-label">Destino</label>
                <div class="col-sm-4">
                    <input type="text" name="ubicacion_destino" id="ubicacion_destino" class="form-control @error('ubicacion_destino') is-invalid @enderror" 
                    value="{{ old('ubicacion_destino') }}" placeholder="Ingrese el Destino">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-label">Responsable</label>
                <div class="col-sm-4 @error('responsable') is-invalid @enderror">
                    <select name="responsable" class="js-example-basic-single form-control">
                        <option value="0">SELECCIONE EL RESPONSABLE</option>
                        @foreach($empleados as $empleado)
                            <option value="{{$empleado->Empleado}}" @if ($empleado->Empleado == old('responsable')) selected = "selected" @endif>
                                {{$empleado->Empleado}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-2 col-form-label">Observacion</label>
                <div class="col-md-4 col-lg-4">
                    <textarea rows="3" cols="3" class="form-control @error('observacion') is-invalid @enderror" name="observacion"
                        id="observacion" placeholder="Ingrese la Observacion">{{ old('observacion') }}</textarea>
                </div>
            </div>
            <h4 class="sub-title">Articulos</h4>
            <div class="form-group row">
                <div class="col-md-8 col-lg-8">
                    <label for="articulos" class="block" id="scrollable-dropdown-menu">Articulos</label>
                    <select name="id_articulo" id="id_articulo" data-old="{{ old('id_articulo') }}"
                        class="js-example-basic-single form-control" onchange="StockArticulo()">
                        <option value="0">Seleccione Articulo</option>
                    </select>
                </div>
                <div class="col-md-1 col-lg-1">
                    <label for="cantidad" class="block">Cantidad</label>
                    <input type="hidden" name="stock_actual" id="stock_actual">
                    <input type="number"
                        class="form-control @error('cantidad') is-invalid @enderror"
                        name="cantidad" id="cantidad" value="{{ old('cantidad') }}" min="0.10" step="0.10">   
                </div>
                <div class="col-md-1 col-lg-1">
                    <label for="name-2" class="block">Agregar</label>
                    <br>
                    <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTabla()">
                        <i class="fa fa-plus"></i> </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="tablaarticulos">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Articulo</th>
                            <th>Presentacion</th>
                            <th>Cantidad Disp</th>
                            <th>Cantidad Solc</th>
                            <th>Estado</th>
                            <th>Disposicion Final</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <hr>
            {{-- Campo oculto con arreglo de los datos adicionales --}}
            <input type="hidden" name="articulos" id="articulos">
            <div class="d-grid gap-2 d-md-block float-right">

                <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla()">
                    <i class="fa fa-save"></i>Guardar
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<!-- personalizado -->
<script>
    var BuscarArticulos = "{{ url('resgarticulosalmacen') }}"; 
</script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\ResgDespachos.js') }}"></script>


@endsection