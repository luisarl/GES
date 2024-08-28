@extends('layouts.master')

@section('titulo', 'Seguimiento')

@section('titulo_pagina', 'Seguimiento')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cencordentrabajo.index') }}">Orden de Trabajo</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('cencseguimiento.index') }}">Seguimiento</a> </li>
    {{-- <li class="breadcrumb-item"><a href="#!">Conap</a> </li> --}}
</ul>
@endsection

@section('contenido')
<!-- Scroll - Vertical table end -->
@include('mensajes.MsjExitoso')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

@include('CentroCorte.OrdenTrabajo.Seguimiento.SeguimientoFinalizar')


<form method="POST" id="FormSeguimiento"
        action="{{ isset($SeguimientoPlancha) ? route('cencseguimiento.update', $SeguimientoPlancha->id_seguimiento, ['IdOrdenTrabajoPlancha' => $OrdenTrabajoPlancha->id_orden_trabajo_plancha]) : route('cencseguimiento.store', ['IdOrdenTrabajoPlancha' => $OrdenTrabajoPlancha->id_orden_trabajo_plancha]) }}"
        enctype="multipart/form-data">
        @if(isset($SeguimientoPlancha))
        @method("put")
        @endif
        @csrf

<div class="card">
        <div class="card-block">
               Estatus:
            @if(isset($SeguimientoPlancha->estatus))
                @if($SeguimientoPlancha->estatus == 'EN PROCESO')
                    <label class="label label-warning">EN PROCESO</label>
                    @elseif($SeguimientoPlancha->estatus == 'ANULADO')
                    <label class="label label-danger">ANULADO</label>
                    @elseif($SeguimientoPlancha->estatus == 'FINALIZADO')
                    <label class="label label-success">FINALIZADO</label>
                @endif

            @if($SeguimientoPlancha->estatus == 'EN PROCESO')
                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                    data-target="#modal-seguimiento-finalizar" title="Finalizar Seguimiento" href="#!">
                    <i class="fa fa-check-square"></i>FINALIZAR
                </button>
            @endif
            @else
            @endif
        </div>
    </div>

