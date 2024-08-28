// Función para capturar los datos de la tabla de vehículos/equipos
function CapturarDatosTablaVehiculos() {
    let combustible = document.getElementById('stock').value;
    let lista_vehiculos = [];
    
    document.querySelectorAll('#tablaequipos tbody tr').forEach(function(e) {
        // Verifica si el checkbox en la fila actual está seleccionado
        let checkbox = e.querySelector('input[type="checkbox"][name="seleccionar[]"]');
        if (checkbox && checkbox.checked) {
            let fila = {
                id_solicitud_despacho_detalle: e.querySelector('#id_solicitud_despacho_detalle').innerText,
                placa_vehiculo: e.querySelector('#placa_vehiculo').innerText,
                marca_vehiculo: e.querySelector('#marca_vehiculo').innerText,
                responsable: e.querySelector('#responsable').innerText,
                equipo: e.querySelector('#marca_vehiculo').innerText,
                departamento: e.querySelector('#departamento').innerText,
                cantidad: parseFloat(e.querySelector('#cantidad').innerText),
                cantidad_despachada: parseFloat(e.querySelector('input[name="cd"]').value), // Cambiar innerText a value
                fecha_despacho: e.querySelector('input[name="fecha_despacho"]').value, // Usar .value para inputs
                combustible: combustible,
            };

            lista_vehiculos.push(fila);
        }
    });

    console.log(JSON.stringify(lista_vehiculos));
    $('#vehiculos').val(JSON.stringify(lista_vehiculos));
    CapturarTotal();
    return lista_vehiculos;
    
}

function CapturarTotal() {

    
    let lista_totales = [];
   
    // Obtener el valor del input con id "total"
    let total = document.getElementById('stock').value;
    let despachado=  document.getElementById('despachado').value;
    let total_despachado=  document.getElementById('totaldespachado').value;
    // Convertir el valor a un número si es necesario
  
    let  nuevostock = total - despachado;
    // Agregar ambos valores al array
    lista_totales.push({ despachado: despachado, stock_final: nuevostock , totaldespachado:total_despachado});
   
  
    console.log(JSON.stringify(lista_totales));
   $('#totales').val(JSON.stringify(lista_totales));
  }



function ActualizarTotal() {
    let total = 0;
    let total_despachado= 0;
    document.querySelectorAll('#tablaequipos tbody tr').forEach(function(e) {
        let checkbox = e.querySelector('input[name="seleccionar[]"]');
        if (checkbox && checkbox.checked) {
            let cantidadElement = e.querySelector('input[name="cd"]');
            if (cantidadElement) {
                let cantidad = parseFloat(cantidadElement.value);
                if (!isNaN(cantidad)) {
                    total += cantidad;
                }
            }
        }

        let despachadoelementos = e.querySelector('input[name="cd"]');
            if (despachadoelementos) {
                let despachadototal = parseFloat(despachadoelementos.value);
                if (!isNaN(despachadototal)) {
                    total_despachado += despachadototal;
                }
            }


    });

    // Asigna el total al campo #despachado y total despachado
    document.getElementById('despachado').value = total;
    document.getElementById('totaldespachado').value = total_despachado;
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


