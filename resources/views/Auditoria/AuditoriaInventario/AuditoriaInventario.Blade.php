@extends('layouts.master')

@section('titulo', 'Auditoria')

@section('titulo_pagina', 'Auditoria Inventario')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Auditoria</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('audiauditoriainventario.index') }}">Auditoria Inventario</a></li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('Auditoria.AuditoriaInventario.AuditoriaInventarioDestroy')

<div class="card">
    <div class="card-header">
        <h5>PARAMETROS DE BUSQUEDA</h5>
        {{-- <h4 class="sub-title"><strong>PARAMETROS DE BUSQUEDA</strong> </h4> --}}
        @can('audi.auditoriainventario.crear')
        <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('audiauditoriainventario.create') !!}">
            <i class="fa fa-plus"></i> Nuevo</a>
        @endcan
       
    </div>
    <div class="card-block">
        <form method="GET" action="">
            {{-- @csrf --}}
            <div class="form-group row">
                <label class="col-sm-2 col-md-1 form-label">Fecha</label>
                <div class="col-sm-4 col-md-2 ">
                    <input type="date" name="fecha" min="" id=""
                        class="form-control @error('fecha') is-invalid @enderror"
                        value="{{ old('fecha', $_GET['fecha'] ?? '') }}">
                </div>
        
                <label class="col-sm-2 col-md-1 form-label">Numero Auditoria</label>
                <div class="col-sm-4 col-md-2 ">
                    <input type="number" name="numero_auditoria" id="" class="form-control" value="{{old('numero_auditoria', $_GET['numero_auditoria'] ?? '')}}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-1">
                </div>
                <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-1 mb-1" OnClick="">
                         {{-- <i class="fa fa-search"></i>Buscar
                    </input> --}} 
                </div>
                {{-- @can('audi.auditoriafisica.imprimir') --}}
                <div class="col-auto">
                    <input type="submit" value="Imprimir" name="pdf" class="btn btn-primary mt-1 mb-1">
                </div>
                {{-- @endcan --}}
                {{-- @can('audi.auditoriafisica.exportar') --}}
                <div class="col-auto">
                    <input type="submit" value="Exportar" name="excel" class="btn btn-primary mt-1 mb-1" OnClick="">
                        {{-- <i class="fa fa-file-excel-o"></i>Exportar
                    </input> --}}
                </div>
                {{-- @endcan --}}
            </div>
            
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tabla">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Codigo</th>
                        <th>Articulo</th>
                        <th>Almacen</th>
                        <th>SubAlmacen</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Stock</th>
                        <th>Conteo</th>
                        <th>Direfencia</th>
                        {{-- <th>Observacion</th> --}}
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if($articulos != null)
                        @foreach ($articulos as $articulo)
                        <tr>
                            <td>{{$articulo->numero_auditoria}}</td>
                            <td>{{$articulo->codigo_articulo}}</td>
                            <td>{{$articulo->nombre_articulo}}</td>
                            <td>{{$articulo->nombre_almacen}}</td>
                            <td>{{$articulo->nombre_subalmacen}}</td>
                            <td>{{$articulo->usuario}}</td>
                            <td>{{date('d-m-Y g:i:s A', strtotime($articulo->fecha))}}</td>
                            <td>{{number_format($articulo->stock_actual, 2)}}</td>
                            <td>{{number_format($articulo->conteo_fisico, 2)}}</td>
                            <td>{{number_format($articulo->diferencia, 2)}}</td>
                            <td class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                    @can('audi.auditoriainventario.editar')
                                        <a class="dropdown-item" href=" {{ route('audiauditoriainventario.edit', $articulo->id_auditoria_inventario)}}" ><i class="fa fa-edit"></i>Editar</a>
                                    @endcan 
                                    @can('audi.auditoriainventario.eliminar')
                                        <a class="dropdown-item" data-id="{{ $articulo->id_auditoria_inventario }}" data-nombre="{{ $articulo->nombre_articulo }}"  data-toggle="modal" data-target="#modal-eliminar" href="#!"><i class="fa fa-trash"></i>Borrar</a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<!-- sweet alert js -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>

<script>
    $('#modal-eliminar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button que llama al modal
        var id = button.data('id') // Extrae la informacion de data-id
        var nombre = button.data('nombre') // Extrae la informacion de data-nombre
        action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
        action += id; // se agrega el id seleccionado al formulario

        $('#formdelete').attr('action', action); //cambia la ruta del formulario

        var modal = $(this)
        modal.find('.modal-body h5').text('Desea Eliminar La Auditoria Del Articulo ' + nombre + ' ?') //cambia texto en el body del modal
    })
</script>

@endsection