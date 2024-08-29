<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cnth_EmpleadosModel extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'cnth_empleados';
    protected $primaryKey = 'id_empleado';

    protected $fillable = [
        'id_empleado',
        'nombre_empleado',
        'estatus',
        'id_departamento',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function EmpleadosCnth()
    {
        return DB::table('cnth_empleados')
            ->select(
                'id_empleado',
                'nombre_empleado as Empleado'
            )
            ->where('estatus', '=', 'SI')
            ->get(); 
    }
    
    public function departamento()
    {
        return $this->belongsTo(DepartamentosModel::class, 'id_departamento');
    }
}
