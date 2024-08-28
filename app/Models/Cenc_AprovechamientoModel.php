<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_AprovechamientoModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_aprovechamientos';
    protected $primaryKey = 'id_aprovechamiento';

    protected $fillable = [
        'id_aprovechamiento',
        'id_lista_parte',
        'estatus',
        'fecha_creado',
        'creado_por',
        'fecha_validado',
        'validado_por',
        'fecha_aprobado',
        'aprobado_por',
        'fecha_enproceso',
        'enproceso_por',
        'fecha_finalizado',
        'finalizado_por',
        'fecha_anulado',
        'anulado_por',
    ];

    public static function Aprovechamientos()
    {
        return DB::table('cenc_aprovechamientos AS ap')
                ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                ->select(
                    'ap.id_aprovechamiento', 
                    'ap.id_lista_parte', 
                    'ap.estatus',
                    't.nombre_tecnologia',
                    't.id_tecnologia',
                    'listap.tipo_lista',
                    'c.nro_conap',
                    'c.id_conap',
                    'u.name',
                    'aprovpl.espesor',
                    'e.nombre_equipo',
                    'e.id_equipo',
                    )
                ->get();
    }


    public static function AprovechamientosEditar($IdAprovechamiento){
        return DB::table('cenc_aprovechamientos as aprov')
        ->join ('cenc_lista_partes as lp','lp.id_lista_parte','=','aprov.id_lista_parte')
        ->join ('cenc_conaps as c','c.id_conap','=','lp.nro_conap')
        ->join ('cenc_aprovechamiento_planchas as aprovpl','aprovpl.id_aprovechamiento','=','aprov.id_aprovechamiento')
        ->join ('cenc_tecnologias as t','t.id_tecnologia','=','aprovpl.nombre_tecnologia')
        ->join ('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
        ->join ('users AS u', 'aprov.creado_por', '=', 'u.id')
        ->select(
            'aprov.id_lista_parte',
            'aprov.id_aprovechamiento',
            'aprov.estatus',
            'aprov.created_at',
            'aprov.updated_at',
            'aprov.creado_por',
            'aprov.fecha_creado',

            'aprov.fecha_validado',
            'aprov.validado_por',

            'aprov.fecha_aprobado',
            'aprov.aprobado_por',

            'aprov.fecha_enproceso',
            'aprov.enproceso_por',

            'aprov.fecha_anulado',
            'aprov.anulado_por',

            'aprov.fecha_finalizado',
            'aprov.finalizado_por',


            'aprovpl.espesor', 
            'lp.tipo_lista',
            'lp.nro_conap as idconap',
            'c.nro_conap',
            't.nombre_tecnologia as tecnologia',
            'e.nombre_equipo as equipo',
            'aprovpl.nombre_equipo',
            'aprovpl.nombre_tecnologia',
            'aprovpl.longitud_corte',
            'aprovpl.numero_piercing',
            'aprovpl.tiempo_estimado',
            'aprovpl.juego_antorcha',
            'aprovpl.numero_boquilla',
            'aprovpl.precalentamiento',
            'aprovpl.tiempo_precalentamiento',
            'aprovpl.observaciones',
            'u.name'
            )
        ->where('aprov.id_aprovechamiento','=',$IdAprovechamiento)
        ->first();
    }

    public static function UsuarioAprovechamientoValidado($IdAprovechamiento)
    {
        return DB::table('cenc_aprovechamientos as aprov')
                ->join('users AS u', 'aprov.validado_por', '=', 'u.id')
                ->select(
                    'aprov.validado_por',
                    'aprov.fecha_validado',
                    'u.name',
                    )
                ->where('aprov.id_aprovechamiento','=',$IdAprovechamiento)
                ->first();
    }

    public static function UsuarioAprovechamientoAprobado($IdAprovechamiento)
    {
        return DB::table('cenc_aprovechamientos as aprov')
                ->join('users AS u', 'aprov.aprobado_por', '=', 'u.id')
                ->select(
                    'aprov.aprobado_por',
                    'aprov.fecha_aprobado',
                    'u.name',
                    )
                ->where('aprov.id_aprovechamiento','=',$IdAprovechamiento)
                ->first();
    }

    public static function UsuarioAprovechamientoEnProceso($IdAprovechamiento)
    {
        return DB::table('cenc_aprovechamientos as aprov')
                ->join('users AS u', 'aprov.enproceso_por', '=', 'u.id')
                ->select(
                    'aprov.enproceso_por',
                    'aprov.fecha_enproceso',
                    'u.name',
                    )
                ->where('aprov.id_aprovechamiento','=',$IdAprovechamiento)
                ->first();
    }

    public static function UsuarioAprovechamientoAnulado($IdAprovechamiento)
    {
        return DB::table('cenc_aprovechamientos as aprov')
                ->join('users AS u', 'aprov.anulado_por', '=', 'u.id')
                ->select(
                    'aprov.anulado_por',
                    'aprov.fecha_anulado',
                    'u.name',
                    )
                ->where('aprov.id_aprovechamiento','=',$IdAprovechamiento)
                ->first();
    }

    public static function UsuarioAprovechamientoFinalizado($IdAprovechamiento)
    {
        return DB::table('cenc_aprovechamientos as aprov')
                ->join('users AS u', 'aprov.finalizado_por', '=', 'u.id')
                ->select(
                    'aprov.finalizado_por',
                    'aprov.fecha_finalizado',
                    'u.name',
                    )
                ->where('aprov.id_aprovechamiento','=',$IdAprovechamiento)
                ->first();
    }

    public static function BuscarSiTieneSeguimiento($IdAprovechamiento)
    {
        return DB::table('cenc_aprovechamientos as aprov')
                ->join('cenc_orden_trabajo_planchas AS otp', 'otp.id_aprovechamiento', '=', 'aprov.id_aprovechamiento')
                ->select(
                    'otp.id_aprovechamiento',
                    'otp.id_orden_trabajo_plancha',
                    )
                ->where('otp.id_aprovechamiento','=',$IdAprovechamiento)
                ->first();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
