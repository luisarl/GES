<?php

namespace App\Http\Controllers;

use App\Http\Requests\CnthZonasCreateRequest;
use App\Http\Requests\CnthZonasUpdateRequest;
use App\Models\Cnth_ZonasModel;
use Exception;
use Illuminate\Http\Request;

class CnthZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zonas = Cnth_ZonasModel::all();
        return view('ControlHerramientas.Zonas.Zonas', compact('zonas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ControlHerramientas.Zonas.ZonasCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnthZonasCreateRequest $request)
    {
        try
        {
            Cnth_ZonasModel::create([
                'id_zona' => strtoupper($request['id_zona']),
                'nombre_zona' => strtoupper($request['nombre_zona']),
            ]);
        } 
        catch (Exception $ex) 
        {
            return redirect("zonadespacho")->withError('Ha Ocurrido Un Error al Crear la Zona ' . $ex->getMessage());
        }
        
        return redirect("zonadespacho")->withSuccess('La Zona Ha Sido Creado Exitosamente');
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
    public function edit($id_zona)
    {
        $zonas = Cnth_ZonasModel::find($id_zona);
        return view('ControlHerramientas.Zonas.ZonasEdit', compact('zonas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CnthZonasUpdateRequest $request, $id_zona)
    {
        try
        {
            $zonas = Cnth_ZonasModel::find($id_zona);
            $zonas->fill([
                'id_zona' => strtoupper($request['id_zona']),
                'nombre_zona' => strtoupper($request['nombre_zona']),

            ]);
            $zonas->save();
        } catch (Exception $ex) {
            return redirect("zonadespacho.edit")->withError('Ha Ocurrido Un Error al Actualizar la Zona ' . $ex->getMessage());
        }

        return redirect("zonadespacho")->withSuccess('La Zona ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_zona)
    {
        try
        {
           Cnth_ZonasModel::destroy($id_zona);
        } 
        catch(Exception $ex) 
        {
        return redirect("zonadespacho")->withError('No se puede eliminar la zona, porque tiene Despachos asociados'. $ex->getMessage());
        }

        return redirect("zonadespacho")->withSuccess('La Zona Ha Sido Eliminado Exitosamente');
    }
    
}
