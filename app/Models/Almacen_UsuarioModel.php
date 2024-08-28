<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Almacen_UsuarioModel extends Model
{
    use HasFactory;

    protected $table = 'almacen_usuario';
    protected $primaryKey = 'id_almacen_usuario';

    protected $fillable = [
        'id_almacen_usuario',
        'id_almacen',
        'id',
        'id_empresa'
    ];

    public static function AlmacenesUsuario($IdUsuario)
    {
        return DB::table('almacen_usuario as au')
            ->join('almacenes as a', 'a.id_almacen', '=', 'au.id_almacen')
            ->join('empresas as e', 'e.id_empresa', '=', 'au.id_empresa')
            ->select(
                'au.id_almacen_usuario',
                'au.id_almacen',
                'a.nombre_almacen',
                'au.id as id_user',
                'au.id_empresa',
                'e.nombre_empresa'
            )
            ->where('au.id', '=', $IdUsuario)
            ->get();
    }

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

}
