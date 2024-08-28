@extends('layouts.master')

@section('titulo', 'Autorización de Salida')

@section('titulo_pagina', 'Crear Salida')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('autorizacionsalidas') }}">Autorización de Salida</a> </li>
    <li class="breadcrumb-item"><a href="{{ url('autorizacionsalidas') }}">Salidas</a> </li>
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
        <form method="POST" action="{{ route('autorizacionsalidas.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-1 form-label">Almacen</label>
                <div class="col-sm-5 @error('id_almacen') is-invalid @enderror">
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
                <label class="col-sm-1 form-label">Fecha Estimada De Salida</label>
                <div class="col-sm-2">
                    <input type="date" name="fecha_salida" min="{{date("Y-m-d")}}" id="" class="form-control @error('fecha_salida') is-invalid @enderror"  value="{{ old('fecha_salida') }}" >
                </div>
                <label class="col-sm-1 form-label">Hora Estimada de Salida</label>
                <div class="col-sm-2">
                    <input type="time" name="hora_salida" id="" class="form-control @error('hora_salida') is-invalid @enderror" value="{{ old('hora_salida') }}" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 form-label">Solicita</label>
                <div class="col-sm-5 @error('solicitante') is-invalid @enderror">
                    <select name="solicitante" id="solicitante"
                        class="js-example-basic-single form-control "
                        onchange="DepartamentoEmpleado();">
                        <option value="0">SELECCIONE QUIEN SOLICITA</option>
                        @foreach($solicitantes as $solicitante)
                            <option value="{{$solicitante->name}}" @if ($solicitante->name == old('solicitante')) selected = "selected" @endif>
                                {{$solicitante->name}} - {{$solicitante->nombre_departamento}} 
                            </option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-1 form-label">Unidad / Gerencia</label>
                <div class="col-sm-5">
                    <input type="text" name="departamento" id="departamento" class="form-control" value="{{ old('departamento') }}" readonly>
                </div>         
            </div>
            <div class="form-group row">
                <label class="col-sm-1 form-label">Autoriza</label>
                <div class="col-sm-5 @error('autorizado') is-invalid @enderror">
                    <select name="autorizado"
                        class="js-example-basic-single form-control">
                        <option value="0">SELECCIONE QUIEN AUTORIZA</option>
                        @foreach($autorizados as $autorizado)
                            <option value="{{$autorizado->Empleado}}" @if ($autorizado->Empleado == old('autorizado')) selected = "selected" @endif>
                                {{$autorizado->Empleado}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-1 form-label">Responsable</label>
                <div class="col-sm-5 @error('responsable') is-invalid @enderror">
                    <select name="responsable"
                        class="js-example-basic-single form-control ">
                        <option value="0">SELECCIONE EL RESPONSABLE</option>
                        @foreach($empleados as $empleado)
                            <option value="{{$empleado->Empleado}}" @if ($empleado->Empleado == old('responsable')) selected = "selected" @endif>
                                {{$empleado->Empleado}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-1 form-label">Conductor</label>
                <div class="form-radio col-sm-1"> 
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="tipo_chofer" id="ChoferInterno" value="INTERNO" onClick="TipoConductor();" checked>
                            <i class="helper"></i>Interno
                        </label>
                    </div>
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="tipo_chofer" id="ChoferForaneo" value="FORANEO" alue="FORANEO" {{ old('tipo_chofer')=="FORANEO" ? 'checked='.'"'.'checked'.'"' : '' }} onClick="TipoConductor();">
                            <i class="helper"></i>Foraneo
                        </label>
                    </div>
                </div>   
                {{-- CONDUCTOR INTERNO--}}
                <div class="col-sm-3  @error('conductorinterno') is-invalid @enderror" id="ConductorInterno" >
                    <select name="conductorinterno" id=""
                        class="js-example-basic-single form-control">
                        <option value="0">SELECCIONE EL CONDUCTOR</option>
                        @foreach($empleados as $empleado)
                            <option value="{{$empleado->Empleado}}" @if ($empleado->Empleado == old('conductorinterno')) selected = "selected" @endif>
                                {{$empleado->Empleado}}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- CONDUCTOR FORANEO  --}}
                <div class="col-sm-3 @error('conductorforaneo') is-invalid @enderror" id="ConductorForaneo">
                    <input type="text" name="conductorforaneo" id="" class="form-control @error('conductorforaneo') is-invalid @enderror" placeholder="Nombre del conductor" value="{{ old('conductorforaneo') }}">
                </div>
                <label class="col-sm-1 form-label">Vehiculo</label>
                <div class="form-radio col-sm-1"> 
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="tipo_vehiculo" id="VehiculoInterno" value="INTERNO" onClick="TipoVehiculo();" checked>
                            <i class="helper"></i>Interno
                        </label>
                    </div>
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="tipo_vehiculo" id="VehiculoForaneo" value="FORANEO" {{ old('tipo_vehiculo')=="FORANEO" ? 'checked='.'"'.'checked'.'"' : '' }} onClick="TipoVehiculo();">
                            <i class="helper"></i>Foraneo
                        </label>
                    </div>
                </div> 
                {{-- VEHICULO INTERNO --}}
                <div class="col-sm-5 @error ('id_vehiculo') is-invalid @enderror" id="id_vehiculo" > 
                    <select name="id_vehiculo" id="" class="js-example-basic-single form-control">
                        <option value="0">SELECCIONE EL VEHICULO</option>
                        @foreach($vehiculos as $vehiculo)
                        <option value="{{$vehiculo->id_vehiculo}}" @if ($vehiculo->id_vehiculo == old('id_vehiculo')) selected = "selected" @endif>
                            {{$vehiculo->placa_vehiculo}} - {{$vehiculo->marca_vehiculo}} - {{$vehiculo->modelo_vehiculo}}
                        </option>
                        @endforeach
                    </select>
                </div>
                {{-- VEHICULO FORANEO --}}
                <div class="col-sm-1">
                    <input type="text" name="placa" id="PlacaVehiculoForaneo" class="form-control @error('placa') is-invalid @enderror" placeholder="Placa" value="{{ old('placa') }}">
                </div>
                <div class="col-sm-2">
                    {{-- VEHICULO FORANEO --}}
                    <input type="text" name="marca" id="MarcaVehiculoForaneo" class="form-control @error('marca') is-invalid @enderror" placeholder="Marca" value="{{ old('marca') }}">
                </div>
                <div class="col-sm-2">
                    {{-- VEHICULO FORANEO --}}
                    <input type="text" name="modelo" id="ModeloVehiculoForaneo" class="form-control @error('modelo') is-invalid @enderror" placeholder="Modelo"  value="{{ old('modelo') }}">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-1 form-label">Tipo Salida</label>
                <div class="col-sm-3 @error('id_tipo') is-invalid @enderror">
                    <select name="id_tipo" id="id_tipo" class="js-example-basic-single form-control">
                        @foreach($tipos as $tipo)
                            <option value="{{$tipo->id_tipo}}" @if($tipo->id_tipo == old('id_tipo')) selected = "selected" @endif>{{$tipo->nombre_tipo}}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-1 form-label">Motivo Salida</label>
                <div class="col-sm-3 @error('id_subtipo') is-invalid @enderror">
                    <select name="id_subtipo" id="id_subtipo" class="js-example-basic-single form-control ">
                    </select>
                </div>
                <label class="col-sm-1 form-label">Destino</label>
                <div class="col-sm-3">
                    <input type="text" name="destino" id="destino" class="form-control @error('destino') is-invalid @enderror" value="{{ old('destino') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label">Actividad</label>
                <div class="col-md-11 col-lg-11">
                    <textarea rows="3" cols="3" class="form-control @error('motivo') is-invalid @enderror" name="motivo"
                        id="motivo" placeholder="Ingrese la Actividad a Realizar">{{ old('motivo') }}</textarea>
                </div>
            </div>
            <h4 class="sub-title">Articulos</h4>
            <div class="row"> 

                <div class="col-sm-6 col-md-4 col-lg-4">
                    <h4 class="sub-title">Importar NDE Profit</h4>
                    <div class="form-group row">
                        <label for="numero" class="block col-md-4">Numero</label>     
                        <div class="col-md-3">
                            <input type="number"class="form-control @error('numero') is-invalid @enderror"
                            name="numero" id="numero" min="1" value="{{ old('numero') }}">
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary btn-sm" title="Importar" onClick="CargarTablaNotaEntregaProfit()">
                                <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <h4 class="sub-title">Importar Despacho Herramientas</h4>
                    <div class="form-group row">
                        <label for="numero" class="block col-md-4">Numero</label>     
                        <div class="col-md-3">
                            <input type="number"class="form-control  @error('numero_despacho') is-invalid @enderror"
                                                    name="numero_despacho" id="numero_despacho" min="1" value="{{ old('numero_despacho') }}">
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary btn-sm" title="Importar" onClick="CargarTablaDespachoHerramientas()">
                                <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div>
                </div>

            </div>
            <h4 class="sub-title">Tipo Articulos</h4>
            <div class="form-group row">
                <label for="" class="col-sm-1">Tipo</label>
                <div class="form-radio col-sm-2"> 
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="articulo" id="ArticuloInterno" value="INTERNO" onClick="TipoArticulo()" checked>
                            <i class="helper"></i>Interno
                        </label>
                    </div>
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="articulo" id="ArticuloOtro" value="OTRO" onClick="TipoArticulo()">
                            <i class="helper"></i>Otro
                        </label>
                    </div>
                </div>  
            </div>
            <hr>
            <div class="form-group row" id="buscar_articulo">
                <div class="col-md-3 col-lg-3">
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
            <div class="form-group row">
                <div class="col-md-4 col-lg-4" id="id_articulo_interno">
                    <label for="articulos" class="block" id="scrollable-dropdown-menu">Articulos</label>
                    <select name="id_articulo" id="id_articulo" data-old="{{ old('id_articulo') }}"
                        class="js-example-basic-single form-control">
                        <option value="0">Seleccione Articulo</option>
                    </select>
                </div>
                
                <div class="col-sm-4" id="id_articulo_otro">
                    <label for="articulos" class="block" id="">Articulo</label>
                    <input type="text"class="form-control form-control-uppercase @error('id_articulo_otro') is-invalid @enderror"
                    name="id_articulo_otro" id="id_articulo_foraneo" value="{{ old('id_articulo_otro') }}">
                </div>
                <div class="col-md-2 col-lg-2">
                    <label for="unidades" class="block">Unidad</label>
                    <select class="form-control @error('unidades') is-invalid @enderror"
                        name="unidades" id="unidades" value="{{ old('unidades') }}">
                        <option value=""></option>
                    </select>
                    <select class="form-control @error('UnidadOtro') is-invalid @enderror"
                        name="UnidadOtro" id="UnidadOtro" value="{{ old('UnidadOtro') }}">
                        @foreach ($unidades as $unidad)
                            <option value="{{$unidad->nombre_unidad}}">{{$unidad->nombre_unidad}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 col-lg-1">
                    <label for="cantidad" class="block">Cantidad</label>
                    <input type="number"
                        class="form-control @error('cantidad') is-invalid @enderror"
                        name="cantidad" id="cantidad" value="{{ old('cantidad') }}" min="1">   
                </div>
                <div class="col-md-3 col-lg-3">
                    <label for="comentario" class="block">Comentario</label>
                    <input type="text"class="form-control form-control-uppercase @error('comentario') is-invalid @enderror"
                        name="comentario" id="comentario" value="{{ old('comentario') }}">
                </div>
                <div class="col-md-1 col-lg-1">
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
                            <th>Articulo</th>
                            <th>Unidad</th>
                            <th>Cantidad</th>
                            <th>Comentario</th>
                            <th>Importacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($articulos = json_decode(old('datosmovimiento')))
                        @if($articulos != null)
                            @foreach($articulos as $articulo)
                                <tr>
                                    <td id="id_detalle" style="visibility:collapse; display:none;"></td>
                                    <td id="id_articulo">{{$articulo->id_articulo}}</td>
                                    <td id="nombre_articulo">{{$articulo->nombre_articulo}}</td>
                                    <td id="unidad">{{$articulo->unidad}}</td>
                                    <td id="cantidad">{{$articulo->cantidad}}</td>
                                    <td id="comentario" contenteditable="true" >{{$articulo->comentario}}</td>
                                    <td id="importacion">{{$articulo->importacion}}</td>
                                    {{-- <td id="disposicion_final">{{$articulo->disposicion_final}}</td> --}}
                                    {{-- <td id="observacion">{{$articulo->observacion}}</td> --}}
                                    <th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th>
                                </tr>
                            @endforeach
                        @endif
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
    var route = "{{ url('unidadesarticulo') }}"; 
    var importarnde = "{{ url('importarnde') }}"; 
    var HerramientasDespacho = "{{ url('herramientasdespacho') }}"; 
    var BuscarArticulos = "{{ url('buscararticulosalidas') }}"; 
    var SubTiposSalidas = "{{ url('asalsubtipossalidas') }}"; 
</script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\AsalSalidas.js') }}"></script>


@endsection