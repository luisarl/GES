//LENA EL SELECT DE SUBGRUPOS
function CargarSubgrupos() {
    //console.log(e);
    var IdGrupo = $('#_grupos').val();

    $.get('../../subgruposherramientas/' + IdGrupo, function(data) {
        var old = $('#_subgrupos').data('old') != '' ? $('#_subgrupos').data('old') : '';
        $('#_subgrupos').empty();
        $('#_subgrupos').append('<option value="0">Seleccione El Subgrupo</option>');

        $.each(data, function(fetch, subgrupos) {
            console.log(data);
            for (i = 0; i < subgrupos.length; i++) {
                $('#_subgrupos').append('<option value="' + subgrupos[i].id_subgrupo + '"   ' + (old ==
                        subgrupos[i].id_subgrupo ? "selected" : "") + ' >'+ subgrupos[i]
                    .codigo_subgrupo + ' - ' + subgrupos[i]
                    .nombre_subgrupo + '</option>');
            }
        })

    })
}

//LLENA EL SELECT ALMACENES
function CargarAlmacenesHerramientas() {

    //console.log(e);
    var IdEmpresa = $('#id_empresa').val();
    
    $.get('../../almacenesherramientas/' + IdEmpresa, function(data) {
        var old = $('#id_almacen').data('old') != '' ? $('#id_almacen').data('old') : '';
        $('#id_almacen').empty();
        $('#id_almacen').append('<option value="0">Seleccione Almacen</option>');
    
        $.each(data, function(fetch, almacenes) {
            console.log(data);
            for (i = 0; i < almacenes.length; i++) {
                $('#id_almacen').append('<option value="' + almacenes[i].id_almacen + '"   ' + (old ==
                    almacenes[i].id_almacen ? "selected" : "") + ' >'+ almacenes[i]
                    .id_almacen + ' - ' + almacenes[i]
                    .nombre_almacen + '</option>');
            }
        })
    
    })
}

function CargarUbicacion() {
    //console.log(e);
    var IdUbicacion = $('#id_almacen').val();

    $.get('../../ubicacionesHerramientas/' + IdUbicacion, function(data) {
        var old = $('#id_ubicacion').data('old') != '' ? $('#id_ubicacion').data('old') : '';
        $('#id_ubicacion').empty();
        $('#id_ubicacion').append('<option value="0">Seleccione La Ubicacion</option>');

        $.each(data, function(fetch, ubicaciones) {
            console.log(data);
            for (i = 0; i < ubicaciones.length; i++) {
                $('#id_ubicacion').append('<option value="' + ubicaciones[i].id_ubicacion + '"   ' + (old ==
                    ubicaciones[i].id_ubicacion ? "selected" : "") + ' >'+ ubicaciones[i]
                    .id_ubicacion + ' - ' + ubicaciones[i]
                    .nombre_ubicacion + '</option>');
            }
        })

    })
}

function CargarUbicacionTabla() {
    $('.id_ubicaciontabla').each(function() {
      var $fila = $(this).closest('tr');
      var idalmacenText = $fila.find("#id_almacen").text();
      var IdUbicacion = parseInt(idalmacenText);
  
      $.get('../../ubicacionesHerramientas/' + IdUbicacion, function(data) {
        var ubicaciones = data.ubicaciones;
        var $select = $fila.find('.id_ubicaciontabla');
        var old = $select.data('old'); // Guardar el valor seleccionado anteriormente
        $select.empty();
  
        for (var i = 0; i < ubicaciones.length; i++) {
          $select.append('<option value="' + ubicaciones[i].id_ubicacion + '">' + ubicaciones[i].id_ubicacion + ' - ' + ubicaciones[i].nombre_ubicacion + '</option>');
        }
  
        if (old) {
          $select.val(old); // Establecer el valor seleccionado anteriormente
        }
      });
    });
  }

//LLENA LA TABLA ADICIONALES CON LOS DATOS DE HERRAMIENTAS
// function CargarTabla()
// {
//     var empresas = $("#_empresas option:selected").text();
//     var almacenes = $("#_almacenes option:selected").text();
//     var ubicaciones = $("#_ubicaciones option:selected").text();
//     var stock = $('#stock').val();


