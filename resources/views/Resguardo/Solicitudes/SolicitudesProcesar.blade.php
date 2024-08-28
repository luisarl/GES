<div class="modal fade" id="modal-procesar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('resgprocesarsolicitudresguardo', $solicitud->id_solicitud_resguardo) }}" >
                @csrf
            <div class="modal-body">
                <h5>Desea Procesar la Solicitud de Resguardo?</h5>
                <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap" id="tablaresguardo">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Codigo</th>
                                            <th>Nombre del Articulo</th>
                                            <th>Ubicacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($articulos as $articulo)
                                        <tr>
                                            <td id="id_resguardo">{{$articulo->id_resguardo}}</td>
                                            <td id="codigo_articulo">{{$articulo->codigo_articulo}}</td>
                                            <td id="nombre_articulo">{{$articulo->nombre_articulo}}</td>
                                            <td id="id_ubicacion"> 
                                                <select name="ubicacion_articulo" id="ubicacion_articulo" class="form-control">
                                                    @foreach ($ubicaciones as $ubicacion)
                                                        <option value="{{$ubicacion->id_ubicacion}}">{{$ubicacion->nombre_ubicacion}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                {{-- <p class=""> <span class="font-weight-bold">NOTA: </span> AL VALIDAR LA SALIDA NO SE PODRA REALIZAR NINGUNA MODIFICACIÓN</p> --}}
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="articulos_resguardo" id="articulos_resguardo">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                    <button type="submit" onclick="CapturarDatosTablaResguardo()" class="btn btn-primary waves-effect waves-light ">Si</button>
                </div>
            </form>
        </div>
    </div>
</div>
