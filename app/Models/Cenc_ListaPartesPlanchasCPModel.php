<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Cenc_ListaPartesPlanchasCPModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_perforaciones_planchas';
    protected $primaryKey = 'id_perforacion_plancha';

    protected $fillable = [
        'id_perforacion_plancha',
        'id_plancha',
        'diametro_perforacion',
        'cantidad_perforacion',
        'cantidad_total'
    ];

    public static function ListaPartesPlanchasConPerf()
    {
        return DB::table('cenc_lista_planchas as lp_pla')
                ->join('cenc_perforaciones_planchas as perf_pla', 'lp_pla.id_lplancha', '=', 'perf_pla.id_plancha')
                ->select(
                    'lp_pla.nro_partes',
                    'lp_pla.descripcion',
                    'lp_pla.prioridad',
                    'lp_pla.dimensiones', 
                    'lp_pla.espesor',
                    'lp_pla.cantidad_piezas',
                    'lp_pla.id_usuario',
                    'perf_pla.id_perforacion_plancha',
                    'perf_pla.diametro_perforacion',
                    'perf_pla.cantidad_perforacion',
                    'perf_pla.cantidad_total'
                    )
                ->get();
    }

    public static function Contador($id) 
    {
        $totalRegistros = DB::table('cenc_perforaciones_planchas')
        ->where('id_plancha', $id)
        ->count();

        return $totalRegistros;
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

}


