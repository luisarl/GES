@extends('layouts.master')

@section('titulo', 'Hora de Asistencia')

@section('titulo_pagina', 'Editar Horario')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Gestion de Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('gstahorarios.index') }}">Editar Horario</a> </li>
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>Horarios de Jornada</strong></h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('gstahorarios.update',$horarios->id_horario) }}">
            @csrf
            @method('put')
            <div class="form-group row">
            <label class="col-sm-2 form-label">Nombre Horario</label>
                <div class="col-sm-4">
                    <input type="text" name="nombre_horario" id="nombre_horario" class="form-control @error('nombre_horario') is-invalid @enderror" value="{{ old('nombre_horario',$horarios->nombre_horario) }}">
                </div>

                
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-label">Hora de Inicio Jornada</label>
                <div class="col-sm-4">
                    <input type="time" name="hora_inicio_jornada" id="hora_inicio_jornada" class="form-control "value="{{ old('hora_inicio_jornada', \Carbon\Carbon::parse($horarios->inicio_jornada)->format('H:i') ?? '') }}"  >
                </div>

                <label class="col-sm-2 form-label">Hora de Fin de Jornada</label>
                <div class="col-sm-4">
                    <input type="time" name="hora_fin_jornada" id="hora_fin_jornada" class="form-control "value="{{ old('fin_jornada', \Carbon\Carbon::parse($horarios->fin_jornada)->format('H:i') ?? '') }}">
                </div>
               
            </div>
             <h4 class="sub-title">Horarios de Descanso</h4>
            <div class="form-group row">
           
                <label class="col-sm-2 form-label">Hora de Inicio Descanso</label>
                <div class="col-sm-4">
                    <input type="time" name="hora_inicio_descanso" id="hora_inicio_descanso" class="form-control "value="{{ old('inicio_descanso', \Carbon\Carbon::parse($horarios->inicio_descanso)->format('H:i') ?? '') }}">
                </div>

                <label class="col-sm-2 form-label">Hora de Fin de Descanso</label>
                <div class="col-sm-4">
                    <input type="time" name="hora_fin_descanso" id="hora_fin_descanso" class="form-control"value="{{ old('fin_descanso', \Carbon\Carbon::parse($horarios->fin_descanso)->format('H:i') ?? '') }}">
                </div>
               
            </div>
            <h4 class="sub-title">Dias Laborables</h4>
            
            <div class="form-group row">
                <label class="col-sm-2 form-label">Días de la Semana</label>
                <div class="col-sm-10">
                    @php
                    
                    $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                    @endphp
                    @foreach($diasSemana as $dia)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="{{ strtolower($dia) }}" name="dias[]" value="{{ $dia }}" {{ in_array($dia, $diasSeleccionados) ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ strtolower($dia) }}">{{ $dia }}</label>
                    </div>
                    @endforeach
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