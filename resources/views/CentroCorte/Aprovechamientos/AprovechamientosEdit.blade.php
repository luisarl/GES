@extends('layouts.master')

@section('titulo', 'Aprovechamiento')

@section('titulo_pagina', 'Aprovechamiento')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cencaprovechamientos.index') }}">Centro Corte</a>
    <li class="breadcrumb-item"><a href="{{ route('cencaprovechamientos.index') }}">Aprovechamiento</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')
@include('CentroCorte.Aprovechamientos.AprovechamientosDestroy')

<form method="POST" id="FormAprov" action="{{ route('cencaprovechamientos.update', $aprov->id_aprovechamiento) }}" enctype="multipart/form-data">
    @method("put")
    @csrf

    <div class="card">
        <div class="card-header">
            <h5>Editar Aprovechamiento</h5>
        </div>
        <div class="card-block" name="select_card" id="_select_card">

            <div class="form-group row">

                <label class="col-sm-1 col-form-label">N° CONAP</label>
                <div class="col-sm-2 @error('id_conap') is-invalid @enderror">
                    <select name="id_conap" id="_id_conap" class="js-example-basic-single form-control">
                        @foreach ($conaps as $conap)
                        <option value="{{$conap->id_conap}}" @if ($conap->nro_conap== old('nro_conap',
                            $aprov->nro_conap ?? '')) selected="selected" @endif>{{$conap->nro_conap }}</option>
                        @endforeach
                    </select>
                </div>

                <label class="col-sm-1 col-form-label">N° Lista Parte</label>
                <div class="col-sm-2 @error('id_listaparte') is-invalid @enderror ">
                    <select name="id_listaparte" id="_id_listaparte"
                        data-old="{{ old('id_listaparte', $aprov->id_lista_parte.'-'.$aprov->tipo_lista ?? '' ) }}"
                        class="js-example-basic-single form-control">
                        <option selected value="{{$aprov->id_lista_parte.'-'.$aprov->tipo_lista}}">{{$aprov->id_lista_parte}}</option>
                    </select>
                </div>

                <label class="col-sm-1 col-form-label">Equipo</label>
                <div class="col-sm-2 @error('equipocorte') is-invalid @enderror">
                    <select name="equipocorte" id="_equipocorte" data-old="{{ old('equipocorte', $aprov->nombre_equipo ?? '' ) }}"
                    class="js-example-basic-single form-control">
                        <option value="0">Seleccione equipo</option>
                        @foreach ($equipos as $equipo)
                        <option value="{{$equipo->id_equipo}}" @if ($equipo->id_equipo == old('equipocorte',
                            $aprov->nombre_equipo ?? '')) selected = "selected" @endif>{{$equipo->nombre_equipo}}
                        </option>
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
                        <div class="col-sm-8 @error('espesor') is-invalid @enderror ">
                            <select name="espesor" id="_espesor"
                                data-old="{{ old('espesor', number_format($aprov->espesor, 2, '.', '') ?? '' ) }}"
                                class="js-example-basic-single form-control">
                                <option selected value="{{number_format($aprov->espesor, 2, '.', '')}}">
                                    {{number_format($aprov->espesor, 2, '.', '')}}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="tipo_perfil" style="display: none;" class="col-sm-3">
                    <div class="row">
                        <label class="col-sm-4 col-form-label">Perfil</label>
                        <div class="col-sm-8 @error('perfil') is-invalid @enderror ">
                            <select name="perfil" id="_perfil" class="js-example-basic-single form-control">
                                <option value="0">Seleccione Perfil</option>
                            </select>
                        </div>
                    </div>
                </div>

                <label class="col-sm-1 col-form-label p-r-0 p-l-10">Tipo</label>
                <div class="col-sm-2 @error('tipo_aprov') is-invalid @enderror ">
                    <select disabled name="tipo_aprov" id="_tipo_aprov"
                        data-old="{{ old('tipo_aprov', $aprov->tipo_lista ?? '' ) }}"
                        class="js-example-basic-single form-control">
                        <option selected value="{{$aprov->tipo_lista}}">{{$aprov->tipo_lista}}</option>
                    </select>
                </div>

                <div id='nroboquilla_Morrocoy' class="col-sm-3" style="display: none;">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="col-form-label p-r-0 p-l-10">Nro. Boquilla</label>
                        </div>
                        <div class="col-sm-8 @error('boquilla') is-invalid @enderror">
                            <select name="boquilla" id="_boquilla" data-old="{{ old('boquilla', $aprov->numero_boquilla ?? '' ) }}"
                                class="js-example-basic-single form-control">
                                <option value="0">Seleccione Boquilla</option>
                                <option value="1" 
                                @if ($aprov->numero_boquilla == old('boquilla', 1 ?? '')) selected="selected" @endif>1</option>
                                <option value="2" 
                                @if ($aprov->numero_boquilla == old('boquilla', 2 ?? ''))selected="selected" @endif>2</option>
                                <option value="3" 
                                @if ($aprov->numero_boquilla == old('boquilla', 3 ?? ''))selected="selected" @endif>3</option>
                                <option value="4" 
                                @if ($aprov->numero_boquilla == old('boquilla', 4 ?? ''))selected="selected" @endif>4</option>
                                <option value="5" 
                                @if ($aprov->numero_boquilla == old('boquilla', 5 ?? ''))selected="selected" @endif>5</option>
                                <option value="6" 
                                @if ($aprov->numero_boquilla == old('boquilla', 6 ?? ''))selected="selected" @endif>6</option>
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
                            <select name="boquilla2" id="_boquilla2" data-old="{{ old('boquilla2', $aprov->numero_boquilla ?? '' ) }}"
                                class="js-example-basic-single form-control">
                                <option value="0">Seleccione Boquilla</option>
                                <option value="Quemador 3-6 PM" 
                                @if ($aprov->numero_boquilla == old('boquilla2', 'Quemador 3-6 PM' ?? '')) selected="selected" @endif>
                                Quemador 3-6 PM</option>
                                <option value="Quemador 6-15 PM" 
                                @if ($aprov->numero_boquilla == old('boquilla2', 'Quemador 6-15 PM' ?? '')) selected="selected" @endif>
                                Quemador 6-15 PM</option>
                                <option value="Quemador 15-25 PM" 
                                @if ($aprov->numero_boquilla == old('boquilla2', 'Quemador 15-25 PM' ?? '')) selected="selected" @endif>
                                Quemador 15-25 PM</option>
                                <option value="Quemador 25-40 PM" 
                                @if ($aprov->numero_boquilla == old('boquilla2', 'Quemador 25-40 PM' ?? '')) selected="selected" @endif>
                                Quemador 25-40 PM</option>
                                <option value="Quemador 40-60 PM" 
                                @if ($aprov->numero_boquilla == old('boquilla2', 'Quemador 40-60 PM' ?? '')) selected="selected" @endif>
                                Quemador 40-60 PM</option>
                                <option value="Quemador 60-100 PM" 
                                @if ($aprov->numero_boquilla == old('boquilla2', 'Quemador 60-100 PM' ?? '')) selected="selected" @endif>
                                Quemador 60-100 PM</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id='JuegoAntorcha' class="col-sm-3" style="display: none;">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="col-form-label">Antorcha</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="antorcha" id="_antorcha" class="js-example-basic-single form-control">
                                <option value="0">Seleccione Antorcha</option>
                                <option value="130A" 
                                @if ($aprov->juego_antorcha == old('antorcha', '130A' ?? '')) selected="selected" @endif>130A</option>
                                <option value="200A" 
                                @if ($aprov->juego_antorcha == old('antorcha', '200A' ?? '')) selected="selected" @endif>200A</option>
                                <option value="260A" 
                                @if ($aprov->juego_antorcha == old('antorcha', '260A' ?? '')) selected="selected" @endif>260A</option>
                                <option value="400A" 
                                @if ($aprov->juego_antorcha == old('antorcha', '400A' ?? '')) selected="selected" @endif>400A</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="PrecaOxicorte" style="display: none;">
                <div class="form-group row">
                    <label class="col-sm-1 col-form-label">Prec</label>
                    <div class="col-sm-2">
                        <select name="precalentamiento" id="_precalentamiento" data-old="{{ old('precalentamiento') }}"
                            class="js-example-basic-single form-control">
                            <option value="0">Seleccione</option>
                            <option value="Si" @if ($aprov->precalentamiento == old('precalentamiento', 'Si' ?? '')) selected="selected" @endif>Si</option>
                            <option value="No" @if ($aprov->precalentamiento == old('precalentamiento', 'No' ?? '')) selected="selected" @endif>No</option>
                        </select>
                    </div>

                    <div id="TiempoPrecaOxicorte" style="display: none;" class="col-sm-3">
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Tiempo Prec.</label>
                            <div class="col-sm-8">
                                <select name="tiempo_precalentamiento" id="_tiempo_precalentamiento"
                                    data-old="{{ old('tiempo_precalentamiento') }}" class="js-example-basic-single form-control">
                                    <option value="0">Seleccione</option>
                                    <option value="30" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 30 ?? '')) selected="selected" @endif>30</option>
                                    <option value="35" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 35 ?? ''))selected="selected" @endif>35</option>
                                    <option value="40" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 40 ?? ''))selected="selected" @endif>40</option>
                                    <option value="45" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 45 ?? ''))selected="selected" @endif>45</option>
                                    <option value="50" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 50 ?? ''))selected="selected" @endif>50</option>
                                    <option value="55" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 55 ?? ''))selected="selected" @endif>55</option>
                                    <option value="60" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 60 ?? '')) selected="selected" @endif>60</option>
                                    <option value="65" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 65 ?? ''))selected="selected" @endif>65</option>
                                    <option value="70" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 70 ?? ''))selected="selected" @endif>70</option>
                                    <option value="75" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 75 ?? ''))selected="selected" @endif>75</option>
                                    <option value="80" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 80 ?? ''))selected="selected" @endif>80</option>
                                    <option value="85" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 85 ?? ''))selected="selected" @endif>85</option>
                                    <option value="90" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 90 ?? '')) selected="selected" @endif>90</option>
                                    <option value="95" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 95 ?? ''))selected="selected" @endif>95</option>
                                    <option value="100" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 100 ?? ''))selected="selected" @endif>100</option>
                                    <option value="105" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 105 ?? ''))selected="selected" @endif>105</option>
                                    <option value="110" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 110 ?? ''))selected="selected" @endif>110</option>
                                    <option value="115" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 115 ?? ''))selected="selected" @endif>115</option>
                                    <option value="120" 
                                    @if ($aprov->tiempo_precalentamiento == old('tiempo_precalentamiento', 120 ?? ''))selected="selected" @endif>120</option>
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
                        class="form-control @error('longitud_corte') is-invalid @enderror" 
                        value="{{ $aprov->longitud_corte }}" @if(old('longitud_corte') == $aprov->longitud_corte) @endif placeholder="mm">
                    </div>
                    
                    <label class="col-sm-1 col-form-label">Nro. Piercing</label>
                    <div class="col-sm-2">
                        <input type="text" name="numero_piercing" id="_numero_piercing"
                        class="form-control @error('numero_piercing') is-invalid @enderror" 
                        value="{{ $aprov->numero_piercing }}" @if(old('numero_piercing') == $aprov->numero_piercing) @endif placeholder="unidad">
                    </div>

                    <label class="col-sm-1 col-form-label">T.E. Corte</label>
                    <div class="col-sm-2">
                        <input type="text" data-mask="99:99:99" name="tiempo_estimado_corte" id="_tiempo_estimado_corte"
                        class="form-control hour @error('tiempo_estimado_corte') is-invalid @enderror" 
                        value="{{ $aprov->tiempo_estimado }}" @if(old('tiempo_estimado_corte') == $aprov->tiempo_estimado) @endif>
                    </div>

                    <input type="hidden" name="id_aprovechamiento" id="_id_aprovechamiento" value="{{$aprov->id_aprovechamiento}}">
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

                    @foreach($documentos as $documento)
                    <span data-id="{{$documento->id_aprovechamiento_documento}}">
                        <a href="{{asset($documento->ubicacion_documento)}}" target="_blank"
                            class="link-active m-r-10 f-12">
                            <i class="icofont icofont-attachment text-primary p-absolute f-30"></i>
                            {{$documento->nombre_documento}}</a>
                        <button type="button"
                            onclick="EliminarDocumentoAprov({{$documento->id_aprovechamiento_documento}})"
                            class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                    </span><br>
                    @endforeach
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
                                    <th style="width: 30%">Espesor (mm)</th>
                                    <th style="width: 30%">Cantidad (und)</th>
                                    <th style="width: 30%">Peso Total (kg)</th>
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

        {{-- MATERIA PRIMA PLANCHAS style="display: none;" --}}
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
                        </div>

                        <div class="col-md-4 col-lg-4" id="materia_tipo">
                            <label for="name-2">Materia</label>
                            <select name="materia_prima" id="_materia_prima" data-old="{{ old('co_art') }}"
                                class="js-example-basic-single form-control" onchange="StockMateriaPrima();">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>

                        <div class="col-md-1 col-md-1" id="existenciaherramientas">
                            <label for="existencia" class="block">Existencia</label>
                            <input type="number"
                                class="form-control form-control-bold form-control-uppercase @error('') is-invalid @enderror"
                                name="existencia" id="existencia" value="" placeholder="" readonly>
                        </div>
                        <div class="col-md-2 col-lg-2" id="cantidadherramientas">
                            <label for="cantidad" class="block">Cantidad Requerida</label>
                            <input type="number" min="1" max="1"
                                class="form-control form-control-bold form-control-uppercase @error('cantidad_entregada') is-invalid @enderror"
                                name="cantidad_entregada" id="cantidad_entregada"
                                value="{{ old('cantidad_entregada') }}" placeholder="Cantidad">
                        </div>

                        {{-- <div id="foraneo" class="row" style="padding-left: 30px;">
                            <div class="col-sm-4">
                                <label for="dimensiones" class="block">Dimensiones</label>
                                <input type="text" name="dimensiones" id="dimensionesForaneo"
                                    class="form-control @error('dimensiones') is-invalid @enderror"
                                    placeholder="ancho x largo" value="{{ old('dimensiones') }}">
                            </div>
                            <div class="col-sm-4">
                                <label for="cantidad" class="block">Cantidad</label>
                                <input type="text" name="cantidad" id="cantidadForaneo"
                                    class="form-control @error('cantidad') is-invalid @enderror" placeholder="unidad"
                                    value="{{ old('cantidad') }}">
                            </div>
                            <div class="col-sm-4">
                                <label for="peso" class="block">Peso</label>
                                <input type="text" name="peso" id="pesoForaneo"
                                    class="form-control @error('peso') is-invalid @enderror" placeholder="gr"
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
                                    <th style='display: none;'>ID</th>
                                    <th style='display: none;'>CODIGO</th>
                                    <th style="width: 40%">Dimensiones (mm)</th>
                                    <th style="width: 20%">Cantidad Requerida (und)</th>
                                    <th style="width: 20%">Peso Unitario (kg)</th>
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
                                            <td style='display: none;' id='id_materia_prima'>{{$materia_prima->id_materia_prima}}</td>
                                            <td style='display: none;' id="codigo_materia">{{$materia_prima->codigo_materia}}</td>
                                            <td id="dimensiones_materia">{{$materia_prima->dimensiones_materia}}</td>
                                            <td id="cantidad_materia">{{$materia_prima->cantidad_materia}}</td>
                                            <td id='pesounitario_materia'>{{number_format($materia_prima->pesounitario_materia, 2, '.', '')}}</td>
                                            <td id='pesototal_materia'>{{number_format($materia_prima->pesototal_materia, 2, '.', '')}}</td>
                                            <th> 
                                                {{-- <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>  --}}
                                            <button type="button"
                                                onclick="EliminarDetalleMateriaP({{$materia_prima->id_materia_prima}})"
                                                class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                                            </th>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($MateriaPrima as $MateriaPrimas)
                                        <tr>
                                            <td style='display: none;' id='id_materia_prima'>{{$MateriaPrimas->id_materia_prima}}</td>
                                            <td style='display: none;' id="codigo_materia" >{{$MateriaPrimas->codigo_materia}}</td>
                                            <td id="dimensiones_materia">{{$MateriaPrimas->dimensiones}}</td>
                                            <td id="cantidad_materia">{{$MateriaPrimas->cantidad}}</td>
                                            <td id='pesounitario_materia'>{{number_format($MateriaPrimas->peso_unit, 2, '.', '')}}</td>
                                            <td id='pesototal_materia'>{{number_format($MateriaPrimas->peso_total, 2, '.', '')}}</td>
                                            <th> 
                                                <button type="button"
                                                onclick="EliminarDetalleMateriaP({{$MateriaPrimas->id_materia_prima}})"
                                                class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                                            </th>
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
                    <h4 class="sub-title">AREA DE CORTE PLANCHA</h4>
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
                        <label class="col-sm-1 col-form-label">Cantidad (und)</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control @error('area_corte') is-invalid @enderror"
                                name="area_corte" id="cantidad_plancha" value="{{ old('area_corte') }}" placeholder="">
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
                                    <th style='display: none;'>ID</th>
                                    <th style="width: 30%">Dimensiones (mm)</th>
                                    <th style="width: 30%">Cantidad (und)</th>
                                    <th style="width: 30%">Peso Unitario (kg)</th>
                                    <th style="width: 30%">Peso Total (kg)</th>
                                    <th style="width: 10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                   $data = json_decode(old('_caracteristicas'));
                                @endphp
                              @if($data && isset($data->area_corte))
                              @foreach($data->area_corte as $area_corte)
                                <tr>
                                    <td style='display: none;' id='id_area_corte'>{{$area_corte->id_area_corte}}</td>
                                    <td id='dimensiones_corte'>{{$area_corte->dimensiones_corte}}</td>
                                    <td id='cantidad_corte'>{{$area_corte->cantidad_corte}}</td>
                                    <td id='pesounitario_corte'>{{number_format($area_corte->pesounitario_corte, 2, '.', '')}}</td>
                                    <td id='pesototal_corte'>{{number_format($area_corte->pesototal_corte, 2, '.', '')}}</td>
                                    <th style='text-align: center;'>
                                        <button type="button" onclick="EliminarDetalleAreaC({{$area_corte->id_area_corte}})" class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                                    </th>
                                </tr>
                                @endforeach
                            @else
                                @foreach ($AreaCorte as $AreaCortes)
                                <tr>
                                    <td style='display: none;' id='id_area_corte'>{{$AreaCortes->id_area_corte}}</td>
                                    <td id='dimensiones_corte'>{{$AreaCortes->dimensiones}}</td>
                                    <td id='cantidad_corte'>{{$AreaCortes->cantidad}}</td>
                                    <td id='pesounitario_corte'>{{number_format($AreaCortes->peso_unit, 2, '.', '')}}</td>
                                    <td id='pesototal_corte'>{{number_format($AreaCortes->peso_total, 2, '.', '')}}</td>
                                    <th style='text-align: center;'>
                                        <button type="button" onclick="EliminarDetalleAreaC({{$AreaCortes->id_area_corte}})" class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                                    </th>
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
                            placeholder="">{{$aprov->observaciones}}</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <br>
    <div class="d-grid gap-2 d-md-block float-left">
        <a class="btn btn-primary" type="button"
            href="{{ route('cencaprovechamientos.show', $aprov->id_aprovechamiento) }}">
            <i class="fa fa-eye"></i>Ver
        </a>
    </div>
    <input type="hidden" name="_caracteristicas" id="_caracteristicas">
    <div class="d-grid gap-2 d-md-block float-right">
        <button type="button" value="Enviar" id="enviar" class="btn btn-primary" onclick="CapturarDatosSelect()">
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
    var ListaParteConaps = '{{ url("ListaParteConaps") }}';
    var ListaParteEspesor = '{{ url("ListaParteEspesor") }}';
    var MaterialProcesados = '{{ url("MaterialProcesado") }}';
    var EliminarDetalleAreaCorte = "{{ url('eliminardetalleareacorte') }}"; 
    var EliminarDetalleMateriaPrima = "{{ url('eliminardetallemateriaprima') }}"; 
    var EliminarDocumentoAprovechamiento = "{{ url('eliminardocumentoaprovechamiento') }}";
    var MostrarMateriaPrima = '{{ url("mostrarmateriaprima") }}';
    var ruta = "{{ url('cencaprovechamientos') }}";
</script>

<script type="text/javascript" src="{{ asset('libraries\assets\js\CencAprovechamiento-edit.js') }}"></script>
@endsection