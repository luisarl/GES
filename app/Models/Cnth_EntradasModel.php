<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cnth_EntradasModel extends Model
{
    use HasFactory;
    
    protected $table = 'cnth_entradas';
    protected $primaryKey = 'id_entrada';

    protected $fillable = [
        'id_entrada',
    	'fecha',
		'usuario',
        'motivo',
        'descripcion',
        'id_almacen'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ListaEntradas()
    {
        return DB::table('cnth_entradas as e')
                ->join('almacenes as a', 'a.id_almacen', '=', 'e.id_almacen')
                ->join('users as u', 'u.id', '=', 'e.usuario')
                ->select(                    
                    'e.id_entrada',
                    'e.id_almacen',
                    'a.nombre_almacen',
                    'e.usuario',
                    'u.name as nombre_usuario',
                    DB::raw("CONVERT(VARCHAR(10), e.fecha, 103) + ' ' + RIGHT(CONVERT(VARCHAR, e.fecha, 100), 7) as fecha") 
                )
                ->get();
    }

    public static function DetalleEntrada($IdEntrada)
    {
        return DB::table('cnth_entradas as e')
                ->join('almacenes as a', 'a.id_almacen', '=', 'e.id_almacen')
                ->join('users as u', 'u.id', '=', 'e.usuario')
                ->select(                    
                    'e.id_entrada',
                    'e.id_almacen',
                    'a.nombre_almacen',
                    'e.usuario',
                    'u.name as nombre_usuario',
                    'e.motivo',
                    'e.descripcion',
                    DB::raw("CONVERT(VARCHAR(10), e.fecha, 103) + ' ' + RIGHT(CONVERT(VARCHAR, e.fecha, 100), 7) as fecha") 
                )
                ->where('e.id_entrada', '=', $IdEntrada)
                ->first();
    }

    public static function MovimientoEntrada($IdEntrada)
    {
        return DB::table('cnth_entradas_detalle ')
                ->select( 
                    'id_detalle',                   
                    'id_entrada',
                    'id_herramienta',
                    'nombre_herramienta',
                    'cantidad'
                )
                ->where('id_entrada', '=', $IdEntrada)
                ->get();
    }
}
