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
    <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
<div class="card">
    <div class="card-header">
        <h5>Consultar Articulo</h5>
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-md-12">
                <form method="GET" action="">
                    <div class="form-group row">
                        <label for="codigo_articulo" class="block col-sm-2">Codigo </label>
                        <div class="col-sm-10">
                            <input type="number" min="0"
                                class="form-control  @error('codigo_articulo') is-invalid @enderror"
                                name="codigo_articulo" id='codigo_articulo'
                                value="{{old('codigo_articulo', $_GET['codigo_articulo'] ?? '')}}"
                                placeholder="Ingrese El Codigo del Articulo" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="codigo_articulo" class="block col-sm-2">Almacenes </label>
                        <div class="col-sm-10">
                            <select name="id_almacen" id="id_almacen" class="form-control @error('id_almacen') is-invalid @enderror" required>
                                <option value="0">SELECCIONE EL ALMACEN</option>
                                    @foreach ($almacenes as $almacen)
                                    <option value="{{$almacen->id_almacen}}" @if ($almacen->id_almacen == old('id_almacen', $_GET['id_almacen'] ?? '')) selected = "selected" @endif>
                                        {{$almacen->nombre_almacen}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label for="codigo_articulo" class="block col-sm-2">Sub Almacenes </label>
                        <div class="col-sm-10">
                            <select name="id_subalmacen" id="id_subalmacen" data-old="{{ old('id_subalmacen', $_GET['id_subalmacen'] ?? '' )}}" class="form-control @error('id_subalmacen') is-invalid @enderror" required>
                                <option value="0">SELECCIONE EL SUBALMACEN</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label for="codigo_articulo" class="block col-sm-2"> </label>
                        <div class="col-sm-4">
                            <button type="submit" onclick="BuscarArticulo()" class="form-control btn btn-primary" id='buscar'>
                                <i class="fa fa-search"></i> BUSCAR
                            </button>
                        </div>
                    </div>
                    @if(isset($_GET['codigo_articulo']) && $articulos == '[]')
                        <div class="alert alert-danger background-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled text-white"></i>
                            </button>
                            {{-- <strong><i class="fa fa-exclamation-triangle"></i> Alerta!</strong> --}}
                            EL ARTICULO NO EXISTE EN EL ALMACEN SELECCIONADO
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@if(isset($_GET['codigo_articulo'])  && $articulos != '[]'  )
        <div class="card">
            <div class="card-header">
                <h5>Articulo</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-block table-border-style">
                            <form action="{{ route('audiauditoriainventario.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                {{-- CAMPO OCULTO CON EL ID DEL ARTICULO --}}
                                <input type="hidden" name="id_articulo" value="{{ $articulos[0]->id_articulo }}">
                                <input type="hidden" name="codigo_articulo" value="{{ $articulos[0]->codigo_articulo }}">
                                <input type="hidden" name="id_almacen" value="{{ $articulos[0]->id_almacen}}">

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Imagen</label>
                                        <div class="col-sm-10 col-md-10">
                                            <div class="thumbnail img-100">
                                                <div class="thumb">
                                                    <a href="{{ asset($articulos[0]->imagen_articulo ?? '') }} " data-lightbox="1"
                                                        data-title="{{ $articulos[0]->nombre_articulo ?? '' }}">
                                                        <img src="{{ asset($articulos[0]->imagen_articulo ?? '') }}" alt=""
                                                            class="img-fluid img-thumbnail">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10 col-md-10">
                                            <input type="text" class="form-control" name="nombre_articulo" id="nombre_articulo"
                                                value="{{old('nombre_articulo', $articulos[0]->nombre_articulo ?? '')}}" readonly>
                                        </div>
                                    </div>
                               
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Sub Almacenes</label>
                                        <div class="col-sm-10 col-md-10">
                                            <div class="table-responsive">
                                                <table id="tabla_subalmacenes" class="table table-sm table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr class="table-secondary">
                                                            <th style="display: none;">ID SUBALMACEN</th>
                                                            <th>NOMBRE</th>
                                                            <th>ZONA</th>
                                                            <th>UBICACION</th>
                                                            <th>STOCK ACTUAL</th>
                                                            <th>CONTEO</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($articulos as $articulo)
                                                            <tr>
                                                                <td id="id_subalmacen"  style="display: none;">{{$articulo->id_subalmacen}}</td>
                                                                <td id="nombre_subalmacen">{{$articulo->nombre_subalmacen}}</td>
                                                                <td>{{$articulo->nombre_ubicacion}}</td>
                                                                <td>{{$articulo->zona}}</td>
                                                                <td id="stock_actual">
                                                                @php( $stock = App\Models\Articulo_MigracionModel::StockArticuloAlmacenProfit($articulo->base_datos, $articulo->codigo_articulo, $articulo->codigo_subalmacen))
                                                                    @if($stock != null)
                                                                        {{ number_format($stock->stock_act, 2, '.', '') }}
                                                                    @else
                                                                        {{ number_format(0, 2, '.', '') }}
                                                                    @endif
                                                                </td>
                                                                <td id="conteo_fisico"> 
                                                                    <input type="number" name="conteo" id="conteo" min="0" class="form-control @error('conteo') is-invalid @enderror" value="{{old('conteo')}}">
                                                                </td>
                                                            </tr>    
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-sm-2">Numero Auditoria</label>
                                        <div class="col-sm-10 col-md-10">
                                            <input type="number" name="numero_auditoria" id="" class="form-control  @error('numero_auditoria') is-invalid @enderror" value="{{old('numero_auditoria')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2">Observacion</label>
                                        <div class="col-sm-10 col-md-10">
                                            <textarea name="observacion" id="observacion" class="form-control @error('observacion') is-invalid @enderror" cols="3" rows="3">{{old('observacion')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2">Fotografia </label>
                                        <div class="col-sm-10 col-md-10">
                                            <input type="file" name="fotografia" id="" class="form-control">
                                        </div>
                                    </div>
                                <hr>
                                <input type="hidden" name="subalmacenes" id="subalmacenes">
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

<script>
    var ImportarArticulo = '{{url('importararticulo')}}';
    var SubAlmacenes = '{{url('obtenersubalmacen')}}'
</script>
<script src="{{ asset('libraries\assets\js\AudiTomaFisica.js') }}"></script>

@endsection