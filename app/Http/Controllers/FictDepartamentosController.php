<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DepartamentosCreateRequest;
use App\Http\Requests\DepartamentosUpdateRequest;
use App\Models\DepartamentosModel;
use Illuminate\Support\Facades\DB;
use Exception;
use Redirect;
use Session;

use Illuminate\Http\Request;

class FictDepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos  = DepartamentosModel::all();
        return view('Configuracion.Departamentos.Departamentos', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Configuracion.Departamentos.DepartamentosCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartamentosCreateRequest $request)
    {
        $IdDepartamento = DepartamentosModel::max('id_departamento') + 1; // Id del Departamento a Crear

        if($request->has('aplica_servicios'))
        {
            $AplicaServicios = 'SI';
        }
        else
            {
                $AplicaServicios = 'NO';
            }
       
        try
        {
            DepartamentosModel::create([
                'id_departamento' => $IdDepartamento,
                'nombre_departamento' => strtoupper($request['nombre_departamento']),
                'prefijo' => strtoupper($request['prefijo']),
                'responsable' => strtoupper($request['responsable']),
                'correo' => $request['correo'],
                'aplica_servicios' => strtoupper($AplicaServicios),
                'correlativo_servicios' => $request['correlativo_servicios'],
            ]);
            
        }
        catch(Exception $ex)
        {
            return redirect("departamentos")->withError('Ha Ocurrido Un Error al Crear El Departamento '.$ex->getMessage());
        }

    return redirect("departamentos")->withSuccess('El Departamento Ha Sido Creado Exitosamente');
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
    public function edit($id_departamento)
    {
        $departamento = DepartamentosModel::find($id_departamento);
        return view('Configuracion.Departamentos.DepartamentosEdit', compact('departamento'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartamentosUpdateRequest $request, $id_departamento)
    {
        try
        {
            if($request->has('aplica_servicios'))
            {
                $AplicaServicios = 'SI';
            }
            else
                {
                    $AplicaServicios = 'NO';
                }

            $departamento = DepartamentosModel::find($id_departamento);
            
            $departamento->fill([
                'nombre_departamento' => strtoupper($request['nombre_departamento']),
                'prefijo' => strtoupper($request['prefijo']),
                'responsable' => strtoupper($request['responsable']),
                'correo' => $request['correo'],
                'aplica_servicios' => strtoupper($AplicaServicios),
        ]);
            $departamento->save();        
        }
        catch(Exception $ex)
        {
            return redirect("departamentos")->withError('El Departamento No ha sido Actualizado', $ex->getMessage());
        }

        return redirect("departamentos")->withSuccess('El Departamento Ha Sido Actualizado Exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_departamento)
    {
        try
        {
            $departamento = DepartamentosModel::find($id_departamento);
            DepartamentosModel::destroy($id_departamento);

        }
        catch(Exception $e)
        {
            return redirect("departamentos")->withError('No se puede eliminar el departamento, porque tiene Usuarios asociados');
        }

    return redirect("departamentos")->withSuccess('El Departamento Ha Sido Eliminado Exitosamente');
    }
}
