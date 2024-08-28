@extends('layouts.email')

@section('titulo','OC INTERNACIONAL CON COSTO CERO')

@section('contenido')

<table class="content" style="border-collapse: collapse;width: 100%;max-width: 800px; " cellspacing="4" cellpadding="4" border="0" align="center">
    <thead>
        <tr style="border-bottom: 1px solid">
            <th>OC</th>
            <th>FechaOC</th>
            <th>Codigo</th>
            <th>Articulo</th>
            <th>Cantidad</th>
            <th>CostoUnitUs </th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        @foreach ($articulos as $articulo)
            <tr style="border-bottom: 1px solid">
                <td>{{$articulo->OC}}</td>
                <td>{{$articulo->FechaOC}}</td>
                <td>{{$articulo->Codigo}}</td>
                <td>{!!wordwrap($articulo->Articulo, 40, "<br>", false)!!}  </td>
                <td>{{number_format($articulo->Cantidad, 2)}}</td>
                <td>{{number_format($articulo->CostoUnitUS, 2)}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

{{-- @section('url', Request::root().'/despachos/'.$movimiento->id_movimiento)
@section('boton', 'VER DESPACHO') --}}