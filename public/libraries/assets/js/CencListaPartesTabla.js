function miCard(){
    var card = document.getElementById("select_tipo");
    var miCardPlanchas1 = document.getElementById("miCardPlanchas1");
    var miCardPerfiles2 = document.getElementById("miCardPerfiles2");
   
    if(card.value === "PLANCHAS")
    {
        miCardPlanchas1.style.display = "block"; 
        miCardPerfiles2.style.display = "none";
    }
    else
    { 
        miCardPlanchas1.style.display = "none"; 
        miCardPerfiles2.style.display = "block";
    }
}

// function miCardPerforacion(){
//     var cardperf = document.getElementById("perforacion");
//     var miCardperforacionPlanchas1 = document.getElementById("miCardperforacionPlanchas1");
//     var miCardperforacionPerfiles2 = document.getElementById("miCardperforacionPerfiles2");
//     var miCardTablaPlanchas = document.getElementById("tabla_planchaspn");
//     var miCardTablaPerfiles = document.getElementById("tabla_perfilespn");
//     var ocultarAgregarPlancha = document.getElementById("ocultarAgregarPlancha");
//     var ocultarAgregarPerfil = document.getElementById("ocultarAgregarPerfil");

//     if(cardperf.value === "si"){
//         ocultarAgregarPlancha.style.display = "none";
//         ocultarAgregarPerfil.style.display = "none";
//         miCardperforacionPlanchas1.style.display = "block";
//         miCardperforacionPerfiles2.style.display = "block";
//         miCardTablaPlanchas.style.display = "none";
//         miCardTablaPerfiles.style.display = "none";
//     }else{
//         ocultarAgregarPlancha.style.display = "block";
//         ocultarAgregarPerfil.style.display = "block";
//         miCardperforacionPlanchas1.style.display = "none";
//         miCardperforacionPerfiles2.style.display = "none";
//         miCardTablaPlanchas.style.display = "block";
//         miCardTablaPerfiles.style.display = "block";
//     }
// }



//LLENA LA TABLA PLANCHAS SIN PERFORACION
// function CargarTablaPlanchaSP() {
//     var nroparte_pla      = $("#_nroparte_pla").val();
//     var descripcion_pla   = $("#_descripcion_pla").val();
//     var prioridad_pla     = $("#_prioridad_pla").val();
//     var dimensiones_pla1   = $("#_dimensiones_pla1").val();
//     var dimensiones_pla2   = $("#_dimensiones_pla2").val();
//     var espesor_pla       = $("#_espesor_pla").val();
//     var cantpiezas_pla    = $("#_cantpiezas_pla").val();
//     var datos_dim_pla     = dimensiones_pla1+"x"+dimensiones_pla2;
//     var datos_pesou_pla   = dimensiones_pla1 * dimensiones_pla2 * espesor_pla * 0.000008;
//     var peso_unit_pla     = datos_pesou_pla.toFixed(2);
//     var datos_pesot_pla   = peso_unit_pla * cantpiezas_pla;
//     var peso_total_pla    = datos_pesot_pla.toFixed(2);

//     if ($("#_nroparte_pla").val() == 0 || $("#_descripcion_pla").val() == 0 
//     || $("#_prioridad_pla").val() == 0 || $("#_dimensiones_pla1").val() == 0
//     || $("#_dimensiones_pla2").val() == 0 || $("#_espesor_pla").val() == 0 
//     || $("#_cantpiezas_pla").val() == 0 || $("#_peso_unit_pla").val() == 0 
//     || $("#_peso_total_pla").val() == 0)
//     {
//         alert('Para Agregar complete los valores faltantes');
//         return;
//     } 
//     else
//     {
//         $("#tablaplasp>tbody").append("<tr>"
//         +"<td contenteditable='true' id='nroparte_pla'>"+nroparte_pla+"</td>"
//         +"<td contenteditable='true' id='prioridad_pla'>"+prioridad_pla+"</td>"
//         +"<td contenteditable='true' id='descripcion_pla'>"+descripcion_pla+"</td>"
//         +"<td contenteditable='true' id='datos_dim_pla'>"+datos_dim_pla+"</td>"
//         +"<td contenteditable='true' id='espesor_pla'>"+espesor_pla+"</td>"
//         +"<td contenteditable='true' id='cantpiezas_pla'>"+cantpiezas_pla+"</td>"
//         +"<td contenteditable='true' id='peso_unit_pla'>"+peso_unit_pla+"</td>"
//         +"<td contenteditable='true' id='peso_total_pla'>"+peso_total_pla+"</td>"
//         +"<th><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
//     }

