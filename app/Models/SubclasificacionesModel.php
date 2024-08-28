<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubclasificacionesModel extends Model
{
    use HasFactory;

    protected $table = 'subclasificaciones';
    protected $primaryKey = 'id_subclasificacion';

    protected $fillable = [
        'id_subclasificacion',
    	'nombre_subclasificacion',
        'id_clasificacion',
        'visible_fict'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha

    //Relacion de con clasificacion
    public function clasificacion()
    {
        return $this->belongsTo(ClasificacionesModel::class, 'id_clasificacion');
    }
}
