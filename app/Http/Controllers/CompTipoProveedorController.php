<?php

namespace App\Http\Controllers;
use App\Models\Comp_Tipo_ProveedorModel;
use App\Http\Requests\CompTipoProveedorCreateRequest;
use App\Http\Requests\CompTipoProveedorUpdateRequest;
use DB;
use Exception;

class CompTipoProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = Comp_Tipo_ProveedorModel::all();
        return view('Compras.TipoProveedor.TipoProveedor', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Compras.TipoProveedor.TipoProveedorCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompTipoProveedorCreateRequest $request)
    {
        try {
            Comp_Tipo_ProveedorModel::create([
                'id_tipo' => strtoupper($request['id_tipo']),
                'nombre_tipo' => strtoupper($request['nombre_tipo']),
            ]);
        } catch (Exception $ex) {
            return redirect("tiposproveedor")->withError('Ha Ocurrido Un Error al Crear el Tipo Proveedor ' . $ex->getMessage());
        }


        return redirect("tiposproveedor")->withSuccess('El tipo proveedor Ha Sido Creado Exitosamente');
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
    public function edit($id_tipo)
    {
        $tiposproveedor = Comp_Tipo_ProveedorModel::find($id_tipo);
        return view('Compras.TipoProveedor.TipoProveedorEdit', compact('tiposproveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompTipoProveedorUpdateRequest $request, $id_tipo)
    {
        try {
            $tipos = Comp_Tipo_ProveedorModel::find($id_tipo);
            $tipos->fill([
                'id_tipo' => strtoupper($request['id_tipo']),
                'nombre_tipo' => strtoupper($request['nombre_tipo']),

            ]);
        $tipos->save();
        } catch (Exception $ex) {
            return redirect("tiposproveedor")->withError('Ha Ocurrido Un Error al Actualizar El tipo Proveedor ' . $ex->getMessage());
        }

        return redirect("tiposproveedor")->withSuccess('El tipo proveedor ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_tipo)
    {
        try {
            Comp_Tipo_ProveedorModel::destroy($id_tipo);
        } catch (Exception $ex) {
            return redirect("tiposproveedor")->withError('No se puede eliminar el tipo Proveedor, porque tiene Proveedores asociados'. $ex->getMessage());
        }

        return redirect("tiposproveedor")->withSuccess('El tipo Proveedor Ha Sido Eliminado Exitosamente');
    }
}
