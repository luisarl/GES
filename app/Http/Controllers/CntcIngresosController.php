<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cntc_Tipo_CombustibleModel;
use App\Models\Cntc_Tipo_IngresosModel;
use App\Models\Cntc_Solicitudes_IngresoModel;
use Carbon\Carbon;
use Exception;
use App\Http\Requests\CntcIngresosCreateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class CntcIngresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $tipos= Cntc_Tipo_CombustibleModel::all();
        $TiposIngresos= Cntc_Tipo_IngresosModel::all();
        $solicitudes=Cntc_Solicitudes_IngresoModel::SolicitudIngreso();
        return view('ControlCombustible.Ingresos.Ingreso', compact('tipos','TiposIngresos','solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos= Cntc_Tipo_CombustibleModel::all();
        $TiposIngresos= Cntc_Tipo_IngresosModel::all();
        return view('ControlCombustible.Ingresos.IngresoCreate', compact('tipos','TiposIngresos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CntcIngresosCreateRequest $request)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $IdSolicitudIngreso = Cntc_Solicitudes_IngresoModel::max('id_solicitud_ingreso') + 1;
    
        try
        {
            DB::transaction(function () use ($request, $FechaActual, $IdSolicitudIngreso) 
                {
                    Cntc_Solicitudes_IngresoModel::create([
                        'id_solicitud_ingreso' => $IdSolicitudIngreso,
                        'id_combustible' => $request['id_combustible'],
                        'id_tipo_ingreso'=>$request['id_tipo_ingreso'],
                        'id_departamento' => Auth::user()->id_departamento,
                        'creado_por' => Auth::user()->name,
                        'observacion'=>$request['observacion'],
                        'fecha_creacion' => $FechaActual,
                        'cantidad'=>$request['cantidad'],
                        'stock_anterior'=>$request['stock'],
                    ]);  
                    
                    $tipoCombustible = Cntc_Tipo_CombustibleModel::where('id_tipo_combustible', '=',  $request['id_combustible'])->first();
                    $nuevoStock = $tipoCombustible->stock + $request['cantidad'];
                     // Actualiza el stock
                     $tipoCombustible->update(['stock' => $nuevoStock]);
                }
            );
         
        }
        catch(Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Solicitud. '.$ex->getMessage())->withInput();
        }
       
        return redirect(route("cntcingresos.index"))->withSuccess("El Ingreso de Combustible Ha Sido Creado Exitosamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdSolicitudIngreso)
    {
        $solicitudes=Cntc_Solicitudes_IngresoModel::SolicitudIngresodetalle($IdSolicitudIngreso);
     
        return view('ControlCombustible.Ingresos.IngresoShow', compact('solicitudes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
