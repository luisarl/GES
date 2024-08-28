<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Cnth_UbicacionesModel;
use App\Models\AlmacenesModel;
use App\Http\Requests\CnthUbicacionesCreateRequest;
use App\Http\Requests\CnthUbicacionesUpdateRequest;
use Illuminate\Http\Request;
use Exception;

class CnthUbicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ubicaciones = Cnth_UbicacionesModel::with('almacen')->get();
        // dd($ubicaciones);
        return view('ControlHerramientas.Ubicaciones.Ubicaciones', compact('ubicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = AlmacenesModel::select('id_almacen', 'nombre_almacen')->get();
        return view('ControlHerramientas.Ubicaciones.UbicacionesCreate', compact('almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnthUbicacionesCreateRequest $request)
    {
        $IdUbicacion = Cnth_UbicacionesModel::max('id_ubicacion') + 1; // Id de la Ubicacion a Crear

        try {
            Cnth_UbicacionesModel::create([
                'id_ubicacion' => $IdUbicacion,
                'nombre_ubicacion' => strtoupper($request['nombre_ubicacion']),
                'codigo_ubicacion' => strtoupper($request['codigo_ubicacion']),
                'id_almacen' => $request['id_almacen'],
                'creado_por' =>  Auth::user()->name
            ]);
        } catch (Exception $e) {
            return redirect("ubicaciones")->withError('Ha Ocurrido Un Error al Crear la Ubicacion' . $e);
        }

        return redirect("ubicaciones")->withSuccess('La ubicacion Ha Sido Creado Exitosamente');
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
    public function edit($id_ubicaciones)
    {
        $almacenes = AlmacenesModel::select('id_almacen', 'nombre_almacen')->get();
        $ubicacion = Cnth_UbicacionesModel::find($id_ubicaciones);
        return view('ControlHerramientas.Ubicaciones.UbicacionesEdit', compact('ubicacion', 'almacenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CnthUbicacionesUpdateRequest $request, $id_ubicacion)
    {
        try{
            $ubicacion = Cnth_UbicacionesModel::find($id_ubicacion);
            $ubicacion->fill([
            'nombre_ubicacion' => strtoupper($request['nombre_ubicacion']),
            'codigo_ubicacion' => $request['codigo_ubicacion'],
            'id_almacen' => $request['id_almacen'],
            'actualizado_por' => Auth::user()->name
            ]); 
            $ubicacion->save();

        }
        catch(Exception $e)
        {
            return redirect("ubicaciones")->withError('Ha Ocurrido Un Error Al Actualizar la Ubicacion'.$e);
        }

        return redirect("ubicaciones")->withSuccess('La ubicacion Ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_ubicacion)
    {
        try
        {
            Cnth_UbicacionesModel::destroy($id_ubicacion);
        }
        catch (Exception $e)
        {
            return redirect("ubicaciones")->withError('No se puede eliminar la Ubicacion, porque tiene herramientas asociadas');
        }
      return redirect("ubicaciones")->withSuccess('La ubicacion Ha Sido Eliminado Exitosamente');
    }
}
