@extends('layouts.master')

@section('titulo', 'Hora de Asistencia')

@section('titulo_pagina', 'Horario')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Gestion Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="{{ url('gstahorarios') }}">Horarios</a> </li>
    <li class="breadcrumb-item"><a href="#!">Ver</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')

<div class="card product-detail-page">
    <div class="card-block">
        <div class="row">
            <div class="col-lg-12 col-xs-12 product-detail" id="product-detail">
                <div class="row">
                    <div class="col-lg-12">
                    {{-- BOTON EDITAR --}}  
                      

                            <a href="{{ route('gstahorarios.edit', $horario->id_horario) }}" type="button"
                                class="btn btn-primary btn-sm float-right mr-2" title="Editar">
                                <i class="fa fa-edit fa-2x"></i> </a>
                        
                      <br>
                    <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($horario->created_at)) }}">
                            <strong>CREADO EL: </strong> {{ $horario->created_at }} </label>
                        <br>
                    
                        <hr>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-block">
        <h4 class="sub-title">Horario</h4>
        <div class="table-responsive">
           
            @csrf
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th style="width:5%">ID HORARIO</th>
                        <th style="width:10%">NOMBRE HORARIO</th>
                        <th style="width:30%">HORA DE INICIO DE JORNADA</th>
                        <th style="width:5%">HORA DE FIN DE JORNADA</th>
                        <th style="width:5%">HORA DE INICIO DESCANSO</th>
                        <th style="width:20%">HORA DE FIN DE DESCANSO</th>
                        <th style="width:20%">DIAS LABORABLES</th>
                    </tr>
                </thead>
                <tbody>
                    
                        <tr>
                        <td>{{$horario->id_horario}}</td>
                        <td>{{$horario->nombre_horario}}</td>
                        <td>{{date('g:i:s A', strtotime($horario->inicio_jornada))}}</td>
                        <td>{{date('g:i:s A', strtotime($horario->fin_jornada))}}</td>
                        <td>{{date('g:i:s A', strtotime($horario->inicio_descanso))}}</td>
                        <td>{{date('g:i:s A', strtotime($horario->fin_descanso))}}</td>
                        <td>{{$horario->dias_seleccionados}}</td>
                        </tr>
                    
                </tbody>
            </table>
        </div>  
    </div>
</div>
@endsection

@section('scripts')

@endsection