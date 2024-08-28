<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emba_EmbarcacionesModel extends Model
{
    use HasFactory;

    protected $table = 'emba_embarcaciones';
    protected $primaryKey = 'id_embarcaciones';

    protected $fillable = [
        'id_embarcaciones',
        'nombre_embarcaciones',
        'descripcion',
  
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //formato de fecha
}
