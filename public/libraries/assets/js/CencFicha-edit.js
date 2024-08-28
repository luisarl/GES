

//LLENA EL SELECT CARACTERISTICAS 
function CargarCaracteristicas2() 
{
    var IdTipo = $('#id_tipo2').val();
    console.log(caracteristicasvalores);

    $.get(caracteristicasvalores +'/'+ IdTipo, function(data) {
        var old = $('#id_caracteristica2').data('old') != '' ? $('#id_caracteristica2').data('old') : '';
        $('#id_caracteristica2').empty();
        $('#id_caracteristica2').append('<option value="0">Seleccione la caracteristica</option>');

        $.each(data, function(fetch, caracteristicas) {
            //console.log(data);
            for (i = 0; i < caracteristicas.length; i++) {
                $('#id_caracteristica2').append('<option value="' + caracteristicas[i].id_caracteristica + '"   ' + (old ==
                    caracteristicas[i].id_caracteristica ? "selected" : "") + ' >'+caracteristicas[i].id_caracteristica+' | '+caracteristicas[i]
                    .nombre_caracteristica + '</option>');
            }
        })
    })
}

//LLENA LA TABLA ADICIONALES CON LOS DATOS DE LAS CARACTERISTICAS SELECCIONADAS
function CargarTabla2()
{
    var IdCaracteristica = $("#id_caracteristica2 option:selected").text();
    console.log(IdCaracteristica); 
    var valor = $('#valor_caracteristica2').val();


    if ($("#id_caracteristica2").val() == 0 || valor == "" ) 
    {
        alert('Para Agregar Debe Seleccionar La Caracteristica e Ingresar El Valor');
    }
    else
        {
            $("#tabla_caracteristicas2>tbody").append("<tr><td id='id_ficha_valor' style='visibility:collapse; display:none;'></td><td id='id_caracteristica2'>"+IdCaracteristica.split('|')[0]+"</td><td id='nombre_caracteristica2'>"+IdCaracteristica.split('|')[1]+"</td><td id='valor_caracteristica2'>"+valor+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th> </tr>");
            $('#id_caracteristica2').val('');
            $('#valor_caracteristica2').val('');
        }
}

//OBTENER DATOS DE LA TABLA 
function CapturarDatosTabla2()
{
    let caracteristicas2 = [];
    
    document.querySelectorAll('#tabla_caracteristicas2 tbody tr').forEach(function(e){
        let fila = {
            id_ficha_valor: e.querySelector('#id_ficha_valor').innerText,
            id_caracteristica: e.querySelector('#id_caracteristica2').innerText,
            nombre_caracteristica: e.querySelector('#nombre_caracteristica2').innerText,
            valor_caracteristica: e.querySelector('#valor_caracteristica2').innerText,
        };

        caracteristicas2.push(fila);
    });

    $('#caracteristicas2').val(JSON.stringify(caracteristicas2)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    console.log("Hola aqui");
    console.log(caracteristicas2);

    return caracteristicas2;
}


//ELIMINAR ADICIONALES CON AJAX
function EliminarAdicional(id)
{
    $.ajax({
        // dataType: "JSON",
        url: eliminaradicional2+'/'+id,
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


CargarCaracteristicas2();
$('#id_tipo2').on('change', CargarCaracteristicas2);
