<?php

namespace App\Http\Controllers;
use App\Models\Emba_EmbarcacionesModel;
use Illuminate\Http\Request;
use Exception;
class EmbaEmbarcacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $embarcaciones = Emba_EmbarcacionesModel::all();
        return view('Embarcaciones.Embarcaciones.Embarcaciones',compact('embarcaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Embarcaciones.Embarcaciones.EmbarcacionesCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $IdEmbarcaciones = Emba_EmbarcacionesModel::max('id_embarcaciones') + 1;

        try 
        {
            Emba_EmbarcacionesModel::create([
                'id_embarcaciones' =>  $IdEmbarcaciones,
                'nombre_embarcaciones' => strtoupper($request['nombre_embarcacion']),
                'descripcion' => strtoupper($request['descripcion']),
              
            ]);
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Embarcacion. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embaembarcaciones.index')->withSuccess('La Embarcacion Ha Sido Creado Exitosamente.');
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
    public function edit($IdEmbarcaciones)
    {
        $embarcacion = Emba_EmbarcacionesModel::find($IdEmbarcaciones);
        return view('Embarcaciones.Embarcaciones.EmbarcacionesEdit', compact('embarcacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdEmbarcaciones)
    {
        try 
        {
            $embarcacion= Emba_EmbarcacionesModel::find($IdEmbarcaciones);
            $embarcacion->fill([
                'nombre_embarcaciones' => strtoupper($request['nombre_embarcacion']),
                'descripcion' => strtoupper($request['descripcion']),
               
            ]);
            $embarcacion->save();
        } 
        catch (Exception $ex) 
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Embarcacion. '.$ex->getMessage())->withInput();
            }

        return redirect()->route('embaembarcaciones.edit',$IdEmbarcaciones)->withSuccess('La Embarcacion Ha Sido Editada Exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdEmbarcaciones)
    {
        try
        {
            Emba_EmbarcacionesModel::destroy($IdEmbarcaciones);
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Eliminar La Embarcacion. '.$ex->getMessage())->withInput();
            }
        
        return redirect()->route('embaembarcaciones.index')->withSuccess('La Embarcacion Ha Sido Eliminada Exitosamente.');    
    }
}
