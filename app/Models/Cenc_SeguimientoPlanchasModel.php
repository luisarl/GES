<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_SeguimientoPlanchasModel extends Model
{
    use HasFactory;
    protected $table = 'cenc_seguimiento_planchas';
    protected $primaryKey = 'id_seguimiento_plancha';

    protected $fillable = [
        'id_seguimiento_plancha',
        'id_seguimiento',
        'espesor',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';

    
    public static function SeguimientoPlanchaCreate($id)
    {
    return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'otplancha.id_lista_parte')
                    ->join('cenc_conaps AS c', 'c.id_conap', '=', 'ot.id_conap')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'otplancha.tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'otplancha.equipo')
                    ->select(
                        'seg.id_orden_trabajo_plancha',
                        'seg.id_seguimiento', 
                        'seg.created_at',
                        'listap.tipo_lista',
                        'c.nro_conap',
                        'e.nombre_equipo',
                        't.nombre_tecnologia',
                        'seg.estatus',
                        )
                    ->where('seg.id_seguimiento','=',$id)
                    ->first();
    }

    public static function SeguimientoPlanchaEditar($id)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'ot.id_orden_trabajo',
                        'otplancha.id_orden_trabajo_plancha',
                        'ap.id_aprovechamiento', 
                        'ap.id_lista_parte', 
                        'ap.estatus',
                        'seg.estatus',
                        't.nombre_tecnologia',
                        't.id_tecnologia',
                        'listap.tipo_lista',
                        'c.nro_conap',
                        'c.id_conap',
                        'u.name',
                        'aprovpl.espesor',
                        'e.nombre_equipo',
                        'e.id_equipo',
                        'seg.id_seguimiento',
                        'segpl.id_seguimiento_plancha',
                        )
                    ->where('otplancha.id_orden_trabajo_plancha','=',$id)
                    ->first();
    }
    
    public static function BuscarIdOrdenPlancha($id_seguimiento)
    {
        return DB::table('cenc_seguimiento_planchas AS segpl')
            ->select('segpl.id_seguimiento_plancha')
            ->where('segpl.id_seguimiento','=',$id_seguimiento)
            ->first();
    }

    public static function BuscarIdSeguimiento($id_seguimiento_plancha)
    {
        return DB::table('cenc_seguimiento_planchas AS segpl')
            ->select('segpl.id_seguimiento')
            ->where('segpl.id_seguimiento_plancha','=',$id_seguimiento_plancha)
            ->first();
    }
}