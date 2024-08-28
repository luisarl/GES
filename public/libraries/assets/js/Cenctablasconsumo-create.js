// muestra tecnologias asociadas al equipo 
$(document).ready(function() 
{
    $('#id_equipo').change(function() 
    {
        var idEquipo = $(this).val();
        // devolucion de json
        if (idEquipo !== '0') 
        {
            $.ajax({
                url: ruta + '/obtener-tecnologias/' + idEquipo,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#id_tecnologia').empty();
                    $('#id_tecnologia').append('<option value="0">Seleccione la tecnología</option>');

                    $.each(response.caracteristicas, function(index, tecnologia) {
                        $('#id_tecnologia').append('<option value="' + tecnologia.id_tecnologia + '">' + tecnologia.nombre_tecnologia + '</option>');
                    });
                }
            });
        } 
        else 
        {
            $('#id_tecnologia').empty();
            $('#id_tecnologia').append('<option value="0">Seleccione la tecnología</option>');
        }
    });
});

// muestra tecnologias asociadas al equipo 
function ObtenerIDEquipoTecnologia()
{
    var id_equipotecnologia; 
    var id_equipo_consumible; 

    $(document).ready(function () {
        $('#id_tecnologia').change(function () {
            var IdEquipo = $("#id_equipo option:selected").val();
            var IdTecnologia = $("#id_tecnologia option:selected").val();
            var espesor = $("#espesor_consumible").val();   

            if (IdEquipo !== '0' && IdTecnologia !== '0') 
            {
                $.get(rutatablaconsumo + '/obtener-idequipotecnologia/' + IdEquipo + '/' + IdTecnologia, function (data)
                {
                    id_equipotecnologia = data;
                    console.log(id_equipotecnologia);
                    if (id_equipotecnologia !== '0') 
                    {
                        $.get(rutatablaconsumo + '/obtener-idconsumibles/' +id_equipotecnologia, function (data) 
                        {
                            id_equipo_consumible = data;
                            console.log(id_equipo_consumible);
                            console.log(id_equipo_consumible.caracteristicas[0].id_equipo_consumible); 
                            // ciclo para recorrer toda la variable y que se inserte 
                            $("#tabla_registros>tbody").empty();
                            for(var i=0;i<id_equipo_consumible.caracteristicas.length;i++)
                            {
                                $("#tabla_registros>tbody").append("<tr><td id='id_equipo_consumible' style='visibility:collapse; display:none;'>"+id_equipo_consumible.caracteristicas[i].id_equipo_consumible+"</td><td id='nombre_consumible' style='width: 40%'>"+id_equipo_consumible.caracteristicas[i].nombre_consumible+"<td style='width: 10%'>"+id_equipo_consumible.caracteristicas[i].unidad_consumible+"</td></td><td id='valor_espesor' style='width: 20%'>"+espesor+"</td> <td> <input type='text' id='valor_registro' class='form-control'> </td> </tr>");
        
                            }
                        });
                    }
                });
            }
        });
    });
}

ObtenerIDEquipoTecnologia();


function CapturarDatosTabla2() 
{
    let parametros = [];

    $('#tabla_registros tbody tr').each(function()
    {
        let fila = {
            id_equipo_consumible: $(this).find('#id_equipo_consumible').text(),
            valor_espesor: $(this).find('#valor_espesor').text(),
            valor_registro: $(this).find('td input#valor_registro').val()
        };
        parametros.push(fila);
    });

    $('#parametros').val(JSON.stringify(parametros));

return parametros;
}