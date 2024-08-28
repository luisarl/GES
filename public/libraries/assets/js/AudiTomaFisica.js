 
//OBTENER DATOS DE LA TABLA 
function CapturarDatosTabla()
{
    let lista_conteo = [];
    
    document.querySelectorAll('#tabla_subalmacenes tbody tr').forEach(function(e)
    {
        var conteo_fisico = e.querySelector('#conteo_fisico input[name="conteo"]').value

        if(conteo_fisico != '')
        {
            let fila = {
                id_subalmacen: e.querySelector('#id_subalmacen').innerText,
                nombre_subalmacen: e.querySelector('#nombre_subalmacen').innerText,
                stock_actual: e.querySelector('#stock_actual').innerText,
                conteo_fisico: e.querySelector('#conteo_fisico input[name="conteo"]').value
            };

            lista_conteo.push(fila);
        }
    });

    console.log(JSON.stringify(lista_conteo));
    $('#subalmacenes').val(JSON.stringify(lista_conteo)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return lista_conteo;

}

//  function BuscarArticulo()
//  {
//     var CodigoArticulo = $('#codigo_articulo').val();
     
//     $.get(ImportarArticulo + '/' + CodigoArticulo, function(data) {

//         const { articulos: articulo } = data;
//         console.log(data);
//             $("#nombre_articulo").val(articulo.nombre_articulo);
//             $("#descripcion_articulo").val(articulo.descripcion_articulo);
//             $("#grupo").val(articulo.nombre_grupo);
//             $("#subgrupo").val(articulo.nombre_subgrupo);
//             $("#categoria").val(articulo.nombre_categoria);
           
//     });
            
//  }

// function CargarSubalmacenes() {
//     //console.log(e);
//     var IdAlmacen = $('#id_almacen').val();

//     $.get(SubAlmacenes+ '/' + IdAlmacen, function(data) {
//         var old = $('#id_subalmacen').data('old') != '' ? $('#id_subalmacen').data('old') : '';
//         $('#id_subalmacen').empty();
//         $('#id_subalmacen').append('<option value="0">SELECCIONE EL SUBALMACEN</option>');
       
//         $.each(data, function(fetch, subalmacenes) {
//             for (i = 0; i < subalmacenes.length; i++) {
//                 $('#id_subalmacen').append('<option value="' + subalmacenes[i].id_subalmacen + '"  ' 
//                     + (old == subalmacenes[i].id_subalmacen ? "selected" : "") + ' >' 
//                     + subalmacenes[i].nombre_subalmacen + '</option>');
//             }
//         })

//     })
// }

// CargarSubalmacenes();
// $('#id_almacen').on('change', CargarSubalmacenes);