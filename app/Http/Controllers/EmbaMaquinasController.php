<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmbaMaquinasCreateRequest;
use App\Http\Requests\EmbaMaquinasUpdateRequest;
use App\Models\Emba_Maquinas_ParametrosModel;
use App\Models\Emba_MaquinasModel;
use App\Models\Emba_ParametrosModel;
use App\Models\Emba_EmbarcacionesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmbaMaquinasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maquinas = Emba_MaquinasModel::select('id_maquina', 'nombre_maquina', 'descripcion_maquina')->get();     
        return view('Embarcaciones.Maquinas.Maquinas', compact('maquinas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parametros =Emba_ParametrosModel::select('id_parametro', 'nombre_parametro')->get();
        $embarcaciones =Emba_EmbarcacionesModel::select('id_embarcaciones', 'nombre_embarcaciones')->get();
        return view('Embarcaciones.Maquinas.MaquinasCreate', compact('parametros','embarcaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmbaMaquinasCreateRequest $request)
    {
        
        $IdMaquina = Emba_MaquinasModel::max('id_maquina') + 1;

        try 
        {
            $parametros =  json_decode($request['parametros']);

            if($parametros  == NULL) //Valida que el arreglo de las herramientas no este vacio
            {
                return back()->withErrors(['parametros'=> 'Para crear la maquina debe seleccionar uno o varios parametros'])->withInput();
            }

            DB::transaction(function () use ($IdMaquina, $request, $parametros)
            {
                Emba_MaquinasModel::create([
                    'id_maquina' => $IdMaquina,
                    'nombre_maquina' => strtoupper($request['nombre_maquina']),
                    'id_embarcaciones'=>$request['id_embarcacion'],
                    'descripcion_maquina' => strtoupper($request['descripcion_maquina']),
                ]);

                if($parametros != NULL)
                {
                    foreach($parametros as $parametro)
                    {
                        $IdMaquinaParametro = Emba_Maquinas_ParametrosModel::max('id_maquina_parametro') + 1;

                        Emba_Maquinas_ParametrosModel::create([
                            'id_maquina_parametro' => $IdMaquinaParametro,
                            'id_maquina' => $IdMaquina,
                            'id_parametro' => $parametro->id_parametro,
                            'orden' => $parametro->orden,
                            'valor_minimo' => $parametro->valor_minimo,
                            'valor_maximo' => $parametro->valor_maximo
                        ]);
                    }
                }
            });
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Maquina. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embamaquinas.edit', $IdMaquina)->withSuccess('La Maquina Ha Sido Creado Exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $IdMaquina)
    {
        $maquina = Emba_MaquinasModel::find($IdMaquina);
        $parametros =Emba_ParametrosModel::select('id_parametro', 'nombre_parametro')->get();
        $MaquinaParametros = Emba_Maquinas_ParametrosModel::MaquinaParametros($IdMaquina);
        $embarcaciones =Emba_EmbarcacionesModel::select('id_embarcaciones', 'nombre_embarcaciones')->get();
        return view('Embarcaciones.Maquinas.MaquinasEdit', compact('maquina', 'parametros', 'MaquinaParametros','embarcaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmbaMaquinasUpdateRequest $request, int $IdMaquina)
    {
        try 
        {
            $parametros =  json_decode($request['parametros']);

            DB::transaction(function () use ($IdMaquina, $request, $parametros)
            {
                $maquina =Emba_MaquinasModel::find($IdMaquina);
                $maquina->fill([
                    'nombre_maquina' => strtoupper($request['nombre_maquina']),
                    'descripcion_maquina' => strtoupper($request['descripcion_maquina']),
                    'id_embarcaciones'=>$request['id_embarcacion'],
                ]);
                $maquina->save();

                if($parametros != NULL)
                {
                    foreach($parametros as $parametro)
                    {
                        if($parametro->id_maquina_parametro == "") //si la primera columna de la tabla esta vacia busca el maximo id de la base de datos y le suma 1
                        {
                            $IdMaquinaParametro = Emba_Maquinas_ParametrosModel::max('id_maquina_parametro') + 1;
                        }
                        else //si no captura el valor de la primera columna de la tabla
                            {
                                $IdMaquinaParametro = $parametro->id_maquina_parametro;
                            }

                        //insert or update
                        Emba_Maquinas_ParametrosModel::updateOrCreate(
                            ['id_maquina_parametro' => $IdMaquinaParametro],
                            [
                            'id_maquina_parametro' => $IdMaquinaParametro,
                            'id_maquina' => $IdMaquina,
                            'id_parametro' => $parametro->id_parametro,
                            'orden' => $parametro->orden,
                            'valor_minimo' => $parametro->valor_minimo,
                            'valor_maximo' => $parametro->valor_maximo
                            ]
                        );
                    }
                }
            });
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Maquina. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embamaquinas.edit', $IdMaquina)->withSuccess('La Maquina Ha Sido Editada Exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $IdMaquina)
    {
        try
        {  
            Emba_Maquinas_ParametrosModel::where('id_maquina', $IdMaquina)->delete();
            Emba_MaquinasModel::destroy($IdMaquina);
             // Eliminar los detalles de solicitud existentes
           
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Eliminar La Maquina. '.$ex->getMessage())->withInput();
            }
        
        return redirect()->route('embamaquinas.index')->withSuccess('La Maquina Ha Sido Eliminada Exitosamente.');  
    }

    public function EliminarParametros(int $IdMaquinaParametro)
    {
        try
        {
            Emba_Maquinas_ParametrosModel::destroy($IdMaquinaParametro);
        }
            catch (Exception $e)
            {
                return back()->withError('Error Al Eliminar');
            }

        return back()->with('');
    }

    public function MaquinaParametros(int $IdMaquina)
    {
        $parametros = Emba_Maquinas_ParametrosModel::MaquinaParametros($IdMaquina);
        return with(["parametros" => $parametros]);
    }
}
