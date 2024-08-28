@extends('layouts.master')

@section('titulo', 'Lista Partes')

@section('titulo_pagina', 'Lista de Partes')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cenclistapartes.index') }}">Lista de Partes</a>
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


 @foreach ($tipos as $tipo)

    @if ($tipo->tipo_lista === 'PLANCHAS')
    @php
        $TotalPiezas = 0;
        $TotalPeso = 0;
        $MetrosPerf = 0;
        $TotalMetros = 0;
    @endphp

<div class="form-group row">
    <div class="col-8">
        <div class="card">
            <div class="card-block">

                <span class="title m-r-10 m-b-15 h6 ">
                    <strong>Estatus: </strong></span>

                @if($tipo->estatus == 'ACTIVADO')
                <label class="label label-success">{{$tipo->estatus}}</label>
                @elseif($tipo->estatus == 'ANULADO')
                <label class="label label-danger">{{$tipo->estatus}}</label>
                @elseif($tipo->estatus == 'FINALIZADO')
                <label class="label label-success">{{$tipo->estatus}}</label>
                @endif

                <a href="{{ route('cenclistapartes.edit', $tipo->id_lista_parte) }}" target="_blank" type="button"
                    class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                    <i class="fa fa-edit"></i> Editar</a>
                <hr>

                <table class="table table-borderless table-responsive table-xs">
                    <tbody>
                        <tr>
                            <th>ID LISTA DE PARTE:</th>
                            <td>{{$tipo->id_lista_parte}}</td>
                        </tr>
                        <tr>
                            <th>TIPO:</th>
                            <td>{{$tipo->tipo_lista}}</td>
                        </tr>
                        <tr>
                            <th>NRO. CONAP:</th>
                            <td>{{$tipo->nro_conap}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<div class="col-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-header-text"><i class="fa fa-users m-r-10"></i>Responsables</h5>
        </div>
        <div class="card-block task-details table-responsive dt-responsive">
            <table class="table table-border table-xs">
                <tbody>
                    <tr>
                        <td><i class="fa fa-calendar-plus-o m-r-5"></i></i> Fecha creado:</td>
                        <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($tipo->fecha_creado))}}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-user m-r-5"></i></i> Creado por:</td>
                        <td class="text-right">{{ $tipo->name}}</td>
                    </tr>
                    @if($tipo->fecha_anulado != NULL)
                        <tr>
                            <td><i class="fa fa-calendar m-r-5"></i> Anulado: </td>
                            <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($UsuarioListaParteAnulado->fecha_anulado))}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-user m-r-5"></i></i> Anulado por:</td>
                            <td class="text-right">{{ $UsuarioListaParteAnulado->name}}</td>
                        </tr>
                    @endif
                    @if($tipo->fecha_finalizado != NULL)
                        <tr>
                            <td><i class="fa fa-calendar m-r-5"></i> Finalizado: </td>
                            <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($UsuarioListaParteFinalizado->fecha_finalizado))}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-user m-r-5"></i></i> Finalizado por:</td>
                            <td class="text-right">{{ $UsuarioListaParteFinalizado->name}}</td>
                        </tr>
                    @endif 
                </tbody> 
            </table>
        </div>
    </div>
</div>
</div>



