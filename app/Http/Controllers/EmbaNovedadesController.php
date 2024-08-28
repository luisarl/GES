<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmbaNovedadesCreateRequest;
use App\Http\Requests\EmbaNovedadesUpdateRequest;
use App\Models\Emba_NovedadesModel;
use App\Models\Emba_EmbarcacionesModel;
use Exception;
use Illuminate\Http\Request;

class EmbaNovedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $novedades = Emba_NovedadesModel::select('id_novedad', 'motivo_novedad')->get();
        return view('Embarcaciones.Novedades.Novedades', compact('novedades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $embarcaciones =Emba_EmbarcacionesModel::select('id_embarcaciones', 'nombre_embarcaciones')->get();
        return view('Embarcaciones.Novedades.NovedadesCreate',compact('embarcaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmbaNovedadesCreateRequest $request)
    {
        $IdNovedad = Emba_NovedadesModel::max('id_novedad') + 1;

        try 
        {
            Emba_NovedadesModel::create(
                [
                    'id_novedad' => $IdNovedad,
                    'motivo_novedad' => strtoupper($request['motivo_novedad']),
                    'descripcion_novedad' => strtoupper($request['descripcion_novedad']),
                    'id_embarcacion'=>$request['id_embarcacion']
                ]);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Novedad. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embanovedades.index')->withSuccess('La Novedad Ha Sido Creada Exitosamente.');
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
    public function edit(int $IdNovedad)
    {
        $novedad = Emba_NovedadesModel::find($IdNovedad);
        $embarcaciones =Emba_EmbarcacionesModel::select('id_embarcaciones', 'nombre_embarcaciones')->get();
        return view('Embarcaciones.Novedades.NovedadesEdit', compact('novedad','embarcaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmbaNovedadesUpdateRequest $request, int $IdNovedad)
    {
        try 
        {
            $novedad = Emba_NovedadesModel::find($IdNovedad);

            $novedad->fill(
                [
                    'motivo_novedad' => strtoupper($request['motivo_novedad']),
                    'descripcion_novedad' => strtoupper(($request['descripcion_novedad'])),
                    'id_embarcacion'=>$request['id_embarcacion']
                ]);

            $novedad->save();
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Novedad. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embanovedades.edit', $IdNovedad)->withSuccess('La Novedad Ha Sido Editada Exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $IdNovedad)
    {
        try 
        {
            Emba_NovedadesModel::destroy($IdNovedad);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Eliminar La Novedad. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embanovedades.index')->withSuccess('La Novedad Ha Sido Eliminada Exitosamente.');
    }
}
