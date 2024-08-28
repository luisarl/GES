@extends('layouts.master')

@section('titulo', 'Crear SubServicio')

@section('titulo_pagina', 'Crear SubServicio')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('solicitudes.index')}}">Solicitudes de Servicios</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('subservicios.index') }}">Sub Servicios</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear SubServicio</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('subservicios.store') }}">
                @csrf
                <div class="form-group row">    
                    <label class="col-sm-2 col-form-label">Servicio</label>
                   <div class="col-sm-10  @error('id_servicio') is-invalid @enderror">
                       <select name="id_servicio" class="js-example-basic-single form-control @error('id_servicio') is-invalid @enderror">
                           <option value="0">Seleccione el Servicio</option>
                           @foreach ($servicios as $servicio)
                               <option value="{{ $servicio->id_servicio }}"
                                   @if ($servicio->id_servicio == old('id_servicio', $subservicio->id_servicio ?? '')) selected = "selected" @endif>
                                   {!!$servicio->nombre_departamento.' - '.$servicio->nombre_servicio!!}</option>
                           @endforeach
                       </select>
                   </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('nombre_subservicio') is-invalid @enderror" name="nombre_subservicio"
                           value="{{ old('nombre_subservicio') }}" placeholder="Ingrese el Nombre del SubServicio">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('descripcion_subservicio') is-invalid @enderror" name="descripcion_subservicio"
                            placeholder="Ingrese la Descripción del SubServicio">{{ old('descripcion_subservicio') }}</textarea>
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
