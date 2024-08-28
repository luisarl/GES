<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Actv_Activos_CaracteristicasModel extends Model
{
    use HasFactory;

    protected $table = 'actv_activos_caracteristicas';
    protected $primaryKey = 'id_activo_caracteristica';

    protected $fillable = [
        'id_activo_caracteristica',
    	'valor_caracteristica',
        'id_activo',
        'id_caracteristica'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function CaracteristicasActivo($IdActivo)
    {
        return DB::table('actv_activos_caracteristicas as ac')
                ->join('actv_activos as a', 'ac.id_activo', '=', 'a.id_activo')
                ->join('actv_caracteristicas as c', 'ac.id_caracteristica', '=', 'c.id_caracteristica')
                ->select(
                    'ac.id_activo_caracteristica',
                    'ac.valor_caracteristica',
                    'ac.id_activo',
                    'a.nombre_activo',
                    'c.id_caracteristica',
                    'c.nombre_caracteristica',
                )
                ->where('ac.id_activo', '=',  $IdActivo)
                ->orderBy('c.nombre_caracteristica')
                ->get();
    }

    public function activo()
    {
        return $this->belongsTo(Actv_ActivosModel::class, 'id_activo');
    }

    public function caracteristica()
    {
        return $this->belongsTo(Actv_CaracteristicasModel::class, 'id_caracteristica');
    }
}
