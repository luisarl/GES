<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActvActivosCreateRequest;
use App\Http\Requests\ActvActivosUpdateRequest;
use App\Models\Actv_Activos_CaracteristicasModel;
use App\Models\Actv_ActivosModel;
use App\Models\Actv_CaracteristicasModel;
use App\Models\Actv_EstadosModel;
use App\Models\Actv_SubTiposModel;
use App\Models\Actv_TiposModel;
use App\Models\DepartamentosModel;
use Exception;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActvActivosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activos = Actv_ActivosModel::ListaActivos();
        return view('Activos.Activos.Activos', compact('activos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $caracteristicas = Actv_CaracteristicasModel::select('id_caracteristica', 'nombre_caracteristica')->get();
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
        $tipos = Actv_TiposModel::select('id_tipo', 'nombre_tipo')->get();
        $subtipos = Actv_SubTiposModel::select('id_subtipo', 'nombre_subtipo')->get();
        $estados = Actv_EstadosModel::select('id_estado', 'nombre_estado')->get();
        return view('Activos.Activos.ActivosCreate', compact('tipos', 'subtipos', 'departamentos', 'caracteristicas','estados')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActvActivosCreateRequest $request)
    {
        $IdActivo = Actv_ActivosModel::max('id_activo') + 1;
        $activo = new Actv_ActivosModel();

        try 
        {
            $activo->id_activo = $IdActivo;
            $activo->nombre_activo = strtoupper($request['nombre_activo']);
            $activo->descripcion_activo = strtoupper($request['descripcion_activo']);
            $activo->codigo_activo = strtoupper($request['codigo_activo']);
            $activo->marca = strtoupper($request['marca']);
            $activo->modelo = strtoupper($request['modelo']);
            $activo->serial = strtoupper($request['serial']);
            $activo->ubicacion = strtoupper($request['ubicacion']);
            $activo->id_tipo = $request['id_tipo'];
            $activo->id_departamento = $request['id_departamento'];
            $activo->id_subtipo = $request['id_subtipo'];
            $activo->estatus = $request['estatus_activo'];
            $activo->id_estado = $request['estado_activo'];
            $activo->responsable = strtoupper($request['responsable']);

            if ($request->hasFile('imagen_activo')) 
            {
                $imagenes = $request->file('imagen_activo');
                foreach ($imagenes as $imagen) { 
                    $destino = "images/activos/";
                    $NombreImagen = $IdActivo . '.jpg';
                    $imagen->move($destino, $NombreImagen);
                }
                //Funcion para renderizar la imagenes y cambiar el tamaño
                $RutaImagen = public_path($destino . $NombreImagen);
                $imagen = Image::make($RutaImagen)->resize(400, 400)->save($RutaImagen);
                $imagen->save($RutaImagen);
                $activo->imagen_activo = $destino . $NombreImagen; //Guarda Ruta Imagen en bd
            }
            
            $caracteristicas = json_decode($request['caracteristicas']); //arreglo de datos adicionales
            
            // if ($caracteristicas  == NULL) //Valida que el arreglo de las adicionales no este vacio
            // {
            //     return back()->withErrors(['caracteristicas' => 'Debe Agregar Las Caracteristicas Del Activo'])->withInput();
            // }

            DB::transaction(function () use ($IdActivo, $activo, $caracteristicas)
            {
              
                $activo->save(); // guarda el activo
                
                //$filas = count($caracteristicas);
                if ($caracteristicas != "")  //verifica si el arreglo no esta vacio
                {
                    foreach($caracteristicas  as $caracteristica )
                    {
                        $IdActivoCaracteristica = Actv_Activos_CaracteristicasModel::max('id_activo_caracteristica') + 1;
                        //Inserta datos de la tabla 
                        Actv_Activos_CaracteristicasModel::create([
                            'id_activo_caracteristica' =>  $IdActivoCaracteristica,
                            'id_activo' => $IdActivo,
                            'id_tipo' => $activo->id_tipo,
                            'id_caracteristica' => $caracteristica->id_caracteristica,
                            'valor_caracteristica' => $caracteristica->valor_caracteristica,
                            'estatus'=>$activo->estatus,
                        ]);
                    }
                }

            });
            //$activo->save(); // guarda el activo
        }
        catch(Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear El Activo '.$ex->getMessage())->withInput();
        }
        
        return redirect("activos")->withSuccess('El Activo Ha Sido Creado Exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdActivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdActivo)
    {
        $activo = Actv_ActivosModel::find($IdActivo);
        $CaracteristicasActivo = Actv_Activos_CaracteristicasModel::CaracteristicasActivo($IdActivo);
        $caracteristicas = Actv_CaracteristicasModel::select('id_caracteristica', 'nombre_caracteristica')->get();
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
        $tipos = Actv_TiposModel::select('id_tipo', 'nombre_tipo')->get();
        $subtipos = Actv_SubTiposModel::select('id_subtipo', 'nombre_subtipo')->get();
        $estados = Actv_EstadosModel::select('id_estado', 'nombre_estado')->get();

        return view('Activos.Activos.ActivosEdit', compact('tipos', 'subtipos', 'CaracteristicasActivo', 'departamentos', 'caracteristicas', 'activo','estados')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActvActivosUpdateRequest $request, $IdActivo)
    {
        try 
        {
            $activo = Actv_ActivosModel::find($IdActivo);

            $activo->fill([
                'codigo_activo' => strtoupper($request['codigo_activo']),
                'nombre_activo' => strtoupper($request['nombre_activo']),
                'descripcion_activo' => strtoupper($request['descripcion_activo']),
                'marca' => strtoupper($request['marca']),
                'modelo' => strtoupper($request['modelo']),
                'serial' => strtoupper($request['serial']),
                'ubicacion' => strtoupper($request['ubicacion']),
                'id_tipo' => $request['id_tipo'],
                'id_departamento' => $request['id_departamento'],
                'id_subtipo' => $request['id_subtipo'],
                'estatus' => $request['estatus_activo'],
                'id_estado' => $request['estado_activo'],
                'responsable' => strtoupper($request['responsable']),

            ]);

            if ($request->hasFile('imagen_activo')) 
            {
                $imagenes = $request->file('imagen_activo');
                foreach ($imagenes as $imagen) {
                    $destino = "images/activos/";
                    $NombreImagen = $IdActivo . '.jpg';
                    $imagen->move($destino, $NombreImagen);
                }
                //Funcion para renderizar la imagenes y cambiar el tamaño
                $RutaImagen = public_path($destino . $NombreImagen);
                $imagen = Image::make($RutaImagen)->resize(400, 400)->save($RutaImagen);
                $imagen->save($RutaImagen);
                $activo->imagen_activo = $destino . $NombreImagen; //Guarda Ruta Imagen en bd
            }

            $caracteristicas = json_decode($request['caracteristicas']); //arreglo de datos adicionales
            
            // if ($caracteristicas  == NULL) //Valida que el arreglo de las adicionales no este vacio
            // {
            //     return back()->withErrors(['caracteristicas' => 'Debe Agregar Las Caracteristicas Del Activo'])->withInput();
            // }

            DB::transaction(function () use ($IdActivo, $activo, $caracteristicas){

                $activo->save(); // guarda el activo
                
                if ($caracteristicas != "")  //verifica si el arreglo no esta vacio
                {
                    foreach($caracteristicas as $caracteristica) 
                    {
                        
                        if($caracteristica->id_activo_caracteristica == "") //si la primera columna de la tabla esta vacia busca el maximo id de la base de datos y le suma 1
                        {
                            $IdActivoCaracteristica = Actv_Activos_CaracteristicasModel::max('id_activo_caracteristica') + 1;
                        }
                            else //si no captura el valor de la primera columna de la tabla
                            {
                                $IdActivoCaracteristica = $caracteristica->id_activo_caracteristica;
                            }

                        //Inserta datos de la tabla 
                        Actv_Activos_CaracteristicasModel::updateOrCreate(
                            [ 'id_activo_caracteristica' => $IdActivoCaracteristica],
                            [
                                'id_activo' => $IdActivo,
                                'id_tipo' => $activo->id_tipo,
                                'id_caracteristica' => $caracteristica->id_caracteristica,
                                'valor_caracteristica' => strtoupper($caracteristica->valor_caracteristica),
                                'estatus' => $activo->estatus
                            ]
                        );
                    }
                }
            });
        } 
        catch (Exception $ex) 
            {
               return redirect()->back()->withError('Ha Ocurrido Un Error Al Actualizar El Activo. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('activos.edit', $IdActivo)->withSuccess('El Activo Ha Sido Actualizado Exitosamente');
    }

      /**
     * OBTIENE LA LISTA DE SUBTIPOS SEGUN EL TIPO SELECCIONADO EN EL FORMULARIO 
     * DE ACTIVOS 
     */
    public function SubtiposActivos(Request $request)
    {
        $subtipos = Actv_SubTiposModel::where('id_tipo', '=', $request->id)->get();
        return with(["subtipos" => $subtipos]);
    }

    /**
     * OBTIENE LA LISTA DE CARACTERISTICAS SEGUN EL TIPO SELECCIONADO EN EL FORMULARIO 
     * DE ACTIVOS 
     */
    public function CaracteristicasActivos(Request $request)
    {
        $caracteristicas = Actv_CaracteristicasModel::where('id_tipo', '=', $request->id)->get();
        return with(["caracteristicas" => $caracteristicas]);
    }

    public function EliminarCaracteristica($IdActivoCaracteristica)
    {
        try
        {
            Actv_Activos_CaracteristicasModel::destroy($IdActivoCaracteristica);
        }
            catch (Exception $e)
            {
                return back()->withError('Error Al Eliminar');
            }

        return back()->with('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdActivo)
    {
        try
        {
            DB::transaction(function () use ($IdActivo)
            {
                //Elimina los datos de la tabla actv_activos_caracteristicas
                Actv_Activos_CaracteristicasModel::where('id_activo', '=', $IdActivo)->delete(); 
                //Elimina el activo
                Actv_ActivosModel::destroy($IdActivo);
            });
        }
        catch(Exception $ex)
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Eliminar El Activo'.$ex->getMessage());
            }

        return redirect()->route('activos.index')->withSuccess('El Activo Ha Sido Eliminado Exitosamente');
    }
}
