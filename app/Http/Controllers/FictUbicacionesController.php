<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FictUbicacionesCreateRequest;
use App\Http\Requests\FictUbicacionesUpdateRequest;
use App\Models\Almacen_UsuarioModel;
use App\Models\AlmacenesModel;
use App\Models\Fict_UbicacionesModel;
use App\Models\Fict_SubalmacenesModel;
use Illuminate\Http\Request;
use Exception;

class FictUbicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ubicaciones = Fict_UbicacionesModel::with('subalmacen')->get();
        //dd($ubicaciones);
        return view('FichaTecnica.Ubicaciones.Ubicaciones', compact('ubicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);
        $subalmacenes = Fict_SubalmacenesModel::select('id_subalmacen', 'nombre_subalmacen', 'codigo_subalmacen')->get();
        return view('FichaTecnica.Ubicaciones.UbicacionesCreate', compact('subalmacenes', 'almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FictUbicacionesCreateRequest $request)
    {
        $IdUbicacion = Fict_UbicacionesModel::max('id_ubicacion') + 1; // Id de la Ubicacion a Crear

        try {
            Fict_UbicacionesModel::create([
                'id_ubicacion' => $IdUbicacion,
                'nombre_ubicacion' => strtoupper($request['nombre_ubicacion']),
                'codigo_ubicacion' => strtoupper($request['codigo_ubicacion']),
                'id_subalmacen' => $request['id_subalmacen'],
                'creado_por' =>  Auth::user()->name
            ]);
        } catch (Exception $e) {
            return redirect("ubicacionesarticulos")->withError('Ha Ocurrido Un Error al Crear la Ubicacion' . $e);
        }

        return redirect("ubicacionesarticulos")->withSuccess('La ubicacion Ha Sido Creado Exitosamente');
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
    public function edit($id_ubicacion)
    {
        $almacenes = AlmacenesModel::all();
        $subalmacenes = Fict_SubalmacenesModel::select('id_subalmacen', 'nombre_subalmacen', 'codigo_subalmacen')->get();
        $ubicacion = Fict_UbicacionesModel::find($id_ubicacion);
        return view('FichaTecnica.Ubicaciones.UbicacionesEdit', compact('ubicacion', 'subalmacenes','almacenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_ubicacion)
    {
        try
        {
            $ubicacion = Fict_UbicacionesModel::find($id_ubicacion);
            $ubicacion->fill([
                'nombre_ubicacion' => strtoupper($request['nombre_ubicacion']),
                'id_subalmacen' => $request['id_subalmacen'],
                'actualizado_por' => Auth::user()->name
            ]);
            $ubicacion->save();
        }catch (Exception $e) 
        {
            return redirect("ubicacionesarticulos")->withError('Ha Ocurrido Un Error Al Actualizar la Ubicacion' . $e);
        }

        return redirect("ubicacionesarticulos")->withSuccess('La ubicacion Ha Sido Actualizado Exitosamente');
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
            Fict_UbicacionesModel::destroy($id_ubicacion);
        }
        catch (Exception $e)
        {
            return redirect("ubicacionesarticulos")->withError('No se puede eliminar la Ubicacion, porque tiene herramientas asociadas');
        }
      return redirect("ubicacionesarticulos")->withSuccess('La ubicacion Ha Sido Eliminado Exitosamente');

    }
}
