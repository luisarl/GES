<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sols_ResponsablesModel extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'sols_responsables';
    protected $primaryKey = 'id_responsable';

    protected $fillable = [
        'id_responsable',
        'nombre_responsable',
        'cargo_responsable',
        'correo',
        'estatus',
        'id_departamento',
    ];

    public static function ListaResponsables()
    {
        return DB::table('sols_responsables as s')
                ->join('departamentos as d', 's.id_departamento', '=', 'd.id_departamento')
                ->select(
                    's.id_responsable',
                    's.nombre_responsable',
                    's.cargo_responsable',
                    's.correo',
                    's.estatus',
                    'd.id_departamento',
                    'd.nombre_departamento'
                    )
                ->get();

    }

    public static function ListaResponsablesDepartamento($IdDepartamento)
    {
        return DB::table('sols_responsables as s')
                ->join('departamentos as d', 's.id_departamento', '=', 'd.id_departamento')
                ->select(
                    's.id_responsable',
                    's.nombre_responsable',
                    's.cargo_responsable',
                    's.correo',
                    's.estatus',
                    'd.id_departamento',
                    'd.nombre_departamento'
                    )
                ->where('d.id_departamento', '=', $IdDepartamento)
                ->where('s.estatus', '=', 'SI')
                ->get();

    }

    public static function ResponsablesDepartamentoSolicitud($IdDepartamento, $IdSolicitud)
    {

        $responsables = DB::table('sols_solicitudes_responsables as s')
                                    ->select('id_responsable')
                                    ->where('id_solicitud', '=', $IdSolicitud)
                                    ->get();
            
                    $usuarios = array();
                    foreach ($responsables as $responsable)
                    {
                        $usuarios[] = $responsable->id_responsable;
                    }   

        return DB::table('sols_responsables as r')
                ->join('departamentos as d', 'r.id_departamento', '=', 'd.id_departamento')
                ->select(
                    'r.id_responsable',
                    'r.nombre_responsable',
                    'r.cargo_responsable',
                    'r.correo',
                    'r.estatus',
                    'd.id_departamento',
                    'd.nombre_departamento'
                    )
                    ->where('d.id_departamento', '=', $IdDepartamento)
                    ->where('r.estatus', '=', 'SI')
                    ->whereNotIn('r.id_responsable', $usuarios) //NO INCLUIR USUARIOS ASIGNADOS
                    ->orderBy('r.nombre_responsable')
                ->get();

    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
