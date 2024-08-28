//LENA EL SELECT DE SUBGRUPOS
function CargarSubgrupos() {

    var IdGrupo = $('#_grupos').val();

    $.get('../../subgruposarticulo/' + IdGrupo, function(data) {
        var old = $('#_subgrupos').data('old') != '' ? $('#_subgrupos').data('old') : '';
        $('#_subgrupos').empty();
        $('#_subgrupos').append('<option value="0">Seleccione El Subgrupo</option>');

        $.each(data, function(fetch, subgrupos) {
            console.log(data);
            for (i = 0; i < subgrupos.length; i++) {

                $('#_subgrupos').append('<option value="' + subgrupos[i].id_subgrupo + '"   ' +
                    (old == subgrupos[i].id_subgrupo ? "selected" : "") + ' >' + subgrupos[i]
                    .codigo_subgrupo + ' - ' + subgrupos[i]
                    .nombre_subgrupo + '</option>');
            }
        })

    })
}

//LLENA EL SELECT SUBCLASIFICACION
function CargarSubclasificacion() {

//console.log(e);
var IdClasificacion = $('#_clasificacion').val();

    $.get('../../subclasificacionarticulo/' + IdClasificacion, function(data) {
        var old = $('#_subclasificacion').data('old') != '' ? $('#_subclasificacion').data('old') : '';
        $('#_subclasificacion').empty();
        $('#_subclasificacion').append('<option value="0">Seleccione la Subclasificacion</option>');

        $.each(data, function(fetch, subclasificacion) {
            console.log(data);
            for (i = 0; i < subclasificacion.length; i++) {
                $('#_subclasificacion').append('<option value="' + subclasificacion[i].id_subclasificacion + '"   ' + (old ==
                subclasificacion[i].id_subclasificacion ? "selected" : "") + ' >'+subclasificacion[i].id_subclasificacion+' - '+subclasificacion[i]
                    .nombre_subclasificacion + '</option>');
            }
        })

    })
}
//GENERA EL CODIGO DEL ARTICULO SUBGRUPO + CORRELATIVO

function GenerarCodigo() {

    var grupo = $("#_grupos option:selected").text(); //captura el valor del texto del select
    var subgrupo = $("#_subgrupos option:selected").text(); //captura el valor del texto del select
    var CodigoGrupo = grupo.split(' ')[0]; //extrae el primer texto hasta es espacio en blanco
    var CodigoSubgrupo = subgrupo.split(' ')[0]; //extrae el primer texto hasta es espacio en blanco
    //var CodigoArticulo = CodigoGrupo+CodigoSubgrupo;

    if (($("#_grupos").val() == 0 && $("#_subgrupos").val() == 0) || ($("#_subgrupos").val() == 0)) // valida que el grupo y subgrupo sea seleccionado
    {
        alert('Para Generar el Codigo Debe Seleccionar el Grupo y Subgrupo');
    } else {
        $.get('../../generarcodigoarticulo/', function(data) {
            console.log(data.codigo);
            $('#codigo_articulo').empty();
            $('#correlativo').empty();
            $('#correlativo').val(data.codigo);
            $('#codigo_articulo').val(CodigoSubgrupo + data.codigo);
        });
    }
}

//OCULTA O MUESTRA SEGUN EL TIPO DE UNIDAD
function TipoUnidad() {
    var tipo_simple = document.getElementById("tipo_unidad_s");
    var tipo_multi = document.getElementById('tipo_unidad_m');

    if (tipo_simple.checked)
    {
        $('#equi_unid_pri').hide();
        $('#equi_unid_sec').hide();
        $('#equi_unid_ter').hide();
        $('#id_unidad_ter_col').hide();
    }
    else if (tipo_multi.checked)
        {
            $('#equi_unid_pri').show();
            $('#equi_unid_sec').show();
            $('#equi_unid_ter').show();
            $('#id_unidad_ter_col').show();
        }
}

