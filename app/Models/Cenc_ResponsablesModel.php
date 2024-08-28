<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_ResponsablesModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_responsables';
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
        return DB::table('cenc_responsables as s')
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

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
