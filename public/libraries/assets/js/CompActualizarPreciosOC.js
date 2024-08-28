//OBTENER DATOS DE LA TABLA 
function CapturarDatosTabla()
{
    let lista_articulos = [];
    
    document.querySelectorAll('#tabla_articulos tbody tr').forEach(function(e){
        let fila = {
            reng_num: e.querySelector('#reng_num').innerText,
            codigo_articulo: e.querySelector('#codigo_articulo').innerText,
            nombre_articulo: e.querySelector('#nombre_articulo').innerText,     
            total_art: e.querySelector('#total_art').innerText,
            prec_vta: e.querySelector('#prec_vta input[name="precio"]').value
        };

        lista_articulos.push(fila);
    });

    console.log(JSON.stringify(lista_articulos));
    $('#articulos').val(JSON.stringify(lista_articulos)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return lista_articulos;

}