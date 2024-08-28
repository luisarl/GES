<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comp_SegmentoProveedorModel;
use App\Http\Requests\CompSegmentoProveedorCreateRequest;
use App\Http\Requests\CompSegmentoProveedorUpdateRequest;
use DB;
use Exception;

class CompSegmentoProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segmentos = Comp_SegmentoProveedorModel::all();
        return view('Compras.SegmentoProveedor.SegmentoProveedor', compact('segmentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Compras.SegmentoProveedor.SegmentoProveedorCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompSegmentoProveedorCreateRequest $request)
    {

        try {
            Comp_SegmentoProveedorModel::create([
                'id_segmento' => strtoupper($request['id_segmento']),
                'nombre_segmento' => strtoupper($request['nombre_segmento']),
            ]);
        } catch (Exception $ex) {
            return redirect("segmentos")->withError('Ha Ocurrido Un Error al Crear el Segmento Proveedor ' . $ex->getMessage());
        }


        return redirect("segmentos")->withSuccess('El Segmento Ha Sido Creado Exitosamente');
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
    public function edit($id_segmento)
    {
        $segmentos = Comp_SegmentoProveedorModel::find($id_segmento);
        return view('Compras.SegmentoProveedor.SegmentoProveedorEdit', compact('segmentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompSegmentoProveedorUpdateRequest $request, $id_segmento)
    {
        try {
            $segmentos = Comp_SegmentoProveedorModel::find($id_segmento);
            $segmentos->fill([
                'id_segmento' => strtoupper($request['id_segmento']),
                'nombre_segmento' => strtoupper($request['nombre_segmento']),

            ]);
            $segmentos->save();
        } catch (Exception $ex) {
            return redirect("segmentos")->withError('Ha Ocurrido Un Error al Actualizar al segmentos Proveedor ' . $ex->getMessage());
        }

        return redirect("segmentos")->withSuccess('El segmento del proveedor ha Sido Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_segmento)
    {
        try {
            Comp_SegmentoProveedorModel::destroy($id_segmento);
        } catch (Exception) {
            return redirect("segmentos")->withError('No se puede eliminar el segmento del Proveedor, porque tiene Proveedores asociados');
        }

        return redirect("segmentos")->withSuccess('El Segmentos Proveedor Ha Sido Eliminado Exitosamente');
    }

}
