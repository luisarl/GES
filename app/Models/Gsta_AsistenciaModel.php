<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Gsta_AsistenciaModel extends Model
{
    use HasFactory;
    
    protected $dateFormat = 'Y-d-m H:i'; 
    protected $fillable = [
      
        'id_empleado',
        'nombre',
        'apellido',
        'fecha_hora',
        'grupo_persona',
        'evento',
        'estado_asistencia',


    ];

   
    public static function ListadoAsistencia($IdDepartamento,$IdEmpresa,$FechaInicio, $FechaFin){

        $FechaInicio = Carbon::parse($FechaInicio)->format('Y-m-d');
        $FechaFin = Carbon::parse($FechaFin)->format('Y-m-d');
        
        $registros = DB::connection('BIOMETRICO')
            ->table('View_Registros_Empleados AS r1')
          
            ->select(
                'r1.cod_biometrico',
                'r1.cod_empresa',
                'r1.empresa',
                'r1.nombres',
                'r1.apellidos',
                'r1.fecha',
             
                DB::raw('MIN(r1.hora) AS hora'),
                DB::raw('(SELECT TOP 1 r2.hora FROM View_Registros_Empleados  AS r2 WHERE r2.cod_biometrico = r1.cod_biometrico AND r2.fecha = r1.fecha ORDER BY r2.hora DESC) AS ultima_hora')
            );
        
        if ($IdDepartamento !== 'TODOS') {
            $registros = $registros->where('r1.co_depart', '=', $IdDepartamento);
        }
        if($IdEmpresa!=='TODAS'){
            $registros->where('r1.cod_empresa', '=', $IdEmpresa);
        }
        
        $registros = $registros
            ->whereBetween(DB::raw("CONVERT(date, r1.fecha)"), [$FechaInicio, $FechaFin])
            ->groupBy('r1.cod_biometrico','r1.cod_empresa', 'r1.empresa', 'r1.nombres','r1.apellidos',  'r1.fecha')
            ->get();
        
        return $registros;
        
        
    }

    
    public static function ListadoAsistenciaPersona($IdEmpleado,$FechaInicio){


        $FechaInicio = Carbon::parse($FechaInicio)->format('d-m-Y');
    
        return DB::connection('BIOMETRICO')
        ->table('View_Registros_Empleados')
        ->select(
            
            'cod_biometrico',
            'nombres',
            'apellidos',
            'fecha',
            'hora',
            'evento',
            'estado_asistencia'
        )
        ->where('cod_biometrico', '=', $IdEmpleado)
        ->where('fecha', '=', $FechaInicio)
        ->orderBy('hora', 'asc')
        ->get();
        
        
    }

    public static function DepartamentosNomina()
    {
        return DB::connection('profit')
                ->table('N_ACERO.dbo.sndepart')
                ->select(
                    'co_depart as id_departamento',
                    'des_depart as nombre_departamento'
                )
                ->get(); 
    }
    
    public static function EmpresasNomina(){
        return DB::connection('BIOMETRICO')
        ->table('View_Registros_Empleados')
        ->select(
           'cod_empresa as id_empresa',
           'empresa as nombre_empresa'
        )
        ->distinct()
        ->get();
    }
   
}
