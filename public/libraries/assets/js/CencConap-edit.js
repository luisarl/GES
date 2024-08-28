function EliminarDocumentoConap(id) {
    $.ajax({
        url: EliminarDocumentoConaps + '/' + id,
        type: 'post',
        data:
        {
            _token: $("input[name=_token]").val(),
            _method: 'delete'
        },
        success: function (data) {
            console.log("eliminado");
            document.querySelector(`[data-id="${id}"]`).remove()
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}

//boton elimnar filas de tablas
$(document).on('click', '.borrar', function (event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});