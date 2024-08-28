<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnth_SubgruposModel extends Model
{
    use HasFactory;

    protected $table = 'cnth_subgrupos';
    protected $primaryKey = 'id_subgrupo';

    protected $fillable = [

    	'nombre_subgrupo',
		'descripcion_subgrupo',
        'codigo_subgrupo',
        'prefijo',
        'creado_por',
        'actualizado_por',
        'id_grupo'
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcioon para formateo de la fecha


    //Relacion de con grupos
    public function grupo()
    {
        return $this->belongsTo(Cnth_GruposModel::class, 'id_grupo');
    }
    
    public function herramientas()
    {
        return $this->hasMany(Cnth_HerramientasModel::class, 'id_herramienta');
    }
}
