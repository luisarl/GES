<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cntc_Tipo_CombustibleModel;
use App\Http\Requests\CntcTiposCombustiblesCreateRequest;
use App\Http\Requests\CntcTiposCombustiblesUpdateRequest;
use App\Models\DepartamentosModel;
use Exception;
class CntcTiposCombustiblesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos= Cntc_Tipo_CombustibleModel::TiposCombustible();
        return view('ControlCombustible.TiposCombustibles.TiposCombustible',compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
        return view('ControlCombustible.TiposCombustibles.TiposCombustibleCreate',compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CntcTiposCombustiblesCreateRequest $request)
    {
        try
        {
            $IdTipoCombustible=  Cntc_Tipo_CombustibleModel::max('id_tipo_combustible') + 1;
            Cntc_Tipo_CombustibleModel::create([
                   'id_tipo_combustible'=>$IdTipoCombustible,
                   'descripcion_combustible'=>strtoupper($request['combustible']),
                   'id_departamento_encargado'=>$request['departamento'],
                   'stock'=>$request['stock'],
                ]);
        }
        catch(Exception $ex)
         {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear El Tipo de Combustible'.$ex->getMessage())->withInput();
         }
       
        return redirect()->route("cntctiposcombustible.index")->withSuccess("El Tipo de Combustible Ha Sido Creada Exitosamente");
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
    public function edit($IdTipoCombustible)
    {
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
        $tipos= Cntc_Tipo_CombustibleModel::find($IdTipoCombustible);
        return view('ControlCombustible.TiposCombustibles.TiposCombustibleEdit', compact('tipos','departamentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CntcTiposCombustiblesUpdateRequest $request, $IdTipoCombustible)
    {
        try
        {
            $tipos= Cntc_Tipo_CombustibleModel::find($IdTipoCombustible);
            $tipos->fill([
                'descripcion_combustible'=>strtoupper($request['combustible']),
                'id_departamento_encargado'=>$request['departamento'],
                'stock'=>$request['stock'],
            ]);
            $tipos->save();
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar El Tipo de Combustible'.$ex->getMessage())->withInput();  
            }
        return redirect()->route("cntctiposcombustible.index")->withSuccess("El Tipo de Combustible Ha Sido Editada Exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdTipoCombustible)
    {
        try
        {
            Cntc_Tipo_CombustibleModel::destroy($IdTipoCombustible);
        }
        catch (Exception $ex)
            {
                return back()->withError('Error Al Eliminar '.$ex->getMessage());
            }

        return redirect()->route("cntctiposcombustible.index")->withSuccess("El Combustible Ha Sido Eliminado Exitosamente");
    }
}
