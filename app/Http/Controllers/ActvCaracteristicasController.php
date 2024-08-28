<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActvCaracteristicasCreateRequest;
use App\Http\Requests\ActvCaracteristicasUpdateRequest;
use App\Models\Actv_CaracteristicasModel;
use App\Models\Actv_TiposModel;
use Exception;
use Illuminate\Http\Request;

class ActvCaracteristicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caracteristicas = Actv_CaracteristicasModel::ListaCaracteristicas();
        return view('Activos.Caracteristicas.Caracteristicas', compact('caracteristicas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = Actv_TiposModel::select('id_tipo', 'nombre_tipo')->get();
        return view('Activos.Caracteristicas.CaracteristicasCreate', compact('tipos')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActvCaracteristicasCreateRequest $request)
    {
        $IdCaracteristica = Actv_CaracteristicasModel::max('id_caracteristica') + 1; // Id del Grupo a Crear

        try
        {
            Actv_CaracteristicasModel::create([
                'id_caracteristica' => $IdCaracteristica,
                'nombre_caracteristica' => strtoupper($request['nombre_caracteristica']),
                'id_tipo' => $request['id_tipo']
            ]);

        }
        catch(Exception $ex)
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Crear La Caracteristica '.$ex->getMessage());
            }

        return redirect("caracteristicasactivos")->withSuccess('La Caracteristica Ha Sido Creado Exitosamente');
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
        $tipos = Actv_TiposModel::select('id_tipo', 'nombre_tipo')->get();
        $caracteristica = Actv_CaracteristicasModel::find($IdCaracteristica);
        return view('Activos.Caracteristicas.CaracteristicasEdit', compact('tipos', 'caracteristica')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActvCaracteristicasUpdateRequest $request, $IdCaracteristica)
    {
        try 
        {
            $caracteristica = Actv_CaracteristicasModel::find($IdCaracteristica);
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

        return redirect("caracteristicasactivos")->withSuccess('La Caracteristica Ha Sido Actualizada Exitosamente');
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
            Actv_CaracteristicasModel::destroy($IdCaracteristica);
        } 
        catch (Exception $ex) 
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Eliminar La Caracteristica'.$ex->getMessage());
            }
       
        return redirect("caracteristicasactivos")->withSuccess('La Caracteristica Ha Sido Eliminada Exitosamente');
    }
}
