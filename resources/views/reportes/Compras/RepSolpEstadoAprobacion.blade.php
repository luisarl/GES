@extends('layouts.master')

@section('titulo', 'Reportes')

@section('titulo_pagina', 'Reporte Solicitud de Compra Estados Aprobacion')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Reportes</a> </li>
    <li class="breadcrumb-item"><a href="#!">Solicitud de Compra Estados Aprobacion</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')


@section('contenido')
<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>PARAMETROS DE BUSQUEDA</strong></h4>
    </div>
    <div class="card-block">
        <form method="GET" action="">
            {{-- @csrf --}}
            <div class="form-group row">
                <label class="col-sm-12 col-md-1 form-label">Fecha Inicio</label>
                <div class="col-sm-12 col-md-2 ">
                    <input type="date" name="fecha_inicio" min="" id=""
                        class="form-control @error('fecha_inicio') is-invalid @enderror"
                        value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '') }}">
                </div>
                <label class="col-sm-12 col-md-1 form-label">Fecha Fin</label>
                <div class="col-sm-12 col-md-2 ">
                    <input type="date" name="fecha_fin" min="" id=""
                        class="form-control @error('fecha_fin') is-invalid @enderror"
                        value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '')  }}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-1">
                </div>
                <div class="col-auto">
                    <input type="submit" value="Buscar" name="buscar" class="btn btn-primary mt-1 mb-1" OnClick="">
                         {{-- <i class="fa fa-search"></i>Buscar
                    </input> --}} 
                </div>
            </div>
        </form>
        <hr>
        <h4 class="sub-title">Datos</h4>

        <form action="" method="get">
            <input type="hidden" name="fecha_inicio"  value="{{ old('fecha_inicio', $_GET['fecha_inicio'] ?? '')  }}">
            <input type="hidden" name="fecha_fin" value="{{ old('fecha_fin', $_GET['fecha_fin'] ?? '')  }}">
             
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="table-responsive">    
                        <table class="table table-striped table-bordeles">
                            <thead>
                                <tr>
                                    <th>ESTADO</th>
                                    <th>CANTIDAD</th>
                                    <th>ACUMULADO <br>AÑO</th>
                                    <th>ACUMULADO <br>TOTAL</th>
                                    <th>VER</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $TotalEmitidas = 0;
                                    $TotalAcuAnio = 0;
                                    $TotalAcuTotal = 0;
                                @endphp
                        
                                @foreach($solicitudes as $solicitud)
                                @php 
                                    $TotalEmitidas += $solicitud->Emitidas;
                                    $TotalAcuAnio += $solicitud->AcumuladoAnio;
                                    $TotalAcuTotal += $solicitud->AcumuladoTotal;
                        
                                @endphp
                                <tr>
                                    <td>{{$solicitud->Estado}}</td>
                                    <td>{{$solicitud->Emitidas}}</td>
                                    <td>{{$solicitud->AcumuladoAnio}}</td>
                                    <td>{{$solicitud->AcumuladoTotal}}</td>
                                    <td>
                                        <input type="submit" class="btn btn-primary btn-sm" id="btn" name="estado" value="{{$solicitud->Estado}}">
                                            {{-- <i class="fa fa-eye fa-2x"></i>
                                        </input> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>TOTAL</th>
                                    <th>{{$TotalEmitidas}}</th>
                                    <th>{{$TotalAcuAnio}}</th>
                                    <th>{{$TotalAcuTotal}}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div id="grafico_solp_estados" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        </form>
    </div>
</div>

@if(isset($_GET['estado']))
    
<div class="card">
    <div class="card-header">
        <h4 class="sub-title"><strong>Solicitudes de Compras Estado: {{$_GET['estado']}}</strong></h4>
    </div>
    <div class="card-block">
        <div class="table-responsive dt-responsive">
            <table id="datatable-excel" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>SolP</th>
                        <th>EstadoSolP</th>
                        <th>Fecha</th>
                        <th>Solicita</th>
                        <th>Unidad</th>
                        <th>Motivo</th>
                        {{-- <th>Comprador</th>
                        <th>Fecha Aprob.</th>
                        <th>Aprobado por</th> --}}
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($SolicitudesCompras as $solicitud)
                    <tr>
                        <td>{{$solicitud->Empresa}}</td>
                        <td>{{$solicitud->NumSolP}}</td>
                        <td>{{$solicitud->EstadoSolP}}</td>
                        <td>{{$solicitud->FechaSolP}}</td>
                        <td>{{$solicitud->Solicita}}</td>
                        <td>{{$solicitud->Unidad}}</td>
                        <td>{{$solicitud->Motivo}}</td>
                        {{-- <td>{{$solicitud->Comprador}}</td>
                        <td>{{$solicitud->FechaAprob}}</td>
                        <td>{{$solicitud->Aprobo}}</td> --}}
                        <td>
                            <a class="btn btn-primary btn-sm" title="VER SOLP" target="_blank" href=" {{ route('reposolpdetalle', ['empresa' => $solicitud->CodEmpresa, 'solp' => $solicitud->SolP ])}}" ><i
                                class="fa fa-eye fa-2x"></i></a>
                            {{-- <button type="button" class="btn btn-primary btn-sm waves-effect" 
                                data-toggle="modal" 
                                data-target="#modal-solicitud"
                                data-id="{{$solicitud->SolP}}"  
                                data-solp="{{$solicitud->NumSolP}}"  
                                data-empresa="{{$solicitud->CodEmpresa}}"
                                data-motivo="{{$solicitud->Motivo}}">  
                                <i class="fa fa-eye fa-2x"></i>
                            </button> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <th>TOTAL</th>
                        <th>{{$TotalEmitidas}}</th>
                        <th>{{$TotalAcuAnio}}</th>
                        <th>{{$TotalAcuTotal}}</th>
                        <th></th>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
</div>
    
@endif


@endsection

@section('scripts')
<!-- google chart -->
<script src="{{ asset('libraries\assets\pages\chart\google\js\google-loader.js') }}"></script>
 
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

<!-- personalizado -->
<script src="{{ asset('libraries\assets\js\CompReportes.js') }}"></script>

<script>

    var solicitudes = {!! json_encode($solicitudes) !!};

</script>

<script>
    $('#modal-solicitud').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button que llama al modal
            var id = button.data('id') // Extrae la informacion de data-id
            var solp = button.data('solp') // Extrae la informacion de data-solp
            var motivo = button.data('motivo') // Extrae la informacion de data-nombre
            var empresa = button.data('empresa') // Extrae la informacion de data-empresa
            var justificacion = button.data('justificacion') // Extrae la informacion de data-justificacion

            // action = $('#formdelete').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
            // action += id; // se agrega el id seleccionado al formulario

            // $('#formdelete').attr('action', action); //cambia la ruta del formulario

            var modal = $(this)
            modal.find('.modal-title h4').text('Empresa: ' + empresa + ' SolP: ' +solp);  //cambia texto en el titulo del modal
            modal.find('.modal-body p').text( motivo) //cambia texto en el body del modal
            modal.find('#empresa').val(empresa)
            modal.find('#solp').val(id)
        })
</script>

@endsection