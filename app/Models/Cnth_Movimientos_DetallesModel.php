<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cnth_Movimientos_DetallesModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_movimientos_detalles';
    protected $primaryKey = 'id_detalle';

    protected $fillable = [
      
        'id_detalle',
        'id_movimiento',
        'id_herramienta',
        'id_empleado',
        'responsable',
        'fecha_despacho',
        'cantidad_entregada',
        'fecha_devolucion',
        'cantidad_devuelta',
        'aprobacion',
        'estatus',
        'eventualidad',
        'recibido_por'
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcion para formateo de la fecha
    
    public static function recepcion_detalle($IdMovimiento)
    {
        return DB::table('cnth_movimientos_detalles as d')
            ->join('cnth_herramientas as h', 'd.id_herramienta', '=', 'h.id_herramienta')
            //->join('cnth_empleados as e', 'd.id_empleado', '=', 'e.id_empleado')
            ->select(
                'd.id_detalle',
                'd.id_movimiento',
                'd.id_herramienta',
                'h.nombre_herramienta',
                'd.recibido_por',
                DB::raw("CONVERT(VARCHAR(10), d.fecha_despacho, 103) + ' - ' + RIGHT(CONVERT(VARCHAR, d.fecha_despacho, 100), 7) as fecha_despacho"),
                'd.cantidad_entregada',
                'd.cantidad_devuelta',
                'd.responsable',
                DB::raw("CONVERT(VARCHAR(10), d.fecha_devolucion, 103) + ' - ' + RIGHT(CONVERT(VARCHAR, d.fecha_devolucion, 100), 7) as fecha_devolucion"),
                'd.aprobacion',
                'd.estatus',
                'd.eventualidad',
                'd.created_at'
            )
            ->where('d.id_movimiento', '=', $IdMovimiento)
            //->where('d.estatus', '=', NULL)
            ->orderBy('d.id_herramienta', 'DESC')
            ->orderBy('d.cantidad_entregada', 'DESC')
            ->get();
    }

    public static function HerramientasDespacho($IdMovimiento)
    {
        return DB::table('cnth_movimientos_detalles as d')
            ->join('cnth_herramientas as h', 'd.id_herramienta', '=', 'h.id_herramienta')
            //->join('cnth_empleados as e', 'd.id_empleado', '=', 'e.id_empleado')
            ->select(
                'd.id_detalle',
                'd.id_movimiento',
                'd.id_herramienta',
                'h.codigo_herramienta',
                'h.nombre_herramienta',
                'd.cantidad_entregada'
            )
            ->where('d.id_movimiento', '=', $IdMovimiento)
            ->where('d.estatus', '=', NULL)
            ->get();
    }

    public static function EstatusDespacho($FechaInicio, $FechaFin,$estatus,$IdAlmacen)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('d-m-Y');
        $FechaFin = Carbon::parse($FechaFin)->format('d-m-Y');

        $EstatusDespacho = DB::table('cnth_movimientos as m')
            ->join('almacenes as a', 'm.id_almacen', '=', 'a.id_almacen')
            ->join('cnth_movimientos_detalles as md', 'md.id_movimiento', '=', 'm.id_movimiento')
            ->join('cnth_herramientas as h', 'h.id_herramienta', '=', 'md.id_herramienta')
            ->select(
                'm.id_movimiento',
                'm.id_almacen',
                'a.nombre_almacen', 
                'm.creado_por',
                'm.responsable',
                'm.estatus',
                'h.nombre_herramienta'                      
            );
            $EstatusDespacho->whereBetween( DB::raw("CONVERT(date, m.created_at)"), [$FechaInicio, $FechaFin]);
            $EstatusDespacho->where('a.id_almacen','=',$IdAlmacen);

                if($estatus != 'TODOS') 
                {
                    $EstatusDespacho->where('m.estatus', '=', $estatus);
                }
             
        return $EstatusDespacho->get();
    }

  

    public static function EstatusDespachoReportePDF($FechaInicio,$FechaFin,$estatus,$IdAlmacen)
    {
        $EstatusDespacho = DB::table('cnth_movimientos_detalles as d')
            ->join('cnth_movimientos as m', 'm.id_movimiento', '=', 'd.id_movimiento')
            ->join('cnth_herramientas as h', 'd.id_herramienta', '=', 'h.id_herramienta')
            ->join('almacenes as a', 'a.id_almacen', '=', 'm.id_almacen')
            ->select(
                'd.id_movimiento',
                'm.created_at',
                'a.id_almacen',
                'a.nombre_almacen',
                'm.creado_por',
                'm.responsable',
                'm.estatus',
                
            DB::raw("CASE WHEN d.id_movimiento IS NULL
                THEN NULL 
            ELSE 
                STRING_AGG( CAST(CONCAT('<tr>
                <td>',h.nombre_herramienta,'</td>
                <td>',d.fecha_despacho,'</td>
                <td>',d.cantidad_entregada,'</td>
                <td>',d.fecha_devolucion,'</td>
                <td>',d.cantidad_devuelta,'</td>
                </tr>')
                AS VARCHAR(MAX)),'') WITHIN GROUP ( ORDER BY h.nombre_herramienta ASC )
            END herramientas"
            )
        );
            $EstatusDespacho->whereBetween( DB::raw("CONVERT(date, m.created_at)"), [$FechaInicio, $FechaFin]);
            $EstatusDespacho->where('a.id_almacen','=',$IdAlmacen);
            $EstatusDespacho->where('m.estatus','=',$estatus);
            $EstatusDespacho->groupBy(
            'd.id_movimiento',
            'm.created_at', 
            'a.id_almacen',
            'a.nombre_almacen',
            'm.creado_por', 
            'm.responsable',
            'm.estatus',
        );
            return $EstatusDespacho->get();
    }
  
    public function movimientos()
    {
        return $this->belongsToMany(Cnth_MovimientosModel::class,'cnth_movimientos_detalles','id_movimiento','id_herramienta');
    }
}
