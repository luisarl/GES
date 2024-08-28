<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Resg_Solicitudes_ResguardoModel extends Model
{
    use HasFactory;

    protected $table = 'resg_solicitudes_resguardo';
    protected $primaryKey = 'id_solicitud_resguardo';

    protected $fillable = [
        'id_solicitud_resguardo',
        'id_almacen',
        'ubicacion_actual',
        'observacion',
        'estatus',
        'id_departamento',
        'responsable',
        'creado_por',
        'fecha_creacion',
        'actualizado_por',
        'fecha_actualizacion',
        'aprobado_por',
        'fecha_aprobacion',
        'procesado_por',
        'fecha_procesado',
        'anulado_por',
        'fecha_anulacion',
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha


    public static function ListadoSolicitudesResguardo()
    {
        return DB::table('resg_solicitudes_resguardo as s')
            ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->join('users as u', 'u.id', '=', 's.creado_por')
            ->select(
                's.id_solicitud_resguardo',
                's.fecha_creacion',
                'u.name as creado_por',
                'a.nombre_almacen',
                's.ubicacion_actual',
                's.responsable',
                's.estatus'
            )
            ->get();
    }

    public static function ListadoSolicitudesResguardoAlmacen($IdUsuario)
    {
        return DB::table('resg_solicitudes_resguardo as s')
            ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->join('almacen_usuario as au', 'au.id_almacen', '=', 'a.id_almacen')
            ->join('users as u', 'u.id', '=', 's.creado_por')
            ->select(
                's.id_solicitud_resguardo',
                's.fecha_creacion',
                //'s.creado_por',
                'u.name as creado_por',
                'a.nombre_almacen',
                's.ubicacion_actual',
                's.estatus'
            )
            ->where('au.id', '=', $IdUsuario)
            ->whereRaw("(s.estatus = 'APROBADO' OR s.estatus = 'PROCESADO')")
            ->orWhere('s.id_departamento', '=', Auth::user()->id_departamento)
            ->groupBy(
                's.id_solicitud_resguardo',
                's.fecha_creacion',
                'u.name',
                'a.nombre_almacen',
                's.ubicacion_actual',
                's.estatus'
            )
            ->get();
    }

    public static function ListadoSolicitudesResguardoDepartamento($IdDepartamento)
    {
        return DB::table('resg_solicitudes_resguardo as s')
            ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->join('users as u', 'u.id', '=', 's.creado_por')
            ->select(
                's.id_solicitud_resguardo',
                's.fecha_creacion',
                //'s.creado_por',
                'u.name as creado_por',
                'a.nombre_almacen',
                's.ubicacion_actual',
                's.estatus'
            )
            ->where('s.id_departamento', '=', $IdDepartamento)
            ->get();
    }

    public static function BuscarArticulos($articulo)
    {
        return DB::select("
        SELECT codigo, nombre
            from (	
                SELECT codigo_articulo  AS codigo, nombre_articulo  as nombre from articulos
                WHERE estatus = 'MIGRADO'
                UNION
                SELECT codigo_activo as codigo, nombre_activo as nombre from actv_activos
                UNION 
                SELECT convert(nvarchar(100), id_herramienta) COLLATE Modern_Spanish_CI_AS AS codigo, nombre_herramienta COLLATE Modern_Spanish_CI_AS as nombre  from cnth_herramientas 
            )
            as articulos
        WHERE  nombre like '%'+'$articulo'+'%' or codigo like  '%'+'$articulo'+'%'
        ");
    }

    public static function VerSolicitudResguardo($IdSolicitudResguardo)
    {
        return DB::table('resg_solicitudes_resguardo as s')
            ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
            ->join('departamentos as d', 'd.id_departamento', '=', 's.id_departamento')
            ->join('users as uc', 'uc.id', '=', 's.creado_por')
            ->leftJoin('users as ua', 'ua.id', '=', 's.aprobado_por')
            ->leftJoin('users as up', 'up.id', '=', 's.procesado_por')
            ->select(
                's.id_solicitud_resguardo',
                's.ubicacion_actual',
                's.observacion',
                's.estatus',
                's.responsable',
                's.fecha_creacion',
                'uc.name as creado_por',
                's.fecha_aprobacion',
                'ua.name as aprobado_por',
                's.fecha_procesado',
                'up.name as procesado_por',
                'a.nombre_almacen',
                'd.nombre_departamento'
            )
            ->where('s.id_solicitud_resguardo', '=', $IdSolicitudResguardo)
            ->first();  
    }
}
