<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnth_Almacen_HerramientasModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_almacen_herramientas';
    protected $primaryKey = 'id_almacen_herramienta';

    protected $fillable = [
      
        'id_almacen_herramienta',
        'id_almacen',
        'id_herramienta',
        'id_ubicacion',
        'id_empresa',
        'stock_inicial',
        'stock_actual',

    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcion para formateo de la fecha
    
    public function herramientas()
    {
        return $this->belongsToMany(Cnth_HerramientasModel::class,'cnth_almacen_herramientas','id_almacen','id_herramienta');
    }
}
