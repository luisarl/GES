@extends('layouts.master')

@section('titulo', 'Herramientas')

@section('titulo_pagina', 'Herramientas')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item"><a href="{{ asset('/dashboardcnth') }}"> <i class="feather icon-home"></i> </a> </li>
        <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
        <li class="breadcrumb-item"><a href="{{ asset('/herramientas') }}">Herramientas</a> </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>

@endsection

@section('contenido')

    @include('mensajes.MsjExitoso')
    @include('mensajes.MsjError')
    @include('mensajes.MsjAlerta')
    @include('mensajes.MsjValidacion')


    <div class="card">
        <div class="card-header">
            <h5>Editar Herramienta</h5>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-12">
                    <div id="wizard">
                        <form method="POST" action="{{ route('herramientas.update', $herramienta->id_herramienta) }}"
                            enctype="multipart/form-data">
                            @csrf @method('put')

                            <div class="form-group row">
                                <div class="col-md-2 col-lg-2 @error('imagen_herramienta') @enderror ">
                                    <label for="userName-2" class="block">Imagen</label>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="thumbnail">
                                        <div class="thumb">
                                            <a href="{{ asset($herramienta->imagen_herramienta) }} " data-lightbox="1"
                                                data-title="{{ $herramienta->nombre_herramienta }}">
                                                <img src="{{ asset($herramienta->imagen_herramienta) }}" alt=""
                                                    class="img-fluid img-thumbnail">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6">
                                    {{-- @if ($deshabilitar == '') --}}
                                    <input type="file" name="imagen_herramienta" id="filer_input_single"
                                        multiple="multiple">
                                    {{-- @endif --}}
                                </div>
                            </div>

                            <div class="form-group row">
                                @can('cnth.herramienta.generar.codigo')
                                    <label class="col-sm-2 col-form-label">Codigo</label>
                                    <div class="col-sm-3">
                                        <input type="text"
                                            class="form-control form-control-bold form-control-uppercase @error('codigo_herramienta') is-invalid @enderror"
                                            name="codigo_herramienta" id='codigo_herramienta'
                                            value="{{ old('codigo_herramienta', $herramienta->codigo_herramienta ?? '') }}"
                                            placeholder="Ingrese El Codigo" readonly>
                                    </div>
                                @endcan
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text"
                                        class="form-control @error('nombre_herramienta') is-invalid @enderror"
                                        name="nombre_herramienta"
                                        value="{{ old('nombre_herramienta', $herramienta->nombre_herramienta ?? '') }}"
                                        placeholder="Ingrese el Nombre de la Herramienta">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-sm-10">
                                    <textarea rows="3" cols="3" class="form-control @error('descripcion_herramienta') is-invalid @enderror"
                                        name="descripcion_herramienta" placeholder="Ingrese la Descripción de la Herramienta">{{ old('descripcion_herramienta', $herramienta->descripcion_herramienta ?? '') }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2 col-lg-2">
                                    <label for="name-2" class="block">Grupos</label>
                                </div>
                                <div class="col-md-4 col-lg-4 @error('') is-invalid @enderror">
                                    <select name="id_grupo" id="_grupos" readonly
                                        class="js-example-basic-single form-control">
                                        <option value="0">Seleccione el Grupo </option>
                                        @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->id_grupo }}"
                                                @if ($grupo->id_grupo == old('id_grupo', $herramienta->id_grupo ?? '')) selected = "selected" @endif>
                                                {{ $grupo->codigo_grupo }} - {!! $grupo->nombre_grupo !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <label for="name-2" class="block">SubGrupos</label>
                                </div>
                                <div class="col-md-4 col-lg-4 @error('') is-invalid @enderror">
                                    <select name="id_subgrupo" id="_subgrupos" readonly
                                        data-old="{{ old('id_subgrupo', $herramienta->id_subgrupo ?? '') }}"
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
                                                @if ($categoria->id_categoria == old('id_categoria', $herramienta->id_categoria ?? '')) selected = "selected" @endif>
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
                                                Empresas y Almacenes <i class="fa fa-plus"> </i>
                                            </a>

                                        </h3>
                                    </div>
                                    @if ($almacenes == '[]')
                                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                            aria-labelledby="headingOne">
                                        @else
                                            <div class="accordion-box" id="single-open">
                                    @endif
                                    {{-- <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                        aria-labelledby="headingOne"> --}}
                                    <div class="accordion-content accordion-desc">
                                        <div class="form-group row">
                                            <div class="col-md-3 col-lg-3">
                                                <label for="name-2" class="block">Empresa</label>
                                                <div class=" @error('') is-invalid @enderror">
                                                    <select name="id_empresa" id="id_empresa"
                                                        class="js-example-basic-single form-control">
                                                        <option value="0">Seleccione la Empresa </option>
                                                        @foreach ($empresas as $empresa)
                                                            <option value="{{ $empresa->id_empresa }}"
                                                                @if ($empresa->id_empresa == old('id_empresa')) selected = "selected" @endif>
                                                                {!! $empresa->id_empresa !!} - {!! $empresa->nombre_empresa !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-lg-3">
                                                <label for="name-2" class="block">Almacenes</label>
                                                <div class="@error('id_almacen') is-invalid @enderror">
                                                    <select name="id_almacen" id="id_almacen"
                                                        data-old="{{ old('id_almacen') }}"
                                                        class="js-example-basic-single form-control ">
                                                        <option value="0">Seleccione Almacen</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-lg-2">
                                                <label for="name-2" class="block">Ubicaciones</label>
                                                <div class="@error('id_ubicacion') is-invalid @enderror">
                                                    <select name="id_ubicacion" id="id_ubicacion"
                                                        data-old="{{ old('id_ubicacion') }}"
                                                        class="js-example-basic-single form-control ">
                                                        <option value="0">Seleccione</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-lg-1">
                                                <label for="stock" class="block">Stock</label>
                                                <input type="number"
                                                    class="form-control form-control-bold form-control-uppercase @error('stock_inicial') is-invalid @enderror"
                                                    name="stock_inicial" id="stock_inicial"
                                                    value="{{ old('stock_inicial') }}" placeholder="Stock">
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
                                                        <th style="width: 5%">#</th>
                                                        <th style="width: 30%">Empresa</th>
                                                        <th style="width: 20%">Almacenes</th>
                                                        <th style="width: 30%">Ubicaciones</th>
                                                        <th style="width: 5%">Stock Inicial</th>
                                                        <th style="width: 5%">Stock Actual</th>
                                                        <th >Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($almacenes as $almacen)
                                                      <tr>
                                                        <td id="">{{ $almacen->id_almacen_herramienta }}</td>
                                                        <td id="id_empresa">{{ $almacen->id_empresa }} - {{ $almacen->nombre_empresa }}</td>
                                                        <td id="id_almacen" class="id_almacen">{{ $almacen->id_almacen }} - {{ $almacen->nombre_almacen }}</td>
                                                        <td id="id_ubicacion" style="width: 30%">
                                                          <select name="id_ubicaciontabla" class="js-example-basic-single form-control id_ubicaciontabla" data-old="{{ $almacen->id_ubicacion }}">
                                                            <option value="0">{{ $almacen->id_ubicacion }} - {{ $almacen->nombre_ubicacion }}</option>
                                                          </select>
                                                        </td>
                                                        <td id="stock_inicial">{{ $almacen->stock_inicial }}</td>
                                                        <td id="stock_actual">{{ $almacen->stock_actual }}</td>
                                                        <th>
                                                        </th>
                                                      </tr>
                                                    @endforeach
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

                        <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla()">
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
    <script src="{{ asset('libraries\assets\js\herramientas-edit.js') }}"></script>

@endsection
