@extends('layouts.master')

@section('titulo', 'Hora de Asistencia')

@section('titulo_pagina', 'Crear Horario')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Gestion de Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('gstahorarios.index') }}">Creacion de Horario</a> </li>
    <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
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
        <form method="POST" action="{{ route('gstahorarios.store') }}">
            @csrf
            <div class="form-group row">
            <label class="col-sm-2 form-label">Nombre Horario</label>
                <div class="col-sm-4">
                    <input type="text" name="nombre_horario" id="nombre_horario" class="form-control @error('nombre_horario') is-invalid @enderror" value="{{ old('nombre_horario') }}">
                </div>

                
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-label">Hora de Inicio Jornada</label>
                <div class="col-sm-4">
                    <input type="time" name="hora_inicio_jornada" id="hora_inicio_jornada" class="form-control @error('hora_inicio_jornada') is-invalid @enderror" value="{{ old('hora_inicio_jornada') }}">    
                </div>
               

                <label class="col-sm-2 form-label">Hora de Fin de Jornada</label>
                <div class="col-sm-4">
                    <input type="time" name="hora_fin_jornada" id="hora_fin_jornada" class="form-control @error('hora_fin_jornada') is-invalid @enderror" value="{{ old('hora_fin_jornada') }}"> 
                </div>
               
            </div>
             <h4 class="sub-title">Horarios de Descanso</h4>
            <div class="form-group row">
           
                <label class="col-sm-2 form-label">Hora de Inicio Descanso</label>
                <div class="col-sm-4">
                    <input type="time" name="hora_inicio_descanso" id="hora_inicio_descanso" class="form-control @error('hora_inicio_descanso') is-invalid @enderror" value="{{ old('hora_inicio_descanso') }}">
                </div>

                <label class="col-sm-2 form-label">Hora de Fin de Descanso</label>
                <div class="col-sm-4">
                    <input type="time" name="hora_fin_descanso" id="hora_fin_descanso" class="form-control @error('hora_fin_descanso') is-invalid @enderror" value="{{ old('hora_fin_descanso') }}">
                </div>
               
            </div>
            <h4 class="sub-title">Dias Laborables</h4>
            
            <div class="form-group row">
                <label class="col-sm-2 form-label">Días de la Semana</label>
                <div class="col-sm-10">
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" id="lunes" name="dias[]" value="Lunes" >
                        <label class="form-check-label" for="lunes">Lunes</label>
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" id="martes" name="dias[]" value="Martes" >
                        <label class="form-check-label" for="martes">Martes</label>
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" id="miercoles" name="dias[]" value="Miércoles" >
                        <label class="form-check-label" for="miercoles">Miércoles</label>
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" id="jueves" name="dias[]" value="Jueves" >
                        <label class="form-check-label" for="jueves">Jueves</label>
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" id="viernes" name="dias[]" value="Viernes" >
                        <label class="form-check-label" for="viernes">Viernes</label>
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" id="sabado" name="dias[]" value="Sábado" >
                        <label class="form-check-label" for="sabado">Sábado</label>
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" id="domingo" name="dias[]" value="Domingo" >
                        <label class="form-check-label" for="domingo">Domingo</label>
                    </div>
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