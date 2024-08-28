<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_ConsumiblesModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_consumibles';
    protected $primaryKey = 'id_consumible';

    protected $fillable =  [
        'id_consumible',
        'nombre_consumible',
        'descripcion_consumible',
        'unidad_consumible'
    ];

    public static function ListaConsumibles()
    {
        return DB::table('cenc_consumibles as c')
                ->select(
                    'c.id_consumible',
                    'c.nombre_consumible',
                    'c.descripcion_consumible',
                    'c.unidad_consumible'
                    )
                ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

}
