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

class Gsta_NovedadesModel extends Model
{
  
    use HasFactory;
    protected $dateFormat = 'Y-d-m H:i';   //funcion para formateo de la fecha
    protected $table = 'gsta_novedades';
    protected $primaryKey = 'id_novedad';

    protected $fillable = [
        'id_novedad',
        'descripcion',
       
    ];
 
    public static function VerNovedades($IdNovedad)
    {
            
        return DB::table('gsta_novedades as n')
           
            ->select(
                'n.id_novedad',
                'n.descripcion',
                'n.created_at'
              
            )
            ->where('n.id_novedad', '=', $IdNovedad)
            ->first(); 
    }
}
