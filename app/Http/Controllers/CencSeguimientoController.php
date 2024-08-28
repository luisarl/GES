<?php

namespace App\Http\Controllers;

use App\Http\Requests\CencSeguimientoUpdateRequest;
use App\Models\Cenc_AprovechamientoModel;
use App\Models\Cenc_ConapModel;
use App\Models\Cenc_Aprovechamiento_PlanchasModel;
use App\Models\Cenc_CierreModel;
use App\Models\Cenc_CierrePlanchasModel;
use App\Models\Cenc_OrdenTrabajoModel;
use App\Models\Cenc_OrdenTrabajo_PlanchasModel;
use App\Models\Cenc_SeguimientoModel;
use App\Models\Cenc_SeguimientoPlanchasModel;
use App\Models\Cenc_SeguimientoPlanchaHorometroModel;
use App\Models\Cenc_SeguimientoPlanchaAvanceModel;
use App\Models\Cenc_SeguimientoPlanchaOxigenoModel;
use App\Models\Cenc_SeguimientoPlanchaConsumiblesModel;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CencSeguimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Seguimientos = Cenc_SeguimientoModel::Cenc_SeguimientosVer();
        return view('CentroCorte.OrdenTrabajo.Seguimiento.Seguimiento',compact('Seguimientos'));
    }

    public function buscarInserto($DiametrosInserto)
    {
        $diametrosValidos = $DiametrosInserto->filter(function ($diametro) 
        {
            return $diametro->diametro_perforacion > 0;
        });
        $Inserto = $diametrosValidos->isNotEmpty() ? $diametrosValidos->toArray() : [];

        return $Inserto;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $IdOrdenTrabajoPlancha = (int)$request->query("IdOrdenTrabajoPlancha");
        $OrdenTrabajoPlancha = Cenc_OrdenTrabajo_PlanchasModel::OrdenTrabajoPlanchasBuscar($request->query("IdOrdenTrabajoPlancha"));
        $SeguimientoPlancha = Cenc_SeguimientoPlanchasModel::SeguimientoPlanchaCreate($request->query("IdOrdenTrabajoPlancha"));

        $DiametrosInserto = Cenc_Aprovechamiento_PlanchasModel::BuscarInsertoPlancha($OrdenTrabajoPlancha->id_lista_parte, $OrdenTrabajoPlancha->espesor);
        $Inserto = $this->buscarInserto($DiametrosInserto);

        $SeguimientoPlanchaHorometro = Cenc_SeguimientoPlanchaHorometroModel::Cenc_SeguimientoPlanchaHorometroCrear($IdOrdenTrabajoPlancha);
        $SeguimientoPlanchaOxigeno = Cenc_SeguimientoPlanchaOxigenoModel::Cenc_SeguimientoPlanchaOxigenoCrear($IdOrdenTrabajoPlancha);
        //INFORMACIÓN PARA LA TABLA DE AVANCE
        $SeguimientoPlanchaAvance = Cenc_SeguimientoPlanchaAvanceModel::Cenc_SeguimientoPlanchaAvanceCrear($IdOrdenTrabajoPlancha);
        $SeguimientoPlanchaConsumible = Cenc_SeguimientoPlanchaConsumiblesModel::Cenc_SeguimientoPlanchaConsumibleCrear($IdOrdenTrabajoPlancha);
        
        $ListaNumeroPartes = Cenc_SeguimientoModel::ListaNumeroPartes($OrdenTrabajoPlancha->id_lista_parte,$OrdenTrabajoPlancha->espesor);
        
        $MaterialProcesado = Cenc_Aprovechamiento_PlanchasModel::MaterialProcesadoPlanchaEspesor($OrdenTrabajoPlancha->id_lista_parte, $OrdenTrabajoPlancha->espesor);
        foreach ($MaterialProcesado as $MaterialProcesados)
        {
            $espesor = $MaterialProcesados->espesor;
            $cantidad = $MaterialProcesados->cantidad;
            $peso = $MaterialProcesados->peso;
        }

        return view(
            'CentroCorte.OrdenTrabajo.Seguimiento.SeguimientoEdit',
            compact(
                    'espesor',
                    'cantidad',
                    'peso',
                    'Inserto',
                    'ListaNumeroPartes',
                    'OrdenTrabajoPlancha',
                    'SeguimientoPlancha',
                    'SeguimientoPlanchaHorometro',
                    'SeguimientoPlanchaAvance',
                    'SeguimientoPlanchaOxigeno',
                    'SeguimientoPlanchaConsumible',
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
            $SeguimientoPlancha = Cenc_SeguimientoPlanchasModel::SeguimientoPlanchaEditar((int)$id);
 
            if (isset($SeguimientoPlancha))
            {
                $SeguimientoPlanchaHorometro = Cenc_SeguimientoPlanchaHorometroModel::Cenc_SeguimientoPlanchaHorometroEditar($SeguimientoPlancha->id_seguimiento_plancha);
                $SeguimientoPlanchaAvance = Cenc_SeguimientoPlanchaAvanceModel::Cenc_SeguimientoPlanchaAvanceEditar($SeguimientoPlancha->id_seguimiento_plancha);
                $SeguimientoPlanchaOxigeno = Cenc_SeguimientoPlanchaOxigenoModel::Cenc_SeguimientoPlanchaOxigenoEditar($SeguimientoPlancha->id_seguimiento_plancha);
                $SeguimientoPlanchaConsumible = Cenc_SeguimientoPlanchaConsumiblesModel::Cenc_SeguimientoPlanchaConsumibleEditar($SeguimientoPlancha->id_seguimiento_plancha);
                $OrdenTrabajoPlancha = Cenc_OrdenTrabajo_PlanchasModel::OrdenTrabajoPlanchasBuscar($SeguimientoPlancha->id_orden_trabajo);

                $DiametrosInserto = Cenc_Aprovechamiento_PlanchasModel::BuscarInsertoPlancha($OrdenTrabajoPlancha->id_lista_parte, $OrdenTrabajoPlancha->espesor);
                $Inserto = $this->buscarInserto($DiametrosInserto);
    
                $ListaNumeroPartes = Cenc_SeguimientoModel::ListaNumeroPartes($OrdenTrabajoPlancha->id_lista_parte,$OrdenTrabajoPlancha->espesor);           
                $MaterialProcesado = Cenc_Aprovechamiento_PlanchasModel::MaterialProcesadoPlanchaEspesor($SeguimientoPlancha->id_lista_parte, $SeguimientoPlancha->espesor);
    
                foreach ($MaterialProcesado as $MaterialProcesados)
                {
                    $espesor = $MaterialProcesados->espesor;
                    $cantidad = $MaterialProcesados->cantidad;
                    $peso = $MaterialProcesados->peso;
                }
    
                return view('CentroCorte.OrdenTrabajo.Seguimiento.SeguimientoEdit',
                compact('espesor',
                        'cantidad',
                        'peso',
                        'ListaNumeroPartes',
                        'OrdenTrabajoPlancha',
                        'SeguimientoPlancha',
                        'SeguimientoPlanchaHorometro',
                        'SeguimientoPlanchaAvance',
                        'SeguimientoPlanchaOxigeno',
                        'SeguimientoPlanchaConsumible',
                        'Inserto',
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
    public function update(Request $request, $IdSeguimiento)
    {
        return $this->upsert($request, $IdSeguimiento);
    }

    /**
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function upsert(Request $request, $IdSeguimiento)
    {
        $IdOrdenTrabajoPlancha = (int)$request->query("IdOrdenTrabajoPlancha");
        $id_seguimiento = (int)$IdSeguimiento;

        try {
            DB::transaction(function () use ($request, &$id_seguimiento, $IdOrdenTrabajoPlancha) {
                $IdUsuario = Auth::user()->id;
                $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
                $data = json_decode($request['datos_seguimiento']);

                $tabla_horometro = $data->tabla_horometro;
                $tabla_avance = $data->tabla_avance;
                $total_prod_cant_piezas_avance = $data->total_prod_cant_piezas_avance;
                $total_prod_peso_total_avance = $data->total_prod_peso_total_avance;
                $total_pend_cant_piezas_avance = $data->total_pend_cant_piezas_avance;
                $total_pend_peso_avance = $data->total_pend_peso_avance;
                $tabla_oxigeno = $data->tabla_oxigeno;
                $total_oxigeno_usados = $data->total_oxigeno_usados;
                $total_litros_gaseosos = $data->total_litros_gaseosos;
                $tabla_consumibles = $data->tabla_consumibles;

                if ($id_seguimiento == '')
                {
                    $id_seguimiento = Cenc_SeguimientoModel::max('id_seguimiento') + 1;
                }
                else
                {
                    $DatosSeguimiento = Cenc_SeguimientoModel::Cenc_SeguimientosDatosBuscar($id_seguimiento);
                    $IdOrdenTrabajoPlancha = $DatosSeguimiento->id_orden_trabajo_plancha;
                }

                $DatosOrden = Cenc_OrdenTrabajo_PlanchasModel::OrdenTrabajoPlanchasVer($IdOrdenTrabajoPlancha);

                // 1. TABLA SEGUIMIENTO
                Cenc_SeguimientoModel::updateOrCreate(
                    [
                        'id_seguimiento'    => $id_seguimiento,
                    ],
                    [
                        'id_seguimiento'               => $id_seguimiento,
                        'id_orden_trabajo_plancha'     => (int)$IdOrdenTrabajoPlancha,
                        'estatus'                      => 'EN PROCESO',
                        'creado_por'                   => $IdUsuario,
                        'fecha_creado'                 => $FechaActual,
                        'enproceso_por'                => $IdUsuario,
                        'fecha_enproceso'              => $FechaActual,
                    ]
                );

                $ExisteIdSeguimientoPlancha = Cenc_SeguimientoPlanchasModel::BuscarIdOrdenPlancha($id_seguimiento);

                $id_seguimiento_plancha = 0;

                if (isset($ExisteIdSeguimientoPlancha)) {
                    $IdSeguimientoPlancha = (int)$ExisteIdSeguimientoPlancha->id_seguimiento_plancha;
                    $id_seguimiento_plancha = $IdSeguimientoPlancha;
                } else {
                    $id_seguimiento_plancha = Cenc_SeguimientoPlanchasModel::max('id_seguimiento_plancha') + 1;
                }

                $espesor = (float)$DatosOrden->espesor;

                // 2. TABLA SEGUIMIENTO PLANCHA
                Cenc_SeguimientoPlanchasModel::updateOrCreate(
                    [
                        'id_seguimiento_plancha'    => $id_seguimiento_plancha,
                    ],
                    [
                        'id_seguimiento_plancha'       => $id_seguimiento_plancha,
                        'id_seguimiento'               => $id_seguimiento,
                        'espesor'                      => $espesor,
                    ]
                );

                $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
                $estatus = 'EN PROCESO';

                // 3. TABLA ORDEN DE TRABAJO
                Cenc_OrdenTrabajoModel::where('id_orden_trabajo', '=', (int)$IdOrdenTrabajoPlancha)->update(
                    [
                        'enproceso_por'      => Auth::user()->id,
                        'fecha_enproceso'    => $FechaActual,
                        'estatus'            => $estatus
                    ]
                );

                // 3. TABLA SEGUIMIENTO HOROMETRO
                foreach ($tabla_horometro as $tabla_horometros)
                {
                    if ($tabla_horometros->id_seguimiento_pl_horometro == '')
                    {
                        $TablaHorometro = Cenc_SeguimientoPlanchaHorometroModel::max('id_seguimiento_pl_horometro') + 1;
                    }
                    else
                    {
                        $TablaHorometro = $tabla_horometros->id_seguimiento_pl_horometro;
                    }

                Cenc_SeguimientoPlanchaHorometroModel::updateOrCreate(
                     [
                         'id_seguimiento_pl_horometro'    => $TablaHorometro,
                     ],
                     [
                         'id_seguimiento_pl_horometro'       => $TablaHorometro,
                         'id_seguimiento_plancha'            => $id_seguimiento_plancha,
                         'horometro_inicial_on'              => $tabla_horometros->horometro_inicial_on,
                         'horometro_final_on'                => $tabla_horometros->horometro_final_on,
                         'horas_hms_on'                      => $tabla_horometros->horas_maquina_on,
                         'horas_on'                          => $tabla_horometros->horas_on,
                         'total_horas_on'                    => $tabla_horometros->total_horas_on,
                         'horometro_inicial_aut'             => $tabla_horometros->horometro_inicial_aut,
                         'horometro_final_aut'               => $tabla_horometros->horometro_final_aut,
                         'tiempo_hms_aut'                    => $tabla_horometros->tiempo_modo_aut,
                         'tiempo_aut'                        => $tabla_horometros->tiempo_aut,
                         'total_tiempo_aut'                  => $tabla_horometros->total_tiempo_aut,
                         'creado_por'                        => $IdUsuario,
                         'fecha_creado'                      => $tabla_horometros->fecha_creado,
                     ]);
                }

                // 5. TABLA SEGUIMIENTO AVANCE
                foreach ($tabla_avance as $tabla_avances)
                {
                    if ($tabla_avances->id_seguimiento_pl_avance == '')
                    {
                        $TablaAvance = Cenc_SeguimientoPlanchaAvanceModel::max('id_seguimiento_pl_avance') + 1;
                    }
                    else
                    {
                        $TablaAvance = $tabla_avances->id_seguimiento_pl_avance;
                    }

                Cenc_SeguimientoPlanchaAvanceModel::updateOrCreate(
                    [
                        'id_seguimiento_pl_avance'    => $TablaAvance,
                    ],
                    [
                        'id_seguimiento_pl_avance'       => $TablaAvance,
                        'id_seguimiento_plancha'         => $id_seguimiento_plancha,
                        'nro_partes'                     => $tabla_avances->numero_parte,
                        'descripcion'                    => $tabla_avances->descripcion_nroparte,
                        'dimensiones'                    => $tabla_avances->dimensiones_nroparte,
                        'cantidad_piezas'                => $tabla_avances->cant_piezas_nroparte,
                        'peso_unitario'                  => $tabla_avances->peso_unit_nroparte,
                        'peso_total'                     => $tabla_avances->peso_total_nroparte,
                        'avance_cant_piezas'             => $tabla_avances->cant_piezas_avance,
                        'avance_peso'                    => $tabla_avances->peso_avance,
                        'pendiente_cant_piezas'          => $tabla_avances->cant_piezas_pendiente,
                        'pendiente_peso'                 => $tabla_avances->peso_pendiente,
                        'prod_cant_piezas_avance'        => $total_prod_cant_piezas_avance,
                        'prod_peso_total_avance'         => $total_prod_peso_total_avance,
                        'pend_cant_piezas_avance'        => $total_pend_cant_piezas_avance,
                        'pend_peso_avance'               => $total_pend_peso_avance,
                        'creado_por'                     => $IdUsuario,
                        'fecha_creado'                   => $tabla_avances->fecha_creado,
                    ]);
                }

                // 6. TABLA SEGUIMIENTO OXIGENO
                foreach ($tabla_oxigeno as $tabla_oxigenos)
                 {
                    if ($tabla_oxigenos->id_seguimiento_pl_oxigeno == '')
                    {
                         $TablaOxigeno = Cenc_SeguimientoPlanchaOxigenoModel::max('id_seguimiento_pl_oxigeno') + 1;
                    }
                    else
                    {
                         $TablaOxigeno = $tabla_oxigenos->id_seguimiento_pl_oxigeno;
                    }

                 Cenc_SeguimientoPlanchaOxigenoModel::updateOrCreate(
                    [
                         'id_seguimiento_pl_oxigeno'    => $TablaOxigeno,
                    ],
                    [
                         'id_seguimiento_pl_oxigeno'      => $TablaOxigeno,
                         'id_seguimiento_plancha'         => $id_seguimiento_plancha,
                         'oxigeno_inicial'                => $tabla_oxigenos->oxigeno_inicial,
                         'oxigeno_final'                  => $tabla_oxigenos->oxigeno_final,
                         'oxigeno_usado'                  => $tabla_oxigenos->oxigeno_usado,
                         'cambio'                         => $tabla_oxigenos->cambio,
                         'litros_gaseosos'                => $tabla_oxigenos->litros_gaseosos,
                         'total_oxigeno_usado'            => $total_oxigeno_usados,
                         'total_litros_gaseosos'          => $total_litros_gaseosos,
                         'creado_por'                     => $IdUsuario,
                         'fecha_creado'                   => $tabla_oxigenos->fecha_creado,
                    ]);
                }

                // 7. TABLA CIERRE CONSUMIBLE
                foreach ($tabla_consumibles as $tabla_consumible)
                {
                    if ($tabla_consumible->id_seguimiento_pl_consumible == '')
                    {
                        $TablaConsumible = Cenc_SeguimientoPlanchaConsumiblesModel::max('id_seguimiento_pl_consumible') + 1;
                    }
                    else
                    {
                        $TablaConsumible = $tabla_consumible->id_seguimiento_pl_consumible;
                    }

                    Cenc_SeguimientoPlanchaConsumiblesModel::updateOrCreate(
                    [
                        'id_seguimiento_pl_consumible'    => $TablaConsumible,
                    ],
                    [
                        'id_seguimiento_pl_consumible'    => $TablaConsumible,
                        'id_seguimiento_plancha'     => $id_seguimiento_plancha,
                        'consumible'                 => $tabla_consumible->consumible_usado,
                        'consumo'                    => $tabla_consumible->consumo_consumible,
                        'unidad'                     => $tabla_consumible->unidad_consumible,
                        'observaciones'              => $tabla_consumible->observacion_consumible,
                        'creado_por'                 => $IdUsuario,
                        'fecha_creado'               => $tabla_consumible->fecha_creado,
                    ]);
                  }

            });
        } 
        catch (Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error al crear el Seguimiento ' . $ex->getMessage())->withInput();
        }
        return redirect()->route('cencseguimiento.edit', $id_seguimiento)->withSuccess('Se Ha Actualizado Exitosamente');
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdOrdenTrabajoPlancha)
    {
        $OrdenTrabajoPlancha = Cenc_OrdenTrabajo_PlanchasModel::OrdenTrabajoPlanchasBuscar($IdOrdenTrabajoPlancha);

        $Seguimiento = Cenc_SeguimientoModel::BuscarIdSeguimiento($IdOrdenTrabajoPlancha);
        
        $SeguimientoPlanchaHorometro = Cenc_SeguimientoPlanchaHorometroModel::Cenc_SeguimientoPlanchaHorometroCrear($IdOrdenTrabajoPlancha);
            foreach($SeguimientoPlanchaHorometro as $SeguimientoPlanchaHorometros)
            {
                $TotalHorasOn = $SeguimientoPlanchaHorometros->total_horas_on;
                $TotalTiempoAut = $SeguimientoPlanchaHorometros->total_tiempo_aut;

            }

            if(isset($TotalHorasOn) || isset($TotalTiempoAut))
            {
                $TotalHorasOn = $SeguimientoPlanchaHorometros->total_horas_on;
                $TotalTiempoAut = $SeguimientoPlanchaHorometros->total_tiempo_aut;

            }
            else
            {
                $TotalHorasOn = '';
                $TotalTiempoAut = '';
            }

        $SeguimientoPlanchaOxigeno = Cenc_SeguimientoPlanchaOxigenoModel::Cenc_SeguimientoPlanchaOxigenoCrear($IdOrdenTrabajoPlancha);

            foreach($SeguimientoPlanchaOxigeno as $SeguimientoPlanchaOxigenos)
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
                $TotalOxigenoUsado = 0;
                $TotalLitrosGaseosos = 0;
            }

        $SeguimientoPlanchaAvance = Cenc_SeguimientoPlanchaAvanceModel::Cenc_SeguimientoPlanchaAvanceCrear($IdOrdenTrabajoPlancha);
            foreach($SeguimientoPlanchaAvance as $SeguimientoPlanchaAvances)
            {
                $prod_cant_piezas_avance = $SeguimientoPlanchaAvances->prod_cant_piezas_avance;
                $prod_peso_total_avance = $SeguimientoPlanchaAvances->prod_peso_total_avance;
                $pend_cant_piezas_avance = $SeguimientoPlanchaAvances->pend_cant_piezas_avance;
                $pend_peso_avance = $SeguimientoPlanchaAvances->pend_peso_avance;
            }

            if(isset($prod_cant_piezas_avance) || isset($prod_peso_total_avance)  || isset($pend_cant_piezas_avance)  || isset($pend_peso_avance)) 
            {
                $prod_cant_piezas_avance = $SeguimientoPlanchaAvances->prod_cant_piezas_avance;
                $prod_peso_total_avance = $SeguimientoPlanchaAvances->prod_peso_total_avance;
                $pend_cant_piezas_avance = $SeguimientoPlanchaAvances->pend_cant_piezas_avance;
                $pend_peso_avance = $SeguimientoPlanchaAvances->pend_peso_avance;
            }
            else
            {
                $prod_cant_piezas_avance = '';
                $prod_peso_total_avance = 0;
                $pend_cant_piezas_avance = '';
                $pend_peso_avance = 0;
            }

            $SeguimientoPlanchaConsumible = Cenc_SeguimientoPlanchaConsumiblesModel::Cenc_SeguimientoPlanchaConsumibleCrear($IdOrdenTrabajoPlancha);

            foreach($SeguimientoPlanchaConsumible as $SeguimientoPlanchaConsumibles)
            {
                if ($SeguimientoPlanchaConsumibles->consumible == 'OXIGENO')
                {
                    $consumo_oxigeno = $SeguimientoPlanchaConsumibles->consumo; 
                }
                if(isset($consumo_oxigeno))
                {
                    $consumo_oxigeno = $SeguimientoPlanchaConsumibles->consumo; 
                }
                else
                {
                    $consumo_oxigeno = 0;
                }


                if ($SeguimientoPlanchaConsumibles->consumible == 'GAS PROPANO')
                {
                    $consumo_gaspropano = $SeguimientoPlanchaConsumibles->consumo; 
                }
                if(isset($consumo_gaspropano))
                {
                    $consumo_gaspropano = $SeguimientoPlanchaConsumibles->consumo; 
                }
                else
                {
                    $consumo_gaspropano = 0;
                }
            }

        $ListaNumeroPartes = Cenc_SeguimientoModel::ListaNumeroPartes($OrdenTrabajoPlancha->id_lista_parte,$OrdenTrabajoPlancha->espesor);
        $MaterialProcesado = Cenc_Aprovechamiento_PlanchasModel::MaterialProcesadoPlanchaEspesor($OrdenTrabajoPlancha->id_lista_parte, $OrdenTrabajoPlancha->espesor);
            foreach ($MaterialProcesado as $MaterialProcesados)
            {
                $espesor = $MaterialProcesados->espesor;
                $cantidad = $MaterialProcesados->cantidad;
                $peso = $MaterialProcesados->peso;
            }

        return view('CentroCorte.OrdenTrabajo.Seguimiento.SeguimientoShow',
        compact(
                'espesor',
                'cantidad',
                'peso',
                'ListaNumeroPartes',
                'OrdenTrabajoPlancha',
                'SeguimientoPlanchaHorometro',
                'TotalHorasOn',
                'TotalTiempoAut',
                'SeguimientoPlanchaOxigeno',
                'TotalOxigenoUsado',
                'TotalLitrosGaseosos',
                'SeguimientoPlanchaAvance',
                'prod_cant_piezas_avance',
                'prod_peso_total_avance',
                'pend_cant_piezas_avance',
                'pend_peso_avance',
                'Seguimiento',
                'SeguimientoPlanchaConsumible'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function EliminarDetalleHorometro($id_seguimiento_pl_horometro)
    {
        try 
        {
            Cenc_SeguimientoPlanchaHorometroModel::destroy($id_seguimiento_pl_horometro);
        }
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('No se pudo eliminar el Registro' . $ex->getMessage());
        }
        return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
    }

    public function EliminarDetalleAvance($id_seguimiento_pl_avance)
    {
        try 
        {
            Cenc_SeguimientoPlanchaAvanceModel::destroy($id_seguimiento_pl_avance);
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('No se pudo eliminar el Registro' . $ex->getMessage());
        }
        return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
    }

    public function EliminarDetalleOxigeno($id_seguimiento_pl_oxigeno)
    {
        try 
        {
            Cenc_SeguimientoPlanchaOxigenoModel::destroy($id_seguimiento_pl_oxigeno);
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('No se pudo eliminar el Registro' . $ex->getMessage());
        }
        return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
    }

    public function EliminarDetalleConsumible($id_seguimiento_pl_consumible)
    {
        try 
        {
            Cenc_SeguimientoPlanchaConsumiblesModel::destroy($id_seguimiento_pl_consumible);
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('No se pudo eliminar el Registro' . $ex->getMessage());
        }
        return redirect()->back()->withSuccess('El registro Ha Sido Eliminado Exitosamente');
    }


    public function FinalizarSeguimiento($id)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
        $estatus = 'FINALIZADO';
        $id_cierre = Cenc_CierreModel::max('id_cierre') + 1;
        
        try 
        {
            DB::transaction(function () use ($FechaActual, $estatus, $id, $id_cierre) {
                Cenc_SeguimientoModel::where('id_seguimiento', '=', $id)->update(
                    [
                        'finalizado_por'      => Auth::user()->id, 
                        'fecha_finalizado'    => $FechaActual, 
                        'estatus'             => $estatus
                    ]
                );

                $BuscarOrdenTrabajoConIdSeguimiento = Cenc_OrdenTrabajoModel::BuscarOrdenTrabajoConIdSeguimiento($id);
                foreach ($BuscarOrdenTrabajoConIdSeguimiento as $BuscarOrdenTrabajoConIdSeguimientos)
                {
                    $IdOrdenTrabajo = (int)$BuscarOrdenTrabajoConIdSeguimientos->id_orden_trabajo;
                }
           
                // Cenc_OrdenTrabajoModel::where('id_orden_trabajo', '=', $IdOrdenTrabajo)->update(
                // [
                //     'finalizado_por'      => Auth::user()->id, 
                //     'fecha_finalizado'    => $FechaActual, 
                //     'estatus'             => $estatus
                // ]
                // );

                $OrdenTrabajo = Cenc_OrdenTrabajoModel::MostrarOrdenTrabajoEditar($IdOrdenTrabajo);
                $IdAprovechamiento = (int)$OrdenTrabajo->id_aprovechamiento;
                $IdConap = (int)$OrdenTrabajo->id_conap;

                Cenc_AprovechamientoModel::where('id_aprovechamiento', '=', $IdAprovechamiento)->update(
                    [
                        'finalizado_por'     => Auth::user()->id, 
                        'fecha_finalizado'   => $FechaActual, 
                        'estatus'            => $estatus
                    ]
                );

                Cenc_ConapModel::where('id_conap', '=', $IdConap)->update(
                    [
                        'finalizado_por'     => Auth::user()->id, 
                        'fecha_finalizado'   => $FechaActual, 
                        'estatus_conap'      => $estatus
                    ]
                );

                Cenc_CierreModel::create([
                        'id_cierre'          => $id_cierre,
                        'id_seguimiento'     => $id,
                        'creado_por'         => Auth::user()->id, 
                        'fecha_creado'       => $FechaActual, 
                ]);

                $id_cierre_planchas = Cenc_CierrePlanchasModel::max('id_cierre_planchas') + 1;
                Cenc_CierrePlanchasModel::create([
                        'id_cierre_planchas'     => $id_cierre_planchas,
                        'id_cierre'              => $id_cierre,
                ]);
            });

        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Finalizar El Seguimiento. '.$ex->getMessage())->withInput();
        }
        return redirect()->route("cenccierre.edit", $id_cierre)->withSuccess("El Seguimiento Ha Finalizado Y Se Ha Creado Un Cierre Del Seguimiento");
    }

    public function ImprimirSeguimiento($IdSeguimiento)
    {
        // $BuscarIdSeguimiento = Cenc_SeguimientoPlanchasModel::BuscarIdSeguimiento($IdSeguimientoPlancha);
        $BuscarSeguimiento = Cenc_SeguimientoModel::Cenc_SeguimientosBuscar((int)$IdSeguimiento);
        $IdSeguimientoPlancha = (int)$BuscarSeguimiento->id_seguimiento_plancha;
        $IdOrdenTrabajoPlancha = (int)$BuscarSeguimiento->id_orden_trabajo_plancha;

       //dd($IdOrdenTrabajoPlancha);

        $SeguimientoPlanchaHorometro = Cenc_SeguimientoPlanchaHorometroModel::Cenc_SeguimientoPlanchaHorometroEditar($IdSeguimientoPlancha);
            foreach($SeguimientoPlanchaHorometro as $SeguimientoPlanchaHorometros )
            {
                $TotalHorasOn = $SeguimientoPlanchaHorometros->total_horas_on;
                $TotalTiempoAut = $SeguimientoPlanchaHorometros->total_tiempo_aut;
            }

            if(isset($TotalHorasOn) || isset($TotalTiempoAut))
            {
                $TotalHorasOn = $SeguimientoPlanchaHorometros->total_horas_on;
                $TotalTiempoAut = $SeguimientoPlanchaHorometros->total_tiempo_aut;
            }
            else
            {
                $TotalHorasOn = '';
                $TotalTiempoAut = '';
            }

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

        $SeguimientoPlanchaAvance = Cenc_SeguimientoPlanchaAvanceModel::Cenc_SeguimientoPlanchaAvanceEditar($IdSeguimientoPlancha);
            foreach($SeguimientoPlanchaAvance as $SeguimientoPlanchaAvances)
            {
                $prod_cant_piezas_avance = $SeguimientoPlanchaAvances->prod_cant_piezas_avance;
                $prod_peso_total_avance = $SeguimientoPlanchaAvances->prod_peso_total_avance;
                $pend_cant_piezas_avance = $SeguimientoPlanchaAvances->pend_cant_piezas_avance;
                $pend_peso_avance = $SeguimientoPlanchaAvances->pend_peso_avance;
            }

            if(isset($prod_cant_piezas_avance) || isset($prod_peso_total_avance)  || isset($pend_cant_piezas_avance)  || isset($pend_peso_avance)) 
            {
                $prod_cant_piezas_avance = $SeguimientoPlanchaAvances->prod_cant_piezas_avance;
                $prod_peso_total_avance = $SeguimientoPlanchaAvances->prod_peso_total_avance;
                $pend_cant_piezas_avance = $SeguimientoPlanchaAvances->pend_cant_piezas_avance;
                $pend_peso_avance = $SeguimientoPlanchaAvances->pend_peso_avance;
            }
            else
            {
                $prod_cant_piezas_avance = '';
                $prod_peso_total_avance = 0;
                $pend_cant_piezas_avance = '';
                $pend_peso_avance = 0;
            }

            $SeguimientoPlanchaConsumible = Cenc_SeguimientoPlanchaConsumiblesModel::Cenc_SeguimientoPlanchaConsumibleEditar($IdSeguimientoPlancha);

            foreach($SeguimientoPlanchaConsumible as $SeguimientoPlanchaConsumibles)
            {
                if ($SeguimientoPlanchaConsumibles->consumible == 'OXIGENO')
                {
                    $consumo_oxigeno = $SeguimientoPlanchaConsumibles->consumo; 
                }
                if(isset($consumo_oxigeno))
                {
                    $consumo_oxigeno = $SeguimientoPlanchaConsumibles->consumo; 
                }
                else
                {
                    $consumo_oxigeno = 0;
                }


                if ($SeguimientoPlanchaConsumibles->consumible == 'GAS PROPANO')
                {
                    $consumo_gaspropano = $SeguimientoPlanchaConsumibles->consumo; 
                }
                if(isset($consumo_gaspropano))
                {
                    $consumo_gaspropano = $SeguimientoPlanchaConsumibles->consumo; 
                }
                else
                {
                    $consumo_gaspropano = 0;
                }
            }

        $BuscarOrdenTrabajo = Cenc_SeguimientoModel::MostrarOrdenTrabajoSeguimiento($IdOrdenTrabajoPlancha);

        $ListaNumeroPartes = Cenc_SeguimientoModel::ListaNumeroPartes($BuscarOrdenTrabajo->id_lista_parte,$BuscarOrdenTrabajo->espesor);
        $MaterialProcesado = Cenc_Aprovechamiento_PlanchasModel::MaterialProcesadoPlanchaEspesor($BuscarOrdenTrabajo->id_lista_parte, $BuscarOrdenTrabajo->espesor);
        foreach ($MaterialProcesado as $MaterialProcesados)
            {
                $espesor = $MaterialProcesados->espesor;
                $cantidad = $MaterialProcesados->cantidad;
                $peso = $MaterialProcesados->peso;
            }
        
        //dd($BuscarOrdenTrabajo);

        //return view('CentroCorte.OrdenTrabajo.Seguimiento.SeguimientoPDF');
        $pdf = PDF::loadView('CentroCorte.OrdenTrabajo.Seguimiento.SeguimientoPDF',
        compact(
            'BuscarOrdenTrabajo',
            'BuscarSeguimiento',
            'SeguimientoPlanchaHorometro',
            'TotalHorasOn',
            'TotalTiempoAut',
            'SeguimientoPlanchaAvance',
            'prod_cant_piezas_avance',
            'prod_peso_total_avance',
            'pend_cant_piezas_avance',
            'pend_peso_avance',
            'espesor',
            'cantidad',
            'peso',
            'ListaNumeroPartes',
            'SeguimientoPlanchaOxigeno',
            'TotalOxigenoUsado',
            'TotalLitrosGaseosos',
            'SeguimientoPlanchaConsumible'
            ))->setPaper('letter','landscape');

        return $pdf->stream('SeguimientoPlancha.pdf');
    }

    public function BuscarNumeroParte($IdListaParte, $IdListaPartePlancha)
    {
        $NumeroParte = Cenc_SeguimientoModel::InformacionNumeroParte($IdListaParte, $IdListaPartePlancha);
        return with(["nro_partes" => $NumeroParte]);

    }
}