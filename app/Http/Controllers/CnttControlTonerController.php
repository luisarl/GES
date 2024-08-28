<?php

namespace App\Http\Controllers;
use App\Models\DepartamentosModel;
use App\Models\Actv_ActivosModel;
use App\Models\Cntt_Reemplazo_TonerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CnttControlTonerCreateRequest;
use App\Http\Requests\CnttControlTonerUpdateRequest;
use Exception;

class CnttControlTonerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reemplazos= Cntt_Reemplazo_TonerModel::ListadoReemplazos();
       
        return view('ControlToner.ControlToner.Cambio',compact('reemplazos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $IdDepartamento= $request->get('departamento'); 
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
        $activos = Actv_ActivosModel::ListaImpresoras($IdDepartamento);
    
        return view('ControlToner.ControlToner.CambioCreate',compact('departamentos','activos'));
    }
    public function getImpresoras(Request $request)
    {
        $IdDepartamento = $request->get('departamento');
        $activos = Actv_ActivosModel::ListaImpresoras($IdDepartamento);
        return response()->json($activos);
    }
    public function getUltimoServicio(Request $request)
    {
        $IdDepartamento = $request->get('departamento');
        $IdImpresora = $request->get('impresora'); // Asegúrate de que esto coincide con el nombre del parámetro en el AJAX
      
        $ultimoServicio = Cntt_Reemplazo_TonerModel::ultimoservicio($IdDepartamento, $IdImpresora);
    
        return response()->json($ultimoServicio);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnttControlTonerCreateRequest $request)
    {
 
       
          $IdReemplazo =  Cntt_Reemplazo_TonerModel::max('id_reemplazo_toner') + 1;
    
     
          try
          {
            Cntt_Reemplazo_TonerModel::create([
                  'id_reemplazo_toner'=>$IdReemplazo,
                  'fecha_cambio'=>$request['fecha_cambio'],
                  'fecha_cambio_anterior'=>$request['fecha_ultimo_cambio'],
                  'id_impresora'=>$request['activo'],  
                  'id_departamento'=>$request['departamento'],
                  'cantidad_hojas_actual'=>$request['cantidad_actual'],
                  'cantidad_hojas_anterior'=>$request['cantidad_anterior'],
                  'cantidad_hojas_total'=>$request['cantidad_total'],
                  'dias_de_duracion'=>$request['dias_total'],
                  'observacion'=>$request['observacion'],
                  'tipo_servicio'=>$request['servicio'],
                  'creado_por' => Auth::user()->name,

              ]);
          }
          catch(Exception $ex)
              {
                  return redirect()->back()->withError('Ha Ocurrido Un Error Al Guardar El Control de Toner '.$ex->getMessage())->withInput();
              }
  
          return redirect()->route("cnttcontroltoner.index")->withSuccess('El Control De Toner Ha Sido Creado Exitosamente.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdReemplazo)
    {
        $reemplazo = Cntt_Reemplazo_TonerModel::Reemplazos($IdReemplazo);    
        return view('ControlToner.ControlToner.CambioShow', compact('reemplazo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$IdReemplazo)
    {
        $reemplazo= Cntt_Reemplazo_TonerModel::find($IdReemplazo);
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
       
        $activos = Actv_ActivosModel::ListaImpresoras($reemplazo->id_departamento);
      
    
      
        return view('ControlToner.ControlToner.CambioEdit', compact('reemplazo','activos','departamentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CnttControlTonerUpdateRequest $request, $IdReemplazo)
    {
        try
        {
                $reemplazo = Cntt_Reemplazo_TonerModel::find($IdReemplazo);
                $reemplazo->fill([
                  'fecha_cambio'=>$request['fecha_cambio'],
                  'id_impresora'=>$request['activo'],  
                  'cantidad_hojas_actual'=>$request['cantidad_actual'],
                  'cantidad_hojas_total'=>$request['cantidad_total'],
                  'dias_de_duracion'=>$request['dias_total'],
                  'observacion'=>$request['observacion'],
                  'tipo_servicio'=>$request['servicio'],

                   
                ]);
                $reemplazo->save();
                
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Solicitud. '.$ex->getMessage())->withInput();
            }

       
        return redirect()->route("cnttcontroltoner.edit",$IdReemplazo)->withSuccess("El Control De Toner Ha Sido Editada Exitosamente");
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
