$(document).ready(function()
{
  var labelEstatus = document.getElementById('estatus');
  var valorEstatus = labelEstatus.textContent;

    if (valorEstatus === "ACEPTADA" || valorEstatus === "EN PROCESO" || valorEstatus === "FINALIZADO")
    {
      tabla_orden_trabajo.style.display = "block";
    }
});

//LEER TODOS LOS DATOS
function CapturarDatosOT()
{
        
        let observaciones = [];
        document.querySelectorAll('#card_observaciones').forEach(function (e) {
            let fila = 
            {
                observaciones_ot: e.querySelector('#observaciones_ot').value,
            };
            observaciones.push(fila);
        });

        const DatosOrdenTrabajo =
        {
            fecha_inicio_ot: document.querySelector("#fecha_inicio_ot").value,
            fecha_fin_ot: document.querySelector("#fecha_fin_ot").value,
            observaciones,
        };

        console.log(JSON.stringify(DatosOrdenTrabajo));
        //alert(JSON.stringify(DatosOrdenTrabajo));
        $('#datos_orden_trabajo').val(JSON.stringify(DatosOrdenTrabajo));
        return DatosOrdenTrabajo;
}


$(document).on('click', '.borrar', function (event) 
{
    event.preventDefault();
    $(this).closest('tr').remove();
});

function pregunta() {
    if (confirm('¿Estas seguro de GUARDAR la ORDEN DE TRABAJO?'))
    {
      document.getElementById('FormOrdenTrabajo').submit();
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('enviar').addEventListener('click', function(e) {
      e.preventDefault();
      pregunta()
    });
  });