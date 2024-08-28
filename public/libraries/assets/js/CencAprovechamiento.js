function mostrarDiv()
{
    var equipo = $('#_equipocorte').val();
    var tecnologia = document.getElementById("_tecnologia");
    var valorTecnologia = tecnologia.value;

    var nroboquilla_Morrocoy = document.getElementById("nroboquilla_Morrocoy");
    var nroboquilla_KF = document.getElementById("nroboquilla_KF");
    var PrecaOxicorte = document.getElementById("PrecaOxicorte");
    var TiempoPrecaOxicorte = document.getElementById("TiempoPrecaOxicorte");
    var JuegoAntorcha = document.getElementById("JuegoAntorcha");

    var antorcha = $("#_antorcha option:selected").val();

    if (equipo === "1"){ //KF2612
        if(valorTecnologia === "1"){ //OXICORTE
            nroboquilla_Morrocoy.style.display = "none";
            nroboquilla_KF.style.display = "block";
            PrecaOxicorte.style.display = "block";
            JuegoAntorcha.style.display = "none";
            TiempoPrecaOxicorte.style.display = "block";
        }else{ //PLASMA
            JuegoAntorcha.style.display = "block";
            nroboquilla_Morrocoy.style.display = "none";
            nroboquilla_KF.style.display = "none";
            PrecaOxicorte.style.display = "none";
            TiempoPrecaOxicorte.style.display = "none";
        }
    }else if (equipo === "2") { // MORROCOY
        if(valorTecnologia === "1"){ //OXICORTE
            nroboquilla_Morrocoy.style.display = "block";
            nroboquilla_KF.style.display = "none";
            PrecaOxicorte.style.display = "block";
            TiempoPrecaOxicorte.style.display = "block";
            JuegoAntorcha.style.display = "none";
        }
    }
}

function CargarListaParte()
{
    var IdConap = $('#_id_conap').val();

    $.get('../ListaParteConaps/' + IdConap, function (data) 
    {
        var old = $('#_id_listaparte').data('old') != '' ? $('#_id_listaparte').data('old') : '';
        $('#_id_listaparte').empty();
        $('#_id_listaparte').append('<option value="0">Seleccione la Lista Parte</option>');

        $.each(data, function (fetch, listaparte) 
        {
            for (i = 0; i < listaparte.length; i++) 
            {
                $('#_id_listaparte').append('<option value="' + listaparte[i].id_lista_parte + '-' + listaparte[i].tipo_lista + '"   ' + (old ==
                    listaparte[i].id_lista_parte + '-' + listaparte[i].tipo_lista ? "selected" : "") + ' >' + listaparte[i]
                        .id_lista_parte + ' - ' + listaparte[i]
                        .tipo_lista + '</option>');
            }
        })
        Espesores();
    })
}


function TipoAprovechamiento()
{
    var IdListaParte = $('#_id_listaparte').val();
    var partes = IdListaParte.split('-');
    var IdListaParte = parseInt(partes[0]);
    var tipo = partes[1];
    var espesorValue = parseFloat($('#_espesor').val());
    var espesor = espesorValue.toFixed(2);

    const [campos_planchas, campos_perfiles, miCardPlanchamp, miCardPlanchacp, miCardPlanchampr, miCardPerfilesmp] = [
        document.querySelector("#campos_planchas"),
        document.querySelector("#campos_perfiles"),
        document.querySelector("#miCardPlanchamp"),
        document.querySelector("#miCardPlanchacp"),
        document.querySelector("#miCardPlanchampr"),
        document.querySelector("#miCardPerfilesmp")
    ];

    if (!tipo) 
    {
        tipo = "";
    }
    var inputTipo = document.getElementById('_tipo_aprov');
    var aux = 1;
    inputTipo.value = tipo;
    inputTipo.readOnly = true;


    if (tipo === "PLANCHAS") 
    {
        miCardPlanchamp.style.display = "block";
        miCardPlanchacp.style.display = "block";
        miCardPlanchampr.style.display = "block";
        campos_planchas.style.display = "block";
        miCardPerfilesmp.style.display = "none";
        campos_perfiles.style.display = "none";
        tipo_espesor.style.display = "block";
        tipo_perfil.style.display = "none";

    } 
    else 
    {
        if (tipo === "PERFILES") 
        {
            miCardPlanchamp.style.display = "none";
            miCardPlanchacp.style.display = "none";
            miCardPlanchampr.style.display = "none";
            campos_planchas.style.display = "none";
            miCardPerfilesmp.style.display = "block";
            campos_perfiles.style.display = "block";
            tipo_espesor.style.display = "none";
            tipo_perfil.style.display = "block";
        }
    }
}



