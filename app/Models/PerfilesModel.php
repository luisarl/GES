<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilesModel extends Model
{
    use HasFactory;

    protected $table = 'perfiles';
    protected $primaryKey = 'id_perfil';

    protected $fillable = [   
    	'descripcion_perfil',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha
 
    //Relacion de con usuarios
    public function Users()
    {
        return $this->hasMany(User::class, 'id');
    }

}
