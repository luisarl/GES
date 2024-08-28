<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_EquiposTecnologiaModel extends Model
{

    use HasFactory;

    protected $table = 'cenc_equipos_tecnologias';
    protected $primaryKey = 'id_equipotecnologia';

    protected $fillable =  [
        'id_equipotecnologia',
        'id_equipo',
        'id_tecnologia'
    ];

    // muestra las tecnologias asociadas a un equipo para poder editarlas
    public static function TecnologiaEquipo($IdEquipo) 
    {
        return DB::table('cenc_equipos_tecnologias as cet') 
                ->join('cenc_tecnologias as t', 'cet.id_tecnologia', '=', 't.id_tecnologia')
                ->select(
                    't.id_tecnologia',
                    't.nombre_tecnologia',
                )
                ->where('cet.id_equipo', '=', $IdEquipo)
                ->get();
    }

    public static function destroy2($IdTecnologia, $IdEquipo)
    {
        return DB::table('cenc_equipos_tecnologias')
        ->where([
            ['id_equipo', '=', $IdEquipo],
            ['id_tecnologia', '=', $IdTecnologia],
        ])
        ->delete();
    }

    public static function TecnologiaSinEquipo($IdEquipo) // lista de tecnologias no asociadas al equipo
    {
        return DB::table('cenc_tecnologias as t')
            ->select('t.id_tecnologia', 't.nombre_tecnologia')
            ->whereNotIn('t.id_tecnologia', function ($query) use ($IdEquipo) {
                $query->select('id_tecnologia')
                    ->from('cenc_equipos_tecnologias')
                    ->where('id_equipo', '=', $IdEquipo);
            })
            ->get();
    }


        // muestra el id_tecnologia_equipo a partir del id_equipo y el id_tecnologia 
        public static function idEquipoTecnologia($IdEquipo,$IdTecnologia) 
        {
            return DB::table('cenc_equipos_tecnologias as cet') 
                    ->join('cenc_tecnologias as t', 'cet.id_tecnologia', '=', 't.id_tecnologia')
                    ->join('cenc_equipos as e', 'cet.id_equipo', '=', 'e.id_equipo')
                    ->select(
                        'cet.id_equipotecnologia'
                    )
                    ->where('cet.id_equipo', '=', $IdEquipo)
                    ->where('cet.id_tecnologia', '=', $IdTecnologia)
                    ->value('cet.id_equipotecnologia');
        }

        //Muestra el id_equipotecnologia con solo el id del equipo 
        public static function obtenerId($IdEquipo) 
        {
            return DB::table('cenc_equipos_tecnologias as cet') 
                    ->join('cenc_equipos as e', 'cet.id_equipo', '=', 'e.id_equipo')
                    ->select(
                        'cet.id_equipotecnologia'
                    )
                    ->where('cet.id_equipo', '=', $IdEquipo)
                    ->get();
                    //->value('cet.id_equipotecnologia');
        }

    protected $dateFormat = 'Y-d-m H:i:s';
}
