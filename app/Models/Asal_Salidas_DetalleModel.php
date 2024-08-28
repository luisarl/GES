<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Asal_Salidas_DetalleModel extends Model
{
    
    use HasFactory;

    protected $table = 'asal_salidas_detalle';
    protected $primaryKey = 'id_detalle'; 

    protected $fillable = [
        'id_detalle',
        'id_salida',
        'item',
        'codigo_articulo',
        'nombre_articulo',
        'retorna',
        'tipo_unidad',
        'cantidad_salida',
        'fecha_salida',
        'comentario',
        'usuario_retorno',
        'cantidad_retorno',
        'fecha_retorno',
        'observacion',
        'estatus',
        'importacion',  
        'cerrado',
        'usuario_cierre',
        'fecha_cierre',
        'observacion_almacen'  
    ];

    public static function DetalleSalida($IdSalida)
    {
        return DB::table('asal_salidas_detalle')
                ->select(
                    'id_detalle',
                    'id_salida',
                    'item',
                    'codigo_articulo',
                    'nombre_articulo',
                    'comentario',
                    'tipo_unidad',
                    DB::raw("CONVERT(VARCHAR(10), fecha_salida, 105) + ' ' + RIGHT(CONVERT(VARCHAR, fecha_salida, 100), 7) as fecha_salida"),
                    'usuario_retorno',
                    DB::raw('CAST(cantidad_salida AS decimal(18,2)) as cantidad_salida'),
                    DB::raw("CONVERT(VARCHAR(10), fecha_retorno, 105) + ' ' + RIGHT(CONVERT(VARCHAR, fecha_retorno, 100), 7) as fecha_retorno"),
                    DB::raw('CAST(cantidad_retorno AS decimal(18,2)) as cantidad_retorno'),
                    'estatus',
                    'observacion',
                    'importacion',
                    'cerrado',
                    'observacion_almacen'
                )
                ->orderBy('item')
                ->orderBy('fecha_retorno')
                ->where('id_salida', '=', $IdSalida)
                ->get();
    }

    public static function NotaEntregaProfit($bd, $numero)
    {
        return DB::connection('profit')
                ->table($bd.'.dbo.reng_nde as r')
                ->join($bd.'.dbo.art as a', 'r.co_art', '=', 'a.co_art')
                ->join($bd.'.dbo.unidades as u', 'r.uni_venta', '=', 'u.co_uni')
                ->select(
                    'r.fact_num',
                    'r.reng_num',
                    'r.co_art as codigo_articulo',
                    'a.art_des as nombre_articulo',
                    DB::raw('CAST(r.total_art AS decimal(18,2)) as cantidad'),
                    'u.des_uni as unidad'
                )
                ->where('r.fact_num', '=', $numero)
                ->get();
    }


    public static function CierreArticulos($IdDetalle)
    {
        $CantidadPendiente = DB::table('asal_salidas_detalle')
            ->selectRaw('SUM(isnull(cantidad_salida,0) - isnull(cantidad_retorno,0)) as cantidad_pendiente')
            ->where('id_detalle', '=', $IdDetalle)
            ->where('estatus', '=', NULL)
            ->value('cantidad_pendiente');

            if($CantidadPendiente == 0 )
            {
                DB::table('asal_salidas_detalle')
                    ->where('id_detalle', '=', $IdDetalle)
                    ->where('estatus', '=', NULL)
                            ->update([
                                'estatus' =>  'CERRADO'
                            ]);
            }
    }

    public static function CantidadPendiente($IdSalida)
    {
        return DB::table('asal_salidas_detalle')
            ->selectRaw('SUM(isnull(cantidad_salida,0) - isnull(cantidad_retorno,0)) as cantidad_pendiente')
            ->where('id_salida', '=', $IdSalida)
            ->where('estatus', '=', NULL)
            ->value('cantidad_pendiente');
    }

    public static function BuscarArticulos($articulo)
    {
        return DB::select("
            SELECT codigo, nombre
                from (	
                    SELECT codigo_articulo  AS codigo, nombre_articulo  as nombre from articulos
                    WHERE estatus = 'MIGRADO'
                    UNION 
                    SELECT codigo_herramienta COLLATE Modern_Spanish_CI_AS AS codigo, nombre_herramienta COLLATE Modern_Spanish_CI_AS as nombre  from cnth_herramientas 
                )
                as articulos
            WHERE  nombre like '%'+'$articulo'+'%' or codigo like  '%'+'$articulo'+'%'
        ");
    }
    
    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    //Relacion de con articulo
    public function articulos()
    {
        return $this->hasMany(ArticulosModel::class, 'id_articulo');
    }

        //Relacion de con articulo
    public function salidas()
    {
        return $this->hasMany(Asal_SalidasModel::class, 'id_salida');
    }
}
