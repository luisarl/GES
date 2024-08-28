<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnth_Responsables_MovimientosModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_responsables_movimientos';
    protected $primaryKey = 'id_responsable_movimiento';

    protected $fillable = [
        'id_responsable_movimiento',
    	'id_movimiento',
		'responsable'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
