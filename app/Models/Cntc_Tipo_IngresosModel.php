<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Cntc_Tipo_IngresosModel extends Model
{
    use HasFactory;
    protected $dateFormat = 'Y-d-m H:i';   //funcion para formateo de la fecha
    protected $table = 'cntc_tipo_ingresos';
    protected $primaryKey = 'id_tipo_ingresos';

    protected $fillable = [
        'id_tipo_ingresos',
        'descripcion_ingresos',
       
        
    ];
}
