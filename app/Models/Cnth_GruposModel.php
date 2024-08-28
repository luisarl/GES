<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnth_GruposModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_grupos';
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
        return $this->hasMany(Cnth_SubgruposModel::class, 'id_grupo');
    }
    
    public function herramientas()
    {
        return $this->hasMany(Cnth_HerramientasModel::class, 'id_herramienta');
    }
}
