<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerfilesModel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Exception;


class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permisos = Permission::all();
        return view('Configuracion.Usuarios.Permisos.Permisos', compact('permisos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permisos = Permission::all();
        return view('Configuracion.Usuarios.Permisos.PermisosCreate', compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Permission::create($request->only('name')); //creacion de los permisos
        return redirect()->route('permisos.index')->withSuccess('El Permiso ha sido Creado Exitosamente');

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
    public function edit($id)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            $permiso = Permission::find($id);
            Permission::destroy($id);
        } 
        catch(Exception $e) 
            {
                return redirect()->route('permisos.index')->withError('No se puede eliminar el permiso');
            }
    
         return redirect()->route('permisos.index')->withSuccess('El Permiso Ha Sido Eliminado Exitosamente');
    }
}
