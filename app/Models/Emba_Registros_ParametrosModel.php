<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Emba_Registros_ParametrosModel extends Model
{
    use HasFactory;

    protected $table = 'emba_registros_parametros';
    protected $primaryKey = 'id_registro_parametro';

    protected $fillable = [
        'id_registro_parametro',
        'id_maquina',
        'id_parametro',
        'valor',
        'fecha',
        'hora',
        'creado_por',
        'actualizado_por',
        'observaciones'
    ];

    protected $dateFormat = 'Y-d-m H:i:s';  //formato de fecha

    public static function DatosCrearRegistroParametros($IdMaquina, $fecha)
    {
        return DB::table('emba_maquinas_parametros AS mp')
                ->join('emba_maquinas AS m','mp.id_maquina','=','m.id_maquina')
                ->join('emba_parametros AS p', 'mp.id_parametro', '=', 'p.id_parametro')
                ->select(
                    'mp.id_maquina',
                    'm.nombre_maquina',
                    'mp.id_parametro',
                    'p.nombre_parametro',
                    'mp.valor_minimo',
                    'mp.valor_maximo',
                    DB::raw("(select DATEADD(HOUR, 1, MAX(CAST(hora AS TIME(0)))) 
                    from emba_registros_parametros where id_maquina = mp.id_maquina and fecha = '$fecha') 
                    as hora")
                )
                ->where('mp.id_maquina', '=', $IdMaquina)
                ->orderBy('mp.orden')
                ->get();
    }

    public static function DatosEditarRegistroParametros($IdMaquina, $fecha, $hora)
    {
        return DB::table('emba_registros_parametros AS rp')
                ->join('emba_maquinas AS m','rp.id_maquina','=','m.id_maquina')
                ->join('emba_parametros AS p', 'rp.id_parametro', '=', 'p.id_parametro')
                ->join('emba_maquinas_parametros AS mp', function($join)
                {
                    $join->on('mp.id_parametro', '=', 'rp.id_parametro');
                    $join->on('mp.id_maquina', '=', 'rp.id_maquina');
                })
                ->select(
                    'rp.id_registro_parametro',
                    'rp.id_maquina',
                    'm.nombre_maquina',
                    'rp.id_parametro',
                    'p.nombre_parametro',
                    'mp.valor_minimo',
                    'mp.valor_maximo',
                    DB::raw("CAST(rp.hora AS TIME(0)) as hora"),
                    'rp.valor',
                    'rp.observaciones'
                )
                ->where('rp.id_maquina', '=', $IdMaquina)
                ->where('rp.fecha', '=', $fecha)
                ->where('rp.hora', '=', $hora)
                ->get();
    }

    public static function BuscarRegistroParametros($IdMaquina, $fecha)
    {
        return DB::select("
            SELECT 
                fecha,
                nombre_maquina,
                nombre_parametro,
                orden, 
                valor_minimo,
                valor_maximo,
                [00:00] AS hora0,
                [01:00] AS hora1,
                [02:00] AS hora2,
                [03:00] AS hora3,
                [04:00] AS hora4,
                [05:00] AS hora5,
                [06:00] AS hora6,
                [07:00] AS hora7,
                [08:00] AS hora8,
                [09:00] AS hora9,
                [10:00] AS hora10,
                [11:00] AS hora11,
                [12:00] AS hora12,
                [13:00] AS hora13,
                [14:00] AS hora14,
                [15:00] AS hora15,
                [16:00] AS hora16,
                [17:00] AS hora17,
                [18:00] AS hora18,
                [19:00] AS hora19,
                [20:00] AS hora20,
                [21:00] AS hora21,
                [22:00] AS hora22,
                [23:00] AS hora23
            
            FROM (
                SELECT 
                    rp.id_maquina,
                    m.nombre_maquina,
                    mp.orden,
                    rp.id_parametro,
                    p.nombre_parametro,
                    mp.valor_minimo,
                    mp.valor_maximo,
                    rp.valor,
                    rp.fecha,
                    rp.hora
                FROM emba_registros_parametros AS rp
                    INNER JOIN emba_maquinas_parametros AS mp ON mp.id_parametro = rp.id_parametro AND mp.id_maquina = rp.id_maquina
                    INNER JOIN emba_parametros AS p ON p.id_parametro = rp.id_parametro
                    INNER JOIN emba_maquinas as m ON m.id_maquina = rp.id_maquina
                WHERE rp.id_maquina = ? AND rp.fecha = ?
                )
                AS parametros
                PIVOT  (MAX(valor) 
                FOR hora IN ([00:00],[01:00],[02:00],[03:00],[04:00],[05:00],[06:00],[07:00],[08:00],[09:00],[10:00],[11:00],
                             [12:00],[13:00],[14:00],[15:00],[16:00],[17:00],[18:00],[19:00],[20:00],[21:00],[22:00],[23:00])) as pvt 
                ORDER BY orden" 
                ,[$IdMaquina, $fecha]
            );
    }

    public static function BuscarObservacionesRegistroParametros($IdMaquina, $fecha)
    {
        return DB::table('emba_registros_parametros')
            ->where('id_maquina', '=', $IdMaquina)
            ->where('fecha', '=', $fecha)
            ->distinct()
            ->select( 
                DB::raw("CAST(hora AS TIME(0)) as hora"),
                'observaciones'
                )
            ->get();
    }

    public static function ContarRegistrosMaquinaFecha($IdMaquina, $fecha)
    {
        return DB::table('emba_registros_parametros')
            ->where('id_maquina', '=', $IdMaquina)
            ->where('fecha', '=', $fecha)
            ->distinct('hora')
            ->count();
    }

    public static function RegistroParametrosHoras($IdMaquina, $fecha)
    {
        return  DB::select("
            DECLARE @columnas nvarchar(MAX);
            DECLARE @sql nvarchar(MAX);

            SELECT @columnas= ISNULL(@columnas + ',','')  
                + QUOTENAME(parametros) 
            FROM (
                    SELECT DISTINCT
                        p.nombre_parametro parametros, orden
                    FROM emba_registros_parametros as rp
                    inner join emba_maquinas_parametros as mp ON mp.id_parametro = rp.id_parametro and mp.id_maquina = rp.id_maquina
                    inner join emba_parametros as p ON p.id_parametro = rp.id_parametro
                    WHERE rp.id_maquina = $IdMaquina and  rp.fecha = '$fecha'
                    ORDER BY  mp.orden OFFSET 0 ROWS  
                    )
                    AS parametros
                  
            SET @sql =   
                    N' SELECT 
                    *
                    FROM (
                        SELECT 
                            rp.hora,
                            p.nombre_parametro,
                            rp.valor
                        FROM emba_registros_parametros as rp
                        INNER JOIN emba_maquinas_parametros as mp ON mp.id_parametro = rp.id_parametro and mp.id_maquina = rp.id_maquina
                        INNER JOIN emba_parametros as p ON p.id_parametro = rp.id_parametro
                        WHERE rp.id_maquina = $IdMaquina
                        AND rp.fecha = ''$fecha''
                       ) 
                     AS parametros

                     PIVOT (
                        MAX(valor) 
                            FOR nombre_parametro IN (' + @columnas + N')
                       ) AS pvt ';
                        
            EXEC sp_executesql @sql
        ");

    }

    public static function RegistroParametroMaquinaFecha($IdMaquina, $IdParametro, $fecha)
    {
        return DB::table('emba_registros_parametros AS rp')
                ->join('emba_maquinas AS m', 'm.id_maquina', '=', 'rp.id_maquina')
                ->join('emba_parametros AS p', 'p.id_parametro', '=', 'rp.id_parametro')
                ->select(
                    'm.nombre_maquina',
                    'p.nombre_parametro',
                    'rp.hora',
                    'rp.valor'
                )
                ->where('rp.id_maquina', '=', $IdMaquina)
                ->where('rp.id_parametro', '=', $IdParametro)
                ->where('rp.fecha', '=', $fecha)
                ->get();
    }

    public static function EstadisticasRegistrosMaquinasFecha($IdMaquina, $IdParametro, $fecha)
    {
        $estadisticas = DB::table('emba_registros_parametros AS rp')
                ->join('emba_maquinas AS m', 'm.id_maquina', '=', 'rp.id_maquina')
                ->join('emba_parametros AS p', 'p.id_parametro', '=', 'rp.id_parametro')
                ->join('emba_maquinas_parametros AS mp', function($join)
                {
                    $join->on('mp.id_parametro', '=', 'rp.id_parametro');
                    $join->on('mp.id_maquina', '=', 'rp.id_maquina');
                })
                ->select(
                    'm.nombre_maquina',
                    'p.nombre_parametro',
                    DB::raw("(SELECT MIN(hora) from emba_registros_parametros 
                            where valor = min(rp.valor) and id_maquina = rp.id_maquina and id_parametro = rp.id_parametro  and fecha = rp.fecha)
                            AS hora_minima"),
                    DB::raw("MIN(rp.valor) AS valor_minimo"),
                    DB::raw("(SELECT MAX(hora) from emba_registros_parametros 
                            where valor = max(rp.valor) and id_maquina = rp.id_maquina and id_parametro = rp.id_parametro  and fecha = rp.fecha) 
                            AS hora_maxima"),
                    DB::raw("MAX(rp.valor) AS valor_maximo"),
                    DB::raw("AVG(rp.valor) as valor_promedio")
                )
                ->where('rp.id_maquina', '=', $IdMaquina)
                ->where('rp.fecha', '=', $fecha);
                
                if($IdParametro != 0)
                {
                    $estadisticas->where('rp.id_parametro', '=', $IdParametro);
                }
                
                $estadisticas->groupBy(
                    'rp.fecha',
                    'rp.id_maquina',
                    'm.nombre_maquina',
                    'rp.id_parametro',
                    'p.nombre_parametro',
                    'mp.orden'
                )
                ->orderBy('mp.orden');

        return $estadisticas->get();
    }
    

}
