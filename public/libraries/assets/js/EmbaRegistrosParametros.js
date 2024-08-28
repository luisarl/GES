//CARGA TABLA CREAR REGISTRO DE PARAMETROS
function CargarTabla()
{
    var IdMaquina = $("#id_maquina").val();
    var fecha = $("#fecha").val();
    $('#tabla_parametros>tbody').empty();

    $.get(CrearRegistroParametros +'/'+IdMaquina+'/'+fecha, function(data)
    {
        $.each(data, function(fetch, parametros) 
        {
            for (i = 0; i < parametros.length; i++) 
            {
                var hora;

                if(parametros[i].hora == null)
                {
                    hora = '00:00';
                }
                else if(parametros[i].hora == '00:00:00' )
                    {
                        $('#alerta').show() ;
                        $("#alerta>#mensaje").append('Los Registros De La Fecha '+fecha+ ' Han Sido Completados'); 
                        return
                    }
                    else
                        {
                            hora = parametros[i].hora;
                        }

                $("#tabla_parametros>tbody").append("<tr>"
                    +"<td id='id_registro_parametro' style='visibility:collapse; display:none;'></td>"
                    +"<td id='id_parametro' style='visibility:collapse; display:none;'>"+parametros[i].id_parametro+"</td>"
                    +"<td id='nombre_parametro'>"+parametros[i].nombre_parametro+" ("+parseFloat(parametros[i].valor_minimo)+" - "+parseFloat(parametros[i].valor_maximo)+")</td>"
                    +"<td id='hora'>"+hora+"</td>"
                    +"<td id='valor_minimo' style='visibility:collapse; display:none;'>"+parametros[i].valor_minimo+"</td>"
                    +"<td id='valor_maximo' style='visibility:collapse; display:none;'>"+parametros[i].valor_maximo+"</td>"
                    +"<td id='valor'> <input type='number' name='valor' class='form-control col-4' required='required'> </td>"
                    +"</tr>");
            }
        });
    });
}