@if($OrdenTrabajoPlancha->id_equipo == '1') 
    <div class="card">
        <div class="card-block">
            <h4 class="sub-title">TIEMPOS TOTALES / HORÓMETROS MAQUINA KF2612</h4>

            <input type="text"  id="equipo" value="KF2612" style="display: none;">

            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0 @error('fecha_creado_horometro') is-invalid @enderror">Fecha</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="fecha_creado_horometro" id="fecha_creado_horometro"
                        value="{{ old('fecha_creado_horometro') }}" placeholder="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Horómetro Inicial ON</label>
                <div class="col-sm-2">
                    <input type="text" data-inputmask="'mask': '9999:99:99'" name="horometro_inicial_on" id="horometro_inicial_on"
                        class="form-control hour @error('horometro_inicial_on') is-invalid @enderror"
                        value="{{ old('horometro_inicial_on') }}">
                </div>

                <label class="col-sm-1 form-label p-r-0">Horómetro Final ON</label>
                <div class="col-sm-2">
                    <input type="text" data-inputmask="'mask': '9999:99:99'" name="horometro_final_on" id="horometro_final_on"
                        class="form-control hour @error('horometro_final_on') is-invalid @enderror"
                        value="{{ old('horometro_final_on') }}">
                </div>
                <label class="col-sm-1 col-form-label p-r-0">Horómetro Inicial AUT</label>
                <div class="col-sm-2">
                    <input type="text" data-inputmask="'mask': '9999:99:99'" name="horometro_inicial_aut" id="horometro_inicial_aut"
                        class="form-control hour @error('horometro_inicial_aut') is-invalid @enderror"
                        value="{{ old('horometro_inicial_aut') }}">
                </div>

                <label class="col-sm-1 form-label p-r-0">Horómetro Final AUT</label>
                <div class="col-sm-2">
                    <input type="text" data-inputmask="'mask': '9999:99:99'" name="horometro_final_aut" id="horometro_final_aut"
                        class="form-control hour @error('horometro_final_aut') is-invalid @enderror"
                        value="{{ old('horometro_final_aut') }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="float-right">
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarHorometro()">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" title="Limpiar" onClick="LimpiarCamposHorometro()">
                            <i class="icofont icofont-brush"></i>
                        </button>
                    </div>
                </div>
            </div>
            <br>

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="TablaHorometro">
                    <thead>
                        <tr>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                            <th class="bg-primary text-center" colspan="4">ESTADO EN FUNCIONAMIENTO/MÁQUINA ENCENDIDA</th>
                            <th class="bg-primary text-center" colspan="4">TIEMPO DE TRABAJO BAJO PROGRAMACIÓN</th>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                        </tr>
                        <tr>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                            <th class="bg-primary text-center" colspan="2">CONTADOR MÁQUINA</th>
                            <th class="bg-inverse text-center" colspan="2">RELACIÓN</th>
                            <th class="bg-primary text-center" colspan="2">CONTADOR MÁQUINA</th>
                            <th class="bg-inverse text-center" colspan="2">RELACIÓN</th>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                        </tr>
                        <tr>
                            <th class="bg-primary text-center" style="width: 5%">ID</th>
                            <th class="bg-primary text-center" style="width: 5%">Fecha</th>
                            <th class="bg-primary text-center" style="width: 15%">Horómetro Inicial ON</th>
                            <th class="bg-primary text-center" style="width: 15%">Horómetro Final ON</th>
                            <th class="bg-inverse text-center" style="width: 15%">Horas Máquina ON (HH:MM:SEC)</th>
                            <th class="bg-inverse text-center" style="width: 15%">Horas Máquina ON (Horas)</th>
                            <th class="bg-primary text-center" style="width: 15%">Horómetro Inicial AUT</th>
                            <th class="bg-primary text-center" style="width: 15%">Horómetro Final AUT</th>
                            <th class="bg-inverse text-center" style="width: 15%">Tiempo modo AUT (HH:MM:SEC)</th>
                            <th class="bg-inverse text-center" style="width: 15%">Tiempo modo AUT (Horas)</th>
                            <th class="bg-primary text-center" style="width: 5%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = json_decode(old('datos_seguimiento'));
                        @endphp
                        @if($data && isset($data->tabla_horometro))
                        @foreach($data->tabla_horometro as $horometro)
                        <tr>
                            <td id='id_horometro'> {{$horometro->id_seguimiento_pl_horometro}}</td>
                            <td id='fecha_creado_horometro'> {{ $horometro->fecha_creado}}</td>
                            <td id='horometro_inicial_on'> {{$horometro->horometro_inicial_on}}</td>
                            <td id='horometro_final_on'> {{$horometro->horometro_final_on}}</td>
                            <td id='horas_maquina_on'> {{$horometro->horas_maquina_on}}</td>
                            <td class='horas_on' id='horas_on'> {{$horometro->horas_on}}</td>
                            <td id='horometro_inicial_aut'> {{$horometro->horometro_inicial_aut}}</td>
                            <td id='horometro_final_aut'> {{$horometro->horometro_final_aut}}</td>
                            <td id='tiempo_modo_aut'> {{$horometro->tiempo_modo_aut}}</td>
                            <td class='tiempo_aut' id='tiempo_aut'> {{$horometro->tiempo_aut}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleH({{$horometro->id_seguimiento_pl_horometro}})"
                                class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @else
                        @foreach($SeguimientoPlanchaHorometro as $SeguimientoPlanchaHorometros)
                        <tr>
                            <td id='id_horometro'> {{$SeguimientoPlanchaHorometros->id_seguimiento_pl_horometro}}</td>
                            <td id='fecha_creado_horometro'> {{$SeguimientoPlanchaHorometros->fecha_creado}}</td>
                            <td id='horometro_inicial_on'> {{$SeguimientoPlanchaHorometros->horometro_inicial_on}}</td>
                            <td id='horometro_final_on'> {{$SeguimientoPlanchaHorometros->horometro_final_on}}</td>
                            <td id='horas_maquina_on'> {{$SeguimientoPlanchaHorometros->horas_hms_on}}</td>
                            <td class='horas_on' id='horas_on'> {{$SeguimientoPlanchaHorometros->horas_on}}</td>
                            <td id='horometro_inicial_aut'> {{$SeguimientoPlanchaHorometros->horometro_inicial_aut}}</td>
                            <td id='horometro_final_aut'> {{$SeguimientoPlanchaHorometros->horometro_final_aut}}</td>
                            <td id='tiempo_modo_aut'> {{$SeguimientoPlanchaHorometros->tiempo_hms_aut}}</td>
                            <td class='tiempo_aut' id='tiempo_aut'> {{$SeguimientoPlanchaHorometros->tiempo_aut}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleH({{$SeguimientoPlanchaHorometros->id_seguimiento_pl_horometro}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4"></th>
                            <th style="width: 15%">Total Horas</th>
                            <th style="width: 15%" id="total_horas_on">0</th>
                            <th colspan="2"> </th>
                            <th style="width: 15%" >Total Horas</th>
                            <th style="width: 15%" id="total_tiempo_aut">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
@else

    <div class="card">
        <div class="card-block">
            <h4 class="sub-title">TIEMPOS TOTALES / HORÓMETROS MAQUINA MORROCOY</h4>

            <input type="text"  id="equipo" value="MORROCOY" style="display: none;">

            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0 @error('fecha_creado_horometro') is-invalid @enderror">Fecha</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="fecha_creado_horometro" id="fecha_creado_horometro"
                        value="{{ old('fecha_creado_horometro') }}" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Horómetro Inicial ON</label>
                <div class="col-sm-2">
                    <input type="text" data-inputmask="'mask': '9999:99:99'" name="horometro_inicial_on" id="horometro_inicial_on"
                        class="form-control hour @error('horometro_inicial_on') is-invalid @enderror"
                        value="{{ old('horometro_inicial_on') }}">
                </div>

                <label class="col-sm-1 form-label p-r-0">Horómetro Final ON</label>
                <div class="col-sm-2">
                    <input type="text" data-inputmask="'mask': '9999:99:99'" name="horometro_final_on" id="horometro_final_on"
                        class="form-control hour @error('horometro_final_on') is-invalid @enderror"
                        value="{{ old('horometro_final_on') }}">
                </div>
               
                <div class="col-sm-6">
                    <div class="float-right">
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarHorometro()">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" title="Limpiar" onClick="LimpiarCamposHorometro()">
                            <i class="icofont icofont-brush"></i>
                        </button>
                    </div>
                </div>
            </div>
            <br>

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="TablaHorometro">
                    <thead>
                        <tr>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                            <th class="bg-primary text-center" colspan="4">ESTADO EN FUNCIONAMIENTO/MÁQUINA ENCENDIDA</th>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                        </tr>
                        <tr>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                            <th class="bg-primary text-center" colspan="2">CONTADOR MÁQUINA</th>
                            <th class="bg-inverse text-center" colspan="2">RELACIÓN</th>
                            <th class="bg-primary text-center" style="width: 15%"></th>
                        </tr>
                        <tr>
                            <th class="bg-primary text-center" style="width: 5%">ID</th>
                            <th class="bg-primary text-center" style="width: 5%">Fecha</th>
                            <th class="bg-primary text-center" style="width: 15%">Horómetro Inicial ON</th>
                            <th class="bg-primary text-center" style="width: 15%">Horómetro Final ON</th>
                            <th class="bg-inverse text-center" style="width: 15%">Horas Máquina ON (HH:MM:SEC)</th>
                            <th class="bg-inverse text-center" style="width: 15%">Horas Máquina ON (Horas)</th>
                            <th class="bg-primary text-center" style="width: 5%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = json_decode(old('datos_seguimiento'));
                        @endphp
                        @if($data && isset($data->tabla_horometro))
                        @foreach($data->tabla_horometro as $horometro)
                        <tr>
                            <td id='id_horometro'> {{$horometro->id_seguimiento_pl_horometro}}</td>
                            <td id='fecha_creado_horometro'> {{ $horometro->fecha_creado}}</td>
                            <td id='horometro_inicial_on'> {{$horometro->horometro_inicial_on}}</td>
                            <td id='horometro_final_on'> {{$horometro->horometro_final_on}}</td>
                            <td id='horas_maquina_on'> {{$horometro->horas_maquina_on}}</td>
                            <td class='horas_on' id='horas_on'> {{$horometro->horas_on}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleH({{$horometro->id_seguimiento_pl_horometro}})"
                                class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @else
                        @foreach($SeguimientoPlanchaHorometro as $SeguimientoPlanchaHorometros)
                        <tr>
                            <td id='id_horometro'> {{$SeguimientoPlanchaHorometros->id_seguimiento_pl_horometro}}</td>
                            <td id='fecha_creado_horometro'> {{$SeguimientoPlanchaHorometros->fecha_creado}}</td>
                            <td id='horometro_inicial_on'> {{$SeguimientoPlanchaHorometros->horometro_inicial_on}}</td>
                            <td id='horometro_final_on'> {{$SeguimientoPlanchaHorometros->horometro_final_on}}</td>
                            <td id='horas_maquina_on'> {{$SeguimientoPlanchaHorometros->horas_hms_on}}</td>
                            <td class='horas_on' id='horas_on'> {{$SeguimientoPlanchaHorometros->horas_on}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleH({{$SeguimientoPlanchaHorometros->id_seguimiento_pl_horometro}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4"></th>
                            <th style="width: 15%">Total Horas</th>
                            <th style="width: 15%" id="total_horas_on">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endif
    <div class="card">
        <div class="card-block">
            <h4 class="sub-title">AVANCE DE CORTE DIARIO</h4>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Fecha</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="fecha_creado_avance" id="fecha_creado_avance"
                        value="{{ old('fecha_creado_avance') }}" placeholder="">
                </div>

                <label class="col-sm-1 col-form-label p-r-0">Nro. Parte</label>
                <div class="col-md-3 col-lg-3">
                    <select name="numero_parte" id="numero_parte" onchange="NroParte()" class="js-example-basic-single form-control 
                    @error('numero_parte') is-invalid @enderror">
                        <option value="0" disabled selected>Seleccione la parte</option>
                        @foreach($ListaNumeroPartes as $ListaNumeroParte)
                            <option value="{{$ListaNumeroParte->id_lplancha}}">{{$ListaNumeroParte->id_lplancha}}-{{$ListaNumeroParte->nro_partes}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div><span class="text-muted">Información de la Lista de Partes</span></div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-styling" id="tabla_lista_parte">
                    <thead>
                        <tr class="bg-inverse">
                            <th style="text-align: center">Lista de Partes</th>
                            <th style="text-align: center">Espesor (MM)</th>
                            <th style="text-align: center">Cantidad Total (UND)</th>
                            <th style="text-align: center">Peso Total (KG)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th style="text-align: center" class="id_listap">{{$OrdenTrabajoPlancha->id_lista_parte}}</th>
                            <th style="text-align: center">{{number_format($espesor, 2, '.', '')}}</th>
                            <th style="text-align: center" class="cantidad_total_lp">{{$cantidad}}</th>
                            <th style="text-align: center" class="peso_total_lp">{{number_format($peso, 2, '.', '')}}</th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div><span class="text-muted">Detalle de la Parte</span></div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-styling" id="tabla_nro_parte">
                    <thead>
                        <tr class="background-primary">
                            <th>ID</th>
                            <th>Nro. Parte</th>
                            <th id="descripcion_nroparte">Descripción</th>
                            <th id="dimensiones_nroparte">Dimensiones (MM)</th>
                            <th id="cant_piezas_nroparte">Cantidad Piezas (UND)</th>
                            <th id="peso_unit_nroparte">Peso Unitario (KG)</th>
                            <th id="peso_total_nroparte">Peso Total (KG)</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        
                    </tbody>
                </table>
            </div>
            <br>

            <div class="form-group row">
                <label class="col-sm-1 form-label p-r-0">Cantidad Piezas (und)</label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" name="cant_pieza_avance" id="cant_pieza_avance"
                        value="{{ old('cant_pieza_avance') }}" placeholder="">
                </div>

                {{-- <label class="col-sm-1 form-label p-r-0">Peso (Kg)</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="peso_avance" id="peso_avance"
                        value="{{ old('peso_avance') }}" placeholder="">
                </div> --}}

                <div class="col-sm-9">
                    <div class="float-right">
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" id="carga" onClick="CargarAvance()">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" title="Limpiar" onClick="LimpiarCamposAvance()">
                            <i class="icofont icofont-brush"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
            
                <table class="table table-striped table-bordered table-styling" id="TablaAvance">
                    <thead>
                        <tr class="background-primary">
                            <th class="bg-inverse">ID</th>
                            <th class="bg-inverse">Fecha</th>
                            <th class="bg-inverse">Nro. Parte</th>
                            <th class="bg-inverse">Descripción</th>
                            <th class="bg-inverse">Dimensiones (MM)</th>
                            <th class="bg-inverse">Cantidad Piezas (UND)</th>
                            <th class="bg-inverse">Peso Unitario (KG)</th>
                            <th class="bg-inverse">Peso Total (KG)</th>
                            <th>Avance Cant. Piezas (UND)</th>
                            <th>Avance Peso Total (KG)</th>
                            <th>Pendiente Cant. Piezas (UND)</th>
                            <th>Pendiente Peso Total (KG)</th> 
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = json_decode(old('datos_seguimiento'));
                        @endphp
                        @if($data && isset($data->tabla_avance))
                        @foreach($data->tabla_avance as $avance)
                        <tr>
                            <td id='id_avance'> {{$avance->id_seguimiento_pl_avance}}</td>
                            <td id='fecha_creado_avance'> {{$avance->fecha_creado}}</td>
                            <td class='numero_parte' id='numero_parte'>{{$avance->numero_parte}}</td>
                            <td class='descripcion_nroparte' id='descripcion_nroparte'> {{$avance->descripcion_nroparte}}</td>
                            <td class='dimensiones_nroparte' id='dimensiones_nroparte'> {{$avance->dimensiones_nroparte}}</td>
                            <td class='cant_piezas_nroparte' id='cant_piezas_nroparte'> {{$avance->cant_piezas_nroparte}}</td>
                            <td class='peso_unit_nroparte' id='peso_unit_nroparte'> {{number_format($avance->peso_unit_nroparte, 3, '.', '')}}</td>
                            <td class='peso_total_nroparte' id='peso_total_nroparte'> {{number_format($avance->peso_total_nroparte, 3, '.', '')}}</td>
                            <td class='cant_piezas_avance' id='cant_piezas_avance'> {{$avance->cant_piezas_avance}}</td>
                            <td class='peso_avance' id='peso_avance'> {{number_format($avance->peso_avance, 3, '.', '')}}</td>
                            <td class='cant_piezas_pendiente' id='cant_piezas_pendiente'> {{$avance->cant_piezas_pendiente}}</td>
                            <td class='peso_pendiente' id='peso_pendiente'> {{number_format($avance->peso_pendiente, 3, '.', '')}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleA({{$avance->id_seguimiento_pl_avance}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @else
                        @foreach($SeguimientoPlanchaAvance as $SeguimientoPlanchaAvances)
                        <tr>
                            <td id='id_avance'> {{$SeguimientoPlanchaAvances->id_seguimiento_pl_avance}}</td>
                            <td id='fecha_creado_avance'> {{$SeguimientoPlanchaAvances->fecha_creado}}</td>
                            <td class='numero_parte' id='numero_parte'>{{$SeguimientoPlanchaAvances->nro_partes}}</td>
                            <td class='descripcion_nroparte' id='descripcion_nroparte'> {{$SeguimientoPlanchaAvances->descripcion}}</td>
                            <td class='dimensiones_nroparte' id='dimensiones_nroparte'> {{$SeguimientoPlanchaAvances->dimensiones}}</td>
                            <td class='cant_piezas_nroparte' id='cant_piezas_nroparte'> {{$SeguimientoPlanchaAvances->cantidad_piezas}}</td>
                            <td class='peso_unit_nroparte' id='peso_unit_nroparte'> {{number_format($SeguimientoPlanchaAvances->peso_unitario, 3, '.', '')}}</td>
                            <td class='peso_total_nroparte' id='peso_total_nroparte'> {{number_format($SeguimientoPlanchaAvances->peso_total, 3, '.', '')}}</td>
                            <td class='cant_piezas_avance' id='cant_piezas_avance'> {{$SeguimientoPlanchaAvances->avance_cant_piezas}}</td>
                            <td class='peso_avance' id='peso_avance'> {{number_format($SeguimientoPlanchaAvances->avance_peso, 3, '.', '')}}</td>
                            <td class='cant_piezas_pendiente' id='cant_piezas_pendiente'> {{$SeguimientoPlanchaAvances->pendiente_cant_piezas}}</td>
                            <td class='peso_pendiente' id='peso_pendiente'> {{number_format($SeguimientoPlanchaAvances->pendiente_peso, 3, '.', '')}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleA({{$SeguimientoPlanchaAvances->id_seguimiento_pl_avance}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <thead>
                        <tr class="background-primary">
                            <th colspan="8">TOTAL DE PRODUCCIÓN</th>
                            <th id="total_prod_cant_piezas_avance"></th>
                            <th id="total_prod_peso_total_avance"></th>
                            <th> </th>
                            <th> </th>
                            <th> </th>
                        </tr>
                        <tr class="bg-inverse">
                            <th colspan="8">TOTAL PENDIENTE</th>
                            <th id="total_pend_cant_piezas_avance"></th>
                            <th id="total_pend_peso_avance"></th>
                            <th> </th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-block">
            <h4 class="sub-title">CONSUMO DE OXIGENO</h4>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Fecha</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="fecha_creado_oxigeno" id="fecha_creado_oxigeno"
                        value="{{ old('fecha_creado_oxigeno') }}" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 form-label p-r-0">Oxigeno Inicial (PSI)</label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" name="oxigeno_inicial" id="oxigeno_inicial"
                        value="{{ old('oxigeno_inicial') }}" placeholder="">
                </div>
                <label class="col-sm-1 col-form-label p-r-0">Oxigeno Final (PSI)</label>
                <div class="col-sm-2">
                    <input type="number" class="form-control" name="oxigeno_final" id="oxigeno_final"
                        value="{{ old('oxigeno_final') }}">
                </div>
                <label class="col-sm-1 col-form-label p-r-0">¿Cambió?</label>
                <div class="col-sm-2">
                    <select name="cambio_oxigeno" id="cambio_oxigeno" class="js-example-basic-single form-control 
                        @error('cambio_oxigeno') is-invalid @enderror">
                        <option value="0" disabled selected>Seleccione</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
              </div>
                <div class="col-sm-3">
                    <div class="float-right">
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarOxigeno()">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" title="Limpiar" onClick="LimpiarCamposOxigeno()">
                            <i class="icofont icofont-brush"></i>
                        </button> 
                    </div>
                </div>
            </div>
            <br>
            
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-styling" id="TablaOxigeno">
                    <thead>
                        <tr class="background-primary">
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Oxigeno Inicial (PSI)</th>
                            <th>Oxigeno Final (PSI)</th>
                            <th>Oxigeno Usados (PSI)</th>
                            <th>Cambio</th>
                            <th>Litros Gaseosos (L)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = json_decode(old('datos_seguimiento'));
                        @endphp
                        @if($data && isset($data->tabla_oxigeno))
                        @foreach($data->tabla_oxigeno as $oxigeno)
                        <tr>
                            <td id='id_oxigeno'> {{$oxigeno->id_seguimiento_pl_oxigeno}}</td>
                            <td id='fecha_creado_oxigeno'> {{$oxigeno->fecha_creado}}</td>
                            <td id='oxigeno_inicial'> {{$oxigeno->oxigeno_inicial}}</td>
                            <td id='oxigeno_final'> {{$oxigeno->oxigeno_final}}</td>
                            <td class='oxigeno_usado' id='oxigeno_usado'> {{$oxigeno->oxigeno_usado}}</td>
                            <td id='cambio_oxigeno'> {{$oxigeno->cambio}}</td>
                            <td class='litros_gaseosos' id='litros_gaseosos'> {{number_format($oxigeno->litros_gaseosos, 2, '.', '')}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleO({{$oxigeno->id_seguimiento_pl_oxigeno}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @else
                        @foreach($SeguimientoPlanchaOxigeno as $SeguimientoPlanchaOxigenos)
                        <tr>
                            <td id='id_oxigeno'> {{$SeguimientoPlanchaOxigenos->id_seguimiento_pl_oxigeno}}</td>
                            <td id='fecha_creado_oxigeno'> {{$SeguimientoPlanchaOxigenos->fecha_creado}}</td>
                            <td id='oxigeno_inicial'> {{$SeguimientoPlanchaOxigenos->oxigeno_inicial}}</td>
                            <td id='oxigeno_final'> {{$SeguimientoPlanchaOxigenos->oxigeno_final}}</td>
                            <td class='oxigeno_usado' id='oxigeno_usado'> {{$SeguimientoPlanchaOxigenos->oxigeno_usado}}</td>
                            <td id='cambio_oxigeno'> {{$SeguimientoPlanchaOxigenos->cambio}}</td>
                            <td class='litros_gaseosos' id='litros_gaseosos'> {{number_format($SeguimientoPlanchaOxigenos->litros_gaseosos, 2, '.', '')}}</td>                   
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleO({{$SeguimientoPlanchaOxigenos->id_seguimiento_pl_oxigeno}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <thead>
                        <tr class="background-primary">
                            <th></th>
                            <th colspan="3">TOTAL OXIGENO</th>
                            <th id="total_oxigeno_usados"></th>
                            <th>TOTAL LITROS</th>
                            <th id="total_litros_gaseosos"></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-block">
            <h4 class="sub-title">CONSUMIBLES USADOS</h4>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Fecha</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="fecha_creado_consumible" id="fecha_creado_consumible"
                        value="{{ old('fecha_creado_consumible') }}" placeholder="">
                </div>

                <div class="form-radio col-sm-1"> 
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="tipo_materia" id="ConsumibleAprov" value="CONSUMIBLE"
                                onclick="Consumible();" checked><i class="helper"></i>Consumible
                        </label>
                    </div>
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="tipo_materia" id="ConsumibleOtro" value="OTRO" {{
                                old('tipo_materia')=="OTRO" ? 'checked=' .'"'.'checked'.'"' : '' }}
                                onclick="Consumible();">
                            <i class="helper"></i>Otro
                        </label>
                    </div>
                </div>
            </div>

               <div class="form-group row" id="consumible_aprovechamiento">
                    <label class="col-sm-1 col-form-label p-r-0">Consumible</label>
                    @if ($OrdenTrabajoPlancha->id_tecnologia == 1)
                    <div class="col-md-3 col-lg-3">
                        <select name="consumible_usado" id="consumible_usado" class="js-example-basic-single form-control
                                            @error('consumible_usado') is-invalid @enderror">
                            <option value="0" disabled selected>Seleccione el consumible</option>
                            @foreach($Inserto as $Insertos)
                                <option value="">INSERTO {{$Insertos->diametro_perforacion}}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <div class="col-md-3 col-lg-3">
                        <select name="consumible_usado" id="consumible_usado" class="js-example-basic-single form-control 
                            @error('consumible_usado') is-invalid @enderror">
                            <option value="0" disabled selected>Seleccione el consumible</option>
                            <option value="JUEGO DE ANTORCHA {{$OrdenTrabajoPlancha->juego_antorcha}}">JUEGO DE ANTORCHA
                                {{$OrdenTrabajoPlancha->juego_antorcha}}</option>
                                @foreach($Inserto as $Insertos)
                                <option value="">INSERTO {{$Insertos->diametro_perforacion}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                
                    <label class="col-sm-1 col-form-label p-r-0">Consumo</label>
                    <div class="col-sm-2">
                        <input type="number" name="consumo_consumible" id="consumo_consumible"
                            class="form-control @error('consumo_consumible') is-invalid @enderror"
                            value="{{ old('consumo_consumible') }}">
                    </div>
                
                    <label class="col-sm-1 col-form-label p-r-0">Observación</label>
                    <div class="col-sm-2">
                        <input type="text" name="observacion_consumible" id="observacion_consumible"
                            class="form-control @error('observacion_consumible') is-invalid @enderror"
                            value="{{ old('observacion_consumible') }}">
                    </div>
                </div>

                
                <div id="consumible_otro" class="form-group row">
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label p-r-0">Consumible</label>
                        <div class="col-sm-2">
                            <input type="text" name="consumible_usado_otro" id="consumible_usado_otro"
                                class="form-control @error('consumible_usado_otro') is-invalid @enderror"
                                value="{{ old('consumible_usado_otro') }}">
                        </div>
        
                    <label class="col-sm-1 col-form-label p-r-0">Consumo</label>
                    <div class="col-sm-2">
                        <input type="number" name="consumo_consumible_otro" id="consumo_consumible_otro"
                            class="form-control @error('consumo_consumible_otro') is-invalid @enderror"
                            value="{{ old('consumo_consumible_otro') }}">
                    </div>

                    <label class="col-sm-1 form-label p-r-0">Unidad</label>
                    <div class="col-sm-2">
                        <select name="unidad_consumible_otro" id="unidad_consumible_otro" class="js-example-basic-single form-control 
                            @error('unidad_consumible_otro') is-invalid @enderror">
                            <option value="0" disabled selected>Seleccione</option>
                            <option value="METROS DE PERFORACION">METROS DE PERFORACION</option>
                            <option value="PIERCINGS">PIERCINGS</option>
                            <option value="LITROS">LITROS</option>
                        </select>
                    </div>
                
                    <label class="col-sm-1 col-form-label p-r-0">Observación</label>
                    <div class="col-sm-2">
                        <input type="text" name="observacion_consumible_otro" id="observacion_consumible_otro"
                            class="form-control @error('observacion_consumible_otro') is-invalid @enderror"
                            value="{{ old('observacion_consumible_otro') }}">
                    </div>

                    </div>
                </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="float-right">
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarConsumible()">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" title="Limpiar" onClick="LimpiarCamposConsumible()">
                            <i class="icofont icofont-brush"></i>
                        </button> 
                    </div>
                </div>
            </div>

      <br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-styling" id="TablaConsumible">
                    <thead>
                        <tr class="background-primary">
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Consumible</th>
                            <th>Consumo</th>
                            <th>Unidad</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = json_decode(old('datos_seguimiento'));
                        @endphp
                        @if($data && isset($data->tabla_consumibles))
                        @foreach($data->tabla_consumibles as $consumibles)
                        <tr>
                            <td id='id_consumible'> {{$consumibles->id_seguimiento_pl_consumible}}</td>
                            <td id='fecha_creado_consumible'> {{$consumibles->fecha_creado}}</td>
                            <td id='consumible_usado'> {{$consumibles->consumible_usado}}</td>
                            <td id='consumo_consumible'> {{number_format($consumibles->consumo_consumible, 2, '.', '')}}</td>
                            <td id='unidad_consumible'> {{$consumibles->unidad_consumible}}</td>
                            <td id='observacion_consumible'> {{$consumibles->observacion_consumible}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleCon({{$consumibles->id_seguimiento_pl_consumible}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @else
                        @foreach($SeguimientoPlanchaConsumible as $SeguimientoPlanchaConsumibles)
                        <tr>
                            <td id='id_consumible'> {{$SeguimientoPlanchaConsumibles->id_seguimiento_pl_consumible}}</td>
                            <td id='fecha_creado_consumible'> {{$SeguimientoPlanchaConsumibles->fecha_creado}}</td>
                            <td id='consumible_usado'> {{$SeguimientoPlanchaConsumibles->consumible}}</td>
                            <td id='consumo_consumible'> {{number_format($SeguimientoPlanchaConsumibles->consumo, 2, '.', '')}}</td>
                            <td id='unidad_consumible'> {{$SeguimientoPlanchaConsumibles->unidad}}</td>
                            <td id='observacion_consumible'> {{$SeguimientoPlanchaConsumibles->observaciones}}</td>    
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleCon({{$SeguimientoPlanchaConsumibles->id_seguimiento_pl_consumible}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @endif 
                    </tbody> 
                </table>
            </div>
        </div>
    </div> 

        <br>
            <input type="hidden" name="datos_seguimiento" id="datos_seguimiento">
            <div class="d-grid gap-2 d-md-block float-right">
                <button type="button" value="Enviar" id="enviar" class="btn btn-primary" OnClick="CapturarDatosSeguimiento()">
                    <i class="fa fa-save"></i>Guardar
                </button>
            </div>
        </form>
@endsection

@section('scripts')
<!-- data-table js -->
<script src="{{ asset('libraries\bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\data-table\js\jszip.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\data-table\js\pdfmake.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\data-table\js\vfs_fonts.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.print.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}"></script>

<!-- Custom js -->
<script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>

<!-- sweet alert js -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>

<script src="{{ asset('libraries\assets\pages\form-masking\inputmask.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\form-masking\jquery.inputmask.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\form-masking\form-mask.js') }}" type="text/javascript"></script>

<script>
    var EliminarDetalleHorometro = "{{ url('cenceliminardetallehorometro') }}"; 
    var EliminarDetalleCortes = "{{ url('cenceliminardetallecortes') }}";
    var EliminarDetalleAvance = "{{ url('cenceliminardetalleavance') }}";
    var EliminarDetalleOxigeno = "{{ url('cenceliminardetalleoxigeno') }}";
    var EliminarDetalleConsumible = "{{ url('cenceliminardetalleconsumible') }}";
    var NumeroParte = "{{ url('cencnumeroparte') }}";
</script>

<script src="{{ asset('libraries\assets\js\CencSeguimiento.js') }}"></script>

@endsection