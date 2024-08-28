<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_Aprovechamiento_Plancha_Materia_PrimaModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_aprovechamiento_planchas_materia_prima';
    protected $primaryKey = 'id_materia_prima';

    protected $fillable = [
        'id_materia_prima',
        'codigo_materia',
        'dimensiones',
        'cantidad',
        'peso_unit',
        'peso_total',
        'created_at',
        'updated_at',
        'id_aprovechamiento_plancha'
    ];

    public static function MateriaPrimaAprovechamiento($IdAprovechamiento)
    {
        return DB::table('cenc_aprovechamiento_planchas_materia_prima as aprov_mp')
        ->join ('cenc_aprovechamiento_planchas as aprovpl','aprovpl.id_aprovechamiento_plancha', '=','aprov_mp.id_aprovechamiento_plancha')
        ->select(
            'aprov_mp.id_materia_prima',
            'aprov_mp.codigo_materia',
            'aprov_mp.dimensiones',
            'aprov_mp.cantidad',
            'aprov_mp.peso_unit',
            'aprov_mp.peso_total',
            'aprov_mp.id_aprovechamiento_plancha'
        )
        ->where('id_aprovechamiento','=',$IdAprovechamiento)
        ->get();
    }

    public static function EditarMateriaPrimaAprovechamiento($IdAprovechamiento)
    {
        return DB::table('cenc_aprovechamiento_planchas_materia_prima as aprov_mp')
        ->join ('cenc_aprovechamiento_planchas as aprovpl','aprovpl.id_aprovechamiento_plancha', '=','aprov_mp.id_aprovechamiento_plancha')
        ->join ('cenc_aprovechamientos as aprov','aprov.id_aprovechamiento', '=','aprovpl.id_aprovechamiento')
        ->join ('cenc_lista_partes as lp','lp.id_lista_parte', '=','aprov.id_lista_parte')
        ->select(
            'aprov_mp.id_materia_prima',
            'aprov_mp.codigo_materia',
            'aprov_mp.dimensiones',
            'aprov_mp.cantidad',
            'aprov_mp.peso_unit',
            'aprov_mp.peso_total',
            'aprov_mp.id_aprovechamiento_plancha',
            'lp.tipo_lista'
        )
        ->where('aprov.id_aprovechamiento','=',$IdAprovechamiento)
        ->get();
    }


    public static function Contador($id) 
    {
        $totalRegistros = DB::table('cenc_aprovechamiento_planchas_materia_prima')
        ->where('id_materia_prima', $id)
        ->count();

        return $totalRegistros;
    }


    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
