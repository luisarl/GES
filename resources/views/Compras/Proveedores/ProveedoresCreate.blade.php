@extends('layouts.master')

@section('titulo', 'Proveedores')

@section('titulo_pagina', 'Proveedores')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Compras</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

    <div class="card">
        <div class="card-header">
            <h5>Crear Proveedor</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('proveedores.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    {{-- <label class="col-sm-2 col-form-label">Codigo</label>
                    <div class="col-sm-2">
                        <input type="text"
                            class="form-control @error('codigo_proveedor') is-invalid @enderror"
                            name="codigo_proveedor" value="{{ old('codigo_proveedor') }}"
                            placeholder="Ingrese el Codigo del Proveedor">
                    </div> --}}
                    <label class="col-sm-2 col-form-label">R.I.F</label>
                        <div class="col-sm-1 col-md-1 col-lg-1" >
                            <select name="tipo_rif" class="form-control @error('tipo_rif') is-invalid @enderror" >
                                {{-- <option value="0">Seleccione El Tipo</option> --}}
                                <option value="J" @if ("J" == old('tipo_rif')) selected = "selected" @endif> J</option>
                                <option value="V" @if ("V" == old('tipo_rif')) selected = "selected" @endif> V</option>
                                <option value="E" @if ("E" == old('tipo_rif')) selected = "selected" @endif> E</option>
                                <option value="G" @if ("G" == old('tipo_rif')) selected = "selected" @endif> G</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="text"
                                class="form-control numero_rif @error('numero_rif') is-invalid @enderror"
                                data-mask="99999999-9" name="numero_rif" value="{{ old('numero_rif') }}"
                                placeholder="Ingrese el RIF del Proveedor">
                        </div>
                        <label class="col-sm-1 col-form-label">N.I.T</label>
                        <div class="col-sm-2">
                            <input type="text"
                                class="form-control @error('nit') is-invalid @enderror"
                                name="nit" value="{{ old('nit') }}"
                                placeholder="Ingrese el NIT del Proveedor">
                        </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control @error('nombre_proveedor') is-invalid @enderror" name="nombre_proveedor" 
                        value="{{ old('nombre_proveedor') }}" placeholder="Ingrese el Nombre del Proveedor">
                    </div>
            
                    <div class="col-sm-2">
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary">
                                <input class="border-checkbox" type="checkbox" id="nacional" name="nacional" value="SI" checked>
                                <label class="border-checkbox-label" for="nacional">Nacional</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tipo</label>
                    <div class="col-md-4 col-lg-4 @error('id_tipo') is-invalid @enderror">
                        <select name="id_tipo" id="id_tipo"
                           class="js-example-basic-single form-control">
                           <option value="NO">Seleccione el Tipo </option>
                           @foreach ($tipos as $tipo)
                               <option value="{{ str_replace(' ', '',$tipo->id_tipo) }}"
                                   @if (str_replace(' ', '',$tipo->id_tipo) == old('id_tipo')) selected = "selected" @endif>
                                   {{ $tipo->nombre_tipo }}</option>
                           @endforeach
                       </select>
                   </div>
                   <label class="col-sm-1 col-form-label">Segmento</label>
                    <div class="col-md-4 col-lg-4 @error('id_segmento') is-invalid @enderror">
                        <select name="id_segmento" id="id_segmento"
                           class="js-example-basic-single form-control">
                           <option value="NO">Seleccione El Segmento </option>
                           @foreach ($segmentos as $segmento)
                               <option value="{{ str_replace(' ', '',$segmento->id_segmento) }}"
                                   @if (str_replace(' ', '',$segmento->id_segmento) == old('id_segmento')) selected = "selected" @endif>
                                   {{ $segmento->nombre_segmento }}</option>
                           @endforeach
                       </select>
                   </div>
                </div>
                {{-- <h4 class="sub-title">Datos</h4>
                <div class="form-group row">
                    
                </div> --}}
                <h4 class="sub-title">Contacto</h4>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Direccion</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('direccion') is-invalid @enderror" name="direccion"
                            placeholder="Ingrese la Direccion del Proveedor">{{ old('direccion') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pais {{old('id_pais')}}</label>
                    <div class="col-md-4 col-lg-4 @error('id_pais') is-invalid @enderror">
                        <select name="id_pais" id="id_pais"
                           class="js-example-basic-single form-control">
                           <option value="NO">Seleccione El Pais </option>
                           @foreach ($paises as $pais)
                               <option value="{{ str_replace(' ', '', $pais->id_pais) }}"
                                @if (str_replace(' ', '', $pais->id_pais) == old('id_pais')) selected = "selected" @endif>
                                    {{ $pais->nombre_pais }}</option>
                           @endforeach
                       </select>
                   </div>
                   <label class="col-sm-2 col-form-label">Zona</label>
                    <div class="col-md-4 col-lg-4 @error('id_zona') is-invalid @enderror">
                        <select name="id_zona" id="id_zona"
                           class="js-example-basic-single form-control">
                           <option value="NO">Seleccione la Zona </option>
                           @foreach ($zonas as $zona)
                               <option value="{{ str_replace(' ', '',$zona->id_zona) }}"
                                   @if (str_replace(' ', '',$zona->id_zona) == old('id_zona')) selected = "selected" @endif>
                                   {{ $zona->nombre_zona }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ciudad</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('ciudad') is-invalid @enderror" name="ciudad"
                           value="{{ old('ciudad') }}" placeholder="Ingrese la Ciudad">
                    </div>
                    <label class="col-sm-2 col-form-label">Cod Postal</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('codigo_postal') is-invalid @enderror" name="codigo_postal"
                           value="{{ old('codigo_postal') }}" placeholder="Ingrese el Codigo Postal">
                    </div>
                </div>
               
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Responsable</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('responsable') is-invalid @enderror" name="responsable"
                           value="{{ old('responsable') }}" placeholder="Ingrese el Nombre del Responsable">
                    </div>
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('correo') is-invalid @enderror" name="correo"
                           value="{{ old('correo') }}" placeholder="Ingrese el Email">
                    </div>
                </div>
                <div class="form-group row">            
                    <label class="col-sm-2 col-form-label">Telefonos</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('telefonos') is-invalid @enderror" name="telefonos"
                           value="{{ old('telefonos') }}" placeholder="Ingrese los telefonos">
                    </div>
                    <label class="col-sm-2 col-form-label">Web Site</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('website') is-invalid @enderror" name="website"
                           value="{{ old('website') }}" placeholder="Ingrese el Web Site">
                    </div>
                </div>       
                <h4 class="sub-title">Datos Municipales</h4>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">RUC</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('ruc') is-invalid @enderror" name="ruc"
                           value="{{ old('ruc') }}" placeholder="Ingrese el RUC">
                    </div>
                    <label class="col-sm-2 col-form-label">LAE</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('lae') is-invalid @enderror" name="lae"
                           value="{{ old('lae') }}" placeholder="Ingrese el LAE">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Cod. Actividad</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('codigo_actividad') is-invalid @enderror" name="codigo_actividad"
                           value="{{ old('codigo_actividad') }}" placeholder="Ingrese el Codigo">
                    </div>         
                </div>
                <h4 class="sub-title">Datos de Pago</h4>
                <div class="form-group row">
                <label class="col-sm-2 col-form-label">Cta. Juridica</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('pago1') is-invalid @enderror" name="pago1"
                           value="{{ old('pago1') }}" placeholder="">
                    </div>
                    <label class="col-sm-2 col-form-label">Cta. Personal</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('pago2') is-invalid @enderror" name="pago2"
                           value="{{ old('pago2') }}" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pago Movil</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('pago3') is-invalid @enderror" name="pago3"
                           value="{{ old('pago3') }}" placeholder="">
                    </div>
                    <label class="col-sm-2 col-form-label">Otro Pago</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('pago4') is-invalid @enderror" name="pago4"
                           value="{{ old('pago4') }}" placeholder="">
                    </div>
                </div>
                <h4 class="sub-title">Otros</h4>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tipo de persona</label>
                    <div class="col-md-4 col-lg-4 @error('tipo_persona') is-invalid @enderror">
                        <select name="tipo_persona" id="tipo_persona"
                           class="js-example-basic-single form-control">
                            <option value="0" @if (0 == old('tipo_persona')) selected = "selected" @endif>Seleccione El Tipo </option>
                            <option value="1" @if (1 == old('tipo_persona')) selected = "selected" @endif>Natural Residente</option>
                            <option value="2" @if (2 == old('tipo_persona')) selected = "selected" @endif>Natural no Residente</option>
                            <option value="3" @if (3 == old('tipo_persona')) selected = "selected" @endif>Juridica Domiciliada</option>
                            <option value="4" @if (4 == old('tipo_persona')) selected = "selected" @endif>Juridica no Domiciliada</option>
                            <option value="5" @if (5 == old('tipo_persona')) selected = "selected" @endif>Exenta</option>
                            <option value="6" @if (6 == old('tipo_persona')) selected = "selected" @endif>Tesoreria Nacional</option>
                            <option value="7" @if (7 == old('tipo_persona')) selected = "selected" @endif>Otros 1</option>
                            <option value="8" @if (8 == old('tipo_persona')) selected = "selected" @endif>Otros 2</option>
                       </select>
                   </div>
                   <div class="col-sm-2">
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary">
                                <input class="border-checkbox" type="checkbox" name="cont_especial" id="contribuyente" value="SI" onclick="retencion()">
                                <label class="border-checkbox-label" for="contribuyente">Contibuyente Especial</label>
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label" id="retencion">Retención(%)</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control autonumber @error('porc_retencion') is-invalid @enderror" name="porc_retencion" id="porc_retencion"
                           value="{{ old('porc_retencion', 0 ?? '') }}" data-v-max="100" data-v-min="0" placeholder="0.00%">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Comentario</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('comentario') is-invalid @enderror" name="comentario"
                            placeholder="Ingrese un Comentario del Proveedor">{{ old('comentario') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Documentos</label>
                    <div class="col-sm-10">
                        <input type="file" name="documento[]" id="documento" class="form-control @error('documento') is-invalid @enderror" value="{{ old('documento') }}"
                        placeholder="Solo documentos PDF" accept="application/pdf" multiple>
                    </div>
                </div>
                <hr>
                <div class="d-grid gap-2 d-md-block float-right">
                    <button type="submit" class="btn btn-primary ">
                        <i class="fa fa-save"></i>Guardar
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
      <!-- Select -->
      <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
  
      <!-- Masking js -->
      <script src="{{ asset('libraries\assets\pages\form-masking\inputmask.js') }}"></script>
      <script src="{{ asset('libraries\assets\pages\form-masking\autoNumeric.js') }} "></script>
      <script src="{{ asset('libraries\assets\pages\form-masking\jquery.inputmask.js') }}"></script>
      <script src="{{ asset('libraries\assets\pages\form-masking\form-mask.js') }} "></script>

      <!-- Proveedores -->
      <script src="{{ asset('libraries\assets\js\proveedores.js') }} "></script>

@endsection
