@extends('layouts.master')

@section('titulo', 'Reporte')

@section('titulo_pagina', 'Solicitud de Compra')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#">Reportes</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Ver Solicitud de Compra</a> </li>
</ul>
@endsection

@section('contenido')
@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

<div class="page-body">
    <div class="row">
        <div class="col-xl-8 col-lg-12 ">
            <div class="card">
                <div class="card-block">
                    <div class="">
                        <div class="m-b-20">
                            <h6 class="sub-title m-b-15"><i class="fa fa-industry"> </i> EMPRESA :
                                {{$SolicitudCompra[0]->Empresa}}</h6>
                            <h6 class="sub-title m-b-15"><i class="icofont icofont-ui-note"> </i> SOLP :
                                {{$SolicitudCompra[0]->NumSolP}} </h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <label for="" class="col-md-12"><strong>DEPARTAMENTO : </strong>
                                {{$SolicitudCompra[0]->Unidad}}</label>
                            <label for="" class="col-md-12"><strong>SOLICITANTE : </strong>
                                {{$SolicitudCompra[0]->Solicita}}</label>
                            <label for="" class="col-md-12"><strong>SUPERIOR : </strong>
                                {{$SolicitudCompra[0]->Superior}}</label>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <label for="" class="col-md-12"><strong>ESTADO : </strong> {{$SolicitudCompra[0]->Estado}} -
                                {{$SolicitudCompra[0]->EstadoSolP}}</label>
                            <label for="" class="col-md-12"><strong>APROBADO : </strong>
                                {{$SolicitudCompra[0]->Aprobo}}</label>
                            <label for="" class="col-md-12"><strong>FECHA : </strong>
                                {{$SolicitudCompra[0]->FechaSolP}}</label>
                            <label for="" class="col-md-12"><strong>COMPRADOR : </strong>
                                {{$SolicitudCompra[0]->Comprador}}</label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-block">
                    <div class="">
                        <div class="m-b-20">
                            <h6 class="sub-title m-b-15"><i class="icofont icofont-ui-note"> </i>Motivo</h6>
                            <p>
                                {{$SolicitudCompra[0]->Motivo}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-block">
                    <div class="">
                        <div class="m-b-20">
                            <h6 class="sub-title m-b-15"><i class="icofont icofont-ui-note"> </i>JUSTIFICACION</h6>
                            <p>
                                {!!$SolicitudCompra[0]->Justifica!!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-block">
                    <div class="">
                        <div class="m-b-20">
                            <h6 class="sub-title m-b-15"><i class="fa fa-shopping-bag"> </i> Articulos</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <th>CODIGO</th>
                                        <th>NOMBRE</th>
                                        <th>CANTIDAD</th>
                                        <th>PENDIENTE</th>
                                    </thead>
                                    <tbody>
                                        @foreach($SolicitudCompra as $solicitud)
                                        <tr>
                                            <td>{{$solicitud->CodArticulo}}</td>
                                            <td>
                                                @php
                                                $texto = $solicitud->Articulo;
                                                $NombreArticulo = wordwrap($texto, 40, "<br>", false);
                                                @endphp
                                                {!!$NombreArticulo!!}
                                            </td>
                                            <td>{{number_format($solicitud->Cantidad, 2)}}</td>
                                            <td>{{number_format($solicitud->Pendiente, 2)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12 ">
            @if($SolicitudCompra[0]->Estado != 'APROBADO')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text"><i class="fa fa-check-square-o m-r-10"></i>APROBACION</h5>
                </div>
                <div class="card-block">
                    <form class="" method="POST" action="{{ route('compguardaraprobacionsolp') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="empresa" value="{{$SolicitudCompra[0]->CodEmpresa}}">
                        <input type="hidden" name="solp" value="{{$SolicitudCompra[0]->SolP}}">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Estado</label>
                            <div class="col-sm-9">
                                <select name="estado" class="js-example-basic-single form-control">
                                    <option value="APROBADO">APROBADO</option>
                                    <option value="NO APROBADO">NO APROBADO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Autorizado Por</label>
                            <div class="col-sm-9">
                                <select name="autorizado" class="js-example-basic-single form-control">
                                    <option value="MARK SERFATY">MARK SERFATY</option>
                                    <option value="MONICA DA SILVA">MONICA DA SILVA</option>
                                    <option value="HISLENIS GONZALEZ">HISLENIS GONZALEZ</option>
                                    <option value="ANGIE LINARES">ANGIE LINARES</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Fecha</label>
                            <div class="col-sm-9">
                                <input type="date" name="fecha" class="form-control ">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-check-square-o"></i>Aprobar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text"><i class="icofont icofont-users-alt-4 m-r-10"></i> COMPRADOR ASIGNADO
                    </h5>
                </div>
                <div class="card-block user-box assign-user">
                    <form method="POST" action=" {{ route('compasignarcompradorsolp')}}">
                        @csrf
                        <input type="hidden" name="empresa" value="{{$SolicitudCompra[0]->CodEmpresa}}">
                        <input type="hidden" name="solp" value="{{$SolicitudCompra[0]->SolP}}">
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <select name="comprador"
                                    class="js-example-basic-single form-control @error('comprador') is-invalid @enderror">
                                    @foreach($compradores as $comprador)
                                    <option value="{{trim($comprador->nombre_comprador)}}" @if (trim($comprador->nombre_comprador) == old('comprador' , $SolicitudCompra[0]->Comprador ?? '' ))
                                        selected="selected" @endif>
                                        {{$comprador->nombre_comprador}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary" value="Asignar">
                                        <i class="fa fa-hand-paper-o"></i>Asignar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<!-- Multiselect js -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\bootstrap-multiselect\js\bootstrap-multiselect.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\bower_components\multiselect\js\jquery.multi-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\jquery.quicksearch.js') }}"></script>

<!-- Personalizado -->

@endsection