<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CencEquiposCreateRequest;
use App\Models\Cenc_EquiposModel;
use App\Models\Cenc_TecnologiaModel;
use App\Models\Cenc_EquiposTecnologiaModel;
use App\Models\Cenc_ConsumiblesModel; 
use App\Models\Cenc_EquiposConsumiblesModel;
use App\Models\Cenc_TablasConsumoModel;
use Exception;

class CencEquiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipos = Cenc_EquiposModel::ListaEquipos();
        $tecnologias = Cenc_EquiposModel::ListaTecnologiaAsociada(); 

        return view('CentroCorte.Equipos.Equipos', compact('equipos', 'tecnologias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tecnologias = Cenc_TecnologiaModel::select('id_tecnologia', 'nombre_tecnologia')->get();
        return view('CentroCorte.Equipos.EquiposCreate', compact('tecnologias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CencEquiposCreateRequest $request)
    {

        try 
        {

            $idTecnologias = $request['id_tecnologia'];
            $IdEquipo = Cenc_EquiposModel::max('id_equipo') + 1;
                
            Cenc_EquiposModel::create([
                'id_equipo' => $IdEquipo,
                'nombre_equipo' => strtoupper($request['nombre_equipo']),
                'descripcion_equipo' => strtoupper($request['descripcion_equipo'])
            ]);


            foreach ($idTecnologias as $idTecnologia) 
            {
                $IdEquipoTecnologia = Cenc_EquiposTecnologiaModel::max('id_equipotecnologia') + 1;
                Cenc_EquiposTecnologiaModel::create([
                    'id_equipotecnologia' => $IdEquipoTecnologia,
                    'id_equipo' => $IdEquipo,
                    'id_tecnologia' => $idTecnologia
                ]);
            }

        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Crear El Equipo: '.$ex->getMessage())->withInput();
            }
            
    return redirect("cencequipos")->withSuccess('El Equipo Ha Sido Creado Exitosamente');
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
    public function edit($IdEquipo)
    {
        $equipo = Cenc_EquiposModel::find($IdEquipo);
        $tecnologias = Cenc_EquiposModel::ListaEquiposEdit($IdEquipo); 
        $opciones = Cenc_ConsumiblesModel::ListaConsumibles();
        $tecnos = Cenc_EquiposTecnologiaModel::TecnologiaSinEquipo($IdEquipo); // envia las tecnologias que no estan asociadas al equipo
        $consumibles = Cenc_EquiposModel::ConsumiblesEquipo($IdEquipo);
        return view('CentroCorte.Equipos.EquiposEdit', compact('equipo','tecnologias', 'tecnos','opciones','consumibles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CencEquiposCreateRequest $request, $IdEquipo)
    {
        $parametros = json_decode($request->caracteristicas); //arreglo de datos adicionales
        $equipo = Cenc_EquiposModel::find($IdEquipo);
        $idTecnologias = $request['id_tecnologia'];


        try 
        {
            $equipo->fill([
                    
                'id_equipo' => $IdEquipo,
                'nombre_equipo' => strtoupper($request['nombre_equipo']),
                'descripcion_equipo' => strtoupper($request['descripcion_equipo'])
            ]);

            if($idTecnologias !=null)
            {
                foreach ($idTecnologias as $idTecnologia) 
                {
                    $IdEquipoTecnologia = Cenc_EquiposTecnologiaModel::max('id_equipotecnologia') + 1;
                    Cenc_EquiposTecnologiaModel::create([
                        'id_equipotecnologia' => $IdEquipoTecnologia,
                        'id_equipo' => $IdEquipo,
                        'id_tecnologia' => $idTecnologia
                    ]);
                }    
            }
            $equipo->save();

            //REGISTRO EN cenc_equipos_consumibles 
            foreach($parametros as $parametro)
            {
                $IdEquipoTecnologia = Cenc_EquiposTecnologiaModel::idEquipoTecnologia($IdEquipo,(int)$parametro->idtecnologia); 
                $IdEquipoConsumible = Cenc_EquiposConsumiblesModel::max('id_equipo_consumible') + 1; 
                Cenc_EquiposConsumiblesModel::create([
                    'id_equipo_consumible' => $IdEquipoConsumible,
                    'id_consumible'=>(int)$parametro->idconsumible,
                    'id_equipotecnologia'=>(int)$IdEquipoTecnologia
                ]);
            }
                
            

        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Actualizar El Equipo: '.$ex->getMessage())->withInput();
            }
            
        return redirect("cencequipos")->withSuccess('El Equipo Ha Sido Actualizado Exitosamente');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdEquipo)
    {
        $valores = Cenc_EquiposTecnologiaModel::obtenerId($IdEquipo); 
 
        try 
        {
            foreach($valores as $valor)
            {
                Cenc_EquiposTecnologiaModel::destroy($valor->id_equipotecnologia); 
            }
            
            Cenc_EquiposModel::destroy($IdEquipo);
        } 
        catch (Exception $ex) 
        {
            return back()->withError('Ha Ocurrido Un Error Al Eliminar El Equipo: '.$ex->getMessage())->withInput();
        }

       return redirect('cencequipos')->withSuccess('El Equipo Ha Sido Eliminado Exitosamente'); 
    }


    public function EliminarTecnologias(Request $request, $id_tecnologia)
    {
        $equipo = $request->input('equipo');
        $equipoParts = explode('/', $equipo);
        $id_tecnologia = $equipoParts[0];
        $equipoId = $equipoParts[1];

        try {
            Cenc_EquiposTecnologiaModel::destroy2($id_tecnologia, $equipoId);
        } catch (Exception $e) {
            return redirect("cencequipos")->withError('No se puede eliminar la tecnologia');
        }
    
        return redirect()->back()->withSuccess('La Tecnologia Ha Sido Eliminada Exitosamente');
    }

    
}
