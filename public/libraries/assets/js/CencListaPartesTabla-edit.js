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
    var diametro_placp      = $("#_diametro_perf_placp").val();
    var cant_perf_placp     = $("#_cant_perf_placp").val();
    var lista_parte         = $("#lista_parte_pla").val(); 

    if ($("#_diametro_perf_placp").val() == "" || diametro_placp  === null ) 
    {
        diametro_placp  = 0;
    }

    if ($("#_cant_perf_placp").val() == "" || _cant_perf_placp === null )
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
        +"<td><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></td>"
        +"<td id='auxiliar_pla' style='display: none;'>"+1+"</td>" 
        +"<td id='lista_parte_pla' style='display: none;'>"+lista_parte+"</td></tr>");
    }

    //LIMPIAR CAMPOS
    $("#_diametro_perf_placp").val(''); 
    $("#_cant_perf_placp").val('');   
    $("#_cant_total_pla").val('');   
}

//OBTENER DATOS DE LA TABLA PLANCHA SIN PERFORACION
function CapturarDatosTablaPlancha()
{
    var cardperf = document.getElementById("perforacion");
    let lista_datos = [];
    var aux = 0; 

    document.querySelectorAll('#tablaplacp tbody tr').forEach(function(e){
        aux = parseInt(e.querySelector('#auxiliar_pla').innerText);
        console.log(aux);
        if(aux==1){
            let fila = {
                nroparte_pla:      e.querySelector('#nroparte_placp').innerText,
                prioridad_pla:     e.querySelector('#prioridad_placp').innerText,
                descripcion_pla:   e.querySelector('#descripcion_placp').innerText,
                datos_dim_pla:     e.querySelector('#datos_dim_placp').innerText,
                espesor_pla:       e.querySelector('#espesor_placp').innerText,
                cantpiezas_pla:    e.querySelector('#cantpiezas_placp').innerText,
                peso_unit_pla:     e.querySelector('#peso_unit_placp').innerText,
                peso_total_pla:    e.querySelector('#peso_total_placp').innerText,
                diametro_perf_pla: e.querySelector('#diametro_perf_placp').innerText,
                cant_perf_pla:     e.querySelector('#cant_perf_placp').innerText,
                cant_total_pla:    e.querySelector('#cant_total_placp').innerText,
                lista_parte_pla:   e.querySelector('#lista_parte_pla').innerText
            };
            lista_datos.push(fila);
        }
    });

    let observaciones = [];
    document.querySelectorAll('#card_observaciones_plancha').forEach(function (e) {
        let fila = {
            observaciones_plancha: e.querySelector('#observaciones_plancha').value,
        };
        observaciones.push(fila);
    });

    const TodosDatos = {
        lista_datos,
        observaciones,
    };

    //alert(JSON.stringify(TodosDatos));
    console.log(JSON.stringify(TodosDatos));
    $('#datos_lplancha').val(JSON.stringify(TodosDatos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST
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
    var lista_parte          = $("#lista_parte_per").val(); 
    

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
        +"<th><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th>" 
        +"<td id='auxiliar_per' style='display: none;'>"+1+"</td>" 
        +"<td id='lista_parte_per' style='display: none;'>"+lista_parte+"</td></tr>");
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
    var aux = 0; 
    
    // if(cardperf.value === "si"){
       
       document.querySelectorAll('#tablaper_cp tbody tr').forEach(function(e){
            aux = parseInt(e.querySelector('#auxiliar_per').innerText);
            if(aux==1)
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
                    lista_parte_per:   e.querySelector('#lista_parte_per').innerText
                };
                lista_perfiles.push(fila);
                console.log(lista_perfiles);
            }
       });

        let observaciones = [];
        document.querySelectorAll('#card_observaciones_perfil').forEach(function (e) {
            let fila = {
                observaciones_perfil: e.querySelector('#observaciones_perfil').value,
            };
            observaciones.push(fila);
        });

        const TodosDatos = {
            lista_perfiles,
            observaciones,
        };

        console.log(JSON.stringify(TodosDatos));
        $('#datos_lperfil').val(JSON.stringify(TodosDatos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST
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