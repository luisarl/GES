<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Embarcaciones_UsuariosModel extends Model
{
    use HasFactory;

    protected $table = 'embarcaciones_usuarios';
    protected $primaryKey = 'id_embarcaciones_usuario';

    protected $fillable = [
        'id_embarcaciones_usuario',
        'id_embarcaciones',
        'id_usuario',

    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //formato de fecha


    public static function EmbarcacionesUsuario($IdUsuario)
    {
        return DB::table('embarcaciones_usuarios as eu')
            ->join('emba_embarcaciones as e', 'e.id_embarcaciones', '=', 'eu.id_embarcaciones')
            ->select(
                'eu.id_embarcaciones',
                'e.nombre_embarcaciones',
                'eu.id_embarcaciones_usuario'
            )
            ->where('eu.id_usuario', '=', $IdUsuario)
            ->get();
    }
}
