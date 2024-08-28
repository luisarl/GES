<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Cntc_Solicitudes_DespachoModel extends Model
{
    use HasFactory;
    protected $dateFormat = 'Y-d-m H:i';   //funcion para formateo de la fecha
    protected $table = 'cntc_solicitudes_despacho';
    protected $primaryKey = 'id_solicitud_despacho';

    protected $fillable = [
        'id_solicitud_despacho',
        'id_combustible',
        'id_departamento',
        'motivo',
        'creado_por',
        'fecha_creacion',
        'estatus',
        'total',
        'total_despachado',
        'stock_final',
        'aceptado_por',
        'fecha_aceptado',
        'aprobado_por',
        'fecha_aprobacion',
        'anulado_por',
        'fecha_anulacion',
        'id_departamento_servicio',
    ];

    public static function Solicitudes()
    {

        $registros = DB::table('cntc_solicitudes_despacho as d')
          
            ->join('departamentos as de','d.id_departamento','=','de.id_departamento')
            ->join('cntc_tipo_combustible as t','d.id_combustible','=','t.id_tipo_combustible')

            ->select(
                'd.id_solicitud_despacho',
                'd.motivo',
                'd.estatus',
                'd.fecha_creacion',
                'd.fecha_aceptado',
                'd.fecha_aprobacion',
                'd.aprobado_por',
                'd.aceptado_por',
                'd.creado_por',
                'd.total',
                'de.nombre_departamento',
                'd.id_departamento',
                't.descripcion_combustible',
                't.id_tipo_combustible',
                'd.id_departamento_servicio'

            );
        return $registros->get();
        
    }



    public static function Solicitud($IdDespacho)
    {
       

        $registros = DB::table('cntc_solicitudes_despacho as d')
            ->join('departamentos as de','d.id_departamento','=','de.id_departamento')
            ->join('cntc_tipo_combustible as t','d.id_combustible','=','t.id_tipo_combustible')


            ->select(
                'd.id_solicitud_despacho',
                'd.motivo',
                'd.estatus',
                'd.fecha_creacion',
                'd.fecha_aprobacion',
                'd.fecha_aceptado',
                'd.aceptado_por',
                'd.aprobado_por',
                'd.total',
                'd.total_despachado',
                'd.creado_por',
                'de.nombre_departamento',
                'd.id_departamento',
                't.descripcion_combustible',
                't.id_tipo_combustible',
            );
     
        return $registros->where('d.id_solicitud_despacho', '=',$IdDespacho)->first();
        
    }

    public static function ReporteDespachosVehiculos($FechaInicio, $FechaFin, $IdCombustible, $Vehiculos, $Departamentos)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
    
        // Consulta principal
        $query = DB::table('cntc_solicitudes_despacho as sd')
            ->join('cntc_tipo_combustible as tc', 'sd.id_combustible', '=', 'tc.id_tipo_combustible')
            ->join('departamentos as d', 'd.id_departamento', '=', 'sd.id_departamento')
            ->join('cntc_solicitudes_despacho_detalle as dd', 'dd.id_solicitud_despacho', '=', 'sd.id_solicitud_despacho')
            ->select(
                'sd.id_solicitud_despacho',
                'sd.fecha_aprobacion',
                'd.nombre_departamento',
                'dd.placa_equipo',
                'dd.marca_equipo',
                'dd.fecha_despacho',
                'dd.stock_combustible',
                'dd.cantidad_despachada',
                DB::raw('(dd.stock_combustible + dd.cantidad_despachada) as stock_anterior')
            )
            ->whereBetween(DB::raw("CONVERT(date, dd.fecha_despacho)"), [$FechaInicio, $FechaFin])
            ->where('tc.id_tipo_combustible', '=', $IdCombustible)
            ->where('sd.estatus', '=', 'PROCESADO')
            ->orderBy('dd.fecha_despacho', 'asc')   
            ->orderBy('sd.id_solicitud_despacho', 'asc');    
        // Aplicar el filtro de placa_equipo si $Vehiculos no es 'TODOS' y no está vacío
        if (!empty($Vehiculos) && $Vehiculos !== 'TODOS' && $Vehiculos !== 'EQUIPOS'  ) {
            $query->whereIn('dd.placa_equipo', $Vehiculos);
        }
    
        // Aplicar el filtro si $Vehiculos es 'EQUIPOS'
        if ($Vehiculos === 'EQUIPOS' ) {
            $query->where('dd.placa_equipo', '=', 'NO APLICA');
        }
    
       

        return $query->get();
    }
    
    public static function ReporteDespachosDepartamentos($FechaInicio, $FechaFin, $IdCombustible, $Vehiculos, $Departamentos)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
    
        // Consulta principal
        $query = DB::table('cntc_solicitudes_despacho as sd')
            ->join('cntc_tipo_combustible as tc', 'sd.id_combustible', '=', 'tc.id_tipo_combustible')
            ->join('departamentos as d', 'd.id_departamento', '=', 'sd.id_departamento')
            ->join('cntc_solicitudes_despacho_detalle as dd', 'dd.id_solicitud_despacho', '=', 'sd.id_solicitud_despacho')
            ->select(
                'sd.id_solicitud_despacho',
                'sd.fecha_aprobacion',
                'd.nombre_departamento',
                'dd.placa_equipo',
                'dd.marca_equipo',
                'dd.fecha_despacho',
                'dd.stock_combustible',
                'dd.cantidad_despachada',
                DB::raw('(dd.stock_combustible + dd.cantidad_despachada) as stock_anterior')
            )
            ->whereBetween(DB::raw("CONVERT(date, dd.fecha_despacho)"), [$FechaInicio, $FechaFin])
            ->where('tc.id_tipo_combustible', '=', $IdCombustible)
            ->where('sd.estatus', '=', 'PROCESADO')  
            ->orderBy('dd.fecha_despacho', 'asc')   
            ->orderBy('sd.id_solicitud_despacho', 'asc');
    
      
        // Aplicar el filtro por departamento si $Departamentos no es 'TODOS' y $Vehiculos está vacío
        if ($Departamentos != 'TODOS' ) {
            $query->where('d.id_departamento', '=', $Departamentos);
        }

        return $query->get();
    }
    

    public static function CantidadDespachada($IdCombustible, $FechaInicio, $FechaFin,$Departamentos)
    {
            $registros = DB::table('cntc_solicitudes_despacho as d')
                    ->join('departamentos as de', 'd.id_departamento', '=', 'de.id_departamento')
                    ->join('cntc_solicitudes_despacho_detalle as dd', 'd.id_solicitud_despacho', '=', 'dd.id_solicitud_despacho')
                    ->select(
                        'de.nombre_departamento',
                        DB::raw('SUM(dd.cantidad_despachada) as cantidad')
                    )
                    ->whereBetween(DB::raw("CONVERT(date, dd.fecha_despacho)"), [$FechaInicio, $FechaFin])
                    ->where('d.id_combustible', '=', $IdCombustible)
                    ->where('d.estatus', '=', 'PROCESADO')
                    ->groupBy('de.nombre_departamento');

                    if ($Departamentos != 'TODOS' ) {
                        $registros->where('d.id_departamento', '=', $Departamentos);
                    }
                
                
            return $registros->get();
    }

    public static function CantidadDespachadaVehiculos($IdCombustible, $FechaInicio, $FechaFin,$Vehiculos)
    {
            $registros = DB::table('cntc_solicitudes_despacho as d')
                    ->join('departamentos as de', 'd.id_departamento', '=', 'de.id_departamento')
                    ->join('cntc_solicitudes_despacho_detalle as dd', 'd.id_solicitud_despacho', '=', 'dd.id_solicitud_despacho')
                   
                    ->select(
                        'dd.placa_equipo',
                        'dd.marca_equipo',
                        DB::raw('SUM(dd.cantidad_despachada) as cantidad')
                    )
                    ->whereBetween(DB::raw("CONVERT(date, dd.fecha_despacho)"), [$FechaInicio, $FechaFin])
                    ->where('d.id_combustible', '=', $IdCombustible)
                    ->where('d.estatus', '=', 'PROCESADO')
                    ->groupBy(

                        'dd.placa_equipo',
                        'dd.marca_equipo');

                    // Aplicar el filtro de placa_equipo si $Vehiculos no es 'TODOS' y no está vacío
                    if (!empty($Vehiculos) && $Vehiculos !== 'TODOS' && $Vehiculos !== 'EQUIPOS'  ) {
                        $registros->whereIn('dd.placa_equipo', $Vehiculos);
                    }
                
                    // Aplicar el filtro si $Vehiculos es 'EQUIPOS'
                    if ($Vehiculos === 'EQUIPOS' ) {
                        $registros->where('dd.placa_equipo', '=', 'NO APLICA');
                    }
                       
                
                
            return $registros->get();
    }


    public static function ReporteAnual($IdCombustible,$Año)
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
                            MONTH(dd.fecha_despacho) AS mes,
                            SUM(dd.cantidad_despachada) as cantidad
                        FROM 
                           cntc_solicitudes_despacho as sd
                        INNER JOIN departamentos as d ON d.id_departamento = sd.id_departamento
                        inner join cntc_tipo_combustible as tc on tc.id_tipo_combustible =sd.id_combustible
						inner join cntc_solicitudes_despacho_detalle as dd on dd.id_solicitud_despacho= sd.id_solicitud_despacho
                        where sd.id_combustible='$IdCombustible'
                        and Year(dd.fecha_despacho)='$Año'
						and sd.estatus='PROCESADO'
                        GROUP BY 
                            d.nombre_departamento,
                            MONTH(dd.fecha_despacho)
                    ) AS SourceTable
                    PIVOT
                    (
                        SUM(cantidad)
                        FOR mes IN ([1], [2], [3], [4], [5], [6], [7], [8], [9], [10], [11], [12])
                    ) AS PivotTable");
    }

  

  
    public static function ReporteAnualEquipos($IdCombustible,$Año)
    {
             return DB::select("
                        SELECT 
                        marca_equipo,
                        placa_equipo,
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
                            sdd.placa_equipo,
                            sdd.marca_equipo,
                            MONTH(sdd.fecha_despacho) AS mes,
                            SUM(sdd.cantidad_despachada) as cantidad
                        FROM 
                            cntc_solicitudes_despacho as sd
                        INNER JOIN departamentos as d ON d.id_departamento = sd.id_departamento
                        INNER JOIN cntc_tipo_combustible as tc ON tc.id_tipo_combustible = sd.id_combustible
                        INNER JOIN cntc_solicitudes_despacho_detalle as sdd ON sdd.id_solicitud_despacho = sd.id_solicitud_despacho
                        WHERE 
                            sd.id_combustible = '$IdCombustible' AND 
                            YEAR(sd.fecha_aprobacion) = '$Año'  -- Cambia el año a filtrar
							and sd.estatus='PROCESADO'
                        GROUP BY 
                            sdd.placa_equipo,
                            sdd.marca_equipo,
                            MONTH(sdd.fecha_despacho)
                    ) AS SourceTable
                    PIVOT
                    (
                        SUM(cantidad)
                        FOR mes IN ([1], [2], [3], [4], [5], [6], [7], [8], [9], [10], [11], [12])
                    ) AS P");
    }

}