@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte de Salidas Articulos Departamento Por Mes')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Reporte de Salidas Articulos Departamento Por Mes</a> </li>
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
            <div class="form-group row">
                {{-- FILTROS DE BUSQUEDA --}}

                <div class="col-md-2 col-lg-2">
                    <label for="departamento" class="form-label">Departamentos</label>
                    <div class=" @error('departamento') is-invalid @enderror">
                        <select name="departamento" class="js-example-basic-single form-control">
                            <option value="TODOS">TODOS</option>
                            @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->nombre_departamento }}" @if ($departamento->nombre_departamento == old('departamento', $_GET['departamento'] ?? '' )) selected="selected" @endif>
                              {{ $departamento->nombre_departamento }}
                            </option>
                            @endforeach
                          </select>
                    </div>
                </div>

                <div class="col-md-2 col-lg-2">
                    <label class="form-label">Articulos</label>
                    <div class="@error('articulo') is-invalid @enderror">
                        <select name="articulo" class="js-example-basic-single form-control">
                            <option value="TODOS">TODOS</option>
                            @foreach ($articulos as $articulo)
                            <option value="{{ $articulo->codigo_articulo }}" @if ($articulo->codigo_articulo == old('articulo', $_GET['articulo'] ?? '' )) selected="selected" @endif>
                              {{ $articulo->nombre_articulo }}
                            </option>
                            @endforeach
                          </select>
                    </div>
                </div>

                <div class="col-md-2 col-lg-2">
                    <label class="form-label">Categorias</label>
                    <div class=" @error('categoria') is-invalid @enderror">
                        <select name="categoria" class="js-example-basic-single form-control">
                            <option value="TODOS">TODOS</option>
                            @foreach ($categorias as $categoria)
                            <option value="{{ trim($categoria->codigo_categoria) }}" @if (trim($categoria->codigo_categoria) == old('categoria', $_GET['categoria'] ?? '' )) selected="selected" @endif>
                              {{ trim($categoria->nombre_categoria) }}
                            </option>
                            @endforeach
                          </select>
                    </div>
                </div>

                <div class="col-md-2 col-lg-2">
                    <label class="form-label">Grupos</label>
                    <div class="@error('grupo') is-invalid @enderror">
                        <select name="grupo" id="grupo" class="js-example-basic-single form-control" onchange="CargarSubgrupos()">
                            <option value="TODOS">TODOS</option>
                            @foreach ($grupos as $grupo)
                            <option value="{{ trim($grupo->codigo_grupo) }}" @if (trim($grupo->codigo_grupo) == old('grupo', $_GET['grupo'] ?? '' )) selected="selected" @endif>
                              {{ trim($grupo->nombre_grupo) }}
                            </option>
                            @endforeach
                          </select>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2">
                    <label class="form-label">SubGrupos</label>
                    <div class="@error('subgrupo') is-invalid @enderror">
                        <select name="subgrupo" id="subgrupo" class="js-example-basic-single form-control"
                        data-old="{{ old('subgrupo', $_GET['subgrupo'] ?? '') }}">
                            <option value="TODOS">TODOS</option>
                          </select>
                    </div>
                </div>

                <div class="col-md-1 col-lg-1">
                    <label class="form-label">Año</label>
                    <div class="@error('año') is-invalid @enderror">
                        <input type="number" name="año" class="form-control" value="{{ old('año', $_GET['año'] ?? '') }}">
                    </div>
                </div>

            </div>
            <div class="form-group row">
                <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-1 mb-1" OnClick="">
                </div>
                <div class="col-auto">
                    <input type="submit" value="Excel" name="excel" class="btn btn-primary mt-1 mb-1" OnClick="">
                </div>
            </div>           
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>
        @php
        $contador = 1;
        @endphp
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="">
                <thead>
                    <tr>
                        <th>Gerencia</th>
                        <th>Codigo</th>
                        <th>Articulo</th>
                        <th>Categoria</th>
                        <th>Grupo</th>
                        <th>SubGrupo</th>
                        <th>Unidad</th>
                        <th>Año</th>
                        <th>Ene</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Abr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Ago</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dic</th>
                        <th>Total</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($salidas as $salida)
                    <tr>
                        <td>{{$salida->Gerencia}}</td>
                        <td>{{$salida->Codigo}}</td>
                        <td>{!!wordwrap($salida->Articulo, 25, '<br>')!!} </td>
                        <td>{!!wordwrap($salida->Categoria, 10, '<br>')!!}</td>
                        <td>{!!wordwrap($salida->Grupo, 10, '<br>')!!}</td>
                        <td>{!!wordwrap($salida->SubGrupo, 10, '<br>')!!}</td>
                        <td>{{$salida->Unidad}}</td>
                        <td>{{$salida->Anio}}</td>
                        <td>{{number_format($salida->Ene, 2)}}</td>
                        <td>{{number_format($salida->Feb, 2)}}</td>
                        <td>{{number_format($salida->Mar, 2)}}</td>
                        <td>{{number_format($salida->Abr, 2)}}</td>
                        <td>{{number_format($salida->May, 2)}}</td>
                        <td>{{number_format($salida->Jun, 2)}}</td>
                        <td>{{number_format($salida->Jul, 2)}}</td>
                        <td>{{number_format($salida->Ago, 2)}}</td>
                        <td>{{number_format($salida->Sep, 2)}}</td>
                        <td>{{number_format($salida->Oct, 2)}}</td>
                        <td>{{number_format($salida->Nov, 2)}}</td>
                        <td>{{number_format($salida->Dic, 2)}}</td>
                        <td>
                            @php
                                $total = $salida->Ene + $salida->Feb + $salida->Mar + $salida->Abr
                                + $salida->May + $salida->Jun + $salida->Jul + $salida->Ago + $salida->Sep
                                + $salida->Oct + $salida->Nov + $salida->Dic;
                            @endphp
                            {{number_format($total, 2)}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<script>
    function CargarSubgrupos() 
    {
        var IdGrupo = $('#grupo').val();

        $.get('subgruposarticulo/' + IdGrupo, function(data) 
        {
            var old = $('#subgrupo').data('old') != '' ? $('#subgrupo').data('old') : '';

            $('#subgrupo').empty();
            $('#subgrupo').append('<option value="TODOS">TODOS</option>');

            $.each(data, function(fetch, subgrupos) {
                for (i = 0; i < subgrupos.length; i++) {
                    $('#subgrupo').append('<option value="' + subgrupos[i].codigo_subgrupo + '"   ' + (old ==
                            subgrupos[i].codigo_subgrupo ? "selected" : "") + ' >'+ subgrupos[i].nombre_subgrupo + '</option>');
                }
            })

        })
    }

CargarSubgrupos();
</script>
@endsection