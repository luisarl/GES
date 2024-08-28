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
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('Compras.Proveedores.ProveedoresInactivar')

    <div class="card">
        <div class="row card-header">
            <div class=" col-6">
                <h5>Editar Proveedor</h5>
            </div>
            <div class="col-6">
                @if ($proveedor->activo == 'NO')
                    <h1 class="text-danger">PROVEEDOR INACTIVO</h1>
                @endif   
            </div> 
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form class="" method="POST" action=" {{ route('proveedores.update', $proveedor->id_proveedor) }}" enctype="multipart/form-data">
                @csrf @method('put')
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Codigo</label>
                    <div class="col-sm-2">
                        <input type="text"
                            class="form-control @error('codigo_proveedor') is-invalid @enderror"
                            name="codigo_proveedor" value="{{ old('codigo_proveedor', $proveedor->codigo_proveedor ?? '') }}"
                            placeholder="Ingrese el Codigo del Proveedor" readonly>
                    </div>
                    <label class="col-sm-1 col-form-label">R.I.F</label>
                        
                        <div class="col-sm-3">
                            <input type="text"
                                class="form-control rif @error('rif') is-invalid @enderror"
                                data-mask="a-99999999-9" name="rif" value="{{ old('rif', $proveedor->rif ?? '') }}"
                                placeholder="Ingrese el RIF del Proveedor">
                        </div>
                        <label class="col-sm-1 col-form-label">N.I.T</label>
                        <div class="col-sm-3">
                            <input type="text"
                                class="form-control @error('nit') is-invalid @enderror"
                                name="nit" value="{{ old('nit', $proveedor->nit ?? '') }}"
                                placeholder="Ingrese el NIT del Proveedor">
                        </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control @error('nombre_proveedor') is-invalid @enderror" name="nombre_proveedor" 
                        value="{{ old('nombre_proveedor', $proveedor->nombre_proveedor ?? '') }}" placeholder="Ingrese el Nombre del Proveedor">
                    </div>
            
                    <div class="col-sm-2">
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary">
                                <input class="border-checkbox" type="checkbox" id="nacional" name="nacional" value="SI" @if ($proveedor->nacional == 'SI') checked @endif>
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
                                   @if (str_replace(' ', '',$tipo->id_tipo) == old('id_tipo', str_replace(' ', '',$proveedor->id_tipo) ?? '') ) selected = "selected" @endif>
                                   {{ $tipo->nombre_tipo }}</option>
                           @endforeach
                       </select>
                   </div>
                   <label class="col-sm-1 col-form-label">Segmento</label>
                   <div class="col-md-3 col-lg-3 @error('id_segmento') is-invalid @enderror">
                       <select name="id_segmento" id="id_segmento"
                          class="js-example-basic-single form-control">
                          <option value="NO">Seleccione El Segmento </option>
                          @foreach ($segmentos as $segmento)
                              <option value="{{ str_replace(' ', '',$segmento->id_segmento) }}"
                                  @if (str_replace(' ', '',$segmento->id_segmento) == old('id_segmento', str_replace(' ', '',$proveedor->id_segmento) ?? '') ) selected = "selected" @endif>
                                  {{ $segmento->nombre_segmento }}</option>
                          @endforeach
                      </select>
                  </div>
                   <div class="col-sm-2">
                        @can('comp.proveedores.activo')
                            @if($proveedor->activo == 'SI' )
                                <button type="button" class="form-control btn btn-primary btn-sm"
                                    data-toggle="modal" data-target="#modal-inactivar-proveedor" title="Inactivar Proveedor"
                                    href="#!">
                                    <i class="fa fa-ban"></i> Inactivar Proveedor
                                </button>
                            @elseif($proveedor->activo == 'NO' )
                                <button type="button" class="form-control btn btn-primary btn-sm"
                                    data-toggle="modal" data-target="#modal-inactivar-proveedor" title="Activar Proveedor"
                                    href="#!">
                                    <i class="fa fa-ban"></i> Activar Proveedor
                                </button>
                            @endif
                        @endcan
                    </div>
                </div>
                <h4 class="sub-title">Contacto</h4>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Direccion</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('direccion') is-invalid @enderror" name="direccion"
                            placeholder="Ingrese la Direccion del Proveedor">{{ old('direccion', $proveedor->direccion ?? '') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pais</label>
                    <div class="col-md-4 col-lg-4 @error('id_pais') is-invalid @enderror">
                        <select name="id_pais" id="id_pais"
                           class="js-example-basic-single form-control">
                           <option value="NO">Seleccione El Pais </option>
                           @foreach ($paises as $pais)
                               <option value="{{ str_replace(' ', '',$pais->id_pais) }}"
                                   @if (str_replace(' ', '',$pais->id_pais) == old('id_pais', str_replace(' ', '',$proveedor->id_pais) ?? '') ) selected = "selected" @endif>
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
                                   @if (str_replace(' ', '',$zona->id_zona) == old('id_zona', str_replace(' ', '',$proveedor->id_zona) ?? '' )) selected = "selected" @endif>
                                   {{ $zona->nombre_zona }}</option>
                           @endforeach
                        </select>
                   </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Ciudad</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('ciudad') is-invalid @enderror" name="ciudad"
                           value="{{ old('ciudad', $proveedor->ciudad ?? '') }}" placeholder="Ingrese la ciudad">
                    </div>
                    <label class="col-sm-2 col-form-label">Cod Postal</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('codigo_postal') is-invalid @enderror" name="codigo_postal"
                           value="{{ old('codigo_postal', $proveedor->codigo_postal ?? '') }} " placeholder="Ingrese el Codigo Postal">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Responsable</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('responsable') is-invalid @enderror" name="responsable"
                           value="{{ old('responsable', $proveedor->responsable ?? '') }}" placeholder="Ingrese el Nombre del Responsable">
                    </div>
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('correo') is-invalid @enderror" name="correo"
                           value="{{ old('correo', $proveedor->correo ?? '') }}" placeholder="Ingrese el Email">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Telefonos</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('telefonos') is-invalid @enderror" name="telefonos"
                           value="{{ old('telefonos', $proveedor->telefonos ?? '') }} " placeholder="Ingrese los telefonos">
                    </div>
                
                    <label class="col-sm-2 col-form-label">Web Site</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('website') is-invalid @enderror" name="website"
                           value="{{ old('website', $proveedor->website ?? '') }} " placeholder="Ingrese el Web Site">
                    </div>
                </div>       
                <h4 class="sub-title">Datos Municipales</h4>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">RUC</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('ruc') is-invalid @enderror" name="ruc"
                           value="{{ old('ruc', $proveedor->ruc ?? '') }}" placeholder="Ingrese el RUC">
                    </div>
                    <label class="col-sm-2 col-form-label">LAE</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('lae') is-invalid @enderror" name="lae"
                           value="{{ old('lae', $proveedor->lae ?? '') }}" placeholder="Ingrese el LAE">
                    </div>
                </div>
                <div class="form-group row">
                <label class="col-sm-2 col-form-label">Cod. Actividad</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('codigo_actividad') is-invalid @enderror" name="codigo_actividad"
                           value="{{ old('codigo_actividad', $proveedor->codigo_actividad ?? '') }} " placeholder="Ingrese el Codigo">
                    </div>
                </div>  
                <h4 class="sub-title">Datos de pago</h4>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Cta. Juridica</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('pago1') is-invalid @enderror" name="pago1"
                           value="{{ old('pago1', $proveedor->pago1 ?? '') }}" placeholder="">
                    </div>
                    <label class="col-sm-2 col-form-label">Cta. Personal</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('pago2') is-invalid @enderror" name="pago2"
                           value="{{ old('pago2', $proveedor->pago2 ?? '') }}" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pago Movil</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('pago3') is-invalid @enderror" name="pago3"
                           value="{{ old('pago3', $proveedor->pago3 ?? '') }}" placeholder="">
                    </div>
                    <label class="col-sm-2 col-form-label">Otro Pago</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @error('pago4') is-invalid @enderror" name="pago4"
                           value="{{ old('pago4', $proveedor->pago4 ?? '') }}" placeholder="">
                    </div>
                </div>
                <h4 class="sub-title">Otros</h4>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tipo de persona</label>
                    <div class="col-md-4 col-lg-4 @error('tipo_persona') is-invalid @enderror">
                        <select name="tipo_persona" id="tipo_persona"
                           class="js-example-basic-single form-control">
                            <option value="0"> Seleccione El Tipo </option>
                            <option value="1" @if (1 == old('tipo_persona', $proveedor->tipo_persona ?? '')) selected = "selected" @endif>Natural Residente</option>
                            <option value="2" @if (2 == old('tipo_persona', $proveedor->tipo_persona ?? '')) selected = "selected" @endif>Natural no Residente</option>
                            <option value="3" @if (3 == old('tipo_persona', $proveedor->tipo_persona ?? '')) selected = "selected" @endif>Juridica Domiciliada</option>
                            <option value="4" @if (4 == old('tipo_persona', $proveedor->tipo_persona ?? '')) selected = "selected" @endif>Juridica no Domiciliada</option>
                            <option value="5" @if (5 == old('tipo_persona', $proveedor->tipo_persona ?? '')) selected = "selected" @endif>Exenta</option>
                            <option value="6" @if (6 == old('tipo_persona', $proveedor->tipo_persona ?? '')) selected = "selected" @endif>Tesoreria Nacional</option>
                            <option value="7" @if (7 == old('tipo_persona', $proveedor->tipo_persona ?? '')) selected = "selected" @endif>Otros 1</option>
                            <option value="8" @if (8 == old('tipo_persona', $proveedor->tipo_persona ?? '')) selected = "selected" @endif>Otros 2</option>
                       </select>
                   </div>
                   <div class="col-sm-2">
                        <div class="border-checkbox-section">
                            <div class="border-checkbox-group border-checkbox-group-primary">
                                <input class="border-checkbox" type="checkbox" name="cont_especial" id="contribuyente" value="SI" @if($proveedor->cont_especial == 'SI') checked @endif onclick="retencion()">
                                <label class="border-checkbox-label" for="contribuyente">Contibuyente Especial</label>
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label" id="retencion">Retención(%)</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control autonumber @error('porc_retencion') is-invalid @enderror" name="porc_retencion" id="porc_retencion"
                           value="{{ old('porc_retencion', $proveedor->porc_retencion ?? '') }}" data-v-max="100" data-v-min="0" placeholder="0.00%">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Comentario</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('comentario') is-invalid @enderror" name="comentario"
                            placeholder="Ingrese un Comentario del Proveedor">{{ old('comentario', $proveedor->comentario ?? '') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Documentos</label>
                    <div class="col-sm-10">
                        <input type="file" name="documento[]" id="documento" class="form-control @error('documento') is-invalid @enderror" value="{{ old('documento') }}"
                        placeholder="Solo documentos PDF" accept="application/pdf" multiple>
                        <br>
                        @if ($proveedor->documento != '')
                            <iframe src="{{ asset($proveedor->documento) }}" frameborder="0" height="300" class="form-control">
                            </iframe>
                        @endif
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

    @can('comp.proveedores.migrar')
        <div class="card">
            <div class="card-header">
                <h5>Enviar Proveedor a Profit</h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Listado de Empresas</h5>
                            </div>
                            <div class="card-block table-border-style">
                                <form action="{{ route('migracionproveedor') }}" method="post">   
                                    @csrf
                                    {{-- CAMPO OCULTO CON EL ID DEL PROVEEDOR --}}
                                    <input type="hidden" name="id_proveedor"
                                        value="{{ $proveedor->id_proveedor }}">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Empresa</th>
                                                <th>Alias</th>
                                                {{-- <th>BD</th> --}}
                                                <th>
                                                    <div class="checkbox-fade fade-in-primary">
                                                        <label>
                                                            <input type="checkbox" id="todos" name="todos"
                                                                value="">
                                                            <span class="cr">
                                                                <i
                                                                    class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                            </span>
                                                            <span>Marcar/Desmarcar Todos</span>
                                                        </label>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach ($empresas as $empresa)
                                                    <tr>
                                                        <td>{{ $empresa->id_empresa }}</td>
                                                        <td>{{ $empresa->nombre_empresa }}</td>
                                                        <td>{{ $empresa->alias_empresa }} </td>
                                                        {{-- <td>{{ $empresa->bd_empresa }}</td> --}}
                                                        <td>
                                                            @php
                                                                $EstatusProveedor = App\Models\Comp_Proveedores_EmpresasModel::EstatusProveedorMigracion($proveedor->id_proveedor, $empresa->id_empresa);
                                                                if ($EstatusProveedor != null) {
                                                                    $migrado = str_replace(' ', '', $EstatusProveedor->migrado);
                                                                
                                                                } else {
                                                                    $migrado = '';
                                                                }
                                                            @endphp

                                                        @if ($migrado == 'SI')  
                                                                
                                                                <div class="checkbox-fade fade-in-primary">
                                                                    <label>
                                                                        <input type="checkbox" id="empresas"
                                                                            name="empresas[]"
                                                                            value="{{ $empresa->id_empresa }}">
                                                                        <span class="cr">
                                                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                        </span>
                                                                    </label>
                                                                </div>

                                                                <label class="label label-info label-lg "
                                                                data-toggle="popover" data-placement="right"
                                                                title="MIGRADO POR:"
                                                                data-content="{{$EstatusProveedor->usuario_migracion}}">
                                                                <i class="fa fa-check-square-o text-dark"> </i> <strong
                                                                    class="text-dark"> DISPONIBLE EN PROFIT
                                                                </strong></label>
                                                            @else
                                                                <div class="checkbox-fade fade-in-primary">
                                                                    <label>
                                                                        <input type="checkbox" id="empresas"
                                                                            name="empresas[]"
                                                                            value="{{ $empresa->id_empresa }}">
                                                                        <span class="cr">
                                                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                        </span>
                                                                    </label>
                                                                </div>

                                                            @endif    
                                                        </td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-grid gap-2 d-md-block float-right">

                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-migracion" href="#!">
                                        <i class="fa fa-share-square-o"></i> Enviar
                                    </button>
                                </div>
                                @include('Compras.Proveedores.ProveedoresMigrate') 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
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

      <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function() {
            $('[data-toggle="popover"]').popover({
                html: true,
                content: function() {
                    return $('#primary-popover-content').html();
                }
            });
        });
    </script>

@endsection
