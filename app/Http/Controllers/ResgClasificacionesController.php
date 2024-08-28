<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResgClasificacionesCreateRequest;
use App\Http\Requests\ResgClasificacionesUpdateRequest;
use App\Models\Resg_ClasificacionesModel;
use Exception;
use Illuminate\Http\Request;

class ResgClasificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $clasificaciones = Resg_ClasificacionesModel::select('id_clasificacion', 'nombre_clasificacion')->get();
       return view('Resguardo.Clasificaciones.Clasificaciones', compact('clasificaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Resguardo.Clasificaciones.ClasificacionesCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResgClasificacionesCreateRequest $request)
    {
        $IdClasificacion = Resg_ClasificacionesModel::max('id_clasificacion') + 1;

        try 
        {
            Resg_ClasificacionesModel::create([
                    'id_clasificacion' => $IdClasificacion,
                    'nombre_clasificacion' => strtoupper($request['nombre_clasificacion']),
                    'descripcion_clasificacion' => strtoupper($request['descripcion_clasificacion'])
                ]);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Clasificacion. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('resgclasificaciones.edit', $IdClasificacion)->withSuccess('La Clasificacion Ha Sido Creada Exitosamente.');
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
    public function edit($IdClasificacion)
    {
        $clasificacion = Resg_ClasificacionesModel::find($IdClasificacion);
        return view('Resguardo.Clasificaciones.ClasificacionesEdit', compact('clasificacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResgClasificacionesUpdateRequest $request, $IdClasificacion)
    {
        try
        {
            $clasificacion = Resg_ClasificacionesModel::find($IdClasificacion);
            $clasificacion->fill([
                'nombre_clasificacion' => strtoupper($request['nombre_clasificacion']),
                'descripcion_clasificacion'  => strtoupper($request['descripcion_clasificacion'])
            ]);
            $clasificacion->save();
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Clasificacion. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('resgclasificaciones.edit', $IdClasificacion)->withSuccess('La Clasificacion Ha Sido Editada Exitosamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdClasificacion)
    {
        try
        {
            Resg_ClasificacionesModel::destroy($IdClasificacion);
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Eliminar La Clasificacion. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('resgclasificaciones.index')->withSuccess('La Clasificacion Ha Sido Eliminada Exitosamente.');
    }
}
