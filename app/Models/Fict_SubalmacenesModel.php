<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fict_SubalmacenesModel extends Model
{
    use HasFactory;

    protected $table = 'subalmacenes';
    protected $primaryKey = 'id_subalmacen';

    protected $fillable = [
        'id_subalmacen',
    	'nombre_subalmacen',
		'descripcion_subalmacen',
        'codigo_subalmacen',
        'creado_por',
        'actualizado_por',
        'id_almacen'
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcioon para formateo de la fecha

    //Relacion de con almacenes
    public function almacen()
    {
        return $this->belongsTo(AlmacenesModel::class, 'id_almacen');
    }

    public function ubicaciones()
    {
        return $this->hasMany(Fict_UbicacionesModel::class, 'id_ubicacion');
    }
}
