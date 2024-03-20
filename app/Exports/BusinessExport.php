<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BusinessExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * @var array
     */
    protected $businesses;

    /**
     * @param array $businesses
     */
    public function __construct(array $businesses)
    {
        $this->businesses = $businesses;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->businesses;
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'Sr.no',
            'Category Name',
            'Business Name',
            'Business State',
            'Business Rating',
            'Business Opening Hours',
            'Business Detail',
            'Business Location',
            'Business Longitude',
            'Business Latitude',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('B1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('C1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('D1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('E1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('F1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('G1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('H1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('I1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('J1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }
}
