<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cnth_Movimiento_ImagenModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_movimiento_imagen';
    protected $primaryKey = 'id_movimiento_imagen';

    protected $fillable = [
        'id_movimiento_imagen',
    	'id_movimiento',
		'imagen',
        'tipo'
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcion para formateo de la fecha

    public static function CorrelativoImagen($IdMovimiento)
    {
        return DB::table('cnth_movimiento_imagen')
                  ->select(
                    DB::raw("max(SUBSTRING(imagen, CHARINDEX('-', imagen) +1  , 1)) as correlativo_imagen")
                    )
                    ->where('id_movimiento', '=', $IdMovimiento)
                    ->first();  
                    
    }

    public static function ImagenPrincipalRecepcion($IdMovimiento)
    {
        return DB::table('cnth_movimiento_imagen')
                    ->where('id_movimiento', '=', $IdMovimiento)
                    ->min('imagen'); 
                    
    }

    //Relacion de con movimiento
    public function recepciones()
    {
        return $this->hasMany(Cnth_MovimientosModel::class, 'id_movimiento');
    }
}
