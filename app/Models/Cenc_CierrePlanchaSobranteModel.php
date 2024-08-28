<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Cenc_CierrePlanchaSobranteModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_cierre_plancha_sobrante';
    protected $primaryKey = 'id_cierre_pl_sobrante';

    protected $fillable = [
        'id_cierre_pl_sobrante',
        'id_cierre_planchas',
        'descripcion',
        'referencia',
        'cantidad',
        'ubicacion',
        'observacion',
        'creado_por',
        'fecha_creado',
    ];

    public static function Cenc_CierrePlanchaSobranteEditar($id)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre AS ce', 'ce.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre_planchas AS ce_pla', 'ce_pla.id_cierre', '=', 'ce.id_cierre')
                    ->join('cenc_cierre_plancha_sobrante AS ce_so', 'ce_so.id_cierre_planchas', '=', 'ce_pla.id_cierre_planchas')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'ce_pla.id_cierre_planchas', 
                        'ce_so.id_cierre_pl_sobrante',
                        'ce_so.fecha_creado',
                        'ce_so.creado_por',
                        'ce_so.descripcion',
                        'ce_so.referencia',
                        'ce_so.cantidad',
                        'ce_so.ubicacion',
                        'ce_so.observacion',
                        )
                    ->where('ce_so.id_cierre_planchas','=',$id)
                    ->get();
    }

    // public static function OrdenTrabajoSobranteBuscar($IdOrdenTrabajoPlancha)
    // {
    //     return DB::table('cenc_orden_trabajo_planchas AS otplancha')
    //             ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
    //             ->join('cenc_orden_trabajo_sobrante AS ots', 'ots.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
    //             ->select(
    //                 'ot.id_orden_trabajo',
    //                 'ots.id_orden_trabajo_sobrante',
    //                 'ots.descripcion',
    //                 'ots.referencia',
    //                 'ots.cantidad',
    //                 'ots.ubicacion',
    //                 'ots.observacion',
    //                 )
    //             ->where('otplancha.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
    //             ->get();
    // }

    // public static function MostrarMateriaPrimaSobrante($IdOrdenTrabajoPlancha)
    // {
    //     return DB::table('cenc_orden_trabajo_planchas AS otplancha')
    //             ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
    //             ->join('cenc_orden_trabajo_sobrante AS ots', 'ots.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
    //             ->select(
    //                 'ot.id_orden_trabajo',
    //                 'ots.id_orden_trabajo_sobrante',
    //                 'ots.descripcion',
    //                 'ots.referencia',
    //                 'ots.cantidad',
    //                 'ots.ubicacion',
    //                 'ots.observacion',
    //                 )
    //             ->where('otplancha.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
    //             ->get();
    // }

    protected $dateFormat = 'Y-d-m H:i:s';
}
