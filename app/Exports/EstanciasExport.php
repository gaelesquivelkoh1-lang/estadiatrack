<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class EstanciasExport
{
    protected $estancias;
    protected $titulo;

    public function __construct($estancias, $titulo = 'Todas las carreras')
    {
        $this->estancias = $estancias;
        $this->titulo    = $titulo;
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Estancias');

        // Encabezado principal
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'UNIVERSIDAD TECNOLÓGICA DEL CENTRO — ESTADÍAS');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '006341']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Carrera y fecha
        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', $this->titulo . '  |  Generado: ' . now()->format('d/m/Y H:i'));
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 9, 'color' => ['rgb' => '555555']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Cabeceras
        $headers = ['#', 'Alumno', 'Matrícula', 'Carrera', 'Grupo', 'Empresa', 'Fecha Inicio', 'Fecha Fin', 'Estatus'];
        $cols    = ['A','B','C','D','E','F','G','H','I'];

        foreach ($headers as $i => $header) {
            $sheet->setCellValue($cols[$i] . '3', $header);
            $sheet->getStyle($cols[$i] . '3')->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '004d33']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '006341']]],
            ]);
        }
        $sheet->getRowDimension(3)->setRowHeight(20);

        // Datos
        $row = 4;
        foreach ($this->estancias as $i => $estancia) {
            $bgColor = ($i % 2 === 0) ? 'F0FAF5' : 'FFFFFF';
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $estancia->alumno->nombre   ?? '—');
            $sheet->setCellValue('C' . $row, $estancia->alumno->matricula ?? '—');
            $sheet->setCellValue('D' . $row, $estancia->alumno->carrera   ?? '—');
            $sheet->setCellValue('E' . $row, $estancia->alumno->grupo     ?? '—');
            $sheet->setCellValue('F' . $row, $estancia->empresa->nombre   ?? '—');
            $sheet->setCellValue('G' . $row, $estancia->fecha_inicio      ?? '—');
            $sheet->setCellValue('H' . $row, $estancia->fecha_fin         ?? '—');
            $sheet->setCellValue('I' . $row, $estancia->estatus           ?? '—');

            $sheet->getStyle("A{$row}:I{$row}")->applyFromArray([
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
            ]);
            $row++;
        }

        // Anchos de columna
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(45);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(14);
        $sheet->getColumnDimension('H')->setWidth(14);
        $sheet->getColumnDimension('I')->setWidth(14);

        $writer   = new Xlsx($spreadsheet);
        $filename = 'estancias_' . now()->format('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}