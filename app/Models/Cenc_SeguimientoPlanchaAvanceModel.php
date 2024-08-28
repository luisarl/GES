<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_SeguimientoPlanchaAvanceModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_seguimiento_plancha_avance';
    protected $primaryKey = 'id_seguimiento_pl_avance';

    protected $fillable = [
        'id_seguimiento_pl_avance',
        'id_seguimiento_plancha',
        'nro_partes',
        'descripcion',
        'dimensiones',
        'cantidad_piezas',
        'peso_unitario',
        'peso_total',
        'avance_cant_piezas',
        'avance_peso',
        'pendiente_cant_piezas',
        'pendiente_peso',
        'prod_cant_piezas_avance',
        'prod_peso_total_avance',
        'pend_cant_piezas_avance',
        'pend_peso_avance',
        'creado_por',
        'fecha_creado',
    ];

    public static function Cenc_SeguimientoPlanchaAvanceVer()
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'ot.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_avance AS segpl_a', 'segpl_a.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl_a.id_seguimiento_pl_avance',
                        'segpl_a.id_seguimiento_plancha',
                        'segpl_a.nro_partes',
                        'segpl_a.descripcion',
                        'segpl_a.dimensiones',
                        'segpl_a.cantidad_piezas',
                        'segpl_a.peso_unitario',
                        'segpl_a.peso_total',
                        'segpl_a.avance_cant_piezas',
                        'segpl_a.avance_peso',
                        'segpl_a.pendiente_cant_piezas',
                        'segpl_a.pendiente_peso',
                        'segpl_a.prod_cant_piezas_avance',
                        'segpl_a.prod_peso_total_avance',
                        'segpl_a.pend_cant_piezas_avance',
                        'segpl_a.pend_peso_avance',
                        'segpl_a.creado_por',
                        'segpl_a.fecha_creado',
                        )
                    ->get();
    }

    public static function Cenc_SeguimientoPlanchaAvanceCrear($IdOrdenTrabajoPlancha)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_avance AS segpl_a', 'segpl_a.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl_a.id_seguimiento_pl_avance',
                        'segpl_a.id_seguimiento_plancha',
                        'segpl_a.nro_partes',
                        'segpl_a.descripcion',
                        'segpl_a.dimensiones',
                        'segpl_a.cantidad_piezas',
                        'segpl_a.peso_unitario',
                        'segpl_a.peso_total',
                        'segpl_a.avance_cant_piezas',
                        'segpl_a.avance_peso',
                        'segpl_a.pendiente_cant_piezas',
                        'segpl_a.pendiente_peso',
                        'segpl_a.prod_cant_piezas_avance',
                        'segpl_a.prod_peso_total_avance',
                        'segpl_a.pend_cant_piezas_avance',
                        'segpl_a.pend_peso_avance',
                        'segpl_a.creado_por',
                        'segpl_a.fecha_creado',
                        )
                    ->where('otplancha.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
                    ->get();
    }

    public static function Cenc_SeguimientoPlanchaAvanceEditar($id)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_avance AS segpl_a', 'segpl_a.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'segpl_a.id_seguimiento_pl_avance',
                        'segpl_a.id_seguimiento_plancha',
                        'segpl_a.nro_partes',
                        'segpl_a.descripcion',
                        'segpl_a.dimensiones',
                        'segpl_a.cantidad_piezas',
                        'segpl_a.peso_unitario',
                        'segpl_a.peso_total',
                        'segpl_a.avance_cant_piezas',
                        'segpl_a.avance_peso',
                        'segpl_a.pendiente_cant_piezas',
                        'segpl_a.pendiente_peso',
                        'segpl_a.prod_cant_piezas_avance',
                        'segpl_a.prod_peso_total_avance',
                        'segpl_a.pend_cant_piezas_avance',
                        'segpl_a.pend_peso_avance',
                        'segpl_a.creado_por',
                        'segpl_a.fecha_creado',
                        )
                    ->where('segpl.id_seguimiento_plancha','=',$id)
                    ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';

}
