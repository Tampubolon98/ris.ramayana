<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExportReportEmployeeSPG implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($item) {
            return [
                $item->id_employee ?? '',       
                $item->nama ?? '',     
                $item->alamat ?? '',           
                $item->tanggal_lahir ?? '',        
                $item->tanggal_masuk ?? '',          
                $item->no_handphone ?? '',    
                $item->kategori_karyawan ?? '',       
                $item->status == 1 ? 'Belum Menikah' : ($item->status == 2 ? 'Menikah' : ($item->status == 3 ? 'Duda' : 'Janda')),          
                $item->kode_toko ?? '',      
                $item->no_kk ?? '',           
                $item->no_ktp ?? '',           
                $item->md_emp ?? '',           
                $item->brand_emp ?? '',           
                $item->supplier ?? '',          
                $item->jenis_kelamin ?? '',        
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['Report Karyawan SPG'],
            [], 
            [ 
                'ID Employee',
                'Nama Karyawan',
                'Alamat',
                'Tanggal Lahir',
                'Tanggal Masuk',
                'No Handphone',
                'Kategori',
                'Status',
                'Kode Toko',
                'No KK',
                'No KTP',
                'MD',
                'Brand',
                'Nama Supplier',
                'Jenis Kelamin'
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk judul utama
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
            
            // Style untuk header kolom
            3 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD9D9D9'],
                ],
            ],
            
            // Alignment untuk data
            'A4:M1000' => [
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP]
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, 
            'B' => 25, 
            'C' => 35, 
            'D' => 15, 
            'E' => 15, 
            'F' => 15, 
            'G' => 15, 
            'H' => 15, 
            'I' => 15,  
            'J' => 20, 
            'K' => 20, 
            'L' => 10, 
            'M' => 25, 
            'N' => 30, 
            'O' => 15, 
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge cells untuk judul
                $event->sheet->mergeCells('A1:O1');
                
                // Auto size kolom setelah data dimasukkan
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                
                // Format tanggal
                $lastRow = count($this->data) + 3; // 3 baris header
                $event->sheet->getStyle("D4:D{$lastRow}")->getNumberFormat()->setFormatCode('dd/mm/yyyy');
                $event->sheet->getStyle("E4:E{$lastRow}")->getNumberFormat()->setFormatCode('dd/mm/yyyy');
                
                // Border untuk seluruh data
                $event->sheet->getStyle("A3:O{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}