//CARGA LA TABLA BUSCAR REGISTRO DE PARAMETROS
function CargarTablaBuscar()
{
    var IdMaquina = $("#id_maquina").val();
    var fecha = $("#fecha").val();
    $('#tabla_parametros>tbody').empty();
    $('#observaciones').empty();

    $.get(BuscarObservacionesRegistroParametros +'/'+IdMaquina+'/'+fecha, function(data)
    {
        $.each(data, function(fetch, observaciones) 
        {
            for (i = 0; i < observaciones.length; i++) 
            {
                $('#observaciones').append('Hora '+observaciones[i].hora+': '+observaciones[i].observaciones+'\n');
            }
        });
    });

    $.get(BuscarRegistroParametros +'/'+IdMaquina+'/'+fecha, function(data)
    {
        $.each(data, function(fetch, parametros) 
        {
            var clase = 'background-danger';

            for (i = 0; i < parametros.length; i++) 
            {
                var ValorMinimo = parseFloat(parametros[i].valor_minimo);
                var ValorMaximo = parseFloat(parametros[i].valor_maximo); 

                $("#tabla_parametros>tbody").append("<tr>"
                    +"<td id='nombre_parametro'>"+parametros[i].nombre_parametro+" ("+parseFloat(parametros[i].valor_minimo)+" - "+parseFloat(parametros[i].valor_maximo)+")</td>"
                        +"<td id='hora0' class='"+(parseFloat(parametros[i].hora0) < ValorMinimo ? clase : parseFloat(parametros[i].hora0) > ValorMaximo ? clase : ' ') +"'>"
                    +(parametros[i].hora0 != null ? parseFloat(parametros[i].hora0) : '')+"</td>"
                    +"<td id='hora1' class='"+(parseFloat(parametros[i].hora1) < ValorMinimo ? clase : parseFloat(parametros[i].hora1) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora1 != null ? parseFloat(parametros[i].hora1) : '')+"</td>"
                    +"<td id='hora2' class='"+(parseFloat(parametros[i].hora2) < ValorMinimo ? clase : parseFloat(parametros[i].hora2) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora2 != null ? parseFloat(parametros[i].hora2) : '')+"</td>"
                    +"<td id='hora3' class='"+(parseFloat(parametros[i].hora3) < ValorMinimo ? clase : parseFloat(parametros[i].hora3) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora3 != null ? parseFloat(parametros[i].hora3) : '')+"</td>"
                    +"<td id='hora4' class='"+(parseFloat(parametros[i].hora4) < ValorMinimo ? clase : parseFloat(parametros[i].hora4) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora4 != null ? parseFloat(parametros[i].hora4) : '')+"</td>"
                    +"<td id='hora5' class='"+(parseFloat(parametros[i].hora5) < ValorMinimo ? clase : parseFloat(parametros[i].hora5) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora5 != null ? parseFloat(parametros[i].hora5) : '')+"</td>"
                    +"<td id='hora6' class='"+(parseFloat(parametros[i].hora6) < ValorMinimo ? clase : parseFloat(parametros[i].hora6) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora6 != null ? parseFloat(parametros[i].hora6) : '')+"</td>"
                    +"<td id='hora7' class='"+(parseFloat(parametros[i].hora7) < ValorMinimo ? clase : parseFloat(parametros[i].hora7) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora7 != null ? parseFloat(parametros[i].hora7) : '')+"</td>"
                    +"<td id='hora8' class='"+(parseFloat(parametros[i].hora8) < ValorMinimo ? clase : parseFloat(parametros[i].hora8) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora8 != null ? parseFloat(parametros[i].hora8) : '')+"</td>"
                    +"<td id='hora9' class='"+(parseFloat(parametros[i].hora9) < ValorMinimo ? clase : parseFloat(parametros[i].hora9) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora9 != null ? parseFloat(parametros[i].hora9) : '')+"</td>"
                    +"<td id='hora10' class='"+(parseFloat(parametros[i].hora10) < ValorMinimo ? clase : parseFloat(parametros[i].hora10) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora10 != null ? parseFloat(parametros[i].hora10) : '')+"</td>"
                    +"<td id='hora11' class='"+(parseFloat(parametros[i].hora11) < ValorMinimo ? clase : parseFloat(parametros[i].hora11) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora11 != null ? parseFloat(parametros[i].hora11) : '')+"</td>"
                    +"<td id='hora12' class='"+(parseFloat(parseFloat(parametros[i].hora12)) < ValorMinimo ? clase : parseFloat(parametros[i].hora12) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora12 != null ? parseFloat(parametros[i].hora12) : '')+"</td>"
                    +"<td id='hora13' class='"+(parseFloat(parametros[i].hora13) < ValorMinimo ? clase : parseFloat(parametros[i].hora13) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora13 != null ? parseFloat(parametros[i].hora13) : '')+"</td>"
                    +"<td id='hora14' class='"+(parseFloat(parametros[i].hora14) < ValorMinimo ? clase : parseFloat(parametros[i].hora14) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora14 != null ? parseFloat(parametros[i].hora14) : '')+"</td>"
                    +"<td id='hora15' class='"+(parseFloat(parametros[i].hora15) < ValorMinimo ? clase : parseFloat(parametros[i].hora15) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora15 != null ? parseFloat(parametros[i].hora15) : '')+"</td>"
                    +"<td id='hora16' class='"+(parseFloat(parametros[i].hora16) < ValorMinimo ? clase : parseFloat(parametros[i].hora16) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora16 != null ? parseFloat(parametros[i].hora16) : '')+"</td>"
                    +"<td id='hora17' class='"+(parseFloat(parametros[i].hora17) < ValorMinimo ? clase : parseFloat(parametros[i].hora17) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora17 != null ? parseFloat(parametros[i].hora17) : '')+"</td>"
                    +"<td id='hora18' class='"+(parseFloat(parametros[i].hora18) < ValorMinimo ? clase : parseFloat(parametros[i].hora18) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora18 != null ? parseFloat(parametros[i].hora18) : '')+"</td>"
                    +"<td id='hora19' class='"+(parseFloat(parametros[i].hora19) < ValorMinimo ? clase : parseFloat(parametros[i].hora19) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora19 != null ? parseFloat(parametros[i].hora19) : '')+"</td>"
                    +"<td id='hora20' class='"+(parseFloat(parametros[i].hora20) < ValorMinimo ? clase : parseFloat(parametros[i].hora20) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora20 != null ? parseFloat(parametros[i].hora20) : '')+"</td>"
                    +"<td id='hora21' class='"+(parseFloat(parametros[i].hora21) < ValorMinimo ? clase : parseFloat(parametros[i].hora21) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora21 != null ? parseFloat(parametros[i].hora21) : '')+"</td>"
                    +"<td id='hora22' class='"+(parseFloat(parametros[i].hora22) < ValorMinimo ? clase : parseFloat(parametros[i].hora22) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora22 != null ? parseFloat(parametros[i].hora22) : '')+"</td>"
                    +"<td id='hora23' class='"+(parseFloat(parametros[i].hora23) < ValorMinimo ? clase : parseFloat(parametros[i].hora23) > ValorMaximo ? clase : ' ') +"'>"
                        +(parametros[i].hora23 != null ? parseFloat(parametros[i].hora23) : '')+"</td>"
                    +"</tr>");
            }
        });
    });
}

