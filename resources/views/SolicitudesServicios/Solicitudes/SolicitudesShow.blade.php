@extends('layouts.master')

@section('titulo', 'Solicitudes')

@section('titulo_pagina', 'Solicitudes')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('solicitudes.index') }}">Solicitudes</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Editar Solicitud</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

<div class="page-body">
    <div class="row">
        <div class="col-xl-8 col-lg-12 ">
            <div class="card">
                {{-- <div class="card-header">
                    
                </div> --}}
                <div class="card-block">
                    <span class="title m-r-10 m-b-15 h6 "><i class="icofont icofont-tasks-alt m-r-5"></i> SOLICITUD Nº  {{$solicitud->id_solicitud}} </strong> </span>
                    @if($solicitud->estatus == 'POR ACEPTAR')
                        <label class="label label-warning">POR ACEPTAR</label>
                    @elseif($solicitud->estatus == 'ABIERTO')
                        <label class="label label-info">ABIERTO</label>
                    @elseif($solicitud->estatus == 'EN PROCESO')
                        <label class="label label-warning">EN PROCESO</label>
                    @elseif($solicitud->estatus == 'CERRADO')
                        <label class="label label-primary">CERRADO</label>
                    @elseif($solicitud->estatus == 'FINALIZADO')
                        <label class="label label-success">FINALIZADO</label>
                    @elseif($solicitud->estatus == 'ANULADO')
                        <label class="label label-danger">ANULADO</label>
                    @elseif($solicitud->estatus == 'NO PROCEDE')
                        <label class="label label-danger">NO PROCEDE</label>    
                    @endif
                    
                    {{-- BOTON IMPRIMIR --}}
                    <a href="{{ route('solsimprimirot', $solicitud->id_solicitud) }}" target="_blank" type="button"
                        class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir OT">
                        <i class="fa fa-print"></i> Imprimir OT</a>

                    <a href="{{ route('solicitudes/imprimir/solicitud', $solicitud->id_solicitud) }}" target="_blank" type="button"
                        class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                        <i class="fa fa-print"></i> Imprimir</a>

                    {{-- BOTON ACEPTAR --}}
                    @if($solicitud->estatus == 'POR ACEPTAR' && Auth::user()->id_departamento == $solicitud->id_departamento_servicio)
                        @can('sols.solicitudes.aceptar')
                            @include('SolicitudesServicios.Solicitudes.SolicitudesAprobacion')

                            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                data-target="#modal-aprobacion-solicitud" title="Aceptar Solicitud" href="#!">
                                <i class="fa fa-check-square"></i>Aceptar
                            </button>
                        @endcan
                    @endif
                    {{-- BOTON REABRIR --}}
                    @if(($solicitud->estatus == 'CERRADO' || $solicitud->estatus == 'NO PROCEDE') && (Auth::user()->id_departamento == $solicitud->id_departamento_servicio || Auth::user()->id_departamento == $solicitud->id_departamento_solicitud))
                        @can('sols.solicitudes.reabrir')
                            @include('SolicitudesServicios.Solicitudes.SolicitudesReabrir')

                            <button type="button" class="btn btn-primary btn-sm float-right m-r-10" data-toggle="modal"
                                    data-target="#modal-reabrir-solicitud" title="Reabrir Solicitud" href="#!">
                                    <i class="fa fa-undo"></i>Reabrir
                            </button>
                        @endcan
                    @endif
                    <hr>
                    <table class="table table-borderless table-responsive table-xs">
                        <tbody>
                            <tr>
                                <th>PRIORIDAD : </th> <td>{{$solicitud->prioridad}}</td>
                                <th>CODIGO: </th> <td>{{$solicitud->codigo_solicitud}}</td>
                            </tr>
                            <tr>
                                <th>USUARIO : </th> <td>{{$solicitud->creado_por}}</td>
                                <th>FECHA CREACION : </th> <td>{{date('d-m-Y g:i:s A', strtotime($solicitud->fecha_creacion))}}</td>
                            </tr>
                            <tr>
                                <th>DEPARTAMENTO SOLI. : </th> <td>{{$solicitud->nombre_departamento_solicitud}}</td>
                                <th>DEPARTAMENTO SERV. : </th> <td>{{$solicitud->nombre_departamento_servicio}}</td>
                            </tr>
                            <tr>
                                <th>CORREO : </th> <td> <a href="mailto:{{$solicitud->correo_usuario}}">{{$solicitud->correo_usuario}}</a> </td>
                                <th>SERVICIO : </th> <td>{{$solicitud->nombre_servicio}}</td>
                            </tr>
                            <tr>
                                <th>DIRECCION IP: </th><td>{{$solicitud->direccion_ip}}</td>
                                <th>SUBSERVICIO : </th><td>{{$solicitud->nombre_subservicio}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <div class="">
                        <div class="m-b-20">
                            <h6 class="sub-title m-b-15"><i class="icofont icofont-ui-note"> </i>Motivo</h6>
                            <p>
                                {{$solicitud->asunto_solicitud}}
                            </p>
                            {{-- DEPARTAMENTO LOGISTICA --}}   
                            @if($solicitud->id_departamento_servicio == 9)
                            <p>
                                ORIGEN : {{$solicitud->logistica_origen}} <br> DESTINO : {{$solicitud->logistica_destino}} 
                                <br> FECHA/HORA : {{date('d-m-Y g:i:s A', strtotime($solicitud->logistica_fecha))}} <br> NUMERO TELEFONICO: {{$solicitud->logistica_telefono}}
                            </p>
                            @endif

                            {{-- DEPARTAMENTO MANTENIMIENTO --}}    
                            @if($solicitud->id_departamento_servicio == 10)
                            <p>
                                TIPO : {{$solicitud->mantenimiento_tipo_equipo}} <br> 
                                NOMBRE : {{$solicitud->mantenimiento_nombre_equipo}}<br> 
                                PLACA/CODIGO : {{$solicitud->mantenimiento_codigo_equipo}} 
                            </p>
                            @endif
                            {{-- DEPARTAMENTO MANTENIMIENTO EMBARCACIONES --}}    
                            @if($solicitud->id_departamento_servicio == 22)
                            <p>
                                EMBARCACION / UNIDAD : {{$solicitud->mantenimiento_tipo_equipo}} <br> 
                                EQUIPO : {{$solicitud->mantenimiento_nombre_equipo}} 
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card comment-block">
                <div class="">
                    {{-- <h5 class="card-header-text"><i class="icofont icofont-comment m-r-5"></i> Comentarios</h5> --}}
                    {{-- <button type="button" class="btn btn-sm btn-primary f-right">
                        <i class="icofont icofont-plus"></i>
                    </button> --}}
                </div>
                <div class="card-block">
                    <h6 class="sub-title m-b-15"><i class="icofont icofont-comment"> </i>COMENTARIOS</h6>
                    <ul class="media-list">
                        @foreach($SolicitudDetalle as $detalle)   
                        <li>
                            <div class="card list-view-media">
                                <div class="card-block">
                                    <div class="media">
                                        <a class="media-left" href="#">
                                            <img class="media-object img-radius comment-img" src="{{asset('libraries/assets/images/avatar.jpg')}}" alt="Avatar Usuario">
                                        </a>
                                        <div class="media-body">
                                            <div class="col-xs-12">
                                                <h6 class="d-inline-block"> {{$detalle->usuario}}</h6>
                                                @if($detalle->estatus == 'POR ACEPTAR')
                                                    <label class="label label-warning">POR ACEPTAR</label>
                                                    @elseif($detalle->estatus == 'ABIERTO')
                                                        <label class="label label-info">ABIERTO</label>
                                                    @elseif($detalle->estatus == 'EN PROCESO')
                                                        <label class="label label-warning">EN PROCESO</label>
                                                    @elseif($detalle->estatus == 'CERRADO')
                                                        <label class="label label-primary">CERRADO</label>
                                                    @elseif($detalle->estatus == 'FINALIZADO')
                                                        <label class="label label-success">FINALIZADO</label>
                                                    @elseif($detalle->estatus == 'ANULADO')
                                                        <label class="label label-danger">ANULADO</label>
                                                    @elseif($detalle->estatus == 'NO PROCEDE')
                                                        <label class="label label-danger">NO PROCEDE</label> 
                                                @else
                                                    {{$detalle->estatus}} 
                                                @endif
                                            </div>
                                            <div class="f-13 text-muted m-b-15">
                                                {{date('d-m-Y g:i:s A', strtotime($detalle->fecha))}}
                                            </div>
                                            <p>{{$detalle->comentario}}</p>
                                            @if($detalle->documentos == 'SI')
                                            <div class="m-t-15">
                                                <span> <i class="icofont icofont-attachment text-primary p-absolute f-30"></i></span>
                                                @php
                                                    $documentos = App\Models\Sols_Solicitudes_DocumentosModel::all()->where('id_solicitud', '=', $solicitud->id_solicitud)->where('id_solicitud_detalle', '=', $detalle->id_solicitud_detalle);
                                                @endphp
                                                @foreach($documentos as $documento)
                                                    <span>
                                                        <a href="{{asset($documento->ubicacion_documento)}}" target="_blank" class="link-active m-r-10 f-12">{{$documento->nombre_documento}}</a>
                                                    </span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Task-detail-left end -->
        <!-- Task-detail-right start -->
        <div class="col-xl-4 col-lg-12 ">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text"><i class="icofont icofont-clock-time m-r-10"></i>Tiempo Transcurrido
                    </h5>
                </div>
                <div class="card-block">
                    <div class="counter">
                        <div class="yourCountdownContainer">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h2>{{$TiempoTranscurrido->days}}</h2>
                                    <p>Dias</p>
                                </div>
                                <div class="col-sm-3">
                                    <h2>{{$TiempoTranscurrido->h}}</h2>
                                    <p>Horas</p>
                                </div>
                                <div class="col-sm-3">
                                    <h2>{{$TiempoTranscurrido->i}}</h2>
                                    <p>Minutos</p>
                                </div>
                                <div class="col-sm-3">
                                    <h2>{{$TiempoTranscurrido->s}}</h2>
                                    <p>Segundos</p>
                                </div>
                            </div>
                            <!-- end of row -->
                        </div>
                        <!-- end of yourCountdown -->
                    </div>
                    <!-- end of counter -->
                </div>
            </div>
            {{-- DETALLES --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text"><i class="icofont icofont-ui-calendar m-r-10"></i>Fechas</h5>
                </div>
                <div class="card-block task-details">
                    <table class="table table-border table-xs">
                        <tbody>
                            <tr>
                                <td><i class="fa fa-calendar-plus-o m-r-5"></i></i> Creada:</td>
                                <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($solicitud->fecha_creacion))}}</td>
                            </tr>
                            @if($solicitud->fecha_aceptacion != NULL)
                                <tr>
                                    <td><i class="fa fa-calendar-check-o m-r-5"></i> Aceptada: <span>{{$solicitud->aceptada}}</span></td>
                                    <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($solicitud->fecha_aceptacion))}}</td>
                                </tr>
                            @endif
                            @if($solicitud->fecha_asignacion != NULL)
                                <tr>
                                    <td><i class="fa fa-calendar m-r-5"></i> Asigada: </td>
                                    <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($solicitud->fecha_asignacion))}}</td>
                                </tr>
                            @endif
                            @if($solicitud->fecha_cierre != NULL)
                                <tr>
                                    <td><i class="fa fa-calendar m-r-5"></i> Cerrada: </td>
                                    <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($solicitud->fecha_cierre))}}</td>
                                </tr>
                            @endif
                            @if($solicitud->fecha_finalizacion != NULL)
                                <tr>
                                    <td><i class="fa fa-calendar m-r-5"></i> Finalizada: </td>
                                    <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($solicitud->fecha_finalizacion))}}</td>
                                </tr>
                            @endif
                            @if($solicitud->fecha_anulacion != NULL)
                                <tr>
                                    <td><i class="fa fa-calendar-times-o m-r-5"></i> Anulada: </td>
                                    <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($solicitud->fecha_anulacion))}}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- TECNICO ASIGNADO --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text"><i class="icofont icofont-users-alt-4 m-r-10"></i> Responsables Asignados</h5>
                </div>
                <div class="card-block user-box assign-user">
                    @foreach($ResponsablesSolicitud as $responsable)
                        <div class="media"> 
                            <div class="media-left media-middle photo-table">
                                <a href="#">
                                    <img class="img-radius" src=" {{ asset('libraries/assets/images/avatar.jpg') }}"
                                        alt="chat-user">
                                </a>
                            </div>
                            <div class="media-body">
                                <h6>{{$responsable->nombre_responsable}}</h6>
                                <p>{{ucwords(strtolower($responsable->cargo_responsable))}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ENCUESTA SERVICIO --}}
            @if($EncuestaServicio != NULL)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text"><i class="icofont icofont-prescription m-r-10"></i> Encuesta Servicio</h5>
                    </div>
                    <div class="card-block">
                        <table class="table table-border table-xs">
                            <tbody>
                                <tr>
                                    <td><i class="fa fa-user m-r-5"></i></i> {{$EncuestaServicio->usuario}}</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-calendar m-r-5"></i></i> {{date('d-m-Y g:i:s A', strtotime($EncuestaServicio->fecha))}}</td>
                                </tr>
                                <tr>
                                    <td> <strong>CALIFICACIÓN</strong></td>
                                </tr>
                                <tr>
                                    <td> {!!wordwrap($EncuestaServicio->pregunta1, 40, '<br>')!!}
                                        <br>
                                        @for($i = 0; $i < $EncuestaServicio->calificacion_pregunta1; $i++)
                                            <span> <i class="icofont icofont icofont-star text-primary p-absolute f-20"></i></span>
                                        @endfor
                                    </td>
                                </tr>
                                <tr>
                                    <td> {!!wordwrap($EncuestaServicio->pregunta2, 40, '<br>')!!}
                                        <br>
                                        @for($i = 0; $i < $EncuestaServicio->calificacion_pregunta2; $i++)
                                            <span> <i class="icofont icofont icofont-star text-primary p-absolute f-20"></i></span>
                                        @endfor
                                    </td>
                                </tr>
                                <tr>
                                    <td> {!!wordwrap($EncuestaServicio->pregunta3, 40, '<br>')!!}
                                        <br>
                                        @for($i = 0; $i < $EncuestaServicio->calificacion_pregunta3; $i++)
                                            <span> <i class="icofont icofont icofont-star text-primary p-absolute f-20"></i></span>
                                        @endfor
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
             {{-- ENCUESTA SOLICITUD --}}
            @if($EncuestaSolicitud != NULL)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text"><i class="icofont icofont-prescription m-r-10"></i> Encuesta Solicitud</h5>
                    </div>
                    <div class="card-block">
                        <table class="table table-border table-xs">
                            <tbody>
                                <tr>
                                    <td><i class="fa fa-user m-r-5"></i></i> {{$EncuestaSolicitud->usuario}}</td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-calendar m-r-5"></i></i> {{date('d-m-Y g:i:s A', strtotime($EncuestaSolicitud->fecha))}}</td>
                                </tr>
                                <tr>
                                    <td> <strong>CALIFICACIÓN</strong></td>
                                </tr>
                                <tr>
                                    <td> {!!wordwrap($EncuestaSolicitud->pregunta1, 40, '<br>')!!}
                                        <br>
                                        @for($i = 0; $i < $EncuestaSolicitud->calificacion_pregunta1; $i++)
                                            <span> <i class="icofont icofont icofont-star text-primary p-absolute f-20"></i></span>
                                        @endfor
                                    </td>
                                </tr>
                                <tr>
                                    <td> {!!wordwrap($EncuestaSolicitud->pregunta2, 40, '<br>')!!}
                                        <br>
                                        @for($i = 0; $i < $EncuestaSolicitud->calificacion_pregunta2; $i++)
                                            <span> <i class="icofont icofont icofont-star text-primary p-absolute f-20"></i></span>
                                        @endfor
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        <!-- Task-detail-right start -->
        <!-- Task-detail-left start -->
    </div>
</div>
<!-- Page-body end -->

@endsection

@section('scripts')


@endsection