@extends('layouts.master')

@section('titulo', 'Activos')

@section('titulo_pagina', 'Activos')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ asset('/activos') }}">Activos</a>
    </li>
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
        <h5>Editar Activos</h5>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('activos.update', $activo->id_activo) }}" enctype="multipart/form-data">
            @csrf @method('put')
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="imagen" class="col-md-2 col-lg-2 col-form-label">Imagen</label>
                    <div class="col-md-3 col-lg-3">
                        <div class="thumbnail img-150">
                            <div class="thumb">
                                <a href="{{ asset($activo->imagen_activo) }} " data-lightbox="1"
                                    data-title="{{ $activo->nombre_activo }}">
                                    <img src="{{ asset($activo->imagen_activo) }}" alt=""
                                        class="img-fluid img-thumbnail">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 @error('imagen_activo') is-invalid @enderror">
                        <input type="file" name="imagen_activo" id="filer_input_single"
                            value="{{ old('imagen_activo[]') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="codigo" class="col-md-2 col-lg-2 col-form-label">Codigo</label>
                    <div class="col-sm-3">
                        <input type="text"
                            class="form-control form-control-bold form-control-uppercase @error('codigo_activo') is-invalid @enderror"
                            name="codigo_activo" id="codigo_activo"
                            value="{{ old('codigo_activo', $activo->codigo_activo ?? '') }}"
                            placeholder="Ingrese el Codigo">
                    </div>
                    <label for="serial" class="col-md-1 col-lg-1 col-form-label">Serial</label>
                    <div class="col-sm-3">
                        <input type="text"
                            class="form-control form-control-bold form-control-uppercase @error('serial') is-invalid @enderror"
                            name="serial" id="serial" value="{{ old('serial', $activo->serial ?? '') }}"
                            placeholder="Ingrese el Serial">
                    </div>
                    <label for="estatus" class="col-md-1 col-lg-1 col-form-label">Estatus</label>
                    <div class="col-sm-2">
                        <select name="estatus_activo" id="estatus_activo" class="js-example-basic-single form-control">
                            <option value="ACTIVO" @if('ACTIVO' == old('estatus_activo', $activo->estatus ?? '')) selected = "selected" @endif>ACTIVO</option>
                            <option value="INACTIVO" @if('INACTIVO' == old('estatus_activo', $activo->estatus ?? '')) selected = "selected" @endif>INACTIVO</option>
                            <option value="DESINCORPORADO" @if('DESINCORPORADO' == old('estatus_activo', $activo->estatus ?? '')) selected = "selected" @endif>DESINCORPORADO</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nombre" class="col-md-2 col-lg-2 col-form-label">Nombre</label>
                    <div class="col-sm-3" id="scrollable-dropdown-menu">
                        <input type="text" class="typeahead form-control @error('nombre_activo') is-invalid @enderror"
                            id="nombre_activo" name="nombre_activo"
                            value="{{ old('nombre_activo', $activo->nombre_activo ?? '') }}"
                            placeholder="Ingrese el Nombre del Activo">
                    </div>
                    <label for="marca" class="col-md-1 col-lg-1 col-form-label">Marca</label>
                    <div class="col-sm-3" id="scrollable-dropdown-menu">
                        <input type="text" class="typeahead form-control @error('marca') is-invalid @enderror"
                            id="marca" name="marca" value="{{ old('marca', $activo->marca ?? '') }}"
                            placeholder="Ingrese la Marca del Activo">

                    </div>

                    <label for="condicion" class="col-sm-1 col-form-label">Condición</label>
                    <div class="col-sm-2">
                        <select name="estado_activo" id="estado_activo" class="js-example-basic-single form-control">
                            <option disabled selected>Seleccione la condicion del activo</option>
                            @foreach ($estados as $estado)
                            <option value="{{ $estado->id_estado }}" @if ($estado->id_estado == old('id_estado',
                                $activo->id_estado ?? '')) selected = "selected" @endif>
                                {{ $estado->nombre_estado }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3"
                            class="form-control @error('descripcion_activo') is-invalid @enderror"
                            name="descripcion_activo"
                            placeholder="Uso o Fin del Activo">{{ old('descripcion_activo', $activo->descripcion_activo ?? '') }}</textarea>
                    </div>
                </div>

                <h4 class="sub-title">Tipos</h4>
                <div class="form-group row">
                    <label for="tipos" class="col-md-2 col-lg-2 col-form-label">Tipos</label>
                    <div class="col-sm-3 @error('id_tipo') is-invalid @enderror">
                        <select name="id_tipo" id='id_tipo' class="js-example-basic-single form-control">
                            <option value="0">Seleccione el Tipo</option>
                            @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id_tipo }}" @if ($tipo->id_tipo == old('id_tipo', $activo->id_tipo
                                ?? '')) selected = "selected" @endif>
                                {{ $tipo->nombre_tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="subtipos" class="col-md-1 col-lg-1 col-form-label">Subtipos</label>
                    <div class="col-sm-3 @error('id_subtipo') is-invalid @enderror">
                        <select name="id_subtipo" id="_subtipos"
                            data-old="{{ old('id_subtipo', $activo->id_subtipo ?? '') }}"
                            class="js-example-basic-single form-control ">
                            <option value="0">Seleccione el Subtipos</option>
                        </select>
                    </div>
                </div>

                <h4 class="sub-title">Ubicacion</h4>
                <div class="form-group row">
                    <label for="departamento" class="col-md-2 col-lg-2 col-form-label">Departamento</label>
                    <div class="col-sm-3 @error('id_departamento') is-invalid @enderror">
                        <select name="id_departamento" class="js-example-basic-single form-control">
                            <option value="0">Seleccione el Departamento</option>
                            @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento }}" @if ($departamento->id_departamento ==
                                old('id_departamento', $activo->id_departamento ?? '')) selected = "selected" @endif>
                                {{ $departamento->nombre_departamento }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="name-2" class="col-md-1 col-lg-1 col-form-label">Ubicacion</label>
                    <div class="col-sm-3" id="scrollable-dropdown-menu">
                        <input type="text" class="form-control @error('ubicacion') is-invalid @enderror" id="ubicacion"
                            name="ubicacion" value="{{ old('ubicacion', $activo->ubicacion ?? '') }}"
                            placeholder="Ingrese Ubicacion del Activo">
                    </div>
                    <label class="col-md-1 col-lg-1 col-form-label">Responsable</label>
                    <div class="col-sm-2" id="">
                        <input type="text" class="form-control @error('responsable') is-invalid @enderror"
                            id="responsable" name="responsable"
                            value="{{ old('ubicacion', $activo->responsable ?? '') }}" placeholder="Ingrese el Nombre">
                    </div>
                </div>

                <hr>
                <div class="card-block accordion-block color-accordion-block">
                    <div class="color-accordion" id="color-accordion">
                        <div class="accordion-heading" role="tab" id="headingOne">
                            <h3 class="card-title accordion-title">
                                <a class="accordion-msg bg-primary b-none" data-toggle="collapse"
                                    data-parent="#accordion" href="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    AGREGAR CARACTERISTICAS <i class="fa fa-plus"></i>
                                </a>
                            </h3>
                        </div>
                        {{-- Si los datos adicionales estan vacios --}}
                        @if ($caracteristicas == '[]')
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="headingOne">
                            @else
                            <div class="accordion-box" id="single-open">
                                @endif
                                <div class="accordion-content accordion-desc">
                                    <div class="form-group row">
                                        <div class="col-md-3 col-lg-3">
                                            <label for="name-2" class="block">Caracteristica</label>
                                            <div class="@error('id_caracteristica') is-invalid @enderror">
                                                <select name="id_caracteristica" id="id_caracteristica"
                                                    data-old="{{ old('id_caracteristica') }}"
                                                    class="js-example-basic-single form-control ">
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-4">
                                            <label for="valor_caracteristica" class="block">Valor</label>
                                            <input type="text"
                                                class="form-control form-control-bold form-control-uppercase @error('valor_caracteristica') is-invalid @enderror"
                                                name="valor_caracteristica" id="valor_caracteristica"
                                                value="{{ old('valor_caracteristica') }}"
                                                placeholder="Ingrese El Valor">
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
                                        <table class="table table-striped table-bordered" id="tabla_caracteristicas">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Caracteristica</th>
                                                    <th>Valor</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($CaracteristicasActivo as $caracteristica)
                                                <tr>
                                                    <td id='id_activo_caracteristica'>{{$caracteristica->id_activo_caracteristica}}</td>
                                                    <td id='id_caracteristica' style='visibility:collapse; display:none;'>{{$caracteristica->id_caracteristica}}</td>
                                                    <td id='nombre_caracteristica'>{{$caracteristica->nombre_caracteristica}}</td>
                                                    <td id='valor_caracteristica'>{{$caracteristica->valor_caracteristica}}</td>
                                                    <th>
                                                        <button type="button"
                                                            onclick="EliminarAdicional({{ $caracteristica->id_activo_caracteristica }})"
                                                            class="borrar btn btn-danger btn-sm"><i
                                                                class="fa fa-trash"></i></button>
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
                    {{-- Campo oculto con arreglo de las caracteristicas--}}
                    <input type="hidden" name="caracteristicas" id="caracteristicas">
                    <div class="d-grid gap-2 d-md-block float-right">
                        <button type="submit" class="btn btn-primary" onclick="CapturarDatosTabla()">
                            <i class="fa fa-save"></i>Guardar
                        </button>
                    </div>
                </div>
            </div>
        </form>
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

<!-- lightbox js -->
<script type="text/javascript" src=" {{ asset('libraries\bower_components\lightbox2\js\lightbox.min.js') }} "></script>
<script>
    lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })
</script>

<!--Personalizado -->
<script>
    var RutaSubTipos = "{{ url('actvsubtipos') }}";
        var RutaCaracteristicas = "{{ url('actvcaracteristicas') }}";
        var eliminaradicional = "{{ url('actveliminarcaracteristica') }}";
</script>
<script src="{{ asset('libraries\assets\js\activos-edit.js') }}"></script>

@endsection