<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpresasModel;
use App\Http\Requests\EmpresasCreateRequest;
use App\Http\Requests\EmpresasUpdateRequest;
use DB;
use Exception;
class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = EmpresasModel::all();
        return view('Configuracion.Empresas.Empresas', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Configuracion.Empresas.EmpresasCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpresasCreateRequest $request)
    {
        $IdEmpresa = EmpresasModel::max('id_empresa') + 1; // Id del pais
        
        if($request['visible_ficht'] == 'SI')
        {
            $visible = 'SI';
        }
        else
            {
                $visible = 'NO'; 
            }

        try {
            EmpresasModel::create([
                'id_empresa' => $IdEmpresa,
                'nombre_empresa' => strtoupper($request['nombre_empresa']),
                'direccion' => strtoupper($request['direccion']),
                'rif' => strtoupper($request['rif']),
                'presidente' => strtoupper($request['presidente']),
                'correo_presidente' => strtoupper($request['correo_presidente']),
                'base_datos' => strtoupper($request['base_datos']),
                'visible_ficht' => $visible,
                'alias_empresa' => strtoupper($request['alias_empresa']),
                'responsable_almacen' => strtoupper($request['responsable_almacen']),
                'correo_responsable' => strtoupper($request['correo_responsable']),
                'superior_almacen' => strtoupper($request['superior_almacen']),
                'correo_superior' => strtoupper($request['correo_superior']),
            ]);
        } catch (Exception $ex) {
            return redirect("empresas")->withError('Ha Ocurrido Un Error al Crear la Empresa ' . $ex->getMessage());
        }

        return redirect("empresas")->withSuccess('La Empresa Ha Sido Creado Exitosamente');

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
    public function edit($id_empresa)
    {
        $empresa = EmpresasModel::find($id_empresa);
        return view('Configuracion.Empresas.EmpresasEdit', compact('empresa'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmpresasUpdateRequest $request, $id_empresa)
    {
        if($request['visible_ficht'] == 'SI')
        {
            $visible = 'SI';
        }
        else
            {
                $visible = 'NO'; 
            }

        try {
            $empresa = EmpresasModel::find($id_empresa);
            $empresa->fill([
                'nombre_empresa' => strtoupper($request['nombre_empresa']),
                'direccion' => strtoupper($request['direccion']),
                'rif' => strtoupper($request['rif']),
                'presidente' => strtoupper($request['presidente']),
                'correo_presidente' => strtoupper($request['correo_presidente']),
                'base_datos' => strtoupper($request['base_datos']),
                'visible_ficht' => $visible,
                'alias_empresa' => strtoupper($request['alias_empresa']),
                'responsable_almacen' => strtoupper($request['responsable_almacen']),
                'correo_responsable' => strtoupper($request['correo_responsable']),
                'superior_almacen' => strtoupper($request['superior_almacen']),
                'correo_superior' => strtoupper($request['correo_superior']),

            ]);
        $empresa->save();

        } catch (Exception $ex) {
            return redirect("empresas")->withError('Ha Ocurrido Un Error al Actualizar la Empresa ' . $ex->getMessage());
        }

        return redirect("empresas")->withSuccess('La Empresa ha Sido Actualizado Exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_empresa)
    {
        try {
            EmpresasModel::destroy($id_empresa);
        } catch (Exception $e) {
            return redirect("empresas")->withError('No se puede eliminar la Empresa, porque tiene Proveedores asociados');
        }

        return redirect("empresas")->withSuccess('La empresa Ha Sido Eliminado Exitosamente');

    }
}
