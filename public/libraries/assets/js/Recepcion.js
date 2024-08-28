function CapturarDatosTabla()
{
  let listado_herramientas = [];
    
  document.querySelectorAll('.listado_herramientas tbody tr').forEach(function(e)
  {
    let fila = 
    {
      recibir: e.querySelector('.recibir input[name="recibir"]').checked,
      id_detalle: e.querySelector('.id_detalle').innerText,
      id_herramienta: e.querySelector('.id_herramienta').innerText,
      id_empleado: e.querySelector('.id_empleado').innerText,
      responsable: e.querySelector('.responsable').innerText,
      cantidad_pendiente: e.querySelector('.cantidad_entregada').innerText,
      cantidad_devuelta: e.querySelector('.cantidad_devuelta').innerText,
      estatus: e.querySelector('.estatus').innerText,
      eventualidad: e.querySelector('.eventualidad').innerText
    };

    listado_herramientas.push(fila);
  });

  console.log(JSON.stringify(listado_herramientas));
  $('#datosrecepcion').val(JSON.stringify(listado_herramientas)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST
  //alert(datosrecepcion);
}

  function saveSnap(){
    var base64data = $("#captured_image_data").val();
     $.ajax({
            type: "POST",
            dataType: "json",
            url: './enviar',
            data: {image: base64data},
            success: function(data) { 
                alert(data);
            }
        });
        alert(base64data);
    console.log(base64data);
}


$("#todos").change(function () {
  $("input:checkbox").prop('checked', $(this).prop("checked"));
  var tabla = $('#tabla_recepcion>tbody>tr>td');
  if($(this).is(':checked'))
  {
    tabla.addClass('bloqueado');
  }
  else
    {
      tabla.removeClass('bloqueado');
    }
});

$('.recibido').on('click', function(){
  var row = $(this).closest('tr');
  if($(this).is(':checked'))
  {
      row.find('td').addClass('bloqueado');
  } 
  else 
      {
          row.find('td').removeClass('bloqueado');
      }
});

