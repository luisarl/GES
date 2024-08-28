<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Cnth_HerramientasModel;
use App\Models\Cnth_MovimientosModel;
use App\Models\Cnth_Movimientos_DetallesModel;
use App\Models\AlmacenesModel;
use App\Http\Requests\CnthMovimientosCreateRequest;
use App\Http\Requests\CnthMovimientosUpdateRequest;
use App\Http\Requests\Cnth_EnviarRecepcionRequest;
use App\Mail\CnthDespachosMailable;
use App\Mail\CnthRecepcionMailable;
use App\Models\Almacen_UsuarioModel;
use App\Models\Asal_SalidasModel;
use App\Models\Cnth_EmpleadosModel;
use App\Models\Cnth_Movimiento_ImagenModel;
use App\Models\Cnth_Movimiento_InventarioModel;
use App\Models\Cnth_Responsables_MovimientosModel;
use App\Models\Cnth_ZonasModel;
use App\Models\CorreosModel;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Session\Session as SessionSession;
use Session;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CnthMovimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movimientos = Cnth_MovimientosModel::ListaMovimientos(Auth::user()->id);
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);
        $zonas = Cnth_ZonasModel::select('id_zona', 'nombre_zona')->get();

        foreach($almacenes as $almacen)
        {
            $ArregloAlmacenes [] =  $almacen->id_almacen;
        }
        
        $herramientas = Cnth_HerramientasModel::HerramientasAlmacenes($ArregloAlmacenes);
     
        return view('ControlHerramientas.DespachosHerramientas.Despachos', compact('movimientos', 'herramientas', 'zonas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);
        $empleados = Cnth_EmpleadosModel::EmpleadosCnth();
        $zonas = Cnth_ZonasModel::all();
        return view('ControlHerramientas.DespachosHerramientas.DespachosCreate', compact('almacenes', 'empleados', 'zonas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnthMovimientosCreateRequest $request)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

        try 
        {
            $IdMovimiento = Cnth_MovimientosModel::max('id_movimiento') + 1; //obtiene el maximo de la tabla movimiento
            $IdMovimientoImagen = Cnth_Movimiento_ImagenModel::max('id_movimiento_imagen') + 1; //obtiene el maximo de la tabla movimiento_imagenes
            $IdResponsableMovimiento = Cnth_Responsables_MovimientosModel::max('id_responsable_movimiento') + 1; //obtiene el maximo de la tabla responsable_movimiento

            $movimiento = new Cnth_MovimientosModel();
            $movimiento->id_movimiento = $IdMovimiento;
            $movimiento->motivo = strtoupper($request['motivo']);
            $movimiento->id_almacen = $request['id_almacen'];
            //$movimiento->id_empleado = $request['id_empleado'];
            $movimiento->responsable = strtoupper($request['responsable']);
            $movimiento->id_zona = $request['id_zona'];
            $movimiento->estatus = 'DESPACHO';
            $movimiento->creado_por = Auth::user()->name;

            //CREACION DE CARPETA Y CAPTURA DE FOTOGRAFIA
            try 
            {
                $destino = "images/herramientas/despachos/";
                $NombreCarpeta = $IdMovimiento;
                
                $Ruta = public_path($destino . $NombreCarpeta);

                if (!File::exists($Ruta)) 
                {
                    File::makeDirectory($Ruta, 0777, true);
                    echo "La carpeta se ha creado correctamente.";
                } 

                $NombreImagen = $IdMovimiento . '.jpg';
                $RutaImagen = public_path('images/herramientas/despachos/' . $NombreCarpeta . '/' . $NombreImagen); // ruta donde se guarda la imagen mas el nombre
                $image_parts = explode(";base64,", $_POST['captured_image_data']);
                $image_type_aux = explode("images/", $image_parts[0]);
                $imagen = base64_decode($image_parts[1]); // convierte imagen en un archivo legible 

                file_put_contents($RutaImagen, $imagen); //envia el archivo a la carpeta almacenada en la ruta
                $movimiento->imagen = $destino . $NombreCarpeta . '/' . $NombreImagen;  //guarda la imagen en la base de datos mas la ruta y el nombre de imagen
                
            } 
            catch (Exception $ex) 
            {
                return back()->withError('Ocurrio Un Error al Cargar La Fotografia: ' . $ex->getMessage())->withInput();
            }
            
            $herramientas = json_decode($request['datosdespacho']); //arreglo de herramientas

            if ($herramientas  == NULL) //Valida que el arreglo de las herramientas no este vacio
            {
                return back()->withErrors(['datosmovimiento' => 'Para realizar un despacho debe seleccionar una o varias herramientas']);
            }

            DB::transaction(function () use ($movimiento, $herramientas, $IdMovimiento, $IdMovimientoImagen, $IdResponsableMovimiento, $FechaActual, $request) 
            {
                $movimiento->save(); // guarda el despacho

                //Guarda las imagenes del movimiento
                Cnth_Movimiento_ImagenModel::create([
                    'id_movimiento_imagen' => $IdMovimientoImagen,
                    'id_movimiento' => $IdMovimiento,
                    'tipo' => 'DESPACHO',
                    'imagen' => $movimiento->imagen,
                ]);

                //Inserta en la tabla responsables Movimientos
                Cnth_Responsables_MovimientosModel::create(
                    [
                        'id_responsable_movimiento' => $IdResponsableMovimiento,
                        'id_movimiento' => $IdMovimiento,
                        'responsable' =>  $request['responsable'] ,
                    ]
                );

                if ($herramientas != "")  //verifica si el arreglo no esta vacio
                {
                    foreach ($herramientas as $herramienta) 
                    {
                        $IdDetalle = Cnth_Movimientos_DetallesModel::max('id_detalle') + 1;
                        $IdInventario = Cnth_Movimiento_InventarioModel::max('id_inventario') + 1;
                        //Inserta datos de la tabla 
                        Cnth_Movimientos_DetallesModel::create([
                            'id_detalle' => $IdDetalle,
                            'id_movimiento' => $IdMovimiento,
                            //'id_empleado' => $request['id_empleado'],
                            'responsable' => $request['responsable'],
                            'fecha_despacho' => $FechaActual,
                            'id_herramienta' => $herramienta->id_herramienta,
                            'cantidad_entregada' =>  $herramienta->cantidad,

                        ]);

                        Cnth_Movimiento_InventarioModel::create(
                            [
                                'id_inventario' => $IdInventario,
                                'id_herramienta' => $herramienta->id_herramienta,
                                'id_almacen' => $request->id_almacen,
                                'movimiento' => $IdMovimiento,
                                'tipo_movimiento' => 'DESPACHO',
                                'usuario' => Auth::user()->name,
                                'fecha' => $FechaActual,
                                'descripcion',
                                'entrada' => '0',
                                'salida' => $herramienta->cantidad
                            ]
                        );

                        //Actualizar Stock de la Herramienta
                        Cnth_Movimiento_InventarioModel::ActualizarStock($herramienta->id_herramienta, $request->id_almacen);
                    }
                }
            });
        } 
        catch (Exception $ex) 
        {
            return back()->withError('Ha Ocurrido Un Error Al Crear El Despacho ' . $ex->getMessage())->withInput();
        }

        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $movimiento = Cnth_MovimientosModel::movimiento($IdMovimiento); //busca los datos
            $herramientas = Cnth_MovimientosModel::movimiento_detalle($IdMovimiento); // busca el detalle de las herramientas

            //dd($herramientas);
            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::CnthCorreosDestinatarios($movimiento->responsable, $request->id_almacen, 'DESPACHO');
            //dd($destinatarios);
           
            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(10), new CnthDespachosMailable($movimiento, $herramientas));   
        }
        catch (Exception $ex)
        {
            Session::flash('alert','Se Produjo Un error Al Enviar El Correo: '.$ex->getMessage());
        }

        return redirect()->route('despachos.index')->withSuccess('Las Herramientas Se Han Despachado Exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdMovimiento)
    {

        $movimientos = Cnth_MovimientosModel::movimiento($IdMovimiento);
        $detalles = Cnth_Movimientos_DetallesModel::recepcion_detalle($IdMovimiento);
        $imagenes = Cnth_Movimiento_ImagenModel::select('id_movimiento_imagen','imagen')->where('id_movimiento', '=', $IdMovimiento)->get();
        $responsables = Cnth_Responsables_MovimientosModel::select('responsable', 'created_at as fecha')->where('id_movimiento', '=', $IdMovimiento)->get();
        return view('ControlHerramientas.DespachosHerramientas.DespachosShow', compact('movimientos', 'detalles','imagenes', 'responsables'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdMovimiento)
    {

        $movimiento = Cnth_MovimientosModel::find($IdMovimiento);
        $almacenes = AlmacenesModel::all();
        $empleados = Cnth_EmpleadosModel::EmpleadosCnth();
        $zonas = Cnth_ZonasModel::all();
        $detalles = Cnth_MovimientosModel::movimiento_detalle($IdMovimiento);
        $responsables = Cnth_Responsables_MovimientosModel::select('responsable', 'created_at as fecha')->where('id_movimiento', '=', $IdMovimiento)->get();
        return view('ControlHerramientas.DespachosHerramientas.DespachosEdit', compact('movimiento', 'almacenes', 'detalles', 'empleados', 'zonas', 'responsables'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CnthMovimientosUpdateRequest $request, $IdMovimiento)
    {
        $IdResponsableMovimiento = Cnth_Responsables_MovimientosModel::max('id_responsable_movimiento') + 1; //obtiene el maximo de la tabla responsable_movimiento
        $movimiento = Cnth_MovimientosModel::find($IdMovimiento);
        $ResponsableActual =  $movimiento->responsable;

        try 
        {  
            DB::transaction(function () use ($movimiento, $IdMovimiento, $IdResponsableMovimiento, $ResponsableActual, $request) 
            {
                $movimiento->fill([
                    'motivo' => strtoupper($request['motivo']),
                    'actualizado_por' => Auth::user()->name,
                    'responsable' => $request['responsable']
                ]);
                $movimiento->save(); // guarda el despacho

                //Si cambia el responsable guarda en la tabla
                if($ResponsableActual != $request['responsable'])
                {
                    //Inserta en la tabla responsables Movimientos
                    Cnth_Responsables_MovimientosModel::create(
                        [
                            'id_responsable_movimiento' => $IdResponsableMovimiento,
                            'id_movimiento' => $IdMovimiento,
                            'responsable' =>  $request['responsable'] ,
                        ]
                    );

                     //ACTUALIZA EL RESPONSABLE EN LA TABLA MOVIMIENTOS_DETALLE    
                     Cnth_Movimientos_DetallesModel::where('id_movimiento', '=', $IdMovimiento)
                     ->where('estatus', '=', NULL)
                     ->whereRaw('cantidad_entregada <> isnull(cantidad_devuelta,0)')
                     ->update([
                         'responsable' =>  $request['responsable']
                     ]);

                }
            });    
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error al actualizar el Despacho' . $ex->getMessage())->withInput();
            }

        return back()->withSuccess('El Despacho Ha Sido Actualizado Exitosamente');
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
    //LLENAR POR AJAX TIPO JSON DE LA VISTA DE DESPACHO DATATABLE
    public function DatosDespachos()
    {
        $data = Cnth_MovimientosModel::ListaMovimientosHerramientas(Auth::user()->id);
        return with(["data" => $data]);
    }

    public function recepcion($IdMovimiento)
    {
        $movimientos = Cnth_MovimientosModel::movimiento($IdMovimiento);
        $detalles = Cnth_MovimientosModel::movimiento_detalle($IdMovimiento);
        $imagenes = Cnth_Movimiento_ImagenModel::select('id_movimiento_imagen','imagen')->where('id_movimiento', '=', $IdMovimiento)->get();
        return view('ControlHerramientas.RecepcionesHerramientas.Recepcion', compact('detalles', 'movimientos', 'imagenes'));
    }

    public function EnviarRecepcion(Cnth_EnviarRecepcionRequest $request, $IdMovimiento)
    {
        try 
        {
            $movimientos = Cnth_MovimientosModel::find($IdMovimiento);

            $destino = "images/herramientas/despachos/";
            $NombreCarpeta = $IdMovimiento;
            $correlativo = Cnth_Movimiento_ImagenModel::CorrelativoImagen($IdMovimiento);
            $i = $correlativo->correlativo_imagen; //correlativo imagen
            $i++;
            $NombreImagen = $IdMovimiento.'-'.$i.'.jpg';
            $RutaImagen = public_path('images/herramientas/despachos/' . $NombreCarpeta . '/' . $NombreImagen); // ruta donde se guarda la imagen mas el  nombre
            $image_parts = explode(";base64,", $_POST['captured_image_data']);
            $image_type_aux = explode("images/", $image_parts[0]);
            $imagen = base64_decode($image_parts[1]); // convierte imagen en un archivo legible 

            if ($imagen  == NULL) //Valida que el arreglo de las herramientas no este vacio
            {
                return back()->withErrors(['datosmovimiento' => 'Para realizar un despacho debe seleccionar una o varias herramientas']);
            }

            //$file = $RutaImagen . $IdMovimiento . '.png';
            file_put_contents($RutaImagen, $imagen); //envia el archivo a la carpeta almacenada en la ruta
            //dd(file_put_contents($file, $image_base64));
            $movimientos->imagen = $destino . $NombreCarpeta. '/' .$NombreImagen;  //guarda la imagen en la base de datos mas la ruta y el nombre de   imagen
            //dd($movimiento);
            $IdMovimientoImagen = Cnth_Movimiento_ImagenModel::max('id_movimiento_imagen') + 1; //obtiene el maximo de la tabla articulo_imagen

            Cnth_Movimiento_ImagenModel::create([
                'id_movimiento_imagen' => $IdMovimientoImagen,
                'id_movimiento' => $IdMovimiento,
                'tipo' => 'RECEPCION',
                'imagen' => $movimientos->imagen,
            ]);
        }
        catch (Exception $ex) 
        {
            return back()->withError('Para Realizar la Recepcion de la Herramienta Necesita Tomar La Fotografia '.$ex->getMessage());
        }  
        // //busca los datos del detalle de los movimientos del despacho
        try {

            $datosrecepcion = json_decode($request['datosrecepcion']); //arreglo de datos adicionales

            DB::transaction(function () use ($datosrecepcion, $IdMovimiento, $request) {
                $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

                if ($datosrecepcion != "")  //verifica si el arreglo no esta vacio
                {
                    foreach ($datosrecepcion as $datos) 
                    {
                        $IdDetalle = Cnth_Movimientos_DetallesModel::max('id_detalle') + 1;
                        $IdInventario = Cnth_Movimiento_InventarioModel::max('id_inventario') + 1;

                        //RECEPCION NORMAL
                        if ($datos->recibir == false && $datos->cantidad_devuelta != 0) 
                        {
                            //BUSCA LA CANTIDAD DEVUELTA DE UNA HERRAMIENTA
                            $CantidadDevuelta = Cnth_Movimientos_DetallesModel::where('id_detalle', '=', $datos->id_detalle)
                                ->where('estatus', '=', NULL)
                                ->value('cantidad_devuelta');

                            //ACTUALIZA LA CANTIDAD DEVUELTA DE UNA HERRAMIENTA    
                            Cnth_Movimientos_DetallesModel::where('id_detalle', '=', $datos->id_detalle)
                                ->where('estatus', '=', NULL)
                                ->update([
                                    'cantidad_devuelta' =>  $datos->cantidad_devuelta + $CantidadDevuelta
                                ]);

                            //INSERTA EL MOVIMIENTO O DEVOLUCION DE UNA HERRAMIENTA 
                            Cnth_Movimientos_DetallesModel::create([
                                'id_detalle' => $IdDetalle,
                                'id_movimiento' => $IdMovimiento,
                                'responsable' => $datos->responsable,
                                'id_herramienta' => $datos->id_herramienta,
                                'estatus' => $datos->estatus,
                                'fecha_devolucion' => $FechaActual,
                                'cantidad_devuelta' =>  $datos->cantidad_devuelta,
                                'eventualidad' =>  strtoupper($datos->eventualidad),
                                'recibido_por' => Auth::user()->name
                            ]);

                            //INSERTA EN LA TABLA MOVIMIENTO INVENTARIO
                            Cnth_Movimiento_InventarioModel::create(
                                [
                                    'id_inventario' => $IdInventario,
                                    'id_herramienta' => $datos->id_herramienta,
                                    'id_almacen' => $request->id_almacen,
                                    'movimiento' => $IdMovimiento,
                                    'tipo_movimiento' => 'RECEPCION',
                                    'usuario' => Auth::user()->name,
                                    'fecha' => $FechaActual,
                                    'descripcion',
                                    'entrada' => $datos->cantidad_devuelta,
                                    'salida' => '0'
                                ]
                            );

                            //Actualizar Stock de la Herramienta
                            Cnth_Movimiento_InventarioModel::ActualizarStock($datos->id_herramienta, $request->id_almacen);
                        }
                        //RECEPCION LOTE
                        elseif($datos->recibir)
                            {
                                //BUSCA LA CANTIDAD DEVUELTA DE UNA HERRAMIENTA
                                $CantidadDevuelta = Cnth_Movimientos_DetallesModel::where('id_detalle', '=', $datos->id_detalle)
                                ->where('estatus', '=', NULL)
                                ->value('cantidad_devuelta');

                                //ACTUALIZA LA CANTIDAD DEVUELTA DE UNA HERRAMIENTA    
                                Cnth_Movimientos_DetallesModel::where('id_detalle', '=', $datos->id_detalle)
                                    ->where('estatus', '=', NULL)
                                    ->update([
                                        'cantidad_devuelta' => $CantidadDevuelta + $datos->cantidad_pendiente
                                    ]);

                                //INSERTA EL MOVIMIENTO O DEVOLUCION DE UNA HERRAMIENTA 
                                Cnth_Movimientos_DetallesModel::create([
                                    'id_detalle' => $IdDetalle,
                                    'id_movimiento' => $IdMovimiento,
                                    'responsable' => $datos->responsable,
                                    'id_herramienta' => $datos->id_herramienta,
                                    'estatus' => 'BUEN ESTADO',
                                    'fecha_devolucion' => $FechaActual,
                                    'cantidad_devuelta' =>  $datos->cantidad_pendiente,
                                    'eventualidad' =>  strtoupper($datos->eventualidad),
                                    'recibido_por' => Auth::user()->name
                                ]);

                                //INSERTA EN LA TABLA MOVIMIENTO INVENTARIO
                                Cnth_Movimiento_InventarioModel::create(
                                    [
                                        'id_inventario' => $IdInventario,
                                        'id_herramienta' => $datos->id_herramienta,
                                        'id_almacen' => $request->id_almacen,
                                        'movimiento' => $IdMovimiento,
                                        'tipo_movimiento' => 'RECEPCION',
                                        'usuario' => Auth::user()->name,
                                        'fecha' => $FechaActual,
                                        'descripcion',
                                        'entrada' => $datos->cantidad_pendiente,
                                        'salida' => '0'
                                    ]
                                );

                                //Actualizar Stock de la Herramienta
                                Cnth_Movimiento_InventarioModel::ActualizarStock($datos->id_herramienta, $request->id_almacen);
                            }
                    }
                }
            });

            $CantidadPendiente = Cnth_MovimientosModel::cantidad_pendiente($IdMovimiento);

            if ($CantidadPendiente == 0) 
            {
                // ACTUALIZA EL ESTATUS DEL MOVIMIENTO 
                Cnth_MovimientosModel::where('id_movimiento', '=', $IdMovimiento)
                    ->update([
                        'estatus' => 'RECEPCION'
                    ]);
            }
        } 
        catch (Exception $ex) 
        {
            return back()->withError('Ocurrio Un Error Al Realizar la Recepcion de la Herramienta ' . $ex->getMessage());
        }
     
        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $usuario = Auth::user()->name;
            $movimiento = Cnth_MovimientosModel::movimiento($IdMovimiento); //busca los datos
            $herramientas = Cnth_Movimientos_DetallesModel::recepcion_detalle($IdMovimiento); // busca el detalle de las herramientas

            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::CnthCorreosDestinatarios($movimiento->responsable, $movimiento->id_almacen, 'RECEPCION');
            
            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(60), new CnthRecepcionMailable($movimiento, $herramientas, $usuario));   
        }
        catch (Exception $ex)
            {
                Session::flash('alert','Se Produjo Un error Al Enviar El Correo: '.$ex->getMessage());
            }

        if ($CantidadPendiente == 0) 
        {
            return redirect()->route('despachos.index')->withSuccess('La Recepcion De las Herramientas Se Han Realizado Exitosamente');
        }
         else
            {
                return redirect()->route('recepcion', $IdMovimiento)->withSuccess('La Recepcion De la Herramienta Se Ha Realizado Exitosamente');
            }    
        
    }

    public function eliminardatosdespacho($id_detalle)
    {
        try 
        {
            Cnth_Movimientos_DetallesModel::destroy($id_detalle);
        } 
        catch (Exception $e) 
            {
                return back()->withError('Error Al Eliminar');
            }

        return back()->with('');
    }
    /**
     * REALIZA LA BUSQUEDA DE LAS HERRAMIENTAS SEGUN EL ALMACEN SELECCIONADO
     **/
    public function HerramientasAlmacen($IdAlmacen)
    {
        $herramientas = Cnth_HerramientasModel::ListadoHerramientas($IdAlmacen);
        return with(["herramientas" => $herramientas]);
    }

     /**
     * REALIZA LA BUSQUEDA DE DE LAS HERRAMIENTAS SEGUN EL NUMERO DE MOVIMIENTO
     **/
    public function HerramientasDespacho($IdMovimiento)
    {
        $herramientas = Cnth_Movimientos_DetallesModel::HerramientasDespacho($IdMovimiento);
        return with(["herramientas" => $herramientas]);
    }
}
