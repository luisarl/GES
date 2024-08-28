<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resg_ResguardoModel extends Model
{
    use HasFactory;

    protected $table = 'resg_resguardos';
    protected $primaryKey = 'id_resguardo';

    protected $fillable = [
        'id_resguardo',
        'id_solicitud_resguardo',
        'codigo_articulo',
        'nombre_articulo',
        'tipo_unidad',
        'equivalencia_unidad',
        'cantidad',
        'cantidad_disponible',
        'estado',
        'observacion',
        'id_clasificacion',
        'id_ubicacion',
        'estatus',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ArticulosSolicitudResguardo($IdSolicitud)
    {
        return DB::table('resg_resguardos as r')
            ->join('resg_clasificaciones as c', 'r.id_clasificacion', '=', 'c.id_clasificacion')
            ->leftJoin('resg_ubicaciones as u', 'r.id_ubicacion', '=', 'u.id_ubicacion')
            ->select(
                'r.id_resguardo',
                'r.codigo_articulo',
                'r.nombre_articulo',
                'r.tipo_unidad',
                'r.equivalencia_unidad',
                'r.cantidad',
                'r.estado',
                'r.observacion',
                'r.id_clasificacion',
                'c.nombre_clasificacion',
                'r.id_ubicacion',
                'u.nombre_ubicacion',
                'r.estatus',
            )
            ->where('r.id_solicitud_resguardo', '=', $IdSolicitud)
            ->get();
    }

    public static function ArticulosResguardo()
    {
        return DB::table('resg_resguardos as r')
            ->join('resg_clasificaciones as c', 'c.id_clasificacion', '=', 'r.id_clasificacion')
            ->join('resg_ubicaciones as u', 'u.id_ubicacion', '=', 'r.id_ubicacion')
            ->join('resg_solicitudes_resguardo as s', 's.id_solicitud_resguardo', '=', 'r.id_solicitud_resguardo')
            ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->join('departamentos as d', 'd.id_departamento', '=', 's.id_departamento')
            ->select(
                'r.id_resguardo',
                's.id_almacen',
                'a.nombre_almacen',
                'r.id_solicitud_resguardo',
                'r.codigo_articulo',
                'r.nombre_articulo',
                'r.tipo_unidad',
                'r.equivalencia_unidad',
                'r.cantidad',
                'r.cantidad_disponible',
                'r.estado',
                'r.observacion',
                'r.id_clasificacion',
                'c.nombre_clasificacion',
                'r.id_ubicacion',
                'u.nombre_ubicacion',
                'd.nombre_departamento',
                'r.estatus'
            )
            //->whereNotIn('r.id_clasificacion', [4]) DEVOLUCION
            ->where('r.estatus', '=', 'DISPONIBLE')
            ->orWhere('r.estatus', '=', 'POR PROCESAR')
            ->get();
    }

    public static function VerArticuloResguardo($IdResguardo)
    {
        return DB::table('resg_resguardos as r')
            ->join('resg_clasificaciones as c', 'c.id_clasificacion', '=', 'r.id_clasificacion')
            ->join('resg_ubicaciones as u', 'u.id_ubicacion', '=', 'r.id_ubicacion')
            ->join('resg_solicitudes_resguardo as s', 's.id_solicitud_resguardo', '=', 'r.id_solicitud_resguardo')
            ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->join('users as us', 'us.id', '=', 's.creado_por')
            ->join('departamentos as d', 'd.id_departamento', '=', 's.id_departamento')
            ->select(
                'r.id_resguardo',
                's.id_almacen',
                'a.nombre_almacen',
                'r.id_solicitud_resguardo',
                'r.codigo_articulo',
                'r.nombre_articulo',
                'r.tipo_unidad',
                'r.equivalencia_unidad',
                'r.cantidad',
                'r.cantidad_disponible',
                'r.estado',
                'r.observacion',
                'r.id_clasificacion',
                'c.nombre_clasificacion',
                'r.id_ubicacion',
                'u.nombre_ubicacion',
                'r.estatus',
                'us.name as creado_por',
                's.fecha_creacion',
                'd.nombre_departamento'
                
            )
            ->where('r.id_resguardo', '=', $IdResguardo)     
            ->first();
    }

    public static function ArticulosResguardoAlmacen($IdAlmacen)
    {
        return DB::table('resg_resguardos as r')
            ->join('resg_clasificaciones as c', 'c.id_clasificacion', '=', 'r.id_clasificacion')
            ->join('resg_ubicaciones as u', 'u.id_ubicacion', '=', 'r.id_ubicacion')
            ->join('resg_solicitudes_resguardo as s', 's.id_solicitud_resguardo', '=', 'r.id_solicitud_resguardo')
            //->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->select(
                'r.id_resguardo',
                's.id_almacen',
                //'a.nombre_almacen',
                'r.id_solicitud_resguardo',
                'r.codigo_articulo',  
                'r.nombre_articulo',
                'r.tipo_unidad',
                'r.equivalencia_unidad',
                'r.cantidad',
                'r.cantidad_disponible',
                'r.estado',
                'r.observacion',
                'r.id_clasificacion',
                'c.nombre_clasificacion',
                'r.id_ubicacion',
                'u.nombre_ubicacion',
                'r.estatus'
            )
            ->where('r.estatus', '=', 'DISPONIBLE')
            ->whereIn('r.id_clasificacion', [1,2,5])
            ->where('s.id_almacen', '=', $IdAlmacen)
            ->get();
    }

    public static function ArticulosDesincorporarAlmacen($IdAlmacen)
    {
        return DB::table('resg_resguardos as r')
            ->join('resg_clasificaciones as c', 'c.id_clasificacion', '=', 'r.id_clasificacion')
            ->join('resg_ubicaciones as u', 'u.id_ubicacion', '=', 'r.id_ubicacion')
            ->join('resg_solicitudes_resguardo as s', 's.id_solicitud_resguardo', '=', 'r.id_solicitud_resguardo')
            //->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->select(
                'r.id_resguardo',
                's.id_almacen',
                //'a.nombre_almacen',
                'r.id_solicitud_resguardo',
                'r.codigo_articulo',  
                'r.nombre_articulo',
                'r.tipo_unidad',
                'r.equivalencia_unidad',
                'r.cantidad',
                'r.cantidad_disponible',
                'r.estado',
                'r.observacion',
                'r.id_clasificacion',
                'c.nombre_clasificacion',
                'r.id_ubicacion',
                'u.nombre_ubicacion',
                'r.estatus'
            )
            ->where('r.estatus', '=', 'DISPONIBLE')
            ->where('s.id_almacen', '=', $IdAlmacen)
            ->whereIn('r.id_clasificacion', [3])
            ->get();
    }

    public static function HistoricoResguardo($IdResguardo)
    {
        $despacho = DB::table('resg_resguardos AS r')
            ->join('resg_solicitudes_despacho_detalle as sd', 'sd.id_resguardo', '=', 'r.id_resguardo') 
            ->join('resg_solicitudes_despacho as s', 's.id_solicitud_despacho', '=', 'sd.id_solicitud_despacho')
            ->select(
                'r.id_resguardo',
                's.id_solicitud_despacho as id_solicitud',
                's.fecha_creacion',
                DB::raw("'DESPACHO' as tipo"),
                's.responsable' ,
                'r.codigo_articulo',
                'r.nombre_articulo',
                'sd.cantidad',
                's.observacion'
            )
            ->where('r.id_resguardo', '=', $IdResguardo);
       
        return DB::table('resg_resguardos AS r')
            ->join('resg_solicitudes_resguardo as s', 's.id_solicitud_resguardo', '=', 'r.id_solicitud_resguardo')
            ->select(
                'r.id_resguardo',
                'r.id_solicitud_resguardo as id_solicitud',
                's.fecha_creacion',
                DB::raw("'RESGUARDO' as tipo"),
                's.responsable' ,
                'r.codigo_articulo',
                'r.nombre_articulo',
                'r.cantidad',
                's.observacion'
            )
            ->union($despacho)
            ->where('r.id_resguardo', '=', $IdResguardo)
            ->get();
    }

    public static function ArticulosResguardoAlmacenClasificacion($IdAlmacen, $IdClasificacion)
    {
       $resguardos = DB::table('resg_resguardos as r')
                ->join('resg_clasificaciones as c', 'c.id_clasificacion', '=', 'r.id_clasificacion')
                ->join('resg_solicitudes_resguardo as sr', 'sr.id_solicitud_resguardo', '=', 'r.id_solicitud_resguardo')
                ->join('almacenes as a', 'a.id_almacen', '=', 'sr.id_almacen')
                ->select(
                   'r.id_resguardo',
                    'r.id_solicitud_resguardo',
                    'sr.id_almacen',
                    'a.nombre_almacen',
                    'r.codigo_articulo',
                    'r.nombre_articulo',
                    DB::raw("CONCAT(r.equivalencia_unidad, ' ', r.tipo_unidad) as presentacion"),
                    'r.cantidad',
                    'r.cantidad_disponible',
                    'r.id_ubicacion',
                    'r.id_clasificacion',
                    'c.nombre_clasificacion',
                    'r.estado',
                    'r.estatus',
                    'r.observacion'
                )
                ->whereIn('r.estatus', ['DISPONIBLE', 'POR PROCESAR'])
                ->where('a.id_almacen', '=', $IdAlmacen);
                
                if ($IdClasificacion != 0)
                {
                    $resguardos->where('c.id_clasificacion', '=', $IdClasificacion);
                }
                   
                return $resguardos->get();
    }
}
