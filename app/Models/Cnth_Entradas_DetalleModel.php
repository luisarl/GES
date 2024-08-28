<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnth_Entradas_DetalleModel extends Model
{
    use HasFactory;
    
    protected $table = 'cnth_entradas_detalle';
    protected $primaryKey = 'id_detalle';

    protected $fillable = [
        'id_detalle',
        'id_entrada',
        'id_herramienta',
        'nombre_herramienta',
    	'cantidad'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
