
//Oculta o muestra los campos segun el tipo de conductor
function TipoConductor()
{
    var ChoferInterno = document.getElementById("ChoferInterno");
    var ChoferForaneo = document.getElementById('ChoferForaneo');

    if(ChoferInterno.checked )
    {
        $('#ConductorInterno').show();
        $('#ConductorForaneo').hide();
    }
     else if(ChoferForaneo.checked)
            {
                $('#ConductorInterno').hide();
                $('#ConductorForaneo').show();
            }
}

//Oculta o muestra los campos segun el tipo de vehiculo
function TipoVehiculo()
{
    var VehiculoInterno = document.getElementById("VehiculoInterno");
    var VehiculoForaneo = document.getElementById('VehiculoForaneo');

    if(VehiculoInterno.checked )
    {
        $('#id_vehiculo').show() ;
        $('#PlacaVehiculoForaneo').hide();
        $('#MarcaVehiculoForaneo').hide();
        $('#ModeloVehiculoForaneo').hide();
    }
     else if(VehiculoForaneo.checked)
            {
                $('#id_vehiculo').hide() ;
                $('#PlacaVehiculoForaneo').show();
                $('#MarcaVehiculoForaneo').show();
                $('#ModeloVehiculoForaneo').show();
            }
}

//Oculta o muestra los campos segun el tipo de articulo
function TipoArticulo()
{
    var ArticuloInterno = document.getElementById('ArticuloInterno');
    var ArticuloOtro = document.getElementById('ArticuloOtro');

    if(ArticuloInterno.checked )
    {
        $('#buscar_articulo').show();
        $('#id_articulo_interno').show() ;
        $('#unidades').show() ;
        $('#UnidadOtro').hide();
        $('#id_articulo_otro').hide();
    }
     else if(ArticuloOtro.checked)
            {
                $('#buscar_articulo').hide();
                $('#id_articulo_interno').hide() ;
                $('#unidades').hide();
                $('#UnidadOtro').show();
                $('#id_articulo_otro').show();
            }
}


TipoConductor();
TipoVehiculo();

