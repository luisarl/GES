<?php

namespace App\Http\Controllers;

use App\Models\Resg_ClasificacionesModel;
use App\Models\Resg_ResguardoModel;
use App\Models\Resg_UbicacionesModel;
use Exception;
use Illuminate\Http\Request;

class ResgResguardosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articulos = Resg_ResguardoModel::ArticulosResguardo(); 
        return view('Resguardo.Resguardos.Resguardos', compact('articulos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdResguardo)
    {
        $resguardo = Resg_ResguardoModel::VerArticuloResguardo($IdResguardo);
        $historicos = Resg_ResguardoModel::HistoricoResguardo($IdResguardo);

        //dd($historicos);
        return view('Resguardo.Resguardos.ResguardosShow', compact('resguardo', 'historicos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdResguardo)
    {
        $resguardo = Resg_ResguardoModel::VerArticuloResguardo($IdResguardo);
        $ubicaciones = Resg_UbicacionesModel::select('id_ubicacion', 'nombre_ubicacion')->where('id_almacen', '=', $resguardo->id_almacen )->get();
        $clasificaciones = Resg_ClasificacionesModel::select('id_clasificacion', 'nombre_clasificacion')->get();
        return view('Resguardo.Resguardos.ResguardosEdit', compact('resguardo', 'ubicaciones', 'clasificaciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdResgaurdo)
    {
        try
        {
            $resguardo = Resg_ResguardoModel::find($IdResgaurdo);
            $resguardo->fill([
                'id_ubicacion' => $request['id_ubicacion'],
                'id_clasificacion' => $request['id_clasificacion']
            ]);
            $resguardo->save();
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar El Resguardo. '.$ex->getMessage())->withInput();
            }
            
        return redirect()->back()->withSuccess('El Resguardo Fue Editado Exitosamente.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
