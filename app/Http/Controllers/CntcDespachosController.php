<?php

namespace App\Http\Controllers;
use App\Models\Asal_VehiculosModel;
use App\Models\Cntc_Tipo_CombustibleModel;
use App\Models\Cntc_Solicitudes_DespachoModel;
use App\Models\Cntc_Solicitudes_Despacho_DetalleModel;
use App\Models\Asal_SalidasModel;
use App\Models\DepartamentosModel;
use App\Models\CorreosModel;
use App\Mail\CntcSolicitudesDespachoCreateMailable;
use App\Mail\CntcSolicitudesDespachoAceptarMailable;
use App\Mail\CntcSolicitudesDespachoProcesadoMailable;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\CntcDespachosCreateRequest;
use App\Http\Requests\CntcDespachosUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CntcDespachosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos= Cntc_Tipo_CombustibleModel::all();
        $solicitudes=Cntc_Solicitudes_DespachoModel::Solicitudes();
     
        return view('ControlCombustible.Despachos.Despacho',compact('tipos','solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehiculos = Asal_VehiculosModel::all();
        $tipos= Cntc_Tipo_CombustibleModel::all();
        $empleados = Asal_SalidasModel::EmpleadosSalidas();
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
        return view('ControlCombustible.Despachos.DespachoCreate',compact('vehiculos','departamentos','tipos','empleados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CntcDespachosCreateRequest $request)
    {
    
       $IdSolicitudDespacho = Cntc_Solicitudes_DespachoModel::max('id_solicitud_despacho') + 1;
       $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
       $EstatusSolicitud='POR ACEPTAR';
        if( $request['id_combustible'] == 1)
        {
            $IdDepartamentoServicio= 19;
        }
        else{
            $IdDepartamentoServicio= 9;
        }

       $equipos= json_decode($request['vehiculos']); 

       if($equipos  == NULL) //Valida que el arreglo de los equipo no este vacio
        {
            return back()->withErrors(['equipos'=> 'Para realizar una solicitud debe seleccionar uno o varios equipos'])->withInput();
        }
       

        try
        {
            DB::transaction(function () use ($request, $FechaActual, $EstatusSolicitud, $IdSolicitudDespacho, $equipos,$IdDepartamentoServicio)
            {
                Cntc_Solicitudes_DespachoModel::create([
                    'id_solicitud_despacho' => $IdSolicitudDespacho,
                    'id_combustible' => $request['id_combustible'],
                    'id_departamento' => $request['departamento'],
                    'motivo' => strtoupper($request['motivo']),
                    'creado_por' => Auth::user()->name,
                    'fecha_creacion' => $FechaActual,
                    'estatus' => $EstatusSolicitud,
                    'total'=>$request['total'],
                    'id_departamento_servicio'=>$IdDepartamentoServicio,
                ]);

                foreach($equipos as $equipo)
                {
                    $IdSolicitudDespachoDetalle = Cntc_Solicitudes_Despacho_DetalleModel::max('id_solicitud_despacho_detalle') + 1;

                    Cntc_Solicitudes_Despacho_DetalleModel::create([
                        'id_solicitud_despacho_detalle' => $IdSolicitudDespachoDetalle,
                        'id_solicitud_despacho' => $IdSolicitudDespacho,
                        'placa_equipo' => $equipo->placa_vehiculo,
                        'marca_equipo'=> strtoupper($equipo->marca_vehiculo),
                        'responsable'=>$equipo->responsable,
                        'cantidad' => $equipo->cantidad
                    ]);
                }

            });
        }
        catch(Exception $ex) 
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Solicitud. '.$ex->getMessage())->withInput();
        }

         //VALIDACION AL ENVIAR CORREOS
         try
         {
             $solicitud =  Cntc_Solicitudes_DespachoModel::Solicitud($IdSolicitudDespacho); //busca los datos

             //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
             $destinatarios = CorreosModel::CntcCorreosDestinatarios(Auth::user()->id, $request['id_departamento'], $request['id_combustible'], 'CREAR');
            
             // ENVIA EL CORREO
             Mail::to($destinatarios[0]) //DESTINATARIOS
                 ->cc($destinatarios[1]) //EN COPIA
                 //->bcc($destinatarios[2]) // EN COPIA OCULTA
                 ->later(now()->addSeconds(10), new CntcSolicitudesDespachoCreateMailable($solicitud));   
         }
         catch (Exception $ex)
             {
                 Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
             }   
        return redirect(route("cntcdespachos.index"))->withSuccess("La Solicitud de Despacho de Combustible Ha Sido Creada Exitosamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdSolicitudDespacho)
    {
        $solicitudes = Cntc_Solicitudes_DespachoModel::Solicitud($IdSolicitudDespacho);
        $equipos = Cntc_Solicitudes_Despacho_DetalleModel::EquiposDespacho($IdSolicitudDespacho);
        return view('ControlCombustible.Despachos.DespachoShow',compact('solicitudes','equipos'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdSolicitudDespacho)
    {
        $solicitudes =  Cntc_Solicitudes_DespachoModel::find($IdSolicitudDespacho);
        $vehiculos = Asal_VehiculosModel::all();
        $tipos= Cntc_Tipo_CombustibleModel::all();
        $empleados = Asal_SalidasModel::EmpleadosSalidas();
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
        $equipos=Cntc_Solicitudes_Despacho_DetalleModel::EquiposDespacho($IdSolicitudDespacho);
      
        if($solicitudes->estatus == 'APROBADO')
        {
            $aprobado = 'disabled';
        }
        else
            {
                $aprobado = NULL;
            }
            return view('ControlCombustible.Despachos.DespachoEdit', compact('solicitudes', 'aprobado', 'vehiculos','tipos','departamentos','equipos','empleados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CntcDespachosUpdateRequest $request, $IdSolicitudDespacho)
    {
      
        $equipos =  json_decode($request['vehiculos']); 
  

        if($equipos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['equipos'=> 'Para realizar una solicitud debe seleccionar uno o varios equipos'])->withInput();
        }

        try
        {
            DB::transaction(function () use ($request, $equipos, $IdSolicitudDespacho) 
            {
                $solicitud = Cntc_Solicitudes_DespachoModel::find($IdSolicitudDespacho);
                $solicitud->fill([
                    'id_solicitud_despacho' => $IdSolicitudDespacho,
                    'motivo' => strtoupper($request['motivo']),
                    'total'=> $request['total'],
                   
                ]);
                $solicitud->save();
                
                if ($equipos != NULL)  //verifica si el arreglo no esta vacio
                {
                   // Eliminar los detalles de solicitud existentes
                    Cntc_Solicitudes_Despacho_DetalleModel::where('id_solicitud_despacho', $IdSolicitudDespacho)->delete();

                  // Insertar los nuevos detalles de solicitud
                    foreach ($equipos as $equipo) {
                        $IdSolicitudDespachoDetalle = Cntc_Solicitudes_Despacho_DetalleModel::max('id_solicitud_despacho_detalle') + 1;
                        Cntc_Solicitudes_Despacho_DetalleModel::create([

                            'id_solicitud_despacho_detalle'=>$IdSolicitudDespachoDetalle,
                            'id_solicitud_despacho' => $IdSolicitudDespacho,
                            'placa_equipo' => $equipo->placa_vehiculo,
                            'marca_equipo' => $equipo->marca_vehiculo,
                            'cantidad' => $equipo->cantidad,
                            'responsable' => $equipo->responsable,
                        ]);
                    }
                }
            });
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Solicitud. '.$ex->getMessage())->withInput();
            }

       
        return redirect()->route("cntcdespachos.edit", $IdSolicitudDespacho)->withSuccess("La Solicitud de Despacho Ha Sido Editada Exitosamente");
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
      
        
        try
        {
            DB::transaction(function () use ($IdSolicitudDespacho, $FechaActual, $EstatusSolicitud)
            {
                $solicitud = Cntc_Solicitudes_DespachoModel::find($IdSolicitudDespacho);

                $solicitud->fill([
                    'estatus' => $EstatusSolicitud,
                    'anulado_por' => Auth::user()->name,
                    'fecha_anulacion' => $FechaActual
                ]);  

                $solicitud->save();

            });
        }
        catch (Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Anular La Solicitud. '.$ex->getMessage())->withInput();
        }

        return redirect()->route("cntcdespachos.index")->withSuccess("La Solicitud de Despacho de Combustible Ha Sido Anulada Exitosamente");
    }


  
    

    public function Despachar($IdSolicitudDespacho)
    {
        $solicitudes = Cntc_Solicitudes_DespachoModel::Solicitud($IdSolicitudDespacho);
        $equipos = Cntc_Solicitudes_Despacho_DetalleModel::EquiposDespacho($IdSolicitudDespacho);
        $IdCombustible = Cntc_Solicitudes_DespachoModel::where('id_solicitud_despacho', '=', $IdSolicitudDespacho)
        ->pluck('id_combustible')
        ->first();
        $tipoCombustible = Cntc_Tipo_CombustibleModel::where('id_tipo_combustible', '=',  $IdCombustible)->first();

        return view('ControlCombustible.Despachos.DespachoDespachar',compact('solicitudes','equipos','tipoCombustible'));

    }

    public function AceptarSolicitudDespacho(Request $request,$IdSolicitudDespacho)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $estatus = 'ACEPTADO';

        try 
        {
            DB::transaction(function () use ($FechaActual, $IdSolicitudDespacho,$estatus) 
                {
                    Cntc_Solicitudes_DespachoModel::where('id_solicitud_despacho', '=', $IdSolicitudDespacho)
                    ->update(['aceptado_por' => Auth::user()->name, 'fecha_aceptado' => $FechaActual, 'estatus' => $estatus]);
                    
                  
                }
            );
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Aceptar La Solicitud. '.$ex->getMessage())->withInput();
            }
        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $solicitud =  Cntc_Solicitudes_DespachoModel::Solicitud($IdSolicitudDespacho); //busca los datos
            
            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::CntcCorreosDestinatarios(Auth::user()->id, $solicitud->id_departamento, $solicitud->id_tipo_combustible, 'ACEPTAR');
           
            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(10), new CntcSolicitudesDespachoAceptarMailable($solicitud));   
        }
        catch (Exception $ex)
            {
                Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
            }   



        return redirect()->route("cntcdespachos.show", $IdSolicitudDespacho)->withSuccess("La Solicitud de Despacho Ha Sido Aceptada.");
    }

    public function ProcesarSolicitudDespacho(Request $request,$IdSolicitudDespacho)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $estatus = 'PROCESADO';
        $IdCombustible = Cntc_Solicitudes_DespachoModel::where('id_solicitud_despacho', '=', $IdSolicitudDespacho)
        ->pluck('id_combustible')
        ->first();
        $tipoCombustible = Cntc_Tipo_CombustibleModel::where('id_tipo_combustible', '=',  $IdCombustible)->first();
        $totales =  json_decode($request['totales']); 
        $equipos =  json_decode($request['vehiculos']); 
   
        foreach ($equipos as $equipo)
        {
            if (empty($equipo->fecha_despacho)) {
                return back()->withErrors(['fecha_despacho' => 'La fecha de despacho no puede estar vacía en ninguno de los equipos.'])->withInput();
            }
        }


      
       
        if($totales[0]->despachado > $tipoCombustible->stock ) {
            return back()->withErrors(['totales'=> 'La Solicitud De Despacho No Puede Ser Mayor A La Disponibilidad de Combustible Ni Menor a Cero'])->withInput();
        }
        
        else{
                try 
                {
                    DB::transaction(function () use ($FechaActual, $IdSolicitudDespacho,$estatus, $totales, $tipoCombustible,$equipos) 
                        {
                         
                          
                             // Insertar los nuevos detalles de solicitud
                                
                            // Inicializar una variable para almacenar el valor del combustible anterior
                            $combustible_anterior = null;

                            foreach ($equipos as $equipo) {
                                // Calcula el nuevo valor de stock_combustible
                                if ($combustible_anterior !== null) {
                                    $nuevo_stock_combustible = $combustible_anterior - $equipo->cantidad_despachada;
                                } else {
                                    // Para la primera iteración, usa el valor de combustible menos cantidad_despachada
                                    $nuevo_stock_combustible = $equipo->combustible - $equipo->cantidad_despachada;
                                }

                                // Actualizar el registro en la base de datos
                                Cntc_Solicitudes_Despacho_DetalleModel::where('id_solicitud_despacho_detalle', '=', $equipo->id_solicitud_despacho_detalle)
                                    ->update([
                                        'cantidad_despachada' => $equipo->cantidad_despachada,
                                        'fecha_despacho' => $equipo->fecha_despacho,
                                        'stock_combustible' => $nuevo_stock_combustible
                                    ]);

                                // Actualizar el valor del combustible anterior para la siguiente iteración
                                $combustible_anterior = $nuevo_stock_combustible;
                            }
                            
                            $nuevoStock = $tipoCombustible->stock - $totales[0]->despachado;
                            // Actualiza el stock
                            $tipoCombustible->update(['stock' => $nuevoStock]);

                              $detallesDespacho = Cntc_Solicitudes_Despacho_DetalleModel::where('id_solicitud_despacho', '=', $IdSolicitudDespacho)
                                ->whereNull('fecha_despacho')
                                ->get();

                            if ($detallesDespacho->isEmpty()) {
                                // Todos los detalles tienen fecha de despacho, por lo tanto, actualiza el estado de la solicitud de despacho
                                Cntc_Solicitudes_DespachoModel::where('id_solicitud_despacho', '=', $IdSolicitudDespacho)
                                    ->update(['aprobado_por' => Auth::user()->name, 'fecha_aprobacion' => $FechaActual, 'estatus' => $estatus, 'stock_final' => $totales[0]->stock_final, 'total_despachado' => $totales[0]->totaldespachado]);
                                    

                                    //VALIDACION AL ENVIAR CORREOS
                                        try
                                        {
                                            $solicitud =  Cntc_Solicitudes_DespachoModel::Solicitud($IdSolicitudDespacho); //busca los datos
                                            
                                            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
                                            $destinatarios = CorreosModel::CntcCorreosDestinatarios(Auth::user()->id, $solicitud->id_departamento, $solicitud->id_tipo_combustible, 'PROCESADO');
                                        
                                            // ENVIA EL CORREO
                                            Mail::to($destinatarios[0]) //DESTINATARIOS
                                                ->cc($destinatarios[1]) //EN COPIA
                                                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                                                ->later(now()->addSeconds(10), new CntcSolicitudesDespachoProcesadoMailable($solicitud));   
                                        }
                                        catch (Exception $ex)
                                            {
                                                Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
                                            }   

                            }
                        }
                    );
                } 
                catch (Exception $ex) 
                    {
                        return redirect()->back()->withError('Ha Ocurrido Un Error Al Procesar La Solicitud. '.$ex->getMessage())->withInput();
                    }
        }
        return redirect()->route("cntcdespacharsolicituddespacho", $IdSolicitudDespacho)->withSuccess("La Solicitud de Despacho Ha Sido Procesada.");
    }


}
