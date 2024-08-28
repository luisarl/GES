<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class Cntc_Solicitudes_IngresoModel extends Model
{
    use HasFactory;
    protected $dateFormat = 'Y-d-m H:i';   //funcion para formateo de la fecha
    protected $table = 'cntc_solicitudes_ingreso';
    protected $primaryKey = 'id_solicitud_ingreso';

    protected $fillable = [
        'id_solicitud_ingreso',
        'id_combustible',
        'id_tipo_ingreso',
        'id_departamento',
        'cantidad',
        'stock_anterior',
        'observacion',
        'creado_por',
        'fecha_creacion',
    ];



    public static function SolicitudIngreso()
    {

        $registros = DB::table('cntc_solicitudes_ingreso as i')
    
            ->join('cntc_tipo_combustible as t','i.id_combustible','=','t.id_tipo_combustible')
            ->join('cntc_tipo_ingresos as ti','i.id_tipo_ingreso','=','ti.id_tipo_ingresos')
            ->select(
                'i.id_solicitud_ingreso',
                'i.fecha_creacion',
                'i.creado_por',
                't.descripcion_combustible',
                't.id_tipo_combustible',
                'ti.descripcion_ingresos',
                'i.cantidad',
                'id_tipo_ingreso',

            );
        return $registros->get();
        
    }

    public static function SolicitudIngresodetalle($IdSolicitudIngreso)
    {

        $registros = DB::table('cntc_solicitudes_ingreso as i')

            ->join('departamentos as d','i.id_departamento','=','d.id_departamento')
            ->join('cntc_tipo_combustible as t','i.id_combustible','=','t.id_tipo_combustible')
            ->join('cntc_tipo_ingresos as ti','i.id_tipo_ingreso','=','ti.id_tipo_ingresos')
            ->select(
                'd.nombre_departamento',
                'i.id_solicitud_ingreso',
                'i.fecha_creacion',
                'i.creado_por',
                't.descripcion_combustible',
                't.id_tipo_combustible',
                'i.observacion',
                'ti.descripcion_ingresos',
                'i.cantidad',
                'i.stock_anterior',
           

            );
        return $registros->where('i.id_solicitud_ingreso','=',$IdSolicitudIngreso)->first();
        
    }

    public static function SolicitudIngresos($FechaInicio, $FechaFin, $IdCombustible)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
    
        return DB::table('cntc_solicitudes_ingreso as si')
            ->join('departamentos as d', 'si.id_departamento', '=', 'd.id_departamento')
            ->join('cntc_tipo_combustible as tc', 'si.id_combustible', '=', 'tc.id_tipo_combustible')
            ->join('cntc_tipo_ingresos as ti', 'si.id_tipo_ingreso', '=', 'ti.id_tipo_ingresos')
            ->select(
                'si.id_solicitud_ingreso',
                'si.fecha_creacion',
                'si.creado_por',
                'tc.descripcion_combustible',
                'tc.id_tipo_combustible',
                'ti.descripcion_ingresos',
                'si.cantidad',
                'si.id_tipo_ingreso',
                'd.nombre_departamento',
                'si.stock_anterior',
                DB::raw('(si.cantidad + si.stock_anterior) AS stock_final')
            )
            ->whereBetween(DB::raw("CONVERT(date, si.fecha_creacion)"), [$FechaInicio, $FechaFin])
            ->where('tc.id_tipo_combustible', '=', $IdCombustible)
            ->get();
    }

    public static function CantidadIngresada($IdCombustible, $FechaInicio, $FechaFin)
    {
            $registros = DB::table('cntc_solicitudes_ingreso as s')
                    ->join('departamentos as de', 's.id_departamento', '=', 'de.id_departamento')
                    ->join('cntc_tipo_combustible as t', 's.id_combustible', '=', 't.id_tipo_combustible')
                    ->select(
                        'de.nombre_departamento',
                        DB::raw('SUM(s.cantidad) as cantidad')
                    )
                    ->whereBetween(DB::raw("CONVERT(date, s.fecha_creacion)"), [$FechaInicio, $FechaFin])
                    ->where('t.id_tipo_combustible', '=', $IdCombustible)
                    ->groupBy('de.nombre_departamento')
                    ->get();
                
            return $registros;
    }

    public static function reporteanual($IdCombustible,$Año)
    {
    return DB::select("
                        SELECT 
                            nombre_departamento,
                            ISNULL([1], 0) AS ENERO,
                            ISNULL([2], 0) AS FEBRERO,
                            ISNULL([3], 0) AS MARZO,
                            ISNULL([4], 0) AS ABRIL,
                            ISNULL([5], 0) AS MAYO,
                            ISNULL([6], 0) AS JUNIO,
                            ISNULL([7], 0) AS JULIO,
                            ISNULL([8], 0) AS AGOSTO,
                            ISNULL([9], 0) AS SEPTIEMBRE,
                            ISNULL([10], 0) AS OCTUBRE,
                            ISNULL([11], 0) AS NOVIEMBRE,
                            ISNULL([12], 0) AS DICIEMBRE
                        
                        FROM 
                        (
                            SELECT 
                                d.nombre_departamento,
                                MONTH(sd.fecha_creacion) AS mes,
                                SUM(sd.cantidad) as cantidad
                            FROM 
                               cntc_solicitudes_ingreso as sd
                            INNER JOIN departamentos as d ON d.id_departamento = sd.id_departamento
                            inner join cntc_tipo_combustible as tc on tc.id_tipo_combustible =sd.id_combustible
                            where sd.id_combustible='$IdCombustible' and    YEAR(sd.fecha_creacion) = '$Año'  -- Cambia el año a filtrar

                            GROUP BY 
                                d.nombre_departamento,
                                MONTH(sd.fecha_creacion)
                        ) AS SourceTable
                        PIVOT
                        (
                            SUM(cantidad)
                            FOR mes IN ([1], [2], [3], [4], [5], [6], [7], [8], [9], [10], [11], [12])
                        ) AS PivotTable");
    }
}
