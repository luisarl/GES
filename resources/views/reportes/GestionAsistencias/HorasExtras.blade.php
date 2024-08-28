@extends('layouts.master')

@section('titulo', 'Reporte Horas Extras')

@section('titulo_pagina', '  Reporte Horas Extras')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Gestion Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="#!"> Reporte Horas Extras </a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('GestionAsistencia.Asistencias.AsistenciaVer')

<div class="card">
    <div class="card-header">

    </div>
    <div class="card-block">
        <form method="GET" action="">
            <div class="form-group row">
                {{-- FILTROS DE BUSQUEDA --}}

                
                <div class="col-md-2 col-lg-2">
                    <label for="departamento" class="form-label">Departamentos</label>
                    <div class=" @error('departamento') is-invalid @enderror">
                        <select name="departamento" class="js-example-basic-single form-control">
                            <option value="TODOS">TODOS</option>
                            @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento }}" @if ($departamento->id_departamento == old('departamento', $_GET['departamento'] ?? '' )) selected="selected" @endif>
                              {{ $departamento->nombre_departamento }}
                            </option>
                            @endforeach
                          </select>
                    </div>
                </div>

                <div class="col-md-2 col-lg-2">
                    <label for="empresa" class="form-label">Empresas</label>
                    <div class=" @error('empresa') is-invalid @enderror">
                        <select name="empresa" class="js-example-basic-single form-control">
                            <option value="TODAS">TODAS</option>
                            @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id_empresa }}" @if ($empresa->id_empresa == old('empresa', $_GET['empresa'] ?? '' )) selected="selected" @endif>
                              {{ $empresa->nombre_empresa }}
                            </option>
                            @endforeach
                          </select>
                    </div>
                </div>
              
                <div class="col-md-2 col-lg-2 ">
                    <label class="form-label">Fecha </label>
                        <input type="date" name="fecha_inicio" min="" id=""
                            class="form-control @error('fecha_inicio') is-invalid @enderror"
                            value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '') }}">
                </div>
                <div class="col-md-2 col-lg-2 ">
                    <label class="form-label">Fecha </label>
                        <input type="date" name="fecha_fin" min="" id=""
                            class="form-control @error('fecha_fin') is-invalid @enderror"
                            value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '') }}">
                </div>
                {{-- BOTON  BUSCAR--}}
                <div class="col-auto">
                    <label class="form-label"></label>
                    <div class="col-auto">
                        <input type="submit" value="Buscar" name="buscar" class="btn btn-primary " OnClick="">
                    </div>   
                </div>
            </div>

            <div class="form-group row">
                {{-- BOTON IMPRIMIR --}}
                <div class="col-auto">
                    <label class="form-label"> </label>
                    
                        <button id="btnReporte" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                            <i class="fa fa-print fa-2x"></i> Imprimir </button>
                    
                </div>
                {{-- BOTON IMPRIMIR --}}
                <div class="col-auto">
                    <label class="form-label"> </label>
                    
                        <button id="btnReporterango" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                            <i class="fa fa-print fa-2x"></i> Imprimir rango </button>
                  
                </div>

                <div class="col-auto">
                    <label class="form-label"> </label>
                    
                        <input type="submit" value="Exportar" name="excel2" class="btn btn-primary " OnClick=""></input>
                    
                </div>
            </div>    
        </form>
      
       
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tabla_validaciones">
                <thead class="text-center">
                    <tr>
                            <th style="width:1%">Id</th>
                            <th style="width:2%">Empleado</th>
                            <th style="width:2%">Fecha</th>
                            <th style="width:1%">Hora Entrada </th>
                            <th style="width:1%">Hora Salida </th>
                            <th style="width:1%">Horas Minimas</th>
                            <th style="width:1%">Horas Extras Diurnas</th>
                            <th style="width:1%">Horas Extras Nocturnas</th>
                            <th style="width:1%">Horas Totales</th>
                    </tr>
                </thead>
                
                <tbody>
         @foreach ($validaciones as $validacion)
  
        @php($asistencias = App\Models\Gsta_AsistenciaModel::ListadoAsistenciaPersona($validacion->id_biometrico, $validacion->fecha_validacion))
        <tr>
            <td id="id_biometrico">{{$validacion->id_biometrico}}</td>
            </td>
            <td id="nombre_empleado">{{$validacion->nombre_empleado}}
                 @php($horarioEmpleado  = App\Models\Gsta_AsistenciasValidacionModel::HorarioEmpleado($validacion->id_biometrico))
                <br>
                HORARIO: {{date('g:i:s A', strtotime($horarioEmpleado->inicio_jornada))}}-{{date('g:i:s A', strtotime($horarioEmpleado->fin_jornada))}}
                <br>
                {{$validacion->nombre_empresa}}
            </td>
            <td id="fecha_validacion">{{ date('d-m-Y', strtotime($validacion->fecha_validacion)) }}</td>

          
            <td id="hora_entrada">
                @if ($validacion->hora_entrada == '00:00:00.0000000')
                    00:00:00
                @else
                    {{ date('g:i:s A', strtotime($validacion->hora_entrada)) }}
                @endif
            </td>

            <td id="hora_salida">
                @if ($validacion->hora_salida== '00:00:00.0000000')
                    00:00:00
                @else
                    {{ date('g:i:s A', strtotime($validacion->hora_salida)) }}
                @endif
            </td>

            <td id="id_novedad">
                {{$validacion->horas_jornada}}
            </td>

            <td>
                {{$validacion->horas_extra_diurnas}}
            </td>
            <td>
                {{$validacion->horas_extra_nocturnas}}
            </td>
            <td>
                {{$validacion->horas_trabajadas}}
            </td>
        </tr>
