
function ObtenerCaracteristicasTipoFicha() {

    $(document).ready(function () {
        $('#id_tipo').change(function () {
            var codigo = $("#codigo_ficha").val();   
            var idTipo = $("#id_tipo option:selected").val();
            var aux = 1;
           
            if (codigo !== '0' && idTipo !== '0') 
            {

                        $.get(ruta +'/'+ idTipo, function (data) 
                        {
                            tipoFicha = data;

                            // ciclo para recorrer toda la variable y que se inserte 
                            $("#tabla_caracteristicas>tbody").empty();
                            for(var i=0;i<tipoFicha.caracteristicas.length;i++)
                            {
                                $("#tabla_caracteristicas>tbody").append("<tr><td id='id_caracteristica' style='visibility:collapse; display:none;'>"+tipoFicha.caracteristicas[i].id_caracteristica+"</td><td id='nro' style='width: 10%'>"+aux+"</td><td id='nombre_caracteristica' style='width: 60%'>"+tipoFicha.caracteristicas[i].nombre_caracteristica+"</td><td> <input type='text' id='valor_caracteristica' class='form-control'> </td> </tr>");
                                aux++;
                            }
                            
                        });

            }
        });
        
    });
}

function CapturarDatosTabla()
{
    let caracteristicas = [];
    
    document.querySelectorAll('#tabla_caracteristicas tbody tr').forEach(function(e) {
        let fila = {
            id_caracteristica: e.querySelector('#id_caracteristica').innerText,
            nombre_caracteristica: e.querySelector('#nombre_caracteristica').innerText,
            valor_caracteristica: e.querySelector('input#valor_caracteristica').value,
        };
    
        caracteristicas.push(fila);
    });

    $('#caracteristicas').val(JSON.stringify(caracteristicas)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    console.log(caracteristicas);

    return caracteristicas;
}

ObtenerCaracteristicasTipoFicha();
