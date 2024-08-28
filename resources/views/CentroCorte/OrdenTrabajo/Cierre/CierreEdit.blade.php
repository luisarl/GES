@extends('layouts.master')

@section('titulo', 'Cierre')

@section('titulo_pagina', 'Cierre')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('cencseguimiento.index') }}">Seguimiento</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('cenccierre.index') }}">Cierre</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjAlerta')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

{{-- @include('CentroCorte.OrdenTrabajo.Cierre.CierreFinalizar') --}}


<form method="POST" id="FormCierre"
        action=" {{ isset($CierrePlancha) ? route('cenccierre.update', $CierrePlancha->id_cierre_planchas, ['IdCierrePlancha' => $CierrePlancha->id_cierre_planchas]) : route('cenccierre.store', ['IdCierrePlancha' => $CierrePlancha->id_cierre_planchas]) }}"
        enctype="multipart/form-data">

        @if(isset($CierrePlancha))
        @method("put")
        @endif
        @csrf 

 <div class="card">
        <div class="card-block">
            <h4 class="sub-title">CORTES</h4>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Fecha</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="fecha_creado_cortes" id="fecha_creado_cortes"
                        value="{{ old('fecha_creado_cortes') }}" placeholder="">
                </div>

                <label class="col-sm-1 col-form-label p-r-0">CNC Aprov</label>
                <div class="col-sm-2">
                    <input type="text" name="cnc_aprovechamiento" id="cnc_aprovechamiento"
                        class="form-control @error('cnc_aprovechamiento') is-invalid @enderror"
                        value="{{ old('cnc_aprovechamiento') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Piezas Anidadas</label>
                <div class="col-sm-2">
                    <input type="number" name="piezas_anidadas" id="piezas_anidadas"
                        class="form-control @error('piezas_anidadas') is-invalid @enderror"
                        value="{{ old('piezas_anidadas') }}">
                </div>

                <label class="col-sm-1 form-label p-r-0">Piezas Cortadas</label>
                <div class="col-sm-2">
                    <input type="number" name="piezas_cortadas" id="piezas_cortadas"
                        class="form-control @error('piezas_cortadas') is-invalid @enderror"
                        value="{{ old('piezas_cortadas') }}">
                </div>
                <label class="col-sm-1 col-form-label p-r-0">Piezas Dañadas</label>
                <div class="col-sm-2">
                    <input type="number" name="piezas_danadas" id="piezas_danadas"
                        class="form-control @error('piezas_danadas') is-invalid @enderror"
                        value="{{ old('piezas_danadas') }}">
                </div>

                <label class="col-sm-1 form-label p-r-0">Longitud de Corte (MM)</label>
                <div class="col-sm-2">
                    <input type="number" name="longitud_corte" id="longitud_corte"
                        class="form-control @error('longitud_corte') is-invalid @enderror"
                        value="{{ old('longitud_corte') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Nro. Perf</label>
                <div class="col-sm-2">
                    <input type="number" name="numero_perforaciones" id="numero_perforaciones"
                        class="form-control @error('numero_perforaciones') is-invalid @enderror"
                        value="{{ old('numero_perforaciones') }}" placeholder="">
                </div>

                    <div class="col-sm-9">
                        <div class="float-right">
                            <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarCortes()">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" title="Limpiar" onClick="LimpiarCamposCortes()">
                                <i class="icofont icofont-brush"></i>
                            </button>
                        </div>
                    </div>
                </div>

            <br>
            
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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = json_decode(old('datos_cierre'));
                        @endphp
                        @if($data && isset($data->tabla_cortes))
                        @foreach($data->tabla_cortes as $cortes)
                        <tr>
                            <td id='id_cortes'> {{$cortes->id_cierre_pl_cortes}}</td>
                            <td id='fecha_creado_cortes'> {{$cortes->fecha_creado}}</td>
                            <td id='cnc_aprovechamiento'> {{$cortes->cnc_aprovechamiento}}</td>
                            <td class='piezas_anidadas' id='piezas_anidadas'> {{$cortes->piezas_anidadas}}</td>
                            <td class='piezas_cortadas' id='piezas_cortadas'> {{$cortes->piezas_cortadas}}</td>
                            <td class='piezas_danadas' id='piezas_danadas'> {{$cortes->piezas_danadas}}</td>
                            <td class='longitud_corte' id='longitud_corte'> {{number_format($cortes->longitud_corte, 2, '.', '')}}</td>
                            <td class='numero_perforaciones' id='numero_perforaciones'> {{$cortes->numero_perforaciones}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleC({{$cortes->id_cierre_pl_cortes}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @else
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
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleC({{$CierrePlanchaCorte->id_cierre_pl_cortes}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <thead>
                        <tr class="background-primary">
                            <th> </th>
                            <th colspan="2">TOTAL</th>
                            <th id="total_piezas_anidadas"> </th>
                            <th id="total_piezas_cortadas"> </th>
                            <th id="total_piezas_danadas"> </th>
                            <th id="total_longitud_cortes"> </th>
                            <th id="total_nro_perforacion"> </th>
                            <th> </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    
  {{--   <div class="card">
        <div class="card-block">
            <h4 class="sub-title">CONSUMIBLES USADOS</h4>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Fecha</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="fecha_creado_consumible" id="fecha_creado_consumible"
                        value="{{ old('fecha_creado_consumible') }}" placeholder="">
                </div>
            </div>

            <div class="form-group row"> 
                <label class="col-sm-1 col-form-label p-r-0">Consumible</label>
                
                @if ($CierrePlancha->id_tecnologia == 1)
                        <div class="col-md-3 col-lg-3">
                            <select name="consumible_usado" id="consumible_usado" class="js-example-basic-single form-control
                            @error('consumible_usado') is-invalid @enderror">
                                <option value="0" disabled selected>Seleccione el consumible</option>
                                <option value="OXIGENO">OXIGENO</option>
                                <option value="GAS PROPANO">GAS PROPANO</option>
                                @foreach($Inserto as $Insertos)
                                    <option value="">INSERTO {!! $Insertos !!}</option>
                                @endforeach
                            </select>
                        </div>
                @else
                        <div class="col-md-3 col-lg-3">
                            <select name="consumible_usado" id="consumible_usado" class="js-example-basic-single form-control 
                            @error('consumible_usado') is-invalid @enderror">
                                <option value="0" disabled selected>Seleccione el consumible</option>
                                <option value="OXIGENO">OXIGENO</option>
                                <option value="JUEGO DE ANTORCHA {{$CierrePlancha->juego_antorcha}}">JUEGO DE ANTORCHA {{$CierrePlancha->juego_antorcha}}</option>
                                @foreach($Inserto as $Insertos)
                                    <option value="{!! $Insertos !!}">INSERTO {!! $Insertos !!}</option>
                                @endforeach
                            </select>
                        </div>
                @endif

                <label class="col-sm-1 col-form-label p-r-0">Consumo</label>
                <div class="col-sm-3">
                    <input type="text" name="consumo_consumible" id="consumo_consumible"
                        class="form-control @error('consumo_consumible') is-invalid @enderror"
                        value="{{ old('consumo_consumible') }}">
                </div>

                <label class="col-sm-1 col-form-label p-r-0">Observación</label>
                <div class="col-sm-3">
                    <input type="text" name="observacion_consumible" id="observacion_consumible"
                        class="form-control @error('observacion_consumible') is-invalid @enderror"
                        value="{{ old('observacion_consumible') }}">
                </div>
            </div>
      
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="float-right">
                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarConsumible()">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" title="Limpiar" onClick="LimpiarCamposConsumible()">
                            <i class="icofont icofont-brush"></i>
                        </button> 
                    </div>
                </div>
            </div>
      <br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-styling" id="TablaConsumible">
                    <thead>
                        <tr class="background-primary">
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Consumible</th>
                            <th>Consumo</th>
                            <th>Unidad</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = json_decode(old('datos_cierre'));
                        @endphp
                        @if($data && isset($data->tabla_consumibles))
                        @foreach($data->tabla_consumibles as $consumibles)
                        <tr>
                            <td id='id_consumible'> {{$consumibles->id_cierre_pl_consumible}}</td>
                            <td id='fecha_creado_consumible'> {{$consumibles->fecha_creado}}</td>
                            <td id='consumible_usado'> {{$consumibles->consumible_usado}}</td>
                            <td id='consumo_consumible'> {{number_format($consumibles->consumo_consumible, 2, '.', '')}}</td>
                            <td id='unidad_consumible'> {{$consumibles->unidad_consumible}}</td>
                            <td id='observacion_consumible'> {{$consumibles->observacion_consumible}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleCon({{$consumibles->id_cierre_pl_consumible}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @else
                        @foreach($CierrePlanchaConsumible as $CierrePlanchaConsumibles)
                        <tr>
                            <td id='id_consumible'> {{$CierrePlanchaConsumibles->id_cierre_pl_consumible}}</td>
                            <td id='fecha_creado_consumible'> {{$CierrePlanchaConsumibles->fecha_creado}}</td>
                            <td id='consumible_usado'> {{$CierrePlanchaConsumibles->consumible}}</td>
                            <td id='consumo_consumible'> {{number_format($CierrePlanchaConsumibles->consumo, 2, '.', '')}}</td>
                            <td id='unidad_consumible'> {{$CierrePlanchaConsumibles->unidad}}</td>
                            <td id='observacion_consumible'> {{$CierrePlanchaConsumibles->observaciones}}</td>    
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleCon({{$CierrePlanchaConsumibles->id_cierre_pl_consumible}})"
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>  --}}

    <div class="card" id="materia_prima_sobrante">
        <div class="card-block">
            <h4 class="sub-title">MATERIA PRIMA SOBRANTE</h4>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Fecha</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" name="fecha_creado_sobrante" id="fecha_creado_sobrante"
                        value="{{ old('fecha_creado_sobrante') }}" placeholder="">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Descripción</label>
                <div class="col-sm-4">
                    <input type="text" name="descripcion_sobrante" id="descripcion_sobrante"
                        class="form-control @error('descripcion_sobrante') is-invalid @enderror"
                        value="{{ old('descripcion_sobrante') }}">
                </div>
                <label class="col-sm-1 form-label p-r-0">Referencia</label>
                <div class="col-sm-2">
                    <input type="text" name="referencia_sobrante" id="referencia_sobrante"
                        class="form-control @error('referencia_sobrante') is-invalid @enderror"
                        value="{{ old('referencia_sobrante') }}">
                </div>
                <label class="col-sm-1 col-form-label p-r-0">Cantidad</label>
                <div class="col-sm-1">
                    <input type="number" name="cantidad_sobrante" id="cantidad_sobrante"
                        class="form-control @error('cantidad_sobrante') is-invalid @enderror"
                        value="{{ old('cantidad_sobrante') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label p-r-0">Ubicación</label>
                <div class="col-sm-4">
                    <input type="text" name="ubicacion_sobrante" id="ubicacion_sobrante"
                        class="form-control @error('ubicacion_sobrante') is-invalid @enderror"
                        value="{{ old('ubicacion_sobrante') }}">
                </div>
                <label class="col-sm-1 col-form-label p-r-0">Observación</label>
                <div class="col-sm-4">
                    <input type="text" name="observacion_sobrante" id="observacion_sobrante"
                        class="form-control @error('observacion_sobrante') is-invalid @enderror"
                        value="{{ old('observacion_sobrante') }}">
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarMateriaPrimaSobrante()">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" title="Limpiar" onClick="LimpiarMateriaPrimaSobrante()">
                        <i class="icofont icofont-brush"></i>
                    </button> 
                </div>
            </div>
            <br>

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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                           $data = json_decode(old('datos_cierre'));
                        @endphp
                      @if($data && isset($data->tabla_sobrante))
                      @foreach($data->tabla_sobrante as $sobrantes)
                        <tr>
                            <td id='id_sobrante'>{{$sobrantes->id_cierre_pl_sobrante}}</td>
                            <td id='fecha_creado_sobrante'> {{$sobrantes->fecha_creado}}</td>
                            <td id='descripcion_sobrante'>{{$sobrantes->descripcion_sobrante}}</td>
                            <td id='referencia_sobrante'>{{$sobrantes->referencia_sobrante}}</td>
                            <td id='cantidad_sobrante'>{{$sobrantes->cantidad_sobrante}}</td>
                            <td id='ubicacion_sobrante'>{{$sobrantes->ubicacion_sobrante}}</td>
                            <td id='observacion_sobrante'>{{$sobrantes->observacion_sobrante}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleTablaSobrante({{$sobrantes->id_cierre_pl_sobrante}})" 
                                    class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                            </th>
                        </tr>
                        @endforeach
                    @else
                        @foreach ($CierrePlanchaSobrante as $CierrePlanchaSobrantes)
                        <tr>
                            <td id='id_sobrante'>{{$CierrePlanchaSobrantes->id_cierre_pl_sobrante}}</td>
                            <td id='fecha_creado_sobrante'> {{$CierrePlanchaSobrantes->fecha_creado}}</td>
                            <td id='descripcion_sobrante'>{{$CierrePlanchaSobrantes->descripcion}}</td>
                            <td id='referencia_sobrante'>{{$CierrePlanchaSobrantes->referencia}}</td>
                            <td id='cantidad_sobrante'>{{$CierrePlanchaSobrantes->cantidad}}</td>
                            <td id='ubicacion_sobrante'>{{$CierrePlanchaSobrantes->ubicacion}}</td>
                            <td id='observacion_sobrante'>{{$CierrePlanchaSobrantes->observacion}}</td>
                            <th style='text-align: center;'>
                                <button type="button" onclick="EliminarDetalleTablaSobrante({{$CierrePlanchaSobrantes->id_cierre_pl_sobrante}})" 
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

<br>
            <input type="hidden" name="datos_cierre" id="datos_cierre">
            <div class="d-grid gap-2 d-md-block float-right">

                <button type="button" value="Enviar" id="enviar" class="btn btn-primary" OnClick="CapturarDatosCierre()">
                    <i class="fa fa-save"></i>Guardar
                </button>
            </div>
        </form>

@endsection

@section('scripts')
<!-- data-table js -->
<script src="{{ asset('libraries\bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\data-table\js\jszip.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\data-table\js\pdfmake.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\data-table\js\vfs_fonts.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.print.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}"></script>
<!-- Custom js -->
<script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>
<!-- sweet alert js -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>

<script src="{{ asset('libraries\assets\pages\form-masking\inputmask.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\form-masking\jquery.inputmask.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\form-masking\form-mask.js') }}" type="text/javascript"></script>

<script>
    var EliminarDetalleCortes = "{{ url('cenceliminardetallecortes') }}";
    var EliminarDetalleSobrante = "{{ url('cenceliminardetallesobrante') }}"; 
</script>

<script src="{{ asset('libraries\assets\js\CencCierre.js') }}"></script>
@endsection