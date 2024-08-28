<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
class Gsta_EmpleadosModel extends Model
{
    use HasFactory;  protected $dateFormat = 'Y-d-m H:i'; 
    protected $primaryKey = 'id_horario_empleado';
    protected $table = 'gsta_horario_empleados';
    protected $fillable = [
        'id_horario_empleado',
        'id_empleado',
        'id_biometrico',
        'nombre_empleado',
        'id_horario',

    ];

    public static function TieneAsignado($cod_biometrico)
    {
        return DB::table('gsta_horario_empleados')
            ->where('id_biometrico', '=',$cod_biometrico)
            ->exists();
    }
    public static function ListadoHorarioPersona($id_empleado)
    {
        $registros = DB:: table('gsta_horario_empleados AS h')
            ->join('MasterProfitPro.dbo.View_Empleados_Biometrico as b', 'h.id_biometrico','=','b.cod_biometrico')
            ->join('gsta_horarios as h1', 'h.id_horario', '=', 'h1.id_horario')
            ->select(
                'h.id_horario_empleado',
                'h.id_empleado',
                'h.id_biometrico',
                'h.id_horario',
                'b.des_depart',
                'b.empresa',
                'b.nombres',
                'b.apellidos',
                'h1.nombre_horario'
            )
    
            ->where('h.id_biometrico', '=',$id_empleado)
            ->first();
        
    
        return $registros;

    }
    
    public static function ListadoPersonal($id_empleado = null)
    {
        $registros = DB::connection('profit')
            ->table('MasterProfitPro.dbo.View_Empleados_Biometrico')
            ->select(
                'cod_biometrico',
                'cod_emp',
                'co_depart',
                'cod_empresa',
                'empresa',
                'nombres',
                'apellidos',
                'des_depart'
            );
    
        if ($id_empleado !== null) {
            $registros->where('cod_biometrico', $id_empleado);
            return $registros->distinct()->first();
        }
    
        return $registros->distinct()->get();
    }
        
    
}
