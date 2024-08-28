@extends('layouts.master')

@section('titulo', 'Cierre')

@section('titulo_pagina', 'Cierre')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cenccierre.index') }}">Cierre</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Ver</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

<style>
    /* Estilos CSS para el acordeón */
    .card {
      cursor: pointer;
    }
    .card-content {
      display: none;
      transition: all 0.3s ease;
    }
    .card.open .card-content {
      display: block;
    }
    /* Estilos CSS para el acordeón */
    .card-header {
        display: flex;
        align-items: center;
    }
    .card-header-text {
        flex-grow: 1;
    }
    .card-header-toggle {
        margin-left: 10px;
        cursor: pointer;
    }    
</style>


<div class="card">
    <div class="card-block">
        Id Orden de Trabajo: {{$CierrePlancha->id_orden_trabajo}} | CONAP: {{$CierrePlancha->nro_conap}} | Id Aprovechamiento: {{$CierrePlancha->id_aprovechamiento}}

         <a href="{{ route('cenccierrepdf', $CierrePlancha->id_cierre) }}" 
        target="_blank" type="button"class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
        <i class="fa fa-print"></i>Imprimir</a>

    </div> 
</div>     

<div class="page-body">
    <div class="row">
        <div class="col-xl-12 col-lg-12 ">

            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title">CONSUMO DE GAS PROPANO Y OXIGENO</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="TablaConsumible">
                            <thead>
                                <tr class="background-primary">
                                    <th>GAS PROPANO</th>
                                    <th>OXIGENO</th>
                                </tr>
                                
                            </thead>

                            <tbody>
                                <tr>
                                    @if($CierrePlancha->consumo_gas == '')
                                        <td> 0 </td>
                                    @else
                                        <td>{{number_format($CierrePlancha->consumo_gas, 2, '.', '')}}</td>
                                    @endif

                                    @if($TotalLitrosGaseosos == '')
                                        <td> 0 </td>
                                    @else
                                        <td>{{number_format($TotalLitrosGaseosos, 2, '.', '')}}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  

            
            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title">CORTES</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="TablaCortes">
                            <thead>
                                <tr class="background-primary">
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>CNC Aprov</th>
                                    <th>Piezas Anidadas</th>
                                    <th>Piezas Cortadas</th>
                                    <th>Piezas Dañadas</th>
                                    <th>Longitud de Corte (MM)</th>
                                    <th>Nro. Perf</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($CierrePlanchaCortes as $CierrePlanchaCorte)
                                <tr>
                                    <td id='id_cortes'> {{$CierrePlanchaCorte->id_cierre_pl_cortes}}</td>
                                    <td id='fecha_creado_cortes'> {{$CierrePlanchaCorte->fecha_creado}}</td>
                                    <td id='cnc_aprovechamiento'> {{$CierrePlanchaCorte->cnc_aprovechamiento}}</td>
                                    <td class='piezas_anidadas' id='piezas_anidadas'> {{$CierrePlanchaCorte->piezas_anidadas}}</td>
                                    <td class='piezas_cortadas' id='piezas_cortadas'> {{$CierrePlanchaCorte->piezas_cortadas}}</td>
                                    <td class='piezas_danadas' id='piezas_danadas'> {{$CierrePlanchaCorte->piezas_danadas}}</td>
                                    <td class='longitud_corte' id='longitud_corte'> {{number_format($CierrePlanchaCorte->longitud_corte, 2, '.', '')}}</td>
                                    <td class='numero_perforaciones' id='numero_perforaciones'> {{$CierrePlanchaCorte->numero_perforaciones}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr class="background-primary">
                                    <th> </th>
                                    <th colspan="2">TOTAL</th>
                                    <th id="total_piezas_anidadas">{{$TotalAnidadas}}</th>
                                    <th id="total_piezas_cortadas">{{$TotalCortadas}}</th>
                                    <th id="total_piezas_danadas">{{$TotalDanadas}}</th>
                                    <th id="total_longitud_cortes">{{$TotalLongitudCorte}}</th>
                                    <th id="total_nro_perforacion">{{$TotalPerforaciones}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        
            <div class="card" id="materia_prima_sobrante">
                <div class="card-block">
                    <h4 class="sub-title">MATERIA PRIMA SOBRANTE</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="TablaMateriaPrimaSobrante">
                            <thead>
                                <tr class="background-primary">
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Referencia</th>
                                    <th>Cantidad</th>
                                    <th>Ubicación</th>
                                    <th>Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($CierrePlanchaSobrante as $CierrePlanchaSobrantes)
                                <tr>
                                    <td id='id_sobrante'>{{$CierrePlanchaSobrantes->id_cierre_pl_sobrante}}</td>
                                    <td id='fecha_creado_sobrante'> {{$CierrePlanchaSobrantes->fecha_creado}}</td>
                                    <td id='descripcion_sobrante'>{{$CierrePlanchaSobrantes->descripcion}}</td>
                                    <td id='referencia_sobrante'>{{$CierrePlanchaSobrantes->referencia}}</td>
                                    <td id='cantidad_sobrante'>{{$CierrePlanchaSobrantes->cantidad}}</td>
                                    <td id='ubicacion_sobrante'>{{$CierrePlanchaSobrantes->ubicacion}}</td>
                                    <td id='observacion_sobrante'>{{$CierrePlanchaSobrantes->observacion}}</td>
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

@endsection