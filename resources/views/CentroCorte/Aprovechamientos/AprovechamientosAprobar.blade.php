<div class="modal fade" id="modal-aprobar-aprovechamiento" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('aprovechamientoaprobar', $aprov->id_aprovechamiento) }}">
                @csrf
                <div class="modal-body">
                    <h5>Desea Aprobar el Aprovechamiento?</h5>
                    <br>
                </div>
                <input type="hidden" name="datos" id="datos">

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" OnClick="CapturarDatos()">Si</button>
                </div>
            </form>
        </div>
    </div>
</div>
