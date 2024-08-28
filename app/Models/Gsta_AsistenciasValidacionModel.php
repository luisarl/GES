<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class Gsta_AsistenciasValidacionModel extends Model
{
    use HasFactory;
    
    protected $dateFormat = 'Y-d-m H:i'; 
    protected $primaryKey = 'id_validacion';
    protected $table = 'gsta_validaciones_asistencias';
    protected $fillable = [
        
        'id_validacion',
        'id_empleado',
        'id_biometrico',
        'fecha_validacion',
        'nombre_empleado',
        'hora_entrada',
        'hora_salida',
        'id_departamento',
        'id_empresa',
        'nombre_empresa',
        'id_novedad',
        'observacion',
        'estatus',
        'creado_por',
        'fecha_creacion',
        'actualizado_por',
        'fecha_actualizacion',
        'direccion_ip',
        'nombre_equipo',
        


    ];

    public static function HorasTrabajadas($IdDepartamento,$IdEmpresa,$FechaInicio,$FechaFin)
    {
            $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
            $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
            $InicioHoraDiurna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->inicio_hora_diurna;
            $FinHoraDiurna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->fin_hora_diurna;

            $InicioHoraNocturna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->inicio_hora_nocturna;
            $FinHoraNocturna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->fin_hora_nocturna;
            $registros = DB::table('gsta_validaciones_asistencias as a')

                ->join('gsta_horario_empleados as he','a.id_biometrico', '=','he.id_biometrico ')
                ->join('gsta_horarios as h','he.id_horario', '=','h.id_horario ')
                ->join('N_ACERO.dbo.sndepart as d','a.id_departamento','=','d.co_depart')
                ->select(
                    'a.id_validacion',
                    'a.nombre_empleado',
                    'a.hora_entrada',
                    'a.id_departamento',
                    'a.id_empresa',
                    'a.nombre_empresa',
                    'a.id_biometrico',
                    'a.id_empleado',
                    'a.hora_salida',
                    'a.observacion',
                    'a.fecha_validacion',
                    'a.estatus',
                    'd.des_depart',
                    'h.inicio_jornada',
                    'h.fin_jornada',
                    'h.inicio_descanso',
                    'fin_descanso',
                    
                   
                    DB::raw("(select min(hora) from BIOMETRICO.dbo.View_Registros_Empleados
                    where cod_biometrico = a.id_biometrico and fecha = a.fecha_validacion) as primera_hora"),
                    DB::raw("(select max(hora) from BIOMETRICO.dbo.View_Registros_Empleados
                    where cod_biometrico = a.id_biometrico and fecha = a.fecha_validacion) as ultima_hora"),
                    
                    DB::raw("CONVERT(VARCHAR(5), DATEADD(MINUTE, DATEDIFF(MINUTE, h.inicio_descanso, h.fin_descanso), 0), 108) as horas_descanso_formato"),

                    DB::raw("CONVERT(VARCHAR(5), 
                            DATEADD(MINUTE, 
                                DATEDIFF(MINUTE, h.inicio_jornada, h.fin_jornada) - DATEDIFF(MINUTE, h.inicio_descanso, h.fin_descanso), 
                                0), 108) as horas_jornada"),

                    
                    DB::raw("
                    CONVERT(VARCHAR(8), 
                        DATEADD(SECOND, 
                            CASE 
                                WHEN DATEDIFF(SECOND, 
                                    CONVERT(DATETIME, CONVERT(VARCHAR(10), (a.hora_entrada), 108), 108), 
                                    CONVERT(DATETIME, CONVERT(VARCHAR(10), (a.hora_salida), 108), 108)
                                    ) > 0 THEN 
                                    CASE
                                        WHEN DATEDIFF(SECOND, 
                                            CONVERT(DATETIME, CONVERT(VARCHAR(10), (a.hora_entrada), 108), 108), 
                                            CONVERT(DATETIME, CONVERT(VARCHAR(10), (a.hora_salida), 108), 108)
                                            ) < 3600 THEN
                                            DATEDIFF(SECOND, 
                                                CONVERT(DATETIME, CONVERT(VARCHAR(10), (a.hora_entrada), 108), 108), 
                                                CONVERT(DATETIME, CONVERT(VARCHAR(10), (a.hora_salida), 108), 108)
                                                )
                                        ELSE
                                            DATEDIFF(SECOND, 
                                                CONVERT(DATETIME, CONVERT(VARCHAR(10), (a.hora_entrada), 108), 108), 
                                                CONVERT(DATETIME, CONVERT(VARCHAR(10), (a.hora_salida), 108), 108)
                                                ) -  (DATEDIFF(SECOND, 
                                                CONVERT(DATETIME, CONVERT(VARCHAR(10), h.inicio_descanso, 108), 108), 
                                                CONVERT(DATETIME, CONVERT(VARCHAR(10), h.fin_descanso, 108), 108)
                                            ))
                                    END
                                ELSE 
                                    0 END, 108), 114) AS horas_trabajadas" ),

                    DB::raw("
                      CASE
                                        WHEN a.hora_salida > h.fin_jornada AND a.hora_entrada < h.inicio_jornada  THEN
                                            CONVERT(VARCHAR(8), 
                                            DATEADD(SECOND, 
                                                DATEDIFF(SECOND, h.fin_jornada, 
                                                    CASE WHEN a.hora_salida <= '$FinHoraDiurna' THEN a.hora_salida ELSE '$FinHoraDiurna' END
                                                ) + 
                                                DATEDIFF(SECOND, 
                                                    CASE WHEN a.hora_entrada >= '$InicioHoraDiurna' THEN a.hora_entrada ELSE '$InicioHoraDiurna' END, 
                                                    h.inicio_jornada
                                                ), 
                                            0), 108)

										 WHEN a.hora_salida > h.fin_jornada AND a.hora_entrada < h.inicio_jornada  AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, a.hora_entrada), 108) != h.fin_jornada  THEN
                                            CONVERT(VARCHAR(8), 
                                            DATEADD(SECOND, 
                                                DATEDIFF(SECOND,CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, a.hora_entrada), 108), 
                                                    CASE WHEN a.hora_salida <= '$FinHoraDiurna' THEN a.hora_salida ELSE '$FinHoraDiurna' END
                                                ) , 
                                            0), 108)

                                        WHEN a.hora_salida > h.fin_jornada and a.hora_entrada=h.inicio_jornada  THEN
                                            CASE
                                                WHEN a.hora_salida <= '$FinHoraDiurna' THEN
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, h.fin_jornada, a.hora_salida), 
                                                            0), 108)
                                                ELSE
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, h.fin_jornada, '$FinHoraDiurna'), 
                                                            0), 108)
                                            END

                                        WHEN a.hora_entrada < h.inicio_jornada  THEN
                                            CASE
                                                WHEN a.hora_entrada >= '$InicioHoraDiurna' THEN
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, a.hora_entrada, h.inicio_jornada), 
                                                            0), 108)
                                                WHEN a.hora_entrada < '$InicioHoraDiurna' AND a.hora_salida <= '$InicioHoraDiurna' THEN
                                                    CONVERT(VARCHAR(8), 
                                                    DATEADD(SECOND, 
                                                        DATEDIFF(SECOND, 1, 1), 
                                                        0), 108)
                                                 WHEN a.hora_entrada < '$InicioHoraDiurna' AND a.hora_salida < h.fin_jornada THEN
                                                    CONVERT(VARCHAR(8), 
                                                    DATEADD(SECOND, 
                                                        DATEDIFF(SECOND,CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, a.hora_entrada), 108),a.hora_salida), 
                                                        0), 108)
												ELSE
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, '$InicioHoraDiurna', h.inicio_jornada), 
                                                            0), 108)
                                            END
                                    ELSE
                                        '00:00:00'
                        END as horas_extra_diurnas"),

                    DB::raw("
                          CASE
                            -- Si la hora en que se cumplen las 9 horas es después de las 19:00
                            WHEN a.hora_salida > '$InicioHoraNocturna' AND a.hora_entrada < '$FinHoraNocturna' THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, '$InicioHoraNocturna', a.hora_salida) + 
                                        DATEDIFF(SECOND, a.hora_entrada, '$FinHoraNocturna'), 
                                        0), 108)

							WHEN a.hora_salida > '$InicioHoraNocturna' AND a.hora_entrada < '$FinHoraNocturna' AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, a.hora_entrada), 108) != h.fin_jornada  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, a.hora_entrada), 108), a.hora_salida) + 
                                        DATEDIFF(SECOND, a.hora_entrada, '$FinHoraNocturna'), 
                                        0), 108)

                            WHEN a.hora_salida > '$InicioHoraNocturna' AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, a.hora_entrada), 108) != h.fin_jornada AND a.hora_entrada > h.inicio_jornada THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, a.hora_entrada), 108), a.hora_salida), 
                                        0), 108)
							  WHEN a.hora_salida > '$InicioHoraNocturna'  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, '$InicioHoraNocturna', a.hora_salida), 
                                        0), 108)
                            WHEN a.hora_entrada < '$FinHoraNocturna' AND a.hora_salida <= '$FinHoraNocturna'  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, a.hora_entrada, a.hora_salida), 
                                        0), 108)
                            WHEN a.hora_entrada < '$FinHoraNocturna'  AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, a.hora_entrada), 108) = h.fin_jornada  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, a.hora_entrada, '$FinHoraNocturna'), 
                                        0), 108)
							
                            ELSE
                                '00:00:00'
                        END as horas_extra_nocturnas" )

                );
                
            if ($IdDepartamento!== 'TODOS') 
            {
                $registros->where('id_departamento', '=', $IdDepartamento);
            }
            if($IdEmpresa!=='TODAS')
            {
                $registros->where('id_empresa', '=', $IdEmpresa);
            }
            $registros->whereBetween(DB::raw("CONVERT(date, a.fecha_validacion)"), [$FechaInicio, $FechaFin])
                ->groupBy(
                        'a.nombre_empleado', 
                        'a.hora_entrada', 
                        'a.hora_salida',
                        
                        'a.observacion', 
                        'a.fecha_validacion',
                        'a.id_departamento',
                        'a.id_empresa',
                        'a.nombre_empresa',
                        'a.id_biometrico',
                        'a.estatus',
                        'a.id_validacion',
                        'a.id_empleado',
                        'd.des_depart', 
                        'h.fin_jornada',
                        'h.inicio_jornada',
                        'h.inicio_descanso',
                        'fin_descanso'
                    )
                    ->orderBy('d.des_depart')
                    ->orderBy('a.fecha_validacion', 'asc');
                
                
            return $registros->get();
                    
    }

    public static function ListadoValidaciones($IdDepartamento, $IdEmpresa, $FechaInicio, $FechaFin)
{
    $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
    $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');

    $registros = DB::table('gsta_validaciones_asistencias as a')
        ->join('N_ACERO.dbo.sndepart as d', 'a.id_departamento', '=', 'd.co_depart')
        ->select(
            'a.id_validacion',
            'a.nombre_empleado',
            'a.hora_entrada',
            'a.id_departamento',
            'a.id_empresa',
            'a.nombre_empresa',
            'a.id_biometrico',
            'a.id_empleado',
            'a.hora_salida',
            'a.observacion',
            'a.fecha_validacion',
            'a.estatus',
            'd.des_depart',
            DB::raw("(select min(hora) from BIOMETRICO.dbo.View_Registros_Empleados
                      where cod_biometrico = a.id_biometrico and fecha = a.fecha_validacion) as primera_hora"),
            DB::raw("(select max(hora) from BIOMETRICO.dbo.View_Registros_Empleados
                      where cod_biometrico = a.id_biometrico and fecha = a.fecha_validacion) as ultima_hora")
        );

    if ($IdDepartamento !== 'TODOS') {
        $registros->where('a.id_departamento', '=', $IdDepartamento);
    }

    if ($IdEmpresa !== 'TODAS') {
        $registros->where('a.id_empresa', '=', $IdEmpresa);
    }

    $registros->whereBetween(DB::raw("CONVERT(date, a.fecha_validacion)"), [$FechaInicio, $FechaFin])
              ->groupBy(
                  'a.id_validacion',
                  'a.nombre_empleado',
                  'a.hora_entrada',
                  'a.hora_salida',
                  'a.observacion',
                  'a.fecha_validacion',
                  'a.id_departamento',
                  'a.id_empresa',
                  'a.nombre_empresa',
                  'a.id_biometrico',
                  'a.estatus',
                  'a.id_empleado',
                  'd.des_depart'
              )
              ->orderBy('d.des_depart')
              ->orderBy('a.fecha_validacion', 'asc'); // Ordenar por departamento y fecha de validación

    return $registros->get();
}

    public static function ListadoValidacionesNove($IdDepartamento, $IdEmpresa, $FechaInicio,$FechaFin,$Novedades)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
        $registros = DB::table('gsta_validaciones_asistencias as a')
            ->join('gsta_validacion_novedades as vn', 'a.id_validacion', '=', 'vn.id_validacion')
            ->join('gsta_novedades as n', 'vn.id_novedad', '=', 'n.id_novedad')
            ->join('N_ACERO.dbo.sndepart as d', 'a.id_departamento', '=', 'd.co_depart')
            ->select(
                'a.id_validacion',
                'a.nombre_empleado',
                'a.hora_entrada',
                'a.id_departamento',
                'a.id_empresa',
                'a.nombre_empresa',
                'a.id_biometrico',
                'a.id_empleado',
                'a.hora_salida',
                'a.observacion',
                'a.fecha_validacion',
                'a.estatus',
                'd.des_depart',
                DB::raw("(select min(hora) from BIOMETRICO.dbo.View_Registros_Empleados
                        where cod_biometrico = a.id_biometrico and fecha = a.fecha_validacion) as primera_hora"),
                DB::raw("(select max(hora) from BIOMETRICO.dbo.View_Registros_Empleados
                        where cod_biometrico = a.id_biometrico and fecha = a.fecha_validacion) as ultima_hora")
            );

        if ($IdDepartamento !== 'TODOS') {
            $registros->where('a.id_departamento', '=', $IdDepartamento);
        }

        if ($IdEmpresa !== 'TODAS') {
            $registros->where('a.id_empresa', '=', $IdEmpresa);
        }

    
        $registros->whereBetween(DB::raw("CONVERT(date, a.fecha_validacion)"), [$FechaInicio, $FechaFin])
                ->groupBy(
                    'a.id_validacion',
                    'a.nombre_empleado',
                    'a.hora_entrada',
                    'a.hora_salida',
                    'a.observacion',
                    'a.fecha_validacion',
                    'a.id_departamento',
                    'a.id_empresa',
                    'a.nombre_empresa',
                    'a.id_biometrico',
                    'a.estatus',
                    'a.id_empleado',
                    'd.des_depart',
                    'n.descripcion'
                )
                ->orderBy('d.des_depart'); // Ordenar por departamento

        // Aplicar el filtro de novedades si $Novedades no es 'TODOS' y no está vacío
        if (!empty($Novedades) && $Novedades !== 'TODOS') {
            $registros->whereIn('n.id_novedad', $Novedades);
        }

        $registros->distinct();

        return $registros->get();
    }


    public static function ListadoValidacionesfecha($IdDepartamento, $IdEmpresa, $FechaInicio, $FechaFin, $Novedades)
{
    $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
    $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
    
    // Construir la consulta base
    $query = "
        DECLARE @fechas nvarchar(max)
        DECLARE @sql nvarchar(max)

        SELECT @fechas = ISNULL(@fechas + ',','')  
            + QUOTENAME(asistencias) 
        FROM (
                SELECT DISTINCT  
                va.fecha_validacion as asistencias
                FROM gsta_validaciones_asistencias as va
                WHERE va.fecha_validacion BETWEEN '$FechaInicio' AND '$FechaFin'
            ) AS asistencias

        SET @sql = 
        N' SELECT 
            *
        FROM
        (
            SELECT  
                va.nombre_empleado,
                va.nombre_empresa,
                va.fecha_validacion,
                d.des_depart,
                CONCAT(
                    CASE 
                        WHEN va.hora_entrada = ''00:00:00.0000000'' THEN ''00:00:00''
                        ELSE CONVERT(VARCHAR, va.hora_entrada, 22)
                    END,
                    '' - '', 
                    CASE 
                        WHEN va.hora_salida = ''00:00:00.0000000'' THEN ''00:00:00''
                        ELSE CONVERT(VARCHAR, va.hora_salida, 22)
                    END,
                    ''<br> NOVEDADES: '',
                    STRING_AGG(n.descripcion, '' - '')
                ) AS horas
            FROM gsta_validaciones_asistencias va
            INNER JOIN gsta_validacion_novedades as vn ON vn.id_validacion = va.id_validacion
            INNER JOIN gsta_novedades as n ON n.id_novedad = vn.id_novedad
            INNER JOIN N_ACERO.dbo.sndepart as d ON d.co_depart = va.id_departamento
            WHERE va.fecha_validacion BETWEEN ''$FechaInicio'' AND ''$FechaFin'' ";

    // Aplicar filtros opcionales
    if ($IdDepartamento !== 'TODOS') {
        $query .= " AND va.id_departamento = $IdDepartamento";
    }
    if ($IdEmpresa !== 'TODAS') {
        $query .= " AND va.id_empresa =''$IdEmpresa''";
    }
    
    // Filtrar por empleados que tienen las novedades especificadas
    if (!empty($Novedades) && $Novedades !== 'TODOS') {
        $novedadesList = implode(',', array_map('intval', $Novedades));
        $query .= " AND va.nombre_empleado IN (
            SELECT DISTINCT va2.nombre_empleado
            FROM gsta_validaciones_asistencias va2
            INNER JOIN gsta_validacion_novedades vn2 ON vn2.id_validacion = va2.id_validacion
            WHERE vn2.id_novedad IN ($novedadesList)
            AND va2.fecha_validacion BETWEEN ''$FechaInicio'' AND ''$FechaFin''
        )";
    }

    $query .= "
        GROUP BY 
            va.nombre_empleado,
            va.fecha_validacion,
            va.nombre_empresa,
            va.hora_entrada,
            va.hora_salida,
            d.des_depart
        ) as asistencias

    PIVOT(
        MAX(horas) FOR fecha_validacion IN('+ @fechas +')
    ) AS pvt
    ORDER BY pvt.des_depart';

    EXEC sp_executesql @sql;";
    
    $result = DB::select($query);

    // Extraer fechas
    $fechas = DB::select("SELECT DISTINCT va.fecha_validacion as asistencias
                        FROM gsta_validaciones_asistencias as va
                        WHERE va.fecha_validacion BETWEEN '$FechaInicio' AND '$FechaFin'
                        ORDER BY va.fecha_validacion");

    return [
        'result' => $result,
        'fechas' => array_map(function($f) {
            return $f->asistencias;
        }, $fechas)
    ];
}

    public static function Listadohorasextras($IdDepartamento, $IdEmpresa, $FechaInicio, $FechaFin)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
        $InicioHoraDiurna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->inicio_hora_diurna;
        $FinHoraDiurna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->fin_hora_diurna;

        $InicioHoraNocturna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->inicio_hora_nocturna;
        $FinHoraNocturna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->fin_hora_nocturna;
      
        // Construir la consulta base
        $query = "
            DECLARE @fechas nvarchar(max);
            DECLARE @sql nvarchar(max);
    
            SELECT @fechas = ISNULL(@fechas + ',', '')  
                + QUOTENAME(asistencias) 
            FROM (
                SELECT DISTINCT  
                    va.fecha_validacion as asistencias
                FROM gsta_validaciones_asistencias as va
                WHERE va.fecha_validacion BETWEEN '$FechaInicio' AND '$FechaFin'
            ) AS asistencias;
    
            SET @sql = N' 
            SELECT * FROM (
                SELECT
                    va.id_empleado,
                    va.id_biometrico,  
                    va.nombre_empleado,
                    va.nombre_empresa,
                    va.fecha_validacion,
                    d.des_depart,
                    CONCAT(
                        CASE 
                    WHEN va.hora_entrada = ''00:00:00.0000000'' THEN ''00:00:00''
                    ELSE CONVERT(VARCHAR, va.hora_entrada, 22)
                END,
                '' - '', 
                CASE 
                    WHEN va.hora_salida = ''00:00:00.0000000'' THEN ''00:00:00''
                    ELSE CONVERT(VARCHAR, va.hora_salida, 22)
                END,

                ''<br> Observacion: '',
                    va.observacion,

                CASE 
                    WHEN (DATEDIFF(SECOND, va.hora_entrada, va.hora_salida) / 3600.0)  > 9 THEN
                    CONCAT(
                       
                       ''<br> Horas Extra Diurna: '',
                                    CASE
                                        WHEN va.hora_salida > h.fin_jornada AND va.hora_entrada < h.inicio_jornada  THEN
                                            CONVERT(VARCHAR(8), 
                                            DATEADD(SECOND, 
                                                DATEDIFF(SECOND, h.fin_jornada, 
                                                    CASE WHEN va.hora_salida <= ''$FinHoraDiurna'' THEN va.hora_salida ELSE ''$FinHoraDiurna'' END
                                                ) + 
                                                DATEDIFF(SECOND, 
                                                    CASE WHEN va.hora_entrada >= ''$InicioHoraDiurna'' THEN va.hora_entrada ELSE ''$InicioHoraDiurna'' END, 
                                                    h.inicio_jornada
                                                ), 
                                            0), 108)

										 WHEN va.hora_salida > h.fin_jornada AND va.hora_entrada < h.inicio_jornada  AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108) != h.fin_jornada  THEN
                                            CONVERT(VARCHAR(8), 
                                            DATEADD(SECOND, 
                                                DATEDIFF(SECOND,CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108), 
                                                    CASE WHEN va.hora_salida <= ''$FinHoraDiurna'' THEN va.hora_salida ELSE ''$FinHoraDiurna'' END
                                                ) , 
                                            0), 108)

                                        WHEN va.hora_salida > h.fin_jornada and va.hora_entrada=h.inicio_jornada  THEN
                                            CASE
                                                WHEN va.hora_salida <= ''$FinHoraDiurna'' THEN
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, h.fin_jornada, va.hora_salida), 
                                                            0), 108)
                                                ELSE
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, h.fin_jornada, ''$FinHoraDiurna''), 
                                                            0), 108)
                                            END

                                        WHEN va.hora_entrada < h.inicio_jornada  THEN
                                            CASE
                                                WHEN va.hora_entrada >= ''$InicioHoraDiurna'' THEN
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, va.hora_entrada, h.inicio_jornada), 
                                                            0), 108)
                                                WHEN va.hora_entrada < ''$InicioHoraDiurna'' AND va.hora_salida <= ''$InicioHoraDiurna'' THEN
                                                    CONVERT(VARCHAR(8), 
                                                    DATEADD(SECOND, 
                                                        DATEDIFF(SECOND, 1, 1), 
                                                        0), 108)
                                                 WHEN va.hora_entrada < ''$InicioHoraDiurna'' AND va.hora_salida < h.fin_jornada THEN
                                                    CONVERT(VARCHAR(8), 
                                                    DATEADD(SECOND, 
                                                        DATEDIFF(SECOND,CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108),va.hora_salida), 
                                                        0), 108)
												ELSE
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, ''$InicioHoraDiurna'', h.inicio_jornada), 
                                                            0), 108)
                                            END
                                    ELSE
                                        ''00:00:00''
                        END,
                        ''<br> Horas Extra Nocturnas: '',
                        CASE
                            -- Si la hora en que se cumplen las 9 horas es después de las 19:00
                            WHEN va.hora_salida > ''$InicioHoraNocturna'' AND va.hora_entrada < ''$FinHoraNocturna'' THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, ''$InicioHoraNocturna'', va.hora_salida) + 
                                        DATEDIFF(SECOND, va.hora_entrada, ''$FinHoraNocturna''), 
                                        0), 108)

							WHEN va.hora_salida > ''$InicioHoraNocturna'' AND va.hora_entrada < ''$FinHoraNocturna'' AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108) != h.fin_jornada  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108), va.hora_salida) + 
                                        DATEDIFF(SECOND, va.hora_entrada, ''$FinHoraNocturna''), 
                                        0), 108)

                            WHEN va.hora_salida > ''$InicioHoraNocturna'' AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108) != h.fin_jornada AND va.hora_entrada > h.inicio_jornada THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108), va.hora_salida), 
                                        0), 108)
							  WHEN va.hora_salida > ''$InicioHoraNocturna''  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, ''$InicioHoraNocturna'', va.hora_salida), 
                                        0), 108)
                            WHEN va.hora_entrada < ''$FinHoraNocturna'' AND va.hora_salida <= ''$FinHoraNocturna''  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, va.hora_entrada, va.hora_salida), 
                                        0), 108)
                            WHEN va.hora_entrada < ''$FinHoraNocturna''  AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108) = h.fin_jornada  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, va.hora_entrada, ''$FinHoraNocturna''), 
                                        0), 108)
							
                            ELSE
                                ''00:00:00''
                        END
                    )
                ELSE
                    CONCAT(
                        ''<br> Horas Extra Diurna: 00:00:00'',
                        ''<br> Horas Extra Nocturnas: 00:00:00''
                    )
            END
                    ) AS horas
                FROM gsta_validaciones_asistencias va
                    INNER JOIN gsta_horario_empleados he ON he.id_biometrico = va.id_biometrico
                    INNER JOIN gsta_horarios h ON h.id_horario = he.id_horario
                    INNER JOIN N_ACERO.dbo.sndepart d ON d.co_depart = va.id_departamento
                WHERE va.fecha_validacion BETWEEN ''$FechaInicio'' AND ''$FechaFin''";
        
        // Aplicar filtros opcionales
        if ($IdDepartamento !== 'TODOS') {
            $query .= " AND va.id_departamento = $IdDepartamento";
        }
        if ($IdEmpresa !== 'TODAS') {
            $query .= " AND va.id_empresa = ''$IdEmpresa''";
        }
    
        $query .= "
            GROUP BY 
                va.id_empleado,
                va.id_biometrico,
                va.nombre_empleado,
                va.nombre_empresa,
                va.id_departamento,
                va.fecha_validacion,
                va.hora_entrada,
                va.hora_salida,
                h.inicio_jornada,
                h.fin_jornada,
                h.inicio_descanso,
                h.fin_descanso,
                va.observacion,
                d.des_depart
            ) AS asistencias
            PIVOT(
                MAX(horas) FOR fecha_validacion IN (' + @fechas + ')
            ) AS pvt
            ORDER BY pvt.des_depart';
        
        EXEC sp_executesql @sql;";
        
        $result = DB::select($query);
    
        // Extraer fechas
        $fechas = DB::select("
            SELECT DISTINCT va.fecha_validacion as asistencias
            FROM gsta_validaciones_asistencias as va
            WHERE va.fecha_validacion BETWEEN '$FechaInicio' AND '$FechaFin'
            ORDER BY va.fecha_validacion");
    
        return [
            'result' => $result,
            'fechas' => array_map(function($f) {
                return $f->asistencias;
            }, $fechas)
        ];
    }
    
    public static function Listadohorasextrasexcell($IdDepartamento, $IdEmpresa, $FechaInicio, $FechaFin)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
        $InicioHoraDiurna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->inicio_hora_diurna;
        $FinHoraDiurna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->fin_hora_diurna;

        $InicioHoraNocturna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->inicio_hora_nocturna;
        $FinHoraNocturna = Gsta_AsistenciasValidacionModel::HorarioJornadaLey()->fin_hora_nocturna;
      
        // Construir la consulta base
        $query = "
            DECLARE @fechas nvarchar(max);
            DECLARE @sql nvarchar(max);
    
            SELECT @fechas = ISNULL(@fechas + ',', '')  
                + QUOTENAME(asistencias) 
            FROM (
                SELECT DISTINCT  
                    va.fecha_validacion as asistencias
                FROM gsta_validaciones_asistencias as va
                WHERE va.fecha_validacion BETWEEN '$FechaInicio' AND '$FechaFin'
            ) AS asistencias;
    
            SET @sql = N' 
            SELECT * FROM (
                SELECT
                    va.id_empleado,
                    va.id_biometrico,  
                    va.nombre_empleado,
                    va.nombre_empresa,
                    va.fecha_validacion,
                    d.des_depart,
                    CONCAT(
                        CASE 
                    WHEN va.hora_entrada = ''00:00:00.0000000'' THEN ''00:00:00''
                    ELSE CONVERT(VARCHAR, va.hora_entrada, 22)
                    
                END,
                '' - '',
                CASE 
                    WHEN va.hora_salida = ''00:00:00.0000000'' THEN ''00:00:00''
                    ELSE CONVERT(VARCHAR, va.hora_salida, 22)
                    
                END,
                '' - '',
                 va.observacion,
                    
                CASE 
                    WHEN (DATEDIFF(SECOND, va.hora_entrada, va.hora_salida) / 3600.0)  > 9 THEN
                    CONCAT(
                       '' - '', 
                      
                                    CASE
                                        WHEN va.hora_salida > h.fin_jornada AND va.hora_entrada < h.inicio_jornada  THEN
                                            CONVERT(VARCHAR(8), 
                                            DATEADD(SECOND, 
                                                DATEDIFF(SECOND, h.fin_jornada, 
                                                    CASE WHEN va.hora_salida <= ''$FinHoraDiurna'' THEN va.hora_salida ELSE ''$FinHoraDiurna'' END
                                                ) + 
                                                DATEDIFF(SECOND, 
                                                    CASE WHEN va.hora_entrada >= ''$InicioHoraDiurna'' THEN va.hora_entrada ELSE ''$InicioHoraDiurna'' END, 
                                                    h.inicio_jornada
                                                ), 
                                            0), 108)

										 WHEN va.hora_salida > h.fin_jornada AND va.hora_entrada < h.inicio_jornada  AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108) != h.fin_jornada  THEN
                                            CONVERT(VARCHAR(8), 
                                            DATEADD(SECOND, 
                                                DATEDIFF(SECOND,CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108), 
                                                    CASE WHEN va.hora_salida <= ''$FinHoraDiurna'' THEN va.hora_salida ELSE ''$FinHoraDiurna'' END
                                                ) , 
                                            0), 108)

                                        WHEN va.hora_salida > h.fin_jornada and va.hora_entrada=h.inicio_jornada  THEN
                                            CASE
                                                WHEN va.hora_salida <= ''$FinHoraDiurna'' THEN
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, h.fin_jornada, va.hora_salida), 
                                                            0), 108)
                                                ELSE
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, h.fin_jornada, ''$FinHoraDiurna''), 
                                                            0), 108)
                                            END

                                        WHEN va.hora_entrada < h.inicio_jornada  THEN
                                            CASE
                                                WHEN va.hora_entrada >= ''$InicioHoraDiurna'' THEN
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, va.hora_entrada, h.inicio_jornada), 
                                                            0), 108)
                                                WHEN va.hora_entrada < ''$InicioHoraDiurna'' AND va.hora_salida <= ''$InicioHoraDiurna'' THEN
                                                    CONVERT(VARCHAR(8), 
                                                    DATEADD(SECOND, 
                                                        DATEDIFF(SECOND, 1, 1), 
                                                        0), 108)
                                                 WHEN va.hora_entrada < ''$InicioHoraDiurna'' AND va.hora_salida < h.fin_jornada THEN
                                                    CONVERT(VARCHAR(8), 
                                                    DATEADD(SECOND, 
                                                        DATEDIFF(SECOND,CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108),va.hora_salida), 
                                                        0), 108)
												ELSE
                                                    CONVERT(VARCHAR(8), 
                                                        DATEADD(SECOND, 
                                                            DATEDIFF(SECOND, ''$InicioHoraDiurna'', h.inicio_jornada), 
                                                            0), 108)
                                            END
                                    ELSE
                                        ''00:00:00''
                        END,
                        '' - '', 
                        
                        CASE
                            -- Si la hora en que se cumplen las 9 horas es después de las 19:00
                            WHEN va.hora_salida > ''$InicioHoraNocturna'' AND va.hora_entrada < ''$FinHoraNocturna'' THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, ''$InicioHoraNocturna'', va.hora_salida) + 
                                        DATEDIFF(SECOND, va.hora_entrada, ''$FinHoraNocturna''), 
                                        0), 108)

							WHEN va.hora_salida > ''$InicioHoraNocturna'' AND va.hora_entrada < ''$FinHoraNocturna'' AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108) != h.fin_jornada  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108), va.hora_salida) + 
                                        DATEDIFF(SECOND, va.hora_entrada, ''$FinHoraNocturna''), 
                                        0), 108)

                            WHEN va.hora_salida > ''$InicioHoraNocturna'' AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108) != h.fin_jornada AND va.hora_entrada > h.inicio_jornada THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108), va.hora_salida), 
                                        0), 108)
							  WHEN va.hora_salida > ''$InicioHoraNocturna''  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, ''$InicioHoraNocturna'', va.hora_salida), 
                                        0), 108)
                            WHEN va.hora_entrada < ''$FinHoraNocturna'' AND va.hora_salida <= ''$FinHoraNocturna''  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, va.hora_entrada, va.hora_salida), 
                                        0), 108)
                            WHEN va.hora_entrada < ''$FinHoraNocturna''  AND CONVERT(VARCHAR(8), DATEADD(SECOND, 9 * 3600, va.hora_entrada), 108) = h.fin_jornada  THEN
                                CONVERT(VARCHAR(8), 
                                    DATEADD(SECOND, 
                                        DATEDIFF(SECOND, va.hora_entrada, ''$FinHoraNocturna''), 
                                        0), 108)
							
                            ELSE
                                ''00:00:00''
                        END
                    )
                ELSE
                    CONCAT(
                        '' - '',
                        ''00:00:00'',
                        '' - '', 
                        ''00:00:00''
                    )
            END
                    ) AS horas
                FROM gsta_validaciones_asistencias va
                    INNER JOIN gsta_horario_empleados he ON he.id_biometrico = va.id_biometrico
                    INNER JOIN gsta_horarios h ON h.id_horario = he.id_horario
                    INNER JOIN N_ACERO.dbo.sndepart d ON d.co_depart = va.id_departamento
                WHERE va.fecha_validacion BETWEEN ''$FechaInicio'' AND ''$FechaFin''";
        
        // Aplicar filtros opcionales
        if ($IdDepartamento !== 'TODOS') {
            $query .= " AND va.id_departamento = $IdDepartamento";
        }
        if ($IdEmpresa !== 'TODAS') {
            $query .= " AND va.id_empresa = ''$IdEmpresa''";
        }
    
        $query .= "
            GROUP BY 
                va.id_empleado,
                va.id_biometrico,
                va.nombre_empleado,
                va.nombre_empresa,
                va.id_departamento,
                va.fecha_validacion,
                va.hora_entrada,
                va.hora_salida,
                h.inicio_jornada,
                h.fin_jornada,
                h.inicio_descanso,
                h.fin_descanso,
                va.observacion,
                d.des_depart
            ) AS asistencias
            PIVOT(
                MAX(horas) FOR fecha_validacion IN (' + @fechas + ')
            ) AS pvt
            ORDER BY pvt.des_depart';
        
        EXEC sp_executesql @sql;";
        
        $result = DB::select($query);
    
        // Extraer fechas
        $fechas = DB::select("
            SELECT DISTINCT va.fecha_validacion as asistencias
            FROM gsta_validaciones_asistencias as va
            WHERE va.fecha_validacion BETWEEN '$FechaInicio' AND '$FechaFin'
            ORDER BY va.fecha_validacion");
    
        return [
            'result' => $result,
            'fechas' => array_map(function($f) {
                return $f->asistencias;
            }, $fechas)
        ];
    }

    public static function ListadoAsistencia($IdDepartamento,$IdEmpresa,$Fecha)
    {
        return  DB::connection('BIOMETRICO')
            ->select('EXEC SP_Registros_Empleados ?, ?, ?', array($Fecha, $IdDepartamento, $IdEmpresa));
    }

    
    public static function ListadoAsistenciaPersona($IdEmpleado,$FechaInicio)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('d-m-Y');
    
        return DB::connection('BIOMETRICO')
        ->table('View_Registros_Empleados')
        ->select(
            
            'cod_biometrico',
            'nombres',
            'apellidos',
            'fecha',
            'hora',
            'evento',
            'estado_asistencia'
        )
        ->where('cod_biometrico', '=', $IdEmpleado)
        ->where('fecha', '=', $FechaInicio)
        ->orderBy('hora', 'asc')
        ->get();
    }

    public static function DepartamentosNomina()
    {
        return DB::connection('profit')
                ->table('N_ACERO.dbo.sndepart')
                ->select(
                    'co_depart as id_departamento',
                    'des_depart as nombre_departamento'
                )
                ->get(); 
    }
   
    
    public static function EmpresasNomina()
    {
        return DB::connection('BIOMETRICO')
        ->table('View_Registros_Empleados')
        ->select(
        'cod_empresa as id_empresa',
        'empresa as nombre_empresa',
        )
        ->distinct()
        ->get();
    }

    
    public static function HorarioJornadaLey()
    {
        return DB::connection('profit')
            ->table('N_ACERO.dbo.par_emp')
            ->select(
                DB::raw('convert(time, lot_jornada_diurna_d ) as inicio_hora_diurna'),
                DB::raw('convert(time, lot_jornada_diurna_h ) as fin_hora_diurna'),
                DB::raw('convert(time, lot_jornada_nocturna_d ) as   inicio_hora_nocturna'),
                DB::raw('convert(time, lot_jornada_nocturna_h ) as fin_hora_nocturna')
            )
            ->first();
    }

    public static function BuscarDepartamentos($IdDepartamento)
    {
            $registros = DB::connection('profit')
            ->table('N_ACERO.dbo.sndepart')
            ->select(
                'des_depart as nombre_departamento'
            );
        
            if ($IdDepartamento !== 'TODOS') 
            {
                $nombreDepartamento = $registros->where('co_depart', '=', $IdDepartamento)->value('nombre_departamento');
                $resultados = $nombreDepartamento ;
            } 
            else 
                {
                    $resultados = 'TODOS';
                }
            
            return $resultados;
    }

    public static function HorarioEmpleado($id_empleado){

        $registros = DB:: table('gsta_horario_empleados AS e')
        ->join('gsta_horarios as h', 'e.id_horario', '=', 'h.id_horario')
        ->select(
            'e.id_empleado',
            'e.id_biometrico',
            'e.id_horario',
            'h.nombre_horario',
            'h.inicio_jornada',
            'h.fin_jornada',
            'h.inicio_descanso',
            'h.fin_descanso',
        )

        ->where('e.id_biometrico', '=',$id_empleado)
        ->first();


    return $registros;

    }

 public static function AusenciasDepartamento($FechaInicio,$FechaFin){
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
        
        $registros = DB::table('gsta_validaciones_asistencias as a')
            ->join('gsta_validacion_novedades as vn', 'a.id_validacion', '=', 'vn.id_validacion')
            ->join('gsta_novedades as n', 'vn.id_novedad', '=', 'n.id_novedad')
            ->join('N_ACERO.dbo.sndepart as d', 'a.id_departamento', '=', 'd.co_depart')
            ->select(
                'a.id_departamento',
                'd.des_depart',
                DB::raw('COUNT(a.id_validacion) as cantidad')
            )
            ->where('n.descripcion', '=', 'AUSENCIA')
            ->whereBetween(DB::raw("CONVERT(date, a.fecha_validacion)"), [$FechaInicio, $FechaFin])
            ->groupBy(
                'a.id_departamento',
                'd.des_depart'
            );
        
        return $registros->get();

    }
    public static function TardeDepartamento($FechaInicio,$FechaFin){
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
        
        $registros = DB::table('gsta_validaciones_asistencias as a')
            ->join('gsta_validacion_novedades as vn', 'a.id_validacion', '=', 'vn.id_validacion')
            ->join('gsta_novedades as n', 'vn.id_novedad', '=', 'n.id_novedad')
            ->join('N_ACERO.dbo.sndepart as d', 'a.id_departamento', '=', 'd.co_depart')
            ->select(
                'a.id_departamento',
                'd.des_depart',
                DB::raw('COUNT(a.id_validacion) as cantidad')
            )
            ->where('n.descripcion', '=', 'HORAS DIURNAS NO LABORADAS')
            ->whereBetween(DB::raw("CONVERT(date, a.fecha_validacion)"), [$FechaInicio, $FechaFin])
            ->groupBy(
                'a.id_departamento',
                'd.des_depart'
            );
        
        return $registros->get();

    }

    public static function AusenciasEmpleado($FechaInicio,$FechaFin,$IdDepartamento){
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
        
        $registros = DB::table('gsta_validaciones_asistencias as a')
            ->join('gsta_validacion_novedades as vn', 'a.id_validacion', '=', 'vn.id_validacion')
            ->join('gsta_novedades as n', 'vn.id_novedad', '=', 'n.id_novedad')
            ->join('N_ACERO.dbo.sndepart as d', 'a.id_departamento', '=', 'd.co_depart')
            ->select(
                'a.nombre_empleado',
                'd.des_depart',
                'n.descripcion',
                DB::raw('COUNT(a.id_validacion) as cantidad')
            )
            ->where('n.descripcion', '=', 'AUSENCIA')
            ->where('a.id_departamento','=',$IdDepartamento)
            ->whereBetween(DB::raw("CONVERT(date, a.fecha_validacion)"), [$FechaInicio, $FechaFin])
            ->groupBy(
                'a.nombre_empleado',
                'd.des_depart',
                'n.descripcion'
            );
        
        return $registros->get();

    }
    public static function RetardosEmpleado($FechaInicio,$FechaFin,$IdDepartamento){
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
        
        $registros = DB::table('gsta_validaciones_asistencias as a')
            ->join('gsta_validacion_novedades as vn', 'a.id_validacion', '=', 'vn.id_validacion')
            ->join('gsta_novedades as n', 'vn.id_novedad', '=', 'n.id_novedad')
            ->join('N_ACERO.dbo.sndepart as d', 'a.id_departamento', '=', 'd.co_depart')
            ->select(
                'a.nombre_empleado',
                'd.des_depart',
                'n.descripcion',
                DB::raw('COUNT(a.id_validacion) as cantidad')
            )
            ->where('n.descripcion', '=', 'HORAS DIURNAS NO LABORADAS')
            ->where('a.id_departamento','=',$IdDepartamento)
            ->whereBetween(DB::raw("CONVERT(date, a.fecha_validacion)"), [$FechaInicio, $FechaFin])
            ->groupBy(
                'a.nombre_empleado',
                'd.des_depart',
                'n.descripcion'
            );
        
        return $registros->get();

    }

    public static function Empleados(){
        
        $registros = DB::connection('BIOMETRICO')
            ->table('View_Registros_Empleados AS ve')
            ->join('N_ACERO.dbo.sndepart as d', 've.co_depart', '=', 'd.co_depart')
            ->select(
                'd.des_depart',
               db::raw(' COUNT(DISTINCT ve.cod_biometrico) as cantidad')
            )
                ->groupBy('d.des_depart');
        
        return $registros->get();

    }



}
