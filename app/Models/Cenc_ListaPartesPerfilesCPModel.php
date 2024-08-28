<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_ListaPartesPerfilesCPModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_perforaciones_perfiles';
    protected $primaryKey = 'id_perforacion_perfil';

    protected $fillable = [
        'id_perforacion_perfil',
        'id_lperfil',
        'diametro_perforacion',
        't_ala',
        's_alma',
        'cantidad_total'
    ];

    // funcion a utilizar cuando ya se tenga los registros
    public static function ListaPartesPerfilesConPerf()
    {
        return DB::table('cenc_lista_perfiles as lp_per')
                ->join('cenc_perforaciones_perfiles as perf_per', 'lp_per.id_lperfil', '=', 'perf_per.id_lperfil')
                ->select(
                    'lp_per.nro_partes',
                    'lp_per.tipo_perfil',
                    'lp_per.cantidad_piezas',
                    'lp_per.prioridad',
                    'lp_per.dimensiones', 
                    'lp_per.longitud_corte',
                    'lp_per.tipo_corte',
                    'lp_per.id_usuario',
                    'perf_per.id_perforacion_perfil',
                    'perf_per.diametro_perforacion',
                    'perf_per.t_ala',
                    'perf_per.s_alma',
                    'perf_per.cantidad_total'
                    )
                ->get();
    }

    public static function Contador($id) 
    {
        $totalRegistros = DB::table('cenc_perforaciones_perfiles')
        ->where('id_lperfil', $id)
        ->count();

        return $totalRegistros;
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

}
