<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_OrdenTrabajo_PlanchasModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_orden_trabajo_planchas';
    protected $primaryKey = 'id_orden_trabajo_plancha';

    protected $fillable = [
        'id_orden_trabajo_plancha',
        'id_orden_trabajo',
        'id_aprovechamiento',
        'id_lista_parte',
        'equipo',
        'tecnologia',
        'tiempo_estimado',
        'consumo_oxigeno',
        'consumo_gas',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';

    public static function BuscarEspesorOrdenTrabajoPlancha($IdOrdenTrabajoPlancha)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'ot.id_aprovechamiento')
                ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                ->select(
                    'aprovpl.espesor',
                    )
                ->where('otplancha.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
                ->value('espesor'); 
    }

    public static function OrdenTrabajoPlanchasVer($IdOrdenTrabajoPlancha)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                ->select(
                    'ot.id_orden_trabajo',
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
                    'aprovpl.juego_antorcha',
                    'e.nombre_equipo',
                    'e.id_equipo',
                    )
                ->where('otplancha.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
                ->first();
    }

    public static function OrdenTrabajoPlanchasBuscar($IdOrdenTrabajoPlancha)
    {
        return DB::table('cenc_orden_trabajo AS ot')
                ->join('cenc_orden_trabajo_planchas AS otp', 'otp.id_orden_trabajo', '=', 'ot.id_orden_trabajo')
                ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otp.id_aprovechamiento')
                ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                ->join('cenc_lista_planchas as lp_pla', 'lp_pla.id_lista_parte', '=', 'listap.id_lista_parte')
                ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                ->join('users AS u', 'ot.creado_por', '=', 'u.id')
                ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'otp.tecnologia')
                ->join('cenc_equipos as e', 'e.id_equipo', '=', 'otp.equipo')
                ->select(
                    'ot.id_orden_trabajo',
                    'otp.id_orden_trabajo_plancha',
                    'lp_pla.id_lplancha',
                    'listap.tipo_lista',
                    'c.nro_conap',
                    'c.id_conap',
                    'u.name',
                    'ap.id_aprovechamiento', 
                    'ap.id_lista_parte', 
                    'ap.estatus',
                    'aprovpl.nombre_equipo',
                    'aprovpl.nombre_tecnologia',
                    'aprovpl.espesor', 
                    'aprovpl.juego_antorcha',
                    't.nombre_tecnologia',
                    't.id_tecnologia',
                    'aprovpl.espesor',
                    'aprovpl.juego_antorcha',
                    'e.nombre_equipo',
                    'e.id_equipo',
                    )
                ->where('otp.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
                ->first();
    }
}
