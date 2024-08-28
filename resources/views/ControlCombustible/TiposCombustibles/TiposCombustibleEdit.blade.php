@extends('layouts.master')

@section('titulo', 'Control Combustible')

@section('titulo_pagina', 'Editar Tipo de Combustible')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Control de Combustible</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('cntctiposcombustible.index') }}">Tipos de Combustible</a> </li>
    <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
<div class="card-header">
        <h4 class="sub-title"><strong>Tipo de Combustible</strong></h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('cntctiposcombustible.update',$tipos->id_tipo_combustible) }}">
            @csrf
            @method('put')
            <div class="form-group row">
                <div class="col-md-3 col-lg-3">
                    <label for="motivo" class="form-label">Nombre Combustible</label>
                    <input type="text" name="combustible" id="combustible" class="form-control @error('combustible') is-invalid @enderror" value="{{$tipos->descripcion_combustible}}">
                </div> 

                <div class="col-md-3 col-lg-3">
                    <label for="departamento" class="form-label">Departamentos</label>
                    <div class=" @error('departamento') is-invalid @enderror">
                        <select name="departamento" id="departamento" class="js-example-basic-single form-control" >
                            <option value="0">SELECCIONE UN DEPARTAMENTO</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id_departamento }}" @if ($departamento->id_departamento == old('departamento',$tipos->id_departamento_encargado )) selected="selected" @endif>
                                    {{ $departamento->nombre_departamento }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <label for="motivo" class="form-label">Stock Inicial</label>
                    <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror"  value="{{$tipos->stock}}">
                </div> 
            </div>
            <hr>
        

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



@endsection