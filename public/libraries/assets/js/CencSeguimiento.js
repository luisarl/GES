function restarHoras(hora1, hora2, hora3, hora4)
{
    var equipo = $("#equipo").val();

    console.log(equipo);
    if (equipo === 'MORROCOY')
    {
        var segundosHora1 = convertirASegundos(hora1);
        var segundosHora2 = convertirASegundos(hora2);
        // Calcular la diferencia de segundos
        var diferenciaSegundos = segundosHora2 - segundosHora1;
    }
    else if(equipo === 'KF2612')
    {
        if (arguments.length === 4) 
        {
        // Convertir las horas a segundos
        var segundosHora1 = convertirASegundos(hora1);
        var segundosHora2 = convertirASegundos(hora2);
        // Calcular la diferencia de segundos
        var diferenciaSegundos = segundosHora2 - segundosHora1;

            var segundosHora3 = convertirASegundos(hora3);
            var segundosHora4 = convertirASegundos(hora4);
            var diferenciaSegundos2 = segundosHora4 - segundosHora3;
        } 
        else 
        {
            diferenciaSegundos2 = diferenciaSegundos;
        }
    }

    // Convertir la diferencia de segundos a formato de hora
    var resultado = convertirAHoras(diferenciaSegundos);
    var resultado2 = convertirAHoras(diferenciaSegundos2);
  
    return [resultado, resultado2];
  }

function convertirASegundos(hora)
{
    var partes = hora.split(":");
    var segundos = parseInt(partes[0]) * 3600 + parseInt(partes[1]) * 60 + parseInt(partes[2]);
    return segundos;
}

function convertirAHoras(segundos)
{
    var horas = Math.floor(segundos / 3600);
    var minutos = Math.floor((segundos % 3600) / 60);
    var segundosRestantes = segundos % 60;
    return pad(horas, 4) + ":" + pad(minutos, 2) + ":" + pad(segundosRestantes, 2);
}

function pad(num, size)
{
    var s = "0000" + num;
    return s.substr(s.length - size);
}

$(document).ready(function()
{
    $('#horometro_inicial_on, #horometro_final_on', '#horometro_inicial_aut', '#horometro_final_aut').inputmask({
        mask: '9999:99:99'
    });
    CalcularTotalesTablaHorometros();
    CalcularTotalesTablaAvance();
    CalcularTotalesTablaOxigeno();
});

function CalcularTotalesTablaHorometros()
{
    var ListaHorasON = $(".horas_on").map((i,el)=>Number(el.innerText.trim())).get();
    var TotalHorasOn = ListaHorasON.reduce((partialSum,a) => partialSum + a, 0);
    var ListaTiempoAut = $(".tiempo_aut").map((i,el)=>Number(el.innerText.trim())).get();
    var TotalTiempoAut = ListaTiempoAut.reduce((partialSum,a) => partialSum + a, 0);

    $("#total_horas_on").text(Number(TotalHorasOn).toFixed(2));
    $("#total_tiempo_aut").text(Number(TotalTiempoAut).toFixed(2));
}

