<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasificacionesModel extends Model
{
    use HasFactory;

    
    protected $table = 'clasificaciones';
    protected $primaryKey = 'id_clasificacion';

    protected $fillable = [
        'id_clasificacion',
    	'nombre_clasificacion',
        
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha

    //Relacion de con subclasificacion
    public function subclasificaciones()
    {
        return $this->hasMany(SubclasificacionesModel::class, 'id_clasificacion');
    }
}
