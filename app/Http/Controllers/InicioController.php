<?php

namespace App\Http\Controllers;

use App\Models\Actv_ActivosModel;
use App\Models\ArticulosModel;
use App\Models\AlmacenesModel;
use App\Models\Asal_SalidasModel;
use App\Models\Audi_Auditoria_InventarioModel;
use App\Models\Cenc_ConapModel;
use App\Models\Cnth_HerramientasModel;
use App\Models\Cnth_MovimientosModel;
use App\Models\Comp_ProveedoresModel;
use App\Models\GruposModel;
use App\Models\Gsta_AsistenciasValidacionModel;
use App\Models\Resg_ResguardoModel;
use App\Models\Sols_ResponsablesModel;
use App\Models\Sols_ServiciosModel;
use App\Models\Sols_SolicitudesModel;
use App\Models\Sols_SubServiciosModel;
use App\Models\Cntc_Solicitudes_DespachoModel;
use App\Models\Cntc_Solicitudes_IngresoModel;
use App\Models\Cntc_Tipo_CombustibleModel;
use App\Models\Cntt_Reemplazo_TonerModel;
use App\Models\Emba_MaquinasModel;
use App\Models\Emba_ParametrosModel;
use App\Models\Emba_Registros_ParametrosModel;
use App\Models\Emba_EmbarcacionesModel;
use App\Models\DepartamentosModel;
use App\Models\Asal_VehiculosModel;
use App\Models\SubgruposModel;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;
class InicioController extends Controller
{
    public function inicio()
    {
        $articulos = ArticulosModel::count();
        $proveedores = Comp_ProveedoresModel::count();
        $despachos = Cnth_MovimientosModel::count();
        $activos = Actv_ActivosModel::count();
        $salidas = Asal_SalidasModel::count();
        $solicitudes = Sols_SolicitudesModel::count();
        $conaps = Cenc_ConapModel::count();
        $usuarios = User::count();
        $resguardos = Resg_ResguardoModel::ArticulosResguardo()->count();
        $auditoria = Audi_Auditoria_InventarioModel::count();
        $asistencias = Gsta_AsistenciasValidacionModel::distinct('fecha_validacion')->count();
        $despachoscombustible=Cntc_Solicitudes_DespachoModel::count();
        $reemplazos=Cntt_Reemplazo_TonerModel::count();
        $embarcaciones=Emba_EmbarcacionesModel::count();

        $hoy = getdate();
        $hora=$hoy["hours"];
        
        if ($hora < 6) 
        { 
            $bienvenida = 'Buenas Madrugadas ';
        }
        elseif ($hora < 12) 
            { 
                $bienvenida = 'Buenos Días ';
            }
            elseif($hora<=18)
                {
                    $bienvenida = 'Buenas Tardes ';
                }
                else
                    { 
                        $bienvenida = 'Buenas Noches '; 
                    }

        return view('inicio', compact('articulos', 'proveedores', 'despachos', 'activos', 'salidas', 'solicitudes', 'conaps', 'resguardos', 'auditoria', 'asistencias', 'despachoscombustible','reemplazos','embarcaciones','usuarios', 'bienvenida'));
    }

    public function DashboardFichaTecnica()
    {
        $articulos = ArticulosModel::count();
        $almacenes = AlmacenesModel::count();
        $grupos = GruposModel::count();
        $subgrupos = SubgruposModel::count();
        $UltimosArticulos = ArticulosModel::UltimosArticulos();
        return view('FichaTecnica.DashboardFict', compact('articulos', 'almacenes', 'grupos', 'subgrupos', 'UltimosArticulos'));
    }

    public function DashboardControlHerramientas()
    {
        $herramientas = Cnth_HerramientasModel::count();
        $despachos = Cnth_MovimientosModel::count();
        $recepciones = Cnth_MovimientosModel::where('estatus', 'RECEPCION')->count();
        $CantidadHerramientasPendientes = Cnth_HerramientasModel::HerramientasRecepcionPendiente(Auth::user()->id)->count();
        $HerramientasPendientes = Cnth_HerramientasModel::HerramientasRecepcionPendiente(Auth::user()->id);
        return view('ControlHerramientas.DashboardCnth', compact('herramientas', 'despachos', 'recepciones', 'CantidadHerramientasPendientes', 'HerramientasPendientes'));
    }

