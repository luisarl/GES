<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_SeguimientoPlanchaHorometroModel extends Model
{
    use HasFactory;
    protected $table = 'cenc_seguimiento_plancha_horometro';
    protected $primaryKey = 'id_seguimiento_pl_horometro';

    protected $fillable = [
        'id_seguimiento_pl_horometro',
        'id_seguimiento_plancha',
        'horometro_inicial_on',
        'horometro_final_on',
        'horas_hms_on',
        'horas_on',
        'total_horas_on',
        'horometro_inicial_aut',
        'horometro_final_aut',
        'tiempo_hms_aut',
        'tiempo_aut',
        'total_tiempo_aut',
        'creado_por',
        'fecha_creado',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';

    public static function Cenc_SeguimientoPlanchaHorometroVer()
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'ot.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_horometro AS segpl_h', 'segpl_h.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl.id_seguimiento_plancha',
                        'segpl_h.id_seguimiento_pl_horometro',
                        'segpl_h.horometro_inicial_on',
                        'segpl_h.horometro_final_on',
                        'segpl_h.horas_hms_on',
                        'segpl_h.horas_on',
                        'segpl_h.total_horas_on',
                        'segpl_h.horometro_inicial_aut',
                        'segpl_h.horometro_final_aut',
                        'segpl_h.tiempo_hms_aut',
                        'segpl_h.tiempo_aut',
                        'segpl_h.total_tiempo_aut',
                        'segpl_h.creado_por',
                        'segpl_h.fecha_creado',
                        )
                    ->get();
    }

    public static function Cenc_SeguimientoPlanchaHorometroCrear($IdOrdenTrabajoPlancha)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_horometro AS segpl_h', 'segpl_h.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl.id_seguimiento_plancha',
                        'segpl_h.id_seguimiento_pl_horometro',
                        'segpl_h.horometro_inicial_on',
                        'segpl_h.horometro_final_on',
                        'segpl_h.horas_hms_on',
                        'segpl_h.horas_on',
                        'segpl_h.total_horas_on',
                        'segpl_h.horometro_inicial_aut',
                        'segpl_h.horometro_final_aut',
                        'segpl_h.tiempo_hms_aut',
                        'segpl_h.tiempo_aut',
                        'segpl_h.total_tiempo_aut',
                        'segpl_h.creado_por',
                        'segpl_h.fecha_creado',
                        )
                    ->where('otplancha.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
                    ->get();
    }

    public static function Cenc_SeguimientoPlanchaHorometroEditar($IdSeguimientoPlancha)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_horometro AS segpl_h', 'segpl_h.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl.id_seguimiento_plancha',
                        'segpl_h.id_seguimiento_pl_horometro',
                        'segpl_h.horometro_inicial_on',
                        'segpl_h.horometro_final_on',
                        'segpl_h.horas_hms_on',
                        'segpl_h.horas_on',
                        'segpl_h.total_horas_on',
                        'segpl_h.horometro_inicial_aut',
                        'segpl_h.horometro_final_aut',
                        'segpl_h.tiempo_hms_aut',
                        'segpl_h.tiempo_aut',
                        'segpl_h.total_tiempo_aut',
                        'segpl_h.creado_por',
                        'segpl_h.fecha_creado',
                        )
                    ->where('segpl.id_seguimiento_plancha','=',$IdSeguimientoPlancha)
                    ->get();
    }
}