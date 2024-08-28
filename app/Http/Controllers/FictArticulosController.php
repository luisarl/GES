<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticulosCreateRequest;
use App\Http\Requests\ArticulosUpdateRequest;
use App\Http\Requests\ArticulosMigrateRequest;
use App\Http\Requests\ArticuloSolicitudRequest;
use App\Models\GruposModel;
use App\Models\SubgruposModel;
use App\Models\CategoriasModel;
use App\Models\UnidadesModel;
use App\Models\ArticulosModel;
use App\Models\ClasificacionesModel;
use App\Models\Articulo_MigracionModel;
use App\Models\Almacen_UsuarioModel;
use App\Models\Articulo_ImagenModel;
use App\Mail\ArticulosCreateMailable;
use App\Mail\ArticulosEditMailable;
use App\Mail\ArticulosMigrateMailable;
use App\Mail\ArticuloSolicitudMailable;
use App\Mail\ArticulosAprobarMailable;
use App\Models\Articulo_ClasificacionModel;
use App\Models\Articulo_UbicacionModel;
use App\Models\CorreosModel;
use App\Models\EmpresasModel;
use App\Models\SubclasificacionesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\DB;
use Redirect;
use Session;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FictArticulosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->roles[0]->name == 'administrador' || Auth::user()->roles[0]->name == 'catalogador' )
        {
            $articulos = ArticulosModel::VistaArticulos();
        }
        else
            {
                $articulos = ArticulosModel::VistaArticulosActivos();  
            }
               
        return view('FichaTecnica.Articulos.Articulos', compact('articulos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidades = UnidadesModel::select('id_unidad', 'nombre_unidad', 'abreviatura_unidad')->get();
        $grupos = GruposModel::select('id_grupo', 'nombre_grupo', 'codigo_grupo')->get();
        $categorias = CategoriasModel::select('id_categoria', 'nombre_categoria', 'codigo_categoria')->get();
        $subgrupos = SubgruposModel::select('id_subgrupo', 'nombre_subgrupo', 'codigo_subgrupo')->get();
        $clasificaciones = ClasificacionesModel::select('id_clasificacion', 'nombre_clasificacion')->get();
        $empresas = EmpresasModel::select('id_empresa', 'nombre_empresa', 'alias_empresa','base_datos')->where('visible_ficht', 'SI')->get();

        return view('FichaTecnica.Articulos.ArticulosCreate', compact( 'unidades', 'grupos', 'subgrupos', 'categorias','clasificaciones', 'empresas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticulosCreateRequest $request)
    { 
        $IdArticulo = ArticulosModel::max('id_articulo') + 1; // Id del Articulo a Crear

        $ArregloEmpresas = $request['empresas']; //CAPTURA LOS ID DE LAS EMPRESAS SELECCIONADOS PARA LA SOLICITUD
        $empresas = DB::table('empresas')->whereIn('id_empresa', $ArregloEmpresas)->get();

        $articulo = new ArticulosModel();
       // GruposModel::create([
        $articulo->id_articulo = $IdArticulo;
        $articulo->codigo_articulo = strtoupper($request['codigo_articulo']);
        $articulo->nombre_articulo = strtoupper($request['nombre_articulo']);
        $articulo->correlativo = $request['correlativo'];
        $articulo->referencia = strtoupper($request['referencia']);
        $articulo->descripcion_articulo = strtoupper($request['descripcion_articulo']);
        $articulo->pntominimo_articulo = $request['pntominimo_articulo'];
        $articulo->pntomaximo_articulo = $request['pntomaximo_articulo'];
        $articulo->pntopedido_articulo = $request['pntopedido_articulo'];
        $articulo->tipo_unidad = strtoupper($request['tipo_unidad']);
        $articulo->id_unidad = $request['id_unidad'];
        $articulo->id_unidad_sec = $request['id_unidad_sec'];
        $articulo->id_unidad_ter = $request['id_unidad_ter'];
        $articulo->equi_unid_pri = $request['equi_unid_pri'];
        $articulo->equi_unid_sec = $request['equi_unid_sec'];
        $articulo->equi_unid_ter = $request['equi_unid_ter'];
        $articulo->id_categoria = $request['id_categoria'];
        $articulo->id_subgrupo = $request['id_subgrupo'];
        $articulo->id_grupo = $request['id_grupo'];
        $articulo->id_tipo = $request['id_tipo'];
        $articulo->activo = 'SI';
        $articulo->creado_por = Auth::user()->id;
        $articulo->actualizado_por = Auth::user()->id;
        $articulo->estatus = 'APROBACION PENDIENTE';
        $articulo->aprobado = 'NO';


        if ($request->hasFile('imagen_articulo'))
        {
            $imagenes = $request->file('imagen_articulo');
            $i = 0;
            foreach ($imagenes as $imagen) {
                $i++;
                $destino = "images/articulos/";
                $NombreImagen = $IdArticulo.'-'.$i.'.jpg';
                $imagen->move($destino,$NombreImagen);
           
                //Funcion para renderizar la imagenes y cambiar el tamaño
                $RutaImagen = public_path('images/articulos/' . $NombreImagen);
                $imagen = Image::make($RutaImagen)->resize(400, 400)->save($RutaImagen);
                $imagen->save($RutaImagen);

                $ArregloImagenes[] = $destino.$NombreImagen; //almacena el nombre de las imagenes guardadas
            } 

            $articulo->imagen_articulo = $ArregloImagenes[0]; //Guarda la primera imagen seleccionada en el campo imagen_articulo
         
        }

        if ($request->hasFile('documento_articulo'))
        {
            $documento = $request->file('documento_articulo');

                $destino = "documents/articulos/";
                $NombreDocumento = $IdArticulo.'.PDF';
                $documento->move($destino,$NombreDocumento);

            $articulo->documento_articulo = $destino .$NombreDocumento; //Guarda Ruta Imagen en bd
        }

        // validacion al crear el articulo
        try
        {
            $DatosAdicionales = json_decode($request['datosadicionales']); //arreglo de datos adicionales

            DB::transaction(function () use ($IdArticulo, $articulo, $DatosAdicionales, $empresas, $ArregloImagenes){
                
                $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

                $articulo->save(); // guarda el articulo

                if($DatosAdicionales != "")  //verifica si el arreglo eno esta vacio
                {

                    foreach($DatosAdicionales as $clasificacion)
                    {
                        $IdArticuloClasificacion = Articulo_ClasificacionModel::max('id_articulo_clasificacion') + 1; //obtiene el maximo de la tabla articulo clasificacion

                        //Inserta En la Tabla articulo_clasificacion
                        Articulo_ClasificacionModel::create([
                            'id_articulo_clasificacion' => $IdArticuloClasificacion,
                            'id_articulo' => $IdArticulo,
                            'id_clasificacion' => $clasificacion->id_clasificacion,
                            'id_subclasificacion' =>  $clasificacion->id_subclasificacion,
                            'valor' =>  strtoupper($clasificacion->valor)
                        ]);
                    }
                }
                
                foreach($ArregloImagenes as $imagen)
                {
                    $IdArticuloImagen = Articulo_ImagenModel::max('id_articulo_imagen') + 1; //obtiene el maximo de la tabla articulo_imagen
                    
                    //Inserta En la Tabla articulo_imagen
                    Articulo_ImagenModel::create([
                            'id_articulo_imagen' => $IdArticuloImagen,
                            'id_articulo' => $IdArticulo,
                            'imagen' => $imagen,
                        ]);
                }

                foreach ($empresas as $empresa) 
                {
                    // Inserta En la tabla  articulo_migracion
                    Articulo_MigracionModel::create(
                        [
                            'id_articulo' =>  $IdArticulo,
                            'id_empresa' => $empresa->id_empresa,
                            'solicitado' => 'SI',
                            'migrado' => 'NO',
                            'nombre_solicitante' => Auth::user()->name,
                            'fecha_solicitud' => $FechaActual
                        ]);
                }
    
            });

        }
        catch (Exception $e)
        {
            return back()->withError('Ocurrio Un Error al Crear Articulo: '.$e->getMessage())->withInput();
        }
        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $usuario = Auth::user()->name;
            $articulo = ArticulosModel::find($IdArticulo); //busca los datos del articulo creado

            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::FictCorreosDestinatarios(Auth::user()->id ,'', $ArregloEmpresas, 'CREAR');

            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(60), new ArticulosCreateMailable($articulo, $empresas, $usuario));   
        }
        catch (Exception $ex)
        {
            Session::flash('alert','Se Produjo Un error Al Enviar El Correo: '.$ex->getMessage());
        }

        return redirect()->route('articulos.edit',$IdArticulo)->withSuccess('El Articulo Ha Sido Creado Exitosamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdArticulo)
    {
        $articulo = ArticulosModel::DetalleArticulo($IdArticulo);
        $responsables = ArticulosModel::ResponsablesArticulo($IdArticulo);
        $empresas = EmpresasModel::select('id_empresa', 'nombre_empresa', 'alias_empresa','base_datos')->where('visible_ficht', 'SI')->get();
        $unidades = UnidadesModel::select('id_unidad', 'nombre_unidad', 'abreviatura_unidad')->get();
        $grupos = GruposModel::select('id_grupo', 'nombre_grupo', 'codigo_grupo')->get();
        $categorias = CategoriasModel::select('id_categoria', 'nombre_categoria', 'codigo_categoria')->get();
        $subgrupos = SubgruposModel::select('id_subgrupo', 'nombre_subgrupo', 'codigo_subgrupo')->get();
        $clasificaciones = ClasificacionesModel::select('id_clasificacion', 'nombre_clasificacion')->get();
        $DatosAdicionales = Articulo_ClasificacionModel::DatosAdicionales($IdArticulo);
        $ConteoAlmacenesArticulo = Articulo_MigracionModel::ConteoMigracionAlmacenesArticulo($IdArticulo);
        $imagenes = Articulo_ImagenModel::select('id_articulo_imagen','imagen')->where('id_articulo', '=', $IdArticulo)->get();
        $ubicaciones = Articulo_UbicacionModel::ConsultarArticuloPorUbicacion(Auth::user()->id, $IdArticulo);

        return view('FichaTecnica.Articulos.ArticulosShow', compact('articulo', 'unidades', 'grupos', 'subgrupos', 'categorias', 'empresas', 'clasificaciones', 'DatosAdicionales','ConteoAlmacenesArticulo','imagenes','responsables','ubicaciones'));

    }

    public function pdf($IdArticulo)
    {
        $articulo = ArticulosModel::DetalleArticulo($IdArticulo);
        $DatosAdicionales = Articulo_ClasificacionModel::DatosAdicionalesPDF($IdArticulo);
        //return view('reportes.FichaTecnica', compact('articulo','DatosAdicionales'));
        $pdf = PDF::loadView('reportes.FichaTecnica', compact('articulo','DatosAdicionales'));
        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdArticulo)
    {
        $articulo = ArticulosModel::find($IdArticulo);
        $responsables = ArticulosModel::ResponsablesArticulo($IdArticulo);
        $empresas = EmpresasModel::select('id_empresa', 'nombre_empresa', 'alias_empresa','base_datos')->where('visible_ficht', 'SI')->get();
        $unidades = UnidadesModel::select('id_unidad', 'nombre_unidad', 'abreviatura_unidad')->get();
        $grupos = GruposModel::select('id_grupo', 'nombre_grupo', 'codigo_grupo')->get();
        $categorias = CategoriasModel::select('id_categoria', 'nombre_categoria', 'codigo_categoria')->get();
        $subgrupos = SubgruposModel::select('id_subgrupo', 'nombre_subgrupo', 'codigo_subgrupo')->get();
        $clasificaciones = ClasificacionesModel::select('id_clasificacion', 'nombre_clasificacion')->get();
        $ConteoAlmacenesArticulo = Articulo_MigracionModel::ConteoMigracionAlmacenesArticulo($IdArticulo);
        $DatosAdicionales = Articulo_ClasificacionModel::DatosAdicionales($IdArticulo);
        $imagenes = Articulo_ImagenModel::select('id_articulo_imagen','imagen')->where('id_articulo', '=', $IdArticulo)->get();
        $DepartamentoAprobacion = User::where('id' ,'=', $articulo->creado_por)->value('id_departamento'); //consultar el departamento del usuario que creo y validad if auth->dapartamento = 1
        $ubicaciones = Articulo_UbicacionModel::ConsultarArticuloPorUbicacion(Auth::user()->id, $IdArticulo);
        $existeArticulo = Articulo_UbicacionModel::select('id_articulo')->where('id_articulo',$IdArticulo)->exists(); 
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);

        //Verifica si el articulo fue migrado para inhabiltar el formulario de edicion de la ficha  
        if ($articulo->estatus == 'MIGRADO' || $articulo->estatus == 'MIGRACION PENDIENTE' )
            {
                $deshabilitar = 'readonly';
            }
            else
                {
                    $deshabilitar = '';
                }

        //Verifica si el articulo fue migrado     
        if (DB::table('articulo_migracion')->where('id_articulo', $articulo->id_articulo)->where('migrado', 'SI')->exists() ) 
            {
                $migrado = true;
            }
            else
                {
                    $migrado = false;
                }     

        return view('FichaTecnica.Articulos.ArticulosEdit', compact('articulo', 'unidades', 'grupos', 'subgrupos', 'categorias', 'empresas', 'clasificaciones', 'ConteoAlmacenesArticulo', 'DatosAdicionales', 'deshabilitar', 'migrado', 'imagenes', 'responsables', 'DepartamentoAprobacion', 'ubicaciones','existeArticulo','almacenes'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticulosUpdateRequest $request, $IdArticulo)
    {
        $articulo = ArticulosModel::find($IdArticulo);

        // Validacion Codigo De Articulo
        // Valida si el campo del codigo articulo estaba vacio y se agrego un valor al campo
        if($articulo->codigo_articulo  == "" && $request['codigo_articulo'] != "") 
        {
            $existe = ArticulosModel::where('codigo_articulo', '=', $request['codigo_articulo'] )->exists(); // regressa true si el codigo existe
            
            if($existe) //si es true
            {
                return back()->withErrors(['codigo_articulo'=>'El valor del campo codigo articulo ya está en uso.'])->withInput();
            }
        }

        $ConteoImagenes = Articulo_ImagenModel::where('id_articulo', '=', $IdArticulo)->count('id_articulo'); //cuenta el numero de imagenes del articulo
       
        if($ConteoImagenes == 0 && $request->hasFile('imagen_articulo')  == false) //Valida que exista imagen cargada en el articulo
        {
            return back()->withErrors(['imagen_articulo'=>'Debe Seleccionar Por Lo Menos Una Imagen']);

        }

            $articulo->fill([
                'codigo_articulo' => strtoupper($request['codigo_articulo']),
                'nombre_articulo' => strtoupper($request['nombre_articulo']),
                'correlativo' => $request['correlativo'],
                'referencia' => strtoupper($request['referencia']),
                'descripcion_articulo' => strtoupper($request['descripcion_articulo']),
                'pntominimo_articulo' => $request['pntominimo_articulo'],
                'pntomaximo_articulo' => $request['pntomaximo_articulo'],
                'pntopedido_articulo' => $request['pntopedido_articulo'],
                'tipo_unidad' => strtoupper($request['tipo_unidad']),
                'id_unidad' => $request['id_unidad'],
                'id_unidad_sec' => $request['id_unidad_sec'],
                'id_unidad_ter' => $request['id_unidad_ter'],
                'equi_unid_pri' => $request['equi_unid_pri'],
                'equi_unid_sec' => $request['equi_unid_sec'],
                'equi_unid_ter' => $request['equi_unid_ter'],
                'id_categoria' => $request['id_categoria'],
                'id_subgrupo' => $request['id_subgrupo'],
                'id_grupo' => $request['id_grupo'],
                'id_tipo' => $request['id_tipo'],
                'actualizado_por' => Auth::user()->id
            ]);

            $ArregloImagenes[] = ""; //Inicializar arreglo de imagenes
           

            if ($request->hasFile('imagen_articulo'))
            {
                $imagenes = $request->file('imagen_articulo');
                
                $correlativo = Articulo_ImagenModel::CorrelativoImagen($IdArticulo);
                $i = $correlativo->correlativo_imagen; //correlativo imagen
                $j = 0; //incrementador arreglo imagenes

                foreach ($imagenes as $imagen) {
                    $i++;
                    $destino = "images/articulos/";
                    $NombreImagen = $IdArticulo.'-'.$i.'.jpg';
                    $imagen->move($destino,$NombreImagen);
            
                    //Funcion para renderizar la imagenes y cambiar el tamaño
                    $RutaImagen = public_path('images/articulos/' . $NombreImagen);
                    $imagen = Image::make($RutaImagen)->resize(400, 400)->save($RutaImagen);
                    $imagen->save($RutaImagen);

                    $ArregloImagenes[$j] = $destino.$NombreImagen; //almacena el nombre de las imagenes guardadas
                    $j++;
                } 
                
                if($ConteoImagenes == 0) //Si No existen imagenes en la tabla articulo_imagen 
                {
                    $articulo->fill(['imagen_articulo' => $ArregloImagenes[0]]); //Guarda la primera imagen seleccionada en el campo imagen_articulo
                }
                
            }

            if ($request->hasFile('documento_articulo'))
            {
                $documento = $request->file('documento_articulo');

                $destino = "documents/articulos/";
                $NombreDocumento = $IdArticulo.'.PDF';
                $documento->move($destino,$NombreDocumento);

                $articulo->documento_articulo = $destino .$NombreDocumento; //Guarda Ruta Documento en bd
            }

            //Validacion del articulo
            try
            {
                $DatosAdicionales = json_decode($request['datosadicionales']); //arreglo de datos adicionales

                DB::transaction(function () use ($IdArticulo, $articulo, $DatosAdicionales, $ArregloImagenes){

                    $articulo->save(); // guarda el articulo

                    if($DatosAdicionales != "") //verifica si el arreglo no esta vacio
                    {

                        foreach($DatosAdicionales as $clasificacion)
                        {
                            if($clasificacion->id_articulo_clasificacion == "") //si la primera columna de la tabla esta vacia busca el maximo id de la base de datos y le suma 1
                            {
                                $IdArticuloClasificacion = Articulo_ClasificacionModel::max('id_articulo_clasificacion') + 1;
                            }
                            else //si no captura el valor de la primera columna de la tabla
                                {
                                    $IdArticuloClasificacion = $clasificacion->id_articulo_clasificacion;
                                }

                            Articulo_ClasificacionModel::updateOrInsert(
                                [ 'id_articulo_clasificacion' => $IdArticuloClasificacion],
                                [
                                'id_articulo' => $IdArticulo,
                                'id_clasificacion' => $clasificacion->id_clasificacion,
                                'id_subclasificacion' =>  $clasificacion->id_subclasificacion,
                                'valor' =>  strtoupper($clasificacion->valor)
                                ]);
                        }
                    }

                    if($ArregloImagenes[0] != "") //verifica si el arreglo no esta vacio
                    {
                        foreach($ArregloImagenes as $imagen)
                        {
                            $IdArticuloImagen = Articulo_ImagenModel::max('id_articulo_imagen') + 1; //obtiene el maximo de la tabla articulo_imagen
            
                            //Inserta En la Tabla articulo_imagen
                            Articulo_ImagenModel::create([
                                    'id_articulo_imagen' => $IdArticuloImagen,
                                    'id_articulo' => $IdArticulo,
                                    'imagen' => $imagen,
                                ]);
                        }
                    }

                });

            }
            catch (Exception $e)
            {
                return back()->withError('Ocurrio Un Error al Modificar Articulo: '.$e->getMessage())->withInput();
            }

            //Validacion del Correo
            try
            {
                $usuario = Auth::user()->name;
                if(Auth::user()->id == $articulo->creado_por) // Verifica si es usuario que modifico es el mismo que creo
                {
                    //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
                    $destinatarios = CorreosModel::FictCorreosDestinatarios(Auth::user()->id ,'', '', 'EDITAR');
                     // ENVIA EL CORREO
                        Mail::to($destinatarios[0]) //DESTINATARIOS
                        ->cc($destinatarios[1]) //EN COPIA
                        //->bcc($destinatarios[2]) // EN COPIA OCULTA
                        ->later(now()->addSeconds(60), new ArticulosEditMailable($articulo, $usuario));   
                 }
               
            }
            catch (Exception $ex)
            {
                Session::flash('alert','Se Produjo Un error Al Enviar El Correo: '.$ex->getMessage());
            }

             return back()->withSuccess('El Articulo Ha Sido Modificado Exitosamente');
    }

    /**
     * PROCESO DE MIGRACION DE UN ARTICULO A PROFIT
     *
     */
    public function migrate(ArticulosMigrateRequest $request)
    {
        $IdArticulo = $request['id_articulo']; //OBTIENE DEL CAMPO OCULTO EL ID DEL ARTICULO
        $ArregloEmpresas = $request['empresas']; //CAPTURA LOS ID DE LAS EMPRESAS SELECCIONADOS PARA LA MIGRACION

        $empresas = DB::table('empresas')->whereIn('id_empresa', $ArregloEmpresas)->get(); //Obtiene los datos de las empresas

        $articulo = ArticulosModel::DetalleArticulo($IdArticulo); // Obtiene datos del Articulo

        if($articulo->codigo_articulo  == "") //Valida que el codigo del articulo no este vacio
        {
            return back()->withErrors(['codigo_articulo'=>'Para Migrar El Codigo No Puede Estar Vacio']);
        }

        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        
        $DireccionIp = $request->ip();

        try
        {
            // VALIDA SI EXISTE UN ERROR EN ALGUN INSERT NO REALIZE NINGUNO
            DB::transaction(function () use ($empresas, $articulo, $FechaActual, $DireccionIp){

                 // Actualiza el estatus al enviar un articulo a profit
                 ArticulosModel::where('id_articulo' , '=', $articulo->id_articulo )
                 ->update(['estatus' => 'MIGRADO', 'catalogado_por' => Auth::user()->id, 'fecha_catalogacion' => $FechaActual]);
             
                foreach ($empresas as $empresa) {
                 
                    // Inserta en la base de datos "art" de profit
                    Articulo_MigracionModel::MigrarArticuloProfit($empresa->base_datos, $articulo->codigo_articulo, $articulo->nombre_articulo,
                    $articulo->correlativo, $articulo->referencia, $FechaActual, $articulo->grupo, $articulo->subgrupo, $articulo->categoria,
                    $articulo->unidad,  $articulo->unidad_sec, $articulo->unidad_ter, $articulo->minimo, $articulo->maximo, $articulo->pedido,
                    $articulo->color, $articulo->proveedor, $articulo->procedencia,  $articulo->tipo, $articulo->impuesto, $articulo->tipo_unidad,
                    $articulo->equivalencia1,  $articulo->equivalencia2,  $articulo->equivalencia3 );

                    // Inserta En la tabla Articulo_migracion
                    Articulo_MigracionModel::updateOrInsert(
                        [
                            'id_empresa' => $empresa->id_empresa,
                            'id_articulo' => $articulo->id_articulo,
                        ],
                        [
                            'migrado' => 'SI', 
                            'nombre_usuario' => Auth::user()->name,
                            'nombre_equipo' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                            'direccion_ip' => $DireccionIp,
                            'updated_at' => $FechaActual,

                        ]);
                }
            });

        }
        catch (Exception $e)
        {
             return back()->withError('Ocurrio Un Error al Migrar El Articulo: '.$e->getMessage())->withInput();
        }

        try
        {
            $usuario = Auth::user()->name;
            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::FictCorreosDestinatarios(Auth::user()->id , $articulo->creado_por, $ArregloEmpresas, 'MIGRAR');

           // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(60), new ArticulosMigrateMailable($articulo, $empresas, $usuario));   
        }
        catch (Exception $ex)
        {
            Session::flash('alert','Se Produjo Un error Al Enviar El Correo: '.$ex->getMessage());
        }
        return back()->withSuccess('El Articulo Ha Sido Migrado Exitosamente');

    }

    /**
     * OBTIENE LA LISTA DE SUBGRUPOS SEGUN EL GRUPO SELECCIONADO EN EL FORMULARIO 
     * DE ARTICULOS
     */
    public function subgruposarticulo(Request $request)
    {
        $subgrupos = SubgruposModel::SubgruposPorGrupo($request->id);
        return with(["subgrupos" => $subgrupos]);
    }

    /**
     * OBTIENE LA LISTA DE SUBCLASIFICACIONES SEGUN LA CLASIFICACION SELECCIONADA 
     * EN LA SECCION DE DATOS ADICIONALES DE ARTICULOS
     */
    public function subclasificacionarticulo(Request $request)
    {
        $subclasificacion = SubclasificacionesModel::where('id_clasificacion', '=', $request->id)->get();
        return with(["subclasificacion" => $subclasificacion]);
    }

    /**
     * OBTIENE LA LISTA DE LAS UNIADES DE MEDIDA QUE POSSE UN ARTICULO 
     */
    public function unidadesarticulo(Request $request)
    {
        $unidades = ArticulosModel::UnidadesArticulos($request->id);
        return with(["unidades" => $unidades]);
    }

    /**
     * GENERA CODIGO DEL ARTICULO TOMANDO EL MAXIMO DEL CAMPO CORRELATIVO + 1
     * RELLENANDO CON CEROS A LA IZQUIERDA
     */
    public function generarcodigo()
    {
        //$CodigoArticulo =  ArticulosModel::where('codigo_articulo', 'like', '%'.$codigo.'%')->max('codigo_articulo');
        $CodigoArticulo =  ArticulosModel::max('correlativo') + 1;
        //Formatea el Maximo Agregando ceros a la izquierda
        $CodigoGenerado = str_pad($CodigoArticulo, 5 , "0", STR_PAD_LEFT);

        return with(["codigo" => $CodigoGenerado]);
    }

    /**
     * ELIMINA DATOS LA CLASIFICACION DE LA SECCION DE DATOS ADICIONALES
     * DE LOS ARTICULOS
     */
    public function EliminarAdicionales($IdArticuloClasificacion)
    {
        try
        {
            Articulo_ClasificacionModel::destroy($IdArticuloClasificacion);
        }
        catch (Exception $e)
        {
            return back()->withError('Error Al Eliminar');
        }

        return back()->with('');
    }

    /**
     * PROCESO QUE DESBLOQUEA/BLOQUEA UN ARTICULO PARA MODIFICAR SUS DATOS
     * EXCEPTO LOS CAMPOS, CODIGO, GRUPO Y SUBGRUPO
     */
    public function HabilitarArticulo($IdArticulo)
    {
        $resultado =  ArticulosModel::select('estatus')->where('id_articulo', $IdArticulo)->first(); //obtiene el estus del articulo

        if($resultado->estatus == 'MIGRADO' || $resultado->estatus == 'MIGRACION PENDIENTE')
        {
            $estatus = 'NO MIGRADO';    
        }
        else    
            {
                $estatus = 'MIGRADO';  
            }
            
        ArticulosModel::where('id_articulo', $IdArticulo)
        ->update(['estatus' => $estatus]);

        return back();
    }

    /**
     * REALIZA LA BUSUQEDA DE LOS NOMBRES DE ARTICULOS SEGUN LO ESCRITO EN EL CAMPO NOMBRE
     * DEL FORMULARIO CREAR ARTICULO
     */
    public function AutoCompletar(Request $request)
    {       
        $valor = $request->get('query');
        $resultado = ArticulosModel::select('nombre_articulo')->where('nombre_articulo', 'LIKE', '%'. $valor. '%')->where('activo', 'SI')->get();

        $data = array();
        foreach ($resultado as $result)
        {
            $data[] = rtrim($result->nombre_articulo, ' ');
        } 

        return response()->json($data);
    }

        /**
     * REALIZA LA BUSUQEDA DE LOS NOMBRES Y CODIGODE ARTICULOS SEGUN LO ESCRITO EN EL CAMPO NOMBRE
     * DEL FORMULARIO CREAR ARTICULO
     */
    public function AutoCompletarArticulo(Request $request)
    {       
        $valor = $request->get('query');
        $resultado = ArticulosModel::select('codigo_articulo', 'nombre_articulo')->where('nombre_articulo', 'LIKE', '%'. $valor. '%')->where('activo', 'SI')->get();

        $data = array();
        foreach ($resultado as $result)
        {
            $data[] = rtrim($result->codigo_articulo, ' ').'|'.rtrim($result->nombre_articulo, ' ');
        } 

        return response()->json($data);
    }

    /**
     * PROCESO QUE CREA LA SOLICITUD DE MIGRACION DE UN ARTICULO A PROFIT
     * DISPONIBLE EN LA SECCION DE ALMACENES DE VER ARTICULO
     */
    public function SolicitudMigracion(ArticuloSolicitudRequest $request)
    {    
        $IdArticulo = $request['id_articulo']; //OBTIENE DEL CAMPO OCULTO EL ID DEL ARTICULO
        $ArregloEmpresas = $request['empresas']; //CAPTURA LOS ID DE LAS EMPRESAS SELECCIONADOS PARA LA MIGRACION
        $articulo = ArticulosModel::DetalleArticulo($IdArticulo); // Obtiene datos del Articulo

        $empresas = DB::table('empresas')->whereIn('id_empresa', $ArregloEmpresas)->get();
    
        try
        {
            // VALIDA SI EXISTE UN ERROR EN ALGUN INSERT NO REALIZE NINGUNO
            DB::transaction(function () use ($empresas, $articulo){
            
            $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
                
            //Actualiza el estatus cuando el usuario realiza una solicitud de migracion
            ArticulosModel::where('id_articulo', '=', $articulo->id_articulo )
                            ->update(['estatus' => 'MIGRACION PENDIENTE']);

                foreach ($empresas as $empresa) {

                    // Inserta En la tabla Migracion Articulo
                    Articulo_MigracionModel::updateOrCreate(
                        [
                            'id_articulo' => $articulo->id_articulo,
                            'id_empresa' => $empresa->id_empresa
                        ],
                        [    
                            'solicitado' => 'SI',
                            'migrado' => 'NO',
                            'nombre_solicitante' => Auth::user()->name,
                            'fecha_solicitud' => $FechaActual
                        ]);
                }

            });

        }
        catch (Exception $e)
        {
             return back()->withError('Ocurrio Un Error Al Solicitar La Migración Del Articulo: '.$e->getMessage())->withInput();
        }
        try
        {
            $usuario = Auth::user()->name;
            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::FictCorreosDestinatarios(Auth::user()->id , ' ', $ArregloEmpresas , 'SOLICITUD');
            
            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(10), new ArticuloSolicitudMailable($articulo, $empresas, $usuario));   
           
        }
        catch (Exception $ex)
        {
            Session::flash('alert','Se Produjo Un error Al Enviar El Correo: '.$ex->getMessage());
        }

        return back()->withSuccess('La Solicitud Se Ha Realizado Exitosamente');

    }

    /**
     * PROCESO QUE INACTIVA/ACTIVA UN ARTICULO EN SISTEMA Y EN PROFIT
     * SEGUN LA EMPRESA DONDE ESTE DISPONIBLE EL ARTICULO Y NO POSEA STOCK
     */
    public function InactivarArticulo($IdArticulo)
    {
        $articulo =  ArticulosModel::select('id_articulo', 'codigo_articulo', 'activo')->where('id_articulo', $IdArticulo)->first(); //obtiene los datos del articulo
        $empresas = EmpresasModel::select('base_datos','nombre_empresa')->where('visible_ficht', 'SI')->get(); //obtiene las empresas

        foreach ($empresas as $empresa )
        {
            //Obtiene la suma del stock de un articulo en profit
            $stock = Articulo_MigracionModel::SumaStockArticuloProfit($empresa->base_datos, $articulo->codigo_articulo);
            

            if($stock != NULL)  // Si El stock retorna null es porque no existe el articulo esa empresa
            {
                if($stock->total_stock > 0) // si el articulo tiene stock mayor a cero muestra el mensaje la empresa que posee stock
                {
                    return back()->withAlert('El Articulo No Se Puede Inactivar Porque Tiene Stock Disponible En La Empresa: '.$empresa->nombre_empresa);
                }
                else
                    {
                        //arreglo de empresas donde esta disponible el articulo
                        $EmpresasDisponible[] = $empresa->base_datos;  
                    }
            }
        }

        try
        {
            DB::transaction(function () use ($EmpresasDisponible, $articulo){
                
                if(str_replace(" ","",$articulo->activo) == 'SI')
                {
                    $activo = 'NO';
                    $anulado = 1;    
                }
                else if(str_replace(" ","",$articulo->activo) == 'NO')    
                    {  
                        $activo = 'SI';    
                        $anulado = 0;
                    }

                //Actualiza el campo activo de la tabla de articulos
                ArticulosModel::where('id_articulo', $articulo->id_articulo)
                ->update(['activo' => $activo]);
                
                
                    foreach ($EmpresasDisponible as $empresa) {
                        //actualiza el campo anulado de la tabla art de profit
                        DB::connection('profit')
                            ->table($empresa.'.dbo.art')
                            ->where('co_art', $articulo->codigo_articulo) 
                            ->update(['anulado' => $anulado]);
                    }
            });
        }
        catch(Exception $ex)
            {
                return back()->withError('Ocurrio Un Error Al Inactivar/Activar El Articulo '.$ex->getMessage());
            }
            
        return back();

    }

    /**
     * REALIZA LA APROBACION DE UN ARTICULO PARA VERIFICAR SI ESTA CREADO CORRECTAMENTE
     *
     */
    public function AprobarArticulo($IdArticulo)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $articulo = ArticulosModel::DetalleArticulo($IdArticulo); //busca los datos del articulo 

        //Obtiene Las Empresas que fue solicitado en la creacion del articulo 
        $SolicitudEmpresa = Articulo_MigracionModel::where('id_articulo', '=', $IdArticulo)->where('solicitado', '=', 'SI')->get(); 
       
        foreach($SolicitudEmpresa as $empresa)
        {
            $ArregloEmpresas [] = $empresa->id_empresa; // LLena el Arreglo con el valor id_empresa
        }

        $empresas = DB::table('empresas')->whereIn('id_empresa', $ArregloEmpresas)->get(); //Obtiene los datos de las empresas

        try
        {
            // Actualiza el campo aprobado y la fecha de aprobacion de un articulo
            ArticulosModel::where('id_articulo' , '=', $IdArticulo )
                ->update([
                    'aprobado' => 'SI',
                    'aprobado_por' => Auth::user()->id,
                    'fecha_aprobacion' => $FechaActual,
                    'estatus' => 'NO MIGRADO'
                ]);
        }
        catch(Exception $ex)
            {
                return back()->withError('Ocurrio Un Error Al Aprobar El Articulo '.$ex->getMessage());
            }
        
        //VALIDACION AL ENVIAR CORREOS
        try
        {
            $usuario = Auth::user()->name;
            //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
            $destinatarios = CorreosModel::FictCorreosDestinatarios(Auth::user()->id ,'', $ArregloEmpresas, 'APROBAR');

            // ENVIA EL CORREO
            Mail::to($destinatarios[0]) //DESTINATARIOS
                ->cc($destinatarios[1]) //EN COPIA
                //->bcc($destinatarios[2]) // EN COPIA OCULTA
                ->later(now()->addSeconds(60), new ArticulosAprobarMailable($articulo, $empresas, $usuario));   
        }
        catch (Exception $ex)
        {
            Session::flash('alert','Se Produjo Un error Al Enviar El Correo: '.$ex->getMessage());
        }    
        
        return back()->withSuccess('La Aprobación Del Articulo Se Ha Realizado Exitosamente');    
    }

    /**
     * ELIMINA LA IMAGEN SELECCIONADA DE UN ARTICULO
     *
     */
    public function EliminarImagen($IdArticuloImagen)
    {
        $imagen = Articulo_ImagenModel::find($IdArticuloImagen); 
       
        try
        {
            if($imagen->imagen != NULL)
            {
                storage::disk('local')->delete($imagen->imagen);
            }

            //Elimina la imagen
            Articulo_ImagenModel::destroy($IdArticuloImagen);
            
            //Obtiene la imagen principal del articulo 
            $ImagenPrincipal = Articulo_ImagenModel::ImagenPrincipalArticulo($imagen->id_articulo);

            // Actualiza el campo imagen_articulo de la tabla articulos
            ArticulosModel::where('id_articulo' , '=', $imagen->id_articulo )
            ->update(['imagen_articulo' => $ImagenPrincipal]);
        }
        catch(Exception)
            {
                return back()->withError('Se Produjo Un Error Al Eliminar La Imagen');
            }

       return back()->withSuccess('La Imagen Ha Sido Eliminada Exisosamente');
    } 
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdArticulo)
    {   
        //Valida si un articulo fue migrado a profit
        $ArticuloMigrado = Articulo_MigracionModel::ArticuloMigrado($IdArticulo);
        $imagenes = Articulo_ImagenModel::select('imagen')->where('id_articulo', '=', $IdArticulo)->get();

        if($ArticuloMigrado == FALSE){ //si no fue migrado , elimina los datos del articulo en todas las tablas
            try
            {
                $articulo = ArticulosModel::find($IdArticulo);

                    if($articulo->imagen_articulo != NULL)
                    {
                        //storage::disk('local')->delete($articulo->imagen_articulo);
                        foreach($imagenes as $imagen)
                        {
                            storage::disk('local')->delete($imagen->imagen);
                        }
                    }

                    if($articulo->documento_articulo != NULL)
                    {
                        storage::disk('local')->delete($articulo->documento_articulo);
                    }

                    //Elimina los datos de la tabla articulo_ubicacion
                    Articulo_UbicacionModel::where('id_articulo', '=', $IdArticulo)->delete(); 

                    //Elimina los datos de la tabla articulo_migracion
                    Articulo_MigracionModel::where('id_articulo', '=', $IdArticulo)->delete(); 

                    //Elimina los adicionales de la tabla articulo_clasificacion
                    Articulo_ClasificacionModel::where('id_articulo', '=', $IdArticulo)->delete(); 

                    //Elimina los datos de la tabla articulo_imagen
                    Articulo_ImagenModel::where('id_articulo', '=', $IdArticulo)->delete(); 
                    
                    //Elimina el articulo
                    ArticulosModel::destroy($IdArticulo); 
            }
            catch (Exception $e)
            {
                return redirect("articulos")->withError('Error Al Eliminar el articulo');
            }

            return redirect("articulos")->withSuccess('El Articulo Ha Sido Eliminado Exitosamente');
        }
        else
            {
                return redirect("articulos")->withError('El Articulo No Puede Ser Eliminado, Esta Migrado a Profit');
            }    
    }

    public function ImprimirEtiquetas(Request $request)
    {
        $IdArticulo = $request->id_articulo;
        $IdAlmacen = $request->id_almacen;
        $IdSubalmacen = $request->id_subalmacen;

        $articulo = Articulo_UbicacionModel::ZonasArticuloSubAlmacen($IdArticulo, $IdAlmacen, $IdSubalmacen);

        $qr = QrCode::size(50)
                ->generate('http://10.10.0.14/audiauditoriainventario/create?codigo_articulo='.trim($articulo[0]->codigo_articulo).
                '&id_almacen='.$IdAlmacen.
                '&id_subalmacen='.$IdSubalmacen);

        $pdf = Pdf::loadView('FichaTecnica.Articulos.ArticuloImprimirEtiqueta', compact('qr', 'articulo'))->setPaper([0, 0, 155.906, 85.0394], 'portrait');
        return $pdf->stream('etiquetaarticulo.pdf');
        return view('FichaTecnica.Articulos.ArticuloImprimirEtiqueta', compact('qr', 'articulo'));
    }

    public function BuscarArticulos(Request $request) 
    {
        
        $articulos = ArticulosModel::BuscarArticulos($request->articulo);
        return with(["articulos" => $articulos]);
    }

}
