//LLENA LA TABLA PLANCHAS CON LOS DATOS DE UBICACION SELECCIONADOS
function CargarTablaPlancha() {
    var nroparte = $("#_nroparte_pla").val();  
    var cantidad = $("#_cantidad_pla").val();
    var espesor = $("#_espesor_pla").val();
    var medida1 = $("#_medida1_pla").val();
    var medida2 = $("#_medida2_pla").val();
    var peso = $("#_peso_pla").val();
    var omm = $("#_omm_pla").val();
    var piezas = $("#_piezas_pla").val();
    var observacion = $("#_observacion_pla").val(); 

    if ($("#_nroparte_pla").val() == 0 && $("#_cantidad_pla").val() == 0 && $("#_espesor_pla").val() == 0 && $("#_medida1_pla").val() == 0  && $("#_medida2_pla").val() == 0 && $("#_omm_pla").val() == 0 && $("#_piezas_pla").val() == 0 && $("#_observacion_pla").val() == 0) {
        alert('Para Agregar complete los valores faltantes');
    } else {
        $("#tabla_planchas>tbody").append("<tr><td contenteditable='true' id='id_nroparte_pla'>"+ nroparte +"</td><td contenteditable='true' id='id_cantidad_pla'>" + cantidad + "</td><td contenteditable='true' id='id_espesor_pla'>" + espesor + "</td><td contenteditable='true' id='id_medida1_pla'>" + medida1 + "x"+ medida2 +"<td contenteditable='true' id='_peso_pla'>"+ peso+"</td> <td contenteditable='true' id='peso_total'></td> <td contenteditable='true' id='id_omm_pla'>"+omm+"</td><td contenteditable='true' id='id_piezas_pla'>"+piezas+"</td> <td contenteditable='true' id='peso_total'></td> <td contenteditable='true' id='id_observacion_pla'>"+observacion+
        "</td></td><th><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    } 

    //Limpia campos 
    $("#_nroparte_pla").val("");
    $("#_cantidad_pla").val("");
    $("#_espesor_pla").val("");
    $("#_medida1_pla").val("");
    $("#_medida2_pla").val("");
    $("#_peso_pla").val("");
    $("#_omm_pla").val("");
    $("#_piezas_pla").val("");
    $("#_observacion_pla").val("");
    
}

//LLENA LA TABLA PLANCHAS CON LOS DATOS DE UBICACION SELECCIONADOS
function CargarTablaPerfiles() {
    var nroparte = $("#_nroparte_per").val();
    var longitud = $("#_longitud_per").val();
    var peso = $("#_peso_per").val();
    var cantidad = $("#_cantidad_per").val();
    var referencia1 = $("#_referencia1_per").val();
    var referencia2 = $("#_referencia2_per").val();
    var omm = $("#_omm_per").val();
    var piezas = $("#_piezas_per").val();
    var observacion = $("#_observacion_per").val();

    if ($("#_nroparte_per").val() == 0 && $("#_longitud_per").val() == 0 && $("#_cantidad_per").val() == 0 && $("#_referencia1_per").val() == 0  && $("#_referencia2_per").val() == 0 && $("#_omm_per").val() == 0 && $("#_piezas_per").val() == 0 && $("#_observacion_per").val() == 0 && $("#_peso_per").val() == 0) {
        alert('Para Agregar complete los valores faltantes');
    } else {
        $("#tabla_perfiles>tbody").append("<tr><td contenteditable='true' id='id_nroparte_per'>"+ nroparte +"</td><td contenteditable='true' id='id_longitud_per'>"+ 42 +"<td contenteditable='true' id='id_peso_per'>"+ 17 + "<td contenteditable='true' id='id_cantidad_per'>" + cantidad + "</td><td contenteditable='true' id='id_referencias_per'>" + 410 + "x"+ 421 +"</td> <td contenteditable='true' id='peso_total_per'>"+34+"</td> <td contenteditable='true' id='id_omm_per'>"+omm+"</><td contenteditable='true' id='id_piezas_per'>"+piezas+"</td> <td contenteditable='true' id='peso_total'>"+25+"</td> <td contenteditable='true' id='id_observaciones_per'>"+observacion+
        "</td></td><th><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    } 

    //Limpia campos 
    $("#_nroparte_per").val("");
    $("#_longitud_per").val("");
    $("#_peso_per").val("");
    $("#_cantidad_per").val("");
    $("#_referencia1_per").val("");
    $("#_referencia2_per").val("");
    $("#_omm_per").val("");
    $("#_piezas_per").val("");
    $("#_observacion_per").val("");
    
}

//OBTENER DATOS DE LA TABLA ADICIONALES
function CapturarDatosTablaUbicacion()
{
    let listado_ubicaciones = [];
    
    document.querySelectorAll('#tabla_ubicaciones tbody tr').forEach(function(e){
        let fila = {
            id_articulo_ubicacion: e.querySelector('#id_articulo_ubicacion').innerText,
            id_almacen: e.querySelector('#id_almacen').innerText.split('-')[0].trim(),
            id_subalmacen: e.querySelector('#id_subalmacen').innerText.split('-')[0].trim(),
            id_zona: e.querySelector('#id_zona').innerText.split('-')[0].trim(),
            id_ubicacion: e.querySelector("#id_ubicacion").innerText,
        };

        listado_ubicaciones.push(fila);
    });

    console.log(JSON.stringify(listado_ubicaciones));
    $('#datosubicaciones').val(JSON.stringify(listado_ubicaciones)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST

    return listado_ubicaciones;
}


//boton elimnar filas de tablas
$(document).on('click', '.borrar', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});

