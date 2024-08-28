<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_FichasCaracteristicasValoresModel extends Model
{
    use HasFactory;
   
    protected $table = 'cenc_fichas_valores_caracteristicas';
    protected $primaryKey = 'id_ficha_valor';

    protected $fillable = [
        'id_ficha_valor',
        'id_ficha',
        'id_caracteristica',
        'valor_caracteristica',
    	'nombre_caracteristica'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ListaValores($Idficha)
    {
        return DB::table('cenc_fichas as c')
                ->join('cenc_fichas_valores_caracteristicas as cv', 'c.id_ficha', '=', 'cv.id_ficha')
                ->join('cenc_fichas_caracteristicas as cc', 'cv.id_caracteristica', '=', 'cc.id_caracteristica')
                ->select(
                    'cv.id_ficha_valor',
                    'cv.id_caracteristica',
                    'cc.nombre_caracteristica',
                    'cv.valor_caracteristica'
                )
                ->where('cv.id_ficha','=',$Idficha)
                ->get();
    }

    //Relacion de con tipos
    // public function tipo()
    // {
    //     return $this->belongsTo(Cenc_FichasTiposModel::class, 'id_tipo');
    // }
}
