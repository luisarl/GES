<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resg_ClasificacionesModel extends Model
{
    use HasFactory;

    protected $table = 'resg_clasificaciones';
    protected $primaryKey = 'id_clasificacion';
    protected $fillable =  [
        'id_clasificacion',
        'nombre_clasificacion',
        'descripcion_clasificacion'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
