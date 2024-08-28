<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsalVehiculosCreateRequest;
use App\Http\Requests\AsalVehiculosUpdateRequest;
use App\Models\Asal_VehiculosModel;
use Exception;
use Illuminate\Http\Request;

class AsalVehiculosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos = Asal_VehiculosModel::all();
        return view('SalidaMateriales.Vehiculos.Vehiculos', compact('vehiculos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SalidaMateriales.Vehiculos.VehiculosCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsalVehiculosCreateRequest $request)
    {
        $IdVehiculo =  Asal_VehiculosModel::max('id_vehiculo') + 1; 
        try
            {
                Asal_VehiculosModel::create([
                    'id_vehiculo' => $IdVehiculo,
                    'activo' => strtoupper($request['activo']),
                    'placa_vehiculo' => strtoupper($request['placa_vehiculo']),
                    'marca_vehiculo' => strtoupper($request['marca_vehiculo']),
                    'modelo_vehiculo' => strtoupper($request['modelo_vehiculo']),
                    'descripcion' => strtoupper($request['descripcion']),
                ]);

            }
            catch(Exception $ex)
            {
                return redirect("vehiculos")->withError('Ha Ocurrido Un Error al Crear el Vehiculo '.$ex->getMessage());
            }

        return redirect("vehiculos")->withSuccess('El Vehiculo Ha Sido Creado Exitosamente');
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
    public function edit($id_vehiculo)
    {
        $vehiculo = Asal_VehiculosModel::find($id_vehiculo);
        return view('SalidaMateriales.Vehiculos.VehiculosEdit', compact('vehiculo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AsalVehiculosUpdateRequest $request, $id_vehiculo)
    {
        try
        {
            $vehiculo = Asal_VehiculosModel::find($id_vehiculo);
            
            $vehiculo->fill([
                'activo' => strtoupper($request['activo']),
                'marca_vehiculo' => strtoupper($request['marca_vehiculo']),
                'modelo_vehiculo' => strtoupper($request['modelo_vehiculo']),
                'descripcion' => strtoupper($request['descripcion']),
            ]);
            $vehiculo->save();        
    
            return redirect("vehiculos")->withSuccess('El Vehiculo Ha Sido actualizado Exitosamente');

        }
        catch(Exception $ex)
        {
            return redirect("vehiculos")->withError('El Vehiculo No ha sido Actualizado', $ex->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_vehiculo)
    {
        try
        {        
            Asal_VehiculosModel::destroy($id_vehiculo);
        }
        catch(Exception $e)
        {
            return redirect("vehiculos")->withError('No se puede eliminar el vehiculo, porque tiene despachos asociados');
        }

    return redirect("vehiculos")->withSuccess('El vehiculo Ha Sido Eliminado Exitosamente');
    }
}
