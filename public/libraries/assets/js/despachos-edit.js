
//LLENA LA TABLA ADICIONALES CON LOS DATOS DE CLASIFICACION SELECCIONADOS
function CargarTabla()
{
    var herramienta = $('#id_herramienta').val();
    var responsable = $('#responsable').val();
    var cantidad = $('#cantidad_entregada').val();
    
    $("#tabla_despacho>tbody").append("<tr><th></th><td>"+herramienta+"</td><td>"+responsable+"</td><td>"+cantidad+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th> </tr>");

}

//OBTENER DATOS DE LA TABLA ADICIONALES
function CapturarDatosTabla()
{
    var tabla = document.getElementById("tabla_despacho");
    var filas = tabla.rows.length - 1 ; //obtiene el numero de filas de la tabla , menos el encabezado TH
    var celda = document.getElementsByTagName("td"); //ingresa en la propiedad td de la tabla

    var acumulador1 = 0;
    var acumulador2 = 1;
    var acumulador3 = 2;


    var columnas = 3;
    var arreglo = [];

    for(var i = 0; i < filas; i++)
    {
        for(var j = 0; j < 1; j ++)
        {
            arreglo.push([celda[acumulador1].innerHTML.split(' ')[0],  celda[acumulador2].innerHTML, celda[acumulador3].innerHTML.split(' ')[0]]);
            acumulador1 = acumulador1 + columnas;
            acumulador2 = acumulador2 + columnas;
            acumulador3 = acumulador3 + columnas;
        }
    }

    console.log(JSON.stringify(arreglo));
    $('#datosdespacho').val(JSON.stringify(arreglo)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST
    //alert('Stop')
}

//ELIMINAR ADICIONALES CON AJAX
function eliminardatosdespacho(id)
{
    $.ajax({
        // dataType: "JSON",
        url: '../../eliminardatosdespacho/'+id,
        type: 'DELETE',
        data:
        {
            _token: $("input[name=_token]").val()
        },
        success: function(data)
        {
            console.log("eliminado");
        }
    });
}



$(document).on('click', '.borrar', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});

//auto completar en nombre de la herramienta
$('#scrollable-dropdown-menu .typeahead').typeahead( {
    items: 'all',

    source: function (query, process) {
        return $.get(route, {
            query: query,
            movimiento: movimiento

        }, function (data) {
            return process(data);
        });
    }
});
