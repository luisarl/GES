<?php

namespace App\Http\Controllers;

use App\Http\Requests\CnthPlantillasCreateRequest;
use App\Http\Requests\CnthPlantillasUpdateRequest;
use App\Models\Almacen_UsuarioModel;
use App\Models\AlmacenesModel;
use App\Models\Cnth_Plantillas_DetalleModel;
use App\Models\Cnth_PlantillasModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CnthPlantillasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plantillas = Cnth_PlantillasModel::ListaPlantillas(Auth::user()->id);
        return view('ControlHerramientas.Plantillas.Plantillas', compact('plantillas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);
        return view('ControlHerramientas.Plantillas.PlantillasCreate', compact('almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnthPlantillasCreateRequest $request)
    {
        //dd($request->all());

        //$FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $ListaHerramientas = json_decode($request['datosmovimiento']);

        if($ListaHerramientas  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['datosmovimiento'=> 'Para Crear una Plantilla debe seleccionar una o varias herramientas'])->withInput();
        }

       try
       {
           // VALIDA SI EXISTE UN ERROR EN ALGUN INSERT NO REALIZE NINGUNO
           DB::transaction(function () use ($request, $ListaHerramientas)
           {
                    $IdPlantilla = Cnth_PlantillasModel::max('id_plantilla') + 1;
        
                    Cnth_PlantillasModel::create(
                        [
                        'id_plantilla' => $IdPlantilla,
                        'nombre_plantilla' => strtoupper($request->nombre_plantilla),
                        'descripcion_plantilla' => strtoupper($request->descripcion_plantilla),
                        'id_almacen' => $request->id_almacen  
                        ]
                    );
        
                    foreach($ListaHerramientas  as $herramienta)
                    {
                        $IdDetalle = Cnth_Plantillas_DetalleModel::max('id_plantilla_detalle') + 1;
        
                        Cnth_Plantillas_DetalleModel::create(
                            [
                                'id_plantilla_detalle' => $IdDetalle,
                                'id_plantilla' =>$IdPlantilla,
                                'id_herramienta' => $herramienta->id_herramienta,
                                'cantidad' => $herramienta->cantidad
                            ]
                        );
                    }   
                                
             });
        }
        catch(Exception $ex)
            {
                return back()->withError('Ocurrio Un Error al Crear la Plantilla: '.$ex->getMessage())->withInput();
            }
        
        return redirect('plantillas')->withSuccess('La Plantilla Ha Sido Creada Exitosamente');        
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdPlantilla)
    {
        $plantilla = Cnth_PlantillasModel::find($IdPlantilla);
        $herramientas = Cnth_Plantillas_DetalleModel::HerramientasPlantilla($IdPlantilla);
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);

        return view('ControlHerramientas.Plantillas.PlantillasEdit', compact('plantilla', 'herramientas','almacenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CnthPlantillasUpdateRequest $request, $IdPlantilla)
    {
        //dd($request->all());
        $plantilla = Cnth_PlantillasModel::find($IdPlantilla);
        
        try
        {
            $plantilla->fill([
                'nombre_plantilla' => strtoupper($request['nombre_plantilla']),
                'descripcion_plantilla' => strtoupper($request['descripcion_plantilla']),
            ]);  
                
            $herramientas =  json_decode($request['datosmovimiento']); 
            
            if($herramientas  == NULL) //Valida que el arreglo de las herramientas no este vacio
            {
                return back()->withErrors(['datosmovimiento'=> 'Para editar una plantilla debe seleccionar uno o varias herramientas'])->withInput();
            }
            
            DB::transaction(function () use ($plantilla, $herramientas, $IdPlantilla) {
                $plantilla->save();

                if ($herramientas != NULL)  //verifica si el arreglo no esta vacio
                {
                    foreach ($herramientas as $herramienta) {

                        if($herramienta->id_plantilla_detalle == '')
                        {
                              $IdDetalle = Cnth_Plantillas_DetalleModel::max('id_plantilla_detalle') + 1;
                        }
                        else
                            {   
                                $IdDetalle = $herramienta->id_plantilla_detalle;
                            }
                      
                        Cnth_Plantillas_DetalleModel::updateOrCreate(
                            [
                                'id_plantilla_detalle' => $IdDetalle,
                                'id_plantilla' => $IdPlantilla,     
                            ],
                            [
                                'id_plantilla_detalle' => $IdDetalle,
                                'id_plantilla' => $IdPlantilla,     
                                'id_herramienta' => $herramienta->id_herramienta,
                                'cantidad' => $herramienta->cantidad,
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

        return back()->withSuccess('La Plantilla Ha Sido Actualizada Exitosamente'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdPlantilla)
    {
        try
        {
            //Eliminar Herramientas de Plantilla
            Cnth_Plantillas_DetalleModel::where('id_plantilla', '=', $IdPlantilla)->delete(); 
            
            //Eliminar Plantilla
            Cnth_PlantillasModel::destroy($IdPlantilla);
        }
        catch (Exception $ex)
            {
                return back()->withError('Error Al Eliminar la Plantilla '.$ex->getMessage());
            }

        return redirect()->route('plantillas.index')->withSuccess('La Plantilla Ha Sido Eliminada Exitosamente');
    }

    public function EliminarHerramienta($IdPlantillaDetalle)
    {
        try
        {
            Cnth_Plantillas_DetalleModel::destroy($IdPlantillaDetalle);
        }
        catch (Exception $e)
            {
                return back()->withError('Error Al Eliminar');
            }

        return back()->with('');
    }

    public function PlantillasAlmacen($IdAlmacen)
    {
        $plantillas = Cnth_PlantillasModel::where('id_almacen', $IdAlmacen)->get();
        return with(["plantillas" => $plantillas]);
    }

    public function HerramientasPlantilla($IdPlantilla)
    {
        $herramientas = Cnth_Plantillas_DetalleModel::HerramientasPlantilla($IdPlantilla);
        return with(["herramientas" => $herramientas]);
    }
}
