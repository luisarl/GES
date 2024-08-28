<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorreosCreateRequest;
use App\Http\Requests\CorreosUpdateRequest;
use App\Models\CorreosModel;
use App\Models\User;
use Exception;

class CorreosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $correos = CorreosModel::UsuariosCorreos();
        return view('Configuracion.Correos.Correos', compact( 'correos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $usuarios = User::select('id', 'name')->get();
        $correos = CorreosModel::All();
        return view('Configuracion.Correos.CorreosCreate', compact('usuarios', 'correos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorreosCreateRequest $request)
    {
        $IdCorreo = CorreosModel::max('id_correo') + 1; // Id del Correos a Crear
        try
        {
            CorreosModel::create([
                'id_correo' => $IdCorreo,
                'modulo' => strtoupper($request['modulo']),
                'proceso' => strtoupper($request['proceso']),
                'correo_destinatario' => $request['correo_destinatario'],
                'nombre_destinatario' => $request['nombre_destinatario'],
                'id_usuario' => $request['id_usuario'],
            ]);
            return redirect("correos")->withSuccess('El Correo fue Asignado Exitosamente'); 
        }catch(Exception $ex){
            return redirect("correos")->withError('No se puede Asigar el Correo correctamente');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_correo)
    {
        $correo = CorreosModel::find($id_correo);
        $usuarios = User::select('id', 'name')->get();
        return view('Configuracion.Correos.CorreosEdit', compact( 'correo', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CorreosUpdateRequest $request, $id_correo)
    {
        try{
            $correo = CorreosModel::find($id_correo);
            $correo->fill([
                'modulo' => strtoupper($request['modulo']),
                'proceso' => strtoupper($request['proceso']),
                'correo_destinatario' => $request['correo_destinatario'],
                'nombre_destinatario' => $request['nombre_destinatario'],
                'id_usuario' => $request['id_usuario'],
            ]);
            return redirect("correos")->withSuccess('El Usuario se ha Actualizado Exitosamente');
        }catch(Exception $ex){
            return redirect("correos")->withError('No se pudo actualizar el Correo correctamente', $ex->getMessage());
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
        CorreosModel::destroy($id_correos);
        return redirect("correos")->withSuccess('El correo asignado se ha Sido Eliminado Exitosamente');
    }
}
