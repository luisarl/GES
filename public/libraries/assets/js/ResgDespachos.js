
//LLENA LA TABLA ADICIONALES CON LOS DATOS DE CLASIFICACION SELECCIONADOS
function CargarTabla()
{
    var IdResguardo = $("#id_articulo").val();
    var articulo = $("#id_articulo option:selected").text();
    var cantidad = $('#cantidad').val();
    var StockActual = $('#stock_actual').val();

    var ListaArticulos = CapturarDatosTabla();

    for (i = 0; i < ListaArticulos.length; i++) // si tiene datos la tabla de articulos
    {
        // verifica si el articulo seleccionada fue cargado
        if(ListaArticulos[i].id_resguardo == IdResguardo ) 
        {
            //si el articulo esta cargado muestra el mensaje y sale de la funcion
            alert('EL ARTICULO DE RESGUARDO YA ESTA CARGADO');
            return; 
        }
    }
    
    if(IdResguardo  == 0 )
    {
        alert('DEBE SELECCIONAR UN ARTICULO');
    }
    else if( cantidad <= 0 || cantidad > StockActual) //valida si la cantidad ingresada es mayor al stock o menor a cero
        {
            alert('LA CANTIDAD INGRESADA ES INVALIDA');
            $('#cantidad').val('');
        }
        else
            {
            
            $("#tablaarticulos>tbody").append("<tr><td id='id_solicitud_despacho_detalle' style='visibility:collapse; display:none;'></td>"
                +"<td id='id_resguardo' style='visibility:collapse; display:none;'>"+IdResguardo+"</td>"
                +"<td id='codigo_articulo'>"+articulo.split('|')[0]+"</td>"
                +"<td id='nombre_articulo'>"+articulo.split('|')[1]+"</td>"
                +"<td id='unidad'>"+articulo.split('|')[2]+"</td>"
                +"<td id='cantidad_disponible'>"+articulo.split('|')[3]+"</td>"
                +"<td id='cantidad'>"+cantidad+"</td>"
                +"<td id='estado'>"+articulo.split('|')[4]+"</td>"
                +"<td id='disposicion_final'>"+articulo.split('|')[5]+"</td>"
                //+"<td id='id_clasificacion' style='visibility:collapse; display:none;'>"+IdClasificacion+"</td>"
                //+"<td id='disposicion_final'>"+DisposicionFinal+"</td>"
                //+"<td id='observacion' contenteditable='true'>"+comentario+"</td>"
                +"<th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
            }   
}

//OBTENER DATOS DE LA TABLA 
function CapturarDatosTabla()
{
    let lista_articulos = [];
    
    document.querySelectorAll('#tablaarticulos tbody tr').forEach(function(e){
        let fila = {
            id_solicitud_despacho_detalle: e.querySelector('#id_solicitud_despacho_detalle').innerText,
            id_resguardo: e.querySelector('#id_resguardo').innerText,
            cantidad_disponible: e.querySelector( '#cantidad_disponible').innerText,
            cantidad: e.querySelector('#cantidad').innerText,
            // codigo_articulo: e.querySelector('#codigo_articulo').innerText,
            // nombre_articulo: e.querySelector('#nombre_articulo').innerText,
            // unidad: e.querySelector('#unidad').innerText,
            // cantidad: e.querySelector('#cantidad').innerText,
            // estado: e.querySelector('#estado').innerText,
            // id_clasificacion: e.querySelector('#id_clasificacion').innerText,
            // disposicion_final: e.querySelector('#disposicion_final').innerText,
            // observacion: e.querySelector('#observacion').innerText,
        };

        lista_articulos.push(fila);
    });

    console.log(JSON.stringify(lista_articulos));
    $('#articulos').val(JSON.stringify(lista_articulos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return lista_articulos;
}

function CapturarDatosTablaDespacho()
{
    let lista_articulos = [];
    
    document.querySelectorAll('#tablaarticulos tbody tr').forEach(function(e){
        let fila = {
            id_solicitud_despacho_detalle: e.querySelector('#id_solicitud_despacho_detalle').innerText,
            id_resguardo: e.querySelector('#id_resguardo').innerText,
            cantidad_disponible: e.querySelector( '#cantidad_disponible').innerText,
            cantidad: e.querySelector('#cantidad').innerText,
            // codigo_articulo: e.querySelector('#codigo_articulo').innerText,
            // nombre_articulo: e.querySelector('#nombre_articulo').innerText,
            // unidad: e.querySelector('#unidad').innerText,
            // cantidad: e.querySelector('#cantidad').innerText,
            // estado: e.querySelector('#estado').innerText,
            // id_clasificacion: e.querySelector('#id_clasificacion').innerText,
            // disposicion_final: e.querySelector('#disposicion_final').innerText,
            // observacion: e.querySelector('#observacion').innerText,
        };

        lista_articulos.push(fila);
    });

    console.log(JSON.stringify(lista_articulos));
    $('#articulos_despacho').val(JSON.stringify(lista_articulos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return lista_articulos;
}

//LLENA EL SELECT DE ARTICULOS
function CargarArticulos() 
{
    var IdAlmacen = $('#id_almacen').val();

    $.get(BuscarArticulos +'/'+ IdAlmacen, function(data) {
        var old = $('#id_articulo').data('old') != '' ? $('#id_articulo').data('old') : '';
        $('#id_articulo').empty();

        $.each(data, function(fetch, articulos) {
            console.log(data);
            $('#id_articulo').append('<option value="0">SELECCIONE</option>');
            for (i = 0; i < articulos.length; i++) 
            {
                $('#id_articulo').append('<option value="' + articulos[i].id_resguardo + '"   ' + (old ==
                    articulos[i].id_resguardo ? "selected" : "") + ' >'
                    +articulos[i].codigo_articulo+ ' | '
                    +articulos[i].nombre_articulo+ ' | '
                    +parseFloat(articulos[i].equivalencia_unidad, 2)+ ' '
                    +articulos[i].tipo_unidad+ ' | '
                    +parseFloat(articulos[i].cantidad_disponible, 2)+ ' | '
                    +articulos[i].estado+ ' | '
                    +articulos[i].nombre_clasificacion+ ' | '
                    +'SOLRESG: '+ articulos[i].id_solicitud_resguardo
                    +'</option>');
            }
        })

    })
}

function StockArticulo()
{
    var stock = parseFloat($("#id_articulo option:selected").text().split("|")[3]);
    $('#stock_actual').val(stock);
    $('#cantidad').val(stock);
    $("#cantidad").attr("max", stock);
}


//ELIMINAR ADICIONALES CON AJAX
function EliminarDetalle(id)
{
    $.ajax({
        // dataType: "JSON",
        url: EliminarArticulo+'/'+id,
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



$('#articulo').keypress(function(e)
{
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if(keycode == 13)
    {
        e.preventDefault();
        CargarArticulos();
        
    }
})

CargarArticulos();
$('#id_almacen').on('change', CargarArticulos);
      