@endforeach
                </tbody>
                <tfoot>
                    <tr>
                         <th>Id</th>
                         <th>Empleado</th>
                         <th>Fecha</th>
                         <th>Hora Entrada </th>
                         <th>Hora Salida</th>
                         <th>Horas Minimas</th>
                         <th>Horas Extras Diurnas</th>
                         <th>Horas Extras Nocturnas</th>
                         <th>Horas Totales</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<!-- data-table js -->
<script src="{{ asset('libraries\bower_components\datatables.net\js\jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\data-table\js\jszip.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\data-table\js\pdfmake.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\data-table\js\vfs_fonts.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.print.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-buttons\js\buttons.html5.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('libraries\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js') }}">
</script>
<script src="{{ asset('libraries\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<!-- Custom js -->
<script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>
<!--Bootstrap Typeahead js -->
<script src=" {{ asset('libraries\bower_components\bootstrap-typeahead\js\bootstrap-typeahead.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
  $('#modal-mostrar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button que llama al modal
        var nombre = button.data('nombre');
        var datos = button.data('asistencia');
        var i = 0;
        var asistencia = '';
        
        if (datos.length === 0) {
            asistencia = '<tr><td colspan="4">No hay registros de asistencia</td></tr>';
        } else {
            datos.forEach(element => {
                asistencia += '<tr>'
                    + '<td>' + moment(datos[i].fecha).format('DD-MM-YYYY') + '</td>'
                    + '<td>' + datos[i].evento + '</td>'
                    + '<td>' + moment(datos[i].hora, 'HH:mm:ss').format('hh:mm:ss A') + '</td>'
                    + '<td>' + datos[i].estado_asistencia + '</td>'
                    + '</tr>';
                i++;
            });
        }
        
        var modal = $(this);
        modal.find('.modal-title').text('Registros de ' + nombre);
        modal.find('.modal-body table tbody').html(asistencia);
        console.log(asistencia);
    });
</script>


<script>
    document.getElementById('btnReporte').addEventListener('click', function() {
        var departamento = document.querySelector('select[name="departamento"]').value || 'TODOS';
        var empresa = document.querySelector('select[name="empresa"]').value || 'TODAS';
        var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
        
        console.log("Departamento:", departamento);
        console.log("Empresa:", empresa);
        console.log("Fecha de inicio:", fecha_inicio);

        var url = "{{ route('gstareportehoras') }}?departamento=" + departamento + "&empresa=" + empresa + "&fecha_inicio=" + fecha_inicio;
        window.open(url, '_blank'); // Abre la URL en una nueva pestaña
    });
</script>

<script>
    document.getElementById('btnReporterango').addEventListener('click', function() {
        var departamento = document.querySelector('select[name="departamento"]').value || 'TODOS';
        var empresa = document.querySelector('select[name="empresa"]').value || 'TODAS';
        var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
        var fecha_fin = document.querySelector('input[name="fecha_fin"]').value;

        console.log("Departamento:", departamento);
        console.log("Empresa:", empresa);
        console.log("Fecha de inicio:", fecha_inicio);
        console.log("Fecha de fin:", fecha_fin);

        var url = "{{ route('gstareportehorasrango') }}?departamento=" + departamento + "&empresa=" + empresa + "&fecha_inicio=" + fecha_inicio+ "&fecha_fin=" + fecha_fin;
        window.open(url, '_blank'); // Abre la URL en una nueva pestaña
    });
</script>
@endsection