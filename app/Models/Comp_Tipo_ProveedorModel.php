<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comp_Tipo_ProveedorModel extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'comp_tipo_proveedor';
    protected $primaryKey = 'id_tipo';

    protected $fillable = [
        'id_tipo',
    	'nombre_tipo',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha

    //Relacion de con proveedores
    public function proveedores()
    {
        return $this->hasMany(Comp_ProveedoresModel::class, 'id_proveedores');
    }
}