@extends('layouts.master')

@section('titulo', 'Articulo')

@section('titulo_pagina', 'Articulo')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Ficha Tecnica</a> </li>
        <li class="breadcrumb-item"><a href="{{ asset('/articulos') }}">Articulos</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>
@endsection

@section('contenido')

    @include('mensajes.MsjExitoso')
    @include('mensajes.MsjError')
    @include('mensajes.MsjAlerta')
    @include('mensajes.MsjValidacion')
    @include('FichaTecnica.Articulos.ArticulosHabilitar')
    @include('FichaTecnica.Articulos.ArticulosInactivar')
    @include('FichaTecnica.Articulos.ArticuloEliminarImagen')
    @include('FichaTecnica.Articulos.ArticuloAprobar')

    <div class="card">
        <div class="row card-header">
            <div class="col-6">
                <h5>Editar Articulo
                    @can('fict.articulos.habilitar')
                        @if ($articulo->estatus == 'MIGRADO' || $articulo->estatus == 'MIGRACION PENDIENTE')
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modal-habilitar" title="Habilitar Articulo" href="#!">
                                <i class="fa fa-unlock"></i>
                            </button>
                        @else
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modal-habilitar" title="Bloquear Articulo" href="#!">
                                <i class="fa fa-lock"></i>
                            </button>
                        @endif
                    @endcan
                </h5>
            </div>
            <div class="col-6">
                @if (str_replace(' ', '', $articulo->activo) == 'NO')
                    <h1 class="text-danger">ARTICULO INACTIVO</h1>
                @else
                    <div class="d-grid gap-2 d-md-block float-right">
                        <h5>Estatus:</h5>
                        @if ($articulo->estatus == 'MIGRADO')
                            <label class="label label-primary label-lg">{{$articulo->estatus}}</label>
                        @elseif($articulo->estatus == 'NO MIGRADO')
                            <label class="label label-warning label-lg">{{$articulo->estatus}}</label>
                        @elseif($articulo->estatus == 'MIGRACION PENDIENTE')
                            <label class="label label-danger label-lg">{{$articulo->estatus}}</label>
                            @elseif($articulo->estatus == 'APROBACION PENDIENTE')
                            <label class="label label-warning label-lg">{{$articulo->estatus}}</label>
                        @endif
                    </div>    
                 @endif
            </div>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action=" {{ route('articulos.update', $articulo->id_articulo) }}"
                        enctype="multipart/form-data">
                        @csrf @method('put')

                        <div class="form-group row">
                            <div class="col-md-2 col-lg-2 @error('imagen_articulo') @enderror ">
                                <label for="userName-2" class="block">Imagen</label>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="row">

                                    @foreach ($imagenes as $imagen)
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <div class="thumbnail img-150">
                                                <div class="thumb">
                                                    <a href="{{ asset($imagen->imagen) }} " data-lightbox="1"
                                                        data-title="{{ $articulo->nombre_articulo }}">
                                                        <img src="{{ asset($imagen->imagen) }}" alt=""
                                                            class="img-fluid img-thumbnail">
                                                    </a>
                                                    @if ($articulo->estatus == 'NO MIGRADO' || $articulo->estatus == 'APROBACION PENDIENTE')
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-id="{{ $imagen->id_articulo_imagen }}"
                                                            data-imagen="{{ asset($imagen->imagen) }}" data-toggle="modal"
                                                            data-target="#modal-eliminar-imagen" data-toggle="modal"
                                                            data-target="#modal-eliminar-imagen" title="Eliminar Imagen "
                                                            href="#!">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 @error('imagen_articulo') is-invalid @enderror">
                                @if ($articulo->estatus == 'NO MIGRADO' || $articulo->estatus == 'APROBACION PENDIENTE')
                                    <input type="file" name="imagen_articulo" id="filer_input_single"
                                        multiple="multiple">
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            @can('fict.articulo.generar.codigo')
                                <label class="col-sm-2 col-form-label">Codigo</label>
                                <div class="col-sm-3">
                                    <input type="text"
                                        class="form-control form-control-bold form-control-uppercase @error('codigo_articulo') is-invalid @enderror"
                                        name="codigo_articulo" id='codigo_articulo'
                                        value="{{ old('codigo_articulo', $articulo->codigo_articulo ?? '') }}"
                                        placeholder="Ingrese El Codigo"
                                        @if (($articulo->estatus == 'NO MIGRADO' && $migrado) ||
                                            ($articulo->estatus == 'MIGRACION PENDIENTE' && $migrado)) readonly
                                                            @elseif ($articulo->estatus == 'MIGRADO')
                                                                readonly @endif>
                                </div>
                                @if ($migrado == false)
                                    <div class="col-sm-3">
                                        <button onclick="GenerarCodigo()" class="form-control btn btn-primary btn-sm"
                                            type="button"> <i class="fa fa-refresh"></i> Generar </button>
                                    </div>
                                @endif
                            @endcan

                            @if ($articulo->estatus == 'MIGRADO' || $articulo->estatus == 'MIGRACION PENDIENTE')
                                @can('fict.articulos.activo')
                                    <div class="col-sm-3">
                                        @if (str_replace(' ', '', $articulo->activo) == 'NO')
                                            <button type="button" class="form-control btn btn-primary btn-sm"
                                                data-toggle="modal" data-target="#modal-inactivar" title="Activar Articulo"
                                                href="#!">
                                                <i class="fa fa-ban"></i> Activar Articulo
                                            </button>
                                        @else
                                            <button type="button" class="form-control btn btn-primary btn-sm"
                                                data-toggle="modal" data-target="#modal-inactivar" title="Inactivar Articulo"
                                                href="#!">
                                                <i class="fa fa-ban"></i> Inactivar Articulo
                                            </button>
                                        @endif
                                    </div>
                                @endcan
                            @endif

                            {{-- Campo oculto para almacenar el correlativo --}}
                            <input type="hidden" class="form-control" name="correlativo" id="correlativo"
                                value="{{ old('correlativo', $articulo->correlativo ?? '') }}">
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('nombre_articulo') is-invalid @enderror"
                                    name="nombre_articulo"
                                    value=" {{ old('nombre_articulo', $articulo->nombre_articulo ?? '') }}"
                                    placeholder="Ingrese el Nombre del articulo" {{ $deshabilitar }}>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Descripción</label>
                            <div class="col-sm-10">
                                <textarea rows="3" cols="3" class="form-control @error('descripcion_articulo') is-invalid @enderror"
                                    name="descripcion_articulo" {{ $deshabilitar }} placeholder="Ingrese la Descripción, Uso o Fin del Articulo">{{ old('descripcion_articulo', $articulo->descripcion_articulo ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 col-lg-2">
                                <label for="name-2" class="block">Grupos</label>
                            </div>
                            <div class="col-md-4 col-lg-4 @error('id_grupo') is-invalid @enderror">
                                <select name="id_grupo" id="_grupos" class="js-example-basic-single form-control "
                                    {{-- @if (($articulo->estatus == 'NO MIGRADO' && $migrado) ||
                                        ($articulo->estatus == 'MIGRACION PENDIENTE' && $migrado)) readonly --}}
                                                    @if ($articulo->estatus == 'MIGRADO')
                                                        readonly @endif
                                                        >
                                    <option value="0">Seleccione el Grupo </option>
                                    @foreach ($grupos as $grupo)
                                        <option value="{{ $grupo->id_grupo }}"
                                            @if ($grupo->id_grupo == old('id_grupo', $articulo->id_grupo ?? '')) selected = "selected" @endif>
                                            {{ $grupo->codigo_grupo }} - {!! $grupo->nombre_grupo !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <label for="name-2" class="block">Sub Grupos</label>
                            </div>
                            <div class="col-md-4 col-lg-4 @error('id_subgrupo') is-invalid @enderror">
                                <select name="id_subgrupo" id="_subgrupos"
                                    {{-- @if (($articulo->estatus == 'NO MIGRADO' && $migrado) ||
                                        ($articulo->estatus == 'MIGRACION PENDIENTE' && $migrado)) readonly --}}
                                                    @if ($articulo->estatus == 'MIGRADO')
                                                        readonly @endif
                                    data-old="{{ old('id_subgrupo', $articulo->id_subgrupo ?? '') }}"
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
                                <select name="id_categoria" {{ $deshabilitar }}
                                    class="js-example-basic-single form-control">
                                    <option value="0">Seleccione la Categoria</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}"
                                            @if ($categoria->id_categoria == old('id_categoria', $articulo->id_categoria ?? '')) selected = "selected" @endif>
                                            {{ $categoria->codigo_categoria }} - {!! $categoria->nombre_categoria !!}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <label for="name-2" class="block">Tipo</label>
                            </div>
                            <div class="col-md-4 col-lg-4 @error('id_tipo') is-invalid @enderror">
                                <select name="id_tipo" {{ $deshabilitar }} class="js-example-basic-single form-control ">
                                    <option value="0">Seleccione El Tipo</option>
                                    <option value="V"
                                        @if ('V' == old('id_tipo', $articulo->id_tipo ?? '')) selected = "selected" @endif> PRODUCTO</option>
                                    <option value="S"
                                        @if ('S' == old('id_tipo', $articulo->id_tipo ?? '')) selected = "selected" @endif> SERVICIO</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="sub-title">Unidades</h4>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tipo de Unidad</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" onClick="TipoUnidad()"
                                            name="tipo_unidad" id="tipo_unidad_s" value="SIMPLE" {{ $deshabilitar }}
                                            @if ($articulo->tipo_unidad == 'SIMPLE') checked @endif> Simple </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" onClick="TipoUnidad()"
                                            name="tipo_unidad" id="tipo_unidad_m" value="MULTIPLE" {{ $deshabilitar }}
                                            @if ($articulo->tipo_unidad == 'MULTIPLE') checked @endif
                                            {{ old('tipo_unidad') == 'MULTIPLE' ? 'checked=' . '"' . 'checked' . '"' : '' }}>
                                        Multiple </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 col-lg-2">
                                <label for="name-2" class="block">Primaria</label>
                            </div>
                            <div class="col-md-4 col-lg-4  @error('id_unidad') is-invalid @enderror">
                                <select name="id_unidad" {{ $deshabilitar }}
                                    class="js-example-basic-single form-control">
                                    <option value="0">Seleccione Unidad</option>
                                    @foreach ($unidades as $unidad)
                                        <option value="{{ $unidad->id_unidad }}"
                                            @if ($unidad->id_unidad == old('id_unidad', $articulo->id_unidad ?? '')) selected = "selected" @endif>
                                            {!! $unidad->nombre_unidad !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <input type="text" name="equi_unid_pri" id="equi_unid_pri" {{ $deshabilitar }}
                                    class="form-control @error('equi_unid_pri') is-invalid @enderror autonumber"
                                    value="{{ old('equi_unid_pri', $articulo->equi_unid_pri ?? '') }}" data-a-sep=","
                                    data-a-dec="." placeholder="Equivalencia Primaria">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 col-lg-2">
                                <label for="name-2" class="block">Secundaria</label>
                            </div>
                            <div class="col-md-4 col-lg-4 @error('id_unidad_sec') is-invalid @enderror ">
                                <select name="id_unidad_sec" {{ $deshabilitar }}
                                    class="js-example-basic-single form-control">
                                    <option value="0">Seleccione Unidad</option>
                                    @foreach ($unidades as $unidad)
                                        <option value="{{ $unidad->id_unidad }}"
                                            @if ($unidad->id_unidad == old('id_unidad_sec', $articulo->id_unidad_sec ?? '')) selected = "selected" @endif>
                                            {!! $unidad->nombre_unidad !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <input type="text" name="equi_unid_sec" id="equi_unid_sec" {{ $deshabilitar }}
                                    class="form-control @error('equi_unid_sec') is-invalid @enderror autonumber"
                                    value="{{ old('equi_unid_sec', $articulo->equi_unid_sec ?? '') }}" data-a-sep=","
                                    data-a-dec="." placeholder="Equivalencia Secundaria">
                            </div>
                        </div>
                        <div class="form-group row" id="id_unidad_ter_col">
                            <div class="col-md-2 col-lg-2">
                                <label for="name-2" class="block">Alterna</label>
                            </div>
                            <div class="col-md-4 col-lg-4 @error('id_unidad_ter') is-invalid @enderror">
                                <select name="id_unidad_ter" {{ $deshabilitar }}
                                    class="js-example-basic-single form-control">
                                    <option value="0">Seleccione Unidad</option>
                                    @foreach ($unidades as $unidad)
                                        <option value="{{ $unidad->id_unidad }}"
                                            @if ($unidad->id_unidad == old('id_unidad_ter', $articulo->id_unidad_ter ?? '')) selected = "selected" @endif>
                                            {!! $unidad->nombre_unidad !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <input type="text" name="equi_unid_ter" id="equi_unid_ter" {{ $deshabilitar }}
                                    class="form-control @error('equi_unid_ter') is-invalid @enderror autonumber"
                                    value="{{ old('equi_unid_ter', $articulo->equi_unid_ter ?? '') }}" data-a-sep=","
                                    data-a-dec="." placeholder="Equivalencia Secundaria">
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
                                    name="pntominimo_articulo" min="0"
                                    value="{{ old('pntominimo_articulo', $articulo->pntominimo_articulo ?? '') }}"
                                    placeholder="" {{ $deshabilitar }} readonly>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <label for="University-2" class="block">Punto de Pedido</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="number"
                                    class="form-control @error('pntopedido_articulo') is-invalid @enderror"
                                    name="pntopedido_articulo" min="0"
                                    value="{{ old('pntopedido_articulo', $articulo->pntopedido_articulo ?? '') }}"
                                    placeholder="" {{ $deshabilitar }} readonly>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <label for="University-2" class="block">Punto Maximo</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="number"
                                    class="form-control @error('pntomaximo_articulo') is-invalid @enderror"
                                    name="pntomaximo_articulo" min="0"
                                    value="{{ old('pntomaximo_articulo', $articulo->pntomaximo_articulo ?? '') }}"
                                    placeholder="" {{ $deshabilitar }} readonly>
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
                                    name="referencia" id="referencia"
                                    value="{{ old('referencia', $articulo->referencia ?? '') }}"
                                    placeholder="Ingrese la referencia" {{ $deshabilitar }}>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <label for="University-2" class="block">Documento</label>
                            </div>
                            <div class="col-sm-5">
                                <input type="file"
                                    class="form-control @error('documento_articulo') is-invalid @enderror"
                                    name="documento_articulo"
                                    value="{{ old('documento_articulo', $articulo->documento_articulo ?? '') }}"
                                    placeholder="" accept="application/pdf" {{ $deshabilitar }}>

                                @if ($articulo->documento_articulo != '')
                                    <br>
                                    <a href="{{ asset($articulo->documento_articulo) }}" class="label label-primary"
                                        target="_blank">Ver Documento</a>
                                @endif

                            </div>
                        </div>
                        
                        <div class="card-block accordion-block color-accordion-block">
                            <div class="color-accordion" id="color-accordion">
                                <div class="accordion-heading" role="tab" id="headingOne">
                                    <h3 class="card-title accordion-title">
                                        <a class="accordion-msg bg-primary b-none" data-toggle="collapse"
                                            data-parent="#accordion" href="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            AGREGAR DATOS ADICIONALES <i class="fa fa-plus"></i>
                                        </a>
                                    </h3>
                                </div>
                                {{-- Si los datos adicionales estan vacios --}}
                                @if ($DatosAdicionales == '[]')
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                        aria-labelledby="headingOne">
                                    @else
                                        <div class="accordion-box" id="single-open">
                                @endif

                                <div class="accordion-content accordion-desc">
                                    @if ($articulo->estatus == 'NO MIGRADO' || $articulo->estatus == 'APROBACION PENDIENTE' )
                                        <div class="form-group row">
                                            <div class="col-md-3 col-lg-3">
                                                <label for="name-2" class="block">Clasificación</label>
                                                <div class="@error('id_clasificacion') is-invalid @enderror">

                                                    <select name="clasificacion" id="_clasificacion"
                                                        class="js-example-basic-single form-control">
                                                        <option value="0">Seleccione la Clasificación </option>
                                                        @foreach ($clasificaciones as $clasificaion)
                                                            <option value="{{$clasificaion->id_clasificacion}}"
                                                                @if ($clasificaion->id_clasificacion == old('id_clasificacion')) selected = "selected" 
                                                                @endif>{!!$clasificaion->id_clasificacion!!} - {!!$clasificaion->nombre_clasificacion!!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-lg-3">
                                                <label for="name-2" class="block">Sub Clasificación</label>
                                                <div class="@error('id_subclasificacion') is-invalid @enderror">
                                                    <select name="id_subclasificacion" id="_subclasificacion"
                                                        data-old="{{ old('id_subclasificacion') }}"
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
                                                <button type="button" class="btn btn-primary btn-sm" title="Agregar"
                                                    onClick="CargarTablaClasificaciones()">
                                                    <i class="fa fa-plus"></i> </button>
                                            </div>
                                        </div>
                                    @endif
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
                                                @foreach ($DatosAdicionales as $adicionales)
                                                    <tr>
                                                        <td id="id_articulo_clasificacion">{{$adicionales->id_articulo_clasificacion}}</td>
                                                        <td id="id_clasificacion" style="visibility:collapse; display:none;">{{$adicionales->id_clasificacion}}</td>
                                                        <td id="nombre_clasificacion">{{ $adicionales->nombre_clasificacion }}</td>
                                                        <td id="id_subclasificacion" style="visibility:collapse; display:none;">{{$adicionales->id_subclasificacion}}</td>
                                                        <td id="nombre_subclasificacion">{{ $adicionales->nombre_subclasificacion }}</td>
                                                        <td id="valor" contenteditable="true"> {{ $adicionales->valor }} </td>
                                                        <th>
                                                            @if ($articulo->estatus == 'NO MIGRADO' || $articulo->estatus == 'APROBACION PENDIENTE')
                                                                <button type="button"
                                                                    onclick="EliminarAdicional({{ $adicionales->id_articulo_clasificacion }})"
                                                                    class="borrar btn btn-danger btn-sm"><i
                                                                        class="fa fa-trash"></i></button>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                {{-- Campo oculto con arreglo de los datos adicionales --}}
                <input type="hidden" name="datosadicionales" id="datosadicionales">

                <hr>
                <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ $responsables->fecha_creacion  }}">
                    <strong> SOLICITADO POR: </strong> {{ $responsables->creado_por }} </label>
                <br>
                <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ $responsables->fecha_aprobacion  }}">
                    <strong> APROBADO POR: </strong> {{ $responsables->aprobado_por }} </label>
                <br>
                <label data-toggle="popover" data-placement="bottom"  title="FECHA:" data-content="{{ $responsables->fecha_catalogacion  }}">
                    <strong> CATALOGADO POR: </strong> {{ $responsables->catalogado_por }} </label>
                <br>

                @if ($articulo->estatus == 'NO MIGRADO' || $articulo->estatus == 'APROBACION PENDIENTE' )
                    <div class="d-grid gap-2 d-md-block float-right">
                        {{-- APROBACION DE ARTICULO --}}
                        {{--  Si el Articulo No esta Aprobado y miembro del Departamento de solicitante o Departamento de sistemas --}}
                        @if(($articulo->aprobado == 'NO' && Auth::user()->id_departamento == $DepartamentoAprobacion) ||
                            ($articulo->aprobado == 'NO' && Auth::user()->id_departamento == 1) ) 
                            @can('fict.articulos.aprobar')
                                <button type="button" class="btn btn-primary"  
                                data-toggle="modal" data-target="#modal-aprobar-articulo" title="Activar Articulo"
                                href="#!">
                                    <i class="fa fa-check-square-o"></i>Aprobar
                                </button>
                            @endcan    
                        @endif    

                        <button type="submit" class="btn btn-primary" onclick="CapturarDatosTablaClasificacion()">
                            <i class="fa fa-save"></i>Guardar
                        </button>
                    </div>
                @endif
                </form>
            </div>
        </div>
    </div>
    </div>

    {{-- UBICACION DE ARTICULOS  --}}
    @if($articulo->estatus == 'MIGRADO')
    @can('fict.articulos.ubicacion')
        <div class="card">
            <div class="card-header">
                <h5>Ubicacion Articulo</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="{{ route('articulosubicaciones.update', $articulo->id_articulo) }}">
                            @method('put')
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-3 col-lg-3">
                                    <label for="name-2" class="block">Almacen</label>
                                    <select name="id_almacen" id="_almacenes" class="js-example-basic-single form-control">
                                        <option value="0">Seleccione el Almacén</option>
                                        @foreach ($almacenes as $almacen)
                                            <option value="{{ $almacen->id_almacen }}"
                                            @if ($almacen->id_almacen == old('id_almacen')) selected="selected" @endif>{!! $almacen->id_almacen !!} -
                                            {!! $almacen->nombre_almacen !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-lg-3"> 
                                    <label for="name-2" class="block ">SubAlmacen</label>
                                    <select name="id_subalmacen" id="_subalmacenes" data-old="{{ old('id_subalmacen') }}" class="js-example-basic-single form-control ">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label for="name-2" class="block">Zona</label>
                                    <select name="id_ubicacion" id="_zonas" data-old="{{ old('id_ubicacion') }}" class="js-example-basic-single form-control same-size-input">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <label for="valor" class="block">Ubicación</label>
                                    <input type="text" class="form-control form-control-lg" name="id_zona" id="_ubicaciones" value="{{ old('id_zona') }}" placeholder="Ubicación">
                                </div>
                                <div class="col-md-1 col-lg-1">
                                    <label for="name-2" class="block">Agregar</label>
                                    <br>
                                    <button type="button" class="btn btn-primary btn-sm" title="Agregar" 
                                        onClick="CargarTablaUbicacion()">
                                        <i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tabla_ubicaciones">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%">#</th>
                                            <th style="text-align: left">Almacen</th>
                                            <th style="text-align: left">Subalmacen</th>
                                            <th style="text-align: left">Zona</th>
                                            <th style="text-align: left">Ubicacion</th>
                                            <th style="text-align: center">Acciones</th>
                                        </tr>
                                    </thead>
                        
                                    <tbody>
                                        @foreach ($ubicaciones->sortBy('id_articulo_ubicacion') as $ubicacion)
                                            <tr>
                                                <td id="id_articulo_ubicacion">{{$ubicacion->id_articulo_ubicacion}}</td>
                                                <td>{{$ubicacion->nombre_almacen}}</td>
                                                <td id="id_almacen" style='visibility:collapse; display:none;'>{{$ubicacion->id_almacen}}</td>
                                                <td >{{$ubicacion->nombre_subalmacen}}</td>
                                                <td id="id_subalmacen" style='visibility:collapse; display:none;'>{{$ubicacion->id_subalmacen}}</td>
                                                <td >{{$ubicacion->nombre_ubicacion}}</td>
                                                <td id="id_zona" style='visibility:collapse; display:none;'>{{$ubicacion->id_ubicacion}}</td>
                                                <td id="id_ubicacion" style="width: 13%" contenteditable="true">{{$ubicacion->zona}}</td>  
            
                                                <th style="text-align: center">
                                                    <a class="btn btn-primary btn-sm" title="Imprimir" target="_blank"
                                                    href=" {{ route('fictimprimiretiquetas', ['id_articulo' => $ubicacion->id_articulo, 'id_almacen' =>  $ubicacion->id_almacen, 'id_subalmacen' => $ubicacion->id_subalmacen])}}" >
                                                    <i class="fa fa-print fa-2x"></i></a>  
                                                    
                                                    <button type="button" onclick="EliminarUbicacion({{ $ubicacion->id_articulo_ubicacion}})" class="borrar btn btn-danger btn-sm"><i class="fa fa-trash fa-2x"></i></button>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- Campo oculto con arreglo de los datos adicionales --}}
                            <input type="hidden" name="datosubicaciones" id="datosubicaciones">
        
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary" onclick="CapturarDatosTablaUbicacion()"><i class="fa fa-save"></i>Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    @endcan
    @endif
    {{-- FIN  --}}

    @if (str_replace(' ', '', $articulo->activo) == 'SI' && $articulo->codigo_articulo != '')
        @can('fict.articulos.migracion')
            <div class="card">
                <div class="card-header">
                    <h5>Enviar Articulo a Profit</h5>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Listado de Empresas</h5>
                                </div>
                                <div class="card-block table-border-style">
                                <form action="{{ route('migracion') }}" method="post">
                                    @csrf
                                    {{-- CAMPO OCULTO CON EL ID DEL ARTICULO --}}
                                    <input type="hidden" name="id_articulo"value="{{ $articulo->id_articulo }}">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Almacen</th>
                                                    <th>Empresa</th>
                                                    {{-- <th>BD</th> --}}
                                                    <th>
                                                        @foreach ($empresas as $empresa)
                                                            @php $contador = $loop->count; @endphp
                                                        @endforeach

                                                        @if ($articulo->estatus == 'NO MIGRADO' || $contador != $ConteoAlmacenesArticulo)
                                                            <div class="checkbox-fade fade-in-primary">
                                                                <label>
                                                                    <input type="checkbox" id="todos" name="todos"
                                                                        value="">
                                                                    <span class="cr">
                                                                        <i
                                                                            class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                    </span>
                                                                    <span>Marcar/Desmarcar Todos</span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($empresas as $empresa)
                                                    <tr>
                                                        <td>{{ $empresa->id_empresa }}</td>
                                                        <td>{{ $empresa->alias_empresa }} </td>
                                                        <td>{{ $empresa->nombre_empresa }}</td>
                                                        {{-- <td>{{ $empresa->base_datos }}</td> --}}
                                                        <td>
                                                            {{-- Busca si un articulo esta migrado y/o tiene solicitud a una empresa --}}
                                                            @php
                                                                $EstatusArticulo = App\Models\Articulo_MigracionModel::EstatusArticuloMigracion($articulo->id_articulo, $empresa->id_empresa);
                                                                if ($EstatusArticulo != null) 
                                                                {
                                                                    $migrado = str_replace(' ', '', $EstatusArticulo->migrado);
                                                                    $solicitado = str_replace(' ', '', $EstatusArticulo->solicitado);
                                                                } 
                                                                else 
                                                                    {
                                                                        $migrado = '';
                                                                        $solicitado = '';
                                                                    }
                                                            @endphp
                                                            @if ($migrado == 'SI')
                                                                @if ($articulo->estatus == 'NO MIGRADO')
                                                                    <div class="checkbox-fade fade-in-primary">
                                                                        <label>
                                                                            <input type="checkbox" id="empresas"
                                                                                name="empresas[]"
                                                                                value="{{ $empresa->id_empresa }}">
                                                                            <span class="cr">
                                                                                <i
                                                                                    class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endif

                                                                <label class="label label-info label-lg "
                                                                    data-toggle="popover" data-placement="right"
                                                                    title="MIGRADO POR:"
                                                                    data-content="{{ $EstatusArticulo->nombre_usuario }}">
                                                                    <i class="fa fa-check-square-o text-dark"> </i> <strong
                                                                        class="text-dark"> DISPONIBLE EN PROFIT
                                                                    </strong></label>
                                                            @elseif($migrado == 'NO' && $solicitado == 'SI')
                                                                <div class="checkbox-fade fade-in-primary">
                                                                    <label>
                                                                        <input type="checkbox" id="empresas"
                                                                            name="empresas[]"
                                                                            value="{{ $empresa->id_empresa }}">
                                                                        <span class="cr">
                                                                            <i
                                                                                class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <label class="label label-danger label-lg "
                                                                    data-toggle="popover" data-placement="right"
                                                                    title="SOLICITADO POR:"
                                                                    data-content="{{ $EstatusArticulo->nombre_solicitante }}">
                                                                    <i class="fa fa-info-circle text-dark"> </i> <strong
                                                                        class="text-dark"> MIGRACION PENDIENTE
                                                                    </strong></label>
                                                            @else
                                                                <div class="checkbox-fade fade-in-primary">
                                                                    <label>
                                                                        <input type="checkbox" id="empresas"
                                                                            name="empresas[]"
                                                                            value="{{ $empresa->id_empresa }}">
                                                                        <span class="cr">
                                                                            <i
                                                                                class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- VALIDA SI UN ARTICULO ESTA MIGRADO EN TODAS LAS EMPRESAS
                                    DE DESHABILITA EL BOTON DE ENVIAR A PROFIT --}}
                                    @if ($articulo->estatus == 'NO MIGRADO' || $contador != $ConteoAlmacenesArticulo)
                                        <div class="d-grid gap-2 d-md-block float-right">

                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#modal-migracion" href="#!">
                                                <i class="fa fa-share-square-o"></i> Enviar
                                            </button>
                                        </div>
                                    @endif
                                    @include('FichaTecnica.Articulos.ArticulosMigrate')
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    @endif

