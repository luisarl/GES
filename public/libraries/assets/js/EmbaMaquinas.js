//LLENA LA TABLA CON LOS DATOS DE LOS PARAMETROS SELECCIONADAS
function CargarTabla()
{
    var IdParametro = $("#id_parametro").val();
    var NombreParametro = $("#id_parametro option:selected").text();
    var ValorMinimo = $("#valor_minimo").val();
    var ValorMaximo = $("#valor_maximo").val();

    var parametros = CapturarDatosTabla(); 
    
    if ($("#id_parametro").val() == 0) 
    {
        alert('Para Agregar Debe Seleccionar Un Parametro');
    }
    else
        {
            for (i = 0; i < parametros.length; i++) // si tiene datos la tabla de parametros
            {
                // verifica si el parametro seleccionado fue cargada
                if(parametros[i].id_parametro == IdParametro) 
                {
                    //si el parametro esta cargado muestra el mensaje y sale de la funcion
                    alert('EL PARAMETRO YA ESTA CARGADO');
                    return; 
                }
            }

            $("#tabla_parametros>tbody").append("<tr><td id='id_maquina_parametro' style='visibility:collapse; display:none;'></td>"
                +"<td id='id_parametro'>"+IdParametro+"</td>"
                +"<td id='orden'> <input type='number' name='orden' class='form-control' min='1' required='required'></td>"
                +"<td id='nombre_parametro'>"+NombreParametro+"</td>"
                +"<td id='valor_minimo' contenteditable='true'>"+ValorMinimo+"</td>"
                +"<td id='valor_maximo' contenteditable='true'>"+ValorMaximo+"</td>"
                +"<th> <button type='button' class='borrar btn btn-danger btn-sm' title='Eliminar'><i class='fa fa-trash'></i></button> </th> </tr>");
        }
}

//OBTENER DATOS DE LA TABLA 
function CapturarDatosTabla()
{
    let parametros = [];
    
    document.querySelectorAll('#tabla_parametros tbody tr').forEach(function(e){
        let fila = {
            id_maquina_parametro: e.querySelector('#id_maquina_parametro').innerText,
            orden: e.querySelector('#orden input[name="orden"]').value,
            id_parametro: e.querySelector('#id_parametro').innerText,
            nombre_parametro: e.querySelector('#nombre_parametro').innerText,
            valor_minimo: e.querySelector('#valor_minimo').innerText,
            valor_maximo: e.querySelector('#valor_maximo').innerText,
        };

        parametros.push(fila);
    });

    $('#parametros').val(JSON.stringify(parametros)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return parametros;
}

//ELIMINAR ADICIONALES CON AJAX
function EliminarParametro(id)
{
    $.ajax({
        // dataType: "JSON",
        url: eliminarparametro+'/'+id,
        type: 'post',
        data:
        {
            _token: $("input[name=_token]").val(),
            _method: 'delete'
        },
        success: function(data)
        {
            //console.log("eliminado");
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
}

//boton elimnar filas de tablas
$(document).on('click', '.borrar', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});
