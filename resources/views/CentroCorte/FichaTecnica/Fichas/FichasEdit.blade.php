@extends('layouts.master')

@section('titulo', 'Fichas')

@section('titulo_pagina', 'Fichas')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Centro de Corte</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('cencfichas.index') }}">Fichas</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>

@endsection

@section('contenido')

    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')
    <div class="card">
        <div class="card-header">
            <h5>Editar Fichas</h5>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-12">
                    <div id="wizard">
                            <form method="POST" action=" {{ route('cencfichas.update', $ficha->id_ficha) }}" enctype="multipart/form-data">
                                @csrf @method('put')
                                    <div class="form-group row">

                                        <div class="col-md-1 col-lg-1">
                                            <label for="name-3" class="block">Nombre</label>
                                        </div>
                                            <div class="col-sm-3" id="scrollable-dropdown-menu">
                                                <input type="text"
                                                    class="typeahead form-control @error('nombre_ficha') is-invalid @enderror"
                                                    id="nombre_ficha" name="nombre_ficha" value="{{ old('nombre_ficha', $ficha->nombre_ficha ?? '') }}"
                                                    placeholder="Ingrese el Nombre del ficha">
                                            </div>

                                        <div class="cols-sm-1 col-lg-1">
                                            <label for="name-2" class="block">Tipo de Ficha</label>
                                        </div>
                                        <div class="col-sm-3 col-lg-3">
                                            <input type="text"
                                            class="typeahead form-control @error('nombre_ficha') is-invalid @enderror"
                                            id="nombre_ficha" name="nombre_ficha" value="{{$tipos[0]->nombre_tipo}}"
                                            placeholder="Ingrese el Nombre del ficha" disabled ="true">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Descripción</label>
                                        <div class="col-sm-11">
                                            <textarea rows="3" cols="3" class="form-control @error('descripcion_ficha') is-invalid @enderror"
                                                name="descripcion_ficha"
                                                placeholder="Tipo de ficha tecnica">{{ old('descripcion_ficha', $ficha->descripcion_ficha ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <hr><br>

                                    {{-- <div class="form-group row">

                                        <div class="col-md-3 col-lg-3">
                                            <label for="name-2" class="block">Caracteristicas</label>
                                            <div class="@error('id_caracteristica2') is-invalid @enderror">
                                                <select name="id_caracteristica2" id="id_caracteristica2"
                                                    class="js-example-basic-single form-control ">
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-4">
                                            <label for="valor_caracteristica2" class="block">Valor</label>
                                            <input type="text"
                                                class="form-control form-control-bold form-control-uppercase @error('valor_caracteristica2') is-invalid @enderror"
                                                name="valor_caracteristica2" id="valor_caracteristica2" value="{{ old('valor_caracteristica2') }}"
                                                placeholder="Ingrese El Valor">
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <label for="name-2" class="block">Agregar</label>
                                            <br>
                                            <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTabla2()">
                                                <i class="fa fa-plus"></i>  </button>
                                        </div>
                                    </div> --}}
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="tabla_caracteristicas2">
                                            <thead>
                                                <tr>
                                                    <th style="visibility:collapse; display:none;">Ficha valor</th>
                                                    <th style="width: 5%">#</th>
                                                    <th>Caracteristica</th>
                                                    <th style="width: 15%">Valor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($caracteristicas as $caracteristica)
                                                    <tr>
                                                        <td id='id_ficha_valor' style="visibility:collapse; display:none;">{{$caracteristica->id_ficha_valor}}</td>
                                                        <td id='id_caracteristica2'>{{$caracteristica->id_caracteristica}}</td>
                                                        <td id='nombre_caracteristica2'>{{$caracteristica->nombre_caracteristica}}</td>
                                                        <td contenteditable="true" id='valor_caracteristica2'>{{$caracteristica->valor_caracteristica}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <br>
                                    {{-- Campo oculto con arreglo de los datos adicionales --}}
                                    <input type="hidden" name="caracteristicas2" id="caracteristicas2">
                                    <div class="d-grid gap-2 d-md-block float-right">
                                        <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla2()">
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

    <!--Bootstrap Typeahead js -->
    <script src=" {{ asset('libraries\bower_components\bootstrap-typeahead\js\bootstrap-typeahead.min.js') }}" ></script>
     
    <!--Personalizado -->
    <script>
        var RutaCaracteristicas2 = "{{ url('cencfichasvalores') }}";
        var eliminaradicional2 = "{{ url('cenceliminarcaracteristica') }}"; // cenccaracteristicas 
        var caracteristicasvalores = "{{ url('cenccaracteristicas') }}";
    </script>
    <script src="{{asset('libraries\assets\js\CencFicha-edit.js')}}"> </script>


@endsection
