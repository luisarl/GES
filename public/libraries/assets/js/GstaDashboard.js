"use strict";
$(document).ready(function () {


     //Donut chart Empleados
     google.charts.load("current", { packages: ["corechart"] });
     google.charts.setOnLoadCallback(GraficoDonutEmpleados);
 
     function GraficoDonutEmpleados() 
     {
         var dataRows = [['Empleados', 'Por Departamento']];
         for (var i = 0; i < empleados.length; i++) 
         {
             dataRows.push([empleados[i].des_depart, parseFloat(empleados[i].cantidad)]);
         }
 
         var dataDonut = google.visualization.arrayToDataTable(dataRows);
 
         var optionsDonut = {
             title: 'Empleados por Departamento',
             pieHole: 0.4,
             colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
         };
 
         var chart = new google.visualization.PieChart(document.getElementById('grafico_empleados'));
         chart.draw(dataDonut, optionsDonut);
     }
    //Donut chart Ausencias
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutAusencias);

    function GraficoDonutAusencias() 
    {
        var dataRows = [['Ausencias', 'Por Departamento']];
        for (var i = 0; i < ausencias.length; i++) 
        {
            dataRows.push([ausencias[i].des_depart, parseFloat(ausencias[i].cantidad)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Ausencias por Departamento',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_ausencias'));
        chart.draw(dataDonut, optionsDonut);
    }


    //Donut chart retardos
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutRetardos);

    function GraficoDonutRetardos() 
    {
        var dataRows = [['Retardos', 'Por Departamento']];
        for (var i = 0; i < retardos.length; i++) 
        {
            dataRows.push([retardos[i].des_depart, parseFloat(retardos[i].cantidad)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Retardos Por Departamentos',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_retardos'));
        chart.draw(dataDonut, optionsDonut);
    }

    //Donut chart Ausencias por Empleado
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutAusenciasEmpleados);

    function GraficoDonutAusenciasEmpleados() 
    {
        var dataRows = [['Ausencias', 'Por Empleado']];
        for (var i = 0; i < ausenciasempleados.length; i++) 
        {
            dataRows.push([ausenciasempleados[i].nombre_empleado, parseFloat(ausenciasempleados[i].cantidad)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Ausencias por Empleado',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_ausencia_empleado'));
        chart.draw(dataDonut, optionsDonut);
    }

    //Donut chart Retardos por Empleado
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutRetardosEmpleados);

    function GraficoDonutRetardosEmpleados() 
    {
        var dataRows = [['Retardos', 'Por Empleado']];
        for (var i = 0; i < retardosempleados.length; i++) 
        {
            dataRows.push([retardosempleados[i].nombre_empleado, parseFloat(retardosempleados[i].cantidad)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Retardos por Empleado',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_retardos_empleado'));
        chart.draw(dataDonut, optionsDonut);
    }
   
 
});