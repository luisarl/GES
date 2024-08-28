<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_SeguimientoPlanchaConsumiblesModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_seguimiento_plancha_consumibles';
    protected $primaryKey = 'id_seguimiento_pl_consumible';

    protected $fillable = [
        'id_seguimiento_pl_consumible',
        'id_seguimiento_plancha',
        'consumible',
        'consumo',
        'unidad',
        'observaciones',
        'creado_por',
        'fecha_creado',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';

    public static function Cenc_SeguimientoPlanchaConsumibleEditar($id)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_consumibles AS segpl_con', 'segpl_con.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl.id_seguimiento_plancha', 
                        'segpl_con.id_seguimiento_pl_consumible',
                        'segpl_con.fecha_creado',
                        'segpl_con.consumible',
                        'segpl_con.consumo',
                        'segpl_con.unidad',
                        'segpl_con.observaciones',
                        )
                    ->where('segpl.id_seguimiento_plancha','=',$id)
                    ->get();
    }

    public static function Cenc_SeguimientoPlanchaConsumibleCrear($IdOrdenTrabajoPlancha)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_consumibles AS segpl_con', 'segpl_con.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl.id_seguimiento_plancha', 
                        'segpl_con.id_seguimiento_pl_consumible',
                        'segpl_con.fecha_creado',
                        'segpl_con.consumible',
                        'segpl_con.consumo',
                        'segpl_con.unidad',
                        'segpl_con.observaciones',
                        )
                    ->where('otplancha.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
                    ->get();
    }
}
