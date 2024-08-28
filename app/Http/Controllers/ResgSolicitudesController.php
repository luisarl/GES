<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResgSolicitudesResguardoCreateRequest;
use App\Http\Requests\ResgSolicitudesResguardoUpdateRequest;
use App\Models\AlmacenesModel;
use App\Models\Asal_SalidasModel;
use App\Models\Resg_ClasificacionesModel;
use App\Models\Resg_ResguardoModel;
use App\Models\Resg_Solicitudes_ResguardoModel;
use App\Models\Resg_UbicacionesModel;
use App\Models\UnidadesModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResgSolicitudesController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::user()->roles[0]->name == 'almacen')
        {
            $solicitudes = Resg_Solicitudes_ResguardoModel::ListadoSolicitudesResguardoAlmacen(Auth::user()->id);
        }
        else
            {
                $solicitudes = Resg_Solicitudes_ResguardoModel::ListadoSolicitudesResguardoDepartamento(Auth::user()->id_departamento);
            }

        return view('Resguardo.Solicitudes.Solicitudes', compact('solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = AlmacenesModel::select('id_almacen', 'nombre_almacen')->get();
        $unidades = UnidadesModel::select('id_unidad', 'nombre_unidad')->get();
        $clasificaciones = Resg_ClasificacionesModel::select('id_clasificacion', 'nombre_clasificacion')->get();
        $empleados = Asal_SalidasModel::EmpleadosSalidas();

        return view('Resguardo.Solicitudes.SolicitudesCreate', compact('almacenes', 'unidades', 'clasificaciones', 'empleados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResgSolicitudesResguardoCreateRequest $request)
    {
        $IdSolicitudResguardo = Resg_Solicitudes_ResguardoModel::max('id_solicitud_resguardo') + 1;
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $estatus = 'APROBADO';

        $articulos =  json_decode($request['articulos']); 

        //dd($articulos);
        if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['articulos'=> 'Para realizar una solciitud debe seleccionar uno o varios articulos'])->withInput();
        }

        try 
        {
            DB::transaction(function () use ($request, $FechaActual, $estatus, $IdSolicitudResguardo, $articulos)
            {
                Resg_Solicitudes_ResguardoModel::create([
                    'id_solicitud_resguardo' => $IdSolicitudResguardo,
                    'id_almacen' => $request['id_almacen'],
                    'responsable' => strtoupper($request['responsable']),
                    'ubicacion_actual' => strtoupper($request['ubicacion_actual']),
                    'observacion' => strtoupper($request['observacion']),
                    'id_departamento' => Auth::user()->id_departamento,
                    'creado_por' => Auth::User()->id,
                    'fecha_creacion' => $FechaActual,
                    'estatus' => $estatus
                ]);

                foreach($articulos as $articulo)
                {
                    $IdResguardo = Resg_ResguardoModel::max('id_resguardo') + 1;

                    Resg_ResguardoModel::create([
                        'id_resguardo' => $IdResguardo,
                        'id_solicitud_resguardo' => $IdSolicitudResguardo,
                        'codigo_articulo' => $articulo->codigo_articulo,
                        'nombre_articulo' => $articulo->nombre_articulo,
                        'tipo_unidad' => strtoupper($articulo->unidad),
                        'equivalencia_unidad'  => $articulo->equivalencia_unidad,
                        'cantidad' => $articulo->cantidad,
                        'cantidad_disponible' => $articulo->cantidad,
                        'estado' => strtoupper($articulo->estado),
                        'observacion' => strtoupper($articulo->observacion),
                        'id_clasificacion' => $articulo->id_clasificacion,
                        'id_ubicacion' => NULL,
                        //'estatus' => $estatus,
                    ]);
                }
            });
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect(route("resgsolicitudes.edit", $IdSolicitudResguardo))->withSuccess("La Solicitud de Resguardo Ha Sido Creada Exitosamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdSolicitudResguardo)
    {
        $solicitud = Resg_Solicitudes_ResguardoModel::VerSolicitudResguardo($IdSolicitudResguardo);
        $articulos = Resg_ResguardoModel::ArticulosSolicitudResguardo($IdSolicitudResguardo);

        return view('Resguardo.Solicitudes.SolicitudesShow', compact('solicitud', 'articulos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdSolcitud)
    {
        $almacenes = AlmacenesModel::select('id_almacen', 'nombre_almacen')->get();
        $unidades = UnidadesModel::select('id_unidad', 'nombre_unidad')->get();
        $clasificaciones = Resg_ClasificacionesModel::select('id_clasificacion', 'nombre_clasificacion')->get();
        $empleados = Asal_SalidasModel::EmpleadosSalidas();
       
        $solicitud = Resg_Solicitudes_ResguardoModel::find($IdSolcitud);
        $articulos = Resg_ResguardoModel::ArticulosSolicitudResguardo($IdSolcitud);
        $ubicaciones = Resg_UbicacionesModel::select('id_ubicacion', 'nombre_ubicacion')->where('id_almacen', '=', $solicitud->id_almacen)->get();
       
        if($solicitud->estatus == 'PROCESADO')
        {
            $procesado = 'disabled';
        }
        else
            {
                $procesado = NULL;
            }

        return view('Resguardo.Solicitudes.SolicitudesEdit', compact('almacenes', 'unidades', 'clasificaciones', 'solicitud', 'articulos', 'ubicaciones', 'procesado', 'empleados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResgSolicitudesResguardoUpdateRequest $request, $IdSolicitudResguardo)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        //$estatus = 'POR APROBACION';

        $articulos =  json_decode($request['articulos']); 

        //dd($articulos);
        if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['articulos'=> 'Para realizar una solicitud debe seleccionar uno o varios articulos'])->withInput();
        }

        try
        {
            DB::transaction(function () use ($request, $articulos, $IdSolicitudResguardo, $FechaActual) 
            {
                $solicitud = Resg_Solicitudes_ResguardoModel::find($IdSolicitudResguardo);
                $solicitud->fill([
                    'id_solicitud_resguardo' => $IdSolicitudResguardo,
                    'id_almacen' => $request['id_almacen'],
                    'ubicacion_actual' => strtoupper($request['ubicacion_actual']),
                    'responsable' => strtoupper($request['responsable']),
                    'observacion' => strtoupper($request['observacion']),
                    //'id_departamento' => Auth::user()->id_departamento,
                    'actualizado_por' => Auth::User()->id,
                    'fecha_actualizacion' => $FechaActual,
                    //'estatus' => $estatus
                ]);
                $solicitud->save();
                
                if ($articulos != NULL)  //verifica si el arreglo no esta vacio
                {
                    foreach ($articulos as $articulo) 
                    {
                        if($articulo->id_resguardo == '')
                        {
                                $IdResguardo = Resg_ResguardoModel::max('id_resguardo') + 1;
                        }
                        else
                            {   
                                $IdResguardo = $articulo->id_resguardo;
                            }
                        
                        Resg_ResguardoModel::updateOrCreate(
                            [
                                'id_resguardo' => $IdResguardo,
                                'id_solicitud_resguardo' => $IdSolicitudResguardo,     
                            ],
                            [
                                'id_resguardo' => $IdResguardo,
                                'id_solicitud_resguardo' => $IdSolicitudResguardo,
                                'codigo_articulo' => $articulo->codigo_articulo,
                                'nombre_articulo' => strtoupper($articulo->nombre_articulo),
                                'tipo_unidad' => strtoupper($articulo->unidad),
                                'equivalencia_unidad'  => $articulo->equivalencia_unidad,
                                'cantidad' => $articulo->cantidad,
                                'cantidad_disponible' => $articulo->cantidad,
                                'estado' => strtoupper($articulo->estado),
                                'observacion' => strtoupper($articulo->observacion),
                                'id_clasificacion' => $articulo->id_clasificacion,
                                'id_ubicacion' => NULL,
                                //'estatus' => $estatus,
                            ]
                        );
                    }
                }
            });
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect()->route("resgsolicitudes.edit", $IdSolicitudResguardo)->withSuccess("La Solicitud de Resguardo Ha Sido Editada Exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdSolicitudResguardo)
    { 
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $estatus = 'ANULADO';
        
        try
        {
            $solicitud = Resg_Solicitudes_ResguardoModel::find($IdSolicitudResguardo);

            $solicitud->fill([
                'estatus' => $estatus,
                'anulado_por' => Auth::user()->id,
                'fecha_anulacion' => $FechaActual
            ]);  
           $solicitud->save();
        }
        catch (Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Anular La Solicitud. '.$ex->getMessage())->withInput();
        }

        return redirect()->route("resgsolicitudes.index")->withSuccess("La Solicitud de Resguardo Ha Sido Anulada Exitosamente");
    }

    public function AprobarSolicitudResguardo($IdSolicitudResguardo)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $estatus = 'APROBADO';
        
        try 
        {
            Resg_Solicitudes_ResguardoModel::where('id_solicitud_resguardo', '=', $IdSolicitudResguardo)
            ->update(['aprobado_por' => Auth::user()->id, 'fecha_aprobacion' => $FechaActual, 'estatus' => $estatus]);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Aprobar La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect()->route("resgsolicitudes.edit", $IdSolicitudResguardo)->withSuccess("La Solicitud de Resguardo Ha Sido Aprobada.");
    }

    public function ProcesarSolicitudResguardo(Request $request, $IdSolicitudResguardo)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $EstatusSolicitud = 'PROCESADO';
        $EstatusArticulo = 'DISPONIBLE';

        $articulos =  json_decode($request['articulos_resguardo']); 

        try 
        {
            DB::transaction(function () use ($IdSolicitudResguardo,$FechaActual,$EstatusSolicitud, $EstatusArticulo, $articulos)
            {
                Resg_Solicitudes_ResguardoModel::where('id_solicitud_resguardo', '=', $IdSolicitudResguardo)
                ->update(['procesado_por' => Auth::user()->id, 'fecha_procesado' => $FechaActual, 'estatus' => $EstatusSolicitud]);
                
                foreach($articulos as $articulo)
                {
                    Resg_ResguardoModel::where('id_resguardo', '=', $articulo->id_resguardo)
                    ->update(['estatus' => $EstatusArticulo, 'id_ubicacion' => $articulo->id_ubicacion ]);
                }
            });
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Procesar La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect()->route("resgsolicitudes.edit", $IdSolicitudResguardo)->withSuccess("La Solicitud de Resguardo Ha Sido Procesada.");

    }

    public function EliminarArticuloResguardo($IdResguardo)
    {
        try
        {
            Resg_ResguardoModel::destroy($IdResguardo);
        }
        catch (Exception $ex)
            {
                return back()->withError('Error Al Eliminar');
            }

        return back()->with('');
    }

    public function BuscarArticulos(Request $request) 
    {
        $articulos = Resg_Solicitudes_ResguardoModel::BuscarArticulos($request->articulo);
        return with(["articulos" => $articulos]);
    }

    public function ImprimirSolicitudResguardo($IdSolicitudResguardo)
    {
        $solicitud = Resg_Solicitudes_ResguardoModel::VerSolicitudResguardo($IdSolicitudResguardo);
        $articulos = Resg_ResguardoModel::ArticulosSolicitudResguardo($IdSolicitudResguardo);
      
        $pdf = PDF::loadView('reportes.Resguardo.SolicitudResguardoPDF', compact('solicitud', 'articulos'));
        return $pdf->stream('Solicitud.pdf');
    }

    public function ImprimirEtiquetasResguardo(Request $request, $IdSolicitudResguardo)
    {
        //dd($request->all());
        //$articulos = Resg_ResguardoModel::ArticulosSolicitudResguardo($IdSolicitudResguardo);
        $solicitud = Resg_Solicitudes_ResguardoModel::VerSolicitudResguardo($IdSolicitudResguardo);
        $articulos = json_decode($request['articulos_impresion']);
        
        $pdf = PDF::loadView('reportes.Resguardo.EtiquetasResguardoPDF', compact('solicitud','articulos'));
        return $pdf->stream('Etiquetas-SOLRESG'.$IdSolicitudResguardo.'.pdf');
    }
}
