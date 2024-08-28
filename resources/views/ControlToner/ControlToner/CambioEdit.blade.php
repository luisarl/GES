@extends('layouts.master')

@section('titulo', 'Control de Toner')

@section('titulo_pagina', 'Control de Toner')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}"></a>Control Toner</li>
    <li class="breadcrumb-item"><a href="{{ route('cnttcontroltoner.index') }}">Editar Control de Toner</a> </li>
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>CONTROL</strong></h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('cnttcontroltoner.update',$reemplazo->id_reemplazo_toner) }}">
            @csrf
            @method('put')
            <div class="form-group row">
                <label class="col-sm-2 form-label">Fecha de Cambio</label>
                <div class="col-sm-2">
                    <input type="date" name="fecha_cambio" id="fecha_cambio" class="form-control @error('fecha_cambio') is-invalid @enderror" value="{{ $reemplazo->fecha_cambio}}">    
                </div>
               

                <label class="col-sm-2 form-label">Unidad/Departamento</label>
                <div class="col-sm-2">
                    <select name="departamento" id="departamento" class="js-example-basic-single form-control" readonly>
                        <option value="">SELECCIONE UN DEPARTAMENTO</option>
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento }}" @if ($departamento->id_departamento == old('departamento',$reemplazo->id_departamento)) selected="selected" @endif>
                                {{ $departamento->nombre_departamento }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <label class="col-sm-1 form-label">Impresora</label>
                <div class="col-sm-3">
                    <select name="activo" id="activo" class="js-example-basic-single form-control">
                        <option value="">SELECCIONE UNA IMPRESORA</option>
                        @foreach ($activos as $activo)
                        <option value="{{ $activo->id_activo }}" @if ($activo->id_activo  == old('activo',$reemplazo->id_impresora)) selected="selected" @endif>
                            {{ $activo->nombre_activo }} - {{ $activo->ubicacion }}
                        </option>
                        @endforeach
                    </select>
                </div>
               

            </div>
            <div class="form-group row">

                <label class="col-sm-2 form-label">Fecha de  Ultimo Cambio</label>
                <div class="col-sm-2">
                    <input type="date" name="fecha_ultimo_cambio" id="fecha_ultimo_cambio" class="form-control @error('fecha_ultimo_cambio') is-invalid @enderror" value="{{$reemplazo->fecha_cambio_anterior }}" readonly>    
                </div>
                <label class="col-sm-2 form-label">Contador actual</label>
                <div class="col-sm-2">
                    <input type="number" name="cantidad_actual" id="cantidad_actual" class="form-control @error('cantidad_actual') is-invalid @enderror" value="{{$reemplazo->cantidad_hojas_actual}}">
                </div>

                <label class="col-sm-1 form-label">Contador anterior</label>
                <div class="col-sm-3">
                    <input type="number" name="cantidad_anterior" id="cantidad_anterior" class="form-control @error('cantidad_anterior') is-invalid @enderror" value="{{$reemplazo->cantidad_hojas_anterior}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-label">Tipo de servicio</label>
                <div class="col-sm-2">
                    <select name="servicio" id="servicio" class="js-example-basic-single form-control">
                        <option value="">SELECCIONE UN SERVICIO</option>
                        <option value="RECARGA TONER" @if ('RECARGA TONER' == old('servicio', $reemplazo->tipo_servicio)) selected="selected" @endif>RECARGA TONER</option>
                        <option value="TONER NUEVO" @if ('TONER NUEVO' == old('servicio', $reemplazo->tipo_servicio)) selected="selected" @endif>TONER NUEVO</option>
                    </select>
                </div>

                <label class="col-sm-2 form-label">Observacion</label>
                <div class="col-sm-6">
                    <input type="text" name="observacion" id="observacion" class="form-control @error('observacion') is-invalid @enderror" value="{{ $reemplazo->observacion }}">
                </div>
            </div>
             <h4 class="sub-title">Hojas</h4>
            <div class="form-group row">
                <label class="col-sm-2 form-label">Cantidad de hojas impresas total</label>
                <div class="col-sm-1">
                    <input type="number" name="cantidad_total" id="cantidad_total" class="form-control @error('cantidad_total') is-invalid @enderror" value="{{$reemplazo->cantidad_hojas_total}}" readonly>
                </div>

                <label class="col-sm-2 form-label">Dias de duracion del toner</label>
                <div class="col-sm-1">
                    <input type="number" name="dias_total" id="dias_total" class="form-control @error('dias_total') is-invalid @enderror" value="{{$reemplazo->dias_de_duracion}}"readonly>
                </div>


            </div>

            <hr>
            <div class="d-grid gap-2 d-md-block float-right">
                <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla()">
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
    $(document).ready(function() {
    $('#departamento').change(function() {
        var departamentoId = $(this).val();
        
        if(departamentoId) {
            $.ajax({
                url: '{{ route('cnttimpresoras') }}',
                type: 'GET',
                data: {departamento: departamentoId},
                success: function(data) {
                    $('#activo').empty();
                    $('#activo').append('<option value="">SELECCIONE UNA IMPRESORA</option>');
                    $.each(data, function(key, value) {
                        $('#activo').append('<option value="'+ value.id_activo +'">'+ value.nombre_activo +'</option>');
                    });
                }
            });
        } else {
            $('#activo').empty();
            $('#activo').append('<option value="">SELECCIONE UNA IMPRESORA</option>');
        }
    });


   
    $('#activo').change(function() {
    var departamentoId = $('#departamento').val();
    var impresoraId = $(this).val();
    var fecha = $('#fecha_cambio').val();

    console.log("Impresora ID: ", impresoraId); // Agrega esta línea para depuración

    if (impresoraId) {
        $.ajax({
            url: '{{ route('cnttultimoservicio') }}',
            type: 'GET',
            data: { departamento: departamentoId, impresora: impresoraId },
            success: function(data) {
                console.log("Response data: ", data); // Agrega esta línea para depuración
                console.log(impresoraId)
                if (data && Object.keys(data).length > 0) {
                    // Actualizar los campos con la información del último servicio
                    $('#fecha_ultimo_cambio').val(data.fecha_cambio);
                    $('#cantidad_anterior').val(data.cantidad_hojas_actual);
                } else {
                    // Si no hay datos, establecer los campos a 0
                    $('#fecha_ultimo_cambio').val(fecha);
                    $('#cantidad_anterior').val('0');
                }
            },
            error: function() {
                // Manejar errores, si es necesario
                $('#fecha_ultimo_cambio').val(fecha);
                $('#cantidad_anterior').val('0');
            }
        });
    } else {
        // Limpiar los campos si no hay impresora seleccionada
        $('#fecha_ultimo_cambio').val('');
        $('#cantidad_anterior').val('');
    }


});
});
</script>
<script>
$(document).ready(function() {
    function calcularTotales() {
        var actual = parseInt($('#cantidad_actual').val()) || 0;
        var anterior = parseInt($('#cantidad_anterior').val()) || 0;

        var total = actual - anterior;
        $('#cantidad_total').val(total);

        // Obtener las fechas
        var fechaCambio = new Date($('#fecha_cambio').val());
        var fechaUltimoCambio = new Date($('#fecha_ultimo_cambio').val());

        // Calcular la diferencia en días
        var diferenciaTiempo = fechaCambio.getTime() - fechaUltimoCambio.getTime();
        var diasDuracion = diferenciaTiempo / (1000 * 3600 * 24); // Convertir de milisegundos a días

        $('#dias_total').val(diasDuracion);
    }

    // Escuchar cambios en los campos relevantes
    $('#cantidad_actual, #cantidad_anterior, #fecha_cambio, #fecha_ultimo_cambio').on('input change', calcularTotales);
});


</script>

@endsection