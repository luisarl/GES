<?php

namespace App\Exports;

use App\Models\Asal_Salidas_DetalleModel;
use App\Models\Asal_SalidasModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;

class AutorizacionSalidasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;

    public function __construct($FechaInicio, $FechaFin, $estatus, $IdAlmacen)
    {
        $this->FechaInicio = $FechaInicio;
        $this->FechaFin = $FechaFin;
        $this->estatus = $estatus;
        $this->IdAlmacen = $IdAlmacen;

    }

    public function collection()
    {
        $salidas = Asal_SalidasModel::ReporteSalidas($this->FechaInicio, $this->FechaFin, $this->estatus, $this->IdAlmacen);

        $reporte = [];

        foreach($salidas as $salida)
        {
            $articulos = Asal_Salidas_DetalleModel::
                select(
                    'codigo_articulo',
                    'nombre_articulo',
                    'tipo_unidad',
                    'cantidad_salida',
                    'cantidad_retorno',
                    'comentario',
                    'estatus'
                    )
                ->where('id_salida', $salida->id_salida)
                ->where('fecha_retorno', NULL)
                ->get();

                if($salida->tipo_vehiculo == 'INTERNO')
                { 
                    $vehiculo = $salida->vehiculo_interno;
                }
                else
                    {
                        $vehiculo =  $salida->vehiculo_foraneo;
                    }
                
                $reporte[] =[
                    $salida->fecha_validacion,
                    $salida->id_salida,
                    $salida->solicitante,
                    $salida->departamento,
                    $salida->autorizado,
                    $salida->responsable,
                    $salida->conductor,
                    $vehiculo,
                    $salida->destino,
                    $salida->motivo,
                    'CODIGO',
                    'NOMBRE',
                    'SALIDA', 
                    'COMENTARIO', 
                    'RETORNO',
                    'OBERVACIONES',
                    'ESTATUS'              
                ];

                foreach($articulos as $articulo)
                {
                    $reporte[] = ['','','','','','','','','','', $articulo->codigo_articulo, $articulo->nombre_articulo, $articulo->cantidad_salida, $articulo->cometario, $articulo->cantidad_retorno, $articulo->observaciones, $articulo->estatus ];
                }
        }

        return collect($reporte);
    }

    public function headings(): array
    {     
        return [
           // [' ', ' ',' ', ' ',' ', ' ',' ', ' ',' ', ' ','ARTICULOS', '','', '',''],
            ['FECHA VALIDACIÓN', 'CORRELATIVO', 'SOLICITANTE','DEPARTAMENTO','AUTORIZADO','RESPONSABLE','CONDUCTOR','VEHÍCULO','DESTINO','MOTIVO','ARTÍCULOS', '','','', '', '', ''],
         ];

    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $celdas = "K1:Q1";
            $event->sheet->mergeCells($celdas);
            $event->sheet->getDelegate()->getStyle($celdas)->getAlignment()->setVertical(StyleAlignment::VERTICAL_CENTER);
            $event->sheet->getDelegate()->getStyle($celdas)->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);

        }
    ];
}

}
