<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolsSubServiciosCreateRequest;
use App\Http\Requests\SolsSubServiciosUpdateRequest;
use App\Models\Sols_ServiciosModel;
use App\Models\Sols_SubServiciosModel;
use Exception;
use Illuminate\Http\Request;

class SolsSubServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subservicios = Sols_SubServiciosModel::ListaSubServicios();
        return view('SolicitudesServicios.SubServicios.SubServicios', compact('subservicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $servicios = Sols_ServiciosModel::ListaServicios();
        return view('SolicitudesServicios.SubServicios.SubServiciosCreate', compact('servicios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolsSubServiciosCreateRequest $request)
    {
        try 
        {
            $IdSubServicio = Sols_SubServiciosModel::max('id_subservicio') +1;

            Sols_SubServiciosModel::create([
                'id_subservicio' => $IdSubServicio,
                'nombre_subservicio' => strtoupper($request['nombre_subservicio']),
                'descripcion_subservicio' => strtoupper($request['descripcion_subservicio']),
                'id_servicio' => $request['id_servicio']
            ]);

        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Crear El SubServicio '.$ex->getMessage())->withInput();
            }
        
        return redirect()->route('subservicios.edit', $IdSubServicio)->withSuccess('El SubServicio Ha Sido Creado Exitosamente');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdSubServicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdSubServicio)
    {
        $servicios = Sols_ServiciosModel::ListaServicios();
        $subservicio = Sols_SubServiciosModel::find($IdSubServicio);
        return view('SolicitudesServicios.SubServicios.SubServiciosEdit', compact('servicios','subservicio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SolsSubServiciosUpdateRequest $request, $IdSubServicio)
    {
        try
        {
            $subservicios = Sols_SubServiciosModel::find($IdSubServicio);

            $subservicios->fill([
                'nombre_subservicio' => strtoupper($request['nombre_subservicio']),
                'descripcion_subservicio' => strtoupper($request['descripcion_subservicio']),
                'id_servicio' => $request['id_servicio']
            ]);

            $subservicios->save();
        }
        catch(Exception $ex)
            {
                return back()->withError('Ha Ocurrido Un Error Al Actualizar El SubServicio '.$ex->getMessage())->withInput();
            }
    
        return redirect()->route('subservicios.edit', $IdSubServicio)->withSuccess('El SubServicio Ha Sido Actualizado Exitosamente');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdSubServicio)
    {
        try 
        {
           Sols_SubServiciosModel::destroy($IdSubServicio);
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Eliminar El SubServicio '.$ex->getMessage());
            }
        
        return redirect('subservicios')->withSuccess('El SubServicio Ha Sido Eliminado Exitosamente');   
    }
}
