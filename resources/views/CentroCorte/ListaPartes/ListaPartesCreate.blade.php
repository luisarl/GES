@extends('layouts.master')

@section('titulo', 'Lista Partes')

@section('titulo_pagina', 'Lista Partes')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item"><a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a></li>
        <li class="breadcrumb-item"><a href="#!">Centro de Corte</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('cenclistapartes.index') }}">Lista Partes</a></li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')


<form method="POST" action="{{ route('cenclistapartes.store') }}" enctype="multipart/form-data">
    @csrf
   
    <div class="card">
        <div class="card-header">
            <h5>Crear Lista Partes</h5>
        </div>
        <div class="card-block">
            <div class="form-group row">
                <label class="col-sm-2 form-label">Nro CONAP</label>
                <div class="col-sm-3 @error('nro_conap_lp') is-invalid @enderror">
                    <select name="nro_conap_lp" id="nro_conap_lp" class="js-example-basic-single form-control">
                        <option value="0">SELECCIONE EL NRO CONAP</option>
                        @foreach ($conaps as $conap)
                        <option value="{{ $conap->id_conap }}"
                            @if ($conap->id_conap==old('id_conap')) selected="selected" @endif>{{ $conap->nro_conap }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <label class="col-sm-1 col-form-label">Tipo</label>
                <div class="col-sm-2 @error('select_tipo') is-invalid @enderror">
                    <select name="select_tipo" id="select_tipo" class="js-example-basic-single form-control" onchange="miCard()">
                        <option disabled selected></option>
                        <option value="PLANCHAS">PLANCHAS</option>
                        <option value="PERFILES">PERFILES</option>
                    </select>
                </div>
                {{-- <label class="col-sm-1 form-label" style="padding-right:0px;">Perforación</label>
                <div class="col-sm-3 @error('perforacion') is-invalid @enderror">
                    <select name="perforacion" id="perforacion" class="js-example-basic-single form-control" onchange="miCardPerforacion()">
                        <option value="0">SELECCIONE</option>
                        <option value="si">SI</option>
                        <option value="no">NO</option>
                    </select>
                </div> --}}
            </div>    
        </div>
    </div>

    {{-- PLANCHAS --}}
    <div id="miCardPlanchas1" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h5>PLANCHAS</h5>
            </div>
            <div class="card-block">
                
                    <div class="form-group row"> 
                        <label class="col-sm-2 col-form-label">Nro. Parte</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="nroparte_pla" id="_nroparte_pla" 
                            value="{{ old('nroparte_pla') }}" placeholder="">
                        </div>
                        <label class="col-sm-1 col-form-label p-r-0">Descripción</label>
                        <div class="col-sm-3">
                            <input type="text" rows="3" cols="2" class="form-control" name="descripcion_pla" id="_descripcion_pla"
                                placeholder="Sea específico y detallado">{{ old('descripcion_pla') }}
                        </div>
                        <label class="col-sm-1 form-label p-r-0">Prioridad</label>
                        <div class="col-sm-2 @error('prioridad_pla') is-invalid @enderror">
                            <select name="prioridad_pla" id="_prioridad_pla" class="j+0s-example-basic-single form-control">
                                <option value="0">SELECCIONE</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Dimensiones (mm)</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" name="dimensiones_pla1" id="_dimensiones_pla1" 
                                value="{{ old('dimensiones_pla1') }}" placeholder="mm">
                            </div>
                            <div>x</div>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" name="dimensiones_pla2" id="_dimensiones_pla2" 
                                value="{{ old('dimensiones_pla2') }}" placeholder="mm">
                            </div>

                        <label class="col-sm-1 col-form-label">Espesor (mm)</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="espesor_pla" id="_espesor_pla" 
                            value="{{ old('espesor_pla') }}" placeholder="mm">
                        </div>
                        <label class="col-sm-1 col-form-label p-r-0">Cant. Piezas (und)</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="cantpiezas_pla" id="_cantpiezas_pla"
                            value="{{ old('cantpiezas_pla') }}" placeholder="und">
                        </div>
                      
                        {{-- <div id="ocultarAgregarPlancha">
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTablaPlanchaSP()">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div> 
                        </div> --}}
                    </div>
                    <br>
                    {{-- DATOS PERFORACIONES PLANCHAS--}}
                    <div>
                    <h4 class="sub-title">Perforaciones</h4>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Diámetro de perforación (m)</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="diametro_perf_pla" id="_diametro_perf_pla"
                                value="{{ old('diametro_perf_pla') }}" placeholder="m">
                        </div>
                        <label class="col-sm-2 col-form-label">Cantidad de perforación (und)</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" name="cant_perf_pla" id="_cant_perf_pla"
                                value="{{ old('cant_perf_pla') }}" placeholder="und">
                        </div>
                        <div id="ocultarAgregarPlancha" class="col-sm-4"> <!-- Nuevo contenedor para los botones -->
                            <div class="row"> <!-- Row para alinear los botones horizontalmente -->
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTablaPlanchaCP()">
                                        <i class="fa fa-plus"></i>
                                    </button> 
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-danger btn-sm" title="Limpiar" onClick="LimpiarCampos()">
                                        <i class="fa fa-trash"></i>
                                    </button> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- TABLA DE PLANCHAS --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tablaplacp">
                            <thead>
                                <tr>
                                    <th style="width: 5%">Nro. Parte</th>
                                    <th style="width: 5%">Prioridad</th>
                                    <th style="width: 10%">Descripción</th>
                                    <th style="width: 15%">Dimensiones (mm)</th>
                                    <th style="width: 10%">Espesor (mm)</th>
                                    <th style="width: 10%">Cant. Piezas (und)</th>
                                    <th style="width: 10%">Peso Unit (Kg)</th>   
                                    <th style="width: 5%">Peso Total (Kg)</th>
                                    <th style="width: 5%">Diámetro (m)</th>
                                    <th style="width: 5%">Cant. Perf (und)</th>
                                    <th style="width: 5%">Cant. Total Perf (und)</th>
                                    <th style="width: 5%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>   

        <div class="card">
            <div class="card-block" name="card_observaciones_plancha" id="card_observaciones_plancha">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Observaciones</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3"
                            class="form-control @error('observaciones_lista') is-invalid @enderror"
                            name="observaciones_lista" id="observaciones_lista"
                            placeholder="">{{ old('observaciones_lista') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="datos_lplancha" id="datos_lplancha">
        <div class="d-grid gap-2 d-md-block float-right">
            <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTablaPlancha()">
                <i class="fa fa-save"></i>Guardar
            </button>
        </div>

    </div>


     {{-- PERFILES --}}
     <div id="miCardPerfiles2" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h5>PERFILES</h5>
            </div>
            <div class="card-block">
                    <div class="form-group row"> 
                        <label class="col-sm-2 col-form-label">Nro. Parte </label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="nroparte_per" id="nroparte_per" 
                            value="{{ old('id_nroparte_per') }}" placeholder="">
                        </div>
                        <label class="col-sm-1 col-form-label">Tipo</label>
                        <div class="col-sm-3 @error('id_equipo') is-invalid @enderror">
                            <select name="tipo_per" id="tipo_per" class="j+0s-example-basic-single form-control">
                            <option value="0">SELECCIONE</option>
                            @foreach ($fichas as $ficha)
                            <option value="{{ $ficha->id_ficha . ' - ' . $ficha->nombre_ficha }}"
                                @if ($ficha->id_ficha==old('id_ficha')) selected="selected" @endif>{{ $ficha->nombre_ficha }}
                            </option>
                            @endforeach
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label" style="padding-right: 0px;">Cant. Piezas (und)</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="cantidad_piezas_per" id="cantidad_piezas_per" 
                            value="{{ old('id_cantidad_per') }}" placeholder="unidad">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 form-label" style="padding-right:0px;">Prioridad</label>
                        <div class="col-sm-2 @error('id_almacen') is-invalid @enderror">
                            <select name="prioridad_per" id="prioridad_per" class="j+0s-example-basic-single form-control">
                                <option value="0">SELECCIONE</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <label class="col-sm-1 col-form-label" style="padding-right: 0px;">Longitud Pieza (mm)</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="longitud_pieza_per" id="longitud_pieza_per" 
                            value="{{ old('id_cantidad_per') }}" placeholder="mm">
                        </div>
                        <label class="col-sm-1 form-label" style="padding-right:0px;">Tipo de corte</label>
                        <div class="col-sm-2 @error('id_almacen') is-invalid @enderror">
                            <select name="tipo_corte_per" id="tipo_corte_per" class="j+0s-example-basic-single form-control">
                                <option value="0">SELECCIONE</option>
                                <option value="0°">0°</option>
                                <option value="Angular">Angular</option>
                            </select>
                        </div>
                        {{-- <div id="ocultarAgregarPerfil">
                            {{-- <label class="col-sm-2 col-form-label">Agregar</label> 
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTablaPerfilesSP()">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div> --}}
                    </div>
                    <br>
                    {{-- DATOS PERFORACIONES --}}
                    <div>
                    <h4 class="sub-title">Perforaciones</h4>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Diámetro de perforación (mm)</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control "  name="diametro_perf_per" id="diametro_perf_per"
                            value="{{ old('diametro_perf_per') }}" placeholder="mm">
                        </div>
                        <label class="col-sm-2 col-form-label" style="text-align:right">Cantidad Ala (T)(mm)</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" name="cantidad_t_per" id="cantidad_t_per"
                            value="{{ old('cantidad_t_per') }}" placeholder="mm">
                        </div>
                        <label class="col-sm-2 col-form-label" style="text-align:right">Cantidad Alma (S)(mm)</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" name="cantidad_s_per" id="cantidad_s_per"
                            value="{{ old('cantidad_s_per') }}" placeholder="mm">
                        </div>
                        <div id="ocultarAgregarPerfil" class="col-sm-3">
                            <div class="row"> 
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTablaPerfilesCP()">
                                        <i class="fa fa-plus"></i>
                                    </button> 
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-danger btn-sm" title="Limpiar" onClick="LimpiarCampos()">
                                        <i class="fa fa-trash"></i>
                                    </button> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    
                    {{-- TABLA DE PERFILES --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tablaper_cp">
                            <thead>
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
                                    <th style="width: 5%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-block" name="card_observaciones_perfil" id="card_observaciones_perfil">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Observaciones</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3"
                            class="form-control @error('observaciones_lista') is-invalid @enderror"
                            name="observaciones_lista" id="observaciones_lista"
                            placeholder="">{{ old('observaciones_lista') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="datos_lperfil" id="datos_lperfil">
        <div class="d-grid gap-2 d-md-block float-right">
            <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTablaPerfil()">
                <i class="fa fa-save"></i>Guardar
            </button>
        </div>

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
    <script src="{{ asset('libraries\assets\js\CencListaPartesTabla.js') }}" type="text/javascript"></script>
@endsection