<?php

namespace App\Http\Controllers;
use App\Models\Gsta_AsistenciasValidacionModel;
use App\Models\Gsta_ValidacionNovedadesModel;
use App\Models\DepartamentosModel;
use App\Models\Gsta_NovedadesModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GstaAsistenciaValidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $fecha = $request->get('fecha_inicio');
        $departamento = $request->departamento;
        $departamentos = Gsta_AsistenciasValidacionModel::DepartamentosNomina();
        $empresa = $request->empresa;
        $empresas = Gsta_AsistenciasValidacionModel::EmpresasNomina();
        $novedades = Gsta_NovedadesModel::select('id_novedad', 'descripcion')->get();
    
        if ($fecha != null) {
            $personal = Gsta_AsistenciasValidacionModel::ListadoAsistencia($departamento, $empresa, $fecha);
        } else {
            $personal = Gsta_AsistenciasValidacionModel::ListadoAsistencia($departamento, 'NINGUNA', $fecha);
        }
    
        // Recorrer el listado de personal y obtener el horario de cada empleado
        foreach ($personal as $persona) {
            $horarioEmpleado = Gsta_AsistenciasValidacionModel::HorarioEmpleado($persona->cod_biometrico);
       //dd($horarioEmpleado);
            if ($horarioEmpleado !== null) {
                if (($persona->primera_hora === '00:00:00.0000000' || $persona->primera_hora === null) && ($persona->ultima_hora === '00:00:00.0000000' || $persona->ultima_hora === null)) {
                    $persona->novedad = 'SIN MARCAJE';
                } elseif ($persona->primera_hora > $horarioEmpleado->inicio_jornada && $persona->ultima_hora < $horarioEmpleado->fin_jornada) {
                    $persona->novedad = 'ENTRADA TARDIA Y SALIDA ANTICIPADA';
                } elseif ($persona->primera_hora > $horarioEmpleado->inicio_jornada && $persona->ultima_hora > $horarioEmpleado->fin_jornada) {
                    $persona->novedad = 'ENTRADA TARDIA Y SALIDA TARDIA';
                } elseif ($persona->primera_hora < $horarioEmpleado->inicio_jornada && $persona->ultima_hora > $horarioEmpleado->fin_jornada) {
                    $persona->novedad = 'ENTRADA ANTICIPADA Y SALIDA TARDIA';
                } elseif ($persona->primera_hora < $horarioEmpleado->inicio_jornada && $persona->ultima_hora < $horarioEmpleado->fin_jornada) {
                    $persona->novedad = 'ENTRADA ANTICIPADA Y SALIDA ANTICIPADA';
                }
                 elseif ($persona->primera_hora < $horarioEmpleado->inicio_jornada) {
                    $persona->novedad = 'ENTRADA ANTICIPADA';
                } elseif ($persona->primera_hora > $horarioEmpleado->inicio_jornada) {
                    $persona->novedad = 'ENTRADA TARDIA';
                } elseif ($persona->ultima_hora < $horarioEmpleado->fin_jornada) {
                    $persona->novedad = 'SALIDA ANTICIPADA';
                }elseif ($persona->ultima_hora > $horarioEmpleado->fin_jornada) {
                    $persona->novedad = 'SALIDA TARDIA';
                } else {
                    $persona->novedad = 'SIN NOVEDAD'; // No hay novedad
                }
            } else {
                $persona->novedad = ''; // No se pudo obtener el horario, por lo que no hay novedad
            }
        }
       
        return view('GestionAsistencia.ValidarAsistencias.ValidarAsistencia', compact('personal', 'departamentos', 'novedades', 'empresas'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $EstatusValidacion = 'VALIDADO';
        $DireccionIp = $request->ip();
        $NombreEquipo = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $validaciones = json_decode($request->validaciones);


        try
        {
            DB::transaction(function () use ($validaciones, $FechaActual,$EstatusValidacion, $DireccionIp, $NombreEquipo){
                foreach($validaciones as $validacion)
                {
                        $IdValidacion =  Gsta_AsistenciasValidacionModel::max('id_validacion') + 1;
                
                        Gsta_AsistenciasValidacionModel::create([

                                'id_validacion'=>$IdValidacion,
                                'id_biometrico' => $validacion->id_biometrico,
                                'id_empleado'=> $validacion->id_empleado,
                                'nombre_empleado'=>$validacion->nombre_empleado,
                                'fecha_validacion' => $validacion->fecha_validacion,
                                'hora_entrada' => $validacion->hora_entrada,
                                'hora_salida' => $validacion->hora_salida,
                                'id_departamento' => $validacion->id_departamento,
                                'id_empresa'=> $validacion->id_empresa,
                                'nombre_empresa'=> $validacion->nombre_empresa,
                                'observacion' => strtoupper($validacion->observacion),
                                'estatus' => $EstatusValidacion,
                                'creado_por' => Auth::user()->name,
                                'fecha_creacion' => $FechaActual,
                                'nombre_equipo' => $NombreEquipo,
                                'direccion_ip' => $DireccionIp,
                            ]);


                                $id_novedades = $validacion->id_novedad; // $id_novedades es un array con los IDs de las novedades

                                foreach ($id_novedades as $id_novedad){ 
                                    $IdvalidacionNovedad=   Gsta_ValidacionNovedadesModel::max('id_validacion_novedades') + 1;
                                        Gsta_ValidacionNovedadesModel::create([

                                    'id_validacion_novedades' => $IdvalidacionNovedad,
                                    'id_validacion'=>$IdValidacion,
                                    'id_novedad'=> $id_novedad,
                                ] );
                                }
                                
                                DB::connection('BIOMETRICO')
                                        ->table('registros')
                                        ->where('id_empleado', '=', $validacion->id_biometrico )
                                        ->where('fecha', '=', $validacion->fecha_validacion )
                                        ->update(['estatus' => 'VALIDADO']);
                    
                }
            });
        }
        catch(Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Validar La Asistencia'.$ex->getMessage())->withInput();  
        }
       return redirect()->back()->withSuccess('Se Ha Validado La Asistencia Exitosamente');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id_
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ListadoValidacionEditar(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
   
        $departamento = $request->departamento;
        $departamentos = Gsta_AsistenciasValidacionModel::DepartamentosNomina();
        $empresa = $request->empresa;
        $empresas= Gsta_AsistenciasValidacionModel::EmpresasNomina();
        $novedades = Gsta_NovedadesModel::select('id_novedad', 'descripcion')->get();
        $validaciones = Gsta_AsistenciasValidacionModel::ListadoValidaciones($departamento,$empresa,$FechaInicio,$FechaInicio);

        foreach ($validaciones as $validacion) {
            $horarioEmpleado = Gsta_AsistenciasValidacionModel::HorarioEmpleado($validacion->id_biometrico);
            if ($horarioEmpleado !== null) {
                if (($validacion->primera_hora == '00:00:00.0000000' || $validacion->primera_hora === null) && ($validacion->ultima_hora === '00:00:00.0000000' || $validacion->ultima_hora === null)) {
                    $validacion->novedad = 'SIN MARCAJE';
                } elseif ($validacion->primera_hora > $horarioEmpleado->inicio_jornada && $validacion->ultima_hora < $horarioEmpleado->fin_jornada) {
                    $validacion->novedad = 'ENTRADA TARDIA Y SALIDA ANTICIPADA';
                } elseif ($validacion->primera_hora > $horarioEmpleado->inicio_jornada && $validacion->ultima_hora > $horarioEmpleado->fin_jornada) {
                    $validacion->novedad = 'ENTRADA TARDIA Y SALIDA TARDIA';
                } elseif ($validacion->primera_hora < $horarioEmpleado->inicio_jornada && $validacion->ultima_hora > $horarioEmpleado->fin_jornada) {
                    $validacion->novedad = 'ENTRADA ANTICIPADA Y SALIDA TARDIA';
                } elseif ($validacion->primera_hora < $horarioEmpleado->inicio_jornada && $validacion->ultima_hora < $horarioEmpleado->fin_jornada) {
                    $validacion->novedad = 'ENTRADA ANTICIPADA Y SALIDA ANTICIPADA';
                }
                 elseif ($validacion->primera_hora < $horarioEmpleado->inicio_jornada) {
                    $validacion->novedad = 'ENTRADA ANTICIPADA';
                } elseif ($validacion->primera_hora > $horarioEmpleado->inicio_jornada) {
                    $validacion->novedad = 'ENTRADA TARDIA';
                } elseif ($validacion->ultima_hora < $horarioEmpleado->fin_jornada) {
                    $validacion->novedad = 'SALIDA ANTICIPADA';
                }elseif ($validacion->ultima_hora > $horarioEmpleado->fin_jornada) {
                    $validacion->novedad = 'SALIDA TARDIA';
                } else {
                    $validacion->novedad = 'SIN NOVEDAD'; // No hay novedad
                }
            } else {
                $validacion->novedad = ''; // No se pudo obtener el horario, por lo que no hay novedad
            }
        }
        return view('GestionAsistencia.ValidarAsistencias.ValidarAsistenciaEdit', compact('departamentos','novedades','validaciones','empresas'));


    }
    public function EditarValidacion(Request $request)  
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $validaciones = json_decode($request->validaciones);
        
        try
        {
            DB::transaction(function () use ($validaciones, $FechaActual, $request) {
                foreach ($validaciones as $validacion) {
                    $id_validacion = $validacion->id_validacion;
    
                    $validacionModel = Gsta_AsistenciasValidacionModel::find($id_validacion);
                    if ($validacionModel) {
                        $validacionModel->fill([
                            'observacion' => strtoupper($validacion->observacion),
                            'hora_entrada' => $validacion->hora_entrada,
                            'hora_salida' => $validacion->hora_salida,
                            'actualizado_por' => Auth::user()->name,
                            'fecha_actualizacion' => $FechaActual,
                            'nombre_equipo' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                            'direccion_ip' => $request->ip(),
                        ]);
                        $validacionModel->save();
                        
                        // Obtener los nuevos IDs de novedades
                        $id_novedades = $validacion->id_novedad;

                        // Obtener las relaciones existentes para esta validación
                        $relacionesExistentes = Gsta_ValidacionNovedadesModel::where('id_validacion', $id_validacion)->get();
    
                        // Actualizar las relaciones existentes con los nuevos IDs de novedades
                        foreach ($relacionesExistentes as $relacion) {
                            if (in_array($relacion->id_novedad, $id_novedades)) {
                                // Si la novedad existe en los nuevos IDs, no hacer nada
                                continue;
                            }
                            // Si la novedad no está en los nuevos IDs, eliminar la relación
                            $relacion->delete();
                        }
                        // Crear nuevas relaciones para las novedades que no estaban en las relaciones existentes
                        foreach ($id_novedades as $id_novedad) {
                            if ($relacionesExistentes->contains('id_novedad', $id_novedad)) {
                                // Si la novedad ya está en las relaciones existentes, no hacer nada
                                continue;
                            }
                            // Si la novedad no está en las relaciones existentes, crear una nueva relación
                            $IdvalidacionNovedad=   Gsta_ValidacionNovedadesModel::max('id_validacion_novedades') + 1;
                            Gsta_ValidacionNovedadesModel::create([
                                'id_validacion_novedades' =>$IdvalidacionNovedad,
                                'id_validacion' => $id_validacion,
                                'id_novedad' => $id_novedad,
                            ]);
                        }
                        DB::connection('BIOMETRICO')
                            ->table('registros')
                            ->where('id_empleado', '=', $validacion->id_biometrico)
                            ->where('fecha', '=', $validacion->fecha_validacion)
                            ->update(['estatus' => 'VALIDADO']);
                    }
                }
            });
        }
        catch(Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Validacion De La Asistencia'.$ex->getMessage())->withInput();  
        }
       
        return redirect()->back()->withSuccess('Se Ha Editado la Validacion de La Asistencia Exitosamente');
    }

    public function ImprimirValidacionesFinal(Request $request)
    {
        $FechaInicio = $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
        $departamento = $request->departamento;
        $departamentos = Gsta_AsistenciasValidacionModel::BuscarDepartamentos($departamento);
        $empresa = $request->empresa;
        $novedadesString = $request->input('id_novedad');
        
        // Si novedadesString está vacío, asignar 'TODOS'
        if (empty($novedadesString)) {
            $novedades = 'TODOS';
        } else {
            // Verificar si novedadesString es 'TODOS' o dividir la cadena por comas
            $novedades = ($novedadesString === 'TODOS') ? $novedadesString : explode(',', $novedadesString);
        }
    
        // Obtener validaciones
        $validaciones = Gsta_AsistenciasValidacionModel::ListadoValidacionesNove($departamento, $empresa, $FechaInicio, $FechaInicio, $novedades);
    
        // Generar PDF
        $pdf = PDF::loadView('reportes.GestionAsistencias.ValidacionAsistenciaFinalPDF', compact('validaciones', 'FechaInicio', 'departamentos'))->setPaper('letter', 'landscape');
        return $pdf->stream('Solicitud.pdf');
    }
    public function ImprimirValidacionesDiaria(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');
        $departamento = $request->departamento;
        $departamentos = Gsta_AsistenciasValidacionModel::BuscarDepartamentos($departamento);
        $empresa = $request->empresa;
       // Validar que el rango de días no sea mayor de 15 días
       $inicio = \Carbon\Carbon::parse($FechaInicio);
       $fin = \Carbon\Carbon::parse($FechaFin);
       $diferenciaDias = $inicio->diffInDays($fin);
       
       if ($diferenciaDias >= 15) {
           return back()->with('error', 'El rango de fechas no puede ser mayor de 15 días.');
       }
       $novedadesString = $request->input('id_novedad');
       // Si novedadesString está vacío, asignar 'TODOS'
       if (empty($novedadesString)) {
        $novedades = 'TODOS';
    } else {
        // Verificar si novedadesString es 'TODOS' o dividir la cadena por comas
        $novedades = ($novedadesString === 'TODOS') ? $novedadesString : explode(',', $novedadesString);
    }

        $validacionesData = Gsta_AsistenciasValidacionModel::ListadoValidacionesfecha($departamento, $empresa, $FechaInicio, $FechaFin,$novedades);
        $validaciones2 = $validacionesData['result'];
        
        $fechas = $validacionesData['fechas'];
     
        $pdf = PDF::loadView('reportes.GestionAsistencias.ValidacionAsistenciaRangoPDF', compact('FechaInicio','departamentos','validaciones2','fechas'))->setPaper('letter', 'landscape');
        return $pdf->stream('Solicitud.pdf');
    }

    public function ImprimirValidacionesInicial(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
        $departamento = $request->departamento;
        $departamentos = Gsta_AsistenciasValidacionModel::BuscarDepartamentos($departamento);
        $empresa = $request->empresa;
        $validaciones=Gsta_AsistenciasValidacionModel::ListadoValidaciones($departamento,$empresa,$FechaInicio,$FechaInicio);
        
        $pdf = PDF::loadView('reportes.GestionAsistencias.ValidacionAsistenciaInicialPDF', compact('validaciones','FechaInicio','departamentos'))->setPaper('letter', 'landscape');
        return $pdf->stream('Solicitud.pdf');
    }

    public function ImprimirHorasTrabajadas(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
        $departamento = $request->departamento;
        $empresa = $request->empresa;
        $departamentos = Gsta_AsistenciasValidacionModel::BuscarDepartamentos($departamento);
        $validaciones=Gsta_AsistenciasValidacionModel::HorasTrabajadas($departamento,$empresa,$FechaInicio,$FechaInicio);
        $pdf = PDF::loadView('reportes.GestionAsistencias.HorasTrabajadasPDF', compact('validaciones','FechaInicio','departamentos'))->setPaper('letter', 'landscape');
        return $pdf->stream('Solicitud.pdf');
    }
    public function ImprimirHorasTrabajadasRango(Request $request)
    {
        $FechaInicio = $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
        $departamento = $request->departamento;
        $empresa = $request->empresa;
    
        // Validar que el rango de días no sea mayor de 15 días
        $inicio = \Carbon\Carbon::parse($FechaInicio);
        $fin = \Carbon\Carbon::parse($FechaFin);
        $diferenciaDias = $inicio->diffInDays($fin);
        
        if ($diferenciaDias >= 15) {
            return back()->with('error', 'El rango de fechas no puede ser mayor de 15 días.');
        }
    
        $departamentos = Gsta_AsistenciasValidacionModel::BuscarDepartamentos($departamento);
        $validacionesData = Gsta_AsistenciasValidacionModel::Listadohorasextras($departamento, $empresa, $FechaInicio, $FechaFin);
        $validaciones2 = $validacionesData['result'];
        $fechas = $validacionesData['fechas'];
    
        $pdf = PDF::loadView('reportes.GestionAsistencias.HorasTrabajadasRangoPDF', compact('validaciones2', 'FechaInicio', 'departamentos', 'fechas'))->setPaper('letter', 'landscape');
        return $pdf->stream('Solicitud.pdf');
    }
}
