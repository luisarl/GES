@extends('layouts.master')

@section('titulo', 'Despacho')

@section('titulo_pagina', 'Despacho de Herramientas')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item"><a href="{{ url('/dashboardcnth') }}"> <i class="feather icon-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
        <li class="breadcrumb-item"><a href="{{ url('/despachos') }}">Despachos</a> </li>
        <li class="breadcrumb-item"><a href="#">Editar</a> </li>
    </ul>
@endsection

@section('contenido')
    @include('mensajes.MsjExitoso')
    @include('mensajes.MsjError')
    @include('mensajes.MsjAlerta')
    @include('mensajes.MsjValidacion')

    <div class="page-body">
        <div class="card">
            <div class="card-header">
            <h4 class="sub-title"><strong>Editar el Despacho</strong></h4>
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('despachos.update', $movimiento->id_movimiento) }}" enctype="multipart/form-data">
                    @csrf @method('put')    
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Almacenes</label>
                                <div class="col-sm-9 @error('id_almacen') is-invalid @enderror">
                                    <select name="id_almacen" id="_almacenes" class="js-example-basic-single form-control" readonly>
                                        @foreach ($almacenes as $almacen)
                                        <option value="{{ $almacen->id_almacen }}"
                                            @if ($almacen->id_almacen == old('id_almacen', $movimiento->id_almacen ?? '')) selected = "selected" @endif>
                                            {!! $almacen->id_almacen !!} - {!! $almacen->nombre_almacen !!}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Responsables" class="col-sm-3 col-form-label">Responsable</label>
                                <div class="col-sm-9 @error('') is-invalid @enderror">
                                    <select name="responsable" id="" class="js-example-basic-single form-control">
                                        @foreach($empleados as $empleado)
                                            <option value="{{$empleado->Empleado}}" 
                                                @if ($empleado->Empleado == old('responsable', $movimiento->responsable ?? '')) selected = "selected" @endif>
                                                {{$empleado->Empleado}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Zonas </label>
                                <div class="col-sm-9 @error('id_zona') is-invalid @enderror">
                                    <select name="id_zona" id="id_zona" class="js-example-basic-single form-control"readonly>
                                        @foreach ($zonas as $zona)
                                        <option value="{{ $zona->id_zona }}"
                                            @if ($zona->id_zona == old('id_zona', $movimiento->id_zona ?? '')) selected = "selected" @endif>
                                            {!! $zona->nombre_zona !!}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Motivo del Despacho</label>
                                <div class="col-sm-9">
                                    <textarea rows="3" cols="3" class="form-control @error('motivo') is-invalid @enderror" name="motivo"
                                    id="motivo" placeholder="Motivo del Despacho">{{ old('motivo', $movimiento->motivo ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3 text-center">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <div id="my_camera"></div>
                                    <img style="width: 300px" class="after_capture_frame"
                                            src="{{ asset($movimiento->imagen) }}" />
                                </div>
                                {{-- <div class="col-sm-6">
                                    <div id="results">
                                        <img style="width: 300px" class="after_capture_frame"
                                            src="{{ asset($movimiento->imagen) }}" />
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h4 class="sub-title">Historico Responsables</h4>
                            
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Responsable</th>
                                        <th>Fecha</th>
                                    </thead>
                                    <tbody>
                                        @foreach($responsables as $responsable)
                                        <tr>
                                            <td>{{$responsable->responsable}}</td>
                                            <td>{{date('d-m-Y g:i:s A', strtotime($responsable->fecha))}}</td>
                                        </tr>
                                        @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <h4 class="sub-title">Herramientas</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tabla_despacho">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Herramienta</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detalles as $detalle)
                                    <tr>
                                        <th>{{ $detalle->id_herramienta }} </th>
                                        <td>{{ $detalle->nombre_herramienta }}</td>
                                        <td>{{ $detalle->cantidad_entregada }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="d-grid gap-2 d-md-block float-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>Guardar
                        </button>
                    </div>
                </form>
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

        <script src="{{ asset('libraries\assets\pages\data-table\js\data-table-custom.js') }}"></script>
        <script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}">
        </script>
        <script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>

        <!--Bootstrap Typeahead js -->
        <script src=" {{ asset('libraries\bower_components\bootstrap-typeahead\js\bootstrap-typeahead.min.js') }}"></script>
        <!--Personalizado -->
        <script src="{{ asset('libraries\assets\js\despachos-edit.js') }}"></script>
        {{-- autocompletar nombre de articulo --}}
        <script>
            var route = "{{ url('autocompletardespacho') }}";
            var movimiento = "{{$movimiento->id_movimiento}}";
        </script>
        <!-- Select -->
        <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

    @endsection
