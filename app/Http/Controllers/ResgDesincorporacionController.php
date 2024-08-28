<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResgSolicitudesDesincorporacionCreateRequest;
use App\Http\Requests\ResgSolicitudesDesincorporacionUpdateRequest;
use App\Models\AlmacenesModel;
use App\Models\Asal_SalidasModel;
use App\Models\Resg_ResguardoModel;
use App\Models\Resg_Solicitudes_Desincorporacion_DetalleModel;
use App\Models\Resg_Solicitudes_DesincorporacionModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResgDesincorporacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitudes = Resg_Solicitudes_DesincorporacionModel::ListadoSolicitudesDesincorporacionAlmacen(Auth::user()->id);
      
        return view('Resguardo.Desincorporaciones.Desincorporaciones', compact('solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = AlmacenesModel::select('id_almacen', 'nombre_almacen')->get();
        $empleados = Asal_SalidasModel::EmpleadosSalidas();

        return view('Resguardo.Desincorporaciones.DesincorporacionesCreate', compact('almacenes', 'empleados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResgSolicitudesDesincorporacionCreateRequest $request)
    {
        $IdSolicitudDesincorporacion = Resg_Solicitudes_DesincorporacionModel::max('id_solicitud_desincorporacion') + 1;
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $EstatusSolicitud = 'POR APROBACION';
        //$EstatusArticulo = 'POR PROCESAR';

        $articulos =  json_decode($request['articulos']); 

        //dd($articulos);
        if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['articulos'=> 'Para realizar una solicitud debe seleccionar uno o varios articulos'])->withInput();
        }

        if ($request->hasFile('documento'))
        {
            //CREA LA CARPETA DONDE SE GUARDARAN LOS ARCHIVOS DE LA SOLICITUD 
            $destino = "documents/Resguardo/SolicitudDesincorporacion/".$IdSolicitudDesincorporacion."/";
            
            $Ruta = public_path($destino);
            if (!File::exists($Ruta)) 
            {
                File::makeDirectory($Ruta, 0777, true);
            } 
            
            //GUARDA DOCUMENTO EN LA CARPETA
            $archivo = $request->file('documento');
            $NombreDocumento = $archivo->getClientOriginalName();
            $archivo->move($destino,$NombreDocumento);

            $documento = $destino.$NombreDocumento;
        }
        else
            {
                $documento = null;
            }

        try 
        {
            DB::transaction(function () use ($request, $FechaActual, $EstatusSolicitud, $IdSolicitudDesincorporacion, $documento, $articulos)
            {
                Resg_Solicitudes_DesincorporacionModel::create([
                    'id_solicitud_desincorporacion' => $IdSolicitudDesincorporacion,
                    'id_almacen' => $request['id_almacen'],
                    //'ubicacion_destino' => strtoupper($request['ubicacion_destino']),
                    'responsable' => strtoupper($request['responsable']),
                    'observacion' => strtoupper($request['observacion']),
                    'id_departamento' => Auth::user()->id_departamento,
                    'creado_por' => Auth::User()->id,
                    'fecha_creacion' => $FechaActual,
                    'documento' => $documento,
                    'estatus' => $EstatusSolicitud
                ]);

                foreach($articulos as $articulo)
                {
                    $IdSolicitudDesincorporacionDetalle = Resg_Solicitudes_Desincorporacion_DetalleModel::max('id_solicitud_desincorporacion_detalle') + 1;

                    Resg_Solicitudes_Desincorporacion_DetalleModel::create([
                        'id_solicitud_desincorporacion_detalle' => $IdSolicitudDesincorporacionDetalle,
                        'id_solicitud_desincorporacion' => $IdSolicitudDesincorporacion,
                        'id_resguardo' => $articulo->id_resguardo,
                        'cantidad' => $articulo->cantidad_disponible
                    ]);

                    // Resg_ResguardoModel::where('id_resguardo', '=', $articulo->id_resguardo)
                    // ->update(['estatus' => $EstatusArticulo]);
                }
            });
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect(route("resgdesincorporaciones.edit", $IdSolicitudDesincorporacion))->withSuccess("La Solicitud de Desincorporacion Ha Sido Creada Exitosamente");
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdSolicitudDesincorporacion)
    {
        $solicitud = Resg_Solicitudes_DesincorporacionModel::VerSolicitudDesincorporacion($IdSolicitudDesincorporacion);
        $articulos = Resg_Solicitudes_Desincorporacion_DetalleModel::ArticulosSolicitudDesincorporacion($IdSolicitudDesincorporacion);

        return view('Resguardo.Desincorporaciones.DesincorporacionesShow', compact('solicitud', 'articulos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdSolicitudDesincorporacion)
    {
        $solicitud = Resg_Solicitudes_DesincorporacionModel::find($IdSolicitudDesincorporacion);
        $almacenes = AlmacenesModel::select('id_almacen', 'nombre_almacen')->get();
        $articulos = Resg_Solicitudes_Desincorporacion_DetalleModel::ArticulosSolicitudDesincorporacion($IdSolicitudDesincorporacion);
        $empleados = Asal_SalidasModel::EmpleadosSalidas();

        if($solicitud->estatus == 'PROCESADO')
        {
            $procesado = 'disabled';
        }
        else
            {
                $procesado = NULL;
            }
        
        return view('Resguardo.Desincorporaciones.DesincorporacionesEdit', compact('solicitud', 'articulos', 'almacenes', 'empleados','procesado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResgSolicitudesDesincorporacionUpdateRequest $request, $IdSolicitudDesincorporacion)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        //$EstatusArticulo = 'POR PROCESAR';

        $articulos =  json_decode($request['articulos']); 

        if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['articulos'=> 'Para realizar una solicitud debe seleccionar uno o varios articulos'])->withInput();
        }

        try
        {
            DB::transaction(function () use ($request, $articulos, $IdSolicitudDesincorporacion, $FechaActual) 
            {
                $solicitud = Resg_Solicitudes_DesincorporacionModel::find($IdSolicitudDesincorporacion);
                $solicitud->fill([
                    'id_solicitud_desincorporacion' => $IdSolicitudDesincorporacion,
                    'id_almacen' => $request['id_almacen'],
                    'responsable' => strtoupper($request['responsable']),
                    'observacion' => strtoupper($request['observacion']),
                    'actualizado_por' => Auth::User()->id,
                    'fecha_actualizacion' => $FechaActual,
                ]);

                if ($request->hasFile('documento'))
                {
                    //CREA LA CARPETA DONDE SE GUARDARAN LOS ARCHIVOS DE LA SOLICITUD 
                    $destino = "documents/Resguardo/SolicitudDesincorporacion/".$IdSolicitudDesincorporacion."/";
                    
                    $Ruta = public_path($destino);
                    if (!File::exists($Ruta)) 
                    {
                        File::makeDirectory($Ruta, 0777, true);
                    } 
            
                    //GUARDA DOCUMENTO EN LA CARPETA
                    $archivo = $request->file('documento');
                    $NombreDocumento = $archivo->getClientOriginalName();
                    $archivo->move($destino,$NombreDocumento);

                    $solicitud->fill(['documento' => $destino.$NombreDocumento]);
                }
     
                $solicitud->save();
                
                if ($articulos != NULL)  //verifica si el arreglo no esta vacio
                {
                    foreach ($articulos as $articulo) 
                    {
                        if($articulo->id_solicitud_desincorporacion_detalle == '')
                        {
                                $IdSolicitudDesincorporacionDetalle = Resg_Solicitudes_Desincorporacion_DetalleModel::max('id_solicitud_desincorporacion_detalle') + 1;
                        }
                        else
                            {   
                                $IdSolicitudDesincorporacionDetalle = $articulo->id_solicitud_desincorporacion_detalle;
                            }
                        
                            Resg_Solicitudes_Desincorporacion_DetalleModel::updateOrCreate(
                            [
                                'id_solicitud_desincorporacion_detalle' => $IdSolicitudDesincorporacionDetalle,
                            ],
                            [
                                'id_solicitud_desincorporacion_detalle' => $IdSolicitudDesincorporacionDetalle,
                                'id_solicitud_desincorporacion' => $IdSolicitudDesincorporacion,
                                'id_resguardo' => $articulo->id_resguardo,
                                'cantidad' => $articulo->cantidad_disponible
                            ]
                        );

                        // Resg_ResguardoModel::where('id_resguardo', '=', $articulo->id_resguardo)
                        // ->update(['estatus' => $EstatusArticulo]);
                    }
                }
            });
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect()->route("resgdesincorporaciones.edit", $IdSolicitudDesincorporacion)->withSuccess("La Solicitud de Desincorporacion Ha Sido Editada Exitosamente");
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

    public function AprobarSolicitudDesincorporacion($IdSolicitudDesincorporacion)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $estatus = 'APROBADO';
        
        try 
        {
            Resg_Solicitudes_DesincorporacionModel::where('id_solicitud_desincorporacion', '=', $IdSolicitudDesincorporacion)
            ->update(['aprobado_por' => Auth::user()->id, 'fecha_aprobacion' => $FechaActual, 'estatus' => $estatus]);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Aprobar La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect()->route("resgdesincorporaciones.edit", $IdSolicitudDesincorporacion)->withSuccess("La Solicitud de Desincorporacion Ha Sido Aprobada.");
    }

    public function ProcesarSolicitudDesincorporacion(Request $request)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $IdSolicitudDesincorporacion = $request->id_solicitud_desincorporacion;
        $EstatusSolicitud = 'PROCESADO';
        $EstatusArticulo = 'DESINCORPORADO';
        
        $articulos =  json_decode($request['articulos_desincorporacion']); 
        //dd($articulos);

        if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['articulos'=> 'Para procesar una solicitud debe seleccionar uno o varios articulos'])->withInput();
        }
        
        try 
        {
            DB::transaction(function () use ($IdSolicitudDesincorporacion, $FechaActual, $EstatusSolicitud, $EstatusArticulo, $articulos)
            {
                Resg_Solicitudes_DesincorporacionModel::where('id_solicitud_desincorporacion', '=', $IdSolicitudDesincorporacion)
                ->update(['procesado_por' => Auth::user()->id, 'fecha_procesado' => $FechaActual, 'estatus' => $EstatusSolicitud]);
                
                foreach ($articulos as $articulo) 
                {
                    Resg_ResguardoModel::where('id_resguardo', '=', $articulo->id_resguardo)
                    ->update([ 'estatus' => $EstatusArticulo]);
                }
            });
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Procesar La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect()->route("resgdesincorporaciones.edit", $IdSolicitudDesincorporacion)->withSuccess("La Solicitud de Desincorporacion Ha Sido Procesada.");
    }

    public function ArticulosDesincorporarAlmacen(Request $request)
    {
        $articulos = Resg_ResguardoModel::ArticulosDesincorporarAlmacen($request->id_almacen);
        return with(["articulos" => $articulos]);
    }

    public function EliminarArticuloDesincorporacion($IdSolicitudDesincorporacionDetalle)
    {
        try 
        {
            //Elimina el Id de la solicitud de desincorporacion
            Resg_Solicitudes_Desincorporacion_DetalleModel::destroy($IdSolicitudDesincorporacionDetalle);
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Error Al Eliminar');
            }

        return back()->with('');
    }

    public function ImprimirSolicitudDesincorporacion($IdSolicitudDesincorporacion)
    {
        $solicitud = Resg_Solicitudes_DesincorporacionModel::VerSolicitudDesincorporacion($IdSolicitudDesincorporacion);
        $articulos = Resg_Solicitudes_Desincorporacion_DetalleModel::ArticulosSolicitudDesincorporacion($IdSolicitudDesincorporacion);

        $pdf = PDF::loadView('reportes.Resguardo.SolicitudDesincorporacionPDF', compact('solicitud', 'articulos'));
        return $pdf->stream('Solicitud.pdf');
    }
}
