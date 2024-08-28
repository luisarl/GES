<?php

namespace App\Http\Controllers;

use App\Http\Requests\CencConsumiblesCreateRequest;
use App\Http\Requests\CencConsumiblesUpdateRequest;
use App\Models\Cenc_EquiposModel;
use App\Models\Cenc_EquiposTecnologiasModel;
use App\Models\Cenc_EquiposConsumiblesModel;
use Illuminate\Http\Request;
use App\Models\Cenc_ConsumiblesModel;
use App\Models\Cenc_TablasConsumoModel;
use App\Models\Cenc_EquiposTecnologiaModel;
use Exception;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class CencConsumiblesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consumibles = Cenc_ConsumiblesModel::ListaConsumibles(); 
        return view('CentroCorte.Consumibles.Consumibles',compact('consumibles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $equipos = Cenc_EquiposModel::ListaEquipos();
        return view('CentroCorte.Consumibles.ConsumiblesCreate', compact('equipos'));
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CencConsumiblesCreateRequest $request)
    {
        try 
        {
            $IdConsumible = Cenc_ConsumiblesModel::max('id_consumible') + 1;
            Cenc_ConsumiblesModel::create([
                    
                'id_consumible' => $IdConsumible,
                'nombre_consumible' => strtoupper($request['nombre_consumible']),
                'unidad_consumible' => strtoupper($request['unidad_consumible']), 
                'descripcion_consumible' => strtoupper($request['descripcion_consumible'])

            ]);

   
            return redirect("cencconsumibles")->withSuccess('El Consumible Ha Sido Creado Exitosamente');
        } 
        catch (Exception $ex) 
        {
            return back()->withError('Ha Ocurrido Un Error Al Crear El Consumible: '.$ex->getMessage())->withInput();
        }
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
    public function edit($IdConsumible)
    {
        $consumible = Cenc_ConsumiblesModel::find($IdConsumible);
        return view('CentroCorte.Consumibles.ConsumiblesEdit', compact('consumible'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CencConsumiblesCreateRequest $request, $IdConsumible)
    {
        $consumible = Cenc_ConsumiblesModel::find($IdConsumible);
        

        try 
        {
            $consumible->fill([
                    
                'id_consumible' => $IdConsumible,
                'nombre_consumible' => strtoupper($request['nombre_consumible']),
                'unidad_consumible' => strtoupper($request['unidad_consumible']),
                'descripcion_consumible' => strtoupper($request['descripcion_consumible'])

            ]);
            $consumible->save();

            return redirect()->route('cencconsumibles.index')->withSuccess('El Consumible Ha Sido Actualizado Exitosamente'); 
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Actualizar El Consumible: '.$ex->getMessage())->withInput();
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdConsumible)
    {
        try 
        {
            // primero eliminamos de la tabla cenc_equipos_consumibles
            $id_equipo_consumible = Cenc_EquiposConsumiblesModel::ObtenerIdEquipo($IdConsumible); 
            if($id_equipo_consumible!=null)
            {
                Cenc_EquiposConsumiblesModel::destroy((int)$id_equipo_consumible[0]->id_equipo_consumible);
            }
            
            //luego eliminamos de la tabla cenc_consumibles
            Cenc_ConsumiblesModel::destroy($IdConsumible);
            // necesito una funcion que en base al id consumible me devuelva el id_equipotecnologia 

        } 
        catch (Exception $ex) 
        {
            return back()->withError('Ha Ocurrido Un Error Al Eliminar El Consumible: '.$ex->getMessage())->withInput();
        }

       return redirect('cencconsumibles')->withSuccess('El Consumible Ha Sido Eliminado Exitosamente');  
    }


    public function EliminarEquipoConsumible($IdEquipoConsumible)
    {
        try
        {
            // primero debo eliminar todos los registros de la tabla tabla_consumo  
            Cenc_TablasConsumoModel::where('id_equipo_consumible', (int)$IdEquipoConsumible)->delete();
            
            Cenc_EquiposConsumiblesModel::destroy((int)$IdEquipoConsumible); 
        }
            catch (Exception $e)
            {
                return back()->withError('Error Al Eliminar');
            }

        return back()->with('');
    }
}
