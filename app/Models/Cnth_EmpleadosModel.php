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

         $EmpeladosProfit =  DB::connection('profit')
         ->select(
            "
            SELECT 
                N_ACERO.dbo.snemple.nombres + ' ' + N_ACERO.dbo.snemple.apellidos AS Empleado 
                FROM N_ACERO.dbo.snemple 
                WHERE N_ACERO.dbo.snemple.status = 'A'
            UNION ALL
            SELECT 
                N_GLOBAL.dbo.snemple.nombres + ' ' + N_GLOBAL.dbo.snemple.apellidos AS Empleado              
                FROM N_GLOBAL.dbo.snemple 
                WHERE N_GLOBAL.dbo.snemple.status = 'A'
            UNION ALL
            SELECT
                N_DESTAJO.dbo.snemple.nombres + ' ' + N_DESTAJO.dbo.snemple.apellidos AS Empleado       
                FROM N_DESTAJO.dbo.snemple 
                WHERE N_DESTAJO.dbo.snemple.status = 'A'
            UNION ALL
            SELECT 
                    N_PUEBLO.dbo.snemple.nombres + ' ' + N_PUEBLO.dbo.snemple.apellidos AS Empleado           
                    FROM N_PUEBLO.dbo.snemple      
                    WHERE N_PUEBLO.dbo.snemple.status = 'A'
            "
        );

        $EmpleadosCnth = DB::select("
            SELECT 
                nombre_empleado AS Empleado
                FROM cnth_empleados
                WHERE estatus = 'SI'
            ");
                
         $empleados = array_merge($EmpeladosProfit, $EmpleadosCnth);    
         
         return $empleados;
    }
    
    public function departamento()
    {
        return $this->belongsTo(DepartamentosModel::class, 'id_departamento');
    }
}
