@extends('layouts.master')

@section('titulo', 'Ordenes')

@section('titulo_pagina', 'Orden de Trabajo')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Centro de Corte</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('cencordentrabajo.index') }}">Orden trabajo</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

@include('CentroCorte.OrdenTrabajo.Orden.OrdenTrabajoFinalizar')
@include('CentroCorte.OrdenTrabajo.Orden.OrdenTrabajoAceptar')

<form method="POST" id="FormOrdenTrabajo"
         action="{{ 
        isset($OrdenTrabajo) ? 
        route('cencordentrabajo.update', $OrdenTrabajo->id_orden_trabajo_plancha,
         ['IdOrdenTrabajo' => $OrdenTrabajo->id_orden_trabajo]) :
         route('cencordentrabajo.store', 
         ['IdOrdenTrabajo' => $OrdenTrabajo->id_orden_trabajo]) 
         }}"
        enctype="multipart/form-data">
        @if(isset($OrdenTrabajo))
        @method("put")
        @endif
        @csrf

<div class="page-body">
   
    <div class="form-group row">
        <div class="col-8">
            <div class="card">
                <div class="card-block">
                    <span class="title m-r-10 m-b-15"><strong><i class="icofont icofont-tasks-alt m-r-5"></i>ORDEN DE TRABAJO - N° {{$OrdenTrabajo->id_orden_trabajo}}</strong></span>
                        @if($OrdenTrabajo->estatus == 'POR ACEPTAR')
                        <label class="label label-info" id="estatus">POR ACEPTAR</label>
                        @elseif($OrdenTrabajo->estatus == 'ACEPTADA')
                        <label class="label label-success" id="estatus">ACEPTADA</label>
                        @elseif($OrdenTrabajo->estatus == 'APROBADO')
                        <label class="label label-danger" id="estatus">APROBADO</label>
                        @elseif($OrdenTrabajo->estatus == 'EN PROCESO')
                        <label class="label label-warning" id="estatus">EN PROCESO</label>
                        @elseif($OrdenTrabajo->estatus == 'ANULADO')
                        <label class="label label-danger" id="estatus">ANULADO</label>
                        @elseif($OrdenTrabajo->estatus == 'FINALIZADO')
                        <label class="label label-danger" id="estatus">FINALIZADO</label>
                        @endif
                    
                    @if($OrdenTrabajo->estatus == 'POR ACEPTAR')
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                        data-target="#modal-orden-aceptar" title="Aceptar Orden" href="#!">
                        <i class="fa fa-check-square"></i>ACEPTAR
                    </button>
                    @elseif($OrdenTrabajo->estatus == 'EN PROCESO')
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                        data-target="#modal-orden-finalizar" title="Finalizar Orden" href="#!">
                        <i class="fa fa-check-square"></i>FINALIZAR
                    </button> 
                    @endif
                    
                    <hr>

                    <div class="table-responsive dt-responsive">
                        <table class="table table-borderless table-responsive table-xs">
                            <tbody>
                                <tr>
                                    <th>N° CONAP:</th>
                                    <td>{{$OrdenTrabajo->nro_conap}}</td>
                                </tr>
                                <tr>
                                    <th>NOMBRE DEL CONAP:</th>
                                    <td>{{$OrdenTrabajo->nombre_conap}}</td>
                                </tr>

                                <tr>
                                    <th>FECHA INICIO:</th>
                                    <td>
                                        <input type="date" name="fecha_inicio_ot" id="fecha_inicio_ot"
                                        class="form-control col-12 @error('fecha_inicio_ot') is-invalid @enderror" 
                                        value="{{$OrdenTrabajo->fecha_inicio}}" @if(old('fecha_inicio_ot') == $OrdenTrabajo->fecha_inicio) @endif>
                                    </td>
                                </tr>

                                <tr>
                                    <th>FECHA FIN:</th>
                                    <td>
                                        <input type="date" name="fecha_fin_ot" id="fecha_fin_ot"
                                        class="form-control col-12 @error('fecha_fin_ot') is-invalid @enderror" 
                                        value="{{$OrdenTrabajo->fecha_fin}}" @if(old('fecha_fin_ot') == $OrdenTrabajo->fecha_fin) @endif>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

     <div class="col-4">
            <div class="card">
                <div class="card-block">
                    <span class="title m-r-10 m-b-15 h6 "><i class="fa fa-file-text m-r-5"></i> Documentos
                     </strong> </span>
                    <hr>
                    <div style="height:225px; overflow:auto;">
                        <div class="table-responsive dt-responsive">
                            <table class="table table-striped table-bordered nowrap table-responsive" cellspacing="0"
                                cellpadding="1" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 20%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @foreach($DocumentosConap as $DocumentosConaps)
                                    <tr>
                                        <td>
                                            <a target="_blank" href="{{asset($DocumentosConaps->ubicacion_documento)}}">
                                                {{$DocumentosConaps->nombre_documento}}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                    @foreach($DocumentosAprovechamientos as $DocumentosAprovechamiento)
                                    <tr>
                                    <td>
                                        <a target="_blank" href="{{asset($DocumentosAprovechamiento->ubicacion_documento)}}">
                                            {{$DocumentosAprovechamiento->nombre_documento}}
                                        </a>
                                    </td>
                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>


