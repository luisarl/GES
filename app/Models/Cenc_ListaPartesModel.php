<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_ListaPartesModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_lista_partes';
    protected $primaryKey = 'id_lista_parte';

    protected $fillable = [
        'id_lista_parte',
        'nro_conap',
        'tipo_lista',
        'estatus',
        'fecha_anulado',
        'anulado_por',
        'observaciones',
        'creado_por',
        'fecha_creado',
        'finalizado_por',
        'fecha_finalizado'
    ];

    public static function ListaPartes()
    {
        return DB::table('cenc_lista_partes as listap')
                ->join('cenc_conaps as c', 'listap.nro_conap', '=', 'c.id_conap')
                ->join('users AS u', 'listap.creado_por', '=', 'u.id')
                ->select(
                    'listap.id_lista_parte',
                    'listap.nro_conap',
                    'listap.tipo_lista',
                    'listap.estatus',
                    'listap.creado_por',
                    'c.nombre_conap',
                    'c.nro_conap',
                    'u.name'
                    )
                ->get();
    }

    public static function ListaPartes_tipo($IdListaParte)
    {
        return DB::table('cenc_lista_partes as listap')
            ->join('cenc_conaps as c', 'listap.nro_conap', '=', 'c.id_conap')
            ->join('users AS u', 'listap.creado_por', '=', 'u.id')
                ->select(
                    'listap.id_lista_parte',
                    'listap.tipo_lista',
                    'listap.nro_conap',
                    'listap.created_at',
                    'listap.estatus',
                    'listap.creado_por',
                    'listap.fecha_creado',
                    'listap.fecha_anulado',
                    'listap.fecha_finalizado',
                    'listap.observaciones',
                    'c.nro_conap',
                    'u.name'
                    )
                ->where('listap.id_lista_parte', '=', $IdListaParte)
                ->get();
    }

    public static function UsuarioListaParteAnulado($IdListaParte)
    {
        return DB::table('cenc_lista_partes as listap')
                ->join('cenc_conaps as c', 'listap.nro_conap', '=', 'c.id_conap')
                ->join('users AS u', 'listap.anulado_por', '=', 'u.id')
                ->select(
                    'listap.anulado_por',
                    'listap.fecha_anulado',
                    'u.name',
                    )
                ->where('listap.id_lista_parte','=',$IdListaParte)
                ->first();
    }

    public static function UsuarioListaParteFinalizado($IdListaParte)
    {
        return DB::table('cenc_lista_partes as listap')
                ->join('cenc_conaps as c', 'listap.nro_conap', '=', 'c.id_conap')
                ->join('users AS u', 'listap.finalizado_por', '=', 'u.id')
                ->select(
                    'listap.finalizado_por',
                    'listap.fecha_finalizado',
                    'u.name',
                    )
                ->where('listap.id_lista_parte','=',$IdListaParte)
                ->first();
    }

    public static function SumListaPartesPlanchas($Idlistap)
    {
        return DB::table('cenc_lista_planchas as lp_pla')
                ->select(
                    'lp_pla.espesor',
                    DB::raw('SUM(cantidad_piezas)  AS  resumen_cant'),
                    DB::raw('SUM(peso_total)  AS  resumen_peso'),
                    )
                ->where('lp_pla.id_lista_parte', '=', $Idlistap)
                ->groupBy('lp_pla.espesor')
                ->get();
    }

    public static function CantPerforacionesListaPartesPlanchas($Idlistap) // te da los valores de cada espacio de la tabla tipo json 
    {
        $CantPerf = DB::select("
            DECLARE @cols AS NVARCHAR(MAX);
            DECLARE @query AS NVARCHAR(MAX);
            
            SELECT @cols = STUFF((SELECT ',' + QUOTENAME(CAST(espesor AS NVARCHAR(MAX)))
                                 FROM (
                                    SELECT espesor
                                    FROM [cenc_lista_planchas]
                                    WHERE id_lista_parte = $Idlistap AND ISNUMERIC(espesor) = 1
                                    GROUP BY espesor
                                 ) AS sub
                                 ORDER BY espesor ASC
                                 FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '');
            
            SET @query = 'SELECT *
                        FROM
                        (SELECT perf_pla.diametro_perforacion, lp_pla.espesor, COALESCE(perf_pla.cantidad_perforacion, 0) AS cantidad_perforacion
                            FROM [cenc_lista_planchas] AS lp_pla
                            INNER JOIN [cenc_perforaciones_planchas] AS perf_pla ON perf_pla.id_plancha = lp_pla.id_lplancha
                            WHERE lp_pla.id_lista_parte = $Idlistap
                        ) AS tabla
                        PIVOT
                        (
                            SUM(cantidad_perforacion)
                            FOR espesor IN (' + @cols + ')
                        ) AS pivottable';
            
            SET @query = REPLACE(@query, 'NULL', '0');
            
            EXEC sp_executesql @query;
        ");
        return $CantPerf; 
    }

    public static function SumPerforacionesListaPartesPlanchas($Idlistap)
    {
        $CantPerf = DB::select("
            DECLARE @cols AS NVARCHAR(MAX);
            DECLARE @query AS NVARCHAR(MAX);
            
            SELECT @cols = STUFF((SELECT ',' + QUOTENAME(CAST(espesor AS NVARCHAR(MAX)))
                                 FROM (
                                    SELECT espesor
                                    FROM [cenc_lista_planchas]
                                    WHERE id_lista_parte = $Idlistap AND ISNUMERIC(espesor) = 1
                                    GROUP BY espesor
                                 ) AS sub
                                 ORDER BY espesor ASC
                                 FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '');
            
            SET @query = 'SELECT ' + @cols + '
                        FROM
                        (SELECT perf_pla.diametro_perforacion, lp_pla.espesor, COALESCE(perf_pla.cantidad_perforacion, 0) AS cantidad_perforacion
                            FROM [cenc_lista_planchas] AS lp_pla
                            INNER JOIN [cenc_perforaciones_planchas] AS perf_pla ON perf_pla.id_plancha = lp_pla.id_lplancha
                            WHERE lp_pla.id_lista_parte = $Idlistap
                        ) AS tabla
                        PIVOT
                        (
                            SUM(cantidad_perforacion)
                            FOR espesor IN (' + @cols + ')
                        ) AS pivottable';
            
            SET @query = REPLACE(@query, 'NULL', '0');
            
            EXEC sp_executesql @query;
        ");

         
    // Suma las perforaciones asociadas a cada diametro con su respectivo espesor, es decir me da la cantidad total de perforaciones de la columna 
        $sumas = [];
        foreach ($CantPerf as $registro) {
            foreach ($registro as $campo => $valor) {
                if (!is_null($valor)) {

                 
                    if (!isset($sumas[$campo])) {
                        $sumas[$campo] = 0;
                    }
                    $sumas[$campo] += intval($valor);
                }
            }
        }

        uksort($sumas, function($a, $b) {
            return $a <=> $b;
        });
 
        return $sumas;
    }

    //Devuelve los valores de cada espacio de la tabla tipo json
    public static function MetrosPerforacionesListaPartesPlanchas($Idlistap)  
    {
        $MetrosPerfPla = DB::select("
                DECLARE @cols AS NVARCHAR(MAX);
                DECLARE @query AS NVARCHAR(MAX);
                
                SELECT @cols = STUFF((SELECT ',' + QUOTENAME(CAST(espesor AS NVARCHAR(MAX)))
                                    FROM (
                                        SELECT espesor
                                        FROM [cenc_lista_planchas]
                                        WHERE id_lista_parte = $Idlistap AND ISNUMERIC(espesor) = 1
                                        GROUP BY espesor
                                    ) AS sub
                                    ORDER BY espesor ASC
                                    FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '');
                
                SET @query = 'SELECT *
                            FROM
                            (SELECT perf_pla.diametro_perforacion, lp_pla.espesor,
                            CAST(lp_pla.espesor * perf_pla.cantidad_perforacion AS FLOAT) * 0.001 AS Metros
                                FROM [cenc_lista_planchas] AS lp_pla
                                INNER JOIN [cenc_perforaciones_planchas] AS perf_pla ON perf_pla.id_plancha = lp_pla.id_lplancha
                                WHERE lp_pla.id_lista_parte =  $Idlistap
                            ) AS tabla
                            PIVOT
                            (
                                SUM(Metros)
                                FOR espesor IN (' + @cols + ')
                            ) AS pivottable';
            
                EXEC sp_executesql @query;
        ");
        return $MetrosPerfPla; 
    }

    public static function TotalMetrosPerforacionesListaPartesPlanchas($Idlistap) 
    {
        $MetrosPerfPla = DB::select("
                DECLARE @cols AS NVARCHAR(MAX);
                DECLARE @query AS NVARCHAR(MAX);
                
                SELECT @cols = STUFF((SELECT ',' + QUOTENAME(CAST(espesor AS NVARCHAR(MAX)))
                                    FROM (
                                        SELECT espesor
                                        FROM [cenc_lista_planchas]
                                        WHERE id_lista_parte = $Idlistap AND ISNUMERIC(espesor) = 1
                                        GROUP BY espesor
                                    ) AS sub
                                    ORDER BY espesor ASC
                                    FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '');
                
                SET @query = 'SELECT *
                            FROM
                            (SELECT lp_pla.espesor,
                            CAST(lp_pla.espesor * perf_pla.cantidad_perforacion AS FLOAT) * 0.001 AS Metros
                                FROM [cenc_lista_planchas] AS lp_pla
                                INNER JOIN [cenc_perforaciones_planchas] AS perf_pla ON perf_pla.id_plancha = lp_pla.id_lplancha
                                WHERE lp_pla.id_lista_parte =  $Idlistap
                            ) AS tabla
                            PIVOT
                            (
                                SUM(Metros)
                                FOR espesor IN (' + @cols + ')
                            ) AS pivottable';
            
                EXEC sp_executesql @query;
        ");
       
        $sumas = [];
        foreach ($MetrosPerfPla as $registro) {
            foreach ($registro as $campo => $valor) {
                if (!is_null($valor)) {
                    if (!isset($sumas[$campo])) {
                        $sumas[$campo] = 0;
                    }
                    $sumas[$campo] += ($valor);
                }
            }
        }

        uksort($sumas, function($a, $b) {
            return $a <=> $b;
        });
        return $sumas;
    }

    public static function ListaPartesDetalladaPlancha($IdListaParte)
    {
        return DB::table('cenc_lista_partes as listap')
                ->join('cenc_lista_planchas as lp_pla', 'lp_pla.id_lista_parte', '=', 'listap.id_lista_parte')
                ->join('cenc_perforaciones_planchas AS perf_pla', 'perf_pla.id_plancha', '=', 'lp_pla.id_lplancha')
                ->join('cenc_conaps as c', 'listap.nro_conap', '=', 'c.id_conap')
                ->select(
                    'listap.id_lista_parte',
                    'listap.tipo_lista',
                    'listap.nro_conap',
                    'listap.created_at',
                    'listap.estatus',
                    'listap.observaciones',
                    'lp_pla.nro_partes',
                    'lp_pla.descripcion',
                    'lp_pla.prioridad',
                    'lp_pla.dimensiones',
                    'lp_pla.espesor',
                    'lp_pla.cantidad_piezas',
                    'lp_pla.peso_unit',
                    'lp_pla.peso_total',
                    'perf_pla.diametro_perforacion',
                    'perf_pla.cantidad_perforacion',
                    'perf_pla.cantidad_total'
                    )
                ->where('listap.id_lista_parte', '=', $IdListaParte)
                ->get();
    }
 
    
/********************************** PERFILES ****************************************/
     public static function SumListaPartesPerfiles($Idlistap)
    {
        return DB::table('cenc_lista_perfiles as lp_per')
                ->join('cenc_fichas as c_ficha', 'lp_per.id_ficha', '=', 'c_ficha.id_ficha')
                ->select(
                    'c_ficha.nombre_ficha',
                    DB::raw('SUM(lp_per.cantidad_piezas)  AS  resumen_cant'),
                    DB::raw('SUM(lp_per.peso_total)  AS  resumen_peso'),
                    )
                ->where('lp_per.id_lista_parte', '=', $Idlistap)
                ->groupBy('c_ficha.nombre_ficha')
                ->get();
    }

    public static function CantPerforacionesListaPartesPerfiles($Idlistap)
    {
        $CantPerf = DB::select("
        DECLARE @cols AS NVARCHAR(MAX);
        DECLARE @query AS NVARCHAR(MAX);
        
        SELECT @cols = STUFF((SELECT ',' + QUOTENAME(CAST(id_ficha AS NVARCHAR(MAX)))
                             FROM (
                                SELECT id_ficha
                                FROM [cenc_lista_perfiles]
                                WHERE id_lista_parte = $Idlistap AND ISNUMERIC(id_ficha) = 1
                                GROUP BY id_ficha
                             ) AS sub
                             ORDER BY id_ficha ASC
                             FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '');
        
        SET @query = 'SELECT *
                    FROM
                    (SELECT perf_per.diametro_perforacion, lp_perf.id_ficha, perf_per.cantidad_total
                        FROM [cenc_lista_perfiles] AS lp_perf
                        INNER JOIN [cenc_perforaciones_perfiles] AS perf_per ON perf_per.id_lperfil = lp_perf.id_lperfil
                        WHERE lp_perf.id_lista_parte = $Idlistap
                    ) AS tabla
                    PIVOT
                    (
                        SUM(cantidad_total)
                        FOR id_ficha IN (' + @cols + ')
                    ) AS pivottable';
        
        SET @query = REPLACE(@query, 'NULL', '0');
        
        EXEC sp_executesql @query;
        ");
        return $CantPerf; 
    }

    
    public static function SumPerforacionesListaPartesPerfiles($Idlistap)
    {
        $CantPerf = DB::select("
        DECLARE @cols AS NVARCHAR(MAX);
        DECLARE @query AS NVARCHAR(MAX);
        
        SELECT @cols = STUFF((SELECT ',' + QUOTENAME(CAST(id_ficha AS NVARCHAR(MAX)))
                             FROM (
                                SELECT id_ficha
                                FROM [cenc_lista_perfiles]
                                WHERE id_lista_parte = $Idlistap AND ISNUMERIC(id_ficha) = 1
                                GROUP BY id_ficha
                             ) AS sub
                             ORDER BY id_ficha ASC
                             FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '');

            SET @query = 'SELECT ' + @cols + '
                      FROM
                    (SELECT perf_per.diametro_perforacion, lp_perf.id_ficha, perf_per.cantidad_total
                        FROM [cenc_lista_perfiles] AS lp_perf
                        INNER JOIN [cenc_perforaciones_perfiles] AS perf_per ON perf_per.id_lperfil = lp_perf.id_lperfil
                        WHERE lp_perf.id_lista_parte = $Idlistap
                    ) AS tabla
                    PIVOT
                    (
                        SUM(cantidad_total)
                        FOR id_ficha IN (' + @cols + ')
                    ) AS pivottable';
        
        SET @query = REPLACE(@query, 'NULL', '0');
        
        EXEC sp_executesql @query;
        ");
   
        $sumas = [];
        foreach ($CantPerf as $registro) {
            foreach ($registro as $campo => $valor) {
                if (!is_null($valor)) {
                    if (!isset($sumas[$campo])) {
                        $sumas[$campo] = 0;
                    }
                    $sumas[$campo] += intval($valor);
                }
            }
        }

        uksort($sumas, function($a, $b) {
            return $a <=> $b;
        });
        return $sumas;
    }

    //Devuelve los valores de cada espacio de la tabla tipo json
    public static function MetrosPerforacionesListaPartesPerfiles($Idlistap)
    {
        $MetrosPerfPerf = DB::select("
        DECLARE @cols AS NVARCHAR(MAX);
        DECLARE @query AS NVARCHAR(MAX);
        
        SELECT @cols = STUFF((SELECT ',' + QUOTENAME(CAST(id_ficha AS NVARCHAR(MAX)))
                             FROM (
                                SELECT id_ficha
                                FROM [cenc_lista_perfiles]
                                WHERE id_lista_parte = $Idlistap AND ISNUMERIC(id_ficha) = 1
                                GROUP BY id_ficha
                             ) AS sub
                             ORDER BY id_ficha ASC
                             FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '');
        
        SET @query = 'SELECT *
                    FROM
                    (SELECT perf_per.diametro_perforacion, lp_perf.id_ficha, perf_per.cantidad_total
                        FROM [cenc_lista_perfiles] AS lp_perf
                        INNER JOIN [cenc_perforaciones_perfiles] AS perf_per ON perf_per.id_lperfil = lp_perf.id_lperfil
                        WHERE lp_perf.id_lista_parte = $Idlistap
                    ) AS tabla
                    PIVOT
                    (
                        SUM(cantidad_total)
                        FOR id_ficha IN (' + @cols + ')
                    ) AS pivottable';
        
        SET @query = REPLACE(@query, 'NULL', '0');
        
        EXEC sp_executesql @query;
        ");
        return $MetrosPerfPerf; 
    }

    public static function TotalMetrosPerforacionesListaPartesPerfiles($Idlistap) 
    {
        $MetrosPerfPerf = DB::select("
        DECLARE @cols AS NVARCHAR(MAX);
        DECLARE @query AS NVARCHAR(MAX);
        
        SELECT @cols = STUFF((SELECT ',' + QUOTENAME(CAST(id_ficha AS NVARCHAR(MAX)))
                             FROM (
                                SELECT id_ficha
                                FROM [cenc_lista_perfiles]
                                WHERE id_lista_parte = $Idlistap AND ISNUMERIC(id_ficha) = 1
                                GROUP BY id_ficha
                             ) AS sub
                             ORDER BY id_ficha ASC
                             FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '');
        
        SET @query = 'SELECT ' + @cols + '
                    FROM
                    (SELECT perf_per.diametro_perforacion, lp_perf.id_ficha, perf_per.cantidad_total
                        FROM [cenc_lista_perfiles] AS lp_perf
                        INNER JOIN [cenc_perforaciones_perfiles] AS perf_per ON perf_per.id_lperfil = lp_perf.id_lperfil
                        WHERE lp_perf.id_lista_parte = $Idlistap
                    ) AS tabla
                    PIVOT
                    (
                        SUM(cantidad_total)
                        FOR id_ficha IN (' + @cols + ')
                    ) AS pivottable';
        
        SET @query = REPLACE(@query, 'NULL', '0');
        
        EXEC sp_executesql @query;
        ");
   
        $sumas = [];
        foreach ($MetrosPerfPerf as $registro) {
            foreach ($registro as $campo => $valor) {
                if (!is_null($valor)) {
                    if (!isset($sumas[$campo])) {
                        $sumas[$campo] = 0;
                    }
                    $sumas[$campo] += $valor;
                }
            }
        }

        uksort($sumas, function($a, $b) {
            return $a <=> $b;
        });
        return $sumas;
    }

    public static function BuscarAlayAlmaListaPartesPerfiles($Idlistap,$Diametro)
    {
        $BuscarAPerfil = DB::select("
        SELECT 
            lp_perf.id_lista_parte, 
            lp_perf.id_ficha, 
            c_ficha.nombre_ficha,
            lp_perf.nro_partes, 
            perf_per.diametro_perforacion,  
            perf_per.t_ala,
            perf_per.s_alma,
            perf_per.cantidad_total
        FROM cenc_lista_perfiles AS lp_perf
        INNER JOIN cenc_perforaciones_perfiles AS perf_per ON lp_perf.id_lperfil = perf_per.id_lperfil
        INNER JOIN cenc_fichas as c_ficha ON lp_perf.id_ficha = c_ficha.id_ficha
        WHERE lp_perf.id_lista_parte = $Idlistap and perf_per.diametro_perforacion = $Diametro
        ");
        return $BuscarAPerfil; 
    }


    
    public static function ListaPartesDetalladaPerfil($IdListaParte)
    {
        return DB::table('cenc_lista_partes as listap')
                ->join('cenc_lista_perfiles as lp_perf', 'lp_perf.id_lista_parte', '=', 'listap.id_lista_parte')
                ->join('cenc_perforaciones_perfiles AS perf_per', 'perf_per.id_lperfil', '=', 'lp_perf.id_lperfil')
                ->join('cenc_fichas as c_ficha', 'lp_perf.id_ficha', '=', 'c_ficha.id_ficha')
                ->join('cenc_conaps as c', 'listap.nro_conap', '=', 'c.id_conap')
                ->select(
                    'listap.id_lista_parte',
                    'listap.nro_conap',
                    'listap.created_at',
                    'listap.tipo_lista',
                    'listap.observaciones',
                    'lp_perf.nro_partes',
                    'lp_perf.id_ficha',
                    'c_ficha.nombre_ficha',
                    'lp_perf.id_lperfil',
                    'lp_perf.cantidad_piezas',
                    'lp_perf.prioridad',
                    'lp_perf.longitud_pieza',
                    'lp_perf.tipo_corte',
                    'lp_perf.peso_unit',
                    'lp_perf.peso_total',
                    'perf_per.id_perforacion_perfil',
                    'perf_per.diametro_perforacion',
                    'perf_per.t_ala',
                    'perf_per.s_alma',
                    'perf_per.cantidad_total',
                    'c.nro_conap'
                    )
                ->where('listap.id_lista_parte', '=', $IdListaParte)
                ->get();
    }
    

    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
