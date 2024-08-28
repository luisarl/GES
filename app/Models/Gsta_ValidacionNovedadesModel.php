<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
class Gsta_ValidacionNovedadesModel extends Model
{
    
    use HasFactory;  protected $dateFormat = 'Y-d-m H:i'; 
    protected $primaryKey = 'id_validacion_novedades';
    protected $table = 'gsta_validacion_novedades';
    protected $fillable = [
        'id_validacion_novedades',
        'id_validacion',
        'id_novedad',
    ];

    public static function ListarNovedad($id_validacion)
    {
        $registros = DB::table('gsta_validacion_novedades AS vn')
        ->join('gsta_novedades as n', 'n.id_novedad','=','vn.id_novedad')
        ->select(
            'vn.id_validacion_novedades',
            'vn.id_validacion',
            'vn.id_novedad',
            'n.descripcion'
        )
        ->where('vn.id_validacion', '=', $id_validacion)
        ->get();
    
    return $registros;
    }
}
