@extends('layouts.master')

@section('titulo', 'Solicitudes')

@section('titulo_pagina', 'Encuesta de la Solicitud')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('solicitudes.index') }}">Solicitudes</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Encuesta de la Solicitud</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Encuesta de la Solicitud Nº {{$solicitud->id_solicitud}} </h5>
        <hr>
        <h6><strong> Codigo: </strong> {{$solicitud->codigo_solicitud}}</h6>
        <h6><strong>Motivo: </strong> {{$solicitud->asunto_solicitud}}</h6>
        <h6><strong>Comentario: </strong> {{$solicitud->descripcion_solicitud}}</h6>
    </div>
    <div class="card-block">
        @if($EncuestaEnviada == 'SI')
            <div class="alert alert-success background-success">
                <strong>La Encuesta De La Solicitud Fue Enviada</strong> 
            </div>
        @else
            <div class="j-wrapper j-wrapper-640">
                <form action="{{route('solsencuestasolicitud', $solicitud->id_solicitud)}}" method="post" class="j-pro" id="j-pro" novalidate="">
                    @csrf
                    <div class="j-content">
                        <!-- start name -->
                        <div class="j-unit">
                            <label class="j-label">Nombre</label>
                            <div class="j-input">
                                <label class="j-icon-right" for="name">
                                    <i class="icofont icofont-user"></i>
                                </label>
                                <input type="text" id="usuario" name="usuario" placeholder="" value="{{Auth::user()->name}}" readonly>
                            </div>
                        </div>
                        <!-- end name -->
                        <!-- start email-->
                        <div class="j-unit">
                            <label class="j-label">Correo Electronico</label>
                            <div class="j-input">
                                <label class="j-icon-right" for="email">
                                    <i class="icofont icofont-envelope"></i>
                                </label>
                                <input type="email" placeholder="email@domain.com" id="correo" name="correo" value="{{Auth::user()->email}}" readonly>
                            </div>
                        </div>
                        <!-- end email -->
                        {{-- <!-- start message -->
                        <div class="j-unit">
                            <label class="j-label">Review message</label>
                            <div class="j-input">
                                <textarea placeholder="message..." spellcheck="false" name="message"></textarea>
                            </div>
                        </div>
                        <!-- end message --> --}}
                        <div class="j-divider j-gap-bottom-25"></div>
                        <h6 class="sub-title m-b-25">Califique</h6>
                        <!-- start ratings -->
                        <div class="j-unit">
                            <div class="j-rating-group">
                                
                                <label class="j-label">Cumplimiento de normativas para la solicitud del Servicio</label>
                                <div class="j-ratings">
                                    <input id="5q" type="radio" name="calificacion_pregunta1" value="5">
                                    <label for="5q">
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                    <input id="4q" type="radio" name="calificacion_pregunta1" value="4">
                                    <label for="4q">
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                    <input id="3q" type="radio" name="calificacion_pregunta1" value="3">
                                    <label for="3q">
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                    <input id="2q" type="radio" name="calificacion_pregunta1" value="2">
                                    <label for="2q">
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                    <input id="1q" type="radio" name="calificacion_pregunta1" value="1" checked="">
                                    <label for="1q">
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="j-rating-group">
                                <label class="j-label">Nivel de información y planificación del servicio solicitado</label>
                                <div class="j-ratings">
                                    <input id="5s" type="radio" name="calificacion_pregunta2" value="5">
                                    <label for="5s">
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                    <input id="4s" type="radio" name="calificacion_pregunta2" value="4">
                                    <label for="4s">
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                    <input id="3s" type="radio" name="calificacion_pregunta2" value="3">
                                    <label for="3s">
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                    <input id="2s" type="radio" name="calificacion_pregunta2" value="2">
                                    <label for="2s">
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                    <input id="1s" type="radio" name="calificacion_pregunta2" value="1" checked="" alt="Bueno">
                                    <label for="1s">
                                        <i class="icofont icofont-star"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- end ratings -->
                    </div>
                    <!-- end /.content -->
                    <div class="j-footer">
                        <button type="submit" class="btn btn-primary">Finalizar</button>
                    </div>
                    <!-- end /.footer -->
                </form>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')


@endsection