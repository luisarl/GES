<div class="modal fade" id="modal-validar-aprovechamiento" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action=" {{ route('aprovechamientovalidar', $aprov->id_aprovechamiento) }}">
                @csrf
                <div class="modal-body">
                    <h5>Desea Validar el Aprovechamiento?</h5>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Si</button>
                </div>
            </form>
        </div>
    </div>
</div>
