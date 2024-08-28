<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisesModel extends Model
{
    use HasFactory;
    
    public $incrementing = false;
    protected $table = 'paises';
    protected $primaryKey = 'id_pais';

    protected $fillable = [
        'id_pais',
    	'nombre_pais',
    ];

    
    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha

    //Relacion de con proveedores
    public function proveedores()
    {
        return $this->hasMany(Comp_ProveedoresModel::class, 'id_proveedores');
    }
}
