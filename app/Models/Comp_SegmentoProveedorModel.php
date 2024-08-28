<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comp_SegmentoProveedorModel extends Model
{
    use HasFactory;
    
    public $incrementing = false;
    protected $table = 'comp_segmento_proveedor';
    protected $primaryKey = 'id_segmento';

    protected $fillable = [
        'id_segmento',
    	'nombre_segmento',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha

    //Relacion de con proveedores
    public function proveedores()
    {
        return $this->hasMany(Comp_ProveedoresModel::class, 'id_proveedores');
    }
}
