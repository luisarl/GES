<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_Aprovechamiento_Plancha_Area_CorteModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_aprovechamiento_planchas_area_corte';
    protected $primaryKey = 'id_area_corte';

    protected $fillable = [
        'id_area_corte',
        'dimensiones',
        'cantidad',
        'peso_unit',
        'peso_total',
        'created_at',
        'updated_at',
        'id_aprovechamiento_plancha'
    ];

    public static function EditarAreaCorteAprovechamiento($IdAprovechamiento)
    {
        return DB::table('cenc_aprovechamiento_planchas_area_corte as aprov_ac')
            ->join ('cenc_aprovechamiento_planchas as aprovpl','aprovpl.id_aprovechamiento_plancha', '=','aprov_ac.id_aprovechamiento_plancha')
            ->join ('cenc_aprovechamientos as aprov','aprov.id_aprovechamiento', '=','aprovpl.id_aprovechamiento')
            ->join ('cenc_lista_partes as lp','lp.id_lista_parte', '=','aprov.id_lista_parte')
            ->select(
                'aprov_ac.id_area_corte',
                'aprov_ac.dimensiones',
                'aprov_ac.cantidad',
                'aprov_ac.peso_unit',
                'aprov_ac.peso_total',
                'aprov_ac.id_aprovechamiento_plancha',
                'lp.tipo_lista'
            )
            ->where('aprov.id_aprovechamiento','=',$IdAprovechamiento)
            ->get();
    }
    
    public static function Contador($id) 
    {
        $totalRegistros = DB::table('cenc_aprovechamiento_planchas_area_corte')
        ->where('id_area_corte', $id)
        ->count();

        return $totalRegistros;
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}