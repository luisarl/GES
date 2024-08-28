<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_TecnologiaModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_tecnologias';
    protected $primaryKey = 'id_tecnologia';

    protected $fillable =  [
        'id_tecnologia',
        'nombre_tecnologia',
        'descripcion_tecnologia'
    ];

    public static function ListaTecnologias()
    {
        return DB::table('cenc_tecnologias as c')
                ->select(
                    'c.id_tecnologia',
                    'c.nombre_tecnologia',
                    'c.descripcion_tecnologia',
                    )
                ->get();
    }

    public static function ListaTecnologiasEdit($IdTecnologia)
    {
        return DB::table('cenc_tecnologias as c')
                ->select(
                    'c.id_tecnologia',
                    'c.nombre_tecnologia',
                    'c.descripcion_tecnologia'
                    )
                ->where('c.id_tecnologia', '=', $IdTecnologia)
                ->get();
    }

    

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
    //->whereNotIn('r.id_responsable', $usuarios) //NO INCLUIR USUARIOS ASIGNADOS
}
