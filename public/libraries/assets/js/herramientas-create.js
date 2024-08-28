//LENA EL SELECT DE SUBGRUPOS
function CargarSubgrupos() {

    //console.log(e);
    var IdGrupo = $('#_grupos').val();

    $.get('../subgruposherramientas/' + IdGrupo, function(data) {
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


//LLENA EL SELECT ALMACENES
function CargarAlmacenesHerramientas() {

    //console.log(e);
    var IdEmpresa = $('#_empresas').val();
    
    $.get('../almacenesherramientas/' + IdEmpresa, function(data) {
        var old = $('#_almacenes').data('old') != '' ? $('#_almacenes').data('old') : '';
        $('#_almacenes').empty();
        $('#_almacenes').append('<option value="0">Seleccione Almacen</option>');
    
        $.each(data, function(fetch, almacenes) {
            console.log(data);
            for (i = 0; i < almacenes.length; i++) {
                $('#_almacenes').append('<option value="' + almacenes[i].id_almacen + '"   ' + (old ==
                    almacenes[i].id_almacen ? "selected" : "") + ' >'+ almacenes[i]
                    .id_almacen + ' - ' + almacenes[i]
                    .nombre_almacen + '</option>');
            }
        })
    
    })
}

function CargarUbicacion() {
    //console.log(e);
    var IdUbicacion = $('#_almacenes').val();

    $.get('../ubicacionesHerramientas/' + IdUbicacion, function(data) {
        var old = $('#_ubicaciones').data('old') != '' ? $('#_ubicaciones').data('old') : '';
        $('#_ubicaciones').empty();
        $('#_ubicaciones').append('<option value="0">Seleccione La Ubicacion</option>');

        $.each(data, function(fetch, ubicaciones) {
            console.log(data);
            for (i = 0; i < ubicaciones.length; i++) {
                $('#_ubicaciones').append('<option value="' + ubicaciones[i].id_ubicacion + '"   ' + (old ==
                    ubicaciones[i].id_ubicacion ? "selected" : "") + ' >'+ ubicaciones[i]
                    .id_ubicacion + ' - ' + ubicaciones[i]
                    .nombre_ubicacion + '</option>');
            }
        })

    })
}

//LLENA LA TABLA ADICIONALES CON LOS DATOS DE HERRAMIENTAS
function CargarTabla()
{
    var empresas = $("#_empresas option:selected").text();
    var almacenes = $("#_almacenes option:selected").text();
    var ubicaciones = $("#_ubicaciones option:selected").text();
    var stock = $('#stock').val();


    if ($("#_empresas").val() == 0 || stock == 0 ) // valida que la Empresa y Almacen sean seleccionados
    {
        alert('Para Agregar Debe Seleccionar La Empresa e Ingresar El Stock');
    }
    else
        {
            $("#tabla_almacenes>tbody").append("<tr><th></th><td>"+empresas+"</td><td>"+almacenes+"</td><td>"+ubicaciones+"</td><td>"+stock+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th> </tr>");
        }

}


//OBTENER DATOS DE LA TABLA ADICIONALES
function CapturarDatosTabla()
{
    var tabla = document.getElementById("tabla_almacenes");
    var filas = tabla.rows.length - 1 ; //obtiene el numero de filas de la tabla , menos el encabezado TH
    var celda = document.getElementsByTagName("td"); //ingresa en la propiedad td de la tabla

    var acumulador1 = 0;
    var acumulador2 = 1;
    var acumulador3 = 2;
    var acumulador4 = 3;


    var columnas = 4;
    var arreglo = [];

    for(var i = 0; i < filas; i++)
    {
        for(var j = 0; j < 1; j ++)
        {
            arreglo.push([celda[acumulador1].innerHTML.trim().split(' ')[0], celda[acumulador2].innerHTML.split(' ')[0], celda[acumulador3].innerHTML.split(' ')[0], celda[acumulador4].innerHTML]);
            acumulador1 = acumulador1 + columnas;
            acumulador2 = acumulador2 + columnas;
            acumulador3 = acumulador3 + columnas;
            acumulador4 = acumulador4 + columnas;
        }
    }

   //alert(arreglo);
    console.log(JSON.stringify(arreglo));
    $('#datosherramientas').val(JSON.stringify(arreglo)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST 
    
}


$(document).on('click', '.borrar', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});

//GENERA EL CODIGO DEL ARTICULO SUBGRUPO + CORRELATIVO
function GenerarCodigoHerramienta()
{

    var grupo = $("#_grupos option:selected").text(); //captura el valor del texto del select
    var subgrupo = $("#_subgrupos option:selected").text(); //captura el valor del texto del select
    var CodigoGrupo = grupo.split(' ')[0]; //extrae el primer texto hasta es espacio en blanco
    var CodigoSubgrupo = subgrupo.split(' ')[0]; //extrae el primer texto hasta es espacio en blanco
    

    if  ( ($("#_grupos").val() == 0 && $("#_subgrupos").val() == 0) || ($("#_subgrupos").val() == 0)) // valida que el grupo y subgrupo sea seleccionado
    {
        alert('Para Generar el Codigo Debe Seleccionar el Grupo y Subgrupo');
    }
    else
        {
            $.get('../generarcodigoherramienta/' + CodigoSubgrupo, function(data) {
                console.log(data.codigo);
                $('#codigo_herramienta').empty();
                $('#correlativo').empty();
                $('#correlativo').val(data.codigo);
                $('#codigo_herramienta').val(CodigoSubgrupo+data.codigo);
            });
        }
}

function ImportarArticulo()
{
    var codigo_articulo = $('#_codigoarticulo').val();
     
    $.get('../importararticulo/' + codigo_articulo, function(data) {

        const { articulos: articulo } = data;
            document.getElementById("codigo_herramienta").value = articulo.codigo_articulo;
            document.getElementById("_nombre").value = articulo.nombre_articulo;
            document.getElementById("_descripcion").value = articulo.descripcion_articulo;
            document.getElementById("_grupos").value = articulo.id_grupo;
            document.getElementById("_subgrupos").value = articulo.id_subgrupo;
            document.getElementById("id_categoria").value = articulo.id_categoria;
            
            $('#_grupos').empty()
            $('#_grupos').append('<option value="' + data.articulos.id_grupo + '" ' + "selected"  + ' >'+ data.articulos.codigo_grupo 
                + ' - ' + data.articulos.nombre_grupo + '</option>');
            
            $('#_subgrupos').empty()
            $('#_subgrupos').append('<option value="' + data.articulos.id_subgrupo + '" ' + "selected"  + ' >'+ data.articulos.codigo_subgrupo 
                + ' - ' + data.articulos.nombre_subgrupo + '</option>');
            
            $('#id_categoria').empty()
            $('#id_categoria').append('<option value="' + data.articulos.id_categoria + '" ' + "selected"  + ' >'+ data.articulos.codigo_categoria 
                + ' - ' + data.articulos.nombre_categoria + '</option>');
        
    })     
}

function Importar()
{
    var ImportarArticulo = document.getElementById("importar");

    if(ImportarArticulo.checked )
    {
        $('#_codigoarticulo').show();
        $('#botonImportar').show();        
        $('#codigo_herramienta').attr('readonly', true);
        $('#_grupos').attr('readonly', true);
        $('#_subgrupos').attr('readonly', true);
        $('#id_categoria').attr('readonly', true);

    }
    else 
        {
            $('#_codigoarticulo').hide();
            $('#botonImportar').hide();
            $('#codigo_herramienta').attr('readonly', false);
            $('#_grupos').attr('readonly', false);
            $('#_subgrupos').attr('readonly', false);
            $('#id_categoria').attr('readonly', false);
        }
}

Importar();

CargarSubgrupos();
$('#_grupos').on('change', CargarSubgrupos);

CargarAlmacenesHerramientas();
$('#_empresas').on('change', CargarAlmacenesHerramientas);

CargarUbicacion();
$('#_almacenes').on('change', CargarUbicacion);

ImportarArticulo();
$('#_codigoarticulo').on('change', ImportarArticulo);