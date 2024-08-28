@extends('layouts.master')

@section('titulo', 'Novedades en Asistencias ')

@section('titulo_pagina', 'Novedades')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="{{ url('#') }}">Gestion Asistencia</a> </li>
    <li class="breadcrumb-item"><a href="{{ url('gstahorarios') }}">Novedades</a> </li>
    <li class="breadcrumb-item"><a href="#!">Ver</a> </li>
</ul>
@endsection

@section('contenido')

@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')

<div class="card product-detail-page">
    <div class="card-block">
        <div class="row">
            <div class="col-lg-12 col-xs-12 product-detail" id="product-detail">
                <div class="row">
                    <div class="col-lg-12">
                    {{-- BOTON EDITAR --}}  
                      

                            <a href="{{ route('gstanovedades.edit', $novedades->id_novedad) }}" type="button"
                                class="btn btn-primary btn-sm float-right mr-2" title="Editar">
                                <i class="fa fa-edit fa-2x"></i> </a>
                        
                      <br>
                    <label  data-toggle="popover" data-placement="top"  title="FECHA:" data-content="{{ date('d-m-Y g:i:s A', strtotime($novedades->created_at)) }}">
                            <strong>CREADO EL: </strong> {{ $novedades->created_at }} </label>
                        <br>
                    
                        <hr>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-block">
        <h4 class="sub-title">Novedad</h4>
        <div class="table-responsive">
           
            @csrf
            <table class="table table-striped table-bordered" id="">
                <thead>
                    <tr>
                        <th >ID NOVEDAD</th>
                        <th >NOMBRE DE LA NOVEDAD</th>
                   
                    </tr>
                </thead>
                <tbody>
                    
                        <tr>
                        <td>{{$novedades->id_novedad}}</td>
                        <td>{{$novedades->descripcion}}</td>
                        </tr>
                    
                </tbody>
            </table>
        </div>  
    </div>
</div>
@endsection

@section('scripts')

@endsection