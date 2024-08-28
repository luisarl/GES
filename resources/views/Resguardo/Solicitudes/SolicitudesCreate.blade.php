@extends('layouts.master')

@section('titulo', 'Solicitudes Resguardo')

@section('titulo_pagina', 'Crear Solicitud de Resguardo')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Resguardo</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('resgsolicitudes.index') }}">Solicitud de Resguardo</a> </li>
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
        <form method="POST" action="{{ route('resgsolicitudes.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 form-label">Almacen Destino</label>
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
                <label class="col-sm-2 form-label">Ubicacion Actual</label>
                <div class="col-sm-4">
                    <input type="text" name="ubicacion_actual" id="ubicacion_actual" class="form-control @error('ubicacion_actual') is-invalid @enderror" value="{{ old('ubicacion_actual') }}">
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
            <div class="form-group row" id="buscar_articulo">     
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <h4 class="sub-title">Articulos</h4>
                    <div class="form-group row">
                        <div class="col-md-6 col-lg-6">
                            <label for="articulo" class="block" id="">Buscar Articulo</label>
                            <input type="text" class="form-control" name="articulo" id="articulo" placeholder="Ingrese Codigo o Nombre">
                        </div>
                        <div class="col-auto" >
                            <label for="name-2" class="block">&nbsp;</label>
                            <br>
                            <button type="button" class="btn btn-primary btn-sm" title="Buscar" onClick="CargarArticulos()">
                                <i class="fa fa-search"></i> 
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <h4 class="sub-title">Importar NDE Profit</h4>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="numero" class="block">Numero NDE</label>     
                            <input type="number"class="form-control @error('numero') is-invalid @enderror"
                            name="numero" id="numero" min="1" value="{{ old('numero') }}">
                        </div>
                        <div class="col-sm-1">
                            <label for="name-2" class="block">&nbsp;</label>
                            <br>
                            <button type="button" class="btn btn-primary btn-sm" title="Importar" onClick="CargarTablaNotaEntregaProfit()">
                                <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 col-lg-3" id="id_articulo_interno">
                    <label for="articulos" class="block" id="scrollable-dropdown-menu">Articulos</label>
                    <select name="id_articulo" id="id_articulo" data-old="{{ old('id_articulo') }}"
                        class="js-example-basic-single form-control">
                        <option value="0">Seleccione Articulo</option>
                    </select>
                </div>
                <div class="col-md-2 col-lg-2">
                    <label for="unidades" class="block">Unidad</label>
                    <select class="js-example-basic-single form-control @error('unidades') is-invalid @enderror"
                        name="unidades" id="unidades" value="{{ old('unidades') }}">
                        <option value="0">SELECCIONE LA UNIDAD</option>
                        @foreach ($unidades as $unidad)
                            <option value="{{$unidad->nombre_unidad}}">
                                {{$unidad->nombre_unidad}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 col-lg-1">
                    <label for="equivalencia_unidad" class="block">Presentacion</label>
                    <input type="number"
                        class="form-control @error('equivalencia_unidad') is-invalid @enderror"
                        name="equivalencia_unidad" id="equivalencia_unidad" value="{{ old('equivalencia_unidad') }}" min="1">   
                </div>
                <div class="col-md-1 col-lg-1">
                    <label for="cantidad" class="block">Cantidad</label>
                    <input type="number"
                        class="form-control @error('cantidad') is-invalid @enderror"
                        name="cantidad" id="cantidad" value="{{ old('cantidad') }}" min="0.10">   
                </div>
                <div class="col-md-1 col-lg-1">
                    <label for="estatus" class="block">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="OPERATIVO">OPERATIVO</option>
                        <option value="NO OPERATIVO">NO OPERATIVO</option>
                    </select>
                </div>
                <div class="col-md-2 col-lg-2">
                    <label for="disposicion_final" class="block">Disposicion Final</label>
                    <select name="disposicion_final" id="disposicion_final" class="form-control">
                        @foreach($clasificaciones as $clasificacion)
                            <option value="{{$clasificacion->id_clasificacion}}">{{$clasificacion->nombre_clasificacion}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-lg-2">
                    <label for="name-2" class="block">Observacion</label>
                    <br>
                    <textarea name="comentario" id="comentario" class="form-control" cols="5" rows="1" required></textarea>
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
                            <th>Unidad</th>
                            <th>Presentacion</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th>Disposicion Final</th>
                            <th>Observacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($articulos = json_decode(old('articulos')))
                        @if($articulos != null)
                            @foreach($articulos as $articulo)
                                <tr>
                                    <td id="id_resguardo" style="visibility:collapse; display:none;"></td>
                                    <td id="codigo_articulo">{{$articulo->codigo_articulo}}</td>
                                    <td id="nombre_articulo">{{$articulo->nombre_articulo}}</td>
                                    <td id="unidad">{{$articulo->unidad}}</td>
                                    <td id="equivalencia_unidad">{{$articulo->equivalencia_unidad}}</td>
                                    <td id="cantidad">{{$articulo->cantidad}}</td>
                                    <td id="estado">{{$articulo->estado}}</td>
                                    <td id="id_clasificacion" style="visibility:collapse; display:none;">{{$articulo->id_clasificacion}}</td>
                                    <td id="disposicion_final">{{$articulo->disposicion_final}}</td>
                                    <td id="observacion">{{$articulo->observacion}}</td>
                                    <th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th>
                                </tr>
                            @endforeach
                        @endif
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
    var BuscarArticulos = "{{ url('resgbuscararticulos') }}"; 
    var importarnde = "{{ url('importarnde') }}"; 
</script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\ResgSolicitudes.js') }}"></script>


@endsection