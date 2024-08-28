<div class="modal fade" id="modal-solicitud" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-warning">
                <h4 class="modal-title"> <i class="fa fa-warning fa-2xl"></i> Alerta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Desea Solicitar La Migracion Del Articulo :
                    <strong>{{$articulo->nombre_articulo}}</strong>
                    <br> a las Empresas Seleccionadas ?
                </h5>

            </div>
            <div class="modal-footer">
                {{-- <form method="GET" action=" {{ route('migracion', ['articulo' => $articulo->id_articulo, 'almacen' => $almacen->id_almacen]) }}" >
                    @csrf --}}
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-warning waves-effect waves-light ">Si</button>
            
            </div>
        </div>
    </div>
</div>
</form>