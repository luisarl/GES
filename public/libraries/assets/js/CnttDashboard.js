$(document).ready(function () {

    //Donut chart Cambios
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutReeemplazos);

    function GraficoDonutReeemplazos() 
    {
        var dataRows = [['Reemplazo', 'Por Departamento']];
        for (var i = 0; i < reemplazos.length; i++) 
        {
            dataRows.push([reemplazos[i].nombre_departamento, parseFloat(reemplazos[i].cantidad)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Reemplazo por Departamentos',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_reemplazos'));
        chart.draw(dataDonut, optionsDonut);
    }

      //Donut chart promedio de hojas
      google.charts.load("current", { packages: ["corechart"] });
      google.charts.setOnLoadCallback(GraficoDonutPromedios);
  
      function GraficoDonutPromedios() 
      {
          var dataRows = [['Promedio de hojas', 'Por Departamento']];
          for (var i = 0; i < promedio.length; i++) 
          {
              dataRows.push([promedio[i].nombre_departamento, parseFloat(promedio[i].promedio)]);
          }
  
          var dataDonut = google.visualization.arrayToDataTable(dataRows);
  
          var optionsDonut = {
              title: 'Promedio de hojas por Departamentos',
              pieHole: 0.4,
              colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
          };
  
          var chart = new google.visualization.PieChart(document.getElementById('grafico_promedios'));
          chart.draw(dataDonut, optionsDonut);
      }

      //Donut chart promedio de hojas
      google.charts.load("current", { packages: ["corechart"] });
      google.charts.setOnLoadCallback(GraficoDonutDiasPromedios);
  
      function GraficoDonutDiasPromedios() 
      {
          var dataRows = [['Promedio de Dias', 'Por Departamento']];
          for (var i = 0; i < diaspromedio.length; i++) 
          {
              dataRows.push([diaspromedio[i].nombre_departamento, parseFloat(promedio[i].diaspromedio)]);
          }
  
          var dataDonut = google.visualization.arrayToDataTable(dataRows);
  
          var optionsDonut = {
              title: 'Promedio de Dias por Departamentos',
              pieHole: 0.4,
              colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
          };
  
          var chart = new google.visualization.PieChart(document.getElementById('grafico_diaspromedios'));
          chart.draw(dataDonut, optionsDonut);
      }
});