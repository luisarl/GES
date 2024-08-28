@extends('layouts.master')

@section('titulo', 'Perfiles')

@section('titulo_pagina', 'Perfiles')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('perfiles.index') }}">Perfiles</a>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>
@endsection

@section('contenido')
    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')


    <div class="card">
        <div class="card-header">
            <h5>Crear Perfil</h5>

        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('perfiles.store') }}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}"
                            placeholder="Ingrese El Nombre del perfil">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Permisos</label>
                    <div class="col-sm-10">
                        <button type="button" class="btn btn-primary waves-effect waves-light m-b-10" id='select-all'>
                            Agregar Todos
                        </button>
                        <button type="button" class="btn btn-primary waves-effect waves-light m-b-10" id='deselect-all'>
                            Quitar Todos
                        </button>
                        <select name='permisos[]' id='public-methods' class="searchable" multiple='multiple'>
                            @foreach ($permisos as $permiso)
                            <option value="{{ $permiso->name }}"
                                @if ($permiso->name == old('permisos', $perfiles->name ?? '')) selected = "selected" @endif>
                                {!! $permiso->name !!}</option>
                            @endforeach
                        </select>
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
@endsection

@section('scripts')
<!-- Select 2 js -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }} "></script>
<!-- Multiselect js -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\bootstrap-multiselect\js\bootstrap-multiselect.js') }}">

</script>
<script type="text/javascript" src="{{ asset('libraries\bower_components\multiselect\js\jquery.multi-select.js') }} "></script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\jquery.quicksearch.js') }} "></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

@endsection