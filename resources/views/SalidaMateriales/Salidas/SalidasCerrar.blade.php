<div class="modal fade" id="modal-cierre-almacen" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Desea Realizar el Cierre de los Articulos Seleccionados?</h5>
                <br>
                {{-- <p class=""> <span class="font-weight-bold">NOTA: </span> AL CERRAR LA SALIDA NO SE PODRA REALIZAR NINGUNA MODIFICACIÓN</p> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="CapturarDatosCierre()">Si</button>
            </div>
        </div>
    </div>
</div>
