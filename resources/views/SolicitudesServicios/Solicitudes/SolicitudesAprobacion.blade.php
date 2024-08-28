<div class="modal fade" id="modal-aprobacion-solicitud" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action=" {{ route('solsaceptar', $solicitud->id_solicitud) }}">
                @csrf
                <div class="modal-body">
                    <h5>Desea Aceptar la Solicitud?</h5>
                    <br>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <div class="form-radio">
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" name="aceptar" value="SI" id="aceptar" onClick="AceptarSolicitud()" checked="checked" >
                                        <i class="helper"></i>SI
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <label>
                                        <input type="radio" value="NO" name="aceptar" id="rechazar" onClick="AceptarSolicitud()">
                                        <i class="helper"></i>NO
                                    </label>
                                </div>
                            </div>   
                        </div>
                    </div>
                    <div class="form-group row" id="comentario">
                        <label class="col-sm-10 col-form-label">Motivo</label>
                        <div class="col-sm-12">
                            <textarea rows="4" cols="3" class="form-control @error('comentario') is-invalid @enderror" name="comentario"
                                 placeholder="Sea específico y detallado" required>{{ old('comentario') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>
