<?php

namespace App\Http\Controllers;

// use App\Http\Requests\ActvCaracteristicasCreateRequest;
// use App\Http\Requests\ActvCaracteristicasUpdateRequest;
use App\Models\Actv_EstadosModel;
// use App\Models\Actv_TiposModel;
use Exception;
use Illuminate\Http\Request;

class ActvEstadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados = Actv_EstadosModel::ListaEstados();
        return view('Activos.Estados.Estados', compact('estados'));
    }

    public function create()
    {
        $estados = Actv_EstadosModel::select('id_estado', 'nombre_estado')->get();
        return view('Activos.Estados.EstadosCreate', compact('estados'));
    }

    public function edit($IdEstado)
    {
        $estado = Actv_EstadosModel::find($IdEstado);
        return view('Activos.Estados.EstadosEdit', compact('estado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $IdEstado = Actv_EstadosModel::max('id_estado') + 1; // Id del Grupo a Crear

        try
        {
            Actv_EstadosModel::create([
                'id_estado' => $IdEstado,
                'nombre_estado' => strtoupper($request['nombre_estado']),
            ]);

        }
        catch(Exception $ex)
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Crear el Estado'.$ex->getMessage());
            }

        return redirect("estadosactivos")->withSuccess('El estado Ha Sido Creado Exitosamente');
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
    public function update(Request $request, $IdEstado)
    {
        try 
        {
            $estado = Actv_EstadosModel::find($IdEstado);
            $estado->fill([
                'nombre_estado' => strtoupper($request['nombre_estado'])
            ]);

            $estado->save();
        } 
        catch (Exception $ex) 
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Actualizar el Estado '.$ex->getMessage());
            }

        return redirect("estadosactivos")->withSuccess('El estado Ha Sido Actualizada Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
