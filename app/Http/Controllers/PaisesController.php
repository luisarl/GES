<?php

namespace App\Http\Controllers;
use App\Models\PaisesModel;
use App\Http\Requests\PaisesCreateRequest;
use App\Http\Requests\PaisesUpdateRequest;
use Illuminate\Http\Request;
use Exception;

class PaisesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paises = PaisesModel::all();
        // dd($paises);
        return view('Configuracion.Paises.Paises', compact('paises'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Configuracion.Paises.PaisesCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaisesCreateRequest $request)
    {
        
        try {
            PaisesModel::create([
                'id_pais' =>  strtoupper($request['id_pais']),
                'nombre_pais' => strtoupper($request['nombre_pais']),
            ]);
        } catch (Exception $ex) {
            return redirect("paises")->withError('Ha Ocurrido Un Error al Crear el Pais ' . $ex->getMessage());
        }

        return redirect("paises")->withSuccess('El Pais Ha Sido Creado Exitosamente');
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
    public function edit($id_pais)
    {
        $pais = PaisesModel::find($id_pais);
        return view('Configuracion.Paises.PaisesEdit', compact('pais'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaisesUpdateRequest $request, $id_pais)
    {
        try {
            $pais = PaisesModel::find($id_pais);
            $pais->fill([
                'nombre_pais' => strtoupper($request['nombre_pais']),

            ]);
        $pais->save();
        } catch (Exception $ex) {
            return redirect("paises")->withError('Ha Ocurrido Un Error al Actualizar el Pais ' . $ex->getMessage());
        }

        return redirect("paises")->withSuccess('El pais ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pais)
    {
        try {
            PaisesModel::destroy($id_pais);
        } catch (Exception $e) {
            return redirect("paises")->withError('No se puede eliminar el Pais, porque tiene Proveedores asociados');
        }

        return redirect("paises")->withSuccess('El pais Ha Sido Eliminado Exitosamente');
    }
}
