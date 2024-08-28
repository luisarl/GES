<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actv_TiposModel extends Model
{
    use HasFactory;

    protected $table = 'actv_tipos';
    protected $primaryKey = 'id_tipo';

    protected $fillable = [
        'id_tipo',
    	'nombre_tipo'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
    
}
