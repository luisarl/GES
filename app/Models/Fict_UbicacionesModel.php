<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fict_UbicacionesModel extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones';
    protected $primaryKey = 'id_ubicacion';

    protected $fillable = [
        'id_ubicacion',
        'codigo_ubicacion',
        'nombre_ubicacion',
        'id_subalmacen'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha


    public static function ConsultarArticulosUbicaciones()
    {
        return Fict_UbicacionesModel::join('articulos', 'articulo_ubicacion.id_articulo', '=', 'articulos.id_articulo')
                    ->join('almacenes', 'articulo_ubicacion.id_almacen', '=', 'almacenes.id_almacen')
                    ->join('subalmacenes', 'articulo_ubicacion.id_subalmacen', '=', 'subalmacenes.id_subalmacen')
                    ->select(
                        'articulo_ubicacion.id_articulo', 
                        'articulos.nombre_articulo', 
                        'almacenes.nombre_almacen', 
                        'subalmacenes.nombre_subalmacen', 
                        'articulo_ubicacion.id_ubicacion',
                        'articulo_ubicacion.id_articulo_ubicacion'
                        
                        )
                    ->get();
    }

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'id_articulo');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }

    public function subalmacen()
    {
        return $this->belongsTo(Fict_SubalmacenesModel::class, 'id_subalmacen');
    }
    
}
