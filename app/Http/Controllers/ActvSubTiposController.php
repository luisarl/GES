<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActvSubTiposCreateRequest;
use App\Http\Requests\ActvSubTiposUpdateRequest;
use App\Models\Actv_SubTiposModel;
use App\Models\Actv_TiposModel;
use Exception;
use Illuminate\Http\Request;

class ActvSubTiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subtipos = Actv_SubTiposModel::ListaSubTipos();
        return view('Activos.Subtipos.Subtipos', compact('subtipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = Actv_TiposModel::select('id_tipo', 'nombre_tipo')->get();
        return view('Activos.Subtipos.SubtiposCreate', compact('tipos')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActvSubTiposCreateRequest $request)
    {
        $IdSubtipo = Actv_SubTiposModel::max('id_subtipo') + 1; // Id del Grupo a Crear

        try
        {
            Actv_SubTiposModel::create([
                'id_subtipo' => $IdSubtipo,
                'nombre_subtipo' => strtoupper($request['nombre_subtipo']),
                'id_tipo' => $request['id_tipo']
            ]);

        }
        catch(Exception $ex)
        {
            return back()->withErrors('Ha Ocurrido Un Error Al Crear El Tipo '.$ex->getMessage());
        }

        return redirect("subtiposactivos")->withSuccess('El SubTipo Ha Sido Creado Exitosamente');
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
    public function edit($IdSubtipo)
    {
        $tipos = Actv_TiposModel::select('id_tipo', 'nombre_tipo')->get();
        $subtipo = Actv_SubTiposModel::find($IdSubtipo);
        return view('Activos.Subtipos.SubtiposEdit', compact('tipos', 'subtipo')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActvSubTiposUpdateRequest $request, $IdSubtipo)
    {
        try 
        {
            $subtipo = Actv_SubTiposModel::find($IdSubtipo);
            $subtipo->fill([
                'nombre_subtipo' => strtoupper($request['nombre_subtipo']),
                'id_tipo' => $request['id_tipo']
            ]);

            $subtipo->save();
        } 
        catch (Exception $ex) 
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Actualizar El Subtipo '.$ex->getMessage());
            }

        return redirect("subtiposactivos")->withSuccess('El Subtipo Ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdSubtipo)
    {
        try 
        {
            Actv_SubTiposModel::destroy($IdSubtipo);
        } 
        catch (Exception $ex) 
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Eliminar El Subtipo '.$ex->getMessage());
            }
       
        return redirect("subtiposactivos")->withSuccess('El Subtipo Ha Sido Eliminado Exitosamente');
    }
}
