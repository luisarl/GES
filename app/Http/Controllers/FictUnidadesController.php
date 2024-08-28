<?php

namespace App\Http\Controllers;

use App\Models\UnidadesModel;
use App\Models\EmpresasModel;
use Illuminate\Http\Request;
use App\Http\Requests\UnidadesCreateRequest;
use App\Http\Requests\UnidadesUpdateRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use Exception;
use Redirect;
use Session;


class FictUnidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $unidades = UnidadesModel::all();
        return view('FichaTecnica.Unidades.Unidades', compact('unidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('FichaTecnica.Unidades.UnidadesCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnidadesCreateRequest $request)
    {
        $IdUnidad = UnidadesModel::max('id_unidad') + 1;

        $unidad = new UnidadesModel();

        try
        {
            $unidad->id_unidad = $IdUnidad;
            $unidad->nombre_unidad = strtoupper($request['nombre_unidad']);
            $unidad->abreviatura_unidad = strtoupper($request['abreviatura_unidad']);
            $unidad->clasificacion_unidad = strtoupper($request['clasificacion_unidad']);
            $unidad->creado_por = Auth::user()->name;
            $unidad->actualizado_por = null;

            $unidad->save();
        }
        catch(Exception $ex)
        {
            return redirect("unidades")->withError('Ha Ocurrido Un Error Al Crear La Unidad '.$ex->getMessage());
        }

        try 
        {
            $empresas = EmpresasModel::all();

            foreach ($empresas as $empresa )
            {
                DB::connection('profit')
                ->table($empresa->base_datos.'.dbo.unidades')
                ->insert([
                    'co_uni' =>  strtoupper($request['abreviatura_unidad']),
                    'des_uni' => strtoupper($request['nombre_unidad']),
                    'co_us_in' => '001',
                    'co_sucu' => '000001'
                    ]);
            }
        } 
        catch (Exception $ex) 
            {
                return redirect("unidades")->withError('Ha Ocurrido Un Error Al Crear La Unidad En Profit '.$ex->getMessage());
            }


    return redirect("unidades")->withSuccess('La Unidad Ha Sido Creado Exitosamente');

    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_unidad)
    {

        $unidad = UnidadesModel::find($id_unidad);
        return view('FichaTecnica.Unidades.UnidadesEdit', compact('unidad'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UnidadesUpdateRequest $request, $id_unidad)
    {
        $unidad = UnidadesModel::find($id_unidad);
        $unidad->fill([
            'nombre_unidad' => strtoupper($request['nombre_unidad']),
            'abreviatura_unidad' => strtoupper($request['abreviatura_unidad']),
            'clasificacion_unidad' => strtoupper($request['clasificacion_unidad']),
            'actualizado_por' => Auth::user()->name

        ]);

            try
            {
                $unidad->save();

                $empresas = EmpresasModel::all();

                    foreach ($empresas as $empresa )
                    {
                        DB::connection('profit')
                        ->table($empresa->base_datos.'.dbo.unidades')
                        ->where( 'co_uni', $request['abreviatura_unidad'])
                        ->update([
                            'des_uni' => strtoupper($request['nombre_unidad']),
                            'co_us_in' => '001',
                            'co_sucu' => '000001'
                            ]);
                    }
            }
            catch(Exception $ex)
            {
                return redirect("unidades")->withError('Ha Ocurrido Un Error Al Actualizar La Unidad '.$ex->getMessage());
            }

        return redirect("unidades")->withSuccess('La unidad de medida se ha Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_unidad)
    {
        try
        {
            $unidad = UnidadesModel::find($id_unidad);

            UnidadesModel::destroy($id_unidad);
            $empresas = EmpresasModel::all();

            foreach ($empresas as $empresa )
            {
                DB::connection('profit')
                ->table($empresa->base_datos.'.dbo.unidades')
                ->where( 'co_uni', $unidad->abreviatura_unidad)
                ->delete();
            }

        }
        catch(Exception $e)
        {
            return redirect("unidades")->withError('No se puede eliminar la unidad, porque tiene articulos asociados');
        }

        return redirect("unidades")->withSuccess('La unidad de medida Ha Sido Eliminado Exitosamente');

    }

    public function migrate()
    {
        $unidades = UnidadesModel::all();
        $empresas = EmpresasModel::all();

        foreach ($empresas as $empresa ) {
            foreach($unidades as $unidad){

                DB::connection('profit')
                ->table($empresa->base_datos.'.dbo.unidades')
                ->updateOrInsert(
                    ['co_uni' =>  $unidad->abreviatura_unidad],
                    [
                    'des_uni' => $unidad->nombre_unidad,
                    'co_us_in' => '001',
                    'co_sucu' => '000001'
                    ]);
            }
        }

        return redirect("unidades")->withSuccess('Las Unidades Han Sido Actualizados en Profit');

    }
}
