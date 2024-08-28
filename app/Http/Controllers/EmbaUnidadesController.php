<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmbaUnidadesCreateRequest;
use App\Http\Requests\EmbaUnidadesUpdateRequest;
use App\Models\Emba_UnidadesModel;
use Exception;
use Illuminate\Http\Request;

class EmbaUnidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unidades = Emba_UnidadesModel::select('id_unidad', 'nombre_unidad', 'abreviatura')->get();
        return view('Embarcaciones.Unidades.Unidades', compact('unidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Embarcaciones.Unidades.UnidadesCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmbaUnidadesCreateRequest $request)
    {
      
        $IdUnidad = Emba_UnidadesModel::max('id_unidad') + 1;
        
        try 
        {
            Emba_UnidadesModel::create(
                [
                    'id_unidad' => $IdUnidad,
                    'nombre_unidad' => strtoupper($request['nombre_unidad']),
                    'descripcion_unidad' => strtoupper($request['descripcion_unidad']),
                    'abreviatura' => strtoupper($request['abreviatura'])
                ]);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Unidad De Medida. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embaunidades.index')->withSuccess('La Unidad De Medida Ha Sido Creada Exitosamente.');
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
    public function edit(int $IdUnidad)
    {
        $unidad = Emba_UnidadesModel::find($IdUnidad);
        return view('Embarcaciones.Unidades.UnidadesEdit', compact('unidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmbaUnidadesUpdateRequest $request, int $IdUnidad)
    {
        try 
        {
            $novedad = Emba_UnidadesModel::find($IdUnidad);

            $novedad->fill(
                [
                    'nombre_unidad' => strtoupper($request['nombre_unidad']),
                    'descripcion_unidad' => strtoupper($request['descripcion_unidad']),
                    'abreviatura' => strtoupper($request['abreviatura'])
                ]);

            $novedad->save();
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Unidad De Medida. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embaunidades.edit', $IdUnidad)->withSuccess('La Unidad De Medida Ha Sido Editada Exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $IdUnidad)
    {
        try 
        {
            Emba_UnidadesModel::destroy($IdUnidad);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Eliminar La Unidad De Medida. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embaunidades.index')->withSuccess('La Unidad De Medida Ha Sido Eliminada Exitosamente.');
    }
}
