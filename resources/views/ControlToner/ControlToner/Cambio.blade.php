@extends('layouts.master')

@section('titulo', 'Control de Toner')

@section('titulo_pagina', 'Control de Toner')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Control de Toner</a> </li>
    <li class="breadcrumb-item"><a href="#!">Control de Toner</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')



<div class="card">
    <div class="card-header">
     @can('cntt.controltoner.crear')
          <a class="btn btn-primary float-right" title="Nuevo" href="{!! route('cnttcontroltoner.create') !!}">
            <i class="fa fa-plus"></i> Nuevo</a>
     @endcan
    </div>
    <div class="card-block">
        
      
       
        <div class="dt-responsive table-responsive">
            <table class="table table-striped table-bordered" id="datatable">
                <thead class="text-center">
                    <tr>
                            <th>Id</th>
                            <th>Fecha</th>
                            <th>Departamento</th>
                            <th>Equipo</th>
                            <th>Ubicacion</th>
                            <th>Recarga/Reemplazo</th>
                            <th>Ver</th>
                          
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reemplazos as $reemplazo)
                    <tr>
                        <td>{{$reemplazo->id_reemplazo_toner}}</td>
                        <td>{{date('d-m-Y', strtotime($reemplazo->fecha_cambio)) }}</td> 
                        <td>{{$reemplazo->nombre_departamento}}</td>
                        <td>{{$reemplazo->nombre_activo}}</td>
                        <td>{{$reemplazo->ubicacion}}</td>
                        <td>{{$reemplazo->tipo_servicio}}</td>
                        <td class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"
                                    aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                @can('cntt.controltoner.ver') 
                                    <a class="dropdown-item" href="{{ route('cnttcontroltoner.show',$reemplazo->id_reemplazo_toner) }}">
                                    <i class="fa fa-eye"></i>Ver</a>
                                @endcan
                                
                              
                                @can('cntt.controltoner.editar') 
                                <a class="dropdown-item"
                                    href="{{ route('cnttcontroltoner.edit',$reemplazo->id_reemplazo_toner) }}">
                                    <i class="fa fa-edit"></i>Editar</a>
                                @endcan 
                             
                            </div>
                        </td>
                       
                        
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Fecha</th>
                        <th>Departamento</th>
                        <th>Equipo</th>
                        <th>Ubicacion</th>
                        <th>Recarga/Reemplazo</th>
                        <th>Ver</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
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
<!-- Custom js -->
<script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>
<!--Bootstrap Typeahead js -->




@endsection

