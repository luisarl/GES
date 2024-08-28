@extends('layouts.master')

@section('titulo', 'Dashboard Control de Toner')

@section('titulo_pagina', 'Dashboard Control de Toner')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{route('cnttdashboard')}}">Control de Toner</a> </li>
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
            <div class="col-sm-12 col-md-2">
                <label class="form-label">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" min="" id=""
                       class="form-control @error('fecha_inicio') is-invalid @enderror"
                       value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '') }}">
            </div>
            
            <div class="col-sm-12 col-md-2">
                <label class="form-label">Fecha Fin</label>
                <input type="date" name="fecha_fin" min="" id=""
                       class="form-control @error('fecha_fin') is-invalid @enderror"
                       value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '') }}">
            </div>
        
            <div class="col-md-2 col-lg-2" id="departamentoSection">
                <label for="departamento" class="form-label">Departamentos</label>
                <select name="departamento" id="departamento" class="js-example-basic-single form-control">
                    <option value="TODOS">TODOS</option>
                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->id_departamento }}" 
                                @if ($departamento->id_departamento == old('departamento', $_GET['departamento'] ?? '')) selected="selected" @endif>
                            {{ $departamento->nombre_departamento }}
                        </option>
                    @endforeach
                </select>
            </div>  
        
            <div class="col-auto">
                <label class="form-label"> </label>
                <div class="col-auto">
                    <button id="btnImprimir" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                        <i class="fa fa-print fa-2x"></i> Imprimir Reporte
                    </button>
                </div>
               
            </div>
            
            <div class="col-auto">
                <label class="form-label"> </label>
                <div class="col-auto">
                    <button type="submit" name="buscar" class="btn btn-primary" OnClick="">
                         <i class="fa fa-search"></i> Buscar
                    </button>
                </div>
                
            </div>
        </div>
    </form>
    </div> 
   </div>

   <div class="card">
    <div class="card-header">
        <h5>Cantidad de Reemplazos de toner</h5>
      
    </div>
    <div class="card-block">
    
        <div class="row">
            
            <div class="col-md-5 col-lg-5">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>Departamento</th>
                            <th>Cantidad de reemplazos</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        @php($total = 0)
                        @foreach($promedios as $promedio)
                        @php( $total += $promedio->cantidad)
                        <tr>
                            <td>{{$promedio->nombre_departamento}}</td>
                            <td>{{$promedio->cantidad}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            <div class="col-md-7 col-lg-7">
                <div id="grafico_reemplazos" style="width: 100%; height: 500px;"></div>
            </div>
            
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h5>Cantidad Promedio de hojas impresas por toner</h5>
      
    </div>
    <div class="card-block">
    
        <div class="row">
            
            <div class="col-md-5 col-lg-5">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>Departamento</th>
                            <th>Cantidad Promedio</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        @php($total = 0)
                        @foreach($promedios as $promedio)
                        @php( $total += $promedio->promedio)
                        <tr>
                            <td>{{$promedio->nombre_departamento}}</td>
                            <td>{{$promedio->promedio}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            <div class="col-md-7 col-lg-7">
                <div id="grafico_promedios" style="width: 100%; height: 500px;"></div>
            </div>
            
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Dias promedios de duracion de un toner</h5>
      
    </div>
    <div class="card-block">
    
        <div class="row">
            
            <div class="col-md-5 col-lg-5">
                <table class="table table-striped table-bordeles">
                    <thead>
                        <tr>
                            <th>Departamento</th>
                            <th>Dias Promedio</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        @php($total = 0)
                        @foreach($promedios as $promedio)
                        @php( $total += $promedio->diaspromedio)
                        <tr>
                            <td>{{$promedio->nombre_departamento}}</td>
                            <td>{{$promedio->diaspromedio}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                   
                </table>
            </div>
            <div class="col-md-7 col-lg-7">
                <div id="grafico_diaspromedios" style="width: 100%; height: 500px;"></div>
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
<script src="{{ asset('libraries\assets\js\CnttDashboard.js') }}"></script>
<script>

var reemplazos = {!! json_encode($promedios) !!};
var promedio = {!! json_encode($promedios) !!};
var diaspromedio = {!! json_encode($promedios) !!};
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
     document.getElementById('btnImprimir').addEventListener('click', function() {
         var departamento = document.getElementById('departamento').value;
         var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
         var fecha_fin = document.querySelector('input[name="fecha_fin"]').value;
       
         console.log("Fecha de inicio:", fecha_inicio);
         console.log("Fecha de fin:", fecha_fin);
     
         console.log("departamento:", departamento);
 
         var url = "{{ route('cnttreporte') }}?fecha_inicio=" + fecha_inicio +  "&fecha_fin=" + fecha_fin +"&departamento=" + departamento;
         window.open(url, '_blank'); // Abre la URL en una nueva pestaña
     });
 });
 </script>

@endsection