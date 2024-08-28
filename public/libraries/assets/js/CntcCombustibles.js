"use strict";
//Oculta o muestra los campos segun el tipo de conductor
function TipoFiltro() {
    var EquipoVehiculo = document.getElementById("DEPARTAMENTO");
    var EquipoOtro = document.getElementById('VEHICULO');
  
    if (EquipoVehiculo.checked) {
        $('#departamentoSection').show();
        $('#VehiculoSection').hide();
        $('#Imprimirdepartamento').show();
        $('#Imprimirvehiculo').hide();
    } else if (EquipoOtro.checked) {
        $('#departamentoSection').hide();
        $('#VehiculoSection').show(); 
        $('#Imprimirdepartamento').hide();
        $('#Imprimirvehiculo').show();
        
    }
}

TipoFiltro();


$(document).ready(function () {

      //Donut chart Empleados
      google.charts.load("current", { packages: ["corechart"] });
      google.charts.setOnLoadCallback(GraficoDonutCombustible);
  
      function GraficoDonutCombustible() 
      {
          var dataRows = [['Combustible', 'Por Tipo']];
          for (var i = 0; i < combustible.length; i++) 
          {
              dataRows.push([combustible[i].descripcion_combustible, parseFloat(combustible[i].stock)]);
          }
  
          var dataDonut = google.visualization.arrayToDataTable(dataRows);
  
          var optionsDonut = {
              title: 'Combustible por Tipo',
              pieHole: 0.4,
              colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
          };
  
          var chart = new google.visualization.PieChart(document.getElementById('grafico_combustible'));
          chart.draw(dataDonut, optionsDonut);
      }

//GRAFICA DESPACHOS POR GERENCIAS
      google.charts.load('current', { 'packages': ['corechart'] });
      google.charts.setOnLoadCallback(function() {
        GraficoBarDepartamentos(year);
    });
      
      function GraficoBarDepartamentos(year) {
          var tabla = document.getElementById('tabla_datos');
          var filas = tabla.getElementsByTagName('tr');
      
          // Inicializar un objeto para almacenar la cantidad de combustible por departamento
          var dataDepartamentos = {};
      
          // Colores para los departamentos
          var colores = ['#4680ff', '#ff5252', '#ff9800', '#4caf50', '#9c27b0', '#795548', '#607d8b', '#e91e63', '#03a9f4', '#8bc34a'];
      
          // Recorrer las filas de la tabla (omitir la primera fila de encabezados y la última de totales)
          for (var i = 1; i < filas.length - 1; i++) {
              var celdas = filas[i].getElementsByTagName('td');
              var departamento = celdas[0].innerText;
      
              // Si el departamento no está en el objeto, inicializarlo con cantidad cero
              if (!dataDepartamentos.hasOwnProperty(departamento)) {
                  dataDepartamentos[departamento] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
              }
      
              // Actualizar la cantidad para cada mes
              for (var j = 1; j < celdas.length; j++) {
                  var cantidad = parseFloat(celdas[j].innerText);
                  dataDepartamentos[departamento][j - 1] += cantidad;
              }
          }
      
          // Crear un array con los datos de cada mes
          var dataRows = [['Meses'].concat(Object.keys(dataDepartamentos))];
          for (var i = 0; i < 12; i++) {
              var row = [getMes(i)].concat(Object.values(dataDepartamentos).map(function(val) { return val[i]; }));
              dataRows.push(row);
          }
      
          // Crear el DataTable a partir de dataRows
          var data = google.visualization.arrayToDataTable(dataRows);
      
          // Opciones del gráfico
          var options = {
            title: 'GRAFICA DESPACHOS POR GERENCIAS - ' + year,
            titleTextStyle: {
                fontSize: 16,
                bold: true,
                italic: false,
                color: '#333', // Color del texto del título
                auraColor: 'transparent', // Color de la sombra del texto
                position: 'center' // Alineación del texto (centrado)
            },
            hAxis: { slantedText: true },
            legend: { position: 'right', textStyle: { fontSize: 12 } },
            colors: colores.slice(0, Object.keys(dataDepartamentos).length),
            bar: { groupWidth: '150%' }
        };
      
          // Dibujar el gráfico
          var chart = new google.visualization.ColumnChart(document.getElementById('grafico_departamentos_detalle'));
          chart.draw(data, options);
      }
      
      // Función auxiliar para obtener el nombre del mes dado su número (0-11)
      function getMes(numeroMes) {
          var meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
          return meses[numeroMes];
      }

//GRAFICA DESPACHOS POR EQUIPOS
      google.charts.load('current', { 'packages': ['corechart'] });
      google.charts.setOnLoadCallback(GraficoBarEquipos);
      google.charts.setOnLoadCallback(function() {
        GraficoBarEquipos(year);
    });
      
      function GraficoBarEquipos(year) {
          var tabla = document.getElementById('tabla_equipos');
          var filas = tabla.getElementsByTagName('tr');
      
          // Inicializar un objeto para almacenar la cantidad de combustible por departamento
          var dataDepartamentos = {};
      
          // Colores para los departamentos
          var colores = ['#4680ff', '#ff5252', '#ff9800', '#4caf50', '#9c27b0', '#795548', '#607d8b', '#e91e63', '#03a9f4', '#8bc34a'];
      
          // Recorrer las filas de la tabla (omitir la primera fila de encabezados y la última de totales)
          for (var i = 1; i < filas.length - 1; i++) {
              var celdas = filas[i].getElementsByTagName('td');
              var departamento = celdas[0].innerText;
      
              // Si el departamento no está en el objeto, inicializarlo con cantidad cero
              if (!dataDepartamentos.hasOwnProperty(departamento)) {
                  dataDepartamentos[departamento] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
              }
      
              // Actualizar la cantidad para cada mes
              for (var j = 2; j < celdas.length; j++) {
                  var cantidad = parseFloat(celdas[j].innerText);
                  dataDepartamentos[departamento][j - 2] += cantidad;
              }
          }
      
          // Crear un array con los datos de cada mes
          var dataRows = [['Meses'].concat(Object.keys(dataDepartamentos))];
          for (var i = 0; i < 12; i++) {
              var row = [getMes(i)].concat(Object.values(dataDepartamentos).map(function(val) { return val[i]; }));
              dataRows.push(row);
          }
      
          // Crear el DataTable a partir de dataRows
          var data = google.visualization.arrayToDataTable(dataRows);
      
          // Opciones del gráfico
          var options = {
            title: 'GRAFICA DESPACHOS POR EQUIPOS - ' + year,
            titleTextStyle: {
                fontSize: 16,
                bold: true,
                italic: false,
                color: '#333', // Color del texto del título
                auraColor: 'transparent', // Color de la sombra del texto
                position: 'center' // Alineación del texto (centrado)
            },
            hAxis: { slantedText: true },
            legend: { position: 'right', textStyle: { fontSize: 12 } },
            colors: colores.slice(0, Object.keys(dataDepartamentos).length),
            bar: { groupWidth: '150%' }
        };
      
          // Dibujar el gráfico
          var chart = new google.visualization.ColumnChart(document.getElementById('grafico_equipos_detalle'));
          chart.draw(data, options);
      }
      
      // Función auxiliar para obtener el nombre del mes dado su número (0-11)
      function getMes(numeroMes) {
          var meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
          return meses[numeroMes];
      }

// GRAFICA INGRESOS POR DEPARTAMENTOS

      google.charts.load('current', { 'packages': ['corechart'] });
      google.charts.setOnLoadCallback(function() {
        GraficoBarIngresos(year);
    });
      
      function GraficoBarIngresos(year) {
          var tabla = document.getElementById('tabla_ingresos');
          var filas = tabla.getElementsByTagName('tr');
      
          // Inicializar un objeto para almacenar la cantidad de combustible por departamento
          var dataDepartamentos = {};
      
          // Colores para los departamentos
          var colores = ['#4680ff', '#ff5252', '#ff9800', '#4caf50', '#9c27b0', '#795548', '#607d8b', '#e91e63', '#03a9f4', '#8bc34a'];
      
          // Recorrer las filas de la tabla (omitir la primera fila de encabezados y la última de totales)
          for (var i = 1; i < filas.length - 1; i++) {
              var celdas = filas[i].getElementsByTagName('td');
              var departamento = celdas[0].innerText;
      
              // Si el departamento no está en el objeto, inicializarlo con cantidad cero
              if (!dataDepartamentos.hasOwnProperty(departamento)) {
                  dataDepartamentos[departamento] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
              }
      
              // Actualizar la cantidad para cada mes
              for (var j = 1; j < celdas.length; j++) {
                  var cantidad = parseFloat(celdas[j].innerText);
                  dataDepartamentos[departamento][j - 1] += cantidad;
              }
          }
      
          // Crear un array con los datos de cada mes
          var dataRows = [['Meses'].concat(Object.keys(dataDepartamentos))];
          for (var i = 0; i < 12; i++) {
              var row = [getMes(i)].concat(Object.values(dataDepartamentos).map(function(val) { return val[i]; }));
              dataRows.push(row);
          }
      
          // Crear el DataTable a partir de dataRows
          var data = google.visualization.arrayToDataTable(dataRows);
      
          // Opciones del gráfico
          var options = {
                title: 'GRAFICA INGRESOS POR GERENCIAS - ' + year,
                titleTextStyle: {
                    fontSize: 16,
                    bold: true,
                    italic: false,
                    color: '#333', // Color del texto del título
                    auraColor: 'transparent', // Color de la sombra del texto
                    position: 'center' // Alineación del texto (centrado)
                },
              hAxis: { slantedText: true }, // Mostrar etiquetas del eje x en horizontal
              legend: { position: 'right', textStyle: { fontSize: 12 } }, // Colocar la leyenda a la derecha y ajustar el tamaño de fuente
              colors: colores.slice(0, Object.keys(dataDepartamentos).length),  // Usar los primeros colores según la cantidad de departamentos
              bar: { groupWidth: '150%' } // Ajustar el ancho de las barras
            
          };
          // Dibujar el gráfico
          var chart = new google.visualization.ColumnChart(document.getElementById('grafico_ingresos'));
          chart.draw(data, options);
      }
      
      // Función auxiliar para obtener el nombre del mes dado su número (0-11)
      function getMes(numeroMes) {
          var meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
          return meses[numeroMes];
      }

});

