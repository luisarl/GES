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
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

@include('SolicitudesServicios.Solicitudes.SolicitudesResponsablesDestroy')

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
                    {{-- BOTON IMPRIMIR --}}
                    <a href="{{ route('solsimprimirot', $solicitud->id_solicitud) }}" target="_blank" type="button"
                        class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir OT">
                        <i class="fa fa-print"></i> Imprimir OT</a>

                    <a href="{{ route('solicitudes/imprimir/solicitud', $solicitud->id_solicitud) }}" target="_blank" type="button"
                        class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                        <i class="fa fa-print"></i> Imprimir</a>
                    
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
                    {{-- bandera --}}
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
                                <th>SERVICIO : </th><td>{{$solicitud->nombre_servicio}}</td>   
                            </tr>
                            <tr>
                                <th>DIRECCION IP: </th><td>{{$solicitud->direccion_ip}}</td>
                                <th>SUBSERVICIO : </th><td>{{$solicitud->nombre_subservicio}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
{{-- FILTRAR POR RESPONSABLES DE SOLICITUD DE SERVICIO  --}}

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
                                    ORIGEN : {{$solicitud->logistica_origen}} <br> 
                                    DESTINO : {{$solicitud->logistica_destino}} <br> 
                                    FECHA/HORA : {{date('d-m-Y g:i:s A', strtotime($solicitud->logistica_fecha))}} <br> 
                                    NUMERO TELEFONICO: {{$solicitud->logistica_telefono}}
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
            
            @if($solicitud->estatus == 'EN PROCESO')
                @can('sols.solicitudes.comentarios')
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-block">
                
                        <form method="POST" action=" {{ route('solicitudes.update', $solicitud->id_solicitud) }}" enctype="multipart/form-data">
                            @method("put")
                            @csrf
                            <h6 class="sub-title m-b-15"><i class="icofont icofont-comment"> </i>Agregar Comentario</h6>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Comentario</label>
                                <div class="col-sm-10">
                                    <textarea rows="3" cols="3" class="form-control @error('comentario') is-invalid @enderror"
                                        name="comentario"
                                        placeholder="Para asistirlo mejor, sea específico y detallado">{{ old('comentario') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="documentos" class="col-sm-2 col-md-2 col-lg-2 col-form-label">Archivos</label>
                                <div class="col-md-10 col-lg-10 @error('documentos') is-invalid @enderror">
                                    <input type="file" name="documentos" id="filer_input" value="{{old('documentos[]') }}">
                                </div>
                            </div>
                            @if(Auth::user()->id_departamento == $solicitud->id_departamento_servicio )
                                @can('sols.solicitudes.cerrar')
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-3">
                                            <div class="border-checkbox-section">
                                                <div class="border-checkbox-group border-checkbox-group-primary">
                                                    <input class="border-checkbox" type="checkbox" id="estatus" name="estatus" value="CERRADO">
                                                    <label class="border-checkbox-label" for="estatus">Cerrar Solicitud</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            @endif
                            <hr>
                            <div class="d-grid gap-2 d-md-block float-right">
                                <button type="submit" class="btn btn-primary ">
                                    <i class="fa fa-save"></i>Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endcan
            @endif
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
            
        {{-- ACTUALIZAR SERVICIO  --}}
        @can('sols.solicitudes.editarservicio')
        <div class="card">
            <div class="card-header">
                <h5 class="card-header-text"><i class="icofont icofont-tools m-r-10"></i>Actualizar Servicios</h5>
            </div>
            <div class="card-block">
                <form class="" method="POST" action=" {{ route('solupdateservicios', $solicitud->id_solicitud) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="departamento" value="{{$solicitud->id_departamento_servicio}}" /> 
                    <input type="hidden" id="servicio" value="{{$solicitud->id_servicio}}" /> 
                    <input type="hidden" id="subservicio" value="{{$solicitud->id_subservicio}}" /> 

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Servicios</label>
                        <div class="col-sm-9">
                            <select name="id_servicio" id="servicios" class="js-example-basic-single form-control">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">SubServicios</label>
                        <div class="col-sm-9">
                            <select name="id_subservicio" id="subservicios" class="js-example-basic-single form-control ">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary"><i
                                        class="fa fa-save"></i>Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>  
            </div>
        </div>
        @endcan
        
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
                    @if(($solicitud->estatus == 'ABIERTO' || $solicitud->estatus == 'EN PROCESO') && (Auth::user()->id_departamento == $solicitud->id_departamento_servicio))
                        @can('sols.solicitudes.asignar')
                            <form method="POST" action=" {{ route('solsasignarresponsables', $solicitud->id_solicitud) }}">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <select name="responsables[]" class="js-example-basic-multiple form-control @error('responsables') is-invalid @enderror"
                                            multiple="multiple">
                                            @foreach($UsuariosResponsables as $responsable)
                                                <option value="{{$responsable->id_responsable}}-{{$responsable->nombre_responsable}}" @if ($responsable->id_responsable==old('responsables')) selected="selected" @endif>
                                                    {{$responsable->nombre_responsable}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-primary" value="Asignar">
                                                <i class="fa fa-hand-paper-o"></i>Asignar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endcan
                    @endif    
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
                                {{-- Eliminar responsable --}}
                            </div>
                            @if($solicitud->estatus == 'EN PROCESO')
                                @can('sols.solicitudes.eliminarasignado')
                                    <a data-id="{{$responsable->id_solicitud_responsable}}" data-nombre="{{$responsable->nombre_responsable}}" class='fa fa-trash btn btn-danger' data-toggle="modal" data-target="#modal-eliminar" href=''></a>
                                @endcan
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- COMENTARIO INTERNO --}}
            @if(Auth::user()->id_departamento == $solicitud->id_departamento_servicio)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text"><i class="icofont icofont-comment m-r-10"></i> Comentario Interno</h5>
                    </div>
                    <form method="POST" action=" {{ route('solscomentariointerno', $solicitud->id_solicitud) }}">
                    @csrf
                        <div class="card-block task-attachment">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea rows="3" cols="3"
                                        class="form-control @error('comentario_interno') is-invalid @enderror"
                                        name="comentario_interno"
                                        placeholder="Ingrese Comentario Interno, solo visible a usuarios asignados">{{ old('comentario_interno', $solicitud->comentario_interno ?? '') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-primary"><i
                                                class="fa fa-save"></i>Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<!-- jquery file upload js -->
<script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

      <!-- Personalizado -->
    <script>
        var RutaServicios = "{{ url('serviciosdepartamento') }}";
        var RutaSubServicios = "{{ url('subserviciosdepartamento') }}";
    </script>

<script src="{{ asset('libraries\assets\js\SolsSolicitudes-edit.js') }} "></script>

<!-- Multiselect js -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\bootstrap-multiselect\js\bootstrap-multiselect.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\bower_components\multiselect\js\jquery.multi-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\jquery.quicksearch.js') }}"></script>

<!-- eliminar responsables -->
<script>
    $('#modal-eliminar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button que llama al modal
        var id = button.data('id') // Extrae la informacion de data-id
        var nombre = button.data('nombre') // Extrae la informacion de data-nombre

        action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
        action += id; // se agrega el id seleccionado al formulario

        $('#formdelete').attr('action', action); //cambia la ruta del formulario

        var modal = $(this)
        modal.find('.modal-body h5').text('Desea Eliminar al responsable:  '+ nombre + ' ?') //cambia texto en el body del modal
    })
</script>

@endsection

