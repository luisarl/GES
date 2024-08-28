<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticulosUbicacionCreateRequest;
use App\Http\Requests\FictUbicacionesCreateRequest;
use App\Http\Requests\FictUbicacionesUpdateRequest;
use App\Models\Almacen_UsuarioModel;
use App\Models\AlmacenesModel;
use App\Models\Articulo_MigracionModel;
use App\Models\Articulo_UbicacionModel;
use App\Models\ArticulosModel;
use App\Models\CategoriasModel;
use App\Models\Fict_UbicacionesModel;
use App\Models\Fict_SubalmacenesModel;
use App\Models\GruposModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FictArticulosUbicacionesController extends Controller
{


    public function index()
    {
        // $ubicaciones = Articulo_UbicacionModel::ConsultarArticulosUbicaciones();
        // return view('FichaTecnica.ArticulosUbicaciones.ArticulosUbicaciones', compact('ubicaciones'));
    }



    public function create()
    {

        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);
        $categorias = CategoriasModel::select('id_categoria', 'nombre_categoria', 'codigo_categoria')->get();
        $grupos = GruposModel::select('id_grupo', 'nombre_grupo', 'codigo_grupo')->get();
        $ubicaciones = Fict_UbicacionesModel::select('id_ubicacion', 'nombre_ubicacion', 'codigo_ubicacion')->get();

        return view('FichaTecnica.ArticulosUbicaciones.ArticulosUbicacionesCreate', compact('almacenes', 'categorias', 'grupos', 'ubicaciones'));
    }


    public function store(ArticulosUbicacionCreateRequest $request)
    {   

        $articulos =  json_decode($request['datosarticulos']);   

        if ($articulos  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['articulosubicaciones' => 'Para asignar una ubicacion debe seleccionar una o varios articulos']);
        }
        try
        {                
                foreach($articulos as $articulo) 
                {
                    if($articulo->id_articulo_ubicacion == 0)
                    {
                            $IdArticuloUbicacion = Articulo_UbicacionModel::max('id_articulo_ubicacion') + 1;  
                    }
                    else
                        {   
                            $IdArticuloUbicacion = $articulo->id_articulo_ubicacion;
                        }

                        Articulo_UbicacionModel::updateOrCreate(
                        [
                            'id_articulo_ubicacion' => $IdArticuloUbicacion,
                        ],
                        [
                            'id_almacen' => $request['id_almacen'],
                            'id_subalmacen' => $request['id_subalmacen'],
                            'id_ubicacion' => $request['id_ubicacion'],
                            'id_articulo' => $articulo->id_articulo,
                            'zona' => strtoupper($articulo->zona)
                        ]); 
                }
        }
        catch(Exception $ex)
        {
            return back()->withError('Ha Ocurrido Un Error Al Asignar la Ubicacion : '.$ex->getMessage())->withInput();
        }

      return back()->withSuccess('La Ubicacion se ha Asignado Exitosamente');
       
    }

    public function edit($id_articulo_ubicacion)
    {
        //
    }


    public function show()
    {
        //
    }

    public function update(Request $request,$IdArticulo)
    {
        $DatosUbicaciones = json_decode($request->input('datosubicaciones')); // arreglo de datos adicionales

        if($DatosUbicaciones  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['datosubicaciones'=> 'Para realizar un ajuste debe seleccionar una ubicacion']);
        }
        
        try
        {
            
            foreach($DatosUbicaciones  as $ubicacion)
            {
             
                if($ubicacion->id_articulo_ubicacion == '')
                {
                        $IdArticuloUbicacion = Articulo_UbicacionModel::max('id_articulo_ubicacion') + 1;  
                }
                else
                    {   
                        $IdArticuloUbicacion = $ubicacion->id_articulo_ubicacion;
                    }


                    Articulo_UbicacionModel::updateOrCreate(
                        [
                            'id_articulo_ubicacion' => $IdArticuloUbicacion,
                        ],
                        [
                            'id_almacen' => $ubicacion->id_almacen,
                            'id_subalmacen' => $ubicacion->id_subalmacen,
                            'id_ubicacion' => $ubicacion->id_zona,
                            'zona' => strtoupper($ubicacion->id_ubicacion),
                            'id_articulo' => $IdArticulo  
                        ]
                    );
            }  
                
        }
        catch(Exception $ex)
        {
            return back()->withError('Ha Ocurrido Un Error Al Asignar la Ubicacion : '.$ex->getMessage())->withInput();
        }

      return back()->withSuccess('La Ubicacion se ha Asignado Exitosamente');
    }

    public function destroy()
    {
        //
    }

    /**
     * ELIMINA DATOS DE LA UBICACION DEL ARTICULO
     * DE LOS ARTICULOS
     */
    public function EliminarUbicaciones($IdArticuloUbicacion)
    {
        try
        {
            Articulo_UbicacionModel::destroy($IdArticuloUbicacion);
        }
        catch (Exception $e)
        {
            return back()->withError('Error Al Eliminar');
        }

        return back()->with('');
    }

    //OBTIENE LOS SUBALMACENES PARA EL FILTRO
    public function ObtenerSubalmacen(Request $request)
    {
        $subalmacenes = Fict_SubalmacenesModel::where('id_almacen', '=', $request->id)->get();
        return with(["subalmacenes" => $subalmacenes]);
    }

    //OBTIENE LA UBICACION (ZONAS) PARA EL FILTRO
    public function ObtenerZonas(Request $request)
    {
        $zonas = Fict_UbicacionesModel::where('id_subalmacen', '=', $request->id)->get();
        return with(["zonas" => $zonas]);
    }
    
    // OBTIENE LOS DATOS DE LOS ARTICULOS CON O SIN UBICACION SEGUN EL FILTRO SELECCIONADO
    public function FiltroArticulosUbicaciones($IdArticulo, $IdGrupo, $IdCategoria, $IdAlmacen, $IdSubAlmacen, $IdUbicacion)
    {
        $articulos = Articulo_UbicacionModel::FiltroArticulosUbicaciones($IdArticulo, $IdGrupo, $IdCategoria, $IdAlmacen, $IdSubAlmacen, $IdUbicacion);
        return with(["articulos" => $articulos]);
    }

}
