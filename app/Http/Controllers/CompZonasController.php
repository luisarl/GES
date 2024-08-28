<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comp_ZonasModel;
use App\Http\Requests\CompZonasCreateRequest;
use App\Http\Requests\CompZonasUpdateRequest;
use DB;
use Exception;

class CompZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zonas = Comp_ZonasModel::all();
        return view('Compras.Zonas.Zonas', compact('zonas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Compras.Zonas.ZonasCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompZonasCreateRequest $request)
    {

        try {
            Comp_ZonasModel::create([
                'id_zona' => strtoupper($request['id_zona']),
                'nombre_zona' => strtoupper($request['nombre_zona']),
            ]);
        } catch (Exception $ex) {
            return redirect("zona")->withError('Ha Ocurrido Un Error al Crear la Zona ' . $ex->getMessage());
        }


        return redirect("zonas")->withSuccess('La Zona Ha Sido Creado Exitosamente');
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
        $zonas = Comp_ZonasModel::find($id_zona);
        return view('Compras.Zonas.ZonasEdit', compact('zonas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompZonasUpdateRequest $request, $id_zona)
    {
        try {
            $zona = Comp_ZonasModel::find($id_zona);
            $zona->fill([
                'id_zona' => strtoupper($request['id_zona']),
                'nombre_zona' => strtoupper($request['nombre_zona']),

            ]);
        $zona->save();
        } catch (Exception $ex) {
            return redirect("zonas")->withError('Ha Ocurrido Un Error al Actualizar la Zona ' . $ex->getMessage());
        }

        return redirect("zonas")->withSuccess('La Zona ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_zona)
    {
        try {
            Comp_ZonasModel::destroy($id_zona);
        } catch (Exception $ex) {
            return redirect("zonas")->withError('No se puede eliminar la zona, porque tiene Proveedores asociados'. $ex->getMessage());
        }

        return redirect("zonas")->withSuccess('La Zona Ha Sido Eliminado Exitosamente');
    }
}
