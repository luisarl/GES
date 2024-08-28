function CapturarDatosTabla2()
{
        let parametros = [];

        $('#tabla_registros tbody tr').each(function() 
        {
            let fila = {
                id_tabla_consumo: $(this).find('#id_tabla_consumo').text(),
                valor_espesor: $(this).find('#valor_espesor').text(),
                valor_registro: $(this).find('td input#valor_registro').val()
            };

            parametros.push(fila);
        });

        $('#parametros').val(JSON.stringify(parametros)); //PASA DATOS DE LA TABLA A CAMPO OCULTO PARA ENVIAR POR POST

    return parametros;
}