//     if ($("#_empresas").val() == 0 || stock == 0 ) // valida que la Empresa y Almacen sean seleccionados
//     {
//         alert('Para Agregar Debe Seleccionar La Empresa e Ingresar El Stock');
//     }
//     else
//         {
//             $("#tabla_almacenes>tbody").append("<tr><td></td><td>"+empresas+"</td><td>"+almacenes+"</td><td>"+ubicaciones+"</td><td>"+stock+"</td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button> </th> </tr>");
//         }

// }

//LLENA LA TABLA ADICIONALES CON LOS DATOS DE HERRAMIENTAS
function CargarTabla() {
    var id_empresa = $("#id_empresa option:selected").text();
    var id_almacen = $("#id_almacen option:selected").text();
    var id_ubicacion = $("#id_ubicacion option:selected").text();
    var stock_inicial = $('#stock_inicial').val();
  
    var empresaExistente = false;
  
    // Verificar si ya existe una columna con el nombre de empresa
    $("#tabla_almacenes td.id_almacen").each(function() {
      if ($(this).text() === id_almacen) {
        empresaExistente = true;
        return false; // Salir del bucle each
      }
    });
  
    if ($("#id_empresa").val() == 0 || stock_inicial == 0) {
      alert('Para Agregar Debe Seleccionar La Empresa e Ingresar El Stock');
    } else if (empresaExistente) {
      alert('La empresa ya está cargada en la tabla');
    } else {
      var newSelectHtml = "<select name='id_ubicaciontabla' class='js-example-basic-single form-control id_ubicaciontabla' data-old='{{ old('id_ubicaciontabla') }}'> <option value='0'>" + id_ubicacion + "</option></select>";
      $("#tabla_almacenes>tbody").append("<tr><td></td><td class='empresa' id='id_empresa'>" + id_empresa + "</td><td id='id_almacen'>" + id_almacen + "</td><td id='id_ubicacion'>" + newSelectHtml + "</td> <td id='stock_inicial'>" + stock_inicial + "</td><td></td><th> <button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></th></tr>");
    }
  }

function CapturarDatosTabla()
{
    let listado_almacenes = [];
    document.querySelectorAll('#tabla_almacenes tbody tr').forEach(function(e){
        let fila = {
            id_empresa: e.querySelector('#id_empresa').innerText.split(' ')[0],
            id_almacen: e.querySelector('#id_almacen').innerText.split(' ')[0],
            id_ubicacion: $(e).find('option:selected').text().split(' - ')[0],
            stock_inicial: e.querySelector('#stock_inicial').innerText
        };
    listado_almacenes.push(fila);
    
    });
    console.log(JSON.stringify(listado_almacenes));
    $('#datosherramientas').val(JSON.stringify(listado_almacenes)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST
    //alert(datosherramientas);
}

//OBTENER DATOS DE LA TABLA ADICIONALES
// function CapturarDatosTabla()
// {
//     var tabla = document.getElementById("tabla_almacenes");
//     var filas = tabla.rows.length - 1 ; //obtiene el numero de filas de la tabla , menos el encabezado TH
//     var celda = document.getElementsByTagName("td"); //ingresa en la propiedad td de la tabla

//     var acumulador1 = 0;
//     var acumulador2 = 1;
//     var acumulador3 = 2;
//     var acumulador4 = 3;


//     var columnas = 4;
//     var arreglo = [];

//     for(var i = 0; i < filas; i++)
//     {
//         for(var j = 0; j < 1; j ++)
//         {
//             arreglo.push([
//                 celda[acumulador1].innerHTML.split(' ')[0], 
//                 celda[acumulador2].innerHTML.split(' ')[0],  
//                 celda[acumulador3].innerHTML.split(' ')[0], 
//                 celda[acumulador4].innerHTML.split(' ')[0]
//             ]);

//             acumulador1 = acumulador1 + columnas;
//             acumulador2 = acumulador2 + columnas;
//             acumulador3 = acumulador3 + columnas;
//             acumulador4 = acumulador4 + columnas;
//         }
//     }

//    alert(arreglo);
//     console.log(JSON.stringify(arreglo));
//     $('#datosherramientas').val(JSON.stringify(arreglo)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST 
    
// }


$(document).on('click', '.borrar', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
});

CargarSubgrupos();
$('#_grupos').on('change', CargarSubgrupos);

CargarAlmacenesHerramientas();
$('#id_empresa').on('change', CargarAlmacenesHerramientas);

CargarUbicacion();
$('#id_almacen').on('change', CargarUbicacion);

CargarUbicacionTabla();
// $('1').on('change', CargarUbicacionTabla);