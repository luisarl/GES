@extends('layouts.master')

@section('titulo', 'Dashboard Control de Combustibles')

@section('titulo_pagina', 'Dashboard Control de Combustibles')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('gstadashboard')}}">Combustibles</a> </li>
    <li class="breadcrumb-item"><a href="#!">Dashboard</a> </li>
</ul>
@endsection

@section('contenido')
<div class="card">
    <div class="card-header">
        <h5>Filtros</h5>
    </div>
    <div class="card-block">
    <form method="GET" action="">

        <div class="form-group row" style="margin-bottom: 0px;">
              
            <div class="col-sm-12 col-md-2 ">
                <label class="form-label">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" min="" id=""
                    class="form-control @error('fecha_inicio') is-invalid @enderror"
                    value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '') }}">
            </div>
            
            <div class="col-sm-12 col-md-2 ">
                <label class="form-label">Fecha Fin</label>
                <input type="date" name="fecha_fin" min="" id=""
                    class="form-control @error('fecha_fin') is-invalid @enderror"
                    value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '')  }}">
            </div>
          
            <div class="col-md-2 col-lg-2">
                <label class="form-label">Tipo de Combustible</label>
                <select name="id_combustible" id="id_combustible" class="js-example-basic-single form-control" >
                    <option value="0">SELECCIONE UNA OPCION</option>
                    @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_combustible }}" @if ($tipo->id_tipo_combustible == old('id_combustible', $_GET['id_combustible'] ?? '' )) selected="selected" @endif>
                        {{ $tipo->descripcion_combustible }}
                      </option>
                    @endforeach
                </select>   
            </div>  

            <div class="col-md-2 col-lg-2">
                <div class="form-radio col-sm-1"> 
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="filtro" id="DEPARTAMENTO" value="DEPARTAMENTO" @if("DEPARTAMENTO" == old('filtro', $_GET['filtro'] ?? '')) checked @endif onClick="TipoFiltro();" checked>
                            <i class="helper"></i>Departamentos
                        </label>
                    </div>
                    <div class="radio radio-inline">
                        <label>
                            <input type="radio" name="filtro" id="VEHICULO" value="VEHICULO" @if("VEHICULO" == old('filtro', $_GET['filtro'] ?? '')) checked @endif onClick="TipoFiltro();">
                            <i class="helper"></i>Vehiculos
                        </label>
                    </div>
                </div>  
            </div>

            <div class="col-md-2 col-lg-2" id="departamentoSection">
                <label for="departamento" class="form-label">Departamentos</label>
                <select name="departamento" id="departamento" class="js-example-basic-single form-control">
                    <option value="TODOS">TODOS</option>
                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->id_departamento }}" @if ($departamento->id_departamento == old('departamento', $_GET['departamento'] ?? '' )) selected="selected" @endif>
                            {{ $departamento->nombre_departamento }}
                        </option>
                    @endforeach
                </select>
            </div>  
            <div class="col-md-2 col-lg-2"id="VehiculoSection">
                <label class="form-label">Vehiculos</label>
                <select name="id_vehiculo[]" id="id_vehiculo" class="js-example-basic-single form-control @error('id_vehiculo') is-invalid @enderror" multiple>
                    <option value="TODOS" @if ('TODOS' == old('id_vehiculo', $_GET['id_vehiculo'][0] ?? '' )) selected="selected" @endif>TODOS</option>
                    <option value="EQUIPOS"@if ('EQUIPOS' == old('id_vehiculo', $_GET['id_vehiculo'][0] ?? '' )) selected="selected" @endif>EQUIPOS</option>
                    @foreach($vehiculos as $vehiculo)
                        <option value="{{$vehiculo->placa_vehiculo}}"
                            @isset($_GET['id_vehiculo'])
                                @foreach($_GET['id_vehiculo'] as $IdVehiculo)
                                    @if ($vehiculo->placa_vehiculo == $IdVehiculo ?? '' ) selected="selected" @endif
                                @endforeach
                            @endisset
                            >
                          {{$vehiculo->modelo_vehiculo}} - {{$vehiculo->marca_vehiculo}} - {{$vehiculo->placa_vehiculo}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-1">
                <label class="form-label"> </label>
                <button type="submit" name="buscar" class="btn btn-primary" OnClick="">
                    <i class="fa fa-search"></i>Buscar
                </button>
            </div>
        </div>
    </form>
    </div> 
   </div>

<div class="card">
    <div class="card-header">
        <h5>REPORTES DE DESPACHOS</h5>
    </div>
  
    <div class="card-block">
      
            <div class="form-group row" style="margin-bottom: 0px;">
              
                <div class="col-sm-12 col-md-2">
                    <label class="form-label"> </label>
                    <div class="col-auto"id="Imprimirdepartamento">
                         <button id="btnImprimirdepartamento" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                            <i class="fa fa-print fa-2x"></i> Imprimir Detalles</button>
                    </div>
                    <div class="col-auto" id="Imprimirvehiculo">
                       <button id="btnImprimirvehiculo" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                           <i class="fa fa-print fa-2x"></i> Imprimir Detalles</button>
                   </div>
                </div>
                <div class="col-auto">
                    <label class="form-label"> </label>
                    <div class="col-auto">
                         <button id="btnImprimirAnual" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                            <i class="fa fa-print fa-2x"></i> Imprimir Reporte Anual Por Gerencias</button>
                    </div>
                </div>
                <div class="col-auto">
                    <label class="form-label"> </label>
                    <div class="col-auto">
                         <button id="btnImprimirAnualEquipos" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                            <i class="fa fa-print fa-2x"></i> Imprimir Reporte Anual Por Vehiculos</button>
                    </div>
                </div>
            </div>
    
    </div>

    <div class="card-header">
        <h5>Combustible Despachado Anual por Gerencia año</h5>
 
    </div>
    <?php
        $total_enero = 0;
        $total_febrero = 0;
        $total_marzo = 0;
        $total_abril = 0;
        $total_mayo = 0;
        $total_junio = 0;
        $total_julio = 0;
        $total_agosto = 0;
        $total_septiembre = 0;
        $total_octubre = 0;
        $total_noviembre = 0;
        $total_diciembre = 0;
    ?>
<div class="card-block">
    <div class="row">
        <table id="tabla_datos" style="display: none;">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
                @foreach($reportes as $reporte)
                    <?php
                        $total_enero += $reporte->ENERO;
                        $total_febrero += $reporte->FEBRERO;
                        $total_marzo += $reporte->MARZO;
                        $total_abril += $reporte->ABRIL;
                        $total_mayo += $reporte->MAYO;
                        $total_junio += $reporte->JUNIO;
                        $total_julio += $reporte->JULIO;
                        $total_agosto += $reporte->AGOSTO;
                        $total_septiembre += $reporte->SEPTIEMBRE;
                        $total_octubre += $reporte->OCTUBRE;
                        $total_noviembre += $reporte->NOVIEMBRE;
                        $total_diciembre += $reporte->DICIEMBRE;
                        $total_anual = $reporte->ENERO + $reporte->FEBRERO + $reporte->MARZO + $reporte->ABRIL + $reporte->MAYO + $reporte->JUNIO + $reporte->JULIO + $reporte->AGOSTO + $reporte->SEPTIEMBRE + $reporte->OCTUBRE + $reporte->NOVIEMBRE + $reporte->DICIEMBRE;
                    ?>
                    <tr>
                        <td>{{ $reporte->nombre_departamento }}</td>
                        <td class="center">{{ $reporte->ENERO }}</td>
                        <td class="center">{{ $reporte->FEBRERO }}</td>
                        <td class="center">{{ $reporte->MARZO }}</td>
                        <td class="center">{{ $reporte->ABRIL }}</td>
                        <td class="center">{{ $reporte->MAYO }}</td>
                        <td class="center">{{ $reporte->JUNIO }}</td>
                        <td class="center">{{ $reporte->JULIO }}</td>
                        <td class="center">{{ $reporte->AGOSTO }}</td>
                        <td class="center">{{ $reporte->SEPTIEMBRE }}</td>
                        <td class="center">{{ $reporte->OCTUBRE }}</td>
                        <td class="center">{{ $reporte->NOVIEMBRE }}</td>
                        <td class="center">{{ $reporte->DICIEMBRE }}</td>
                    </tr>
                @endforeach
                
                <tr>
                    <th>TOTAL</th>
                    <th>{{ $total_enero }}</th>
                    <th>{{ $total_febrero }}</th>
                    <th>{{ $total_marzo }}</th>
                    <th>{{ $total_abril }}</th>
                    <th>{{ $total_mayo }}</th>
                    <th>{{ $total_junio }}</th>
                    <th>{{ $total_julio }}</th>
                    <th>{{ $total_agosto }}</th>
                    <th>{{ $total_septiembre }}</th>
                    <th>{{ $total_octubre }}</th>
                    <th>{{ $total_noviembre }}</th>
                    <th>{{ $total_diciembre }}</th>
                </tbody>
            </table>
            <div id="grafico_departamentos_detalle" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
   
    <div class="card-header">
        <h5>Combustible Despachado Anual por Equipo</h5>
    </div>
    <?php
        $total_enero = 0;
        $total_febrero = 0;
        $total_marzo = 0;
        $total_abril = 0;
        $total_mayo = 0;
        $total_junio = 0;
        $total_julio = 0;
        $total_agosto = 0;
        $total_septiembre = 0;
        $total_octubre = 0;
        $total_noviembre = 0;
        $total_diciembre = 0;
    ?>
    <div class="card-block">
        <div class="row">
            <table id="tabla_equipos" style="display: none;">
                <thead>
                    <tr>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipos as $equipo)
                        <?php
                            $total_enero += $equipo->ENERO;
                            $total_febrero += $equipo->FEBRERO;
                            $total_marzo += $equipo->MARZO;
                            $total_abril += $equipo->ABRIL;
                            $total_mayo += $equipo->MAYO;
                            $total_junio += $equipo->JUNIO;
                            $total_julio += $equipo->JULIO;
                            $total_agosto += $equipo->AGOSTO;
                            $total_septiembre += $equipo->SEPTIEMBRE;
                            $total_octubre += $equipo->OCTUBRE;
                            $total_noviembre += $equipo->NOVIEMBRE;
                            $total_diciembre += $equipo->DICIEMBRE;
                            $total_anual = $equipo->ENERO + $equipo->FEBRERO + $equipo->MARZO + $equipo->ABRIL + $equipo->MAYO + $equipo->JUNIO + $equipo->JULIO + $equipo->AGOSTO + $equipo->SEPTIEMBRE + $equipo->OCTUBRE + $equipo->NOVIEMBRE + $equipo->DICIEMBRE;
                        ?>
                        <tr>
                            <td>{{ $equipo->marca_equipo }}</td>
                            <td>{{$equipo->placa_equipo }}</td>
                            <td class="center">{{ $equipo->ENERO }}</td>
                            <td class="center">{{ $equipo->FEBRERO }}</td>
                            <td class="center">{{ $equipo->MARZO }}</td>
                            <td class="center">{{ $equipo->ABRIL }}</td>
                            <td class="center">{{ $equipo->MAYO }}</td>
                            <td class="center">{{ $equipo->JUNIO }}</td>
                            <td class="center">{{ $equipo->JULIO }}</td>
                            <td class="center">{{ $equipo->AGOSTO }}</td>
                            <td class="center">{{ $equipo->SEPTIEMBRE }}</td>
                            <td class="center">{{ $equipo->OCTUBRE }}</td>
                            <td class="center">{{ $equipo->NOVIEMBRE }}</td>
                            <td class="center">{{ $equipo->DICIEMBRE }}</td>
                        </tr>
                    @endforeach
                    
                    <tr>
                        <th>TOTAL</th>
                        <th>{{ $total_enero }}</th>
                        <th>{{ $total_febrero }}</th>
                        <th>{{ $total_marzo }}</th>
                        <th>{{ $total_abril }}</th>
                        <th>{{ $total_mayo }}</th>
                        <th>{{ $total_junio }}</th>
                        <th>{{ $total_julio }}</th>
                        <th>{{ $total_agosto }}</th>
                        <th>{{ $total_septiembre }}</th>
                        <th>{{ $total_octubre }}</th>
                        <th>{{ $total_noviembre }}</th>
                        <th>{{ $total_diciembre }}</th>
                    </tbody>
                </table>
                <div id="grafico_equipos_detalle" style="width: 100%; height: 500px;"></div>
            </div>
        </div>



