//LENA EL SELECT DE HERRAMIENTAS    
function CargarHerramientas() {

    var IdAlmacen= $('#_almacenes').val();

    $.get(HerramientasAlmacen+'/'+IdAlmacen, function(data) 
    {
        var old = $('#_herramientas').data('old') != '' ? $('#_herramientas').data('old') : '';
        $('#_herramientas').empty();
        $('#_herramientas').append('<option value="0">Seleccione la Herramienta</option>');

        $.each(data, function(fetch, herramientas) {
            console.log(data);
            for (i = 0; i < herramientas.length; i++) {
                $('#_herramientas').append('<option value="' + herramientas[i].stock_actual + '"   ' + (old ==
                    herramientas[i].id_herramienta ? "selected" : "") + ' >'+ 
                    herramientas[i].id_herramienta 
                    + ' | ' + 
                    herramientas[i].nombre_herramienta 
                     + '</option>');
            }
        })
    })
}

//LENA EL SELECT DE PLANTILLAS    
function CargarPlantillas() {

    var IdAlmacen= $('#_almacenes').val();

    $.get(PlantillasAlmacen+'/' + IdAlmacen, function(data) 
    {
        var old = $('#_plantillas').data('old') != '' ? $('#_plantillas').data('old') : '';
        $('#_plantillas').empty();
        $('#_plantillas').append('<option value="0">Seleccione la Plantilla</option>');

        $.each(data, function(fetch, plantillas) {
            console.log(data);
            for (i = 0; i < plantillas.length; i++) {
                $('#_plantillas').append('<option value="' + plantillas[i].id_plantilla + '"   ' + (old ==
                    plantillas[i].id_plantilla ? "selected" : "") + ' >'+ 
                    plantillas[i].nombre_plantilla
                     + '</option>');
            }
        })

    })
}

//LLENA LA TABLA CON LOS DATOS DE LA HERRAMIENTA SELECCIONADA
function CargarTabla()
{
    var herramienta = $("#_herramientas option:selected").text();
    var cantidad = $('#cantidad_entregada').val();
    let stock = document.getElementById("_herramientas").value;
    var IdPlantilla= $('#_plantillas').val();

    var CargarHerramienta = document.getElementById('herramienta');
    var CargarPlantilla = document.getElementById('plantilla');
    
    if(CargarPlantilla.checked)
    {
        $.get(HerramientasPlantilla+'/' + IdPlantilla, function(data) 
        {
            $.each(data, function(fetch, herramientas) {
                console.log(data);
                for (i = 0; i < herramientas.length; i++) 
                {
                    if(parseFloat(herramientas[i].cantidad) > parseFloat(herramientas[i].stock_actual) )
                    {
                        $('#error').show() ;
                        $("#error>#mensaje").append(herramientas[i].nombre_herramienta+' | CANTIDAD: '+herramientas[i].cantidad+' | STOCK: '+herramientas[i].stock_actual +'<br>');       
                    }
                    else
                        {
                            $("#tabla_despacho>tbody").append("<tr><td id='id_herramienta'>"+herramientas[i].id_herramienta+"</td><td id='nombre_herramienta'>"+herramientas[i].nombre_herramienta+"</td><td id='cantidad'>"+herramientas[i].cantidad+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
                        }
                }
            })
        })
    }
    else if(CargarHerramienta.checked)
        {
            var lista_herramientas = CapturarDatosTabla(); //captura los datos de la  tabla
  
            if(parseFloat(cantidad) > parseFloat(stock) || cantidad <= 0) //valida si la cantidad ingresada es mayor al stock o menor a cero
            {
                alert('LA CANTIDAD INGRESADA ES INVALIDA');
                $('#cantidad_entregada').val('');
            }
            else 
                {
                    for (i = 0; i < lista_herramientas.length; i++) // si tiene datos la tabla de herramientas
                    {
                        // verifica si la herramienta seleccionada fue cargada
                        if(lista_herramientas[i].id_herramienta == herramienta.split(' | ')[0] ) 
                        {
                            //si la herramienta esta cargada muestra el mensaje y sale de la funcion
                            alert('LA HERRAMIENTA YA ESTA CARGADA');
                            return; 
                        }
                    }
                    // si la herramienta no esta cargada la agrega a la tabla
                    $("#tabla_despacho>tbody").append("<tr><td id='id_herramienta'>"+herramienta.split('|')[0]+"</td><td id='nombre_herramienta'>"+herramienta.split('|')[1]+"</td><td id='cantidad'>"+cantidad+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th></tr>");
                    $('#_herramientas').val(0);
                    $('#cantidad_entregada').val('');
                    $('#existencia').val('');

                }
        }
}

//OBTENER DATOS DE LA TABLA 
function CapturarDatosTabla()
{
    let listado_herramientas = [];
    
    document.querySelectorAll('#tabla_despacho tbody tr').forEach(function(e){
        let fila = {
            id_herramienta: e.querySelector('#id_herramienta').innerText,
            nombre_herramienta: e.querySelector('#nombre_herramienta').innerText,
            cantidad: e.querySelector('#cantidad').innerText,
        };

    listado_herramientas.push(fila);
    });

    $('#datosdespacho').val(JSON.stringify(listado_herramientas)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST
    return listado_herramientas;
}

$(document).on('click', '.borrar', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});

//Captura el Stock de la herramienta
function StockHerramienta()
{
    let stock = document.getElementById("_herramientas").value;
    document.getElementById("existencia").value = stock;

    $("#cantidad_entregada").attr("max", stock);
    $("#cantidad_entregada").val('');
}
      
function saveSnap(){
      var base64data = $("#captured_image_data").val();
       $.ajax({
              type: "POST",
              dataType: "json",
              url: './store',
              data: {image: base64data},
              success: function(data) { 
                  alert(data);
              }
          });
          console.log(base64data);
}

//Oculta o muestra los campos segun de carga de herramienta
function TipoCargaHerramientas()
{
    var CargarHerramienta = document.getElementById('herramienta');
    var CargarPlantilla = document.getElementById('plantilla');

    if(CargarHerramienta.checked )
    {
        $('#herramientas').show() ;
        $('#existenciaherramientas').show() ;
        $('#cantidadherramientas').show() ;
        $('#plantillas').hide();

    }
     else if(CargarPlantilla.checked)
            {
                $('#herramientas').hide() ;
                $('#existenciaherramientas').hide() ;
                $('#cantidadherramientas').hide() ;
                $('#plantillas').show();
            }
}

$('#error').hide() ;
CargarHerramientas();
CargarPlantillas();
TipoCargaHerramientas();
$('#_almacenes').on('change', CargarHerramientas);
$('#_almacenes').on('change', CargarPlantillas);