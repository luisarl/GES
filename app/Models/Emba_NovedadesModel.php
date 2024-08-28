<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emba_NovedadesModel extends Model
{
    use HasFactory;

    protected $table = 'emba_novedades';
    protected $primaryKey = 'id_novedad';

    protected $fillable = 
    [
        'id_novedad',
        'motivo_novedad',
        'descripcion_novedad',
        'id_embarcacion'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //formato de fecha
}
