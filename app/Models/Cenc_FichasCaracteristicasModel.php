<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_FichasCaracteristicasModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_fichas_caracteristicas';
    protected $primaryKey = 'id_caracteristica';

    protected $fillable = [
        'id_caracteristica',
    	'nombre_caracteristica',
        'id_tipo'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ListaCaracteristicas()
    {
        return DB::table('cenc_fichas_caracteristicas as c')
                ->join('cenc_fichas_tipos as t', 't.id_tipo', '=', 'c.id_tipo')
                ->select(
                    'c.id_caracteristica',
                    'c.nombre_caracteristica',
                    'c.id_tipo',
                    't.nombre_tipo'
                )
                ->get();
    }

    //Relacion de con tipos
    public function tipo()
    {
        return $this->belongsTo(Cenc_FichasTiposModel::class, 'id_tipo');
    }
}
