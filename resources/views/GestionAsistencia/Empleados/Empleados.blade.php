@extends('layouts.master')

@section('titulo', 'Empleados')

@section('titulo_pagina', 'Listado de Empleados')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Gestion Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="#!">Empleados</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')

<div class="card">
    <div class="card-header">

    </div>
    <div class="card-block">
        
        <div class="table-responsive">
           
            <table class="table table-striped table-bordered" id="datatable">
                <thead class="text-center">
                    <tr>
                        <th>Id Biometrico</th>
                        <th>Id Nomina</th>
                        <th>Empresa</th>
                        <th>Departamento</th>
                        <th>Empleado</th>
                        <th>Opciones</th>
                        
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($empleados as $empleado)
                       
                    <tr>
                        <td>{{$empleado->cod_biometrico}}</td>
                        <td>{{$empleado->cod_emp}}</td>
                        <td>{{$empleado->empresa}}</td>
                        <td>{{$empleado->des_depart}}</td>
                        <td>{{$empleado->nombres.' '.$empleado->apellidos}}</td>
              
                      
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                    aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                             
                                @if(App\Models\Gsta_EmpleadosModel::TieneAsignado($empleado->cod_biometrico))
                                @can('gsta.empleados.editar')
                                <a class="dropdown-item"
                                   href="{{ route('gstaempleados.edit', $empleado->cod_biometrico) }}">
                                    <i class="fa fa-edit"></i> Editar
                                </a>
                                @endcan
                            @else
                            @can('gsta.empleados.crear')
                                <a class="dropdown-item"
                                   href="{{ route('gstaempleadosasignar', $empleado->cod_biometrico) }}">
                                    <i class="fa fa-eye"></i> Asignar
                                </a>
                             @endcan    
                            @endif
                            
                            </div>
                        </td>

                    </tr>
                
                    @endforeach
                      
                </tbody>
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



@endsection