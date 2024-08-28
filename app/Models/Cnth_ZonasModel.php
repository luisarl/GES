<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnth_ZonasModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_zonas';
    protected $primaryKey = 'id_zona';

    protected $fillable = [
        'id_zona',
    	'nombre_zona',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