<div class="page-body">
    <div class="row">

        <div class="col-xl-12 col-lg-12 ">

        <div class="card">
            <div class="card-block">
                <div class="">
                    <div class="m-b-20">
                        <h6 class="sub-title m-b-15"><i class="fa fa-comments-o m-r-5"> </i>Observaciones</h6>
                        <p>
                            {{$tipo->observaciones}}
                        </p>
    
                    </div>
                </div>
            </div>
        </div>

                <div id="CardListaParteResumen">
                    <div class="card">
                        <div class="card-block"> 
                            <span class="title m-r-10 m-b-15 h6 "><i class="icofont icofont-tasks-alt m-r-5"></i> 
                                 <strong> RESUMEN DE LISTA DE PARTES</strong></span>
                                 <a href="{{ route('listapartesresumenpdf', $tipo->id_lista_parte) }}" target="_blank" type="button"
                                 class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                                 <i class="fa fa-print"></i> Imprimir</a>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                     <th class="bg-primary">RESUMEN</th>
                                    <tbody>
                                        <tr> 
                                            <th class="bg-inverse">Espesores (mm)</th>
                                            @foreach ($SumListaPla as $SumListaPlas)
                                                <th class="bg-primary text-center">
                                                    {{$espesor = number_format($SumListaPlas->espesor, 2, '.', '')}}
                                                </th>
                                                @php
                                                    $arrayespesores[]=$SumListaPlas->espesor;
                                                    $iteracion_espesores= count($arrayespesores);
                                                @endphp
                                            @endforeach
                                            <th class="background-primary text-center">TOTALES</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-inverse">Cant. de Piezas (und)</th>
                                            @foreach ($SumListaPla as $SumListaPlas)
                                            <th class="text-center">{{$SumListaPlas->resumen_cant}}</th>
                                                @php
                                                    $TotalPiezas = $TotalPiezas + $SumListaPlas->resumen_cant;
                                                @endphp
                                            @endforeach
                                            <th class="background-primary text-center">{{$TotalPiezas}}</th>
                                        </tr>
                                        </tr>
                                        <tr>
                                            <th class="bg-inverse">Peso (Kg)</th>
                                            @foreach ($SumListaPla as $SumListaPlas)
                                                @php
                                                    $peso=number_format($SumListaPlas->resumen_peso, 2, '.', '');
                                                    $TotalPeso = $TotalPeso + $peso;
                                                @endphp 
                                                <th class="text-center">{{$peso}}</th>
                                            @endforeach
                                            <th class="background-primary text-center">{{$TotalPeso}}</th>
                                        </tr>
                                        <tr>
                                            <th class="background-primary text-center">DIÁMETRO DE PERFORACIONES (mm)</th>
                                            <th colspan="{{$iteracion_espesores+1}}" class="background-primary text-center">CANTIDAD DE PERFORACIONES (und)</th>
                                        </tr>
                                        @for ($i=0; $i < $iteracion_espesores; $i++) 
                                            @php
                                                $TotalCantPerf = 0;
                                                $Totales = 0;
                                            @endphp
                                        @endfor
                                            <tr> 
                                            @foreach ($CantPerfPla as $CantPerfPlas)
                                                @foreach ($CantPerfPlas as $valors)
                                                @if ($valors != NULL)
                                                <td class="text-center">
                                                    @if($loop->iteration > 1)
                                                        {{$valors}}
                                                    @else
                                                        {{$valor=number_format($valors, 0, '.', '')}}
                                                    @endif
                                                </td>
                                            @else
                                                <td class="text-center"> 0 </td>
                                            @endif
                                                    @if($loop->iteration > 1)
                                                        @php($TotalCantPerf += $valors)
                                                    @endif
                                                @endforeach
                                                <td class="background-primary text-center">{{$TotalCantPerf}}</td>
                                                  @php($TotalCantPerf = 0)
                                            </tr>
                                            @endforeach
                                            <th class="background-primary text-center">TOTAL</th>
                                            @foreach ($SumPerfPla as $SumPerfPlas)
                                                <td class="background-primary text-center"> {{$SumPerfPlas}}</td>
                                                @php($Totales += $SumPerfPlas)
                                            @endforeach
                                            <td class="background-primary text-center">{{$Totales}}</td>
                                            <tr> 
                                                <th colspan="{{$iteracion_espesores+2}}" ></th>
                                            </tr>
                                            <tr>
                                                <th class="background-primary text-center">DIÁMETRO DE PERFORACIONES (mm)</th>
                                                <th colspan="{{$iteracion_espesores+1}}" class="background-primary text-center">METROS DE PERFORACIÓN (m)</th>
                                            </tr>
                                            @for ($i=0; $i < $iteracion_espesores; $i++)
                                                @php ($TotalMetrosPerf = 0)
                                                @php ($TotalesMetros = 0)
                                                @php ($Conversion = 0)
                                            @endfor
                                                <tr> 
                                                    @foreach ($MetrosPerfPla as $MetrosPerfPlas)
                                                        @foreach ($MetrosPerfPlas as $valors)
                                                            @if ($valors != NULL)
                                                                <td class="text-center">
                                                                    @if($loop->iteration > 1)
                                                                        {{$valor=number_format($valors, 2, '.', '')}}
                                                                    @else
                                                                        {{$valor=number_format($valors, 0, '.', '')}}
                                                                    @endif
                                                                </td>
                                                            @else
                                                                <td class="text-center"> 0 </td>
                                                            @endif
                                                            @if($loop->iteration > 1)
                                                                @php($TotalMetrosPerf += $valors)
                                                            @endif
                                                        @endforeach
                                                        <td class="background-primary text-center">
                                                            {{$SumaMetrosPerf=number_format($TotalMetrosPerf, 2, '.', '')}}
                                                        </td>
                                                        @php($TotalMetrosPerf = 0)
                                                </tr>
                                                    @endforeach
                                                <th class="background-primary text-center">TOTAL</th>
                                                @foreach ($TotalMetrosPerfPla as $TotalMetrosPerfPlas)
                                                    <td class="background-primary text-center">
                                                        {{$TotalMP=number_format($TotalMetrosPerfPlas, 2, '.', '')}}
                                                    </td>
                                                    @php($TotalesMetros += $TotalMetrosPerfPlas)
                                                @endforeach
                                            <td class="background-primary text-center">
                                                {{$TotalesMetrosP=number_format($TotalesMetros, 2, '.', '')}}
                                            </td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="CardListaParteDetallada">
                    <div class="card">
                        <div class="card-block"> 
                            <span class="title m-r-10 m-b-15 h6 "><i class="icofont icofont-tasks-alt m-r-5"></i> 
                                <strong> DETALLE DE LISTA DE PARTES</strong></span>
                                 <a href="{{ route('listapartesdetallepdf', $tipo->id_lista_parte) }}" target="_blank" type="button"
                                class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                                <i class="fa fa-print"></i> Imprimir</a>
                            <hr>
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tablaplacp">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th style="width: 5%">Nro. Parte</th>
                                            <th style="width: 5%">Prioridad</th>
                                            <th style="width: 10%">Descripción</th>
                                            <th style="width: 15%">Dimensiones (MM)</th>
                                            <th style="width: 10%">Espesor (MM)</th>
                                            <th style="width: 10%">Cant. Piezas (UND)</th>
                                            <th style="width: 10%">Peso Unit (KG)</th>   
                                            <th style="width: 5%">Peso Total (KG)</th>
                                            <th style="width: 5%">Diámetro (M)</th>
                                            <th style="width: 5%">Cant. Perf (UND)</th>
                                            <th style="width: 5%">Cant. Total Perf (UND)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($DetalleListaPartePlancha as $DetalleListaPartes)
    
                                        <tr>
                                            <th style="width: 5%">{{$DetalleListaPartes->nro_partes}}</th>
                                            <th style="width: 5%">{{$DetalleListaPartes->prioridad}}</th>
                                            <th style="width: 10%">{{$DetalleListaPartes->descripcion}}</th>
                                            <th style="width: 15%">{{$DetalleListaPartes->dimensiones}}</th>
                                            <th style="width: 10%">{{number_format($DetalleListaPartes->espesor, 2, '.', '')}}</th>
                                            <th style="width: 10%">{{$DetalleListaPartes->cantidad_piezas}}</th>
                                            <th style="width: 10%">{{number_format($DetalleListaPartes->peso_unit, 3, '.', '')}}</th>   
                                            <th style="width: 5%">{{number_format($DetalleListaPartes->peso_total, 3, '.', '')}}</th>
                                            <th style="width: 5%">{{number_format($DetalleListaPartes->diametro_perforacion, 2, '.', '')}}</th>
                                            <th style="width: 5%">{{$DetalleListaPartes->cantidad_perforacion}}</th>
                                            <th style="width: 5%">{{$DetalleListaPartes->cantidad_total}}</th>
                                        </tr>
                                        @endforeach
    
                                    </tbody>
                                </table>
                            </div>
    
                        </div>
                    </div>
                </div>

            </div>
            @else

            @php ($TotalPiezas = 0)
            @php ($TotalPeso = 0)
            @php ($MetrosPerf = 0)
            @php ($TotalMetros = 0)


        
