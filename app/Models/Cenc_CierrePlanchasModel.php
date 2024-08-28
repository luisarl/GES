<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Cenc_CierrePlanchasModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_cierre_planchas';
    protected $primaryKey = 'id_cierre_planchas';

    protected $fillable = [
        'id_cierre_planchas',
        'id_cierre',
    ];

    public static function cenc_CierrePlanchaEditar($IdCierrePlancha)
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
                            'ot.id_orden_trabajo',
                            'otplancha.id_orden_trabajo_plancha',
                            'ap.id_aprovechamiento', 
                            'ap.id_lista_parte',
                            'seg.estatus',
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
                            'seg.id_seguimiento',
                            'segpl.id_seguimiento_plancha',
                            'ce.id_cierre',
                            'ce_pla.id_cierre_planchas',
                            'ce.creado_por',
                            'ce.fecha_creado',
                            'ce_pla.created_at',
                            'otplancha.consumo_gas'
                        )
                    ->where('ce_pla.id_cierre_planchas','=',$IdCierrePlancha)
                    ->first();
    }

    protected $dateFormat = 'Y-d-m H:i:s';

}
