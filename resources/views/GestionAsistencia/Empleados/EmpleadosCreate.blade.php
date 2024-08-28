@extends('layouts.master')

@section('titulo', 'Empleados')

@section('titulo_pagina', 'Asignar Horario')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Gestion de Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('gstaempleados.index') }}">Empleados</a> </li>
    <li class="breadcrumb-item"><a href="#!">Asignar</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>Empleado</strong></h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('gstaempleados.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 form-label">Nombre Empleado</label>
                <div class="col-sm-4">
                    <input type="hidden" name="id_biometrico" id="id_biometrico" class="form-control " value="{{ old('id_biometrico', $empleados->cod_biometrico) }}">
                    <input type="hidden" name="id_empleado" id="id_empleado" class="form-control " value="{{ old('id_empleado', $empleados->cod_emp) }}">
                    <input type="text" name="nombre_empleado" id="nombre_empleado" class="form-control " value="{{ old('nombre_empleado', $empleados->nombres.' '.$empleados->apellidos) }}"readonly>
                </div>

                <label class="col-sm-2 form-label">Empresa</label>
                <div class="col-sm-4">
                    <input type="text" name="nombre_empresa" id="nombre_empresa" class="form-control"  value="{{ $empleados->empresa }}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-label">Departamento</label>
                <div class="col-sm-4">
                    <input type="text" name="nombre_departamento" id="nombre_departamento" class="form-control " value="{{ $empleados->des_depart }}" readonly>
                </div>

                 <label class="col-sm-2 form-label">Horario a Asignar</label>
                <div class="col-sm-4">
                   <select name="id_horario" class="js-example-basic-single form-control" >
                    <option value="SIN ASIGNAR">SIN ASIGNAR</option>
                            @foreach ($horarios as $horario)
                             <option value="{{$horario->id_horario}}">
                                   {{ $horario->nombre_horario }} 
                             </option>
                             @endforeach
                     </select>   
                </div>

            </div>
  
            <hr>
           
            <div class="d-grid gap-2 d-md-block float-right">
                <button type="submit" id="enviar" class="btn btn-primary" >
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