function TecnologiaAsociadaEquipo (){
  
    var idEquipo = $("#_equipocorte option:selected").val();
    
    if (idEquipo !== '0') 
    {
        $.ajax({
            url: ruta + '/obtener-tecnologias/' + idEquipo,
            type: 'GET',
            dataType: 'json',
            success: function (response) {

            var old = $('#_tecnologia').data('old') != '' ? $('#_tecnologia').data('old') : '';

                $('#_tecnologia').empty();
                $('#_tecnologia').append('<option value="0">Seleccione la tecnología</option>');

                $.each(response.caracteristicas, function (index, tecnologia) {
                    // $('#_tecnologia').append('<option value="' + tecnologia.id_tecnologia + '">' + tecnologia.nombre_tecnologia + '</option>');
                    $('#_tecnologia').append('<option value="' + tecnologia.id_tecnologia + '" ' + (old == tecnologia.id_tecnologia? "selected" : "") 
                    + '>' + tecnologia.nombre_tecnologia + '</option>');

                });
            }
        });
    }
    else
    {
        $('#id_tecnologia').empty();
        $('#id_tecnologia').append('<option value="0">Seleccione tecnología</option>');
    }
}

function Espesores()
{
    var IdConap = $('#_id_conap').val() == null ? $('#_id_conap').val() : $('#_id_conap').val();
    var IdListaParte = $('#_id_listaparte').val();
    var partes = IdListaParte.split('-');
    var IdListaParte = parseInt(partes[0]);
    var equipo = $("#_equipocorte option:selected").val();
    var tecnologia = $("#_tecnologia option:selected").val();
 
    $.get('../ListaParteEspesor/' + IdConap + '/' + IdListaParte + '/' + equipo + '/' + tecnologia, function (data) {
        var old = $('#_espesor').data('old') != '' ? $('#_espesor').data('old') : '';
        $('#_espesor').empty();
        $('#_espesor').append('<option value="0">Seleccione el espesor</option>');
        $.each(data, function (fetch, datos) {
            for (i = 0; i < datos.length; i++) {
                var espesorValue = parseFloat(datos[i].espesor);
                var espesor = espesorValue.toFixed(2);
                $('#_espesor').append('<option value="' + espesor + '" ' + (old == espesor? "selected" : "") 
                + '>' + espesor + '</option>');
            }
        })
    })

}
// function PrecalentamientoOxicorte (){
//     var PrecalentamientoValue = $("#_precalentamiento option:selected").text();

//     if (PrecalentamientoValue == 'Si') {
//         TiempoPrecaOxicorte.style.display = "block";
//     }else{
//         TiempoPrecaOxicorte.style.display = "none";
//     }
// }

function MaterialProcesado()
{
    var IdListaParte = $('#_id_listaparte').val();
    var partes = IdListaParte.split('-');
    var IdListaParte = parseInt(partes[0]);
    var tipo = partes[1];
    var espesorValue = parseFloat($('#_espesor').val());
    var espesor = espesorValue.toFixed(2);

    $.get('../MaterialProcesado/' + IdListaParte + '/' + espesor, function(data)
    {
        $.each(data, function(fetch, datos) 
        {
            for(i=0; i< datos.length; i++)
            {
                $("#tabla_plancha_material>tbody").empty().append(
                "<tr></td><td id='espesor_material'>" + Number(datos[i].espesor).toFixed(2) + 
                "</td><td id='cantidad_material'>" + datos[i].cantidad + 
                "</td><td id='peso_material'>" + Number(datos[i].peso).toFixed(2) + "</tr>");
            }
        })
    })
 }
CargarListaParte();
$('#_id_conap').on('change', CargarListaParte);
TecnologiaAsociadaEquipo();
$('#_equipocorte').on('change', TecnologiaAsociadaEquipo);
TipoAprovechamiento();
$('#_id_listaparte').on('change', TipoAprovechamiento);
Espesores();
$('#_tecnologia').on('change', Espesores);
// PrecalentamientoOxicorte();
// $('#PrecaOxicorte').on('change', PrecalentamientoOxicorte);
MaterialProcesado();
$('#_espesor').on('change', MaterialProcesado);

$(document).ready(TipoAprovechamiento)
$(document).ready(mostrarDiv)


