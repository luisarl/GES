//LLENA EL SELECT SERVICIOS
function SelectServicios()
{
    var IdDepartamento = $('#departamento').val();
    var servicio = $('#servicio').val();
    $.get(RutaServicios +'/'+ IdDepartamento, function(data) {
        $.each(data, function(fetch, servicios) {
            console.log(data);
            for (i = 0; i < servicios.length; i++) 
            {                             
                $('#servicios').append('<option value="' + servicios[i].id_servicio + '"  ' 
                + (servicio == servicios[i].id_servicio ? "selected" : "") + ' >'
                + servicios[i].nombre_servicio+ '</option>');
            }
        })
    })
}

//LLENA EL SELECT SUBSERVICIOS
function SelectSubServicios()
{
    var IdServicio = $('#servicios').val() == null ? $('#servicio').val() : $('#servicios').val() ;
    var SubServicio = $('#subservicio').val();
    console.log(IdServicio);
    $.get(RutaSubServicios +'/'+ IdServicio, function(data) {
        $('#subservicios').empty();
        $.each(data, function(fetch, subservicios) {
            console.log(data);
            for (i = 0; i < subservicios.length; i++) {
                $('#subservicios').append('<option value="' + subservicios[i].id_subservicio + '"  ' 
                + (SubServicio == subservicios[i].id_subservicio ? "selected" : "") + ' >'
                + subservicios[i].nombre_subservicio+ '</option>');
            }
        })
    })
}

function AceptarSolicitud()
{
    var aceptar = document.getElementById('aceptar');
    var rechazar = document.getElementById('rechazar');

    if(aceptar.checked)
    {
        $('#comentario').hide();
    }
    else if(rechazar.checked)
        {
            $('#comentario').show();
        }
}

SelectServicios();
$('#departamentos').on('change', SelectServicios);
SelectSubServicios();
$('#servicios').on('change', SelectSubServicios);
AceptarSolicitud();