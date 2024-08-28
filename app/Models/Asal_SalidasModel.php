<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Asal_SalidasModel extends Model
{
    use HasFactory;

    protected $table = 'asal_salidas';
    protected $primaryKey = 'id_salida'; 

    protected $fillable = [
        'id_salida',
        'destino',
        'motivo',
        'estatus',
        'solicitante',
        'departamento',
        'correlativo',
        'solicitante',
        'autorizado',
        'responsable',
        'departamento',
        'tipo_salida',
        'tipo_conductor',
        'conductor',
        'tipo_vehiculo',
        'vehiculo_foraneo',
        'validado',
        'usuario_validacion',
        'fecha_validacion',
        'fecha_salida',
        'creado_por',
        'actualizado_por',
        'anulado',
        'anulado_por',
        'hora_salida',
        'id_almacen',
        'id_vehiculo',
        'cerrado_por',
        'fecha_cierre',
        'usuario_validacion_almacen',
        'fecha_validacion_almacen' ,
        'id_tipo',
        'id_subtipo',
        'usuario_cierre_almacen',
        'fecha_cierre_almacen'  
    ];

    public static function EmpleadosAutorizadosSalidas()
    {
        return DB::connection('profit')
        ->select(
            "
            SELECT 'ACERO MAX' AS Empresa, N_ACERO.dbo.snemple.cod_emp AS Ficha, SUBSTRING(N_ACERO.dbo.snemple.cod_emp,6,3) AS Codigo,
            N_ACERO.dbo.snemple.nombres + ' ' + N_ACERO.dbo.snemple.apellidos AS Empleado, 
            N_ACERO.dbo.snemple.rif As Cedula, 
                        N_ACERO.dbo.snemple.co_depart, 
            N_ACERO.dbo.sndepart.des_depart AS Departamento,
            N_ACERO.dbo.snemple.co_cargo,
            N_ACERO.dbo.sncargo.des_cargo
            FROM N_ACERO.dbo.snemple 
            INNER JOIN N_ACERO.dbo.sndepart ON N_ACERO.dbo.snemple.co_depart = N_ACERO.dbo.sndepart.co_depart
            INNER JOIN N_ACERO.dbo.sncargo ON N_ACERO.dbo.snemple.co_cargo = N_ACERO.dbo.sncargo.co_cargo
            WHERE (N_ACERO.dbo.snemple.status = 'A' AND N_ACERO.dbo.snemple.campo1 = '1') 
                OR (N_ACERO.dbo.snemple.nombres LIKE '%GISMAR%' AND N_ACERO.dbo.snemple.status <> 'A')
            UNION ALL
            SELECT 'GLOBAL' AS Empresa, N_GLOBAL.dbo.snemple.cod_emp AS Ficha, SUBSTRING(N_GLOBAL.dbo.snemple.cod_emp,6,3) AS Codigo,
                        N_GLOBAL.dbo.snemple.nombres + ' ' + N_GLOBAL.dbo.snemple.apellidos AS Empleado, 
            N_GLOBAL.dbo.snemple.rif As Cedula, 
                        N_GLOBAL.dbo.snemple.co_depart, 
            N_GLOBAL.dbo.sndepart.des_depart AS Departamento,
            N_GLOBAL.dbo.snemple.co_cargo,
            N_GLOBAL.dbo.sncargo.des_cargo
            FROM N_GLOBAL.dbo.snemple 
            INNER JOIN N_GLOBAL.dbo.sndepart ON N_GLOBAL.dbo.snemple.co_depart = N_GLOBAL.dbo.sndepart.co_depart
            INNER JOIN N_GLOBAL.dbo.sncargo ON N_GLOBAL.dbo.snemple.co_cargo = N_GLOBAL.dbo.sncargo.co_cargo
            WHERE N_GLOBAL.dbo.snemple.status = 'A'AND N_GLOBAL.dbo.snemple.campo1 = '1'
            UNION ALL
            SELECT 'DESTAJO' AS Empresa, N_DESTAJO.dbo.snemple.cod_emp AS Ficha, SUBSTRING(N_DESTAJO.dbo.snemple.cod_emp,6,3) AS Codigo,
                        N_DESTAJO.dbo.snemple.nombres + ' ' + N_DESTAJO.dbo.snemple.apellidos AS Empleado, 
            N_DESTAJO.dbo.snemple.rif As Cedula, 
                        N_DESTAJO.dbo.snemple.co_depart, 
            N_DESTAJO.dbo.sndepart.des_depart AS Departamento,
            N_DESTAJO.dbo.snemple.co_cargo,
            N_DESTAJO.dbo.sncargo.des_cargo
            FROM N_DESTAJO.dbo.snemple 
            INNER JOIN N_DESTAJO.dbo.sndepart ON N_DESTAJO.dbo.snemple.co_depart = N_DESTAJO.dbo.sndepart.co_depart
            INNER JOIN N_DESTAJO.dbo.sncargo ON N_DESTAJO.dbo.snemple.co_cargo = N_DESTAJO.dbo.sncargo.co_cargo
            WHERE (N_DESTAJO.dbo.snemple.status = 'A' AND N_DESTAJO.dbo.snemple.campo1 = '1') 
                OR (N_DESTAJO.dbo.snemple.nombres LIKE '%JUAISBEL%' AND N_DESTAJO.dbo.snemple.status <> 'A')
            "
        );
    }

    public static function EmpleadosSalidas()
    {
        return DB::connection('profit')
        ->select(
            "
            SELECT 'ACERO MAX' AS Empresa, N_ACERO.dbo.snemple.cod_emp AS Ficha, 
                    N_ACERO.dbo.snemple.nombres + ' ' + N_ACERO.dbo.snemple.apellidos AS Empleado, 
                    N_ACERO.dbo.snemple.rif As Cedula, 
                    N_ACERO.dbo.snemple.co_depart, 
                    N_ACERO.dbo.sndepart.des_depart AS Departamento,
                    N_ACERO.dbo.snemple.co_cargo,
                    N_ACERO.dbo.sncargo.des_cargo
            FROM N_ACERO.dbo.snemple 
            INNER JOIN N_ACERO.dbo.sndepart ON N_ACERO.dbo.snemple.co_depart = N_ACERO.dbo.sndepart.co_depart
            INNER JOIN N_ACERO.dbo.sncargo ON N_ACERO.dbo.snemple.co_cargo = N_ACERO.dbo.sncargo.co_cargo
            WHERE N_ACERO.dbo.snemple.status = 'A'
            UNION ALL
            SELECT 'GLOBAL' AS Empresa, N_GLOBAL.dbo.snemple.cod_emp AS Ficha, 
                    N_GLOBAL.dbo.snemple.nombres + ' ' + N_GLOBAL.dbo.snemple.apellidos AS Empleado, 
                    N_GLOBAL.dbo.snemple.rif As Cedula, 
                    N_GLOBAL.dbo.snemple.co_depart, 
                    N_GLOBAL.dbo.sndepart.des_depart AS Departamento,
                    N_GLOBAL.dbo.snemple.co_cargo,
                    N_GLOBAL.dbo.sncargo.des_cargo
            FROM N_GLOBAL.dbo.snemple 
            INNER JOIN N_GLOBAL.dbo.sndepart ON N_GLOBAL.dbo.snemple.co_depart = N_GLOBAL.dbo.sndepart.co_depart
            INNER JOIN N_GLOBAL.dbo.sncargo ON N_GLOBAL.dbo.snemple.co_cargo = N_GLOBAL.dbo.sncargo.co_cargo
            WHERE N_GLOBAL.dbo.snemple.status = 'A'
            UNION ALL
            SELECT 'DESTAJO' AS Empresa, N_DESTAJO.dbo.snemple.cod_emp AS Ficha, 
                    N_DESTAJO.dbo.snemple.nombres + ' ' + N_DESTAJO.dbo.snemple.apellidos AS Empleado, 
                    N_DESTAJO.dbo.snemple.rif As Cedula, 
                    N_DESTAJO.dbo.snemple.co_depart, 
                    N_DESTAJO.dbo.sndepart.des_depart AS Departamento,
                    N_DESTAJO.dbo.snemple.co_cargo,
                    N_DESTAJO.dbo.sncargo.des_cargo
            FROM N_DESTAJO.dbo.snemple 
            INNER JOIN N_DESTAJO.dbo.sndepart ON N_DESTAJO.dbo.snemple.co_depart = N_DESTAJO.dbo.sndepart.co_depart
            INNER JOIN N_DESTAJO.dbo.sncargo ON N_DESTAJO.dbo.snemple.co_cargo = N_DESTAJO.dbo.sncargo.co_cargo
            WHERE N_DESTAJO.dbo.snemple.status = 'A'
                UNION ALL
            SELECT 'PUEBLO' AS Empresa, N_PUEBLO.dbo.snemple.cod_emp AS Ficha, 
                    N_PUEBLO.dbo.snemple.nombres + ' ' + N_PUEBLO.dbo.snemple.apellidos AS Empleado, 
                    N_PUEBLO.dbo.snemple.rif As Cedula, 
                    N_PUEBLO.dbo.snemple.co_depart, 
                    N_PUEBLO.dbo.sndepart.des_depart AS Departamento,
                    N_PUEBLO.dbo.snemple.co_cargo,
                    N_PUEBLO.dbo.sncargo.des_cargo
            FROM N_PUEBLO.dbo.snemple 
            INNER JOIN N_PUEBLO.dbo.sndepart ON N_PUEBLO.dbo.snemple.co_depart = N_PUEBLO.dbo.sndepart.co_depart
            INNER JOIN N_PUEBLO.dbo.sncargo ON N_PUEBLO.dbo.snemple.co_cargo = N_PUEBLO.dbo.sncargo.co_cargo
            WHERE N_PUEBLO.dbo.snemple.status = 'A'  
            "
        );
    }

    public static function VerSalida($IdSalida)
    {
        return DB::table('Asal_salidas as s')
            ->leftJoin('asal_vehiculos as v', 's.id_vehiculo', 'v.id_vehiculo')
            ->join('almacenes as a', 's.id_almacen', '=', 'a.id_almacen')
            ->join('users as u', 'u.id', '=', 's.creado_por')
            //->join('users as u2', 'u.id', '=', 's.actualizado_por')
            ->join('asal_tipos as t', 't.id_tipo', '=', 's.id_tipo')
            ->leftJoin('asal_subtipos as sub', 'sub.id_subtipo', '=', 's.id_subtipo')
            ->select(
                's.id_salida',
                's.correlativo',
                's.motivo',
                's.destino',
                's.solicitante',
                's.departamento',
                's.responsable',
                's.autorizado',
                //'s.tipo_salida',
                't.nombre_tipo',
                'sub.nombre_subtipo',
                's.tipo_conductor',
                's.tipo_vehiculo',
                's.conductor',
                's.vehiculo_foraneo',
                's.validado',
                's.usuario_validacion',
                DB::raw("CONVERT(VARCHAR(10), s.fecha_validacion, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.fecha_validacion, 100), 7) as fecha_validacion"),
                DB::raw("CONVERT(VARCHAR(10), s.fecha_salida, 105) as fecha_salida"),
                's.estatus',
                's.creado_por',
                //'s.actualizado_por',
                'u.name as creado_por',
                //'u2.name as actualizado_por',
                DB::raw('CONVERT(varchar(15),CAST(s.hora_salida AS TIME),100) as hora_salida'),
                's.id_almacen',
                'a.nombre_almacen',
                'a.superior as responsable_almacen',
                's.id_vehiculo',
                DB::raw(" CONCAT('PLACA: ', v.placa_vehiculo, ' MARCA: ', v.marca_vehiculo, ' MODELO: ', v.modelo_vehiculo ) as vehiculo_interno"),
                's.created_at',
                's.updated_at',
                DB::raw("CONVERT(VARCHAR(10), s.created_at, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.created_at, 100), 7) as fecha_emision"),
                's.anulado',
                's.cerrado_por',
                DB::raw("CONVERT(VARCHAR(10), s.fecha_cierre, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.fecha_cierre, 100), 7) as fecha_cierre"),
                's.usuario_validacion_almacen',
                DB::raw("CONVERT(VARCHAR(10), s.fecha_validacion_almacen, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.fecha_validacion_almacen, 100), 7) as fecha_validacion_almacen"),
                's.usuario_cierre_almacen',
                DB::raw("CONVERT(VARCHAR(10), s.fecha_cierre_almacen, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.fecha_cierre_almacen, 100), 7) as fecha_cierre_almacen")
                )
                ->where('s.id_salida', '=', $IdSalida)
                ->first();
    }

    public static function ListaSalidas()
    {
        return DB::table('asal_salidas as s')
                ->leftJoin('asal_salidas_detalle as sd', 's.id_salida', '=', 'sd.id_salida')
                ->join('almacenes as a', 'a.id_almacen', '=', 's.id_almacen')
                ->join('asal_tipos as t', 't.id_tipo', '=', 's.id_tipo')
                ->select(
                    's.id_salida',
                    DB::raw("CONVERT(VARCHAR(10), s.created_at, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.created_at, 100), 7) as fecha_emision"),
                    'a.nombre_almacen',
                    's.solicitante',
                    's.responsable',
                    't.nombre_tipo',
                    's.anulado',
                    's.estatus',
                    DB::raw("STRING_AGG( CAST(sd.nombre_articulo AS VARCHAR(MAX)) , ', ') AS articulos")
                    )
                ->groupBy(
                    's.id_salida',
                    's.created_at',
                    'a.nombre_almacen',
                    's.solicitante',
                    's.responsable',
                    't.nombre_tipo',
                    's.anulado',
                    's.estatus'
                    )
                ->get();
    }

    public static function ReporteSalidas($FechaInicio, $FechaFin, $estatus, $IdAlmacen)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('d-m-Y');
        $FechaFin = Carbon::parse($FechaFin)->format('d-m-Y');
       
         $salidas = DB::table('Asal_salidas as s')
            ->leftJoin('asal_vehiculos as v', 's.id_vehiculo', 'v.id_vehiculo')
            ->join('almacenes as a', 's.id_almacen', '=', 'a.id_almacen')
            ->join('users as u', 'u.id', '=', 's.creado_por')
            ->join('asal_tipos as t', 't.id_tipo', '=', 's.id_tipo')
            //->join('users as u2', 'u.id', '=', 's.actualizado_por')
            ->select(
                's.id_salida',
                's.correlativo',
                's.motivo',
                's.destino',
                's.solicitante',
                's.departamento',
                's.responsable',
                's.autorizado',
                't.nombre_tipo',
                's.tipo_conductor',
                's.tipo_vehiculo',
                's.conductor',
                's.vehiculo_foraneo',
                's.validado',
                's.usuario_validacion',
                's.id_almacen',
                DB::raw("CONVERT(VARCHAR(10), s.fecha_validacion, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.fecha_validacion, 100), 7) as fecha_validacion"),
                DB::raw("CONVERT(VARCHAR(10), s.fecha_salida, 105) as fecha_salida"),
                's.estatus',
                //'s.creado_por',
                //'s.actualizado_por',
                'u.name as creado_por',
                //'u2.name as actualizado_por',
                DB::raw('CONVERT(varchar(15),CAST(s.hora_salida AS TIME),100) as hora_salida'),
                's.id_almacen',
                'a.nombre_almacen',
                'a.superior as responsable_almacen',
                's.id_vehiculo',
                DB::raw(" CONCAT('PLACA: ', v.placa_vehiculo, ' MARCA: ', v.marca_vehiculo, ' MODELO: ', v.modelo_vehiculo ) as vehiculo_interno"),
                's.created_at',
                's.updated_at',
                DB::raw("CONVERT(VARCHAR(10), s.created_at, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.created_at, 100), 7) as fecha_emision"),
                's.anulado',
                's.cerrado_por',
                DB::raw("CONVERT(VARCHAR(10), s.fecha_cierre, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.fecha_cierre, 100), 7) as fecha_cierre"),

                );

                if($estatus != 'TODOS' ) 
                {
                    $salidas->where('s.estatus', '=', $estatus);
                }

                $salidas->where('s.id_almacen', '=', $IdAlmacen);   
                $salidas->whereBetween( DB::raw("CONVERT(date, s.created_at)"), [$FechaInicio, $FechaFin]);
               
                return  $salidas->get();
    }

    public static function ReporteSalidasPDF($FechaInicio, $FechaFin, $estatus, $IdAlmacen)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('d-m-Y');
        $FechaFin = Carbon::parse($FechaFin)->format('d-m-Y');
       
         $salidas = DB::table('Asal_salidas as s')
            ->leftJoin('asal_vehiculos as v', 's.id_vehiculo', 'v.id_vehiculo')
            ->join('users as u', 'u.id', '=', 's.creado_por')
            ->join('asal_tipos as t', 't.id_tipo', '=', 's.id_tipo')
            ->join('asal_salidas_detalle as sd', function($join)
                {
                    $join->on('sd.id_salida', '=', 's.id_salida')
                    ->whereNull('sd.fecha_retorno');
                })
            //->join('users as u2', 'u.id', '=', 's.actualizado_por')
            ->select(
                's.id_salida',
                //'s.motivo',
                //'s.destino',
                's.solicitante',
                's.departamento',
                's.responsable',
                //'s.autorizado',
                't.nombre_tipo',
                's.estatus',
                DB::raw("CONVERT(VARCHAR(10), s.fecha_validacion, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.fecha_validacion, 100), 7) as fecha_validacion"),
                DB::raw("CONVERT(VARCHAR(10), s.fecha_salida, 105) as fecha_salida"),
                DB::raw("CONVERT(VARCHAR(10), s.created_at, 105) + ' ' + RIGHT(CONVERT(VARCHAR, s.created_at, 100), 7) as fecha_emision"),
                DB::raw("CASE WHEN s.id_salida IS NULL
                        THEN NULL 
                            ELSE 
                                STRING_AGG(CAST(CONCAT('<tr>
                                                    <td>',sd.codigo_articulo,'</td>
                                                    <td>',sd.nombre_articulo, '</td>
                                                    <td>',sd.comentario,'</td>
                                                    <td>',sd.tipo_unidad,'</td>
                                                    <td>',sd.cantidad_salida,'</td>
                                                    <td>',isnull(sd.estatus, 'ABIERTO'), '</td>
                                                    </tr>') AS nvarchar(MAX)),'') 
                            END
                            as articulos"
                        )

                );

                if($estatus != 'TODOS' ) 
                {
                    $salidas->where('s.estatus', '=', $estatus);
                }

                $salidas->where('s.id_almacen', '=', $IdAlmacen);   
                $salidas->whereBetween( DB::raw("CONVERT(date, s.created_at)"), [$FechaInicio, $FechaFin]);
                
                $salidas->groupBy(
                        's.id_salida',
                        's.solicitante',
                        's.departamento',
                        's.responsable',
                        't.nombre_tipo',
                        's.fecha_validacion',
                        's.fecha_salida',
                        's.estatus',
                        's.created_at',
                );
                return  $salidas->get();
    }

    public static function CierreSalidas($IdSalida)
    {
        $ConteoCerrados = DB::table('asal_salidas_detalle')
                ->selectRaw('count(estatus) as conteo_cerrados')
                    ->where('id_salida', '=', $IdSalida)
                    ->where('estatus', '=', 'CERRADO')
                    ->where('fecha_retorno', '=', null)
                    ->value('conteo_cerrados');

        $ConteoPendientes = DB::table('asal_salidas_detalle')
            ->selectRaw('count(id_detalle) as conteo_pendientes')
                ->where('id_salida', '=', $IdSalida)
                ->where('fecha_retorno', '=', null)
                ->value('conteo_pendientes');

        $pendiente = $ConteoPendientes - $ConteoCerrados;
        
         // ACTUALIZA EL ESTATUS DE LA SALIDA A CERRADO  
        if($pendiente == 0)
        {
            Asal_SalidasModel::where('id_salida', '=', $IdSalida)
            ->update([
                'fecha_cierre' =>  Carbon::now()->format('Y-d-m H:i:s'),
                'cerrado_por' => Auth::user()->name,
                'estatus' => 'CERRADO'
            ]);
        }
        
    }

    public static function CierreAlmacenSalidas($IdSalida)
    {
        $ConteoCerrados = DB::table('asal_salidas_detalle')
                ->selectRaw('count(cerrado) as conteo_cerrados')
                    ->where('id_salida', '=', $IdSalida)
                    ->where('estatus', '=', 'CERRADO')
                    ->where('fecha_retorno', '=', null)
                    ->value('conteo_cerrados');

        $ConteoPendientes = DB::table('asal_salidas_detalle')
            ->selectRaw('count(id_detalle) as conteo_pendientes')
                ->where('id_salida', '=', $IdSalida)
                ->where('fecha_retorno', '=', null)
                ->value('conteo_pendientes');

        $pendiente = $ConteoPendientes - $ConteoCerrados;
        
         // ACTUALIZA EL ESTATUS DE LA SALIDA A CERRADO/ALMACEN  
        if($pendiente == 0)
        {
            Asal_SalidasModel::where('id_salida', '=', $IdSalida)
                ->update([
                    'usuario_cierre_almacen' => Auth::user()->name, 
                    'fecha_cierre_almacen' => Carbon::now()->format('Y-d-m H:i:s'), 
                    'estatus' => 'CERRADO/ALMACEN'
                ]); 

            return true;
        }
        
    }

    public static function ReporteSalidasAuditoria($FechaInicio, $FechaFin, $estatus, $IdAlmacen)
    {
        $FechaInicio = Carbon::parse($FechaInicio)->format('d-m-Y');
        $FechaFin = Carbon::parse($FechaFin)->format('d-m-Y');

        $salidas = DB::table('asal_salidas as s')
                ->leftJoin('users as u', 'u.id', '=', 's.anulado_por')
                ->join('almacenes as a','a.id_almacen','=','s.id_almacen')
                ->select(
                    's.id_salida',
                    's.created_at as fecha_creacion',
                    's.departamento',
                    's.motivo',
                    's.estatus',
                    's.fecha_validacion_almacen',
                    's.usuario_validacion_almacen',
                    's.fecha_validacion as fecha_validacion_control',
                    's.usuario_validacion as usuario_validacion_control',
                    's.fecha_cierre',
                    's.cerrado_por',
                    'u.name as anulado_por',
                    's.updated_at as fecha_anulacion',
                    'a.nombre_almacen',
                    's.usuario_cierre_almacen',
                    's.fecha_cierre_almacen'
                );
                $salidas->whereBetween( DB::raw("CONVERT(date, s.created_at)"), [$FechaInicio, $FechaFin]);
                $salidas->where('s.id_almacen','=',$IdAlmacen);

                if($estatus != 'TODOS') 
                {
                    $salidas->where('s.estatus', '=', $estatus);
                }
                $salidas->orderBy('s.id_salida');
        
        return $salidas->get();
    }
    
    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha

    public function detalle()
    {
        return $this->belongsTo(Asal_Salidas_DetalleModel::class, 'id_detalle');
    }
    
    //Relacion de con vehiculos
    public function vehiculos()
    {
        return $this->belongsTo(Asal_VehiculosModel::class, 'id_vehiculo');
    }
    //Relacion de con almacenes
    public function almacenes()
    {
        return $this->belongsTo(AlmacenesModel::class, 'id_almacen');
    }
}
