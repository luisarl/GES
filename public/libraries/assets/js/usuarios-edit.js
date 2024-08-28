//LLENA EL SELECT ALMACENES
function SelectAlmacenesUsuarios() {

    //console.log(e);
    var IdEmpresa = $('#_empresas').val();
    
    $.get('../../almacenesempresa/' + IdEmpresa, function(data) {
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

//LLENA LA TABLA CON LOS DATOS DE LA HERRAMIENTA SELECCIONADA
function CargarAlmacenUsuario()
{
    var empresa = $("#_empresas option:selected").text();
    var almacen = $("#_almacenes option:selected").text();

    // si la herramienta no esta cargada la agrega a la tabla
    $("#tabla_almacen>tbody").append("<tr><td></td><td id='id_empresas'>"+empresa+"</td><td id='id_almacen'>"+almacen+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
    $('#_almacenes').val('');
    $('#_empresas').val(0);
    

}

function CargarEmbarcacionUsuario()
{
    var embarcacion = $("#id_embarcacion option:selected").text();
   

    // si la herramienta no esta cargada la agrega a la tabla
    $("#tabla_embarcaciones>tbody").append("<tr><td id='id_embarcacion'>"+embarcacion.split(' - ')[0]+"</td><td id='nombre_embarcacion'>"+embarcacion.split(' - ')[1]+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
    $('#id_embarcacion').val(0);

}

// function CapturarDatosAlmacenes()
// {
//     let Listado_almacenes = [];

//     document.querySelectorAll('#tabla_almacen tbody tr').forEach(function(e){
//         let fila = {
//             id_empresa: e.querySelector('#_empresas').inner.Textsplit(' ')[0],
//             id_almacen: e.querySelector('#_almacenes').innerText.split(' ')[0],
//         };

//         Listado_almacenes.push(fila);
//     });
   
//     $('#datosalmacen').val(JSON.stringify(Listado_almacenes)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST
//     return Listado_almacenes;
    
// }

function CapturarDatosAlmacenes()
{
    var tabla = document.getElementById("tabla_almacen");
    var filas = tabla.rows.length - 1 ; //obtiene el numero de filas de la tabla , menos el encabezado TH
    var celda = document.getElementsByTagName("td"); //ingresa en la propiedad td de la tabla

    var acumulador1 = 0;
    var acumulador2 = 1;
    var acumulador3 = 2;


    var columnas = 3;
    var arreglo = [];

    for(var i = 0; i < filas; i++)
    {
        for(var j = 0; j < 1; j ++)
        {
            arreglo.push([celda[acumulador1].innerHTML, celda[acumulador2].innerHTML.trim().split('')[0], celda[acumulador2].innerHTML.trim().split('')[0]]);
            acumulador1 = acumulador1 + columnas;
            acumulador2 = acumulador2 + columnas;
            acumulador3 = acumulador3 + columnas;
          
        }
    }

    CapturarDatosTablaEmbarcaciones();
    console.log(JSON.stringify(arreglo));
    //alert(arreglo);
    $('#datosalmacen').val(JSON.stringify(arreglo)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST 
    
}

function CapturarDatosTablaEmbarcaciones() {
    let lista_embarcaciones = [];
    
    document.querySelectorAll('#tabla_embarcaciones tbody tr').forEach(function(e) {
        let fila = {
            id_embarcacion: e.querySelector('#id_embarcacion').innerText 
        };

        lista_embarcaciones.push(fila);
    });

    console.log(JSON.stringify(lista_embarcaciones));
    $('#datosembarcacion').val(JSON.stringify(lista_embarcaciones));

    return lista_embarcaciones;
}

$(document).on('click', '.borrar', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});

//ELIMINAR ADICIONALES CON AJAX
function EliminarAlmacenes(id)
{
    $.ajax({
        // dataType: "JSON",
        url: eliminaralmacenes+'/'+id,
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

//ELIMINAR ADICIONALES CON AJAX
function EliminarEmbarcaciones(id)
{
    $.ajax({
        // dataType: "JSON",
        url: eliminarembarcaciones+'/'+id,
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

SelectAlmacenesUsuarios();
$('#_empresas').on('change', SelectAlmacenesUsuarios);