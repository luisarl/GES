<div class="modal fade" id="modal-procesar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('resgprocesarsolicituddesincorporacion', $solicitud->id_solicitud_desincorporacion) }}" >
                @csrf
            <div class="modal-body">
                <h5>Desea Procesar la Solicitud de Desincorporacion?</h5>
                <br>
                <p class=""> <span class="font-weight-bold">NOTA: </span> AL PROCESAR LA SOLICITUD NO SE PODRA REALIZAR NINGUNA MODIFICACIÓN</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="articulos_desincorporacion" id="articulos_desincorporacion">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="CapturarDatosTablaDesincorporacion()">Si</button>
                </div>
            </form>
        </div>
    </div>
</div>
