function CargarSubalmacen() {
    //console.log(e);
    var IdSubalmacen = $('#_almacenes').val();

    $.get(obtenersubalmacen+ '/' + IdSubalmacen, function(data) {
        var old = $('#_subalmacenes').data('old') != '' ? $('#_subalmacenes').data('old') : '';
        $('#_subalmacenes').empty();
        $('#_subalmacenes').append('<option value="0">Seleccione el Subalmacen</option>');

        $.each(data, function(fetch, subalmacenes) {
            console.log(data);
            for (i = 0; i < subalmacenes.length; i++) {
                $('#_subalmacenes').append('<option value="' + subalmacenes[i].id_subalmacen + '"   ' + (old ==
                    subalmacenes[i].id_subalmacen ? "selected" : "") + ' >'+ subalmacenes[i]
                    .id_subalmacen + ' - ' + subalmacenes[i]
                    .nombre_subalmacen + '</option>');
            }
        })

    })
}

function CargarZonas() {
    //console.log(e);
    var IdZona = $('#_subalmacenes').val();

    $.get(obtenerzonas+ '/' + IdZona, function(data) {
        var old = $('#_zonas').data('old') != '' ? $('#_zonas').data('old') : '';
        $('#_zonas').empty();
        $('#_zonas').append('<option value="0">Seleccione el Subalmacen</option>');

        $.each(data, function(fetch, zonas) {
            console.log(data);
            for (i = 0; i < zonas.length; i++) {
                $('#_zonas').append('<option value="' + zonas[i].id_ubicacion + '"   ' + (old ==
                    zonas[i].id_ubicacion ? "selected" : "") + ' >'+ zonas[i]
                    .id_ubicacion + ' - ' + zonas[i]
                    .nombre_ubicacion + '</option>');
            }
        })

    })
}

//TRAE UN ARTICULO FILTRADO POR EL CODIGO
function FiltroArticulosUbicaciones()
{
    var CodigoArticulo = $('#_codigoarticulo').val();
    var IdGrupo = $('#_grupos').val();
    var IdCategoria = $('#_categorias').val();
    var IdAlmacen = $('#_almacenes').val();
    var IdSubAlmacen = $('#_subalmacenes').val();
    var IdZona = $('#_zonas').val();
    
    if(CodigoArticulo == '')
    {
        CodigoArticulo = 0; 
    }
    
    if(IdAlmacen == 0 || IdSubAlmacen == 0 || IdZona == 0)
    {
        alert('DEBE SELECCIONAR EL FILTRO DE UBICACIONES');
    }
    else
        {
            $.get(FiltroArticulos + '/' +CodigoArticulo+ '/' +IdGrupo+ '/' +IdCategoria+ '/' +IdAlmacen+ '/' +IdSubAlmacen+ '/' +IdZona, function(data) {
                $('#_articulos').empty();
                // vaciar tabla 
                $('#tabla_almacenes>tbody').empty(); 
                    $.each(data, function(fetch, articulos) 
                    {
                        for (i = 0; i < articulos.length; i++) 
                        {
                            $("#tabla_almacenes>tbody").append("<tr><td id='id_articulo_ubicacion' style='visibility:collapse; display:none;'>"+articulos[i].id_articulo_ubicacion+"</><td id='id_articulo'>"+articulos[i].id_articulo+"</td><td id='nombre_articulo'>"+articulos[i].nombre_articulo+"</td><td id='zona' contenteditable='true'>"+articulos[i].zona+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
                        }    
                    })
            })   
        }          
}

//CAPTURA EL CODIGO DEL ARTICULO SELECCIONADO EN LA BUSQUEDA POR NOMBRE
function ObtenerCodigoArticulo()
{
    var NombreArticulo = $('#nombre_articulo').val();
    var CodigoArticulo = NombreArticulo.split('|')[0];
    $('#_codigoarticulo').val(CodigoArticulo);

}

//CAPTURAR LOS DATOS DE LA TABLA
function CapturarDatosTabla()
{
    let lista_articulos = [];
    
    document.querySelectorAll('#tabla_almacenes tbody tr').forEach(function(e){
        let fila = {
            id_articulo_ubicacion: e.querySelector('#id_articulo_ubicacion').innerText,
            id_articulo: e.querySelector('#id_articulo').innerText,
            zona: e.querySelector('#zona').innerText,
        };

        lista_articulos.push(fila);
    });

    console.log(JSON.stringify(lista_articulos));
    //alert(lista_articulos);
    $('#datosarticulos').val(JSON.stringify(lista_articulos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST
    return lista_articulos;

}

$(document).on('click', '.borrar', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});


CargarSubalmacen();
$('#_almacenes').on('change', CargarSubalmacen);

CargarZonas();
$('#_subalmacenes').on('change', CargarZonas);

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