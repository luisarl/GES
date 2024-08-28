<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UsuariosCorreosCreateRequest;
use App\Http\Requests\UsuariosCorreosUpdateRequest;
use App\Http\Requests\UsuariosUpdateRequest;
use App\Models\Usuarios_CorreosModel;
use App\Models\User;
use DB;
use Auth;
use Mail;
use Exception;
use Redirect;
use Session;



class UsuariosCorreosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $correos = Usuarios_CorreosModel::UsuariosCorreos();
        return view('Usuarios.UsuariosCorreos.UsuariosCorreos', compact( 'correos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = User::select('id', 'name')->get();
        $correos = Usuarios_CorreosModel::All();
        return view('Usuarios.UsuariosCorreos.UsuariosCorreosCreate', compact('usuarios', 'correos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuariosCorreosCreateRequest $request)
    {
        $IdCorreosUsuarios = Usuarios_CorreosModel::max('id_correos') + 1; // Id del Correos a Crear
        try{
            Usuarios_CorreosModel::create([
                'id_correos' => $IdCorreosUsuarios,
                'proceso' => strtoupper($request['proceso']),
                'correo_destinatario' => $request['correo_destinatario'],
                'nombre_destinatario' => $request['nombre_destinatario'],
                'id_usuario' => $request['id_usuario'],
            ]);
            return redirect("usuarioscorreos")->withSuccess('El Correo fue Asignado Exitosamente'); 
        }catch(Exception $ex){
            return redirect("usuarioscorreos")->withError('No se puede Asigar el Correo correctamente');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
         $correos = Usuarios_CorreosModel::all();
         //dd($correos);
         return view('Usuarios.UsuariosCorreos.UsuariosCorreos', compact( 'correos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_correos)
    {
        $correo = Usuarios_CorreosModel::find($id_correos);
        $usuarios = User::select('id', 'name')->get();
        return view('Usuarios.UsuariosCorreos.UsuariosCorreosEdit', compact( 'correo', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuariosCorreosUpdateRequest $request, $id_correos)
    {
        try{
            $correo = Usuarios_CorreosModel::find($id_correos);
            $correo->fill([
                'proceso' => strtoupper($request['proceso']),
                'correo_destinatario' => $request['correo_destinatario'],
                'nombre_destinatario' => $request['nombre_destinatario'],
                'id_usuario' => $request['id_usuario'],
            ]);
            return redirect("usuarioscorreos")->withSuccess('El Usuario se ha Actualizado Exitosamente');
        }catch(Exception $ex){
            return redirect("usuarioscorreos")->withError('No se pudo actualizar el Correo correctamente', $ex->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_correos)
    {
        $correos = Usuarios_CorreosModel::destroy($id_correos);
        return redirect("usuarioscorreos")->withSuccess('El correo asignado se ha Sido Eliminado Exitosamente');
    }

}
