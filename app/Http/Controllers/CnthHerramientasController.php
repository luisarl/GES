<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cnth_HerramientasModel;
use App\Models\Cnth_UbicacionesModel;
use App\Models\Cnth_GruposModel;
use App\Models\Cnth_SubgruposModel;
use App\Models\Cnth_CategoriasModel;
use App\Models\Cnth_Almacen_HerramientasModel;
use App\Models\AlmacenesModel;
use App\Models\EmpresasModel;
use App\Http\Requests\CnthHerramientasCreateRequest;
use App\Http\Requests\CnthHerramientasUpdateRequest;
use App\Models\ArticulosModel;
use App\Models\Cnth_Movimiento_InventarioModel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Session;

use Illuminate\Http\Request;

class CnthHerramientasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $herramientas = Cnth_HerramientasModel::with('categoria', 'grupo', 'subgrupo')->get();
        return view('ControlHerramientas.Herramientas.Herramientas', compact('herramientas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupos = Cnth_GruposModel::select('id_grupo', 'nombre_grupo', 'codigo_grupo')->get();
        $categorias = Cnth_CategoriasModel::select('id_categoria', 'nombre_categoria', 'codigo_categoria')->get();
        $subgrupos = Cnth_SubgruposModel::select('id_subgrupo', 'nombre_subgrupo', 'codigo_subgrupo')->get();
        $empresas = EmpresasModel::select('id_empresa', 'nombre_empresa')->get();
        return view('ControlHerramientas.Herramientas.HerramientasCreate', compact('grupos', 'categorias', 'subgrupos', 'empresas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnthHerramientasCreateRequest $request)
    {
        $IdHerramienta = Cnth_HerramientasModel::max('id_herramienta') + 1;
        $herramienta = new Cnth_HerramientasModel();

        try {
            $herramienta->id_herramienta = $IdHerramienta;
            $herramienta->nombre_herramienta = strtoupper($request['nombre_herramienta']);
            $herramienta->descripcion_herramienta = strtoupper($request['descripcion_herramienta']);
            $herramienta->codigo_herramienta = $request['codigo_herramienta'];
            $herramienta->correlativo = $request['correlativo'];
            $herramienta->id_grupo = $request['id_grupo'];
            $herramienta->id_subgrupo = $request['id_subgrupo'];
            $herramienta->id_categoria = $request['id_categoria'];
            $herramienta->creado_por = Auth::user()->name;
            $herramienta->actualizado_por = Auth::user()->name;

            try {
                if ($request->hasFile('imagen_herramienta')) {
                    $imagenes = $request->file('imagen_herramienta');
                    foreach ($imagenes as $imagen) {
                        $destino = "images/herramientas/";
                        $NombreImagen = $IdHerramienta . '.jpg';
                        $CargarImagen = $imagen->move($destino, $NombreImagen);
                    }
                    //Funcion para renderizar la imagenes y cambiar el tamaño
                    $RutaImagen = public_path('images/herramientas/' . $NombreImagen);
                    $imagen = Image::make($RutaImagen)->resize(400, 400)->save($RutaImagen);
                    $imagen->save($RutaImagen);
                    $herramienta->imagen_herramienta = $destino . $NombreImagen; //Guarda Ruta Imagen en bd
                }
                try {

                    $DatosHerramientas = json_decode($request['datosherramientas']); //arreglo de datos adicionales

                    if ($DatosHerramientas  == NULL) //Valida que el arreglo de las herramientas no este vacio
                    {
                        return back()->withErrors(['datosherramientas' => 'Para crear una herramienta debe seleccionar uno o varios almacenes'])->withInput();
                    }

                    DB::transaction(function () use ($herramienta, $DatosHerramientas, $IdHerramienta) {

                        $herramienta->save(); // guarda el despacho


                        $filas = count($DatosHerramientas);

                        if ($DatosHerramientas != "")  //verifica si el arreglo no esta vacio
                        {
                            $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

                            for ($i = 0; $i < $filas; $i++) {
                                $IdInventario = Cnth_Movimiento_InventarioModel::max('id_inventario') + 1;
                                //Inserta datos de la tabla 
                                Cnth_Almacen_HerramientasModel::create([
                                    'id_herramienta' => $IdHerramienta,
                                    'id_empresa' => $DatosHerramientas[$i][0],
                                    'id_almacen' => $DatosHerramientas[$i][1],
                                    'id_ubicacion' =>  $DatosHerramientas[$i][2],
                                    'stock_inicial' =>  $DatosHerramientas[$i][3],
                                    'stock_actual' =>  $DatosHerramientas[$i][3],
                                    'created_at' => $FechaActual
                                ]);

                                Cnth_Movimiento_InventarioModel::create(
                                    [
                                        'id_inventario' => $IdInventario,
                                        'id_herramienta' => $IdHerramienta,
                                        'id_almacen' => $DatosHerramientas[$i][1],
                                        'movimiento' => '',
                                        'tipo_movimiento' => 'STOCK INICIAL',
                                        'usuario' => Auth::user()->name,
                                        'fecha' => $FechaActual,
                                        'descripcion',
                                        'entrada' => $DatosHerramientas[$i][3],
                                        'salida' => '0'
                                    ]
                                );

                                //Actualizar Stock de la Herramienta
                                Cnth_Movimiento_InventarioModel::ActualizarStock($IdHerramienta, $DatosHerramientas[$i][1]);
                            }
                        }
                    });
                } catch (Exception $ex) {
                    return back()->withError('Ocurrio Un Error al Cargar datos de la Tabla: ' . $ex->getMessage());
                }
            } catch (Exception $ex) {
                return back()->withError('Ocurrio Un Error al Cargar fotografia de la herramienta: ' . $ex->getMessage());
            }

            $herramienta->save(); // guarda la herramienta

        } catch (Exception $ex) {
            return redirect("herramientas")->withError('Ha Ocurrido Un Error al Crear la herramienta' . $ex);
        }

        return redirect("herramientas")->withSuccess('La Herramienta Ha Sido Creado Exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdHerramienta)
    {
        $herramientas = Cnth_HerramientasModel::DetallesHerramientas($IdHerramienta);
        $almacenes = Cnth_HerramientasModel::ListadoAlmacenes($IdHerramienta);
        $HistoricoHerramienta = Cnth_Movimiento_InventarioModel::HistoricoHerramienta($IdHerramienta);
        return view('ControlHerramientas.Herramientas.HerramientasShow', compact('herramientas', 'almacenes', 'HistoricoHerramienta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdHerramienta)
    {
        $herramienta = Cnth_HerramientasModel::find($IdHerramienta);
        $almacenes = Cnth_HerramientasModel::ListadoAlmacenes($IdHerramienta);
        $grupos = Cnth_GruposModel::select('id_grupo', 'nombre_grupo', 'codigo_grupo')->get();
        $categorias = Cnth_CategoriasModel::select('id_categoria', 'nombre_categoria', 'codigo_categoria')->get();
        $subgrupos = Cnth_SubgruposModel::select('id_subgrupo', 'nombre_subgrupo', 'codigo_subgrupo')->get();
        $empresas = EmpresasModel::select('id_empresa', 'nombre_empresa')->get();
        return view('ControlHerramientas.Herramientas.HerramientasEdit', compact('herramienta', 'grupos', 'subgrupos', 'categorias', 'empresas', 'almacenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CnthHerramientasUpdateRequest $request, $IdHerramienta)
    {
        
        try {
            $herramienta = Cnth_HerramientasModel::find($IdHerramienta);
            $herramienta->fill([
                'nombre_herramienta' => strtoupper($request['nombre_herramienta']),
                'descripcion_herramienta' => strtoupper($request['descripcion_herramienta']),
                'id_categoria' => $request['id_categoria'],
                'actualizado_por' => Auth::user()->name
            ]);
            if ($request->hasFile('imagen_herramienta')) {
                $imagenes = $request->file('imagen_herramienta');
                foreach ($imagenes as $imagen) {
                    $destino = "images/herramientas/";
                    $NombreImagen = $IdHerramienta . '.jpg';
                    $CargarImagen = $imagen->move($destino, $NombreImagen);
                }
                //Funcion para renderizar la imagenes y cambiar el tamaño
                $RutaImagen = public_path('images/herramientas/' . $NombreImagen);
                $imagen = Image::make($RutaImagen)->resize(400, 400)->save($RutaImagen);
                $imagen->save($RutaImagen);
                $herramienta->fill(['imagen_herramienta' => $destino . $NombreImagen]); //Guarda Ruta Imagen en bd         
            }
            try 
            {
                $DatosHerramientas = json_decode($request['datosherramientas']);

                DB::transaction(function () use ($DatosHerramientas, $IdHerramienta) 
                {
                    if($DatosHerramientas != NULL) 
                    {
                        foreach ($DatosHerramientas as $datoHerramienta) 
                        {
                            // Verifica si el registro existe
                            $registroExistente = Cnth_Almacen_HerramientasModel::where([
                            'id_herramienta' => $IdHerramienta,
                            'id_empresa' => $datoHerramienta->id_empresa,
                            'id_almacen' => $datoHerramienta->id_almacen
                            ])->first();

                            if ($registroExistente) 
                            {
                                // Actualiza el registro existente
                                $registroExistente->update([
                                    'id_ubicacion' => $datoHerramienta->id_ubicacion,
                                ]);

                            } else 
                                {
                                    // Inserta un nuevo registro
                                    Cnth_Almacen_HerramientasModel::create([
                                        'id_herramienta' => $IdHerramienta,
                                        'id_empresa' => $datoHerramienta->id_empresa,
                                        'id_almacen' => $datoHerramienta->id_almacen,
                                        'id_ubicacion' => $datoHerramienta->id_ubicacion,
                                        'stock_inicial' => $datoHerramienta->stock_inicial,
                                        'stock_actual' => $datoHerramienta->stock_inicial
                                    ]);

                                    // Inserta un nuevo registro en movimiento cuando se agrega una segunda ubicacion a un producto. 
                                    // Se debe tambien limitar a las personas a no guadar herramientas sin ubicacion
                                    $IdInventario = Cnth_Movimiento_InventarioModel::max('id_inventario') + 1;
                                    $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
                                    
                                    Cnth_Movimiento_InventarioModel::create(
                                        [
                                            'id_inventario' => $IdInventario,
                                            'id_herramienta' => $IdHerramienta,
                                            'id_almacen' => $datoHerramienta->id_almacen,
                                            'movimiento' => '',
                                            'tipo_movimiento' => 'STOCK INICIAL',
                                            'usuario' => Auth::user()->name,
                                            'fecha' => $FechaActual,
                                            'descripcion',
                                            'entrada' => $datoHerramienta->stock_inicial,
                                            'salida' => '0'
                                        ]
                                    );

                                }
                        }
                    }
                });

                $herramienta->save(); //guarda el despacho
            } catch (Exception $ex) {
                return back()->withError('Ocurrio Un Error al Modificar Herramienta: ' . $ex->getMessage())->withInput();
            }
        } catch (Exception $ex) {
            return back()->withError('Ocurrio Un Error al Modificar Herramienta: ' . $ex->getMessage())->withInput();
        }

        return redirect()->route('herramientas.edit', $IdHerramienta)->withSuccess('La herramienta Ha Sido Modificado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_herramienta)
    {
        try {
            Cnth_HerramientasModel::destroy($id_herramienta);
        } catch (Exception $ex) {
            return redirect("herramientas")->withError('No se puede eliminar la herramienta porque tiene Despachos Asociados' . $ex->getMessage());
        }

        return redirect("herramientas")->withSuccess('La herramienta Ha Sido Eliminado Exitosamente');
    }

    public function subgruposherramientas(Request $request)
    {
        $subgrupos = Cnth_SubgruposModel::where('id_grupo', '=', $request->id)->get();
        return with(["subgrupos" => $subgrupos]);
    }

    /**
     * OBTIENE LA LISTA DE ALMACENES SEGUN LA EMPRESA SELECCIONADA 
     * EN LA SECCION DE EMPRESAS Y ALMACENES DE HERRAMIENTAS
     */
    public function almacenesherramientas(Request $request)
    {
        $almacenes = AlmacenesModel::where('id_empresa', '=', $request->id)->get();
        return with(["almacenes" => $almacenes]);
    }

    public function ubicacionesHerramientas(Request $request)
    {
        $ubicaciones = Cnth_UbicacionesModel::where('id_almacen', '=', $request->id)->get();
        return with(["ubicaciones" => $ubicaciones]);
    }


    //GENERA CODIGO DE LA HERRAMIENTA CAMPO CORRELATIVO + 1
    public function generarcodigoherramienta($codigo)
    {
        $CodigoHerramienta =  Cnth_HerramientasModel::max('correlativo') + 1;
        //Formatea el Maximo Agregando ceros a la izquierda
        $CodigoGenerado = str_pad($CodigoHerramienta, 5, "0", STR_PAD_LEFT);

        return with(["codigo" => $CodigoGenerado]);
    }

    public function importararticulo($IdArticulo)
    {
        $articulos = ArticulosModel::ImportarArticulo($IdArticulo);
        return with(["articulos" => $articulos]);
    }

    public function HerramientasAlmacen(Request $request)
    {
        $herramientas = Cnth_HerramientasModel::ListadoHerramientas($request->id);
        return with(["herramientas" => $herramientas]);
    }
}
