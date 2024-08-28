@extends('layouts.master')

@section('titulo', 'Editar Equipo')

@section('titulo_pagina', 'Editar Equipo')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('cencequipos.index')}}">Centro de Corte</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('cencequipos.index') }}">Equipos</a></li>
        <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
    </ul>
@endsection

{{-- Estilo para tecnologias asociadas al equipo --}}
<style>
.cuadrado {
    display: inline-block;
    background-color: #01a9ac;
    width: 100px;
    height: 35px;
    text-align: center;
    line-height: 30px;
    margin-right: 10px;
    border-radius: 5px;
    color: #ffffff;
}

.x {
    display: inline-block;
    color: #ffffff;
    font-weight: bold;
    text-decoration: none;
}

.x:hover {
    color: rgb(14, 13, 13); 
}

#tecnologias-container {
    display: flex;
}

.tecnologia-nombre {
    margin-right: 10px;
}
</style>

@section('contenido')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('CentroCorte.Equipos.EquiposTecnologiasDestroy')
@include('CentroCorte.Consumibles.ConsumiblesDestroy')

<div class="card">
    <div class="card-header">
        <h5>Editar Equipos</h5>
    </div>
    <div class="card-block">
        <h4 class="sub-title"></h4>
        <form method="POST" action="{{ route('cencequipos.update', $equipo->id_equipo) }}" enctype="multipart/form-data"> 
            @csrf @method('put')

             <div class="form-group row">
                <div class="col-md-2 col-lg-2">
                    <label for="name-2" class="block">Nombre</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nombre_equipo') is-invalid @enderror" name="nombre_equipo"
                    value="{{ old('nombre_equipo', $equipo->nombre_equipo ?? '') }}" placeholder="Ingrese el Nombre del Equipo">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea rows="3" cols="3" class="form-control @error('descripcion_equipo') is-invalid @enderror" name="descripcion_equipo" 
                     placeholder="Ingrese la Descripción del Equipo">{{old('descripcion_equipo', $equipo->descripcion_equipo ?? '')}}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2 col-lg-2">
                    <label for="name-2" class="block">Tecnologia</label>
                </div>
                <div class="col-sm-4 @error('id_tecnologia') is-invalid @enderror">
                    <select name="id_tecnologia[]" id="id_tecnologia" class="js-example-basic-multiple form-control @error('responsables') is-invalid @enderror"
                    multiple="multiple" >
                    @foreach($tecnos as $tecno)
                        <option value="{{$tecno->id_tecnologia}}" @if ($tecno->id_tecnologia==old('tecnologias')) selected="selected" @endif>
                            {{$tecno->nombre_tecnologia}}</option>
                    @endforeach
                    </select>
                </div>
                <div id="tecnologias-container">
                    @foreach($tecnologias as $tecnologia)
                        <div class="cuadrado">
                            <span class="tecnologia-nombre">{{$tecnologia->nombre_tecnologia}}</span>
                            <a data-id="{{$tecnologia->id_tecnologia}}" data-nombre="{{$tecnologia->nombre_tecnologia}}"  data-equipo="{{$equipo->id_equipo}}" class="x" href="#" data-toggle="modal" data-target="#modal-eliminarT">x</a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card-header">
                <h5>Tabla de consumibles</h5>
                <hr>
            </div>
            
            {{-- TABLA DE CONSUMIBLES ASOCIADOS AL EQUIPO Y TECNOLOGIA --}}
            <div class="form-group row">

                <label for="name-2" class="col-sm-2 col-form-label">Tecnologia</label>
                <div class="col-sm-3 @error('id_tecnologia') is-invalid @enderror">
                    <select name="id_tecnologiaconsumible" id="id_tecnologiaconsumible" class="js-example-basic-multiple form-control">
                        <option value="0">Seleccione tecnología</option>
                        @foreach ($tecnologias as $tecnologia)
                            <option>{{$tecnologia->id_tecnologia . ' | ' . $tecnologia->nombre_tecnologia}}</option>
                        @endforeach
                    </select>
                </div>
            
                <label for="name-2" class="col-sm-2 col-form-label">Consumibles</label>
                <div class="col-sm-3 @error('id_consumible') is-invalid @enderror">
                    <select name="id_consumible" id="id_consumible" class="js-example-basic-multiple form-control">
                        <option value="0">Seleccione consumible</option>
                        @foreach($opciones as $opcion)
                            <option>{{$opcion->id_consumible . ' | ' . $opcion->nombre_consumible}}</option>
                        @endforeach
                    </select>
                </div>

                <label for="name-2" class="block">Agregar</label>
                <div class="col-md-1 col-lg-1">
                    <button type="button" class="btn btn-primary btn-sm" title="Nuevo" onClick="CargarTabla()">
                        <i class="fa fa-plus"></i>  </button>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="tabla_consumibles">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="visibility:collapse; display:none;">idtecnologia</th>
                            <th>Tecnologia</th>
                            <th style="visibility:collapse; display:none;">idconsumible</th>
                            <th>Consumible</th>
                            <th style="width: 10%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consumibles as $consumible)
                            <tr>
                                <td id="conteo">{{$loop->iteration}}</td>
                                <td id='idtecnologia' style="visibility:collapse; display:none;">{{$consumible->id_tecnologia}}</td>
                                <td id='nombre_tecnologia'>{{$consumible->nombre_tecnologia}}</td>
                                <td id='idconsumible' style="visibility:collapse; display:none;">{{$consumible->id_consumible}}</td>
                                <td id='nombre_consumible'>{{$consumible->nombre_consumible}}</td>
                                <th>
                                    <button type="button"
                                        onclick="EliminarAdicional({{ $consumible->id_equipo_consumible }})"
                                        class="borrar btn btn-danger btn-sm"><i
                                            class="fa fa-trash"></i></button>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <hr>
            <br>
            {{-- Campo oculto con arreglo de los datos adicionales --}}
            <input type="hidden" name="caracteristicas" id="caracteristicas">
            <div class="d-grid gap-2 d-md-block float-right">
                <button type="submit" class="btn btn-primary" OnClick="CapturarDatosTabla()">
                <i class="fa fa-save"></i>Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')


    <!-- jquery file upload js -->
    <script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

    <!-- Select -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

    <!-- Masking js -->
    <script src="{{ asset('libraries\assets\pages\form-masking\inputmask.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\autoNumeric.js') }} "></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\jquery.inputmask.js') }}"></script>
    <script src="{{ asset('libraries\assets\pages\form-masking\form-mask.js') }} "></script>

    <!--Bootstrap Typeahead js -->
    <script src=" {{ asset('libraries\bower_components\bootstrap-typeahead\js\bootstrap-typeahead.min.js') }}" ></script>

