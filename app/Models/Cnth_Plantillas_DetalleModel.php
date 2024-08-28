<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cnth_Plantillas_DetalleModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_plantillas_detalle';
    protected $primaryKey = 'id_plantilla_detalle';

    protected $fillable = [
        'id_plantilla_detalle',
        'id_plantilla',
    	'id_herramienta',
		'cantidad'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function HerramientasPlantilla($IdPlantilla)
    {   
        return DB::table('cnth_plantillas_detalle as pd')
                ->join('cnth_plantillas as p', 'pd.id_plantilla', '=', 'p.id_plantilla')
                ->join('cnth_herramientas as h', 'pd.id_herramienta', '=', 'h.id_herramienta')
                ->join('cnth_almacen_herramientas as a', function($join)
                    {
                        $join->on('p.id_almacen', '=', 'a.id_almacen');
                        $join->on('pd.id_herramienta', '=', 'a.id_herramienta');

                    })
                ->select(
                    'pd.id_plantilla_detalle',
                    'pd.id_plantilla',
                    'h.id_herramienta',
                    'h.nombre_herramienta',
                    'pd.cantidad',
                    'a.stock_actual'
                )
                ->where('p.id_plantilla', '=', $IdPlantilla)
                ->get();
    }

    public static function PlantillasAlmacen($IdAlmacen, $IdPlantilla)
    {
            return DB::table('cnth_plantillas AS p')
            ->join('cnth_plantillas_detalle AS pd', 'pd.id_plantilla', '=', 'p.id_plantilla')
            ->join('cnth_herramientas AS h', 'h.id_herramienta', '=', 'pd.id_herramienta')
            ->join('almacenes AS a', 'a.id_almacen', '=', 'p.id_almacen')
            ->select(
                'p.id_plantilla',
                'P.nombre_plantilla',
                'a.id_almacen',
                'h.id_herramienta',
                'h.nombre_herramienta',
                'pd.cantidad',
                'a.nombre_almacen'
            )
            ->where('a.id_almacen', '=', $IdAlmacen)
            ->where('p.id_plantilla', '=', $IdPlantilla)
           ->orderBy('p.id_plantilla', 'asc')
           ->get();
    }

}
