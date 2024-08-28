<?php

namespace App\Http\Controllers;

use App\Http\Requests\CencResponsablesCreateRequest;
use App\Http\Requests\CencResponsablesUpdateRequest;
use App\Models\Cenc_ResponsablesModel;
use App\Models\DepartamentosModel;    
use Exception;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CencResponsablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responsables = Cenc_ResponsablesModel::ListaResponsables();
        return view('CentroCorte.Responsables.Responsables', compact('responsables')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = DepartamentosModel::all();
        return view('CentroCorte.Responsables.ResponsablesCreate', compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CencResponsablesCreateRequest $request)
    {
        //
        try
        {
            $IdResponsable = Cenc_ResponsablesModel::max('id_responsable') + 1; // Id del responsable (responsable) a Crear
            
            Cenc_ResponsablesModel::create([
                'id_responsable' => $IdResponsable,
                'nombre_responsable' => strtoupper($request['nombre_responsable']),
                'cargo_responsable' => strtoupper($request['cargo_responsable']),
                'correo' => $request['correo'],
                'id_departamento' => $request['id_departamento'],
                'estatus' => strtoupper($request['estatus'])
    
            ]);
        }
        catch(Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error al Crear Responsable '.$ex->getMessage())->withInput();
        }
    
        return redirect("cencresponsables")->withSuccess('El Responsable Ha sido Creado Exitosamente');
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
    public function edit($IdResponsable)
    {

        $responsable = Cenc_ResponsablesModel::find($IdResponsable);

        if(Auth::user()->roles[0]->name == 'administrador')
        {
            $departamentos = DepartamentosModel::all();
        }
        else
            {
                $departamentos = DepartamentosModel::where('id_departamento', '=',  Auth::user()->id_departamento)->get();
            }

        return view('CentroCorte.Responsables.ResponsablesEdit', compact('responsable', 'departamentos')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CencResponsablesUpdateRequest $request, $IdResponsable)
    {
        try 
        {
            $responsable = Cenc_ResponsablesModel::find($IdResponsable);
            $responsable->fill([
                'nombre_responsable' => strtoupper($request['nombre_responsable']),
                'id_departamento' => $request['id_departamento'],
                'cargo_responsable' => strtoupper($request['cargo_responsable']),
                'correo' => $request['correo'],
                'estatus' => strtoupper($request['estatus'])
            ]);

            $responsable->save();
        }
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error al Editar el Responsable '.$ex->getMessage())->withInput();
        }

        return redirect("cencresponsables")->withSuccess('El Responsable Ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_responsable)
    {
        try
        {
            Cenc_ResponsablesModel::destroy($id_responsable);
        }
        catch (Exception $e)
        {
            return redirect("cencresponsables")->withError('No se puede eliminar el Responsable'); 
        }
        
        return redirect("cencresponsables")->withSuccess('El Responsable Ha Sido Eliminado Exitosamente');
    }
}
