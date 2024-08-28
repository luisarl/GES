<?php

namespace App\Http\Controllers;

use App\Models\Gsta_EmpleadosModel;
use App\Models\Gsta_HorarioModel;
use Illuminate\Http\Request;
use App\Http\Requests\GstaEmpleadosCreatedRequest;
use App\Http\Requests\GstaEmpleadosUpdateRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class GstaEmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados= Gsta_EmpleadosModel::ListadoPersonal();
        $horarios = Gsta_HorarioModel::select('id_horario', 'nombre_horario')->get();
        return view('GestionAsistencia.Empleados.Empleados',compact('empleados','horarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_empleado)
    {
       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GstaEmpleadosCreatedRequest $request)
    {
        $IdHorarioEmpleado = Gsta_EmpleadosModel::max('id_horario_empleado') + 1;
        try
        {
            Gsta_EmpleadosModel::create([

             'id_horario_empleado'=>$IdHorarioEmpleado,
             'id_biometrico'=>$request['id_biometrico'],
             'id_empleado'=>$request['id_empleado'],
             'id_horario'=>$request['id_horario'],
             ]);
        }
        catch(Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Asignar El Horario'.$ex->getMessage())->withInput();
        }
       
        return redirect()->route("gstaempleados.index")->withSuccess("El Horario Ha Sido Asignado Exitosamente");
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
    public function edit($id_horario_empleado)
    {
        $empleados=Gsta_EmpleadosModel::ListadoHorarioPersona($id_horario_empleado);
       
        $horarios = Gsta_HorarioModel::select('id_horario', 'nombre_horario')->get();
        return view('GestionAsistencia.Empleados.EmpleadosEdit',compact('empleados','horarios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GstaEmpleadosUpdateRequest $request, $id_horario_empleado)
    {
        try
        {
            $empleados= Gsta_EmpleadosModel::find($id_horario_empleado);
            $empleados->fill([
                  
                'id_horario'=>$request['id_horario'],
            ]);
            $empleados->save();
                        
        }
        catch(Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar El Horario Del Empleado'.$ex->getMessage())->withInput();
        }
        return redirect()->route("gstaempleados.index")->withSuccess("El Horario Asignado Ha Sido Editado Exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Asignar($id_empleado)
    {
        $empleados =Gsta_EmpleadosModel::ListadoPersonal($id_empleado);
        $horarios = Gsta_HorarioModel::select('id_horario', 'nombre_horario')->get();
        return view('GestionAsistencia.Empleados.EmpleadosCreate',compact('empleados','horarios'));
    }
}
