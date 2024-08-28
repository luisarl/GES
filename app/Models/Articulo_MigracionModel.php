<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Articulo_MigracionModel extends Model
{
    use HasFactory;

    protected $table = 'articulo_migracion';
    protected $primaryKey = 'id_articulo';

    protected $fillable = [
    	'id_articulo',
		'id_empresa',
        'nombre_usuario',
        'nombre_equipo',
        'direccion_ip',
        'solicitado',
        'nombre_solicitante',
        'fecha_solicitud',
        'migrado'
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcion para formateo de la fecha

    //Funcion que guarda articulo en profit
    public static function MigrarArticuloProfit($bd, $codigo, $nombre, $correlativo, $referencia, $fecha, $grupo, $subgrupo, $categoria, $unidad, $unidadsec, $unidadter, $minimo, $maximo,
    $pedido, $color, $proveedor, $procedencia,  $tipo, $impuesto, $tipounidad, $equivalencia1, $equivalencia2, $equivalencia3)
    {
        if($tipounidad == 'SIMPLE')
        {
            $tipounidad = 1;
        }
        else
            {
                $tipounidad = 4;
            }

        if($unidadter == 0)
            {
                $tuni_venta = " ";
            }
            else
                {
                    $resultado = DB::table('unidades')
                        ->select('abreviatura_unidad')
                        ->where('id_unidad', '=', $unidadter)
                        ->first();

                    $tuni_venta = $resultado->abreviatura_unidad;
                }
                    
        DB::connection('profit')
        ->table($bd.'.dbo.art')
        ->updateOrInsert(
            ['co_art' => $codigo],
            [
            'art_des' => $nombre,
            'item' => $correlativo,
            'ref' => $referencia,
            'fecha_reg' =>$fecha,
            'co_lin' =>$grupo,
            'co_subl' =>$subgrupo,
            'co_cat' =>$categoria,
            'uni_venta' => $unidad,
            'suni_venta' => $unidadsec,
            'tuni_venta' => $tuni_venta,
            'relac_aut' => $tipounidad,
            'equi_uni1' => $equivalencia1,
            'equi_uni2' => $equivalencia2,
            'equi_uni3' => $equivalencia3,
            'stock_min' => $minimo,
            'stock_max' => $maximo,
            'pto_pedido' => $pedido,
            'co_color' => '000000',
            'co_prov' => '000000000',
            'procedenci' =>'000000',
            'tipo' => $tipo,
            'tipo_imp' => 1,
            'prec_vta1' => '0.1',
            'cos_prov' => '0.1',
            'cos_merc' => '0.1',
            'cos_pro_un' => '0.1',
            'cos_un_an' => '0.1',
            'ult_cos_un' => '0.1'
        ]);

        // $RutaProfit = config('app.ruta_profit_a');

        // // GENERA ARCHIVO TXT CON DATOS DEL ARTICULO MIGRADO
        // $archivo = fopen($RutaProfit.'act_dbf\articulo.txt','w+');
        // $contenido = $bd."|".$codigo."|".$nombre."|".$correlativo."|".
        // $referencia."|".Carbon::createFromFormat('Y-d-m H:i:s', $fecha)->format('m/d/Y')."|".str_replace(" ","",$grupo)."|".str_replace(" ","",$subgrupo)."|".$categoria."|".str_replace(" ","",$unidad)."|".
        // str_replace(" ","",$unidadsec)."|".str_replace(" ","",$tuni_venta)."|".$tipounidad."|".$equivalencia1."|".$equivalencia2."|".$equivalencia3."|".
        // $minimo."|".$maximo."|".$pedido."|000000|000000000|000000|".$tipo."|1|0.1|0.1|0.1|0.1|0.1|0.1";

        // fputs($archivo,$contenido);
        // fclose($archivo);
            
        //EJECUTA EL PROGRAMA QUE INSERTA EN LAS TABLAS DBF DE PROFIT
        //exec($RutaProfit.'act_dbf\act_prov.exe', $salida);

    }

    //consulta el stock actual y pendiente de un articulo en profit
    public static function StockArticuloProfit($bd, $codigo){

        return DB::connection('profit')
        ->table($bd.'.dbo.art')
        ->select(
            'co_art',
            'art_des',
            'stock_act',
            'stock_lle',
            'stock_min',
            'stock_max',
            'pto_pedido'
            )
        ->where('co_art', '=', $codigo)
        ->first();

    }

    //consulta el stock de los almacenes de un articulo en profit
    public static function StockAlmacenesArticuloProfit($bd, $codigo){

        return DB::connection('profit')
        ->table($bd.'.dbo.st_almac as a')
        ->join($bd.'.dbo.sub_alma as b', 'a.co_alma', '=', 'b.co_sub')
        ->select(
            'a.co_alma',
	        'b.des_sub',
            'a.co_art',
            'a.stock_act',
            'a.stock_lle'
            )
        ->where('a.co_art', '=', $codigo)
        ->whereNotIn('a.co_alma', ['9999'])
        ->get();

    }

    //consulta el stock de articulo en un almacen en profit
    public static function StockArticuloAlmacenProfit($bd, $CodigoArticulo, $CodigoAlmacen)
    {

        return DB::connection('profit')
        ->table($bd.'.dbo.st_almac as a')
        ->join($bd.'.dbo.sub_alma as b', 'a.co_alma', '=', 'b.co_sub')
        ->select(
            'a.co_alma',
            'b.des_sub',
            'a.co_art',
            'a.stock_act',
            'a.stock_lle'
            )
        ->where('a.co_art', '=', $CodigoArticulo)
        ->where('a.co_alma', '=', $CodigoAlmacen)
        ->first();

    }

    public static function PuntosArticuloProfit($bd, $CodigoArticulo)
    {
        return DB::connection('profit')
        ->table($bd.'.dbo.vArticulosPuntoPedidoTodos')
        ->select(
            'co_art',
            'art_des',
            'uni_venta',
            'stock_act',
            'pto_pedido',
            'stock_ped',
            'stock_lle',
            'procedenci'
        )
        ->where('co_art', '=', $CodigoArticulo)
        ->first();
    }

    //Obtiene la suma del stock de un articulo en profit
    public static function SumaStockArticuloProfit($bd, $codigo){

        return DB::connection('profit')
        ->table($bd.'.dbo.art')
        ->select(
            'co_art',
            DB::raw('SUM(stock_act + stock_com + stock_lle  + stock_des) as total_stock')
               
            )
        ->groupBy('co_art')
        ->where('co_art', '=', $codigo)
        ->first();

    }

    //funcion que muestra el estatus de migracion de un articulo
    public static function EstatusArticuloMigracion($IdArticulo, $IdEmpresa)
    {
        return DB::table('articulo_migracion')
                    ->select(
                            'nombre_usuario',
                            'migrado', 
                            'solicitado',
                            'nombre_solicitante'
                            )
                    ->where('id_articulo', $IdArticulo)
                    ->where('id_empresa', $IdEmpresa)
                    ->first();
    }

    //funcion boolean que retorna true, si un articulo fue migrado
    public static function ArticuloMigrado($IdArticulo)
    {
        return DB::table('articulo_migracion')
                    ->select('migrado')->distinct('migrado')
                    ->where('id_articulo', '=', $IdArticulo)
                    ->where('migrado', '=', 'SI')
                    ->exists();
    }

    //funcion que obtiene el conteo de la cantidad de empresas en la que existe el articulo
    public static function ConteoMigracionAlmacenesArticulo($IdArticulo)
    {
        return DB::table('articulo_migracion')
                    ->where('id_articulo', $IdArticulo)
                    ->where('migrado', 'SI')
                    ->distinct('id_empresa')
                    ->count('id_empresa');
    }

    public static function EmpresasArticulo($IdArticulo)
    {
        return DB::table('articulo_migracion as am')
                    ->join('empresas as e', 'e.id_empresa', '=', 'am.id_empresa')
                    ->join('articulos as a', 'a.id_articulo', '=', 'am.id_articulo')
                    ->select(
                        'a.id_articulo',
                        'a.codigo_articulo',
                        'am.id_empresa',
                        'e.nombre_empresa',
                        'e.alias_empresa',
                        'e.base_datos',
                    )
                    ->where('am.migrado', 'SI')
                    //->where('a.id_articulo', $IdArticulo)
                    ->where('a.codigo_articulo', $IdArticulo)
                    ->distinct('a.id_empresa')
                    ->get();
    }

    public static function EmpresaArticulo($IdEmpresa, $IdArticulo)
    {
        return DB::table('articulo_migracion as am')
                    ->join('empresas as e', 'e.id_empresa', '=', 'am.id_empresa')
                    ->join('articulos as a', 'a.id_articulo', '=', 'am.id_articulo')
                    ->select(
                        'a.id_articulo',
                        'a.codigo_articulo',
                        'am.id_empresa',
                        'e.nombre_empresa',
                        'e.alias_empresa',
                        'e.base_datos',
                    )
                    ->where('am.migrado', 'SI')
                    //->where('a.id_articulo', $IdArticulo)
                    ->where('a.codigo_articulo', $IdArticulo)
                    ->where('e.id_empresa', $IdEmpresa)
                    ->distinct('a.id_empresa')
                    ->get();
    }
}