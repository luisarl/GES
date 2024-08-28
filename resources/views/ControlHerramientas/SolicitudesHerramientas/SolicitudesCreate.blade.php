@extends('layouts.master')

@section('titulo', 'Creacion de Solicitudes')

@section('titulo_pagina', 'Creacion de Solicitudes')

@section('menu_pagina')
    <ul class="breadcrumb-title">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"> <i class="feather icon-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="{{route('dashboardcnth')}}">Control Herramientas</a> </li>
        <li class="breadcrumb-item"><a href="#!">Creacion de Solicitudes</a> </li>
    </ul>
@endsection

@section('contenido')

<div class="page-body">
    <div class="card">
        <div class="card-header">
            <h4 class="sub-title">Datos del Despacho</h4>
            <div class="form-group row">
                <label class="col-md-2 col-lg-2 col-form-label">Motivo del despacho</label>
                <div class="col-md-4 col-lg-4">
                    <textarea rows="3" cols="3" class="form-control @error('') is-invalid @enderror" name=""
                        placeholder="Motivo de los Despachos"></textarea>
                </div> 
                <div class="card-header">
                    <h5>FILTRAR</h5>
                </div>
                <!-- Date card start -->
                <div class="card-block">
                    <form>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">FECHA INICIO</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control date" data-mask="99/99/9999">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="col-form-label">FECHA CIERRE</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control date2" data-mask="99-99-9999">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Date card end -->
            </div>
            <h5>AGREGAR HERRAMIENTAS</h5>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="example-4">
                    <thead>
                        <tr>
                            <th>ARTICULO</th>
                            <th>UNIDAD</th>
                            <th>CANTIDAD</th>
                            <th>RESPONSABLE</th>
                            <th>ALMACENES</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-primary waves-effect waves-light add" onclick="add_row3();">
                AGREGAR
            </button>
            <div class="d-grid gap-2 d-md-block float-right">
                <button type="submit" class="btn btn-primary ">
                    <i class="fa fa-save"></i>Guardar
                </button>
            </div>
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
    <!-- sweet alert js -->
    <script type="text/javascript" src="{{ asset('libraries\bower_components\sweetalert\js\sweetalert.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('libraries\assets\js\modal.js') }}"></script>
    <!-- Editable-table js -->
    <script type="text/javascript" src="libraries\assets\pages\edit-table\jquery.tabledit.js"></script>
    <script type="text/javascript" src="libraries\assets\pages\edit-table\editable.js"></script>

    <script>
        'use strict';

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById("snap");
        const errorMsgElement = document.querySelector('span#errorMsg');

        const constraints = {
            audio: true,
            video: {
                width: 300,
                height: 250
            }
        };

        // Access webcam
        async function init() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleSuccess(stream);
            } catch (e) {
                errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
            }
        }

        // Success
        function handleSuccess(stream) {
            window.stream = stream;
            video.srcObject = stream;
        }

        // Load init
        init();

        // Draw image
        var context = canvas.getContext('2d');
        snap.addEventListener("click", function() {
            context.drawImage(video, 0, 0, 300, 300);
        });
    </script>
    <script>
        'use strict';
        $(document).ready(function() {
            $('#example-4').Tabledit({

                editButton: false,
                deleteButton: false,
                hideIdentifier: false,
                columns: {
                    identifier: [0, 'id'],
                    editable: [
                        [1, 'ARTICULO'],
                        [2, 'UNIDAD'],
                        [3, 'CANTIDAD'],
                        [4, 'RESPONSABLE'],
                        [5, 'ALMACEN'],
                    ]
                }
            });
        });

        function add_row3() {
            var table = document.getElementById("example-4");
            var t1 = (table.rows.length);
            var row = table.insertRow(t1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4)

            cell1.className = '';
            cell2.className = '';
            cell3.className = '';
            cell4.className = '';
            cell5.className = '';


            $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="" value=" " enable="">')
                .appendTo(cell1);
            $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="" value=" "  enable="">')
                .appendTo(cell2);
            $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="" value=" "  enable="">')
                .appendTo(cell3);
            $('<span class="tabledit-span" > </span><input class="tabledit-input form-control input-sm" type="text" name="" value=" "  enable="">')
                .appendTo(cell4);
            $('<span class="tabledit-span" > </span><select class="tabledit-input form-control input-sm" name="ALMACEN PRINCIPAL"  enable="" ><option value="1">EMBARCACIONES</option><option value="2">PRINCIPAL</option><option value="3">MANTENIMIENTO</option></select>')
                .appendTo(cell5);

        };
    </script>
@endsection
