@extends('layouts.master')

@section('titulo', 'Historial Articulos')

@section('titulo_pagina', 'Historial Articulos')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item"><a href="{{ url('/') }}"> <i class="feather icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}"></i>Reportes</a></li>
    <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Compras    </a> </li>
    <li class="breadcrumb-item"><a href="#!">Historial Articulos</a> </li>
</ul>
@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>PARAMETROS DE BUSQUEDA</strong></h4>
        <form method="GET" action="">
            <div class="form-group row">
                <div class="col-md-3 col-lg-3">
                    <label for="articulo" class="block" id="">Buscar Articulo</label>
                    <input type="text" class="form-control" name="articulo" id="articulo" placeholder="Ingrese Codigo o Nombre">
                </div>
                <div class="col-auto" >
                    <label for="name-2" class="block">&nbsp;</label>
                    <br>
                    <button type="button" class="btn btn-primary btn-sm" title="Buscar" onClick="CargarArticulos()">
                        <i class="fa fa-search"></i> 
                    </button>
                </div>
                    
                <div class="col-md-4 col-lg-4" id="id_articulo_interno">
                    <label for="articulos" class="block mb-0 " id="scrollable-dropdown-menu">Articulos</label>
                    <select name="_codigo" id="_codigo"  data-old="{{ old('_codigo') }}"
                        class="js-example-basic-single form-control ">
                        <option value="0">Seleccione Articulo</option>
                    </select>
                </div>

                <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-4 mb-1">
                </div>
            </div>
        </form>
    </div>
    <div class="card-block">
        <div class="dt-responsive table-responsive">
            <table id="despachos" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Articulo</th>
                        <th>Fecha</th>
                        <th>Código Proveedor</th>
                        <th>Proveedor</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Costo Unitario</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($historial != null)
                    @foreach ($historial as $historial)
                    <tr>
                        <td>{{$historial->Codigo}}</td>
                        <td>{{$historial->Articulo}}</td>
                        <td>{{date('d-m-Y', strtotime($historial->Fecha))}}</td>
                        <td>{{$historial->CodProveedor}}</td>
                        <td>{{$historial->Proveedor}}</td>
                        <td style='text-align:right'>{{number_format($historial->Cantidad,2,',','.')}}</td>
                        <td>{{$historial->Unidad}}</td>
                        <td style='text-align:right'>{{number_format($historial->CostoUnitarioUS,2,',','.')}}</td>                     
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
    <script> 

        var BuscarArticulos = "{{ url('fictbuscararticulo') }}"; 
        function CargarArticulos() 
        {
            var articulo = $('#articulo').val();

            $.get(BuscarArticulos +'/'+ articulo, function(data) {
                var old = $('#_codigo').data('old') != '' ? $('#_codigo').data('old') : '';
                $('#_codigo').empty();

                $.each(data, function(fetch, articulos) {
                    console.log(data);
                    $('#_codigo').append('<option value="0">SELECCIONE</option>');
                    for (i = 0; i < articulos.length; i++) {
                        $('#_codigo').append('<option value="' + articulos[i].codigo.trim() + '"   ' + (old ==
                            articulos[i].nombre ? "selected" : "") + ' >'+articulos[i].codigo.trim()+ ' | '+ articulos[i].nombre +'</option>');
                    }
                })

            })
        }
    </script>

    <!-- Select -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
@endsection
