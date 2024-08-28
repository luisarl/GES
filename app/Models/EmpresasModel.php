<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmpresasModel extends Model
{
    use HasFactory;
    
    protected $table = 'empresas';
    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        'id_empresa',
    	'nombre_empresa',
        'direccion',
        'rif',
        'base_datos',
        'visible_ficht',
        'alias_empresa',
        'presidente' ,
        'correo_presidente',
        'responsable_almacen',
        'correo_responsable',
        'superior_almacen' ,
        'correo_superior' ,

    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcioon para formateo de la fecha
    
    public static function EmpresaSegunAlmacen($IdAlmacen)
    {
        return DB::table('almacenes as a')
                ->join('empresas as e', 'e.id_empresa', '=', 'a.id_empresa')
                ->select(
                    'a.id_almacen', 
                    'a.nombre_almacen',
                    'a.id_empresa',
                    'e.nombre_empresa',
                    'e.base_datos'
                )
                ->where('a.id_almacen', '=', $IdAlmacen)
                ->first();
    }
   
    public static function EmpresaAlmacenSubalmacen($IdAlmacen, $IdSubAlmacen)
    {
        return DB::table('empresas as e')
            ->join('almacenes as a', 'a.id_empresa', '=', 'e.id_empresa')
            ->join('subalmacenes as s', 's.id_almacen', '=', 'a.id_almacen')
            ->select(
                'e.id_empresa',
                'e.nombre_empresa',
                'e.base_datos',
                'a.id_almacen',
                'a.nombre_almacen',
                's.id_subalmacen',
                's.nombre_subalmacen',
                's.codigo_subalmacen'
            )
            ->where('a.id_almacen', '=', $IdAlmacen)
            ->where('s.id_subalmacen', '=', $IdSubAlmacen)
            ->first();
    } 

    //Relacion de con almacenes
    public function almacenes()
    {
        return $this->hasMany(AlmacenesModel::class, 'id_almacen');
    }
}
