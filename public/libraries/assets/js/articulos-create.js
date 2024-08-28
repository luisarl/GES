//LENA EL SELECT DE SUBGRUPOS
function CargarSubgrupos() {

    //console.log(e);
    var IdGrupo = $('#_grupos').val();

    $.get('../subgruposarticulo/' + IdGrupo, function(data) {
        var old = $('#_subgrupos').data('old') != '' ? $('#_subgrupos').data('old') : '';
        $('#_subgrupos').empty();
        $('#_subgrupos').append('<option value="0">Seleccione El Subgrupo</option>');

        $.each(data, function(fetch, subgrupos) {
            console.log(data);
            for (i = 0; i < subgrupos.length; i++) {
                $('#_subgrupos').append('<option value="' + subgrupos[i].id_subgrupo + '"   ' + (old ==
                        subgrupos[i].id_subgrupo ? "selected" : "") + ' >'+ subgrupos[i]
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

$.get('../subclasificacionarticulo/' + IdClasificacion, function(data) {
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
function GenerarCodigo()
{
    var grupo = $("#_grupos option:selected").text(); //captura el valor del texto del select
    var subgrupo = $("#_subgrupos option:selected").text(); //captura el valor del texto del select
    var CodigoGrupo = grupo.split(' ')[0]; //extrae el primer texto hasta es espacio en blanco
    var CodigoSubgrupo = subgrupo.split(' ')[0]; //extrae el primer texto hasta es espacio en blanco
    //var CodigoArticulo = CodigoGrupo+CodigoSubgrupo;

    if  ( ($("#_grupos").val() == 0 && $("#_subgrupos").val() == 0) || ($("#_subgrupos").val() == 0)) // valida que el grupo y subgrupo sea seleccionado
    {
        alert('Para Generar el Codigo Debe Seleccionar el Grupo y Subgrupo');
    }
    else
        {
            $.get('../generarcodigoarticulo/', function(data) {
                console.log(data.codigo);
                $('#codigo_articulo').empty();
                $('#correlativo').empty();
                $('#correlativo').val(data.codigo);
                $('#codigo_articulo').val(CodigoSubgrupo+data.codigo);
            });
        }
}

//OCULTA O MUESTRA SEGUN EL TIPO DE UNIDAD
function TipoUnidad()
{
    var tipo_simple = document.getElementById("tipo_unidad_s");
    var tipo_multi = document.getElementById('tipo_unidad_m');

    if(tipo_simple.checked )
    {
        $('#equi_unid_pri').hide() ;
        $('#equi_unid_sec').hide();
        $('#equi_unid_ter').hide();
        $('#id_unidad_ter_col').hide();
    }
     else if(tipo_multi.checked)
            {
                $('#equi_unid_pri').show() ;
                $('#equi_unid_sec').show();
                $('#equi_unid_ter').show();
                $('#id_unidad_ter_col').show();
            }
}

//LLENA LA TABLA ADICIONALES CON LOS DATOS DE CLASIFICACION SELECCIONADOS
function CargarTabla()
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
function CapturarDatosTabla()
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