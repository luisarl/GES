<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comp_ProfitModel extends Model
{
    use HasFactory;

    public static function CompSolPDetalle($empresa, $solp)
    {
       return DB::connection('profit')
        ->table('masterprofit.dbo.vSolP')
        ->select(
            'CodEmpresa',
            'Empresa',
            'SolP',
            'NumSolP',
            'CondicionSolP',
            'EstadoSolP',
            'FechaSolP',
            'Motivo',
            'Solicita',
            'Superior',
            'Unidad',
            'Comprador',
            'Justifica',
            'Estado',
            'FechaAprob',
            'Aprobo',
            'Renglon',
            'CodArticulo',
            'Articulo',
            'Cantidad',
            'Pendiente',
        )
        ->where('CodEmpresa', '=', $empresa)
        ->where('SolP', '=', $solp)
        ->get();
    }

    public static function CompListaSolPEstado($estado)
    {
        return DB::connection('profit')
        ->table('masterprofit.dbo.vEncabezadoSolP')
        ->select(
            'CodEmpresa',
            'Empresa',
            'SolP',
            'NumSolP',
            'Motivo',
            'CondicionSolP',
            'EstadoSolP',
            'FechaSolP',
            'Solicita',
            'Superior',
            'Unidad',
            'Comprador',
            'Estado',
            'FechaAprob',
            'Aprobo',
            'Justifica'
        )
        ->where('Estado', '=', $estado)
        ->get();  
    }

    public static function CompListadoCompradores()
    {
        return DB::connection('profit')
                ->table('masterprofit.dbo.vCompradores')
                ->select(
                    'employee_i as id_comprador',
                    'last_name as nombre_comprador'
                )
                ->get();
    }

    public static function GuardarAprobacionSolp($empresa, $solp, $estado, $autorizado, $fecha)
    {   
        $FechaA = Carbon::parse($fecha)->format('d/m/Y');

        DB::connection('profit')
            ->table($empresa.'.dbo.placom')
            ->where('fact_num', '=', $solp)
            ->update(['nombre' => $estado, 'rif' => $autorizado, 'nit' => $FechaA ]);
    }

    public static function AsignarCompradorSolp($empresa, $solp, $comprador)
    {   
        DB::connection('profit')
            ->table($empresa.'.dbo.placom')
            ->where('fact_num', '=', $solp)
            ->update(['campo8' => $comprador]);
    }

    public static function CompProductividadComprador($FechaInicio, $FechaFin, $comprador)
    {
        return  DB::connection('profit')
            ->select('EXEC masterprofit.dbo.ResumenProductividadComprador ?, ?, ?', array($FechaInicio, $FechaFin, $comprador));
    }

    public static function CompProductividadComprador1($FechaInicio, $FechaFin, $comprador)
    {
        return  DB::connection('profit')
            ->select('EXEC masterprofit.dbo.ResumenProductividadComprador1 ?, ?, ?', array($FechaInicio, $FechaFin, $comprador));
    }

    public static function CompProductividadComprador2($FechaInicio, $FechaFin, $comprador)
    {
        return  DB::connection('profit')
            ->select('EXEC masterprofit.dbo.ResumenProductividadComprador2 ?, ?, ?', array($FechaInicio, $FechaFin, $comprador));
    }

    public static function CompProductividadComprador3($FechaInicio, $FechaFin, $comprador)
    {
        return  DB::connection('profit')
            ->select('EXEC masterprofit.dbo.ResumenProductividadComprador3 ?, ?, ?', array($FechaInicio, $FechaFin, $comprador));
    }

    public static function CompProductividadCompradorDetalle($FechaInicio, $FechaFin, $comprador)
    {
        $productividad =  DB::connection('profit')
            ->table('MasterProfit.dbo.vSeguimientoSolP-OC-NDR')
            ->select(
                'Empresa',
                'NumSolP',
                'SolP',
                'FecSolP',
                DB::raw("CASE WHEN FecSolP = ' ' THEN '' ELSE MONTH(FecSolP) END AS MesSolP"),
                'CondicionSolP',
                'EstatusSolP',
                'Comprador',
                'Solicitante',
                'Superior',
                'Departamento',
                'Motivo',
                'Estado',
                'Autoriza',
                'FecAut',
                'NumOC',
                'OC',
                'FecOC',
                DB::raw("CASE WHEN FecOC = ' ' THEN '' ELSE MONTH(FecOC) END AS MesOC"),
                'CondicionOC',
                'EstatusOC',
                'NDR',
                'FecNDR',
                DB::raw("CASE WHEN FecNDR = ' ' THEN '' ELSE MONTH(FecNDR) END AS MesNDR"),
                'EstadoEEM',
                'FechaEEM',
                'FechaPago',
                'EmpresaPaga',
                'FACT',
                'FecFACT',
                'Saldo',
            )
            ->whereRaw('convert(DATE,FecSolP, 103) BETWEEN ? AND ?', [$FechaInicio , $FechaFin] );
          
            if($comprador != 'TODOS' ) 
            {
                $productividad->where('Comprador', '=', $comprador);
            }
            
            return $productividad->get();
    }

    public static function CompHistorialCompras($CodigoArticulo)
    {
       return DB::connection('profit')
        ->table('masterprofit.dbo.vArticulosHistorialCompras')
        ->select(
            'Codigo',
            'Articulo',
            'OC',
            DB::RAW("CONVERT(date,Fecha) as Fecha"),
            'CodProveedor',
            'Proveedor',
            DB::RAW("CONVERT(NUMERIC(10, 2), REPLACE(Cantidad, ',', '.')) AS Cantidad"),
            'Unidad',
            DB::RAW("CONVERT(NUMERIC(10, 2), REPLACE(CostoUnitarioUS, ',', '.')) AS CostoUnitarioUS"),
        )
        ->where('Codigo', '=', $CodigoArticulo)
        ->orderBy('Fecha','desc')
        ->get();
    }
}