<div id="tabla_orden_trabajo" style="display: none;">
    <div class="card">
        <div class="card-header">
            <h5>Aprovechamientos asociados al CONAP</h5>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <div class="dt-responsive table-responsive">
                    <table id="datatable" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th style="width: 10%">ID</th>
                                <th style="width: 10%">Aprov</th>
                                <th style="width: 10%">Espesor</th>
                                <th style="width: 15%">Lista Partes</th>
                                <th style="width: 15%">Tipo</th>
                                <th style="width: 15%">Centro de Trabajo</th>
                                <th style="width: 15%">Tecnología</th>
                                <th style="width: 10%">Estatus</th>
                                <th style="width: 10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($OrdenesConap as $OrdenesConaps)
                            <tr>
                                <td>{{$OrdenesConaps->id_orden_trabajo_plancha}}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('aprovechamientopdf', $OrdenesConaps->id_aprovechamiento) }}"
                                        target="_blank" type="button" class="btn btn-primary btn-sm"
                                        title="Ver Aprovechamiento">
                                        <i class="fa fa-file-text"></i> </a>
                                </td>
                                <td>{{number_format($OrdenesConaps->espesor, 2, '.', '')}}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('listapartesdetallepdf', $OrdenesConaps->id_lista_parte) }}"
                                        target="_blank" type="button" class="btn btn-primary btn-sm"
                                        title="Ver Lista Partes">
                                        <i class="fa fa-file-text"></i> </a>
                                </td>
                                <td>{{$OrdenesConaps->tipo_lista}}</td>
                                <td>{{$OrdenesConaps->nombre_equipo}}</td>
                                <td>{{$OrdenesConaps->nombre_tecnologia}}</td>
                                <td>
                                    @if($OrdenesConaps->estatus == 'POR ACEPTAR')
                                    <label class="label label-info">POR ACEPTAR</label>
                                    @elseif($OrdenesConaps->estatus == 'ACEPTADA')
                                    <label class="label label-success">ACEPTADA</label>
                                    @elseif($OrdenesConaps->estatus == 'APROBADO')
                                    <label class="label label-danger">APROBADO</label>
                                    @elseif($OrdenesConaps->estatus == 'EN PROCESO')
                                    <label class="label label-warning">EN PROCESO</label>
                                    @elseif($OrdenesConaps->estatus == 'ANULADO')
                                    <label class="label label-danger">ANULADO</label>
                                    @elseif($OrdenesConaps->estatus == 'FINALIZADO')
                                    <label class="label label-danger">FINALIZADO</label>
                                    @endif
                                </td>
                                <td class="dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                            aria-hidden="true"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                        @php
                            $BuscarOTPlanchaSeguimiento = App\Models\Cenc_OrdenTrabajoModel::BuscarOrdenTrabajoPlanchaSeguimiento($OrdenesConaps->id_orden_trabajo_plancha);
                        @endphp
                                    @foreach ($BuscarOTPlanchaSeguimiento as $BuscarOTPlanchaSeguimientos)
                                        @if(($BuscarOTPlanchaSeguimientos->id_orden_trabajo_plancha == null) && $OrdenesConaps->estatus == 'EN PROCESO')
                                        @else
                                            <a class="dropdown-item" target="_blank"
                                                href="{{ route('cencseguimiento.show', $OrdenesConaps->id_orden_trabajo_plancha) }}"><i
                                                class="fa fa-eye"></i>Ver</a>
                                        @endif
                                    @endforeach

                                    @foreach ($BuscarOTPlanchaSeguimiento as $BuscarOTPlanchaSeguimientos)
                                        @if(($BuscarOTPlanchaSeguimientos->id_orden_trabajo_plancha != null) && $OrdenesConaps->estatus == 'FINALIZADO' || $OrdenesConaps->estatus == 'EN PROCESO')
                                        <a class="dropdown-item" target="_blank"
                                            href=" {{ route('cencseguimientopdf', $OrdenesConaps->id_orden_trabajo_plancha) }}"><i
                                                class="fa fa-print"></i>Imprimir</a>
                                        @endif
                                    @endforeach

                                        @if($OrdenesConaps->estatus == 'POR ACEPTAR' || $OrdenesConaps->estatus == 'EN PROCESO')
                                        <a class="dropdown-item" target="_blank"
                                            href="{{ route('cencseguimiento.create', ['IdOrdenTrabajoPlancha' => $OrdenesConaps->id_orden_trabajo_plancha]) }}"><i
                                                class="fa fa-pencil"></i>Registrar</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <div class="card">
            <div class="card-block" name="card_observaciones" id="card_observaciones">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Observaciones</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3"
                        class="form-control @error('observaciones_ot') is-invalid @enderror"
                        name="observaciones_ot" id="observaciones_ot"
                        placeholder="">{{$OrdenTrabajo->observaciones}}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="datos_orden_trabajo" id="datos_orden_trabajo">
        <div class="d-grid gap-2 d-md-block float-right">
            <button type="button" value="Enviar" id="enviar" class="btn btn-primary" OnClick="CapturarDatosOT()">
                <i class="fa fa-save"></i>Guardar
            </button>
        </div>
</div>
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
<script src="{{ asset('libraries\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}">
</script>
<script src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
</script>

<!-- Custom js -->
<script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>

<!-- sweet alert js -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>

<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<script type="text/javascript" src="{{ asset('libraries\assets\js\CencOrdenTrabajo.js') }} "></script>

@endsection