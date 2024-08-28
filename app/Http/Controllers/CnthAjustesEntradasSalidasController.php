<?php

namespace App\Http\Controllers;

use App\Models\AlmacenesModel;
use App\Models\Cnth_Entradas;
use App\Models\Cnth_Entradas_Detalle;
use App\Models\Cnth_Movimiento_Inventario;
use App\Models\Cnth_Salidas;
use App\Models\Cnth_Salidas_Detalle;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CnthAjustesEntradasSalidasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $entradas = Cnth_Entradas::ListaEntradas();
       // return view('ControlHerramientas.AjustesEntradaSalida.Entradas', compact('entradas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = AlmacenesModel::all();
        return view('ControlHerramientas.AjustesEntradaSalida.AjustesEntradasSalidasCreate', compact('almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $ListaHerramientas = json_decode($request['datosmovimiento']);
       // dd($ListaHerramientas);

       try
       {
           // VALIDA SI EXISTE UN ERROR EN ALGUN INSERT NO REALIZE NINGUNO
           DB::transaction(function () use ($request, $ListaHerramientas, $FechaActual)
           {
                if($request->tipo == 'E') //TIPO ENTRADA
                {
                    $IdEntrada = Cnth_Entradas::max('id_entrada') + 1;
        
                    Cnth_Entradas::create(
                        [
                        'id_entrada' => $IdEntrada,
                        'fecha' => $FechaActual,
                        'usuario' => Auth::user()->id,
                        'motivo' => $request->motivo,
                        'descripcion'=> $request->descripcion,
                        'id_almacen' => $request->id_almacen  
                        ]
                    );
        
                    foreach($ListaHerramientas  as $herramienta)
                    {
                        $IdDetalle = Cnth_Entradas_Detalle::max('id_detalle') + 1;
                        $IdInventario = Cnth_Movimiento_Inventario::max('id_inventario') + 1;
        
                        Cnth_Entradas_Detalle::create(
                            [
                                'id_detalle' =>$IdDetalle,
                                'id_entrada' => $IdEntrada,
                                'id_herramienta' => $herramienta->id_herramienta,
                                'nombre_herramienta' => $herramienta->nombre_herramienta,
                                'cantidad' => $herramienta->cantidad
                            ]
                        );
                    
                        Cnth_Movimiento_Inventario::create(
                            [
                                'id_inventario' => $IdInventario,
                                'id_herramienta' => $herramienta->id_herramienta,
                                'id_almacen' => $request->id_almacen  ,
                                'movimiento' => $IdEntrada,
                                'tipo_movimiento' => $request->tipo,
                                'usuario' => Auth::user()->name,
                                'fecha' => $FechaActual,
                                'descripcion',
                                'entrada' => $herramienta->cantidad,
                                'salida' => '0'
                            ]
                        );

                        Cnth_Movimiento_Inventario::ActualizarStock($herramienta->id_herramienta, $request->id_almacen);
                    }   
                                
                }
                else if($request->tipo == 'S') //TIPO SALIDA
                    {
                        $IdSalida = Cnth_Salidas::max('id_salida') + 1;
                        Cnth_Salidas::create(
                            [
                            'id_salida' => $IdSalida,
                            'fecha' => $FechaActual,
                            'usuario' => Auth::user()->id,
                            'motivo' => $request->motivo,
                            'descripcion'=> $request->descripcion,
                            'id_almacen' => $request->id_almacen  
                            ]
                        );
            
                        foreach($ListaHerramientas  as $herramienta)
                        {
                            $IdDetalle = Cnth_Salidas_Detalle::max('id_detalle') + 1;
                            $IdInventario = Cnth_Movimiento_Inventario::max('id_inventario') + 1;
            
                            Cnth_Salidas_Detalle::create(
                                [
                                    'id_detalle' =>$IdDetalle,
                                    'id_salida' => $IdSalida,
                                    'id_herramienta' => $herramienta->id_herramienta,
                                    'nombre_herramienta' => $herramienta->nombre_herramienta,
                                    'cantidad' => $herramienta->cantidad
                                ]
                            );

                            Cnth_Movimiento_Inventario::create(
                                [
                                    'id_inventario' => $IdInventario,
                                    'id_herramienta' => $herramienta->id_herramienta,
                                    'id_almacen' => $request->id_almacen  ,
                                    'movimiento' => $IdSalida,
                                    'tipo_movimiento' => $request->tipo,
                                    'usuario' => Auth::user()->name,
                                    'fecha' => $FechaActual,
                                    'descripcion',
                                    'entrada' => '0',
                                    'salida' => $herramienta->cantidad
                                ]
                            );

                            Cnth_Movimiento_Inventario::ActualizarStock($herramienta->id_herramienta, $request->id_almacen);
                        }
                    }
            });
        }
        catch(Exception $ex)
            {
                return back()->withError('Ocurrio Un Error al Realizar El Ajuste: '.$ex->getMessage())->withInput();
            }
  
        return redirect('ajustesentradassalidas')->withSuccess('El Movimiento Ha Sido Realizado Exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
