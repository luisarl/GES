<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Audi_Auditoria_InventarioModel extends Model
{
    use HasFactory;
    protected $table = 'audi_auditoria_inventario';
    protected $primaryKey = 'id_auditoria_inventario';

    protected $fillable = [
        'id_auditoria_inventario',
        'id_articulo',
        'codigo_articulo',
        'id_almacen',
        'id_subalmacen',
        'stock_actual',
        'conteo_fisico',
        'numero_auditoria',
        'observacion',
        'fecha',
        'usuario',
        'direccion_ip',
        'nombre_equipo',
        'fotografia'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ArticulosAuditoriaInventario($fecha, $NumeroAuditoria)
    {
        $articulos = DB::table('audi_auditoria_inventario as ai')
            ->join('articulos as a', 'a.id_articulo', '=', 'ai.id_articulo')
            ->join('almacenes as al', 'al.id_almacen', '=', 'ai.id_almacen')
            ->join('subalmacenes as s', 's.id_subalmacen', '=', 'ai.id_subalmacen')
            ->join('users as u', 'u.id', '=', 'ai.usuario')            
            ->select(
                'ai.id_auditoria_inventario',
                'ai.numero_auditoria',
                'ai.id_articulo',
                'ai.codigo_articulo',
                'a.nombre_articulo',
                'al.nombre_almacen',
                's.nombre_subalmacen',
                'ai.stock_actual',
                'ai.conteo_fisico',
                DB::raw('ai.conteo_fisico - ai.stock_actual as diferencia'),
                'u.name as usuario',
                'ai.fecha',
                'ai.observacion'
                
            );

            if($fecha != null)
            {
                $articulos->whereRaw('CONVERT(DATE, ai.fecha) = ?', [$fecha]);
            }

            if($NumeroAuditoria != null)
            {
                $articulos->where('ai.numero_auditoria', '=', $NumeroAuditoria);
            }

            return $articulos->get();
    }
    
    public static function VerAuditoriaInventario($IdTomaFisica)
    {
        return DB::table('audi_auditoria_inventario as ai')
            ->join('articulos as a', 'a.id_articulo', '=', 'ai.id_articulo')
            ->join('almacenes as al', 'al.id_almacen', '=', 'ai.id_almacen')
            ->join('subalmacenes as s', 's.id_subalmacen', '=', 'ai.id_subalmacen')
            ->join('users as u', 'u.id', '=', 'ai.usuario')            
            ->select(
                'ai.id_auditoria_inventario',
                'ai.numero_auditoria',
                'ai.id_articulo',
                'ai.codigo_articulo',
                'a.nombre_articulo',
                'al.nombre_almacen',
                's.nombre_subalmacen',
                'ai.stock_actual',
                'ai.conteo_fisico',
                DB::raw('ai.conteo_fisico - ai.stock_actual as diferencia'),
                'u.name as usuario',
                'ai.fecha',
                'ai.observacion',
                'ai.fotografia'   
            )
            ->where('ai.id_auditoria_inventario', '=', $IdTomaFisica)
            ->first();
    }
}
