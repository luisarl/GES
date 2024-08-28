<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GruposModel extends Model
{
    use HasFactory;

    protected $table = 'grupos';
    protected $primaryKey = 'id_grupo';

    protected $fillable = [
        'id_grupo',
    	'nombre_grupo',
		'descripcion_grupo',
        'codigo_grupo',
        'prefijo',
        'creado_por',
        'actualizado_por'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha

    //Relacion de con subgrupo
    public function subgrupos()
    {
        return $this->hasMany(SubgruposModel::class, 'id_grupo');
    }
    //Relacion de con articulo
    public function articulos()
    {
        return $this->hasMany(ArticulosModel::class, 'id_articulo');
    }
}
