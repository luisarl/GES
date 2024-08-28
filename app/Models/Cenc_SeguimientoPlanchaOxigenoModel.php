<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_SeguimientoPlanchaOxigenoModel extends Model
{
    use HasFactory;
    protected $table = 'cenc_seguimiento_plancha_oxigeno';
    protected $primaryKey = 'id_seguimiento_pl_oxigeno';

    protected $fillable = [
        'id_seguimiento_pl_oxigeno',
        'id_seguimiento_plancha',
        'oxigeno_inicial',
        'oxigeno_final',
        'oxigeno_usado',
        'cambio',
        'litros_gaseosos',
        'total_oxigeno_usado',
        'total_litros_gaseosos',
        'creado_por',
        'fecha_creado',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';

    public static function Cenc_SeguimientoPlanchaOxigenoVer()
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'ot.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_oxigeno AS segpl_o', 'segpl_o.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl.id_seguimiento_plancha', 
                        'segpl_o.id_seguimiento_pl_oxigeno',
                        'segpl_o.fecha_creado',
                        'segpl_o.oxigeno_inicial',
                        'segpl_o.oxigeno_final',
                        'segpl_o.oxigeno_usado',
                        'segpl_o.cambio',
                        'segpl_o.litros_gaseosos',
                        )
                    ->get();
    }

    public static function Cenc_SeguimientoPlanchaOxigenoCrear($IdOrdenTrabajoPlancha)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_oxigeno AS segpl_o', 'segpl_o.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl.id_seguimiento_plancha', 
                        'segpl_o.id_seguimiento_pl_oxigeno',
                        'segpl_o.fecha_creado',
                        'segpl_o.oxigeno_inicial',
                        'segpl_o.oxigeno_final',
                        'segpl_o.oxigeno_usado',
                        'segpl_o.cambio',
                        'segpl_o.litros_gaseosos',
                        'segpl_o.total_oxigeno_usado',
                        'segpl_o.total_litros_gaseosos'
                        )
                    ->where('otplancha.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
                    ->get();
    }


    public static function Cenc_SeguimientoPlanchaOxigenoEditar($id)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_oxigeno AS segpl_o', 'segpl_o.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl.id_seguimiento_plancha', 
                        'segpl_o.id_seguimiento_pl_oxigeno',
                        'segpl_o.fecha_creado',
                        'segpl_o.oxigeno_inicial',
                        'segpl_o.oxigeno_final',
                        'segpl_o.oxigeno_usado',
                        'segpl_o.cambio',
                        'segpl_o.litros_gaseosos',
                        'segpl_o.total_oxigeno_usado',
                        'segpl_o.total_litros_gaseosos'
                        )
                    ->where('segpl.id_seguimiento_plancha','=',$id)
                    ->get();
    }

}
