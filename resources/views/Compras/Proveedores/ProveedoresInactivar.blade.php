<div class="modal fade" id="modal-inactivar-proveedor" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($proveedor->activo == 'NO')
                    <h5>Desea Activar El Proveedor ?</h5>

                @else
                    <h5>Desea Inactivar El Proveedor ?</h5>  
                @endif
            </div>
            <div class="modal-footer">
               <form method="GET" action=" {{ route('inactivarproveedor', $proveedor->id_proveedor) }}" >
                    @csrf
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light ">Si</button>
            </form>
            </div>
        </div>
    </div>
</div>