
//LLENA LA TABLA ADICIONALES CON LOS DATOS DE CLASIFICACION SELECCIONADOS
function CargarTabla()
{
    var CodigoArticulo = $("#id_articulo").val();
    var articulo = $("#id_articulo option:selected").text();
    var unidad = $('#unidades').val();
    var EquivalenciaUnidad = $('#equivalencia_unidad').val();
    var cantidad = $('#cantidad').val();
    var estado = $('#estado').val();
    var IdClasificacion =  $('#disposicion_final').val();
    var DisposicionFinal = $('#disposicion_final option:selected').text();
    var comentario = $('#comentario').val();
        
    if( cantidad <= 0 ) //valida si la cantidad ingresada es mayor al stock o menor a cero
    {
        alert('LA CANTIDAD INGRESADA ES INVALIDA');
        $('#cantidad').val('');
    }
    else if(EquivalenciaUnidad <= 0 || unidad == 0 || CodigoArticulo == 0 )
        {
            alert('FALTAN DATOS POR COMPLETAR');
        }
        else if(comentario == '' )
        {
            alert('LA OBSERVACION ES OBLIGATORIA');
        }
        else 
            {     
                $("#tablaarticulos>tbody").append("<tr><td id='id_resguardo' style='visibility:collapse; display:none;'></td>"
                    +"<td id='codigo_articulo'>"+CodigoArticulo+"</td>"
                    +"<td id='nombre_articulo'>"+articulo.split('|')[1]+"</td>"
                    +"<td id='unidad'>"+unidad+"</td>"
                    +"<td id='equivalencia_unidad'>"+EquivalenciaUnidad+"</td>"
                    +"<td id='cantidad'>"+cantidad+"</td>"
                    +"<td id='estado'>"+estado+"</td>"
                    +"<td id='id_clasificacion' style='visibility:collapse; display:none;'>"+IdClasificacion+"</td>"
                    +"<td id='disposicion_final'>"+DisposicionFinal+"</td>"
                    +"<td id='observacion' contenteditable='true'>"+comentario+"</td>"
                    +"<th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
        
                $('#cantidad').val('');
                $('#comentario').val('');
            
            }
}

//LLENA LA TABLA  CON LOS DATOS DE LA NDR PROFIT
function CargarTablaNotaEntregaProfit()
{
   var IdAlmacen = $('#id_almacen').val();
   var numero = $('#numero').val();

    $.get(importarnde +'?id_almacen='+ IdAlmacen+'&numero='+numero, function(data) {
        $.each(data, function(fetch, articulos) {
            for (i = 0; i < articulos.length; i++) {
                $("#tablaarticulos>tbody").append("<tr><td id='id_resguardo' style='visibility:collapse; display:none;'></td>"
                    +"<td id='codigo_articulo'>"+articulos[i].codigo_articulo+"</td>"
                    +"<td id='nombre_articulo'>"+articulos[i].nombre_articulo+"</td>"
                    +"<td id='unidad'>"+articulos[i].unidad+"</td>"
                    +"<td id='equivalencia_unidad'>1</td>"
                    +"<td id='cantidad' contenteditable='true'>"+articulos[i].cantidad+"</td>"
                    +"<td id='estado'>OPERATIVO</td>"
                    +"<td id='id_clasificacion' style='visibility:collapse; display:none;'>4</td>"
                    +"<td id='disposicion_final'>DEVOLUCION</td>"
                    +"<td id='observacion'>PROFIT NDE: "+numero+"</td>"
                    +"<th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
            }
        })
    })

    $('#cantidad').val('');
    $('#comentario').val('');
    $('#id_articulo_foraneo').val('');
}

//OBTENER DATOS DE LA TABLA 
function CapturarDatosTabla()
{
    let lista_articulos = [];
    
    document.querySelectorAll('#tablaarticulos tbody tr').forEach(function(e){
        let fila = {
            id_resguardo: e.querySelector('#id_resguardo').innerText,
            codigo_articulo: e.querySelector('#codigo_articulo').innerText,
            nombre_articulo: e.querySelector('#nombre_articulo').innerText,
            unidad: e.querySelector('#unidad').innerText,
            equivalencia_unidad: e.querySelector('#equivalencia_unidad').innerText,
            cantidad: e.querySelector('#cantidad').innerText,
            estado: e.querySelector('#estado').innerText,
            id_clasificacion: e.querySelector('#id_clasificacion').innerText,
            disposicion_final: e.querySelector('#disposicion_final').innerText,
            observacion: e.querySelector('#observacion').innerText,
        };

        lista_articulos.push(fila);
    });

    console.log(JSON.stringify(lista_articulos));
    $('#articulos').val(JSON.stringify(lista_articulos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return lista_articulos;

}

//OBTENER DATOS DE LA TABLA 
function CapturarDatosTablaResguardo()
{
    let lista_articulos = [];
    
    document.querySelectorAll('#tablaresguardo tbody tr').forEach(function(e){
        let fila = {
            id_resguardo: e.querySelector('#id_resguardo').innerText,
            codigo_articulo: e.querySelector('#codigo_articulo').innerText,
            nombre_articulo: e.querySelector('#nombre_articulo').innerText,     
            id_ubicacion: e.querySelector('#id_ubicacion select[name="ubicacion_articulo"]').value
        };

        lista_articulos.push(fila);
    });

    console.log(JSON.stringify(lista_articulos));
    $('#articulos_resguardo').val(JSON.stringify(lista_articulos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return lista_articulos;

}

//OBTENER DATOS DE LA TABLA 
function CapturarDatosTablaImpresion()
{
    let lista_articulos = [];
    
    document.querySelectorAll('#tablaimpresion tbody tr').forEach(function(e){
        let fila = {
            id_resguardo: e.querySelector('#id_resguardo').innerText,
            codigo_articulo: e.querySelector('#codigo_articulo').innerText,
            nombre_articulo: e.querySelector('#nombre_articulo').innerText,     
            presentacion: e.querySelector('#presentacion').innerText,
            clasificacion: e.querySelector('#clasificacion').innerText,
            cantidad_impresion: e.querySelector('#cantidad_impresion input[name="cantidad"]').value
        };

        lista_articulos.push(fila);
    });

    console.log(JSON.stringify(lista_articulos));
    $('#articulos_impresion').val(JSON.stringify(lista_articulos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return lista_articulos;

}


//LENA EL SELECT DE UNIDADES DE MEDIDA
function CargarUnidades() {

    var CodigoArticulo = $('#id_articulo').val();

    $.get(route +'/'+ CodigoArticulo.split('|')[0], function(data) {
        var old = $('#unidades').data('old') != '' ? $('#unidades').data('old') : '';
        $('#unidades').empty();

        $.each(data, function(fetch, unidades) {
            //console.log(data);
            if(unidades.length == 0)
            {
                $('#unidades').append('<option value="UNIDAD">UNIDAD</option>');
            }
            else
                {
                    for (i = 0; i < unidades.length; i++) 
                    {
                        $('#unidades').append('<option value="' + unidades[i].nombre_unidad + '"   ' + (old ==
                        unidades[i].nombre_unidad ? "selected" : "") + ' >'+ unidades[i]
                        .nombre_unidad +'</option>');
                     }
                }
        })
    })
}

//LLENA EL SELECT DE ARTICULOS
function CargarArticulos() 
{
    var articulo = $('#articulo').val();

    $.get(BuscarArticulos +'/'+ articulo, function(data) {
        var old = $('#id_articulo').data('old') != '' ? $('#id_articulo').data('old') : '';
        $('#id_articulo').empty();

        $.each(data, function(fetch, articulos) {
            console.log(data);
            $('#id_articulo').append('<option value="0">SELECCIONE</option>');
            for (i = 0; i < articulos.length; i++) {
                $('#id_articulo').append('<option value="' + articulos[i].codigo + '"   ' + (old ==
                    articulos[i].nombre ? "selected" : "") + ' >'+articulos[i].codigo+ ' | '+ articulos[i].nombre +'</option>');
            }
        })

    })
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


      