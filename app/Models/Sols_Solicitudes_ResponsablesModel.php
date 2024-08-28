<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sols_Solicitudes_ResponsablesModel extends Model
{
    use HasFactory;

    protected $table = 'sols_solicitudes_responsables';
    protected $primaryKey = 'id_solicitud_responsable';

    protected $fillable =  [
        'id_solicitud_responsable',
        'id_solicitud',
        'id_responsable',
        'nombre_responsable',
        'fecha_asignacion'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ResponsablesSolicitud($IdSolicitud) 
    {
        return DB::table('sols_solicitudes_responsables as s')
                ->join('sols_responsables as r', 's.id_responsable', '=', 'r.id_responsable')
                ->select(
                    'r.id_responsable',
                    'r.nombre_responsable',
                    'r.cargo_responsable',
                    's.id_solicitud_responsable'
                )
                ->where('s.id_solicitud', '=', $IdSolicitud)
                ->get();
    }
}
