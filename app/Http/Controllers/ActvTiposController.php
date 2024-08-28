<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActvTiposCreateRequest;
use App\Http\Requests\ActvTiposUpdateRequest;
use App\Models\Actv_TiposModel;
use Exception;
use Illuminate\Http\Request;

class ActvTiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = Actv_TiposModel::all();
        return view('Activos.Tipos.Tipos', compact('tipos')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Activos.Tipos.TiposCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActvTiposCreateRequest $request)
    {
        $IdTipo = Actv_TiposModel::max('id_tipo') + 1; // Id del Grupo a Crear

        try
        {
            Actv_TiposModel::create([
                'id_tipo' => $IdTipo,
                'nombre_tipo' => strtoupper($request['nombre_tipo']),
            ]);
        }
        catch(Exception $ex)
        {
            return back()->withErrors('Ha Ocurrido Un Error al Crear El Tipo '.$ex->getMessage());
        }

        return redirect('tiposactivos')->withSuccess('El Tipo Ha Sido Creado Exitosamente');
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
    public function edit($IdTipo)
    {
        $tipo = Actv_TiposModel::find($IdTipo);
        return view('Activos.Tipos.TiposEdit', compact('tipo')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActvTiposUpdateRequest $request, $IdTipo)
    {   
        try
        {
            $tipo = Actv_TiposModel::find($IdTipo);
            $tipo->fill([
                'nombre_tipo' => strtoupper($request['nombre_tipo']),
            ]);

            $tipo->save();
        }
        catch(Exception $ex)
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Actualizar El Tipo '.$ex->getMessage());
            }

        return redirect("tiposactivos")->withSuccess('El Tipo Ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdTipo)
    {   
        try
        {
            Actv_TiposModel::destroy($IdTipo);
        }
        catch(Exception $ex)
        {
            return back()->withErrors('Ha Ocurrido Un Error Al Actualizar El Tipo '.$ex->getMessage());
        }

        return redirect("tiposactivos")->withSuccess('El Tipo Ha Sido Eliminado Exitosamente');
    }
}
