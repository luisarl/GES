<?php

namespace App\Http\Controllers;

use App\Http\Requests\CencFichasTiposCreateRequest;
use App\Http\Requests\CencFichasTiposUpdateRequest;
use App\Models\Actv_TiposModel;
use App\Models\Cenc_FichasTiposModel;
use Exception;
use Illuminate\Http\Request;



class CencFichasTiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = Cenc_FichasTiposModel::all();
        return view('CentroCorte.FichaTecnica.Tipos.Tipos', compact('tipos')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('CentroCorte.FichaTecnica.Tipos.TiposCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CencFichasTiposCreateRequest $request)
    {
        $IdTipo = Cenc_FichasTiposModel::max('id_tipo') + 1; // Id del Grupo a Crear

        try
        {
            Cenc_FichasTiposModel::create([
                'id_tipo' => $IdTipo,
                'nombre_tipo' => strtoupper($request['nombre_tipo']),
            ]);
        }
        catch(Exception $ex)
        {
            return back()->withErrors('Ha Ocurrido Un Error al Crear El Tipo '.$ex->getMessage());
        }

        return redirect('cencfichastipos')->withSuccess('El Tipo Ha Sido Creado Exitosamente');
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
    public function edit($IdTipo)
    {
        $tipo = Cenc_FichasTiposModel::find($IdTipo);
        return view('CentroCorte.FichaTecnica.Tipos.TiposEdit', compact('tipo')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CencFichasTiposUpdateRequest $request, $IdTipo)
    {
        try
        {
            $tipo = Cenc_FichasTiposModel::find($IdTipo);
            $tipo->fill([
                'nombre_tipo' => strtoupper($request['nombre_tipo']),
            ]);

            $tipo->save();
        }
        catch(Exception $ex)
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Actualizar El Tipo '.$ex->getMessage());
            }

        return redirect("cencfichastipos")->withSuccess('El Tipo Ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdTipo)
    {
        try
        {
            Cenc_FichasTiposModel::destroy($IdTipo);
        }
        catch(Exception $ex)
        {
            return back()->withErrors('Ha Ocurrido Un Error Al Actualizar El Tipo '.$ex->getMessage());
        }

        return redirect("cencfichastipos")->withSuccess('El Tipo Ha Sido Eliminado Exitosamente');
    
    }
}
