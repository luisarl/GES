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
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

    <div class="card">
        <div class="card-header">
            <h5>Crear Solicitud</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title">Servicio</h4>
            <form class="" method="POST" action=" {{ route('solicitudes.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row"> 
                    <label class="col-sm-2 col-form-label">Prioridad</label>
                    <div class="col-sm-3 @error('prioridad') is-invalid @enderror">
                        <select name="prioridad" id="prioridad" class="js-example-basic-single form-control @error('prioridad') is-invalid @enderror">
                            <option value="0">Seleccione la Prioridad</option>
                            <option value="BAJA"  @if ("BAJA" == old('prioridad')) selected = "selected" @endif>BAJA</option>
                            <option value="MEDIA" @if ("MEDIA" == old('prioridad')) selected = "selected" @endif>MEDIA</option>
                            <option value="ALTA"  @if ("ALTA" == old('prioridad')) selected = "selected" @endif>ALTA</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row"> 
                    <label class="col-sm-2 col-form-label">Departamento</label>
                    <div class="col-sm-3 @error('id_departamento_servicio') is-invalid @enderror">
                    <select name="id_departamento_servicio" id="departamentos" class="js-example-basic-single form-control @error('id_departamento_servicio') is-invalid @enderror">
                        <option value="0">Seleccione el Departamento</option>
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento }}"
                                @if ($departamento->id_departamento == old('id_departamento_servicio', $user->id_departamento ?? '')) selected = "selected" @endif>
                                {!! $departamento->nombre_departamento!!}</option>
                        @endforeach
                    </select>
                    </div>
                    <label class="col-sm-1 col-form-label">Servicios</label>
                    <div class="col-sm-3 col-md-3 col-lg-3" >
                        <div class="@error('id_servicio') is-invalid @enderror">
                            <select name="id_servicio" id="servicios" data-old="{{ old('id_servicio') }}"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione El Servicio</option>
                            </select>
                        </div>
                    </div>
                    <label class="col-sm-1 col-form-label">Sub Servicios</label>
                    <div class="col-sm-2 col-md-2 col-lg-2" >
                        <div class="@error('id_subservicio') is-invalid @enderror">
                            <select name="id_subservicio" id="subservicios" data-old="{{ old('id_subservicio') }}"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione El SubServicio</option>
                            </select>
                        </div>
                    </div>
                </div>
                <h4 class="sub-title">información</h4>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Motivo</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('asunto_solicitud') is-invalid @enderror" name="asunto_solicitud" 
                        value="{{ old('asunto_solicitud') }}" placeholder="Ingrese el Asunto">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Comentario</label>
                    <div class="col-sm-10">
                        <textarea rows="4" cols="3" class="form-control @error('descripcion_solicitud') is-invalid @enderror" name="descripcion_solicitud"
                            placeholder="Para asistirlo mejor, sea específico y detallado">{{ old('descripcion_solicitud') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="documentos" class="col-sm-2 col-md-2 col-lg-2 col-form-label">Archivos</label>
                    <div class="col-md-10 col-lg-10 @error('documentos') is-invalid @enderror">
                        <input type="file" name="documentos" id="filer_input" value="{{old('documentos[]') }}">
                    </div>
                </div>
                <h4 class="sub-title" id="LogisticaTitulo">Logistica y Operaciones</h4>
                <div id="LogisticaFormulario">
                    <div class="form-group row" id="">
                        <label class="col-sm-2 col-form-label">Origen</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control @error('logistica_origen') is-invalid @enderror" name="logistica_origen" id="logistica_origen"
                            value="{{ old('logistica_origen') }}" placeholder="Ingrese el Origen">
                        </div>
                        <label class="col-sm-2 col-form-label">Destino</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control @error('logistica_destino') is-invalid @enderror" name="logistica_destino" id="logistica_destino"
                            value="{{ old('logistica_destino') }}" placeholder="Ingrese Destino">
                        </div>
                        {{-- <label class="col-sm-1 col-form-label">Fecha de Requerimiento</label>
                        <div class="col-sm-2">
                            <input type="datetime-local" name="logistica_fecha" min="{{date("Y-m-d")}}" id="logistica_fecha" class="form-control @error('logistica_fecha') is-invalid @enderror"  value="{{ old('logi_fecha') }}" >
                        </div> --}}
                    </div>
                    <div class="form-group row" id="">
                        <label class="col-sm-2 col-form-label">Fecha de Requerimiento</label>
                        <div class="col-sm-4">
                            <input type="datetime-local" name="logistica_fecha" min="{{date("Y-m-d")}}" id="logistica_fecha" class="form-control @error('logistica_fecha') is-invalid @enderror"  value="{{ old('logi_fecha') }}" >
                        </div>
                        <label class="col-sm-2 col-form-label">Numero Telefonico</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control @error('logistica_telefono') is-invalid @enderror" name="logistica_telefono" id="logistica_origen"
                            value="{{ old('logistica_telefono') }}" placeholder="Ingrese el numero">
                        </div>
                    </div>
                </div>
                <h4 class="sub-title" id="MantenimientoTitulo">Mantenimiento Mecanico</h4>
                    <div id="MantenimientoFormulario">
                        <div class="form-group row" id="">
                            <label class="col-sm-2 col-form-label">Tipo</label>
                            <div class="col-sm-3 @error('mantenimiento_tipo_equipo') is-invalid @enderror ">
                                <select name="mantenimiento_tipo_equipo" id="mantenimiento_tipo_equipo" class="form-control @error('mantenimiento_tipo_equipo') is-invalid @enderror">
                                    <option value="0">Seleccione el tipo</option>
                                    <option value="VEHICULO">VEHICULO</option>
                                    <option value="HERRAMIENTA">HERRAMIENTA</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                            </div>
                            <label class="col-sm-1 col-form-label">Nombre</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('mantenimiento_nombre_equipo') is-invalid @enderror" name="mantenimiento_nombre_equipo" id="mantenimiento_nombre_equipo"
                                value="{{ old('mantenimiento_nombre_equipo') }}" placeholder="Ingrese nombre">
                            </div>
                            <label class="col-sm-1 col-form-label">Placa o Codigo</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control @error('mantenimiento_codigo_equipo') is-invalid @enderror" name="mantenimiento_codigo_equipo" id="mantenimiento_codigo_equipo"
                                value="{{ old('mantenimiento_codigo_equipo') }}" placeholder="Ingrese la placa o codigo">
                            </div>
                        </div>
                    </div>

                    <h4 class="sub-title" id="MantenimientoEmbarcacionesTitulo">Mantenimiento Embarcaciones</h4>
                    <div id="MantenimientoEmbarcacionesFormulario">
                        <div class="form-group row" id="">
                            <label class="col-sm-2 col-form-label">Embarcacion/Unidad</label>
                            <div class="col-sm-3 @error('mantenimiento_tipo_equipo') is-invalid @enderror ">
                                <select name="mantenimiento_tipo_equipo" id="mantenimiento_emb_tipo_equipo" class="form-control @error('mantenimiento_tipo_equipo') is-invalid @enderror">
                                    <option value="0">Seleccione la Embarcacion/Unidad</option>
                                    <option value="REMOLCADOR NIOLO">REMOLCADOR NIOLO</option>
                                    <option value="REMOLCADOR RIO CARIBE">REMOLCADOR RIO CARIBE</option>
                                    <option value="REMOLCADOR MERIDA">REMOLCADOR MERIDA</option>
                                    <option value="GABARRA CAROLINA M">GABARRA CAROLINA M</option>
                                    <option value="GABARRA HARBOLT">GABARRA HARBOLT</option>
                                    <option value="GABARRA MOBRO">GABARRA MOBRO</option>
                                    <option value="REMOLCADOR BARQUISIMENTO">REMOLCADOR BARQUISIMENTO</option>
                                    <option value="REMOLCADOR CUMANA">REMOLCADOR CUMANA</option>
                                    <option value="GABARRA CPM 45">GABARRA CPM 45</option>
                                    <option value="GABARRA CPM 46">GABARRA CPM 46</option>
                                    <option value="GABARRA MAR AZUL">GABARRA MAR AZUL</option>
                                    <option value="GABARRA JACK">GABARRA JACK</option>
                                    <option value="MUELLE ALIANZA">MUELLE ALIANZA</option>
                                    <option value="DINGUI DL-15">DINGUI DL-15</option>

                                </select>
                            </div>
                            <label class="col-sm-1 col-form-label">Equipo</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control @error('mantenimiento_nombre_equipo') is-invalid @enderror" name="mantenimiento_nombre_equipo" id="mantenimiento_emb_nombre_equipo"
                                value="{{ old('mantenimiento_nombre_equipo') }}" placeholder="Ingrese nombre">
                            </div>
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
  
      <!-- jquery file upload js -->
    <script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

      <!-- Personalizado -->
      <script>
            var RutaServicios = "{{ url('serviciosdepartamento') }}";
            var RutaSubServicios = "{{ url('subserviciosdepartamento') }}";
      </script>

    <script src="{{ asset('libraries\assets\js\SolsSolicitudes-create.js') }} "></script>

@endsection
