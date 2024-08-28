<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cenc_EquiposModel;
use App\Models\Cenc_TecnologiaModel;
use App\Models\Cenc_EquiposTecnologiaModel;
use App\Models\Cenc_TablasConsumoModel;
use App\Http\Requests\CencTablasConsumoCreateRequest;
use App\Http\Requests\CencTablasConsumoUpdateRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class CencTablasConsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $espesores = Cenc_TablasConsumoModel::ListaEspesores(); 
        return view('CentroCorte.TablasConsumo.TablasConsumo', compact('espesores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CencTablasConsumoCreateRequest $request)
    {

        $parametros = json_decode($request->parametros); //arreglo de datos adicionales

        try 
        {

            foreach ($parametros as $parametro) 
            {
                $IdTablaConsumo = Cenc_TablasConsumoModel::max('id_tabla_consumo') + 1;
                Cenc_TablasConsumoModel::create([
                    'id_tabla_consumo' => $IdTablaConsumo,
                    'id_equipo_consumible' => $parametro->id_equipo_consumible,
                    'espesor' => $parametro->valor_espesor,
                    'valor' => $parametro->valor_registro
                ]);
            }

        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Registrar Los valores: '.$ex->getMessage())->withInput();
            }
            
    return redirect("cenctablasconsumo")->withSuccess('Los valores han sido registrado Exitosamente');

    }

    public function create(Request $request)
    {
        $equipos = Cenc_EquiposModel::ListaEquipos();
        return view('CentroCorte.TablasConsumo.TablasConsumoCreate', compact('equipos'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function edit($idTablaConsumo)
     {
         $registro = Cenc_TablasConsumoModel::find($idTablaConsumo);
         $idequipotecnologia = Cenc_TablasConsumoModel::obtenerIdEquipotecnologia($registro->id_equipo_consumible); 
         $parametros = Cenc_TablasConsumoModel::parametros2((int)$idequipotecnologia[0]->id_equipotecnologia,(float)$registro->espesor);
         $datos = Cenc_TablasConsumoModel::obtenerDatos($idTablaConsumo); 
         return view('CentroCorte.TablasConsumo.TablasConsumoEdit', compact('registro','parametros','datos'));
     }
     
     
    public function update(CencTablasConsumoUpdateRequest $request, $IdEquipo)
    {

        try 
        {
            $parametros = json_decode($request->parametros); //arreglo de datos adicionales

            if ($parametros  == NULL) //Valida que el arreglo de las adicionales no este vacio
            {
                return back()->withErrors(['parametros' => 'Debe Agregar Los parametros del registro'])->withInput();
            }

            DB::transaction(function () use ($parametros){
                
                if ($parametros != "")  //verifica si el arreglo no esta vacio
                {
                    foreach($parametros as $parametro) 
                    {
                        Cenc_TablasConsumoModel::where('id_tabla_consumo', $parametro->id_tabla_consumo)
                            ->update([
                                'valor' => $parametro->valor_registro
                            ]);
                    }
                }
            });
        } 
        catch (Exception $ex) 
            {
               return redirect()->back()->withError('Ha Ocurrido Un Error Al Actualizar El Registro. '.$ex->getMessage())->withInput();
            }

        return redirect("cenctablasconsumo")->withSuccess('Los Valores Han Sido Actualizado Exitosamente');

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idTablaConsumo)
    {
        
        $registro = Cenc_TablasConsumoModel::find($idTablaConsumo);
        $idequipotecnologia = Cenc_TablasConsumoModel::obtenerIdEquipotecnologia($registro->id_equipo_consumible); 
        $parametros = Cenc_TablasConsumoModel::parametros2((int)$idequipotecnologia[0]->id_equipotecnologia,(float)$registro->espesor);

        try 
        {
            foreach($parametros as $parametro)
            {
                Cenc_TablasConsumoModel::destroy(((int)$parametro->id_tabla_consumo)); 
            }

        } 
        catch (Exception $ex) 
        {
            return back()->withError('Ha Ocurrido Un Error Al Eliminar El Registro: '.$ex->getMessage())->withInput();
        }

       return redirect('cenctablasconsumo')->withSuccess('El Registro Ha Sido Eliminado Exitosamente'); 

    }

    public function TecnologiaEquipoC($idEquipo){

        $tecnologia = Cenc_EquiposTecnologiaModel::TecnologiaEquipo($idEquipo);
        return with(["caracteristicas" => $tecnologia]);
    }


    public function IdEquipoConsumible($idEquipo, $idTecnologia)
    {
        $IdEquipoTecnologia = Cenc_EquiposTecnologiaModel::idEquipoTecnologia($idEquipo,$idTecnologia); 
        return $IdEquipoTecnologia;
    }

    public function IdConsumible($IdEquipoTecnologia)
    {
        $IdConsumibles = Cenc_TablasConsumoModel::idConsumible($IdEquipoTecnologia); 
        return with(["caracteristicas" =>  $IdConsumibles]); // cambiar el nombre de caracteristicas por consumibles, mas representativo
    }

}
