<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolsServiciosCreateRequest;
use App\Http\Requests\SolsServiciosUpdateRequest;
use App\Models\DepartamentosModel;
use App\Models\Sols_ServiciosModel;
use Exception;
use Illuminate\Http\Request;

class SolsServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Sols_ServiciosModel::ListaServicios();
        return view('SolicitudesServicios.Servicios.Servicios', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->where('aplica_servicios', '=', 'SI')->get();
        return view('SolicitudesServicios.Servicios.ServiciosCreate', compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolsServiciosCreateRequest $request)
    {
        try 
        {
            $IdServicio = Sols_ServiciosModel::max('id_servicio') + 1;

            Sols_ServiciosModel::create([
                    
                'id_servicio' => $IdServicio,
                'id_departamento' => $request['id_departamento'],
                'nombre_servicio' => strtoupper($request['nombre_servicio']),
                'descripcion_servicio' => strtoupper($request['descripcion_servicio'])

            ]);
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Crear El Servicio: '.$ex->getMessage())->withInput();
            }
            
        return redirect()->route('servicios.edit',$IdServicio)->withSuccess('El Servicio Ha Sido Creado Exitosamente');    
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
    public function edit($IdServicio)
    {
        $servicio = Sols_ServiciosModel::find($IdServicio);
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->where('aplica_servicios', '=', 'SI')->get();
        return view('SolicitudesServicios.Servicios.ServiciosEdit', compact('servicio','departamentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SolsServiciosUpdateRequest $request, $IdServicio)
    {
        $servicio = Sols_ServiciosModel::find($IdServicio);

        try 
        {
            $servicio->fill([
                    
                'id_servicio' => $IdServicio,
                'id_departamento' => $request['id_departamento'],
                'nombre_servicio' => strtoupper($request['nombre_servicio']),
                'descripcion_servicio' => strtoupper($request['descripcion_servicio'])

            ]);

            $servicio->save();
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Actualizar El Servicio: '.$ex->getMessage())->withInput();
            }
            
        return redirect()->route('servicios.edit',$IdServicio)->withSuccess('El Servicio Ha Sido Actualizado Exitosamente');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdServicio)
    {
        try 
        {
            Sols_ServiciosModel::destroy($IdServicio);
        } 
        catch (Exception $ex) 
        {
            return back()->withError('Ha Ocurrido Un Error Al Eliminar El Servicio: '.$ex->getMessage())->withInput();
        }

       return redirect('servicios')->withSuccess('El Servicio Ha Sido Eliminado Exitosamente');  
    }
}
