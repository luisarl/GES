<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnth_CategoriasModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'id_categoria',
        'codigo_categoria',
    	'nombre_categoria',
		'descripcion_categoria',
        'creado_por',
        'actualizado_por'
    ];
    
    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha
    
     //Relacion de con herramienta
    public function herramientas()
    {
        return $this->hasMany(Cnth_HerramientasModel::class, 'id_herramienta');
    }
}
