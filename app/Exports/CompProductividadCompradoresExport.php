<?php

namespace App\Exports;

use App\Models\Comp_ProfitModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompProductividadCompradoresExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function __construct($FechaInicio, $FechaFin, $comprador)
    {
        $this->FechaInicio = $FechaInicio;
        $this->FechaFin = $FechaFin;
        $this->comprador = $comprador;
    }

    public function collection()
    {
        return Comp_ProfitModel::CompProductividadCompradorDetalle($this->FechaInicio, $this->FechaFin, $this->comprador);
    }

    public function headings(): array
    {     
        return 
        [
            ['Empresa',	'NumSolP',	'SolP',	'FecSolP', 'MesSolP',	'CondicionSolP',	'EstatusSolP',	'Comprador',	'Solicitante',	'Superior',	'Departamento',
            	'Motivo',	'Estado',	'Autoriza',	'FecAut',	'NumOC',	'OC',	'FecOC', 'MesOC',	'CondicionOC',	'EstatusOC',	'NDR',	'FecNDR', 'MesNDR',	'EstadoEEM',	
                'FechaEEM',	'FechaPago',	'EmpresaPaga',	'FACT',	'FecFACT',	'Saldo'],
        ];

    }
}
