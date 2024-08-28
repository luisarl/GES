@extends('layouts.master')

@section('titulo', 'Usuarios')

@section('titulo_pagina', 'Usuarios')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Configuración</a> </li>
        <li class="breadcrumb-item"><a href="{{ asset('usuarios/') }}">Usuarios</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>
@endsection


@section('contenido')
    @include('mensajes.MsjError')
    @include('mensajes.MsjValidacion')

    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Basic Inputs Validation start -->
                <div class="card">
                    <div class="card-header">
                        <h5>Editar Usuario</h5>
                    </div>
                    <div class="card-block">
                        <form method="POST" action=" {{ route('usuarios.update', $usuario->id) }}" enctype="multipart/form-data">
                            @csrf @method('put')
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value=" {{ old('name', $usuario->name ?? '') }}" placeholder="Ingrese el Nombre">
                                </div>
                                <label class="col-sm-2 col-form-label">Nombre Usuario</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        name="username" value=" {{ old('username', $usuario->username ?? '') }}"
                                        placeholder="Ingrese el Nombre del usuario">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Correo Electronico</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value=" {{ old('email', $usuario->email ?? '') }}"
                                        placeholder="Ingrese el Correo Principal">
                                </div>
                                <label class="col-sm-2 col-form-label">Contraseña</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" value="{{ old('password') }}" placeholder="Ingrese la contraseña">
                                </div>
                            </div>  
                            <div class="form-group row">    
                                 <label class="col-sm-2 col-form-label">Departamento</label>
                                <div class="col-sm-4 @error('id_departamento') is-invalid @enderror">
                                    <select name="id_departamento" class="js-example-basic-single form-control @error('id_departamento') is-invalid @enderror">
                                        <option value="0">Seleccione el Departamento</option>
                                    @foreach ($departamentos as $departamento)
                                        <option value="{{ $departamento->id_departamento }}"
                                            @if ($departamento->id_departamento == old('id_departamento', $usuario->id_departamento ?? '')) selected = "selected" 
                                            @endif>{!! $departamento->nombre_departamento !!}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Estado</label>
                                <div class="col-sm-4">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="activo"
                                                value="SI" @if($usuario->activo == 'SI') checked @endif> Activo </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="activo"
                                                value="NO" @if($usuario->activo == 'NO') checked @endif> Inactivo </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                             <label class="col-sm-2 col-form-label">Perfil</label>
                                <div class="col-sm-4 @error('roles') is-invalid @enderror">
                                    <select name="roles" class="js-example-basic-single form-control @error('roles') is-invalid @enderror">
                                        <option value="0">Seleccione el Perfil</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" 
                                            @if ($role->name == old('roles', $usuario->roles[0]->name ?? ''))  selected = "selected"
                                        @endif>{!! $role->name !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Responsable Servicio</label>
                                <div class="col-sm-1 col-md-1 col-lg-1">
                                    <div class="checkbox-fade fade-in-primary">
                                        <label>
                                            <input type="checkbox" id="responsable_servicios" name="responsable_servicios" value="SI" @if($usuario->responsable_servicios == 'SI') checked @endif>
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <h4 class="sub-title">Agregar Permisos</h4>  
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Permisos</label>
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-primary waves-effect waves-light m-b-10" id='select-all'>
                                        Agregar Todos
                                    </button>
                                    <button type="button" class="btn btn-primary waves-effect waves-light m-b-10" id='deselect-all'>
                                        Quitar Todos
                                    </button>
                                    <select name='permisos[]' id='public-methods' class="searchable" multiple='multiple'>
                                        @foreach ($permisos as $permiso)
                                            <option value="{{ $permiso->name}}" 
                                                @php
                                                    $EncontarPermiso = $usuario->permissions->where('name', $permiso->name)->first();
                                                    $IdPermiso = is_object($EncontarPermiso) ? $EncontarPermiso->name : "";
                                                @endphp 
                                                @if ($permiso->name == old('id', $IdPermiso )) selected="selected" @endif>
                                                {{$permiso->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h4 class="sub-title m-t-30">Seleccionar Almacen y Empresa</h4>
                            <div class="form-group row">
                                <div class="col-md-4 col-lg-4">
                                    <label for="name-2" class="block">Empresa</label>
                                    <div class=" @error('') is-invalid @enderror">
                                        <select name="id_empresa" id="_empresas"
                                        class="js-example-basic-single form-control">
                                                <option value="0">Seleccione la Empresa </option>
                                            @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id_empresa }}"
                                                @if ($empresa->id_empresa == old('id_empresa')) selected = "selected" @endif>
                                                {{ $empresa->id_empresa }} - {!! $empresa->nombre_empresa !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <label for="name-2" class="block">Almacenes</label>
                                    <div class="@error('id_almacen') is-invalid @enderror">
                                        <select name="id_almacen" id="_almacenes" data-old="{{ old('id_almacen') }}"
                                            class="js-example-basic-single form-control ">
                                            <option value="0">Seleccione Almacen</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-2 col-lg-2">
                                        <label for="name-2" class="block">Agregar</label>
                                        <br>
                                        <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarAlmacenUsuario()">
                                            <i class="fa fa-plus"></i> </button>
                                    </div>
                                </div> 
                            </div>   
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tabla_almacen">
                                    <thead>
                                        <tr>
                                            <th>#</th> 
                                            <th>Empresa</th>
                                            <th>Almacen</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($almacenes as $almacen)
                                            <tr>
                                                <td>{{ $almacen->id_almacen_usuario }}</td>
                                                <td>{{$almacen->id_empresa}} - {{$almacen->nombre_empresa}}</td>
                                                <td>{{$almacen->id_almacen}} - {{$almacen->nombre_almacen}}</td>
                                                <th>
                                                        <button type="button"
                                                            onclick="EliminarAlmacenes({{ $almacen->id_almacen_usuario }})"
                                                            class="borrar btn btn-danger btn-sm"><i
                                                                class="fa fa-trash"></i></button>
                                                
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <h4 class="sub-title">Asignar Embarcacion</h4>
                            <div class="form-group row">
                                
                                <div class="col-sm-4">
                                   <label class="col-sm-4 col-form-label">Embarcacion</label> 
                                    <select name="id_embarcacion" id="id_embarcacion" class="js-example-basic-single form-control">
                                        <option value="">SELECCIONE UNA EMBARCACION</option>
                                        @foreach ($embarcaciones as $embarcacion)
                                            <option value="{{$embarcacion->id_embarcaciones}}">
                                                {{$embarcacion->id_embarcaciones}} - {{ $embarcacion->nombre_embarcaciones }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <label for="name-2" class="block">Agregar</label>
                                    <br>
                                    <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarEmbarcacionUsuario()">
                                        <i class="fa fa-plus"></i> </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="tabla_embarcaciones" name="tabla_embarcaciones">
                                    <thead>
                                        <tr>
                                            {{-- <th>#</th> --}}
                                            <th>Id</th>
                                            <th>Embarcacion</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($embarcaciones_usuarios as $embarcaciones_usuarios)
                                        <tr>
                                            <td id="id_embarcacion">{{$embarcaciones_usuarios->id_embarcaciones }}</td>
                                            <td id="nombre_embarcacion">{{$embarcaciones_usuarios->nombre_embarcaciones}}</td>
                                            <th>
                                                    <button type="button"
                                                        onclick="EliminarEmbarcaciones({{ $embarcaciones_usuarios->id_embarcaciones_usuario}})"
                                                        class="borrar btn btn-danger btn-sm"><i
                                                            class="fa fa-trash"></i></button>
                                            
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> 
                        {{-- Campo oculto con arreglo de los datos adicionales --}}
                        <input type="hidden" name="datosalmacen" id="datosalmacen">
                        <input type="hidden" name="datosembarcacion" id="datosembarcacion">
                        <div class="d-grid gap-2 d-md-block float-right">
                            <button type="submit" class="btn btn-primary" OnClick="CapturarDatosAlmacenes()">
                                <i class="fa fa-save"></i>Guardar
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body end -->
    <!-- Scroll - Vertical, Dynamic Height table end -->
@endsection

@section('scripts')
    <!-- data-table js -->

    <script
        src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
    </script>
    <!-- Custom js -->
    <script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>
    <!-- Select 2 js -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }} "></script>
    <!-- Multiselect js -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\bootstrap-multiselect\js\bootstrap-multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\bower_components\multiselect\js\jquery.multi-select.js') }} "></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\js\jquery.quicksearch.js') }} "></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
    
    <!--Personalizado -->
    <script src="{{ asset('libraries\assets\js\usuarios-edit.js') }}"></script>
    <script>
        var eliminaralmacenes = "{{ url('eliminaralmacenes') }}";
        var eliminarembarcaciones = "{{ url('eliminarembarcaciones') }}";
    </script>

@endsection