    public function DashboardCompras()
    {
        $articulos = ArticulosModel::count();
        $almacenes = AlmacenesModel::count();
        $grupos = GruposModel::count();
        $subgrupos = SubgruposModel::count();
        $UltimosArticulos = ArticulosModel::UltimosArticulos();
        return view('FichaTecnica.dashboard', compact('articulos', 'almacenes', 'grupos', 'subgrupos', 'UltimosArticulos'));
    }

    public function DashboardSolicitudesServicios(Request $request)
    {
        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');

        $solicitudes = Sols_SolicitudesModel::where('id_departamento_servicio', Auth::user()->id_departamento)->count();
        $servicios= Sols_ServiciosModel::where('id_departamento', Auth::user()->id_departamento)->count();
        $subservicios = DB::table('sols_subservicios as sub')
            ->join('sols_servicios as ser', 'ser.id_servicio', '=', 'sub.id_servicio')
            ->where('ser.id_departamento', Auth::user()->id_departamento)
            ->count();

        $responsables = Sols_ResponsablesModel::where('id_departamento', Auth::user()->id_departamento)->count();
        $SolicitudesServicios = Sols_SolicitudesModel::SolicitudesServiciosDepartamento(Auth::user()->id_departamento, $FechaInicio, $FechaFin);
        $SolicitudesSubServicios = Sols_SolicitudesModel::SolicitudesSubServiciosDepartamento(Auth::user()->id_departamento, $FechaInicio, $FechaFin);
        $SolicitudesDepartamentoSolicitante =  Sols_SolicitudesModel::SolicitudesDepartamentoSolicitante(Auth::user()->id_departamento, $FechaInicio, $FechaFin);
        $SolicitudesEstatus = Sols_SolicitudesModel::SolicitudesEstatusDepartamento(Auth::user()->id_departamento, $FechaInicio, $FechaFin);
        $SolicitudesResponsable = Sols_SolicitudesModel::SolicitudesResponsableDepartamento(Auth::user()->id_departamento, $FechaInicio, $FechaFin);
        $SolicitudesSubServiciosDetalle = Sols_SolicitudesModel::SolicitudesSubserviciosDepartamentoDetalle(Auth::user()->id_departamento, $FechaInicio, $FechaFin);
        $SolicitudesDepartamentoSolicitanteDetalle = Sols_SolicitudesModel::SolicitudesDepartamentoSolicitanteDetalle(Auth::user()->id_departamento, $FechaInicio, $FechaFin);
        
        return view('SolicitudesServicios.DashboardSols', compact('solicitudes', 'servicios', 'subservicios', 'responsables', 'SolicitudesServicios', 
                    'SolicitudesSubServicios', 'SolicitudesDepartamentoSolicitante', 'SolicitudesEstatus', 'SolicitudesResponsable', 'SolicitudesSubServiciosDetalle',
                    'SolicitudesDepartamentoSolicitanteDetalle'));
    }