<div class="form-group row">
    <div class="col-8">
        <div class="card">
            <div class="card-block">

                <span class="title m-r-10 m-b-15 h6 "><i class="icofont icofont-tasks-alt m-r-5"></i>
                    <strong>Estatus: </strong></span>

                @if($tipo->estatus == 'ACTIVADO')
                <label class="label label-success">{{$tipo->estatus}}</label>
                @elseif($tipo->estatus == 'ANULADO')
                <label class="label label-danger">{{$tipo->estatus}}</label>
                @elseif($tipo->estatus == 'FINALIZADO')
                <label class="label label-success">{{$tipo->estatus}}</label>
                @endif

                <a href="{{ route('cenclistapartes.edit', $tipo->id_lista_parte) }}" target="_blank" type="button"
                    class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                    <i class="fa fa-edit"></i> Editar</a>
                <hr>

                <table class="table table-borderless table-responsive table-xs">
                    <tbody>
                        <tr>
                            <th>ID LISTA DE PARTE:</th>
                            <td>{{$tipo->id_lista_parte}}</td>
                        </tr>
                        <tr>
                            <th>TIPO:</th>
                            <td>{{$tipo->tipo_lista}}</td>
                        </tr>
                        <tr>
                            <th>NRO. CONAP:</th>
                            <td>{{$tipo->nro_conap}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<div class="col-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-header-text"><i class="fa fa-users m-r-10"></i>Responsables</h5>
        </div>
        <div class="card-block task-details table-responsive dt-responsive">
            <table class="table table-border table-xs">
                <tbody>
                    <tr>
                        <td><i class="fa fa-calendar-plus-o m-r-5"></i></i> Fecha creado:</td>
                        <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($tipo->fecha_creado))}}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-user m-r-5"></i></i> Creado por:</td>
                        <td class="text-right">{{ $tipo->name}}</td>
                    </tr>
                    @if($tipo->fecha_anulado != NULL)
                        <tr>
                            <td><i class="fa fa-calendar m-r-5"></i> Anulado: </td>
                            <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($UsuarioListaParteAnulado->fecha_anulado))}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-user m-r-5"></i></i> Anulado por:</td>
                            <td class="text-right">{{ $UsuarioListaParteAnulado->name}}</td>
                        </tr>
                    @endif
                    @if($tipo->fecha_finalizado != NULL)
                        <tr>
                            <td><i class="fa fa-calendar m-r-5"></i> Finalizado: </td>
                            <td class="text-right">{{date('d-m-Y g:i:s A', strtotime($UsuarioListaParteFinalizado->fecha_finalizado))}}</td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-user m-r-5"></i></i> Finalizado por:</td>
                            <td class="text-right">{{ $UsuarioListaParteFinalizado->name}}</td>
                        </tr>
                    @endif  
                </tbody> 
            </table>
        </div>
    </div>
