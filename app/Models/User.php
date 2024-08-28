<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;
//use HasRoles;

class User extends Authenticatable
{
    
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'id_departamento',
        'activo',
        'responsable_servicios'
        
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcioon para formateo de la fecha

    public static function UsuariosDepartamentos()
    {       
        return DB::table('users as u')
                ->join('departamentos as d', 'u.id_departamento', '=', 'd.id_departamento')
                ->select(
                    'u.id',
                    'u.name',
                    'u.email',  
                    'd.nombre_departamento'
                )
                ->where('u.activo', '=', 'SI')
                ->whereNotIn('u.id', [1]) //NO INCLUIR USUARIO ADMINISTRADOR
                ->orderBy('u.name')
                ->get();
    }

    public static function UsuariosResponsablesServicios($IdDepartamento, $IdSolcitud)
    {       
        $responsables = DB::table('sols_solicitudes_responsables as s')
                        ->select('id_responsable')
                        ->where('id_solicitud', '=', $IdSolcitud)
                        ->get();

        $usuarios = array();
        foreach ($responsables as $responsable)
        {
            $usuarios[] = $responsable->id_responsable;
        }      

        return DB::table('users as u')
                ->join('departamentos as d', 'u.id_departamento', '=', 'd.id_departamento')
                
                ->select(
                    'u.id',
                    'u.name',
                    'u.email',  
                    'd.nombre_departamento'
                )
                ->where('u.activo', '=', 'SI')
                ->where('u.responsable_servicios', '=', 'SI')
                ->where('u.id_departamento', '=', $IdDepartamento)
                ->whereNotIn('u.id', $usuarios) //NO INCLUIR USUARIO ADMINISTRADOR
                ->orderBy('u.name')
                ->get();
    }

    public function usuarioscorreo()
    {
        return $this->belongsTo(Usuarios_CorreosModel::class, 'id_usuario');
    }
    
    public function departamento()
    {
        return $this->belongsTo(DepartamentosModel::class, 'id_departamento');
    }

    public function almacenes()
    {
        return $this->belongsToMany(AlmacenesModel::class,'almacen_usuario','id','id_almacen');
    }
}
