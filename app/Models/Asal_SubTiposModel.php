<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Asal_SubTiposModel extends Model
{
    use HasFactory;

    protected $table = 'asal_subtipos';
    protected $primaryKey = 'id_subtipo';

    protected $fillable = 
    [
        'id_subtipo',    
        'id_tipo',
        'nombre_subtipo',
        'descripcion_subtipo',
        'activo'
    ];

    public static function ListaSubtipos()
    {
        return DB::table('asal_subtipos AS s')
                ->join('asal_tipos AS t', 't.id_tipo', '=', 's.id_tipo')
                ->select(
                    's.id_subtipo',
                    's.nombre_subtipo',
                    's.descripcion_subtipo',
                    't.nombre_tipo',
                    's.activo'
                )
                ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
