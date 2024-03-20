<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * @var array
     */
    protected $users;

    /**
     * @param array $users
     */
    public function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return $this->users;
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'Sr.no',
            'User Type',
            'User Name',
            'User Email',
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
    }
}
