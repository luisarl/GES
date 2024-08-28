<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comp_ZonasModel extends Model
{
    use HasFactory;
    
    public $incrementing = false;
    protected $table = 'comp_zonas';
    protected $primaryKey = 'id_zona';

    protected $fillable = [
        'id_zona',
    	'nombre_zona',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha

    //Relacion de con proveedores
    public function proveedores()
    {
        return $this->hasMany(Comp_ProveedoresModel::class, 'id_proveedores');
    }
}
