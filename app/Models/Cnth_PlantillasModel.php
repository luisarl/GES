<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cnth_PlantillasModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_plantillas';
    protected $primaryKey = 'id_plantilla';

    protected $fillable = [
        'id_plantilla',
    	'nombre_plantilla',
		'descripcion_plantilla',
        'id_almacen'
    ];

    public static function ListaPlantillas($IdUsuario)
    {
        return DB::table('cnth_plantillas as p')
                ->join('almacenes as a', 'p.id_almacen', '=', 'a.id_almacen')
                ->join('almacen_usuario as au', 'au.id_almacen', '=', 'a.id_almacen')
                ->select(
                    'p.id_plantilla',
                    'p.nombre_plantilla',
                    'p.descripcion_plantilla',
                    'a.nombre_almacen'
                    )
                ->where('au.id', '=', $IdUsuario)
                ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
