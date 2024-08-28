<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Cntc_Tipo_CombustibleModel extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-d-m H:i';   //funcion para formateo de la fecha
  
    protected $table = 'cntc_tipo_combustible';
    protected $primaryKey = 'id_tipo_combustible';

    protected $fillable = [
        'id_tipo_combustible',
        'descripcion_combustible',
        'stock',
        'id_departamento_encargado',
        
    ];

    
    public static function BuscarCombustible($IdCombustible)
    {
        return DB::table('cntc_tipo_combustible')
            ->where('id_tipo_combustible', '=', $IdCombustible)
            ->value('descripcion_combustible');

    }

    public static function TiposCombustible()
    {

        $registros = DB::table('cntc_tipo_combustible as c')
            ->join('departamentos as d','c.id_departamento_encargado','=','d.id_departamento')
            ->select(
                
                'c.id_tipo_combustible',
                'c.descripcion_combustible',
                'c.stock',
                'd.nombre_departamento',
                

            );
        return $registros->get();
        
    }
    public static function Combustible($IdCombustible)
    {

        $registros = DB::table('cntc_tipo_combustible as c')
            ->join('departamentos as d','c.id_departamento_encargado','=','d.id_departamento')
            ->select(
                
                'c.id_tipo_combustible',
                'c.descripcion_combustible',
                'c.stock',
                'd.nombre_departamento',
                

            );
        return $registros ->where('c.id_tipo_combustible','=',$IdCombustible)->first();
        
    }
}
