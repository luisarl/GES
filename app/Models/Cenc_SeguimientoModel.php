<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_SeguimientoModel extends Model
{
    use HasFactory;
    protected $table = 'cenc_seguimiento';
    protected $primaryKey = 'id_seguimiento';

    protected $fillable = [
        'id_seguimiento',
        'id_orden_trabajo_plancha',
        'estatus',
        'enproceso_por',
        'fecha_enproceso',
        'anulado_por',
        'fecha_anulado',
        'finalizado_por',
        'fecha_finalizado',
        'fecha_creado',
        'creado_por',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';

    public static function Cenc_SeguimientosVer()
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
                    ->get();
    }

    public static function Cenc_SeguimientosDatosBuscar($IdSeguimiento)
    {
        return DB::table('cenc_seguimiento AS seg')
                    ->select(
                        'seg.id_orden_trabajo_plancha',
                        )
                    ->where('seg.id_seguimiento','=',$IdSeguimiento)
                    ->first();
    }

    public static function Cenc_SeguimientosBuscar($IdSeguimiento)
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
                        'seg.id_orden_trabajo_plancha',
                        'seg.id_seguimiento',
                        'segpl.id_seguimiento_plancha',
                        'seg.created_at',
                        'listap.tipo_lista',
                        'c.nro_conap',
                        'e.nombre_equipo',
                        't.nombre_tecnologia',
                        'seg.estatus',
                        'ot.id_orden_trabajo'
                        )
                    ->where('seg.id_seguimiento','=',$IdSeguimiento)
                    ->first();
    }

    public static function MostrarOrdenTrabajoSeguimiento($IdOrdenTrabajoPlancha)
    {
        return  DB::table('cenc_orden_trabajo_planchas as otp')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otp.id_orden_trabajo')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otp.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'otp.tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'otp.equipo')
                    ->join('cenc_lista_partes as listap', 'listap.id_lista_parte', '=', 'otp.id_lista_parte')
                    ->join('users AS u', 'u.id', '=', 'seg.creado_por')
                    ->join('cenc_conaps AS c', 'c.id_conap', '=', 'ot.id_conap')
                    ->select(
                        'otp.id_lista_parte',
                        'otp.equipo',
                        'otp.tecnologia',
                        'otp.id_aprovechamiento',
                        'ot.id_orden_trabajo',
                        'seg.id_seguimiento',
                        'seg.estatus',
                        'segpl.espesor',
                        'e.nombre_equipo',
                        't.nombre_tecnologia',
                        'listap.tipo_lista',
                        'seg.created_at',
                        'u.name',
                        'c.nro_conap'
                    )
                    ->where('otp.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
                    ->first(); 
    }

    public static function ListaNumeroPartes($IdListaParte, $Espesor)
    {
        return DB::table('cenc_lista_planchas as lp_pla')
                 ->select(
                    'lp_pla.id_lplancha',
                    'lp_pla.id_lista_parte',
                    'lp_pla.nro_partes',
                    'lp_pla.descripcion',
                    'lp_pla.prioridad',
                    'lp_pla.dimensiones',
                    'lp_pla.espesor',
                    'lp_pla.cantidad_piezas',
                    'lp_pla.peso_unit',
                    'lp_pla.peso_total'
                    )
                ->where('lp_pla.id_lista_parte', '=', $IdListaParte)
                ->where('lp_pla.espesor', '=', $Espesor)
                ->get();
    }

        
    public static function InformacionNumeroParte($IdListaParte, $IdListaPartePlancha)
    {
        return DB::table('cenc_lista_planchas as lp_pla')
                 ->select(
                    'lp_pla.id_lplancha',
                    'lp_pla.id_lista_parte',
                    'lp_pla.nro_partes',
                    'lp_pla.descripcion',
                    'lp_pla.prioridad',
                    'lp_pla.dimensiones',
                    'lp_pla.espesor',
                    'lp_pla.cantidad_piezas',
                    'lp_pla.peso_unit',
                    'lp_pla.peso_total'
                    )
                ->where('lp_pla.id_lista_parte', '=', $IdListaParte)
                ->where('lp_pla.id_lplancha', '=', $IdListaPartePlancha)
                ->get();
    }

    public static function BuscarIdSeguimiento($IdOrdenTrabajoPlancha)
    {
        return DB::table('cenc_seguimiento AS seg')
            ->select(
                'seg.id_seguimiento',
                'seg.estatus')
            ->where('seg.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
            ->first();
    }

    public static function BuscarOrdenTrabajoSeguimiento($IdOrdenTrabajoPlancha)
    {
        return DB::table('cenc_orden_trabajo as ot')
                ->join('cenc_orden_trabajo_planchas as otp', 'otp.id_orden_trabajo', '=', 'ot.id_orden_trabajo')
                ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otp.id_orden_trabajo_plancha')
                ->select(
                    'ot.id_orden_trabajo',
                    'otp.id_orden_trabajo_plancha',
                    'seg.id_seguimiento'
                    )
                ->where('seg.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
                ->first();
    }

}