<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesModel extends Model
{
    use HasFactory;

    protected $table = 'unidades';
    protected $primaryKey = 'id_unidad';

    protected $fillable = [
        'id_unidad',
    	'nombre_unidad',
		'abreviatura_unidad',
        'clasificacion_unidad',
        'creado_por',
        'actualizado_por'
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcioon para formateo de la fecha

    //Relacion de muchos a muchos entre articulos y unidad
    public function articulos()
    {
        return $this->hasMany(ArticulosModel::class, 'id_articulo');
    }
}
