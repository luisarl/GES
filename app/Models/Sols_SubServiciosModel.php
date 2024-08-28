<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sols_SubServiciosModel extends Model
{
    use HasFactory;

    protected $table = 'sols_subservicios';
    protected $primaryKey = 'id_subservicio';

    protected $fillable =  [
        'id_subservicio',
        'nombre_subservicio',
        'descripcion_subservicio',
        'id_servicio'
    ];

    public static function ListaSubServicios()
    {
        return DB::table('sols_subservicios as su')
                ->join('sols_servicios as s', 's.id_servicio', '=', 'su.id_servicio')
                ->join('departamentos as d', 'd.id_departamento', '=', 's.id_departamento')
                ->select(
                    'su.id_subservicio',
                    'su.nombre_subservicio',
                    'su.descripcion_subservicio',
                    's.id_servicio',
                    's.nombre_servicio',
                    'd.id_departamento',
                    'd.nombre_departamento'
                    )
                ->get();
    }

    public static function ListaSubServiciosEdit($IdServicio)
    {
        return DB::table('sols_subservicios as su')
                ->join('sols_servicios as s', 's.id_servicio', '=', 'su.id_servicio')
                ->join('departamentos as d', 'd.id_departamento', '=', 's.id_departamento')
                ->select(
                    'su.id_subservicio',
                    'su.nombre_subservicio',
                    'su.descripcion_subservicio',
                    's.id_servicio',
                    's.nombre_servicio',
                    'd.id_departamento',
                    'd.nombre_departamento'
                    )
                ->where('su.id_servicio', '=', $IdServicio)
                ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

}
