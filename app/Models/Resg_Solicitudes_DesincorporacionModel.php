<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resg_Solicitudes_DesincorporacionModel extends Model
{
    use HasFactory;

    protected $table = 'resg_solicitudes_desincorporacion';
    protected $primaryKey = 'id_solicitud_desincorporacion';

    protected $fillable = [
        'id_solicitud_desincorporacion',
        'id_almacen',
        'observacion',
        'responsable',
        'estatus',
        'id_departamento',
        'creado_por',
        'fecha_creacion',
        'actualizado_por',
        'fecha_actualizacion',
        'aprobado_por',
        'fecha_aprobacion',
        'procesado_por',
        'fecha_procesado',
        'anulado_por',
        'fecha_anulacion',
        'documento'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ListadoSolicitudesDesincorporacionAlmacen($IdUsuario)
    {
        return DB::table('resg_solicitudes_desincorporacion as s')
            ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->join('almacen_usuario as au', 'au.id_almacen', '=', 'a.id_almacen')
            ->join('users as u', 'u.id', '=', 's.creado_por')
            ->select(
                's.id_solicitud_desincorporacion',
                's.fecha_creacion',
                //'s.creado_por',
                'u.name as creado_por',
                'a.nombre_almacen',
                's.estatus'
            )
            ->where('au.id', '=', $IdUsuario)
            ->get();
    }

    public static function VerSolicitudDesincorporacion($IdSolicitudDesincorporacion)
    {
        return DB::table('resg_solicitudes_desincorporacion as s')
        ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
        ->join('departamentos as d', 'd.id_departamento', '=', 's.id_departamento')
        ->join('users as uc', 'uc.id', '=', 's.creado_por')
        ->leftJoin('users as ua', 'ua.id', '=', 's.aprobado_por')
        ->leftJoin('users as up', 'up.id', '=', 's.procesado_por')
        ->select(
            's.id_solicitud_desincorporacion',
            's.observacion',
            's.fecha_creacion',
            's.responsable',
            's.estatus',
            'uc.name as creado_por',
            's.fecha_aprobacion',
            'ua.name as aprobado_por',
            's.fecha_procesado',
            'up.name as procesado_por',
            'a.nombre_almacen',
            'd.nombre_departamento',
            's.documento'
        )
        ->where('s.id_solicitud_desincorporacion', '=', $IdSolicitudDesincorporacion)
        ->first();  
    }
    
}
