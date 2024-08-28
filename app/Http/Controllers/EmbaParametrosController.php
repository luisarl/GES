<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmbaParametrosCreateRequest;
use App\Http\Requests\EmbaParametrosUpdateRequest;
use App\Models\Emba_ParametrosModel;
use App\Models\Emba_UnidadesModel;
use Exception;
use Illuminate\Http\Request;

class EmbaParametrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parametros =  Emba_ParametrosModel::all();
        return view('Embarcaciones.Parametros.Parametros',compact('parametros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unidades = Emba_UnidadesModel::select('id_unidad', 'nombre_unidad')->get();
        return view('Embarcaciones.Parametros.ParametrosCreate', compact('unidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmbaParametrosCreateRequest $request)
    {
        $IdParametro = Emba_ParametrosModel::max('id_parametro') + 1;

        try 
        {
            Emba_ParametrosModel::create([
                'id_parametro' => $IdParametro,
                'nombre_parametro' => strtoupper($request['nombre_parametro']),
                'descripcion_parametro' => strtoupper($request['descripcion_parametro']),
                'id_unidad' => $request['id_unidad']
            ]);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear El Parametro. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embaparametros.edit', $IdParametro)->withSuccess('El Parametro Ha Sido Creado Exitosamente.');
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
    public function edit(int $IdParametro)
    {
        $parametro = Emba_ParametrosModel::find($IdParametro);
        $unidades = Emba_UnidadesModel::select('id_unidad', 'nombre_unidad')->get();

        return view('Embarcaciones.Parametros.ParametrosEdit', compact('parametro', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmbaParametrosUpdateRequest $request, int $IdParametro)
    {
        try 
        {
            $parametro = Emba_ParametrosModel::find($IdParametro);
            $parametro->fill([
                'nombre_parametro' => strtoupper($request['nombre_parametro']),
                'descripcion_parametro' => strtoupper($request['descripcion_parametro']),
                'id_unidad' => $request['id_unidad']
            ]);
            $parametro->save();
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar El Parametro. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embaparametros.edit', $IdParametro)->withSuccess('El Parametro Ha Sido Editado Exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $IdParametro)
    {
        try
        {
            Emba_ParametrosModel::destroy($IdParametro);
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Eliminar El Parametro. '.$ex->getMessage())->withInput();
            }
        
        return redirect()->route('embaparametros.index')->withSuccess('El Parametro Ha Sido Eliminado Exitosamente.');    
    }
}
