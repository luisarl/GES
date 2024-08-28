<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Cenc_ListaPartesPlanchasModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_lista_planchas';
    protected $primaryKey = 'id_lplancha';

    protected $fillable = [
        'id_lplancha',
        'id_lista_parte',
        'nro_partes',
        'descripcion',
        'prioridad',
        'dimensiones',
        'espesor',
        'cantidad_piezas',
        'creado_por',
        'fecha_creado',
        'peso_unit',
        'peso_total'
    ];

    public static function ListaPartesPlanchas()
    {
        return DB::table('cenc_lista_partes as lpp')
                ->join('cenc_lista_planchas as lp_pla', 'lpp.id_lista_parte', '=', 'lp_pla.id_lista_parte')
                ->select(
                    'lp_pla.id_lplancha',
                    'lp_pla.id_lista_parte',
                    'lp_pla.nro_partes',
                    'lp_pla.descripcion',
                    'lp_pla.prioridad',
                    'lp_pla.dimensiones', 
                    'lp_pla.espesor',
                    'lp_pla.peso_unit',
                    'lp_pla.peso_total',
                    'lp_pla.creado_por'
                    )
                ->get();
    }

    public static function ListaPartesPlanchasID($IdListaParte)
    {
        return DB::table('cenc_lista_partes as listap')
                ->join('cenc_lista_planchas as lp_pla', 'lp_pla.id_lista_parte', '=', 'listap.id_lista_parte')
                ->join('cenc_perforaciones_planchas AS perf_pla', 'perf_pla.id_plancha', '=', 'lp_pla.id_lplancha')
                ->join('cenc_conaps as c', 'listap.nro_conap', '=', 'c.id_conap')
                ->select(
                    'listap.id_lista_parte',
                    'listap.nro_conap',
                    'listap.created_at',
                    'listap.tipo_lista',
                    'lp_pla.id_lplancha',
                    'lp_pla.nro_partes',
                    'lp_pla.descripcion',
                    'lp_pla.prioridad',
                    'lp_pla.dimensiones',
                    'lp_pla.espesor',
                    'lp_pla.cantidad_piezas',
                    'lp_pla.peso_unit',
                    'lp_pla.peso_total',
                    'perf_pla.id_perforacion_plancha',
                    'perf_pla.diametro_perforacion',
                    'perf_pla.cantidad_perforacion',
                    'perf_pla.cantidad_total',
                    'c.nro_conap',
                    'listap.observaciones'
                    )
                ->where('listap.id_lista_parte', '=', $IdListaParte)
                ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}


