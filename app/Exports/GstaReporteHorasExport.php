<?php

namespace App\Exports;

use App\Models\Gsta_AsistenciasValidacionModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GstaReporteHorasExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;
    
    public function __construct($IdDepartamento, $IdEmpresa, $FechaInicio)
    {
        $this->IdDepartamento = $IdDepartamento;
        $this->IdEmpresa = $IdEmpresa;
        $this->FechaInicio = $FechaInicio;
    }

    public function collection()
    {
        $validaciones = Gsta_AsistenciasValidacionModel::HorasTrabajadas($this->IdDepartamento, $this->IdEmpresa, $this->FechaInicio);
        $reporte = [];

        foreach ($validaciones as $validacion) 
        {
            $hora_entrada_formateada = (($validacion->hora_entrada == '00:00:00.0000000'&& $validacion->hora_salida== '00:00:00.0000000')) 
                ? '00:00:00' 
                : date('g:i:s A', strtotime($validacion->hora_entrada));

            $hora_salida_formateada =($validacion->hora_entrada == '00:00:00.0000000'&& $validacion->hora_salida== '00:00:00.0000000')
            ? '00:00:00' 
            : date('g:i:s A', strtotime($validacion->hora_salida));

            $reporte[] = [
                $validacion->nombre_empresa,
                $validacion->des_depart,
                $validacion->id_biometrico,
                $validacion->id_empleado,
                $validacion->nombre_empleado,
                date('d-m-Y', strtotime($validacion->fecha_validacion)),
                $hora_entrada_formateada,
                $hora_salida_formateada,
                $validacion->horas_jornada,
                $validacion->horas_trabajadas,
                $validacion->horas_extra_diurnas,
                $validacion->horas_extra_nocturnas
            ];
        }

        return collect($reporte);
    }

    public function headings(): array
    {
        return [
            [
                'EMPRESA',
                'DEPARTAMENTO',
                'ID BIOMETRICO',
                'ID NOMINA',
                'EMPLEADO',
                'FECHA',
                'HORA ENTRADA',
                'HORA SALIDA',
                'HORAS MINIMAS',
                'HORAS TOTALES',
                'HORAS EXTRA DIURNAS',
                'HORAS NOCTURNAS',
            ],
        ];
    }
}