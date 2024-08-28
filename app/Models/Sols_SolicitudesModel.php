<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class Sols_SolicitudesModel extends Model
{
    use HasFactory;

    protected $table = 'sols_solicitudes';
    protected $primaryKey = 'id_solicitud';

    protected $fillable = [
        'id_solicitud',
        'codigo_solicitud',
        'asunto_solicitud',
        'descripcion_solicitud',
        'id_departamento_solicitud',
        'id_departamento_servicio',
        'id_servicio',
        'id_subservicio',
        'estatus',
        'fecha_creacion',
        'creado_por',
        'aceptada',
        'fecha_aceptacion',
        'aceptada_por',
        'fecha_asignacion',
        'asignado_por',
        'fecha_cierre',
        'cerrado_por',
        'fecha_finalizacion',
        'finalizado_por',
        'fecha_anulacion',
        'anulado_por',
        'direccion_ip',
        'comentario_interno',
        'archivo',
        'prioridad',
        'observaciones',
        'acciones_aplicadas',
        'porc_avance',
        'avance',
        'logistica_origen',
        'logistica_destino',
        'logistica_fecha',
        'logistica_telefono',
        'mantenimiento_tipo_equipo',
        'mantenimiento_nombre_equipo',
        'mantenimiento_codigo_equipo',
        'encuesta_solicitud_enviada',
        'encuesta_servicio_enviada'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ListaSolicitudes()
    {
        return DB::table('sols_solicitudes as sol')
                ->join('sols_servicios as ser', 'sol.id_servicio','=', 'ser.id_servicio')
                ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
                ->join('users as u', 'sol.creado_por', '=', 'u.id')
                ->join('departamentos as dep', 'sol.id_departamento_servicio', '=', 'dep.id_departamento')
                ->join('departamentos as depa','sol.id_departamento_solicitud', '=', 'depa.id_departamento')
                ->leftJoin('sols_solicitudes_responsables as r', 'sol.id_solicitud', '=', 'r.id_solicitud')
                ->select(
                    'sol.id_solicitud',
                    'sol.codigo_solicitud',
                    'sol.asunto_solicitud',
                    'sol.descripcion_solicitud',
                    'sol.id_departamento_solicitud',
                    'depa.nombre_departamento as nombre_departamento_solicitud',
                    'sol.id_departamento_servicio',
                    'dep.nombre_departamento as nombre_departamento_servicio',
                    'sol.id_servicio',
                    'ser.nombre_servicio',
                    'sol.id_subservicio',
                    'sub.nombre_subservicio',
                    'sol.prioridad',
                    'sol.estatus',
                    DB::raw("CONVERT(VARCHAR(10), sol.fecha_creacion, 105) + ' ' + RIGHT(CONVERT(VARCHAR, sol.fecha_creacion, 100), 7) as fecha_creacion"),
                    //'sol.creado_por',
                    'u.name as creado_por',
                    //'u.email as correo_usuario',
                    //'sol.fecha_asignacion',
                    //'sol.asignado_por',
                    //'sol.fecha_cierre',
                    //'sol.cerrado_por',
                    //'sol.fecha_finalizacion',
                    //'sol.finalizado_por',
                    //'sol.fecha_anulacion',
                    //'sol.anulado_por',
                    //'sol.direccion_ip',
                    //'sol.comentario_interno',
                    'sol.encuesta_solicitud_enviada',
                    'sol.encuesta_servicio_enviada',
                    DB::raw("STRING_AGG(r.nombre_responsable, ', ') as responsables")
                    )
                ->groupBy(
                    'sol.id_solicitud',
                    'sol.codigo_solicitud',
                    'sol.asunto_solicitud',
                    'sol.descripcion_solicitud',
                    'sol.id_servicio',
                    'ser.nombre_servicio',
                    'sol.id_subservicio',
                    'sub.nombre_subservicio',
                    'sol.id_departamento_servicio',
                    'sol.id_departamento_solicitud',
                    'dep.nombre_departamento',
                    'depa.nombre_departamento',
                    'sol.estatus',
                    'sol.fecha_creacion',
                    'sol.creado_por',
                    'u.name',
                    'sol.prioridad',
                    'sol.encuesta_solicitud_enviada',
                    'sol.encuesta_servicio_enviada',
                )
                ->get();
    }

    public static function SolicitudesUsuario($IdUsuario)
    {
        return DB::table('sols_solicitudes as sol') 
                ->join('sols_servicios as ser', 'sol.id_servicio', '=', 'ser.id_servicio')
                ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
                ->join('users as u', 'u.id', '=', 'sol.creado_por')
                ->select(
                    'sol.id_solicitud',
                    'sol.codigo_solicitud',
                    'sol.asunto_solicitud',
                    'sol.descripcion_solicitud',
                    'sol.id_servicio',
                    'ser.nombre_servicio',
                    'sol.id_subservicio',
                    'sub.nombre_subservicio',
                    'sol.id_departamento_servicio',
                    'sol.id_departamento_solicitud',
                    'sol.estatus',
                    'sol.fecha_creacion',
                    'sol.creado_por as id_solicitante',
                    'u.name as creado_por',
                    'sol.prioridad',
                    'sol.encuesta_solicitud_enviada',
                    'sol.encuesta_servicio_enviada'
                    )
                ->where('sol.creado_por', '=', $IdUsuario) 
                ->get();   
    }

    public static function SolicitudesAsignadas($IdUsuario)
    {
        return DB::table('sols_solicitudes as sol') 
                ->join('sols_solicitudes_responsables as res', 'sol.id_solicitud', '=', 'res.id_solicitud')
                ->join('sols_servicios as ser', 'sol.id_servicio', '=', 'ser.id_servicio')
                ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
                ->join('users as u', 'u.id', '=', 'sol.creado_por')
                ->select(
                    'sol.id_solicitud',
                    'sol.codigo_solicitud',
                    'sol.asunto_solicitud',
                    'sol.descripcion_solicitud',
                    'sol.id_servicio',
                    'ser.nombre_servicio',
                    'sol.id_subservicio',
                    'sub.nombre_subservicio',
                    'sol.id_departamento_servicio',
                    'sol.id_departamento_solicitud',
                    'sol.estatus',
                    'sol.fecha_creacion',
                    'sol.creado_por as id_solicitante',
                    'u.name as creado_por',
                    'sol.prioridad',
                    'sol.encuesta_solicitud_enviada',
                    'sol.encuesta_servicio_enviada',
                    'res.nombre_responsable'
                    )
                ->where('res.id_responsable', '=', $IdUsuario) 
                ->get();   
    }

    public static function SolicitudesDepartamento($IdDepartamento)
    {
        return DB::table('sols_solicitudes as sol') 
                ->join('sols_servicios as ser', 'sol.id_servicio', '=', 'ser.id_servicio')
                ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
                ->join('users as u', 'u.id', '=', 'sol.creado_por')
                ->leftJoin('sols_solicitudes_responsables as r', 'sol.id_solicitud', '=', 'r.id_solicitud')
                ->select(
                    'sol.id_solicitud',
                    'sol.codigo_solicitud',
                    'sol.asunto_solicitud',
                    'sol.descripcion_solicitud',
                    'sol.id_servicio',
                    'ser.nombre_servicio',
                    'sol.id_subservicio',
                    'sub.nombre_subservicio',
                    'sol.id_departamento_servicio',
                    'sol.id_departamento_solicitud',
                    'sol.estatus',
                    'sol.fecha_creacion',
                    'sol.creado_por as id_solicitante',
                    'u.name as creado_por',
                    'sol.prioridad',
                    'sol.encuesta_solicitud_enviada',
                    'sol.encuesta_servicio_enviada',
                    DB::raw("STRING_AGG(r.nombre_responsable, ', ') as responsables")
                    )
                ->groupBy(
                    'sol.id_solicitud',
                    'sol.codigo_solicitud',
                    'sol.asunto_solicitud',
                    'sol.descripcion_solicitud',
                    'sol.id_servicio',
                    'ser.nombre_servicio',
                    'sol.id_subservicio',
                    'sub.nombre_subservicio',
                    'sol.id_departamento_servicio',
                    'sol.id_departamento_solicitud',
                    'sol.estatus',
                    'sol.fecha_creacion',
                    'sol.creado_por',
                    'u.name',
                    'sol.prioridad',
                    'sol.encuesta_solicitud_enviada',
                    'sol.encuesta_servicio_enviada',
                )    
                ->where('sol.id_departamento_servicio', '=', $IdDepartamento) 
                ->orWhere('sol.id_departamento_solicitud', '=', $IdDepartamento) 
                ->get();  
    }
    
    public static function SolicitudesPendientes($IdDepartamento)
    {
        return DB::table('sols_solicitudes as sol') 
                ->join('sols_servicios as ser', 'sol.id_servicio', '=', 'ser.id_servicio')
                ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
                ->join('users as u', 'u.id', '=', 'sol.creado_por')
                ->select(
                    'sol.id_solicitud',
                    'sol.codigo_solicitud',
                    'sol.asunto_solicitud',
                    'sol.descripcion_solicitud',
                    'sol.id_servicio',
                    'ser.nombre_servicio',
                    'sol.id_subservicio',
                    'sub.nombre_subservicio',
                    'sol.id_departamento_servicio',
                    'sol.id_departamento_solicitud',
                    'sol.estatus',
                    'sol.fecha_creacion',
                    'sol.creado_por as id_solicitante',
                    'u.name as creado_por',
                    'sol.prioridad',
                    'sol.encuesta_solicitud_enviada',
                    'sol.encuesta_servicio_enviada',
                    )
                ->where('sol.id_departamento_servicio', '=', $IdDepartamento) 
                ->Where('sol.estatus', '!=', 'FINALIZADO' ) 
                ->get();  
    }

    public static function SolicitudesEstatus($IdDepartamento, $estatus)
    {
        return DB::table('sols_solicitudes as sol') 
                ->join('sols_servicios as ser', 'sol.id_servicio', '=', 'ser.id_servicio')
                ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
                ->join('users as u', 'u.id', '=', 'sol.creado_por')
                ->select(
                    'sol.id_solicitud',
                    'sol.codigo_solicitud',
                    'sol.asunto_solicitud',
                    'sol.descripcion_solicitud',
                    'sol.id_servicio',
                    'ser.nombre_servicio',
                    'sol.id_subservicio',
                    'sub.nombre_subservicio',
                    'sol.id_departamento_servicio',
                    'sol.id_departamento_solicitud',
                    'sol.estatus',
                    'sol.fecha_creacion',
                    'sol.creado_por as id_solicitante',
                    'u.name as creado_por',
                    'sol.prioridad',
                    'sol.encuesta_solicitud_enviada',
                    'sol.encuesta_servicio_enviada',
                    )
                ->where('sol.id_departamento_servicio', '=', $IdDepartamento) 
                ->Where('sol.estatus', '=', $estatus) 
                ->get();  
    }

    public static function VerSolicitud($IdSolicitud)
    {
        return DB::table('sols_solicitudes as sol')
                ->join('sols_servicios as ser', 'sol.id_servicio','=', 'ser.id_servicio')
                ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
                ->join('users as u', 'sol.creado_por', '=', 'u.id')
                ->join('departamentos as dep', 'sol.id_departamento_servicio', '=', 'dep.id_departamento')
                ->join('departamentos as depa','sol.id_departamento_solicitud', '=', 'depa.id_departamento')
    
                ->select(
                    'sol.id_solicitud',
                    'sol.codigo_solicitud',
                    'sol.asunto_solicitud',
                    'sol.descripcion_solicitud',
                    'sol.id_departamento_solicitud',
                    'depa.nombre_departamento as nombre_departamento_solicitud',
                    'sol.id_departamento_servicio',
                    'dep.nombre_departamento as nombre_departamento_servicio',
                    'sol.id_servicio',
                    'ser.nombre_servicio',
                    'sol.id_subservicio',
                    'sub.nombre_subservicio',
                    'sol.estatus',
                    'sol.prioridad',
                    DB::raw("CONVERT(VARCHAR(10), sol.fecha_creacion, 105) + ' ' + RIGHT(CONVERT(VARCHAR, sol.fecha_creacion, 100), 7) as fecha_creacion"),
                    'sol.creado_por as id_solicitante',
                    'u.name as creado_por',
                    'u.email as correo_usuario',
                    'sol.aceptada',
                    DB::raw("CONVERT(VARCHAR(10), sol.fecha_aceptacion, 105) + ' ' + RIGHT(CONVERT(VARCHAR, sol.fecha_aceptacion, 100), 7) as fecha_aceptacion"),
                    //'sol.fecha_aceptacion',
                    'sol.aceptada_por',
                    DB::raw("CONVERT(VARCHAR(10), sol.fecha_asignacion, 105) + ' ' + RIGHT(CONVERT(VARCHAR, sol.fecha_asignacion, 100), 7) as fecha_asignacion"),
                    //'sol.fecha_asignacion',
                    'sol.asignado_por',
                    DB::raw("CONVERT(VARCHAR(10), sol.fecha_cierre, 105) + ' ' + RIGHT(CONVERT(VARCHAR, sol.fecha_cierre, 100), 7) as fecha_cierre"),
                    //'sol.fecha_cierre',
                    'sol.cerrado_por',
                    DB::raw("CONVERT(VARCHAR(10), sol.fecha_finalizacion, 105) + ' ' + RIGHT(CONVERT(VARCHAR, sol.fecha_finalizacion, 100), 7) as fecha_finalizacion"),
                    //'sol.fecha_finalizacion',
                    'sol.finalizado_por',
                    DB::raw("CONVERT(VARCHAR(10), sol.fecha_anulacion, 105) + ' ' + RIGHT(CONVERT(VARCHAR, sol.fecha_anulacion, 100), 7) as fecha_anulacion"),
                    //'sol.fecha_anulacion',
                    'sol.anulado_por',
                    'sol.direccion_ip',
                    'sol.comentario_interno',
                    'sol.logistica_origen',
                    'sol.logistica_destino',
                    'sol.logistica_fecha',
                    'logistica_telefono',
                    'mantenimiento_tipo_equipo',
                    'mantenimiento_nombre_equipo',
                    'mantenimiento_codigo_equipo',
                )
                ->where('sol.id_solicitud', '=', $IdSolicitud)
                ->first();
    }

    public static function SolicitudesPendientesPorFinalizar($IdDepartamanetoSolicitante)
    {
        return DB::table('sols_solicitudes')   
            ->selectRaw('count(id_solicitud) as solicitudes_pendientes')
            ->where('estatus', '=', 'CERRADO')
            ->where('encuesta_servicio_enviada', '=', 'NO')
            ->where('id_departamento_solicitud', '=', $IdDepartamanetoSolicitante)
            ->value('solicitudes_pendientes');
    }

    public static function ReporteSolicitudesLogistica($FechaInicio, $FechaFin, $estatus)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('d-m-Y');
        $FechaFin = Carbon::parse($FechaFin)->format('d-m-Y');

         $solicitudes = DB::table('sols_solicitudes as sol')
            ->join('sols_servicios as ser', 'sol.id_servicio', '=', 'ser.id_servicio')
            ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
            ->join('users as u', 'sol.creado_por', '=', 'u.id')
            ->join('departamentos as d', 'sol.id_departamento_solicitud', '=', 'd.id_departamento')
            ->select(
                'sol.id_solicitud',
                'd.nombre_departamento',
                'u.name',
                'ser.nombre_servicio',
                'sub.nombre_subservicio',
                'sol.logistica_origen',
                'sol.logistica_destino',
                'sol.fecha_creacion',
                'sol.logistica_fecha',             
                )
            ->where('sol.id_departamento_servicio', '=', '9');

                if($estatus != 'TODOS' ) 
                {
                    $solicitudes->where('sol.estatus', '=', $estatus);
                }

                // $solicitudes->where('s.id_almacen', '=', $IdAlmacen);   
                $solicitudes->whereBetween( DB::raw("CONVERT(date, sol.fecha_creacion)"), [$FechaInicio, $FechaFin]);
               
                return  $solicitudes->get();
    }

    public static function ListaSolicitudesLogistica()
    {
    
        return DB::table('sols_solicitudes as sol')
            ->join('sols_servicios as ser', 'sol.id_servicio', '=', 'ser.id_servicio')
            ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
            ->join('users as u', 'sol.creado_por', '=', 'u.id')
            ->join('departamentos as d', 'sol.id_departamento_solicitud', '=', 'd.id_departamento')
            ->select(
                'sol.id_solicitud',
                'd.nombre_departamento',
                'u.name',
                'ser.nombre_servicio',
                'sub.nombre_subservicio',
                'sol.logistica_origen',
                'sol.logistica_destino',
                'sol.fecha_creacion',
                'sol.logistica_fecha',             
            )
            ->where('sol.id_departamento_servicio', '=', '9')
            ->get();
    }

    public static function ReporteSolicitudesDepartamentos($FechaInicio, $FechaFin, $estatus,$departamento)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('d-m-Y');
        $FechaFin = Carbon::parse($FechaFin)->format('d-m-Y');

         $solicitudes = DB::table('sols_solicitudes as sol') 
         ->join('sols_servicios as ser', 'sol.id_servicio', '=', 'ser.id_servicio')
         ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
         ->join('users as u', 'u.id', '=', 'sol.creado_por')
         ->select(
             'sol.id_solicitud',
             'sol.codigo_solicitud',
             'sol.asunto_solicitud',
             'sol.descripcion_solicitud',
             'sol.id_servicio',
             'ser.nombre_servicio',
             'sol.id_subservicio',
             'sub.nombre_subservicio',
             'sol.id_departamento_servicio',
             'sol.id_departamento_solicitud',
             'sol.estatus',
             'sol.fecha_creacion',
             'sol.creado_por as id_solicitante',
             'u.name as creado_por',
             'sol.prioridad',
             'sol.encuesta_solicitud_enviada',
             'sol.encuesta_servicio_enviada',
             )
            ->where('sol.id_departamento_servicio', '=', $departamento);

                if($estatus != 'TODOS' ) 
                {
                    $solicitudes->where('sol.estatus', '=', $estatus);
                }

                $solicitudes->whereBetween( DB::raw("CONVERT(date, sol.fecha_creacion)"), [$FechaInicio, $FechaFin]);
               
                return  $solicitudes->get();
    }

    public static function ListaSolicitudesDepartamentos($departamento)
    {
    
        return DB::table('sols_solicitudes as sol') 
        ->join('sols_servicios as ser', 'sol.id_servicio', '=', 'ser.id_servicio')
        ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
        ->join('users as u', 'u.id', '=', 'sol.creado_por')
        ->select(
            'sol.id_solicitud',
            'sol.codigo_solicitud',
            'sol.asunto_solicitud',
            'sol.descripcion_solicitud',
            'sol.id_servicio',
            'ser.nombre_servicio',
            'sol.id_subservicio',
            'sub.nombre_subservicio',
            'sol.id_departamento_servicio',
            'sol.id_departamento_solicitud',
            'sol.estatus',
            'sol.fecha_creacion',
            'sol.creado_por as id_solicitante',
            'u.name as creado_por',
            'sol.prioridad',
            'sol.encuesta_solicitud_enviada',
            'sol.encuesta_servicio_enviada',
            )
            ->where('sol.id_departamento_servicio', '=', $departamento)
            ->get();
    }

    public static function SolicitudesServiciosDepartamento($IdDepartamento, $FechaInicio, $FechaFin)
    {
        return DB::table('sols_solicitudes as sol')
                ->join('sols_servicios as ser', 'sol.id_servicio', '=', 'ser.id_servicio')
                ->select(
                    'ser.nombre_servicio', 
                    DB::raw('COUNT(sol.id_solicitud) as cantidad')    
                )
                ->where('sol.id_departamento_servicio', '=', $IdDepartamento)
                ->whereBetween( DB::raw("CONVERT(date, sol.fecha_creacion)"), [$FechaInicio, $FechaFin])
                ->groupBy('ser.nombre_servicio')
                ->get();    
    
    }

    public static function SolicitudesSubServiciosDepartamento($IdDepartamento, $FechaInicio, $FechaFin)
    {
        return DB::table('sols_solicitudes as sol')
                ->join('sols_subservicios as sub', 'sol.id_subservicio', '=', 'sub.id_subservicio')
                ->select(
                    'sub.nombre_subservicio', 
                    DB::raw('COUNT(sol.id_solicitud) as cantidad')    
                )
                ->where('sol.id_departamento_servicio', '=', $IdDepartamento)
                ->whereBetween( DB::raw("CONVERT(date, sol.fecha_creacion)"), [$FechaInicio, $FechaFin])
                ->groupBy('sub.nombre_subservicio')
                ->get();    
    }

    public static function SolicitudesDepartamentoSolicitante($IdDepartamento, $FechaInicio, $FechaFin)
    {
        return DB::table('sols_solicitudes as s')
                ->join('departamentos as d', 's.id_departamento_solicitud', '=', 'd.id_departamento')
                ->select(
                    'd.nombre_departamento', 
                    DB::raw('COUNT(s.id_solicitud) as cantidad')    
                )
                ->where('s.id_departamento_servicio', '=', $IdDepartamento)
                ->whereBetween( DB::raw("CONVERT(date, s.fecha_creacion)"), [$FechaInicio, $FechaFin])
                ->groupBy('d.nombre_departamento')
                ->get();    
    }

    public static function SolicitudesEstatusDepartamento($IdDepartamento, $FechaInicio, $FechaFin)
    {
        return DB::table('sols_solicitudes as s')
                ->select(
                    's.estatus', 
                    DB::raw('COUNT(s.id_solicitud) as cantidad')    
                )
                ->where('s.id_departamento_servicio', '=', $IdDepartamento)
                ->whereBetween( DB::raw("CONVERT(date, s.fecha_creacion)"), [$FechaInicio, $FechaFin])
                ->groupBy('s.estatus')
                ->get();    
    }

    public static function SolicitudesResponsableDepartamento($IdDepartamento, $FechaInicio, $FechaFin)
    {
        return DB::table('sols_solicitudes as s')
                ->join('sols_solicitudes_responsables as r', 's.id_solicitud', '=', 'r.id_solicitud')
                ->select(
                    'r.nombre_responsable', 
                    DB::raw('COUNT(s.id_solicitud) as cantidad')    
                )
                ->where('s.id_departamento_servicio', '=', $IdDepartamento)
                ->whereBetween( DB::raw("CONVERT(date, s.fecha_creacion)"), [$FechaInicio, $FechaFin])
                ->groupBy('r.nombre_responsable')
                ->get();    
    }

    public static function SolicitudesSubserviciosDepartamentoDetalle($IdDepartamento, $FechaInicio, $FechaFin)
    {

        return DB::select("
            SELECT 
                nombre_servicio,
                nombre_subservicio,
                [POR ACEPTAR] AS por_aceptar,
                [ABIERTO] as abierto,
                [NO PROCEDE] as no_procede,
                [ANULADO] as anulado, 
                [EN PROCESO] as en_proceso,
                [CERRADO] as cerrado,
                [FINALIZADO] as finalizado,
                sum([POR ACEPTAR] + [ABIERTO] + [NO PROCEDE] + [ANULADO] + [EN PROCESO] + [CERRADO] + [FINALIZADO]) as total
                
                FROM
                    (
                    SELECT 
                        sol.id_solicitud,
                        ser.nombre_servicio,
                        sub.nombre_subservicio,
                        sol.estatus

                    FROM sols_solicitudes as sol
                    INNER JOIN sols_servicios as ser ON ser.id_servicio = sol.id_servicio
                    INNER JOIN sols_subservicios as sub ON sub.id_subservicio = sol.id_subservicio
                
                    WHERE sol.id_departamento_servicio = $IdDepartamento 
                    and CONVERT(date, sol.fecha_creacion) between '$FechaInicio' and '$FechaFin'

                    GROUP BY sol.id_solicitud,  ser.nombre_servicio, sub.nombre_subservicio, sol.estatus -- dep.nombre_departamento, 

                    ) t
                PIVOT(
                    COUNT(id_solicitud) 
                    FOR estatus IN (
                        [POR ACEPTAR], 
                        [ABIERTO], 
                        [NO PROCEDE], 
                        [ANULADO], 
                        [EN PROCESO], 
                        [CERRADO], 
                        [FINALIZADO])
                ) AS pivot_table
            
            GROUP BY  
                nombre_servicio, 
                nombre_subservicio,  
                [POR ACEPTAR], 
                [ABIERTO], 
                [NO PROCEDE], 
                [ANULADO], 
                [EN PROCESO], 
                [CERRADO], 
                [FINALIZADO];
        ");
    }

    public static function SolicitudesDepartamentoSolicitanteDetalle($IdDepartamento, $FechaInicio, $FechaFin)
    {
        return DB::select("
            SELECT
                nombre_departamento,
                [POR ACEPTAR] AS por_aceptar,
                [ABIERTO] as abierto,
                [NO PROCEDE] as no_procede,
                [ANULADO] as anulado, 
                [EN PROCESO] as en_proceso,
                [CERRADO] as cerrado,
                [FINALIZADO] as finalizado,
                sum([POR ACEPTAR] + [ABIERTO] + [NO PROCEDE] + [ANULADO] + [EN PROCESO] + [CERRADO] + [FINALIZADO]) as total
                FROM
                (
                    SELECT 
                        sol.id_solicitud,
                        dep.nombre_departamento,
                        sol.estatus
                    
                    FROM sols_solicitudes as sol
                    INNER JOIN departamentos as dep ON dep.id_departamento = id_departamento_solicitud
            
                    WHERE sol.id_departamento_servicio = $IdDepartamento 
                    and CONVERT(date, sol.fecha_creacion) between '$FechaInicio' and '$FechaFin'
            
                    GROUP BY sol.id_solicitud,  dep.nombre_departamento,  sol.estatus 
                ) t
            PIVOT(
                COUNT(id_solicitud) 
                    FOR estatus IN (
                        [POR ACEPTAR], 
                        [ABIERTO], 
                        [NO PROCEDE], 
                        [ANULADO], 
                        [EN PROCESO], 
                        [CERRADO], 
                        [FINALIZADO])
            ) AS pivot_table
            GROUP BY   
                nombre_departamento, 
                [POR ACEPTAR], 
                [ABIERTO], 
                [NO PROCEDE], 
                [ANULADO], 
                [EN PROCESO], 
                [CERRADO], 
                [FINALIZADO];
        ");
    }

    public static function SolicitudesCerradasMayor5Dias()
    {
        return DB::table('sols_solicitudes')
            ->select(
                'id_solicitud',
                DB::raw("DATEDIFF(DAY, fecha_cierre, GETDATE()) AS dias")
                )
            ->where('estatus', '=', 'CERRADO')
            ->groupBy(
                'fecha_cierre',
                'id_solicitud'
                )
            ->havingRaw('DATEDIFF(DAY, fecha_cierre, GETDATE()) >= ?', ['5'])
            ->get();
    }

}
