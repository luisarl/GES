<?php

namespace App\Http\Controllers;

use App\Exports\AudiAuditoriaInventarioExport;
use App\Http\Requests\AudiAuditoriaInventarioCreateRequest;
use App\Models\Almacen_UsuarioModel;
use App\Models\Articulo_MigracionModel;
use App\Models\Articulo_UbicacionModel;
use App\Models\ArticulosModel;
use App\Models\Audi_Auditoria_InventarioModel;
use App\Models\EmpresasModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class AudiAuditoriaInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fecha = $request->get('fecha');
        $NumeroAuditoria = $request->get('numero_auditoria');

        if($request->has('buscar'))
        {
            $articulos = Audi_Auditoria_InventarioModel::ArticulosAuditoriaInventario($fecha, $NumeroAuditoria);
        }
        elseif($request->has('pdf'))
            {
                $articulos = Audi_Auditoria_InventarioModel::ArticulosAuditoriaInventario($fecha, $NumeroAuditoria);
                $pdf = Pdf::loadView('Reportes.Auditoria.AuditoriaInventarioPDF', compact('articulos'));
                return $pdf->stream('auditoriainventario.pdf');
            }
            elseif($request->has('excel'))
                {
                    return (new AudiAuditoriaInventarioExport($fecha, $NumeroAuditoria))->download('auditoriainventario.xlsx');
                }
                else
                    {
                        $articulos = null;
                    }

        return view('Auditoria.AuditoriaInventario.AuditoriaInventario', compact('articulos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);

        if($request->has('codigo_articulo'))
        {
            $CodigoArticulo = $request->get('codigo_articulo');
            $IdAlmacen = $request->get('id_almacen');
            //$IdSubAlmacen = $request->get('id_subalmacen');
           

            //VALIDACIONES
            if($CodigoArticulo  == NULL && $IdAlmacen == 0 ) 
            {
                return back()->withErrors([
                    'codigo_articulo' => 'El campo codigo articulo es obligatorio.',
                    'id_almacen' => 'El campo almacen es obligatorio.',
                    //'id_subalmacen' => 'El campo subalmacen es obligatorio.'
                    ])->withInput();
            }

            if($CodigoArticulo  == NULL) 
            {
                return back()->withErrors(['codigo_articulo' => 'El campo codigo articulo es obligatorio.'])->withInput();
            }

            if($IdAlmacen == 0) 
            //&& $IdSubAlmacen == 0
            {
                return back()->withErrors([
                    'id_almacen' => 'El campo almacen es obligatorio.',
                    //'id_subalmacen' => 'El campo subalmacen es obligatorio.'
                    ])->withInput();
            }

            // if($IdSubAlmacen == 0) 
            // {
            //     return back()->withErrors(['id_subalmacen' => 'El campo subalmacen es obligatorio.' ])->withInput();
            // }


           //datos de articulo
           $articulos = Articulo_UbicacionModel::DetalleUbicacionArticuloAlmacenen($CodigoArticulo, $IdAlmacen);

           if($articulos  == NULL) 
            {
                return back()->withErrors(['codigo_articulo' => 'El codigo del articulo no se encuentra registrado.'])->withInput();
            }
  
           //datos empresa
           //$empresa = EmpresasModel::EmpresaSegunAlmacen($IdAlmacen);
           
           //stock de artiuculo en almacen profit
           ///$StockArticulo = Articulo_MigracionModel::StockAlmacenesArticuloProfit($empresa->base_datos, $CodigoArticulo);
            
           //Zonas Ubicaciones articulos
           //$zonas = Articulo_UbicacionModel::ZonasArticuloAlmacen($articulo->id_articulo,$IdAlmacen);

        }
        else
            {
                $articulos = null;
                //$empresa = null;
                //$StockArticulo = null;
                //$zonas = null;
            }

        return view('Auditoria.AuditoriaInventario.AuditoriaInventarioCreate', compact('articulos', 'almacenes')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AudiAuditoriaInventarioCreateRequest $request)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

        $subalmacenes =  json_decode($request['subalmacenes']); 

        if($subalmacenes  == NULL) //Valida que el arreglo de las herramientas no este vacio
        {
            return back()->withErrors(['subalmacenes'=> 'Para guardar debe ingresar al menos un conteo.'])->withInput();
        }

        try
        {
            if ($request->hasFile('fotografia')) 
            {
                $fotografia = $request->file('fotografia');
            
                $destino = "images/auditoria/AuditoriaInventario/";
                $NombreImagen = $fotografia->getClientOriginalName();
                $fotografia->move($destino, $NombreImagen);
            
                //Funcion para renderizar la imagenes y cambiar el tamaño
                $RutaImagen = public_path($destino . $NombreImagen);
                $imagen = Image::make($RutaImagen)->resize(600, 600)->save($RutaImagen);
                $imagen->save($RutaImagen);
                $FotoTomaFisica = $destino . $NombreImagen; //Guarda Ruta Imagen en bd
            }
            else 
            {  
                $FotoTomaFisica = null;
            }

            foreach($subalmacenes as $subalmacen)
            {
                $IdAuditoriaInventario = Audi_Auditoria_InventarioModel::max('id_auditoria_inventario') + 1;

                Audi_Auditoria_InventarioModel::create([
                    'id_auditoria_inventario' => $IdAuditoriaInventario,
                    'id_articulo' => $request['id_articulo'],
                    'codigo_articulo' => $request['codigo_articulo'],
                    'id_almacen' => $request['id_almacen'],
                    'id_subalmacen' => $subalmacen->id_subalmacen,
                    'stock_actual' => $subalmacen->stock_actual,
                    'conteo_fisico' => $subalmacen->conteo_fisico,
                    'numero_auditoria' => $request['numero_auditoria'],
                    'observacion' => strtoupper($request['observacion']),
                    'fecha' => $FechaActual,
                    'usuario' => Auth::user()->id,
                    'direccion_ip' => $request->ip(),
                    'nombre_equipo' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                    'fotografia' => $FotoTomaFisica,
                ]);
            }
           
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Realizar La Auditoria Del Inventario '.$ex->getMessage())->withInput();
            }
        
        return redirect()->route('audiauditoriainventario.create')->withSuccess('La Auditoria Del Inventario Se Ha Realizado Exitosamente');
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
    public function edit(int $IdAuditoriaInventario)
    {
        $articulo = Audi_Auditoria_InventarioModel::VerAuditoriaInventario($IdAuditoriaInventario);
        
        return view('Auditoria.AuditoriaInventario.AuditoriaInventarioEdit', compact('articulo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $IdAuditoriaInventario)
    {
        try
        {
            $TomaFisica = Audi_Auditoria_InventarioModel::find($IdAuditoriaInventario);

            if ($request->hasFile('fotografia')) 
            {
                $fotografia = $request->file('fotografia');
               
                $destino = "images/auditoria/AuditoriaInventario/";
                $NombreImagen = $fotografia->getClientOriginalName();
                $fotografia->move($destino, $NombreImagen);
             
                //Funcion para renderizar la imagenes y cambiar el tamaño
                $RutaImagen = public_path($destino . $NombreImagen);
                $imagen = Image::make($RutaImagen)->resize(600, 600)->save($RutaImagen);
                $imagen->save($RutaImagen);
                $FotoTomaFisica = $destino . $NombreImagen; //Guarda Ruta Imagen en bd

                $TomaFisica->fill([
                    'fotografia' => $FotoTomaFisica,
                ]);
            }
           
            $TomaFisica->fill([
                'observacion' => strtoupper($request['observacion']),
            ]);

            $TomaFisica->save();
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Editar La Auditoria Del Inventario '.$ex->getMessage())->withInput();
            }
        
        return redirect()->back()->withSuccess('La Auditoria Del Inventario Se Ha Editado Exitosamente');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $IdAuditoriaInventario)
    {
        try
        {
            Audi_Auditoria_InventarioModel::destroy($IdAuditoriaInventario);
        }
        catch(Exception $ex)
            {
                return redirect()->back()->withError('Ha Ocurrido Un Error Al Eliminar La Auditoria Del Inventario '.$ex->getMessage());
            }

        return redirect()->back()->withSuccess('La Auditoria Del Inventario Se Ha Eliminado Exitosamente');
    }
}
