<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emba_ParametrosModel extends Model
{
    use HasFactory;

    protected $table = 'emba_parametros';
    protected $primaryKey = 'id_parametro';

    protected $fillable = [
        'id_parametro',
        'nombre_parametro',
        'descripcion_parametro',
        'id_unidad'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //formato de fecha
}
