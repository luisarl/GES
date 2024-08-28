@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte Productividad de Compradores')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Reporte Productividad de Compradores</a> </li>
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
            {{-- @csrf --}}
            <div class="form-group row">
                <label class="col-sm-12 col-md-1 form-label">Fecha Inicio</label>
                <div class="col-sm-12 col-md-2 ">
                    <input type="date" name="fecha_inicio" min="" id=""
                        class="form-control @error('fecha_inicio') is-invalid @enderror"
                        value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '') }}">
                </div>
                <label class="col-sm-12 col-md-1 form-label">Fecha Fin</label>
                <div class="col-sm-12 col-md-2 ">
                    <input type="date" name="fecha_fin" min="" id=""
                        class="form-control @error('fecha_fin') is-invalid @enderror"
                        value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '')  }}">
                </div>
                <label class="col-sm-12 col-md-1 form-label">Comprador</label>
                <div class="col-sm-12 col-md-2 ">
                    <select name="comprador" class="form-control @error('comprador') is-invalid @enderror">
                        <option value="TODOS">TODOS </option>  
                        @foreach($compradores as $comprador)
                            <option value="{{trim($comprador->nombre_comprador)}}" @if (trim($comprador->nombre_comprador) == old('comprador' , $_GET['comprador']?? '' ))
                                selected="selected" @endif >{{$comprador->nombre_comprador}}
                            </option>  
                        @endforeach
                    </select>
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
                <div class="col-auto">
                    <input type="submit" value="Excel" name="excel" class="btn btn-primary mt-1 mb-1" OnClick="">
                        {{-- <i class="fa fa-file-excel-o"></i>Exportar
                    </input> --}}
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-xl-6 col-lg-12 ">
        <div class="card">
            <div class="card-header">
                <h4 class="sub-title"><strong>Productividad de comprador Año Actual</strong></h4>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">  
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>COMPRADOR</th>
                                        <th>SOLP</th>
                                        <th>OC</th>
                                        <th>NDR</th>
                                        <th>%(NDR/SOLP)</th>
                                        <th>%(OC/SOLP)</th>
                                        <th>%(NDR/OC)</th>
                                    </tr>
                                </thead>
                                <tbody class="text-right">
                                    @foreach($ProductividadAnual as $comprador)
                                    <tr>
                                        <td>{{$comprador->Comprador}}</td>
                                        <td>{{$comprador->CantSolP}}</td>
                                        <td>{{$comprador->CantOC}}</td>
                                        <td>{{$comprador->CantNDR}}</td>
                                        @if($comprador->CantSolP != 0)
                                            <td>{{number_format(($comprador->CantNDR / $comprador->CantSolP) * 100, 2, ',')}}</td>
                                        @else
                                            <td>0</td>
                                        @endif
        
                                        @if($comprador->CantSolP != 0)
                                            <td>{{number_format(($comprador->CantOC / $comprador->CantSolP) * 100, 2, ',')}}</td>
                                        @else
                                            <td>0</td>
                                        @endif
        
                                        @if($comprador->CantOC != 0)
                                            <td>{{number_format(($comprador->CantNDR / $comprador->CantOC) * 100, 2, ',')}}</td>
                                        @else
                                            <td>0</td>
                                        @endif
        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @if($productividad)
                            <div id="grafico_productividad_anual" style="width: 100%; height: 500px;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-12 ">
        <div class="card">
            <div class="card-header">
                <h4 class="sub-title"><strong>Productividad de comprador Periodo Seleccionado</strong></h4>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">  
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>COMPRADOR</th>
                                        <th>SOLP</th>
                                        <th>OC</th>
                                        <th>NDR</th>
                                        <th>%(NDR/SOLP)</th>
                                        <th>%(OC/SOLP)</th>
                                        <th>%(NDR/OC)</th>
                                    </tr>
                                </thead>
                                <tbody class="text-right">
                                    @foreach($productividad as $comprador)
                                    <tr>
                                        <td>{{$comprador->Comprador}}</td>
                                        <td>{{$comprador->CantSolP}}</td>
                                        <td>{{$comprador->CantOC}}</td>
                                        <td>{{$comprador->CantNDR}}</td>
                                        @if($comprador->CantSolP != 0)
                                            <td>{{number_format(($comprador->CantNDR / $comprador->CantSolP) * 100, 2, ',')}}</td>
                                        @else
                                            <td>0</td>
                                        @endif
        
                                        @if($comprador->CantSolP != 0)
                                            <td>{{number_format(($comprador->CantOC / $comprador->CantSolP) * 100, 2, ',')}}</td>
                                        @else
                                            <td>0</td>
                                        @endif
        
                                        @if($comprador->CantOC != 0)
                                            <td>{{number_format(($comprador->CantNDR / $comprador->CantOC) * 100, 2, ',')}}</td>
                                        @else
                                            <td>0</td>
                                        @endif
        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @if($productividad)
                            <div id="grafico_productividad" style="width: 100%; height: 500px;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-12 ">
        <div class="card">
            <div class="card-header">
                <h4 class="sub-title"><strong>Efectividad de SolP</strong></h4>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>COMPRADOR</th>
                                        <th>SIN PROCESAR</th>
                                        <th>PARCIAL</th>
                                        <th>PROCESADA</th>
                                        <th>TOTAL</th>
                                        <th>% EFECTIVIDAD</th>
                                    </tr>
                                </thead>
                                <tbody class="text-right">
                                    @foreach($productividad1 as $comprador)
                                    <tr>
                                        <td>{{$comprador->Comprador}}</td>
                                        <td>{{$comprador->SinProcesar}}</td>
                                        <td>{{$comprador->Parcial}}</td>
                                        <td>{{$comprador->Procesada}}</td>
                                        <td>{{$comprador->Total}}</td>
                                        @if($comprador->Procesada != 0)
                                            <td>{{number_format(($comprador->Procesada / $comprador->Total) * 100, 2, ',')}}</td>
                                        @else
                                            <td>0</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @if($productividad1)
                            <div id="grafico_productividad1" style="width: 100%; height: 500px;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12 ">
        <div class="card">
            <div class="card-header">
                <h4 class="sub-title"><strong>Efectividad de OC</strong></h4>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>COMPRADOR</th>
                                        <th>SIN PROCESAR</th>
                                        <th>PARCIAL</th>
                                        <th>PROCESADA</th>
                                        <th>TOTAL</th>
                                        <th>% EFECTIVIDAD</th>
                                    </tr>
                                </thead>
                                <tbody class="text-right">
                                    @foreach($productividad2 as $comprador)
                                    <tr>
                                        <td>{{$comprador->Comprador}}</td>
                                        <td>{{$comprador->SinProcesar}}</td>
                                        <td>{{$comprador->Parcial}}</td>
                                        <td>{{$comprador->Procesada}}</td>
                                        <td>{{$comprador->Total}}</td>
                                        @if($comprador->Procesada != 0)
                                            <td>{{number_format(($comprador->Procesada / $comprador->Total) * 100, 2, ',')}}</td>
                                        @else
                                            <td>0</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @if($productividad2)
                            <div id="grafico_productividad2" style="width: 100%; height: 500px;"></div>        
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-12 ">
        <div class="card">
            <div class="card-header">
                <h4 class="sub-title"><strong>Satisfaccion de Contraloria</strong></h4>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>COMPRADOR</th>
                                        <th>POSITIVA</th>
                                        <th>NEGATIVA</th>
                                        <th>TOTAL</th>
                                        <th>% SATISFACCION</th>
                                    </tr>
                                </thead>
                                <tbody class="text-right">
                                    @foreach($productividad3 as $comprador)
                                    <tr>
                                        <td>{{$comprador->Comprador}}</td>
                                        <td>{{$comprador->Positiva}}</td>
                                        <td>{{$comprador->Negativa}}</td>
                                        <td>{{$comprador->Total}}</td>
                                        @if($comprador->Positiva != 0)
                                            <td>{{number_format(($comprador->Positiva / $comprador->Total) * 100, 2, ',')}}</td>
                                        @else
                                            <td>0</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @if($productividad1)
                            <div id="grafico_productividad3" style="width: 100%; height: 500px;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12 ">
        
    </div>
</div>
@endsection

@section('scripts')
<!-- google chart -->
<script src="{{ asset('libraries\assets\pages\chart\google\js\google-loader.js') }}"></script>

<!-- personalizado -->
<script src="{{ asset('libraries\assets\js\CompReportes.js') }}"></script>

<script>
    var productividadanual = {!! json_encode($ProductividadAnual) !!};
    var productividad = {!! json_encode($productividad) !!};
    var productividad1 = {!! json_encode($productividad1) !!};
    var productividad2 = {!! json_encode($productividad2) !!};
    var productividad3 = {!! json_encode($productividad3) !!};
</script>

@endsection