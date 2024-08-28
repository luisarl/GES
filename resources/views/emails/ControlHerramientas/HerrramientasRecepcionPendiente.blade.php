@extends('layouts.email')

@section('titulo','HERRAMIENTAS CON RECEPCION PENDIENTES')

@section('contenido')

<table class="content" style="border-collapse: collapse;width: 100%;max-width: 800px; " cellspacing="4" cellpadding="4" border="0" align="center">
    <thead>
        <tr style="border-bottom: 1px solid">
            <th>Movimiento</th>
            <th>Fecha Despacho</th>
            <th>Almacen</th>
            <th>Herramienta</th>
            <th>Responsable</th>
            <th>Cantidad Entregada</th>
            <th>Cantidad Recepción</th>
            <th>Cantidad Pendiente</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        @foreach ($herramientas as $herramienta)
            <tr style="border-bottom: 1px solid">
                <td>{{$herramienta->id_movimiento}}</td>
                <td>{{date("d/m/Y", strtotime($herramienta->fecha_despacho))}}</td>
                <td>{{$herramienta->nombre_almacen}}</td>
                <td> 
                    @php
                    $texto = $herramienta->nombre_herramienta;
                    $NombreHerramienta = wordwrap($texto, 40, "<br>", false);
                    @endphp
                    {!!$NombreHerramienta!!}
                </td>
                <td>{{$herramienta->responsable}}</td>
                <td>{{$herramienta->cantidad_entregada}}</td>
                <td>{{$herramienta->cantidad_devuelta}}</td>
                <td><strong>{{$herramienta->cantidad_pendiente}}</strong></td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

{{-- @section('url', Request::root().'/despachos/'.$movimiento->id_movimiento)
@section('boton', 'VER DESPACHO') --}}