//LLENA LA TABLA ADICIONALES CON LOS DATOS DE CLASIFICACION SELECCIONADOS
function CargarTabla()
{
    var articulo = $("#id_articulo option:selected").text();
    var ArticuloOtro = $("#id_articulo_foraneo").val();
    var unidad = $('#unidades').val();
    var UnidadOtro = $('#UnidadOtro option:selected').text();
    var cantidad = $('#cantidad').val();
    var comentario = $('#comentario').val();
    
    var lista_articulos = CapturarDatosTabla(); //captura los datos de la  tabla
    
    if( cantidad <= 0) //valida si la cantidad ingresada es mayor al stock o menor a cero
    {
        alert('LA CANTIDAD INGRESADA ES INVALIDA');
        $('#cantidad').val('');
    }
    else 
        {
            for (i = 0; i < lista_articulos.length; i++) // si tiene datos la tabla de herramientas
            {
                // verifica si la herramienta seleccionada fue cargada
                if(lista_articulos[i].id_articulo == articulo.split(' - ')[0] && ArticuloInterno.checked == true) 
                {
                    //si la herramienta esta cargada muestra el mensaje y sale de la funcion
                    alert('LA HERRAMIENTA YA ESTA CARGADA');
                    return; 
                }
            }
            // si la herramienta no esta cargada la agrega a la tabla
            if(ArticuloInterno.checked == true)
            {
                $("#tablaajuste>tbody").append("<tr><td id='id_detalle' style='visibility:collapse; display:none;'></td>"
                    +"<td id='id_articulo'>"+articulo.split('|')[0]+"</td>"
                    +"<td id='nombre_articulo'>"+articulo.split('|')[1]+"</td>"
                    +"<td id='unidad'>"+unidad+"</td>"
                    +"<td id='cantidad'>"+cantidad+"</td>"
                    +"<td id='comentario' contenteditable='true'>"+comentario+"</td>"
                    +"<td id='importacion'></td>"
                    +"<th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
            }
            else
                {
                    $("#tablaajuste>tbody").append("<tr><td id='id_detalle' style='visibility:collapse; display:none;'></td>"
                        +"<td id='id_articulo'>GEN001</td>"
                        +"<td id='nombre_articulo'>"+ArticuloOtro+"</td>"
                        +"<td id='unidad'>"+UnidadOtro+"</td>"
                        +"<td id='cantidad'>"+cantidad+"</td>"
                        +"<td id='comentario' contenteditable='true'>"+comentario+"</td>"
                        +"<td id='importacion'></td>"
                        +"<th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
            
                }
            $('#cantidad').val('');
            $('#comentario').val('');
            $('#id_articulo_foraneo').val('');
        }
}

//LLENA LA TABLA ADICIONALES CON LOS DATOS DE LA NDR PROFIT
function CargarTablaNotaEntregaProfit()
{
   var IdAlmacen = $('#id_almacen').val();
   var numero = $('#numero').val();

    $.get(importarnde +'?id_almacen='+ IdAlmacen+'&numero='+numero, function(data) {
        $.each(data, function(fetch, articulos) {
            for (i = 0; i < articulos.length; i++) {
                $("#tablaajuste>tbody").append("<tr><td id='id_detalle' style='visibility:collapse; display:none;'></td>"
                    +"<td id='id_articulo'>"+articulos[i].codigo_articulo+"</td>"
                    +"<td id='nombre_articulo'>"+articulos[i].nombre_articulo+"</td>"
                    +"<td id='unidad'>"+articulos[i].unidad+"</td>"
                    +"<td id='cantidad'>"+articulos[i].cantidad+"</td>"
                    +"<td id='comentario' contenteditable='true'></td>"
                    +"<td id='importacion'>PROFIT NDE: "+numero+"</td>"
                    +"<th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
            }
        })
    })

    $('#cantidad').val('');
    $('#comentario').val('');
    $('#id_articulo_foraneo').val('');
}

//LLENA LA TABLA ADICIONALES CON LOS DATOS DEL DESPACHO DE CONTROL HERRAMIENTAS
function CargarTablaDespachoHerramientas()
{
   var numero = $('#numero_despacho').val();

    $.get(HerramientasDespacho +'/'+numero, function(data) {
        $.each(data, function(fetch, herramientas) {
            for (i = 0; i < herramientas.length; i++) {
                $("#tablaajuste>tbody").append("<tr><td id='id_detalle' style='visibility:collapse; display:none;'></td>"
                +"<td id='id_articulo'>"+herramientas[i].codigo_herramienta+"</td>"
                +"<td id='nombre_articulo'>"+herramientas[i].nombre_herramienta+"</td>"
                +"<td id='unidad'>UNIDAD</td>"
                +"<td id='cantidad'>"+herramientas[i].cantidad_entregada+"</td>"
                +"<td id='comentario' contenteditable='true'></td>"
                +"<td id='importacion'>ACERONET DESPACHO: "+numero+"</td>"
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
    
    document.querySelectorAll('#tablaajuste tbody tr').forEach(function(e){
        let fila = {
            id_detalle: e.querySelector('#id_detalle').innerText,
            id_articulo: e.querySelector('#id_articulo').innerText,
            nombre_articulo: e.querySelector('#nombre_articulo').innerText,
            unidad: e.querySelector('#unidad').innerText,
            cantidad: e.querySelector('#cantidad').innerText,
            comentario: e.querySelector('#comentario').innerText,
            importacion: e.querySelector('#importacion').innerText,
        };

        lista_articulos.push(fila);
    });

    //console.log(JSON.stringify(lista_articulos));
    $('#datosmovimiento').val(JSON.stringify(lista_articulos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST

    return lista_articulos;

}

function CapturarDatosTablaRetorno()
{
    let lista_articulos = [];
    
    document.querySelectorAll('#tablaretorno tbody tr').forEach(function(e){
        var retorna = e.querySelector('.retorna').innerText;
       
       // if (estatus != 'CERRADO' && item != 0)
        if (retorna == 'SI')
        {
            console.log(e.querySelector('.item').innerText);
            let fila = {
                id_detalle: e.querySelector('.id_detalle').innerText,
                item: e.querySelector('.item').innerText,
                codigo_articulo: e.querySelector('.codigo_articulo').innerText,
                nombre_articulo: e.querySelector('.nombre_articulo').innerText,
                unidad: e.querySelector('.unidad').innerText,
                cantidad_salida: e.querySelector('.cantidad_salida').innerText,
                cantidad_retorno: e.querySelector('.cantidad_retorno').innerText,
                estatus: e.querySelector('.estatus').innerText,
                observacion: e.querySelector('.observacion').innerText,
            };

            lista_articulos.push(fila);
        }
               
    });

    console.log(JSON.stringify(lista_articulos));
    $('#datosretorno').val(JSON.stringify(lista_articulos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return lista_articulos;
}

function CapturarDatosCierre()
{
    let lista_articulos = [];
    
    document.querySelectorAll('#tablacierre tbody tr').forEach(function(e){
      
        var cierre = e.querySelector('#cierre').innerText;

        if (cierre == 'SI')
        {
            let fila = {
                cerrar: e.querySelector('.cerrar input[name="cerrar"]').checked,
                id_detalle: e.querySelector('#id_detalle').innerText,
                observacion_almacen: e.querySelector('.observacion_almacen').innerText,
            };

            lista_articulos.push(fila);
        }
               
    });

    console.log(JSON.stringify(lista_articulos));
    $('#datoscierre').val(JSON.stringify(lista_articulos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return lista_articulos;
}

//Captura el departamento del empleado
function DepartamentoEmpleado()
{
    var departamento = $("#solicitante option:selected").text();
    document.getElementById("departamento").value = departamento.split('- ')[1];

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

//LLENA EL SELECT DE SubTipos
function CargarSubTipos() 
{
    var tipo = $('#id_tipo').val();

    $.get(SubTiposSalidas +'/'+ tipo, function(data) {
        var old = $('#id_subtipo').data('old') != '' ? $('#id_subtipo').data('old') : '';
        $('#id_subtipo').empty();

        $.each(data, function(fetch, subtipos) {
            console.log(data);
            $('#id_subtipo').append('<option value="0">SELECCIONE</option>');
            for (i = 0; i < subtipos.length; i++) {
                $('#id_subtipo').append('<option value="' + subtipos[i].id_subtipo + '"   ' + (old ==
                    subtipos[i].id_subtipo ? "selected" : "") + ' >'+subtipos[i].nombre_subtipo+ '</option>');
            }
        })

    })
}


//ELIMINAR ADICIONALES CON AJAX
function EliminarDetalle(id)
{
    $.ajax({
        // dataType: "JSON",
        url: eliminardetalle+'/'+id,
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
CargarUnidades();
$('#id_articulo').on('change', CargarUnidades);

// CargarArticulos();
// $('#articulo').on('keyup', CargarArticulos);

$('#articulo').keypress(function(e)
{
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if(keycode == 13)
    {
        e.preventDefault();
        CargarArticulos();
        
    }
})
CargarSubTipos();
TipoArticulo();

$('#id_tipo').on('change', CargarSubTipos);