@extends('layouts.master')

@section('titulo', 'Control Combustible')

@section('titulo_pagina', 'Ingresos de Combustible')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Control de Combustible</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('cntcingresos.index') }}">Creacion de Ingreso</a> </li>
    <li class="breadcrumb-item"><a href="#!">Crear</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>Ingreso</strong></h4>
    </div>
    <div class="card-block">
        <form method="POST" action="{{ route('cntcingresos.store') }}">
            @csrf
            <div class="form-group row">
                <div class="col-md-3">
                    <label class="form-label">Tipo de Combustible</label>
                    <select name="id_combustible" id="id_combustible" class="js-example-basic-single form-control" >
                        <option value="">SIN ASIGNAR</option>
                        @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id_tipo_combustible }}" @if ($tipo->id_tipo_combustible == old('id_combustible', $_GET['id_combustible'] ?? '' )) selected="selected" @endif>
                            {{ $tipo->descripcion_combustible }}- CANTIDAD EN LITROS: {{number_format($tipo->stock,2)}}
                          </option>
                        @endforeach
                    </select>   
                    <input type="hidden" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock" value="" > 
                </div> 
                <div class="col-md-3">
                    <label class="form-label">Tipo de Ingreso</label>
                    <select name="id_tipo_ingreso" class="js-example-basic-single form-control" >
                        <option value="">SIN ASIGNAR</option>
                        @foreach ($TiposIngresos as $TiposIngreso)
                        <option value="{{ $TiposIngreso->id_tipo_ingresos }}" @if ($TiposIngreso->id_tipo_ingresos == old('id_tipo_ingreso', $_GET['id_tipo_ingreso'] ?? '' )) selected="selected" @endif>
                            {{ $TiposIngreso->descripcion_ingresos }}
                          </option>
                        @endforeach
                    </select>   
                </div> 
                <div class="col-md-2">
                    <label for="cantidad" class="block">Cantidad en litros</label>
                    <input type="number" class="form-control @error('cantidad') is-invalid @enderror" name="cantidad" id="cantidad" value="{{ old('cantidad') }}" min="0.10" step="0.10"> 
                </div> 
                <div class="col-md-3 col-lg-3">
                    <label for="motivo" class="form-label">Observacion</label>
                    <input type="text" name="observacion" id="observacion" class="form-control @error('observacion') is-invalid @enderror" placeholder="Ingrese observacion" value="{{ old('observacion') }}">
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

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        let selectElement = document.getElementById('id_combustible');

        // Función para actualizar el campo de stock
        function actualizarStock() {
            let selectedOption = selectElement.querySelector('option:checked');
            console.log('Selected option:', selectedOption);

            // Verifica si se encontró una opción seleccionada antes de intentar acceder a sus propiedades
            if (selectedOption) {
                // Extrae el texto de la opción seleccionada y obtiene el stock
                let stockText = selectedOption.textContent;
                console.log('Stock text:', stockText); // Depuración: Verifica el texto de la opción seleccionada

                let stockMatch = stockText.match(/CANTIDAD EN LITROS: (\d+(\.\d+)?)/); // Permitir decimales opcionales
                let stockCantidad = stockMatch ? parseFloat(stockMatch[1]) : 0;
                console.log('Stock cantidad:', stockCantidad); // Depuración: Verifica la cantidad de stock

                // Asigna el stock al campo #stock
                document.getElementById('stock').value = stockCantidad;
            } else {
                console.log("No hay ninguna opción seleccionada."); // Depuración: Informa si no hay opción seleccionada
            }
        }

        // Actualizar el campo de stock cuando se cargue la página
        actualizarStock();

        // Actualizar el campo de stock cuando se cambie la selección
        selectElement.addEventListener('change', actualizarStock);
    });
</script>
@endsection