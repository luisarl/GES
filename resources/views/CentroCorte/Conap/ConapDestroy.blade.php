<div class="modal fade" id="modal-anular" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-danger">
                <h4 class="modal-title"> <i class="fa fa-warning fa-2xl"></i> Alerta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>¿Desea Anular la Consulta?</h5>
                <br>
            </div>
            <form id="formdelete" method="POST" action=" {{ route('cencconap.destroy',1) }}" data-action=" {{ route('cencconap.destroy',1) }}" >
                @csrf @method("delete")
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light ">Si</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-aprobar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header btn-primary">
                <h4 class="modal-title"> <i class="fa fa-warning fa-2xl"></i> Alerta</h4>
                <button type="button" class="close" data-dismiss="modal2" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>¿Desea Aprobar la Solicitud?</h5>
                <br>
            </div>
            <form id="formaprobar" method="POST" action=" {{ route('solicitudes.destroy',1) }}" data-action=" {{ route('solicitudes.destroy',1) }}" >
                @csrf @method("delete")
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal2">No</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Si</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-eliminar-documento" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-danger">
                <h4 class="modal-title"> <i class="fa fa-warning fa-2xl"></i> Alerta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>¿Desea Eliminar el Documento?</h5>
                <br>
            </div>
            <form id="formeliminardocumento" method="POST" action=" {{ route('eliminardocumentoconap',1) }}" data-action=" {{ route('eliminardocumentoconap',1) }}" >
                @csrf @method("delete")
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Si</button>
                </div>
            </form>
        </div>
    </div>
</div>