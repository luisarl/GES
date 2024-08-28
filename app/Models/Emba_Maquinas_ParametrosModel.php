<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Emba_Maquinas_ParametrosModel extends Model
{
    use HasFactory;

    protected $table = 'emba_maquinas_parametros';
    protected $primaryKey = 'id_maquina_parametro';

    protected $fillable = [
        'id_maquina_parametro',
        'id_maquina',
        'id_parametro',
        'orden',
        'valor_minimo',
        'valor_maximo'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //formato de fecha

    public static function MaquinaParametros($IdMaquina)
    {
        return DB::table('emba_maquinas_parametros as mp')
                ->join('emba_maquinas as m', 'mp.id_maquina', '=', 'm.id_maquina')
                ->join('emba_parametros as p', 'mp.id_parametro', '=', 'p.id_parametro')
                ->select(
                    'mp.id_maquina_parametro',
                    'mp.id_maquina',
                    'm.nombre_maquina',
                    'mp.orden',
                    'mp.id_parametro',
                    'p.nombre_parametro',
                    'mp.valor_minimo',
                    'mp.valor_maximo'
                )
                ->where('mp.id_maquina', '=',  $IdMaquina)
                ->orderBy('p.nombre_parametro')
                ->get();
    }
}
