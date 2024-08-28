<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolsSolicitudesAceptarRequest;
use App\Http\Requests\SolsSolicitudesCreateRequest;
use App\Http\Requests\SolsSolicitudesReabrirRequest;
use App\Http\Requests\SolsSolicitudesUpdateRequest;
use App\Mail\SolsSolicitudesAceptarMailable;
use App\Mail\SolsSolicitudesAsignarResponsablesMailable;
use App\Mail\SolsSolicitudesComentarioMailable;
use App\Mail\SolsSolicitudesCreateMailable;
use App\Mail\SolsSolicitudesEncuestaServicioMailable;
use App\Mail\SolsSolicitudesEncuestaSolicitudMailable;
use App\Mail\SolsSolicitudesFinalizarEncuestaServicioMailable;
use App\Mail\SolsSolicitudesFinalizarEncuestaSolicitudMailable;
use App\Mail\SolsSolicitudesReabirMailable;
use App\Models\CorreosModel;
use App\Models\DepartamentosModel;
use App\Models\Sols_ResponsablesModel;
use App\Models\Sols_ServiciosModel;
use App\Models\Sols_Solicitudes_DetalleModel;
use App\Models\Sols_Solicitudes_DocumentosModel;
use App\Models\Sols_Solicitudes_EncuestasModel;
use App\Models\Sols_Solicitudes_ResponsablesModel;
use App\Models\Sols_SolicitudesModel;
use App\Models\Sols_SubServiciosModel;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Exception;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SolsSolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $solicitudes = Sols_SolicitudesModel::SolicitudesDepartamento(Auth::user()->id_departamento);
        $usuariosresponsables = Sols_ResponsablesModel::ListaResponsablesDepartamento(Auth::user()->id_departamento);
        return view('SolicitudesServicios.Solicitudes.Solicitudes', compact('solicitudes','usuariosresponsables'));
    }


    public function SolicitudesTodas()
    {
        $solicitudes = Sols_SolicitudesModel::ListaSolicitudes();
        $usuariosresponsables = Sols_ResponsablesModel::ListaResponsablesDepartamento(Auth::user()->id_departamento);

        return view('SolicitudesServicios.Solicitudes.Solicitudes', compact('solicitudes','usuariosresponsables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->where('aplica_servicios', '=', 'SI')->get();
        return view('SolicitudesServicios.Solicitudes.SolicitudesCreate', compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolsSolicitudesCreateRequest $request)
    {
        //$SolicitudesPendientes = Sols_SolicitudesModel::SolicitudesPendientesPorFinalizar(Auth::user()->id_departamento);
        
        //Valida que el departamento solicitante no tengas mas de 3 solicitudes pendientes por finalizar
        // if($SolicitudesPendientes >= 3) 
        // {   
        //     return back()->withAlert('Actualmente el Departamento Posee '. $SolicitudesPendientes. ' Solicitudes Por Finalizar. Debe Finalizarlas Para Poder Crear La Solicitud')->withInput();
        // }

        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $IdSolicitud = Sols_SolicitudesModel::max('id_solicitud') + 1;
        $estatus = 'POR ACEPTAR';

        //CREA LA CARPETA DONDE SE GUARDARAN LOS ARCHIVOS DE LA SOLICITUD 
        $destino = "documents/SolicitudesServicios/";
        $NombreCarpeta = $IdSolicitud;
        
        $Ruta = public_path($destino . $NombreCarpeta);

        if (!File::exists($Ruta)) 
        {
            File::makeDirectory($Ruta, 0777, true);
        } 

        try 
        {
            
            $departamento = DepartamentosModel::select('id_departamento','prefijo','correlativo_servicios')
                            ->where('id_departamento', '=', Auth::user()->id_departamento)->first();
            $CodigoSolicitud = $departamento->prefijo.$departamento->correlativo_servicios + 1;

            DB::transaction(function () use ($IdSolicitud, $CodigoSolicitud, $FechaActual, $departamento, $estatus, $request) {

                //CREA LA SOLICUTUD
                Sols_SolicitudesModel::create([
                    'id_solicitud' => $IdSolicitud,
                    'codigo_solicitud' => $CodigoSolicitud,
                    'id_departamento_solicitud' => Auth::user()->id_departamento,
                    'asunto_solicitud' => strtoupper($request['asunto_solicitud']),
                    'descripcion_solicitud' =>  strtoupper($request['descripcion_solicitud']),
                    'id_servicio' => $request['id_servicio'],
                    'id_subservicio' => $request['id_subservicio'],
                    'id_departamento_servicio' => $request['id_departamento_servicio'],
                    'estatus' => $estatus,
                    'fecha_creacion' => $FechaActual,
                    'creado_por' => Auth::user()->id,
                    'direccion_ip' => $request->ip(),
                    'prioridad' => $request['prioridad'],
                    'logistica_origen' =>  strtoupper($request['logistica_origen']),
                    'logistica_destino' =>  strtoupper($request['logistica_destino']),
                    'logistica_fecha' => Carbon::parse($request['logistica_fecha'])->format('Y-d-m H:i:s'),
                    'logistica_telefono'  => $request['logistica_telefono'],
                    'mantenimiento_tipo_equipo' => strtoupper($request['mantenimiento_tipo_equipo']),
                    'mantenimiento_nombre_equipo' => strtoupper($request['mantenimiento_nombre_equipo']),
                    'mantenimiento_codigo_equipo' => strtoupper($request['mantenimiento_codigo_equipo']),
                    'encuesta_solicitud_enviada' => 'NO',
                    'encuesta_servicio_enviada' => 'NO'
                ]);

                if ($request->hasFile('documentos'))
                {   
                    $PosseDocumentos = 'SI';
                }
                else
                    {
                        $PosseDocumentos = 'NO';
                    }

                //GUARDA EN LA TABLA DETALLE
                $IdSolicitudDetalle= Sols_Solicitudes_DetalleModel::max('id_solicitud_detalle') + 1;

                Sols_Solicitudes_DetalleModel::create([
                    'id_solicitud_detalle' => $IdSolicitudDetalle,
                    'id_solicitud' => $IdSolicitud,
                    'estatus' => $estatus,
                    'fecha' => $FechaActual,
                    'usuario' => Auth::user()->name ,
                    'comentario' =>  strtoupper($request['descripcion_solicitud']),
                    'documentos' => $PosseDocumentos
                ]);

                if($PosseDocumentos == 'SI')
                {
                    $documentos = $request->file('documentos');
                    foreach ($documentos as $documento ) 
                    {
                        $destino = "documents/SolicitudesServicios/".$IdSolicitud."/";
                        $NombreDocumento = $documento->getClientOriginalName();
                        $TipoDocumento = $documento->getClientOriginalExtension();
                        $documento->move($destino,$NombreDocumento);

                        $IdSolicitudDocumento =  Sols_Solicitudes_DocumentosModel::max('id_solicitud_documento') + 1;
                        //GUARDA EN LA TABLA SOLICITUDES DOCUMENTOS
                        Sols_Solicitudes_DocumentosModel::create([
                            'id_solicitud_documento' => $IdSolicitudDocumento,
                            'id_solicitud' => $IdSolicitud,
                            'id_solicitud_detalle' => $IdSolicitudDetalle, 
                            'nombre_documento' => $NombreDocumento,
                            'ubicacion_documento' => $destino .$NombreDocumento,
                            'tipo_documento' => $TipoDocumento ,

                        ]);
                    }    
                }
                
                //ACTUALIZA EL CORRELATIVO DEL SERVICIO DEL DEPARTAMENTO
                DepartamentosModel::where('id_departamento', '=', $departamento->id_departamento )
                ->update(['correlativo_servicios' => $departamento->correlativo_servicios + 1]); 
            });
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Crear La Solicitud: '.$ex->getMessage())->withInput();
            }

        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $solicitud = Sols_SolicitudesModel::VerSolicitud($IdSolicitud); //busca los datos

            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::SolsCorreosDestinatarios(Auth::user()->id, $request['id_departamento_servicio'], Auth::user()->id_departamento, 'CREAR');
           
            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(10), new SolsSolicitudesCreateMailable($solicitud));   
        }
        catch (Exception $ex)
            {
                Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
            }    
        
        return redirect()->route('solicitudes.edit',$IdSolicitud)->withSuccess('La Solicitud Ha Sido Creada Exitosamente'); 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdSolicitud)
    {
        $solicitud = Sols_SolicitudesModel::VerSolicitud($IdSolicitud);
        $SolicitudDetalle = Sols_Solicitudes_DetalleModel::all()->where('id_solicitud', '=', $IdSolicitud);
        //$UsuariosResponsables = User::UsuariosResponsablesServicios($solicitud->id_departamento_servicio, $IdSolicitud);
        $ResponsablesSolicitud = Sols_Solicitudes_ResponsablesModel::ResponsablesSolicitud($IdSolicitud);
        $EncuestaSolicitud = Sols_Solicitudes_EncuestasModel::VerEncuestaPorTipo($IdSolicitud, 'SOLICITUD');
        $EncuestaServicio = Sols_Solicitudes_EncuestasModel::VerEncuestaPorTipo($IdSolicitud, 'SERVICIO');
        $FechaCreada = new DateTime(Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud)->value('fecha_creacion'));
        $FechaFinalizada = new DateTime(Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud)->value('fecha_finalizacion'));

        $TiempoTranscurrido = $FechaCreada->diff($FechaFinalizada); //COMPARA DOS FECHAS Y MUESTRA TIEMPO TRANSCURRIDO

        return view('SolicitudesServicios.Solicitudes.SolicitudesShow', compact('solicitud', 'SolicitudDetalle', 'TiempoTranscurrido','ResponsablesSolicitud', 'EncuestaSolicitud', 'EncuestaServicio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdSolicitud)
    {
        $solicitud = Sols_SolicitudesModel::VerSolicitud($IdSolicitud);
        $SolicitudDetalle = Sols_Solicitudes_DetalleModel::all()->where('id_solicitud', '=', $IdSolicitud);
        $UsuariosResponsables = Sols_ResponsablesModel::ResponsablesDepartamentoSolicitud($solicitud->id_departamento_servicio, $IdSolicitud);
        $ResponsablesSolicitud = Sols_Solicitudes_ResponsablesModel::ResponsablesSolicitud($IdSolicitud);
        $FechaInicio = new DateTime(Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud)->value('fecha_creacion'));
        $FechaActual = Carbon::now(); // Obtiene La fecha Actual
        $servicios = Sols_ServiciosModel::ListaServiciosEdit($solicitud->id_departamento_servicio);
        $subservicios = Sols_SubServiciosModel::ListaSubServiciosEdit($solicitud->id_servicio);
        $TiempoTranscurrido = $FechaInicio->diff($FechaActual); //COMPARA DOS FECHAS Y MUESTRA TIEMPO TRANSCURRIDO

        return view('SolicitudesServicios.Solicitudes.SolicitudesEdit', compact('solicitud', 'SolicitudDetalle', 'TiempoTranscurrido', 'UsuariosResponsables','ResponsablesSolicitud','servicios','subservicios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SolsSolicitudesUpdateRequest $request, $IdSolicitud)
    {   
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $IdSolicitudDetalle = Sols_Solicitudes_DetalleModel::max('id_solicitud_detalle') + 1;

        $solicitud = Sols_SolicitudesModel::VerSolicitud($IdSolicitud);

        try
        {
            DB::transaction(function () use ($IdSolicitud, $IdSolicitudDetalle, $request, $FechaActual) 
            {   
                //VERIFICA SI EL COMENTARIO  AGREGADO POSSE DOCUMENTOS ADJUNTOS
                if ($request->hasFile('documentos'))
                {   
                    $PosseDocumentos = 'SI';
                }
                else
                    {
                        $PosseDocumentos = 'NO';
                    }

                //VERIFICA SI EL ESTATUS FUE MARCADO CERRADO    
                if($request->has('estatus'))
                {
                    $estatus = 'CERRADO';
                    //ACTUALIZA LA TABLA SOLICITUDES
                    Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud )
                    ->update(['estatus' => $estatus, 'fecha_cierre' => $FechaActual, 'cerrado_por' => Auth::user()->id]); 
                }
                else    
                    {
                        $estatus = Sols_SolicitudesModel::where('id_solicitud', $IdSolicitud)->value('estatus');
                    }    

                //GUARDA EN LA TABLA DETALLE
                
                Sols_Solicitudes_DetalleModel::create([
                    'id_solicitud_detalle' => $IdSolicitudDetalle,
                    'id_solicitud' => $IdSolicitud,
                    'estatus' => $estatus,
                    'fecha' => $FechaActual,
                    'usuario' => Auth::user()->name ,
                    'comentario' =>  strtoupper($request['comentario']),
                    'documentos' => $PosseDocumentos
                ]);

                // SI POSSEE DOCUMENTOS ADJUNTOS GUARDA LOS DOCUMENTOS EN LA CARPETA Y EN LA TABLA SOLICITUDES_DOCUMENTOS
                if($PosseDocumentos == 'SI')
                    {
                        $documentos = $request->file('documentos'); //ARREGLO DE DOCUMENTOS

                        foreach ($documentos as $documento ) 
                        {
                            //GUARDA LOS DOCUMENTOS EN LA CARPETA 
                            $destino = "documents/SolicitudesServicios/".$IdSolicitud."/";
                            $NombreDocumento = $documento->getClientOriginalName();
                            $TipoDocumento = $documento->getClientOriginalExtension();
                            $documento->move($destino,$NombreDocumento);
                            
                            $IdSolicitudDocumento =  Sols_Solicitudes_DocumentosModel::max('id_solicitud_documento') + 1;
                            
                            //GUARDA EN LA TABLA SOLICITUDES_DOCUMENTOS
                            Sols_Solicitudes_DocumentosModel::create([
                                'id_solicitud_documento' => $IdSolicitudDocumento,
                                'id_solicitud' => $IdSolicitud,
                                'id_solicitud_detalle' => $IdSolicitudDetalle, 
                                'nombre_documento' => $NombreDocumento,
                                'ubicacion_documento' => $destino .$NombreDocumento,
                                'tipo_documento' => $TipoDocumento ,

                            ]);
                        }    
                    }


            });
        }
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Crear El Comentario. '.$ex->getMessage())->withInput();
            }
        
        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $solicitud = Sols_Solicitudes_DetalleModel::SolicitudDetalle($IdSolicitud, $IdSolicitudDetalle); //busca los datos
            
            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            if($solicitud->estatus == 'CERRADO')
            {
                //ENVIA CORREO PARA ENCUESTA DE SERVICIO
                $destinatarios = CorreosModel::SolsCorreosDestinatarios($solicitud->creado_por, $solicitud->id_departamento_servicio , $solicitud->id_departamento_solicitud, 'ENCUESTA SERVICIO');
                
                // ENVIA EL CORREO
                Mail::to($destinatarios[0]) //DESTINATARIOS
                //->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(10), new SolsSolicitudesEncuestaServicioMailable($solicitud));  

                //ENVIA CORREO PARA ENCUESTA DE SOLICITUD
                $destinatarios = CorreosModel::SolsCorreosDestinatarios($solicitud->creado_por, $solicitud->id_departamento_servicio , $solicitud->id_departamento_solicitud, 'ENCUESTA SOLICITUD');
                
                // ENVIA EL CORREO
                Mail::to($destinatarios[0]) //DESTINATARIOS
                //->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(10), new SolsSolicitudesEncuestaSolicitudMailable($solicitud));  
            
            }
            else
                {
                    $destinatarios = CorreosModel::SolsCorreosDestinatarios($solicitud->creado_por, $solicitud->id_departamento_servicio , $solicitud->id_departamento_solicitud, 'COMENTARIO'); 
                    
                    // ENVIA EL CORREO
                    Mail::to($destinatarios[0]) //DESTINATARIOS
                    ->cc($destinatarios[1]) //EN COPIA
                    //->bcc($destinatarios[2]) // EN COPIA OCULTA
                    ->later(now()->addSeconds(10), new SolsSolicitudesComentarioMailable($solicitud));   
                } 
        }
        catch (Exception $ex)
            {
                Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
            }
        
        if($solicitud->estatus == 'CERRADO')
        {
            return redirect()->route('solicitudes/encuestasolicitud', $IdSolicitud)->withSuccess('La Solicitud Fue Cerrada Exitosamente');
        }
        else
            {
                return redirect()->route('solicitudes.edit', $IdSolicitud)->withSuccess('El Comentario Ha Sido Agregado Exitosamente');
            }   
            
    }

    public function ComentarioInterno(Request $request, $IdSolicitud )
    {
        try 
        {
            Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud )
            ->update(['comentario_interno' => strtoupper($request['comentario_interno'])]); 
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Agregar El comentario Interno. '.$ex->getMessage())->withInput();
            }
        
        return redirect()->route('solicitudes.edit', $IdSolicitud)->withSuccess('El Comentario Interno Ha Sido Agregado Exitosamente');
    
    }

    public function reabrir(SolsSolicitudesReabrirRequest $request, $IdSolicitud)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $IdSolicitudDetalle = Sols_Solicitudes_DetalleModel::max('id_solicitud_detalle') + 1;
       
        $solicitud = Sols_SolicitudesModel::find($IdSolicitud);
      
        if($solicitud->estatus == 'NO PROCEDE')
        {
            try
            {
                DB::transaction(function () use($IdSolicitud, $IdSolicitudDetalle, $solicitud, $FechaActual, $request)
                {
                    $estatus = 'POR ACEPTAR';

                    //ACTUALIZA LA TABLA SOLICITUDES
                    $solicitud->fill([
                        'aceptada' => NULL,
                        'fecha_aceptacion' => NULL,
                        'aceptada_por' => NULL,
                        'estatus' => $estatus
                    ]);
                    $solicitud->save();
        
                    //GUARDA EN LA TABLA DETALLE
                    Sols_Solicitudes_DetalleModel::create([
                        'id_solicitud_detalle' => $IdSolicitudDetalle,
                        'id_solicitud' => $IdSolicitud,
                        'estatus' => $estatus,
                        'fecha' => $FechaActual,
                        'usuario' => Auth::user()->name ,
                        'comentario' =>  strtoupper($request['comentario']),
                        'documentos' => 'NO'
                    ]);
                });
                    
            }
            catch(Exception $ex)
                {
                    return back()->withError('Ha Ocurrido Un Error. '.$ex->getMessage())->withInput();
                }
                
            //VALIDACION AL ENVIAR CORREOS
            try
            {
                $solicitud = Sols_Solicitudes_DetalleModel::SolicitudDetalle($IdSolicitud, $IdSolicitudDetalle); //busca los datos
                
                //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
                $destinatarios = CorreosModel::SolsCorreosDestinatarios($solicitud->creado_por, $solicitud->id_departamento_servicio , $solicitud->id_departamento_solicitud, 'REABRIR');

                // ENVIA EL CORREO
                Mail::to($destinatarios[0]) //DESTINATARIOS
                    ->cc($destinatarios[1]) //EN COPIA
                    //->bcc($destinatarios[2]) // EN COPIA OCULTA
                    ->later(now()->addSeconds(10), new SolsSolicitudesReabirMailable($solicitud));   
            }
            catch (Exception $ex)
                {
                    Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
                }      

            return redirect()->route('solicitudes.edit', $IdSolicitud)->withSuccess('El Estatus De La Solicitud Cambio a POR ACEPTAR');
        }
        else if($solicitud->estatus == 'CERRADO')
            {  
                try
                {
                    DB::transaction(function () use($IdSolicitud, $IdSolicitudDetalle, $solicitud, $FechaActual, $request)
                    {
                        $estatus = 'EN PROCESO';
                        //ACTUALIZA EL ESTATUS DE LA SOLICITUD
                        Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud )
                        ->update(['estatus' => $estatus]); 
                        
                        //GUARDA EN LA TABLA DETALLE
                        Sols_Solicitudes_DetalleModel::create([
                            'id_solicitud_detalle' => $IdSolicitudDetalle,
                            'id_solicitud' => $IdSolicitud,
                            'estatus' => $estatus,
                            'fecha' => $FechaActual,
                            'usuario' => Auth::user()->name ,
                            'comentario' =>  strtoupper($request['comentario']),
                            'documentos' => 'NO'
                        ]);
                    });
                }
                catch(Exception $ex)
                    {
                        return back()->withError('Ha Ocurrido Un Error. '.$ex->getMessage())->withInput();
                    } 

                //VALIDACION AL ENVIAR CORREOS
                try
                {
                    $solicitud = Sols_Solicitudes_DetalleModel::SolicitudDetalle($IdSolicitud, $IdSolicitudDetalle); //busca los datos
                    
                    //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
                    $destinatarios = CorreosModel::SolsCorreosDestinatarios($solicitud->creado_por, $solicitud->id_departamento_servicio , $solicitud->id_departamento_solicitud, 'REABRIR');

                    // ENVIA EL CORREO
                    Mail::to($destinatarios[0]) //DESTINATARIOS
                        ->cc($destinatarios[1]) //EN COPIA
                        //->bcc($destinatarios[2]) // EN COPIA OCULTA
                        ->later(now()->addSeconds(10), new SolsSolicitudesReabirMailable($solicitud));   
                }
                catch (Exception $ex)
                    {
                        Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
                    }      

                return redirect()->route('solicitudes.edit', $IdSolicitud)->withSuccess('La Solicitud Ha Sido Reabierta');
            }
    }

    public function aceptar(SolsSolicitudesAceptarRequest $request, $IdSolicitud)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $IdSolicitudDetalle = Sols_Solicitudes_DetalleModel::max('id_solicitud_detalle') + 1;
        
        try
        {
            DB::transaction(function () use($IdSolicitud, $IdSolicitudDetalle, $request, $FechaActual)
            {
                if($request['aceptar'] == 'SI')
                {
                    $comentario = 'SOLICITUD ACEPTADA. '. $request['comentario']; 
                    $estatus = 'ABIERTO';
                }
                else
                    {
                        $comentario = 'SOLICITUD NO PROCEDE. '. $request['comentario']; 
                        $estatus = 'NO PROCEDE';
                    }

                //ACTUALIZA LA TABLA SOLICITUDES
                $solicitud = Sols_SolicitudesModel::find($IdSolicitud);
                $solicitud->fill([
                    'aceptada' => $request['aceptar'],
                    'fecha_aceptacion' => $FechaActual,
                    'aceptada_por' => Auth::user()->id,
                    'estatus' => $estatus
                ]);
                $solicitud->save();

                //GUARDA EN LA TABLA DETALLE
                Sols_Solicitudes_DetalleModel::create([
                    'id_solicitud_detalle' => $IdSolicitudDetalle,
                    'id_solicitud' => $IdSolicitud,
                    'estatus' => $estatus,
                    'fecha' => $FechaActual,
                    'usuario' => Auth::user()->name ,
                    'comentario' =>  strtoupper($comentario),
                    'documentos' => 'NO'
                ]);
            });    
        }
        catch(Exception $ex)
            {
                return back()->withError('Ha Ocurrido Un Error. '.$ex->getMessage());
            }

        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $solicitud = Sols_Solicitudes_DetalleModel::SolicitudDetalle($IdSolicitud, $IdSolicitudDetalle); //busca los datos
            
            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::SolsCorreosDestinatarios($solicitud->creado_por, $solicitud->id_departamento_servicio , $solicitud->id_departamento_solicitud, 'ACEPTAR');

            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(10), new SolsSolicitudesAceptarMailable($solicitud));   
        }
        catch (Exception $ex)
            {
                Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
            }           

        return redirect()->route('solicitudes.edit', $IdSolicitud)->withSuccess('La Solicitud Ha Sido Aceptada');
    }

    public function AsignarResponsables(Request $request, $IdSolicitud)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

        $responsables = $request['responsables']; //arreglo de responsables

        $IdSolicitudDetalle = Sols_Solicitudes_DetalleModel::max('id_solicitud_detalle') + 1;
        
        try
        {
            DB::transaction(function () use($IdSolicitud, $IdSolicitudDetalle, $responsables, $FechaActual)
            {
                $estatus = 'EN PROCESO';
                $UsuariosResponsables = '';
               
                //ACTUALIZA LA TABLA SOLICITUDES
                $solicitud = Sols_SolicitudesModel::find($IdSolicitud);
                $solicitud->fill([
                    'fecha_asignacion' => $FechaActual,
                    'asignado_por' => Auth::user()->id,
                    'estatus' => $estatus
                ]);
                $solicitud->save();
                
                //GUARDA EN LA TABLA RESPONSABLES
                foreach($responsables as $responsable)
                {
                    $responsable = explode('-', $responsable);;
                    $UsuariosResponsables .= $responsable[1].'. ';

                    $IdSolicitudResponsable = Sols_Solicitudes_ResponsablesModel::max('id_solicitud_responsable') + 1;
                    //GUARDA EN LA TABLA RESPONSABLES
                    Sols_Solicitudes_ResponsablesModel::create([
                        'id_solicitud_responsable' => $IdSolicitudResponsable,
                        'id_solicitud' => $IdSolicitud,
                        'id_responsable' => $responsable[0],
                        'nombre_responsable' => $responsable[1],
                        'fecha_asignacion' => $FechaActual
                    ]);
                }

                if(count($responsables) > 1)
                {
                    $comentario = 'SE HAN ASIGNADO LOS RESPONSABLES: '.$UsuariosResponsables;
                }
                else
                    {
                        $comentario = 'SE HA ASIGNADO EL RESPONSABLE: '.$UsuariosResponsables;
                    }
               
                //GUARDA EN LA TABLA DETALLE
                Sols_Solicitudes_DetalleModel::create([
                    'id_solicitud_detalle' => $IdSolicitudDetalle,
                    'id_solicitud' => $IdSolicitud,
                    'estatus' => $estatus,
                    'fecha' => $FechaActual,
                    'usuario' => Auth::user()->name ,
                    'comentario' =>  strtoupper($comentario),
                    'documentos' => 'NO'
                ]);
            });
        }
        catch(Exception $ex)
        {
            return back()->withError('Ha Ocurrido Un Error Al Agregar Los Responsables. '.$ex->getMessage());
        }

        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $solicitud = Sols_Solicitudes_DetalleModel::SolicitudDetalle($IdSolicitud, $IdSolicitudDetalle); //busca los datos
            
            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::SolsCorreosDestinatarios($solicitud->creado_por, $solicitud->id_departamento_servicio , $solicitud->id_departamento_solicitud, 'ASIGNAR');

            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(10), new SolsSolicitudesAsignarResponsablesMailable($solicitud));   
        }
        catch (Exception $ex)
            {
                Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
            }       

        return redirect()->route('solicitudes.edit', $IdSolicitud)->withSuccess('Responsables Asignados');
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdSolicitud)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

        try
        {
            $salida = Sols_SolicitudesModel::find($IdSolicitud);

            $salida->fill([
                'id_solicitud' => $IdSolicitud,
                'fecha_anulacion' => $FechaActual,
                'estatus' => 'ANULADO',
                'anulado_por' => Auth::user()->id
            ]);  
            $salida->save();
        }
        catch (Exception $ex)
        {
            return redirect()->route('solicitudes.index')->withError('Error Al Anular la solicitud '.$ex->getMessage());
        }
        return redirect()->route('solicitudes.index')->withSuccess('La solicitud ha sido anulada exitosamente');
        
    }
    

    // MUESTRA LA VISTA DE LA ENCUESTA DE LA SOLICITUD
    public function EncuestaSolicitud($IdSolicitud)
    {
        $solicitud = Sols_SolicitudesModel::find($IdSolicitud);
    
        if($solicitud->id_departamento_servicio == Auth::user()->id_departamento)
        {
            $EncuestaEnviada = Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud)->value('encuesta_solicitud_enviada');
            return view('SolicitudesServicios.Solicitudes.SolicitudesEncuestaSolicitud', compact('solicitud','EncuestaEnviada'));
        }
        else
            {
                return abort(401);
            }
        
    }

    // MUESTRA LA VISTA DE LA ENCUESTA DEL SERVICIO
    public function EncuestaServicio($IdSolicitud)
    {
        $solicitud = Sols_SolicitudesModel::find($IdSolicitud);

        if($solicitud->id_departamento_solicitud == Auth::user()->id_departamento)
        {
            $EncuestaEnviada = Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud)->value('encuesta_servicio_enviada');
            return view('SolicitudesServicios.Solicitudes.SolicitudesEncuestaServicio', compact('solicitud','EncuestaEnviada'));
        }
        else
            {
                return abort(401);
            }
    }

    //GUARDA LA ENCUESTA DE LA SOLICUTUD
    public function GuardarEncuestaSolicitud(Request $request, $IdSolicitud)
    {
        $IdSolicitudEncuesta = Sols_Solicitudes_EncuestasModel::max('id_solicitud_encuesta') + 1;
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

        try 
        {
            DB::transaction(function () use($IdSolicitud, $IdSolicitudEncuesta, $FechaActual, $request)
            {
                //GUARDA EN LA TABLA ENCUESTAS
                Sols_Solicitudes_EncuestasModel::create([
                    'id_solicitud_encuesta' => $IdSolicitudEncuesta,
                    'id_solicitud' => $IdSolicitud,
                    //'comentario',
                    'id_usuario' => Auth::user()->id,
                    'correo' => $request['correo'],
                    'tipo_encuesta' => 'SOLICITUD',
                    'fecha' => $FechaActual,
                    'estatus',
                    'pregunta1' => strtoupper('Cumplimiento de normativas para la solicitud del Servicio'),
                    'calificacion_pregunta1' => $request['calificacion_pregunta1'],
                    'pregunta2' => strtoupper('Nivel de información y planificación del servicio solicitado'),
                    'calificacion_pregunta2' => $request['calificacion_pregunta2'],
                ]);

                //ACTUALIZA LA TABLA SOLICITUDES
                Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud )
                        ->update(['encuesta_solicitud_enviada' => 'SI']); 
            });
        } 
        catch(Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Enviar La Encuesta. '.$ex->getMessage());
            }
        
        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $solicitud = Sols_Solicitudes_EncuestasModel::VerEncuesta($IdSolicitud, $IdSolicitudEncuesta); //busca los datos
            
            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::SolsCorreosDestinatarios($solicitud->creado_por, $solicitud->id_departamento_servicio , $solicitud->id_departamento_solicitud, 'ENCUESTA SERVICIO');

            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                //->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(10), new SolsSolicitudesFinalizarEncuestaSolicitudMailable($solicitud));   
        }
        catch (Exception $ex)
            {
                Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
            }     

        return redirect()->route('solicitudes.index')->withSuccess('Encuesta Enviada');
    }

    //GUARDA LA ENCUESTA DEL SERVICIO
    public function GuardarEncuestaServicio(Request $request, $IdSolicitud)
    {
        $IdSolicitudEncuesta = Sols_Solicitudes_EncuestasModel::max('id_solicitud_encuesta') + 1;
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

        try 
        {
            DB::transaction(function () use($IdSolicitud, $IdSolicitudEncuesta, $FechaActual, $request)
            {
                //GUARDA EN LA TABLA ENCUESTAS
                Sols_Solicitudes_EncuestasModel::create([
                    'id_solicitud_encuesta' => $IdSolicitudEncuesta,
                    'id_solicitud' => $IdSolicitud,
                    //'comentario',
                    'id_usuario' => Auth::user()->id,
                    'correo' => $request['correo'],
                    'tipo_encuesta' => 'SERVICIO',
                    'fecha' => $FechaActual,
                    'estatus',
                    'pregunta1' => strtoupper('Calidad y eficiencia del servicio'),
                    'calificacion_pregunta1' => $request['calificacion_pregunta1'],
                    'pregunta2' => strtoupper('Nivel de cumplimiento con los plazos de tiempo ofrecidos'),
                    'calificacion_pregunta2' => $request['calificacion_pregunta2'],
                    'pregunta3' => strtoupper('Nivel de información sobre el progreso del servicio'),
                    'calificacion_pregunta3' => $request['calificacion_pregunta3'],    
                ]);
        
                $estatus = 'FINALIZADO';
                //ACTUALIZA LA TABLA SOLICITUDES
                Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud )
                        ->update([
                            'encuesta_servicio_enviada' => 'SI', 
                            'estatus' => $estatus, 
                            'fecha_finalizacion' => $FechaActual, 
                            'finalizado_por' => Auth::user()->id
                        ]); 
            });
            
        } 
        catch(Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Enviar La Encuesta. '.$ex->getMessage());
            }

        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $solicitud = Sols_Solicitudes_EncuestasModel::VerEncuesta($IdSolicitud, $IdSolicitudEncuesta); //busca los datos
            
            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::SolsCorreosDestinatarios($solicitud->creado_por, $solicitud->id_departamento_servicio , $solicitud->id_departamento_solicitud, 'ENCUESTA SOLICITUD');

            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                //->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(10), new SolsSolicitudesFinalizarEncuestaServicioMailable($solicitud));   
        }
        catch (Exception $ex)
            {
                Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
            }       

        return redirect()->route('solicitudes.index')->withSuccess('Encuesta Enviada, Solicitud Finalizada');
    }

    public function ImprimirSolicitud($IdSolicitud)
    {
        $solicitud = Sols_SolicitudesModel::VerSolicitud($IdSolicitud);
        $pdf = Pdf::loadView('reportes.SolicitudesServicios.SolicitudPDF', compact('solicitud'));
        return $pdf->stream('SOLSERV-'.$IdSolicitud.'.pdf');
        
    }

    public function ImprimirSolicitudOt($IdSolicitud)
    {
        $solicitud = Sols_SolicitudesModel::VerSolicitud($IdSolicitud);
        $responsables = Sols_Solicitudes_ResponsablesModel::ResponsablesSolicitud($IdSolicitud);
        $pdf = Pdf::loadView('reportes.SolicitudesServicios.SolicitudOTPDF', compact('solicitud', 'responsables'));
        return $pdf->stream('SOLSERV-'.$IdSolicitud.'.pdf');
        
    }
    /**
     * OBTIENE LA LISTA DE SERVICIOS SEGUN EL DEPARTAMENTO SELECCIONADO EN EL FORMULARIO 
     * DE SOLICITUDES
     */
    public function serviciosdepartamento(Request $request)
    {
        $servicios = Sols_ServiciosModel::where('id_departamento', '=', $request->id)->get();
        return with(["servicios" => $servicios]);
    }

    /**
     * OBTIENE LA LISTA DE SUBSERVICIOS SEGUN EL SERVICIO SELECCIONADO EN EL FORMULARIO 
     * DE SOLICITUDES
     */
    public function subserviciosdepartamento(Request $request)
    {
        $subservicios = Sols_SubServiciosModel::where('id_servicio', '=', $request->id)->get();
        return with(["subservicios" => $subservicios]);
    }


    /** Eliminar responsables */
    public function EliminarResponsables($id_responsable)
    {
        try
        {
            Sols_Solicitudes_ResponsablesModel::destroy($id_responsable);
        }
        catch (Exception $e)
        {
            return redirect("responsables")->withError('No se puede eliminar el Responsable'); 
        }
        return redirect()->back()->withSuccess('El Responsable Ha Sido Eliminado Exitosamente');
        
    }

    /* Editar servicios y subservicios*/
    public function UpdateServicios(Request $request, $IdSolicitud)
    {   
        //@dd($IdSolicitud);
         $servicio = (int)$request['id_servicio'];
         $subservicio = (int)$request['id_subservicio'];
        
            try
            {
                DB::transaction(function () use ($IdSolicitud, $servicio, $subservicio) 
                {
                    Sols_SolicitudesModel::where('id_solicitud', '=', $IdSolicitud )
                    ->update(['id_servicio' => $servicio, 'id_subservicio'  => $subservicio]); 
                });
            }
            catch (Exception $ex) 
                {
                    return back()->withError('Ha Ocurrido Un Error Al actualizar el servicio. '.$ex->getMessage())->withInput();
                }
     
        return redirect()->route('solicitudes.edit', $IdSolicitud)->withSuccess('El Servicio/Subservicio fue agregado exitosamente');
    
    }
}
