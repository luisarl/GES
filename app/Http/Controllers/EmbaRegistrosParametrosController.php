<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmbaRegistrosParametrosCreateRequest;
use App\Http\Requests\EmbaRegistrosParametrosUpdateRequest;
use App\Models\Emba_MaquinasModel;
use App\Models\Emba_Registros_ParametrosModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmbaRegistrosParametrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maquinas = Emba_MaquinasModel::select('id_maquina', 'nombre_maquina')->get();
        return view('Embarcaciones.RegistrosParametros.RegistrosParametros', compact('maquinas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maquinas =  Emba_MaquinasModel::select('id_maquina', 'nombre_maquina')->get();
        return view('Embarcaciones.RegistrosParametros.RegistrosParametrosCreate', compact('maquinas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmbaRegistrosParametrosCreateRequest $request)
    {
        //dd($request->all());
        try 
        {
            $registros =  Emba_Registros_ParametrosModel::ContarRegistrosMaquinaFecha($request['id_maquina'], $request['fecha']);

            //VALIDA SI YA FUERON REGISTRADOS LOS REGISTROS DE LAS 24 HORAS
            if($registros == 24 )
            {
                return back()->withAlert('Los Registros De La Fecha '. date('d-m-Y', strtotime($request['fecha'])). ' Han Sido Completados.')->withInput();
            }

            $parametros = json_decode($request['parametros']);

            //VALIDA SI NO HAY PARAMETROS
            if($parametros == NULL)
            {
                return back()->withErrors(['parametros' => 'No Se Puede Guardar Sin Parametros'])->withInput();
            }

            //VALIDA SI HAY VALORES VACIOS
            foreach($parametros as $parametro)
            {
                if($parametro->valor == "")
                {
                    return back()->withErrors(['parametros' => 'El Valor De Los Parametros No Pueden Estar Vacios'])->withInput();
                }
            }

            foreach($parametros as $parametro)
            {
                $IdRegistroParametro =  Emba_Registros_ParametrosModel::max('id_registro_parametro') + 1;

                Emba_Registros_ParametrosModel::create([
                    'id_registro_parametro' => $IdRegistroParametro,
                    'id_maquina' => $request['id_maquina'],
                    'id_parametro' => $parametro->id_parametro,
                    'valor' => $parametro->valor,
                    'fecha' => $request['fecha'],
                    'hora' => $parametro->hora,
                    'observaciones' => strtoupper($request['observaciones']),
                    'creado_por' => Auth::user()->id,
                    'actualizado_por' => Auth::user()->id,
                ]);
            }
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Realizar El Registro. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embaregistrosparametros.index')->withSuccess('El Registro Se Ha Realizado Exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $IdMaquina = 5;
        $fecha = '28-11-2023';

        return  Emba_Registros_ParametrosModel::RegistroParametrosHoras($IdMaquina, $fecha);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        return abort(404);
        // $maquinas = MaquinasModel::select('id_maquina', 'nombre_maquina')->get();
        // return view('RegistrosParametros.RegistrosParametrosEdit', compact('maquinas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmbaRegistrosParametrosUpdateRequest $request, int $id)
    {
        // try 
        // {
        //     $parametros = json_decode($request['parametros']);

        //     if($parametros == NULL)
        //     {
        //         return back()->withErrors(['parametros' => 'No Se Puede Guardar Sin Parametros'])->withInput();
        //     }

        //     foreach($parametros as $parametro)
        //     {
        //         Registros_ParametrosModel::where('id_registro_parametro', $parametro->id_registro_parametro)
        //             ->update([
        //                 'id_maquina' => $request['id_maquina'],
        //                 'id_parametro' => $parametro->id_parametro,
        //                 'valor' => $parametro->valor,
        //                 'fecha' => $request['fecha'],
        //                 'hora' => $parametro->hora,
        //                 'observaciones' => strtoupper($request['observaciones']),
        //                 'actualizado_por' => Auth::user()->id,
        //             ]);
        //     }
        // } 
        // catch (Exception $ex) 
        //     {
        //         return redirect()->back()->withError('Ha Ocurrido Un Error Al Actualizar El Registro. '.$ex->getMessage())->withInput();
        //     }

        // return redirect()->route('registrosparametros.index')->withSuccess('El Registro Se Ha Actualizado Exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function RegistroParametrosPDF(Request $request)
    {
        $registros =  Emba_Registros_ParametrosModel::BuscarRegistroParametros($request->id_maquina, $request->fecha);
        $observaciones =  Emba_Registros_ParametrosModel::BuscarObservacionesRegistroParametros($request->id_maquina, $request->fecha);
        $pdf = Pdf::loadView('Embarcaciones.RegistrosParametros.RegistrosParametrosPDF', compact('registros', 'observaciones'))->setPaper('letter', 'landscape');;
        return $pdf->stream('Registros'.$request->id_maquina.'_'.$request->fecha.'.pdf');
    } 

    public function destroy(string $id)
    {
        return abort(404);
    }

    public function DatosCrearRegistroParametros(Request $request)
    {
        $DatosRegistro =  Emba_Registros_ParametrosModel::DatosCrearRegistroParametros($request->id_maquina, $request->fecha);
        return with(["parametros" => $DatosRegistro]);
    }

    public function BuscarRegistroParametros(Request $request)
    {
        $DatosRegistro =  Emba_Registros_ParametrosModel::BuscarRegistroParametros($request->id_maquina, $request->fecha);
        return with(["parametros" => $DatosRegistro]);
    }

    public function BuscarObservacionesRegistroParametros(Request $request)
    {
        $ObservacionesRegistro =  Emba_Registros_ParametrosModel::BuscarObservacionesRegistroParametros($request->id_maquina, $request->fecha);
        return with(["observaciones" => $ObservacionesRegistro]);
    }
}
