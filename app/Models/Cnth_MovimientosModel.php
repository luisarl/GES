<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cnth_MovimientosModel extends Model
{

    use HasFactory;

    protected $table = 'cnth_movimientos';
    protected $primaryKey = 'id_movimiento';

    protected $fillable = [
        'id_movimiento',
        'numero_solicitud',
        'estatus',
        'motivo',
        'imagen',
        'responsable',
        'id_empleado',
        'id_almacen',
        'creado_por',

    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ListaMovimientos($IdUsuario)
    {
        return  DB::table('cnth_movimientos as m')
            ->join('almacenes as a', 'm.id_almacen', '=', 'a.id_almacen')
            //->join('cnth_empleados as e', 'm.id_empleado', '=', 'e.id_empleado')
            ->join('almacen_usuario as au', 'au.id_almacen', '=', 'm.id_almacen')
            ->select(
                'm.id_movimiento',
                'm.motivo',
                'm.imagen',
                'm.id_almacen',
                'a.nombre_almacen',
                'm.creado_por',
                'm.responsable',
                DB::raw("CONVERT(VARCHAR(10), m.created_at, 103) + ' - ' + RIGHT(CONVERT(VARCHAR, m.created_at, 100), 7) as created_at"),
                'm.estatus'
            )
            ->where('au.id', '=', $IdUsuario)
            ->get();
    } 

    public static function ListaMovimientosHerramientas($IdUsuario)
    {
        return  DB::table('cnth_movimientos as m')
            ->join('almacenes as a', 'm.id_almacen', '=', 'a.id_almacen')
            //->join('cnth_empleados as e', 'm.id_empleado', '=', 'e.id_empleado')
            ->join('cnth_zonas as z', 'z.id_zona', '=', 'm.id_zona')    
            ->join('almacen_usuario as au', 'au.id_almacen', '=', 'm.id_almacen')
            ->join('cnth_movimientos_detalles as md', 'md.id_movimiento', '=', 'm.id_movimiento')
            ->join('cnth_herramientas as h', 'h.id_herramienta', '=', 'md.id_herramienta')
            ->select(
                'm.id_movimiento',
                'm.motivo',
                'm.imagen',
                'm.id_almacen',
                'a.nombre_almacen',
                'm.creado_por',
                'm.responsable',
                //'z.id_zona',
                'z.nombre_zona',
                DB::raw("CONVERT(VARCHAR(10), m.created_at, 103) + ' - ' + RIGHT(CONVERT(VARCHAR, m.created_at, 100), 7) as created_at"),
                'm.estatus',
                DB::raw("CASE WHEN m.id_movimiento IS NULL
                            THEN NULL 
                        ELSE 
                            STRING_AGG( CAST(CONCAT('<tr><td>',h.id_herramienta,'</td><td>',h.nombre_herramienta, '</td><td>',cantidad_entregada,'</td><td>',cantidad_devuelta,'</td></tr>')AS VARCHAR(MAX)),'')
                        END  herramientas"
                        )
            )
            ->where('au.id', '=', $IdUsuario)
            ->whereNotNull('md.cantidad_entregada')
            ->groupBy(
                'm.id_movimiento',
                'm.motivo',
                'm.imagen',
                'm.id_almacen',
                'a.nombre_almacen',
                'm.creado_por',
                'm.responsable',
                DB::raw("CONVERT(VARCHAR(10), m.created_at, 103) + ' - ' + RIGHT(CONVERT(VARCHAR, m.created_at, 100), 7)"),
                'z.nombre_zona',
                'm.estatus'
            )
            ->get();
    } 

    public static function movimiento($IdMovimiento)
    {
        return  DB::table('cnth_movimientos as m')
            ->join('almacenes as a', 'm.id_almacen', '=', 'a.id_almacen')
            ->join('cnth_zonas as z', 'm.id_zona', '=', 'z.id_zona')
            ->select(
                'm.id_movimiento',
                'm.motivo',
                'm.imagen',
                'm.id_almacen',
                'm.id_zona',
                'z.nombre_zona',
                'a.nombre_almacen',
                'm.creado_por',
                'm.responsable',
                DB::raw("CONVERT(VARCHAR(10), m.created_at, 103) + ' - ' + RIGHT(CONVERT(VARCHAR, m.created_at, 100), 7) as created_at"),
                'm.estatus'
            )
            ->where('m.id_movimiento', '=', $IdMovimiento)
            ->first();
    }

    public static function movimiento_detalle($IdMovimiento)
    {
        return DB::table('cnth_movimientos_detalles as d')
            ->join('cnth_herramientas as h', 'd.id_herramienta', '=', 'h.id_herramienta')
            //->join('cnth_empleados as e', 'd.id_empleado', '=', 'e.id_empleado')
            ->select(
                'd.id_detalle',
                'd.id_movimiento',
                'd.id_herramienta',
                'h.nombre_herramienta',
                'd.cantidad_entregada',
                'd.cantidad_devuelta',
                'd.responsable',
                DB::raw("CONVERT(VARCHAR(10), d.fecha_despacho, 103) + ' - ' + RIGHT(CONVERT(VARCHAR, d.fecha_despacho, 100), 7) as fecha_despacho"),
                'd.aprobacion',
                'd.estatus',
                'd.eventualidad',
                'd.created_at'
            )
            ->where('d.id_movimiento', '=', $IdMovimiento)
            ->where('d.estatus', '=', NULL)
            ->get();
    }

    public static function detalles_enviar($IdMovimiento)
    {
        return DB::table('cnth_movimientos_detalles as d')
            ->join('cnth_herramientas as h', 'd.id_herramienta', '=', 'h.id_herramienta')
            ->select(
                'd.id_detalle',
                'd.id_movimiento',
                'd.id_herramienta',
                'h.nombre_herramienta',
                'd.cantidad_entregada',
                'd.responsable',
                'd.fecha_despacho',
                'd.aprobacion',
                'd.eventualidad',
                'd.created_at'
            )
            ->where('d.id_movimiento', '=', $IdMovimiento);
    }

    public static function cantidad_pendiente($IdMovimiento)
    {
        return DB::table('cnth_movimientos_detalles')
            ->selectRaw('SUM(isnull(cantidad_entregada,0) - isnull(cantidad_devuelta,0)) as cantidad_pendiente')
            ->where('id_movimiento', '=', $IdMovimiento)
            ->where('estatus', '=', NULL)
            ->value('cantidad_pendiente');
    }

    //Relacion de con herramienta
    public function herramientas()
    {
        return $this->hasMany(Cnth_HerramientasModel::class, 'id_herramienta');
    }

    public function almacen()
    {
        return $this->belongsTo(AlmacenesModel::class, 'id_almacen');
    }

    //Relacion de muchos a muchos entre herramientas y despacho
    public function detalles()
    {
        return $this->belongsToMany(Cnth_HerramientasModel::class, 'cnth_detalles', 'id_herramienta', 'id_movimiento');
    }
}
