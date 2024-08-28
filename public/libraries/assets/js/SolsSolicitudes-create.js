//LLENA EL SELECT SERVICIOS
function SelectServicios() 
{
    var IdDepartamento = $('#departamentos').val();
    
    $.get(RutaServicios +'/'+ IdDepartamento, function(data) {
        var old = $('#servicios').data('old') != '' ? $('#servicios').data('old') : '';
        $('#servicios').empty();
        $('#servicios').append('<option value="0">Seleccione El Servicio</option>');
    
        $.each(data, function(fetch, servicios) {
            console.log(data);
            for (i = 0; i < servicios.length; i++) {
                $('#servicios').append('<option value="' + servicios[i].id_servicio + '"   ' + (old ==
                    servicios[i].id_servicio ? "selected" : "") + ' >'+ servicios[i].nombre_servicio+ '</option>');
            }
        })
    })

    if(IdDepartamento == 9) //DEPARTAMENTO LOGISTICA Y OPERACIONES
    {
        $('#LogisticaTitulo').show();
        $('#LogisticaFormulario').show();
    }
    else
        {
            $('#LogisticaTitulo').hide();
            $('#LogisticaFormulario').hide();
        }

    if(IdDepartamento == 10) //DEPARTAMENTO MANTENIMIENTO MECANICO
    {
        $('#MantenimientoTitulo').show();
        $('#MantenimientoFormulario').show();
        $('#mantenimiento_emb_tipo_equipo').attr('disabled', 'disabled')
        $('#mantenimiento_emb_nombre_equipo').attr('disabled', 'disabled')
    }
    else
        {
            $('#MantenimientoTitulo').hide();
            $('#MantenimientoFormulario').hide();
        }    

    if(IdDepartamento == 22) //DEPARTAMENTO MANTENIMIENTO EMBARCACIONES
    {
        $('#MantenimientoEmbarcacionesTitulo').show();
        $('#MantenimientoEmbarcacionesFormulario').show();
        $('#mantenimiento_emb_tipo_equipo').removeAttr('disabled')
        $('#mantenimiento_emb_nombre_equipo').removeAttr('disabled')
    }
    else
        {
            $('#MantenimientoEmbarcacionesTitulo').hide();
            $('#MantenimientoEmbarcacionesFormulario').hide();
        }  
}

//LLENA EL SELECT SUBSERVICIOS
function SelectSubServicios() 
{
    var IdServicio = $('#servicios').val() == 0 ? $('#servicios').data('old') : $('#servicios').val() ;
    console.log(IdServicio);
    $.get(RutaSubServicios +'/'+ IdServicio, function(data) {
        var old = $('#subservicios').data('old') != '' ? $('#subservicios').data('old') : '';
        $('#subservicios').empty();
        $('#subservicios').append('<option value="0">Seleccione El SubServicio</option>');

        $.each(data, function(fetch, subservicios) {
            console.log(data);
            for (i = 0; i < subservicios.length; i++) {
                $('#subservicios').append('<option value="' + subservicios[i].id_subservicio + '"   ' + (old ==
                    subservicios[i].id_subservicio ? "selected" : "") + ' >'+ subservicios[i].nombre_subservicio+ '</option>');
            }
        })
    })
}

SelectServicios();
$('#departamentos').on('change', SelectServicios);
SelectSubServicios();
$('#servicios').on('change', SelectSubServicios);