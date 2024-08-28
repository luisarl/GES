//Oculta o muestra los campos segun el tipo de conductor
function TipoEquipo() {
    var EquipoVehiculo = document.getElementById("EquipoVehiculo");
    var EquipoOtro = document.getElementById('EquipoOtro');
    var equipoInput = document.getElementById('equipo');
    var idVehiculoSelect = document.getElementById('id_vehiculo');

    if (EquipoVehiculo.checked) {
        $('#vehiculoSection').show();
        $('#otrosSection').hide();
        equipoInput.value = "";
    } else if (EquipoOtro.checked) {
        $('#vehiculoSection').hide();
        $('#otrosSection').show(); 
        idVehiculoSelect.value = '0'; // Establecer el valor del select id_vehiculo en 0
        
        // Asegurar que la opción seleccionada se actualice en el DOM
        $(idVehiculoSelect).val('0').trigger('change');
    }
}

TipoEquipo();

//Oculta o muestra los campos segun el tipo de conductor
function TipoResponsable() {
    var ResponsableInterno = document.getElementById("ChoferInterno");
    var ResponsableOtro = document.getElementById('ChoferForaneo');
    var responsable = document.getElementById('conductorinterno');

    if (ResponsableInterno.checked) {
        $('#ConductorInterno').show();
        $('#ConductorForaneo').hide();
    
    } else if (ResponsableOtro.checked) {
        $('#ConductorInterno').hide();
        $('#ConductorForaneo').show(); 
        responsable.value = '0'; // Establecer el valor del select id_vehiculo en 0
        
        // Asegurar que la opción seleccionada se actualice en el DOM
        $(responsable).val('0').trigger('change');
    }
}

TipoResponsable();

// Función para cargar la tabla de vehículos/equipos
function CargarTablaVehiculos() {
    var IdVehiculo = $("#id_vehiculo").val();
    var IdDepartamento = $("#departamento").val();
    var vehiculo = $("#id_vehiculo option:selected").text();
    var Equipo = $("#equipo").val();
    var departamentoText = $("#departamento option:selected").text();
    var ResponsableInterno= $("#conductorinterno").val();
    var ResponsableOtro= $("#conductorforaneo").val();
    var NombreResponsableInterno= $("#conductorinterno option:selected").text();
    var NombreResponsableOtro= $("#conductorforaneo").val();
    var TipoResponsable = $("input[name='tipo_chofer']:checked").val(); // Asegúrate de tener un input radio para tipo_chofer
    var cantidad = parseFloat($('#cantidad').val());
 
    var ListaVehiculos = CapturarDatosTablaVehiculos();

    if( ResponsableInterno == 0 &&ResponsableOtro.trim() == "")
    {
        alert('DEBE SELECCIONAR UN RESPONSABLE');
        return;  
    }
    // Verifica si el vehículo ya está en la tabla
    // Verifica si el vehículo ya está en la tabla antes de agregarlo
    var placaVehiculo = vehiculo.split(' - ')[0].trim().toUpperCase();
    var existingVehicle = $("#tablavehiculos tbody tr").find(`td:eq(2)`).filter(function() {
        return $(this).text().trim().toUpperCase() === placaVehiculo;
    });
    if (IdVehiculo != 0 && existingVehicle.length > 0) {
        alert('EL VEHÍCULO YA ESTÁ CARGADO');
        return;
    }

    // Verifica si el equipo ya está en la tabla
    if (Equipo && ListaVehiculos.some(v => v.equipo == Equipo)) {
        alert('EL EQUIPO YA ESTÁ CARGADO');
        return;
    }

    if (IdVehiculo == 0 && !Equipo) {
        alert('DEBE SELECCIONAR UN EQUIPO');
    } else if (IdDepartamento == 0) {
        alert('DEBE SELECCIONAR UN DEPARTAMENTO');
    } else if (isNaN(cantidad) || cantidad <= 0) {
        alert('LA CANTIDAD INGRESADA ES INVÁLIDA');
        $('#cantidad').val('');  // Reinicia y enfoca el campo de cantidad
        return;
    } else if (IdVehiculo != 0 && !Equipo) {
        $("#tablavehiculos>tbody").append(
            "<tr><td id='id_solicitud_despacho_detalle' style='visibility:collapse; display:none;'></td>"
            + "<td id='marca_vehiculo'>" + vehiculo.split(' - ')[1] + "</td>"
            + "<td id='placa_vehiculo'>" + vehiculo.split(' - ')[0] + "</td>"
            + "<td id='responsable'>"+ (TipoResponsable == 'INTERNO' ? NombreResponsableInterno : NombreResponsableOtro) +"</td>"
            + "<td id='departamento'>" + departamentoText + "</td>"
            + "<td id='cantidad'>" + cantidad + "</td>"
            + "<th><button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></th></tr>"
        );
    } else if (IdVehiculo == 0 && Equipo) {
        $("#tablavehiculos>tbody").append(
            "<tr><td id='id_solicitud_despacho_detalle' style='visibility:collapse; display:none;'></td>"
            + "<td id='marca_vehiculo'>" + Equipo + "</td>"
            + "<td id='placa_vehiculo'>" + "NO APLICA" + "</td>"
            + "<td id='responsable'>"+ (TipoResponsable == 'INTERNO' ? NombreResponsableInterno : NombreResponsableOtro) +"</td>"
            + "<td id='departamento'>" + departamentoText + "</td>"
            + "<td id='cantidad'>" + cantidad + "</td>"
            + "<th><button type='button' class='borrar btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></th></tr>"
        );
    }

    // Actualiza los datos después de agregar un nuevo vehículo o equipo
    CapturarDatosTablaVehiculos();

    // Actualiza el total
    ActualizarTotal();
}


// Función para capturar los datos de la tabla de vehículos/equipos
function CapturarDatosTablaVehiculos() {
    let lista_vehiculos = [];
    
    document.querySelectorAll('#tablavehiculos tbody tr').forEach(function(e) {
        let fila = {
            id_solicitud_despacho_detalle: e.querySelector('#id_solicitud_despacho_detalle').innerText,
            placa_vehiculo: e.querySelector('#placa_vehiculo').innerText,
            marca_vehiculo: e.querySelector('#marca_vehiculo').innerText,
            responsable: e.querySelector('#responsable').innerText,
            equipo: e.querySelector('#marca_vehiculo').innerText,
            departamento: e.querySelector('#departamento').innerText,
            cantidad: parseFloat(e.querySelector('#cantidad').innerText),
        };

        lista_vehiculos.push(fila);
    });

    console.log(JSON.stringify(lista_vehiculos));
    $('#vehiculos').val(JSON.stringify(lista_vehiculos));

    return lista_vehiculos;
}



function ActualizarTotal() {
    let total = 0;

    document.querySelectorAll('#tablavehiculos tbody tr').forEach(function(e) {
        let cantidadElement = e.querySelector('#cantidad');
        if (cantidadElement) {
            let cantidad = parseFloat(cantidadElement.innerText);
            if (!isNaN(cantidad)) {
                total += cantidad;
            }
        }
    });

    // Asigna el total al campo #total
    $('#total').val(total);

    
}

// Evento para eliminar una fila y actualizar el total
$(document).on('click', '.borrar', function() {
    $(this).closest('tr').remove();
    ActualizarTotal();
});

// Evento para actualizar el total y el requerido cuando cambie el valor del select
$('#id_combustible').on('change', function() {
    ActualizarTotal();
});

// Ejecuta la función para actualizar los valores inicialmente
ActualizarTotal();



