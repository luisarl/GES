<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsalSalidasCreateRequest;
use App\Http\Requests\AsalSalidasUpdateRequest;
use App\Mail\AsalSalidasAprobarMailable;
use App\Mail\AsalSalidasCerrarMailable;
use App\Mail\AsalSalidasCreateMailable;
use App\Mail\AsalSalidasEditMailable;
use App\Mail\AsalSalidasValidarMailable;
use App\Models\AlmacenesModel;
use App\Models\ArticulosModel;
use App\Models\Asal_Salidas_DetalleModel;
use App\Models\Asal_SalidasModel;
use App\Models\Asal_TiposModel;
use App\Models\Asal_VehiculosModel;
use App\Models\CorreosModel;
use App\Models\EmpresasModel;
use App\Models\UnidadesModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Exception;
use Session;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AsalSalidasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salidas = Asal_SalidasModel::ListaSalidas();
        //$articulos = Asal_Salidas_DetalleModel::select('id_salida','nombre_articulo')->get();
        return view('SalidaMateriales.Salidas.Salidas', compact('salidas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = AlmacenesModel::all();
        $unidades = UnidadesModel::select('id_unidad','nombre_unidad')->get();    
        $articulos = ArticulosModel::select('id_articulo', 'codigo_articulo', 'nombre_articulo', 'tipo_unidad')->get();
        $autorizados = Asal_SalidasModel::EmpleadosAutorizadosSalidas();
        $solicitantes = User::UsuariosDepartamentos();
        $empleados = Asal_SalidasModel::EmpleadosSalidas();
        $vehiculos = Asal_VehiculosModel::all();
        $tipos = Asal_TiposModel::select('id_tipo', 'nombre_tipo')->where('activo', '=', 'SI')->get();

        return view('SalidaMateriales.Salidas.SalidasCreate', compact('articulos','empleados', 'autorizados', 'solicitantes', 'unidades', 'vehiculos', 'almacenes', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsalSalidasCreateRequest $request)
    {
        //dd($request->all());

        $IdSalida = Asal_SalidasModel::max('id_salida') + 1;  

        $articulos =  json_decode($request['datosmovimiento']);    

        if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['datosmovimiento'=> 'Para realizar una salida debe seleccionar uno o varios articulos'])->withInput();
        }

       try
       {
           // VALIDA SI EXISTE UN ERROR EN ALGUN INSERT NO REALIZE NINGUNO
           DB::transaction(function () use ($request, $articulos, $IdSalida)
           {    
                $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
                $solicitante = explode(" - ", $request['solicitante']);
                $TipoChofer = $request['tipo_chofer'];
                $TipoVehiculo = $request['tipo_vehiculo'];
        
        
                if($TipoChofer == 'INTERNO')
                {
                    $conductor = $request['conductorinterno'];
                }
                else    
                    {
                        $conductor = $request['conductorforaneo'];
                    }
                
                if($TipoVehiculo == 'INTERNO')
                {
                    $vehiculo_interno = $request['id_vehiculo'];
                    $vehiculo_foraneo = NULL;
                }
                else    
                    {
                        $vehiculo_interno = NULL;
                        $vehiculo_foraneo = 'Placa: '. $request['placa'] .' Marca: '.$request['marca'] . ' Modelo: '. $request['modelo']   ;
                    }

                Asal_SalidasModel::create(
                    [
                        'id_salida' => $IdSalida,
                        'id_almacen' => $request['id_almacen'],
                        //'correlativo',
                        'solicitante' => strtoupper($solicitante[0]),
                        'departamento' => strtoupper($request['departamento']),
                        'autorizado' => strtoupper($request['autorizado']),
                        'responsable'=> strtoupper($request['responsable']),
                        //'tipo_salida' => $request['tipo_salida'],
                        'id_tipo' => $request['id_tipo'],
                        'id_subtipo' => $request['id_subtipo'],
                        'tipo_conductor' => $request['tipo_chofer'],
                        'conductor' => strtoupper($conductor),
                        'tipo_vehiculo' => $request['tipo_vehiculo'],
                        'id_vehiculo' => $vehiculo_interno,
                        'vehiculo_foraneo' => strtoupper($vehiculo_foraneo),
                        'destino' => strtoupper($request['destino']),
                        'motivo'=> strtoupper($request['motivo']),
                        'fecha_salida' => $request['fecha_salida'],
                        'hora_salida' => $request['hora_salida'],
                        'validado' => 'NO',
                        'estatus' => 'GENERADO',
                        'creado_por' => Auth::user()->id ,
                        'actualizado_por' => Auth::user()->id
                    ]
                );

                $item = 0;
                foreach($articulos as $articulo) 
                {
                    $IdDetalle = Asal_Salidas_DetalleModel::max('id_detalle') + 1;
                    $item += 1;

                    Asal_Salidas_DetalleModel::create(
                        [
                            'id_detalle'=> $IdDetalle,
                            'id_salida' => $IdSalida,
                            'item' => $item,
                            //'id_articulo'=> $articulo->id_articulo,
                            'codigo_articulo' => $articulo->id_articulo,
                            'nombre_articulo' => strtoupper($articulo->nombre_articulo),
                            'tipo_unidad' => $articulo->unidad,
                            'cantidad_salida' => $articulo->cantidad,
                            'comentario' => strtoupper($articulo->comentario),
                            'fecha_salida' => $FechaActual,
                            'importacion' => strtoupper($articulo->importacion)
                        ]
                    );     
                }
            });
       }
       catch(Exception $ex)
       {
            return back()->withError('Ha Ocurrido Un Error Al Crear La Salida: '.$ex->getMessage())->withInput();
       }

        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $usuario = Auth::user()->name;
            $salida = Asal_SalidasModel::VerSalida($IdSalida); //busca los datos de la salida

            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::AsalCorreosDestinatarios(Auth::user()->id , $salida->solicitante, $salida->departamento, $request['id_almacen'], 'CREAR');

            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
               // ->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(60), new AsalSalidasCreateMailable($salida, $usuario));   
        }
        catch (Exception $ex)
        {
            Session::flash('alert','Se Produjo Un error Al Enviar El Correo: '.$ex->getMessage());
        }

        return redirect()->route('autorizacionsalidas.edit',$IdSalida)->withSuccess('La Salida Ha Sido Creada Exitosamente');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdSalida)
    {
        $salida = Asal_SalidasModel::VerSalida($IdSalida);
        $articulos = Asal_Salidas_DetalleModel::DetalleSalida($IdSalida);
        return view('SalidaMateriales.Salidas.SalidasShow', compact('salida','articulos'));
    }

    public function imprimir($IdSalida)
    {
        $salida = Asal_SalidasModel::VerSalida($IdSalida);
        $articulos = Asal_Salidas_DetalleModel::all()->where('id_salida', $IdSalida)->where('fecha_retorno', NULL);
    
        $pdf = PDF::loadView('Reportes.SalidaMateriales.AutorizacionSalida', compact('salida','articulos'));
        return $pdf->stream('AS-'.$IdSalida.'.pdf');
    }

    public function ImprimirLargo($IdSalida)
    {
        $salida = Asal_SalidasModel::VerSalida($IdSalida);
        $articulos = Asal_Salidas_DetalleModel::all()->where('id_salida', $IdSalida)->where('fecha_retorno', NULL);
    
        $pdf = PDF::loadView('Reportes.SalidaMateriales.AutorizacionSalidaLargo', compact('salida','articulos'));
        return $pdf->stream('AS-'.$IdSalida.'.pdf');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdSalida)
    {
        $almacenes = AlmacenesModel::all();
        $autorizados = Asal_SalidasModel::EmpleadosAutorizadosSalidas();
        $empleados = Asal_SalidasModel::EmpleadosSalidas();
        $ArticulosSalida = Asal_Salidas_DetalleModel::all()->where('id_salida', $IdSalida)->where('cantidad_salida', '>', 0);
        $articulos = ArticulosModel::select('id_articulo', 'codigo_articulo', 'nombre_articulo', 'tipo_unidad')->get();
        $solicitantes = User::UsuariosDepartamentos();
        $unidades = UnidadesModel::select('id_unidad','nombre_unidad')->get();   
        $vehiculos = Asal_VehiculosModel::all();
        $salida = Asal_SalidasModel::find($IdSalida);
        $tipos = Asal_TiposModel::select('id_tipo', 'nombre_tipo')->where('activo', '=', 'SI')->get();
        //$validado = Asal_SalidasModel::select('validado', 'anulado')->where('id_salida', $IdSalida)->fist();
        $DepartamentoSolicitante = User::where('id' ,'=', $salida->creado_por)->value('id_departamento'); //consultar el departamento del usuario que creo y validad if auth->dapartamento = 1
        $DepartamentoValidacion =  User::where('name' ,'=',  $salida->usuario_validacion_almacen)->value('id_departamento');

        if($salida->validado == 'SI' || $salida->anulado == 'SI' ) 
        {
            $validado = 'disabled';
        }
        else
            {
                $validado = NULL;
            }

        if($DepartamentoValidacion == Auth::user()->id_departamento && $salida->estatus == 'VALIDADO/ALMACEN')
        {
            $validado = NULL;
        }    
        
        return view('SalidaMateriales.Salidas.SalidasEdit', compact('salida', 'articulos', 'unidades', 'ArticulosSalida', 'empleados', 'autorizados', 'solicitantes', 'almacenes', 'vehiculos','validado', 'DepartamentoSolicitante', 'DepartamentoValidacion', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AsalSalidasUpdateRequest $request, $IdSalida)
    {

        $salida = Asal_SalidasModel::find($IdSalida);

        $solicitante = explode(" - ", $request['solicitante']);
        $TipoChofer = $request['tipo_chofer'];
        $TipoVehiculo = $request['tipo_vehiculo'];

        if ($TipoChofer == 'INTERNO') 
        {
            $conductor = $request['conductorinterno'];
        } 
        else 
            {
                $conductor = $request['conductorforaneo'];
            }

        if ($TipoVehiculo == 'INTERNO') 
        {
            $vehiculo_interno = $request['id_vehiculo'];
            $vehiculo_foraneo = NULL;
        } 
        else 
            {
                $vehiculo_interno = NULL;
                $vehiculo_foraneo = 'Placa: ' . $request['placa'] . ' Marca: ' . $request['marca'] . ' Modelo: ' . $request['modelo'];
            }
        
        try
        {
            $salida->fill([
                'id_salida' => $IdSalida,
                'solicitante' => strtoupper($solicitante[0]),
                'departamento' => strtoupper($request['departamento']),
                'autorizado' => strtoupper($request['autorizado']),
                'responsable' => strtoupper($request['responsable']),
                'id_tipo' => $request['id_tipo'],
                'id_subtipo' => $request['id_subtipo'],
                'tipo_conductor' => $request['tipo_chofer'],
                'conductor' => strtoupper($conductor),
                'tipo_vehiculo' => $request['tipo_vehiculo'],
                'id_vehiculo' => $vehiculo_interno,
                'vehiculo_foraneo' => strtoupper($vehiculo_foraneo),
                'destino' => strtoupper($request['destino']),
                'motivo' => strtoupper($request['motivo']),
                'fecha_salida' => $request['fecha_salida'],
                'hora_salida' => $request['hora_salida'],
                //'validado' => 'NO',
                'id_almacen' => $request['id_almacen'],
                'actualizado_por' => Auth::user()->id 

            ]);  
                
            $articulos =  json_decode($request['datosmovimiento']); 
            
            if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
            {
                return back()->withErrors(['datosmovimiento'=> 'Para realizar una salida debe seleccionar uno o varios articulos'])->withInput();
            }
            DB::transaction(function () use ($salida, $articulos, $IdSalida) {
                $salida->save();
                $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
                //dd($articulos);
                if ($articulos != NULL)  //verifica si el arreglo no esta vacio
                {
                    $item = 0;
                    foreach ($articulos as $articulo) {

                        if($articulo->id_detalle == '')
                        {
                              $IdDetalle = Asal_Salidas_DetalleModel::max('id_detalle') + 1;
                        }
                        else
                            {   
                                $IdDetalle = $articulo->id_detalle;
                            }
                      
                        $item += 1;
                        Asal_Salidas_DetalleModel::updateOrCreate(
                            [
                                'id_detalle' => $articulo->id_detalle,
                                'id_salida' => $IdSalida,     
                            ],
                            [
                                'id_detalle' => $IdDetalle,
                                'id_salida' => $IdSalida,
                                'item'=> $item,
                                'codigo_articulo' => $articulo->id_articulo,
                                'nombre_articulo' => strtoupper($articulo->nombre_articulo),
                                'tipo_unidad' => $articulo->unidad,
                                'cantidad_salida' => $articulo->cantidad,
                                'comentario' => strtoupper($articulo->comentario),
                                'fecha_salida' => $FechaActual,
                                'importacion' => strtoupper($articulo->importacion)
                            ]
                        );
                    }
                }
            });
        }
        catch(Exception $ex)
        { 
            return back()->withError('Ha Ocurrido Un Error al Modificar la Salida '.$ex->getMessage()); 
        }
        //VALIDACION AL ENVIAR CORREOS
        try
        { 
            $usuario = Auth::user()->name;
            $salida = Asal_SalidasModel::VerSalida($IdSalida); //busca los datos de la salida

            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::AsalCorreosDestinatarios(Auth::user()->id ,$salida->solicitante , $salida->departamento, $salida->id_almacen, 'EDITAR');

            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(60), new AsalSalidasEditMailable($salida, $usuario));   
        }
        catch (Exception $ex)
        {
            Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
        }
        
        return back()->withSuccess('La Salida Ha Sido Modificada Exitosamente');
    }

    public function ValidarSalida($IdSalida)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        
        try
        {
            $estatus = 'VALIDADO/ABIERTO';  

            Asal_SalidasModel::where('id_salida', '=', $IdSalida )
            ->update(['usuario_validacion' => Auth::user()->name, 'fecha_validacion' => $FechaActual, 'estatus' => $estatus]); 
        }
        catch (Exception $ex)
        {
            return back()->withError('Ha Ocurrido Un Error Al Validar la Salida '.$ex->getMessage()); 
        }
        
        //VALIDACION ENVIO DE CORREO
        try
        {
            $usuario = Auth::user()->name;
            $salida = Asal_SalidasModel::VerSalida($IdSalida); //busca los datos de la salida

            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::AsalCorreosDestinatarios(Auth::user()->id , $salida->solicitante, $salida->departamento, $salida->id_almacen, 'APROBAR');

            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(60), new AsalSalidasAprobarMailable($salida, $usuario));   
        }
        catch (Exception $ex)
        {
            Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
        }

        return back()->withSuccess('La Salida Ha Sido Validada');
    }

    public function ValidarSalidaAlmacen($IdSalida)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        
        try
        {
            $validado = 'SI';  
            $estatus = 'VALIDADO/ALMACEN';  

            Asal_SalidasModel::where('id_salida', '=', $IdSalida )
            ->update(['validado' => $validado, 'usuario_validacion_almacen' => Auth::user()->name, 'fecha_validacion_almacen' => $FechaActual, 'estatus' => $estatus]); 

        }
        catch (Exception $ex)
        {
            return back()->withError('Ha Ocurrido Un Error Al Validar la Salida '.$ex->getMessage()); 
        }
        
        //VALIDACION ENVIO DE CORREO
        try
        {
            $usuario = Auth::user()->name;
            $salida = Asal_SalidasModel::VerSalida($IdSalida); //busca los datos de la salida

            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::AsalCorreosDestinatarios(Auth::user()->id , $salida->solicitante , $salida->departamento, $salida->id_almacen, 'VALIDAR');

            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(60), new AsalSalidasValidarMailable($salida, $usuario));   
        }
        catch (Exception $ex)
        {
            Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
        }

        return back()->withSuccess('La Salida Ha Sido Validada');
    }

    public function CerrarSalidaAlmacen($IdSalida)
    {
        $salida = Asal_SalidasModel::VerSalida($IdSalida);
        $articulos = Asal_Salidas_DetalleModel::DetalleSalida($IdSalida);
        return view('SalidaMateriales.Salidas.SalidasCierreAlmacen', compact('salida','articulos'));
    }

    public function GuardarCierreSalidaAlmacen(Request $request, $IdSalida)
    {
        //dd($request->all());
        $articulos = json_decode($request['datoscierre']); 
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

        if($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['datoscierre'=> 'Para realizar el cierre debe seleccionar uno o varios articulos'])->withInput();
        }

        try
        {
            if($articulos != null)
            {
                foreach ($articulos as $articulo)
                {
                    if($articulo->cerrar == true)
                    {
                        Asal_Salidas_DetalleModel::where('id_salida', '=', $IdSalida )
                        ->where('id_detalle', '=', $articulo->id_detalle)
                        ->update(['usuario_cierre' => Auth::user()->name, 'fecha_cierre' => $FechaActual, 
                                'observacion_almacen' => strtoupper($articulo->observacion_almacen), 'cerrado' => 'SI']); 
                    }
                }

                //cierre almacen cambio estatus
                $cerrado = Asal_SalidasModel::CierreAlmacenSalidas($IdSalida);
            }

             
        }
        catch (Exception $ex)
        {
            return back()->withError('Ha Ocurrido Un Error Al Cerrar  la Salida '.$ex->getMessage()); 
        }
        
        if($cerrado)
        {
            // VALIDACION ENVIO DE CORREO
            try
            {
                $usuario = Auth::user()->name;
                $salida = Asal_SalidasModel::VerSalida($IdSalida); //busca los datos de la salida

                //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
                $destinatarios = CorreosModel::AsalCorreosDestinatarios(Auth::user()->id , $salida->solicitante , $salida->departamento, $salida->id_almacen, 'CERRAR');

                // ENVIA EL CORREO
                Mail::to($destinatarios[0]) //DESTINATARIOS
                    ->cc($destinatarios[1]) //EN COPIA
                    //->bcc($destinatarios[2]) // EN COPIA OCULTA
                    ->later(now()->addSeconds(60), new AsalSalidasCerrarMailable($salida, $usuario));   
            }
            catch (Exception $ex)
            {
                Session::flash('alert','Se Produjo Un Error Al Enviar El Correo: '.$ex->getMessage());
            }

            return back()->withSuccess('La Salida Ha Sido Cerrada');
        }
        
        return back()->withSuccess('Los Articulos Seleccionados Han Sido Cerrados');
    }

    public function EliminarDetalle($id_detalle)
    {
        try
        {
            Asal_Salidas_DetalleModel::destroy($id_detalle);
        }
        catch (Exception $e)
        {
            return back()->withError('Error Al Eliminar');
        }

        return back()->with('');
    }

    public function ImportarNotaEntregaProfit(Request $request)
    {
        $IdAlmacen = $request->get('id_almacen');
        $NumeroNota = $request->get('numero');
        $bd = EmpresasModel::EmpresaSegunAlmacen($IdAlmacen);

        $articulos = Asal_Salidas_DetalleModel::NotaEntregaProfit($bd->base_datos, $NumeroNota);
        return with(["articulos" => $articulos]);
    }

    public function retorno($IdSalida)
    {
        $salida = Asal_SalidasModel::VerSalida($IdSalida);
        $articulos = Asal_Salidas_DetalleModel::DetalleSalida($IdSalida);
        return view('SalidaMateriales.Salidas.SalidasRetorno', compact('salida','articulos'));
    }

    public function RetornoSalidas(Request $request, $IdSalida)
    {     
        //busca los datos del detalle de los movimientos del despacho
        try {

            $datosretorno = json_decode($request['datosretorno']); //arreglo de datos 

            DB::transaction(function () use ($datosretorno, $IdSalida) {
                $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

                if ($datosretorno != "")  //verifica si el arreglo no esta vacio
                {
                    foreach ($datosretorno as $datos) 
                    {
                        $IdDetalle = Asal_Salidas_DetalleModel::max('id_detalle') + 1;

                        //INSERTA SI LA CANTIDAD DE RETORNO ES MAYOR A CERO Y ESTATUS VACIO
                        if($datos->cantidad_retorno != 0 && $datos->estatus == '')
                        {
                            //BUSCA LA CANTIDAD RETORNO DE UN ARTICULO
                            $CantidadRetorno = Asal_Salidas_DetalleModel::where('id_detalle', '=', $datos->id_detalle)
                                ->where('estatus', '=', NULL)
                                ->value('cantidad_retorno');

                            //ACTUALIZA LA CANTIDAD RETORNO DE UN ARTICULO    
                            Asal_Salidas_DetalleModel::where('id_detalle', '=', $datos->id_detalle)
                                ->where('estatus', '=', NULL)
                                ->update([
                                    'cantidad_retorno' =>  $datos->cantidad_retorno + $CantidadRetorno
                                ]);

                            //INSERTA EL MOVIMIENTO O DEVOLUCION DE UN ARTICULO 
                            Asal_Salidas_DetalleModel::create(
                                [
                                    'id_detalle'=> $IdDetalle,
                                    'id_salida' => $IdSalida,
                                    'item' => $datos->item,
                                    'codigo_articulo' => $datos->codigo_articulo,
                                    'nombre_articulo' => strtoupper($datos->nombre_articulo),
                                    'tipo_unidad' => $datos->unidad,
                                    'cantidad_retorno' => $datos->cantidad_retorno,
                                    'fecha_retorno' => $FechaActual,
                                    'observacion' => strtoupper($datos->observacion),
                                    'estatus' => strtoupper($datos->estatus),
                                    'usuario_retorno' => Auth::user()->name
                                ]
                            );
                        }
                        
                        //INSERTA SI LA CANTIDAD DE RETORNO ES IGUAL A CERO Y ESTATUS CERRADO
                        if ($datos->cantidad_retorno == 0 && $datos->estatus == 'CERRADO') 
                        { 
                            //INSERTA EL MOVIMIENTO O DEVOLUCION DE UN ARTICULO 
                            Asal_Salidas_DetalleModel::create(
                                [
                                    'id_detalle'=> $IdDetalle,
                                    'id_salida' => $IdSalida,
                                    'item' => $datos->item,
                                    'codigo_articulo' => $datos->codigo_articulo,
                                    'nombre_articulo' => strtoupper($datos->nombre_articulo),
                                    'tipo_unidad' => $datos->unidad,
                                    'cantidad_retorno' => $datos->cantidad_retorno,
                                    'fecha_retorno' => $FechaActual,
                                    'observacion' => strtoupper($datos->observacion),
                                    'estatus' => strtoupper($datos->estatus),
                                    'usuario_retorno' => Auth::user()->name
                                ]
                            );

                            //ACTUALIZA EL ESTATUS DE UN ARTICULO A CERRADO    
                            Asal_Salidas_DetalleModel::where('id_detalle', '=', $datos->id_detalle)
                                ->where('estatus', '=', NULL)
                                ->update([
                                    'estatus' =>  'CERRADO'
                                ]);
                        }

                        //INSERTA SI LA CANTIDAD DE RETORNO ES MAYOR A CERO Y ESTATUS CERRADO
                        if($datos->cantidad_retorno != 0 && $datos->estatus == 'CERRADO')
                        {
                            //BUSCA LA CANTIDAD RETORNO DE UN ARTICULO
                            $CantidadRetorno = Asal_Salidas_DetalleModel::where('id_detalle', '=', $datos->id_detalle)
                                ->where('estatus', '=', NULL)
                                ->value('cantidad_retorno');

                            //ACTUALIZA LA CANTIDAD RETORNO DE UN ARTICULO    
                            Asal_Salidas_DetalleModel::where('id_detalle', '=', $datos->id_detalle)
                                ->where('estatus', '=', NULL)
                                ->update([
                                    'cantidad_retorno' =>  $datos->cantidad_retorno + $CantidadRetorno
                                ]);

                            //INSERTA EL MOVIMIENTO O DEVOLUCION DE UN ARTICULO 
                            Asal_Salidas_DetalleModel::create(
                                [
                                    'id_detalle'=> $IdDetalle,
                                    'id_salida' => $IdSalida,
                                    'item' => $datos->item,
                                    'codigo_articulo' => $datos->codigo_articulo,
                                    'nombre_articulo' => strtoupper($datos->nombre_articulo),
                                    'tipo_unidad' => $datos->unidad,
                                    'cantidad_retorno' => $datos->cantidad_retorno,
                                    'fecha_retorno' => $FechaActual,
                                    'observacion' => strtoupper($datos->observacion),
                                    'estatus' => strtoupper($datos->estatus),
                                    'usuario_retorno' => Auth::user()->name
                                ]
                            );

                            //ACTUALIZA EL ESTATUS DE UN ARTICULO A CERRADO    
                            Asal_Salidas_DetalleModel::where('id_detalle', '=', $datos->id_detalle)
                                ->where('estatus', '=', NULL)
                                ->update([
                                    'estatus' =>  'CERRADO'
                                ]);
                        }

                        //ACTUALIZA EL ESTATUS DE UN ARTICULO A CERRADO SI LA CANTIDAD SALIENTE ES IGUAL A LA CANTIDAD DE RETORNO
                        Asal_Salidas_DetalleModel::CierreArticulos($datos->id_detalle);
                    }
                }
            });

            //CIERRE SALIDAS
            Asal_SalidasModel::CierreSalidas($IdSalida);

        } 
        
        catch (Exception $ex) 
        {
            return back()->withError('Ocurrio Un Error Al Realizar la Recepcion del Articulo ' . $ex->getMessage());
        }

        return redirect()->route('retornosalidas', $IdSalida)->withSuccess('La Recepción Del Articulo Se Ha Realizado Exitosamente');
    }

    public function BuscarArticulos(Request $request) 
    {
        $articulos = Asal_Salidas_DetalleModel::BuscarArticulos($request->articulo);
        return with(["articulos" => $articulos]);
    }
    
    public function destroy($IdSalida)
    {
        try
        {
            $salida = Asal_SalidasModel::find($IdSalida);

            $salida->fill([
                'id_salida' => $IdSalida,
                'anulado' => 'SI',
                'estatus' => 'ANULADO',
                'anulado_por' => Auth::user()->id
            ]);  
           $salida->save();
        }
        catch (Exception $ex)
        {
            return redirect("autorizacionsalidas")->withError('Error Al Anular la salida '.$ex->getMessage());
        }
        return redirect("autorizacionsalidas")->withSuccess('La Autorizacion de Salida Ha Sido Anulada Exitosamente');
      
    }
}
