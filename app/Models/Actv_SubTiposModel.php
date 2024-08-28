<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Actv_SubTiposModel extends Model
{
    use HasFactory;

    protected $table = 'actv_subtipos';
    protected $primaryKey = 'id_subtipo';

    protected $fillable = [
        'id_subtipo',
    	'nombre_subtipo',
        'id_tipo'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
    
    public static function ListaSubTipos()
    {
        return DB::table('actv_subtipos as s')
                ->join('actv_tipos as t', 't.id_tipo', '=', 's.id_tipo')
                ->select(
                    's.id_subtipo',
                    's.nombre_subtipo',
                    's.id_tipo',
                    't.nombre_tipo'
                )
                ->get();
    }
    //Relacion de con tipos
    public function tipo()
    {
        return $this->belongsTo(Actv_TiposModel::class, 'id_tipo');
    }
}
