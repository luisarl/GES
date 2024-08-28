<?php

namespace App\Http\Controllers;

use App\Models\Cenc_AprovechamientoModel;
use App\Models\Cenc_ConapModel;
use App\Models\Cenc_Conap_DocumentosModel;
use App\Models\Cenc_Aprovechamiento_DocumentosModel;
use App\Models\Cenc_OrdenTrabajoModel;
use App\Models\Cenc_OrdenTrabajo_PlanchasModel;
use App\Models\Cenc_OrdenTrabajoSobranteModel;
use App\Models\Cenc_SeguimientoPlanchasModel;
use App\Models\Cenc_SeguimientoPlanchaHorometroModel;
use App\Models\Cenc_SeguimientoPlanchaCortesModel;
use App\Models\Cenc_SeguimientoPlanchaAvanceModel;
use App\Models\Cenc_SeguimientoPlanchaOxigenoModel;
use App\Models\Cenc_SeguimientoPlanchaConsumiblesModel;
use App\Models\Cenc_Aprovechamiento_Plancha_Materia_PrimaModel;
use App\Models\Cenc_Aprovechamiento_Plancha_Area_CorteModel;
use App\Models\Cenc_Aprovechamiento_PlanchasModel;
use App\Models\Cenc_CierreModel;
use App\Models\Cenc_CierrePlanchaConsumiblesModel;
use App\Models\Cenc_CierrePlanchaCortesModel;
use App\Models\Cenc_CierrePlanchaSobranteModel;
use App\Models\Cenc_SeguimientoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
class CencOrdenTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $OrdenesTrabajos = Cenc_OrdenTrabajoModel::OrdenesTrabajos();
        return view('CentroCorte.OrdenTrabajo.Orden.OrdenTrabajo', compact('OrdenesTrabajos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('CentroCorte.OrdenTrabajo.Orden.OrdenTrabajoCreate');
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
 
    function ObtenerEspesores($items) {
        $espesores = [];
    
        foreach ($items as $item) {
            $espesores[] = $item->espesor;
        }
    
        return $espesores;
    }

    function ObtenerListaPartes($items) {
        $listapartes = [];
    
        foreach ($items as $item) {
            $listapartes[] = $item->id_lista_parte;
        }
    
        return $listapartes;
    }

    function ObtenerAprovechamientos($items) {
        $aprovechamiento = [];
    
        foreach ($items as $item) {
            $aprovechamiento[] = $item->id_aprovechamiento;
        }
    
        return $aprovechamiento;
    }
    
    function ObtenerCentroTrabajo($items) {
        $CentroTrabajo = [];
    
        foreach ($items as $item) {
            $CentroTrabajo[] = $item->nombre_equipo;
        }
    
        return $CentroTrabajo;
    }

     
    function ObtenerTecnologia($items) {
        $Tecnologia = [];
    
        foreach ($items as $item) {
            $Tecnologia[] = $item->nombre_tecnologia;
        }
    
        return $Tecnologia;
    }

    function ObtenerSeguimiento($items) {
        $Seguimiento = [];
    
        foreach ($items as $item) {
            $Seguimiento[] = $item->id_seguimiento;
        }
    
        return $Seguimiento;
    }

    function ObtenerTotalesHorasOnEjecutadoHorometro($items) 
    {
        $datosAgrupados = [];
        foreach ($items as $item) 
        {
            $idSeguimiento = $item->id_seguimiento_plancha;
            $datosAgrupados[$idSeguimiento][] = $item;
        }
    
        return array_column(
            array_map(function ($grupo) {
                return [
                    'total_horas' => array_reduce($grupo, function ($total, $item) {
                        return $total + $item->horas_on;
                    }, 0),
                ];
            }, $datosAgrupados),
            'total_horas'
        );
    }

    function ObtenerTotalesHorometro($seguimientos)
    {
        $seguimientosArray = $seguimientos->toArray();

        return array_reduce($seguimientosArray, function ($resultados, $seguimiento) {
            $idSeguimiento = $seguimiento->id_seguimiento_plancha;

            if (!isset($resultados[$idSeguimiento])) {
                $resultados[$idSeguimiento] = [
                    'horas_on' => 0,
                    'tiempo_aut' => 0,
                    'espesor' => $seguimiento->espesor
                ];
            }
            $resultados[$idSeguimiento]['horas_on'] += $seguimiento->horas_on;
            $resultados[$idSeguimiento]['tiempo_aut'] += $seguimiento->tiempo_aut;

            return $resultados;
        }, []);
    }
    
    function ObtenerTotalesAvance($datos) 
    {
        $resultado = [];
        foreach ($datos as $item) {
            $clave = $item->id_seguimiento_plancha . '_' . $item->nro_partes . '_' . $item->descripcion . '_' . $item->id_aprovechamiento . '_' . $item->espesor;
            if (!isset($resultado[$clave])) {
                $resultado[$clave] = [
                    'id_seguimiento_plancha' => $item->id_seguimiento_plancha,
                    'id_aprovechamiento' => $item->id_aprovechamiento,
                    'espesor' => $item->espesor,
                    'nro_partes' => $item->nro_partes,
                    'descripcion' => $item->descripcion,
                    'avance_cant_piezas' => 0,
                    'avance_peso' => 0.0
                ];
            }
            $resultado[$clave]['avance_cant_piezas'] += $item->avance_cant_piezas;
            $resultado[$clave]['avance_peso'] += $item->avance_peso;
        }
        return array_values($resultado);
    }

    function ObtenerTotaleCortes($items)
    {
        $resultado = [];
        foreach ($items as $item)
        {
            $clave = $item->id_cierre_planchas . '_' . $item->espesor . '_' . $item->cnc_aprovechamiento . '_' . $item->piezas_anidadas . '_' . 
            $item->piezas_cortadas . '_' . $item->piezas_danadas . '_' . $item->longitud_corte . '_' . $item->numero_perforaciones;

            if (!isset($resultado[$clave]))
            {
                $resultado[$clave] = [
                    'id_cierre_planchas'    => $item->id_cierre_planchas,
                    'espesor'               => $item->espesor,
                    'cnc_aprovechamiento'   => $item->cnc_aprovechamiento,
                    'piezas_anidadas'       => $item->piezas_anidadas,
                    'piezas_cortadas'       => $item->piezas_cortadas,
                    'piezas_danadas'        => $item->piezas_danadas,
                    'longitud_corte'        => $item->longitud_corte,
                    'numero_perforaciones'  => $item->numero_perforaciones,
                ];
            }
            $resultado[$clave]['piezas_anidadas'] += $item->piezas_anidadas;
            $resultado[$clave]['piezas_cortadas'] += $item->piezas_cortadas;
            $resultado[$clave]['piezas_danadas'] += $item->piezas_danadas;
            $resultado[$clave]['longitud_corte'] += $item->longitud_corte;
            $resultado[$clave]['numero_perforaciones'] += $item->numero_perforaciones;
        }
        return array_values($resultado);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdOrdenTrabajo)
    {
        $OrdenTrabajo = Cenc_OrdenTrabajoModel::MostrarOrdenTrabajoEditar($IdOrdenTrabajo);

        $estimados = Cenc_OrdenTrabajoModel::MostrarEstimadosAsociadaAOrdenTrabajo($IdOrdenTrabajo);
        $IdOrdenTrabajoPlancha = Cenc_OrdenTrabajoModel::BuscarIdOrdenTrabajoPlancha($IdOrdenTrabajo);
        $TiempoEjecutado = [];
        $OxigenoUsado = [];
        $GasUsado = [];
        $Cierre = 0;
        
        $SeguimientoPlanchaHorometro = Cenc_OrdenTrabajoModel::Cenc_DatosSeguimientoPlanchaHorometro($IdOrdenTrabajo);
        $TiempoEjecutado = $this->ObtenerTotalesHorasOnEjecutadoHorometro($SeguimientoPlanchaHorometro);

        $Espesores = $this->ObtenerEspesores($SeguimientoPlanchaHorometro);
        $Seguimiento = $this->ObtenerSeguimiento($SeguimientoPlanchaHorometro);
        $ListaPartes = $this->ObtenerListaPartes($SeguimientoPlanchaHorometro);
        $Aprovechamiento = $this->ObtenerAprovechamientos($SeguimientoPlanchaHorometro);
        $CentroTrabajo = $this->ObtenerCentroTrabajo($SeguimientoPlanchaHorometro);
        $Tecnologia = $this->ObtenerTecnologia($SeguimientoPlanchaHorometro);

        foreach($TiempoEjecutado as $index => $tiempoEjecutado)
        {
            $Cierre = Cenc_CierreModel::Cenc_BuscarCierreIdSeguimiento((int)$Seguimiento[$index]);

            if (isset($Cierre)) 
            {
                $Cierre = Cenc_CierreModel::Cenc_BuscarCierreIdSeguimiento((int)$Seguimiento[$index]);
            }
            else
            {
                $Cierre = 0;
            }
        }

        foreach ($IdOrdenTrabajoPlancha as $IdOrdenTrabajoPlancha) 
        {
            $SeguimientoPlanchaOxigeno = Cenc_SeguimientoPlanchaOxigenoModel::Cenc_SeguimientoPlanchaOxigenoCrear((int)$IdOrdenTrabajoPlancha->id_orden_trabajo_plancha);
            foreach ($SeguimientoPlanchaOxigeno as $SeguimientoPlanchaOxigenos) 
            {
                $TotalOxigenoUsado = $SeguimientoPlanchaOxigenos->total_oxigeno_usado;
                $TotalLitrosGaseosos = $SeguimientoPlanchaOxigenos->total_litros_gaseosos;

                if (isset($TotalOxigenoUsado) || isset($TotalLitrosGaseosos)) 
                {
                    $TotalOxigenoUsado = $SeguimientoPlanchaOxigenos->total_oxigeno_usado;
                    $TotalLitrosGaseosos = $SeguimientoPlanchaOxigenos->total_litros_gaseosos;
                } 
                else
                {
                    $TotalOxigenoUsado = 0;
                    $TotalLitrosGaseosos = 0;
                }
                $OxigenoUsado[] = $TotalLitrosGaseosos;
            }
        }

        $ConsumoGas = Cenc_OrdenTrabajoModel::ConsumoGas($IdOrdenTrabajo);

            foreach ($ConsumoGas as $ConsumoGasP)
            {
                $consumo_gas = $ConsumoGasP->consumo_gas;
                $GasUsado[] = $consumo_gas;
            }

        $AprovechamientosPlanchas = Cenc_OrdenTrabajoModel::BuscarIdAprovechamientosPlanchas($IdOrdenTrabajo);
        $MateriaPrima = collect();
        $AreaCorte = collect();

        foreach ($AprovechamientosPlanchas as $AprovechamientosPlancha)
        {
            $MateriaPrima = $MateriaPrima->merge(Cenc_OrdenTrabajoModel::ObtenerMateriasPrimasAprovechamiento((int)$AprovechamientosPlancha->id_aprovechamiento_plancha));
            $AreaCorte = $AreaCorte->merge(Cenc_OrdenTrabajoModel::ObtenerAreaCorteAprovechamiento((int)$AprovechamientosPlancha->id_aprovechamiento_plancha));
        }
        $MateriaPrima = $MateriaPrima->flatten()->toArray();
        $AreaCorte = $AreaCorte->flatten()->toArray();

        $TiemposHorometros = $this->ObtenerTotalesHorometro($SeguimientoPlanchaHorometro);

        $SeguimientoPlanchaAvance = Cenc_OrdenTrabajoModel::Cenc_DatosSeguimientoPlanchaAvance($IdOrdenTrabajo);
        $TotalAvance = $this->ObtenerTotalesAvance($SeguimientoPlanchaAvance);

        $CierreSeguimientoCortes = Cenc_OrdenTrabajoModel::Cenc_DatosCierrePlanchaCortes($IdOrdenTrabajo);
        $TotalCortes = $this->ObtenerTotaleCortes($CierreSeguimientoCortes);

        $CierrePlanchaSobrante = Cenc_OrdenTrabajoModel::Cenc_DatosCierrePlanchaSobrante($IdOrdenTrabajo);
        
        $SeguimientoPlanchaConsumible = Cenc_OrdenTrabajoModel::Cenc_DatosSeguimientoPlanchaConsumibles($IdOrdenTrabajo);
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
        
        $FechaInicio = new DateTime(Cenc_OrdenTrabajoModel::where('id_orden_trabajo', '=', $IdOrdenTrabajo)->value('created_at'));
        $FechaActual = Carbon::now();
        $TiempoTranscurrido = $FechaInicio->diff($FechaActual);

       $UsuarioAceptado = Cenc_OrdenTrabajoModel::UsuarioOrdenTrabajoAceptadoPor($IdOrdenTrabajo);
       $UsuarioEnProceso = Cenc_OrdenTrabajoModel::UsuarioOrdenTrabajoEnProcesoPor($IdOrdenTrabajo);
       $UsuarioFinalizado = Cenc_OrdenTrabajoModel::UsuarioOrdenTrabajoFinalizadoPor($IdOrdenTrabajo);

        return view('CentroCorte.OrdenTrabajo.Orden.OrdenTrabajoShow', compact(
            'OrdenTrabajo',
            'TiempoTranscurrido',
            'estimados',
            'TiempoEjecutado',
            'Espesores',
            'OxigenoUsado',
            'GasUsado',
            'MateriaPrima',
            'AreaCorte',
            'TiemposHorometros',
            'TotalAvance',
            'TotalCortes',
            'CierrePlanchaSobrante',
            'SeguimientoPlanchaConsumible',
            'Tecnologia',
            'CentroTrabajo',
            'Aprovechamiento',
            'ListaPartes',
            'UsuarioAceptado',
            'UsuarioEnProceso',
            'UsuarioFinalizado',
            'Seguimiento',
            'Cierre'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $IdOrdenTrabajo)
    {
        $OrdenTrabajo = Cenc_OrdenTrabajoModel::MostrarOrdenTrabajoEditar($IdOrdenTrabajo);
        $IdConap = (int)$OrdenTrabajo->id_conap;
        $IdAprovechamiento = (int)$OrdenTrabajo->id_aprovechamiento;
        $IdOrdenTrabajo= (int)$OrdenTrabajo->id_orden_trabajo;
        $OrdenesConap = Cenc_OrdenTrabajoModel::MostrarOrdenTrabajoConap($IdOrdenTrabajo);
        $DocumentosConap = Cenc_Conap_DocumentosModel::obtenerConapDocumentos($IdConap);
        $DocumentosAprovechamientos = Cenc_Aprovechamiento_DocumentosModel::obtenerAprovechamientoDocumentos($IdAprovechamiento);

        $IdOrdenTrabajoPlancha = (int)$OrdenTrabajo->id_orden_trabajo_plancha;

        return view('CentroCorte.OrdenTrabajo.Orden.OrdenTrabajoEdit', compact(
            'IdOrdenTrabajo',
            'OrdenTrabajo',
            'OrdenesConap',
            'DocumentosConap',
            'DocumentosAprovechamientos',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdOrdenTrabajo)
    {
        return $this->upsert($request, $IdOrdenTrabajo);

    }

       /**
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function upsert(Request $request, $IdOrdenTrabajo)
    {
        try 
        {
            DB::transaction(function () use ($request, $IdOrdenTrabajo) 
            {
                $data = json_decode($request['datos_orden_trabajo']);

                $fecha_inicio_ot = $data->fecha_inicio_ot;
                $fecha_fin_ot = $data->fecha_fin_ot;

                $observaciones_ot = $data->observaciones;
                
                foreach ($observaciones_ot as $text)
                {
                    $observaciones = $text->observaciones_ot;
                }

                $OrdenTrabajo = Cenc_OrdenTrabajoModel::MostrarOrdenTrabajoEditar($IdOrdenTrabajo);
                $id_orden_trabajo = (int)$OrdenTrabajo->id_orden_trabajo;
                $id_orden_trabajo_plancha = (int)$OrdenTrabajo->id_orden_trabajo_plancha;

                // 1. TABLA ORDEN TRABAJO 
                Cenc_OrdenTrabajoModel::updateOrCreate(
                    [
                        'id_orden_trabajo'            => $id_orden_trabajo,
                    ],
                    [
                        'id_orden_trabajo'            => $id_orden_trabajo,
                        'observaciones'               => $observaciones,
                        'fecha_inicio'                => $fecha_inicio_ot,
                        'fecha_fin'                   => $fecha_fin_ot,
                    ]
                );

                // 2. TABLA ORDEN TRABAJO PLANCHA
                Cenc_OrdenTrabajo_PlanchasModel::updateOrCreate(
                    [
                        'id_orden_trabajo_plancha'    => $id_orden_trabajo_plancha,
                    ],
                    [
                        'id_orden_trabajo_plancha'    => $id_orden_trabajo_plancha,
                        'id_orden_trabajo'            => $id_orden_trabajo,
                        'equipo'                      => $OrdenTrabajo->equipo,
                        'tecnologia'                  => $OrdenTrabajo->tecnologia,
                    ]
                );
            });
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error al Registrar Datos ' . $ex->getMessage())->withInput();
        }
        return redirect()->route('cencordentrabajo.edit', $IdOrdenTrabajo)->withSuccess('Se Ha Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $estatus = 'ANULADO';
        
        try
        {
            $orden = Cenc_OrdenTrabajoModel::find($id);

            $orden->fill([
                'anulado_por'      => Auth::user()->id, 
                'fecha_anulado'    => $FechaActual, 
                'estatus'             => $estatus
            ]);  
           $orden->save();
        }
        catch (Exception $ex)
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Anular La Orden De Trabajo. '.$ex->getMessage())->withInput();
        }
        return redirect()->route("cencordentrabajo.index")->withSuccess("La Orden De Trabajo Ha Sido Anulada Exitosamente");
    }

    public function AceptarOrdenTrabajo($id)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s');
        $estatus = 'ACEPTADA';
        
        try 
        {
            Cenc_OrdenTrabajoModel::where('id_orden_trabajo', '=', $id)->update(
                [
                    'aceptado_por'      => Auth::user()->id, 
                    'fecha_aceptado'    => $FechaActual, 
                    'estatus'             => $estatus
                ]
            );
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Aceptar La Orden Trabajo. '.$ex->getMessage())->withInput();
        }
        return redirect()->route("cencordentrabajo.edit", $id)->withSuccess("La Orden Se Ha Aceptado.");
    }

    public function FinalizarOrdenTrabajo($IdOrdenTrabajo)
    {
        $FechaActual = Carbon::now()->format('Y-d-m H:i:s'); // Obtiene La fecha Actual
        $estatus = 'FINALIZADO';
        
        $OrdenTrabajoSeguimientoEstatus = Cenc_OrdenTrabajoModel::MostrarOrdenTrabajoConap($IdOrdenTrabajo);

        foreach ($OrdenTrabajoSeguimientoEstatus as $OrdenTrabajoSeguimientoEstatu)
        {
            $OrdenConCierre = Cenc_OrdenTrabajoModel::BuscarSiOrdenTieneCierre((int)$OrdenTrabajoSeguimientoEstatu->id_orden_trabajo);

            if ($OrdenTrabajoSeguimientoEstatu->estatus !== 'FINALIZADO' || !$OrdenConCierre)
            {
                    return redirect()->back()->withError('Para Finalizar La Orden De Trabajo, Debe Finalizar Todos Los Seguimientos. ')->withInput();
            }
        }
        try 
        {
            DB::transaction(function () use ($IdOrdenTrabajo, $FechaActual, $estatus) 
            {
                $OrdenTrabajoConCierre = Cenc_OrdenTrabajoModel::BuscarSiOrdenTieneCierre($IdOrdenTrabajo);

                if ($OrdenTrabajoConCierre)
                {
                    Cenc_OrdenTrabajoModel::where('id_orden_trabajo', '=', $IdOrdenTrabajo)->update(
                        [
                            'finalizado_por'      => Auth::user()->id, 
                            'fecha_finalizado'    => $FechaActual, 
                            'estatus'             => $estatus
                        ]
                    );
                }
            });
        } 
        catch (Exception $ex) 
        {
            return redirect()->back()->withError('Ha Ocurrido Un Error Al Finalizar La Orden Trabajo. '.$ex->getMessage())->withInput();
        }
        return redirect()->route("cencordentrabajo.show", $IdOrdenTrabajo)->withSuccess("La Orden Ha Finalizado.");
    }

    public function ImprimirOrdenTrabajo($IdOrdenTrabajo)
    {
        $FechaActual = Carbon::now();
        $OrdenesTrabajosConap = Cenc_OrdenTrabajoModel::MostrarOrdenTrabajoEditar($IdOrdenTrabajo);
        $estimados = Cenc_OrdenTrabajoModel::MostrarEstimadosAsociadaAOrdenTrabajo($IdOrdenTrabajo);

        $IdOrdenTrabajoPlancha = Cenc_OrdenTrabajoModel::BuscarIdOrdenTrabajoPlancha($IdOrdenTrabajo);
        $TiempoEjecutado = [];
        $OxigenoUsado = [];
        $GasUsado = [];
        
        $SeguimientoPlanchaHorometro = Cenc_OrdenTrabajoModel::Cenc_DatosSeguimientoPlanchaHorometro($IdOrdenTrabajo);
        $TiempoEjecutado = $this->ObtenerTotalesHorasOnEjecutadoHorometro($SeguimientoPlanchaHorometro);

        $Espesores = $this->ObtenerEspesores($SeguimientoPlanchaHorometro);
        $CentroTrabajo = $this->ObtenerCentroTrabajo($SeguimientoPlanchaHorometro);
        $Tecnologia = $this->ObtenerTecnologia($SeguimientoPlanchaHorometro);

        foreach ($IdOrdenTrabajoPlancha as $IdOrdenTrabajoPlancha) 
        {
            $SeguimientoPlanchaOxigeno = Cenc_SeguimientoPlanchaOxigenoModel::Cenc_SeguimientoPlanchaOxigenoCrear((int)$IdOrdenTrabajoPlancha->id_orden_trabajo_plancha);
            foreach ($SeguimientoPlanchaOxigeno as $SeguimientoPlanchaOxigenos) 
            {
                $TotalOxigenoUsado = $SeguimientoPlanchaOxigenos->total_oxigeno_usado;
                $TotalLitrosGaseosos = $SeguimientoPlanchaOxigenos->total_litros_gaseosos;

                if (isset($TotalOxigenoUsado) || isset($TotalLitrosGaseosos)) 
                {
                    $TotalOxigenoUsado = $SeguimientoPlanchaOxigenos->total_oxigeno_usado;
                    $TotalLitrosGaseosos = $SeguimientoPlanchaOxigenos->total_litros_gaseosos;
                } 
                else
                {
                    $TotalOxigenoUsado = 0;
                    $TotalLitrosGaseosos = 0;
                }
                $OxigenoUsado[] = $TotalLitrosGaseosos;
            }
        }

        $ConsumoGas = Cenc_OrdenTrabajoModel::ConsumoGas($IdOrdenTrabajo);

            foreach ($ConsumoGas as $ConsumoGasP)
            {
                $consumo_gas = $ConsumoGasP->consumo_gas;
                $GasUsado[] = $consumo_gas;
            }
        
        $AprovechamientosPlanchas = Cenc_OrdenTrabajoModel::BuscarIdAprovechamientosPlanchas($IdOrdenTrabajo);
        $MateriaPrima = collect();
        $AreaCorte = collect();

        foreach ($AprovechamientosPlanchas as $AprovechamientosPlancha)
        {
            $MateriaPrima = $MateriaPrima->merge(Cenc_OrdenTrabajoModel::ObtenerMateriasPrimasAprovechamiento((int)$AprovechamientosPlancha->id_aprovechamiento_plancha));
            $AreaCorte = $AreaCorte->merge(Cenc_OrdenTrabajoModel::ObtenerAreaCorteAprovechamiento((int)$AprovechamientosPlancha->id_aprovechamiento_plancha));
        }
        $MateriaPrima = $MateriaPrima->flatten()->toArray();
        $AreaCorte = $AreaCorte->flatten()->toArray();

        $TiemposHorometros = $this->ObtenerTotalesHorometro($SeguimientoPlanchaHorometro);

        $SeguimientoPlanchaAvance = Cenc_OrdenTrabajoModel::Cenc_DatosSeguimientoPlanchaAvance($IdOrdenTrabajo);
        $TotalAvance = $this->ObtenerTotalesAvance($SeguimientoPlanchaAvance);

        $CierreSeguimientoCortes = Cenc_OrdenTrabajoModel::Cenc_DatosCierrePlanchaCortes($IdOrdenTrabajo);
        $TotalCortes = $this->ObtenerTotaleCortes($CierreSeguimientoCortes);

        $CierrePlanchaSobrante = Cenc_OrdenTrabajoModel::Cenc_DatosCierrePlanchaSobrante($IdOrdenTrabajo);
        
        $SeguimientoPlanchaConsumible = Cenc_OrdenTrabajoModel::Cenc_DatosSeguimientoPlanchaConsumibles($IdOrdenTrabajo);

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
        
        //return view('CentroCorte.OrdenTrabajo.Seguimiento.SeguimientoPDF');
        $pdf = PDF::loadView('CentroCorte.OrdenTrabajo.Orden.OrdenTrabajoPDF', 
        compact(
            'OrdenesTrabajosConap',
            'estimados',
            'TiempoEjecutado',
            'Espesores',
            'OxigenoUsado',
            'GasUsado',
            'MateriaPrima',
            'AreaCorte',
            'TiemposHorometros',
            'TotalAvance',
            'TotalCortes',
            'CierrePlanchaSobrante',
            'SeguimientoPlanchaConsumible',
            'Tecnologia',
            'CentroTrabajo'
        ))->setPaper('letter');

        return $pdf->stream('OrdenTrabajo_' . $IdOrdenTrabajo . '_' . $FechaActual . '.pdf');
    }
}

