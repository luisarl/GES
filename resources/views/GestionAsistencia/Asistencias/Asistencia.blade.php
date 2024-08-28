@extends('layouts.master')

@section('titulo', 'Reporte General de Asistencia')

@section('titulo_pagina', 'Reporte General de Asistencia')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Gestion Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="#!">Reporte General de Asistencia</a> </li>
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
                <label class="form-label">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" min="" id=""
                        class="form-control @error('fecha_inicio') is-invalid @enderror"
                        value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '') }}">
                </div>

             
                <div class="col-md-2 col-lg-2 ">
                <label class="form-label">Fecha Fin</label>
                    <input type="date" name="fecha_fin" min="" id=""
                        class="form-control @error('fecha_fin') is-invalid @enderror"
                        value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '')  }}">
                </div>

              {{-- BOTON BUSCAR--}}
              <div class="col-auto">
                <label class="form-label"></label>
                 <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary " OnClick="">
                 </div>   
            </div> 
            </div>
                    
        </form>
      
       
        <div class="dt-responsive table-responsive">
            <table class="table table-striped table-bordered" id="datatable">
                <thead class="text-center">
                    <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Hora Entrada Inicial</th>
                            <th>Hora Salida Final</th>
                            <th>Ver</th>
                 
                          
                    </tr>
                </thead>
                <tbody>
                    @foreach ($personal as $persona)
                        @php($asistencias = App\Models\Gsta_AsistenciaModel::ListadoAsistenciaPersona($persona->cod_biometrico, $persona->fecha))
                    <tr>
                        <td>{{$persona->cod_biometrico}}</td>
                        <td>{{$persona->nombres.' '.$persona->apellidos}} </td>
                        <td>{{ date('d-m-Y', strtotime($persona->fecha)) }}</td>
                        <td>{{date('g:i:s A', strtotime($persona->hora))}}</td>
                        <td>{{date('g:i:s A', strtotime($persona->ultima_hora))}}</td>
                        
                        <td class="dropdown">
                            @can('gsta.asistencias.ver')
                                 <button type="button" class="btn btn-primary" data-id="{{ $persona->cod_biometrico }}"
                                    data-nombre="{{$persona->nombres.' '.$persona->apellidos}}" data-fecha="{{ $persona->fecha }}" 
                                    data-hora="{{ date('g:i:s A', strtotime($persona->hora)) }}" data-toggle="modal"
                                    data-asistencia= "{{$asistencias}}" data-target="#modal-mostrar" href="#">
                                    <i class="fa fa-eye"></i>Ver
                                </button>
                            @endcan
                            </div>
                        </td>
                      
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                         <th>Id</th>
                         <th>Nombre</th>
                         <th>Fecha</th>
                         <th>Hora Entrada Inicial</th>
                         <th>Hora Salida Final</th>
                         <th>Ver</th>
                   
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

<script>
    $('#modal-mostrar').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button que llama al modal
        var nombre = button.data('nombre')
        var datos = button.data('asistencia')
        var i = 0;
        var asistencia;
        datos.forEach(element => {
            asistencia +=     '<tr>'
            + '<td>' + moment(datos[i].fecha).format('DD-MM-YYYY') + '</td>'
                    +'<td>' + datos[i].evento+ '</td>'
                    +'<td>' + moment(datos[i].hora, 'HH:mm:ss').format('hh:mm:ss A') + '</td>'
                    +'<td>' + datos[i].estado_asistencia+ '</td>'
                +'</tr>'
                i++;
               });
        var modal = $(this)
        modal.find('.modal-title').text('Registros de '+nombre)
        modal.find('.modal-body table tbody').html(asistencia);
        console.log(asistencia);
    });
</script>
@endsection