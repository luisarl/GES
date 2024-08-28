@extends('layouts.master')

@section('titulo', 'Crear Maquina')

@section('titulo_pagina', 'Crear Maquina')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('embamaquinas.index') }}">Maquinas</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Maquina</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('embamaquinas.store') }}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Asignar Embarcacion</label>
                    <div class="col-sm-10">
                        <select name="id_embarcacion" id="id_embarcacion"
                            data-old="{{ old('id_embarcacion') }}"
                            class="js-example-basic-single form-control ">
                            <option value="">Seleccione</option>
                            @foreach ($embarcaciones as $embarcacion)
                                <option value="{{$embarcacion->id_embarcaciones}}">{{$embarcacion->nombre_embarcaciones}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('nombre_maquina') is-invalid @enderror" name="nombre_maquina"
                           value="{{ old('nombre_maquina') }}" placeholder="Ingrese el Nombre de la Maquina">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('descripcion_maquina') is-invalid @enderror" name="descripcion_maquina"
                            placeholder="Ingrese la Descripción de la maquina">{{ old('descripcion_maquina') }}</textarea>
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
                                    AGREGAR PARAMETROS <i class="fa fa-plus"></i>
                                </a>
                            </h3>
                        </div>
                        <div class="accordion-box" id="single-open">
                            <div class="accordion-content accordion-desc">
                                <div class="form-group row">
                                    <div class="col-md-4 col-lg-4">
                                        <label for="name-2" class="block">Parametros</label>
                                        <div class="@error('id_parametro') is-invalid @enderror">
                                            <select name="id_parametro" id="id_parametro"
                                                data-old="{{ old('id_parametro') }}"
                                                class="js-example-basic-single form-control ">
                                                <option value="0">Seleccione</option>
                                                @foreach ($parametros as $parametro)
                                                    <option value="{{$parametro->id_parametro}}">{{$parametro->nombre_parametro}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-lg-2">
                                        <label for="name-2" class="block">Valor Minimo</label>
                                        <input type="text" class="form-control" name="valor_minimo" id="valor_minimo">
                                    </div>
                                    <div class="col-md-2 col-lg-2">
                                        <label for="name-2" class="block">Valor Maximo</label>
                                        <input type="text" class="form-control" name="valor_maximo" id="valor_maximo">
                                    </div>
                                    <div class="col-md-2 col-lg-2">
                                        <label for="name-2" class="block">Agregar</label>
                                        <br>
                                        <button type="button" class="btn btn-primary btn-sm" title="Agregar"
                                            onClick="CargarTabla()">
                                            <i class="fa fa-plus"></i> </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="tabla_parametros">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width:100px">Orden</th>
                                                <th>Parametros</th>
                                                <th>Minimo</th>
                                                <th>Maximo</th>
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
                <input type="hidden" name="parametros" id="parametros">
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
<script type="text/javascript" src="{{ asset('libraries\assets\js\EmbaMaquinas.js') }}"></script>

@endsection
