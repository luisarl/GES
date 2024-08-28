<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;


class Gsta_HorarioModel extends Model
{
    use HasFactory;
    protected $dateFormat = 'Y-d-m H:i';   //funcion para formateo de la fecha
    protected $table = 'gsta_horarios';
    protected $primaryKey = 'id_horario';

    protected $fillable = [
        'id_horario',
        'nombre_horario',
        'inicio_jornada',
        'fin_jornada',
        'inicio_descanso',
        'fin_descanso',
        'dias_seleccionados',
    ];
 
    public static function VerHorario($IdHorario)
    {
            
        return DB::table('gsta_horarios as h')
           
            ->select(
                'h.id_horario',
                'h.nombre_horario',
                'h.inicio_jornada',
                'h.fin_jornada',
                'h.inicio_descanso',
                'h.fin_descanso',
                'h.dias_seleccionados',
                'h.created_at'
              
            )
            ->where('h.id_horario', '=', $IdHorario)
            ->first(); 
    }
}

