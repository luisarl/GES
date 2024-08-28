<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cnth_Movimiento_InventarioModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_movimiento_inventario';
    protected $primaryKey = 'id_inventario';

    protected $fillable = [
        'id_inventario',
        'id_herramienta',
        'id_almacen',
    	'movimiento',
        'tipo_movimiento',
		'usuario',
        'fecha',
        'descripcion',
        'entrada',
        'salida'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ActualizarStock($IdHerramienta, $IdAlmacen)
    {
        $stock_actual = DB::table('cnth_movimiento_inventario')
                            ->select( DB::raw('sum(entrada) - sum(salida) as stock_actual '))
                            ->where('id_herramienta', '=', $IdHerramienta)
                            ->where('id_almacen', '=', $IdAlmacen)
                            ->value('stock_actual'); 

        DB::table('cnth_almacen_herramientas')
            ->where('id_herramienta', '=', $IdHerramienta)
            ->where('id_almacen', '=', $IdAlmacen) 
            ->update(['stock_actual' => $stock_actual]);   
    }

    public static function HistoricoHerramienta($IdHerramienta)
    {
        return DB::table('cnth_movimiento_inventario as mi')
                ->join('cnth_herramientas as h', 'h.id_herramienta', '=', 'mi.id_herramienta')
                ->join('almacenes as a', 'a.id_almacen', '=', 'mi.id_almacen')
                ->select(
                    'mi.movimiento',
                    'mi.id_herramienta',
                    'h.nombre_herramienta',
                    'mi.id_almacen',
                    'a.nombre_almacen',
                    'mi.fecha',
                    'mi.tipo_movimiento',
                    'mi.usuario',
                    'mi.entrada', 
                    'mi.salida'
                )
                ->where('mi.id_herramienta','=', $IdHerramienta)
                ->orderBy('mi.id_inventario', 'DESC')
                ->get();
    }
}
