@extends('layouts.master')

@section('titulo', 'Tabla de consumo')

@section('titulo_pagina', 'Tabla de consumo')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('cenctablasconsumo.index') }}">Tabla de consumo</a></li>
        </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

    <div class="card">
        <div class="card-header">
            <h5>Editar Tabla de consumo</h5>
            {{-- <div class="float-right">
                <h6> Equipo: {{$datos[0]->nombre_equipo}}  |  Tecnologia: {{$datos[0]->nombre_tecnologia}}</h6>
            </div> --}}
        </div>

        <div class="card-block">
            <div class="left">
                <h6> Equipo: {{$datos[0]->nombre_equipo}}  |  Tecnologia: {{$datos[0]->nombre_tecnologia}}</h6>
            </div>
            <h4 class="sub-title"></h4>
            <form method="POST" action=" {{ route('cenctablasconsumo.update', $registro->id_tabla_consumo) }}" enctype="multipart/form-data">
                @csrf @method('put')

                <h5 class="sub-title">Tabla de Registros</h5> 
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tabla_registros">
                        <thead>
                            <th>Parametros</th>
                            <th>Unidad</th>
                            <th>Espesor</th>
                            <th>Valor</th>
                        </thead>
                        <tbody>
                            @foreach ($parametros as $parametro)
                                <tr>
                                    <td id='id_tabla_consumo'style='visibility:collapse; display:none;'>{{ $parametro->id_tabla_consumo}}</td>
                                    <td style='visibility:collapse; display:none;'>{{ $parametro->id_equipo_consumible}}</td>
                                    <td style='width: 40%'> {{$parametro->nombre_consumible}}</td>
                                    <td style='width: 10%'>{{$parametro->unidad_consumible}}</td>
                                    <td id='valor_espesor' style='width: 20%'>{{number_format($parametro->espesor, 2)}}</td>
                                    <td><input type='text' id='valor_registro' class='form-control' value="{{$parametro->valor}}"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br>

                <input type="hidden" name="parametros" id="parametros">
                <div class="d-grid gap-2 d-md-block float-right">
                    <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla2();">
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

<script src="{{asset('libraries\assets\js\CencTablasConsumo-update.js')}}"> </script>

@endsection