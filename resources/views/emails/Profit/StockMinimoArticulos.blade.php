@extends('layouts.email')

@section('titulo','ARTICULOS CON STOCK MINIMO ALMACEN '.$empresa->nombre_almacen)

@section('contenido')

<table class="content" style="border-collapse: collapse;width: 100%;max-width: 800px; " cellspacing="4" cellpadding="4" border="0" align="center">
    <thead>
        <tr style="border-bottom: 1px solid">
            <th>Codigo</th>
            <th>Descripcion</th>
            <th>Unidad</th>
            <th>Stock Actual</th>
            <th>Stock Minimo</th>
            <th>Punto Pedido</th>
            <th>Stock Maximo</th>
            <th>Procedencia</th>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        @foreach ($articulos as $articulo)
            <tr style="border-bottom: 1px solid">
                <td>{{$articulo->co_art}}</td>
                <td>{!!wordwrap($articulo->art_des, 40, "<br>", false)!!}  </td>
                <td>{{$articulo->uni_venta}}</td>
                <td>{{$articulo->stock_actual}}</td>
                <td>{{$articulo->stock_minimo}}</td>
                <td>{{$articulo->punto_pedido}}</td>
                <td>{{$articulo->stock_maximo}}</td>
                <td>{{$articulo->procedenci}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

{{-- @section('url', Request::root().'/despachos/'.$movimiento->id_movimiento)
@section('boton', 'VER DESPACHO') --}}