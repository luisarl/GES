<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AlmacenesModel extends Model
{
    use HasFactory;

    protected $table = 'almacenes';
    protected $primaryKey = 'id_almacen';

    protected $fillable = [
        'id_almacen',
    	'nombre_almacen',
        'responsable',
        'correo',
        'superior',
        'correo2',
        'id_empresa',
    ];


    protected $dateFormat = 'Y-d-m H:i:s'; //funcioon para formateo de la fecha


    public static function VistaAlmacenes(){

        return DB::table('almacenes as a')
                    ->join('empresas as e', 'a.id_empresa', '=', 'e.id_empresa')
                    ->select(
                        'a.id_almacen',
                        'a.nombre_almacen',
                        'e.nombre_empresa',
                        'a.responsable',
                        'a.correo',
                        'e.base_datos'
                     )
                    ->get();
    }

    //Relacion de muchos a muchos entre articulos y almacenes
    public function articulos()
    {
        return $this->belongsToMany(Articulo::class,'articulo_migracion','id_articulo','id_almacen');
    }
    //Relacion de muchos a muchos entre usuario y almacenes
    public function usuarios()
    {
        return $this->belongsToMany(User::class,'almacen_usuario','id','id_almacen');
    }
    //Relacion de con empresas
    public function empresa()
    {
        return $this->belongsTo(EmpresasModel::class, 'id_empresa');
    }
    //Relacion de con Salida de Materiales
    public function salida()
    {
        return $this->hasMany(Asal_SalidasModel::class, 'id_salida');
    }
    
    public function ubicaciones()
    {
        return $this->hasMany(Cnth_UbicacionesModel::class, 'id_ubicacion');
    }

    public function herramientas()
    {
        return $this->hasMany(Cnth_HerramientasModel::class, 'id_herramienta');
    }

    public function movimientos()
    {
        return $this->hasOne(Cnth_MovimientosModel::class, 'id_movimiento');
    }
    //Relacion de con subalmacen
    public function subalmacenes()
    {
        return $this->hasMany(Fict_SubalmacenesModel::class, 'id_subalmacen');
    }
}
