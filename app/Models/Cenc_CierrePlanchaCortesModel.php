<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Cenc_CierrePlanchaCortesModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_cierre_plancha_cortes';
    protected $primaryKey = 'id_cierre_pl_cortes';

    protected $fillable = [
        'id_cierre_pl_cortes',
        'id_cierre_planchas',
        'piezas_anidadas',
        'piezas_cortadas',
        'piezas_danadas',
        'longitud_corte',
        'numero_perforaciones',
        'cnc_aprovechamiento',
        'total_anidadas',
        'total_cortadas',
        'total_danadas',
        'total_longitud_corte',
        'total_perforaciones',
        'creado_por',
        'fecha_creado',
    ];
    
    public static function Cenc_CierrePlanchaCortesEditar($id)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre AS ce', 'ce.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre_planchas AS ce_pla', 'ce_pla.id_cierre', '=', 'ce.id_cierre')
                    ->join('cenc_cierre_plancha_cortes AS ce_c', 'ce_c.id_cierre_planchas', '=', 'ce_pla.id_cierre_planchas')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'ce_pla.id_cierre_planchas', 
                        'ce_c.id_cierre_pl_cortes',
                        'ce_c.piezas_anidadas',
                        'ce_c.piezas_cortadas',
                        'ce_c.piezas_danadas',
                        'ce_c.cnc_aprovechamiento',
                        'ce_c.longitud_corte',
                        'ce_c.numero_perforaciones',
                        'ce_c.total_anidadas',
                        'ce_c.total_cortadas',
                        'ce_c.total_danadas',
                        'ce_c.total_longitud_corte',
                        'ce_c.total_perforaciones',
                        'ce_c.creado_por',
                        'ce_c.fecha_creado'
                        )
                    ->where('ce_pla.id_cierre_planchas','=',$id)
                    ->get();
    }

    // public static function Cenc_SeguimientoPlanchaCortesCrear($IdOrdenTrabajoPlancha)
    // {
    //     return DB::table('cenc_orden_trabajo_planchas AS otplancha')
    //                 ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
    //                 ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'ot.id_aprovechamiento')
    //                 ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
    //                 ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
    //                 ->join('cenc_seguimiento_plancha_cortes AS segpl_c', 'segpl_c.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
    //                 ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
    //                 ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
    //                 ->join('users AS u', 'ap.creado_por', '=', 'u.id')
    //                 ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
    //                 ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
    //                 ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
    //                 ->select(
    //                     'ce_pla.id_cierre_planchas', 
    //                     'ce_c.id_cierre_pl_cortes',
    //                     'ce_c.piezas_anidadas',
    //                     'ce_c.piezas_cortadas',
    //                     'ce_c.piezas_danadas',
    //                     'ce_c.cnc_aprovechamiento',
    //                     'ce_c.longitud_corte',
    //                     'ce_c.numero_perforaciones',
    //                     'ce_c.total_anidadas',
    //                     'ce_c.total_cortadas',
    //                     'ce_c.total_danadas',
    //                     'ce_c.total_longitud_corte',
    //                     'ce_c.total_perforaciones',
    //                     'ce_c.creado_por',
    //                     'ce_c.fecha_creado',
    //                     )
    //                 ->where('ce_pla.id_cierre_planchas','=',$id)
    //                 ->get();
    // }

    public static function Cenc_SeguimientoPlanchaCortesVer()
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'ot.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_cortes AS segpl_c', 'segpl_c.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl.id_seguimiento_plancha', 
                        'segpl_c.id_seguimiento_pl_cortes',
                        'segpl_c.piezas_anidadas',
                        'segpl_c.piezas_cortadas',
                        'segpl_c.piezas_danadas',
                        'segpl_c.cnc_aprovechamiento',
                        'segpl_c.longitud_corte',
                        'segpl_c.numero_perforaciones',
                        'segpl_c.total_anidadas',
                        'segpl_c.total_cortadas',
                        'segpl_c.total_danadas',
                        'segpl_c.total_longitud_corte',
                        'segpl_c.total_perforaciones',
                        'segpl_c.creado_por',
                        'segpl_c.fecha_creado',
                        )
                    ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';
}