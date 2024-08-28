@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte de Activos')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Reporte de Activos</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

@section('contenido')
<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>PARAMETROS DE BUSQUEDA</strong></h4>
    </div>
    <div class="card-block">
        <form method="GET" action="">
            <div class="form-group row">
                {{-- FILTROS DE BUSQUEDA --}}
                <label for="departamento" class="col-md-2 col-lg-2 col-form-label">Departamento</label>
                <div class="col-sm-3 @error('id_departamento') is-invalid @enderror">
                    <select name="id_departamento" class="js-example-basic-single form-control" onchange="getHiddenField(this)">
                        <option value="TODOS">TODOS</option>
                        @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->id_departamento }}" @if ($departamento->id_departamento == old('id_departamento', $_GET['id_departamento'] ?? '' )) selected="selected" @endif>
                          {{ $departamento->nombre_departamento }}
                        </option>
                        @endforeach
                      </select>
                      <input type="hidden" name="nombre_departamento" id="nombre_departamento" value="">
                </div>

                <label class="col-sm-6 col-md-1 form-label">Estatus</label>
                <div class="col-sm-6 col-md-2 ">
                    <select name="estatus"
                        class="js-example-basic-single form-control @error('estatus') is-invalid @enderror">
                        <option value="TODOS" @if ('TODOS'==old('estatus', $_GET['estatus'] ?? '' )) selected="selected"
                            @endif>TODOS</option>
                        <option value="ACTIVO" @if ('ACTIVO'==old('estatus', $_GET['estatus'] ?? '' ))
                            selected="selected" @endif>ACTIVO</option>
                        <option value="INACTIVO" @if ('INACTIVO'==old('estatus', $_GET['estatus'] ?? '')) 
                            selected="selected" @endif>INACTIVO</option>
                        <option value="DESINCORPORADO" @if ('DESINCORPORADO'==old('estatus', $_GET['estatus'] ?? '' ))
                            selected="selected" @endif>DESINCORPORADO</option>
                        <option value="RESGUARDADO" @if ('RESGUARDADO'==old('estatus', $_GET['estatus'] ?? '')) 
                            selected="selected" @endif>RESGUARDADO</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2">
                </div>
                <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-1 mb-1" OnClick="">
                </div>
                @can('repo.solicitudes.logistica.pdf')
                <div class="col-auto">
                    <input type="submit" value="Imprimir" name="pdf" class="btn btn-primary mt-1 mb-1">
                </div>
                @endcan
            </div>           
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>
        @php
        $contador = 1;
        @endphp
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tablaajuste">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Serial</th>
                        <th>Marca</th>
                        {{-- <th>Caracteristica</th> --}}
                        <th>Responsable</th>
                        <th>Departamento</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activos as $activo)
                    <tr>
                        <td>{{$activo->codigo_activo}}</td>
                        <td>{{$activo->nombre_activo}}</td>
                        <td>{{$activo->serial}}</td>
                        <td>{{$activo->marca}}</td>
                        <td>{{$activo->responsable }}</td>
                        <td>{{$activo->nombre_departamento}}</td>
                        <td>
                            @if($activo->estatus == 'ACTIVO')
                                <label class="label label-success">ACTIVO</label>
                            @elseif($activo->estatus == 'INACTIVO')
                                <label class="label label-warning">INACTIVO</label>
                            @elseif($activo->estatus == 'DESINCORPORADO')
                                <label class="label label-danger">DESINCORPORADO</label>
                            @elseif($activo->estatus == 'RESGUARDADO')
                                <label class="label label-primary">RESGUARDADO</label>  
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<script>
    function getHiddenField(selectElement) 
    {
      var hiddenInput = document.getElementById('nombre_departamento');
      var selectedOption = selectElement.options[selectElement.selectedIndex];
      hiddenInput.value = selectedOption.text;
    }
  </script>

@endsection