<div class="modal fade" id="modal-procesar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('resgprocesarsolicituddespacho', $solicitud->id_solicitud_despacho) }}" >
                @csrf
            <div class="modal-body">
                <h5>Desea Procesar la Solicitud de Despacho?</h5>
                <br>
                {{-- <p class=""> <span class="font-weight-bold">NOTA: </span> AL VALIDAR LA SALIDA NO SE PODRA REALIZAR NINGUNA MODIFICACIÓN</p> --}}
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="articulos_despacho" id="articulos_despacho">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="CapturarDatosTablaDespacho()">Si</button>
                </div>
            </form>
        </div>
    </div>
</div>