//     //LIMPIAR CAMPOS
//     $("#_nroparte_pla").val('');
//     $("#_descripcion_pla").val('');
//     $("#_prioridad_pla").val('');
//     $("#_dimensiones_pla1").val('');
//     $("#_dimensiones_pla2").val('');
//     $("#_espesor_pla").val('');
//     $("#_cantpiezas_pla").val('');
//     $("#_peso_unit_pla").val('');
//     $("#_peso_total_pla").val('');
// }

//LLENA LA TABLA PLANCHAS CON PERFORACION
function CargarTablaPlanchaCP() {
    var nroparte_placp      = $("#_nroparte_pla").val();
    var descripcion_placp   = $("#_descripcion_pla").val();
    var prioridad_placp     = $("#_prioridad_pla").val();
    var dimensiones_placp1  = $("#_dimensiones_pla1").val();
    var dimensiones_placp2  = $("#_dimensiones_pla2").val();
    var espesor_placp       = $("#_espesor_pla").val();
    var cantpiezas_placp    = $("#_cantpiezas_pla").val();
    var datos_dim_placp     = dimensiones_placp1+"x"+dimensiones_placp2;
    var datos_pesou_placp   = dimensiones_placp1 * dimensiones_placp2 * espesor_placp * 0.000008;
    var peso_unit_placp     = datos_pesou_placp.toFixed(2);
    var datos_pesot_placp   = peso_unit_placp * cantpiezas_placp;
    var peso_total_placp    = datos_pesot_placp.toFixed(2);
    var diametro_placp      = $("#_diametro_perf_pla").val();
    var cant_perf_placp     = $("#_cant_perf_pla").val();

    if ($("#_diametro_perf_pla").val() == "" || diametro_placp  === null ) 
    {
        diametro_placp  = 0;
    }

    if ($("#_cant_perf_pla").val() == "" || _cant_perf_pla === null ) 
    {
        cant_perf_placp = 0;
    }

    var cant_total_placp    = cantpiezas_placp * cant_perf_placp;

    if ($("#_nroparte_pla").val() == 0 || $("#_descripcion_pla").val() == 0 
    || $("#_prioridad_pla").val() == 0 || $("#_dimensiones_pla1").val() == 0
    || $("#_dimensiones_pla2").val() == 0 || $("#_espesor_pla").val() == 0 
    || $("#_cantpiezas_pla").val() == 0 || $("#_peso_unit_pla").val() == 0 
    || $("#_peso_total_pla").val() == 0 || $("#_cant_total_pla").val() == 0)
    {
        alert('Para Agregar complete los valores faltantes');
        return;
    } 
    else 
    {
        $("#tablaplacp>tbody").append("<tr>"
        +"<td contenteditable='true' id='nroparte_placp'>"+nroparte_placp+"</td>"
        +"<td contenteditable='true' id='prioridad_placp'>"+prioridad_placp+"</td>"
        +"<td contenteditable='true' id='descripcion_placp'>"+descripcion_placp+"</td>"
        +"<td contenteditable='true' id='datos_dim_placp'>"+datos_dim_placp+"</td>"
        +"<td contenteditable='true' id='espesor_placp'>"+espesor_placp+"</td>"
        +"<td contenteditable='true' id='cantpiezas_placp'>"+cantpiezas_placp+"</td>"
        +"<td contenteditable='true' id='peso_unit_placp'>"+peso_unit_placp+"</td>"
        +"<td contenteditable='true' id='peso_total_placp'>"+peso_total_placp+"</td>"
        +"<td contenteditable='true' id='diametro_perf_placp'>"+diametro_placp+"</td>"
        +"<td contenteditable='true' id='cant_perf_placp'>"+cant_perf_placp+"</td>"
        +"<td contenteditable='true' id='cant_total_placp'>"+cant_total_placp+"</td>"
        +"<th><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    }

    //LIMPIAR CAMPOS
    $("#_diametro_perf_pla").val(''); 
    $("#_cant_perf_pla").val('');   
    $("#_cant_total_pla").val('');   
}

//OBTENER DATOS DE LA TABLA PLANCHA SIN PERFORACION
function CapturarDatosTablaPlancha()
{
    var cardperf = document.getElementById("perforacion");

    let lista_datos = [];
       document.querySelectorAll('#tablaplacp tbody tr').forEach(function(e)
       {
           let fila = {
               nroparte_pla:      e.querySelector('#nroparte_placp').innerText,
               prioridad_pla:     e.querySelector('#prioridad_placp').innerText,
               descripcion_pla:   e.querySelector('#descripcion_placp').innerText,
               datos_dim_pla:   e.querySelector('#datos_dim_placp').innerText,
               espesor_pla:       e.querySelector('#espesor_placp').innerText,
               cantpiezas_pla:    e.querySelector('#cantpiezas_placp').innerText,
               peso_unit_pla:     e.querySelector('#peso_unit_placp').innerText,
               peso_total_pla:    e.querySelector('#peso_total_placp').innerText,
               diametro_perf_pla: e.querySelector('#diametro_perf_placp').innerText,
               cant_perf_pla:     e.querySelector('#cant_perf_placp').innerText,
               cant_total_pla:    e.querySelector('#cant_total_placp').innerText,  
           };
           lista_datos.push(fila);
       });

       let observaciones = [];
        document.querySelectorAll('#card_observaciones_plancha').forEach(function (e) {
            let fila = {
                observaciones_lista: e.querySelector('#observaciones_lista').value,
            };
            observaciones.push(fila);
        });

    const TodosDatos = {
        lista_datos,
        observaciones,
    };

    console.log(JSON.stringify(TodosDatos));
   // alert(JSON.stringify(TodosDatos));
    $('#datos_lplancha').val(JSON.stringify(TodosDatos));
    return TodosDatos;
}

//LLENA LA TABLA PERFILES CON PERFORACION
function CargarTablaPerfilesCP() {
    var nroparte_per         = $("#nroparte_per").val();
    var tipo_per             = $("#tipo_per").val();
    var cantidad_piezas_per  = $("#cantidad_piezas_per").val();
    var prioridad_per        = $("#prioridad_per").val();
    var longitud_pieza_per   = $("#longitud_pieza_per").val();
    var tipo_corte_per       = $("#tipo_corte_per ").val();
    var diametro_perf_per    = $("#diametro_perf_per").val();
    var cantidad_t_per        = $("#cantidad_t_per").val();
    var cantidad_s_per        = $("#cantidad_s_per").val();
    

    if ($("#diametro_perf_per").val() == "" || diametro_perf_per === null )
    {
        diametro_perf_per = 0;
    }

    if ($("#cantidad_t_per").val() == "" || cantidad_t_per === null )
    {
        cantidad_t_per = 0;
    }

    if ($("#cantidad_s_per").val() == "" || cantidad_t_per === null )
    {
        cantidad_s_per = 0;
    }

    var total_per = (parseFloat(cantidad_t_per) + parseFloat(cantidad_s_per)).toFixed(3);

    if ($("#nroparte_per").val() == 0 || $("#tipo_per").val() == 0 
    || $("#cantidad_piezas_per").val() == 0 || $("#prioridad_per").val() == 0  
    || $("#longitud_pieza_per").val() == 0 || $("#tipo_corte_per").val() == 0)
    {
        alert('Para Agregar complete los valores faltantes');
    } 
    else 
    {
        $("#tablaper_cp>tbody").append("<tr>"
        +"<td contenteditable='true' id='nroparte_per_cp'>"+nroparte_per+"</td>"
        +"<td contenteditable='true' id='prioridad_per_cp'>"+prioridad_per+"</td>"
        +"<td contenteditable='true' id='tipo_per_cp'>"+tipo_per+"</td>"
        +"<td contenteditable='true' id='cantidad_piezas_per_cp'>"+cantidad_piezas_per+"</td>"
        +"<td contenteditable='true' id='longitud_pieza_per_cp'>"+longitud_pieza_per+"</td>"
        +"<td contenteditable='true' id='tipo_corte_per_cp'>"+tipo_corte_per+"</td>"
        +"<td contenteditable='true' id='diametro_perf_per_cp'>"+diametro_perf_per+"</td>"
        +"<td contenteditable='true' id='cantidad_t_per_cp'>"+cantidad_t_per +"</td>"
        +"<td contenteditable='true' id='cantidad_s_per_cp'>"+cantidad_s_per +"</td>"
        +"<td contenteditable='true' id='total_per_cp'>"+total_per+"</td>"
        +"<th><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    }
    //LIMPIAR CAMPOS
    $("#diametro_perf_per").val('');
    $("#cantidad_t_per").val('');
    $("#cantidad_s_per").val('');
}

//OBTENER DATOS DE LA TABLA PERFIL 
function CapturarDatosTablaPerfil()
{
    var cardperf = document.getElementById("perforacion");
    
    let lista_perfiles = [];
       document.querySelectorAll('#tablaper_cp tbody tr').forEach(function(e)
       {
           let fila = {
               nroparte_per:        e.querySelector('#nroparte_per_cp').innerText,
               prioridad_per:       e.querySelector('#prioridad_per_cp').innerText,
               id_perfil:           parseInt(e.querySelector('#tipo_per_cp').innerText.split(" - ")[0]),
               cantidad_piezas_per: e.querySelector('#cantidad_piezas_per_cp').innerText,
               longitud_pieza_per:  e.querySelector('#longitud_pieza_per_cp').innerText,
               tipo_corte_per:      e.querySelector('#tipo_corte_per_cp').innerText,
               diametro_perf_per:   e.querySelector('#diametro_perf_per_cp').innerText,
               cantidad_t_per:      e.querySelector('#cantidad_t_per_cp').innerText,
               cantidad_s_per:      e.querySelector('#cantidad_s_per_cp').innerText,
               total_per_per:       e.querySelector('#total_per_cp').innerText,  
           };
           lista_perfiles.push(fila);
           console.log(lista_perfiles);
       });

       let observaciones = [];
       document.querySelectorAll('#card_observaciones_perfil').forEach(function (e) {
           let fila = {
            observaciones_lista: e.querySelector('#observaciones_lista').value,
           };
           observaciones.push(fila);
       });

    const TodosDatos = {
        lista_perfiles,
        observaciones,
    };

    console.log(JSON.stringify(TodosDatos));
   // alert(JSON.stringify(TodosDatos));
    $('#datos_lperfil').val(JSON.stringify(TodosDatos));
    return TodosDatos;
}

function LimpiarCampos(){

    // limpiar campos planchas 
    $("#_nroparte_pla").val('');
    $("#_descripcion_pla").val('');
    $("#_prioridad_pla").val('');
    $("#_dimensiones_pla1").val('');
    $("#_dimensiones_pla2").val('');
    $("#_espesor_pla").val('');
    $("#_cantpiezas_pla").val('');
    $("#_peso_unit_pla").val('');
    $("#_peso_total_pla").val('');
    $("#_diametro_perf_pla").val('');
    $("#_cant_perf_pla").val('');
    $("#_cant_total_pla").val('');

    // limpiar campos perfiles 
    $("#nroparte_per").val('');
    $("#tipo_per").val('');
    $("#cantidad_piezas_per").val('');
    $("#prioridad_per").val('');
    $("#longitud_pieza_per").val('');
    $("#tipo_corte_per ").val('');
    $("#diametro_perf_per").val('');
    $("#cantidad_t_per").val('');
    $("#cantidad_s_per").val('');
}

$(document).on('click', '.borrar', function(event) 
{
    event.preventDefault();
    $(this).closest('tr').remove();
});