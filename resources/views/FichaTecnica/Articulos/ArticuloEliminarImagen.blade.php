<div class="modal fade" id="modal-eliminar-imagen" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-danger">
                <h4 class="modal-title"> <i class="fa fa-warning fa-2xl"></i> Alerta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Desea Eliminar La Imagen?</h5>
                <br>
                <img src="" class="" style="height: 250px; width: 250px;" alt="imagen">
            </div>
          
            <form id="formdelete" method="POST" action=" {{ route('eliminarimagen', 1) }}" data-action=" {{ route('eliminarimagen', 1) }}">
                @csrf @method("delete")
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light ">Si</button>
                </div>
            </form>
        </div>
    </div>
</div>