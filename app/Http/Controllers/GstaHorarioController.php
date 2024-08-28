<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gsta_HorarioModel;
use App\Http\Requests\GstaHorariosCreateRequest;
use App\Http\Requests\GstaHorariosUpdateRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class GstaHorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function index(Request $request)
    {
        $horarios= Gsta_HorarioModel::all();
        return view('GestionAsistencia.Horarios.Horario', compact('horarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
      
        return view('GestionAsistencia.Horarios.HorarioCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GstaHorariosCreateRequest $request)
    {
        // Convertir los días de la semana en una cadena separada por comas
        $dias_string = implode(',', $request->dias);
          
        //  Crear una nueva instancia del modelo Gsta_HorarioModel
        $IdHorario =  Gsta_HorarioModel::max('id_horario') + 1;

        try
        {
            Gsta_HorarioModel::create([
                'id_horario'=>$IdHorario,
                'nombre_horario'=>strtoupper($request['nombre_horario']),
                'inicio_jornada'=>$request['hora_inicio_jornada'],
                'fin_jornada'=>$request['hora_fin_jornada'],
                'inicio_descanso'=>$request['hora_inicio_descanso'],
                'fin_descanso'=>$request['hora_fin_descanso'],
                'dias_seleccionados'=>$dias_string,
    
            ]);
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Guardar El Horario '.$ex->getMessage())->withInput();
            }

        return redirect()->route("gstahorarios.index")->withSuccess('El Horario Ha Sido Creado Exitosamente.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdHorario)
    {
       
        $horario = Gsta_HorarioModel::VerHorario($IdHorario);    
        return view('GestionAsistencia.Horarios.HorarioShow', compact('horario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_horario)
    {
        $horarios = Gsta_HorarioModel::find($id_horario);
        //leer una cadena separada por comas en la base de datos
        $diasSeleccionados = explode(',', $horarios->dias_seleccionados); 

        return view('GestionAsistencia.Horarios.HorarioEdit', compact('horarios', 'diasSeleccionados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GstaHorariosUpdateRequest $request, $id_horario)
    {
        //// Convertir los días de la semana en una cadena separada por comas
        $dias_string = implode(',', $request->dias);
          
        //  Crear una nueva instancia del modelo Gsta_HorarioModel
            try
            {
             $horarios= Gsta_HorarioModel::find($id_horario);
                $horarios->fill([
                    'nombre_horario'=>strtoupper($request['nombre_horario']),
                    'inicio_jornada'=>$request['hora_inicio_jornada'],
                    'fin_jornada'=>$request['hora_fin_jornada'],
                    'inicio_descanso'=>$request['hora_inicio_descanso'],
                    'fin_descanso'=>$request['hora_fin_descanso'],
                    'dias_seleccionados'=>$dias_string,
                ]);
                $horarios->save();
            }
            catch(Exception $ex)
            {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar El Horario '.$ex->getMessage())->withInput();  
            }
    
        return redirect()->route("gstahorarios.index")->withSuccess("El Horario Ha Sido Editado Exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_horario)
    {
        try
        {
            Gsta_HorarioModel::destroy($id_horario);
        }
        catch (Exception $ex)
            {
                return back()->withError('Error Al Eliminar '.$ex->getMessage());
            }

        return redirect()->route("gstahorarios.index")->withSuccess("El Horario Ha Sido Eliminado Exitosamente");
       
    }
}
