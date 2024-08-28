<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClasificacionesModel;
use App\Models\SubclasificacionesModel;
use App\Http\Requests\SubclasificacionesCreateRequest;
use App\Http\Requests\SubclasificacionesUpdateRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use Redirect;
use Session;


class FictSubclasificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subclasificaciones = SubclasificacionesModel::with('clasificacion')->get();
        //dd($);
        return view('FichaTecnica.Subclasificaciones.Subclasificaciones', compact('subclasificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clasificaciones = ClasificacionesModel::select('id_clasificacion', 'nombre_clasificacion')->get();
        return view('FichaTecnica.Subclasificaciones.SubclasificacionesCreate', compact('clasificaciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubclasificacionesCreateRequest $request)
    {
        // $IdSubclasificacion = SubclasificacionesModel::max('id_subclasificacion') + 1;
        try {
            foreach($request->nombre_subclasificacion as $subclasificacion)//Ciclo para poder Agregar multiples subclasificaciones a una clasificacion
            {
                $IdSubclasificacion = SubclasificacionesModel::max('id_subclasificacion') + 1;
                $newSubclasificacion = new SubclasificacionesModel();
                $newSubclasificacion-> id_subclasificacion = $IdSubclasificacion;
                $newSubclasificacion->nombre_subclasificacion = $subclasificacion;
                $newSubclasificacion->id_clasificacion = $request['id_clasificacion'];
                $newSubclasificacion->visible_fict = strtoupper($request['visible_fict']);
                $newSubclasificacion->save();
            }
        }
        catch(Exception $ex)
        {
            return redirect("subclasificaciones")->withError('Ha Ocurrido Un Error al Crear la SubClasificacion' . $ex->getMessage());
        }
        

        return redirect("subclasificaciones")->withSuccess('La SubClasificacion Ha Sido Creado Exitosamente');
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
    public function edit($id_subclasificacion)
    {
        $clasificaciones = ClasificacionesModel::select('id_clasificacion', 'nombre_clasificacion')->get();
        $subclasificaciones = SubclasificacionesModel::find($id_subclasificacion);
        return view('FichaTecnica.Subclasificaciones.SubclasificacionesEdit', compact('clasificaciones', 'subclasificaciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubclasificacionesUpdateRequest $request, $id_subclasificacion)
    {
        try {
            $subclasificacion = SubclasificacionesModel::find($id_subclasificacion);
            $subclasificacion->fill([
                'nombre_subclasificacion' => strtoupper($request['nombre_subclasificacion']),
                'id_clasificacion' => $request['id_clasificacion'],
                'visible_fict' => $request['visible_fict'],
            ]);

            $subclasificacion->save();
            
        } 
        catch (Exception $ex) 
        {
            return redirect("subclasificaciones")->withError('Ha Ocurrido Un Error Al Actualizar la SubClasificacion' . $ex->getMessage());
        }

        return redirect("subclasificaciones")->withSuccess('La SubClasificacion Ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_subclasificacion)
    {
        try
        {
            $subclasificacion = SubclasificacionesModel::destroy($id_subclasificacion);
            return redirect("subclasificaciones")->withSuccess('La Subclasificacion se ha Sido Eliminado Exitosamente');
        }
        catch(Exception $e)
        {
            return redirect("subclasificaciones")->withError('No se puede eliminar la Subclasificacion, porque tiene articulos asociados');
        }
    }
}
