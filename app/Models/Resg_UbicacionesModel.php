<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resg_UbicacionesModel extends Model
{
    use HasFactory;

    protected $table = 'resg_ubicaciones';
    protected $primaryKey = 'id_ubicacion';

    protected  $fillable = [
        'id_ubicacion',
        'id_almacen',
        'nombre_ubicacion',
        'descripcion_ubicacion'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
    
    public static function ListaUbicaciones()
    {
        return DB::table('resg_ubicaciones as u')
            ->join('almacenes as a', 'u.id_almacen', '=', 'a.id_almacen')
            ->select(
                'u.id_ubicacion',
                'u.nombre_ubicacion',
                'a.id_almacen',
                'a.nombre_almacen'
                )
            ->get();
    }
}
