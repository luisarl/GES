<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompActualizarPreciosOCCreateRequest;
use App\Models\EmpresasModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompActualizarPreciosOCController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $empresas = EmpresasModel::select('id_empresa', 'base_datos', 'nombre_empresa')->get();

        if($request->has('numero'))
        {
            $NumeroOc = $request->get('numero');
            $empresa = $request->get('id_empresa');

            //VALIDACIONES
            if($NumeroOc  == NULL && $empresa == 0 ) 
            {
                return back()->withErrors([
                    'numero' => 'El campo numero articulo es obligatorio.',
                    'id_empresa' => 'El empresa almacen es obligatorio.',
                    ])->withInput();
            }

            if($NumeroOc  == NULL) 
            {
                return back()->withErrors([
                    'numero' => 'El campo numero articulo es obligatorio.',
                    ])->withInput();
            }

            if($empresa == 0) 
            {
                return back()->withErrors([
                    'id_empresa' => 'El empresa almacen es obligatorio.',
                    ])->withInput();
            }
            
            //datos de articulo
            $articulos = DB::connection('profit')
                ->table($empresa.'.dbo.ordenes as o')
                ->join($empresa.'.dbo.prov as p', 'o.co_cli', '=', 'p.co_prov' )
                ->join($empresa.'.dbo.reng_ord as r', 'o.fact_num', '=', 'r.fact_num' )
                ->join($empresa.'.dbo.art as a', 'r.co_art', '=', 'a.co_art' )
                ->select(
                    'o.fact_num AS numOC',
                    'o.descrip AS motivo', 
                    'o.co_cli', 
                    'p.prov_des AS Proveedor',
                    'o.tasa',
                    'o.moneda',
                    'r.reng_num', 
                    'a.co_art as codigo_articulo', 
                    'a.art_des as nombre_articulo', 
                    'r.total_art', 
                    'r.prec_vta', 
                    'r.prec_vta2', 
                    'r.reng_neto'
                )
                ->where('o.fact_num', '=', $NumeroOc)
                ->get();

                if($articulos  == '[]') 
                {
                    $articulos = null;
                }
        }
        else
            {
                $articulos = null;
                $empresa = null;
            }
            
        return view('Compras.OrdenesCompras.ActualizarPrecios.ActualizarPreciosCreate', compact('empresas', 'articulos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompActualizarPreciosOCCreateRequest $request)
    {

        $articulos = json_decode($request['articulos']);
        $empresa = $request['empresa'];
        $NumeroOc = $request['orden'];
        $tasa = $request['tasa'];

        try
        {
            foreach($articulos as $articulo)
            {
                $PrecioBolivares = $tasa * $articulo->prec_vta;
                $TotalNeto = $articulo->total_art * $PrecioBolivares;

                DB::connection('profit')
                ->table($empresa.'.dbo.reng_ord')
                ->where('fact_num', '=', $NumeroOc)
                ->where('co_art', '=', $articulo->codigo_articulo)
                ->update([ 
                    'prec_vta' => $PrecioBolivares,
                    'prec_vta2' => $articulo->prec_vta,
                    'reng_neto' => $TotalNeto
                ]);
            }
        }
        catch(Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Actualizar Los Precios De La OC '.$ex->getMessage())->withInput();
        }
        
        return redirect()->back()->withSuccess('Los Precios Se Han Actualizado Exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
