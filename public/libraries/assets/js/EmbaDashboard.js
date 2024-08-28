$(document).ready(function() {

    //GRAFICO CON TODOS LOS PARAMETROS
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(GraficoParametros);

    function GraficoParametros() 
    {
        var data = new google.visualization.DataTable();

        data.addColumn('string', 'Horas');
        for (var i = 0; i < columnas.length; i++) 
        {
            data.addColumn('number', columnas[i].nombre_parametro);
        }

        data.addRows(ArregloRegistros);

        var options = {
            pointSize: 4,
            hAxis: {title: 'Horas'},
            vAxis: {title: 'Valor'}
        };

      var chart = new google.visualization.LineChart(document.getElementById('grafico_parametros'));

      chart.draw(data, options);
    }

    //GRAFICO CON PARAMETRO INDIVIDUAL
    google.charts.setOnLoadCallback(GraficoParametro);

    function GraficoParametro() 
    {
        var dataRows = [['Horas', columnas]];

        for (var i = 0; i < registros.length; i++) 
        {
            dataRows.push([registros[i].hora.split(':')[0], parseFloat(registros[i].valor)]);
        }

        var data = google.visualization.arrayToDataTable(dataRows);

        var options = {
            pointSize: 4,
            hAxis: {title: 'Horas'},
            vAxis: {title: 'Valor'}
        };

      var chart = new google.visualization.LineChart(document.getElementById('grafico_parametro'));

      chart.draw(data, options);
    }

});

//LLENA EL SELECT SUBSERVICIOS
function SelectParametros() 
{
    var IdMaquina = $('#id_maquina').val() == 0 ? $('#id_maquina').data('old') : $('#id_maquina').val() ;
    $.get('embamaquinaparametros/'+ IdMaquina, function(data) {
        var old = $('#id_parametro').data('old') != '' ? $('#id_parametro').data('old') : '';
        $('#id_parametro').empty();
        $('#id_parametro').append('<option value="0">TODOS</option>');

        $.each(data, function(fetch, parametros) {
            for (i = 0; i < parametros.length; i++) {
                $('#id_parametro').append('<option value="' + parametros[i].id_parametro + '"   ' + (old ==
                parametros[i].id_parametro ? "selected" : "") + ' >'+ parametros[i].nombre_parametro+ '</option>');
            }
        })
    })
}

SelectParametros();
$('#id_maquina').on('change', SelectParametros);

