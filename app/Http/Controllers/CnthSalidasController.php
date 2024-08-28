<?php

namespace App\Http\Controllers;

use App\Http\Requests\CnthEntradasSalidasRequest;
use App\Models\AlmacenesModel;
use App\Models\Cnth_Entradas;
use App\Models\Cnth_Entradas_Detalle;
use App\Models\Cnth_Movimiento_InventarioModel;
use App\Models\Cnth_Salidas;
use App\Models\Cnth_Salidas_Detalle;
use App\Models\Cnth_Salidas_DetalleModel;
use App\Models\Cnth_SalidasModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class CnthSalidasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salidas = Cnth_SalidasModel::ListaSalidas();
        return view('ControlHerramientas.Salidas.Salidas', compact('salidas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = AlmacenesModel::all();
        return view('ControlHerramientas.Salidas.SalidasCreate', compact('almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnthEntradasSalidasRequest $request)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $ListaHerramientas = json_decode($request['datosmovimiento']);
       
        if($ListaHerramientas  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['datosmovimiento'=> 'Para realizar un ajuste debe seleccionar una o varias herramientas']);
        }

       try
       {
           // VALIDA SI EXISTE UN ERROR EN ALGUN INSERT NO REALIZE NINGUNO
           DB::transaction(function () use ($request, $ListaHerramientas, $FechaActual)
           {
                    $IdSalida = Cnth_SalidasModel::max('id_salida') + 1;
        
                    Cnth_SalidasModel::create(
                        [
                        'id_salida' => $IdSalida,
                        'fecha' => $FechaActual,
                        'usuario' => Auth::user()->id,
                        'motivo' => strtoupper($request->motivo),
                        'descripcion'=> strtoupper($request->descripcion),
                        'id_almacen' => $request->id_almacen  
                        ]
                    );
        
                    foreach($ListaHerramientas  as $herramienta)
                    {
                        $IdDetalle = Cnth_Salidas_DetalleModel::max('id_detalle') + 1;
                        $IdInventario = Cnth_Movimiento_InventarioModel::max('id_inventario') + 1;
        
                        Cnth_Salidas_DetalleModel::create(
                            [
                                'id_detalle' =>$IdDetalle,
                                'id_salida' => $IdSalida,
                                'id_herramienta' => $herramienta->id_herramienta,
                                'nombre_herramienta' => strtoupper($herramienta->nombre_herramienta),
                                'cantidad' => $herramienta->cantidad
                            ]
                        );
                    
                        Cnth_Movimiento_InventarioModel::create(
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
                                'salida' => $herramienta->cantidad,
                            ]
                        );

                        Cnth_Movimiento_InventarioModel::ActualizarStock($herramienta->id_herramienta, $request->id_almacen);
                    }   
                                
             });
        }
        catch(Exception $ex)
            {
                return back()->withError('Ocurrio Un Error al Realizar El Ajuste: '.$ex->getMessage())->withInput();
            }
        
        return redirect('salidas')->withSuccess('El Movimiento Ha Sido Realizado Exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdSalida)
    {
        $detalle = Cnth_SalidasModel::DetalleSalida($IdSalida);
        $movimiento = Cnth_SalidasModel::MovimientoSalida($IdSalida);
        return view('ControlHerramientas.Salidas.SalidasShow', compact('detalle', 'movimiento'));
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
