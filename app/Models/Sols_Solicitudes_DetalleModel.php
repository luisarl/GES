<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sols_Solicitudes_DetalleModel extends Model
{
    use HasFactory;

    protected $table = 'sols_solicitudes_detalle';
    protected $primaryKey = 'id_solicitud_detalle';

    protected $fillable =  [
        'id_solicitud_detalle',
        'id_solicitud',
        'estatus',
        'fecha',
        'usuario',
        'comentario',
        'documentos'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function SolicitudDetalle($IdSolicitud, $IdDetalle)
    {
        return DB::table('sols_solicitudes_detalle as d')
                ->join('sols_solicitudes as s', 'd.id_solicitud', '=', 's.id_solicitud')
                ->select(
                    'd.id_solicitud_detalle', 
                    'd.id_solicitud', 
                    's.codigo_solicitud',
                    's.creado_por', 
                    's.id_departamento_servicio',
                    's.id_departamento_solicitud',
                    's.asunto_solicitud',
                    's.aceptada', 
                    'd.estatus',
                    'd.fecha', 
                    'd.usuario', 
                    'd.comentario'
                )
                ->where('d.id_solicitud', '=', $IdSolicitud)
                ->where('d.id_solicitud_detalle', '=', $IdDetalle)
                ->first();
    }
}