function StockMateriaPrima()
{
    var cantidadForaneo = Number($("#cantidadForaneo").val());
    if (cantidadForaneo == 0) 
    {
        var dimensiones = $("#_material_plancha option:selected").text(); // aqui extraigo y divido en las variables
        var stock = dimensiones.split("D:")[1].trim();
        stock = Number(stock.split("|")[0].trim());
        document.getElementById("existencia").value = stock;
        $("#cantidad_entregada").attr("max", stock);
        $("#cantidad_entregada").val('');
    }
}


//LLENA LA TABLA DE MATERIA PRIMA EN PLANCHAS CON LOS DATOS EXTRAIDOS DEL SELECT SELECCIONADO
function CargarTablaPlancha_Materia()
{
    var dimensiones_materia1 = Number($("#dimensiones_materia1").val());
    var dimensiones_materia2 = Number($("#dimensiones_materia2").val());
    var dimensionesForaneo = dimensiones_materia1 + "x" + dimensiones_materia2;
    var cantidadForaneo = Number($("#cantidadForaneo").val());
    var espesorValue = parseFloat($('#_espesor').val());
    var espesor = espesorValue.toFixed(2);
    var pesoUnitarioForaneoValue = dimensiones_materia1 * dimensiones_materia2 * espesor * 0.000008;
    var pesoUnitarioForaneo = Number(pesoUnitarioForaneoValue).toFixed(2);
    var pesoTotalForaneo = pesoUnitarioForaneo * cantidadForaneo;

    if (cantidadForaneo == 0) {

        var dimensiones = $("#_material_plancha option:selected").text();
        var caracteristicas = dimensiones.split("D:")[0].trim();
        var stock = dimensiones.split("D:")[1].trim();
        stock = Number(stock.split("|")[0].trim());
        var cantidad = Number($("#cantidad_entregada").val());
        var pesoUnitarioInterno = dimensiones.split("|")[1].trim();
        var codigo = caracteristicas.split("&")[0].trim();
        var pesoTotalInterno = pesoUnitarioInterno * cantidad;

        if ($("#_material_plancha").val() == 0 || stock == 0) {
            alert('Para Agregar Debe Seleccionar la Materia Prima');
        } else {
            if (cantidad > stock) {
                alert('La cantidad debe ser menor al stock disponible');
            } else {
                $("#tabla_plancha_materia>tbody").append(
                    "<tr></td><td id='codigo_materia' style='display: none;'>" + codigo +
                    "</td><td id='dimensiones_materia'>" + caracteristicas +
                    "</td><td id='cantidad_materia'>" + cantidad +
                    "</td><td id='pesounitario_materia'>" + Number(pesoUnitarioInterno).toFixed(2) +
                    "</td><td id='pesototal_materia'>" + Number(pesoTotalInterno).toFixed(2) +
                    "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
            }
        }
    } else {
        if (dimensionesForaneo == 0 || cantidadForaneo == 0 ) {
            alert('Debe llenar todos los campos');
        } else {
            $("#tabla_plancha_materia>tbody").append(
                "<tr></td><td id='codigo_materia' style='display: none;'>" + "FORANEO" +
                "</td><td id='dimensiones_materia'>" + dimensionesForaneo +
                "</td><td id='cantidad_materia'>" + cantidadForaneo +
                "</td><td id='pesounitario_materia'>" + Number(pesoUnitarioForaneo).toFixed(2) +
                "</td><td id='pesototal_materia'>" + Number(pesoTotalForaneo).toFixed(2) +
                "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
            //Limpia campos 
            $("#dimensionesForaneo").val("");
            $("#cantidadForaneo").val("");
        }
    }
}

function Tipomateria()
{
    var materiaInterno = document.getElementById("materiaInterno");
    var materiaForaneo = document.getElementById('materiaForaneo');

    if (materiaInterno.checked) 
    {
        $('#materia_tipo').show();
        $('#existenciamateria').show();
        $('#cantidadmateria').show();
        $('#foraneo').hide();
    }
    else if (materiaForaneo.checked) 
    {
        $('#materia_tipo').hide();
        $('#existenciamateria').hide();
        $('#cantidadmateria').hide();
        $('#foraneo').show();
    }
}

Tipomateria();

// LLENA LA TABLA DE AREA DE CORTES EN PLANCHAS DE ACUERDO A LOS DATOS INGRESADOS 
function CargarTablaPlancha_Corte()
{
    var dimensiones_corte1 = Number($("#dimensiones_corte1").val());
    var dimensiones_corte2 = Number($("#dimensiones_corte2").val());
    var datos_dimensiones = dimensiones_corte1 + "x" + dimensiones_corte2;
    var cantidad = Number($("#cantidad_plancha").val());
    var espesorValue = parseFloat($('#_espesor').val());
    var espesor = espesorValue.toFixed(2);
    var pesoUnitarioCorteValue = dimensiones_corte1 * dimensiones_corte2 * espesor * 0.000008;
    var pesoUnitarioCorte = Number(pesoUnitarioCorteValue).toFixed(2);
    var pesoTotalCorte = pesoUnitarioCorte * cantidad;

    //Valida que los campos no esten vacios
    if (dimensiones_corte1 == 0 || dimensiones_corte2 == 0 || cantidad == 0) 
    {
        alert('Debe llenar todos los campos');
    }
    else
    {
        $("#tabla_plancha_corte>tbody").append("<tr></td><td id='dimensiones_corte'>" + datos_dimensiones +
            "</td><td id='cantidad_corte'>" + cantidad +
            "</td><td id='pesounitario_corte'>" + Number(pesoUnitarioCorte).toFixed(2)  +
            "</td><td id='pesototal_corte'>" + Number(pesoTotalCorte).toFixed(2)  +
            "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    }
    //Limpia campos 
    $("#dimensiones_corte1").val("");
    $("#dimensiones_corte2").val("");
    $("#cantidad_plancha").val("");
    $("#peso_plancha").val("");
}

//LLENA LA TABLA PERFILES CON LOS DATOS DE UBICACION SELECCIONADOS
function CargarTablaPerfiles() 
{
    var perfil = $("#id_perfil option:selected").text();

    if ($("#id_perfil").val() == 0) 
    {
        alert('Para Agregar debe ingresar los datos');
    } 
    else 
    {
        $("#tabla_perfiles>tbody").append("<tr><td id='id_codigo'>" + 2 + "</td><td id='id_perfil'>" + perfil + "</td><td id='id_pieza' contenteditable='true'>" + 2456 + "</td><td id='id_cantidad' contenteditable='true'>" + 8 + "</td><td id='id_peso' contenteditable='true'>" + 142 +
            "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    }
    //Limpia campos 
    $("#id_perfil").val("");
}

//LLENA LA TABLA PERFILES CON LOS DATOS DE UBICACION SELECCIONADOS
function CargarTablaPiezas() 
{
    var cantidadpiezas = $("#id_cantidadpiezas").val();
    var longitudpiezas = $("#id_longitudpiezas").val();

    if ($("#id_cantidadpiezas").val() == 0) 
    {
        alert('Para Agregar debe ingresar los datos');
    }
    else 
    {
        $("#tabla_perfiles_piezas>tbody").append("<tr><td id='id_codigopieza'>" + 3 + "</td><td id='id_longitudpiezas' contenteditable='true'>" + longitudpiezas + "</td><td id='id_cantidadpiezas' contenteditable='true'>" + cantidadpiezas +
            "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    }

    //Limpia campos 
    $("#id_cantidadpiezas").val("");
    $("#id_longitudpiezas").val("");
    $("#id_tipopiezas").val("");
}

//LLENA LA TABLA PERFILES CON LOS DATOS DE UBICACION SELECCIONADOS
function CargarTablaCortes() 
{
    var perfil = $("#id_perfil_corte option:selected").text();
    var saneo = $("#id_saneo").val();

    if ($("#id_perfil_corte").val() == 0) 
    {
        alert('Para Agregar debe ingresar los datos');
    } 
    else
    {
        $("#tablaCortes>tbody").append("<tr><td>" + 2 + "</td><td id='id_perfil_corte' style='visibility:collapse; display:none;'>" + perfil + "</td><td id='id_saneo' contenteditable='true'>" + saneo +
            "</td><td id='id_c1' contenteditable='true'></td><td id='id_c2' contenteditable='true'></td><td id='id_c3' contenteditable='true'><td id='id_c4' contenteditable='true'></td><td id='id_c5' contenteditable='true'></td><td id='id_c6' contenteditable='true'><td id='id_c7' contenteditable='true'></td><td id='id_c8' contenteditable='true'></td><td id='id_c9' contenteditable='true'><td id='id_c10' contenteditable='true'></td><td id='id_c11' contenteditable='true'></td><td id='id_c12' contenteditable='true'><td id='id_c13' contenteditable='true'></td><td id='id_c14' contenteditable='true'></td><td id='id_c15' contenteditable='true'></tr>");
    }
    //Limpia campos 
    $("#id_perfil").val("");
    $("#id_saneo").val("");
}

//LEER TODOS LOS DATOS
function CapturarDatosSelect() 
{
    var id_conap = document.getElementById("_id_conap");
    var IdListaParte = $('#_id_listaparte').val();
    var partes = IdListaParte.split('-');
    var IdListaParte = parseInt(partes[0]);
    var tipo = partes[1];
    var espesor = document.getElementById("_espesor");

    if (!tipo) 
    {
        tipo = "";
    }
    var inputTipo = document.getElementById('_tipo_aprov');
    var aux = 1;
    inputTipo.value = tipo;
    inputTipo.readOnly = true;

    if (tipo === "PLANCHAS") 
    {


        let lista_datos = [];
        document.querySelectorAll('#_select_card').forEach(function (e) {
            let fila = {
                id_conap: e.querySelector('#_id_conap option:checked').innerText.trim(),
                IdListaParte: e.querySelector('#_id_listaparte option:checked').innerText.split('-')[0].trim(),
                espesor: e.querySelector('#_espesor option:checked').innerText,
                equipocorte: e.querySelector('#_equipocorte option:checked').value.trim(),
                tecnologia: e.querySelector('#_tecnologia option:checked').value.trim(),
                documentos: e.querySelector('#filer_input').value,
                antorcha: e.querySelector('#_antorcha option:checked').innerText,
                numero_boquilla: e.querySelector('#_boquilla option:checked').innerText.trim(),
                numero_boquilla2: e.querySelector('#_boquilla2 option:checked').innerText.trim(),
                precalentamiento: e.querySelector('#_precalentamiento').value,
                tiempo_precalentamiento: e.querySelector('#_tiempo_precalentamiento').value,
                longitud_corte: e.querySelector('#_longitud_corte').value,
                numero_piercing: e.querySelector('#_numero_piercing').value,
                tiempo_estimado_corte: e.querySelector('#_tiempo_estimado_corte').value,
            };
            lista_datos.push(fila);
        });

        let material_procesado = [];
        document.querySelectorAll('#tabla_plancha_material tbody tr').forEach(function (e) {
            let fila = {
                espesor_material: e.querySelector('#espesor_material').innerText,
                cantidad_material: e.querySelector('#cantidad_material').innerText,
                peso_material: e.querySelector('#peso_material').innerText,
            };
            material_procesado.push(fila);
        });

        let materia_prima = [];
        document.querySelectorAll('#tabla_plancha_materia tbody tr').forEach(function (e) {
            let fila = {
                codigo_materia: e.querySelector('#codigo_materia').innerText,
                dimensiones_materia: e.querySelector('#dimensiones_materia').innerText,
                cantidad_materia: e.querySelector('#cantidad_materia').innerText,
                pesounitario_materia: e.querySelector('#pesounitario_materia').innerText,
                pesototal_materia: e.querySelector('#pesototal_materia').innerText,
            };

            if (fila.cantidad_materia === "0") {
                alert("Debe ingresar una cantidad de materia prima superior a 0");
                return;
            }
            materia_prima.push(fila);
        });

        let area_corte = [];
        document.querySelectorAll('#tabla_plancha_corte tbody tr').forEach(function (e) {
            let fila = {
                dimensiones_corte: e.querySelector('#dimensiones_corte').innerText,
                cantidad_corte: e.querySelector('#cantidad_corte').innerText,
                pesounitario_corte: e.querySelector('#pesounitario_corte').innerText,
                pesototal_corte: e.querySelector('#pesototal_corte').innerText,
            };
            area_corte.push(fila);
        });


        let observaciones = [];
        document.querySelectorAll('#_card_observaciones').forEach(function (e) {
            let fila = {
                observaciones_aprov: e.querySelector('#_observaciones_aprov').value,
            };
            observaciones.push(fila);
        });

            const TodosDatos = {
                lista_datos,
                material_procesado,
                materia_prima,
                area_corte,
                observaciones,
            };
            
           //console.log(JSON.stringify(TodosDatos));
           $('#_caracteristicas').val(JSON.stringify(TodosDatos)); 
           
            return TodosDatos;
    }
    else 
    {
        if (tipo === "PERFILES") 
        {

        }
    }
}

//PARA ELIMINAR LAS FILAS DE LAS TABLAS
$(document).on('click', '.borrar', function (event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});


function pregunta() {
    if (confirm('¿Estas seguro de GUARDAR este aprovechamiento?')) 
    {
      document.getElementById('FormAprov').submit();
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('enviar').addEventListener('click', function(e) {
      e.preventDefault();
      pregunta()
    });
  });