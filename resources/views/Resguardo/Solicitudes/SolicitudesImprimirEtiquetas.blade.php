<div class="modal fade" id="modal-imprimir" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: 120%;">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Impresion de Etiquetas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('resgimprimiretiquetasresguardo', $solicitud->id_solicitud_resguardo) }}" >
                @csrf
            <div class="modal-body">
                <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap" id="tablaimpresion"  style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Codigo</th>
                                            <th>Nombre del Articulo</th>
                                            <th>Presentacion</th>
                                            <th>Disp. Final</th>
                                            <th>Cantidad Impresion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($articulos as $articulo)
                                        <tr>
                                            <td id="id_resguardo">{{$articulo->id_resguardo}}</td>
                                            <td id="codigo_articulo">{{$articulo->codigo_articulo}}</td>
                                            <td id="nombre_articulo">{{$articulo->nombre_articulo}}</td>
                                            <td id="presentacion">{{number_format($articulo->equivalencia_unidad, 2).' '.$articulo->tipo_unidad}}</td>
                                            <td id="clasificacion">{{$articulo->nombre_clasificacion}}</td>
                                            <td id="cantidad_impresion"> 
                                               <input type="number" name="cantidad" id="" value="{{number_format($articulo->cantidad, 2)}}" min="1" class="form-control">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
        
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="articulos_impresion" id="articulos_impresion">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                    <button type="submit" formtarget="_blank" onclick="CapturarDatosTablaImpresion()" class="btn btn-primary waves-effect waves-light" >Si</button>
                </div>
            </form>
        </div>
    </div>
</div>
