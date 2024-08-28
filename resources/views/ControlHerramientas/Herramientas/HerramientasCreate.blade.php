@extends('layouts.master')

@section('titulo', 'Herramientas')

@section('titulo_pagina', 'Herramientas')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item"><a href="{{ url('/dashboardcnth') }}"> <i class="feather icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
        <li class="breadcrumb-item"><a href="{{ asset('/herramientas') }}">Herramientas</a></li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')

    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')
    <div class="card">
        <div class="card-header">
            <h5>Crear Herramientas</h5>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-12">
                    <div id="wizard">
                        <form method="POST" action="{{ route('herramientas.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-2 col-lg-2">
                                    <label for="userName-2" class="block">Imagen</label>
                                </div>
                                <div class="col-md-6 col-lg-6 @error('imagen_herramienta') is-invalid @enderror">
                                    <input type="file" name="imagen_herramienta" id="filer_input_single"
                                        value="{{ old('imagen_herramienta[]') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <div class="border-checkbox-section">
                                        <div class="border-checkbox-group border-checkbox-group-primary">
                                            <input class="border-checkbox" type="checkbox" name="cont_especial" id="importar" value="SI" onclick="Importar()">
                                            <label class="border-checkbox-label" for="importar">Importar Articulo</label>
                                        </div>
                                    </div>
                                </div>
                                @can('cnth.herramienta.generar.codigo')
                                    <div class="col-sm-3">
                                        <input type="number" min="1"
                                            class="form-control form-control-bold form-control-uppercase @error('') is-invalid @enderror"
                                            name="codigo_articulo" id='_codigoarticulo'
                                            value="" 
                                            placeholder="Ingrese El Codigo de la ficha">
                                    </div>
                                    <div class="col-sm-2">
                                        <button onclick="ImportarArticulo()" class="form-control btn btn-primary"
                                        id='botonImportar' type="button">
                                            <i class="fa fa-cloud-download"></i> IMPORTAR </button>
                                    </div>
                                @endcan

                            </div>

                            <div class="form-group row">
                                @can('cnth.herramienta.generar.codigo')
                                    <label class="col-sm-2 col-form-label">Codigo Herramienta</label>
                                    <div class="col-sm-3">
                                        <input type="text"
                                            class="form-control form-control-bold form-control-uppercase @error('codigo_herramienta') is-invalid @enderror"
                                            name="codigo_herramienta" id='codigo_herramienta'
                                            value="{{ old('codigo_herramienta', $herramienta->codigo_herramienta ?? '') }}"
                                            placeholder="Ingrese El Codigo">
                                    </div>
                                    <div class="col-sm-2">
                                        <button onclick="GenerarCodigoHerramienta()" class="form-control btn btn-primary" type="button">
                                            <i class="fa fa-refresh"></i> Generar </button>
                                    </div>
                                @endcan
                                {{-- Campo oculto para almacenar el correlativo --}}
                                <input type="hidden" class="form-control" name="correlativo" id="correlativo"
                                    value="{{ old('correlativo', $herramienta->correlativo ?? '') }}">
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                        class="form-control @error('nombre_herramienta') is-invalid @enderror"
                                        name="nombre_herramienta" id="_nombre" value="{{ old('nombre_herramienta') }}"
                                        placeholder="Ingrese el Nombre de la Herramienta">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-sm-10">
                                    <textarea rows="3" cols="3" class="form-control @error('descripcion_herramienta') is-invalid @enderror"
                                        name="descripcion_herramienta" id="_descripcion" placeholder="Ingrese la Descripción de la Herramienta">{{ old('descripcion_herramienta') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-lg-2">
                                    <label for="name-2" class="block">Grupos</label>
                                </div>
                                <div class="col-md-4 col-lg-4 @error('id_grupo') is-invalid @enderror">
                                    <select name="id_grupo" id="_grupos" class="js-example-basic-single form-control">
                                        <option value="0">Seleccione el Grupo </option>
                                        @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->id_grupo }}"
                                                @if ($grupo->id_grupo == old('id_grupo')) selected = "selected" @endif>
                                                {{ $grupo->codigo_grupo }} - {!! $grupo->nombre_grupo !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <label for="name-2" class="block">SubGrupos</label>
                                </div>
                                <div class="col-md-4 col-lg-4 @error('id_subgrupo') is-invalid @enderror">
                                    <select name="id_subgrupo" id="_subgrupos" data-old="{{ old('id_subgrupo') }}"
                                        class="js-example-basic-single form-control ">
                                        <option value="0">Seleccione El Subgrupo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-lg-2">
                                    <label for="name-2" class="block">Categoria</label>
                                </div>
                                <div class="col-md-4 col-lg-4 @error('id_categoria') is-invalid @enderror">
                                    <select name="id_categoria" id="id_categoria" class="js-example-basic-single form-control ">
                                        <option value="0">Seleccione la Categoria</option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id_categoria }}"
                                                @if ($categoria->id_categoria == old('id_categoria')) selected = "selected" @endif>
                                                {{ $categoria->codigo_categoria }} - {!! $categoria->nombre_categoria !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h4 class="sub-title">Almacenes</h4>
                            <div class="card-block accordion-block color-accordion-block">
                                <div class="color-accordion" id="color-accordion">
                                    <div class="accordion-heading" role="tab" id="headingOne">
                                        <h3 class="card-title accordion-title">
                                            <a class="accordion-msg bg-primary b-none" data-toggle="collapse"
                                                data-parent="#accordion" href="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                Empresas y Almacenes  <i class="fa fa-plus"> </i>
                                            </a>

                                        </h3>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                        aria-labelledby="headingOne">
                                        <div class="accordion-content accordion-desc">
                                            <div class="form-group row">
                                                <div class="col-md-3 col-lg-3">
                                                    <label for="name-2" class="block">Empresa</label>
                                                    <div class=" @error('') is-invalid @enderror">
                                                        <select name="id_empresa" id="_empresas"
                                                        class="js-example-basic-single form-control">
                                                                <option value="0">Seleccione la Empresa </option>
                                                            @foreach ($empresas as $empresa)
                                                            <option value="{{ $empresa->id_empresa }}"
                                                                @if ($empresa->id_empresa == old('id_empresa')) selected = "selected" @endif>
                                                                {{ $empresa->id_empresa }} - {!! $empresa->nombre_empresa !!}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                    <label for="name-2" class="block">Almacenes</label>
                                                    <div class="@error('id_almacen') is-invalid @enderror">
                                                        <select name="id_almacen" id="_almacenes" data-old="{{ old('id_almacen') }}"
                                                            class="js-example-basic-single form-control ">
                                                            <option value="0">Seleccione Almacen</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-2">
                                                    <label for="name-2" class="block">Ubicaciones</label>
                                                    <div class="@error('id_ubicacion') is-invalid @enderror">
                                                        <select name="id_ubicacion" id="_ubicaciones"
                                                            data-old="{{ old('id_ubicacion') }}"
                                                            class="js-example-basic-single form-control ">
                                                            <option value="0">Seleccione</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-lg-1">
                                                    <label for="stock" class="block">Stock</label>
                                                    <input type="number" min="0"
                                                        class="form-control form-control-bold form-control-uppercase @error('stock') is-invalid @enderror"
                                                        name="stock" id="stock" value="{{ old('stock') }}"
                                                        placeholder="Stock">
                                                </div>
                                                <div class="col-md-2 col-lg-2">
                                                    <label for="name-2" class="block">Agregar</label>
                                                    <br>
                                                    <button type="button" class="btn btn-primary btn-sm" title="Nuevo"
                                                        onClick="CargarTabla()">
                                                        <i class="fa fa-plus"></i> </button>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" id="tabla_almacenes">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Empresa</th>
                                                            <th>Almacenes</th>
                                                            <th>Ubicaciones</th>
                                                            <th>Stock</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            {{-- Campo oculto con arreglo de los datos de los almacenes --}}
                            <input type="hidden" name="datosherramientas" id="datosherramientas">
                            <div class="d-grid gap-2 d-md-block float-right">

                                <button type="submit" class="btn btn-primary" 
                                    OnClick="CapturarDatosTabla()">
                                <i class="fa fa-save"></i>Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <!-- jquery file upload js -->
    <script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>
    
    <!-- Select -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

    <!-- Masking js -->
    <script src="{{ asset('libraries\assets\pages\form-masking\inputmask.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\autoNumeric.js') }} "></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\jquery.inputmask.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\form-mask.js') }} "></script>
    <!--Personalizado -->
    <script src="{{ asset('libraries\assets\js\herramientas-create.js') }}"></script>

@endsection
