<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnth_UbicacionesModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_ubicaciones';
    protected $primaryKey = 'id_ubicacion';

    protected $fillable = [
        'id_ubicacion',
        'codigo_ubicacion',
        'nombre_ubicacion',
        'id_almacen'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha

    //Relacion de con almacenes
    public function almacen()
    {
        return $this->belongsTo(AlmacenesModel::class, 'id_almacen');
    }
    
    public function herramientas()
    {
        return $this->hasMany(Cnth_HerramientasModel::class, 'id_herramienta');
    }
}