</div> 
</div>    


<div class="page-body">
    <div class="row">

        <div class="col-xl-12 col-lg-12 ">

        <div class="card">
            <div class="card-block">
                <div class="">
                    <div class="m-b-20">
                        <h6 class="sub-title m-b-15"><i class="fa fa-comments-o m-r-5"> </i>Observaciones</h6>
                        <p>
                            {{$tipo->observaciones}}
                        </p>
    
                    </div>
                </div>
            </div>
        </div>

  
            <div id="CardListaParteResumenPerfil">
                    <div class="card">
                        <div class="card-block">
                            <span class="title m-r-10 m-b-15 h6 "><i class="icofont icofont-tasks-alt m-r-5"></i> 
                                <strong> RESUMEN DE LISTA DE PARTES</strong></span>
                                <a href="{{ route('listapartesresumenpdf', $tipo->id_lista_parte) }}" target="_blank" type="button"
                                class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                                <i class="fa fa-print"></i> Imprimir</a>
                            <hr>
                       
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="background-primary">
                                            <td>RESUMEN</td>
                                    </thead>
                                    <tbody>
                                        <tr> 
                                            <th class="bg-inverse">Perfiles</th>
                                            @foreach ($SumListaPer as $SumListaPers)
                                                <th class="bg-primary text-center">{{$SumListaPers->nombre_ficha}}</th>
                                                @php ($arrayFichas[]=$SumListaPers->nombre_ficha)
                                                @php ($iteracion_fichas= count($arrayFichas))
                                            @endforeach
                                            <th class="background-primary text-center">TOTALES</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-inverse">Cant. de Piezas (und)</th>
                                            @foreach ($SumListaPer as $SumListaPers)
                                            <th class="text-center">{{$SumListaPers->resumen_cant}}</th>
                                                @php ($TotalPiezas = $TotalPiezas + $SumListaPers->resumen_cant)
                                            @endforeach                                       
                                            <th class="background-primary text-center">{{$TotalPiezas}}</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-inverse">Peso (Kg)</th>
                                            @foreach ($SumListaPer as $SumListaPers)
                                                @php ($peso=number_format($SumListaPers->resumen_peso, 2, '.', ''))
                                                @php ($TotalPeso = $TotalPeso + $peso)
                                                <th class="text-center">{{$peso}}</th>
                                            @endforeach
                                            <th class="background-primary text-center">{{$TotalPeso}}</th>
                                        </tr>
                                        <tr>
                                            <th class="background-primary text-center">DIÁMETRO DE PERFORACIONES (mm)</th>
                                            <th colspan="{{$iteracion_fichas+1}}" class="background-primary text-center">CANTIDAD DE PERFORACIONES (und)</th>
                                        </tr>
                                        @for ($i=0; $i < $iteracion_fichas; $i++)
                                            @php ($TotalCantPerf = 0)
                                            @php ($Totales = 0)
                                        @endfor
                                        <tr>
                                        @foreach ($CantPerfPer as $CantPerfPers)
                                            @foreach ($CantPerfPers as $valors)
                                            @if ($valors != NULL)
                                            <td class="text-center">
                                                @if($loop->iteration > 1)
                                                    {{$valors}}
                                                @else
                                                    {{$valor=number_format($valors, 0, '.', '')}}
                                                @endif
                                            </td>
                                        @else
                                            <td class="text-center"> 0 </td>
                                        @endif
                                                @if($loop->iteration > 1)
                                                    @php($TotalCantPerf += $valors)
                                                @endif
                                            @endforeach
                                            <td class="background-primary text-center">{{$TotalCantPerf}}</td>
                                              @php($TotalCantPerf = 0)
                                        </tr>
                                        @endforeach
                                        <th class="background-primary text-center">TOTAL</th>
                                            @foreach ($SumPerfPer as $SumPerfPers)
                                                <td class="background-primary text-center"> {{$SumPerfPers}}</td>
                                                @php($Totales += $SumPerfPers)
                                            @endforeach
                                            <td class="background-primary text-center">{{$Totales}}</td>
                                            <tr> 
                                                <th colspan="{{$iteracion_fichas+2}}" ></th>
                                            </tr>
                                            <tr>
                                                <th class="background-primary text-center">DIÁMETRO DE PERFORACIONES (mm)</th>
                                                <th colspan="{{$iteracion_fichas+1}}" class="background-primary text-center">METROS DE PERFORACIÓN (m)</th>
                                            </tr>
                                            @for ($i=0; $i < $iteracion_fichas; $i++)
                                                @php ($TotalMetrosPerf = 0)
                                                @php ($TotalesMetros = 0)
                                                @php ($TotalMetrosAla = 0)
                                                @php ($TotalMetrosAlma = 0)
                                                @php ($SumaMetros = 0)
                                                @php ($SumaMetrosTotal = 0)
                                                @php ($AcumTotal = 0)
                                                @php ($Totales = array_map(function () {return 0;}, array_values((array)$MetrosPerfPer[0])))
                                            @endfor
                                                <tr> 
                                                    @foreach ($MetrosPerfPer as $MetrosPerfPers)
                                                        @foreach ($MetrosPerfPers as $valors)
                                                            @if ($valors != NULL)
                                                            <td class="text-center">
                                                                @if($loop->iteration > 1)
                                                                    {{-- Busca el Ala y Alma segun el diametro --}}
                                                                    @php ($BuscarAPerfil = App\Models\Cenc_ListaPartesModel::BuscarAlayAlmaListaPartesPerfiles($tipo->id_lista_parte,$valor))
                                                                    @php ($BuscarAPerfils = (array)$BuscarAPerfil)
                                                                       @foreach ($BuscarAPerfil as $BuscarAPerfils)
                                                                            @if ($BuscarAPerfils->t_ala != 0)
                                                                                {{$MetrosAla = number_format(($valors * $ala * 0.001),2, '.', '')}}
                                                                                @php ($TotalMetrosAla += $MetrosAla)
                                                                            @elseif($BuscarAPerfils->s_alma != 0)
                                                                                {{$MetrosAlma = number_format(($valors * $alma * 0.001),2, '.', '')}}
                                                                                @php ($TotalMetrosAlma += $MetrosAlma)
                                                                            @endif
                                                                        @endforeach
                                                                        @php ($SumaMetrosTotal = $TotalMetrosAla + $TotalMetrosAlma)
                                                                        @php ($Totales[$loop->index] += $SumaMetrosTotal)
                                                                        @php ($AcumTotal += $SumaMetrosTotal)
                                                                @else
                                                                    {{$valor=number_format($valors, 0, '.', '')}}
                                                                @endif
                                                            </td>
                                                            @else
                                                                <td class="text-center"> 0 </td>
                                                            @endif
                                                            @if($loop->iteration > 1)
                                                                 @php($TotalMetrosPerf = $TotalMetrosAla + $TotalMetrosAlma)
                                                            @endif
                                                        @endforeach
                                                        <td class="background-primary text-center">
                                                            {{$SumaMetrosPerf=number_format($TotalMetrosPerf, 2, '.', '')}}
                                                        </td>
                                                        @php($TotalMetrosPerf = 0)
                                                        @php($TotalMetrosAla = 0)
                                                        @php($TotalMetrosAlma = 0)
                                                </tr>
                                                    @endforeach
                                                <th class="background-primary text-center">TOTAL</th>
                                                @foreach (array_slice($Totales, 1) as $TotalItem)
                                                    <td class="background-primary text-center">
                                                        {{$TotalMP = number_format($TotalItem, 2, '.', '')}}
                                                    </td>
                                                @endforeach
                                            <td class="background-primary text-center">
                                                {{$TotalesMetrosP = number_format($AcumTotal, 2, '.', '')}}
                                            </td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="CardListaParteDetalladaPerfil">
                    <div class="card">
                        <div class="card-block"> 
                            <span class="title m-r-10 m-b-15 h6 "><i class="icofont icofont-tasks-alt m-r-5"></i> 
                                <strong> DETALLE DE LISTA DE PARTES</strong></span>
                                 <a href="{{ route('listapartesdetallepdf', $tipo->id_lista_parte) }}" target="_blank" type="button"
                                class="btn btn-primary btn-sm float-right m-l-10" title="Imprimir">
                                <i class="fa fa-print"></i> Imprimir</a>
                            <hr>
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tablaplacp">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th style="width: 5%">Nro. Parte</th>
                                            <th style="width: 5%">Prioridad</th>
                                            <th style="width: 5%">Tipo</th>
                                            <th style="width: 10%">Cant. Piezas (und)</th>
                                            <th style="width: 5%">Long. Pieza (mm)</th>
                                            <th style="width: 5%">Tipo corte</th>
                                            <th style="width: 5%">Diámetro (mm)</th>
                                            <th style="width: 5%">Ala (T)(mm)</th>
                                            <th style="width: 5%">Alma (S)(mm)</th>
                                            <th style="width: 5%">Cant. Total Perf (und)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($DetalleListaPartePerfil as $DetalleListaPartes)
    
                                        <tr>
                                            <th style="width: 5%">{{$DetalleListaPartes->nro_partes}}</th>
                                            <th style="width: 5%">{{$DetalleListaPartes->prioridad}}</th>
                                            <th style="width: 10%">{{$DetalleListaPartes->nombre_ficha}}</th>
                                            <th style="width: 15%">{{$DetalleListaPartes->cantidad_piezas}}</th>
                                            <th style="width: 10%">{{$DetalleListaPartes->longitud_pieza}}</th>
                                            <th style="width: 10%">{{$DetalleListaPartes->tipo_corte}}</th>
                                            <th style="width: 10%">{{$DetalleListaPartes->diametro_perforacion}}</th>   
                                            <th style="width: 5%">{{$DetalleListaPartes->t_ala}}</th>
                                            <th style="width: 5%">{{$DetalleListaPartes->s_alma}}</th>
                                            <th style="width: 5%">{{$DetalleListaPartes->cantidad_total}}</th>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
    
                        </div>
                    </div>
                </div>


            @endif
            @endforeach 

        </div> 
    </div>
</div>
@endsection