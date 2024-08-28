<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Actv_EstadosModel extends Model
{
    use HasFactory;

    protected $table = 'actv_estados';
    protected $primaryKey = 'id_estado';

    protected $fillable = [
        'id_estado',
    	'nombre_estado'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  

    public static function ListaEstados()
    {
        return DB::table('actv_estados as a')
                ->select(
                    'a.id_estado',
                    'a.nombre_estado'
                )
                ->get();
    }

    //Relacion de con activos
    public function tipo()
    {
        return $this->belongsTo(Actv_ActivosModel::class, 'id_estado');
    }

}
