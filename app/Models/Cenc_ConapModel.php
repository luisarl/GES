<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_ConapModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_conaps';
    protected $primaryKey = 'id_conap';

    protected $fillable =  [
        'id_conap',
        'nro_conap',
        'nombre_conap',
        'descripcion_conap',
        'estatus_conap',
        'creado_por',
        'fecha_creado',
        'aprobado_por',
        'fecha_aprobado',
        'anulado_por',
        'fecha_anulado',
        'finalizado_por',
        'fecha_finalizado'
    ];

    public static function ListaConaps()
    {
        return DB::table('cenc_conaps as c')
                ->join('users AS u', 'c.creado_por', '=', 'u.id')
                ->select(
                    'c.id_conap',
                    'c.nro_conap',
                    'c.created_at',
                    'c.nombre_conap',
                    'c.descripcion_conap',
                    'c.estatus_conap',
                    'u.name',
                    )
                ->get();
    }

    public static function updateStatus($idconap, $estatus)
    {
        DB::table('cenc_conaps')
            ->where('id_conap', $idconap)
            ->update(['estatus_conap' => $estatus]);
    }

    public static function ListaConapsVer($IdConap)
    {
        return DB::table('cenc_conaps AS c')
                ->join('users AS u', 'c.creado_por', '=', 'u.id')
                ->select(
                    'id_conap',
                    'nro_conap',
                    'nombre_conap',
                    'descripcion_conap',
                    'estatus_conap',
                    'creado_por',
                    'fecha_creado',
                    'aprobado_por',
                    'fecha_aprobado',
                    'anulado_por',
                    'fecha_anulado',
                    'finalizado_por',
                    'fecha_finalizado',
                    'u.name',
                    )
                ->where('c.id_conap','=',$IdConap)
                ->first();
    }

    public static function UsuarioConapAprobado($IdConap)
    {
        return DB::table('cenc_conaps AS c')
                ->join('users AS u', 'c.aprobado_por', '=', 'u.id')
                ->select(
                    'aprobado_por',
                    'fecha_aprobado',
                    'u.name',
                    )
                ->where('c.id_conap','=',$IdConap)
                ->first();
    }

    public static function UsuarioConapAnulado($IdConap)
    {
        return DB::table('cenc_conaps AS c')
                ->join('users AS u', 'c.anulado_por', '=', 'u.id')
                ->select(
                    'anulado_por',
                    'fecha_anulado',
                    'u.name',
                    )
                ->where('c.id_conap','=',$IdConap)
                ->first();
    }

    public static function UsuarioConapFinalizado($IdConap)
    {
        return DB::table('cenc_conaps AS c')
                ->join('users AS u', 'c.finalizado_por', '=', 'u.id')
                ->select(
                    'finalizado_por',
                    'fecha_finalizado',
                    'u.name',
                    )
                ->where('c.id_conap','=',$IdConap)
                ->first();
    }



    protected $dateFormat = 'Y-d-m H:i:s';
}
