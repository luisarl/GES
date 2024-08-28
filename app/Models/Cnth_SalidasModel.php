<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cnth_SalidasModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_salidas';
    protected $primaryKey = 'id_salida';

    protected $fillable = [
        'id_salida',
    	'fecha',
		'usuario',
        'motivo',
        'descripcion',
        'id_almacen'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ListaSalidas()
    {
        return DB::table('cnth_salidas as s')
                ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
                ->join('users as u', 'u.id', '=', 's.usuario')
                ->select(                    
                    's.id_salida',
                    's.id_almacen',
                    'a.nombre_almacen',
                    's.usuario',
                    'u.name as nombre_usuario',
                    DB::raw("CONVERT(VARCHAR(10), s.fecha, 103) + ' ' + RIGHT(CONVERT(VARCHAR, s.fecha, 100), 7) as fecha") 
                )
                ->get();
    }

    public static function DetalleSalida($IdSalida)
    {
        return DB::table('cnth_salidas as s')
                ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
                ->join('users as u', 'u.id', '=', 's.usuario')
                ->select(                    
                    's.id_salida',
                    's.id_almacen',
                    'a.nombre_almacen',
                    's.usuario',
                    'u.name as nombre_usuario',
                    's.motivo',
                    's.descripcion',
                    DB::raw("CONVERT(VARCHAR(10), s.fecha, 103) + ' ' + RIGHT(CONVERT(VARCHAR, s.fecha, 100), 7) as fecha") 
                )
                ->where('s.id_salida', '=', $IdSalida)
                ->first();
    }

    public static function MovimientoSalida($IdSalida)
    {
        return DB::table('cnth_salidas_detalle ')
                ->select( 
                    'id_detalle',                   
                    'id_salida',
                    'id_herramienta',
                    'nombre_herramienta',
                    'cantidad'
                )
                ->where('id_salida', '=', $IdSalida)
                ->get();
    }
}
