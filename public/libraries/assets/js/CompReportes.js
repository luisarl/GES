"use strict";
$(document).ready(function () {

    //Donut chart Servicios
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutSolicitudesEstados);

    function GraficoDonutSolicitudesEstados() 
    {
        var dataRows = [['Estados', 'Emitidas']];
        for (var i = 0; i < solicitudes.length; i++) 
        {
            dataRows.push([solicitudes[i].Estado, parseFloat(solicitudes[i].Emitidas)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Solicitudes de Compra Estados Aprobacion',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_solp_estados'));
        chart.draw(dataDonut, optionsDonut);
    }

    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(GraficoDonutSolicitudesAsignadasComprador);

    function GraficoDonutSolicitudesAsignadasComprador() 
    {
        var dataRows = [['Comprador', 'Asignadas']];
        for (var i = 0; i < solicitudes.length; i++) 
        {
            dataRows.push([solicitudes[i].Comprador, parseFloat(solicitudes[i].Asignados)]);
        }

        var dataDonut = google.visualization.arrayToDataTable(dataRows);

        var optionsDonut = {
            title: 'Solicitudes de Compra Asignadas por Comprador',
            pieHole: 0.4,
            colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico_solp_asignadas_comprador'));
        chart.draw(dataDonut, optionsDonut);
    }

        //Donut chart Servicios
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(GraficoDonutSolicitudesDepartamentos);
    
        function GraficoDonutSolicitudesDepartamentos() 
        {
            var dataRows = [['Departamentos', 'Emitidas']];
            for (var i = 0; i < solicitudes.length; i++) 
            {
                dataRows.push([solicitudes[i].Departamento, parseFloat(solicitudes[i].Emitidas)]);
            }
    
            var dataDonut = google.visualization.arrayToDataTable(dataRows);
    
            var optionsDonut = {
                title: 'Solicitudes de Compra Por Departamentos',
                pieHole: 0.4,
                colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
            };
    
            var chart = new google.visualization.PieChart(document.getElementById('grafico_solp_departamentos'));
            chart.draw(dataDonut, optionsDonut);
        }

        //Donut chart Servicios
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(GraficoDonutSolicitudesEstatus);
    
        function GraficoDonutSolicitudesEstatus() 
        {
            var dataRows = [['Estatus', 'Emitidas']];
            for (var i = 0; i < solicitudes.length; i++) 
            {
                dataRows.push([solicitudes[i].Estatus, parseFloat(solicitudes[i].Emitidas)]);
            }
    
            var dataDonut = google.visualization.arrayToDataTable(dataRows);
    
            var optionsDonut = {
                title: 'Solicitudes de Compra Por Estatus',
                pieHole: 0.4,
                colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
            };
    
            var chart = new google.visualization.PieChart(document.getElementById('grafico_solp_estatus'));
            chart.draw(dataDonut, optionsDonut);
        }

        //Combo chart Productividad
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(GraficoBarProductividadAnual);
    
        function GraficoBarProductividadAnual() 
        {
            var dataRows = [['Comprador', 'Solp', 'OC', 'NDR']];
            for (var i = 0; i < productividad.length; i++) 
            {
                dataRows.push([productividadanual[i].Comprador, 
                parseFloat(productividadanual[i].CantSolP),
                parseFloat(productividadanual[i].CantOC),
                parseFloat(productividadanual[i].CantNDR)]);
            }
            
            var data = google.visualization.arrayToDataTable(dataRows);

            var options = {
                title: 'Productividad Anual Compradores',
                vAxis: { title: ' ' },
                hAxis: { title: 'Compradores' },
                seriesType: 'bars',
                //series: { 5: { type: 'line' } },
                bar: {groupWidth: "305%"},
                colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
            };
    
        var chart = new google.visualization.ComboChart(document.getElementById('grafico_productividad_anual'));
        chart.draw(data, options);
            }

        //Combo chart Productividad
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(GraficoBarProductividad);
    
        function GraficoBarProductividad() 
        {
            var dataRows = [['Comprador', 'Solp', 'OC', 'NDR']];
            for (var i = 0; i < productividad.length; i++) 
            {
                dataRows.push([productividad[i].Comprador, 
                parseFloat(productividad[i].CantSolP),
                parseFloat(productividad[i].CantOC),
                parseFloat(productividad[i].CantNDR)]);
            }
            
            var data = google.visualization.arrayToDataTable(dataRows);

            var options = {
                title: 'Productividad Compradores',
                vAxis: { title: ' ' },
                hAxis: { title: 'Compradores' },
                seriesType: 'bars',
                //series: { 5: { type: 'line' } },
                bar: {groupWidth: "305%"},
                colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
            };
    
            var chart = new google.visualization.ComboChart(document.getElementById('grafico_productividad'));
            chart.draw(data, options);
        }

        //Combo chart Productividad 1
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(GraficoBarProductividad1);
    
        function GraficoBarProductividad1() 
        {
            var dataRows = [['Comprador', 'Sin Procesar', 'Parcial', 'Procesada']];
            for (var i = 0; i < productividad1.length; i++) 
            {
                dataRows.push([productividad1[i].Comprador, 
                parseFloat(productividad1[i].SinProcesar),
                parseFloat(productividad1[i].Parcial),
                parseFloat(productividad1[i].Procesada)]);
            }
            
            var data = google.visualization.arrayToDataTable(dataRows);

            var options = {
                title: 'Efectividad Compradores',
                vAxis: { title: ' ' },
                hAxis: { title: 'Compradores' },
                seriesType: 'bars',
                //series: { 5: { type: 'line' } },
                bar: {groupWidth: "305%"},
                colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
            };
    
            var chart = new google.visualization.ComboChart(document.getElementById('grafico_productividad1'));
            chart.draw(data, options);
        }

        //Combo chart Productividad 2
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(GraficoBarProductividad2);
    
        function GraficoBarProductividad2() 
        {
            var dataRows = [['Comprador', 'Sin Procesar', 'Parcial', 'Procesada']];
            for (var i = 0; i < productividad2.length; i++) 
            {
                dataRows.push([productividad2[i].Comprador, 
                parseFloat(productividad2[i].SinProcesar),
                parseFloat(productividad2[i].Parcial),
                parseFloat(productividad2[i].Procesada)]);
            }
            
            var data = google.visualization.arrayToDataTable(dataRows);

            var options = {
                title: 'Efectividad Compradores',
                vAxis: { title: ' ' },
                hAxis: { title: 'Compradores' },
                seriesType: 'bars',
                //series: { 5: { type: 'line' } },
                bar: {groupWidth: "305%"},
                colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
            };
    
            var chart = new google.visualization.ComboChart(document.getElementById('grafico_productividad2'));
            chart.draw(data, options);
        }

        //Combo chart Productividad 2
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(GraficoBarProductividad3);
    
        function GraficoBarProductividad3() 
        {
            var dataRows = [['Comprador', 'Positiva', 'Negativa']];
            for (var i = 0; i < productividad2.length; i++) 
            {
                dataRows.push([productividad3[i].Comprador, 
                parseFloat(productividad3[i].Positiva),
                parseFloat(productividad3[i].Negativa)]);
            }
            
            var data = google.visualization.arrayToDataTable(dataRows);

            var options = {
                title: 'Satisfaccion de Contraloria',
                vAxis: { title: ' ' },
                hAxis: { title: 'Compradores' },
                seriesType: 'bars',
                //series: { 5: { type: 'line' } },
                bar: {groupWidth: "305%"},
                colors: ['#4680ff', '#FFB64D', '#93BE52', '#69CEC6', '#FE8A7D', '#FC6180', '#18A8B3', '#F6ACCD', '#34AAEA', '#FF9242', '#C6A6A1']
            };
    
            var chart = new google.visualization.ComboChart(document.getElementById('grafico_productividad3'));
            chart.draw(data, options);
        }

});