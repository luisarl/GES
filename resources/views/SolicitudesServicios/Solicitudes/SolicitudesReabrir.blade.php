<div class="modal fade" id="modal-reabrir-solicitud" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action=" {{ route('solsreabrir', $solicitud->id_solicitud) }}">
                @csrf
                <div class="modal-body">
                    <h5>Desea Reabrir la Solicitud?</h5>
                    <br>
                    <div class="form-group row">
                        <label class="col-sm-10 col-form-label">Motivo</label>
                        <div class="col-sm-12">
                            <textarea rows="4" cols="3" class="form-control @error('comentario') is-invalid @enderror" name="comentario"
                                placeholder="Sea específico y detallado">{{ old('comentario') }}</textarea>
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
