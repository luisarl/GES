<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AlmacenesCreateRequest;
use App\Http\Requests\AlmacenesUpdateRequest;
use App\Models\AlmacenesModel;
use App\Models\EmpresasModel;
use App\Models\Articulo_MigracionModel;
use Illuminate\Support\Facades\DB;
use Exception;
use Redirect;
use Session;



class FictAlmacenesController extends Controller
{

    public function index()
    {
        $almacenes  = AlmacenesModel::VistaAlmacenes();
        return view('Configuracion.Almacenes.Almacenes', compact('almacenes'));
    }


    public function create()
    {
        $empresas = EmpresasModel::select('id_empresa', 'nombre_empresa')->get();
        return view('Configuracion.Almacenes.AlmacenesCreate', compact('empresas'));
    }


    public function store(AlmacenesCreateRequest $request)
    {
        $IdAlmacen = AlmacenesModel::max('id_almacen') + 1;
        AlmacenesModel::create([
            'id_almacen' => $IdAlmacen,
            'nombre_almacen' => strtoupper($request['nombre_almacen']),
            'id_empresa'=> strtoupper($request['id_empresa']),
            'responsable' => strtoupper($request['responsable']),
            'correo' => strtoupper($request['correo']),
            'superior' => strtoupper($request['superior']),
            'correo2' => strtoupper($request['correo2']),
            'visible_ficht' => strtoupper($request['visible_ficht']),
            'visible_cnth' => strtoupper($request['visible_cnth']),
        ]);

        return redirect("almacenes")->withSuccess('El almacen Ha Sido Creado Exitosamente');
    }


    public function show($id)
    {
        //
    }


    public function edit($id_almacen)
    {
        $almacen = AlmacenesModel::find($id_almacen);
        $empresas = EmpresasModel::select('id_empresa', 'nombre_empresa')->get();
        return view('Configuracion.Almacenes.AlmacenesEdit', compact('almacen', 'empresas'));

    }


    public function update(AlmacenesUpdateRequest $request, $id)
    {
        //dd($request->all());
        $almacen = AlmacenesModel::find($id);
        $almacen->fill([
            'nombre_almacen' => strtoupper($request['nombre_almacen']),
            'id_empresa'=> strtoupper($request['id_empresa']),
            'responsable' => strtoupper($request['responsable']),
            'correo' => strtoupper($request['correo']),
            'superior' => strtoupper($request['superior']),
            'correo2' => strtoupper($request['correo2']),
            'visible_ficht' => strtoupper($request['visible_ficht']),
            'visible_cnth' => strtoupper($request['visible_cnth']),
        ]);

        $almacen->save();

        return redirect("almacenes")->withSuccess('El almacen se ha Actualizado Exitosamente');

    }


    public function destroy($id_almacen)
    {
        if (DB::table('articulo_migracion')->where('id_almacen', $id_almacen)->exists())
        {
            return redirect("almacenes")->withError('No se ha eliminado');
        }
        else
        {
            $almacenes = AlmacenesModel::destroy($id_almacen);
            return redirect("almacenes")->withSuccess('El almacen Ha Sido Eliminado Exitosamente');
        }

    }
}
