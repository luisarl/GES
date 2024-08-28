function CapturarDatos()
{
    var oxigeno = $("#consumo_oxigeno").text();
    var gas = $("#consumo_gas").text();

    let NumeroOxigeno = oxigeno.slice(0, -1);
    let ConsumoOxigeno = parseFloat(NumeroOxigeno);
    let NumeroGas = gas.slice(0, -1);
    let ConsumoGas = parseFloat(NumeroGas);

    const Datos = {
        ConsumoOxigeno,
        ConsumoGas,
    };

    console.log(JSON.stringify(Datos));
    //alert(JSON.stringify(Datos));
    $('#datos').val(JSON.stringify(Datos));
    return Datos;
}