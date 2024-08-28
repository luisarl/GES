@extends('layouts.master')

@section('titulo', 'Compras')

@section('titulo_pagina', 'Actualizar Precios Ordenes de Compras')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Compras</a> </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Ordenes Compras</a></li>
    <li class="breadcrumb-item"><a href="#!">Actualizar Precios</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
<div class="card">
    <div class="card-header">
        <h5>Consultar OC</h5>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-12">
                <form method="GET" action="">
                    <div class="form-group row">
                        <label for="codigo_articulo" class="block col-sm-2">Empresa </label>
                        <div class="col-sm-10">
                            <select name="id_empresa" id="id_empresa" class="form-control @error('id_empresa') is-invalid @enderror" required>
                                <option value="0">SELECCIONE LA EMPRESA</option>
                                    @foreach ($empresas as $empresa)
                                    <option value="{{$empresa->base_datos}}" @if ($empresa->base_datos == old('id_empresa', $_GET['id_empresa'] ?? '')) selected = "selected" @endif>
                                        {{$empresa->nombre_empresa}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="codigo_articulo" class="block col-sm-2">Numero oc</label>
                        <div class="col-sm-10">
                            <input type="number" min="0"
                                class="form-control  @error('numero') is-invalid @enderror"
                                name="numero" id='numero'
                                value="{{old('numero', $_GET['numero'] ?? '')}}"
                                placeholder="Ingrese El Numero De La OC" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="codigo_articulo" class="block col-sm-2"> </label>
                        <div class="col-sm-4">
                            <button type="submit" onclick="BuscarArticulo()" class="form-control btn btn-primary" id='buscar'>
                                <i class="fa fa-search"></i> BUSCAR
                            </button>
                        </div>
                    </div>
                   @if(isset($_GET['numero'])  && $articulos == null)
                        <div class="alert alert-danger background-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled text-white"></i>
                            </button>
                           
                            El Numero de OC no se encuentra registrado en la empresa seleccionada.
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@if($articulos != null)
<div class="card">
    <div class="card-header">
        <h5>Orden de Compra # {{$articulos[0]->numOC}}</h5>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Codigo Proveedor </label>
                    <div class="col-sm-2 col-md-2">
                        <input type="text" class="form-control" name="cod_proveedor" id="cod_proveedor"
                            value="{{old('cod_proveedor', $articulos[0]->co_cli ?? '')}}" readonly>
                    </div>
                    <label class="col-sm-2 col-form-label">Proveedor </label>
                    <div class="col-sm-6 col-md-6">
                        <input type="text" class="form-control" name="proveedor" id="proveedor"
                            value="{{old('proveedor', $articulos[0]->Proveedor ?? '')}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Motivo </label>
                    <div class="col-sm-10 col-md-10">
                        <input type="text" class="form-control" name="motivo" id="motivo"
                            value="{{old('motivo', $articulos[0]->motivo ?? '')}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Moneda </label>
                    <div class="col-sm-2 col-md-2">
                        <input type="text" class="form-control" name="moneda" id="moneda"
                            value="{{old('moneda', $articulos[0]->moneda ?? '')}}" readonly>
                    </div>
                    <label class="col-sm-2 col-form-label">Tasa </label>
                    <div class="col-sm-6 col-md-6">
                        <input type="text" class="form-control" name="tasa" id="tasa"
                            value="{{old('tasa', $articulos[0]->tasa ?? '')}}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="card">
        <div class="card-header">
            <h5>Articulo</h5>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-block table-border-style">
                        <form action="{{ route('compactualizarpreciosoc.store') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="articulos" id="articulos">
                            <input type="hidden" name="empresa" value="{{$_GET['id_empresa']}}">
                            <input type="hidden" name="orden" value="{{$_GET['numero']}}">
                            <input type="hidden" name="tasa" value="{{$articulos[0]->tasa}}">
                            @csrf 
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-striped" id="tabla_articulos">
                                    <thead>
                                        <tr>
                                            <th>NUM</th>
                                            <th>CODIGO</th>
                                            <th>NOMBRE</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO BS</th>
                                            <th>PRECIO USD</th>
                                            <th>TOTAL BS</th>
                                            <th>TOTAL USD</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($articulos as $articulo)
                                            <tr>
                                                <td id="reng_num">{{$articulo->reng_num}}</td>
                                                <td id="codigo_articulo">{{$articulo->codigo_articulo}}</td>
                                                <td id="nombre_articulo">{{$articulo->nombre_articulo}}</td>
                                                <td id="total_art">{{number_format($articulo->total_art, 2, '.', '')}}</td>
                                                <td id="prec_bs"> {{number_format($articulo->prec_vta, 4, '.', '')}}</td>
                                                <td id="prec_vta">
                                                    <input type="number" name="precio" value="{{number_format($articulo->prec_vta2, 4, '.', '')}}" class="form-control"> 
                                                </td>
                                                <td id="reng_neto">{{number_format($articulo->reng_neto, 4, '.', '')}}</td>
                                                <td id="">{{number_format($articulo->prec_vta2 * $articulo->total_art, 4, '.', '')}}</td>
                                            </tr>    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="d-grid gap-2 d-md-block float-right">
                                <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla()">
                                    <i class="fa fa-save"></i>Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif  

@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<script type="text/javascript" src=" {{ asset('libraries\bower_components\lightbox2\js\lightbox.min.js') }} "></script>

<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
</script>
<!--Personalizado -->


<script src="{{ asset('libraries\assets\js\CompActualizarPreciosOC.js') }}"></script>

@endsection