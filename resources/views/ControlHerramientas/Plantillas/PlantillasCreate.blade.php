@extends('layouts.master')

@section('titulo', 'Crear Plantilla')

@section('titulo_pagina', 'Crear Plantilla')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('plantillas.index') }}">Plantillas</a></li>
    <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Crear Plantilla</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form class="" method="POST" action=" {{ route('plantillas.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Almacen</label>
                <div class="col-md-10 col-lg-10 @error('id_almacen') is-invalid @enderror">
                    <select name="id_almacen" id="_almacenes"
                        class="js-example-basic-single form-control">
                        <option value="0">Seleccione el almacen</option>
                        @foreach ($almacenes as $almacen)
                        <option value="{{ $almacen->id_almacen }}" @if ($almacen->id_almacen ==
                            old('id_almacen')) selected = "selected" @endif>
                            {!! $almacen->nombre_almacen !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_plantilla') is-invalid @enderror"
                        name="nombre_plantilla" value="{{ old('nombre_plantilla') }}"
                        placeholder="Ingrese el Nombre de la Plantilla">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="3" cols="3"
                        class="form-control @error('descripcion_plantilla') is-invalid @enderror"
                        name="descripcion_plantilla"
                        placeholder="Ingrese la Descripción de la Plantilla">{{ old('descripcion_plantilla') }}</textarea>
                </div>
            </div>
            <h4 class="sub-title">Herramientas</h4>
            <div class="form-group row">
                <div class="col-md-4 col-lg-4" id="scrollable-dropdown-menu">
                    <label for="herramienta" class="block" id="scrollable-dropdown-menu">Herramienta</label>
                    <select name="id_herramienta" id="_herramientas" data-old="{{ old('id_herramienta') }}"
                        class="js-example-basic-single form-control" onchange="StockHerramienta();">
                        <option value="0">Seleccione</option>
                    </select>
                </div>
                <div class="col-md-1 col-md-1">
                    <label for="existencia" class="block">Existencia</label>
                    <input type="number"
                        class="form-control form-control-bold form-control-uppercase @error('') is-invalid @enderror"
                        name="existencia" id="existencia" value="" placeholder="" readonly>
                </div>
                <div class="col-md-2 col-lg-2">
                    <label for="cantidad" class="block">Cantidad</label>
                    <input type="number"
                        class="form-control form-control-bold form-control-uppercase @error('cantidad') is-invalid @enderror"
                        name="cantidad" id="cantidad" value="{{ old('cantidad') }}" placeholder="Cantidad" min="1"
                        max="">
                </div>
                <div class="col-md-2 col-lg-2">
                    <label for="name-2" class="block">Agregar</label>
                    <br>
                    <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTabla()">
                        <i class="fa fa-plus"></i> </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="tablaajuste">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Herramienta</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <hr>
            {{-- Campo oculto con arreglo de los datos adicionales --}}
            <input type="hidden" name="datosmovimiento" id="datosmovimiento">
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
    var HerramientasAlmacen = "{{ url('herramientasalmacen') }}";
</script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\CnthPlantillas.js') }}"></script>

@endsection