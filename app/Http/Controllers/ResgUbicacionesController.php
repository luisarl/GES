<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResgUbicacionesCreateRequest;
use App\Http\Requests\ResgUbicacionesUpdateRequest;
use App\Models\Almacen_UsuarioModel;
use App\Models\AlmacenesModel;
use App\Models\Resg_UbicacionesModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResgUbicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ubicaciones = Resg_UbicacionesModel::ListaUbicaciones();
        return view('Resguardo.Ubicaciones.Ubicaciones', compact('ubicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);
        return view('Resguardo.Ubicaciones.UbicacionesCreate', compact('almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResgUbicacionesCreateRequest $request)
    {
        $IdUbicacion = Resg_UbicacionesModel::max('id_ubicacion') + 1;

        try 
        {
            Resg_UbicacionesModel::create([
                    'id_ubicacion' => $IdUbicacion,
                    'id_almacen' => $request['id_almacen'],
                    'nombre_ubicacion' => strtoupper($request['nombre_ubicacion']),
                    'descripcion_ubicacion' => strtoupper($request['descripcion_ubicacion'])
                ]);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Ubicacion. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('resgubicaciones.edit', $IdUbicacion)->withSuccess('La Ubicacion Ha Sido Creada Exitosamente.');
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
    public function edit($IdUbicacion)
    {
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);
        $ubicacion = Resg_UbicacionesModel::find($IdUbicacion);
        return view('Resguardo.Ubicaciones.UbicacionesEdit', compact('almacenes', 'ubicacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResgUbicacionesUpdateRequest $request, $IdUbicacion)
    {
        try
        {
            $ubicacion = Resg_UbicacionesModel::find($IdUbicacion);
            $ubicacion->fill([
                'id_almacen' => $request['id_almacen'],
                'nombre_ubicacion' => strtoupper($request['nombre_ubicacion']),
                'descripcion_ubicacion'  => strtoupper($request['descripcion_ubicacion'])
            ]);
            $ubicacion->save();
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Ubicacion. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('resgubicaciones.edit', $IdUbicacion)->withSuccess('La Ubicacion Ha Sido Editada Exitosamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdUbicacion)
    {
        try
        {
            Resg_UbicacionesModel::destroy($IdUbicacion);
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Eliminar La Ubicacion. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('resgubicaciones.index')->withSuccess('La Ubicacion Ha Sido Eliminada Exitosamente.');
    }
}
