<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_ListaPartesPerfilesModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_lista_perfiles';
    protected $primaryKey = 'id_lperfil';

    protected $fillable = [
        'id_lperfil',
        'id_lista_parte',
        'id_ficha',
        'nro_partes',
        'cantidad_piezas',
        'prioridad',
        'longitud_pieza',
        'tipo_corte',
        'creado_por',
        'fecha_creado',
        'peso_unit',
        'peso_total'
    ];

    // funcion a utilizar cuando ya se tenga los registros
    public static function ListaPartesPerfiles() 
    {
        return DB::table('cenc_lista_partes as listap')
                ->join('cenc_lista_perfiles as lp_per', 'listap.id_lista_parte', '=', 'lp_per.id_lista_parte')
                ->select(
                    'lp_per.id_lperfil',
                    'lp_per.id_lista_parte',
                    'lp_per.id_ficha',
                    'lp_per.nro_partes',
                    'lp_per.tipo_perfil',
                    'lp_per.cantidad_piezas',
                    'lp_per.prioridad',
                    'lp_per.longitud_pieza',
                    'lp_per.tipo_corte',
                    'lp_per.creado_por',
                    'lp_per.peso_unit',
                    'lp_per.peso_total'
                    )
                ->get();
    }


    public static function ListaPartesPerfilesID($IdListaParte)
    {
        return DB::table('cenc_lista_partes as listap')
                ->join('cenc_lista_perfiles as lp_perf', 'lp_perf.id_lista_parte', '=', 'listap.id_lista_parte')
                ->join('cenc_perforaciones_perfiles AS perf_per', 'perf_per.id_lperfil', '=', 'lp_perf.id_lperfil')
                ->join('cenc_fichas as c_ficha', 'lp_perf.id_ficha', '=', 'c_ficha.id_ficha')
                ->join('cenc_conaps as c', 'listap.nro_conap', '=', 'c.id_conap')
                ->select(
                    'listap.id_lista_parte',
                    'listap.nro_conap',
                    'listap.created_at',
                    'listap.tipo_lista',
                    'listap.observaciones',
                    'lp_perf.nro_partes',
                    'lp_perf.id_ficha',
                    'c_ficha.nombre_ficha',
                    'lp_perf.id_lperfil',
                    'lp_perf.cantidad_piezas',
                    'lp_perf.prioridad',
                    'lp_perf.longitud_pieza',
                    'lp_perf.tipo_corte',
                    'lp_perf.peso_unit',
                    'lp_perf.peso_total',
                    'perf_per.id_perforacion_perfil',
                    'perf_per.diametro_perforacion',
                    'perf_per.t_ala',
                    'perf_per.s_alma',
                    'perf_per.cantidad_total',
                    'c.nro_conap'
                    )
                ->where('listap.id_lista_parte', '=', $IdListaParte)
                ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
