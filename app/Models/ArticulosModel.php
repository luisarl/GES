<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ArticulosModel extends Model
{
    use HasFactory;

    protected $table = 'articulos';
    protected $primaryKey = 'id_articulo';

    protected $fillable = [
        'id_articulo',
        'codigo_articulo',
        'correlativo',
        'nombre_articulo',
        'descripcion_articulo',
        'referencia',
        'imagen_articulo',
        'documento_articulo',
        'pntominimo_articulo',
        'pntomaximo_articulo',
        'pntopedido_articulo',
        'equi_unid_pri',
        'equi_unid_sec',
        'equi_unid_ter',
        'tipo_unidad',
        'id_subgrupo',
        'id_categoria',
        'id_unidad',
        'id_unidad_sec',
        'id_unidad_ter',
        'id_grupo',
        'id_tipo',
        'id_color',
        'id_proveedor',
        'id_procedencia',
        'id_impuesto',
        'creado_por',
        'actualizado_por',
        'estatus',
        'activo',
        'aprobado',
        'aprobado_por',
        'fecha_aprobacion'

    ];

    //OBTIENE EL DETALLE DE UN ARTICULO
    public static function DetalleArticulo($IdArticulo){

        return DB::table('articulos as a')
                    ->join('grupos as g', 'g.id_grupo', '=', 'a.id_grupo')
                    ->join('subgrupos as s', 's.id_subgrupo', '=', 'a.id_subgrupo')
                    ->join('categorias as c', 'c.id_categoria', '=', 'a.id_categoria')
                    ->join('unidades as u', 'u.id_unidad', '=', 'a.id_unidad')
                    ->join('unidades as u2', 'u2.id_unidad', '=', 'a.id_unidad_sec')
                    ->join('users as us', 'us.id', '=', 'a.creado_por')
                    ->join('users as use', 'use.id', '=', 'a.actualizado_por')
                    ->select(
                        'a.id_articulo',
                        'a.codigo_articulo',
                        'a.nombre_articulo',
                        'a.descripcion_articulo',
                        'a.correlativo',
                        'a.referencia',
                        'a.tipo_unidad',
                        'a.imagen_articulo',
                        'a.documento_articulo',
                        'g.codigo_grupo as grupo', 'g.nombre_grupo',
                        's.codigo_subgrupo AS subgrupo', 's.nombre_subgrupo',
                        'c.codigo_categoria AS categoria', 'c.nombre_categoria',
                        'a.id_unidad', 'u.abreviatura_unidad AS unidad', 'u.nombre_unidad',
                        'u2.abreviatura_unidad AS unidad_sec', 'u2.nombre_unidad AS nombre_unidad_sec' ,
                        DB::raw('(select nombre_unidad from unidades where id_unidad = a.id_unidad_ter) AS nombre_unidad_alt'),
                        'a.id_unidad_ter AS unidad_ter',
                        'a.equi_unid_pri as equivalencia1',
                        'a.equi_unid_sec as equivalencia2',
                        'a.equi_unid_ter as equivalencia3',
                        'a.pntominimo_articulo AS minimo',
                        'a.pntomaximo_articulo AS maximo',
                        'a.pntopedido_articulo AS pedido',
                        'a.id_color AS color',
                        'a.id_proveedor AS proveedor',
                        'a.id_procedencia AS procedencia',
                        'a.id_tipo AS tipo',
                        'a.id_impuesto AS impuesto',
                        'a.creado_por',
                        'us.name AS nombre_usuario_c',
                        'a.actualizado_por',
                        'use.name AS nombre_usuario_a',
                        'a.estatus',
                        'a.activo',
                        'a.aprobado',
                        DB::raw('(select name from users where id = a.aprobado_por) AS aprobado_por'),
                        'a.fecha_aprobacion'
                     )
                    ->where('a.id_articulo', '=', $IdArticulo)
                    ->first();
    }

     //OBTIENE EL DETALLE DE TODOS LOS ARTICULOS
    public static function DatosArticulos(){

        return DB::table('articulos as a')
                    ->join('grupos as g', 'g.id_grupo', '=', 'a.id_grupo')
                    ->join('subgrupos as s', 's.id_subgrupo', '=', 'a.id_subgrupo')
                    ->join('categorias as c', 'c.id_categoria', '=', 'a.id_categoria')
                    ->join('unidades as u', 'u.id_unidad', '=', 'a.id_unidad')
                    ->join('unidades as u2', 'u2.id_unidad', '=', 'a.id_unidad_sec')
                    ->join('users as us', 'us.id', '=', 'a.creado_por')
                    ->join('users as use', 'use.id', '=', 'a.actualizado_por')
                    ->select(
                        'a.id_articulo',
                        'a.codigo_articulo',
                        'a.nombre_articulo',
                        'a.descripcion_articulo',
                        'a.correlativo',
                        'a.referencia',
                        'a.tipo_unidad',
                        'a.imagen_articulo',
                        'a.documento_articulo',
                        'g.codigo_grupo as grupo', 'g.nombre_grupo',
                        's.codigo_subgrupo AS subgrupo', 's.nombre_subgrupo',
                        'c.codigo_categoria AS categoria', 'c.nombre_categoria',
                        'a.id_unidad', 'u.abreviatura_unidad AS unidad', 'u.nombre_unidad',
                        'u2.abreviatura_unidad AS unidad_sec', 'u2.nombre_unidad AS nombre_unidad_sec' ,
                        'a.id_unidad_ter AS unidad_ter',
                        'a.equi_unid_pri as equivalencia1',
                        'a.equi_unid_sec as equivalencia2',
                        'a.equi_unid_ter as equivalencia3',
                        'a.pntominimo_articulo AS minimo',
                        'a.pntomaximo_articulo AS maximo',
                        'a.pntopedido_articulo AS pedido',
                        'a.id_color AS color',
                        'a.id_proveedor AS proveedor',
                        'a.id_procedencia AS procedencia',
                        'a.id_tipo AS tipo',
                        'a.id_impuesto AS impuesto',
                        'a.creado_por',
                        'us.name AS nombre_usuario_c',
                        'a.actualizado_por',
                        'use.name AS nombre_usuario_a',
                        'a.estatus',
                        'a.activo',
                        'a.aprobado',
                        DB::raw('(select name from users where id = a.aprobado_por) AS aprobado_por'),
                        'a.fecha_aprobacion'
                     )
                    ->get();
    }

     //OBTIENE EL DETALLE DE LOS ULTIMOS 10 ARTICULOS CREADOS
    public static function UltimosArticulos(){

        return DB::table('articulos as a')
                    ->join('grupos as g', 'g.id_grupo', '=', 'a.id_grupo')
                    ->join('subgrupos as s', 's.id_subgrupo', '=', 'a.id_subgrupo')
                    ->join('categorias as c', 'c.id_categoria', '=', 'a.id_categoria')
                    ->join('unidades as u', 'u.id_unidad', '=', 'a.id_unidad')
                    ->join('unidades as u2', 'u2.id_unidad', '=', 'a.id_unidad_sec')
                    ->join('users as us', 'us.id', '=', 'a.creado_por')
                    ->join('users as use', 'use.id', '=', 'a.actualizado_por')
                    ->select(
                        'a.id_articulo',
                        'a.codigo_articulo',
                        'a.nombre_articulo',
                        'a.descripcion_articulo',
                        'a.correlativo',
                        'a.referencia',
                        'a.tipo_unidad',
                        'a.imagen_articulo',
                        'a.documento_articulo',
                        'g.codigo_grupo as grupo', 'g.nombre_grupo',
                        's.codigo_subgrupo AS subgrupo', 's.nombre_subgrupo',
                        'c.codigo_categoria AS categoria', 'c.nombre_categoria',
                        'a.id_unidad', 'u.abreviatura_unidad AS unidad', 'u.nombre_unidad',
                        'u2.abreviatura_unidad AS unidad_sec', 'u2.nombre_unidad AS nombre_unidad_sec' ,
                        'a.id_unidad_ter AS unidad_ter',
                        'a.equi_unid_pri as equivalencia1',
                        'a.equi_unid_sec as equivalencia2',
                        'a.equi_unid_ter as equivalencia3',
                        'a.pntominimo_articulo AS minimo',
                        'a.pntomaximo_articulo AS maximo',
                        'a.pntopedido_articulo AS pedido',
                        'a.id_color AS color',
                        'a.id_proveedor AS proveedor',
                        'a.id_procedencia AS procedencia',
                        'a.id_tipo AS tipo',
                        'a.id_impuesto AS impuesto',
                        'a.creado_por',
                        'us.name AS nombre_usuario_c',
                        'a.actualizado_por',
                        'use.name AS nombre_usuario_a',
                        'a.estatus'
                     )
                     ->where('a.activo', '=', 'SI')
                     ->orderByDesc('a.id_articulo')
                    ->limit(10)
                    ->get();
    }

    //OBTIENE LOS DATOS A MOSTRAR EN LA VISTA DE LOS ARTICULOS
    public static function VistaArticulos(){

        return DB::table('articulos as a')
                    ->join('grupos as g', 'g.id_grupo', '=', 'a.id_grupo')
                    ->join('users as u', 'u.id', '=', 'a.creado_por')
                       ->select(
                        'a.id_articulo',
                        'a.codigo_articulo',
                        'a.nombre_articulo',
                        'a.imagen_articulo',
                        'g.codigo_grupo as grupo', 'g.nombre_grupo',
                        'a.estatus',
                        'a.activo',
                        'a.updated_at',
                        'u.name as creado_por'
                     )
                    ->orderByDesc('a.updated_at')   
                    ->get();
    }

    //OBTIENE LOS DATOS DE LOS ARTICULOS ACTIVOS
    public static function VistaArticulosActivos(){

        return DB::table('articulos as a')
                    ->join('grupos as g', 'g.id_grupo', '=', 'a.id_grupo')
                    ->join('users as u', 'u.id', '=', 'a.creado_por')
                        ->select(
                        'a.id_articulo',
                        'a.codigo_articulo',
                        'a.nombre_articulo',
                        'a.imagen_articulo',
                        'g.codigo_grupo as grupo', 'g.nombre_grupo',
                        'a.estatus',
                        'a.activo',
                        'a.updated_at',
                        'u.name as creado_por'
                        )
                    ->where('a.activo', '=', 'SI')
                    ->orderByDesc('a.updated_at')   
                    ->get();
    }

    public static function ResponsablesArticulo($IdArticulo)
    {
        return DB::table('articulos')
                ->select(
                    DB::raw('(select name from users where id = creado_por) as creado_por'),
                    DB::raw("CONVERT(VARCHAR(10), created_at, 103) + ' ' + RIGHT(CONVERT(VARCHAR, created_at, 100), 7) as fecha_creacion"),
                    DB::raw('(select name from users where id = actualizado_por) as actualizado_por'),
                    DB::raw("CONVERT(VARCHAR(10), updated_at, 103) + ' ' + RIGHT(CONVERT(VARCHAR, updated_at, 100), 7) as fecha_actualizacion"),
                    DB::raw('(select name from users where id = aprobado_por) as aprobado_por'),
                    DB::raw("CONVERT(VARCHAR(10), fecha_aprobacion, 103) + ' ' + RIGHT(CONVERT(VARCHAR, fecha_aprobacion, 100), 7) as fecha_aprobacion"),
                    DB::raw('(select name from users where id = catalogado_por) as catalogado_por'),
                    DB::raw("CONVERT(VARCHAR(10), fecha_catalogacion, 103) + ' ' + RIGHT(CONVERT(VARCHAR, fecha_catalogacion, 100), 7) as fecha_catalogacion")
                )
                ->where('id_articulo', '=', $IdArticulo)
                ->first();
    }

    public static function UnidadesArticulos($IdArticulo)
    {
        return DB::select(
            "
            SELECT * 
                FROM   
                (
                select 
                a.id_articulo, 
                a.codigo_articulo, 
                a.nombre_articulo, 
                --a.id_unidad, 
                u.nombre_unidad as unidad1, 
                -- a.id_unidad_sec, 
                u2.nombre_unidad as unidad2, 
                --a.id_unidad_ter,
                (select nombre_unidad from unidades where id_unidad = a.id_unidad_ter) AS unidad3
                from articulos a
                inner join unidades u ON u.id_unidad = a.id_unidad
                inner join unidades u2 ON u2.id_unidad = a.id_unidad_sec
                where a.codigo_articulo = '$IdArticulo'
                ) p  
                UNPIVOT  
                (nombre_unidad FOR unidad IN   
                    (unidad1, unidad2, unidad3)  
                )AS unpvt;  
            "
        );
    }

    public static function ImportarArticulo($CodidoArticulo)
    {

        return DB::table('articulos as a')
                    ->join('grupos as g', 'g.id_grupo', '=', 'a.id_grupo')
                    ->join('subgrupos as s', 's.id_subgrupo', '=', 'a.id_subgrupo')
                    ->join('categorias as c', 'c.id_categoria', '=', 'a.id_categoria')
                    ->select(
                        'a.id_articulo',
                        'a.codigo_articulo',
                        'a.nombre_articulo',
                        'a.descripcion_articulo',
                        'a.imagen_articulo',
                        'a.id_grupo',
                        'a.id_subgrupo',
                        'a.id_categoria',
                        'g.codigo_grupo as grupo', 'g.nombre_grupo', 'g.codigo_grupo',
                        's.codigo_subgrupo AS subgrupo', 's.nombre_subgrupo', 's.codigo_subgrupo',
                        'c.codigo_categoria AS categoria', 'c.nombre_categoria', 'c.codigo_categoria',
                    )                    
                    ->where('a.codigo_articulo', '=', $CodidoArticulo)
                    ->first();
    }
    //MOSTRAR DATOS DEL ARTICULO FILTRADO POR EL GRUPO 
   public static function ArticuloPorGrupo($IdGrupo)
   {
    return DB::table('articulos as a')
            ->join('grupos as g', 'g.id_grupo', '=', 'a.id_grupo')
            ->select(
                'a.id_articulo',
                'a.codigo_articulo',
                'a.nombre_articulo',
                'g.codigo_grupo as grupo', 'g.nombre_grupo',
             )
            ->where('g.id_grupo', '=', $IdGrupo)
            ->first();
    }

    public static function FechasFichasTecnicas($FechaInicio, $FechaFin)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('d-m-Y');
        $FechaFin = Carbon::parse($FechaFin)->format('d-m-Y');
        
        return DB::table('articulos as a')
            ->join('users as u', 'u.id', '=', 'a.creado_por')
            ->leftJoin('users as uc', 'uc.id', '=', 'a.catalogado_por')
            ->leftJoin('users as ua', 'ua.id', '=', 'a.aprobado_por')
            ->leftJoin('users as uac', 'uac.id', '=', 'a.actualizado_por')
            ->select(
                'a.id_articulo',
                'a.codigo_articulo',
                'a.nombre_articulo',
                'u.name as creado_por',
                'ua.name as aprobado_por',
                'uc.name as catalogado_por',
                'uac.name as actualizado_por',
                'a.created_at as fecha_creacion',
                'a.fecha_aprobacion',
                'a.fecha_catalogacion',
                'a.updated_at as fecha_actualizacion'
            )
            ->whereBetween(DB::raw("convert(date, a.updated_at)"), [$FechaInicio, $FechaFin])
            ->get();
    }

    public static function CatalogacionArticulos($FechaInicio, $FechaFin)
    {
        return DB::table('articulo_migracion')
            ->select(
                DB::raw('CONVERT(date, updated_at, 103) as fecha'),
                DB::raw('COUNT(*) as total'),
                'nombre_usuario'
            )
            ->whereNotNull('nombre_usuario')
            ->whereBetween(DB::raw('CONVERT(date,updated_at)'), [$FechaInicio, $FechaFin])
            ->groupBy(DB::raw('CONVERT(date, updated_at, 103)'), 'nombre_usuario')
            ->orderBY(DB::raw('CONVERT(date, updated_at, 103)' ), 'desc')
            ->get();
    }

    public static function BuscarArticulos($articulo)
    {
        return DB::select("
            SELECT codigo_articulo  AS codigo, nombre_articulo  as nombre from articulos
            WHERE estatus = 'MIGRADO' 
            AND nombre_articulo like '%'+'$articulo'+'%' or codigo_articulo like  '%'+'$articulo'+'%'
        ");
    }

    protected $dateFormat = 'Y-d-m H:i:s'; //funcion para formateo de la fecha

    //Relacion de subgrupo
    public function subgrupo()
    {
        return $this->belongsTo(SubgruposModel::class, 'id_subgrupo');
    }
    //Relacion de muchos a muchos entre unidades y articulos
    public function unidades()
    {
        return $this->belongsTo(UnidadesModel::class, 'id_unidad');
    }
    public function unidad_sec()
    {
        return $this->belongsTo(UnidadesModel::class, 'id_unidad');
    }
    public function unidad_ter()
    {
        return $this->belongsTo(UnidadesModel::class, 'id_unidad');
    }
    //Relacion de categoria
    public function categoria()
    {
        return $this->belongsTo(CategoriasModel::class, 'id_categoria');
    }
    //Relacion de grupo
    public function grupo()
    {
        return $this->belongsTo(GruposModel::class, 'id_grupo');
    }
    //Relacion de muchos a muchos entre almacenes y articulos
    public function almacenes()
    {
        return $this->belongsToMany(AlmacenesModel::class,'articulo_migracion','id_almacen','id_articulo');
    }

}
