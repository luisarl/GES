@extends('layouts.master')

@section('titulo', 'Recepcion')

@section('titulo_pagina', 'Recepcion')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/dashboardcnth') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
    <li class="breadcrumb-item"><a href="{{ asset('/despachos') }}">Despachos</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Recepcion</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjAlerta')

    <div class="card">
        <div class="card-header">
            <h4 class="sub-title">Datos de la Recepcion</h4>
        </div>
        <div class="card-block"> 
        <form method="POST" action="{{ route('enviar', $movimientos->id_movimiento) }}" enctype="multipart/form-data">
         @csrf 
         <div class="row">
            <div class="col-sm-5">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Fotografias</label>
                    <div class="col-sm-9">
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
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Fotografia Actual</label>
                    <div class="col-sm-9">
                        <div id="results">
                            <img style="width: 300px" class="after_capture_frame"
                                src="{{ asset('/images/herramientas/despachos/placeholder.jpg') }}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-7 text-center">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <div id="my_camera"></div>
                        <input type="hidden" name="captured_image_data" id="captured_image_data">
                    </div>
                   
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <button type="button" class="btn btn-primary form-control" value="CAPTURAR IMAGEN"
                            onClick="take_snapshot()">
                            <i class="fa fa-camera"></i>CAPTURAR IMAGEN
                        </button>
                    </div>
                </div>
            </div>
         </div>
         <hr>
        <div class="card-block">
            <div class="row invoive-info">
                <div class="col-md-4 col-sm-6">
                    <h6>Informacion Despacho:</h6>
                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                        <tbody>
                            <tr>
                                <th>Despacha : </th>
                                <td>{{ $movimientos->creado_por }}</td>
                            </tr>
                            <tr>
                                <th>Fecha :</th>
                                <td>{{ $movimientos->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Almacen :</th>
                                <td>{{ $movimientos->nombre_almacen }}</td>
                            </tr>
                            <tr>
                                <th>Zona :</th>
                                <td>{{ $movimientos->nombre_zona }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 col-sm-6">
                    <h6>Informacion Recepcion:</h6>
                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                        <tbody>
                            <th>Estatus :</th>
                            <td>
                                @if ($movimientos->estatus == 'DESPACHO')
                                <label class="label label-danger">{{ $movimientos->estatus }}</label>
                                @elseif($movimientos->estatus == 'RECEPCION')
                                <label class="label label-primary">{{ $movimientos->estatus }}</label>
                                @endif
                            </td>
                            </tr>
                            <tr>
                                <th>Despacho :</th>
                                <td>
                                    #{{ $movimientos->id_movimiento}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 col-sm-6">
                    <h6>Motivo de la Solcitud:</h6>
                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                        <tbody> 
                            <td>
                                {{ $movimientos->motivo }}
                            </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
            <h4 class="sub-title">LISTADO DE HERRAMIENTAS</h4>
            <form method="POST" action="{{ route('enviar', $movimientos->id_movimiento) }}"
                enctype="multipart/form-data">
                @csrf @method('put')
                {{-- campo oculto id_almacen --}}
                <input type="hidden" name="id_almacen" value="{{$movimientos->id_almacen}}">
                <div class="table-responsive">                       
                    <table id="tabla_recepcion" class="listado_herramientas table table-striped table-bordered">
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
                                <th style="visibility:collapse; display:none;">MOVIMIENTO</th>
                                <th>CODIGO</th>
                                <th>HERRAMIENTA</th>
                                <th style="visibility:collapse; display:none;">ID EMPLEADO</th>
                                <th>RESPONSABLE</th>
                                <th>CANTIDAD <br> ENTREGADA</th>
                                <th>CANTIDAD <br> DEVUELTA</th>
                                <th>ESTATUS</th>
                                <th>EVENTUALIDAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detalles as $detalle)
                            @php
                            $total_herramientas = $loop->count;
                            $cantidad_pendiente = $detalle->cantidad_entregada - $detalle->cantidad_devuelta;
                            @endphp

                            {{-- MUESTRA LAS HERRAMIENTAS CON DEVOLUCIONES PENDIENTES --}}
                            @if($detalle->cantidad_entregada != $detalle->cantidad_devuelta)
                            <tr>
                                <th class="check recibir">
                                    <div class="checkbox-fade fade-in-primary">
                                        <label>
                                            <input class="form-check-input recibido" type="checkbox" OnClick=""
                                                name="recibir" id="recibir" value="SI">
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                            <span></span>
                                        </label>
                                    </div>
                                </th>
                                <td class="id_detalle" style="visibility:collapse; display:none;">{{$detalle->id_detalle}}</td>
                                <td class="id_herramienta">{{ $detalle->id_herramienta }}</td>
                                <td class="herramienta">{!!wordwrap($detalle->nombre_herramienta , 25, '<br>')!!}</td>
                                <td class="id_empleado" style="visibility:collapse; display:none;">{{ $detalle->responsable }}</td>
                                <td class="responsable">{{ $detalle->responsable }}</td>
                                <td class="cantidad_entregada">{{ $cantidad_pendiente }}</td>
                                <td class="cantidad_devuelta" id="cantidad_devuelta{{$loop->iteration}}"
                                    data-type="number" data-min="1" data-max="{{$cantidad_pendiente}}">0</td>
                                <td class="estatus" id="estatus{{$loop->iteration}}" data-type="select"
                                    data-value="" data-prepend="BUEN ESTADO"
                                    data-source='[{value: 2, text: "DAÑO NATURAL"}, {value: 3, text: "DAÑO POR MAL USO"}, {value: 4, text: "FIN VIDA UTIL"}, {value: 5, text: "REPORTA PERDIDA"}]'>
                                </td>
                                <td class="eventualidad" id="eventualidad{{$loop->iteration}}" data-type="textarea"
                                    data-rows="3" data-cols="3" data-value="" data-prepend="Ingrese Eventualidad">
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($movimientos->estatus != 'RECEPCION')
                <div class="row text-center">
                    {{-- Campo oculto con arreglo de los datos recepcion --}}
                    <input type="hidden" name="datosrecepcion" id="datosrecepcion">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla()">RECIBIR</button>
                    </div>
                </div>
                @endif
            </form>    
            <!-- Filtering Foo-table card end -->
        </div>
    </div>

@endsection
@section('scripts')

<!--Personalizado -->
<script src="{{asset('libraries\assets\pages\webcamjs\webcam.js')}}"></script>
<script src="{{ asset('libraries\assets\js\recepcion.js') }}"></script>
<script src="{{ asset('libraries\assets\js\activar-camara.js') }}"></script>

<!-- Bootstrap Editable -->
<script src="{{ asset('libraries/bower_components/bootstrap-editable/js/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() {
    $.fn.editable.defaults.mode = 'inline';
    
    let total_herramientas = {!! json_encode($total_herramientas) !!};
    
    for(let i= 1; i <= total_herramientas; i++) 
    {
        $('#cantidad_devuelta'+i).editable({

        });
        $('#estatus'+i).editable({
            showbuttons: false 
        });
        $('#eventualidad'+i).editable({
        });

    }
});   

    $("#todos").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $('.recibido').on('click', function(){
        var row = $(this).closest('tr');
        if($(this).is(':checked'))
        {
            row.find('td').addClass('bloqueado');
        } 
        else 
            {
                row.find('td').removeClass('bloqueado');
            }
    });


</script>
<style>
    .bloqueado{
        pointer-events: none;
    }
</style>

<script type="text/javascript" src=" {{ asset('libraries\bower_components\lightbox2\js\lightbox.min.js') }} "></script>

<script>
    lightbox.option({
        'resizeDuration': 500,
        'wrapAround': true
    })
</script>
@endsection