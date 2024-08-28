//CAPTURAR LOS DATOS DE LA TABLA
function CapturarDatosTabla1() {
    let lista_asistencia = [];
    
    document.querySelectorAll('#datatable tbody tr').forEach(function(e) {
        let nombreCompleto = e.querySelector('#nombre_empleado').innerText.split('\n')[0].trim();
        var estatus= e.querySelector('#estatus').innerText;

        if(estatus == '')
        {
            let fila = {
                id_biometrico: e.querySelector('#id_biometrico').innerText,
                id_empleado: e.querySelector('#id_empleado').innerText,
                id_departamento: e.querySelector('#id_departamento').innerText,
                id_empresa: e.querySelector('#id_empresa').innerText,
                nombre_empresa: e.querySelector('#nombre_empresa').innerText,
                nombre_empleado: nombreCompleto,
                hora_entrada: e.querySelector('#hora_entrada input[type="time"]').value,
                hora_salida: e.querySelector('#hora_salida input[type="time"]').value,
                id_novedad: [],
                fecha_validacion: e.querySelector('#fecha_validacion').innerText,
                observacion: e.querySelector('#observacion textarea[name="observacion"]').value,
                estatus: e.querySelector('#estatus').innerText,
            };

            e.querySelectorAll('#id_novedad option:checked').forEach(function(option) {
                fila.id_novedad.push(option.value);
            });
            
            lista_asistencia.push(fila);
        }

        
    });

    console.log(JSON.stringify(lista_asistencia));
    //alert(lista_articulos);
    $('#validaciones').val(JSON.stringify(lista_asistencia)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST
    return lista_asistencia;
}

function CapturarDatosTabla2()
{
    let lista_validaciones = [];
    
    document.querySelectorAll('#datatable tbody tr').forEach(function(e)
    {

        let horaEntrada = e.querySelector('#hora_entrada input[type="time"]').value;
        if (horaEntrada === '') {
            horaEntrada = '00:00:00';
        }
        let horaSalida = e.querySelector('#hora_salida input[type="time"]').value;
        if (horaSalida === '') {
            horaSalida = '00:00:00';
        }
        
        let fila = {
            id_biometrico: e.querySelector('#id_biometrico').innerText,
            id_validacion: e.querySelector('#id_validacion').innerText,
            fecha_validacion: e.querySelector('#fecha_validacion').innerText,
            hora_entrada: horaEntrada,
            hora_salida: horaSalida,
            id_novedad: [],
            observacion: e.querySelector('#observacion textarea[name="observacion"]').value,
        };
        e.querySelectorAll('#id_novedad option:checked').forEach(function(option) {
            fila.id_novedad.push(option.value);
        });

        lista_validaciones.push(fila);
    });

    console.log(JSON.stringify(lista_validaciones));
    //alert(lista_articulos);
    $('#validaciones').val(JSON.stringify(lista_validaciones)); //PASA DATOS DE LA TABLA A CAMPO OCULTO APRA ENVIAR POR POST
    return lista_validaciones;
}

// FUNCIONES PARA VALIDAR INDIVIDUAL



document.addEventListener('DOMContentLoaded', function() {
    // Obtener todos los botones "Validar" de la tabla
    let botonesValidar = document.querySelectorAll('#tabla_asistencias tbody tr button[name="validar"]');

    // Agregar un evento de clic a cada botón "Validar"
    botonesValidar.forEach(function(boton) {
            boton.addEventListener('click', function() {
                    // Obtener la fila padre del botón clickeado
                    let fila = boton.closest('tr');
                    CapturarDatosTabla(fila);
            });
    });
});

function CapturarDatosTabla11(fila) {
    let lista_asistencia = [];

    let idBiometrico = fila.querySelector('#id_biometrico').innerText;
    let idEmpleado = fila.querySelector('#id_empleado').innerText;
    let idDepartamento = fila.querySelector('#id_departamento').innerText;
    let idEmpresa = fila.querySelector('#id_empresa').innerText;
    let nombreEmpresa = fila.querySelector('#nombre_empresa').innerText;
    let nombreEmpleado = fila.querySelector('#nombre_empleado').innerText;
    let idNovedad = fila.querySelector('#id_novedad select[name="id_novedad"]').value;
    let fechaValidacion = fila.querySelector('#fecha_validacion').innerText;
    let horaEntrada = fila.querySelector('#hora_entrada').innerText; 
    let horaSalida = fila.querySelector('#hora_salida').innerText; 
    let observacion = fila.querySelector('#observacion textarea[name="observacion"]').value;
   

    let filaObj = {
        id_biometrico: idBiometrico,
        id_empleado: idEmpleado,
        id_empresa: idEmpresa,
        nombre_empresa: nombreEmpresa,
        id_departamento: idDepartamento,
        nombre_empleado: nombreEmpleado,
        fecha_validacion: fechaValidacion,
        hora_entrada: horaEntrada,
        hora_salida: horaSalida,
        id_novedad: idNovedad,
        observacion: observacion
    };

    lista_asistencia.push(filaObj);

    console.log(JSON.stringify(lista_asistencia));
    $('#validaciones').val(JSON.stringify(lista_asistencia)); // PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST
    return lista_asistencia;
}

document.addEventListener('DOMContentLoaded', function() {
    // Obtener todos los botones "Validar" de la tabla
    let botonesValidar = document.querySelectorAll('#tabla_validaciones tbody tr button[name="validar"]');

    // Agregar un evento de clic a cada botón "Validar"
    botonesValidar.forEach(function(boton) {
            boton.addEventListener('click', function() {
                    // Obtener la fila padre del botón clickeado
                    let fila = boton.closest('tr');
                    CapturarDatosTabla2(fila);
            });
    });
});

function CapturarDatosTabla12(fila) {
    let lista_validaciones = [];

    let idValidacion = fila.querySelector('#id_validacion').innerText;
    let idNovedad = fila.querySelector('#id_novedad select[name="id_novedad"]').value;
    let observacion = fila.querySelector('#observacion textarea[name="observacion"]').value;
   

    let filaObj = {
        id_validacion: idValidacion,
        id_novedad: idNovedad,
        observacion: observacion
    };

    lista_validaciones.push(filaObj);

    console.log(JSON.stringify(lista_validaciones));
    $('#validaciones').val(JSON.stringify(lista_validaciones)); // PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST
    return lista_validaciones;
}