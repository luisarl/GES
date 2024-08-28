@extends('layouts.master')

@section('titulo', 'Crear Servicio')

@section('titulo_pagina', 'Crear Servicio')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('servicios.index')}}">Solicitudes de Servicios</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('servicios.index') }}">Servicios</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Servicios</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('servicios.store') }}">
                @csrf
                <div class="form-group row">    
                    <label class="col-sm-2 col-form-label">Departamento</label>
                   <div class="col-sm-10 @error('id_departamento') is-invalid @enderror">
                       <select name="id_departamento" class="js-example-basic-single form-control @error('id_departamento') is-invalid @enderror">
                           <option value="0">Seleccione el Departamento</option>
                           @foreach ($departamentos as $departamento)
                               <option value="{{ $departamento->id_departamento }}"
                                   @if ($departamento->id_departamento == old('id_departamento', $user->id_departamento ?? '')) selected = "selected" @endif>
                                   {!! $departamento->nombre_departamento!!}</option>
                           @endforeach
                       </select>
                   </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('nombre_servicio') is-invalid @enderror" name="nombre_servicio"
                           value="{{ old('nombre_servicio') }}" placeholder="Ingrese el Nombre del Servicio">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('descripcion_servicio') is-invalid @enderror" name="descripcion_servicio"
                            placeholder="Ingrese la Descripción del Servicio">{{ old('descripcion_servicio') }}</textarea>
                    </div>
                </div>
                <hr>
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
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

@endsection
