<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Articulo_ImagenModel extends Model
{
    use HasFactory;

    protected $table = 'articulo_imagen';
    protected $primaryKey = 'id_articulo_imagen';

    protected $fillable = [
        'id_articulo_imagen',
    	'id_articulo',
		'imagen'
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcion para formateo de la fecha

    public static function CorrelativoImagen($IdArticulo)
    {
        return DB::table('articulo_imagen')
                  ->select(
                    DB::raw("max(SUBSTRING(imagen, CHARINDEX('-', imagen) +1  , 1)) as correlativo_imagen")
                    )
                    ->where('id_articulo', '=', $IdArticulo)
                    ->first();  
                    
    }

    public static function ImagenPrincipalArticulo($IdArticulo)
    {
        return DB::table('articulo_imagen')
                    ->where('id_articulo', '=', $IdArticulo)
                    ->min('imagen'); 
                    
    }

    //Relacion de con articulo
    public function articulos()
    {
        return $this->hasMany(ArticulosModel::class, 'id_articulo');
    }
}
