@extends('layouts.master')

@section('titulo', 'Crear Consumible')

@section('titulo_pagina', 'Crear Consumible')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('cencconsumibles.index')}}">Centro de Corte</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('cencconsumibles.index') }}">Consumible</a></li>
        <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
    </ul>
@endsection

@section('contenido')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h5>Crear Consumibles</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form class="" method="POST" action=" {{ route('cencconsumibles.store') }}">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control @error('nombre_consumible') is-invalid @enderror" name="nombre_consumible"
                        value="{{ old('nombre_consumible') }}" placeholder="Ingrese el Nombre del Consumible">
                </div>
                <label class="col-sm-2 col-form-label">Unidad de medida</label>
                <div class="col-sm-4">
                    <select name="unidad_consumible" id="unidad_consumible" class="js-example-basic-multiple form-control @error('responsables') is-invalid @enderror">
                        <option value="0">Seleccione</option>
                        <option value="unidad">Unidad</option>
                        <option value="mm">mm</option>
                        <option value="kg/cm2">kg/cm2</option>
                        <option value="m3/min">m3/min</option>
                        <option value="mm/min">mm/min</option>
                        <option value="lt/min">lt/min</option>
                        <option value="m/min">m/min</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="3" cols="3" class="form-control @error('descripcion_consumible') is-invalid @enderror" name="descripcion_consumible"
                        placeholder="Ingrese la Descripción del Consumible">{{ old('descripcion_consumible') }}</textarea>
                </div>
            </div>
            <hr>
            <div class="float-right">
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
<!-- personalizado -->
<script>
    var ruta = "{{ url('cenctablasconsumo') }}";
</script>


<script>

    $(document).ready(function() {
        $('#id_equipo').change(function() {
            var idEquipo = $(this).val();

            if (idEquipo !== '0') 
            {
                $.ajax({
                    url: ruta + '/obtener-tecnologias/' + idEquipo,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#id_tecnologia').empty();
                        $('#id_tecnologia').append('<option value="0">Seleccione tecnología</option>');

                        $.each(response.caracteristicas, function(index, tecnologia) {
                            $('#id_tecnologia').append('<option value="' + tecnologia.id_tecnologia + '">' + tecnologia.nombre_tecnologia + '</option>');
                        });
                    }
                });
            } else 
            {
                $('#id_tecnologia').empty();
                $('#id_tecnologia').append('<option value="0">Seleccione tecnología</option>');
            }
        });
    });
</script> 

@endsection