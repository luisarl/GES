<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resg_Solicitudes_Desincorporacion_DetalleModel extends Model
{
    use HasFactory;

    protected $table = 'resg_solicitudes_desincorporacion_detalle';
    protected $primaryKey = 'id_solicitud_desincorporacion_detalle';

    protected $fillable = [
        'id_solicitud_desincorporacion_detalle',
        'id_solicitud_desincorporacion',
        'id_resguardo',
        'cantidad',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ArticulosSolicitudDesincorporacion($IdSolicitudDesincorporacion)
    {
        return DB::table('resg_solicitudes_desincorporacion_detalle as s')
            ->join('resg_resguardos as r', 'r.id_resguardo', 's.id_resguardo')
            ->join('resg_clasificaciones as c', 'c.id_clasificacion', 'r.id_clasificacion')
            ->join('resg_ubicaciones as u', 'u.id_ubicacion', 'r.id_ubicacion')
            ->select(
                's.id_solicitud_desincorporacion_detalle',
                'r.id_solicitud_resguardo',
                's.id_resguardo',
                'r.codigo_articulo',
                'r.nombre_articulo',
                'r.cantidad_disponible',
                's.cantidad',
                'r.equivalencia_unidad',
                'r.tipo_unidad',
                'r.estado',
                'r.observacion',
                'c.nombre_clasificacion',
                'u.nombre_ubicacion'
            )
            ->where('s.id_solicitud_desincorporacion', '=', $IdSolicitudDesincorporacion)
            ->get();
    }
}
