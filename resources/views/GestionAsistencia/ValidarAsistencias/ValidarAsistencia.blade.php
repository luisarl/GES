@extends('layouts.master')

@section('titulo', 'Validacion de Asistencias')

@section('titulo_pagina', 'validacion de Asistencia')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Gestion Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="#!">Validacion de Asistencia</a> </li>
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
                            <option value="">TODOS</option>
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
                            <option value="">TODAS</option>
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

             
                

              {{-- BOTON BUSCAR--}}
               <div class="col-auto">
                    <label class="form-label"></label>
                    <div class="col-auto">
                        <input type="submit" value="Buscar" name="buscar" class="btn btn-primary " OnClick="">
                    </div>   
                </div> 

                @if(isset($personal[0]) && trim($personal[0]->estatus) == 'VALIDADO')
                {{-- BOTON IMPRIMIR --}}
                <div class="col-auto">
                    <label class="form-label"> </label>
                    <div class="col-auto">
                         <button id="btnImprimir" type="button" class="btn btn-primary btn-sm" title="Imprimir">
                            <i class="fa fa-print fa-2x"></i> Imprimir </button>
                    </div>
                </div>
                @endif

            </div>    
        </form>
      
       
        <div class="dt-responsive table-responsive">
            <form action= "{{route('gstaasistenciasvalidaciones.store')}}" method="POST">
                @csrf
                <input type="hidden" name="validaciones" id="validaciones">
                <table class="table table-striped table-bordered" id="datatable">
                    <thead class="text-center">
                        <tr>
                            <th >Id</th>
                            <th style="display:none">Id_empleado</th>
                            <th style="display:none;">Id Departamento</th>
                            <th style="display:none;">Id Empresa/th>
                            <th style="display:none;">Nombre_empresa</th>    
                            <th>Empleado</th>
                            <th>Fecha</th>
                            <th>Marcaje Biometrico</th>
                            <th>Novedades Marcaje</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida </th>
                            <th>Novedades</th>
                            <th>Observaciones</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($mostrarBotonValidar = false)
    
                        @foreach ($personal as $persona)
                            @php($asistencias = App\Models\Gsta_AsistenciaModel::ListadoAsistenciaPersona($persona->cod_biometrico, $persona->fecha))
                            <tr>
                                <td id="id_biometrico">{{$persona->cod_biometrico}}</td>
                                <td id="id_empleado" style="display:none;">{{$persona->cod_emp}}</td>
                                <td id="id_departamento" style="display:none;">{{$persona->co_depart}}</td>
                                <td id="id_empresa" style="display:none;">{{$persona->cod_empresa}}</td>
                                <td id="nombre_empresa" style="display: none;" >{{$persona->empresa}}</td>
                                <td id="nombre_empleado">{{$persona->nombres.' '.$persona->apellidos}}
                                    @php($horarioEmpleado  = App\Models\Gsta_AsistenciasValidacionModel::HorarioEmpleado($persona->cod_biometrico))
                                    <br>
                                    @if ($horarioEmpleado)
                                        HORARIO: {{ date('g:i:s A', strtotime($horarioEmpleado->inicio_jornada ?? '00:00:00')) }} - {{ date('g:i:s A', strtotime($horarioEmpleado->fin_jornada ?? '00:00:00')) }}
                                    @else
                                    <label class="label label-danger">HORARIO NO ASIGNADO</label>
                                    @endif
                                    <br>
                                    {{$persona->empresa}}  
                                </td>
                                <td id="fecha_validacion">{{ date('d-m-Y', strtotime($persona->fecha)) }}</td>

                                 <td class="dropdown">
                                    Hora Entrada:
                                        @if ($persona->primera_hora === '00:00:00.0000000')
                                            00:00:00
                                        @else
                                            {{ date('g:i:s A', strtotime($persona->primera_hora)) }}
                                        @endif
                                        <br>
                                    Hora Salida:
                                        @if ($persona->ultima_hora === '00:00:00.0000000')
                                        00:00:00
                                        @else
                                        {{ date('g:i:s A', strtotime($persona->ultima_hora)) }}
                                        @endif
                                        <br>
                                        <button type="button" class="btn btn-primary" data-id="{{ $persona->cod_biometrico }}"
                                            data-nombre="{{$persona->nombres.' '.$persona->apellidos}}" data-fecha="{{ $persona->fecha }}" 
                                            data-hora="{{ date('g:i:s A', strtotime($persona->primera_hora)) }}" data-toggle="modal"
                                            data-asistencia= "{{$asistencias}}" data-target="#modal-mostrar" href="#">
                                            <i class="fa fa-eye"></i>
                                        </button>
        
                                  
                                </td>
                                <td id="novedad">
                                        <div class="@error('novedad') is-invalid @enderror">
                                            @if ($persona->novedad == 'ENTRADA TARDIA Y SALIDA ANTICIPADA')
                                                <label class="label label-warning"> ENTRADA TARDIA </label>
                                                    <br>
                                                <label class="label label-warning">  SALIDA ANTICIPADA </label>
                                            @elseif($persona->novedad == 'ENTRADA TARDIA Y SALIDA TARDIA')
                                                <label class="label label-warning"> ENTRADA TARDIA </label>
                                                    <br>
                                                <label class="label label-warning">  SALIDA TARDIA</label>
                                             
                                            @elseif($persona->novedad == 'ENTRADA ANTICIPADA Y SALIDA TARDIA')
                                                <label class="label label-warning"> ENTRADA ANTICIPADA</label>
                                              
                                                <br>
                                                <label class="label label-warning">  SALIDA TARDIA</label>
                                            @elseif($persona->novedad == 'ENTRADA ANTICIPADA Y SALIDA ANTICIPADA')
                                                <label class="label label-warning"> ENTRADA ANTICIPADA</label>
                                                <br>
                                                <label class="label label-warning">  SALIDA ANTICIPADA </label>
                                               
                                            @elseif($persona->novedad == 'SIN MARCAJE')
                                                <label class="label label-danger">SIN MARCAJE</label>
                                            @elseif($persona->novedad == 'ENTRADA ANTICIPADA')
                                                <label class="label label-warning"> ENTRADA ANTICIPADA</label>
                                            @elseif($persona->novedad == 'ENTRADA TARDIA')
                                                <label class="label label-warning"> ENTRADA TARDIA </label>
                                            @elseif($persona->novedad == 'SALIDA ANTICIPADA')
                                                <label class="label label-warning">  SALIDA ANTICIPADA </label>
                                            @elseif($persona->novedad == 'SALIDA TARDIA')
                                                <label class="label label-warning">  SALIDA TARDIA</label>   
                                            @else
                                            <label class="label label-success">SIN NOVEDAD</label>
                                                
                                            @endif                                        
                                        </div>
                                  
                                </td>
                               
                                <td id="hora_entrada">
                                    @if(trim($persona->estatus) != 'VALIDADO') 
                                        @php($horarioEmpleado = App\Models\Gsta_AsistenciasValidacionModel::HorarioEmpleado($persona->cod_biometrico))
                                        @if($horarioEmpleado && $horarioEmpleado->inicio_jornada)
                                        <div class="col-md-9 col-lg-9">
                                            <input type="time" id="hora_entrada" name="hora_entrada" class="form-control"
                                            value="{{ date('H:i', strtotime($horarioEmpleado->inicio_jornada)) }}" step="1">
                                        </div>
                                        @endif
                                    @endif
                                </td>
                                <td id="hora_salida">
                                    @if(trim($persona->estatus) != 'VALIDADO') 
                                        @php($horarioEmpleado = App\Models\Gsta_AsistenciasValidacionModel::HorarioEmpleado($persona->cod_biometrico))
                                        @if($horarioEmpleado && $horarioEmpleado->fin_jornada)
                                        <div class="col-md-9 col-lg-9">
                                            <input type="time" id="hora_entrada" name="hora_entrada" class="form-control"
                                            value="{{ date('H:i', strtotime($horarioEmpleado->fin_jornada)) }}" step="1">
                                        </div>
                                        @endif
                                     @endif
                                    
                                </td>
                                <td id="id_novedad">
                                    @if(trim($persona->estatus) != 'VALIDADO') 
                                        <div class="@error('novedad') is-invalid @enderror">
                                            <select name="id_novedad[]" class="js-example-basic-multiple form-control @error('novedades') is-invalid @enderror"
                                                multiple="multiple">
                                                @foreach($novedades as $novedad)
                                                @if (strpos($novedad->descripcion, 'SIN NOVEDAD') !== false )
                                                <option value="{{$novedad->id_novedad}}" selected="selected">
                                                    {{ $novedad->descripcion }}
                                                </option>           
                                                    @else
                                                    <option value="{{$novedad->id_novedad}}">
                                                        {{ $novedad->descripcion }}
                                                    </option>
                                                    @endif
                                                @endforeach
                                        </select>
                                    </div>
                                    @endif
                                </td>
                                <td id="observacion">
                                    @if(trim($persona->estatus) != 'VALIDADO') 
                                    <div class="col-md-8 col-lg-8">
                                    <textarea name="observacion" cols="150" class="form-control @error('observacion') is-invalid @enderror" value="{{ old('observacion') }}"></textarea>
                                    </div>  
                                    @endif
                                </td>
                                <td id="estatus">
                                    @if(trim($persona->estatus) == 'VALIDADO')
                                    <label class="label label-success">VALIDADO</label>
                                    @endif
                                </td>
                            </tr>
                            @if(trim($persona->estatus) != 'VALIDADO')
                                @php($mostrarBotonValidar =  true)
                             @endif
                        @endforeach
                    </tbody>
                </table>
                @if ($mostrarBotonValidar)
                    <div class="d-grid gap-2 d-md-block float-right">
                        <button type="submit" class="btn btn-primary" name="validar" id="validar" onClick="CapturarDatosTabla1()">
                            <i class="fa fa-check"></i>Validar 
                        </button>
                    </div>
                @endif
                </form>
            </div>
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

<script src="{{ asset('libraries\assets\js\GstaAsistencias.js') }}"></script>

<script>
    document.getElementById('btnImprimir').addEventListener('click', function() {
        var departamento = document.querySelector('select[name="departamento"]').value || 'TODOS';
        var empresa = document.querySelector('select[name="empresa"]').value || 'TODAS';
        var fecha_inicio = document.querySelector('input[name="fecha_inicio"]').value;
        
        console.log("Departamento:", departamento);
        console.log("Empresa:", empresa);
        console.log("Fecha de inicio:", fecha_inicio);

        var url = "{{ route('gstareportevalidacioninicial') }}?departamento=" + departamento + "&empresa=" + empresa + "&fecha_inicio=" + fecha_inicio;
        window.open(url, '_blank'); // Abre la URL en una nueva pestaña
    });
</script>

@endsection