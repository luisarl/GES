<?php

namespace App\Exports;

use App\Models\Resg_ResguardoModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResgArticulosResguardoExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;
    
    public function __construct($IdAlmacen,$IdClasificacion)
    {
        $this->IdAlmacen = $IdAlmacen;
        $this->IdClasificacion = $IdClasificacion;
      
    }

    public function collection()
    {
        $resguardos = Resg_ResguardoModel::ArticulosResguardoAlmacenClasificacion($this->IdAlmacen,$this->IdClasificacion);
        $reporte = [];

        foreach ($resguardos as  $resguardo) 
        {
          

            $reporte[] = [
                $resguardo->id_resguardo,
                $resguardo->id_solicitud_resguardo,
                $resguardo->nombre_almacen,
                $resguardo->codigo_articulo,
                wordwrap($resguardo->nombre_articulo, 30, '-'),
                $resguardo->presentacion,
                number_format($resguardo->cantidad_disponible, 2),
                $resguardo->nombre_clasificacion,
                $resguardo->observacion,
                $resguardo->estado,
                $resguardo->estatus,
           
            ];
        }

        return collect($reporte);
    }

    public function headings(): array
    {
        return [
            [
               'RESG.',
               'SOLIC. RESG.',
               'ALMACEN',
               'CODIGO',
               'NOMBRE',
               'PRESENTACION',
               'CANTIDAD',
               'DISP.FINAL',
               'OBSERVACION',
               'ESTADO',
               'ESTATUS'
            ],
        ];
    }
}