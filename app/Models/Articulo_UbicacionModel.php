<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Articulo_UbicacionModel extends Model
{
    use HasFactory;
    protected $table = 'articulo_ubicacion';

    protected $primaryKey = 'id_articulo_ubicacion';


    protected $fillable = [
        'id_articulo_ubicacion',
        'id_articulo',
        'id_almacen',
        'id_subalmacen',
        'id_ubicacion',
        'zona'
];

protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

public static function ConsultarArticulosUbicaciones($IdUsuario)
{
    return DB::table('articulo_ubicacion as au')
    ->join('articulos as ar', 'ar.id_articulo', '=', 'au.id_articulo')
    ->join('almacenes as a', 'a.id_almacen', '=', 'au.id_almacen')
    ->join('almacen_usuario as ua', 'ua.id_almacen', '=', 'au.id_almacen')
    // ->join('empresas as e', 'e.id_empresa', '=', 'a.id_empresa')
    ->join('subalmacenes as sa', 'sa.id_subalmacen', '=', 'au.id_subalmacen')
    ->join('ubicaciones as u', 'u.id_ubicacion', '=', 'au.id_ubicacion')
    ->select(
        'au.id_articulo_ubicacion',
        'au.zona',
        'ar.id_articulo',
        'ar.codigo_articulo',
        'ar.nombre_articulo',
        'a.nombre_almacen',
        // 'a.id_empresa',
        // 'e.base_datos',
        'sa.nombre_subalmacen',
        'u.nombre_ubicacion',
     )
    ->where('ua.id', '=', $IdUsuario)
    ->get();
}

public static function ConsultarArticuloPorUbicacion($IdUsuario, $IdArticulo)
{
    return DB::table('articulo_ubicacion as au')
    ->join('articulos as ar', 'ar.id_articulo', '=', 'au.id_articulo')
    ->join('almacenes as a', 'a.id_almacen', '=', 'au.id_almacen')
    ->join('almacen_usuario as ua', 'ua.id_almacen', '=', 'au.id_almacen')
    // ->join('empresas as e', 'e.id_empresa', '=', 'a.id_empresa')
    ->join('subalmacenes as sa', 'sa.id_subalmacen', '=', 'au.id_subalmacen')
    ->join('ubicaciones as u', 'u.id_ubicacion', '=', 'au.id_ubicacion')
    ->select(
        'au.id_articulo_ubicacion',
        'au.zona',
        'ar.id_articulo',
        'ar.codigo_articulo',
        'ar.nombre_articulo',
        'a.id_almacen',
        'a.nombre_almacen',
        // 'a.id_empresa',
        // 'e.base_datos',
        'sa.id_subalmacen',
        'sa.nombre_subalmacen',
        'u.id_ubicacion',
        'u.nombre_ubicacion',
     )
    ->where('ua.id', '=', $IdUsuario)
    ->where('ar.id_articulo', '=', $IdArticulo)
    ->get();
}


public static function ReporteArticulosUbicaciones($id_almacen, $id_subalmacen, $id_ubicacion)
{
    return DB::table('articulo_ubicacion as au')
    ->join('articulos as ar', 'ar.id_articulo', '=', 'au.id_articulo')
    ->join('almacenes as a', 'a.id_almacen', '=', 'au.id_almacen')
    ->join('empresas as e', 'e.id_empresa', '=', 'a.id_empresa')
    ->join('subalmacenes as sa', 'sa.id_subalmacen', '=', 'au.id_subalmacen')
    ->join('ubicaciones as u', 'u.id_ubicacion', '=', 'au.id_ubicacion')
    ->select(
        'au.id_articulo_ubicacion',
        'au.zona',
        'ar.id_articulo',
        'ar.codigo_articulo',
        'ar.nombre_articulo',
        'a.id_almacen',
        'a.nombre_almacen',
        'a.id_empresa',
        'e.base_datos',
        'sa.id_subalmacen',
        'sa.nombre_subalmacen',
        'u.id_ubicacion',
        'u.nombre_ubicacion',
    )
    ->where('au.id_almacen', '=', $id_almacen)
    ->where('au.id_subalmacen', '=', $id_subalmacen)
    ->where('u.id_ubicacion', '=', $id_ubicacion)
    ->get();
    
}

public static function FiltroArticulosUbicaciones($IdArticulo, $IdGrupo, $IdCategoria, $IdAlmacen, $IdSubAlmacen, $IdUbicacion)
{
        
    if($IdArticulo == 0 && $IdGrupo == 0 && $IdCategoria == 0 )
    {
        return DB::table('articulos as a')
            ->leftJoin('articulo_ubicacion as u', 'u.id_articulo', '=', 'a.id_articulo' )
            ->select(
                DB::raw("ISNULL(u.id_articulo_ubicacion, 0) as id_articulo_ubicacion"),
                'a.id_articulo',
                'a.codigo_articulo',
                'a.nombre_articulo',
                DB::raw("ISNULL(u.zona, ' ') as zona"),
                'a.id_grupo',
                'a.id_subgrupo',
                'a.id_categoria'
            )
            ->where('u.id_almacen', '=', $IdAlmacen)
            ->where('u.id_subalmacen', '=', $IdSubAlmacen)
            ->where('u.id_ubicacion', '=', $IdUbicacion)
            ->get();    
    }
    else
        {
            
        $articulos = DB::table('articulos as a')
                    //->leftJoin('articulo_ubicacion as u', 'u.id_articulo', '=', 'a.id_articulo' )
                    ->leftJoin('articulo_ubicacion as u', function($join) use ($IdAlmacen, $IdSubAlmacen, $IdUbicacion) 
                    {
                        $join->on('u.id_articulo', '=', 'a.id_articulo');
                        $join->on('u.id_almacen', '=', DB::raw("'".$IdAlmacen."'"));
                        $join->on('u.id_subalmacen', '=', DB::raw("'".$IdSubAlmacen."'"));
                        $join->on('u.id_ubicacion', '=', DB::raw("'".$IdUbicacion."'"));
                    })
                    ->select(
                        DB::raw("ISNULL(u.id_articulo_ubicacion, 0) as id_articulo_ubicacion"),
                        'a.id_articulo',
                        'a.codigo_articulo',
                        'a.nombre_articulo',
                        DB::raw("ISNULL(u.zona, ' ') as zona"),
                        'a.id_grupo',
                        'a.id_subgrupo',
                        'a.id_categoria'
                    );

                    if($IdArticulo != 0)
                    {
                        $articulos->where('a.codigo_articulo', '=', $IdArticulo);
                    }
                
                    if($IdGrupo > 0)
                    {
                        $articulos->where('a.id_grupo', '=', $IdGrupo);
                    }

                    if($IdCategoria > 0)
                    {
                        $articulos->where('a.id_categoria', '=', $IdCategoria);
                    }
                
            return $articulos->get();
        }            
}

    public static function ZonasArticuloSubAlmacen($IdArticulo, $IdAlmacen, $IdSubAlmacen)
    {
        return DB::table('articulo_ubicacion as au')
        ->join('articulos as ar', 'ar.id_articulo', '=', 'au.id_articulo')
        ->join('almacenes as a', 'a.id_almacen', '=', 'au.id_almacen')
        ->join('empresas as e', 'e.id_empresa', '=', 'a.id_empresa')
        ->join('subalmacenes as sa', 'sa.id_subalmacen', '=', 'au.id_subalmacen')
        ->join('ubicaciones as u', 'u.id_ubicacion', '=', 'au.id_ubicacion')
        ->select(
            'au.id_articulo_ubicacion',
            'au.zona',
            'ar.id_articulo',
            'ar.codigo_articulo',
            'ar.nombre_articulo',
            'a.id_almacen',
            'a.nombre_almacen',
            'a.id_empresa',
            'e.base_datos',
            'sa.id_subalmacen',
            'sa.nombre_subalmacen',
            'u.id_ubicacion',
            'u.nombre_ubicacion',
        )
        ->where('ar.id_articulo', '=', $IdArticulo)
        ->where('au.id_almacen', '=', $IdAlmacen)
        ->where('au.id_subalmacen', '=', $IdSubAlmacen)
        ->get();
    }

    public static function DetalleUbicacionArticuloAlmacenen($CodigoArticulo, $IdAlmacen)
    {
        return DB::table('articulos as a')
                ->join('articulo_migracion as am', 'am.id_articulo', '=', 'a.id_articulo')
                ->join('empresas as e', 'e.id_empresa', '=', 'am.id_empresa')
                ->join('almacenes as alm', 'alm.id_empresa', '=', 'am.id_empresa')
                ->join('subalmacenes as sub', 'sub.id_almacen', '=', 'alm.id_almacen')
                ->leftJoin('articulo_ubicacion as au', function($join) 
                    {
                        $join->on('au.id_articulo', '=', 'a.id_articulo');
                        $join->on('au.id_subalmacen', '=', 'sub.id_subalmacen');
                    })
                ->leftJoin('ubicaciones as ub', 'ub.id_ubicacion', '=', 'au.id_ubicacion')
                ->select(    
                    'a.id_articulo',
                    'a.codigo_articulo',
                    'a.imagen_articulo',
                    'a.nombre_articulo',
                    'am.id_empresa ',
                    'e.nombre_empresa',
                    'e.base_datos',
                    'alm.id_almacen',
                    'alm.nombre_almacen',
                    'sub.id_subalmacen',
                    'sub.nombre_subalmacen',
                    'sub.codigo_subalmacen',
                    'sub.nombre_subalmacen',
                    'au.id_ubicacion',
                    'ub.nombre_ubicacion',
                    'au.zona'
                )
                ->where('a.codigo_articulo', $CodigoArticulo)
                ->where('alm.id_almacen', $IdAlmacen)
                ->get();
    }
}
