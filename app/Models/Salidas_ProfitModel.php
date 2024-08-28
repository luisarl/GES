<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Salidas_ProfitModel extends Model
{
    use HasFactory;

    public static function SalidasArticulosDepartamentoAño($departamento, $articulo, $categoria, $grupo, $subgrupo, $año)
    {
        $salidas =  DB::connection('profit')
            ->table('MasterProfit.dbo.vSalidaArticulosDepartamentoMes')
            ->select(
                'Gerencia',
                'Codigo',
                'Articulo',
                'Categoria',
                'Grupo',
                'SubGrupo',
                'Unidad',
                'Anio',
                'Ene',
                'Feb',
                'Mar',
                'Abr',
                'May',
                'Jun',
                'Jul',
                'Ago',
                'Sep',
                'Oct',
                'Nov',
                'Dic',
            );
            // ->whereBetween('FecSolP', [$FechaInicio , $FechaFin]);

            if($departamento != 'TODOS') 
            {
                $salidas->where('Gerencia', '=', $departamento);
            }

            if($articulo != 'TODOS') 
            {
                $salidas->where('Codigo', '=', $articulo);
            }

            if($categoria != 'TODOS') 
            {
                $salidas->where('CodCategoria', '=', $categoria);
            }

            if($grupo != 'TODOS') 
            {
                $salidas->where('CodGrupo', '=', $grupo);
            }

            if($subgrupo != 'TODOS') 
            {
                $salidas->where('CodSubGrupo', '=', $subgrupo);
            }

            if($año != '') 
            {
                $salidas->where('anio', '=', $año);
            }
            else
                {
                    $salidas->where('anio', '=', date('Y'));
                }

            //$salidas->limit(10);
            return $salidas->get();
    }
}
