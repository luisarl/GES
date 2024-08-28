<?php

namespace App\Http\Controllers;
use App\Models\Cenc_CierreModel;
use App\Models\Cenc_CierrePlanchaCortesModel;
use App\Models\Cenc_CierrePlanchaConsumiblesModel;
use App\Models\Cenc_CierrePlanchasModel;
use App\Models\Cenc_CierrePlanchaSobranteModel;
use App\Models\Cenc_Aprovechamiento_PlanchasModel;
use App\Models\Cenc_SeguimientoPlanchaOxigenoModel;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class CencCierreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Cierre = Cenc_CierreModel::Cenc_CierreVer();
        return view('CentroCorte.OrdenTrabajo.Cierre.Cierre',compact('Cierre'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $IdCierrePlancha = (int)$request->query("IdCierrePlancha");

        $CierrePlanchaCortes = Cenc_CierrePlanchaCortesModel::Cenc_CierrePlanchaCortesEditar($IdCierrePlancha);
        $CierrePlanchaSobrante = Cenc_CierrePlanchaSobranteModel::Cenc_CierrePlanchaSobranteEditar($IdCierrePlancha);

        $CierrePlancha = Cenc_CierreModel::Cenc_CierreBuscar($request->query("IdCierrePlancha"));
        $DiametrosInserto = Cenc_Aprovechamiento_PlanchasModel::BuscarInsertoPlancha($CierrePlancha->id_lista_parte, $CierrePlancha->espesor);
        
        foreach ($DiametrosInserto as $DiametrosInsertos) 
        {
            if($DiametrosInsertos->diametro_perforacion <> 0)
            {
                $Inserto[] = $DiametrosInsertos->diametro_perforacion;
            }
            else
            {
                $Inserto[] = 0;
            }
        }

        return view('CentroCorte.OrdenTrabajo.Cierre.CierreEdit',
            compact(
                    'CierrePlancha',
                    'CierrePlanchaCortes',
                    'CierrePlanchaSobrante',
                    'Inserto',
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->upsert($request, '');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdCierrePlancha)
    {
        $CierrePlancha = Cenc_CierrePlanchasModel::cenc_CierrePlanchaEditar($IdCierrePlancha);
        $IdSeguimientoPlancha = (int)$CierrePlancha->id_seguimiento_plancha;
        
        $SeguimientoPlanchaOxigeno = Cenc_SeguimientoPlanchaOxigenoModel::Cenc_SeguimientoPlanchaOxigenoEditar($IdSeguimientoPlancha);
           
        foreach($SeguimientoPlanchaOxigeno as $SeguimientoPlanchaOxigenos )
            {
                $TotalOxigenoUsado = $SeguimientoPlanchaOxigenos->total_oxigeno_usado;
                $TotalLitrosGaseosos = $SeguimientoPlanchaOxigenos->total_litros_gaseosos;
            }

            if(isset($TotalOxigenoUsado) || isset($TotalLitrosGaseosos)) 
            {
                $TotalOxigenoUsado = $SeguimientoPlanchaOxigenos->total_oxigeno_usado;
                $TotalLitrosGaseosos = $SeguimientoPlanchaOxigenos->total_litros_gaseosos;
            }
            else
            {
                $TotalOxigenoUsado = '';
                $TotalLitrosGaseosos = '';
            }
    
        $CierrePlanchaCortes = Cenc_CierrePlanchaCortesModel::Cenc_CierrePlanchaCortesEditar($IdCierrePlancha);
       
            foreach($CierrePlanchaCortes as $CierrePlanchaCorte )
            {
                $TotalAnidadas = $CierrePlanchaCorte->total_anidadas;
                $TotalCortadas = $CierrePlanchaCorte->total_cortadas;
                $TotalDanadas = $CierrePlanchaCorte->total_danadas;
                $TotalLongitudCorte = $CierrePlanchaCorte->total_longitud_corte;
                $TotalPerforaciones = $CierrePlanchaCorte->total_perforaciones;
            }

            if(isset($TotalAnidadas) || isset($TotalCortadas) || isset($TotalDanadas) || isset($TotalLongitudCorte) || isset($TotalPerforaciones))
            {
                $TotalAnidadas = $CierrePlanchaCorte->total_anidadas;
                $TotalCortadas = $CierrePlanchaCorte->total_cortadas;
                $TotalDanadas = $CierrePlanchaCorte->total_danadas;
                $TotalLongitudCorte = $CierrePlanchaCorte->total_longitud_corte;
                $TotalPerforaciones = $CierrePlanchaCorte->total_perforaciones;
            }
            else
            {
                $TotalAnidadas = '';
                $TotalCortadas = '';
                $TotalDanadas = '';
                $TotalLongitudCorte = '';
                $TotalPerforaciones = '';
            }

            $CierrePlanchaSobrante = Cenc_CierrePlanchaSobranteModel::Cenc_CierrePlanchaSobranteEditar($IdCierrePlancha);

        return view('CentroCorte.OrdenTrabajo.Cierre.CierreShow',
        compact(
                'CierrePlanchaCortes',
                'TotalAnidadas',
                'TotalCortadas',
                'TotalDanadas',
                'TotalLongitudCorte',
                'TotalPerforaciones',
                'CierrePlanchaSobrante',
                'CierrePlancha',
                'TotalLitrosGaseosos'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $CierrePlancha = Cenc_CierrePlanchasModel::cenc_CierrePlanchaEditar((int)$id);

        if (isset($CierrePlancha))
        {
            $CierrePlanchaCortes = Cenc_CierrePlanchaCortesModel::Cenc_CierrePlanchaCortesEditar($CierrePlancha->id_cierre_planchas);
            $CierrePlanchaSobrante = Cenc_CierrePlanchaSobranteModel::Cenc_CierrePlanchaSobranteEditar($CierrePlancha->id_cierre_planchas);
            
            return view('CentroCorte.OrdenTrabajo.Cierre.CierreEdit',
            compact('CierrePlanchaCortes',
                    'CierrePlanchaSobrante',
                    'CierrePlancha'
            ));
        }
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
        return $this->upsert($request, $id);
    }

     /**
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function upsert(Request $request, $IdCierre)
    {
        $IdCierrePlancha = $request->query("IdCierrePlancha");
        $id_cierre = $IdCierre;

        try {
            DB::transaction(function () use ($request, &$id_cierre, $IdCierrePlancha) 
            {
                $IdUsuario = Auth::user()->id;
                $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
                $data = json_decode($request['datos_cierre']);
                $tabla_cortes = $data->tabla_cortes;
                $total_piezas_anidadas = $data->total_piezas_anidadas;
                $total_piezas_cortadas = $data->total_piezas_cortadas;
                $total_piezas_danadas = $data->total_piezas_danadas;
                $total_longitud_cortes = $data->total_longitud_cortes;
                $total_nro_perforacion = $data->total_nro_perforacion;
                $tabla_sobrante = $data->tabla_sobrante;

                if ($id_cierre == '')
                {
                    $id_cierre = Cenc_CierreModel::max('id_cierre') + 1;
                }
                else
                {
                    $DatosCierre = Cenc_CierreModel::Cenc_CierreBuscarID($id_cierre);
                    $IdCierrePlancha = $DatosCierre->id_cierre_planchas;
                }

                // 4. TABLA CIERRE CORTES
                foreach ($tabla_cortes as $tabla_corte)
                {
                    if ($tabla_corte->id_cierre_pl_cortes == '')
                    {
                        $TablaCortes = Cenc_CierrePlanchaCortesModel::max('id_cierre_pl_cortes') + 1;
                    }
                    else
                    {
                        $TablaCortes = $tabla_corte->id_cierre_pl_cortes;
                    }

                    Cenc_CierrePlanchaCortesModel::updateOrCreate(
                    [
                        'id_cierre_pl_cortes'    => $TablaCortes,
                    ],
                    [
                        'id_cierre_pl_cortes'       => $TablaCortes,
                        'id_cierre_planchas'        => $IdCierrePlancha,
                        'piezas_anidadas'           => $tabla_corte->piezas_anidadas,
                        'piezas_cortadas'           => $tabla_corte->piezas_cortadas,
                        'piezas_danadas'            => $tabla_corte->piezas_danadas,
                        'longitud_corte'            => $tabla_corte->longitud_corte,
                        'numero_perforaciones'      => $tabla_corte->numero_perforaciones,
                        'cnc_aprovechamiento'       => $tabla_corte->cnc_aprovechamiento,
                        'total_anidadas'            => $total_piezas_anidadas,
                        'total_cortadas'            => $total_piezas_cortadas,
                        'total_danadas'             => $total_piezas_danadas,
                        'total_longitud_corte'      => $total_longitud_cortes,
                        'total_perforaciones'       => $total_nro_perforacion,
                        'creado_por'                => $IdUsuario,
                        'fecha_creado'              => $tabla_corte->fecha_creado,
                    ]);
                }

                // 7. TABLA CIERRE SOBRANTE
                foreach ($tabla_sobrante as $tabla_sobrantes) 
                {
                    if ($tabla_sobrantes->id_cierre_pl_sobrante == '')
                    {
                        $TablaSobrantes = Cenc_CierrePlanchaSobranteModel::max('id_cierre_pl_sobrante') + 1;
                    }
                    else
                    {
                        $TablaSobrantes = $tabla_sobrantes->id_cierre_pl_sobrante;
                    }
                
                    Cenc_CierrePlanchaSobranteModel::updateOrCreate(
                    [
                        'id_cierre_pl_sobrante'    => $TablaSobrantes,
                    ],
                    [
                        'id_cierre_pl_sobrante'    => $TablaSobrantes,
                        'id_cierre_planchas'       => $IdCierrePlancha,
                        'descripcion'              => $tabla_sobrantes->descripcion_sobrante,
                        'referencia'               => $tabla_sobrantes->referencia_sobrante,
                        'cantidad'                 => $tabla_sobrantes->cantidad_sobrante,
                        'ubicacion'                => $tabla_sobrantes->ubicacion_sobrante,
                        'observacion'              => $tabla_sobrantes->observacion_sobrante,
                        'creado_por'               => $IdUsuario,
                        'fecha_creado'             => $tabla_sobrantes->fecha_creado,
                    ]
                    );
                }
            });

        } catch (Exception $ex) {
            return redirect()->back()->withError('Ha Ocurrido Un Error al crear el Cierre' . $ex->getMessage())->withInput();
        }
        return redirect()->route('cenccierre.edit', $id_cierre)->withSuccess('Se Ha Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ImprimirCierre($IdCierrePlancha)
    {
        $FechaActual = Carbon::now();
        $BuscarCierrePlancha = Cenc_CierrePlanchasModel::cenc_CierrePlanchaEditar($IdCierrePlancha);

        $CierrePlanchaCortes = Cenc_CierrePlanchaCortesModel::Cenc_CierrePlanchaCortesEditar($IdCierrePlancha);
        foreach($CierrePlanchaCortes as $CierrePlanchaCorte )
        {
            $TotalAnidadas = $CierrePlanchaCorte->total_anidadas;
            $TotalCortadas = $CierrePlanchaCorte->total_cortadas;
            $TotalDanadas = $CierrePlanchaCorte->total_danadas;
            $TotalLongitudCorte = $CierrePlanchaCorte->total_longitud_corte;
            $TotalPerforaciones = $CierrePlanchaCorte->total_perforaciones;
        }

        if(isset($TotalAnidadas) || isset($TotalCortadas) || isset($TotalDanadas) || isset($TotalLongitudCorte) || isset($TotalPerforaciones))
        {
            $TotalAnidadas = $CierrePlanchaCorte->total_anidadas;
            $TotalCortadas = $CierrePlanchaCorte->total_cortadas;
            $TotalDanadas = $CierrePlanchaCorte->total_danadas;
            $TotalLongitudCorte = $CierrePlanchaCorte->total_longitud_corte;
            $TotalPerforaciones = $CierrePlanchaCorte->total_perforaciones;
        }
        else
        {
            $TotalAnidadas = '';
            $TotalCortadas = '';
            $TotalDanadas = '';
            $TotalLongitudCorte = '';
            $TotalPerforaciones = '';
        }

        $CierrePlancha = Cenc_CierreModel::Cenc_CierreBuscar($IdCierrePlancha);
        $DiametrosInserto = Cenc_Aprovechamiento_PlanchasModel::BuscarInsertoPlancha($CierrePlancha->id_lista_parte, $CierrePlancha->espesor);
        
        foreach ($DiametrosInserto as $DiametrosInsertos) 
        {
            if($DiametrosInsertos->diametro_perforacion <> 0)
            {
                $Inserto[] = $DiametrosInsertos->diametro_perforacion;
            }
            else
            {
                $Inserto[] = 0;
            }
        }

        $CierrePlanchaSobrante = Cenc_CierrePlanchaSobranteModel::Cenc_CierrePlanchaSobranteEditar($IdCierrePlancha);

        $SeguimientoPlanchaOxigeno = Cenc_SeguimientoPlanchaOxigenoModel::Cenc_SeguimientoPlanchaOxigenoEditar((int)$BuscarCierrePlancha->id_seguimiento_plancha);
           
        foreach($SeguimientoPlanchaOxigeno as $SeguimientoPlanchaOxigenos )
            {
                $TotalOxigenoUsado = $SeguimientoPlanchaOxigenos->total_oxigeno_usado;
                $TotalLitrosGaseosos = $SeguimientoPlanchaOxigenos->total_litros_gaseosos;
            }

            if(isset($TotalOxigenoUsado) || isset($TotalLitrosGaseosos)) 
            {
                $TotalOxigenoUsado = $SeguimientoPlanchaOxigenos->total_oxigeno_usado;
                $TotalLitrosGaseosos = $SeguimientoPlanchaOxigenos->total_litros_gaseosos;
            }
            else
            {
                $TotalOxigenoUsado = '';
                $TotalLitrosGaseosos = '';
            }
    
        //return view('CentroCorte.OrdenTrabajo.Seguimiento.SeguimientoPDF');
        $pdf = PDF::loadView('CentroCorte.OrdenTrabajo.Cierre.CierrePDF',
        compact(
                'BuscarCierrePlancha',
                'Inserto',
                'CierrePlanchaCortes',
                'TotalAnidadas',
                'TotalCortadas',
                'TotalDanadas',
                'TotalLongitudCorte',
                'TotalPerforaciones',
                'CierrePlanchaSobrante',
                'CierrePlancha',
                'TotalLitrosGaseosos'
            ))->setPaper('letter','landscape');

        return $pdf->stream('CierrePlancha_' . $IdCierrePlancha . '_' . $FechaActual . '.pdf');

    }

    public function EliminarDetalleCortes($id_cierre_pl_cortes)
    {
        try 
        {
            Cenc_CierrePlanchaCortesModel::destroy($id_cierre_pl_cortes);
        }
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('No se pudo eliminar el Registro' . $ex->getMessage());
        }
        return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
    }

  
    public function EliminarDetalleSobrante($id_cierre_pl_sobrante)
    {
        try 
        {
            Cenc_CierrePlanchaSobranteModel::destroy($id_cierre_pl_sobrante);
        }
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('No se pudo eliminar el Registro' . $ex->getMessage());
        }
        return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
    }

}
