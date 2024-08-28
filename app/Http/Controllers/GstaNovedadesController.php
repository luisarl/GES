<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gsta_AsistenciaModel;
use App\Models\Gsta_NovedadesModel;
use App\Models\DepartamentosModel;
use App\Http\Requests\GstaNovedadesCreateRequest;
use App\Http\Requests\GstaNovedadesUpdateRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GstaNovedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $novedades= Gsta_NovedadesModel::all();
        return view('GestionAsistencia.Novedades.Novedad', compact('novedades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('GestionAsistencia.Novedades.NovedadCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GstaNovedadesCreateRequest $request)
    {
        try
        {
            $IdNovedad =  Gsta_NovedadesModel::max('id_novedad') + 1;
                Gsta_NovedadesModel::create([
                   'id_novedad'=>$IdNovedad,
                   'descripcion'=>strtoupper($request['descripcion']),
                ]);
        }
        catch(Exception $ex)
         {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Crear La Novedad'.$ex->getMessage())->withInput();
         }
       
        return redirect()->route("gstanovedades.index")->withSuccess("La Novedad Ha Sido Creada Exitosamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdNovedad)
    {
        $novedades = Gsta_NovedadesModel::VerNovedades($IdNovedad);    
        return view('GestionAsistencia.Novedades.NovedadShow', compact('novedades'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdNovedad)
    {
         $novedades=Gsta_NovedadesModel::find($IdNovedad);
       
        return view('GestionAsistencia.Novedades.NovedadEdit', compact('novedades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GstaNovedadesUpdateRequest $request, $IdNovedad)
    {
        try
        {
            $novedades= Gsta_NovedadesModel::find($IdNovedad);
            $novedades->fill([
                'descripcion'=>strtoupper($request['descripcion']),
            ]);
            $novedades->save();
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Novedad'.$ex->getMessage())->withInput();  
            }
        return redirect()->route("gstanovedades.index")->withSuccess("La Novedad Ha Sido Editada Exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdNovedad)
    {
        try
        {
            Gsta_NovedadesModel::destroy($IdNovedad);
        }
        catch (Exception $ex)
            {
                return back()->withError('Error Al Eliminar');
            }
        return redirect()->route("gstanovedades.index")->withSuccess("La Novedad Ha Sido Eliminada Exitosamente");
    }
}
