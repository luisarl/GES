<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_EquiposConsumiblesModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_equipos_consumibles';
    protected $primaryKey = 'id_equipo_consumible';

    protected $fillable =  [
        'id_equipo_consumible',
        'id_consumible',
        'id_equipotecnologia'
    ];

        // muestra el id_tecnologia_equipo a partir del id_equipo y el id_tecnologia 
        public static function idEquipoConsumible($IdEquipo,$IdTecnologia) 
        {
            return DB::table('cenc_equipos_consumibles as ce') 
                    ->join('cenc_consumibles as cc', 'ce.id_consumible', '=', 'cc.id_consumible')
                    ->join('cenc_equipos_tecnologias as cet', 'ce.id_equipo_tecnologia', '=', 'cet.id_equipotecnologia')
                    ->select(
                        'ce.id_equipo_consumible'
                    )
                    ->where('ce.id_equipo', '=', $IdEquipo)
                    ->where('ce.id_tecnologia', '=', $IdTecnologia)
                    ->get();
        }

        public static function ObtenerIdEquipo($IdConsumible)
        {
            return DB::table('cenc_equipos_consumibles')
            ->select('id_equipo_consumible')
            ->where('id_consumible', '=', $IdConsumible)
            ->get();
        }

    // public static function ListaConsumibles()
    // {
    //     return DB::table('cenc_consumibles as c')
    //             ->select(
    //                 'c.id_consumible',
    //                 'c.nombre_consumible',
    //                 'c.descripcion_consumible',
    //                 'c.unidad_consumible'
    //                 )
    //             ->get();
    // }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

}
