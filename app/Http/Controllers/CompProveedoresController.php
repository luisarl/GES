<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompProveedoresCreateRequest;
use App\Http\Requests\CompProveedoresMigrateRequest;
use App\Http\Requests\CompProveedoresUpdateRequest;
use App\Models\Comp_Proveedores_EmpresasModel;
use Illuminate\Http\Request;
use App\Models\Comp_ProveedoresModel;
use App\Models\Comp_SegmentoProveedorModel;
use App\Models\Comp_Tipo_ProveedorModel;
use App\Models\Comp_ZonasModel;
use App\Models\EmpresasModel;
use App\Models\PaisesModel;
use Session;
use Carbon\Carbon;
use Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Karriere\PdfMerge\PdfMerge;

class CompProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Comp_ProveedoresModel::All();
        return view('Compras.Proveedores.proveedores', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises = PaisesModel::select('id_pais', 'nombre_pais')->get();
        $tipos = Comp_Tipo_ProveedorModel::select('id_tipo', 'nombre_tipo')->get();
        $zonas = Comp_ZonasModel::select('id_zona','nombre_zona')->get();
        $segmentos = Comp_SegmentoProveedorModel::select('id_segmento','nombre_segmento')->get();
        return view('Compras.Proveedores.ProveedoresCreate', compact('paises', 'tipos', 'zonas','segmentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompProveedoresCreateRequest $request)
    {
        $IdProveedor = Comp_ProveedoresModel::max('id_proveedor') + 1; // Id del Proveedor a Crear
        $rif = str_replace('_','', $request['tipo_rif'].'-'.$request['numero_rif']);

        $codigo = str_replace('-', '', $rif);
        
        //VALIDACION CODIGO RIF PROVEEDOR
        $existe = Comp_ProveedoresModel::where('rif', '=', $rif )->exists(); // regressa true si el codigo existe
        
        if($existe) //si es true
        {
            return back()->withErrors(['numero_rif'=>'El campo RIF del proveedor ya está en uso.'])->withInput();
        }

        if($request['nacional'] == 'SI')
        {
            $nacional = 'SI';
        }
        else
            {
                $nacional = 'NO'; 
            }

        try
        {
            $proveedor = new Comp_ProveedoresModel();
            
            $proveedor->id_proveedor = $IdProveedor;
            $proveedor->codigo_proveedor = strtoupper($codigo);
            $proveedor->nombre_proveedor = strtoupper($request['nombre_proveedor']);
            $proveedor->nit = strtoupper($request['nit']);
            $proveedor->rif = strtoupper($rif);
            $proveedor->correo = $request['correo'];
            $proveedor->activo = 'SI';
            $proveedor->direccion = strtoupper($request['direccion']);
            $proveedor->responsable = strtoupper($request['responsable']);
            $proveedor->nacional = $nacional;
            $proveedor->ciudad = strtoupper($request['ciudad']);
            $proveedor->codigo_postal = $request['codigo_postal'];
            $proveedor->telefonos = $request['telefonos'];
            $proveedor->website = $request['website'];
            $proveedor->ruc = strtoupper($request['ruc']);
            $proveedor->lae = strtoupper($request['lae']);
            $proveedor->pago1 = strtoupper($request['pago1']);
            $proveedor->pago2 = strtoupper($request['pago2']);
            $proveedor->pago3 = strtoupper($request['pago3']);
            $proveedor->pago4 = strtoupper($request['pago4']);
            $proveedor->codigo_actividad = $request['codigo_actividad'];
            $proveedor->tipo_persona = $request['tipo_persona'];
            $proveedor->cont_especial = $request['cont_especial'];
            $proveedor->porc_retencion = $request['porc_retencion'];
            $proveedor->comentario = strtoupper($request['comentario']);
            
            $proveedor->creado_por = Auth::user()->id;
            $proveedor->actualizado_por = Auth::user()->id;
            $proveedor->estatus = 'NO MIGRADO';
            $proveedor->id_tipo = $request['id_tipo'];
            $proveedor->id_segmento = $request['id_segmento'];
            $proveedor->id_zona = $request['id_zona'];
            $proveedor->id_pais = $request['id_pais'];

            if ($request->hasFile('documento'))
            {
                $documento = $request->file('documento');
                $proveedor->documento = $this->UnirPdf($documento, $proveedor);
            }

            $proveedor->save();

        }
        catch(Exception $ex)
        {
            return back()->withError('Ha Ocurrido Un Error al Crear El Proveedor '.$ex->getMessage());
        }
        
        return redirect()->route('proveedores.edit',$IdProveedor)->withSuccess('El Proveedor Se Ha Creado Exitosamente');
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
    public function edit($IdProveedor)
    {
        $paises = PaisesModel::select('id_pais', 'nombre_pais')->get();
        $tipos = Comp_Tipo_ProveedorModel::select('id_tipo', 'nombre_tipo')->get();
        $zonas = Comp_ZonasModel::select('id_zona','nombre_zona')->get();
        $segmentos = Comp_SegmentoProveedorModel::select('id_segmento','nombre_segmento')->get();
        $empresas = EmpresasModel::select('id_empresa', 'nombre_empresa', 'alias_empresa','base_datos')->get();
        $proveedor = Comp_ProveedoresModel::find($IdProveedor);

        return view('Compras.Proveedores.ProveedoresEdit', compact('proveedor', 'paises', 'tipos', 'zonas','segmentos','empresas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompProveedoresUpdateRequest $request, $IdProveedor)
    {
        $proveedor = Comp_ProveedoresModel::find($IdProveedor);
        $codigo = str_replace('-', '', $request['rif']);

        if($request['nacional'] == 'SI'){
            $nacional = 'SI';
        }
        else
            {
                $nacional = 'NO'; 
            }

        try
        {
            $proveedor->fill([
                ///'codigo_proveedor' => strtoupper($codigo),
                'nombre_proveedor' => strtoupper($request['nombre_proveedor']),
                'nit' => strtoupper($request['nit']),
                'rif'=> strtoupper($request['rif']),
                'correo' => $request['correo'],
                //'activo' => $request['activo'],
                'direccion' => strtoupper($request['direccion']),
                'responsable' => strtoupper($request['responsable']),
                'nacional' => $nacional,
                'ciudad' => strtoupper($request['ciudad']),
                'codigo_postal' => $request['codigo_postal'],
                'telefonos' => $request['telefonos'],
                'website' => $request['website'],
                'ruc' => strtoupper($request['ruc']),
                'lae' => strtoupper($request['lae']),
                'pago1' => strtoupper($request['pago1']),
                'pago2' => strtoupper($request['pago2']),
                'pago3' => strtoupper($request['pago3']),
                'pago4' => strtoupper($request['pago4']),
                'codigo_actividad' => $request['codigo_actividad'],
                'tipo_persona' => $request['tipo_persona'],
                'cont_especial' => $request['cont_especial'],
                'porc_retencion' => $request['porc_retencion'],
                'comentario' => strtoupper($request['comentario']),
                //'documento' => $request['documento'],
                'actualizado_por' => Auth::user()->id,
                'estatus' => 'NO MIGRADO',
                'id_tipo' => $request['id_tipo'],
                'id_segmento' => $request['id_segmento'],
                'id_zona' => $request['id_zona'],
                'id_pais' => $request['id_pais']

            ]);
          
            if ($request->hasFile('documento'))
            {
                $documento = $request->file('documento');
                $proveedor->documento = $this->UnirPdf($documento, $proveedor);
            }

            $proveedor->save();
        }
        catch(Exception $ex)
        {
          return redirect()->route('proveedores.edit', $IdProveedor)->withError('Ha Ocurrido Un Error al Actualizar El Proveedor '.$ex->getMessage());
        }

        return back()->withSuccess('El Proveedor Se Ha Actualizado Exitosamente');
    }

    /**
     * PROCESO DE MIGRACION DE UN PROVEEDOR  A PROFIT
     *
     */
    public function migrate(CompProveedoresMigrateRequest $request)
    {
        $IdProveedor = $request['id_proveedor']; //OBTIENE DEL CAMPO OCULTO EL ID DEL PROVEEDOR
        $ArregloEmpresas = $request['empresas']; //CAPTURA LOS ID DE LAS EMPRESAS SELECCIONADAS PARA LA MIGRACION

        $empresas = DB::table('empresas')->whereIn('id_empresa', $ArregloEmpresas)->get(); //Obtiene los datos de las empresas

        $proveedor = Comp_ProveedoresModel::find($IdProveedor); // Obtiene datos del Proveedor

        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual

        try
        {
            // VALIDA SI EXISTE UN ERROR EN ALGUN INSERT NO REALIZE NINGUNO
            DB::transaction(function () use ($empresas, $proveedor, $FechaActual){

                 // Actualiza el estatus al enviar un proveedor a profit
                 Comp_ProveedoresModel::where('id_proveedor' , '=', $proveedor->id_proveedor )
                 ->update(['estatus' => 'MIGRADO']);

                foreach ($empresas as $empresa) {

                    // // Inserta en la base de datos "prov" de profit
                    Comp_Proveedores_EmpresasModel::MigrarProveedorProfit($empresa->base_datos, $proveedor->codigo_proveedor, $proveedor->nombre_proveedor, $proveedor->id_segmento,
                    $proveedor->id_zona, $proveedor->direccion, $proveedor->telefonos, $proveedor->responsable, $FechaActual, $proveedor->id_tipo, $proveedor->rif, $proveedor->nacional,
                    $proveedor->nit, $proveedor->correo, $proveedor->comentario, $proveedor->ruc, $proveedor->lae, $proveedor->codigo_actividad, $proveedor->pago1, $proveedor->pago2,
                    $proveedor->pago3, $proveedor->pago4, $proveedor->id_tipo, $proveedor->tipo_persona, $proveedor->id_pais, $proveedor->ciudad, $proveedor->codigo_postal,
                    $proveedor->website, $proveedor->porc_retencion, $proveedor->cont_especial);

                    // Inserta En la tabla comp_proveedore_empresas
                    Comp_Proveedores_EmpresasModel::updateOrCreate(
                        [
                            'id_proveedor' => $proveedor->id_proveedor,
                            'id_empresa' => $empresa->id_empresa
                        ],
                        [
                           // 'id_proveedor_empresa' => Comp_Proveedores_EmpresasModel::max('id_proveedor_empresa') + 1,
                            'usuario_migracion' => Auth::user()->name,
                            'fecha_migracion' => $FechaActual,
                            'migrado' => 'SI' 
                        ]);
                }

            });

        }
        catch (Exception $e)
        {
             return back()->withError('Ocurrio Un Error al Migrar El Proveedor: '.$e->getMessage())->withInput();
        }

        //VALIDACION DE ENVIO DE CORREOS
        try
        {
        //     //OBTIENE EL ARREGLO CON LOS CORREOS A ENVIAR
        //     $destinatarios = Usuarios_CorreosModel::CorreosDestinatarios(Auth::user()->id , $articulo->creado_por, $ArregloAlmacenes, 'MIGRAR');

        //    // ENVIA EL CORREO
        //     Mail::to($destinatarios[0]) //DESTINATARIOS
        //         ->cc($destinatarios[1]) //EN COPIA
        //         ->bcc($destinatarios[2]) // EN COPIA OCULTA
        //         ->send(new ArticulosMigrateMailable($articulo, $almacenes));   
        }
        catch (Exception $ex)
        {
            Session::flash('alert','Se Produjo Un error Al Enviar El Correo: '.$ex->getMessage());
        }

        return back()->withSuccess('El Proveedor Ha Sido Migrado Exitosamente');

    }

    /**
     * PROCESO QUE INACTIVA/ACTIVA UN PROVEDOR EN SISTEMA Y EN PROFIT
     * SEGUN LA EMPRESA DONDE ESTE DISPONIBLE EL PROVEEDOR
     */
    public function InactivarProveedor($IdProveedor)
    {
        $proveedor =  Comp_ProveedoresModel::select('id_proveedor', 'codigo_proveedor', 'activo')->where('id_proveedor', $IdProveedor)->first(); //obtiene los datos del articulo
        $EmpresasDisponibles = Comp_Proveedores_EmpresasModel::select('id_empresa')->where('id_proveedor', $IdProveedor)->get(); // Obtiene el id de las empreas donde esta migrado el proveedor
        
        $ArregloEmpresas[] = '' ; //inicializacion de arreglo

        foreach($EmpresasDisponibles as $empresa)
        {
            $ArregloEmpresas [] = $empresa->id_empresa; // LLena el Arreglo con el valor id_empresa
        }

        $empresas = EmpresasModel::select('base_datos','nombre_empresa')->whereIn('id_empresa', $ArregloEmpresas)->get(); //obtiene las empresas
        
        try
        {
            DB::transaction(function () use ($empresas, $proveedor){
                
                if(str_replace(" ","",$proveedor->activo) == 'SI')
                {
                    $activo = 'NO';
                    $inactivo = 1;    
                }
                else if(str_replace(" ","",$proveedor->activo) == 'NO')    
                    {  
                        $activo = 'SI';    
                        $inactivo = 0;
                    }

                //Actualiza el campo activo de la tabla de provedores
                Comp_ProveedoresModel::where('id_proveedor', $proveedor->id_proveedor)
                ->update(['activo' => $activo]);
                
                    foreach ($empresas as $empresa) {
                        //actualiza el campo inactivo de la tabla prov de profit
                        DB::connection('profit')
                            ->table($empresa->base_datos.'.dbo.prov')
                            ->where('co_prov', $proveedor->codigo_proveedor) 
                            ->update(['inactivo' => $inactivo]);
                    }
            });
        }
        catch(Exception $ex)
            {
                return back()->withError('Ocurrio Un Error Al Inactivar/Activar El Proveedor '.$ex->getMessage());
            }
            
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdProveedor)
    {
        try
        {
            Comp_ProveedoresModel::destroy($IdProveedor);
        }
        catch(Exception $ex)
            {
                return redirect("proveedores")->withError('El Proveedor No Puede Ser Eliminado, Esta Migrado a Profit' );
            }
        
        return redirect("proveedores")->withSuccess('El Proveedor Se Ha Eliminado Exitosamente');
            
    }

    private function UnirPdf($documentos, $proveedor)
    {
        $pdf = new PdfMerge();
        $destino = "/documents/proveedores/";
        $nombre_pdf = $destino.$proveedor->id_proveedor.'.pdf';
       
        //verificamos si en el registro ya existe un documento
        if(!is_null($proveedor->documento))
        {
            $pdf->add(public_path().$proveedor->documento);
        }

        foreach ($documentos as $documento)
        {
            $pdf->add($documento->getPathName());
        }
       
        $pdf->merge(public_path().$nombre_pdf);

        return $nombre_pdf;
    }

}