    public function DashboardGestionAsistencia(Request $request){

        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');
        $departamento = $request->departamento;
        $departamentos = Gsta_AsistenciasValidacionModel::DepartamentosNomina();
        $ausencias= Gsta_AsistenciasValidacionModel::AusenciasDepartamento($FechaInicio,$FechaFin);
        $retardos= Gsta_AsistenciasValidacionModel::TardeDepartamento($FechaInicio,$FechaFin);
        $ausenciasempleados= Gsta_AsistenciasValidacionModel::AusenciasEmpleado($FechaInicio,$FechaFin,$departamento);
        $retardosempleados= Gsta_AsistenciasValidacionModel::RetardosEmpleado($FechaInicio,$FechaFin,$departamento);
        $empleados=Gsta_AsistenciasValidacionModel::Empleados();
       

        if(empty($request->fecha_inicio) || empty($request->fecha_fin)) {
            $FechaInicio = $request->get('fecha_inicio');
            $FechaFin = $request->get('fecha_fin');
        }
     
        return view('GestionAsistencia.DashboardGsta',compact('ausencias','retardos','departamentos','ausenciasempleados','retardosempleados','FechaInicio', 'FechaFin','empleados'));


    }
    public function DashboardControlCombustible(Request $request)
    {   
        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');
        
     
        // Crear un objeto DateTime a partir de la fecha
        $date = new DateTime($FechaInicio);

        // Extraer el año usando el método format
        $year = $date->format('Y');
        $tipos= Cntc_Tipo_CombustibleModel::all();
        $IdCombustible= $request->id_combustible;
        $departamentos = DepartamentosModel::select('id_departamento', 'nombre_departamento')->get();
        $vehiculos = Asal_VehiculosModel::all();
        $reportes=Cntc_Solicitudes_DespachoModel::reporteanual($IdCombustible,$year);
        $equipos=Cntc_Solicitudes_DespachoModel::reporteanualequipos($IdCombustible,$year);
        $ingresos=Cntc_Solicitudes_IngresoModel::reporteanual($IdCombustible,$year);
        return view('ControlCombustible.Dashboard.DashboardCombustible', compact('tipos','reportes','equipos','ingresos','vehiculos','departamentos','year'));

    }
    public function DashboardControlToner(Request $request)
    {   
        $departamentos = DepartamentosModel::select('id_departamento','nombre_departamento')->get();
        $FechaInicio =   $request->get('fecha_inicio');
        $FechaFin =   $request->get('fecha_fin');
        $departamento = $request->departamento;
        $promedios= Cntt_Reemplazo_TonerModel::PromedioHojas($departamento,$FechaInicio,$FechaFin);
        return view('ControlToner.Dashboard.DashboardToner',compact('departamentos','promedios'));
    }

    public function DashboardEmbarcaciones(Request $request)
    {   
        
        
        $maquinas = Emba_MaquinasModel::select('id_maquina', 'nombre_maquina')->get();
        $EstadisticasParametros = null;
        
        if ($request->has('id_maquina') && $request->has('fecha') && $request->has('id_parametro')) 
        {
            $IdMaquina = $request->get('id_maquina');
            $fecha = $request->get('fecha');
            $IdParametro = $request->get('id_parametro');

            //ESTADISTICAS PARAMETROS
            $EstadisticasParametros = Emba_Registros_ParametrosModel::EstadisticasRegistrosMaquinasFecha($IdMaquina, $IdParametro, $fecha);

            //GRAFICO PARAMETROS
            if($IdParametro == 0) //TODOS LOS PARAMETROS
            {
                try
                {
                    $GraficoColumnas = Emba_Registros_ParametrosModel::BuscarRegistroParametros($IdMaquina, $fecha);
                    $GraficoRegistros = Emba_Registros_ParametrosModel::RegistroParametrosHoras($IdMaquina, $fecha);
                    $TipoGrafico = 'TODOS';
                }
                catch(Exception $ex)
                    {
                        $GraficoColumnas = null;
                        $GraficoRegistros = null;
                        $TipoGrafico = null;

                        Session::flash('alert','No Hay Datos Para Mostrar');
                    }
            }
            else //BUSCAR VALORES POR MAQUINA PARAMETRO Y FECHA
                {
                    try
                    {
                        $GraficoRegistros = Emba_Registros_ParametrosModel::RegistroParametroMaquinaFecha($IdMaquina, $IdParametro, $fecha);
                        $GraficoColumnas = $GraficoRegistros[0]->nombre_parametro;
                        $TipoGrafico = 'INDIVIDUAL';
                    }
                    catch(Exception $ex)
                        {
                            $GraficoColumnas = null;
                            $GraficoRegistros = null;
                            $TipoGrafico = null;

                            Session::flash('alert','No Hay Datos Para Mostrar');
                        }
                }          
        }
        else
            {
                $GraficoColumnas = null;
                $GraficoRegistros = null;
                $TipoGrafico = null;
            }

        return view('Embarcaciones.Dashboard.DashboardEmbarcaciones', compact('maquinas','GraficoRegistros','GraficoColumnas', 'TipoGrafico', 'EstadisticasParametros'));
    }

}