</div>

<div class="card">
    <div class="card-header">
        <h5>REPORTES DE INGRESOS</h5>
    </div>
  
    <div class="card-block">
        <div class="form-group row" style="margin-bottom: 0px;">
            
            <div class="col-sm-12 col-md-2">
                <label class="form-label"> </label>
                <div class="col-auto">
                     <button id="btnImprimirIngresos" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                        <i class="fa fa-print fa-2x"></i> Imprimir Detalles</button>
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <label class="form-label"> </label>
                <div class="col-auto">
                    <button id="btnImprimirAnualIngresos" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                        <i class="fa fa-print fa-2x"></i> Imprimir Reporte Anual
                    </button>
                </div>
            </div>
        </div>
    
        
    </div>

    <div class="card-header">
        <h5>Combustible Ingresado Anual por Gerencia</h5>
    </div>
    <?php
        $total_enero = 0;
        $total_febrero = 0;
        $total_marzo = 0;
        $total_abril = 0;
        $total_mayo = 0;
        $total_junio = 0;
        $total_julio = 0;
        $total_agosto = 0;
        $total_septiembre = 0;
        $total_octubre = 0;
        $total_noviembre = 0;
        $total_diciembre = 0;
    ?>
<div class="card-block">
    <div class="row">
        <table id="tabla_ingresos" style="display: none;">
            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
                @foreach($ingresos as $ingreso)
                    <?php
                        $total_enero += $ingreso->ENERO;
                        $total_febrero += $ingreso->FEBRERO;
                        $total_marzo += $ingreso->MARZO;
                        $total_abril += $ingreso->ABRIL;
                        $total_mayo += $ingreso->MAYO;
                        $total_junio += $ingreso->JUNIO;
                        $total_julio += $ingreso->JULIO;
                        $total_agosto += $ingreso->AGOSTO;
                        $total_septiembre += $ingreso->SEPTIEMBRE;
                        $total_octubre += $ingreso->OCTUBRE;
                        $total_noviembre += $ingreso->NOVIEMBRE;
                        $total_diciembre += $ingreso->DICIEMBRE;
                        $total_anual = $ingreso->ENERO + $ingreso->FEBRERO + $ingreso->MARZO + $ingreso->ABRIL + $ingreso->MAYO + $ingreso->JUNIO + $ingreso->JULIO + $ingreso->AGOSTO + $ingreso->SEPTIEMBRE + $ingreso->OCTUBRE + $ingreso->NOVIEMBRE + $ingreso->DICIEMBRE;
                    ?>
                    <tr>
                        <td>{{ $ingreso->nombre_departamento }}</td>
                        <td class="center">{{ $ingreso->ENERO }}</td>
                        <td class="center">{{ $ingreso->FEBRERO }}</td>
                        <td class="center">{{ $ingreso->MARZO }}</td>
                        <td class="center">{{ $ingreso->ABRIL }}</td>
                        <td class="center">{{ $ingreso->MAYO }}</td>
                        <td class="center">{{ $ingreso->JUNIO }}</td>
                        <td class="center">{{ $ingreso->JULIO }}</td>
                        <td class="center">{{ $ingreso->AGOSTO }}</td>
                        <td class="center">{{ $ingreso->SEPTIEMBRE }}</td>
                        <td class="center">{{ $ingreso->OCTUBRE }}</td>
                        <td class="center">{{ $ingreso->NOVIEMBRE }}</td>
                        <td class="center">{{ $ingreso->DICIEMBRE }}</td>
                    </tr>
                @endforeach
                
                <tr>
                    <th>TOTAL</th>
                    <th>{{ $total_enero }}</th>
                    <th>{{ $total_febrero }}</th>
                    <th>{{ $total_marzo }}</th>
                    <th>{{ $total_abril }}</th>
                    <th>{{ $total_mayo }}</th>
                    <th>{{ $total_junio }}</th>
                    <th>{{ $total_julio }}</th>
                    <th>{{ $total_agosto }}</th>
                    <th>{{ $total_septiembre }}</th>
                    <th>{{ $total_octubre }}</th>
                    <th>{{ $total_noviembre }}</th>
                    <th>{{ $total_diciembre }}</th>
                </tbody>
            </table>
            <div id="grafico_ingresos" style="width: 100%; height: 500px;"></div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h5>Cantidad de Combustible Disponible</h5>
      
    </div>
    <div class="card-block">
        <div class="row">
            
            <div class="col-md-5 col-lg-5">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Combustible</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        @php($total = 0)
                        @foreach($tipos as $tipo)
                        @php( $total += $tipo->stock)
                        <tr>
                            <td>{{$tipo->id_tipo_combustible}}</td>
                            <td>{{$tipo->descripcion_combustible}}</td>
                            <td>{{number_format($tipo->stock,2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            <div class="col-md-7 col-lg-7">
                <div id="grafico_combustible" style="width: 100%; height: 500px;"></div>
            </div>
            
        </div>
    </div>
</div>


@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>
<!-- google chart -->
<script src="{{ asset('libraries\assets\pages\chart\google\js\google-loader.js') }}"></script>
<!-- personalizado -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="{{ asset('libraries\assets\js\CntcCombustibles.js') }}"></script>
<script>


var combustible = {!! json_encode($tipos) !!};
var SolicitudesDepartamentoSolicitanteDetalle = {!! json_encode($reportes) !!};
var year = {{ $year }};


</script>
{{-- <script>
    document.getElementById('año').addEventListener('change', function() {
        // Obtener el valor del campo
        var año = this.value;
        var combustible = document.getElementById('id_combustible').value;
        // Redirigir a la misma página con el año como parámetro GET
        window.location.href = window.location.pathname + "?año=" + año+ "&id_combustible=" + combustible;
    });
</script> --}}

<script>
   document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btnImprimirvehiculo').addEventListener('click', function() {
        var combustible = document.getElementById('id_combustible').value;
        var departamento = document.getElementById('departamento').value;
        var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
        var fecha_fin = document.querySelector('input[name="fecha_fin"]').value;
        var vehiculos = Array.from(document.querySelectorAll('#id_vehiculo option:checked')).map(option => option.value);

        console.log("Fecha de inicio:", fecha_inicio);
        console.log("Fecha de fin:", fecha_fin);
        console.log("id_combustible:", combustible);
        console.log("id_vehiculo[]:", vehiculos);
        console.log("departamento:", departamento);

        var url = "{{ route('cntcreportecombustibledetallevehiculos') }}?fecha_inicio=" + fecha_inicio + "&id_combustible=" + combustible + "&fecha_fin=" + fecha_fin + "&id_vehiculo=" + vehiculos.join(",")+"&departamento=" + departamento;
        window.open(url, '_blank'); // Abre la URL en una nueva pestaña
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
     document.getElementById('btnImprimirdepartamento').addEventListener('click', function() {
         var combustible = document.getElementById('id_combustible').value;
         var departamento = document.getElementById('departamento').value;
         var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
         var fecha_fin = document.querySelector('input[name="fecha_fin"]').value;
         var vehiculos = Array.from(document.querySelectorAll('#id_vehiculo option:checked')).map(option => option.value);
 
         console.log("Fecha de inicio:", fecha_inicio);
         console.log("Fecha de fin:", fecha_fin);
         console.log("id_combustible:", combustible);
         console.log("id_vehiculo[]:", vehiculos);
         console.log("departamento:", departamento);
 
         var url = "{{ route('cntcreportecombustibledetalledepartamentos') }}?fecha_inicio=" + fecha_inicio + "&id_combustible=" + combustible + "&fecha_fin=" + fecha_fin + "&id_vehiculo=" + vehiculos.join(",")+"&departamento=" + departamento;
         window.open(url, '_blank'); // Abre la URL en una nueva pestaña
     });
 });
 </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btnImprimirIngresos').addEventListener('click', function() {
            var combustible = document.getElementById('id_combustible').value;
            var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
            var fecha_fin = document.querySelector('input[name="fecha_fin"]').value;
            
            console.log("Fecha de inicio:", fecha_inicio);
            console.log("Fecha de fin:", fecha_fin);
            console.log("id_combustible:", combustible);

            var url = "{{ route('cntcreportecombustibleingreso') }}?fecha_inicio=" + fecha_inicio + "&id_combustible=" + combustible + "&fecha_fin=" + fecha_fin;
            window.open(url, '_blank'); // Abre la URL en una nueva pestaña
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btnImprimirAnual').addEventListener('click', function() {
            var combustible = document.getElementById('id_combustible').value;
            var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
            var fecha_fin = document.querySelector('input[name="fecha_fin"]').value;
            console.log("id_combustible:", combustible);
            var url = "{{ route('cntcreportecombustibledespachoanual') }}?id_combustible=" + combustible + "&fecha_fin=" + fecha_fin+ "&fecha_inicio=" + fecha_inicio;
            window.open(url, '_blank'); // Abre la URL en una nueva pestaña
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btnImprimirAnualEquipos').addEventListener('click', function() {
            var combustible = document.getElementById('id_combustible').value;
            var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
            var fecha_fin = document.querySelector('input[name="fecha_fin"]').value;
            console.log("id_combustible:", combustible);
            var url = "{{ route('cntcreportecombustibledespachoanualequipos') }}?id_combustible=" + combustible + "&fecha_fin=" + fecha_fin+ "&fecha_inicio=" + fecha_inicio;
            window.open(url, '_blank'); // Abre la URL en una nueva pestaña
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btnImprimirAnualIngresos').addEventListener('click', function() {
            var combustible = document.getElementById('id_combustible').value;
            console.log("id_combustible:", combustible);
            var url = "{{ route('cntcreportecombustibleingresoanual') }}?id_combustible=" + combustible ;
            window.open(url, '_blank'); // Abre la URL en una nueva pestaña
        });
    });
</script>
@endsection