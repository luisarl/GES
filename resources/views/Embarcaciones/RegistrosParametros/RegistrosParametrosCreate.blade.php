@extends('layouts.master')

@section('titulo', 'Registros de Parametros')

@section('titulo_pagina', 'Registros de Parametros')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('embaregistrosparametros.index') }}">Registros de Parametros</a></li>
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
            <h5>Crear Registro De Parametros</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('embaregistrosparametros.store') }}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Maquina</label>
                    <div class="col-sm-4">
                        <div class="@error('id_maquina') is-invalid @enderror">
                            <select name="id_maquina" id="id_maquina"
                                data-old="{{ old('id_maquina') }}"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione la Maquina</option>
                                @foreach ($maquinas as $maquina)
                                    <option value="{{$maquina->id_maquina}}" @if ($maquina->id_maquina == old('id_maquina')) selected = "selected" @endif>
                                        {{$maquina->nombre_maquina}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <label class="col-sm-1 col-form-label">Fecha</label>
                    <div class="col-sm-3">
                        <input type="date" value="{{ old('fecha') }}" name="fecha" id="fecha" max="{{date("Y-m-d")}}" class="form-control @error('fecha') is-invalid @enderror">
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-sm btn-primary form-control" name="buscar" title="Buscar" onClick="CargarTabla()"><i class="fa fa-search"></i> </button>
                    </div>
                </div>
               
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Observaciones</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones"
                            placeholder="Ingrese las Observaciones">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
                <div class="alert alert-warning background-warning" id="alerta">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong><i class="fa fa-exclamation-triangle"></i> Alerta!</strong>
                    <div id='mensaje'></div>
                </div>
                <h5 class="sub-title">Tabla de Parametros</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tabla_parametros">
                        <thead>
                            <th>Parametros</th>
                            <th>Hora</th>
                            <th>Valor</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="d-grid gap-2 d-md-block float-right">
                    <input type="hidden" name="parametros" id="parametros">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#modal-confirmar-registros" href="#!" onClick="CapturarDatosTabla()">
                        <i class="fa fa-save"></i>Guardar
                    </button>
                </div>
                @include('Embarcaciones.RegistrosParametros.RegistrosParametrosConfirmacion')
            </form>

        </div>
    </div>
@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<!-- personalizado -->
<script>
    var CrearRegistroParametros = "{{ url('embadatoscrearregistroparametros') }}";
</script>

<script type="text/javascript" src="{{ asset('libraries\assets\js\Embaregistrosparametros.js') }}"></script>

@endsection
