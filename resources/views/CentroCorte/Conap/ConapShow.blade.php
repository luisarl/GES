@extends('layouts.master')

@section('titulo', 'Ver Conap')

@section('titulo_pagina', 'Consulta de Aprovechamiento - CONAP')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Centro de Corte</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('cencconap.index') }}">Conap</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Ver</a> </li>
    </ul>

@endsection


@section('contenido')

@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

<div class="form-group row">
    <div class="col-8">
    <div class="card">
        <div class="card-header">
            <h5>Estatus: </h5>

            @if($conap->estatus_conap == 'EN PROCESO')
            <label class="label label-warning">{{$conap->estatus_conap}}</label>
            @elseif($conap->estatus_conap == 'APROBADO')
            <label class="label label-success">{{$conap->estatus_conap}}</label>
            @elseif($conap->estatus_conap == 'ANULADO')
            <label class="label label-danger">{{$conap->estatus_conap}}</label>
            @elseif($conap->estatus_conap == 'FINALIZADO')
            <label class="label label-success">{{$conap->estatus_conap}}</label>
            @endif

            <a href="{{ route('cencconap.edit', $conap->id_conap) }}" target="_blank" type="button"
                class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                <i class="fa fa-edit"></i> Editar</a>
            <hr>

        </div>
        <div class="card-block">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nº Conap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('asunto_solicitud') is-invalid @enderror" name="nro_conap" id="nro_conap" 
                        value="{{$conap->nro_conap}}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('asunto_solicitud') is-invalid @enderror" name="nombre_conap" id="nombre_conap"
                        value="{{$conap->nombre_conap}}" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" disabled class="form-control @error('descripcion_conap') is-invalid @enderror" name="descripcion_conap" 
                        >{{$conap->descripcion_conap}}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="documentos" class="col-sm-2 col-md-2 col-lg-2 col-form-label">Archivos</label>
                    <div class="col-md-10 col-lg-10 @error('documentos') is-invalid @enderror">
                        {{-- <input type="file" name="documentos" id="filer_input" value="{{old('documentos[]') }}"> --}}
    
                        @foreach($documentos as $documento)
                        <span data-id="{{$documento->id_conap_documento}}">
                            <a href="{{asset($documento->ubicacion_documento)}}" target="_blank"
                                class="link-active m-r-10 f-12">
                                <i class="icofont icofont-attachment text-primary p-absolute f-30"></i>
                                {{$documento->nombre_documento}}</a>
                            {{-- <button type="button"
                                onclick="EliminarDocumentoConap({{$documento->id_conap_documento}})"
                                class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button> --}}
                        </span><br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="col-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-header-text"><i class="icofont icofont-ui-calendar m-r-10"></i>Responsables</h5>
        </div>
        <div class="card-block task-details table-responsive dt-responsive">
            <table class="table table-border table-xs">
                <tbody>
                    <tr>
                        <td><i class="fa fa-calendar-plus-o m-r-5"></i></i> Fecha creado:</td>
                        <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($conap->fecha_creado))}}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-user m-r-5"></i></i> Creado por:</td>
                        <td class="text-right">{{ $conap->name}}</td>
                    </tr> 
                    @if($conap->fecha_aprobado != NULL)
                        <tr>
                            <td><i class="fa fa-calendar-check-o m-r-5"></i> Aprobado:</td>
                            <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($ConapUsuarioAprobado->fecha_aprobado))}}</td>
                        </tr>
                    
                    <tr>
                        <td><i class="fa fa-user m-r-5"></i></i> Aprobado por:</td>
                        <td class="text-right">{{ $ConapUsuarioAprobado->name}}</td>
                    </tr>
                    @endif
                    @if($conap->fecha_anulado != NULL)
                        <tr>
                            <td><i class="fa fa-calendar m-r-5"></i> Anulado: </td>
                            <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($ConapUsuarioAnulado->fecha_anulado))}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-user m-r-5"></i></i> Anulado por:</td>
                            <td class="text-right">{{ $ConapUsuarioAnulado->name}}</td>
                        </tr>
                    @endif
                    @if($conap->fecha_finalizado != NULL)
                        <tr>
                            <td><i class="fa fa-calendar m-r-5"></i> Finalizado: </td>
                            <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($ConapUsuarioFinalizado->fecha_finalizado))}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-user m-r-5"></i></i> Finalizado por:</td>
                            <td class="text-right">{{ $ConapUsuarioFinalizado->name}}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@endsection

@section('scripts')
      <!-- Select -->
      <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
  
      <!-- jquery file upload js -->
    <script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

@endsection