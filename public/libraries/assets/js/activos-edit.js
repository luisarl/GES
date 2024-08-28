//LENA EL SELECT
function CargarSubtipos() {
    var IdTipo = $('#id_tipo').val();

    $.get(RutaSubTipos + '/' + IdTipo, function(data) {
        var old = $('#_subtipos').data('old') != '' ? $('#_subtipos').data('old') : '';
        $('#_subtipos').empty();
        $('#_subtipos').append('<option value="0">Seleccione El Subtipo</option>');

        $.each(data, function(fetch, subtipos) {
            //console.log(data);
            for (i = 0; i < subtipos.length; i++) {
                $('#_subtipos').append('<option value="' + subtipos[i].id_subtipo + '"   ' + (old ==
                    subtipos[i].id_subtipo ? "selected" : "") + ' >'+ subtipos[i].nombre_subtipo + '</option>');
            }
        })

    })
}

//LLENA EL SELECT SUB ADICIONAL 
function CargarCaracteristicas() {
    var IdTipo = $('#id_tipo').val();
    
    $.get(RutaCaracteristicas + '/' + IdTipo, function(data) {
        var old = $('#id_caracteristica').data('old') != '' ? $('#id_caracteristica').data('old') : '';
        $('#id_caracteristica').empty();
        $('#id_caracteristica').append('<option value="0">Seleccione la caracteristica</option>');
    
        $.each(data, function(fetch, caracteristicas) {
            //console.log(data);
            for (i = 0; i < caracteristicas.length; i++) {
                $('#id_caracteristica').append('<option value="' + caracteristicas[i].id_caracteristica + '"   ' + (old ==
                    caracteristicas[i].id_caracteristica ? "selected" : "") + ' >'+caracteristicas[i].id_caracteristica+' | '+caracteristicas[i]
                    .nombre_caracteristica + '</option>');
            }
        })
    
    })
}

//LLENA LA TABLA ADICIONALES CON LOS DATOS DE LAS CARACTERISTICAS SELECCIONADAS
function CargarTabla()
{
    var IdCaracteristica = $("#id_caracteristica option:selected").text();
    var valor = $('#valor_caracteristica').val();


    if ($("#id_caracteristica").val() == 0 || valor == "" ) 
    {
        alert('Para Agregar Debe Seleccionar La Caracteristica e Ingresar El Valor');
    }
    else
        {
            $("#tabla_caracteristicas>tbody").append("<tr><td id='id_activo_caracteristica'></td><td id='id_caracteristica' style='visibility:collapse; display:none;'>"+IdCaracteristica.split('|')[0]+"</td><td id='nombre_caracteristica'>"+IdCaracteristica.split('|')[1]+"</td><td id='valor_caracteristica'>"+valor+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th> </tr>");
            $('#id_caracteristica').val('');
            $('#valor_caracteristica').val('');
        }
}

//OBTENER DATOS DE LA TABLA 
function CapturarDatosTabla()
{
    let caracteristicas = [];
    
    document.querySelectorAll('#tabla_caracteristicas tbody tr').forEach(function(e){
        let fila = {
            id_activo_caracteristica: e.querySelector('#id_activo_caracteristica').innerText,
            id_caracteristica: e.querySelector('#id_caracteristica').innerText,
            nombre_caracteristica: e.querySelector('#nombre_caracteristica').innerText,
            valor_caracteristica: e.querySelector('#valor_caracteristica').innerText,
        };

        caracteristicas.push(fila);
    });

    $('#caracteristicas').val(JSON.stringify(caracteristicas)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return caracteristicas;
}


//ELIMINAR ADICIONALES CON AJAX
function EliminarAdicional(id)
{
    $.ajax({
        // dataType: "JSON",
        url: eliminaradicional+'/'+id,
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

CargarSubtipos();
$('#id_tipo').on('change', CargarSubtipos);


CargarCaracteristicas();
$('#id_tipo').on('change', CargarCaracteristicas);
