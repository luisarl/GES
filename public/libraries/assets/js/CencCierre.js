$(document).ready(function()
{
    CalcularTotalesTablaCortes();
});

function CalcularTotalesTablaCortes()
{
    var ListaPiezasAnidadas = $(".piezas_anidadas").map((i,el)=>Number(el.innerText.trim())).get();
    var TotalPiezasAnidadas = ListaPiezasAnidadas.reduce((partialSum,a) => partialSum + a, 0);
    var ListaPiezasCortadas = $(".piezas_cortadas").map((i,el)=>Number(el.innerText.trim())).get();
    var TotalPiezasCortadas = ListaPiezasCortadas.reduce((partialSum,a) => partialSum + a, 0);
    var ListaPiezasDanadas = $(".piezas_danadas").map((i,el)=>Number(el.innerText.trim())).get();
    var TotalPiezasDanadas = ListaPiezasDanadas.reduce((partialSum,a) => partialSum + a, 0);
    var ListaLongitudCortes = $(".longitud_corte").map((i,el)=>Number(el.innerText.trim())).get();
    var TotalLongitudCortes = ListaLongitudCortes.reduce((partialSum,a) => partialSum + a, 0);
    var ListaNroPerforaciones = $(".numero_perforaciones").map((i,el)=>Number(el.innerText.trim())).get();
    var TotalNroPerforaciones= ListaNroPerforaciones.reduce((partialSum,a) => partialSum + a, 0);

    $("#total_piezas_anidadas").text(TotalPiezasAnidadas);
    $("#total_piezas_cortadas").text(TotalPiezasCortadas);
    $("#total_piezas_danadas").text(TotalPiezasDanadas);
    $("#total_longitud_cortes").text(TotalLongitudCortes);
    $("#total_nro_perforacion").text(TotalNroPerforaciones);
}

