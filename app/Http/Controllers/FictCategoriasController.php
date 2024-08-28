<?php

namespace App\Http\Controllers;

use App\Models\CategoriasModel;
use App\Models\EmpresasModel;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriasCreateRequest;
use App\Http\Requests\CategoriasUpdateRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use Exception;
use Redirect;
use Session;


class FictCategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = CategoriasModel::all();
        return view('FichaTecnica.Categorias.Categorias', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('FichaTecnica.Categorias.CategoriasCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriasCreateRequest $request)
    {   
        $IdCategoria = CategoriasModel::max('id_categoria') + 1;   
        $Categoria = new CategoriasModel();
          
        try
        {   
            $Categoria->id_categoria = $IdCategoria;
            $Categoria->nombre_categoria = strtoupper($request['nombre_categoria']);
            $Categoria->descripcion_categoria = strtoupper($request['descripcion_categoria']);
            $Categoria->codigo_categoria = $request['codigo_categoria'];
            $Categoria->creado_por = Auth::user()->name;
            $Categoria->actualizado_por = null;

            $Categoria->save();
        }
        catch(Exception $ex)
        {
            return redirect("categorias")->withError('Ha Ocurrido Un Error al Crear Categoria ' .$ex->getMessage());
        }
        
        try
        {
            $empresas = EmpresasModel::all();

            foreach ($empresas as $empresa )
            {
                DB::connection('profit')
                ->table($empresa->base_datos.'.dbo.cat_art')
                ->insert([
                    'co_cat' =>  strtoupper($request['codigo_categoria']),
                    'cat_des' => strtoupper($request['nombre_categoria']),
                    'co_us_in' => '001',
                    'co_sucu' => '000001'
                    ]);
            }
        }
        catch(Exception $ex)
            {
                return redirect("categorias")->withError('Ha Ocurrido Un Error al Crear Categoria En Profit ' .$ex->getMessage());
            }
            
       
        return redirect("categorias")->withSuccess('La Categoria Ha Sido Creado Exitosamente');
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
    public function edit($id_categoria)
    {
        $categoria = CategoriasModel::find($id_categoria);
        return view('FichaTecnica.Categorias.CategoriasEdit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriasUpdateRequest $request, $id)
    {

        $categoria = CategoriasModel::find($id);
        $categoria->fill([
            'nombre_categoria' => strtoupper($request['nombre_categoria']),
            'descripcion_categoria' => strtoupper($request['descripcion_categoria']),
            'codigo_categoria' => $request['codigo_categoria'],
            'actualizado_por' => Auth::user()->name

        ]);

            try
            {
                $categoria->save();

                $empresas = EmpresasModel::all();

                    foreach ($empresas as $empresa )
                    {
                        DB::connection('profit')
                        ->table($empresa->base_datos.'.dbo.cat_art')
                        ->where( 'co_cat', $request['codigo_categoria'])
                        ->update([
                            'cat_des' => strtoupper($request['nombre_categoria']),
                            'co_us_in' => '001',
                            'co_sucu' => '000001'
                            ]);
                    }
            } 
            catch (Exception $ex) {
                return redirect("categorias")->withError('Ha Ocurrido Un Error Al Actualizar La Categoria '.$ex->getMessage());
            }

    return redirect("categorias")->withSuccess('La Categoria se ha Actualizado Exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_categoria)
    {
        try
        {
            $categoria = CategoriasModel::find($id_categoria);

            CategoriasModel::destroy($id_categoria);
            $empresas = EmpresasModel::all();

            foreach ($empresas as $empresa )
            {
                DB::connection('profit')
                ->table($empresa->base_datos.'.dbo.cat_art')
                ->where( 'co_cat', $categoria->codigo_categoria)
                ->delete();
            }


        }
        catch(Exception $ex)
        {
            return redirect("categorias")->withError('No se puede eliminar la categoria, porque tiene articulos asociados');
        }
        
    return redirect("categorias")->withSuccess('La Categoria Ha Sido Eliminado Exitosamente');

    }

    public function migrate()
    {
        $categorias = CategoriasModel::all();
        $empresas = EmpresasModel::all();

        foreach ($empresas as $empresa ) {
            foreach($categorias as $categoria){

                DB::connection('profit')
                ->table($empresa->base_datos.'.dbo.cat_art')
                ->updateOrInsert(
                    ['co_cat' =>  $categoria->codigo_categoria],
                    [
                    'cat_des' => $categoria->nombre_categoria,
                    'co_us_in' => '001',
                    'co_sucu' => '000001'
                    ]);
            }
        }

        return redirect("categorias")->withSuccess('Las Categorias Han Sido Actualizados en Profit');

    }
}
