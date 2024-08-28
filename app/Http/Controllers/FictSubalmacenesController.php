<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlmacenesModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Fict_SubalmacenesModel;
use App\Http\Requests\FictSubalmacenesCreateRequest;
use App\Http\Requests\FictSubalmacenesUpdateRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use Redirect;
use Session;


class FictSubAlmacenesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function index()
    {
        $subalmacenes = Fict_SubalmacenesModel::all();
       
        return view('Configuracion.Subalmacenes.Subalmacenes', compact('subalmacenes'));
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $almacenes = AlmacenesModel::all();
        return view('Configuracion.Subalmacenes.SubalmacenesCreate', compact('almacenes'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FictSubalmacenesCreateRequest $request)
    {
        
    $IdSubalmacen= Fict_SubalmacenesModel::max('id_subalmacen') + 1; // ID Del Subalmacen
        
    $Subalmacen = new Fict_SubalmacenesModel();
    try
    {
        $subalmacen = new Fict_SubalmacenesModel();
        $subalmacen->id_subalmacen = $IdSubalmacen;
        $subalmacen->nombre_subalmacen = strtoupper($request['nombre_subalmacen']);
        $subalmacen->descripcion_subalmacen = strtoupper($request['descripcion_subalmacen']);
        $subalmacen->codigo_subalmacen = $request['codigo_subalmacen'];
        $subalmacen->id_almacen = $request['id_almacen'];
        $subalmacen->creado_por = Auth::user()->name;
        $subalmacen->actualizado_por = null;
        $subalmacen->save();
    }
    catch(Exception $ex)
    {
        return redirect("subalmacenes")->withError('Ha Ocurrido Un Error al Crear El Subalmacen '.$ex->getMessage());
    }
 
        
   
  return redirect("subalmacenes")->withSuccess('El Subalmacen Ha Sido Actualizado Exitosamente');
    
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
    public function edit($id_subalmacen)
    {
        $almacenes = almacenesModel::select('id_almacen', 'nombre_almacen')->get();
        $subalmacen = Fict_SubalmacenesModel::find($id_subalmacen);
        return view('Configuracion.Subalmacenes.SubalmacenesEdit', compact('subalmacen', 'almacenes'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(FictSubalmacenesUpdateRequest $request, $id_subalmacen)
    {
        
        $subalmacen = Fict_SubalmacenesModel::find($id_subalmacen);
        
         
        $subalmacen->fill([
            'nombre_subalmacen' => strtoupper($request['nombre_subalmacen']),
            'descripcion_subalmacen' => strtoupper($request['descripcion_subalmacen']),
            'codigo_subalmacen' => $request['codigo_subalmacen'],
            'actualizado_por' => Auth::user()->name

        ]);

        try{
            $subalmacen->save();

            //$almacen = almacenesModel::select('codigo_almacen')->where('id_almacen', $request['id_almacen'])->first();     

        }
        catch(Exception $ex)
        {
            return redirect("subalmacenes")->withError('Ha Ocurrido Un Error Al Actualizar El Subalmacen '.$ex->getMessage());
        }

        return redirect("subalmacenes")->withSuccess('El almacen Ha Sido Actualizado Exitosamente');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_subalmacen)
    {
        try
        {
            $subalmacen = Fict_SubalmacenesModel::find($id_subalmacen);

            Fict_SubalmacenesModel::destroy($id_subalmacen);          

        }
        catch (Exception $ex)
        {
            return redirect("subalmacen")->withError('No se puede eliminar el Sub Almacen, porque tiene articulos asociados');
        }
      return redirect("subalmacenes")->withSuccess('El Sub Almacen Ha Sido Eliminado Exitosamente');
    }
}