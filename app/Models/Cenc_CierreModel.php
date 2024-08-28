<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Cenc_CierreModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_cierre';
    protected $primaryKey = 'id_cierre';

    protected $fillable = [
        'id_cierre',
        'id_seguimiento',
        'fecha_creado',
        'creado_por',
    ];

    public static function Cenc_CierreVer()
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre AS ce', 'ce.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre_planchas AS ce_pla', 'ce_pla.id_cierre', '=', 'ce.id_cierre')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ce.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'ce.id_cierre',
                        'ce.created_at',
                        'ce.fecha_creado',
                        'ce_pla.id_cierre_planchas',
                        'ap.id_lista_parte',
                        'aprovpl.espesor',
                        'u.name',
                        'seg.id_seguimiento',
                        'ot.estatus'
                        )
                    ->get();
    }

    public static function Cenc_CierreBuscar($IdCierrePlancha)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre AS ce', 'ce.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre_planchas AS ce_pla', 'ce_pla.id_cierre', '=', 'ce.id_cierre')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ce.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'ce.id_cierre',
                        'ce.creado_por',
                        'ce.fecha_creado',
                        'ce_pla.id_cierre_planchas',
                        'ap.id_lista_parte',
                        'aprovpl.espesor',
                        'u.name',
                        't.id_tecnologia',
                         'otplancha.consumo_gas'
                        )
                    ->where('ce_pla.id_cierre_planchas','=',$IdCierrePlancha)
                    ->first();
    }

    public static function Cenc_CierreBuscarID($IdCierre)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre AS ce', 'ce.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre_planchas AS ce_pla', 'ce_pla.id_cierre', '=', 'ce.id_cierre')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ce.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'ce.id_cierre',
                        'ce.creado_por',
                        'ce.fecha_creado',
                        'ce_pla.id_cierre_planchas',
                        'ap.id_lista_parte',
                        'aprovpl.espesor',
                        'u.name',
                        't.id_tecnologia',
                        )
                    ->where('ce.id_cierre','=',$IdCierre)
                    ->first();
    }
    

    public static function Cenc_BuscarCierreIdSeguimiento($IdSeguimiento)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre AS ce', 'ce.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_cierre_planchas AS ce_pla', 'ce_pla.id_cierre', '=', 'ce.id_cierre')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ce.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'ce.id_cierre',
                        'ce.creado_por',
                        'ce.fecha_creado',
                        'ce_pla.id_cierre_planchas',
                        'ap.id_lista_parte',
                        'aprovpl.espesor',
                        'u.name',
                        't.id_tecnologia',
                        'seg.id_seguimiento'
                        )
                    ->where('seg.id_seguimiento','=',$IdSeguimiento)
                    ->first();
    }
    

    protected $dateFormat = 'Y-d-m H:i:s';

}
