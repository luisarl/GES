<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sols_ServiciosModel extends Model
{
    use HasFactory;

    protected $table = 'sols_servicios';
    protected $primaryKey = 'id_servicio';

    protected $fillable =  [
        'id_servicio',
        'nombre_servicio',
        'descripcion_servicio',
        'id_departamento'
    ];

    public static function ListaServicios()
    {
        return DB::table('sols_servicios as s')
                ->join('departamentos as d', 's.id_departamento', '=', 'd.id_departamento')
                ->select(
                    's.id_servicio',
                    's.nombre_servicio',
                    's.descripcion_servicio',
                    'd.id_departamento',
                    'd.nombre_departamento'
                    )
                ->get();
    }

    public static function ListaServiciosEdit($IdDepartamento)
    {
        return DB::table('sols_servicios as s')
                ->join('departamentos as d', 's.id_departamento', '=', 'd.id_departamento')
                ->select(
                    's.id_servicio',
                    's.nombre_servicio',
                    's.descripcion_servicio',
                    'd.id_departamento',
                    'd.nombre_departamento'
                    )
                ->where('s.id_departamento', '=', $IdDepartamento)
                ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha


}
