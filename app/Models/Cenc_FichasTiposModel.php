<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cenc_FichasTiposModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_fichas_tipos';
    protected $primaryKey = 'id_tipo';

    protected $fillable = [
        'id_tipo',
    	'nombre_tipo'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