@endsection

@section('scripts')
    <!--Forms - Wizard js-->
    <script src="{{ asset('libraries\bower_components\jquery.cookie\js\jquery.cookie.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\jquery.steps\js\jquery.steps.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\jquery-validation\js\jquery.validate.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\forms-wizard-validation\form-wizard.js') }}"></script>

    <!-- jquery file upload js -->
    <script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

    <!-- Select -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

    <script type="text/javascript" src=" {{ asset('libraries\bower_components\lightbox2\js\lightbox.min.js') }} "></script>

    <!-- Masking js -->
    <script src="{{ asset('libraries\assets\pages\form-masking\inputmask.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\autoNumeric.js') }} "></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\jquery.inputmask.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\form-mask.js') }} "></script>

    <!--Personalizado -->
    <script>
        var eliminaradicionales = "{{ url('eliminaradicionales') }}";
        var eliminarubicaciones = "{{ url('eliminarubicaciones') }}";
        var obtenersubalmacen = "{{ url('obtenersubalmacen') }}"; 
        var obtenerzonas = "{{ url('obtenerzonas') }}"; 
    </script>
    <script src="{{ asset('libraries\assets\js\articulos-edit.js') }}"></script>
    <script src="{{ asset('libraries\assets\js\FictUbicaciones.js') }}"></script>

    <script>

        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function() {
            $('[data-toggle="popover"]').popover({
                html: true,
                content: function() {
                    return $('#primary-popover-content').html();
                }
            });
        });
    </script>
    <script>
        $('#modal-eliminar-imagen').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            var imagen = button.data('imagen') // Extrae la imagen de data-imagen
            action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            action += id; // se agrega el id seleccionado al formulario

            $('#formdelete').attr('action', action); //cambia la ruta del formulario

            var modal = $(this)
            modal.find('.modal-body img').attr('src', imagen); // agrega la imagen al modal

        })
    </script>


{{-- <script>
    // Le añadimos función de borrar al botón
    document.getElementById("clearbutton").onclick = limpiaCampo;

    // En este caso concreto seleccionamos todos los input text y password
    // para una selección más precisa se puede usa una clase
    // para una selección más general, se puede usar solo 'input'
    var elements = document.querySelectorAll("input[type='text'],input[type='password']");
    // Por cada input field le añadimos una funcion 'onFocus'
    for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener("focus", function() {
        // Guardamos la ID del elemento al que hacemos 'focus'
        inputfocused = this;
    });
    }

    function limpiaCampo() {
    //Utilizamos el elemento al que hacemos focus para borrar el campo.
    inputfocused.value = "";
    }
</script> --}}



@endsection
