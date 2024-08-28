<div class="modal fade" id="modal-inactivar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h4 class="modal-title"> <i class="fa fa-info fa-2xl"></i> Información</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($articulo->activo == 'NO ')
                    <h5>Desea Activar El Articulo ?</h5>

                    {{-- <br>
                    <p class=""> <span class="font-weight-bold">NOTA: </span> AL HABILITAR EL ARTICULO NO SE PODRAN MODIFICAR LOS CAMPOS
                    CODIGO, GRUPO Y SUBGRUPO</p> --}}
                @else
                    <h5>Desea Inactivar El Articulo ?</h5>  
                @endif
            </div>
            <div class="modal-footer">
               <form method="GET" action=" {{ route('inactivar', $articulo->id_articulo) }}" >
                    @csrf
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light ">Si</button>
            </form>
            </div>
        </div>
    </div>
</div>