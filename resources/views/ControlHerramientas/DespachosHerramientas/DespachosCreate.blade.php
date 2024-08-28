@extends('layouts.master')

@section('titulo', 'Despacho')

@section('titulo_pagina', 'Despacho de Herramientas')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item"><a href="{{ url('/dashboardcnth') }}"> <i class="feather icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
        <li class="breadcrumb-item"><a href="{{ asset('/despachos') }}">Despacho de Herramientas</a></li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>
@endsection

@section('contenido')
    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')

    <div class="page-body">
        <div class="card">
            <div class="card-header">
                <h4 class="sub-title"><strong>Datos del Despacho</strong></h4>
            </div>
            <div class="card-block">
                
                <form method="POST" action="{{ route('despachos.store') }}" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Almacenes</label>
                            <div class="col-sm-9 @error('id_almacen') is-invalid @enderror">
                                <select name="id_almacen" id="_almacenes" class="js-example-basic-single form-control">
                                    <option value="0">Seleccione el almacen</option>
                                    @foreach ($almacenes as $almacen)
                                        <option value="{{ $almacen->id_almacen }}"
                                            @if ($almacen->id_almacen == old('id_almacen')) selected = "selected" @endif>
                                            {!! $almacen->id_almacen !!} - {!! $almacen->nombre_almacen !!}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{-- <label for="Responsables" class="col-sm-3 col-form-label">Responsable</label>
                            <div class="col-sm-9 @error('id_empleado') is-invalid @enderror">
                                <select name="id_empleado" id="id_empleado" class="js-example-basic-single form-control">
                                    <option value="0">Seleccione el Empleado</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->id_empleado }}"
                                            @if ($empleado->id_empleado == old('id_empleado')) selected = "selected" @endif>
                                            {!! $empleado->nombre_empleado !!}</option>
                                    @endforeach
                                </select> 
                            </div>--}}
                            <label for="Responsables" class="col-sm-3 col-form-label">Responsable</label>
                            <div class="col-sm-9 @error('responsable') is-invalid @enderror">
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
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"> Zonas </label>
                            <div class="col-sm-9 @error('id_zona') is-invalid @enderror">
                                <select name="id_zona" id="id_zona" class="js-example-basic-single form-control">
                                    <option value="0">Seleccione la Zona</option>
                                    @foreach ($zonas as $zona)
                                        <option value="{{ $zona->id_zona }}"
                                            @if ($zona->id_zona == old('id_zona')) selected =
                                    "selected" @endif>
                                            {!! $zona->nombre_zona !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Motivo del Despacho</label>
                            <div class="col-sm-9">
                                <textarea rows="3" cols="3" class="form-control @error('motivo') is-invalid @enderror" name="motivo"
                                    id="motivo" placeholder="Motivo del Despacho">{{ old('motivo') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Fotografia</label>
                            <div class="col-sm-9">
                                <div id="results">
                                    <img style="width: 300px" class="after_capture_frame form-control"
                                        src="{{ asset('/images/herramientas/despachos/placeholder.jpg') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 text-center">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <div id="my_camera"></div>
                                <input type="hidden" name="captured_image_data" id="captured_image_data">
                            </div>
                           
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-primary form-control" value="CAPTURAR IMAGEN"
                                    onClick="take_snapshot()">
                                    <i class="fa fa-camera"></i>CAPTURAR IMAGEN
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="sub-title">Herramientas</h4>
                <div class="form-group row">
                    <div class="form-radio col-sm-1"> 
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" name="tipo" id="herramienta" value="HERRAMIENTA" onClick="TipoCargaHerramientas()" checked>
                                <i class="helper"></i>Herramienta
                            </label>
                        </div>
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" name="tipo" id="plantilla" value="PLANTILLA" onClick="TipoCargaHerramientas()">
                                <i class="helper"></i>Plantilla
                            </label>
                        </div>
                    </div>  
                    <div class="col-md-4 col-lg-4 @error('id_herramienta') is-invalid @enderror" id="herramientas">
                        <label for="cantidad" class="block">Herramientas</label>
                        <select name="id_herramienta" id="_herramientas" data-old="{{ old('id_herramienta') }}"
                            class="js-example-basic-single form-control" onchange="StockHerramienta();">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-4 @error('id_herramienta') is-invalid @enderror" id="plantillas">
                        <label for="cantidad" class="block">Plantillas</label>
                        <select name="id_plantilla" id="_plantillas" data-old="{{ old('id_herramienta') }}"
                            class="js-example-basic-single form-control" onchange="StockHerramienta();">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                    <div class="col-md-1 col-md-1" id="existenciaherramientas">
                        <label for="existencia" class="block">Existencia</label>
                        <input type="number"
                            class="form-control form-control-bold form-control-uppercase @error('') is-invalid @enderror"
                            name="existencia" id="existencia" value="" placeholder="" readonly>
                    </div>
                    <div class="col-md-2 col-lg-2" id="cantidadherramientas">
                        <label for="cantidad" class="block">Cantidad</label>
                        <input type="number" min="1" max="1"
                            class="form-control form-control-bold form-control-uppercase @error('cantidad_entregada') is-invalid @enderror"
                            name="cantidad_entregada" id="cantidad_entregada" value="{{ old('cantidad_entregada') }}"
                            placeholder="Cantidad">
                    </div>
                    <div class="col-md-2 col-lg-2">
                        <label for="name-2" class="block">Agregar</label>
                        <br>
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTabla()">
                            <i class="fa fa-plus"></i> </button>
                    </div>
                </div>
                <hr>
                <div class="alert alert-warning background-warning" id="error">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong><i class="fa fa-exclamation-triangle"></i> Alerta!</strong>
                    Las Siguientes Herramientas No Fueron Cargadas, La Cantidad De La Plantilla Es Mayor Al Stock Actual.
                    <div id='mensaje'>

                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tabla_despacho">
                        <thead>
                            <tr>
                                <th>#</th>
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
                <input type="hidden" name="datosdespacho" id="datosdespacho">
                <div class="d-grid gap-2 d-md-block float-right">

                    <button class="btn btn-primary" OnClick="CapturarDatosTabla()">
                        <i class="fa fa-save"></i>Guardar
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Select -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

    <!--Personalizado -->
    <script>
        var HerramientasAlmacen = '{{ url("herramientasalmacen") }}';
        var PlantillasAlmacen = '{{ url("plantillasalmacen") }}';
        var HerramientasPlantilla = '{{ url("herramientasplantilla") }}'; 
    </script>

    <script src="{{asset('libraries\assets\pages\webcamjs\webcam.js')}}"></script>
    <script src="{{ asset('libraries\assets\js\CnthDespachos.js') }}"></script>
    <script src="{{ asset('libraries\assets\js\activar-camara.js') }}"></script>
   
@endsection
