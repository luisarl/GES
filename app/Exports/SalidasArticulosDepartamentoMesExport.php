<?php

namespace App\Exports;

use App\Models\Salidas_ProfitModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalidasArticulosDepartamentoMesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;
    
    public function __construct($departamento, $articulo, $categoria,  $grupo, $subgrupo, $año)
    {
        $this->departamento = $departamento;
        $this->articulo = $articulo;
        $this->categoria = $categoria;
        $this->grupo = $grupo;
        $this->subgrupo = $subgrupo;
        $this->año = $año;
    }

    public function collection()
    {
        $salidas = Salidas_ProfitModel::SalidasArticulosDepartamentoAño($this->departamento, $this->articulo, $this->categoria, $this->grupo, 
        $this->subgrupo, $this->año);

        $reporte = [];

        foreach($salidas as $salida)
        {
            $total = $salida->Ene + $salida->Feb + $salida->Mar + $salida->Abr + $salida->May + $salida->Jun 
                    + $salida->Jul + $salida->Ago + $salida->Sep + $salida->Oct + $salida->Nov + $salida->Dic;

            $reporte[] =[
                $salida->Gerencia,
                $salida->Codigo,
                $salida->Articulo,
                $salida->Categoria,
                $salida->Grupo,
                $salida->SubGrupo,
                $salida->Unidad,
                $salida->Anio,
                $salida->Ene,
                $salida->Feb,
                $salida->Mar,
                $salida->Abr,
                $salida->May,
                $salida->Jun,
                $salida->Jul,
                $salida->Ago,
                $salida->Sep,
                $salida->Oct,
                $salida->Nov,
                $salida->Dic,
                $total
            ];
        }

        return collect($reporte);
    }

    public function headings(): array
    {     
        return 
        [
            ['Gerencia', 'CodigoArticulo',	'Articulo',	'Categoria', 'Grupo', 'SubGrupo', 'Unidad', 'Anio',	
            'Ene',	'Feb',	'Mar',	'Abr',	'May',	'Jun',	'Jul',	'Ago',	'Sep',	'Oct',	'Nov',	'Dic', 'TOTAL' ],
        ];

    }
}
