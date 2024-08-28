@extends('layouts.master')

@section('titulo', 'Autorización de Salida')

@section('titulo_pagina', 'Editar Solicitud de Despacho')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Resguardo</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('resgdespachos.index') }}">Solicitud de Despacho</a> </li>
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('Resguardo.Despachos.DespachosAprobar')
@include('Resguardo.Despachos.DespachosProcesar')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>DETALLE</strong>
            <a href="{{ route('resgimprimirsolicituddespacho', $solicitud->id_solicitud_despacho) }}" target="_blank" type="button"
                class="btn btn-primary btn-sm" title="Imprimir">
                <i class="fa fa-print fa-2x"></i> </a>
        </h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('resgdespachos.update', $solicitud->id_solicitud_despacho) }}">
            @csrf @method('put')
            <div class="form-group row">
                <label class="col-sm-2 form-label">Almacen Responsable</label>
                <div class="col-sm-4 @error('id_almacen') is-invalid @enderror">
                    <select name="id_almacen" id="id_almacen"
                        class="js-example-basic-single form-control" readonly>
                        <option value="0">SELECCIONE EL ALMACEN</option>
                        @foreach ($almacenes as $almacen)
                        <option value="{{$almacen->id_almacen}}" @if ($almacen->id_almacen == old('id_almacen', $solicitud->id_almacen )) selected = "selected" @endif>
                            {{$almacen->nombre_almacen}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-2 form-label">Destino</label>
                <div class="col-sm-4">
                    <input type="text" name="ubicacion_destino" id="ubicacion_destino" class="form-control @error('ubicacion_destino') is-invalid @enderror" 
                    value="{{ old('ubicacion_destino', $solicitud->ubicacion_destino) }}" {{$procesado}}>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-label">Responsable</label>
                <div class="col-sm-4 @error('responsable') is-invalid @enderror">
                    <select name="responsable"
                        class="js-example-basic-single form-control" {{$procesado}}>
                        <option value="0">SELECCIONE EL RESPONSABLE</option>
                        @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->Empleado }}" @if ($empleado->Empleado  == old('responsable', $solicitud->responsable ?? '')) selected = "selected" @endif>
                            {{ $empleado->Empleado }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-2 col-form-label">Observacion</label>
                <div class="col-md-4 col-lg-4">
                    <textarea rows="3" cols="3" class="form-control @error('observacion') is-invalid @enderror" name="observacion"
                        id="observacion" placeholder="Ingrese la Observacion" {{$procesado}}>{{ old('observacion', $solicitud->observacion) }}</textarea>
                </div>
            </div>
            <h4 class="sub-title">Articulos</h4>
            @if($solicitud->estatus != 'PROCESADO')    
                <div class="form-group row">
                    <div class="col-md-8 col-lg-8" id="id_articulo_interno">
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
                            name="cantidad" id="cantidad" value="{{ old('cantidad') }}" min="1">   
                    </div>
                    <div class="col-md-1 col-lg-1">
                        <label for="name-2" class="block">Agregar</label>
                        <br>
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTabla()">
                            <i class="fa fa-plus"></i> </button>
                    </div>
                </div>
            @endif
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
                        @foreach($articulos as $articulo)
                            <tr>
                                <td id="id_solicitud_despacho_detalle" style='visibility:collapse; display:none;'>{{$articulo->id_solicitud_despacho_detalle}}</td>
                                <td id="id_resguardo" style='visibility:collapse; display:none;'>{{$articulo->id_resguardo}}</td>
                                <td id="codigo_articulo">{{$articulo->codigo_articulo}}</td>
                                <td id="nombre_articulo">{{$articulo->nombre_articulo}}</td>
                                <td id="tipo_unidad">{{$articulo->tipo_unidad}}</td>
                                <td id="cantidad_disponible">{{number_format($articulo->cantidad_disponible, 2)}}</td>
                                <td id="cantidad">{{number_format($articulo->cantidad, 2)}}</td>
                                <td id="estado">{{$articulo->estado}}</td>
                                <td id="disposicion_final">{{$articulo->nombre_clasificacion}}</td>
                                <td>
                                    @if($solicitud->estatus != 'PROCESADO')
                                    <button type="button" onclick="EliminarDetalle({{ $articulo->id_solicitud_despacho_detalle }})"
                                        class="borrar btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <hr>
            {{-- Campo oculto con arreglo de los datos adicionales --}}
            <input type="hidden" name="articulos" id="articulos">
            <div class="d-grid gap-2 d-md-block float-right">
                @if($solicitud->estatus == 'POR APROBACION')
                @can('resg.soldespacho.aprobar')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-aprobar">
                        <i class="fa fa-check"></i>Aprobar
                    </button>
                    @endcan
                @endif

                @if($solicitud->estatus == 'APROBADO')
                    @can('resg.soldespacho.procesar')
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-procesar">
                            <i class="fa fa-check-square"></i>Procesar
                        </button>
                    @endcan
                @endif

                @if($solicitud->estatus != 'PROCESADO')
                    <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla()">
                        <i class="fa fa-save"></i>Guardar
                    </button>
                @endif
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
    var EliminarArticulo = "{{ url('resgeliminararticulodespacho') }}"; 
</script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\ResgDespachos.js') }}"></script>


@endsection