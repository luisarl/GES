<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClasificacionesModel;
use App\Http\Requests\ClasificacionesCreateRequest;
use App\Http\Requests\ClasificacionesUpdateRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use Redirect;
use Session;

class FictClasificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clasificaciones = ClasificacionesModel::all();
        return view('FichaTecnica.Clasificaciones.Clasificaciones', compact('clasificaciones') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('FichaTecnica.Clasificaciones.ClasificacionesCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClasificacionesCreateRequest $request)
    {
        $IdClasificacion = ClasificacionesModel::max('id_clasificacion') + 1; 
        try
            {
                ClasificacionesModel::create([
                    'id_clasificacion' => $IdClasificacion,
                    'nombre_clasificacion' => strtoupper($request['nombre_clasificacion']),
                ]);

            }
            catch(Exception $ex)
            {
                return redirect("clasificaciones")->withError('Ha Ocurrido Un Error al Crear la Clasificacion '.$ex->getMessage());
            }

        return redirect("clasificaciones")->withSuccess('La Clasificacion Ha Sido Creado Exitosamente');
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
    public function edit($id_clasificacion)
    {
        $clasificacion = ClasificacionesModel::find($id_clasificacion);
        return view('FichaTecnica.Clasificaciones.ClasificacionesEdit', compact('clasificacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClasificacionesUpdateRequest $request, $id_clasificacion)
    {

        $clasificacion = ClasificacionesModel::find($id_clasificacion);
        $clasificacion->fill([
            'nombre_clasificacion' => strtoupper($request['nombre_clasificacion']),
        ]);

        try
        {
            $clasificacion->save();
        }
        catch(Exception $ex)
            {
                return redirect("clasificaciones")->withError('Ha Ocurrido Un Error al Actualizar la Clasificacion '.$ex->getMessage());
            }    

        return redirect("clasificaciones")->withSuccess('La Clasificacion Ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_clasificacion)
    {
        try
        {
            ClasificacionesModel::destroy($id_clasificacion);
            return redirect("clasificaciones")->withSuccess('La Clasificacion se ha Sido Eliminado Exitosamente');
        }
        catch(Exception $e)
        {
            return redirect("clasificaciones")->withError('No se puede eliminar la clasificacion, porque tiene SubClasificacion asociados');
        }
    }
}
