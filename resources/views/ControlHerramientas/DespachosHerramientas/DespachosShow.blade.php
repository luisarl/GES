@extends('layouts.master')

@section('titulo', 'Detalle Despacho')

@section('titulo_pagina', 'Detalle Despacho')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item"><a href="{{ url('/dashboardcnth') }}"> <i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="{{ url('/despachos') }}">Despachos</a> </li>
    <li class="breadcrumb-item"><a href="#!">Detalle</a> </li>
</ul>
@endsection

@section('contenido')
<div class="card">
    <div class="card-header">
        <h4 class="sub-title">
            <strong>Despacho Nº {{$movimientos->id_movimiento}}</strong>
            <br>
            <br>
            <strong>Fecha: {{$movimientos->created_at}}</strong>
        </h4>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-4">
                <p class="font-weight-bold">MOTIVO: {{$movimientos->motivo}}</p>
                <p class="font-weight-bold">ALMACEN: {{$movimientos->nombre_almacen}}</p>
                <p class="font-weight-bold">ZONA: {{$movimientos->nombre_zona}}</p>
                <p class="font-weight-bold">DESPACHADO POR: {{$movimientos->creado_por}}</p>
                {{-- <p class="font-weight-bold">RECIBIDO POR: {{$movimientos->creado_por}} </p> --}}
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4">
                @foreach ($imagenes as $imagen)
                <div class="thumbnail">
                    <div class="thumb">
                        <a href="{{ asset($imagen->imagen) }} " data-lightbox="1"
                            data-title="{{ $movimientos->id_movimiento }}">
                            @if($loop->first)
                                <img src="{{ asset($imagen->imagen) }}" alt="" width="350px" height="350px"
                                    class="img-fluid img-thumbnail">
                            @endif        
                        </a>
                        
                    </div>
                </div>
            @endforeach
            </div>
            <div class="col-sm-4">
                <h4 class="sub-title">Historico Responsables</h4>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <th>Responsable</th>
                            <th>Fecha</th>
                        </thead>
                        <tbody>
                            @foreach($responsables as $responsable)
                            <tr>
                                <td>{{$responsable->responsable}}</td>
                                <td>{{date('d-m-Y g:i:s A', strtotime($responsable->fecha))}}</td>
                            </tr>
                            @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="table-responsive col-sm-12">
                <hr>
                <h4 class="sub-title">Lista de Herramientas</h4>
                <table id="" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>HERRAMIENTA</th>
                            <th>FECHA DESPACHO</th>
                            <th>RESPONSABLE HERRAMIENTA</th>
                            <th>CANTIDAD ENTREGADA</th>
                            <th>FECHA RECEPCIÓN</th>
                            <th>CANTIDAD RECEPCIÓN</th>
                            <th>ESTATUS</th>
                            <th>EVENTUALIDADES</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($detalles as $detalle)
                        @if ($detalle->cantidad_entregada != NULL)
                        <tr class="table-active">
                        @else
                        <tr class="">
                        @endif
                            <td>
                                @if($detalle->cantidad_entregada != NULL)
                                {{$detalle->nombre_herramienta}}
                                @endif
                            </td>
                            <td>{{$detalle->fecha_despacho}}</td>
                            <td>{{$detalle->responsable}}</td>
                            <td>{{$detalle->cantidad_entregada}}</td>
                            <td>{{$detalle->fecha_devolucion}}</td>
                            <td>
                                @if($detalle->cantidad_entregada == NULL)
                                {{$detalle->cantidad_devuelta}}
                                @endif
                            </td>
                            <td>
                                @if($detalle->estatus != 'BUEN ESTADO' )
                                <span class="text-danger"> {{$detalle->estatus}} </span>
                                @else
                                <span class="text-success"> {{$detalle->estatus}} </span>
                                @endif
                            </td>
                            <td>{{$detalle->eventualidad}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src=" {{ asset('libraries\bower_components\lightbox2\js\lightbox.min.js') }} ">
</script>
<script>
    lightbox.option({
        'resizeDuration': 500,
        'wrapAround': true
    })
</script>
@endsection