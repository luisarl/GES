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
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Editar Registro Parametros</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form method="POST" action=" {{ route('embaregistrosparametros.update', 1) }}">
                @csrf @method("put")
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Maquina</label>
                    <div class="col-sm-3">
                        <div class="@error('id_maquina') is-invalid @enderror">
                            <select name="id_maquina" id="id_maquina"
                                data-old="{{ old('id_maquina') }}"
                                class="js-example-basic-single form-control ">
                                <option value="0">Seleccione la Maquina</option>
                                @foreach ($maquinas as $maquina)
                                    <option value="{{$maquina->id_maquina}}">{{$maquina->nombre_maquina}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <label class="col-sm-1 col-form-label">Fecha</label>
                    <div class="col-sm-2">
                        <input type="date" value="" max="{{date("Y-m-d")}}" class="form-control @error('fecha') is-invalid @enderror" name="fecha" id="fecha">
                    </div>
                    <label class="col-sm-1 col-form-label">Hora</label>
                    <div class="col-sm-2">
                        <input type="time" name="hora" id="hora" class="form-control @error('hora') is-invalid @enderror" list="listalimitestiempo" step="600">
                        
                    </div>
                        <datalist id="listalimitestiempo">
                            <option value="00:00">
                            <option value="01:00"></option>
                            <option value="02:00"></option>
                            <option value="03:00"></option>
                            <option value="04:00"></option>
                            <option value="05:00"></option>
                            <option value="06:00"></option>
                            <option value="07:00"></option>
                            <option value="08:00"></option>
                            <option value="09:00"></option>
                            <option value="10:00"></option>
                            <option value="11:00"></option>
                            <option value="12:00"></option>
                            <option value="13:00"></option>
                            <option value="14:00"></option>
                            <option value="15:00"></option>
                            <option value="16:00"></option>
                            <option value="17:00"></option>
                            <option value="18:00"></option>
                            <option value="19:00"></option>
                            <option value="20:00"></option>
                            <option value="21:00"></option>
                            <option value="22:00"></option>
                            <option value="23:00"></option>
                        </datalist>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-sm btn-primary form-control" name="buscar" onClick="CargarTablaEditar();"><i class="fa fa-search"></i> </button>
                    </div>
                </div>
               
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Observaciones</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" 
                        id="observaciones" placeholder="Ingrese las Observaciones">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
                <hr>
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
                    <button type="submit" class="btn btn-primary" onClick="CapturarDatosTabla()">
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

<!-- personalizado -->
<script>
    var EditarRegistroParametros = "{{ url('embadatoseditarregistroparametros') }}";
</script>

<script type="text/javascript" src="{{ asset('libraries\assets\js\Embaregistrosparametros.js') }}"></script>

@endsection
