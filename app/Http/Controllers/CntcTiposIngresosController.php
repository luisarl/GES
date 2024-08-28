<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cntc_Tipo_IngresosModel;
use App\Http\Requests\CntcTiposIngresosCreateRequest;
use Exception;
class CntcTiposIngresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos= Cntc_Tipo_IngresosModel::all();
        return view('ControlCombustible.TiposIngresos.TiposIngreso',compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ControlCombustible.TiposIngresos.TiposIngresoCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CntcTiposIngresosCreateRequest $request)
    {
        try
        {
            $IdTipoIngreso=  Cntc_Tipo_IngresosModel::max('id_tipo_ingresos') + 1;
            Cntc_Tipo_IngresosModel::create([
                   'id_tipo_ingresos'=>$IdTipoIngreso,
                   'descripcion_ingresos'=>strtoupper($request['descripcion']),
                ]);
        }
        catch(Exception $ex)
         {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear El Tipo de Ingreso de Combustible'.$ex->getMessage())->withInput();
         }
       
        return redirect()->route("cntctiposingresos.index")->withSuccess("El Tipo de Ingreso de Combustible Ha Sido Creada Exitosamente");
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
    public function edit($IdTipoIngreso)
    {
        $tipos=Cntc_Tipo_IngresosModel::find($IdTipoIngreso);
       
        return view('ControlCombustible.TiposIngresos.TiposIngresoEdit', compact('tipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CntcTiposIngresosCreateRequest $request, $IdTipoIngreso)
    {
        try
        {
            $tipos= Cntc_Tipo_IngresosModel::find($IdTipoIngreso);
            $tipos->fill([
                'descripcion_ingresos'=>strtoupper($request['descripcion']),
            ]);
            $tipos->save();
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar El Tipo de Ingreso de Combustible'.$ex->getMessage())->withInput();  
            }
        return redirect()->route("cntctiposingresos.index")->withSuccess("El Tipo de Ingreso de Combustible Ha Sido Editada Exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdTipoIngreso)
    {
        try
        {
            Cntc_Tipo_IngresosModel::destroy($IdTipoIngreso);
        }
        catch (Exception $ex)
            {
                return back()->withError('Error Al Eliminar'.$ex->getMessage())->withInput();
            }
        return redirect()->route("cntctiposingresos.index")->withSuccess("El Tipo De Ingreso Ha Sido Eliminado Exitosamente");
    }
}
