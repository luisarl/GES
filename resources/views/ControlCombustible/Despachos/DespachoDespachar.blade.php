@extends('layouts.master')

@section('titulo', 'Solicitudes de Despacho')

@section('titulo_pagina', 'Solicitud de Despacho')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Control Combustible</a> </li>
    <li class="breadcrumb-item"><a href="{{route('cntcdespachos.index') }}">Solicitudes Despacho</a> </li>
    <li class="breadcrumb-item"><a href="#!">Ver</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
<div class="card product-detail-page">
    <div class="card-block">
       
        <div class="row">
            <div class="col-lg-12 col-xs-12 product-detail" id="product-detail">
                <div class="row">
                    <div class="col-lg-12">
                        <span class="txt-muted d-inline-block h6 m-r-10"><strong>SOLICITUD Nº {{$solicitudes->id_solicitud_despacho}} </strong> </span>
                        
                        {{-- @if($salida->estatus != 'GENERADO') --}}
                            {{-- @can('asal.salidamateriales.imprimir') --}}
                                {{-- BOTON IMPRIMIR --}}
                                {{-- <a href="{{ route('resgimprimirsolicituddespacho', $solicitud->id_solicitud_despacho) }}" target="_blank" type="button"
                                    class="btn btn-primary btn-sm" title="Imprimir">
                                    <i class="fa fa-print fa-2x"></i> </a> --}}

                            {{-- @endcan --}}
                        {{-- @endif     --}}
                      
                        <span class="f-right">
                            <strong>ESTATUS: </strong>
                            @if($solicitudes->estatus == 'POR APROBAR')
                                <label class="label label-warning">POR APROBACION</label>
                            @elseif($solicitudes->estatus == 'ACEPTADO')
                                <label class="label label-info">ACEPTADO</label>
                            @elseif($solicitudes->estatus == 'PROCESADO')
                                <label class="label label-success">PROCESADO</label>
                            @elseif($solicitudes->estatus == 'ANULADO')
                                <label class="label label-danger">ANULADO</label>
                        @endif
                        </span>
                        <br>
                        <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($solicitudes->fecha_creacion)) }}">
                            <strong>CREADO: </strong> {{ $solicitudes->creado_por }} </label>
                        <br>
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($solicitudes->fecha_aceptado)) }}">
                            <strong>ACEPTADO: </strong> {{  $solicitudes->aceptado_por}} </label>
                        <br>
                        <label data-toggle="popover" data-placement="right"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($solicitudes->fecha_aprobacion)) }}">
                            <strong>PROCESADO: </strong> {{  $solicitudes->aprobado_por}} </label>
                            <br>
                       
                        <hr>
                    </div>
                    <div class="col-lg-6">
                       
                        <h6 class="txt-muted"><strong>SOLICITADO POR: </strong> {{$solicitudes->creado_por}} </h6>
                        <h6 class="txt-muted"><strong>UNIDAD/ GERENCIA: </strong> {{$solicitudes->nombre_departamento}} </h6>
                        
                    </div>
                    <div class="col-lg-6">
                        <h6 class="txt-muted"><strong>TIPO DE COMBUSTIBLE: </strong> {{$solicitudes->descripcion_combustible}} </h6>
                        <h6 class="txt-muted"><strong>MOTIVO: </strong> {{$solicitudes->motivo}} </h6>   
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    
    <div class="card-block">
        <form method="POST" action="{{ route('cntcprocesarsolicituddespachos',$solicitudes->id_solicitud_despacho) }}">
            @csrf
           
            <h4 class="sub-title">Equipos</h4>
            <div class="table-responsive">
            
                <table class="table table-striped table-bordered" id="tablaequipos">
                    <thead>
                        <tr>
                            <th>
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="checkbox" id="todos" name="todos" value="" title="MARCAR/DESMARCAR TODOS">
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                        <span>MARCAR/<br>DESMARCAR</span>
                                    </label>
                                </div>
                            </th>
                            <th style="display:none;">Id Solicitud Detalle</th>
                            <th style="width:5%">Marca/Nombre Equipo</th>
                            <th style="width:10%">PLACA</th>
                            <th style="width:10%">Responsable</th>
                            <th style="width:10%">Departamento Solc</th>
                            <th style="width:5%">Cantidad Solc</th>
                            <th style="width:3%">Cantidad Despa</th>
                            <th style="width:3%">Fecha Despa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipos as $equipo)
                        <tr>
                            @if($equipo->fecha_despacho == NULL)
                                <th><input type="checkbox" name="seleccionar[]" class="seleccionar"></th>
                                <td id="id_solicitud_despacho_detalle" style="display:none;">{{$equipo->id_solicitud_despacho_detalle}}</td>
                                <td id="marca_vehiculo">{{$equipo->marca_equipo}}</td>
                                <td id="placa_vehiculo">{{$equipo->placa_equipo}}</td>
                                <td id="responsable">{{$equipo->responsable}}</td>
                                <td id="departamento">{{$equipo->nombre_departamento}}</td>
                                <td id="cantidad">{{number_format($equipo->cantidad,2)}}</td>
                                <td>
                                    <input type="number" name="cd" class="form-control bloqueado" 
                                        oninput="ActualizarTotal()" 
                                        value="{{ $equipo->fecha_despacho ? number_format($equipo->cantidad_despachada,2) : '' }}" 
                                        {{ $equipo->fecha_despacho ? '' : 'disabled' }}>
                                </td>
                                <td>
                                    <input type="date" id="fecha_despacho" name="fecha_despacho" class="form-control bloqueado" 
                                    value="{{ $equipo->fecha_despacho ?  date('Y-m-d', strtotime($equipo->fecha_despacho))  : '' }}" 
                                    {{ $equipo->fecha_despacho ? '' : 'disabled' }}>
                                </td>
                            @else
                                <th></th>
                                <td id="id_solicitud_despacho_detalle" style="display:none;">{{$equipo->id_solicitud_despacho_detalle}}</td>
                                <td id="marca_vehiculo">{{$equipo->marca_equipo}}</td>
                                <td id="placa_vehiculo">{{$equipo->placa_equipo}}</td>
                                <td id="responsable">{{$equipo->responsable}}</td>
                                <td id="departamento">{{$equipo->nombre_departamento}}</td>
                                <td id="cantidad">{{number_format($equipo->cantidad,2)}}</td>
                                <td>
                                    <input type="number" name="cd" class="form-control bloqueado" 
                                        oninput="ActualizarTotal()" 
                                        value="{{ $equipo->fecha_despacho ? number_format($equipo->cantidad_despachada,2) : '' }}" 
                                        {{ $equipo->fecha_despacho ? '' : 'disabled' }}>
                                </td>
                                <td>
                                    <input type="date" id="fecha_despacho" name="fecha_despacho" class="form-control bloqueado" 
                                    value="{{ $equipo->fecha_despacho ?  date('Y-m-d', strtotime($equipo->fecha_despacho))  : '' }}" 
                                    {{ $equipo->fecha_despacho ? '' : 'disabled' }}>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        <div class="form-group row">
            <label for="TOTAL" class="col-2 form-label">TOTAL SOLICITADO</label>
                <div class="col-sm-1">
                     <input type="number" id="total" name="total" class="form-control @error('total') is-invalid @enderror" value="{{$solicitudes->total}}"  readonly>
                </div>
            <label for="TOTAL" class="col-2 form-label">TOTAL DESPACHADO</label>
           
            <div class="col-sm-1">
                <input type="number" id="totaldespachado" name="totaldespachado" class="form-control @error('totaldespachado') is-invalid @enderror"  readonly>
                <input type="number" id="despachado" name="despachado" class="form-control @error('despachado') is-invalid @enderror"  readonly>
            </div>  
         
            <label for="TOTAL" class="col-2 form-label">TOTAL COMBUSTIBLE</label>
            <div class="col-sm-1">
                <input type="number" id="stock" name="stock" class="form-control @error('stock') is-invalid @enderror"  value="{{$tipoCombustible->stock}}"readonly>
            </div>
        </div>

        <input type="hidden" name="totales" id="totales" >      
        <input type="hidden" name="vehiculos" id="vehiculos">
        <div class="d-grid gap-2 d-md-block float-right">
    
           @if($solicitudes->estatus != 'PROCESADO')
            {{-- @can('resg.soldespacho.aprobar') --}}
                <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTablaVehiculos()">
                    <i class="fa fa-check"></i>GUARDAR
                </button>
           {{-- @endcan --}}
            @endif
       </div>

    </form>
    </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript" src="{{ asset('libraries\assets\js\CntcDespachosDespachar.js') }}"></script>
