@extends('layouts.master')

@section('titulo', 'Tabla de consumo')

@section('titulo_pagina', 'Tabla de consumo')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('cenctablasconsumo.index') }}">Tabla de consumo</a></li>
        </li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>

@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

    <div class="card">
        <div class="card-header">
            <h5>Crear Tabla de consumo</h5>
        </div>
        <div class="card-block">
            <h4 class="sub-title"></h4>
            <form method="POST" action=" {{ route('cenctablasconsumo.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-1 col-form-label">Espesor</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control @error('espesor_consumible') is-invalid @enderror" name="espesor_consumible" id="espesor_consumible"
                            value="{{ old('espesor_consumible') }}" placeholder="Ingrese espesor">
                    </div>

                    <label class="col-sm-1 col-form-label">Equipo</label>
                    <div class="col-sm-3">
                        <div class="@error('id_equipo') is-invalid @enderror">
                            <select name="id_equipo" id="id_equipo" class="js-example-basic-single form-control">
                                <option value="0">Seleccione equipo</option>
                                @foreach ($equipos as $equipo)
                                    <option value="{{$equipo->id_equipo}}">{{$equipo->nombre_equipo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <label for="name-2" class="col-sm-1 col-form-label">Tecnologia</label>
                    <div class="col-sm-3 @error('id_tecnologia') is-invalid @enderror">
                        <select name="id_tecnologia" id="id_tecnologia" class="js-example-basic-multiple form-control">
                            <option value="0">Seleccione tecnología</option>
                        </select>
                    </div>
                    
                </div>
                <br>

                <h5 class="sub-title">Tabla de Registros</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="tabla_registros">
                        <thead>
                            <th>Parametros</th>
                            <th>Unidad</th>
                            <th>Espesor</th>
                            <th>Valor</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <br>

                <input type="hidden" name="parametros" id="parametros">
                <div class="d-grid gap-2 d-md-block float-right">
                    <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla2();">
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
<script>
    var ruta = "{{ url('cencequipos') }}";
    var rutatablaconsumo = "{{ url('cenctablasconsumo') }}";
</script>
<script src="{{asset('libraries\assets\js\CencTablasConsumo-create.js')}}"> </script>

@endsection