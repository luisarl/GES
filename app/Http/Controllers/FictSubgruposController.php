<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GruposModel;
use App\Models\SubgruposModel;
use App\Models\AlmacenesModel;
use App\Http\Requests\SubgruposCreateRequest;
use App\Http\Requests\SubgruposUpdateRequest;
use App\Models\EmpresasModel;
use DB;
use Exception;
use Redirect;
use Session;


class FictSubgruposController extends Controller
{

     /***
    public function __construct()
     {
         $this->middleware('can:fichatecnica.subgrupos')->only('create', 'store', 'edit');
     }
     ***/

    public function index()
    {

        $subgrupos = SubgruposModel::with('grupo')->get();
        //dd($subgrupos);
        return view('FichaTecnica.Subgrupos.Subgrupos', compact('subgrupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $grupos = GruposModel::select('id_grupo', 'nombre_grupo', 'codigo_grupo')->get();
        return view('FichaTecnica.Subgrupos.SubgruposCreate', compact('grupos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubgruposCreateRequest $request)
    {
        $IdSubgrupo = SubgruposModel::max('id_subgrupo') + 1; // ID Del Subgrupo
        
        $Subgrupo = new SubgruposModel();
        try
        {
            $Subgrupo->id_subgrupo = $IdSubgrupo;
            $Subgrupo->nombre_subgrupo = strtoupper($request['nombre_subgrupo']);
            $Subgrupo->descripcion_subgrupo = strtoupper($request['descripcion_subgrupo']);
            $Subgrupo->codigo_subgrupo = $request['codigo_subgrupo'];
            $Subgrupo->id_grupo = $request['id_grupo'];
            $Subgrupo->creado_por = Auth::user()->name;
            $Subgrupo->actualizado_por = null;

            $Subgrupo->save();
        }
        catch(Exception $ex)
            {
                return redirect("subgrupos")->withError('Ha Ocurrido Un Error al Crear El Subgrupo '.$ex->getMessage());
            }
        
        try
        {
            $grupo = GruposModel::select('codigo_grupo')->where('id_grupo', $request['id_grupo'])->first();

            $empresas = EmpresasModel::all();

            foreach ($empresas as $empresa )
            {
                DB::connection('profit')
                    ->table($empresa->base_datos.'.dbo.sub_lin')
                    ->insert([
                        'co_subl' =>  $request['codigo_subgrupo'],
                        'subl_des' => strtoupper($request['nombre_subgrupo']),
                        'co_lin' => $grupo->codigo_grupo,
                        'co_us_in' => '001',
                        'co_sucu' => '000001'
                        ]);
            }
        }
        catch(Exception $ex)
            {
                return redirect("subgrupos")->withError('Ha Ocurrido Un Error al Crear El Subgrupo En Profit '.$ex->getMessage());
            }    
       
      return redirect("subgrupos")->withSuccess('El Subgrupo Ha Sido Creado Exitosamente');
      
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


    public function edit($id_subgrupo)
    {
        $grupos = GruposModel::select('id_grupo', 'nombre_grupo', 'codigo_grupo')->get();
        $subgrupo = SubgruposModel::find($id_subgrupo);
        return view('FichaTecnica.Subgrupos.SubgruposEdit', compact('subgrupo', 'grupos'));
    }

    public function update(SubgruposUpdateRequest $request, $id_subgrupo)
    {
        $subgrupo = SubgruposModel::find($id_subgrupo);
        $subgrupo->fill([
            'nombre_subgrupo' => strtoupper($request['nombre_subgrupo']),
            'descripcion_subgrupo' => strtoupper($request['descripcion_subgrupo']),
            'codigo_subgrupo' => $request['codigo_subgrupo'],
            'id_grupo' => $request['id_grupo'],
            'actualizado_por' => Auth::user()->name

        ]);

        try{
            $subgrupo->save();

            $grupo = GruposModel::select('codigo_grupo')->where('id_grupo', $request['id_grupo'])->first();

            $empresas = EmpresasModel::all();

            foreach ($empresas as $empresa )
            {
                DB::connection('profit')
                    ->table($empresa->base_datos.'.dbo.sub_lin')
                    ->where('co_subl',  $request['codigo_subgrupo'] )
                    ->update([
                        'subl_des' => strtoupper($request['nombre_subgrupo']),
                        'co_lin' => $grupo->codigo_grupo,
                        'co_us_in' => '001',
                        'co_sucu' => '000001'
                        ]);
            }

        }
        catch(Exception $ex)
        {
            return redirect("subgrupos")->withError('Ha Ocurrido Un Error Al Actualizar El Subgrupo '.$ex->getMessage());
        }

        return redirect("subgrupos")->withSuccess('El Grupo Ha Sido Actualizado Exitosamente');
    }


    public function destroy($id_subgrupo)
    {
        try
        {
            $subgrupo = SubgruposModel::find($id_subgrupo);

            SubgruposModel::destroy($id_subgrupo);

            $empresas = EmpresasModel::all();

            foreach ($empresas as $empresa )
            {
                DB::connection('profit')
                    ->table($empresa->base_datos.'.dbo.sub_lin')
                    ->where('co_subl',  $subgrupo->codigo_subgrupo)
                    ->delete();
            }

        }
        catch (Exception $ex)
        {
            return redirect("subgrupos")->withError('No se puede eliminar el sub grupo, porque tiene articulos asociados');
        }
      return redirect("subgrupos")->withSuccess('El Sub Grupo Ha Sido Eliminado Exitosamente');
    }

    public function codigoSubGrupo(Request $request)
    {
        $subgrupos = SubgruposModel::where('id_grupo', '=', $request->id)->get();
        return with(["subgrupos" => $subgrupos]);
    }

    public function migrate()
    {
        $subgrupos = SubgruposModel::DetalleSubgrupos();
        $empresas = EmpresasModel::all();

        foreach ($empresas as $empresa ) {
            foreach($subgrupos as $subgrupo){

                DB::connection('profit')
                ->table($empresa->base_datos.'.dbo.sub_lin')
                ->updateOrInsert(
                    ['co_subl' =>  $subgrupo->codigo_subgrupo],
                    [
                    'subl_des' => $subgrupo->nombre_subgrupo,
                    'co_lin' => $subgrupo->codigo_grupo,
                    'co_us_in' => '001',
                    'co_sucu' => '000001'
                    ]);
            }
        }

        return redirect("subgrupos")->withSuccess('Los SubGrupos Han Sido Actualizados en Profit');

    }
}
