@extends('layouts.master')

@section('titulo', 'Aprovechamientos')

@section('titulo_pagina', 'Aprovechamientos')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cencaprovechamientos.index') }}">Centro Corte</a>
    <li class="breadcrumb-item"><a href="{{ route('cencaprovechamientos.index') }}">Aprovechamientos</a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cencaprovechamientos.create') }}">Crear</a> </li>
</ul>

@endsection

@section('contenido')

<head>
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' />
</head>


@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

{{-- como buena practica: mover esto a la plantilla y cambiar los id para no confundir --}}
<style>
    .highlight {
        border: 2px solid green;
    }

    .clicked {
        background-color: blue;
    }

    .input-container {
        display: flex;
        gap: 14px;
        /* Ajusta el espacio entre los inputs según tus necesidades */
    }
</style>

<form method="POST" id="FormAprov" action=" {{ route('cencaprovechamientos.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="card">
        <div class="card-header">
            <h5>Crear Aprovechamiento</h5>
        </div>
        <div class="card-block" name="select_card" id="_select_card">

            <div class="form-group row">

                <label class="col-sm-1 col-form-label">N° CONAP</label>
                <div class="col-sm-2 @error('id_conap') is-invalid @enderror">
                    <select name="id_conap" id="_id_conap" class="js-example-basic-single form-control">
                        <option value="0">Seleccione Conap</option>
                        @foreach ($conaps as $conap)
                        <option value="{{ $conap->id_conap }}" @if ($conap->id_conap==old('id_conap'))
                            selected="selected" @endif> {{ $conap->nro_conap }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <label class="col-sm-1 col-form-label">N° Lista Parte</label>
                <div class="col-sm-2 @error('id_listaparte') is-invalid @enderror">
                    <select name="id_listaparte" id="_id_listaparte" data-old="{{ old('id_listaparte') }}"
                        class="js-example-basic-single form-control">
                        <option value="0">Seleccione Lista Parte</option>
                    </select>
                </div>
                <label class="col-sm-1 col-form-label">Equipo</label>
                <div class="col-sm-2 @error('equipocorte') is-invalid @enderror">
                    <select name="equipocorte" id="_equipocorte" class="js-example-basic-single form-control">
                        <option value="0">Seleccione equipo</option>
                        @foreach ($equipos as $equipo)
                        <option value="{{$equipo->id_equipo}}" @if ($equipo->id_equipo == old('equipocorte')) selected =
                            "selected" @endif>
                            {{$equipo->nombre_equipo}}
                            @endforeach
                    </select>
                </div>

                <label class="col-sm-1 col-form-label p-r-0 p-l-10">Tecnologia</label>
                <div class="col-sm-2 @error('tecnologia') is-invalid @enderror">
                    <select name="tecnologia" id="_tecnologia" onchange="mostrarDiv()" data-old="{{ old('tecnologia', $aprov->nombre_tecnologia ?? '' ) }}"
                        class="js-example-basic-single form-control">
                            <option value="0">Seleccione la tecnologia</option>
                            @foreach ($tecnologias as $tecnologia)
                            <option value="{{$tecnologia->id_tecnologia}}" @if ($tecnologia->id_tecnologia == old('tecnologia',
                                $aprov->nombre_tecnologia ?? '')) selected = "selected" @endif>{{$tecnologia->nombre_tecnologia}}
                            </option>
                            @endforeach
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div id="tipo_espesor" style="display: none;" class="col-sm-3">
                    <div class="row">
                        <label class="col-sm-4 col-form-label">Espesor</label>
                        <div class="col-sm-8 @error('espesor') is-invalid @enderror">
                            <select name="espesor" id="_espesor" data-old="{{ old('espesor') }}"
                                class="js-example-basic-single form-control">
                                <option value="0">Seleccione Espesor</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="tipo_perfil" style="display: none;" class="col-sm-3">
                    <div class="row">
                        <label class="col-sm-4 col-form-label">Perfil</label>
                        <div class="col-sm-8 @error('perfil') is-invalid @enderror ">
                            <select name="perfil" id="_perfil" data-old="{{ old('perfil') }}"
                                class="js-example-basic-single form-control">
                                <option value="0">Seleccione Perfil</option>
                            </select>
                        </div>
                    </div>
                </div>

                <label class="col-sm-1 col-form-label">Tipo</label>
                <div class="col-sm-2">
                    <input type="text" id="_tipo_aprov" class="form-control @error('tipo_aprov') is-invalid @enderror"
                        readonly>
                </div> 
                
                <div id='nroboquilla_Morrocoy' class="col-sm-3" style="display: none;">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="col-form-label p-r-0 p-l-10">Nro. Boquilla</label>
                        </div>
                        <div class="col-sm-8 @error('boquilla') is-invalid @enderror">
                            <select name="boquilla" id="_boquilla" data-old="{{ old('boquilla') }}"
                                class="js-example-basic-single form-control">
                                <option value="0">Seleccione Boquilla</option>
                                <option value="1" 
                                @if (old('boquilla') == '1') selected="selected" @endif>1</option>
                                <option value="2" 
                                @if (old('boquilla') == '2') selected="selected" @endif>2</option>
                                <option value="3" 
                                @if (old('boquilla') == '3') selected="selected" @endif>3</option>
                                <option value="4" 
                                @if (old('boquilla') == '4') selected="selected" @endif>4</option>
                                <option value="5" 
                                @if (old('boquilla') == '5') selected="selected" @endif>5</option>
                                <option value="6" 
                                @if (old('boquilla') == '6') selected="selected" @endif>6</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id='nroboquilla_KF' class="col-sm-3" style="display: none;">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="col-form-label p-r-0 p-l-10">Nro. Boquilla</label>
                        </div>
                        <div class="col-sm-8 @error('boquilla2') is-invalid @enderror">
                            <select name="boquilla2" id="_boquilla2" data-old="{{ old('boquilla2') }}"
                                class="js-example-basic-single form-control">
                                <option value="0">Seleccione Boquilla</option>
                                <option value="3 - 6 PM" 
                                @if (old('boquilla2') == '3 - 6 PM') selected="selected" @endif>
                                Quemador 3-6 PM</option>
                                <option value="6 - 15 PM" 
                                @if (old('boquilla2') == '6 - 15 PM') selected="selected" @endif>
                                Quemador 6-15 PM</option>
                                <option value="15 - 25 PM" 
                                @if (old('boquilla2') == '15 - 25 PM') selected="selected" @endif>
                                Quemador 15-25 PM</option>
                                <option value="25 - 40 PM" 
                                @if (old('boquilla2') == '25 - 40 PM') selected="selected" @endif>
                                Quemador 25-40 PM</option>
                                <option value="40 - 60 PM" 
                                @if (old('boquilla2') == '40 - 60 PM') selected="selected" @endif>
                                Quemador 40-60 PM</option>
                                <option value="60 - 100 PM" 
                                @if (old('boquilla2') == '60 - 100 PM') selected="selected" @endif>
                                Quemador 60-100 PM</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id='JuegoAntorcha' class="col-sm-3" style="display: none;">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="col-form-label p-r-0 p-l-10">Antorcha</label>
                        </div>
                        <div class="col-sm-8 @error('antorcha') is-invalid @enderror">
                            <select name="antorcha" id="_antorcha" class="js-example-basic-single form-control">
                                <option value="0">Seleccione Antorcha</option>
                                <option value="130A" @if (old('antorcha') == '130A') selected="selected" @endif>130A</option>
                                <option value="200A" @if (old('antorcha') == '200A') selected="selected" @endif>200A</option>
                                <option value="260A" @if (old('antorcha') == '260A') selected="selected" @endif>260A</option>
                                <option value="400A" @if (old('antorcha') == '400A') selected="selected" @endif>400A</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="PrecaOxicorte" style="display: none;">
                <div class="form-group row">
                    <label class="col-sm-1 col-form-label">Prec</label>
                    <div class="col-sm-2 @error('precalentamiento') is-invalid @enderror">
                        <select name="precalentamiento" id="_precalentamiento" data-old="{{ old('precalentamiento') }}"
                            class="js-example-basic-single form-control">
                            <option value="0">Seleccione</option>
                            <option value="Si" @if (old('precalentamiento') == 'Si') selected="selected" @endif>Si</option>
                            <option value="No" @if (old('precalentamiento') == 'No') selected="selected" @endif>No</option>
                        </select>
                    </div>

                    <div id="TiempoPrecaOxicorte" style="display: none;" class="col-sm-3">
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Tiempo Prec.</label>
                            <div class="col-sm-8 @error('tiempo_precalentamiento') is-invalid @enderror">
                                <select name="tiempo_precalentamiento" id="_tiempo_precalentamiento"
                                    data-old="{{ old('tiempo_precalentamiento') }}" class="js-example-basic-single form-control">
                                    <option value="0">Seleccione</option>
                                    <option value="30" 
                                    @if (old('tiempo_precalentamiento') == '30') selected="selected" @endif>30</option>
                                    <option value="35" 
                                    @if (old('tiempo_precalentamiento') == '35') selected="selected" @endif>35</option>
                                    <option value="40" 
                                    @if (old('tiempo_precalentamiento') == '40') selected="selected" @endif>40</option>
                                    <option value="45" 
                                    @if (old('tiempo_precalentamiento') == '45') selected="selected" @endif>45</option>
                                    <option value="50" 
                                    @if (old('tiempo_precalentamiento') == '50') selected="selected" @endif>50</option>
                                    <option value="55" 
                                    @if (old('tiempo_precalentamiento') == '55') selected="selected" @endif>55</option>
                                    <option value="60" 
                                    @if (old('tiempo_precalentamiento') == '60') selected="selected" @endif>60</option>
                                    <option value="65" 
                                    @if (old('tiempo_precalentamiento') == '65') selected="selected" @endif>65</option>
                                    <option value="70" 
                                    @if (old('tiempo_precalentamiento') == '70') selected="selected" @endif>70</option>
                                    <option value="75" 
                                    @if (old('tiempo_precalentamiento') == '75') selected="selected" @endif>75</option>
                                    <option value="80" 
                                    @if (old('tiempo_precalentamiento') == '80') selected="selected" @endif>80</option>
                                    <option value="85" 
                                    @if (old('tiempo_precalentamiento') == '85') selected="selected" @endif>85</option>
                                    <option value="90" 
                                    @if (old('tiempo_precalentamiento') == '90') selected="selected" @endif>90</option>
                                    <option value="95" 
                                    @if (old('tiempo_precalentamiento') == '95') selected="selected" @endif>95</option>
                                    <option value="100" 
                                    @if (old('tiempo_precalentamiento') == '100') selected="selected" @endif>100</option>
                                    <option value="105" 
                                    @if (old('tiempo_precalentamiento') == '105') selected="selected" @endif>105</option>
                                    <option value="110" 
                                    @if (old('tiempo_precalentamiento') == '110') selected="selected" @endif>110</option>
                                    <option value="115" 
                                    @if (old('tiempo_precalentamiento') == '115') selected="selected" @endif>115</option>
                                    <option value="120" 
                                    @if (old('tiempo_precalentamiento') == '120') selected="selected" @endif>120</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="campos_planchas" class="form-group" style="display: none;">
                <div class="row">
                    <label class="col-sm-1 col-form-label">Longitud Corte (mm)</label>
                    <div class="col-sm-2">
                        <input type="text" name="longitud_corte" id="_longitud_corte"
                        class="form-control @error('longitud_corte') is-invalid @enderror" value="{{ old('longitud_corte') }}" placeholder="mm">
                    </div>
                    
                    <label class="col-sm-1 col-form-label">Nro. Piercing</label>
                    <div class="col-sm-2">
                        <input type="text" name="numero_piercing" id="_numero_piercing"
                        class="form-control @error('numero_piercing') is-invalid @enderror" value="{{ old('numero_piercing') }}" placeholder="unidad">
                    </div>

                    <label class="col-sm-1 col-form-label">T.E. Corte</label>
                    <div class="col-sm-2">
                        <input type="text" data-mask="99:99:99" name="tiempo_estimado_corte" id="_tiempo_estimado_corte"
                        class="form-control hour @error('tiempo_estimado_corte') is-invalid @enderror" value="{{ old('tiempo_estimado_corte') }}">
                    </div>
                </div>
            </div>

            <div id="campos_perfiles" class="form-group" style="display: none;">
                <div class="row">
                    <label class="col-sm-1 col-form-label">Perfil</label>
                    <div class="col-sm-2">
                        <select name="select_tipoperfil" id="_select_tipoperfil"
                            class="js-example-basic-single form-control">
                            <option disabled selected></option>
                            <option value="1">HEA100</option>
                            <option value="2">HEA120</option>
                        </select>
                    </div>

                    <label class="col-sm-1 col-form-label"
                        style="padding-right: 10px; padding-left: 0px;">Posición</label>
                    <div class="col-sm-2">
                        <select name="posicion" id="_posicion" class="js-example-basic-single form-control">
                            <option disabled selected></option>
                            <option value="1">Horizontal</option>
                            <option value="2">Vertical</option>
                        </select>
                    </div>

                    <label class="col-sm-1 col-form-label"
                        style="padding-right: 10px; padding-left: 0px;">Material</label>
                    <div class="col-sm-2">
                        <select name="material" id="_material" class="js-example-basic-single form-control">
                            <option disabled selected></option>
                            <option value="1">Acero Carbono</option>
                            <option value="2">Acero Inoxidable</option>
                        </select>
                    </div>

                    <label class="col-sm-1 col-form-label" style="padding-right: 10px; padding-left: 0px;">T.E.
                        Ejecucion</label>
                    <div class="col-sm-2">
                        <input type="text" name="tiempo_estimado_ejecucion" id="_tiempo_estimado_ejecucion"
                            class="form-control @error('tiempo_estimado_ejecucion') is-invalid @enderror"
                            placeholder="">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="documentos" class="col-sm-1 col-md-1 col-lg-1 col-form-label">Archivos</label>
                <div class="col-md-11 col-lg-11 @error('documentos') is-invalid @enderror">
                    <input type="file" name="documentos" id="filer_input" value="{{old('documentos[]') }}">
                </div>
            </div>
        </div>
    </div>

    <div id="miCardPlanchas">

        {{-- MATERIAL PROCESADO PLANCHA--}}
        <div id="miCardPlanchampr" style="display: none;">
            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title">MATERIAL PROCESADO PLANCHA</h4>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="tabla_plancha_material">
                            <thead>
                                <tr class="background-primary">
                                    <th style="width: 30%">Espesor</th>
                                    <th style="width: 30%">Cantidad</th>
                                    <th style="width: 30%">Peso Total (Kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $data = json_decode(old('_caracteristicas'));
                                @endphp
                                @if($data && isset($data->material_procesado))
                                    @foreach($data->material_procesado as $material_procesado)
                                        <tr>
                                            <td id="espesor_material">{{$material_procesado->espesor_material}}</td>
                                            <td id="cantidad_material">{{$material_procesado->cantidad_material}}</td>
                                            <td id="peso_material">{{$material_procesado->peso_material}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>

        {{-- MATERIA PRIMA PLANCHAS --}}
        <div id="miCardPlanchamp" style="display: none;">
            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title">MATERIA PRIMA PLANCHA</h4>
                    <div class="form-group row">

                        <label class="col-sm-1 form-label">Materia Prima</label>
                        <div class="form-radio col-sm-1">
                            <div class="radio radio-inline">
                                <label>
                                    <input type="radio" name="tipo_materia" id="materiaInterno" value="INTERNO"
                                        onClick="Tipomateria();" checked>
                                    <i class="helper"></i>Interno
                                </label>
                            </div>
                            <div class="radio radio-inline">
                                <label>
                                    <input type="radio" name="tipo_materia" id="materiaForaneo" value="FORANEO" {{
                                        old('tipo_materia')=="FORANEO" ? 'checked=' .'"'.'checked'.'"' : '' }}
                                        onClick="Tipomateria();">
                                    <i class="helper"></i>Foraneo
                                </label>
                            </div>
                            <br>
                        </div>

                        <div class="col-md-4 col-lg-4" id="materia_tipo">
                            <label for="name-2">Materia</label>
                            <select name="_material_plancha" id="_material_plancha"
                                class="js-example-basic-single form-control" onchange="StockMateriaPrima();">
                                <option value="0" disabled selected>Ingrese código de la materia</option>
                                @foreach ($materias as $materia)
                                <option value="{{ $materia->co_art }}" @if ($materia->co_art==old('co_art'))
                                    selected="selected" @endif>
                                    {{ $materia->co_art . " & " . $materia->art_des . "D:" .$materia->stock_act. "|".
                                    $materia->peso}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 col-md-1" id="existenciamateria">
                            <label for="existencia" class="block">Existencia</label>
                            <input type="number"
                                class="form-control form-control-bold form-control-uppercase @error('') is-invalid @enderror"
                                name="existencia" id="existencia" value="" placeholder="" readonly>
                        </div>
                        <div class="col-md-2 col-lg-2" id="cantidadmateria">
                            <label for="cantidad" class="block">Cantidad</label>
                            <input type="number" min="1" max="1"
                                class="form-control form-control-bold form-control-uppercase @error('cantidad_entregada') is-invalid @enderror"
                                name="cantidad_entregada" id="cantidad_entregada"
                                value="{{ old('cantidad_entregada') }}" placeholder="Cantidad">
                        </div>

                        {{-- <div id="foraneo" class="row" style="padding-left: 30px;">
                            <div class="col-sm-4">
                                <label for="dimensiones" class="block">Dimensiones (mm)</label>
                                <input type="text" name="dimensiones" id="dimensionesForaneo"
                                    class="form-control @error('dimensiones') is-invalid @enderror"
                                    placeholder="ancho x largo" value="{{ old('dimensiones') }}">
                            </div>

                            <div class="col-sm-4">
                                <label for="cantidad" class="block">Cantidad (und)</label>
                                <input type="text" name="cantidad" id="cantidadForaneo"
                                    class="form-control @error('cantidad') is-invalid @enderror" placeholder="unidad"
                                    value="{{ old('cantidad') }}">
                            </div>

                            <div class="col-sm-4">
                                <label for="peso" class="block">Peso (kg)</label>
                                <input type="text" name="peso" id="pesoForaneo"
                                    class="form-control @error('peso') is-invalid @enderror" placeholder="kg"
                                    value="{{ old('peso') }}">
                            </div>
                        </div> --}}

                        <div id="foraneo" class="form-group row" style="padding-left: 10px;">
                          
                            <label class="col-sm-2 col-form-label p-r-0 p-l-10">Dimensiones (mm)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="dimensiones_materia1" id="dimensiones_materia1"
                                    value="{{ old('dimensiones_materia1') }}" placeholder="ancho">
                            </div>
                            <div>x</div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="dimensiones_materia2" id="dimensiones_materia2"
                                    value="{{ old('dimensiones_materia2') }}" placeholder="largo">
                            </div>
                        
                            <label class="col-sm-1 col-form-label p-r-0 p-l-10">Cantidad</label>
                            <div class="col-sm-3">
                                <input type="text" name="cantidad" id="cantidadForaneo"
                                    class="form-control @error('cantidad') is-invalid @enderror" placeholder="unidad"
                                    value="{{ old('cantidad') }}">
                            </div>
                        </div>

                        <div class="col-sm-1 col-lg-1">
                            <label for="name-2" class="block">Agregar</label>
                            <br>
                            <button type="button" class="btn btn-primary btn-sm" title="Nuevo"
                                onClick="CargarTablaPlancha_Materia()">
                                <i class="fa fa-plus"></i> </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="tabla_plancha_materia">
                            <thead>
                                <tr class="background-primary">
                                    <th style='display: none;'>CÓDIGO</th>
                                    <th style="width: 22%">Dimensiones (mm)</th>
                                    <th style="width: 22%">Cantidad (und)</th>
                                    <th style="width: 22%">Peso Unitario (kg)</th>
                                    <th style="width: 22%">Peso Total (kg)</th>
                                    <th style="width: 10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                   $data = json_decode(old('_caracteristicas'));
                                @endphp
                              @if($data && isset($data->materia_prima))
                              @foreach($data->materia_prima as $materia_prima)
                                        <tr>
                                            <td id="codigo_materia" style="display:none;">{{$materia_prima->codigo_materia}}</td>
                                            <td id="dimensiones_materia">{{$materia_prima->dimensiones_materia}}</td>
                                            <td id="cantidad_materia">{{$materia_prima->cantidad_materia}}</td>
                                            <td id="pesounitario_materia">{{$materia_prima->pesounitario_materia}}</td>
                                            <td id="pesototal_materia">{{$materia_prima->pesototal_materia}}</td>
                                            <th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- AREA DE CORTE PLANCHA--}}
        <div id="miCardPlanchacp" style="display: none;">
            <div class="card">
                <div class="card-block">
                    <h4 class="sub-title">ÁREA DE CORTE PLANCHA</h4>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label">Dimensiones (mm)</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" name="dimensiones_corte1" id="dimensiones_corte1"
                                value="{{ old('dimensiones_corte1') }}" placeholder="ancho">
                        </div>
                        <div>x</div>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" name="dimensiones_corte2" id="dimensiones_corte2"
                                value="{{ old('dimensiones_corte2') }}" placeholder="largo">
                        </div>

                        <label class="col-sm-1 col-form-label">Cantidad</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control @error('area_corte') is-invalid @enderror"
                                name="area_corte" id="cantidad_plancha" value="{{ old('area_corte') }}"
                                placeholder="unidad">
                        </div>

                        <label for="name-2" class="block">Agregar</label>
                        <div class="col-md-1 col-lg-1">
                            <button type="button" class="btn btn-primary btn-sm" title="Nuevo"
                                onClick="CargarTablaPlancha_Corte()">
                                <i class="fa fa-plus"></i> </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-styling" id="tabla_plancha_corte">
                            <thead>
                                <tr class="background-primary">
                                    <th style="width: 22%">Dimensiones (mm)</th>
                                    <th style="width: 22%">Cantidad (und)</th>
                                    <th style="width: 22%">Peso Unitario (kg)</th>
                                    <th style="width: 22%">Peso Total (kg)</th>
                                    <th style="width: 10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                   $data = json_decode(old('_caracteristicas'));
                                @endphp
                              @if($data && isset($data->area_corte))
                              @foreach($data->area_corte as $area_cortes)
                                        <tr>
                                            <td id="dimensiones_corte">{{$area_cortes->dimensiones_corte}}</td>
                                            <td id="cantidad_corte">{{$area_cortes->cantidad_corte}}</td>
                                            <td id="pesounitario_corte">{{$area_cortes->pesounitario_corte}}</td>
                                            <td id="pesototal_corte">{{$area_cortes->pesototal_corte}}</td>
                                            <th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th>
                                        </tr>
                                    @endforeach
                                @endif 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-block" name="card_observaciones" id="_card_observaciones">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Observaciones</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3"
                            class="form-control @error('observaciones_aprov') is-invalid @enderror"
                            name="observaciones_aprov" id="_observaciones_aprov"
                            placeholder="">{{ old('observaciones_aprov') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- PERFILES --}}
    <div id="miCardPerfiles">

        <div id="miCardPerfilesmp" style="display: none;">
            <div class="card">
                <div class="card-header">
                    <h5>PERFILES</h5>
                </div>
                {{-- Datos dinamicos de planchas--}}
                <div class="card-block">
                    <form class="" method="POST" action=" {{ route('cencaprovechamientos.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- Datos de los numeros de cortes --}}
                        <h6 class="sub-title">Cortes</h6>
                        <div class="form-group row">
                            @php
                            $cantidadPerfiles = 0;
                            @endphp
                            <label class="col-sm-1 col-form-label">Perfil</label>
                            <div class="col-sm-2 @error('id_equipo') is-invalid @enderror">
                                <select name="id_perfil_corte" id="id_perfil_corte"
                                    class="js-example-basic-single form-control">
                                    <option value="0" disabled selected>Seleccione el perfil</option>
                                    <option value="7568">7468</option>
                                    <option value="8210">8210</option>
                                </select>
                            </div>
                            <label class="col-sm-1 col-form-label">Saneo inicial</label>
                            <div class="col-sm-2 @error('id_equipo') is-invalid @enderror">
                                <select name="id_saneo" id="id_saneo" class="js-example-basic-single form-control">
                                    <option value="0" disabled selected>Seleccione el saneo</option>
                                    <option value="0">0</option>
                                    <option value="40">40</option>
                                </select>
                            </div>
                            <label for="name-2" class="col-sm-1 col-form-label">Agregar</label>
                            <div class="col-md-2 col-lg-2">
                                <button type="button" class="btn btn-primary btn-sm" title="Nuevo"
                                    onClick="CargarTablaCortes()">
                                    <i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                        <div class="table-responsive dt-responsive">
                            <table id="tablaCortes" class="table table-striped table-bordered nowrap table-responsive"
                                style="width: 100%">
                                <thead>
                                    <th>Nro</th>
                                    {{-- <th>Perfil</th> --}}
                                    <th>Saneo</th>
                                    <th>Corte 1</th>
                                    <th>Corte 2</th>
                                    <th>Corte 3</th>
                                    <th>Corte 4</th>
                                    <th>Corte 5</th>
                                    <th>Corte 6</th>
                                    <th>Corte 7</th>
                                    <th>Corte 8</th>
                                    <th>Corte 9</th>
                                    <th>Corte 10</th>
                                    <th>Corte 11</th>
                                    <th>Corte 12</th>
                                    <th>Corte 13</th>
                                    <th>Corte 14</th>
                                    <th>Corte 15</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        {{-- <td>7675</td> --}}
                                        <td>40</td>
                                        <td>1200</td>
                                        <td>2400</td>
                                        <td>800</td>
                                        <td>3200</td>
                                        <td>1800</td>
                                        <td>2000</td>
                                        <td>400</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>

    </div>

    <br>


    {{-- <div class="d-grid gap-2 d-md-block float-left">
        <a class="btn btn-primary" href="http://localhost/aceronet/public/cencaprovechamientos/1">
            <i class="fa fa-save"></i> Vista Previa
        </a>
    </div> --}}


    <input type="hidden" name="_caracteristicas" id="_caracteristicas">

    <div class="d-grid gap-2 d-md-block float-right">
        <button type="button" value="Enviar" id="enviar" class="btn btn-primary" OnClick="CapturarDatosSelect()">
            <i class="fa fa-save"></i>Guardar
        </button>
    </div>
</form>


@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<!-- jquery file upload js -->
<script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

<script src="{{ asset('libraries\assets\pages\form-masking\inputmask.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\form-masking\jquery.inputmask.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\form-masking\form-mask.js') }}" type="text/javascript"></script>
<script>
    var ruta = "{{ url('cencaprovechamientos') }}";
</script>

<script src="{{ asset('libraries\assets\js\CencAprovechamiento.js') }}"></script>

@endsection