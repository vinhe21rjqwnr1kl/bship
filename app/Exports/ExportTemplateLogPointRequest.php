<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportTemplateLogPointRequest implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            ["0986966719", '1', 'give_event', 'why'], // Data row

        ];
    }

    public function headings(): array
    {
        return ['phone_user', 'point_user', 'type', 'reason'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Styling the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }


}
