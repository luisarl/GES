<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Resg_Solicitudes_DespachoModel extends Model
{
    use HasFactory;

    protected $table = 'resg_solicitudes_despacho';
    protected $primaryKey = 'id_solicitud_despacho';

    protected $fillable = [
        'id_solicitud_despacho',
        'id_almacen',
        'ubicacion_destino',
        'observacion',
        'responsable',
        'estatus',
        'id_departamento',
        'creado_por',
        'fecha_creacion',
        'actualizado_por',
        'fecha_actualizacion',
        'aprobado_por',
        'fecha_aprobacion',
        'procesado_por',
        'fecha_procesado',
        'anulado_por',
        'fecha_anulacion'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public static function ListadoSolicitudesDespacho()
    {
        return DB::table('resg_solicitudes_despacho as s')
            ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->join('users as u', 'u.id', '=', 's.creado_por')
            ->select(
                's.id_solicitud_despacho',
                's.fecha_creacion',
                //'s.creado_por',
                'u.name as creado_por',
                'a.nombre_almacen',
                's.ubicacion_destino',
                's.estatus'
            )
            ->get();
    }
    public static function ListadoSolicitudesDespachoAlmacen($IdUsuario)
    {
        return DB::table('resg_solicitudes_despacho as s')
            ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->join('almacen_usuario as au', 'au.id_almacen', '=', 'a.id_almacen')
            ->join('users as u', 'u.id', '=', 's.creado_por')
            ->select(
                's.id_solicitud_despacho',
                's.fecha_creacion',
                //'s.creado_por',
                'u.name as creado_por',
                'a.nombre_almacen',
                's.ubicacion_destino',
                's.estatus'
            )
            ->where('au.id', '=', $IdUsuario)
            ->whereRaw("(s.estatus = 'APROBADO' OR s.estatus = 'PROCESADO')")
            ->orWhere('s.id_departamento', '=', Auth::user()->id_departamento)
            ->groupBy(
                's.id_solicitud_despacho',
                's.fecha_creacion',
                'u.name',
                'a.nombre_almacen',
                's.ubicacion_destino',
                's.estatus'
            )
            ->get();
    }

    public static function ListadoSolicitudesDespachoDepartamento($IdDepartamento)
    {
        return DB::table('resg_solicitudes_despacho as s')
            ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->join('users as u', 'u.id', '=', 's.creado_por')
            ->select(
                's.id_solicitud_despacho',
                's.fecha_creacion',
                //'s.creado_por',
                'u.name as creado_por',
                'a.nombre_almacen',
                's.ubicacion_destino',
                's.estatus'
            )
            ->where('s.id_departamento', '=', $IdDepartamento)
            ->get();
    }

    public static function VerSolicitudDespacho($IdSolicitudDespacho)
    {
        return DB::table('resg_solicitudes_despacho as s')
        ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
        ->join('departamentos as d', 'd.id_departamento', '=', 's.id_departamento')
        ->join('users as uc', 'uc.id', '=', 's.creado_por')
        ->leftJoin('users as ua', 'ua.id', '=', 's.aprobado_por')
        ->leftJoin('users as up', 'up.id', '=', 's.procesado_por')
        ->select(
            's.id_solicitud_despacho',
            's.ubicacion_destino',
            's.observacion',
            's.fecha_creacion',
            's.responsable',
            's.estatus',
            'uc.name as creado_por',
            's.fecha_aprobacion',
            'ua.name as aprobado_por',
            's.fecha_procesado',
            'up.name as procesado_por',
            'a.nombre_almacen',
            'd.nombre_departamento'
        )
        ->where('s.id_solicitud_despacho', '=', $IdSolicitudDespacho)
        ->first();  
    }
}
