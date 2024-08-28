<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cnth_HerramientasModel extends Model
{
    use HasFactory;
    
    protected $table = 'cnth_herramientas';
    protected $primaryKey = 'id_herramienta';

    protected $fillable = [
        'id_herramienta',
    	'nombre_herramienta',
		'codigo_herramienta',
        'correlativo',
        'descripcion_herramienta',
        'imagen_herramienta',
        'creado_por',
        'actualizado_por',
        'id_grupo',
        'id_subgrupo',
        'id_categoria',
        'creado_por',
        'actualizado_por',
    ];

    protected $dateFormat = 'Y-d-m H:i:s'; //funcion para formateo de la fecha
    
    public static function DetallesHerramientas($IdHerramienta)
    {
        return DB::table('cnth_almacen_herramientas as h2')
            ->join('cnth_herramientas as h', 'h2.id_herramienta', '=', 'h.id_herramienta')
            ->join('cnth_ubicaciones as u', 'h2.id_ubicacion', '=', 'u.id_ubicacion')
            ->join('almacenes as a', 'h2.id_almacen', '=', 'a.id_almacen')
            ->join('cnth_grupos as g', 'g.id_grupo', '=', 'h.id_grupo')
            ->join('cnth_subgrupos as s', 's.id_subgrupo', '=', 'h.id_subgrupo')
            ->join('cnth_categorias as c', 'c.id_categoria', '=', 'h.id_categoria')
            ->select(
                'h.id_herramienta',
                'h.codigo_herramienta',
                'h.nombre_herramienta',
                'h.descripcion_herramienta',
                'h.imagen_herramienta',
                'h.descripcion_herramienta',
                'nombre_grupo',
                'nombre_subgrupo',
                'nombre_categoria',
                'a.nombre_almacen',
                'u.nombre_ubicacion',
                'h2.stock_actual',
            )
            ->where('h.id_herramienta', '=', $IdHerramienta)
            ->first();
    }

    public static function ListadoAlmacenes($IdHerramienta)
    {
        return DB::table('cnth_almacen_herramientas as h2')
            ->join('cnth_herramientas as h', 'h2.id_herramienta', '=', 'h.id_herramienta')
            ->join('cnth_ubicaciones as u', 'h2.id_ubicacion', '=', 'u.id_ubicacion')
            ->join('almacenes as a', 'h2.id_almacen', '=', 'a.id_almacen')
            ->join('empresas as e', 'h2.id_empresa', '=', 'e.id_empresa')
            ->select(
                'a.id_almacen',
                'a.nombre_almacen',
                'e.id_empresa',
                'e.nombre_empresa',
                'u.id_ubicacion',
                'u.nombre_ubicacion',
                'h2.stock_actual',
                'h2.stock_inicial',
                'h2.id_almacen_herramienta'
            )->where('h.id_herramienta', '=', $IdHerramienta)
            ->get();
    }

    public static function HerramientasRecepcionPendiente($IdUsuario)
    {
        return DB::table('cnth_movimientos_detalles as md')
            ->join('cnth_herramientas as h', 'md.id_herramienta', '=', 'h.id_herramienta')
            ->join('cnth_movimientos as m', 'md.id_movimiento', '=', 'm.id_movimiento')
            ->join('almacenes as a', 'a.id_almacen', '=', 'm.id_almacen')
            ->join('almacen_usuario as au', 'au.id_almacen', '=', 'm.id_almacen')
            ->select(
                'md.id_movimiento',
                'md.id_detalle',
                'md.id_herramienta',
                'h.nombre_herramienta',
                'md.responsable',
                'm.id_almacen',
                'a.nombre_almacen',
                'md.fecha_despacho',
                'md.cantidad_entregada',
                'md.cantidad_devuelta',
                DB::raw('isnull(md.cantidad_devuelta, 0) as cantidad_devuelta'), 
                DB::raw('(md.cantidad_entregada - isnull(md.cantidad_devuelta, 0)) as cantidad_pendiente')
                )
            ->whereNull('md.fecha_devolucion')
            ->where('au.id', '=', $IdUsuario)    
            ->groupBy(
                'md.id_movimiento',
                'md.id_detalle',
                'md.id_herramienta',
                'h.nombre_herramienta',
                'md.responsable',
                'md.fecha_despacho',
                'md.cantidad_entregada',
                'md.cantidad_devuelta',
                'md.cantidad_entregada',
                'md.cantidad_devuelta',
                'm.id_almacen',
                'a.nombre_almacen'
                )
            ->orderBy('md.id_movimiento','DESC')
            ->havingRaw('(md.cantidad_entregada - isnull(md.cantidad_devuelta, 0)) <> ?', [0])
            ->get();    


        //funcion anterior
        // return DB::table('cnth_movimientos_detalles AS m')
        // ->select(
        //     'm.id_movimiento', 
        //     'h.id_herramienta', 
        //     'h.nombre_herramienta', 
        //     'e.id_empleado', 
        //     'e.nombre_empleado', 
        //     'd.id_departamento', 
        //     'd.nombre_departamento', 
        //     'm.cantidad_entregada', 
        //     DB::raw('isnull(m.cantidad_devuelta, 0) as cantidad_devuelta'), 
        //     DB::raw('(m.cantidad_entregada - isnull(m.cantidad_devuelta, 0)) as cantidad_pendiente')
        //     )
        // ->join('cnth_herramientas AS h' ,'m.id_herramienta','=','h.id_herramienta')
        // ->join('cnth_empleados AS e','m.id_empleado','=','e.id_empleado')
        // ->join('departamentos As d','d.id_departamento','=','e.id_departamento')
        // ->groupBy('m.id_movimiento','h.id_herramienta','h.id_herramienta','h.nombre_herramienta','e.id_empleado','e.nombre_empleado','m.cantidad_entregada','m.cantidad_devuelta','d.id_departamento','d.nombre_departamento')
        // ->havingRaw('(m.cantidad_entregada - isnull(m.cantidad_devuelta, 0)) <> ?', [0])
        // ->get();
    }

    public static function HerramientasRecepcionPendienteAlmacen($IdAlmacen)
    {
        return DB::table('cnth_movimientos_detalles as md')
            ->join('cnth_herramientas as h', 'md.id_herramienta', '=', 'h.id_herramienta')
            ->join('cnth_movimientos as m', 'md.id_movimiento', '=', 'm.id_movimiento')
            ->join('almacenes as a', 'a.id_almacen', '=', 'm.id_almacen')
            ->select(
                'md.id_movimiento',
                'md.id_detalle',
                'md.id_herramienta',
                'h.nombre_herramienta',
                'md.responsable',
                'm.id_almacen',
                'a.nombre_almacen',
                'md.fecha_despacho',
                'md.cantidad_entregada',
                'md.cantidad_devuelta',
                DB::raw('isnull(md.cantidad_devuelta, 0) as cantidad_devuelta'), 
                DB::raw('(md.cantidad_entregada - isnull(md.cantidad_devuelta, 0)) as cantidad_pendiente')
                )
            ->whereNull('md.fecha_devolucion')
            ->where('a.id_almacen', '=', $IdAlmacen)    
            ->groupBy(
                'md.id_movimiento',
                'md.id_detalle',
                'md.id_herramienta',
                'h.nombre_herramienta',
                'md.responsable',
                'md.fecha_despacho',
                'md.cantidad_entregada',
                'md.cantidad_devuelta',
                'md.cantidad_entregada',
                'md.cantidad_devuelta',
                'm.id_almacen',
                'a.nombre_almacen'
                )
            ->orderBy('md.id_movimiento','DESC')
            ->havingRaw('(md.cantidad_entregada - isnull(md.cantidad_devuelta, 0)) <> ?', [0])
            ->get();   
    }

    public static function HerramientasDefectuosas()
    {
        return DB::table('cnth_movimientos_detalles AS md')
                ->join('cnth_herramientas as h', 'md.id_herramienta', '=', 'h.id_herramienta')
                ->join('cnth_movimientos as m', 'md.id_movimiento', '=', 'm.id_movimiento')
                ->join('almacenes as a', 'a.id_almacen', '=', 'm.id_almacen')
                ->select(
                    'md.id_movimiento',
                    'md.id_detalle',
                    'm.id_almacen',
                    'a.nombre_almacen',
                    'md.responsable',
                    'md.id_herramienta',
                    'h.nombre_herramienta',
                    'md.estatus',
                    'md.eventualidad',
                    'md.responsable',
                    'md.cantidad_devuelta',
                    'md.fecha_devolucion' 
                    )
                ->whereNotNull('md.fecha_devolucion')
                ->where('md.estatus', '!=', 'BUEN ESTADO')
                ->get();        

       // and md.fecha_devolucion between '01-05-23' and '26-05-2023'
    }

    public static function ListadoHerramientas($IdAlmacen)
    {
        return DB::table('cnth_almacen_herramientas as h2')
            ->join('cnth_herramientas as h', 'h2.id_herramienta', '=', 'h.id_herramienta')
            ->join('almacenes as a', 'h2.id_almacen', '=', 'a.id_almacen')
            ->select(
                'a.id_almacen',
                'h.id_herramienta',
                'h.nombre_herramienta',
                'h2.stock_actual',
                'h2.id_almacen_herramienta'
            )->where('h2.id_almacen', '=', $IdAlmacen)
            ->get();
    }

    public static function HerramientasAlmacenes($Almacenes)
    {
        return DB::table('cnth_almacen_herramientas as h2')
            ->join('cnth_herramientas as h', 'h2.id_herramienta', '=', 'h.id_herramienta')
            ->join('almacenes as a', 'h2.id_almacen', '=', 'a.id_almacen')
            ->select(
                'a.id_almacen',
                'h.id_herramienta',
                'h.nombre_herramienta',
                'h2.stock_actual',
                'h2.id_almacen_herramienta'
            )->whereIn('h2.id_almacen', $Almacenes)
            ->get();
    }


    public static function HerramientasStock($IdAlmacen, $IdHerramienta)
    {
        $query = DB::table('cnth_almacen_herramientas as ah')
            ->join('cnth_herramientas as h', 'ah.id_herramienta', '=', 'h.id_herramienta')
            ->join('almacenes as a', 'ah.id_almacen', '=', 'a.id_almacen')
            ->select(
                'ah.id_almacen', //int
                'a.nombre_almacen',
                'ah.id_herramienta',
                'h.nombre_herramienta',
                'ah.stock_actual'
            )
            ->where('ah.id_almacen', '=', $IdAlmacen);
    
        if ($IdHerramienta != 'TODAS') {
            $query->where('ah.id_herramienta', '=', $IdHerramienta);
        }
    
        return $query->get();
    }
    

    //Relacion de categoria
    public function categoria()
    {
        return $this->belongsTo(Cnth_CategoriasModel::class, 'id_categoria');
    }
    //Relacion de grupo
    public function grupo()
    {
        return $this->belongsTo(Cnth_GruposModel::class, 'id_grupo');
    }
    //Relacion de subgrupo
    public function subgrupo()
    {
        return $this->belongsTo(Cnth_SubgruposModel::class, 'id_subgrupo');
    }
    //Relacion de muchos a muchos entre herramientas y despacho
    public function almacen()
    {
        return $this->belongsToMany(AlmacenesModel::class, 'cnth_almacen_herramientas', 'id_herramienta', 'id_almacen');
    }
}
