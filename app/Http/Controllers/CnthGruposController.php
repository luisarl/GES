<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cnth_GruposModel;
use App\Http\Requests\CnthGruposCreateRequest;
use App\Http\Requests\CnthGruposUpdateRequest;
use DB;
use Exception;

use Illuminate\Http\Request;

class CnthGruposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cnthgrupos = Cnth_GruposModel::all();
        return view('ControlHerramientas.Grupos.Grupos', compact('cnthgrupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ControlHerramientas.Grupos.GruposCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnthGruposCreateRequest $request)
    {
        $IdGrupo = Cnth_GruposModel::max('id_grupo') + 1; // Id del Grupo a Crear

        try {
            Cnth_GruposModel::create([
                'id_grupo' => $IdGrupo,
                'nombre_grupo' => strtoupper($request['nombre_grupo']),
                'descripcion_grupo' => strtoupper($request['descripcion_grupo']),
                'codigo_grupo' => $request['codigo_grupo'],
                'creado_por' =>  Auth::user()->name
            ]);
        } catch (Exception $e) {
            return redirect("cnthgrupos")->withError('Ha Ocurrido Un Error al Crear El Grupo' . $e);
        }

        return redirect("cnthgrupos")->withSuccess('El Grupo Ha Sido Creado Exitosamente');
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
    public function edit($id_grupo)
    {

        $cnthgrupo = Cnth_GruposModel::find($id_grupo);
        return view('ControlHerramientas.Grupos.GruposEdit', compact('cnthgrupo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CnthGruposUpdateRequest $request, $id_grupo)
    {

        try {
            $cnthgrupo = Cnth_GruposModel::find($id_grupo);
            $cnthgrupo->fill([
                'nombre_grupo' => strtoupper($request['nombre_grupo']),
                'descripcion_grupo' => strtoupper($request['descripcion_grupo']),
                'codigo_grupo' => $request['codigo_grupo'],
                'actualizado_por' => Auth::user()->name

            ]);

            $cnthgrupo->save();
        } catch (Exception $e) {
            return redirect("cnthgrupos")->withError('Ha Ocurrido Un Error al Actualizar El Grupo' . $e);
        }

        return redirect("cnthgrupos")->withSuccess('El Grupo Ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_grupo)
    {
        try
        {
            Cnth_GruposModel::destroy($id_grupo);
        }
        catch(Exception $e)
        {
            return redirect("cnthgrupos")->withError('No se puede eliminar el grupo, porque tiene Subgrupos asociados'.$e);
        }

    return redirect("cnthgrupos")->withSuccess('El Grupo Ha Sido Eliminado Exitosamente');
    }
}
