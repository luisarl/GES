<div class="modal fade" id="modal-aprobar-articulo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Desea Aprobar Los Datos Del Articulo?</h5>
            </div>
            <div class="modal-footer">
                <form method="POST" action=" {{ route('aprobar', $articulo->id_articulo) }}">
                    @csrf
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Si</button>
                </form>
            </div>
        </div>
    </div>
</div>
