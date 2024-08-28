@extends('layouts.master')

@section('titulo', 'Detalle Salida')

@section('titulo_pagina', 'Detalle Salida')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Detalle Salida</a> </li>
</ul>
@endsection

@section('contenido')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title "> <strong>Salida Nº {{$detalle->id_salida}}</strong> </h4>
    </div>
    <div class="card-block">
        <div class="form-group row">
            <label class="col-md-2 col-lg-2 col-form-label">Almacen</label>
            <div class="col-md-4 col-lg-4">
                <label>{{$detalle->nombre_almacen}}</label>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-lg-2 col-form-label">Motivo</label>
            <div class="col-md-10 col-lg-10">
                <input type="text" class="form-control" name="motivo" id="motivo" value="{{$detalle->motivo}}" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-lg-2 col-form-label">Descripción</label>
            <div class="col-md-10 col-lg-10">
                <textarea rows="3" cols="3" class="form-control" name="descripcion"
                    id="descripcion" readonly>{{$detalle->descripcion}}
                </textarea>
            </div>
        </div>

        <h4 class="sub-title">HERRAMIENTAS</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Herramienta</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movimiento as $herramienta)
                    <tr>
                        <td>{{$herramienta->id_herramienta}}</td>
                        <td>{{$herramienta->nombre_herramienta}}</td>
                        <td>{{$herramienta->cantidad}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
    </div>
</div>

@endsection