@extends('layouts.master')

@section('titulo', 'Conap')

@section('titulo_pagina', 'Consulta de aprovechamiento - CONAP')

@section('menu_pagina')
<ul class="breadcrumb-title">
    <li class="breadcrumb-item">
        <a href="{{ asset('/') }}"> <i class="feather icon-home"></i> </a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Centro de Corte</a> </li>
    <li class="breadcrumb-item"><a href="{{ route('cencconap.index') }}">Conap</a>
    </li>
    <li class="breadcrumb-item"><a href="#!">Editar</a> </li>
</ul>

@endsection

@section('contenido')


@include('mensajes.MsjExitoso')
@include('mensajes.MsjError')
@include('mensajes.MsjValidacion')
@include('mensajes.MsjAlerta')

@include('CentroCorte.Conap.ConapDestroy')

<div class="page-body">

    <div class="card">
        <div class="card-header">
            <h5>Editar Conap - Nro {{ $conap->nro_conap}}</h5>
        </div>
        <div class="card-block">
            <form class="" method="POST" action=" {{ route('cencconap.update', $conap->id_conap) }}" enctype="multipart/form-data">
                @csrf @method('put')

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('nombre_conap') is-invalid @enderror" name="nombre_conap" id="nombre_conap" 
                        value="{{ old('nombre_conap', $conap->nombre_conap ?? '') }}"  placeholder="Ingrese nombre">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea rows="3" cols="3" class="form-control @error('descripcion_conap') is-invalid @enderror" name="descripcion_conap" 
                            >{{ $conap->descripcion_conap}}</textarea>
                    </div>
                </div>

            <div class="form-group row">
                <label for="documentos" class="col-sm-2 col-md-2 col-lg-2 col-form-label">Archivos</label>
                <div class="col-md-10 col-lg-10 @error('documentos') is-invalid @enderror">
                    <input type="file" name="documentos" id="filer_input" value="{{old('documentos[]') }}">

                    @foreach($documentos as $documento)
                    <span data-id="{{$documento->id_conap_documento}}">
                        <a href="{{asset($documento->ubicacion_documento)}}" target="_blank"
                            class="link-active m-r-10 f-12">
                            <i class="icofont icofont-attachment text-primary p-absolute f-30"></i>
                            {{$documento->nombre_documento}}</a>
                        <button type="button"
                            onclick="EliminarDocumentoConap({{$documento->id_conap_documento}})"
                            class='borrar btn btn-danger'><i class='fa fa-trash'></i> </button>
                    </span><br>
                    @endforeach
                </div>
            </div>

                
                <hr>
                <div class="d-grid gap-2 d-md-block float-right">
                    <button type="submit" class="btn btn-primary ">
                        <i class="fa fa-save"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
                
</div>
<!-- Page-body end -->

@endsection

@section('scripts')

<!-- Select -->
<script type="text/javascript" src="{{ asset('libraries\bower_components\select2\js\select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries\assets\pages\advance-elements\select2-custom.js') }}"></script>

<!-- jquery file upload js -->
<script src="{{ asset('libraries\assets\pages\jquery.filer\js\jquery.filer.min.js') }}"></script>
<script src="{{ asset('libraries\assets\pages\filer\custom-filer.js') }}" type="text/javascript"></script>
<script src="{{ asset('libraries\assets\pages\filer\jquery.fileuploads.init.js') }}" type="text/javascript"></script>

<script>
    var EliminarDocumentoConaps = "{{ url('eliminardocumentoconap') }}";

    // Obtener el contenido desde la variable PHP
    var contenido = "{{$conap->descripcion_conap;}}";
    // Establecer el contenido en el editor
    editor.html.set(contenido);
</script>


<script>
    $('#modal-eliminar-documento').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button que llama al modal
        var id = button.data('id') // Extrae la informacion de data-id
        var nombre = button.data('nombre') // Extrae la informacion de data-nombre
        console.log(id);
        action = $('#formeliminardocumento').attr('data-action').slice(0, -1); // elimina el id de la ruta del formulario
        action += id; // se agrega el id seleccionado al formulario
        $('#formeliminardocumento').attr('action', action); //cambia la ruta del formulario
        var modal = $(this)
        modal.find('.modal-body h5').text('Desea Eliminar el Nro Parte:  '+ nombre + ' ?') //cambia texto en el body del modal
    })
</script>
<script type="text/javascript" src="{{ asset('libraries\assets\js\CencConap-edit.js') }}"></script>

@endsection