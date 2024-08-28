@extends('layouts.master')

@section('titulo', 'Control Combustible')

@section('titulo_pagina', 'Solicitud Despacho de Combustible')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cntcdespachos.index') }}">Solicitudes de Despacho</a> </li>
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')


<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>Tipo de Combustible</strong></h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('cntcdespachos.update',$solicitudes->id_solicitud_despacho) }}">
            @csrf
            @method('put')
            <div class="form-group row">
                <div class="col-md-3 col-lg-3">
                    <label class="form-label">Tipo de Combustible</label>
                    <select id="id_combustible" name="id_combustible" class="form-control" disabled>
                        <option value="SIN ASIGNAR">SIN ASIGNAR</option>
                        @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id_tipo_combustible }}" @if ($tipo->id_tipo_combustible == old('id_combustible', $solicitudes->id_combustible )) selected="selected" @endif>
                            {{ $tipo->descripcion_combustible }}
                        </option>
                        @endforeach
                    </select>
                </div>  

                <div class="col-md-3 col-lg-3">
                    <label for="departamento" class="form-label">Departamentos</label>
                    <div class=" @error('departamento') is-invalid @enderror">
                        <select name="departamento" id="departamento" class="js-example-basic-single form-control" readonly>
                            <option value="0">SELECCIONE UN DEPARTAMENTO</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id_departamento }}" @if ($departamento->id_departamento == old('departamento',$solicitudes->id_departamento )) selected="selected" @endif>
                                    {{ $departamento->nombre_departamento }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <label for="motivo" class="form-label">Motivo</label>
                    <input type="text" name="motivo" id="motivo" class="form-control @error('motivo') is-invalid @enderror" placeholder="Ingrese motivo" value="{{ $solicitudes->motivo}}">
                </div>
            </div> 
        
            <h4 class="sub-title">Equipos</h4>
            <div class="form-group row">
                @if(isset($equipos) && count($equipos) > 0 && $equipos[0]->placa_equipo != "NO APLICA")
                <div class="form-radio col-sm-2"> 
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="equipo" id="EquipoVehiculo" value="VEHICULO" onClick="TipoEquipo();" checked disabled>
                            <i class="helper"></i>Vehiculo
                        </label>
                    </div>
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="equipo" id="EquipoOtro" value="OTRO" {{ old('equipo')=="OTRO" ? 'checked='.'"'.'checked'.'"' : '' }} onClick="TipoEquipo();" disabled>
                            <i class="helper"></i>Otro
                        </label>
                    </div>
                </div>
                @else
                <div class="form-radio col-sm-2"> 
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="equipo" id="EquipoVehiculo" value="VEHICULO" onClick="TipoEquipo();" disabled>
                            <i class="helper"></i>Vehiculo
                        </label>
                    </div>
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="equipo" id="EquipoOtro" value="OTRO" {{ old('equipo')=="OTRO" ? 'checked='.'"'.'checked'.'"' : '' }} onClick="TipoEquipo();" checked disabled>
                            <i class="helper"></i>Otro
                        </label>
                    </div>
                </div>
                @endif
            </div>
                    <div class="form-group row">
                        <label class="col-sm-1 form-label">Responsable</label>
                        <div class="form-radio col-sm-1"> 
                            <div class="radio radio-inline">
                                <label>
                                    <input type="radio" name="tipo_chofer" id="ChoferInterno" value="INTERNO" onClick="TipoResponsable();" checked>
                                    <i class="helper"></i>Interno
                                </label>
                            </div>
                            <div class="radio radio-inline">
                                <label>
                                    <input type="radio" name="tipo_chofer" id="ChoferForaneo" value="FORANEO" alue="FORANEO" {{ old('tipo_chofer')=="FORANEO" ? 'checked='.'"'.'checked'.'"' : '' }} onClick="TipoResponsable();">
                                    <i class="helper"></i>Foraneo
                                </label>
                            </div>
                        </div> 
                         {{-- CONDUCTOR INTERNO--}}
                        
                        <div class="col-sm-3  @error('conductorinterno') is-invalid @enderror" id="ConductorInterno" >
                            <label for="responsable" class="form-label">Responsable</label>
                            <select name="conductorinterno" id="conductorinterno"
                                class="js-example-basic-single form-control">
                                <option value="0">SELECCIONE EL CONDUCTOR</option>
                                @foreach($empleados as $empleado)
                                    <option value="{{$empleado->Empleado}}" @if ($empleado->Empleado == old('conductorinterno')) selected = "selected" @endif>
                                        {{$empleado->Empleado}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- CONDUCTOR FORANEO  --}}
                        <div class="col-sm-3 @error('conductorforaneo') is-invalid @enderror" id="ConductorForaneo">
                            <label for="responsable" class="form-label">Responsable</label>
                            <input type="text" name="conductorforaneo" id="conductorforaneo" class="form-control @error('conductorforaneo') is-invalid @enderror" placeholder="Nombre del conductor" value="{{ old('conductorforaneo') }}">
                        </div>

                        <div class="col-md-3 col-lg-3 mb-3" id="vehiculoSection">
                            <label for="vehiculos" class="form-label">Vehiculo</label>
                            <select name="id_vehiculo" id="id_vehiculo" class="js-example-basic-single form-control @error('id_vehiculo') is-invalid @enderror">
                                <option value="0">SELECCIONE EL VEHICULO</option>
                                @foreach($vehiculos as $vehiculo)
                                    <option value="{{$vehiculo->id_vehiculo}}">
                                        {{$vehiculo->placa_vehiculo}} - {{$vehiculo->marca_vehiculo}} - {{$vehiculo->modelo_vehiculo}}
                                    </option>
                                @endforeach
                            </select>
                        </div> 
                        
                        <div class="col-md-3 col-lg-3 mb-3" id="otrosSection">
                            <label for="equipo" class="form-label">Equipo</label>
                            <input type="text" name="equipo" id="equipo" class="form-control @error('equipo') is-invalid @enderror" value="{{ old('equipo') }}">
                        </div>

                        <div class="col-md-3 col-lg-3 mb-3">
                            <label for="cantidad" class="block">Cantidad en litros</label>
                            <input type="number" class="form-control @error('cantidad') is-invalid @enderror" name="cantidad" id="cantidad" value="{{ old('cantidad') }}" min="0.10" step="0.10"> 
                        </div>
                    
                        @if($solicitudes->estatus!='APROBADO'&& $solicitudes->estatus!='ANULADO')
                             <div class="col-md-1 col-lg-1 mb-3">
                            <label for="name-2" class="block">Agregar</label>
                            <br>
                            <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTablaVehiculos()">
                                <i class="fa fa-plus"></i> 
                            </button>
                        </div>
                        @endif
                       
                        <div class="col-12">
                            <div class="table-responsive mt-3">
                                <table class="table table-striped table-bordered" id="tablavehiculos">
                                    <thead>
                                        <tr class="background-primary">
                                            <th>Marca/Nombre Equipo</th>
                                            <th>Placa</th>
                                            <th>Responsable</th>
                                            <th>Departamento Solc</th>
                                            <th>Cantidad Solc</th>
                                      
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($equipos as $equipo)
                                        <tr>
                                            <td id="id_solicitud_despacho_detalle" style='visibility:collapse; display:none;'>{{$equipo->id_solicitud_despacho_detalle}}</td>
                                            <td id="marca_vehiculo">{{$equipo->marca_equipo}}</td>
                                            <td id="placa_vehiculo">{{$equipo->placa_equipo}}</td>
                                            <td id="responsable">{{$equipo->responsable}}</td>
                                            <td id="departamento">{{$equipo->nombre_departamento}}</td>
                                            <td id="cantidad">{{number_format($equipo->cantidad,2)}}</td>
                                            <td>
                                                @if($solicitudes->estatus != 'APROBADO')
                                                <button type="button" 
                                                    class="borrar btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            <input type="hidden" name="totalanterior" id="totalanterior" value="{{$solicitudes->total}}">      
            <input type="hidden" name="vehiculos" id="vehiculos">
            <div class="form-group row">
                <label for="TOTAL" class="col-1 form-label">TOTAL</label>
                <div class="col-sm-2">
                     <input type="number" id="total" name="total" class="form-control @error('total') is-invalid @enderror"  readonly>
                </div>
               
            </div>
            <div class="d-grid gap-2 d-md-block float-right">

                @if($solicitudes->estatus != 'PROCESADO' && $solicitudes->estatus != 'ANULADO')
                    <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTablaVehiculos()">
                        <i class="fa fa-save"></i>Guardar
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\CntcDespachos.js') }}"></script>



@endsection