//OBTENER DATOS DE LA TABLA 
function CapturarDatosTabla()
{
    let parametros = [];
    
    document.querySelectorAll('#tabla_parametros tbody tr').forEach(function(e){
        let fila = {
            id_registro_parametro: e.querySelector('#id_registro_parametro').innerText,
            id_parametro: e.querySelector('#id_parametro').innerText,
            nombre_parametro: e.querySelector('#nombre_parametro').innerText,
            hora: e.querySelector('#hora').innerText,
            valor_minimo: e.querySelector('#valor_minimo').innerText,
            valor_maximo: e.querySelector('#valor_maximo').innerText,
            valor: e.querySelector('#valor input[name="valor"]').value
        };

        parametros.push(fila);
    });

    $('#parametros').val(JSON.stringify(parametros)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    let ParametrosFueraRango = [];
    var j = 0;

    
    for (i = 0; i < parametros.length; i++) 
    {
        //VERIFICA SI EXISTEN VALORES FUERA DE RANGO MINIMO Y MAXIMO
        if(parseFloat(parametros[i].valor) < parseFloat(parametros[i].valor_minimo) || 
            parseFloat(parametros[i].valor) > parseFloat(parametros[i].valor_maximo))
        {
            ParametrosFueraRango[j] = parametros[i].nombre_parametro ;
            j ++;
        }
        //VERIFICA SI EXISTEN VALORES VACIOS
        else if(parametros[i].valor == "" )
            {
                $('#alerta').show() ;
                $("#alerta>#mensaje").text('El Valor De Los Parametros No Pueden Estar Vacios'); 
                return
            }
    }

    return ParametrosFueraRango;
}

//EJECUTA EL MODAL DE CONFIRMACION
$('#modal-confirmar-registros').on('show.bs.modal', function (event) {
    var parametros = CapturarDatosTabla();
    var modal = $(this)
    $('#lista').empty();
    $('#confirmacion').empty();

    if(parametros.length > 0)
    {
       modal.find('.modal-body h5').text('Los Siguientes Parametros Estan Fuera de Rango:') //cambia texto en el body del modal
       
       for(i = 0; i < parametros.length; i++)
       {
            $('#lista').append('<li>'+parametros[i]+'</li>');
       }
      
       modal.find('#confirmacion').text('Desea Guardar El Registro de Los Parametros?');
    }
    else
        {
            modal.find('.modal-body h5').text('Desea Guardar El Registro de Los Parametros?') //cambia texto en el body del modal
        }
})

$('#alerta').hide() ;

//CARGAR TABLA EDITAR REGISTRO DE PARAMETROS
// function CargarTablaEditar()
// {
//     var IdMaquina = $("#id_maquina").val();
//     var fecha = $("#fecha").val();
//     var hora = $("#hora").val();
//     $('#tabla_parametros>tbody').empty();

//     $.get(EditarRegistroParametros +'/'+IdMaquina+'/'+fecha+'/'+hora, function(data)
//     {
//         $.each(data, function(fetch, parametros) 
//         {
//             $('#observaciones').val(parametros[0].observaciones);

//             for (i = 0; i < parametros.length; i++) 
//             {
//                 $("#tabla_parametros>tbody").append("<tr>"
//                     +"<td id='id_registro_parametro' style='visibility:collapse; display:none;'>"+parametros[i].id_registro_parametro+"</td>"
//                     +"<td id='id_parametro' style='visibility:collapse; display:none;'>"+parametros[i].id_parametro+"</td>"
//                     +"<td id='nombre_parametro'>"+parametros[i].nombre_parametro+"</td>"
//                     +"<td id='hora'>"+parametros[i].hora+"</td>"
//                     +"<td id='valor' contenteditable='true'>"+parametros[i].valor+"</td>"
//                     +"</tr>");
//             }
//         });
//     });
// }