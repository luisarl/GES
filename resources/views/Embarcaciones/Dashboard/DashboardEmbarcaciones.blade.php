@extends('layouts.master')

@section('titulo', 'Dashboard Embarcaciones')

@section('titulo_pagina', 'Dashboard Embarcaciones')


{{-- @section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">s
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Almacenes</a> </li>
</ul>
@endsection --}}

@section('contenido')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">

    <div class="card-block">
        <form method="GET" action="">
            <div class="form-group row" style="margin-bottom: 0px;">
                <label class="col-sm-12 col-md-1 form-label text-dark font-weight-bold">Filtro: </label>
                <label class="col-sm-12 col-md-1 form-label">Maquina</label>
                <div class="col-sm-12 col-md-2 ">
                    <select name="id_maquina" id="id_maquina" class="js-example-basic-single form-control" data-old="{{ old('id_maquina') }}">
                        @foreach ($maquinas as $maquina)
                            <option value="{{$maquina->id_maquina}}" @if($maquina->id_maquina == old('id_maquina' ,$_GET['id_maquina'] ?? '')) selected = "selected" @endif>
                                {{$maquina->nombre_maquina}}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-sm-12 col-md-1 form-label">Parametro</label>
                <div class="col-sm-12 col-md-2 ">
                    <select name="id_parametro" id="id_parametro" data-old="{{ old('id_parametro', $_GET['id_parametro'] ?? '')}}" 
                    class="js-example-basic-single form-control">
                    </select>
                </div>
                <label class="col-sm-12 col-md-1 form-label">Fecha</label>
                <div class="col-sm-12 col-md-2 ">
                    <input type="date" name="fecha" min="" id=""
                        class="form-control @error('fecha_fin') is-invalid @enderror"
                        value="{{ old('fecha', $_GET['fecha'] ?? '')  }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" name="buscar" class="btn btn-primary" OnClick="">
                        <i class="fa fa-search"></i>Buscar
                    </button>
                </div>
                {{-- <div class="col-md-1">
                    <button type="submit" name="imprimir" class="btn btn-primary" value="imprimir">
                        <i class="fa fa-print"></i>Imprimir
                    </button>
                </div> --}}
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h5>Parametros por Hora</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-minus minimize-card"></i></li>
                <li><i class="feather icon-trash-2 close-card"></i></li>
            </ul>
        </div>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                @if($TipoGrafico == 'TODOS')
                    <div id="grafico_parametros" style="width: 100%; height: 400px;"></div>
                @elseif($TipoGrafico == 'INDIVIDUAL')
                    <div id="grafico_parametro" style="width: 100%; height: 400px;"></div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Estadisticas De Parametros</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-minus minimize-card"></i></li>
                <li><i class="feather icon-trash-2 close-card"></i></li>
            </ul>
        </div>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                @if($EstadisticasParametros != null)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Parametro</th>
                                    <th>Hora Valor Minimo </th>
                                    <th>Valor Minimo</th>
                                    <th>Hora Valor Maximo</th>
                                    <th>Valor Maximo</th>
                                    <th>Valor Promedio</th>
                                </tr>
                                <tbody>
                                    @foreach ($EstadisticasParametros as $parametro)
                                        <tr>
                                            <td>{{$parametro->nombre_parametro}}</td>
                                            <td>{{ explode(':', $parametro->hora_minima)[0]}}</td>
                                            <td>{{$parametro->valor_minimo}}</td>
                                            <td>{{explode(':',$parametro->hora_maxima)[0]}}</td>
                                            <td>{{$parametro->valor_maximo}}</td>
                                            <td>{{number_format($parametro->valor_promedio, 2, '.', '')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- google chart -->
<script src="{{ asset('libraries\assets\pages\chart\google\js\google-loader.js') }}"></script>

<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<script>
     var columnas = {!! json_encode($GraficoColumnas) !!};
     var registros = {!! json_encode($GraficoRegistros) !!};

     var ArregloRegistros = registros.map(function(o) 
     {
        return Object.keys(o).reduce(function(array, key) {
            if(key == 'hora')
            {
                return array.concat(String([o[key].split(':')[0]]));
            }
            else
                {
                    return array.concat(parseFloat([o[key]]));
                }
            
        }, []);
    });
</script>

<!-- Personalizado -->
<script type="text/javascript" src="{{ asset('libraries\assets\js\EmbaDashboard.js') }}"></script>

@endsection