function CargarCortes()
{
    var fecha_creado = $("#fecha_creado_cortes").val();
    var cnc_aprovechamiento = $("#cnc_aprovechamiento").val();
    var piezas_anidadas = $("#piezas_anidadas").val();
    var piezas_cortadas = $("#piezas_cortadas").val();
    var piezas_danadas = $("#piezas_danadas").val();
    var longitud_corte = $('#longitud_corte').val();
    var numero_perforaciones = $('#numero_perforaciones').val();

    if (!fecha_creado || !cnc_aprovechamiento || piezas_anidadas == '' || piezas_cortadas == '' || piezas_danadas == '' || longitud_corte == '' || numero_perforaciones == '') 
    {
        alert('Debe llenar todos los campos de la tabla CORTES');
        return;
    }
    else
    {
    $("#TablaCortes>tbody").append(
        "<tr></td> <td id='id_cortes'></td></td>" +
        "</td><td id='fecha_creado_cortes'>" + fecha_creado +
        "</td><td id='cnc_aprovechamiento'>" + cnc_aprovechamiento +
        "</td><td class='piezas_anidadas' id='piezas_anidadas'>" + piezas_anidadas +
        "</td><td class='piezas_cortadas' id='piezas_cortadas'>" + piezas_cortadas +
        "</td><td class='piezas_danadas' id='piezas_danadas'>" + piezas_danadas +
        "</td><td class='longitud_corte' id='longitud_corte'>" + Number(longitud_corte).toFixed(2)  +
        "</td><td class='numero_perforaciones' id='numero_perforaciones'>" +  numero_perforaciones +
        "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    }
    $("#fecha_creado_cortes").val("");
    $("#cnc_aprovechamiento").val("");
    $("#piezas_anidadas").val("");
    $("#piezas_cortadas").val("");
    $("#piezas_danadas").val("");
    $("#longitud_corte").val("");
    $("#numero_perforaciones").val("");

    CalcularTotalesTablaCortes();
}


function CargarMateriaPrimaSobrante()
{
    var fecha_creado = $("#fecha_creado_sobrante").val();
    var descripcion_sobrante = $("#descripcion_sobrante").val();
    var referencia_sobrante = $("#referencia_sobrante").val();
    var cantidad_sobrante = $("#cantidad_sobrante").val();
    var ubicacion_sobrante = $("#ubicacion_sobrante").val();
    var observacion_sobrante = $("#observacion_sobrante").val();
 
    if (!fecha_creado || !descripcion_sobrante || !referencia_sobrante || !cantidad_sobrante || !ubicacion_sobrante) 
    {
        alert('Debe llenar todos los campos de la tabla Materia Prima Sobrante');
        return;
    }
    else
    {
        $("#TablaMateriaPrimaSobrante>tbody").append(
            "<tr></td> <td id='id_sobrante'></td></td>" +
            "</td><td class='fecha_creado_sobrante' id='fecha_creado_sobrante'>" + fecha_creado +
            "</td><td class='descripcion_sobrante' id='descripcion_sobrante'>" + descripcion_sobrante +
            "</td><td id='referencia_sobrante'>" + referencia_sobrante +
            "</td><td id='cantidad_sobrante'>" + cantidad_sobrante +
            "</td><td id='ubicacion_sobrante'>" + ubicacion_sobrante +
            "</td><td class='observacion_sobrante' id='observacion_sobrante'>" + observacion_sobrante +
            "</td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger'><i class='fa fa-trash'></i></button></th></tr>");
    }

    $("#fecha_creado_sobrante").val("");
    $("#descripcion_sobrante").val("");
    $("#referencia_sobrante").val("");
    $("#cantidad_sobrante").val("");
    $("#ubicacion_sobrante").val("");
    $("#observacion_sobrante").val("");
}

//LEER TODOS LOS DATOS
function CapturarDatosCierre()
{
        let tabla_cortes = [];
        document.querySelectorAll('#TablaCortes tbody tr').forEach(function (e) 
        {
            let fila = {
                id_cierre_pl_cortes: e.querySelector('#id_cortes').innerText,
                fecha_creado: e.querySelector('#fecha_creado_cortes').innerText,
                cnc_aprovechamiento: e.querySelector('#cnc_aprovechamiento').innerText,
                piezas_anidadas: e.querySelector('#piezas_anidadas').innerText,
                piezas_cortadas: e.querySelector('#piezas_cortadas').innerText,
                piezas_danadas: e.querySelector('#piezas_danadas').innerText,
                longitud_corte: e.querySelector('#longitud_corte').innerText,
                numero_perforaciones: e.querySelector('#numero_perforaciones').innerText,
            };
            tabla_cortes.push(fila);
        });


        let tabla_sobrante = [];
        document.querySelectorAll('#TablaMateriaPrimaSobrante tbody tr').forEach(function (e) 
        {
            let fila = 
            {
                id_cierre_pl_sobrante: e.querySelector('#id_sobrante').innerText,
                fecha_creado: e.querySelector('#fecha_creado_sobrante').innerText,
                descripcion_sobrante: e.querySelector('#descripcion_sobrante').innerText,
                referencia_sobrante: e.querySelector('#referencia_sobrante').innerText,
                cantidad_sobrante: e.querySelector('#cantidad_sobrante').innerText,
                ubicacion_sobrante: e.querySelector('#ubicacion_sobrante').innerText,
                observacion_sobrante: e.querySelector('#observacion_sobrante').innerText,
            };
            tabla_sobrante.push(fila);
        });

            const DatosCierre = {
                tabla_cortes,
                total_piezas_anidadas: document.querySelector('#total_piezas_anidadas').innerText,
                total_piezas_cortadas: document.querySelector('#total_piezas_cortadas').innerText,
                total_piezas_danadas: document.querySelector('#total_piezas_danadas').innerText,
                total_longitud_cortes: document.querySelector('#total_longitud_cortes').innerText,
                total_nro_perforacion: document.querySelector('#total_nro_perforacion').innerText,
                tabla_sobrante,
            };
          
            console.log(JSON.stringify(DatosCierre));
           // alert(JSON.stringify(DatosCierre));
            $('#datos_cierre').val(JSON.stringify(DatosCierre)); 
            return DatosCierre;
}

//PARA ELIMINAR LAS FILAS DE LAS TABLAS
$(document).on('click', '.borrar', function (event) 
{
    event.preventDefault();
    $(this).closest('tr').remove();
    CalcularTotalesTablaCortes();
});

function LimpiarCamposCortes()
{
    $("#fecha_creado_cortes").val("");
    $("#cnc_aprovechamiento").val("");
    $("#piezas_anidadas").val("");
    $("#piezas_cortadas").val("");
    $("#piezas_danadas").val("");
    $("#longitud_corte").val("");
    $("#numero_perforaciones").val("");
}



function LimpiarMateriaPrimaSobrante()
{
    $("#descripcion_sobrante").val("");
    $("#referencia_sobrante").val("");
    $("#cantidad_sobrante").val("");
    $("#ubicacion_sobrante").val("");
    $("#observacion_sobrante").val("");
}

function EliminarDetalleC(id)
{
    $.ajax({
        url: EliminarDetalleCortes + '/' + id,
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


function EliminarDetalleTablaSobrante(id) 
{
    $.ajax({
        url: EliminarDetalleSobrante + '/' + id,
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
    if (confirm('¿Estas seguro de GUARDAR el cierre?')) 
    {
      document.getElementById('FormCierre').submit();
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