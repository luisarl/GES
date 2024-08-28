<div class="modal fade" id="modal-almacenes" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-primary fa-2xl"></i> Seleccione El Almacen Donde Es Solicitado El Articulo </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
        
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Almacen</th>
                                <th>Empresa</th>
                                <th>
                                        {{-- <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" id="todos" name="todos" value="">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>Marcar/Desmarcar Todos</span>
                                            </label>
                                        </div> --}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empresas as $empresa)
                                <tr>
                                    <td>{{ $empresa->id_empresa }}</td>
                                    <td>{{ $empresa->alias_empresa }}</td>
                                    <td>{{ $empresa->nombre_empresa }} </td>
                                    <td>
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" id="empresas" name="empresas[]" value="{{$empresa->id_empresa}}">
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light ">Guardar</button>
        </form>
            </div>
        </div>
    </div>
</div>