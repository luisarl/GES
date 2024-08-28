<?php

namespace App\Http\Controllers;

use App\Exports\AutorizacionSalidasExport;
use App\Exports\CompProductividadCompradoresExport;
use App\Exports\ReportesSolicitudesLogisticaExport;
use App\Exports\SalidasArticulosDepartamentoMesExport;
use App\Models\Almacen_UsuarioModel;
use App\Models\AlmacenesModel;
use App\Models\Articulo_UbicacionModel;
use App\Models\Asal_SalidasModel;
use App\Models\DepartamentosModel;
use App\Models\Actv_CaracteristicasModel;
use App\Models\Fict_SubalmacenesModel;
use App\Models\Fict_UbicacionesModel;
use App\Models\Sols_SolicitudesModel;
use App\Models\Actv_ActivosModel;
use App\Models\Actv_Activos_CaracteristicasModel;
use App\Models\ArticulosModel;
use App\Models\CategoriasModel;
use App\Models\Cnth_movimientos_detallesModel;
use App\Models\Cnth_MovimientosModel;
use App\Models\Comp_ProfitModel;
use App\Models\GruposModel;
use App\Models\Salidas_ProfitModel;
use App\Models\Gsta_NovedadesModel;
use App\Models\Gsta_AsistenciasValidacionModel;
use App\Exports\GstaReporteHorasExport;
use App\Exports\GstaReporteHorasRangoExport;
use App\Exports\ResgArticulosResguardoExport;
use App\Models\Cnth_HerramientasModel;
use App\Models\Cntc_Tipo_CombustibleModel;
use App\Models\Cntc_Solicitudes_DespachoModel;
use App\Models\Cntc_Solicitudes_IngresoModel;
use App\Models\Cntt_Reemplazo_TonerModel;
use App\Models\Asal_VehiculosModel;
use App\Models\Cnth_Plantillas_DetalleModel;
use App\Models\Cnth_PlantillasModel;
use App\Models\Resg_ClasificacionesModel;
use App\Models\Resg_ResguardoModel;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    
    public function AsalListadoSalidas(Request $request)
    {
        $almacenes = AlmacenesModel::all();

        $FechaInicio =  $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
        $estatus = $request->get('estatus');
        $IdAlmacen =  $request->get('id_almacen');
       // dump( $request->all());
        if($request->has('buscar'))
        {   
            $salidas = Asal_SalidasModel::ReporteSalidas($FechaInicio, $FechaFin, $estatus, $IdAlmacen);
        }
        elseif($request->has('pdf'))
            {
                set_time_limit(0);
                ini_set("memory_limit",-1);
                ini_set('max_execution_time', 0);
                $salidas = Asal_SalidasModel::ReporteSalidasPDF($FechaInicio, $FechaFin, $estatus, $IdAlmacen);
                $almacen = AlmacenesModel::where('id_almacen', '=', $IdAlmacen)->value('nombre_almacen');
                $pdf = PDF::loadView('reportes.SalidaMateriales.RepListadoSalidasPDF', compact('salidas', 'almacen'))->setPaper('letter', 'landscape');
                return $pdf->stream('Salidas'.$FechaInicio.'_'.$FechaFin.'.pdf');
            }
            elseif($request->has('excel'))
                {
                    return (new AutorizacionSalidasExport($FechaInicio, $FechaFin, $estatus, $IdAlmacen))->download('Salidas'.$FechaInicio.'_'.$FechaFin.'.xlsx');
                }
                else
                    {
                        $salidas = Asal_SalidasModel::ListaSalidas();
                    }
        
        return view('reportes.SalidaMateriales.RepListadoSalidas', compact('salidas', 'almacenes'));
    }

    public function AsalListadoAuditoria(Request $request)
    {
        $almacenes = AlmacenesModel::all();

        $FechaInicio =  $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
        $estatus = $request->get('estatus');
        $IdAlmacen =  $request->get('id_almacen');
         if($request->has('buscar'))
        {   
            $salidas = Asal_SalidasModel::ReporteSalidasAuditoria($FechaInicio, $FechaFin, $estatus, $IdAlmacen);
        }
        elseif($request->has('pdf'))
            {
                set_time_limit(0);
                ini_set("memory_limit",-1);
                ini_set('max_execution_time', 0);
                $salidas = Asal_SalidasModel::ReporteSalidasAuditoria($FechaInicio, $FechaFin, $estatus, $IdAlmacen);
                $pdf = PDF::loadView('reportes.SalidaMateriales.RepListadoSalidasauditoriaPDF', compact('salidas'))->setPaper('letter', 'landscape');
                return $pdf->stream('Salidas'.$FechaInicio.'_'.$FechaFin.'.pdf');
            }
            elseif($request->has('excel'))
                {
                    return (new AutorizacionSalidasExport($FechaInicio, $FechaFin, $estatus, $IdAlmacen))->download('Salidas'.$FechaInicio.'_'.$FechaFin.'.xlsx');
                }
                else
                    {
                        $salidas = null;
                    } 
        return view('reportes.SalidaMateriales.RepListadoSalidasAuditoria', compact('salidas', 'almacenes'));
    }

    public function FictArticuloUbicacion(Request $request)
    {
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);
        

        $IdAlmacen =  $request->get('id_almacen');
        $IdSubalmacen =  $request->get('id_subalmacen');
        $IdZona =  $request->get('id_ubicacion');
        
        if($request->has('pdf'))
            {
                $articulos = Articulo_UbicacionModel::ReporteArticulosUbicaciones($IdAlmacen, $IdSubalmacen, $IdZona);
                $pdf = PDF::loadView('reportes.FichaTecnica.RepListadoArticuloUbicacionesPDF', compact('articulos'))->setPaper('letter', 'landscape');
                return $pdf->stream('articulos');
            }
        else
        {
            $ubicaciones = Articulo_UbicacionModel::ConsultarArticulosUbicaciones(Auth::user()->id);
            return view('reportes.FichaTecnica.RepListadoArticuloUbicaciones', compact('ubicaciones', 'almacenes'));
        }
        
      
    } 

    public function SolsLogistica(Request $request)
    { 
        // Variables que vienen de la vista 
        $FechaInicio =  $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
        $estatus = $request->get('estatus');
        // PDF 
        // dump( $request->all());

        if($request->has('buscar'))
        {   
            $solicitudes = Sols_SolicitudesModel::ReporteSolicitudesLogistica($FechaInicio, $FechaFin, $estatus);
        }
        elseif($request->has('pdf'))
            {
                $solicitudes = Sols_SolicitudesModel::ReporteSolicitudesLogistica($FechaInicio, $FechaFin, $estatus);
                $pdf = PDF::loadView('reportes.SolicitudesServicios.SolsServLogisticaPDF', compact('solicitudes'))->setPaper('letter', 'landscape');
                return $pdf->stream('Solicitudes'.$FechaInicio.'_'.$FechaFin.'.pdf');
            }
            else
            {
                $solicitudes = Sols_SolicitudesModel::ListaSolicitudesLogistica();          
            }

    return view('reportes.SolicitudesServicios.SolsServLogistica', compact('solicitudes'));
    }

    public function SolsDepartamentos(Request $request)
    { 
        $FechaInicio =  $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
        $estatus = $request->get('estatus');
        $departamento = Auth::user()->id_departamento;
        
        $solicitudes = Sols_SolicitudesModel::ListaSolicitudesDepartamentos($departamento);

        if($request->has('buscar'))
        {   
            $solicitudes = Sols_SolicitudesModel::ReporteSolicitudesDepartamentos($FechaInicio, $FechaFin, $estatus,$departamento);
        }
        elseif($request->has('pdf'))
            {
                $solicitudes = Sols_SolicitudesModel::ReporteSolicitudesDepartamentos($FechaInicio, $FechaFin, $estatus,$departamento);
                $pdf = PDF::loadView('reportes.SolicitudesServicios.SolsDepartamentosPDF', compact('solicitudes'))->setPaper('letter', 'landscape');
                return $pdf->stream('Solicitudes'.$FechaInicio.'_'.$FechaFin.'.pdf');
            }


    return view('reportes.SolicitudesServicios.SolsDepartamentos', compact('solicitudes'));
    }

    public function ActvListadoActivos(Request $request)
    {

        // Variables que vienen de la vista 
        $IdActivo =  $request->get('id_activo');
        $departamento = $request->get('id_departamento'); 
        $estatus = $request->get('estatus');
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
        //$activo = Actv_ActivosModel::find($IdActivo);
        $CaracteristicasActivo = Actv_Activos_CaracteristicasModel::CaracteristicasActivo($IdActivo);
        $caracteristicas = Actv_CaracteristicasModel::select('id_caracteristica', 'nombre_caracteristica')->get();
        // PDF 
        // dump( $request->all());

        if($request->has('buscar'))
        {   
            $activos = Actv_ActivosModel::ReporteActivos($departamento, $estatus);
        }
        elseif($request->has('pdf'))
            {
                $activos = Actv_ActivosModel::ReporteActivosPDF($departamento, $estatus);
                $pdf = PDF::loadView('reportes.Activos.ActivosPDF', compact('activos'))->setPaper('letter', 'landscape');
                return $pdf->stream('ReporteActivo.pdf');
            }
            else
            {
                $activos = Actv_ActivosModel::ListadoActivos();          
            }

        return view('reportes.Activos.Activos', compact('activos','departamentos')); 
    }

    public function CompSolpEstadoAprobacion(Request $request)
    {
        $FechaInicio = Carbon::parse($request->get('fecha_inicio'))->format('d-m-Y');
        $FechaFin = Carbon::parse($request->get('fecha_fin'))->format('d-m-Y');

        if($request->has('buscar'))
        {  
            $solicitudes = DB::connection('profit')
                ->select('EXEC masterprofit.dbo.EstadisticaComprasEstado ?, ?', array($FechaInicio,$FechaFin));
        }
        else
            {
                $solicitudes = DB::connection('profit')
                ->select('EXEC masterprofit.dbo.EstadisticaComprasEstado ?, ?', array(null,null));
            }

        if($request->has('estado'))
        {
            $solicitudes = DB::connection('profit')
            ->select('EXEC masterprofit.dbo.EstadisticaComprasEstado ?, ?', array($FechaInicio,$FechaFin));

            $estado = $request->get('estado');

            $SolicitudesCompras = Comp_ProfitModel::CompListaSolPEstado($estado);  

            return view('reportes.Compras.RepSolpEstadoAprobacion', compact('solicitudes', 'SolicitudesCompras'));
        }

        return view('reportes.Compras.RepSolpEstadoAprobacion', compact('solicitudes'));
                   
    }

    public function CompSolpAsignadaComprador(Request $request)
    {
        $FechaInicio = Carbon::parse($request->get('fecha_inicio'))->format('d-m-Y');
        $FechaFin = Carbon::parse($request->get('fecha_fin'))->format('d-m-Y');
        
        if($request->has('buscar'))
        {  
            $solicitudes = DB::connection('profit')
                ->select('EXEC masterprofit.dbo.EstadisticaComprasComprador ?, ?', array($FechaInicio,$FechaFin));
        }
        else
            {
                $solicitudes = DB::connection('profit')
                ->select('EXEC masterprofit.dbo.EstadisticaComprasComprador ?, ?', array(null,null));
            }
        return view('reportes.Compras.RepSolpAsigandaComprador', compact('solicitudes'));

    }

    public function CompSolpDepartamentos(Request $request)
    {
        $FechaInicio = Carbon::parse($request->get('fecha_inicio'))->format('d-m-Y');
        $FechaFin = Carbon::parse($request->get('fecha_fin'))->format('d-m-Y');
        
        if($request->has('buscar'))
        {  
            $solicitudes = DB::connection('profit')
                ->select('EXEC masterprofit.dbo.EstadisticaComprasDepartamento ?, ?', array($FechaInicio,$FechaFin));
        }
        else
            {
                $solicitudes = DB::connection('profit')
                ->select('EXEC masterprofit.dbo.EstadisticaComprasDepartamento ?, ?', array(null,null));
            }

        return view('reportes.Compras.RepSolpDepartamentos', compact('solicitudes'));
    }

    public function CompSolpEstatus(Request $request)
    {
        $FechaInicio = Carbon::parse($request->get('fecha_inicio'))->format('d-m-Y');
        $FechaFin = Carbon::parse($request->get('fecha_fin'))->format('d-m-Y');
        
        if($request->has('buscar'))
        {  
            $solicitudes = DB::connection('profit')
                ->select('EXEC masterprofit.dbo.EstadisticaComprasEstatus ?, ?', array($FechaInicio,$FechaFin));
        }
        else
            {
                $solicitudes = DB::connection('profit')
                ->select('EXEC masterprofit.dbo.EstadisticaComprasEstatus ?, ?', array(null,null));
            }

        return view('reportes.Compras.RepSolpEstatus', compact('solicitudes'));
    }

    public function CompSolpDetalle(Request $request)
    {
        $SolicitudCompra = Comp_ProfitModel::CompSolPDetalle($request->empresa, $request->solp);
        $compradores =  Comp_ProfitModel::CompListadoCompradores();
    
        return view('reportes.Compras.RepSolpDetalle', compact('SolicitudCompra', 'compradores'));
    }

    public function CompAprobacionSolp(Request $request)
    {
        Comp_ProfitModel::GuardarAprobacionSolp($request->empresa, $request->solp, 
                                $request->estado, $request->autorizado, $request->fecha);
        
        return redirect()->route('reposolpdetalle', ['empresa' => $request->empresa, 'solp' => $request->solp ])->withSuccess('La Aprobacion Fue Realizada Exitosamente');
    }

    public function CompAsignarCompradorSolp(Request $request)
    {
        Comp_ProfitModel::AsignarCompradorSolp($request->empresa, $request->solp, $request->comprador);
        
        return redirect()->route('reposolpdetalle', ['empresa' => $request->empresa, 'solp' => $request->solp ])->withSuccess('La Asignacion del Comprador Fue Realizada Exitosamente');
    }

    public function CompProductividadComprador(Request $request)
    {   
        $compradores = Comp_ProfitModel::CompListadoCompradores();
       
        $FechaInicio =  Carbon::parse($request->get('fecha_inicio'))->format('d/m/Y');
        $FechaFin = Carbon::parse($request->get('fecha_fin'))->format('d/m/Y');
        $comprador = $request->get('comprador');

        $PrimerDiaAño = strtotime('first day of January', time());
        $PrimerDia = date('d/m/Y', $PrimerDiaAño);
        $FechaActual = date('d/m/Y'); 

        if($request->has('buscar'))
        {
            $ProductividadAnual = Comp_ProfitModel::CompProductividadComprador($PrimerDia, $FechaActual, $comprador);
            $productividad = Comp_ProfitModel::CompProductividadComprador($FechaInicio, $FechaFin, $comprador);
            $productividad1 = Comp_ProfitModel::CompProductividadComprador1($FechaInicio, $FechaFin, $comprador);
            $productividad2 = Comp_ProfitModel::CompProductividadComprador2($FechaInicio, $FechaFin, $comprador);
            $productividad3 = Comp_ProfitModel::CompProductividadComprador3($FechaInicio, $FechaFin, $comprador);
        }
        elseif($request->has('excel'))
            {
                return (new CompProductividadCompradoresExport($FechaInicio, $FechaFin, $comprador))->download('productividad'.Date('d-m-Y').'.xlsx');
            }   
            else
                {
                    $ProductividadAnual = Comp_ProfitModel::CompProductividadComprador(null, null, null);
                    $productividad = Comp_ProfitModel::CompProductividadComprador(null, null, null);
                    $productividad1 = Comp_ProfitModel::CompProductividadComprador1(null, null, null);
                    $productividad2 = Comp_ProfitModel::CompProductividadComprador2(null, null, null);
                    $productividad3 = Comp_ProfitModel::CompProductividadComprador3(null, null, null);
                }
        
        return view('reportes.Compras.RepProductividadComprador', compact('ProductividadAnual','productividad', 'productividad1', 'productividad2', 'productividad3', 'compradores'));
    }

    public function CompSeguimientoSolpOcNdr(Request $request)
    {   
        $FechaInicio =  Carbon::parse($request->get('fecha_inicio'))->format('d/m/Y');
        $FechaFin = Carbon::parse($request->get('fecha_fin'))->format('d/m/Y');

        if($request->has('buscar'))
        {
            $seguimiento = Comp_ProfitModel::CompProductividadCompradorDetalle($FechaInicio, $FechaFin, 'TODOS');
        }
        elseif($request->has('excel'))
            {
                return (new CompProductividadCompradoresExport($FechaInicio, $FechaFin, 'TODOS'))->download('SeguimientoSolpOcNdr'.Date('d-m-Y').'.xlsx');
            }   
            else
                {
                    $seguimiento = Comp_ProfitModel::CompProductividadCompradorDetalle(null, null, null);
                }
        
        return view('reportes.Compras.RepSeguimientoSolpOcNdr', compact('seguimiento'));
    }


    public function SalidasArticulosDepartamentoAño(Request $request)
    {
        $departamento = $request->departamento;
        $articulo = $request->articulo;
        $categoria = $request->categoria;
        $grupo = $request->grupo;
        $subgrupo = $request->subgrupo;
        $año = $request->año;

        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
        $articulos = ArticulosModel::select('codigo_articulo', 'nombre_articulo')->where('estatus', 'MIGRADO')->get(); 
        $categorias = CategoriasModel::select('codigo_categoria', 'nombre_categoria')->get();
        $grupos = GruposModel::select('codigo_grupo', 'nombre_grupo')->get();   
 
        $salidas = Salidas_ProfitModel::SalidasArticulosDepartamentoAño($departamento, $articulo, $categoria, $grupo, $subgrupo, $año);
        
        if($request->has('excel'))
            {
                return (new SalidasArticulosDepartamentoMesExport($departamento, $articulo, $categoria, $grupo, $subgrupo, $año))->download('salidasarticulos'.Date('d-m-Y').'.xlsx');
            }   
        

        return view('reportes.SalidaArticulos.RepSalidasArticulosDepartamento', compact('salidas', 'departamentos', 'articulos', 'categorias', 'grupos'));
    }

    public function ListadoValidaciones(Request $request)
    {
        $FechaInicio = $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
        $departamento = $request->departamento;
        $departamentos = Gsta_AsistenciasValidacionModel::DepartamentosNomina();
        $empresa = $request->empresa;
        $empresas = Gsta_AsistenciasValidacionModel::EmpresasNomina();
        
        $novedadesArray = $request->input('id_novedad', []);
        $Novedades = (in_array('TODOS', $novedadesArray)) ? 'TODOS' : $novedadesArray;
        
        $novedades = Gsta_NovedadesModel::all();
        $validaciones = Gsta_AsistenciasValidacionModel::ListadoValidacionesNove($departamento, $empresa, $FechaInicio, $FechaFin, $Novedades);
        
        return view('reportes.GestionAsistencias.ValidacionDiaria', compact('departamentos', 'validaciones', 'empresas', 'novedades'));
    }

    public function ListadoHoras(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');
        $departamento = $request->departamento;
        $departamentos = Gsta_AsistenciasValidacionModel::DepartamentosNomina();
        $empresa = $request->empresa;
        $empresas= Gsta_AsistenciasValidacionModel::EmpresasNomina();
        $validaciones=Gsta_AsistenciasValidacionModel::HorasTrabajadas($departamento,$empresa,$FechaInicio,$FechaFin);
        if($request->has('excel'))
                {
                    return (new GstaReporteHorasExport($departamento,$empresa,$FechaInicio))->download('reportehoras.xlsx');
                }
                elseif($request->has('excel2'))
                {
                    return (new GstaReporteHorasRangoExport($departamento,$empresa,$FechaInicio,$FechaFin))->download('reportehoras.xlsx');
                }
                else
        return view('reportes.GestionAsistencias.HorasExtras', compact('departamentos','validaciones','empresas'));
    }

    public function CnthEstatusDespacho(Request $request)
    {
        $FechaInicio =  $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
        $estatus = $request->get('estatus');
        $IdAlmacen = $request->get('id_almacen');
        $almacenes = AlmacenesModel::all();

        if($request->has('buscar'))
        {   
            $EstatusDespacho = Cnth_movimientos_detallesModel::EstatusDespacho($FechaInicio,$FechaFin,$estatus,$IdAlmacen);
        }
        elseif($request->has('pdf'))
            {
                set_time_limit(0);
                ini_set("memory_limit",-1);
                ini_set('max_execution_time', 0);
                
                $EstatusDespacho = Cnth_movimientos_detallesModel::EstatusDespachoReportePDF($FechaInicio,$FechaFin,$estatus,$IdAlmacen);
                //return view('reportes.ControlHerramientas.ListadoEstatusDespachopdf', compact('EstatusDespacho','IdAlmacen'));
                $pdf = PDF::loadView('reportes.ControlHerramientas.ListadoEstatusDespachopdf', compact('EstatusDespacho','IdAlmacen'))->setPaper('letter', 'landscape');
                return $pdf->stream('EstatusDespachoHerramientas'.$FechaInicio.'_'.$FechaFin.'.pdf');
            }
                else
                    {
                        $EstatusDespacho = null;
                    }  
        return view('reportes.ControlHerramientas.ListadoEstatusDespacho', compact('EstatusDespacho','IdAlmacen','almacenes'));
    
    }

    public function CnthHerramientasStock(Request $request)
    {
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);
        $IdAlmacen = $request->get('id_almacen');
        $IdHerramienta= $request->get('herramientas');
        if($request->has('buscar'))
        { 
            $stock = Cnth_HerramientasModel::HerramientasStock($IdAlmacen,$IdHerramienta);
        }
        elseif($request->has('pdf'))
            {
                set_time_limit(0);
                ini_set("memory_limit",-1);
                ini_set('max_execution_time', 0);
               
                $stock = Cnth_HerramientasModel::HerramientasStock($IdAlmacen,$IdHerramienta);
                //return view('reportes.ControlHerramientas.ListadoHerramientaspdf', compact('stock','IdAlmacen'));
                $pdf = PDF::loadView('reportes.ControlHerramientas.ListadoHerramientaspdf', compact('stock','IdAlmacen'))->setPaper('letter', 'landscape');
                return $pdf->stream('ListadoHerramientasStock'.$IdAlmacen.'.pdf');
            }
                else
                    {
                        $stock = null;
                    }  
    return view('reportes.ControlHerramientas.ListadoHerramientas', compact('stock','almacenes'));
    }

    public function FictFechasFichasTecnicas(Request $request)
    {
        $FechaInicio =  $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
      
        if($request->has('buscar'))
        {   
            $articulos = ArticulosModel::FechasFichasTecnicas($FechaInicio,$FechaFin);
        }
        elseif($request->has('pdf'))
            {
                $articulos = ArticulosModel::FechasFichasTecnicas($FechaInicio,$FechaFin);
                //return view('reportes.ControlHerramientas.ListadoEstatusDespachopdf', compact('EstatusDespacho','IdAlmacen'));
                $pdf = PDF::loadView('reportes.FichaTecnica.RepFechasFichasTecnicasPDF', compact('articulos'))->setPaper('letter', 'landscape');
                return $pdf->stream('RepFechasFichasTecnicasPDF'.$FechaInicio.'_'.$FechaFin.'.pdf');
            }
            else
                {
                    $articulos = null;
                }  

        return view('reportes.FichaTecnica.RepFechasFichasTecnicas', compact('articulos'));
    }

    public static function FictCatalogacion(Request $request)
    {
        $FechaInicio =  $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');

        if($request->has('buscar'))
        {   
            $catalogaciones = ArticulosModel::CatalogacionArticulos($FechaInicio,$FechaFin);
        }
        elseif($request->has('pdf'))
            {
                $catalogaciones = ArticulosModel::CatalogacionArticulos($FechaInicio,$FechaFin);
                //return view('reportes.ControlHerramientas.ListadoEstatusDespachopdf', compact('EstatusDespacho','IdAlmacen'));
                $pdf = PDF::loadView('reportes.FichaTecnica.RepCatalogacionPDF', compact('catalogaciones'))->setPaper('letter');
                return $pdf->stream('RepCatalogacion'.$FechaInicio.'_'.$FechaFin.'.pdf');
            }
            else
                {
                    $catalogaciones = null;
                }  

        return view('reportes.FichaTecnica.RepCatalogacion', compact('catalogaciones'));
    }

    //REPORTES DESPACHOS DETALLE VEHICULOS
    public function CntcReporteDespachosVehiculos(Request $request)
    {
        $FechaInicio = $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
        $departamentos=$request->departamento;
        $vehiculosString = $request->input('id_vehiculo');
        
        // Verificar si vehiculosString es 'TODOS' o 'EQUIPOS', si no, dividir la cadena por comas
        $vehiculos = ($vehiculosString === 'TODOS' || $vehiculosString === 'EQUIPOS') ? $vehiculosString : explode(',', $vehiculosString);
    
        $IdCombustible = $request->id_combustible;
        $combustible = Cntc_Tipo_CombustibleModel::BuscarCombustible($IdCombustible);
        $reportes = Cntc_Solicitudes_DespachoModel::ReporteDespachosVehiculos($FechaInicio, $FechaFin, $IdCombustible, $vehiculos,$departamentos);
        $gerencias = Cntc_Solicitudes_DespachoModel::CantidadDespachadaVehiculos($IdCombustible, $FechaInicio, $FechaFin,$vehiculos);
        
        $pdf = PDF::loadView('reportes.ControlCombustible.DespachosVehiculosPDF', compact('reportes', 'FechaInicio', 'FechaFin', 'combustible', 'gerencias','departamentos'));
    
        return $pdf->stream('Despachos.pdf');

    }

    //REPORTE DETALLE POR DEPARTAMENTOS
    public function CntcReporteDespachosDepartamentos(Request $request)
    {
        $FechaInicio = $request->get('fecha_inicio');
        $FechaFin = $request->get('fecha_fin');
        $departamentos=$request->departamento;
        $vehiculosString = $request->input('id_vehiculo');
        
        // Verificar si vehiculosString es 'TODOS' o 'EQUIPOS', si no, dividir la cadena por comas
        $vehiculos = ($vehiculosString === 'TODOS' || $vehiculosString === 'EQUIPOS') ? $vehiculosString : explode(',', $vehiculosString);
    
        $IdCombustible = $request->id_combustible;
        $combustible = Cntc_Tipo_CombustibleModel::BuscarCombustible($IdCombustible);
        $reportes = Cntc_Solicitudes_DespachoModel::ReporteDespachosDepartamentos($FechaInicio, $FechaFin, $IdCombustible, $vehiculos,$departamentos);
        $gerencias = Cntc_Solicitudes_DespachoModel::CantidadDespachada($IdCombustible, $FechaInicio, $FechaFin,$departamentos);
        
        $pdf = PDF::loadView('reportes.ControlCombustible.DespachosPDF', compact('reportes', 'FechaInicio', 'FechaFin', 'combustible', 'gerencias','departamentos'));
    
        return $pdf->stream('Despachos.pdf');
    }


    //REPORTE DESPACHOS ANUAL POR GERENCIA
    public function CntcReporteAnualDespachos(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');
        
     
        // Crear un objeto DateTime a partir de la fecha
        $date = new DateTime($FechaInicio);

        // Extraer el año usando el método format
        $year = $date->format('Y');
      
        $IdCombustible= $request->id_combustible;
        $reportes=Cntc_Solicitudes_DespachoModel::ReporteAnual($IdCombustible,$year);
        $combustible = Cntc_Tipo_CombustibleModel::BuscarCombustible($IdCombustible);
        $pdf = PDF::loadView('reportes.ControlCombustible.DespachosAnualPDF', compact('reportes','combustible','year'))->setPaper('letter', 'landscape');
        return $pdf->stream('Despachos Anual.pdf');
    }

    //REPORTE DESPACHOS ANUAL POR EQUIPOS
    public function CntcReporteAnualDespachosEquipos(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');
        // Crear un objeto DateTime a partir de la fecha
        $date = new DateTime($FechaInicio);
        // Extraer el año usando el método format
        $year = $date->format('Y');

        $IdCombustible= $request->id_combustible;
        $reportes=Cntc_Solicitudes_DespachoModel::ReporteAnualEquipos($IdCombustible,$year);
        $combustible = Cntc_Tipo_CombustibleModel::BuscarCombustible($IdCombustible);
        $pdf = PDF::loadView('reportes.ControlCombustible.DespachosAnualEquiposPDF', compact('reportes','combustible','year'))->setPaper('letter', 'landscape');
        return $pdf->stream('Despachos Anual Por Equipos.pdf');
    }
 
    //REPORTE INGRESO DETALLE

    public function CntcReporteIngresos(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');
        $IdCombustible= $request->id_combustible;
        $combustible = Cntc_Tipo_CombustibleModel::BuscarCombustible($IdCombustible);
        $reportes = Cntc_Solicitudes_IngresoModel::SolicitudIngresos($FechaInicio,$FechaFin,$IdCombustible);
        $gerencias= Cntc_Solicitudes_IngresoModel::CantidadIngresada($IdCombustible,$FechaInicio,$FechaFin);

        $pdf = PDF::loadView('reportes.ControlCombustible.IngresosPDF', compact('reportes','FechaInicio','FechaFin','combustible','gerencias'));
        return $pdf->stream('Ingresos.pdf');
    }

    //REPORTE INGRESO ANUAL POR GERENCIAS
    public function CntcReporteAnualIngresos(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');
        // Crear un objeto DateTime a partir de la fecha
        $date = new DateTime($FechaInicio);
        // Extraer el año usando el método format
        $year = $date->format('Y');
        $IdCombustible= $request->id_combustible;
        $reportes=Cntc_Solicitudes_IngresoModel::reporteanual($IdCombustible,$year);
        $combustible = Cntc_Tipo_CombustibleModel::BuscarCombustible($IdCombustible);
        $pdf = PDF::loadView('reportes.ControlCombustible.IngresosAnualPDF', compact('reportes','combustible','year'))->setPaper('letter', 'landscape');
        return $pdf->stream('Ingresos Anual.pdf');
    }

    public function CnttReporteToner(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');
        $departamentos=$request->departamento;
        $reportes=Cntt_Reemplazo_TonerModel::Reporte($departamentos,$FechaInicio,$FechaFin);
        $promedios= Cntt_Reemplazo_TonerModel::PromedioHojas($departamentos,$FechaInicio,$FechaFin);
     
        $pdf = PDF::loadView('reportes.ControlToner.ControlTonerPDF', compact('reportes','promedios'))->setPaper('letter', 'landscape');
        return $pdf->stream('Control de Toner.pdf');
    }

    public function ResgArticulosResguardo(Request $request)
    {
        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);
        $clasificaciones = Resg_ClasificacionesModel::select('id_clasificacion', 'nombre_clasificacion')->get();

        $IdAlmacen = $request->get('id_almacen');
        $IdClasificacion = $request->get('id_clasificacion');

        if($request->has('buscar'))
        {   
            $resguardos = Resg_ResguardoModel::ArticulosResguardoAlmacenClasificacion($IdAlmacen,$IdClasificacion);
        }
        elseif($request->has('pdf'))
            {
                $resguardos = Resg_ResguardoModel::ArticulosResguardoAlmacenClasificacion($IdAlmacen,$IdClasificacion);
                //dd($resguardos);
                //return view('reportes.ControlHerramientas.ListadoEstatusDespachopdf', compact('EstatusDespacho','IdAlmacen'));
                $pdf = PDF::loadView('reportes.Resguardo.RepArticulosResguardoPDF', compact('resguardos'));
                return $pdf->stream('RepArticulosResguardoPDF.pdf');
            }
            elseif($request->has('excel'))
            {
                return (new ResgArticulosResguardoExport($IdAlmacen,$IdClasificacion))->download('reportearticulosresguardo.xlsx');
            }
            else
                {
                    $resguardos = null;
                }  

        return view('reportes.Resguardo.RepArticulosResguardo', compact('almacenes', 'clasificaciones', 'resguardos'));
    }
    
    public static function CnthPlantillasAlmacen(Request $request)
    {
        $IdAlmacen =  $request->get('id_almacen');
        $IdPlantilla =  $request->get('id_plantilla');

        $almacenes = Almacen_UsuarioModel::AlmacenesUsuario(Auth::user()->id);        
        if($request->has('buscar'))
        {   
            $plantillas = Cnth_Plantillas_DetalleModel::PlantillasAlmacen($IdAlmacen,$IdPlantilla);
            
        }
        elseif($request->has('pdf'))
            {
                $plantillas = Cnth_Plantillas_DetalleModel::PlantillasAlmacen($IdAlmacen,$IdPlantilla);
                $pdf = PDF::loadView('reportes.ControlHerramientas.PlantillasAlmacenesPDF', compact('plantillas'));
                return $pdf->stream('RepPlantillasAlmacen.pdf');
            }
            else
                {
                    
                    $plantillas = null;
                }  

        return view('reportes.ControlHerramientas.PlantillasAlmacenes', compact('plantillas', 'almacenes'));
    }

    public static function CompHistorialCompras(Request $request){

        $CodigoArticulo = trim($request->get('_codigo'));
        
        if($request->has('buscar'))
        {   

            $historial  = Comp_ProfitModel::CompHistorialCompras($CodigoArticulo);
        }
        else
        {
            $historial = null;
        }

        return view('reportes.Compras.RepHistorialCompras', compact('historial')); 
    }
}


