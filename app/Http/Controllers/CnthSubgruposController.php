<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Cnth_GruposModel;
use App\Models\Cnth_SubgruposModel;
use App\Http\Requests\CnthSubgruposCreateRequest;
use App\Http\Requests\CnthSubgruposUpdateRequest;
use DB;
use Exception;

use Illuminate\Http\Request;

class CnthSubgruposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cnthsubgrupos = Cnth_SubgruposModel::with('grupo')->get();
        // dd($cnthsubgrupos);
        return view('ControlHerramientas.Subgrupos.Subgrupos', compact('cnthsubgrupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cnthgrupos = Cnth_GruposModel::select('id_grupo', 'nombre_grupo', 'codigo_grupo')->get();
        return view('ControlHerramientas.Subgrupos.SubgruposCreate', compact('cnthgrupos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnthSubgruposCreateRequest $request)
    {
        $IdCnthSubgrupo = Cnth_SubgruposModel::max('id_subgrupo') + 1; // ID Del Subgrupo
        
        $CnthSubgrupo = new Cnth_SubgruposModel();
        try
        {
            $CnthSubgrupo->id_subgrupo = $IdCnthSubgrupo;
            $CnthSubgrupo->nombre_subgrupo = strtoupper($request['nombre_subgrupo']);
            $CnthSubgrupo->descripcion_subgrupo = strtoupper($request['descripcion_subgrupo']);
            $CnthSubgrupo->codigo_subgrupo = $request['codigo_subgrupo'];
            $CnthSubgrupo->id_grupo = $request['id_grupo'];
            $CnthSubgrupo->creado_por = Auth::user()->name;
            $CnthSubgrupo->actualizado_por = null;

            $CnthSubgrupo->save();
        }
        catch(Exception $ex)
        {
                return redirect("cnthsubgrupos")->withError('Ha Ocurrido Un Error al Crear El Subgrupo'.$ex->getMessage());
        }


      return redirect("cnthsubgrupos")->withSuccess('El Subgrupo Ha Sido Creado Exitosamente');
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
    public function edit($id_subgrupo)
    {
        $cnthgrupos = Cnth_GruposModel::select('id_grupo', 'nombre_grupo', 'codigo_grupo')->get();
        $cnthsubgrupo = Cnth_SubgruposModel::find($id_subgrupo);
        return view('ControlHerramientas.Subgrupos.SubgruposEdit', compact('cnthsubgrupo', 'cnthgrupos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CnthSubgruposUpdateRequest $request, $id_subgrupo)
    {
        $CnthSubgrupo = Cnth_SubgruposModel::find($id_subgrupo);
        $CnthSubgrupo->fill([
            'nombre_subgrupo' => strtoupper($request['nombre_subgrupo']),
            'descripcion_subgrupo' => strtoupper($request['descripcion_subgrupo']),
            'codigo_subgrupo' => $request['codigo_subgrupo'],
            'id_grupo' => $request['id_grupo'],
            'actualizado_por' => Auth::user()->name

        ]);

        try{
            $CnthSubgrupo->save();
        }
        catch(Exception $ex)
        {
            return redirect("cnthsubgrupos")->withError('Ha Ocurrido Un Error Al Actualizar El Subgrupo '.$ex->getMessage());
        }

        return redirect("cnthsubgrupos")->withSuccess('El SubGrupo Ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_subgrupo)
    {
        try
        {
            Cnth_SubgruposModel::destroy($id_subgrupo);
        }
        catch (Exception $e)
        {
            return redirect("cnthsubgrupos")->withError('No se puede eliminar el sub grupo, porque tiene articulos asociados');
        }
      return redirect("cnthsubgrupos")->withSuccess('El Sub Grupo Ha Sido Eliminado Exitosamente');
    }
}
