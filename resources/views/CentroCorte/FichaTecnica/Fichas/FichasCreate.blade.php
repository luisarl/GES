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
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')

    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')
    <div class="card">
        <div class="card-header">
            <h5>Crear Fichas</h5>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-12">
                    <div id="wizard">
                            <form method="POST" action=" {{ route('cencfichas.store') }}" enctype="multipart/form-data">
                                @csrf
                                    <div class="form-group row">

                                        {{-- <div class="col-md-1 col-lg-1">
                                            <label for="name-2" class="block">Codigo</label>
                                        </div>
                                            <div class="col-sm-3">
                                                <input type="text"
                                                    class="typeahead form-control @error('codigo_ficha') is-invalid @enderror"
                                                    name="codigo_ficha" id="codigo_ficha" value="{{ old('codigo_ficha') }}"
                                                    placeholder="Ingrese Codigo">
                                            </div> --}}

                                        <div class="col-md-1 col-lg-1">
                                            <label for="name-3" class="block">Nombre</label>
                                        </div>
                                            <div class="col-sm-3" id="scrollable-dropdown-menu">
                                                <input type="text"
                                                    class="typeahead form-control @error('nombre_ficha') is-invalid @enderror"
                                                    id="nombre_ficha" name="nombre_ficha" value="{{ old('nombre_ficha') }}"
                                                    placeholder="Ingrese Nombre">
                                            </div>
                                        <div class="cols-sm-1 col-lg-1">
                                            <label for="name-2" class="block">Tipo de Ficha</label>
                                        </div>
                                            <div class="col-sm-3 col-lg-3">
                                                <select name="id_tipo" id='id_tipo' class="js-example-basic-single form-control" >
                                                    <option value="0">Seleccione el Tipo</option>
                                                    @foreach($tipos as $tipo)
                                                    <option value="{{ $tipo->id_tipo }}"
                                                        @if ($tipo->id_tipo == old('id_tipo')) selected = "selected" @endif>
                                                        {{ $tipo->nombre_tipo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Descripción</label>
                                        <div class="col-sm-11">
                                            <textarea rows="3" cols="3" class="form-control @error('descripcion_ficha') is-invalid @enderror"
                                                name="descripcion_ficha"
                                                placeholder="Tipo de ficha tecnica">{{ old('descripcion_ficha') }}</textarea>
                                        </div>
                                    </div>
                                    <hr><br>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="tabla_caracteristicas">
                                            <thead>
                                                <th>#</th>
                                                <th>Caracteristica</th>
                                                <th>Valor</th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr><br>
                                    {{-- Campo oculto con arreglo de los datos adicionales --}}
                                    <input type="hidden" name="caracteristicas" id="caracteristicas">
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

    <!--Bootstrap Typeahead js -->
    <script src=" {{ asset('libraries\bower_components\bootstrap-typeahead\js\bootstrap-typeahead.min.js') }}" ></script>
     
    <!--Personalizado -->
    <script>
        var ruta = "{{ url('cencfichascaracteristicasp') }}";
    </script>
    <script src="{{asset('libraries\assets\js\CencFicha-create.js')}}"> </script>
@endsection