<!-- eliminar tecnologias -->
<script>
    $('#modal-eliminarT').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var id = button.data('id');
        var nombre = button.data('nombre');
        var equipo = button.data('equipo');

        action = $('#formdelete').attr('data-action').slice(0, -1); 
        action += id + '/' + equipo; 

        $('#formdelete').attr('action', action); 

        var modal = $(this);
        modal.find('.modal-body h5').text('¿Desea eliminar la tecnologia: ' + nombre + '?'); 
    });
</script>

<script>
    var ruta = "{{ url('cencequipos/obtener-tecnologias/') }}";
    var eliminaradicional = "{{ url('cencequiposconsumibles') }}";
</script>


<script>

    function CargarTabla()
    {
        var IdTecnologia = $("#id_tecnologiaconsumible option:selected").text();
        var IdConsumible = $("#id_consumible option:selected").text();

        if (IdTecnologia == null  || IdConsumible ==null) 
        {
            alert('Para Agregar Debe Seleccionar La Tecnologia y Consumible');
        }
        else
            {
                $("#tabla_consumibles>tbody").append("<tr><td id='conteo' style='visibility:collapse; display:none;'>"+0+"<td></td></td><td id='idtecnologia' style='visibility:collapse; display:none;'>"+IdTecnologia.split('|')[0]+"</td><td>"+IdTecnologia.split('|')[1]+"</td><td id='idconsumible' style='visibility:collapse; display:none;'>"+IdConsumible.split('|')[0]+"</td><td>"+IdConsumible.split('|')[1]+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th> </tr>");
                // $('#id_tecnologiaconsumible').val('').prepend('<option selected disabled>Seleccione tecnologia</option>');
                // $('#id_consumible').val('').prepend('<option selected disabled>Seleccione consumible</option>');
            }
    }

    function CapturarDatosTabla()
    {
        let caracteristicas = [];

        document.querySelectorAll('#tabla_consumibles tbody tr').forEach(function(e){
            let conteo = e.querySelector('#conteo').innerText.trim();

            if (conteo === '0') 
            {
                let fila = {
                    idtecnologia: e.querySelector('#idtecnologia').innerText,
                    idconsumible: e.querySelector('#idconsumible').innerText,
                };
            caracteristicas.push(fila);
             }

        });
    
        $('#caracteristicas').val(JSON.stringify(caracteristicas)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

        return caracteristicas;
    }

    function EliminarAdicional(id)
    {
        $.ajax({
            // dataType: "JSON",
            url: eliminaradicional+'/'+id,
            type: 'post',
            data:
            {
                _token: $("input[name=_token]").val(),
                _method: 'delete'
            },
            success: function(data)
            {
                console.log("eliminado");
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }

    //boton elimnar filas de tablas
    $(document).on('click', '.borrar', function(event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });

</script>


@endsection







