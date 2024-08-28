<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Cntt_Reemplazo_TonerModel extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-d-m H:i';   //funcion para formateo de la fecha
    protected $table = 'cntt_reemplazo_toner';
    protected $primaryKey = 'id_reemplazo_toner';

    protected $fillable = [
        'id_reemplazo_toner',
        'fecha_cambio',
        'fecha_cambio_anterior',
        'id_impresora',
        'id_departamento',
        'observacion',
        'tipo_servicio',
        'cantidad_hojas_actual',
        'cantidad_hojas_anterior',
        'cantidad_hojas_total',
        'dias_de_duracion',
        'creado_por',
    ];
 
    
    public static function ListadoReemplazos()
    {
        return DB::table('cntt_reemplazo_toner as rt')
                ->join('departamentos as d', 'd.id_departamento', '=', 'rt.id_departamento')
                ->join('actv_activos as a', 'a.id_activo', '=', 'rt.id_impresora')
                ->select(
                    'rt.id_reemplazo_toner',
                    'rt.fecha_cambio',
                    'rt.tipo_servicio',
                    'd.nombre_departamento',
                    'a.nombre_activo',
                    'a.ubicacion'
                )
                ->get(); 
    }

    public static function Reemplazos($IdReemplazo)
    {
        return DB::table('cntt_reemplazo_toner as rt')
                ->join('departamentos as d', 'rt.id_departamento', '=', 'd.id_departamento')
                ->join('actv_activos as a', 'rt.id_impresora', '=', 'a.id_activo')
                ->select(
                    'rt.id_reemplazo_toner',
                    'rt.fecha_cambio',
                    'rt.tipo_servicio',
                    'd.nombre_departamento',
                    'a.nombre_activo',
                    'a.ubicacion',
                    'rt.observacion',
                    'rt.fecha_cambio_anterior',
                    'rt.fecha_cambio_anterior',
                    'rt.cantidad_hojas_actual',
                    'rt.cantidad_hojas_anterior',
                    'rt.cantidad_hojas_total',
                    'rt.dias_de_duracion',
                    'rt.creado_por',
                    
                )
                ->where('rt.id_reemplazo_toner','=',$IdReemplazo)
                ->first(); 
    }

    public static function ultimoservicio($IdDepartamento, $IdImpresora)
    {
        return DB::table('cntt_reemplazo_toner')
                ->select(
                    'cantidad_hojas_actual',
                    'fecha_cambio'
                )
                ->where('id_departamento', '=', $IdDepartamento)
                ->where('id_impresora', '=', $IdImpresora)
                ->orderBy('fecha_cambio', 'desc') // Ordenar por fecha de cambio en orden descendente
                ->first(); // Obtener solo el último registro
    }

    public static function Reporte($IdDepartamento, $FechaInicio, $FechaFin)
    {
        // Convertir fechas a formato 'Y-m-d'
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
    
        // Construir la consulta
        $reporte = DB::table('cntt_reemplazo_toner as rt')
        ->join('departamentos as d','rt.id_departamento','=','d.id_departamento')
        ->join('actv_activos as a','rt.id_impresora','=','a.id_activo')
            ->select(
                'rt.id_reemplazo_toner',
                'rt.fecha_cambio',
                'rt.fecha_cambio_anterior',
                'd.nombre_departamento',
                'a.nombre_activo',
                'a.ubicacion',
                'rt.observacion',
                'rt.tipo_servicio',
                'rt.cantidad_hojas_actual',
                'rt.cantidad_hojas_anterior',
                'rt.cantidad_hojas_total',
                'rt.dias_de_duracion',
            );
    
      
        if ($IdDepartamento !== 'TODOS') {
            $reporte->where('rt.id_departamento', '=', $IdDepartamento);
        }
    
        $reporte->whereBetween(DB::raw("CONVERT(date, rt.fecha_cambio)"), [$FechaInicio, $FechaFin]);
    
        // Obtener los resultados
        return $reporte->get();
    }

    public static function PromedioHojas($IdDepartamento, $FechaInicio, $FechaFin)
    {
        // Convertir fechas a formato 'Y-m-d'
        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
    
        // Construir la consulta
        $reporte = DB::table('cntt_reemplazo_toner as rt')
        ->join('departamentos as d','rt.id_departamento','=','d.id_departamento')
        ->join('actv_activos as a','rt.id_impresora','=','a.id_activo')
            ->select(
                
                'd.nombre_departamento',
                DB::raw('count (rt.id_reemplazo_toner)as cantidad'),
                DB::raw('(SUM(rt.cantidad_hojas_total)/count (rt.id_reemplazo_toner))as promedio'),
                DB::raw('(SUM(rt.dias_de_duracion)/count (rt.id_reemplazo_toner))as diaspromedio')
            );
    
      
        if ($IdDepartamento !== 'TODOS') {
            $reporte->where('rt.id_departamento', '=', $IdDepartamento);
        }
    
        $reporte->whereBetween(DB::raw("CONVERT(date, rt.fecha_cambio)"), [$FechaInicio, $FechaFin])
        ->groupby( 'd.nombre_departamento');
    
        // Obtener los resultados
        return $reporte->get();
    }
}
