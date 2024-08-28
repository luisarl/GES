<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerfilesModel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Exception;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfiles = Role::all();
        return view('Configuracion.Usuarios.Perfiles.Perfiles', compact('perfiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permisos = Permission::select('id', 'name')->orderBy('name')->get();
        return view('Configuracion.Usuarios.Perfiles.PerfilesCreate', compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $role = Role::create($request->only('name')); //creacion de Roles
            $role->syncPermissions($request->input('permisos', [])); //asignacion de los permisos a los roles
        } 
        catch (Exception $ex) 
            {
                return redirect("perfiles")->withError('Ha Ocurido Un Error Al Crear El Perfil'.$ex->getMessage());
            }

        return redirect("perfiles")->withSuccess('El Perfil Ha Sido Creado Exitosamente');
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
        $role = Role::with('permissions')->find($id); //consulta de permisos en el modelo de roles
        $permisos = Permission::select('id', 'name')->orderBy('name')->get();

        return view('Configuracion.Usuarios.Perfiles.PerfilesEdit', compact('role', 'permisos'));
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
        $roles = Role::find($id);

        try
        {
            $roles->update($request->only('name')); // actualizacion de roles
            $roles->syncPermissions($request->input('permisos', [])); //sincronizacion de los permisos en los roles

            $roles->save();
        }
        catch (Exception $ex) 
            {
                return redirect("perfiles")->withError('Ha Ocurrido Un Error Al Actualizar El Perfil'.$ex->getMessage());
            }

        return redirect("perfiles")->withSuccess('El Perfil Se Ha Actualizado Exitosamente');
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
            Role::destroy($id);
        } 
        catch (Exception $ex) 
            {
                return redirect("perfiles")->withError('No Se Puede Eliminar El Perfil Tiene Permisos y Usuarios asociados');
            }
        
        return redirect("perfiles")->withSuccess('El Perfil Ha Sido Eliminado Exitosamente');
    }
}
