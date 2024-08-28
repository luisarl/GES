<?php

namespace App\Http\Controllers;

use App\Models\Cnth_CategoriasModel;
use Illuminate\Http\Request;
use App\Http\Requests\CnthCategoriasCreateRequest;
use App\Http\Requests\CnthCategoriasUpdateRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use Exception;
use Redirect;
use Session;;

class CnthCategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cnthcategorias = Cnth_CategoriasModel::all();
        return view('ControlHerramientas.Categorias.Categorias', compact('cnthcategorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ControlHerramientas.Categorias.CategoriasCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CnthCategoriasCreateRequest $request)
    {
        $IdCnthCategoria = Cnth_CategoriasModel::max('id_categoria') + 1;

        try 
        {
            Cnth_CategoriasModel::create([
                'id_categoria' => $IdCnthCategoria,
                'nombre_categoria' => strtoupper($request['nombre_categoria']),
                'descripcion_categoria' => strtoupper($request['descripcion_categoria']),
                'codigo_categoria' => $request['codigo_categoria'],
                'creado_por' => Auth::user()->name,
                'actualizado_por' => null,
            ]);

        }
        catch (Exception $ex) 
        {
            return redirect("cnthcategorias")->withError('Ha Ocurrido Un Error al Crear Categoria ' . $ex->getMessage());
        }

        return redirect("cnthcategorias")->withSuccess('La Categoria Ha Sido Creado Exitosamente');
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
        $cnthcategoria = Cnth_CategoriasModel::find($id_categoria);
        return view('ControlHerramientas.Categorias.CategoriasEdit', compact('cnthcategoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CnthCategoriasUpdateRequest $request, $id_categoria)
    {

        try 
        {
            $cnthcategoria = Cnth_CategoriasModel::find($id_categoria);
            $cnthcategoria->fill([
                'nombre_categoria' => strtoupper($request['nombre_categoria']),
                'descripcion_categoria' => strtoupper($request['descripcion_categoria']),
                'codigo_categoria' => $request['codigo_categoria'],
                'actualizado_por' => Auth::user()->name

            ]);

            $cnthcategoria->save();
        }
        catch (Exception $ex) 
        {
            return redirect("cnthcategorias")->withError('Ha Ocurrido Un Error Al Actualizar La Categoria ' . $ex->getMessage());
        }

        return redirect("cnthcategorias")->withSuccess('La Categoria se ha Actualizado Exitosamente');
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
            Cnth_CategoriasModel::destroy($id_categoria);
        } 
        catch(Exception $ex) 
        {
            return redirect("cnthcategorias")->withError('No se puede eliminar la categoria, porque tiene herramientas asociados');
        }

        return redirect("cnthcategorias")->withSuccess('La Categoria Ha Sido Eliminado Exitosamente');
    }
}