//LLENA LA TABLA ADICIONALES CON LOS DATOS DE CLASIFICACION SELECCIONADOS
function CargarTablaClasificaciones()
{
    var clasificacion = $("#_clasificacion option:selected").text();
    var subclasificacion = $("#_subclasificacion option:selected").text();
    var valor = $('#valor').val();

    if ($("#_subclasificacion").val() == 0 || valor == "" ) // valida que la clasificacion y subclasificacion sean seleccionados
    {
        alert('Para Agregar Debe Seleccionar La Clasificación e Ingresar El Valor');
    }
    else
        {
            $("#tabla_adicionales>tbody").append("<tr><td id='id_articulo_clasificacion'></td>"
            + "<td id='id_clasificacion' style='visibility:collapse; display:none;'>"+clasificacion.split('-')[0].trim()+"</td>"
            + "<td id='nombre_clasificacion'>"+clasificacion.split('-')[1].trim()+"</td>"
            + "<td id='id_subclasificacion' style='visibility:collapse; display:none;'>"+subclasificacion.split('-')[0].trim()+"</td>"
            + "<td id='nombre_subclasificacion'>"+subclasificacion.split('-')[1].trim()+"</td>"
            + "<td id='valor' contenteditable='true'>"+valor+"</td>"
            +"<th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th> </tr>");
            $('#valor').val('');
        }
}

//OBTENER DATOS DE LA TABLA ADICIONALES
function CapturarDatosTablaClasificacion()
{
    let clasificaciones = [];
    
    document.querySelectorAll('#tabla_adicionales tbody tr').forEach(function(e){
        let fila = {
            id_articulo_clasificacion: e.querySelector('#id_articulo_clasificacion').innerText,
            //id_articulo: e.querySelector('#id_articulo').innerText,
            id_clasificacion: e.querySelector('#id_clasificacion').innerText,
            id_subclasificacion: e.querySelector('#id_subclasificacion').innerText,
            valor: e.querySelector("#valor").innerText,
        };

        clasificaciones.push(fila);
    });

    console.log(JSON.stringify(clasificaciones));
    $('#datosadicionales').val(JSON.stringify(clasificaciones)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

}

//LLENA LA TABLA UBICACION CON LOS DATOS DE UBICACION SELECCIONADOS
function CargarTablaUbicacion() {
    var almacen = $("#_almacenes option:selected").text();
    var subalmacen = $("#_subalmacenes option:selected").text();
    var ubicacion = $("#_zonas option:selected").text();
    var zona = $("#_ubicaciones").val();

    var idalmacen = $("#_almacenes option:selected").text().split('-')[1].trim();
    var idsubalmacen = $("#_subalmacenes option:selected").text().split('-')[1].trim();
    var idubicacion = $("#_zonas option:selected").text().split('-')[1].trim();

    //CapturarDatosTablaUbicacion(); 

    if ($("#_subalmacenes").val() == 0 && $("#_ubicaciones").val() == 0) {
        alert('Para Agregar Debe Seleccionar Almacen, Subalmacen y Zona');
    } else {
        $("#tabla_ubicaciones>tbody").append("<tr><td id='id_articulo_ubicacion'></td><td id='id_almacen' style='visibility:collapse; display:none;'>" + almacen + "</td><td id='id_subalmacen' style='visibility:collapse; display:none;'>" + subalmacen + "</td><td id='id_zona' style='visibility:collapse; display:none;'>" + ubicacion + "</td><td id='id_ubicacion' style='visibility:collapse; display:none;'>" + zona +   "<td>"+idalmacen+"</td><td>"+idsubalmacen+"</td><td>"+idubicacion+"</td><td>"+zona+"</td>     </td><th style='text-align: center;'><button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></th></tr>");
    }
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

//ELIMINAR ADICIONALES CON AJAX
function EliminarAdicional(id)
{
    $.ajax({
        // dataType: "JSON",
        url: eliminaradicionales+'/'+id,
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

//ELIMINAR Ubicacion CON AJAX
function EliminarUbicacion(id)
{
    $.ajax({
        // dataType: "JSON",
        url: eliminarubicaciones+'/'+id,
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


//boton elimnar filas de tablas
$(document).on('click', '.borrar', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});

CargarSubgrupos();
$('#_grupos').on('change', CargarSubgrupos);

TipoUnidad();

CargarSubclasificacion();
$('#_clasificacion').on('change', CargarSubclasificacion);

CargarSubalmacen();
$('#_almacenes').on('change', CargarSubalmacen);

CargarZonas();
$('#_subalmacenes').on('change', CargarZonas);


//Marcar y Desmaracar todos los checkbox de la migracion a profit
$("#todos").change(function () {
     $("input:checkbox").prop('checked', $(this).prop("checked"));
});

//auto completar en nombre del articulo
$('#scrollable-dropdown-menu .typeahead').typeahead( {
    items: 'all',

    source: function (query, process) {
        return $.get(route, {
            query: query
        }, function (data) {
            return process(data);
        });
    }
});