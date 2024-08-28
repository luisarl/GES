<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsalSubTiposCreateRequest;
use App\Http\Requests\AsalSubTiposUpdateRequest;
use App\Models\Asal_SubTiposModel;
use App\Models\Asal_TiposModel;
use Exception;
use Illuminate\Http\Request;

class AsalSubTiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subtipos = Asal_SubTiposModel::ListaSubtipos();
        return view('SalidaMateriales.SubTipos.Subtipos', compact('subtipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = Asal_TiposModel::select('id_tipo', 'nombre_tipo', 'activo')->get();
        return view('SalidaMateriales.SubTipos.SubtiposCreate', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsalSubTiposCreateRequest $request)
    {
        $IdSubTipo = Asal_SubTiposModel::max('id_subtipo') + 1;

        try
        {
            Asal_SubTiposModel::create(
                [
                    'id_subtipo' => $IdSubTipo,
                    'id_tipo' => $request['id_tipo'],
                    'nombre_subtipo' => strtoupper($request['nombre_subtipo']),
                    'descripcion_subtipo' => strtoupper($request['descripcion_subtipo']),
                    'activo' => strtoupper($request['activo']),
                    
                ]);
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear El SubTipo. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('asalsubtipos.edit', $IdSubTipo)->withSuccess('El SubTipo Ha Sido Creado Exitosamente.');
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
    public function edit($IdSubTipo)
    {
        $tipos = Asal_TiposModel::select('id_tipo', 'nombre_tipo')->get();
        $subtipo = Asal_SubTiposModel::find($IdSubTipo);

        return view('SalidaMateriales.SubTipos.SubtiposEdit', compact('tipos', 'subtipo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AsalSubTiposUpdateRequest $request, $IdSubTipo)
    {
        $subtipo = Asal_SubTiposModel::find($IdSubTipo);

        try
        {
            $subtipo->fill(
                [
                    'id_tipo' => $request['id_tipo'],
                    'nombre_subtipo' => strtoupper($request['nombre_subtipo']),
                    'descripcion_subtipo' => strtoupper($request['descripcion_subtipo']),
                    'activo' => strtoupper($request['activo']),
                ]);
    
            $subtipo->save();
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar El SubTipo. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('asalsubtipos.edit', $IdSubTipo)->withSuccess('El SubTipo Ha Sido Editado Exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdSubTipo)
    {
        try
        {
            Asal_SubTiposModel::destroy($IdSubTipo);
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Eliminar El SubTipo. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('asaltipos.index')->withSuccess('El SubTipo Ha Sido Eliminado Exitosamente.');
    }

    public function SubTiposSalidas(Request $request)
    {
        $SubTipos = Asal_SubTiposModel::select('id_subtipo', 'nombre_subtipo')
            ->where('id_tipo', '=', $request->id_tipo)
            ->where('activo', '=', 'SI')
            ->get();
        return with(["subtipos" => $SubTipos]);
    }
}
