<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asal_VehiculosModel extends Model
{
    use HasFactory;

    
    protected $table = 'asal_vehiculos';
    protected $primaryKey = 'id_vehiculo'; 

    protected $fillable = [
        'id_vehiculo',
        'activo',
        'placa_vehiculo',
        'marca_vehiculo',
        'modelo_vehiculo',
        'descripcion',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public function salida()
    {
        return $this->hasMany(Asal_SalidasModel::class, 'id_salida');
    }
}
