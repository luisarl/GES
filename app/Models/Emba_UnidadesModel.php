<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emba_UnidadesModel extends Model
{
    use HasFactory;
    protected $table = 'emba_unidades';
    protected $primaryKey = 'id_unidad';

    protected $fillable = [
        'id_unidad',
        'nombre_unidad',
        'descripcion_unidad',
        'abreviatura'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //formato de fecha
}
