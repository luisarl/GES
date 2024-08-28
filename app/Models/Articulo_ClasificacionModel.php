<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Articulo_ClasificacionModel extends Model
{
    use HasFactory;

    protected $table = 'articulo_clasificacion';
    protected $primaryKey = 'id_articulo_clasificacion';

    protected $fillable = [
        'id_articulo_clasificacion',
    	'id_articulo',
		'id_clasificacion',
        'id_subclasificacion',
        'valor',
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcion para formateo de la fecha

    public static function DatosAdicionales($IdArticulo)
    {
        return DB::table('articulo_clasificacion as a')
                ->join('clasificaciones as b', 'b.id_clasificacion', '=', 'a.id_clasificacion')
                ->join('subclasificaciones as c', 'c.id_subclasificacion', '=', 'a.id_subclasificacion')
                ->select(
                    'a.id_articulo_clasificacion',
                    'a.id_articulo',
                    'b.id_clasificacion',
                    'b.nombre_clasificacion',
                    'c.id_subclasificacion',
                    'c.nombre_subclasificacion',
                    'a.valor'
                )
                ->where('a.id_articulo', '=',  $IdArticulo)
                ->orderBy('b.nombre_clasificacion')
                ->get();
    }

    public static function DatosAdicionalesPDF($IdArticulo)
    {
        return DB::table('articulo_clasificacion as a')
                ->join('clasificaciones as b', 'b.id_clasificacion', '=', 'a.id_clasificacion')
                ->join('subclasificaciones as c', 'c.id_subclasificacion', '=', 'a.id_subclasificacion')
                ->select(
                    'a.id_articulo_clasificacion',
                    'a.id_articulo',
                    'b.id_clasificacion',
                    'b.nombre_clasificacion',
                    'c.id_subclasificacion',
                    'c.nombre_subclasificacion',
                    'a.valor'
                )
                ->where('a.id_articulo', '=',  $IdArticulo)
                ->where('c.visible_fict', '=', 'SI')
                ->orderBy('b.nombre_clasificacion')
                ->get();
    }
}
