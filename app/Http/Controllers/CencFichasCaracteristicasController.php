<?php

namespace App\Http\Controllers;

use App\Http\Requests\CencFichasCaracteristicasCreateRequest;
use App\Http\Requests\CencFichasCaracteristicasUpdateRequest;
use App\Models\Cenc_FichasCaracteristicasModel;  
use App\Models\Cenc_FichasCaracteristicasValoresModel; 
use App\Models\Cenc_FichasTiposModel;
use Exception;
use Illuminate\Http\Request;

class CencFichasCaracteristicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caracteristicas = Cenc_FichasCaracteristicasModel::ListaCaracteristicas();
        return view('CentroCorte.FichaTecnica.Caracteristicas.Caracteristicas', compact('caracteristicas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = Cenc_FichasTiposModel::select('id_tipo', 'nombre_tipo')->get();
        return view('CentroCorte.FichaTecnica.Caracteristicas.CaracteristicasCreate', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CencFichasCaracteristicasCreateRequest $request)
    {
        $IdCaracteristica = Cenc_FichasCaracteristicasModel::max('id_caracteristica') + 1; // Id del Grupo a Crear

        try
        {
            Cenc_FichasCaracteristicasModel::create([
                'id_caracteristica' => $IdCaracteristica,
                'nombre_caracteristica' => strtoupper($request['nombre_caracteristica']),
                'id_tipo' => $request['id_tipo']
            ]);

        }
        catch(Exception $ex)
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Crear La Caracteristica '.$ex->getMessage());
            }

        return redirect("cencfichascaracteristicas")->withSuccess('La Caracteristica Ha Sido Creado Exitosamente');
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
    public function edit($IdCaracteristica)
    {
        $tipos = Cenc_FichasTiposModel::select('id_tipo', 'nombre_tipo')->get();
        $caracteristica = Cenc_FichasCaracteristicasModel::find($IdCaracteristica);
        return view('CentroCorte.FichaTecnica.Caracteristicas.CaracteristicasEdit', compact('tipos', 'caracteristica')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CencFichasCaracteristicasUpdateRequest $request, $IdCaracteristica)
    {
        try 
        {
            $caracteristica = Cenc_FichasCaracteristicasModel::find($IdCaracteristica);
            $caracteristica->fill([
                'nombre_caracteristica' => strtoupper($request['nombre_caracteristica']),
                'id_tipo' => $request['id_tipo']
            ]);

            $caracteristica->save();
        } 
        catch (Exception $ex) 
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Actualizar La Caracteristica '.$ex->getMessage());
            }

        return redirect("cencfichascaracteristicas")->withSuccess('La Caracteristica Ha Sido Actualizada Exitosamente');
    }

    // PRUEBA DE RETORNO en JS
    public function Caracteristicas(Request $request)
    {
        $caracteristicas = Cenc_FichasCaracteristicasModel::where('id_tipo', '=', $request->id)->get();
        return with(["caracteristicas" => $caracteristicas]);
    }

    //PRUEBA #VALORES
    public function FichaValores(Request $request)          
    {
        $caracteristicas = Cenc_FichasCaracteristicasValoresModel::ListaValores($request->id);
        return with(["caracteristicas" => $caracteristicas]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdCaracteristica)
    {
        try 
        {
            Cenc_FichasCaracteristicasModel::destroy($IdCaracteristica);
        } 
        catch (Exception $ex) 
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Eliminar La Caracteristica'.$ex->getMessage());
            }
       
        return redirect("cencfichascaracteristicas")->withSuccess('La Caracteristica Ha Sido Eliminada Exitosamente');
    
    }
}
