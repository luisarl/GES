//LLENA EL SELECT DE HERRAMIENTAS    
function CargarHerramientas() {

    var IdAlmacen= $('#_almacenes').val();
    $.get(HerramientasAlmacen + '/' + IdAlmacen, function(data) {
        var old = $('#_herramientas').data('old') != '' ? $('#_herramientas').data('old') : '';
        $('#_herramientas').empty();
        $('#_herramientas').append('<option value="0">Seleccione la Herramienta</option>');

        $.each(data, function(fetch, herramientas) {
            //console.log(data);
            for (i = 0; i < herramientas.length; i++) {
                $('#_herramientas').append('<option value="' + herramientas[i].stock_actual + '"   ' + (old ==
                    herramientas[i].id_herramienta ? "selected" : "") + ' >'+ 
                    herramientas[i].id_herramienta + ' | ' + herramientas[i].nombre_herramienta 
                     + '</option>');
            }
        })

    })
}

//LLENA LA TABLA ADICIONALES CON LOS DATOS DE CLASIFICACION SELECCIONADOS
function CargarTabla()
{
    var herramienta = $("#_herramientas option:selected").text();
    var cantidad = $('#cantidad').val();
    var existencia = $('#existencia').val();


    var lista_herramientas = CapturarDatosTabla(); //captura los datos de la  tabla
    

    if( cantidad <= 0) //valida si la cantidad ingresada es mayor al stock o menor a cero
    {
        alert('LA CANTIDAD INGRESADA ES INVALIDA');
        $('#cantidad').val('');
    }
    else 
        {
            for (i = 0; i < lista_herramientas.length; i++) // si tiene datos la tabla de herramientas
            {
                // verifica si la herramienta seleccionada fue cargada
                if(lista_herramientas[i].id_herramienta == herramienta.split(' | ')[0] ) 
                {
                    //si la herramienta esta cargada muestra el mensaje y sale de la funcion
                    alert('LA HERRAMIENTA YA ESTA CARGADA');
                    return; 
                }
            }
            // si la herramienta no esta cargada la agrega a la tabla
            $("#tablaajuste>tbody").append("<tr><td id='id_plantilla_detalle' style='visibility:collapse; display:none;'></td><td id='id_herramienta'>"+herramienta.split('|')[0]+"</td><td id='nombre_herramienta'>"+herramienta.split('|')[1]+"</td><td id='cantidad'>"+cantidad+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");

            //$('#_herramientas').val('');
            $('#cantidad_entregada').val('');

        }
}


//OBTENER DATOS DE LA TABLA 
function CapturarDatosTabla()
{
    let listado_herramientas = [];
    
    document.querySelectorAll('#tablaajuste tbody tr').forEach(function(e){
        let fila = {
            id_plantilla_detalle: e.querySelector('#id_plantilla_detalle').innerText,
            id_herramienta: e.querySelector('#id_herramienta').innerText,
            nombre_herramienta: e.querySelector('#nombre_herramienta').innerText,
            cantidad: e.querySelector('#cantidad').innerText,
        };

        listado_herramientas.push(fila);
    });

    //console.log(JSON.stringify(listado_herramientas));
    $('#datosmovimiento').val(JSON.stringify(listado_herramientas)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST

    return listado_herramientas;

}

//Captura el Stock de la herramienta
function StockHerramienta()
{
    let stock = document.getElementById("_herramientas").value;
    document.getElementById("existencia").value = stock;
}

//ELIMINAR HERRAMIENTA CON AJAX
function EliminarDetalle(IdPlantillaDetalle)
{
    $.ajax({
        // dataType: "JSON",
        url: EliminarHerramienta+'/'+IdPlantillaDetalle,
        type: 'post',
        data:
        {
            _token: $("input[name=_token]").val(),
            _method: 'delete'
        },
        success: function(data)
        {
            console.log("eliminado");
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}

$(document).on('click', '.borrar', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});

CargarHerramientas();
$('#_almacenes').on('change', CargarHerramientas);     