<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_EquiposModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_equipos';
    protected $primaryKey = 'id_equipo';

    protected $fillable =  [
        'id_equipo',
        'nombre_equipo',
        'descripcion_equipo',
    ];

    public static function ListaEquipos()
    {
        return DB::table('cenc_equipos as c')
                ->select(
                    'c.id_equipo',
                    'c.nombre_equipo',
                    'c.descripcion_equipo',
                    )
                ->get();
    }

    public static function ListaEquiposEdit($IdEquipo) // lista de equipos y tecnologias registradas. 
    {
        return DB::table('cenc_equipos as c')
        ->join('cenc_equipos_tecnologias as cet', 'c.id_equipo', '=', 'cet.id_equipo')
        ->join('cenc_tecnologias as t', 'cet.id_tecnologia', '=', 't.id_tecnologia')
                ->select(
                    'c.id_equipo',
                    'c.nombre_equipo',
                    'c.descripcion_equipo',
                    't.id_tecnologia',
                    't.nombre_tecnologia'
                    )
                ->where('c.id_equipo', '=', $IdEquipo)
                ->get();
    }

    public static function ListaTecnologiaAsociada() // lista de tecnologia asociada al equipo
    {
        return DB::table('cenc_equipos as c') 
        ->join('cenc_equipos_tecnologias as cet', 'c.id_equipo', '=', 'cet.id_equipo')
        ->join('cenc_tecnologias as t', 'cet.id_tecnologia', '=', 't.id_tecnologia')
        ->select(
            'c.id_equipo as id_equipo',
            DB::raw("STRING_AGG(nombre_tecnologia, ', ') as nombres_tecnologias")
        )
        ->groupBy('c.id_equipo')
        ->get(); 
    }


    // MOSTRAR CONSUMIBLES ASOCIADOS A UN EQUIPO 
    public static function ConsumiblesEquipo($IdEquipo) 
    {
        return DB::table('cenc_equipos_consumibles as cec') 
                ->join('cenc_consumibles as cc', 'cec.id_consumible', '=', 'cc.id_consumible')
                ->join('cenc_equipos_tecnologias as cet', 'cec.id_equipotecnologia', '=', 'cet.id_equipotecnologia')
                ->join('cenc_equipos as ce', 'cet.id_equipo', '=', 'ce.id_equipo')
                ->join('cenc_tecnologias as ct', 'cet.id_tecnologia', '=', 'ct.id_tecnologia')
                ->select(
                    'cec.id_equipo_consumible',
                    'cc.nombre_consumible',
                    'cc.unidad_consumible',
                    'ct.nombre_tecnologia',
                    'ct.id_tecnologia',
                    'cc.id_consumible'
                )
                ->where('ce.id_equipo', '=', $IdEquipo)
                ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
