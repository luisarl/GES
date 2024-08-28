<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_OrdenTrabajoModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_orden_trabajo';
    protected $primaryKey = 'id_orden_trabajo';

    protected $fillable = [
        'id_orden_trabajo',
        'id_conap',
        'estatus',
        'observaciones',
        'fecha_inicio',
        'fecha_fin',
        'fecha_creado',
        'creado_por',
        'fecha_aceptado',
        'aceptado_por',
        'fecha_enproceso',
        'enproceso_por',
        'fecha_anulado',
        'anulado_por',
        'fecha_finalizado',
        'finalizado_por',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';

    public static function OrdenesTrabajos()
    {
        return DB::table('cenc_orden_trabajo AS ot')
                ->join('cenc_conaps as c', 'c.id_conap', '=', 'ot.id_conap')
                ->join('users AS u', 'ot.creado_por', '=', 'u.id')
                ->select(
                    'ot.id_orden_trabajo',
                    'ot.fecha_creado',
                    'ot.id_conap',
                    'ot.estatus',
                    'u.name',
                    'c.nro_conap'
                    )
                ->get();
    }


    public static function MostrarOrdenTrabajoEditar($IdOrdenTrabajo)
    {
        return  DB::table('cenc_orden_trabajo as ot')
        ->join('cenc_orden_trabajo_planchas as otp', 'otp.id_orden_trabajo', '=', 'ot.id_orden_trabajo')
        ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otp.id_aprovechamiento')
        ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
        ->join('cenc_conaps as c', 'c.id_conap', '=', 'ot.id_conap')
        ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'otp.tecnologia')
        ->join('cenc_equipos as e', 'e.id_equipo', '=', 'otp.equipo')
        ->join('users AS u', 'ot.creado_por', '=', 'u.id')
         ->select(
            'ot.id_orden_trabajo',
            'ot.created_at',
            'ot.estatus',
            'ot.id_conap',

            'otp.id_aprovechamiento',
            'otp.id_lista_parte',
            'otp.id_orden_trabajo_plancha',
            'ot.fecha_inicio',
            'ot.fecha_fin',
            'ot.observaciones',
            'ot.fecha_creado',
            'otp.equipo',
            'otp.tecnologia',
            'otp.tiempo_estimado',
            'otp.consumo_oxigeno',
            'otp.consumo_gas',
        
            'c.nro_conap',
            'c.nombre_conap',
            'c.descripcion_conap',

            'u.name',

            'e.nombre_equipo',
            't.nombre_tecnologia',

            'aprovpl.espesor'
        )
        ->where('ot.id_orden_trabajo','=',$IdOrdenTrabajo)
        ->first(); 
    }

    
    public static function  MostrarOrdenTrabajoConap($IdOrdenTrabajo)
    {
        return  DB::table('cenc_seguimiento as seg')
        ->join('cenc_orden_trabajo_planchas as otp', 'otp.id_orden_trabajo_plancha', '=', 'seg.id_orden_trabajo_plancha')
        ->join('cenc_orden_trabajo as ot', 'ot.id_orden_trabajo', '=', 'otp.id_orden_trabajo')
        ->join('cenc_aprovechamientos as aprov', 'aprov.id_aprovechamiento', '=', 'otp.id_aprovechamiento')
        ->join('cenc_aprovechamiento_planchas as aprov_pl', 'aprov_pl.id_aprovechamiento_plancha', '=', 'aprov.id_aprovechamiento')
        ->join('cenc_lista_partes as listap', 'listap.id_lista_parte', '=', 'aprov.id_lista_parte')
        ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'otp.tecnologia')
        ->join('cenc_equipos as e', 'e.id_equipo', '=', 'otp.equipo')
        ->select(
            'otp.id_orden_trabajo_plancha',
            'otp.id_aprovechamiento', 
            'otp.id_lista_parte', 
            'listap.tipo_lista', 
            'e.nombre_equipo', 
            't.nombre_tecnologia',
            'aprov_pl.espesor',
            'seg.estatus',
            'ot.id_orden_trabajo'
        )
        ->where('otp.id_orden_trabajo','=',$IdOrdenTrabajo)
        ->get();
    }

    public static function BuscarConapOrdenTrabajo($IdConap){
        return DB::table('cenc_orden_trabajo as ot')
        ->select(
            'ot.id_conap',
            'ot.estatus',
            'ot.id_orden_trabajo'
            )
        ->where('ot.id_conap','=',$IdConap)
        ->first();
    }

    // public static function BuscarOrdenTrabajoConap($IdConap){
    //     return DB::table('cenc_orden_trabajo as ot')
    //     ->join('cenc_orden_trabajo_planchas as otp', 'otp.id_orden_trabajo', '=', 'ot.id_orden_trabajo')

    //     ->select(
    //         'ot.id_orden_trabajo',
    //         'otp.id_orden_trabajo_plancha',
    //         'ot.estatus'
    //         )
    //     ->where('ot.id_conap','=',$IdConap)
    //     ->first();
    // }

    public static function BuscarOrdenTrabajoConIdSeguimiento($IdSeguimiento)
    {
        return  DB::table('cenc_seguimiento as seg')
        ->join('cenc_orden_trabajo_planchas as otp', 'otp.id_orden_trabajo_plancha', '=', 'seg.id_orden_trabajo_plancha')
        ->join('cenc_orden_trabajo as ot', 'ot.id_orden_trabajo', '=', 'otp.id_orden_trabajo')
        ->select(
            'ot.id_orden_trabajo',
            'seg.estatus'
        )
        ->where('seg.id_seguimiento','=',$IdSeguimiento)
        ->get();
    }

    public static function BuscarOrdenTrabajoPlanchaSeguimiento($IdOrdenTrabajoPlancha){
        return DB::table('cenc_seguimiento as seg')
        ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
        ->select(
            'seg.id_orden_trabajo_plancha'     
            )
        ->where('seg.id_orden_trabajo_plancha','=',$IdOrdenTrabajoPlancha)
        ->get();
    }

    public static function MostrarEstimadosAsociadaAOrdenTrabajo($IdOrdenTrabajo)
    {
        return  DB::table('cenc_orden_trabajo as ot')
                ->join('cenc_orden_trabajo_planchas as otp', 'otp.id_orden_trabajo', '=', 'ot.id_orden_trabajo')
                ->join('cenc_aprovechamientos as aprov', 'aprov.id_aprovechamiento', '=', 'otp.id_aprovechamiento')
                ->join('cenc_aprovechamiento_planchas as aprov_pl', 'aprov_pl.id_aprovechamiento_plancha', '=', 'aprov.id_aprovechamiento')
                ->join('cenc_seguimiento as seg', 'seg.id_orden_trabajo_plancha', '=', 'otP.id_orden_trabajo_plancha')
                ->select(
                    'ot.id_orden_trabajo',
                    'aprov_pl.espesor',
                    'otp.id_orden_trabajo_plancha',
                    'otp.tiempo_estimado',
                    'otp.consumo_oxigeno',
                    'otp.consumo_gas',
                )
                ->where('otp.id_orden_trabajo','=',$IdOrdenTrabajo)
                ->where('seg.estatus','=','FINALIZADO')
                ->get();
    }

    public static function ConsumoGas($IdOrdenTrabajo)
    {
        return  DB::table('cenc_orden_trabajo as ot')
                ->join('cenc_orden_trabajo_planchas as otp', 'otp.id_orden_trabajo', '=', 'ot.id_orden_trabajo')
                ->select(
                    'otp.consumo_gas',
                )
                ->where('otp.id_orden_trabajo','=',$IdOrdenTrabajo)
                ->get();
    }

    public static function BuscarIdOrdenTrabajoPlancha($IdOrdenTrabajo)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otp')
            ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otp.id_orden_trabajo')                                     
            ->select(
                'otp.id_orden_trabajo_plancha')
            ->where('ot.id_orden_trabajo','=',$IdOrdenTrabajo)
            ->get();
    }

    public static function BuscarIdAprovechamientosPlanchas($IdOrdenTrabajo)
    {
        return DB::table('cenc_aprovechamiento_planchas_materia_prima as aprov_mp')
        ->join ('cenc_aprovechamiento_planchas as aprovpl','aprovpl.id_aprovechamiento_plancha', '=','aprov_mp.id_aprovechamiento_plancha')
        ->join ('cenc_aprovechamientos as aprov','aprov.id_aprovechamiento', '=','aprovpl.id_aprovechamiento')
        ->join ('cenc_orden_trabajo_planchas as otp', 'otp.id_aprovechamiento', '=', 'aprov.id_aprovechamiento')
        ->select(
            'aprov_mp.id_aprovechamiento_plancha'
        )
        ->where('otp.id_orden_trabajo','=',$IdOrdenTrabajo)
        ->groupBy('aprov_mp.id_aprovechamiento_plancha')
        ->get();
    }

    public static function ObtenerMateriasPrimasAprovechamiento($IdAprovechamientosPlanchas)
    {
        return DB::table('cenc_aprovechamiento_planchas_materia_prima as aprov_mp')
        ->join ('cenc_aprovechamiento_planchas as aprovpl','aprovpl.id_aprovechamiento_plancha', '=','aprov_mp.id_aprovechamiento_plancha')
        ->join ('cenc_aprovechamientos as aprov','aprov.id_aprovechamiento', '=','aprovpl.id_aprovechamiento')
        ->join ('cenc_lista_partes as lp','lp.id_lista_parte', '=','aprov.id_lista_parte')
        ->join('cenc_orden_trabajo_planchas as otp', 'otp.id_aprovechamiento', '=', 'aprov.id_aprovechamiento')
        ->join('cenc_seguimiento as seg', 'seg.id_orden_trabajo_plancha', '=', 'otp.id_orden_trabajo_plancha')
        ->select(
            'aprov_mp.id_materia_prima',
            'aprov_mp.codigo_materia',
            'aprov_mp.dimensiones',
            'aprov_mp.cantidad',
            'aprov_mp.peso_unit',
            'aprov_mp.peso_total',
            'aprov_mp.id_aprovechamiento_plancha',
            'lp.tipo_lista',
            'seg.estatus',
            'aprovpl.espesor'
        )
        ->where('aprovpl.id_aprovechamiento_plancha','=',$IdAprovechamientosPlanchas)
        ->where('seg.estatus','=', 'FINALIZADO')
        ->get();
    }


    public static function ObtenerAreaCorteAprovechamiento($IdAprovechamientosPlanchas)
    {
        return DB::table('cenc_aprovechamiento_planchas_area_corte as aprov_ac')
            ->join ('cenc_aprovechamiento_planchas as aprovpl','aprovpl.id_aprovechamiento_plancha', '=','aprov_ac.id_aprovechamiento_plancha')
            ->join ('cenc_aprovechamientos as aprov','aprov.id_aprovechamiento', '=','aprovpl.id_aprovechamiento')
            ->join ('cenc_lista_partes as lp','lp.id_lista_parte', '=','aprov.id_lista_parte')
            ->join('cenc_orden_trabajo_planchas as otp', 'otp.id_aprovechamiento', '=', 'aprov.id_aprovechamiento')
            ->join('cenc_seguimiento as seg', 'seg.id_orden_trabajo_plancha', '=', 'otp.id_orden_trabajo_plancha')
            ->select(
                'aprov_ac.id_area_corte',
                'aprov_ac.dimensiones',
                'aprov_ac.cantidad',
                'aprov_ac.peso_unit',
                'aprov_ac.peso_total',
                'aprov_ac.id_aprovechamiento_plancha',
                'lp.tipo_lista',
                'seg.estatus',
                'aprovpl.espesor'
            )
            ->where('aprovpl.id_aprovechamiento_plancha','=',$IdAprovechamientosPlanchas)
            ->where('seg.estatus','=', 'FINALIZADO')
            ->get();
    }

    public static function Cenc_DatosSeguimientoPlanchaHorometro($IdOrdenTrabajo)
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
                        'ot.id_orden_trabajo',
                        'segpl_h.id_seguimiento_plancha',
                        'segpl_h.horas_on',
                        'segpl_h.tiempo_aut',
                        'segpl.espesor',
                        'e.nombre_equipo',
                        't.nombre_tecnologia',
                        'ap.id_aprovechamiento',
                        'listap.id_lista_parte',
                        'seg.id_seguimiento'
                        )
                    ->where('ot.id_orden_trabajo','=',$IdOrdenTrabajo)
                    ->where('seg.estatus','=', 'FINALIZADO')
                    ->get();
    }

    public static function Cenc_DatosSeguimientoPlanchaAvance($IdOrdenTrabajo)
    {
        return DB::table('cenc_orden_trabajo AS ot')
                    ->join('cenc_orden_trabajo_planchas as otplancha', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_avance AS segpl_a', 'segpl_a.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha')
                    ->select(
                        'ot.id_orden_trabajo',
                        'otplancha.id_aprovechamiento',
                        'segpl_a.id_seguimiento_plancha',
                        'segpl_a.nro_partes',
                        'segpl_a.descripcion',
                        'segpl_a.avance_cant_piezas',
                        'segpl_a.avance_peso',
                        'segpl.espesor'
                        )
                    ->where('ot.id_orden_trabajo','=',$IdOrdenTrabajo)
                    ->where('seg.estatus','=', 'FINALIZADO')
                    ->get();
    }

    public static function BuscarIdSeguimiento($IdOrdenTrabajoPlancha)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otp')
            ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otp.id_orden_trabajo')
            ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otp.id_orden_trabajo_plancha')
            ->select(
                'seg.id_seguimiento',
                'seg.estatus',
                'otp.id_aprovechamiento'
                )
            ->where('otp.id_orden_trabajo','=',$IdOrdenTrabajoPlancha)
            ->get();
    }

    public static function Cenc_DatosCierrePlanchaCortes($IdOrdenTrabajo)
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
                        'ce_c.fecha_creado',
                        'aprovpl.espesor'
                        )
                    ->where('ot.id_orden_trabajo','=',$IdOrdenTrabajo)
                    ->where('seg.estatus','=', 'FINALIZADO')
                    ->get();
    }

    public static function Cenc_DatosCierrePlanchaSobrante($IdOrdenTrabajo)
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
                        'aprovpl.espesor'
                        )
                    ->where('ot.id_orden_trabajo','=',$IdOrdenTrabajo)
                    ->where('seg.estatus','=', 'FINALIZADO')
                    ->get();
    }

    public static function Cenc_DatosSeguimientoPlanchaConsumibles($IdOrdenTrabajo)
    {
        return DB::table('cenc_orden_trabajo_planchas AS otplancha')
                    ->join('cenc_orden_trabajo AS ot', 'ot.id_orden_trabajo', '=', 'otplancha.id_orden_trabajo')
                    ->join('cenc_aprovechamientos AS ap', 'ap.id_aprovechamiento', '=', 'otplancha.id_aprovechamiento')
                    ->join('cenc_seguimiento AS seg', 'seg.id_orden_trabajo_plancha', '=', 'otplancha.id_orden_trabajo_plancha')
                    ->join('cenc_seguimiento_planchas AS segpl', 'segpl.id_seguimiento', '=', 'seg.id_seguimiento')
                    ->join('cenc_seguimiento_plancha_consumibles AS segpl_c', 'segpl_c.id_seguimiento_plancha', '=', 'segpl.id_seguimiento_plancha') 
                    ->join('cenc_lista_partes AS listap', 'listap.id_lista_parte', '=', 'ap.id_lista_parte')
                    ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                    ->join('users AS u', 'ap.creado_por', '=', 'u.id')
                    ->join('cenc_aprovechamiento_planchas as aprovpl', 'aprovpl.id_aprovechamiento', '=', 'ap.id_aprovechamiento')
                    ->join('cenc_tecnologias as t', 't.id_tecnologia', '=', 'aprovpl.nombre_tecnologia')
                    ->join('cenc_equipos as e', 'e.id_equipo', '=', 'aprovpl.nombre_equipo')
                    ->select(
                        'ot.id_orden_trabajo',
                        'segpl_c.consumible',
                        'segpl_c.consumo',
                        'segpl_c.unidad',
                        'segpl_c.observaciones',
                        'aprovpl.espesor'
                        )
                    ->where('ot.id_orden_trabajo','=',$IdOrdenTrabajo)
                    ->where('seg.estatus','=', 'FINALIZADO')
                    ->get();
    }

    public static function BuscarSiOrdenTieneCierre($IdOrdenTrabajo)
    {
        return  DB::table('cenc_orden_trabajo as ot')
                ->join('cenc_orden_trabajo_planchas as otp', 'otp.id_orden_trabajo', '=', 'ot.id_orden_trabajo')
                ->join('cenc_seguimiento as seg', 'seg.id_orden_trabajo_plancha', '=', 'otP.id_orden_trabajo_plancha')
                ->join('cenc_cierre as ce', 'ce.id_seguimiento', '=', 'seg.id_seguimiento')
                ->select(
                    'ot.id_orden_trabajo',
                    'otp.id_orden_trabajo_plancha',
                    'seg.id_seguimiento',
                    'ce.id_cierre'
                )
                ->where('otp.id_orden_trabajo','=',$IdOrdenTrabajo)
                ->get();
    }

    public static function UsuarioOrdenTrabajoAceptadoPor($IdOrdenTrabajo)
    {
        return DB::table('cenc_orden_trabajo as ot')
                ->join('users AS u', 'ot.aceptado_por', '=', 'u.id')
                ->select(
                    'ot.id_orden_trabajo',
                    'ot.aceptado_por',
                    'ot.fecha_aceptado',
                    'u.name',
                    )
                ->where('ot.id_orden_trabajo','=',$IdOrdenTrabajo)
                ->first();
    }

    public static function UsuarioOrdenTrabajoEnProcesoPor($IdOrdenTrabajo)
    {
        return DB::table('cenc_orden_trabajo as ot')
                ->join('users AS u', 'ot.enproceso_por', '=', 'u.id')
                ->select(
                    'ot.enproceso_por',
                    'ot.fecha_enproceso',
                    'u.name',
                    )
                ->where('ot.id_orden_trabajo','=',$IdOrdenTrabajo)
                ->first();
    }

    public static function UsuarioOrdenTrabajoFinalizadoPor($IdOrdenTrabajo)
    {
        return DB::table('cenc_orden_trabajo as ot')
                ->join('users AS u', 'ot.finalizado_por', '=', 'u.id')
                ->select(
                    'ot.finalizado_por',
                    'ot.fecha_finalizado',
                    'u.name',
                    )
                ->where('ot.id_orden_trabajo','=',$IdOrdenTrabajo)
                ->first();
    }
}