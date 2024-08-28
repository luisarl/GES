<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasModel extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'id_categoria',
    	'nombre_categoria',
		'descripcion_categoria',
        'creado_por',
        'actualizado_por'
    ];
    
    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha
    
     //Relacion de con articulo
    public function articulos()
    {
        return $this->hasMany(ArticulosModel::class, 'id_articulo');
    }
}
