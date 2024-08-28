<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsalTiposCreateRequest;
use App\Http\Requests\AsalTiposUpdateRequest;
use App\Models\Asal_TiposModel;
use Exception;
use Illuminate\Http\Request;

class AsalTiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = Asal_TiposModel::select('id_tipo', 'nombre_tipo', 'descripcion_tipo', 'activo')->get();
        return view('SalidaMateriales.Tipos.Tipos', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SalidaMateriales.Tipos.TiposCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsalTiposCreateRequest $request)
    {
        $IdTipo = Asal_TiposModel::max('id_tipo') + 1;

        try
        {
            Asal_TiposModel::create(
                [
                    'id_tipo' => $IdTipo,
                    'nombre_tipo' => strtoupper($request['nombre_tipo']),
                    'descripcion_tipo' => strtoupper($request['descripcion_tipo']),
                    'activo' => strtoupper($request['activo']),
                    
                ]);
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear El Tipo. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('asaltipos.edit', $IdTipo)->withSuccess('El Tipo Ha Sido Creado Exitosamente.');
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
        $tipo = Asal_TiposModel::find($IdTipo);

        return view('SalidaMateriales.Tipos.TiposEdit',compact('tipo'));
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AsalTiposUpdateRequest $request, $IdTipo)
    {
        $tipo = Asal_TiposModel::find($IdTipo);

        try
        {
            $tipo->fill(
                [
                    'id_tipo' => $IdTipo,
                    'nombre_tipo' => strtoupper($request['nombre_tipo']),
                    'descripcion_tipo' => strtoupper($request['descripcion_tipo']),
                    'activo' => strtoupper($request['activo']),
                ]);
    
            $tipo->save();
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar El Tipo. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('asaltipos.edit', $IdTipo)->withSuccess('El Tipo Ha Sido Editado Exitosamente.');
        
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
            Asal_TiposModel::destroy($IdTipo);
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Eliminar El Tipo. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('asaltipos.index')->withSuccess('El Tipo Ha Sido Eliminado Exitosamente.');
    }
}
