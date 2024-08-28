<?php
namespace App\Exports;

use App\Models\Gsta_AsistenciasValidacionModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class GstaReporteHorasRangoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithCustomStartCell, WithEvents
{
    use Exportable;

    private $IdDepartamento;
    private $IdEmpresa;
    private $FechaInicio;
    private $FechaFin;
    private $fechas;
    private $maxHorasPorFecha = [];

    public function __construct($IdDepartamento, $IdEmpresa, $FechaInicio, $FechaFin)
    {
        $this->IdDepartamento = $IdDepartamento;
        $this->IdEmpresa = $IdEmpresa;
        $this->FechaInicio = $FechaInicio;
        $this->FechaFin = $FechaFin;

        // Obtener los datos y fechas del modelo
        $validacionesData = Gsta_AsistenciasValidacionModel::Listadohorasextrasexcell($this->IdDepartamento, $this->IdEmpresa, $this->FechaInicio, $this->FechaFin);

        $this->fechas = array_map(function($fecha) {
            return \Carbon\Carbon::parse($fecha)->format('Y-m-d');
        }, $validacionesData['fechas']);

        // Calcular el número máximo de horas por fecha
        foreach ($validacionesData['result'] as $validacion) {
            foreach ($this->fechas as $fecha) {
                if (isset($validacion->$fecha)) {
                    $numHoras = count(explode('-', $validacion->$fecha));
                    if (!isset($this->maxHorasPorFecha[$fecha]) || $numHoras > $this->maxHorasPorFecha[$fecha]) {
                        $this->maxHorasPorFecha[$fecha] = $numHoras;
                    }
                }
            }
        }
    }

    public function collection()
    {
        // Obtener los datos del modelo
        $validacionesData = Gsta_AsistenciasValidacionModel::Listadohorasextrasexcell($this->IdDepartamento, $this->IdEmpresa, $this->FechaInicio, $this->FechaFin);
        $validaciones = $validacionesData['result'];

        $empleados = [];
        foreach ($validaciones as $validacion) {
            $key = $validacion->id_empleado;
            if (!isset($empleados[$key])) {
                $empleados[$key] = [
                    'empresa' => $validacion->nombre_empresa,
                    'departamento' => $validacion->des_depart,
                    'id_biometrico' => $validacion->id_biometrico,
                    'id_nomina' => $validacion->id_empleado,
                    'empleado' => $validacion->nombre_empleado,
                    'horas' => []
                ];
            }
            foreach ($this->fechas as $fecha) {
                if (isset($validacion->$fecha)) {
                    $empleados[$key]['horas'][$fecha] = explode('-', $validacion->$fecha);
                } else {
                    $empleados[$key]['horas'][$fecha] = [];
                }
            }
        }

        $reporte = [];
        foreach ($empleados as $empleado) {
            $row = [
                $empleado['empresa'],
                $empleado['departamento'],
                $empleado['id_biometrico'],
                $empleado['id_nomina'],
                $empleado['empleado']
            ];
            foreach ($this->fechas as $fecha) {
                if (isset($empleado['horas'][$fecha])) {
                    foreach ($empleado['horas'][$fecha] as $hora) {
                        $row[] = $hora;
                    }
                    // Añadir celdas vacías si hay menos horas que el máximo
                    $faltantes = $this->maxHorasPorFecha[$fecha] - count($empleado['horas'][$fecha]);
                    for ($i = 0; $i < $faltantes; $i++) {
                        $row[] = '';
                    }
                } else {
                    for ($i = 0; $i < $this->maxHorasPorFecha[$fecha]; $i++) {
                        $row[] = '';
                    }
                }
            }
            $reporte[] = $row;
        }

        return collect($reporte);
    }

    public function headings(): array
    {
        $baseHeadings = ['EMPRESA', 'DEPARTAMENTO', 'ID BIOMETRICO', 'ID NOMINA', 'EMPLEADO'];
        // Nombres específicos para las columnas adicionales
        $horaHeadings = [
            'Hora Entrada', 
            'Hora Salida', 
            'Observacion', 
            'Hora extra Diurna', 
            'Hora extra nocturna'
        ];
        
        $fechaHeadings = [];
        foreach ($this->fechas as $fecha) {
            $fechaHeadings = array_merge($fechaHeadings, $horaHeadings);
        }

        return array_merge($baseHeadings, $fechaHeadings);
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $columnaInicial = 6; // La columna F es la sexta columna
    
                // Aplicar estilo a los encabezados de fecha
                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ];
    
                foreach ($this->fechas as $fecha) {
                    $fechaFormatted = \Carbon\Carbon::parse($fecha)->format('d/m/Y');
                    $columnaFinal = $columnaInicial + 4; // Tenemos 5 columnas por fecha
                    $sheet->mergeCellsByColumnAndRow($columnaInicial, 1, $columnaFinal, 1);
                    $sheet->setCellValueByColumnAndRow($columnaInicial, 1, $fechaFormatted);
    
                    // Aplicar estilo a las celdas que contienen las fechas
                    $sheet->getStyleByColumnAndRow($columnaInicial, 1, $columnaFinal, 1)->applyFromArray($styleArray);
    
                    $columnaInicial = $columnaFinal + 1;
                }
            },
        ];
    }
}