<script>
// Asignar evento change a los checkboxes
document.querySelectorAll('input[name="seleccionar[]"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', ActualizarTotal);
});

// Asignar evento change al checkbox "todos"
document.querySelector('input[name="todos"]').addEventListener('change', function() {
    document.querySelectorAll('input[name="seleccionar[]"]').forEach(function(checkbox) {
        checkbox.checked = this.checked;
    }, this);
    ActualizarTotal();
});

// Asignar evento input a los campos cd
document.querySelectorAll('input[name="cd"]').forEach(function(input) {
    input.addEventListener('input', ActualizarTotal);
});

</script>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            html: true,
            content: function() {
                return $('#primary-popover-content').html();
            }
        });
    });



     $("#todos").change(function() {
        $("input:checkbox[name='seleccionar[]']").prop('checked', $(this).prop("checked")).change();
    });

   // Habilitar/Deshabilitar campos según el estado del checkbox
$('body').on('change', 'input:checkbox[name="seleccionar[]"]', function() {
    var row = $(this).closest('tr');
    if ($(this).is(':checked')) {
        row.find('input[type!="checkbox"].bloqueado').removeClass('bloqueado').prop('disabled', false);
    } else {
        row.find('input[type!="checkbox"]').addClass('bloqueado').prop('disabled', true);
    }
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var estatus = "{{ $solicitudes->estatus }}";
        var totaldespachado = document.getElementById('totaldespachado');
        var despachadoContainer = document.getElementById('despachado');

        if (estatus == 'PROCESADO') {
            totaldespachado.style.display = 'block';
            despachadoContainer.style.display = 'none';
        } else {
            totaldespachado.style.display = 'none';
            despachadoContainer.style.display = 'block';
        }
    });
</script>
<style>
    .bloqueado{
        pointer-events: none;
    }
</style>
@endsection
