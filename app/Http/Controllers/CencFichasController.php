<?php

namespace App\Http\Controllers;


use App\Models\Cenc_FichasCaracteristicasValoresModel;
use App\Models\Cenc_FichasModel;
use App\Models\Cenc_FichasTiposModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CencFichasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fichas = Cenc_FichasModel::ListaFichas();

        return view('CentroCorte.FichaTecnica.Fichas.Fichas', compact('fichas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = Cenc_FichasTiposModel::select('id_tipo', 'nombre_tipo')->get();
        return view('CentroCorte.FichaTecnica.Fichas.FichasCreate', compact('tipos'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

         $IdFicha = Cenc_FichasModel::max('id_ficha') + 1;
         $ficha = new Cenc_FichasModel();

        try 
        {
            $ficha->id_ficha = $IdFicha;
            $ficha->nombre_ficha = strtoupper($request['nombre_ficha']);
            $ficha->descripcion_ficha = strtoupper($request['descripcion_ficha']);
            $ficha->id_tipo = $request['id_tipo'];
            
            $caracteristicas = json_decode($request['caracteristicas']); //arreglo de datos adicionales
            
            if ($caracteristicas  == NULL) //Valida que el arreglo de las adicionales no este vacio
            {
                return back()->withErrors(['caracteristicas' => 'Debe Agregar Las Caracteristicas de las fichas'])->withInput();
            }

            DB::transaction(function () use ($IdFicha, $ficha, $caracteristicas)
            {

                $ficha->save(); 
                
                if ($caracteristicas != "")  
                {
                    foreach($caracteristicas  as $caracteristica )
                    {
                        
                        $IdFichaCaracteristica = Cenc_FichasCaracteristicasValoresModel::max('id_ficha_valor') + 1;
                        //Inserta datos de la tabla 
                        Cenc_FichasCaracteristicasValoresModel::create([
                            'id_ficha_valor' =>  $IdFichaCaracteristica,
                            'id_ficha' => $IdFicha,
                            'id_tipo' => $ficha->id_tipo,
                            'id_caracteristica' => $caracteristica->id_caracteristica,
                            'valor_caracteristica' => $caracteristica->valor_caracteristica,
                        ]);
                    }
                }

            });

        }
        catch(Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear El ficha '.$ex->getMessage())->withInput();
        }
        
        return redirect("cencfichas")->withSuccess('El ficha Ha Sido Creado Exitosamente');
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
    public function edit($IdFicha)
    {
        $ficha = Cenc_FichasModel::find($IdFicha);
        $caracteristicas = Cenc_FichasCaracteristicasValoresModel::ListaValores($IdFicha);
        $tipos = Cenc_FichasModel::obtenerNombre($ficha->id_ficha); 
        return view('CentroCorte.FichaTecnica.Fichas.FichasEdit', compact('ficha','caracteristicas','tipos')); 
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Idficha)
    {

        try 
        {
            $ficha = Cenc_FichasModel::find($Idficha);
            //dd($ficha);

            $ficha->fill([
                'nombre_ficha' => strtoupper($request['nombre_ficha']),
                'descripcion_ficha' => strtoupper($request['descripcion_ficha']),
                'id_tipo2' => $request['id_tipo2'],

            ]);

            $caracteristicas = json_decode($request['caracteristicas2']); 
            
            
            if ($caracteristicas  == NULL) 
            {
                return back()->withErrors(['caracteristicas2' => 'Debe Agregar Las Caracteristicas De La Ficha'])->withInput();
            }

            DB::transaction(function () use ($Idficha, $ficha, $caracteristicas){

                $ficha->save(); 
                
                if ($caracteristicas != "")  
                {
                    foreach($caracteristicas as $caracteristica) 
                    {
                        
                        if($caracteristica->id_ficha_valor == "") //si la primera columna de la tabla esta vacia busca el maximo id de la base de datos y le suma 1
                        {
                            $IdFichaValor =Cenc_FichasCaracteristicasValoresModel::max('id_ficha_valor') + 1;
                        } 
                        else //si no captura el valor de la primera columna de la tabla
                            {
                                $IdFichaValor = $caracteristica->id_ficha_valor;
                            }

                        //Inserta datos de la tabla 
                        Cenc_FichasCaracteristicasValoresModel::updateOrCreate(
                            [ 'id_ficha_valor' => $IdFichaValor],
                            [
                                'id_ficha' => $Idficha,
                                'id_caracteristica' => $caracteristica->id_caracteristica,
                                'valor_caracteristica' => $caracteristica->valor_caracteristica,
                            ]
                        );
                    }
                }
            });
        } 
        catch (Exception $ex) 
            {
               return redirect()->back()->withError('Ha Ocurrido Un Error Al Actualizar La ficha. '.$ex->getMessage())->withInput();
            }

        return redirect("cencfichas")->withSuccess('La ficha Ha Sido Actualizada Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdFicha)
    {
        try
        {
            DB::transaction(function () use ($IdFicha)
            {
                Cenc_FichasCaracteristicasValoresModel::where('id_ficha', '=', $IdFicha)->delete(); 
                Cenc_FichasModel::destroy($IdFicha);
            });
        }
        catch(Exception $ex)
            {
                return back()->withErrors('Ha Ocurrido Un Error Al Eliminar El Activo'.$ex->getMessage());
            }

        return redirect()->route('cencfichas.index')->withSuccess('El Activo Ha Sido Eliminado Exitosamente');
    
    }

    public function EliminarCaracteristica($IdActivoCaracteristica)
    {
        try
        {
            Cenc_FichasCaracteristicasValoresModel::destroy($IdActivoCaracteristica);
        }
            catch (Exception $e)
            {
                return back()->withError('Error Al Eliminar');
            }

        return back()->with('');
    }
}
