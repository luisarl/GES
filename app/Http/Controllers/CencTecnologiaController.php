<?php

namespace App\Http\Controllers;

use App\Http\Requests\CencTecnologiaCreateRequest;
use App\Models\Cenc_TecnologiaModel;
use Exception;

class CencTecnologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tecnologias = Cenc_TecnologiaModel::ListaTecnologias();
        return view('CentroCorte.Tecnologia.Tecnologia', compact('tecnologias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('CentroCorte.Tecnologia.TecnologiaCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CencTecnologiaCreateRequest $request)
    {
        $tecnologias = Cenc_TecnologiaModel::ListaTecnologias();

        try 
        {
            $IdTecnologia = Cenc_TecnologiaModel::max('id_tecnologia') + 1; 
            Cenc_TecnologiaModel::create([
                    
                'id_tecnologia' => $IdTecnologia,
                'nombre_tecnologia' => strtoupper($request['nombre_tecnologia']),
                'descripcion_tecnologia' => strtoupper($request['descripcion_tecnologia'])

            ]);

            return redirect("cenctecnologia")->withSuccess('La Tecnologia Ha Sido Creado Exitosamente');
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Crear La Tecnologia: '.$ex->getMessage())->withInput();
            }
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
    public function edit($IdTecnologia)
    {
        $tecnologia = Cenc_TecnologiaModel::find($IdTecnologia);
        return view('CentroCorte.Tecnologia.TecnologiaEdit', compact('tecnologia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CencTecnologiaCreateRequest $request, $IdTecnologia)
    {
        $tecnologia = Cenc_TecnologiaModel::find($IdTecnologia);

        try 
        {
            $tecnologia->fill([
                    
                'id_tecnologia' => $IdTecnologia,
                'nombre_tecnologia' => strtoupper($request['nombre_tecnologia']),
                'descripcion_tecnologia' => strtoupper($request['descripcion_tecnologia'])

            ]);
            $tecnologia->save();

            return redirect()->route('cenctecnologia.index')->withSuccess('El Servicio Ha Sido Actualizado Exitosamente'); 
        } 
        catch (Exception $ex) 
            {
                return back()->withError('Ha Ocurrido Un Error Al Actualizar La Tecnologia: '.$ex->getMessage())->withInput();
            }
            
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdTecnologia)
    {
        try 
        {
            Cenc_TecnologiaModel::destroy($IdTecnologia);
        } 
        catch (Exception $ex) 
        {
            return back()->withError('Ha Ocurrido Un Error Al Eliminar La Tecnologia: '.$ex->getMessage())->withInput();
        }

       return redirect('cenctecnologia')->withSuccess('La Tecnologia Ha Sido Eliminado Exitosamente');  
    }
}
