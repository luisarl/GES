<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Emba_MaquinasModel extends Model
{
    use HasFactory;
    protected $table = 'emba_maquinas';
    protected $primaryKey = 'id_maquina';

    protected $fillable = [
        'id_maquina',
        'nombre_maquina',
        'id_embarcaciones',
        'descripcion_maquina',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //formato de fecha
    
}
