@extends('layouts.master')

@section('titulo', 'Responsables')

@section('titulo_pagina', 'Responsables')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('dashboardcnth') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('responsables.index') }}">Responsables</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>
@endsection


@section('contenido')
    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')

    <!-- Page body start -->
    <!-- Page body start -->
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Basic Inputs Validation start -->
                <div class="card">
                    <div class="card-header">
                        <h5>Crear Responsable</h5>
                    </div>
                    <div class="card-block">
                        <form class="" method="POST" action=" {{ route('responsables.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Departamento</label>
                                <div class="col-sm-10 @error('id_departamento') is-invalid @enderror" >
                                    <select name="id_departamento" class="js-example-basic-single form-control">
                                        <option value="0">Seleccione el Departamento</option>
                                        @foreach ($departamentos as $departamento)
                                            <option value="{{ $departamento->id_departamento }}"
                                                @if ($departamento->id_departamento == old('id_departamento', $responsable->id_departamento ?? '')) selected = "selected" @endif>
                                                {!! $departamento->nombre_departamento!!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('nombre_responsable') is-invalid @enderror"
                                        name="nombre_responsable" value="{{ old('nombre_responsable') }}" placeholder="Ingrese el Nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cargo</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('cargo_responsable') is-invalid @enderror"
                                        name="cargo_responsable" value="{{ old('cargo_responsable') }}" placeholder="Ingrese el Cargo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Correo</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('correo') is-invalid @enderror"
                                        name="correo" value="{{ old('correo') }}" placeholder="Ingrese el Correo">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Estado</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="estatus"
                                                value="SI" checked> Activo </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="estatus"
                                                value="NO"> Inactivo </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-block float-right">
                                <button type="submit" class="btn btn-primary ">
                                    <i class="fa fa-save"></i>Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body end -->
    <!-- Scroll - Vertical, Dynamic Height table end -->
@endsection

@section('scripts')
    <!-- data-table js -->
    <script src="{{ asset('libraries\bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\data-table\js\jszip.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\data-table\js\pdfmake.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\data-table\js\vfs_fonts.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.print.min.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libraries\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}">
    </script>
    <script
        src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
    </script>

    <!-- Custom js -->
    <script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>

    <!-- sweet alert js -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>

    <!-- Select 2 js -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }} ">
    </script>
    <!-- Multiselect js -->
    <script type="text/javascript"
        src="{{ asset('libraries\bower_components\bootstrap-multiselect\js\bootstrap-multiselect.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('libraries\bower_components\multiselect\js\jquery.multi-select.js') }} "></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\js\jquery.quicksearch.js') }} "></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}">
    </script>

@endsection
