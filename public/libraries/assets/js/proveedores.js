//Activar Campos de Retencion de Proveedores
function retencion()
{
    var contribuyente = document.getElementById("contribuyente");

    if(contribuyente.checked )
    {
        $('#porc_retencion').show();
        $('#retencion').show();
    }
    else 
        {
            $('#porc_retencion').hide();
            $('#retencion').hide();
        }
}

retencion();

//Marcar y Desmarcar todos los checkbox de la migracion a profit
$("#todos").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});