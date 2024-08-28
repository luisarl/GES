<div class="modal fade" id="modal-orden-finalizar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-danger">
                <h4 class="modal-title"> <i class="fa fa-warning fa-2xl"></i> Alerta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>¿Desea Finalizar la Orden de Trabajo?</h5>
                <br>
            </div>
          <form id="ordentrabajofinalizar" method="POST" action=" {{ route('cencordentrabajofinalizar', $OrdenTrabajo->id_orden_trabajo) }}" data-action=" {{ route('cencordentrabajofinalizar', $OrdenTrabajo->id_orden_trabajo) }}" >
                @csrf
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Si</button>
                </div>
             </form>
        </div>
    </div>
</div>