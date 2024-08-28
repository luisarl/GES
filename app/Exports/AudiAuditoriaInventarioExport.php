<?php

namespace App\Exports;

use App\Models\Audi_Auditoria_InventarioModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AudiAuditoriaInventarioExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;
    
    public function __construct($fecha, $numeroauditoria)
    {
        $this->fecha = $fecha;
        $this->numeroauditoria = $numeroauditoria;
    }

    public function collection()
    {
       $articulos = Audi_Auditoria_InventarioModel::ArticulosAuditoriaInventario($this->fecha, $this->numeroauditoria);
       $reporte = [];

       foreach ($articulos as $articulo) 
       {
            $reporte[] = [
               $articulo->numero_auditoria,
               $articulo->codigo_articulo,
               $articulo->nombre_articulo,
               $articulo->nombre_almacen,
               $articulo->nombre_subalmacen,
               $articulo->usuario,
               date('d-m-Y g:i:s A', strtotime($articulo->fecha)),
               number_format($articulo->stock_actual, 2, ',', ''),
               number_format($articulo->conteo_fisico, 2, ',', ''),
               number_format($articulo->diferencia, 2, ',', ''),
               $articulo->observacion,
            ];
        }

        return collect($reporte);
    }

    public function headings(): array
    {     
        return 
        [
            [
            'NUMERO AUDITORIA', 
            'CODIGO',
            'ARTICULO',
            'ALMACEN',
            'SUBALMACEN',
            'USUARIO',
            'FECHA',
            'STOCK',
            'CONTEO',
            'DIFERENCIA',
            'OBSERVACION',
             ],
        ];
    }
}
