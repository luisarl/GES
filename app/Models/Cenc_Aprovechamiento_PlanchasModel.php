<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cenc_Aprovechamiento_PlanchasModel extends Model
{
    use HasFactory;

    protected $table = 'cenc_aprovechamiento_planchas';
    protected $primaryKey = 'id_aprovechamiento_plancha';

    protected $fillable = [ // con sta estructura voy a repetir los registros... 
        'id_aprovechamiento_plancha',
        'id_aprovechamiento',
        'nombre_equipo',
        'nombre_tecnologia',
        'espesor',
        'longitud_corte',
        'numero_piercing',
        'tiempo_estimado',
        'juego_antorcha',
        'numero_boquilla',
        'precalentamiento',
        'tiempo_precalentamiento',
        'observaciones'
    ];

    public static function ListaParteConap($IdConap)
    {
        return DB::table('cenc_conaps AS c')
                ->join('cenc_lista_partes AS listap', 'listap.nro_conap', '=', 'c.id_conap')
                ->select(
                        'listap.id_lista_parte',
                        'listap.tipo_lista'
                        )
                ->where('listap.nro_conap', '=', $IdConap)
                ->get();
    }

    public static function MaterialProcesadoPlancha($IdConap, $IdListaParte)
    {
        return DB::table('cenc_lista_partes AS listap')
                                ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                                ->join('cenc_lista_planchas AS lp_pla', 'listap.id_lista_parte', '=', 'lp_pla.id_lista_parte')
                                ->join('cenc_perforaciones_planchas AS perf_pla', 'lp_pla.id_lista_parte', '=', 'perf_pla.id_plancha')
                                ->select(
                                    'listap.id_lista_parte',
                                    'lp_pla.espesor',
                                    DB::raw('SUM(cantidad_piezas)  AS  cantidad'),
                                    DB::raw('SUM(peso_total)  AS  peso')
                                )
                                ->where('c.id_conap', '=', $IdConap)
                                ->where('listap.id_lista_parte', '=', $IdListaParte)
                                ->groupBy('lp_pla.espesor','listap.id_lista_parte')
                                ->get();
    }

    // public static function ListaParteEspesor($IdConap, $IdListaParte, $IdEquipo, $IdTecnologia)
    // {
    //     return DB::table('cenc_lista_partes AS listap')
    //                             ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
    //                             ->join('cenc_lista_planchas AS lp_pla', 'listap.id_lista_parte', '=', 'lp_pla.id_lista_parte')
    //                             ->join('cenc_perforaciones_planchas AS perf_pla', 'lp_pla.id_lista_parte', '=', 'perf_pla.id_plancha')
    //                             ->join('cenc_tablas_consumo AS tc', 'tc.espesor', '=', 'lp_pla.espesor')
    //                             ->join('cenc_equipos_consumibles AS ec', 'ec.id_equipotecnologia', '=', 'tc.id_equipo_consumible')
    //                             ->join('cenc_equipos_tecnologias AS et', 'et.id_equipotecnologia', '=', 'ec.id_equipotecnologia')
    //                             ->join('cenc_equipos AS e', 'e.id_equipo', '=', 'et.id_equipo')
    //                             ->join('cenc_tecnologias AS t', 't.id_tecnologia', '=', 'et.id_tecnologia')
    //                             ->select(
    //                                 'lp_pla.espesor'
    //                             )
    //                             ->where('c.id_conap', '=', $IdConap)
    //                             ->where('listap.id_lista_parte', '=', $IdListaParte)
    //                             ->where('e.id_equipo', '=', $IdEquipo)
    //                             ->where('t.id_tecnologia', '=', $IdTecnologia)
    //                             ->groupBy('lp_pla.espesor','listap.id_lista_parte')
    //                             ->get();
        
    // }

    public static function ListaParteEspesor($IdConap, $IdListaParte)
    {
        return DB::table('cenc_lista_partes AS listap')
                                ->join('cenc_conaps AS c', 'listap.nro_conap', '=', 'c.id_conap')
                                ->join('cenc_lista_planchas AS lp_pla', 'listap.id_lista_parte', '=', 'lp_pla.id_lista_parte')
                                //->join('cenc_perforaciones_planchas AS perf_pla', 'lp_pla.id_lista_parte', '=', 'perf_pla.id_plancha')
                               
                                ->select(
                                    'lp_pla.espesor'
                                )
                                ->where('c.id_conap', '=', $IdConap)
                                ->where('listap.id_lista_parte', '=', $IdListaParte)
                                
                                ->groupBy('lp_pla.espesor')
                                ->get();
        
    }

    public static function ListaMateriaPrima()
    {
        return DB::connection('profit')
            ->table('masterprofit.dbo.vArticulosActivosPatio as master')
            ->select(
                'master.co_art',
                'master.art_des',
                'master.stock_act',
                // 'master.ubicacion', 
                // 'master.modelo',
                'master.peso',
                'master.tipo'
            )
            ->get();
    }

    public static function MaterialProcesadoPlanchaEspesor($IdListaParte, $espesor)
    {
       
        return DB::table('cenc_lista_planchas AS lp_pla')
                    ->select(
                            'lp_pla.espesor',
                            DB::raw('SUM(cantidad_piezas)  AS  cantidad'),
                            DB::raw('SUM(peso_total)  AS  peso')
                            )
                    ->where('lp_pla.id_lista_parte', '=', $IdListaParte)
                    ->where('lp_pla.espesor', '=', $espesor)
                    ->groupBy('lp_pla.espesor')
                    ->get();

    }

    public static function BuscarInsertoPlancha($IdListaParte, $espesor)
    {
        return DB::table('cenc_lista_planchas AS lp_pla')
                    ->join('cenc_perforaciones_planchas as perf_pla', 'perf_pla.id_plancha', '=', 'lp_pla.id_lplancha')
                    ->select(
                            'perf_pla.diametro_perforacion'
                            )
                    ->where('lp_pla.id_lista_parte', '=', $IdListaParte)
                    ->where('lp_pla.espesor', '=', $espesor)
                    ->get();
    }

    public static function updateStatus($idAprov, $estatus)
    {
        DB::table('cenc_aprovechamientos')
            ->where('id_aprovechamiento', $idAprov)
            ->update(['estatus' => $estatus]);
    }


    public static function CiclosDeTaladrosPlancha($Idlistap, $espesor)
    {
        return DB::table('cenc_aprovechamientos as aprov')
                ->join('cenc_aprovechamiento_planchas as aprov_pla', 'aprov_pla.id_aprovechamiento', '=', 'aprov.id_aprovechamiento')
                ->join('cenc_lista_partes as lp', 'lp.id_lista_parte', '=', 'aprov.id_lista_parte')
                ->join('cenc_lista_planchas as lpp', 'lpp.id_lista_parte', '=', 'lp.id_lista_parte')
                ->join('cenc_perforaciones_planchas as perf_pla', 'perf_pla.id_plancha', '=', 'lpp.id_lplancha')
                ->select('perf_pla.cantidad_total')
                ->where('lpp.espesor','=',$espesor)
                ->where('lp.id_lista_parte','=',$Idlistap)
                ->groupBy('perf_pla.cantidad_total','lpp.espesor')
                ->get();
    }


    public static function TotalMetrosPerforacionesAprovListaPartesPlanchas($Idlistap,$espesor) 
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
                
                SET @query = 'SELECT *, [$espesor] as TotalMetrosP
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

    public static function MetrosPerforacionPlancha($Idlistap,$espesor)
    {
        $MetrosPerforacionPlancha = DB::select("
            DECLARE @cols AS NVARCHAR(MAX);
            DECLARE @query AS NVARCHAR(MAX);
            
            SELECT @cols = STUFF((SELECT ',' + QUOTENAME(CAST(espesor AS NVARCHAR(MAX)))
                                FROM (
                                    SELECT espesor
                                    FROM [cenc_lista_planchas]
                                    WHERE id_lista_parte = $Idlistap AND ISNUMERIC(espesor) = 1
                                    AND espesor = $espesor
                                    GROUP BY espesor
                                ) AS sub
                                ORDER BY espesor ASC
                                FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '');
            
            SET @query = 'SELECT *, [$espesor] as MetrosPer
                        FROM
                        (SELECT perf_pla.diametro_perforacion, lp_pla.espesor,
                        CAST(lp_pla.espesor * perf_pla.cantidad_perforacion AS FLOAT) * 0.001 AS Metros, COALESCE(perf_pla.cantidad_perforacion, 0) AS cantidad_perforacion
                            FROM [cenc_lista_planchas] AS lp_pla
                            INNER JOIN [cenc_perforaciones_planchas] AS perf_pla ON perf_pla.id_plancha = lp_pla.id_lplancha
                            WHERE lp_pla.id_lista_parte = $Idlistap
                        ) AS tabla
                        PIVOT
                        (
                            SUM(Metros) 
                            FOR espesor IN (' + @cols + ')
                        ) AS pivottable';
        
            EXEC sp_executesql @query;
        ");
        return $MetrosPerforacionPlancha; 
    }


    protected $dateFormat = 'Y-d-m H:i:s';  //funcion para formateo de la fecha
}
