<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GruposModel;
use App\Models\EmpresasModel;
use App\Http\Requests\GruposCreateRequest;
use App\Http\Requests\GruposUpdateRequest;
use DB;
use Redirect;
use Session;
use Exception;

class FictGruposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grupos = GruposModel::all();
        return view('FichaTecnica.Grupos.Grupos', compact('grupos') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('FichaTecnica.Grupos.GruposCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GruposCreateRequest $request)
    {

        $IdGrupo = GruposModel::max('id_grupo') + 1; // Id del Grupo a Crear

            try
            {
                GruposModel::create([
                    'id_grupo' => $IdGrupo,
                    'nombre_grupo' => strtoupper($request['nombre_grupo']),
                    'descripcion_grupo' => strtoupper($request['descripcion_grupo']),
                    'codigo_grupo' => $request['codigo_grupo'],
                    'creado_por' =>  Auth::user()->name
                ]);

            }
            catch(Exception $ex)
            {
                return redirect("grupos")->withError('Ha Ocurrido Un Error al Crear El Grupo '.$ex->getMessage());
            }

            try
            {
                $empresas = EmpresasModel::all();

                foreach ($empresas as $empresa )
                {
                    DB::connection('profit')
                        ->table($empresa->base_datos.'.dbo.lin_art')
                        ->insert([
                            'co_lin' =>  $request['codigo_grupo'],
                            'lin_des' => strtoupper($request['nombre_grupo']),
                            'co_us_in' => '001',
                            'co_sucu' => '000001'
                            ]);
                }
            }
            catch(Exception $ex)
            {
                 return redirect("grupos")->withError('Ha Ocurrido Un Error al Crear El Grupo En Profit '.$ex->getMessage());
            }

        return redirect("grupos")->withSuccess('El Grupo Ha Sido Creado Exitosamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_grupo)
    {
        $grupo = GruposModel::find($id_grupo);
        return view('FichaTecnica.Grupos.GruposEdit', compact('grupo'));
    }


    public function update(GruposUpdateRequest $request, $id_grupo)
    {
        $grupo = GruposModel::find($id_grupo);
        $grupo->fill([
            'nombre_grupo' => strtoupper($request['nombre_grupo']),
            'descripcion_grupo' => strtoupper($request['descripcion_grupo']),
            'codigo_grupo' => $request['codigo_grupo'],
            'actualizado_por' => Auth::user()->name

        ]);

            try
            {

            $grupo->save();

            $empresas = EmpresasModel::all();

                foreach ($empresas as $empresa )
                {
                    DB::connection('profit')
                        ->table($empresa->base_datos.'.dbo.lin_art')
                        ->where('co_lin', $request['codigo_grupo'])
                        ->update([
                            'lin_des' => strtoupper($request['nombre_grupo']),
                            'co_us_in' => '001',
                            'co_sucu' => '000001'
                            ]);
                }

            }
            catch(Exception $ex)
            {
                return redirect("grupos")->withError('Ha Ocurrido Un Error al Actualizar El Grupo '.$ex->getMessage());
            }

        return redirect("grupos")->withSuccess('El Grupo Ha Sido Actualizado Exitosamente');
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
                $grupo = GruposModel::find($id_grupo);
                GruposModel::destroy($id_grupo);

                $empresas = EmpresasModel::all();

                foreach ($empresas as $empresa )
                {
                    DB::connection('profit')
                        ->table($empresa->base_datos.'.dbo.lin_art')
                        ->where('co_lin', $grupo->codigo_grupo)
                        ->delete();
                }

            }
            catch(Exception $e)
            {
                return redirect("grupos")->withError('No se puede eliminar el grupo, porque tiene Subgrupos asociados');
            }

        return redirect("grupos")->withSuccess('El Grupo Ha Sido Eliminado Exitosamente');
    }

    public function migrate()
    {
        $grupos = GruposModel::all();
        $empresas = EmpresasModel::all();

        foreach ($empresas as $empresa ) {
            foreach($grupos as $grupo){

                DB::connection('profit')
                ->table($empresa->base_datos.'.dbo.lin_art')
                ->updateOrInsert(
                    ['co_lin' =>  $grupo->codigo_grupo],
                    [
                    'lin_des' => $grupo->nombre_grupo,
                    'co_us_in' => '001',
                    'co_sucu' => '000001'
                    ]);
            }
        }

        return redirect("grupos")->withSuccess('Los Grupos Han Sido Actualizados en Profit');

    }
}