function CargarHorometro()
{
    var equipo = $("#equipo").val();
    var fecha_creado = $("#fecha_creado_horometro").val();
    var horometro_inicial_on = $("#horometro_inicial_on").val();
    var horometro_final_on = $("#horometro_final_on").val();
    var horometro_inicial_aut = $("#horometro_inicial_aut").val();
    var horometro_final_aut = $("#horometro_final_aut").val();
    var [horas_maquina_on,tiempo_modo_aut] = restarHoras(horometro_inicial_on, horometro_final_on, horometro_inicial_aut, horometro_final_aut);
    
    var horas_on = (convertirASegundos(horas_maquina_on)/3600).toFixed(2);
    var tiempo_aut = (convertirASegundos(tiempo_modo_aut)/3600).toFixed(2);

    if (equipo === 'MORROCOY')
    {
        if (!fecha_creado || !horometro_inicial_on || !horometro_final_on) 
        {
                alert('Debe llenar todos los campos de la tabla HOROMETROS');
                return;
        }
        else
        {
        $("#TablaHorometro>tbody").append(
            "<tr></td> <td id='id_horometro'></td></td>" +
            "</td><td class='fecha_creado_horometro' id='fecha_creado_horometro'>" + fecha_creado +
            "</td><td id='horometro_inicial_on'>" + horometro_inicial_on +
            "</td><td id='horometro_final_on'>" + horometro_final_on +
            "</td><td id='horas_maquina_on'>" + horas_maquina_on +
            "</td><td class='horas_on' id='horas_on'>" + horas_on +
            "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
        }
        $("#fecha_creado_horometro").val("");
        $("#horometro_inicial_on").val("");
        $("#horometro_final_on").val("");
    } 
    else if(equipo === 'KF2612')
    {
            if (!fecha_creado || !horometro_inicial_on || !horometro_final_on || !horometro_inicial_aut || !horometro_final_aut) 
            {
                    alert('Debe llenar todos los campos de la tabla HOROMETROS');
                    return;
            }
            else
            {
            $("#TablaHorometro>tbody").append(
                "<tr></td> <td id='id_horometro'></td></td>" +
                "</td><td class='fecha_creado_horometro' id='fecha_creado_horometro'>" + fecha_creado +
                "</td><td id='horometro_inicial_on'>" + horometro_inicial_on +
                "</td><td id='horometro_final_on'>" + horometro_final_on +
                "</td><td id='horas_maquina_on'>" + horas_maquina_on +
                "</td><td class='horas_on' id='horas_on'>" + horas_on +
                "</td><td id='horometro_inicial_aut'>" + horometro_inicial_aut +
                "</td><td id='horometro_final_aut'>" + horometro_final_aut +
                "</td><td id='tiempo_modo_aut'>" +  tiempo_modo_aut +
                "</td><td class='tiempo_aut' id='tiempo_aut'>" +  tiempo_aut +
                "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
            }
            $("#fecha_creado_horometro").val("");
            $("#horometro_inicial_on").val("");
            $("#horometro_final_on").val("");
            $("#horometro_inicial_aut").val("");
            $("#horometro_final_aut").val("");
    }

    CalcularTotalesTablaHorometros();
}

function NroParte()
{
    var IdListaPartePlancha = $("#numero_parte option:selected").val();
    var IdListaParte = $(".id_listap").text();
    
    $.get(NumeroParte + '/' + IdListaParte + '/' + IdListaPartePlancha, function(data)
    {
         $.each(data, function(fetch, datos) 
        {
            for(i=0; i< datos.length; i++)
            {
                $("#tabla_nro_parte>tbody").empty().append(
                "<tr></td><td id='id_lista_plancha'>" + datos[i].id_lplancha  + 
                "</td><td id='numeroparte'>" + datos[i].nro_partes + 
                "</td><td id='descripcion'>" + datos[i].descripcion + 
                "</td><td id='dimensiones'>" + datos[i].dimensiones + 
                "</td><td id='cantidad_piezas'>" + datos[i].cantidad_piezas + 
                "</td><td id='peso_unit'>" + Number(datos[i].peso_unit).toFixed(3)  + 
                "</td><td id='peso_total'>" + Number(datos[i].peso_total).toFixed(3) + "</tr>");
            }
        })
    })
}

NroParte();
$('#numero_parte').on('change', NroParte);

function CalcularTotalesTablaAvance()
{
    // TOTALES PRODUCCION AVANCE
    var ListaTotalCantidadPiezasAvance = $(".cant_piezas_avance").map((i,el)=>Number(el.innerText.trim())).get();
    var TotalCantPiezasAvance = ListaTotalCantidadPiezasAvance.reduce((partialSum,a) => partialSum + a, 0);
    $("#total_prod_cant_piezas_avance").text(TotalCantPiezasAvance);
    
    var ListaPesoTotalAvance = $(".peso_avance").map((i,el)=>Number(el.innerText.trim())).get();
    var PesoAvance = ListaPesoTotalAvance.reduce((partialSum,a) => partialSum + a, 0);
    var TotalPesoAvance = Number(PesoAvance).toFixed(3);
    $("#total_prod_peso_total_avance").text(TotalPesoAvance);

    // TOTALES PENDIENTE AVANCE
    var cantidad_total_lp = $(".cantidad_total_lp").text();
    var total_pend_longitud_corte_avance = cantidad_total_lp - $("#total_prod_cant_piezas_avance").text();
    $("#total_pend_cant_piezas_avance").text(total_pend_longitud_corte_avance);

    var peso_total_lp = $(".peso_total_lp").text();
    var pend_peso_avance = peso_total_lp - $("#total_prod_peso_total_avance").text();
    var total_pend_peso_avance = Number(pend_peso_avance).toFixed(3);
    $("#total_pend_peso_avance").text(total_pend_peso_avance);
}

function obtenerColumnasTabla()
{
    const tabla = document.getElementById("TablaAvance");
    const columnas = [];

    for (const fila of tabla.rows) 
    {
        const columna = [];

        for (const celda of fila.cells) 
        {
            if (celda.tagName === "TD") 
            {
                columna.push(celda.textContent);
            }
        }
        columnas.push(columna);
    }
    return columnas;
}


function CargarAvance()
{
    var filas = obtenerColumnasTabla();
    var fecha_creado = $("#fecha_creado_avance").val();
    var numero_parte = $("#numeroparte").text();
    var ultima_fila = filas.reverse().find(fila => fila.includes(numero_parte)) || [];
    var cant_piezas_avance = $("#cant_pieza_avance").val();
    var descripcion_nroparte = $("#descripcion").text();
    var dimensiones_nroparte = $("#dimensiones").text();
    var cant_piezas_nroparte = $("#cantidad_piezas").text();
    var peso_unit_nroparte = $("#peso_unit").text();
    var peso_total_nroparte = $("#peso_total").text();

    var peso_avance = cant_piezas_avance * peso_unit_nroparte;

    var cant_piezas_pendiente = (Number(ultima_fila[10]) || cant_piezas_nroparte) - cant_piezas_avance;
    var peso_pendiente = (Number(ultima_fila[11]) || peso_total_nroparte) - peso_avance;

    if (!fecha_creado || !cant_piezas_avance || !peso_avance) 
    {
        alert('Debe llenar todos los campos de la tabla AVANCE');
        return;
    }
    else
    {
    $("#TablaAvance>tbody").append(
        "<tr></td> <td id='id_avance'></td></td>" +
        "</td><td id='fecha_creado_avance'>" + fecha_creado +
        "</td><td class='numero_parte' id='numero_parte'>" +numero_parte+ 
        "</td><td class='descripcion_nroparte' id='descripcion_nroparte'>" + descripcion_nroparte  + 
        "</td><td class='dimensiones_nroparte' id='dimensiones_nroparte'>" + dimensiones_nroparte  + 
        "</td><td class='cant_piezas_nroparte' id='cant_piezas_nroparte'>" + cant_piezas_nroparte  + 
        "</td><td class='peso_unit_nroparte' id='peso_unit_nroparte'>" + Number(peso_unit_nroparte).toFixed(3)  +
        "</td><td class='peso_total_nroparte' id='peso_total_nroparte'>" + Number(peso_total_nroparte).toFixed(3)  +
        "</td><td class='cant_piezas_avance' id='cant_piezas_avance'>" + cant_piezas_avance  + 
        "</td><td class='peso_avance' id='peso_avance'>" + Number(peso_avance).toFixed(3)  +
        "</td><td class='cant_piezas_pendiente' id='cant_piezas_pendiente'>" + cant_piezas_pendiente  + 
        "</td><td class='peso_pendiente' id='peso_pendiente'>" + Number(peso_pendiente).toFixed(3) +
        "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    }
    $("#fecha_creado_avance").val("");
    $("#numero_parte").val("");
    $("#cant_pieza_avance").val("");
    $("#peso_avance").val("");

    CalcularTotalesTablaAvance();    
}

function CalcularTotalesTablaOxigeno()
{
    var ListaOxigenoUsado = $(".oxigeno_usado").map((i,el)=>Number(el.innerText.trim())).get();
    var TotalOxigenoUsado = ListaOxigenoUsado.reduce((partialSum,a) => partialSum + a, 0);
    var ListaLitrosGaseosos = $(".litros_gaseosos").map((i,el)=>Number(el.innerText.trim())).get();
    var TotalLitrosGaseosos = ListaLitrosGaseosos.reduce((partialSum,a) => partialSum + a, 0);

    $("#total_oxigeno_usados").text(TotalOxigenoUsado);
    $("#total_litros_gaseosos").text(TotalLitrosGaseosos);
}

function CargarOxigeno()
{
    var fecha_creado = $("#fecha_creado_oxigeno").val();
    var oxigeno_inicial = $("#oxigeno_inicial").val();
    var oxigeno_final = $("#oxigeno_final").val();
    var cambio_oxigeno = $("#cambio_oxigeno").val();
    var oxigeno_usado = oxigeno_inicial - oxigeno_final;
    var litros_gaseosos = oxigeno_usado / 14.5 * 41.9;

    if (fecha_creado == 0 || oxigeno_inicial == 0 || oxigeno_final == 0) 
    {
        alert('Debe llenar todos los campos de la tabla OXIGENO');
        return;
    }
    else
    {
    $("#TablaOxigeno>tbody").append(
        "<tr></td> <td id='id_oxigeno'></td></td>" +
        "</td><td id='fecha_creado_oxigeno'>" + fecha_creado +
        "</td><td class='oxigeno_inicial' id='oxigeno_inicial'>" + oxigeno_inicial +
        "</td><td class='oxigeno_final' id='oxigeno_final'>" + oxigeno_final +
        "</td><td class='oxigeno_usado' id='oxigeno_usado'>" + oxigeno_usado +
        "</td><td class='cambio_oxigeno' id='cambio_oxigeno'>" + cambio_oxigeno +
        "</td><td class='litros_gaseosos' id='litros_gaseosos'>" + Number(litros_gaseosos).toFixed(2)  + 
        "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    }
    $("#fecha_creado_oxigeno").val("");
    $("#oxigeno_inicial").val("");
    $("#oxigeno_final").val("");
    $("#cambio_oxigeno").val("");

    CalcularTotalesTablaOxigeno();
}

function capturarRadioSeleccionado() 
{
    const radios = document.getElementsByName('tipo_materia');
    for (const radio of radios) 
    {
        if (radio.checked)
        {
            const valorSeleccionado = radio.value;
            console.log(valorSeleccionado);
            return valorSeleccionado;
        }
    }
}
  
function CargarConsumible()
{
    const valorSeleccionado = capturarRadioSeleccionado();
      
    var fecha_creado = $("#fecha_creado_consumible").val();
 
    if (valorSeleccionado == 'CONSUMIBLE')
        {
            console.log(" en consumible");
            var consumible_usado = $("#consumible_usado option:selected").text();
            var consumo_consumible = $("#consumo_consumible").val();
            var observacion_consumible = $("#observacion_consumible").val();

            if(consumible_usado.includes('INSERTO'))
                {
                   var unidad_consumible = 'METROS DE PERFORACION';   
                }
                else if (consumible_usado.includes('JUEGO DE ANTORCHA')) 
                {
                    var unidad_consumible = 'PIERCINGS';
                } 
                else 
                {
                    var unidad_consumible = 'LITROS';
                }
            
                if (!fecha_creado || consumible_usado == 'Seleccione el consumible' || consumo_consumible == '') 
                {
                    alert('Debe llenar los campos de la tabla CONSUMIBLES');
                    return;
                }
                else
                {
                    $("#TablaConsumible>tbody").append(
                        "<tr></td> <td id='id_consumible'></td></td>" +
                        "</td><td id='fecha_creado_consumible'>" + fecha_creado +
                        "</td><td class='consumible_usado' id='consumible_usado'>" + consumible_usado +
                        "</td><td class='consumo_consumible' id='consumo_consumible'>" + consumo_consumible +
                        "</td><td class='unidad_consumible' id='unidad_consumible'>" + unidad_consumible +
                        "</td><td class='observacion_consumible' id='observacion_consumible'>" + observacion_consumible  + 
                        "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
                }
        }
        else
        {
            console.log("en otro");
            var consumible_usado_otro = $("#consumible_usado_otro").val();
            var consumo_consumible_otro = $("#consumo_consumible_otro").val();
            var unidad_consumible_otro = $("#unidad_consumible_otro option:selected").text();
            var observacion_consumible_otro = $("#observacion_consumible_otro").val();

            if (!fecha_creado || consumible_usado_otro == '' || consumo_consumible_otro == ''  || unidad_consumible_otro == '') 
            {
                alert('Debe llenar los campos de la tabla CONSUMIBLES');
                return;
            }
            else
            {
                $("#TablaConsumible>tbody").append(
                    "<tr></td> <td id='id_consumible'></td></td>" +
                    "</td><td id='fecha_creado_consumible'>" + fecha_creado +
                    "</td><td class='consumible_usado' id='consumible_usado'>" + consumible_usado_otro +
                    "</td><td class='consumo_consumible' id='consumo_consumible'>" + consumo_consumible_otro +
                    "</td><td class='unidad_consumible' id='unidad_consumible'>" + unidad_consumible_otro +
                    "</td><td class='observacion_consumible' id='observacion_consumible'>" + observacion_consumible_otro  + 
                    "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
            }
        }

    $("#fecha_creado_consumible").val("");
    $("#consumible_usado").val("");
    $("#consumo_consumible").val("");
    $("#observacion_consumible").val("");

    $("#consumible_usado_otro").val("");
    $("#consumo_consumible_otro").val("");
    $("#unidad_consumible_otro").val("");
    $("#observacion_consumible_otro").val("");

}

function Consumible()
{
    var ConsumibleAprov = document.getElementById('ConsumibleAprov');
    var ConsumibleOtro = document.getElementById('ConsumibleOtro');

    if (ConsumibleAprov.checked) {
        $('#consumible_aprovechamiento').show();
        $('#consumible_otro').hide();
    }
    else if (ConsumibleOtro.checked) {
        $('#consumible_aprovechamiento').hide();
        $('#consumible_otro').show();
    }
}

Consumible();


//LEER TODOS LOS DATOS
function CapturarDatosSeguimiento()
{
    var equipo = $("#equipo").val();
 
            let tabla_horometro = [];
            document.querySelectorAll('#TablaHorometro tbody tr').forEach(function (e) {
                let fila = {
                    id_seguimiento_pl_horometro: e.querySelector('#id_horometro').innerText,
                    fecha_creado: e.querySelector('#fecha_creado_horometro').innerText,
                    horometro_inicial_on: e.querySelector('#horometro_inicial_on').innerText,
                    horometro_final_on: e.querySelector('#horometro_final_on').innerText,
                    horas_maquina_on: e.querySelector('#horas_maquina_on').innerText,
                    horas_on: e.querySelector('#horas_on').innerText,
                    total_horas_on: document.querySelector("#total_horas_on").innerText,
                    horometro_inicial_aut: 0,
                    horometro_final_aut: 0,
                    tiempo_modo_aut: 0,
                    tiempo_aut: 0,
                    total_tiempo_aut: 0,
                };

                if(equipo === 'KF2612')
                {
                    let filaKF = {
                        horometro_inicial_aut: e.querySelector('#horometro_inicial_aut').innerText,
                        horometro_final_aut: e.querySelector('#horometro_final_aut').innerText,
                        tiempo_modo_aut: e.querySelector('#tiempo_modo_aut').innerText,
                        tiempo_aut: e.querySelector('#tiempo_aut').innerText,
                        total_tiempo_aut: document.querySelector("#total_tiempo_aut").innerText,
                    };
                    fila = {...fila,...filaKF};
                }
                tabla_horometro.push(fila);
            });
    
            let tabla_avance = [];
            document.querySelectorAll('#TablaAvance tbody tr').forEach(function (e) {
                let fila = {
                    id_seguimiento_pl_avance: e.querySelector('#id_avance').innerText,
                    fecha_creado: e.querySelector('#fecha_creado_avance').innerText,
                    numero_parte: e.querySelector('#numero_parte').innerText,
                    descripcion_nroparte: e.querySelector('#descripcion_nroparte').innerText,
                    dimensiones_nroparte: e.querySelector('#dimensiones_nroparte').innerText,
                    cant_piezas_nroparte: e.querySelector('#cant_piezas_nroparte').innerText,
                    peso_unit_nroparte: e.querySelector('#peso_unit_nroparte').innerText,
                    peso_total_nroparte: e.querySelector('#peso_total_nroparte').innerText,
                    cant_piezas_avance: e.querySelector('#cant_piezas_avance').innerText,
                    peso_avance: e.querySelector('#peso_avance').innerText,
                    cant_piezas_pendiente: e.querySelector('#cant_piezas_pendiente').innerText,
                    peso_pendiente: e.querySelector('#peso_pendiente').innerText,
                };
                tabla_avance.push(fila);
            });
    
            let tabla_oxigeno = [];
            document.querySelectorAll('#TablaOxigeno tbody tr').forEach(function (e) {
                let fila = {
                    id_seguimiento_pl_oxigeno: e.querySelector('#id_oxigeno').innerText,
                    fecha_creado: e.querySelector('#fecha_creado_oxigeno').innerText,
                    oxigeno_inicial: e.querySelector('#oxigeno_inicial').innerText,
                    oxigeno_final: e.querySelector('#oxigeno_final').innerText,
                    oxigeno_usado: e.querySelector('#oxigeno_usado').innerText,
                    cambio: e.querySelector('#cambio_oxigeno').innerText,
                    litros_gaseosos: e.querySelector('#litros_gaseosos').innerText,
                };
                tabla_oxigeno.push(fila);
            });
    
            
        let tabla_consumibles = [];
        document.querySelectorAll('#TablaConsumible tbody tr').forEach(function (e) 
        {
            let fila = {
                id_seguimiento_pl_consumible: e.querySelector('#id_consumible').innerText,
                fecha_creado: e.querySelector('#fecha_creado_consumible').innerText,
                consumible_usado: e.querySelector('#consumible_usado').innerText,
                consumo_consumible: e.querySelector('#consumo_consumible').innerText,
                unidad_consumible: e.querySelector('#unidad_consumible').innerText,
                observacion_consumible: e.querySelector('#observacion_consumible').innerText,
            };
            tabla_consumibles.push(fila);
        });

                const DatosSeguimiento = {
                    tabla_horometro,
                    tabla_avance,
                    total_prod_cant_piezas_avance: document.querySelector('#total_prod_cant_piezas_avance').innerText,
                    total_prod_peso_total_avance: document.querySelector('#total_prod_peso_total_avance').innerText,
                    total_pend_cant_piezas_avance: document.querySelector('#total_pend_cant_piezas_avance').innerText,
                    total_pend_peso_avance: document.querySelector('#total_pend_peso_avance').innerText,
                    tabla_oxigeno,
                    total_oxigeno_usados: document.querySelector('#total_oxigeno_usados').innerText,
                    total_litros_gaseosos: document.querySelector('#total_litros_gaseosos').innerText,
                    tabla_consumibles,
                };

                console.log(JSON.stringify(DatosSeguimiento));
                //alert(JSON.stringify(DatosSeguimiento));
                $('#datos_seguimiento').val(JSON.stringify(DatosSeguimiento)); 
                return DatosSeguimiento;
}

//PARA ELIMINAR LAS FILAS DE LAS TABLAS
$(document).on('click', '.borrar', function (event) 
{
    event.preventDefault();
    $(this).closest('tr').remove();
    CalcularTotalesTablaHorometros();
    CalcularTotalesTablaAvance();
    CalcularTotalesTablaOxigeno();
});


function LimpiarCamposHorometro()
{
    $("#fecha_creado_horometro").val("");
    $("#horometro_inicial_on").val("");
    $("#horometro_final_on").val("");
    $("#horometro_inicial_aut").val("");
    $("#horometro_final_aut").val("");
}

function LimpiarCamposAvance()
{
    $("#fecha_creado_avance").val("");
    $("#numero_parte").val("");
    $("#cant_pieza_avance").val("");
    $("#peso_avance").val("");
    
}

function LimpiarCamposOxigeno()
{
    $("#fecha_creado_oxigeno").val("");
    $("#oxigeno_inicial").val("");
    $("#oxigeno_final").val("");
    $("#cambio_oxigeno").val("");
}

function LimpiarCamposConsumible()
{
    $("#fecha_creado_consumible").val("");
    $("#consumible_usado").val("");
    $("#consumo_consumible").val("");
    $("#observacion_consumible").val("");
    $("#consumible_usado_otro").val("");
    $("#consumo_consumible_otro").val("");
    $("#unidad_consumible_otro").val("");
    $("#observacion_consumible_otro").val("");
}


function EliminarDetalleH(id)
{
    $.ajax({
        url: EliminarDetalleHorometro + '/' + id,
        type: 'post',
        data:
        {
            _token: $("input[name=_token]").val(),
            _method: 'delete'
        },
        success: function (data) 
        {
            console.log("eliminado");
        },
        error: function (data) 
        {
            console.log('Error:', data);
        }
    });
}


function EliminarDetalleA(id)
{

    $.ajax({
        url: EliminarDetalleAvance + '/' + id,
        type: 'post',
        data:
        {
            _token: $("input[name=_token]").val(),
            _method: 'delete'
        },
        success: function (data) 
        {
            console.log("eliminado");
        },
        error: function (data) 
        {
            console.log('Error:', data);
        }
    });
}

function EliminarDetalleO(id) 
{
    $.ajax({
        url: EliminarDetalleOxigeno + '/' + id,
        type: 'post',
        data:
        {
            _token: $("input[name=_token]").val(),
            _method: 'delete'
        },
        success: function (data)
        {
            console.log("eliminado");
        },
        error: function (data) 
        {
            console.log('Error:', data);
        }
    });
}

function EliminarDetalleCon(id) 
{
    $.ajax({
        url: EliminarDetalleConsumible + '/' + id,
        type: 'post',
        data:
        {
            _token: $("input[name=_token]").val(),
            _method: 'delete'
        },
        success: function (data) 
        {
            console.log("eliminado");
        },
        error: function (data) 
        {
            console.log('Error:', data);
        }
    });
}


function pregunta() 
{
    if (confirm('¿Estas seguro de GUARDAR el seguimiento?')) 
    {
      document.getElementById('FormSeguimiento').submit();
    }
  }

document.addEventListener('DOMContentLoaded', function() 
{
    document.getElementById('enviar').addEventListener('click', function(e) 
    {
      e.preventDefault();
      pregunta()
    });
});