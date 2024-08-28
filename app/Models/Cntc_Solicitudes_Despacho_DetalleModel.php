<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Cntc_Solicitudes_Despacho_DetalleModel extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-d-m H:i';   //funcion para formateo de la fecha
    protected $table = 'cntc_solicitudes_despacho_detalle';
    protected $primaryKey = 'id_solicitud_despacho_detalle';

    protected $fillable = [
        'id_solicitud_despacho_detalle',
        'id_solicitud_despacho',
        'placa_equipo',
        'marca_equipo',
        'responsable',
        'cantidad',
        'cantidad_despachada',
        'stock_combustible',
        'fecha_despacho',
        
    ];

    public static function EquiposDespacho($IdDespacho)
    {
        return DB::table('cntc_solicitudes_despacho_detalle as sd')
            ->join('cntc_solicitudes_despacho as d','sd.id_solicitud_despacho','=','d.id_solicitud_despacho')
            ->join('departamentos as de','d.id_departamento','=','de.id_departamento')
            ->select(
                'sd.id_solicitud_despacho_detalle',
                'sd.placa_equipo',
                'sd.marca_equipo',
                'sd.responsable',
                'sd.cantidad',
                'de.nombre_departamento',
                'sd.stock_combustible',
                'sd.fecha_despacho',
                'sd.cantidad_despachada',
                'sd.fecha_despacho'

            )
        ->where('sd.id_solicitud_despacho','=',$IdDespacho)
        ->get();
    }
}
