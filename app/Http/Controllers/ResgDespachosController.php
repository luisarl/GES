<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResgSolicitudesDespachoCreateRequest;
use App\Http\Requests\ResgSolicitudesDespachoUpdateRequest;
use App\Models\AlmacenesModel;
use App\Models\Asal_SalidasModel;
use App\Models\Resg_ResguardoModel;
use App\Models\Resg_Solicitudes_Despacho_DetalleModel;
use App\Models\Resg_Solicitudes_DespachoModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResgDespachosController extends Controller
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
            $solicitudes = Resg_Solicitudes_DespachoModel::ListadoSolicitudesDespachoAlmacen(Auth::user()->id);
        }
        else
            {
                $solicitudes = Resg_Solicitudes_DespachoModel::ListadoSolicitudesDespachoDepartamento(Auth::user()->id_departamento);
            }

       
        return view('Resguardo.Despachos.Despachos', compact('solicitudes'));
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
        return view('Resguardo.Despachos.DespachosCreate', compact('almacenes', 'empleados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResgSolicitudesDespachoCreateRequest $request)
    {
        $IdSolicitudDespacho = Resg_Solicitudes_DespachoModel::max('id_solicitud_despacho') + 1;
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $EstatusSolicitud = 'APROBADO';
        $EstatusArticulo = 'POR PROCESAR';

        $articulos =  json_decode($request['articulos']); 

        //dd($articulos);
        if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['articulos'=> 'Para realizar una solicitud debe seleccionar uno o varios articulos'])->withInput();
        }

        try 
        {
            DB::transaction(function () use ($request, $FechaActual, $EstatusSolicitud, $EstatusArticulo, $IdSolicitudDespacho, $articulos)
            {
                Resg_Solicitudes_DespachoModel::create([
                    'id_solicitud_despacho' => $IdSolicitudDespacho,
                    'id_almacen' => $request['id_almacen'],
                    'ubicacion_destino' => strtoupper($request['ubicacion_destino']),
                    'responsable' => strtoupper($request['responsable']),
                    'observacion' => strtoupper($request['observacion']),
                    'id_departamento' => Auth::user()->id_departamento,
                    'creado_por' => Auth::User()->id,
                    'fecha_creacion' => $FechaActual,
                    'estatus' => $EstatusSolicitud
                ]);

                foreach($articulos as $articulo)
                {
                    $IdSolicitudDespachoDetalle = Resg_Solicitudes_Despacho_DetalleModel::max('id_solicitud_despacho_detalle') + 1;

                    Resg_Solicitudes_Despacho_DetalleModel::create([
                        'id_solicitud_despacho_detalle' => $IdSolicitudDespachoDetalle,
                        'id_solicitud_despacho' => $IdSolicitudDespacho,
                        'id_resguardo' => $articulo->id_resguardo,
                        'cantidad' => $articulo->cantidad
                    ]);

                    Resg_ResguardoModel::where('id_resguardo', '=', $articulo->id_resguardo)
                    ->update(['estatus' => $EstatusArticulo]);
                }
            });
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect(route("resgdespachos.edit", $IdSolicitudDespacho))->withSuccess("La Solicitud de Despacho Ha Sido Creada Exitosamente");
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdSolicitudDespacho)
    {
        $solicitud = Resg_Solicitudes_DespachoModel::VerSolicitudDespacho($IdSolicitudDespacho);
        $articulos = Resg_Solicitudes_Despacho_DetalleModel::ArticulosSolicitudDespacho($IdSolicitudDespacho);

        return view('Resguardo.Despachos.DespachosShow', compact('solicitud', 'articulos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdSolicitudDespacho)
    {
        $solicitud = Resg_Solicitudes_DespachoModel::find($IdSolicitudDespacho);
        $almacenes = AlmacenesModel::select('id_almacen', 'nombre_almacen')->get();
        $articulos = Resg_Solicitudes_Despacho_DetalleModel::ArticulosSolicitudDespacho($IdSolicitudDespacho);
        $empleados = Asal_SalidasModel::EmpleadosSalidas();

        if($solicitud->estatus == 'PROCESADO')
        {
            $procesado = 'disabled';
        }
        else
            {
                $procesado = NULL;
            }

        return view('Resguardo.Despachos.DespachosEdit', compact('solicitud','almacenes', 'articulos', 'procesado', 'empleados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResgSolicitudesDespachoUpdateRequest $request, $IdSolicitudDespacho)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $EstatusArticulo = 'POR PROCESAR';

        $articulos =  json_decode($request['articulos']); 

        if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['articulos'=> 'Para realizar una solicitud debe seleccionar uno o varios articulos'])->withInput();
        }

        try
        {
            DB::transaction(function () use ($request, $articulos, $IdSolicitudDespacho, $FechaActual, $EstatusArticulo) 
            {
                $solicitud = Resg_Solicitudes_DespachoModel::find($IdSolicitudDespacho);
                $solicitud->fill([
                    'id_solicitud_despacho' => $IdSolicitudDespacho,
                    'id_almacen' => $request['id_almacen'],
                    'ubicacion_destino' => strtoupper($request['ubicacion_destino']),
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
                        if($articulo->id_solicitud_despacho_detalle == '')
                        {
                                $IdSolicitudDespachoDetalle = Resg_Solicitudes_Despacho_DetalleModel::max('id_solicitud_despacho_detalle') + 1;
                        }
                        else
                            {   
                                $IdSolicitudDespachoDetalle = $articulo->id_solicitud_despacho_detalle;
                            }
                        
                        Resg_Solicitudes_Despacho_DetalleModel::updateOrCreate(
                            [
                                'id_solicitud_despacho_detalle' => $IdSolicitudDespachoDetalle,
                            ],
                            [
                                'id_solicitud_despacho_detalle' => $IdSolicitudDespachoDetalle,
                                'id_solicitud_despacho' => $IdSolicitudDespacho,
                                'id_resguardo' => $articulo->id_resguardo,
                                'cantidad' => $articulo->cantidad

                            ]
                        );

                        Resg_ResguardoModel::where('id_resguardo', '=', $articulo->id_resguardo)
                        ->update(['estatus' => $EstatusArticulo]);
                    }
                }
            });
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect()->route("resgdespachos.edit", $IdSolicitudDespacho)->withSuccess("La Solicitud de Despacho Ha Sido Editada Exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdSolicitudDespacho)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $EstatusSolicitud = 'ANULADO';
        $EstatusArticulo = 'DISPONIBLE';
        
        try
        {
            DB::transaction(function () use ($IdSolicitudDespacho, $FechaActual, $EstatusSolicitud, $EstatusArticulo)
            {
                $solicitud = Resg_Solicitudes_DespachoModel::find($IdSolicitudDespacho);

                $solicitud->fill([
                    'estatus' => $EstatusSolicitud,
                    'anulado_por' => Auth::user()->id,
                    'fecha_anulacion' => $FechaActual
                ]);  

                $solicitud->save();

                // obtiene los articulos de la solicitud de despacho
                $articulos = Resg_Solicitudes_Despacho_DetalleModel::where('id_solicitud_despacho', '=', $IdSolicitudDespacho)->get();
                
                // cambia el estatus de los articulos a disponible
                foreach ($articulos as $articulo) 
                {
                    Resg_ResguardoModel::where('id_resguardo', '=', $articulo->id_resguardo)
                    ->update(['estatus' => $EstatusArticulo]);
                }
            });
        }
        catch (Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Anular La Solicitud. '.$ex->getMessage())->withInput();
        }

        return redirect()->route("resgdespachos.index")->withSuccess("La Solicitud de Despacho Ha Sido Anulada Exitosamente");
    }

    public function ArticulosAlmacen(Request $request)
    {
        $articulos = Resg_ResguardoModel::ArticulosResguardoAlmacen($request->id_almacen);
        return with(["articulos" => $articulos]);
    }

    public function AprobarSolicitudDespacho($IdSolicitudDespacho)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $estatus = 'APROBADO';
        
        try 
        {
            Resg_Solicitudes_DespachoModel::where('id_solicitud_despacho', '=', $IdSolicitudDespacho)
            ->update(['aprobado_por' => Auth::user()->id, 'fecha_aprobacion' => $FechaActual, 'estatus' => $estatus]);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Aprobar La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect()->route("resgdespachos.edit", $IdSolicitudDespacho)->withSuccess("La Solicitud de Despacho Ha Sido Aprobada.");
    }

    public function ProcesarSolicitudDespacho(Request $request)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $IdSolicitudDespacho = $request->id_solicitud_despacho;
        $EstatusSolicitud = 'PROCESADO';
        

        $articulos =  json_decode($request['articulos_despacho']); 

        //dd($articulos);
        if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['articulos'=> 'Para procesar una solicitud debe seleccionar uno o varios articulos'])->withInput();
        }
        
        try 
        {
            DB::transaction(function () use ($IdSolicitudDespacho, $FechaActual, $EstatusSolicitud, $articulos)
            {
                Resg_Solicitudes_DespachoModel::where('id_solicitud_despacho', '=', $IdSolicitudDespacho)
                ->update(['procesado_por' => Auth::user()->id, 'fecha_procesado' => $FechaActual, 'estatus' => $EstatusSolicitud]);
                
                foreach ($articulos as $articulo) 
                {
                    $CantidadDisponible = $articulo->cantidad_disponible - $articulo->cantidad;

                    if($CantidadDisponible == 0)
                    {
                        $EstatusArticulo = 'DESPACHADO';
                    }
                    else
                        {
                            $EstatusArticulo = 'DISPONIBLE';
                        }

                    Resg_ResguardoModel::where('id_resguardo', '=', $articulo->id_resguardo)
                    ->update(['cantidad_disponible' => $CantidadDisponible, 'estatus' => $EstatusArticulo]);
                }
            });
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Procesar La Solicitud. '.$ex->getMessage())->withInput();
            }

        return redirect()->route("resgdespachos.edit", $IdSolicitudDespacho)->withSuccess("La Solicitud de Despacho Ha Sido Procesada.");
    }

    public function EliminarArticuloDespacho($IdSolicitudDespachoDetalle)
    {
        try 
        {
            //Obtiene el id de resguardo
            $IdResguardo = Resg_Solicitudes_Despacho_DetalleModel::where('id_solicitud_despacho_detalle', '=', $IdSolicitudDespachoDetalle)
            ->value('id_resguardo');

            //Elimina el Id de la solicitud de despacho
            Resg_Solicitudes_Despacho_DetalleModel::destroy($IdSolicitudDespachoDetalle);

            //Actualiza el estatus del  articulo a disponible en el resguardo
            Resg_ResguardoModel::where('id_resguardo', '=', $IdResguardo)
                ->update(['estatus' => 'DISPONIBLE']);
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Error Al Eliminar');
            }

        return back()->with('');
    }

    public function ImprimirSolicitudDespacho($IdSolicitudDespacho)
    {
        $solicitud = Resg_Solicitudes_DespachoModel::VerSolicitudDespacho($IdSolicitudDespacho);
        $articulos = Resg_Solicitudes_Despacho_DetalleModel::ArticulosSolicitudDespacho($IdSolicitudDespacho);

        $pdf = PDF::loadView('reportes.Resguardo.SolicitudDespachoPDF', compact('solicitud', 'articulos'));
        return $pdf->stream('Solicitud.pdf');
    }
}
