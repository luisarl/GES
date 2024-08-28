<?php

namespace App\Http\Controllers;

use App\Http\Requests\CnthEmpleadosCreateRequest;
use App\Http\Requests\CnthEmpleadosUpdateRequest;
use App\Models\Cnth_EmpleadosModel;
use App\Models\DepartamentosModel;
use Exception;
use Illuminate\Http\Request;

class CnthEmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Cnth_EmpleadosModel::all();
        
        return view('ControlHerramientas.Empleados.Empleados', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = DepartamentosModel::all();

        return view('ControlHerramientas.Empleados.EmpleadosCreate', compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnthEmpleadosCreateRequest $request)
    {     
        $IdEmpleado = Cnth_EmpleadosModel::max('id_empleado') + 1; // Id del responsable (empleado) a Crear

        try
        {
            Cnth_EmpleadosModel::create([
                'id_empleado' => $IdEmpleado,
                'nombre_empleado' => strtoupper($request['nombre_empleado']),
                'estatus' => strtoupper($request['estatus']),
                'id_departamento' => $request['id_departamento'],
            ]);

        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error al Crear Responsable '.$ex->getMessage());
            }

        return redirect("empleados")->withSuccess('El Responsable Ha sido Creado Exitosamente');
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
    public function edit($id_empleado)
    {
        $empleado = Cnth_EmpleadosModel::find($id_empleado);
        $departamentos = DepartamentosModel::all();

        return view('ControlHerramientas.Empleados.EmpleadosEdit', compact('empleado', 'departamentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CnthEmpleadosUpdateRequest $request, $id_empleado)
    {
        try {
            $empleado = Cnth_EmpleadosModel::find($id_empleado);
            $empleado->fill([
                'nombre_empleado' => strtoupper($request['nombre_empleado']),
                'estatus' => strtoupper($request['estatus']),
                'id_departamento' => $request['id_departamento'],
            ]);

            $empleado->save();
        }
        catch (Exception $ex) 
        {
            return redirect("empleados.edit")->withError('Ha Ocurrido Un Error al Editar el Responsable '.$ex->getMessage());
        }

        return redirect("empleados")->withSuccess('El Responsable Ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_empleado)
    {
        try
        {
            Cnth_EmpleadosModel::destroy($id_empleado);
        }
        catch (Exception $ex)
            {
                return redirect("empleados")->withError('No se puede eliminar el Responsable');
            }

        return redirect("empleados")->withSuccess('El Responsable Ha Sido Eliminado Exitosamente');
    }
}
