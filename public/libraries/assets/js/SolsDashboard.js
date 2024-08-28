"use strict";
$(document).ready(function () {

    //Donut chart Servicios
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutServicios);

    function GraficoDonutServicios() 
    {
        var dataRows = [['Solicitudes', 'Por Servicio']];
        for (var i = 0; i < SolicitudesServicios.length; i++) 
        {
            dataRows.push([SolicitudesServicios[i].nombre_servicio, parseFloat(SolicitudesServicios[i].cantidad)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Solicitudes Por Servicio',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_servicios'));
        chart.draw(dataDonut, optionsDonut);
    }

    //Donut chart SubServicios
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutSubServicios);

    function GraficoDonutSubServicios() 
    {
        var dataRows = [['Solicitudes', 'Por SubServicio']];
        for (var i = 0; i < SolicitudesSubServicios.length; i++) 
        {
            dataRows.push([SolicitudesSubServicios[i].nombre_subservicio, parseFloat(SolicitudesSubServicios[i].cantidad)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Solicitudes Por SubServicio',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_subservicios'));
        chart.draw(dataDonut, optionsDonut);
    }

    //Donut chart Departamento
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutDepartamentoSolicitante);

    function GraficoDonutDepartamentoSolicitante() 
    {
        var dataRows = [['Solicitudes', 'Por Departamento']];
        for (var i = 0; i < SolicitudesDepartamentos.length; i++) 
        {
            dataRows.push([SolicitudesDepartamentos[i].nombre_departamento, parseFloat(SolicitudesDepartamentos[i].cantidad)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Solicitudes Por Departamento',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_departamentos'));
        chart.draw(dataDonut, optionsDonut);
    }

    //Donut chart Estatus
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutEstatus);

    function GraficoDonutEstatus() 
    {
        var dataRows = [['Solicitudes', 'Por Estatus']];
        for (var i = 0; i < SolicitudesEstatus.length; i++) 
        {
            dataRows.push([SolicitudesEstatus[i].estatus, parseFloat(SolicitudesEstatus[i].cantidad)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Solicitudes Por Estatus',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_estatus'));
        chart.draw(dataDonut, optionsDonut);
    }

    //Donut chart Responsables
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutResponsables);

    function GraficoDonutResponsables() 
    {
        var dataRows = [['Solicitudes', 'Por Responsable']];
        for (var i = 0; i < SolicitudesResponsable.length; i++) 
        {
            dataRows.push([SolicitudesResponsable[i].nombre_responsable, parseFloat(SolicitudesResponsable[i].cantidad)]);
        }
        
        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Solicitudes Por Responsables',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_responsable'));
        chart.draw(dataDonut, optionsDonut);
    }

     //Combo chart Subservicios
     google.charts.load('current', { 'packages': ['corechart'] });
     google.charts.setOnLoadCallback(GraficoBarSubservicios);
 
     function GraficoBarSubservicios() {
         // Some raw data (not necessarily accurate)

        var dataRows = [['Subservicio', 'Por Aceptar', 'Abierto', 'No Procede', 'Anulado', 'En Proceso', 'Cerrado', 'Finalizado']];
        for (var i = 0; i < SolicitudesSubServiciosDetalle.length; i++) 
        {
            dataRows.push([SolicitudesSubServiciosDetalle[i].nombre_subservicio, parseFloat(SolicitudesSubServiciosDetalle[i].por_aceptar),
            parseFloat(SolicitudesSubServiciosDetalle[i].abierto),parseFloat(SolicitudesSubServiciosDetalle[i].no_procede),parseFloat(SolicitudesSubServiciosDetalle[i].anulado),
            parseFloat(SolicitudesSubServiciosDetalle[i].en_proceso),parseFloat(SolicitudesSubServiciosDetalle[i].cerrado),parseFloat(SolicitudesSubServiciosDetalle[i].finalizado)]);
        }
        
        var data = google.visualization.arrayToDataTable(dataRows);

        var options = {
             title: 'Detalle Subservicios',
             vAxis: { title: 'Total' },
             hAxis: { title: 'Subservicios' },
             seriesType: 'bars',
             //series: { 5: { type: 'line' } },
             bar: {groupWidth: "305%"},
             colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };
 
         var chart = new google.visualization.ComboChart(document.getElementById('grafico_subservicios_detalle'));
         chart.draw(data, options);
     }

     //Combo chart Departamentos
     google.charts.load('current', { 'packages': ['corechart'] });
     google.charts.setOnLoadCallback(GraficoBarDepartamentos);
 
     function GraficoBarDepartamentos() {
         // Some raw data (not necessarily accurate)

        var dataRows = [['Departamentos', 'Por Aceptar', 'Abierto', 'No Procede', 'Anulado', 'En Proceso', 'Cerrado', 'Finalizado']];
        for (var i = 0; i < SolicitudesSubServiciosDetalle.length; i++) 
        {
            dataRows.push([SolicitudesDepartamentoSolicitanteDetalle[i].nombre_departamento, parseFloat(SolicitudesDepartamentoSolicitanteDetalle[i].por_aceptar),
            parseFloat(SolicitudesDepartamentoSolicitanteDetalle[i].abierto),parseFloat(SolicitudesDepartamentoSolicitanteDetalle[i].no_procede),parseFloat(SolicitudesDepartamentoSolicitanteDetalle[i].anulado),
            parseFloat(SolicitudesDepartamentoSolicitanteDetalle[i].en_proceso),parseFloat(SolicitudesDepartamentoSolicitanteDetalle[i].cerrado),parseFloat(SolicitudesDepartamentoSolicitanteDetalle[i].finalizado)]);
        }
        
        var data = google.visualization.arrayToDataTable(dataRows);

        var options = {
             title: 'Detalle Departamentos',
             vAxis: { title: 'Total' },
             hAxis: { title: 'Departamentos' },
             seriesType: 'bars',
             //series: { 5: { type: 'line' } },
             bar: {groupWidth: "305%"},
             colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };
 
         var chart = new google.visualization.ComboChart(document.getElementById('grafico_departamentos_detalle'));
         chart.draw(data, options);
     }

 
});