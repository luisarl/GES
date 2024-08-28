@extends('layouts.master')

@section('titulo', 'Reporte Validaciones de Asistencia')

@section('titulo_pagina', 'Reporte Validaciones de Asistencia')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Gestion Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="#!"> Reporte Validaciones de Asistencia </a> </li>
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
                    <label class="form-label">Fecha Inicio </label>
                        <input type="date" name="fecha_inicio" min="" id=""
                            class="form-control @error('fecha_inicio') is-invalid @enderror"
                            value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '') }}">
                    </div>
                <div class="col-md-2 col-lg-2 ">
                        <label class="form-label">Fecha Fin</label>
                            <input type="date" name="fecha_fin" min="" id=""
                                class="form-control @error('fecha_fin') is-invalid @enderror"
                                value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '') }}">
                </div> 

                <div class="col-md-2 col-lg-2">
                    <label class="form-label">Novedades</label>
                    <select name="id_novedad[]" id="id_novedad" class="js-example-basic-single form-control @error('id_novedad') is-invalid @enderror" multiple>
                        <option value="TODOS" @if ('TODOS' == old('id_novedad', $_GET['id_novedad'][0] ?? '' )) selected="selected" @endif>TODOS</option>
                        @foreach($novedades as $novedad)
                            <option value="{{$novedad->id_novedad}}"
                                @isset($_GET['id_novedad'])
                                    @foreach($_GET['id_novedad'] as $IdNovedad)
                                        @if ($novedad->id_novedad == $IdNovedad ?? '' ) selected="selected" @endif
                                    @endforeach
                                @endisset
                                >
                              {{$novedad->descripcion}} 
                            </option>
                        @endforeach
                    </select>
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
                <!-- BOTON IMPRIMIR -->
                <div class="col-md-2 col-lg-2 ">
                    <button id="reportediario" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                        <i class="fa fa-print fa-2x"></i> Reporte Diario
                    </button>
                </div>
            
                <div class="col-md-2 col-lg-2 ">
                    <button id="btnImprimir" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                        <i class="fa fa-print fa-2x"></i> Reporte Rango de Fechas
                    </button>  
                </div>
            </div>
        </form>
      
       
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tabla_validaciones">
                <thead class="text-center">
                    <tr>
                            <th style="width:5%">Id</th>
                            <th style="width:2%">Empleado</th>
                            <th style="width:5%">Fecha</th>
                            <th style="width:5%">Marcaje</th>
                            <th style="width:1%">Hora Entrada </th>
                            <th style="width:1%">Hora Salida </th>
                            <th style="width:5%">Novedades</th>
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
                @if ($horarioEmpleado)
                     HORARIO: {{ date('g:i:s A', strtotime($horarioEmpleado->inicio_jornada ?? '00:00:00')) }} - {{ date('g:i:s A', strtotime($horarioEmpleado->fin_jornada ?? '00:00:00')) }}
                 @else
                     <label class="label label-danger">HORARIO NO ASIGNADO</label>
                 @endif

                <br>
                {{$validacion->nombre_empresa}}
            </td>
            <td id="fecha_validacion">{{ date('d-m-Y', strtotime($validacion->fecha_validacion)) }}</td>

            <td class="dropdown">
                Hora Entrada:
                @if ($validacion->primera_hora == '')
                    00:00:00
                @else
                    {{ date('g:i:s A', strtotime($validacion->primera_hora)) }}
                @endif
                <br>
                Hora Salida:
                    @if ($validacion->ultima_hora == '')
                    00:00:00
                    @else
                    {{ date('g:i:s A', strtotime($validacion->ultima_hora)) }}
                    @endif
                    <br>
                <button type="button" class="btn btn-primary" data-id="{{$validacion->id_biometrico}}"
                        data-nombre="{{$validacion->nombre_empleado}}" data-fecha="{{ $validacion->fecha_validacion }}" 
                        data-hora="{{ date('g:i:s A', strtotime($validacion->hora_entrada)) }}" data-toggle="modal"
                        data-asistencia= "{{$asistencias}}" data-target="#modal-mostrar" href="#">
                    <i class="fa fa-eye"></i>Ver
                </button>
            </td>
          
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
                @php($novedadesv = App\Models\Gsta_ValidacionNovedadesModel::ListarNovedad($validacion->id_validacion))
                    @foreach ($novedadesv as $novedadv)
                        {{ $novedadv->descripcion }}
                        <br>
                    @endforeach
            </td>
        </tr>
@endforeach
                </tbody>
                <tfoot>
                    <tr>
                         <th>Id</th>
                         <th>Empleado</th>
                         <th>Fecha</th>
                         <th>Marcaje</th>
                         <th>Hora Entrada </th>
                         <th>Hora Salida</th>
                         <th>Novedades</th>
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
    document.getElementById('reportediario').addEventListener('click', function() {
        var departamento = document.querySelector('select[name="departamento"]').value || 'TODOS';
        var empresa = document.querySelector('select[name="empresa"]').value || 'TODAS';
        var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
        var novedad = Array.from(document.querySelectorAll('#id_novedad option:checked')).map(option => option.value);
        
        console.log("Departamento:", departamento);
        console.log("Empresa:", empresa);
        console.log("Fecha de inicio:", fecha_inicio);
    
        console.log("id_novedad[]:", novedad);
        var url = "{{ route('gstareportevalidacionfinal') }}?departamento=" + departamento + "&empresa=" + empresa + "&fecha_inicio=" + fecha_inicio+ "&id_novedad=" + novedad.join(",");
        window.open(url, '_blank'); // Abre la URL en una nueva pestaña
    });
</script>

<script>
    document.getElementById('btnImprimir').addEventListener('click', function() {
        var departamento = document.querySelector('select[name="departamento"]').value;
        var empresa = document.querySelector('select[name="empresa"]').value;
        var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
        var fecha_fin = document.querySelector('input[name="fecha_fin"]').value;
        var novedad = Array.from(document.querySelectorAll('#id_novedad option:checked')).map(option => option.value);
        console.log("Departamento:", departamento);
        console.log("Empresa:", empresa);
        console.log("Fecha de inicio:", fecha_inicio);
        console.log("Fecha de fin:", fecha_fin);

        var url = "{{ route('gstareportevalidaciondiaria') }}?departamento=" + departamento + "&empresa=" + empresa + "&fecha_inicio=" + fecha_inicio+ "&fecha_fin=" + fecha_fin+ "&id_novedad=" + novedad.join(",");
        window.open(url, '_blank'); // Abre la URL en una nueva pestaña
    });
</script>


@endsection