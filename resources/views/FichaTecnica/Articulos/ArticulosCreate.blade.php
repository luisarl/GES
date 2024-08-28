@extends('layouts.master')

@section('titulo', 'Articulos')

@section('titulo_pagina', 'Articulos')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
            <li class="breadcrumb-item"><a href="#!">Ficha Tecnica</a> </li>
        <li class="breadcrumb-item"><a href="{{ asset('/articulos') }}">Articulos</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')

    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')
    <div class="card">
        <div class="card-header">
            <h5>Crear Articulo</h5>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-12">
                    <div id="wizard">
                            <form method="POST" action=" {{ route('articulos.store') }}" enctype="multipart/form-data">
                                @csrf
                                    <div class="form-group row">
                                        <div class="col-md-2 col-lg-2">
                                            <label for="userName-2" class="block">Imagen</label>
                                        </div>
                                        <div class="col-md-6 col-lg-6 @error('imagen_articulo') is-invalid @enderror">
                                            <input type="file" name="imagen_articulo" id="filer_input_single" value="{{old('imagen_articulo[]') }}">
                                        </div>
                                    </div>

                                    @can('fict.articulo.generar.codigo')
                                    <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Codigo</label>
                                            <div class="col-sm-3">
                                                <input type="text"
                                                    class="form-control form-control-bold form-control-uppercase @error('codigo_articulo') is-invalid @enderror"
                                                    name="codigo_articulo" id="codigo_articulo" value="{{ old('codigo_articulo') }}"
                                                    placeholder="Ingrese el Codigo">
                                            </div>
                                            <div class="col-sm-2">
                                                <button onclick="GenerarCodigo()" class="form-control btn btn-primary btn-sm" type="button"> <i class="fa fa-refresh"></i> Generar </button>
                                            </div>
                                            {{-- Campo oculto para almacenar el correlativo --}}
                                            <input type="hidden" class="form-control" name="correlativo" id="correlativo" value="{{ old('correlativo') }}" >
                                    </div>
                                    @endcan
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nombre</label>
                                        
                                        <div class="col-sm-10" id="scrollable-dropdown-menu">
                                            <input type="text"
                                                class="typeahead form-control @error('nombre_articulo') is-invalid @enderror"
                                                id="nombre_articulo" name="nombre_articulo" value="{{ old('nombre_articulo') }}"
                                                placeholder="Ingrese el Nombre del articulo" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Descripción</label>
                                        <div class="col-sm-10">
                                            <textarea rows="3" cols="3" class="form-control @error('descripcion_articulo') is-invalid @enderror"
                                                name="descripcion_articulo"
                                                placeholder="Ingrese la Descripción, Uso o Fin del Articulo">{{ old('descripcion_articulo') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-lg-2">
                                            <label for="name-2" class="block">Grupos</label>
                                        </div>
                                        <div class="col-md-4 col-lg-4 @error('id_grupo') is-invalid @enderror">
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
                                        <div class="col-md-2 col-lg-2">
                                            <label for="name-2" class="block">Sub Grupos</label>
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
                                            <select name="id_categoria"
                                                class="js-example-basic-single form-control ">
                                                <option value="0">Seleccione la Categoria</option>
                                                @foreach ($categorias as $categoria)
                                                    <option value="{{ $categoria->id_categoria }}"
                                                        @if ($categoria->id_categoria == old('id_categoria')) selected = "selected" @endif>
                                                        {{$categoria->codigo_categoria}} - {!! $categoria->nombre_categoria !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <label for="name-2" class="block">Tipo</label>
                                        </div>
                                        <div class="col-md-4 col-lg-4 @error('id_tipo') is-invalid @enderror">
                                            <select name="id_tipo"
                                                class="js-example-basic-single form-control ">
                                                <option value="0">Seleccione El Tipo</option>
                                                <option value="V" @if ("V" == old('id_tipo')) selected = "selected" @endif> PRODUCTO</option>
                                                <option value="S" @if ("S" == old('id_tipo')) selected = "selected" @endif> SERVICIO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <h4 class="sub-title">Unidades</h4>
                                    <div class="form-group row">
                                        {{-- <div class="col-md-4 col-lg-4"> --}}
                                            <label class="col-sm-2 col-form-label">Tipo de Unidad</label>
                                                <div class="col-sm-10">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" onClick="TipoUnidad()" name="tipo_unidad" id="tipo_unidad_s" value="SIMPLE" checked> Simple </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" onClick="TipoUnidad()" name="tipo_unidad" id="tipo_unidad_m" value="MULTIPLE" {{ old('tipo_unidad')=="MULTIPLE" ? 'checked='.'"'.'checked'.'"' : '' }}> Multiple</label>
                                                    </div>
                                                    <span class="messages"></span>
                                                </div>
                                        {{-- </div> --}}
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-lg-2">
                                            <label for="name-2" class="block">Primaria</label>
                                        </div>
                                        <div class="col-md-4 col-lg-4 @error('id_unidad') is-invalid @enderror">
                                            <select name="id_unidad"
                                                class="js-example-basic-single form-control ">
                                                <option value="0">Seleccione La Unidad</option>
                                                @foreach ($unidades as $unidad)
                                                    <option value="{{ $unidad->id_unidad }}"
                                                        @if ($unidad->id_unidad == old('id_unidad')) selected = "selected" @endif>
                                                        {!! $unidad->nombre_unidad !!}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                            {{-- <label class="col-sm-2 col-form-label">Equivalencia</label> --}}
                                            <div class="col-md-3 col-lg-3">
                                                <input type="text" name="equi_unid_pri" id="equi_unid_pri" class="form-control  @error('equi_unid_pri') is-invalid @enderror autonumber" value="{{ old('equi_unid_pri', '0' ?? '') }}"data-a-sep="," data-a-dec="." placeholder="Equivalencia Primaria">
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-lg-2">
                                            <label for="name-2" class="block">Secundaria</label>
                                        </div>
                                        <div class="col-md-4 col-lg-4 @error('id_unidad_sec') is-invalid @enderror">
                                            <select name="id_unidad_sec"
                                                class="js-example-basic-single form-control">
                                                <option value="0">Seleccione La Unidad</option>
                                                @foreach ($unidades as $unidad)
                                                    <option value="{{ $unidad->id_unidad }}"
                                                        @if ($unidad->id_unidad == old('id_unidad_sec')) selected = "selected" @endif>
                                                        {!! $unidad->nombre_unidad !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <input type="text" name="equi_unid_sec" id="equi_unid_sec" class="form-control @error('equi_unid_sec') is-invalid @enderror autonumber" value="{{ old('equi_unid_sec', '0' ?? '') }}" data-a-sep="," data-a-dec="." placeholder="Equivalencia Secundaria">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="id_unidad_ter_col">
                                        <div class="col-md-2 col-lg-2">
                                            <label for="name-2" class="block">Alterna</label>
                                        </div>
                                        <div class="col-md-4 col-lg-4 @error('id_unidad_ter') is-invalid @enderror">
                                            <select name="id_unidad_ter" id="id_unidad_ter"
                                                class="js-example-basic-single form-control">
                                                <option value="0">Seleccione La Unidad</option>
                                                @foreach ($unidades as $unidad)
                                                    <option value="{{$unidad->id_unidad}}"
                                                        @if ($unidad->id_unidad == old('id_unidad_ter')) selected = "selected" @endif>
                                                        {!! $unidad->nombre_unidad !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-lg-3">
                                            <input type="text" name="equi_unid_ter" id="equi_unid_ter" class="form-control @error('equi_unid_ter') is-invalid @enderror autonumber" value="{{ old('equi_unid_ter', '0' ?? '') }}" data-a-sep="," data-a-dec="." placeholder="Equivalencia Alterna">
                                        </div>
                                    </div>

                                    <h4 class="sub-title">Stock</h4>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-lg-2">
                                            <label for="University-2" class="block">Punto Minimo</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="number"
                                                class="form-control @error('pntominimo_articulo') is-invalid @enderror"
                                                name="pntominimo_articulo" min="0" value="{{ old('pntominimo_articulo', 0 ?? '')}}"
                                                placeholder="" readonly>
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <label for="University-2" class="block">Punto de Pedido</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="number"
                                                class="form-control @error('pntopedido_articulo') is-invalid @enderror"
                                                name="pntopedido_articulo" min="0" value="{{ old('pntopedido_articulo', 0 ?? '') }}"
                                                placeholder="" readonly>
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <label for="University-2" class="block">Punto Maximo</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="number"
                                                class="form-control @error('pntomaximo_articulo') is-invalid @enderror"
                                                name="pntomaximo_articulo" min="0" value="{{ old('pntomaximo_articulo', 0 ?? '')}}"
                                                placeholder="" readonly>
                                        </div>
                                    </div>

                                    <h4 class="sub-title">Otros</h4>
                                    <div class="form-group row">

                                        <div class="col-md-2 col-lg-2">
                                            <label>Codigo Referencia</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text"
                                                class="form-control form-control-bold form-control-uppercase @error('referencia') is-invalid @enderror"
                                                name="referencia" id="referencia" value="{{ old('referencia') }}"
                                                placeholder="Ingrese la referencia">
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <label for="University-2" class="block">Documento</label>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="file"
                                                class="form-control @error('documento_articulo') is-invalid @enderror"
                                                name="documento_articulo" value="{{ old('documento_articulo') }}"
                                                placeholder="Solo documentos PDF"  accept="application/pdf">
                                        </div>
                                    </div>
                                    {{-- <hr> --}}
                                    {{-- <h4 class="sub-title">Datos Adicionales</h4> --}}
                                    <div class="card-block accordion-block color-accordion-block">
                                        <div class="color-accordion" id="color-accordion">
                                            <div class="accordion-heading" role="tab" id="headingOne">
                                                <h3 class="card-title accordion-title">
                                                <a class="accordion-msg bg-primary b-none" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    AGREGAR DATOS ADICIONALES <i class="fa fa-plus"></i>
                                                </a>


                                            </h3>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="form-group row">
                                                        <div class="col-md-3 col-lg-3">
                                                            <label for="name-2" class="block">Clasificación</label>
                                                            <div class="@error('id_clasificacion') is-invalid @enderror">

                                                                <select name="clasificacion" id="_clasificacion"
                                                                    class="js-example-basic-single form-control">
                                                                    <option value="0">Seleccione la Clasificación </option>
                                                                    @foreach ($clasificaciones as $clasificaion)
                                                                    <option value="{{$clasificaion->id_clasificacion}}" @if ($clasificaion->id_clasificacion == old('id_clasificacion')) selected = "selected" @endif>{!!$clasificaion->id_clasificacion!!} - {!!$clasificaion->nombre_clasificacion!!}</option>
                                                                @endforeach
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 col-lg-3">
                                                            <label for="name-2" class="block">Sub Clasificación</label>
                                                            <div class="@error('id_subclasificacion') is-invalid @enderror">
                                                                <select name="id_subclasificacion" id="_subclasificacion" data-old="{{ old('id_subclasificacion') }}"
                                                                    class="js-example-basic-single form-control ">
                                                                    <option value="0">Seleccione</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-lg-4">
                                                            <label for="valor" class="block">Valor</label>
                                                            <input type="text"
                                                                class="form-control form-control-bold form-control-uppercase @error('referencia') is-invalid @enderror"
                                                                name="valor" id="valor" value="{{ old('valor') }}"
                                                                placeholder="Ingrese El Valor">
                                                        </div>

                                                        <div class="col-md-2 col-lg-2">
                                                            <label for="name-2" class="block">Agregar</label>
                                                            <br>
                                                            <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTabla()">
                                                                <i class="fa fa-plus"></i>  </button>
                                                        </div>

                                                    </div>
                                                    <div class="table-responsive">
                                                    <table class="table table-striped table-bordered" id="tabla_adicionales">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Clasificación</th>
                                                                <th>SubClasificación</th>
                                                                <th>Valor</th>
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
                                    {{-- Campo oculto con arreglo de los datos adicionales --}}
                                    <input type="hidden" name="datosadicionales" id="datosadicionales">

                                    <div class="d-grid gap-2 d-md-block float-right">

                                        <button type="button" class="btn btn-primary" 
                                            data-toggle="modal"
                                            data-target="#modal-almacenes"
                                            href="#!"
                                            OnClick="CapturarDatosTabla()">
                                            <i class="fa fa-save"></i>Guardar
                                        </button>
                                    </div>
                                    @include('FichaTecnica.Articulos.ArticuloAlmacenes')
                            {{-- </form> --}}
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

    <!--Bootstrap Typeahead js -->
    <script src=" {{ asset('libraries\bower_components\bootstrap-typeahead\js\bootstrap-typeahead.min.js') }}" ></script>

    {{-- autocompletar nombre de articulo --}}
    <script>   var route = "{{ url('autocompletar') }}";  </script> 
     
    <!--Personalizado -->
    <script src="{{asset('libraries\assets\js\articulos-create.js')}}"> </script>
@endsection
