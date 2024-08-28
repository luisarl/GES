<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Action;

class DepartamentosModel extends Model
{
    use HasFactory;

    protected $table = 'departamentos';
    protected $primaryKey = 'id_departamento';

    protected $fillable = [
        
    	'id_departamento',
        'nombre_departamento',
        'responsable',
        'correo',
        'aplica_servicios',
        'correlativo_servicios',
        'prefijo'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    //Relacion de con usuario
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_departamento');
    }
    
    //Relacion de con empleados(respnsable de herramientas 'almacen')
    public function empleados()
    {
        return $this->hasMany(Cnth_EmpleadosModel::class, 'id_empleado');
    }

    //Relacion de con activos
    public function activos()
    {
        return $this->hasMany(ActivosModel::class, 'id_activo');
    }

}
